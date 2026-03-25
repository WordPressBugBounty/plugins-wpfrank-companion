<?php
/**
 * Homerix Newsletter Admin Page
 *
 * Provides admin interface for managing newsletter subscribers.
 *
 * @package Homerix_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class homerix_Newsletter_Admin
 *
 * Admin page for newsletter management.
 */
class homerix_Newsletter_Admin {

	/**
	 * Initialize the admin.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'handle_actions' ) );
		add_action( 'admin_init', array( __CLASS__, 'ensure_table_exists' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
	}

	/**
	 * Ensure database table exists.
	 */
	public static function ensure_table_exists() {
		if ( isset( $_GET['page'] ) && 'homerix-newsletter' === $_GET['page'] ) {
			homerix_Newsletter::create_table();
		}
	}

	/**
	 * Add admin menu page.
	 */
	public static function add_menu_page() {
		add_menu_page(
			__( 'Homerix Newsletter', 'homerix' ),
			__( 'Homerix Newsletter', 'homerix' ),
			'manage_options',
			'homerix-newsletter',
			array( __CLASS__, 'render_page' ),
			'dashicons-email-alt',
			30
		);
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public static function enqueue_styles( $hook ) {
		if ( 'toplevel_page_homerix-newsletter' !== $hook ) {
			return;
		}

		wp_add_inline_style(
			'wp-admin',
			'
			.homerix-newsletter-wrap { max-width: 1200px; }
			.homerix-newsletter-stats { display: flex; gap: 20px; margin-bottom: 20px; }
			.homerix-stat-box { background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px; text-align: center; min-width: 150px; }
			.homerix-stat-number { font-size: 32px; font-weight: 600; color: #2271b1; }
			.homerix-stat-label { color: #646970; margin-top: 5px; }
			.homerix-subscribers-table { width: 100%; border-collapse: collapse; background: #fff; }
			.homerix-subscribers-table th, .homerix-subscribers-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ccd0d4; }
			.homerix-subscribers-table th { background: #f0f0f1; font-weight: 600; }
			.homerix-subscribers-table tr:hover { background: #f6f7f7; }
			.homerix-status-active { color: #00a32a; }
			.homerix-status-unsubscribed { color: #d63638; }
			.homerix-export-btn { margin-left: 10px; }
			.homerix-pagination { margin-top: 20px; display: flex; gap: 10px; align-items: center; }
			'
		);
	}

	/**
	 * Handle admin actions (delete, export, etc.).
	 */
	public static function handle_actions() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Handle CSV export.
		if ( isset( $_GET['action'] ) && 'export_csv' === $_GET['action'] && isset( $_GET['_wpnonce'] ) ) {
			if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'homerix_export_csv' ) ) {
				self::export_csv();
			}
		}

		// Handle single delete.
		if ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && isset( $_GET['subscriber'] ) && isset( $_GET['_wpnonce'] ) ) {
			if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'homerix_delete_subscriber' ) ) {
				homerix_Newsletter::delete_subscriber( absint( $_GET['subscriber'] ) );
				wp_safe_redirect( admin_url( 'admin.php?page=homerix-newsletter&deleted=1' ) );
				exit;
			}
		}

		// Handle bulk delete.
		if ( isset( $_POST['action'] ) && 'bulk_delete' === $_POST['action'] && isset( $_POST['subscribers'] ) && isset( $_POST['_wpnonce'] ) ) {
			if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'homerix_bulk_action' ) ) {
				$subscribers = array_map( 'absint', $_POST['subscribers'] );
				foreach ( $subscribers as $id ) {
					homerix_Newsletter::delete_subscriber( $id );
				}
				wp_safe_redirect( admin_url( 'admin.php?page=homerix-newsletter&deleted=' . count( $subscribers ) ) );
				exit;
			}
		}
	}

	/**
	 * Export subscribers as CSV download.
	 */
	private static function export_csv() {
		$csv = homerix_Newsletter::export_csv( 'all' );

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=homerix-subscribers-' . gmdate( 'Y-m-d' ) . '.csv' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		echo $csv; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	/**
	 * Render the admin page.
	 */
	public static function render_page() {
		$current_page = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
		$per_page     = 20;

		$subscribers = homerix_Newsletter::get_subscribers(
			array(
				'status'   => 'all',
				'per_page' => $per_page,
				'page'     => $current_page,
			)
		);

		$total_subscribers = homerix_Newsletter::get_subscriber_count( 'all' );
		$active_count      = homerix_Newsletter::get_subscriber_count( 'active' );
		$total_pages       = ceil( $total_subscribers / $per_page );

		// Get this month's subscribers.
		global $wpdb;
		$table         = homerix_Newsletter::get_table_name();
		$month_start   = gmdate( 'Y-m-01 00:00:00' );
		$monthly_count = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM $table WHERE subscribed_at >= %s",
				$month_start
			)
		);
		?>
		<div class="wrap homerix-newsletter-wrap">
			<h1><?php esc_html_e( 'Newsletter Subscribers', 'homerix' ); ?>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=homerix-newsletter&action=export_csv' ), 'homerix_export_csv' ) ); ?>" class="page-title-action homerix-export-btn">
					<?php esc_html_e( 'Export CSV', 'homerix' ); ?>
				</a>
			</h1>

			<?php if ( isset( $_GET['deleted'] ) ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Subscriber(s) deleted successfully.', 'homerix' ); ?></p>
				</div>
			<?php endif; ?>

			<!-- Statistics -->
			<div class="homerix-newsletter-stats">
				<div class="homerix-stat-box">
					<div class="homerix-stat-number"><?php echo esc_html( $total_subscribers ); ?></div>
					<div class="homerix-stat-label"><?php esc_html_e( 'Total Subscribers', 'homerix' ); ?></div>
				</div>
				<div class="homerix-stat-box">
					<div class="homerix-stat-number"><?php echo esc_html( $active_count ); ?></div>
					<div class="homerix-stat-label"><?php esc_html_e( 'Active', 'homerix' ); ?></div>
				</div>
				<div class="homerix-stat-box">
					<div class="homerix-stat-number"><?php echo esc_html( $monthly_count ); ?></div>
					<div class="homerix-stat-label"><?php esc_html_e( 'This Month', 'homerix' ); ?></div>
				</div>
			</div>

			<!-- Subscribers Table -->
			<?php if ( empty( $subscribers ) ) : ?>
				<div class="notice notice-info">
					<p><?php esc_html_e( 'No subscribers yet. When visitors subscribe to your newsletter, they will appear here.', 'homerix' ); ?></p>
				</div>
			<?php else : ?>
				<form method="post" action="">
					<?php wp_nonce_field( 'homerix_bulk_action' ); ?>
					<input type="hidden" name="action" value="bulk_delete">

					<div style="margin-bottom: 10px;">
						<button type="submit" class="button" onclick="return confirm('<?php esc_attr_e( 'Delete selected subscribers?', 'homerix' ); ?>');">
							<?php esc_html_e( 'Delete Selected', 'homerix' ); ?>
						</button>
					</div>

					<table class="homerix-subscribers-table">
						<thead>
							<tr>
								<th style="width: 30px;"><input type="checkbox" id="select-all"></th>
								<th><?php esc_html_e( 'Email', 'homerix' ); ?></th>
								<th><?php esc_html_e( 'Date Subscribed', 'homerix' ); ?></th>
								<th><?php esc_html_e( 'Source', 'homerix' ); ?></th>
								<th><?php esc_html_e( 'Status', 'homerix' ); ?></th>
								<th><?php esc_html_e( 'Actions', 'homerix' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $subscribers as $subscriber ) : ?>
								<tr>
									<td><input type="checkbox" name="subscribers[]" value="<?php echo esc_attr( $subscriber->id ); ?>"></td>
									<td><strong><?php echo esc_html( $subscriber->email ); ?></strong></td>
									<td><?php echo esc_html( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $subscriber->subscribed_at ) ) ); ?></td>
									<td><?php echo esc_html( ucfirst( $subscriber->source ) ); ?></td>
									<td>
										<span class="homerix-status-<?php echo esc_attr( $subscriber->status ); ?>">
											<?php echo esc_html( ucfirst( $subscriber->status ) ); ?>
										</span>
									</td>
									<td>
										<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=homerix-newsletter&action=delete&subscriber=' . $subscriber->id ), 'homerix_delete_subscriber' ) ); ?>" class="button button-small" onclick="return confirm('<?php esc_attr_e( 'Delete this subscriber?', 'homerix' ); ?>');">
											<?php esc_html_e( 'Delete', 'homerix' ); ?>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</form>

				<!-- Pagination -->
				<?php if ( $total_pages > 1 ) : ?>
					<div class="homerix-pagination">
						<?php
						echo wp_kses_post(
							paginate_links(
								array(
									'base'      => admin_url( 'admin.php?page=homerix-newsletter&paged=%#%' ),
									'format'    => '',
									'current'   => $current_page,
									'total'     => $total_pages,
									'prev_text' => '&laquo; ' . __( 'Previous', 'homerix' ),
									'next_text' => __( 'Next', 'homerix' ) . ' &raquo;',
								)
							)
						);
						?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<script>
		jQuery(document).ready(function($) {
			$('#select-all').on('change', function() {
				$('input[name="subscribers[]"]').prop('checked', $(this).prop('checked'));
			});
		});
		</script>
		<?php
	}
}

// Initialize admin.
homerix_Newsletter_Admin::init();
