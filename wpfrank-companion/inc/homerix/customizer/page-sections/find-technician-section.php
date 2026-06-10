<?php
/**
 * Homerix Find Technician Settings Customizer
 *
 * Handles all customizer settings for the Find Technician page.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Find Technician Page Settings Section
 */
function homerix_find_technician_sections() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-find-technician.php' );
	$description = esc_html__( 'Configure the Find Technician page settings and appearance.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit Find Technician Page', 'homerix' ) . '</a>';
	}

	// Main Find Technician Page Settings Section
	Kirki::add_section(
		'homerix_find_technician_settings',
		array(
			'title'       => esc_html__( 'Find Technician Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 20,
		)
	);
}

/**
 * Add Find Technician Controls
 */
function homerix_find_technician_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'find_tech_hero_heading',
			'section'  => 'homerix_find_technician_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Background Image.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'image',
			'settings' => 'find_tech_hero_bg_image',
			'label'    => esc_html__( 'Hero Background Image', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 6,
			'default'  => get_template_directory_uri() . '/assets/img/hero-tech.jpg',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'find_tech_hero_bg_color',
			'label'     => esc_html__( 'Hero Background Color', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 7,
			'default'   => '#2563eb',
			'transport' => 'postMessage',
		)
	);

	// Hero Overlay Enabled.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'find_tech_hero_overlay_enabled',
			'label'    => esc_html__( 'Enable Hero Overlay', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 8,
			'default'  => true,
		)
	);

	// Hero Overlay Opacity.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'find_tech_hero_overlay_opacity',
			'label'           => esc_html__( 'Hero Overlay Opacity (%)', 'homerix' ),
			'section'         => 'homerix_find_technician_settings',
			'priority'        => 9,
			'default'         => 40,
			'choices'         => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
			),
			'active_callback' => array(
				array(
					'setting'  => 'find_tech_hero_overlay_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'find_tech_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 10,
			'default'   => esc_html__( 'Meet Our Certified Technicians', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'find_tech_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 20,
			'default'   => esc_html__( 'Skilled professionals ready to handle your home repair needs', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Button Enabled.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'find_tech_hero_btn_enabled',
			'label'    => esc_html__( 'Enable Hero Button', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 22,
			'default'  => true,
		)
	);

	// Hero Button Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'find_tech_hero_btn_text',
			'label'           => esc_html__( 'Hero Button Text', 'homerix' ),
			'section'         => 'homerix_find_technician_settings',
			'priority'        => 23,
			'default'         => esc_html__( 'Browse Technicians', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'find_tech_hero_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Button URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'link',
			'settings'        => 'find_tech_hero_btn_url',
			'label'           => esc_html__( 'Hero Button URL', 'homerix' ),
			'section'         => 'homerix_find_technician_settings',
			'priority'        => 24,
			'default'         => '#technician-list',
			'active_callback' => array(
				array(
					'setting'  => 'find_tech_hero_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== SEARCH & FILTER SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'find_tech_search_heading',
			'section'  => 'homerix_find_technician_settings',
			'priority' => 95,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🔍 Search & Filter</h3></div>',
		)
	);

	// Search Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'find_tech_search_title',
			'label'     => esc_html__( 'Search Section Title', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 100,
			'default'   => esc_html__( 'Find Your Perfect Technician', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Search Placeholder.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'text',
			'settings' => 'find_tech_search_placeholder',
			'label'    => esc_html__( 'Search Placeholder Text', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 105,
			'default'  => esc_html__( "e.g. 'John' or 'plumbing'", 'homerix' ),
		)
	);

	// Services Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'find_tech_services',
			'label'     => esc_html__( 'Services', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 30,
			'default'   => array(
				array(
					'name'  => 'Plumbing',
					'value' => 'plumbing',
				),
				array(
					'name'  => 'Electrical',
					'value' => 'electrical',
				),
				array(
					'name'  => 'HVAC',
					'value' => 'hvac',
				),
				array(
					'name'  => 'Carpentry',
					'value' => 'carpentry',
				),
				array(
					'name'  => 'Handyman',
					'value' => 'handyman',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Service', 'homerix' ),
				'field' => 'name',
			),
			'fields'    => array(
				'name'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Service Name', 'homerix' ),
				),
				'value' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Service Value', 'homerix' ),
				),
			),
		)
	);

	// Locations Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'find_tech_locations',
			'label'     => esc_html__( 'Locations', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 40,
			'default'   => array(
				array(
					'name'  => 'Downtown',
					'value' => 'downtown',
				),
				array(
					'name'  => 'Midtown',
					'value' => 'midtown',
				),
				array(
					'name'  => 'Suburbs',
					'value' => 'suburbs',
				),
				array(
					'name'  => 'North Area',
					'value' => 'north',
				),
				array(
					'name'  => 'South Area',
					'value' => 'south',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Location Area', 'homerix' ),
				'field' => 'name',
			),
			'fields'    => array(
				'name'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Location Name', 'homerix' ),
				),
				'value' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Location Value', 'homerix' ),
				),
			),
		)
	);

	// ===== TECHNICIANS DATA SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'find_tech_technicians_heading',
			'section'  => 'homerix_find_technician_settings',
			'priority' => 195,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">👨‍🔧 Technicians Data</h3></div>',
		)
	);

	// Get default technicians from centralized function (pro-aware: 4 free, 15 pro).
	$default_technicians = function_exists( 'homerix_get_default_technicians' )
		? homerix_get_default_technicians()
		: array();

	// Define default services and locations (must match the defaults in field registration).
	$default_services = array(
		array(
			'name'  => 'Plumbing',
			'value' => 'plumbing',
		),
		array(
			'name'  => 'Electrical',
			'value' => 'electrical',
		),
		array(
			'name'  => 'HVAC',
			'value' => 'hvac',
		),
		array(
			'name'  => 'Carpentry',
			'value' => 'carpentry',
		),
		array(
			'name'  => 'Handyman',
			'value' => 'handyman',
		),
	);

	$default_locations = array(
		array(
			'name'  => 'Downtown',
			'value' => 'downtown',
		),
		array(
			'name'  => 'Midtown',
			'value' => 'midtown',
		),
		array(
			'name'  => 'Suburbs',
			'value' => 'suburbs',
		),
		array(
			'name'  => 'North Area',
			'value' => 'north',
		),
		array(
			'name'  => 'South Area',
			'value' => 'south',
		),
	);

	// Get services and locations from their repeaters, using defaults as fallback.
	$services_repeater  = get_theme_mod( 'find_tech_services', $default_services );
	$locations_repeater = get_theme_mod( 'find_tech_locations', $default_locations );

	// Convert services repeater to choices format.
	$service_choices = array();
	if ( is_string( $services_repeater ) ) {
		$services_repeater = json_decode( $services_repeater, true );
	}
	if ( is_array( $services_repeater ) && ! empty( $services_repeater ) ) {
		foreach ( $services_repeater as $service ) {
			if ( isset( $service['value'], $service['name'] ) ) {
				$service_choices[ $service['value'] ] = $service['name'];
			}
		}
	} else {
		// Use default service choices if repeater is empty.
		$service_choices = array(
			'plumbing'   => esc_html__( 'Plumbing', 'homerix' ),
			'electrical' => esc_html__( 'Electrical', 'homerix' ),
			'hvac'       => esc_html__( 'HVAC', 'homerix' ),
			'carpentry'  => esc_html__( 'Carpentry', 'homerix' ),
			'handyman'   => esc_html__( 'Handyman', 'homerix' ),
		);
	}

	// Convert locations repeater to choices format.
	$location_choices = array();
	if ( is_string( $locations_repeater ) ) {
		$locations_repeater = json_decode( $locations_repeater, true );
	}
	if ( is_array( $locations_repeater ) && ! empty( $locations_repeater ) ) {
		foreach ( $locations_repeater as $location ) {
			if ( isset( $location['value'], $location['name'] ) ) {
				$location_choices[ $location['value'] ] = $location['name'];
			}
		}
	} else {
		// Use default location choices if repeater is empty.
		$location_choices = array(
			'downtown' => esc_html__( 'Downtown', 'homerix' ),
			'midtown'  => esc_html__( 'Midtown', 'homerix' ),
			'suburbs'  => esc_html__( 'Suburbs', 'homerix' ),
			'north'    => esc_html__( 'North Area', 'homerix' ),
			'south'    => esc_html__( 'South Area', 'homerix' ),
		);
	}

	// Set default technicians only if no data exists — never overwrite customer data.
	$current_technicians = get_theme_mod( 'find_tech_technicians_list' );
	if ( empty( $current_technicians ) ) {
		set_theme_mod( 'find_tech_technicians_list', $default_technicians );
	}

	// Technicians Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'         => 'repeater',
			'settings'     => 'find_tech_technicians_list',
			'label'        => esc_html__( 'Technicians', 'homerix' ),
			'section'      => 'homerix_find_technician_settings',
			'priority'     => 260,
			'button_label' => esc_html__( 'Add Technician', 'homerix' ),
			'row_label'    => array(
				'type'  => 'field',
				'value' => esc_html__( 'Technician', 'homerix' ),
				'field' => 'tech_name',
			),
			'default'      => $default_technicians,
			'fields'       => array(
				'tech_name'         => array(
					'type'  => 'text',
					'label' => esc_html__( 'Name', 'homerix' ),
				),
				'tech_specialty'    => array(
					'type'  => 'text',
					'label' => esc_html__( 'Specialty', 'homerix' ),
				),
				'tech_image'        => array(
					'type'  => 'image',
					'label' => esc_html__( 'Photo', 'homerix' ),
				),
				'tech_bio'          => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Bio', 'homerix' ),
				),
				'tech_experience'   => array(
					'type'  => 'text',
					'label' => esc_html__( 'Experience Tags', 'homerix' ),
				),
				'tech_service'      => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Service Type', 'homerix' ),
					'choices' => $service_choices,
				),
				'tech_service_area' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Service Area', 'homerix' ),
					'choices' => $location_choices,
				),
			),
		)
	);

	// ===== WHY CHOOSE SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'find_tech_why_heading',
			'section'  => 'homerix_find_technician_settings',
			'priority' => 295,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">⭐ Why Choose Us</h3></div>',
		)
	);

	// Why Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'find_tech_why_title',
			'label'     => esc_html__( 'Section Title', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 300,
			'default'   => esc_html__( 'Why Choose Our Technicians', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Why Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'find_tech_why_subtitle',
			'label'     => esc_html__( 'Section Subtitle', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 310,
			'default'   => esc_html__( 'We maintain the highest standards for all Homerix Pro service professionals', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Why Choose Items Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'find_tech_why_items',
			'label'     => esc_html__( 'Why Choose Items', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 320,
			'default'   => array(
				array(
					'icon'        => 'fas fa-user-shield',
					'icon_color'  => '#2563EB',
					'title'       => 'Rigorous Vetting Process',
					'description' => 'Every technician undergoes background checks, license verification, and skills assessment.',
				),
				array(
					'icon'        => 'fas fa-medal',
					'icon_color'  => '#22c55e',
					'title'       => 'Proven Track Record',
					'description' => 'We only work with technicians who maintain consistently high customer ratings.',
				),
				array(
					'icon'        => 'fas fa-graduation-cap',
					'icon_color'  => '#eab308',
					'title'       => 'Continuous Training',
					'description' => 'Our technicians receive ongoing training on the latest techniques and technologies.',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Item', 'homerix' ),
				'field' => 'title',
			),
			'fields'    => array(
				'icon'        => array(
					'type'        => 'iconpicker',
					'label'       => esc_html__( 'Icon', 'homerix' ),
					'description' => sprintf(
						wp_kses(
												/* translators: %s: URL to FontAwesome icons page */
							__( 'Enter FontAwesome 7 icon class (e.g. fas fa-faucet) or select from picker. <a href="%s" target="_blank">Browse more icons</a>', 'homerix' ),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
								),
							)
						),
						'https://fontawesome.com/icons'
					),
					'default'     => 'fas fa-star',
				),
				'icon_color'  => array(
					'type'        => 'color',
					'label'       => esc_html__( 'Icon Color', 'homerix' ),
					'description' => esc_html__( 'Icon fill color. A lighter version will be used as background.', 'homerix' ),
					'default'     => '#2563EB',
				),
				'title'       => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title', 'homerix' ),
					'default' => '',
				),
				'description' => array(
					'type'    => 'textarea',
					'label'   => esc_html__( 'Description', 'homerix' ),
					'default' => '',
				),
			),
		)
	);

	// ===== CTA SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'find_tech_cta_heading',
			'section'  => 'homerix_find_technician_settings',
			'priority' => 395,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📢 Call to Action</h3></div>',
		)
	);

	// CTA Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'find_tech_cta_title',
			'label'     => esc_html__( 'CTA Title', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 400,
			'default'   => esc_html__( 'Are You a Skilled Technician?', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'find_tech_cta_subtitle',
			'label'     => esc_html__( 'CTA Subtitle', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 410,
			'default'   => esc_html__( 'Join our network of trusted home service professionals', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Button Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'text',
			'settings' => 'find_tech_cta_btn_text',
			'label'    => esc_html__( 'Primary Button Text', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 420,
			'default'  => esc_html__( 'Apply to Join Our Team', 'homerix' ),
		)
	);

	// CTA Button URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'link',
			'settings' => 'find_tech_cta_btn_url',
			'label'    => esc_html__( 'Primary Button URL', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 430,
			'default'  => '#apply',
		)
	);

	// CTA Secondary Button Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'text',
			'settings' => 'find_tech_cta_secondary_btn_text',
			'label'    => esc_html__( 'Secondary Button Text', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 440,
			'default'  => esc_html__( 'Learn More', 'homerix' ),
		)
	);

	// CTA Secondary Button URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'link',
			'settings' => 'find_tech_cta_secondary_btn_url',
			'label'    => esc_html__( 'Secondary Button URL', 'homerix' ),
			'section'  => 'homerix_find_technician_settings',
			'priority' => 450,
			'default'  => '#learn-more',
		)
	);

	// CTA Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'find_tech_cta_bg_color',
			'label'     => esc_html__( 'CTA Background Color', 'homerix' ),
			'section'   => 'homerix_find_technician_settings',
			'priority'  => 460,
			'default'   => homerix_get_theme_color( 'primary' ),
			'transport' => 'postMessage',
		)
	);
}

// Call the functions directly during file inclusion if Kirki is available.
if ( class_exists( 'Kirki' ) ) {
	homerix_find_technician_sections();
	homerix_find_technician_controls();
}

/**
 * Enqueue customizer control scripts for Find Technician page
 * This handles dynamic dropdown updates when Services/Locations repeaters change
 */
add_action( 'customize_controls_enqueue_scripts', 'homerix_find_technician_customizer_controls_js' );
function homerix_find_technician_customizer_controls_js() {
	wp_enqueue_script(
		'homerix-find-technician-customizer-controls',
		get_template_directory_uri() . '/assets/js/customizer/find-technician-customizer-controls.js',
		array( 'jquery', 'customize-controls' ),
		defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0',
		true
	);
}

/**
 * Enqueue customizer preview scripts for Find Technician page
 */
add_action( 'customize_preview_init', 'homerix_find_technician_customize_preview_js' );
function homerix_find_technician_customize_preview_js() {
	wp_enqueue_script(
		'homerix-find-technician-customizer-preview',
		get_template_directory_uri() . '/assets/js/customizer/find-technician-customizer-preview.js',
		array( 'jquery', 'customize-preview' ),
		defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0',
		true
	);
}
