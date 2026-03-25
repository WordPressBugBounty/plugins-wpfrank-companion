<?php
/**
 * Services Page AJAX Handler
 *
 * Handles AJAX requests for services page
 */

/**
 * Get services for the services page
 */
function homerix_get_services_ajax() {
	// Get services from customizer.
	$services_list = get_theme_mod( 'services_list', array() );

	if ( empty( $services_list ) ) {
		$services_list = array(
			array(
				'name'  => 'Plumbing',
				'value' => 'plumbing',
				'icon'  => 'fa-faucet',
				'color' => 'blue',
			),
			array(
				'name'  => 'Electrical',
				'value' => 'electrical',
				'icon'  => 'fa-bolt',
				'color' => 'yellow',
			),
			array(
				'name'  => 'HVAC',
				'value' => 'hvac',
				'icon'  => 'fa-thermometer-half',
				'color' => 'red',
			),
			array(
				'name'  => 'Handyman',
				'value' => 'handyman',
				'icon'  => 'fa-tools',
				'color' => 'green',
			),
		);
	}

	// Query service posts.
	$args = array(
		'post_type'      => 'services',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);

	$query    = new WP_Query( $args );
	$services = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$service_id       = get_the_ID();
			$service_category = get_the_terms( $service_id, 'service_category' );
			$category_slug    = ! empty( $service_category ) ? $service_category[0]->slug : '';

			// Find matching service from list.
			$service_info = array();
			foreach ( $services_list as $svc ) {
				if ( $svc['value'] === $category_slug ) {
					$service_info = $svc;
					break;
				}
			}

			$services[] = array(
				'id'       => $service_id,
				'title'    => get_the_title(),
				'excerpt'  => get_the_excerpt(),
				'category' => $category_slug,
				'icon'     => isset( $service_info['icon'] ) ? $service_info['icon'] : 'fa-wrench',
				'color'    => isset( $service_info['color'] ) ? $service_info['color'] : 'blue',
			);
		}
		wp_reset_postdata();
	}

	// Group services by category.
	$grouped_services = array();
	foreach ( $services_list as $service ) {
		$grouped_services[ $service['value'] ] = array(
			'name'  => $service['name'],
			'icon'  => $service['icon'],
			'color' => $service['color'],
			'items' => array(),
		);
	}

	foreach ( $services as $service ) {
		if ( isset( $grouped_services[ $service['category'] ] ) ) {
			$grouped_services[ $service['category'] ]['items'][] = $service;
		}
	}

	wp_send_json_success( $grouped_services );
}
add_action( 'wp_ajax_get_services', 'homerix_get_services_ajax' );
add_action( 'wp_ajax_nopriv_get_services', 'homerix_get_services_ajax' );

/**
 * Get service areas
 */
function homerix_get_service_areas_ajax() {
	$areas = get_theme_mod( 'services_areas', array() );

	if ( empty( $areas ) ) {
		$areas = array(
			array(
				'title'     => __( 'Metro Area', 'homerix' ),
				'locations' => array( 'Downtown', 'Midtown', 'Uptown', 'East Side', 'West End' ),
			),
			array(
				'title'     => __( 'Suburbs', 'homerix' ),
				'locations' => array( 'Green Valley', 'Lakeview', 'Pine Hills', 'Oak Brook', 'Riverdale' ),
			),
			array(
				'title'     => __( 'Surrounding Areas', 'homerix' ),
				'locations' => array( 'Springfield', 'Fairview', 'Maplewood', 'Clinton', 'Franklin' ),
			),
		);
	}

	wp_send_json_success( $areas );
}
add_action( 'wp_ajax_get_service_areas', 'homerix_get_service_areas_ajax' );
add_action( 'wp_ajax_nopriv_get_service_areas', 'homerix_get_service_areas_ajax' );

/**
 * Get why choose items
 */
function homerix_get_why_choose_ajax() {
	$why_items = get_theme_mod( 'services_why_items', array() );

	if ( empty( $why_items ) ) {
		$why_items = array(
			array(
				'title'       => __( 'Vetted Professionals', 'homerix' ),
				'description' => __( 'All technicians are licensed, insured, and background-checked.', 'homerix' ),
				'icon'        => 'fa-user-shield',
				'color'       => 'blue',
			),
			array(
				'title'       => __( 'Upfront Pricing', 'homerix' ),
				'description' => __( 'No hidden fees - know the cost before we start any work.', 'homerix' ),
				'icon'        => 'fa-dollar-sign',
				'color'       => 'green',
			),
			array(
				'title'       => __( 'On-Time Guarantee', 'homerix' ),
				'description' => __( 'We arrive when promised or your service is discounted.', 'homerix' ),
				'icon'        => 'fa-clock',
				'color'       => 'yellow',
			),
			array(
				'title'       => __( 'Satisfaction Guaranteed', 'homerix' ),
				'description' => __( 'We stand behind our work with a 100% satisfaction guarantee.', 'homerix' ),
				'icon'        => 'fa-medal',
				'color'       => 'red',
			),
		);
	}

	wp_send_json_success( $why_items );
}
add_action( 'wp_ajax_get_why_choose', 'homerix_get_why_choose_ajax' );
add_action( 'wp_ajax_nopriv_get_why_choose', 'homerix_get_why_choose_ajax' );

