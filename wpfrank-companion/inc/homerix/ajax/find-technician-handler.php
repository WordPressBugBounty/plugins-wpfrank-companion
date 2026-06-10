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
 * @return void
 */
function homerix_get_technician_profile_ajax() {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$technician_id = isset( $_POST['technician_id'] ) ? absint( $_POST['technician_id'] ) : 0;

	if ( ! $technician_id ) {
		wp_send_json_error( array( 'message' => 'Invalid technician ID' ) );
	}

	$post = get_post( $technician_id );

	if ( ! $post || 'technicians' !== $post->post_type ) {
		wp_send_json_error( array( 'message' => 'Technician not found' ) );
	}

	// Get all meta data.
	$meta       = get_post_meta( $technician_id );
	$meta_array = array();

	foreach ( $meta as $key => $value ) {
		$meta_array[ $key ] = is_array( $value ) ? $value[0] : $value;
	}

	$response = array(
		'success' => true,
		'data'    => array(
			'id'      => $technician_id,
			'title'   => $post->post_title,
			'content' => $post->post_content,
			'meta'    => $meta_array,
		),
	);

	wp_send_json( $response );
}
