<?php
/**
 * Find Technician AJAX Handler
 *
 * Handles AJAX requests for technician filtering and searching
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get technicians via AJAX.
 */
add_action( 'wp_ajax_get_technicians', 'homerix_get_technicians_ajax' );
add_action( 'wp_ajax_nopriv_get_technicians', 'homerix_get_technicians_ajax' );

/**
 * AJAX callback to retrieve technicians.
 *
 * @return void
 */
function homerix_get_technicians_ajax() {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$search = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$service = isset( $_POST['service'] ) ? sanitize_text_field( wp_unslash( $_POST['service'] ) ) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$location = isset( $_POST['location'] ) ? sanitize_text_field( wp_unslash( $_POST['location'] ) ) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$per_page = isset( $_POST['per_page'] ) ? absint( $_POST['per_page'] ) : 12;

	// Build query arguments.
	$args = array(
		'post_type'      => 'technicians',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'orderby'        => 'meta_value_num',
		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		'meta_key'       => 'technician_rating',
		'order'          => 'DESC',
	);

	// Add search.
	if ( ! empty( $search ) ) {
		$args['s'] = $search;
	}

	// Add service filter.
	if ( ! empty( $service ) ) {
		$args['meta_query'][] = array(
			'key'     => 'technician_service',
			'value'   => $service,
			'compare' => 'LIKE',
		);
	}

	// Add location filter.
	if ( ! empty( $location ) ) {
		$args['meta_query'][] = array(
			'key'     => 'technician_location',
			'value'   => $location,
			'compare' => 'LIKE',
		);
	}

	// Get technicians.
	$query       = new WP_Query( $args );
	$technicians = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id = get_the_ID();

			// Get technician meta data.
			$name              = get_the_title();
			$specialty         = get_post_meta( $post_id, 'technician_specialty', true );
			$description       = get_post_meta( $post_id, 'technician_description', true );
			$image             = get_post_meta( $post_id, 'technician_image', true );
			$rating            = floatval( get_post_meta( $post_id, 'technician_rating', true ) );
			$rating            = $rating ? $rating : 4.5;
			$reviews           = absint( get_post_meta( $post_id, 'technician_reviews', true ) );
			$reviews           = $reviews ? $reviews : 0;
			$availability      = get_post_meta( $post_id, 'technician_availability', true );
			$availability      = $availability ? $availability : 'available';
			$availability_text = get_post_meta( $post_id, 'technician_availability_text', true );
			$availability_text = $availability_text ? $availability_text : 'AVAILABLE NOW';
			$skills            = get_post_meta( $post_id, 'technician_skills', true );
			$location          = get_post_meta( $post_id, 'technician_location', true );
			$profile_url       = get_permalink();

			// Use placeholder image if not set.
			if ( empty( $image ) ) {
				$image = 'https://randomuser.me/api/portraits/men/' . ( wp_rand( 1, 70 ) ) . '.jpg';
			}

			// Parse skills if JSON.
			if ( is_string( $skills ) ) {
				$skills = json_decode( $skills, true );
			}
			if ( ! is_array( $skills ) ) {
				$skills = array();
			}

			$technicians[] = array(
				'id'                => $post_id,
				'name'              => $name,
				'specialty'         => $specialty,
				'description'       => $description,
				'image'             => $image,
				'rating'            => $rating,
				'reviews'           => $reviews,
				'availability'      => $availability,
				'availability_text' => $availability_text,
				'skills'            => $skills,
				'location'          => $location,
				'profile_url'       => $profile_url,
			);
		}
	}

	wp_reset_postdata();

	// Prepare response.
	$response = array(
		'success' => true,
		'data'    => array(
			'technicians' => $technicians,
			'total'       => $query->found_posts,
			'total_pages' => $query->max_num_pages,
			'pagination'  => array(
				'current_page' => $page,
				'total_pages'  => $query->max_num_pages,
			),
		),
	);

	wp_send_json( $response );
}

/**
 * Get single technician profile via AJAX.
 */
add_action( 'wp_ajax_get_technician_profile', 'homerix_get_technician_profile_ajax' );
add_action( 'wp_ajax_nopriv_get_technician_profile', 'homerix_get_technician_profile_ajax' );

/**
 * AJAX callback to retrieve a technician profile.
 *
 * Secured: requires nonce, restricts to published posts only,
 * and returns only an explicit allowlist of public meta fields.
 *
 * @return void
 */
function homerix_get_technician_profile_ajax() {
	// Verify nonce.
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'homerix_find_tech_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed.', 'wpfrank-companion' ) ) );
	}

	$technician_id = isset( $_POST['technician_id'] ) ? absint( $_POST['technician_id'] ) : 0;

	if ( ! $technician_id ) {
		wp_send_json_error( array( 'message' => __( 'Invalid technician ID.', 'wpfrank-companion' ) ) );
	}

	$post = get_post( $technician_id );

	// Ensure the post exists, is the correct type, AND is published.
	if ( ! $post || 'technicians' !== $post->post_type || 'publish' !== $post->post_status ) {
		wp_send_json_error( array( 'message' => __( 'Technician not found.', 'wpfrank-companion' ) ) );
	}

	// Allowlist of public meta keys — only return fields the frontend needs.
	$allowed_meta_keys = array(
		'technician_specialty',
		'technician_description',
		'technician_image',
		'technician_rating',
		'technician_reviews',
		'technician_availability',
		'technician_availability_text',
		'technician_skills',
		'technician_location',
		'technician_service',
	);

	$meta_array = array();
	foreach ( $allowed_meta_keys as $key ) {
		$meta_array[ $key ] = get_post_meta( $technician_id, $key, true );
	}

	$response = array(
		'success' => true,
		'data'    => array(
			'id'          => $technician_id,
			'title'       => $post->post_title,
			'content'     => $post->post_content,
			'meta'        => $meta_array,
			'profile_url' => get_permalink( $technician_id ),
		),
	);

	wp_send_json( $response );
}
