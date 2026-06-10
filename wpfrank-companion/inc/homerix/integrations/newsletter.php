<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Homerix Newsletter Subscriber Management
 *
 * Handles newsletter subscriptions, database operations, and AJAX.
 *
 * @package Homerix_Pro
 */

// phpcs:disable WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Homerix_Newsletter
 *
 * Manages newsletter subscribers.
 */
class Homerix_Newsletter {

	/**
	 * Database table name (without prefix).
	 *
	 * @var string
	 */
	private static $table_name = 'homerix_subscribers';

	/**
	 * Initialize the newsletter system.
	 */
	public static function init() {
		add_action( 'wp_ajax_homerix_newsletter_subscribe', array( __CLASS__, 'handle_subscription' ) );
		add_action( 'wp_ajax_nopriv_homerix_newsletter_subscribe', array( __CLASS__, 'handle_subscription' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Get the full table name with prefix.
	 *
	 * @return string
	 */
	public static function get_table_name() {
		global $wpdb;
		return $wpdb->prefix . self::$table_name;
	}

	/**
	 * Create the subscribers database table.
	 *
	 * Called on theme activation.
	 */
	public static function create_table() {
		global $wpdb;

		$table_name      = self::get_table_name();
		$charset_collate = $wpdb->get_charset_collate();

		// Use varchar(191) for email to avoid MySQL key length issues with utf8mb4.
		// 191 * 4 bytes = 764 bytes, well under the 1000 byte limit.
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			email varchar(191) NOT NULL,
			subscribed_at datetime DEFAULT CURRENT_TIMESTAMP,
			source varchar(50) DEFAULT 'footer',
			status varchar(20) DEFAULT 'active',
			ip_address varchar(45) DEFAULT '',
			PRIMARY KEY (id),
			UNIQUE KEY email (email)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Enqueue newsletter JavaScript.
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script(
			'homerix-newsletter',
			get_template_directory_uri() . '/assets/js/frontend/newsletter.js',
			array( 'jquery' ),
			defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : wp_get_theme()->get( 'Version' ),
			true
		);

		wp_localize_script(
			'homerix-newsletter',
			'HomerixNewsletter',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'homerix_newsletter_nonce' ),
				'strings' => array(
					'success'     => __( 'Thank you for subscribing!', 'homerix' ),
					'error'       => __( 'Something went wrong. Please try again.', 'homerix' ),
					'invalid'     => __( 'Please enter a valid email address.', 'homerix' ),
					'exists'      => __( 'This email is already subscribed.', 'homerix' ),
					'subscribing' => __( 'Subscribing...', 'homerix' ),
				),
			)
		);
	}

	/**
	 * Handle newsletter subscription AJAX request.
	 */
	public static function handle_subscription() {
		// Verify nonce.
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'homerix_newsletter_nonce' ) ) {
			wp_send_json_error( array( 'message' => __( 'Security check failed.', 'homerix' ) ) );
		}

		// Get and validate email.
		$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

		if ( empty( $email ) || ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'homerix' ) ) );
		}

		// Get source.
		$source = isset( $_POST['source'] ) ? sanitize_text_field( wp_unslash( $_POST['source'] ) ) : 'footer';

		// Try to add subscriber.
		$result = self::add_subscriber( $email, $source );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'message' => __( 'Thank you for subscribing!', 'homerix' ) ) );
	}

	/**
	 * Add a new subscriber.
	 *
	 * @param string $email  Subscriber email.
	 * @param string $source Where the subscription came from.
	 * @return int|WP_Error Subscriber ID or error.
	 */
	public static function add_subscriber( $email, $source = 'footer' ) {
		global $wpdb;

		$email = sanitize_email( $email );

		if ( ! is_email( $email ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email address.', 'homerix' ) );
		}

		// Check if already exists.
		if ( self::subscriber_exists( $email ) ) {
			return new WP_Error( 'already_exists', __( 'This email is already subscribed.', 'homerix' ) );
		}

		// Get IP address.
		$ip_address = '';
		if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip_address = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}

		// Insert subscriber.
		$result = $wpdb->insert(
			self::get_table_name(),
			array(
				'email'         => $email,
				'source'        => $source,
				'ip_address'    => $ip_address,
				'subscribed_at' => current_time( 'mysql' ),
				'status'        => 'active',
			),
			array( '%s', '%s', '%s', '%s', '%s' )
		);

		if ( false === $result ) {
			return new WP_Error( 'db_error', __( 'Failed to add subscriber.', 'homerix' ) );
		}

		return $wpdb->insert_id;
	}

	/**
	 * Check if subscriber exists.
	 *
	 * @param string $email Email to check.
	 * @return bool
	 */
	public static function subscriber_exists( $email ) {
		global $wpdb;

		$count = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT COUNT(*) FROM ' . self::get_table_name() . ' WHERE email = %s',
				sanitize_email( $email )
			)
		);

		return $count > 0;
	}

	/**
	 * Get all subscribers.
	 *
	 * @param array $args Query arguments.
	 * @return array
	 */
	public static function get_subscribers( $args = array() ) {
		global $wpdb;

		$defaults = array(
			'status'   => 'active',
			'orderby'  => 'subscribed_at',
			'order'    => 'DESC',
			'per_page' => 20,
			'page'     => 1,
		);

		$args = wp_parse_args( $args, $defaults );

		$offset = ( $args['page'] - 1 ) * $args['per_page'];

		$table = self::get_table_name();
		$sql   = "SELECT * FROM $table";

		if ( 'all' !== $args['status'] ) {
			$sql .= $wpdb->prepare( ' WHERE status = %s', $args['status'] );
		}

		$sql .= ' ORDER BY ' . esc_sql( $args['orderby'] ) . ' ' . esc_sql( $args['order'] );
		$sql .= $wpdb->prepare( ' LIMIT %d OFFSET %d', $args['per_page'], $offset );

		return $wpdb->get_results( $sql );
	}

	/**
	 * Get total subscriber count.
	 *
	 * @param string $status Subscriber status.
	 * @return int
	 */
	public static function get_subscriber_count( $status = 'active' ) {
		global $wpdb;

		$table = self::get_table_name();

		if ( 'all' === $status ) {
			return (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table" );
		}

		return (int) $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE status = %s", $status )
		);
	}

	/**
	 * Delete a subscriber.
	 *
	 * @param int $id Subscriber ID.
	 * @return bool
	 */
	public static function delete_subscriber( $id ) {
		global $wpdb;

		$result = $wpdb->delete(
			self::get_table_name(),
			array( 'id' => absint( $id ) ),
			array( '%d' )
		);

		return false !== $result;
	}

	/**
	 * Update subscriber status.
	 *
	 * @param int    $id     Subscriber ID.
	 * @param string $status New status.
	 * @return bool
	 */
	public static function update_status( $id, $status ) {
		global $wpdb;

		$result = $wpdb->update(
			self::get_table_name(),
			array( 'status' => sanitize_text_field( $status ) ),
			array( 'id' => absint( $id ) ),
			array( '%s' ),
			array( '%d' )
		);

		return false !== $result;
	}

	/**
	 * Export subscribers to CSV.
	 *
	 * @param string $status Status filter.
	 * @return string CSV content.
	 */
	public static function export_csv( $status = 'all' ) {
		$subscribers = self::get_subscribers(
			array(
				'status'   => $status,
				'per_page' => 99999,
				'page'     => 1,
			)
		);

		$output = "Email,Subscribed Date,Source,Status,IP Address\n";

		foreach ( $subscribers as $subscriber ) {
			$output .= sprintf(
				'"%s","%s","%s","%s","%s"' . "\n",
				$subscriber->email,
				$subscriber->subscribed_at,
				$subscriber->source,
				$subscriber->status,
				$subscriber->ip_address
			);
		}

		return $output;
	}
}

// Initialize the newsletter system.
Homerix_Newsletter::init();
