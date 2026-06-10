<?php
/**
 * Services Page Customizer Settings
 *
 * Kirki-based customizer panel for the Services page
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


/**
 * Initialize Services Page Customizer Defaults
 * Sets default values for services page settings if not already set
 */
add_action( 'init', 'homerix_services_page_defaults' );
function homerix_services_page_defaults() {
	// Set default parent services if not already set
	if ( ! get_theme_mod( 'services_parent_services' ) ) {
		set_theme_mod(
			'services_parent_services',
			array(
				array(
					'name'        => 'Plumbing',
					'value'       => 'plumbing',
					'icon'        => 'fas fa-faucet',
					'color'       => '#2563EB',
					'description' => 'Our licensed plumbers provide reliable solutions for all your plumbing needs, from simple leaks to complete pipe replacements.',
				),
				array(
					'name'        => 'Electrical',
					'value'       => 'electrical',
					'icon'        => 'fas fa-bolt',
					'color'       => '#eab308',
					'description' => 'Certified electricians for safe and code-compliant electrical repairs and installations.',
				),
				array(
					'name'        => 'HVAC',
					'value'       => 'hvac',
					'icon'        => 'fas fa-thermometer-half',
					'color'       => '#ef4444',
					'description' => 'Heating and cooling solutions to keep your home comfortable year-round.',
				),
				array(
					'name'        => 'Handyman',
					'value'       => 'handyman',
					'icon'        => 'fas fa-tools',
					'color'       => '#22c55e',
					'description' => 'General home repairs and maintenance for all your household needs.',
				),
			)
		);
	}

	// Set default sub-services if not already set
	if ( ! get_theme_mod( 'services_sub_services' ) ) {
		set_theme_mod(
			'services_sub_services',
			array(
				// Plumbing Services
				array(
					'parent_service' => 'plumbing',
					'name'           => 'Leak Detection & Repair',
					'description'    => 'Find and fix hidden leaks before they cause water damage.',
					'price'          => '$99+',
					'features'       => 'Pipe leak repairs|Faucet and fixture leaks|Water damage prevention',
				),
				array(
					'parent_service' => 'plumbing',
					'name'           => 'Drain Cleaning',
					'description'    => 'Clear clogged drains and prevent future blockages.',
					'price'          => '$129+',
					'features'       => 'Kitchen sink clogs|Bathroom drain clearing|Main line cleaning',
				),
				array(
					'parent_service' => 'plumbing',
					'name'           => 'Water Heater Services',
					'description'    => 'Installation, repair, and maintenance for all water heater types.',
					'price'          => '$199+',
					'features'       => 'Tank and tankless systems|Leak repairs|Full replacements',
				),
				// Electrical Services
				array(
					'parent_service' => 'electrical',
					'name'           => 'Lighting Installation',
					'description'    => 'Professional installation of all lighting fixtures.',
					'price'          => '$89+',
					'features'       => 'Ceiling lights & chandeliers|Outdoor lighting|Smart lighting systems',
				),
				array(
					'parent_service' => 'electrical',
					'name'           => 'Outlet & Switch Repair',
					'description'    => 'Fix faulty outlets and switches for safer home.',
					'price'          => '$129+',
					'features'       => 'GFCI outlet installation|Three-way switch wiring|Circuit troubleshooting',
				),
				array(
					'parent_service' => 'electrical',
					'name'           => 'Panel Upgrades',
					'description'    => 'Modern electrical panel solutions for safer homes.',
					'price'          => '$199+',
					'features'       => '100-200 amp service|Circuit breaker replacements|Safety inspections',
				),
				// HVAC Services
				array(
					'parent_service' => 'hvac',
					'name'           => 'AC Repair & Maintenance',
					'description'    => 'Keep your cooling system running efficiently.',
					'price'          => '$79+',
					'features'       => 'Diagnostic services|Refrigerant recharge|Seasonal tune-ups',
				),
				array(
					'parent_service' => 'hvac',
					'name'           => 'Heating System Services',
					'description'    => 'Furnace and boiler repairs for winter warmth.',
					'price'          => '$129+',
					'features'       => 'Furnace repairs|Boiler maintenance|Pilot light issues',
				),
				array(
					'parent_service' => 'hvac',
					'name'           => 'Duct Cleaning',
					'description'    => 'Improve air quality and system efficiency.',
					'price'          => '$149+',
					'features'       => 'Air duct cleaning|Vent cleaning|System efficiency improvement',
				),
				// Handyman Services
				array(
					'parent_service' => 'handyman',
					'name'           => 'Drywall & Painting',
					'description'    => 'Professional drywall repair and interior painting.',
					'price'          => '$75+',
					'features'       => 'Drywall patching|Interior painting|Texture finishing',
				),
				array(
					'parent_service' => 'handyman',
					'name'           => 'Door & Lock Repair',
					'description'    => 'Fix or replace doors, locks, and hardware.',
					'price'          => '$99+',
					'features'       => 'Door repairs|Lock replacement|Hardware installation',
				),
				array(
					'parent_service' => 'handyman',
					'name'           => 'General Repairs',
					'description'    => 'All-purpose home repairs and maintenance.',
					'price'          => '$65+',
					'features'       => 'Caulking & sealing|Trim work|General maintenance',
				),
			)
		);
	}

	// Set default Book Now URL if not already set
	if ( ! get_theme_mod( 'services_book_now_url' ) ) {
		set_theme_mod( 'services_book_now_url', get_site_url() . '/homerix-book-now' );
	}
}

/**
 * Add Services Page Panel and Sections
 * Note: This section is now nested under 'homerix_pages_settings' panel
 * Called directly during file inclusion (no add_action needed).
 */
function homerix_add_services_page_section() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-site-services.php' );
	$description = esc_html__( 'Configure the Services page settings and appearance.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit Services Page', 'homerix' ) . '</a>';
	}

	/**
	 * Main Services Page Settings Section
	 */
	Kirki::add_section(
		'homerix_services_page_settings',
		array(
			'title'       => esc_html__( 'Services Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 30,
		)
	);

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_hero_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Show Hero Section
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'services_show_hero',
			'label'    => esc_html__( 'Show Hero Section', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 6,
			'default'  => true,
		)
	);

	// Hero Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_hero_title',
			'label'           => esc_html__( 'Hero Title', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 10,
			'default'         => __( 'Professional Home Repair Services', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'services_hero_subtitle',
			'label'           => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 20,
			'default'         => __( 'Quality repairs done right the first time by certified local technicians', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Background Image
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'image',
			'settings'        => 'services_hero_bg_image',
			'label'           => esc_html__( 'Hero Background Image', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 25,
			'default'         => get_template_directory_uri() . '/assets/img/services-bg.jpg',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_hero_bg_color',
			'label'           => esc_html__( 'Hero Background Color', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 30,
			'default'         => '#2563eb',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Overlay Toggle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'services_hero_overlay_enabled',
			'label'           => esc_html__( 'Enable Hero Overlay', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 32,
			'default'         => true,
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Overlay Opacity
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'services_hero_overlay_opacity',
			'label'           => esc_html__( 'Hero Overlay Opacity', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 34,
			'default'         => 40,
			'choices'         => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
			),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_hero_overlay_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_hero_btn_text',
			'label'           => esc_html__( 'Hero Button Text', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 40,
			'default'         => __( 'Book a Service', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'link',
			'settings'        => 'services_hero_btn_url',
			'label'           => esc_html__( 'Hero Button URL', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 50,
			'default'         => get_site_url() . '/homerix-book-now',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_hero',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== MAIN SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_main_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 95,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📋 Main Section</h3></div>',
		)
	);

	// Main Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'services_main_title',
			'label'     => esc_html__( 'Main Title', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 100,
			'default'   => __( 'Our Comprehensive Services', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Main Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'services_main_subtitle',
			'label'     => esc_html__( 'Main Subtitle', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 110,
			'default'   => __( 'From emergency repairs to planned renovations, we handle all your home maintenance needs with expertise and care.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// ===== PARENT SERVICES SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_parent_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 145,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🏢 Parent Services</h3></div>',
		)
	);

	// Parent Services Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'services_parent_services',
			'label'     => esc_html__( 'Parent Services', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 150,
			'default'   => array(
				array(
					'name'        => 'Plumbing',
					'value'       => 'plumbing',
					'icon'        => 'fas fa-faucet',
					'color'       => '#2563EB',
					'description' => 'Our licensed plumbers provide reliable solutions for all your plumbing needs, from simple leaks to complete pipe replacements.',
				),
				array(
					'name'        => 'Electrical',
					'value'       => 'electrical',
					'icon'        => 'fas fa-bolt',
					'color'       => '#eab308',
					'description' => 'Certified electricians for safe and code-compliant electrical repairs and installations.',
				),
				array(
					'name'        => 'HVAC',
					'value'       => 'hvac',
					'icon'        => 'fas fa-thermometer-half',
					'color'       => '#ef4444',
					'description' => 'Heating and cooling solutions to keep your home comfortable year-round.',
				),
				array(
					'name'        => 'Handyman',
					'value'       => 'handyman',
					'icon'        => 'fas fa-tools',
					'color'       => '#22c55e',
					'description' => 'General home repairs and maintenance for all your household needs.',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Service Name', 'homerix' ),
				'field' => 'name',
			),
			'fields'    => array(
				'name'        => array(
					'type'  => 'text',
					'label' => esc_html__( 'Service Name', 'homerix' ),
				),
				'value'       => array(
					'type'  => 'text',
					'label' => esc_html__( 'Service Value/ID', 'homerix' ),
				),
				'icon'        => array(
					'type'        => 'iconpicker',
					'label'       => esc_html__( 'Font Awesome Icon', 'homerix' ),
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
				),
				'color'       => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Service Color', 'homerix' ),
					'choices' => array(
						'alpha' => true,
					),
				),
				'description' => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Service Description', 'homerix' ),
				),
			),
		)
	);

	// ===== BOOK NOW LINK SECTION HEADING =====
	// Kirki::add_field(
	// 'homerix_theme_config',
	// array(
	// 'type'        => 'custom',
	// 'settings'    => 'services_book_now_heading',
	// 'section'     => 'homerix_services_page_settings',
	// 'priority'    => 152,
	// 'default'     => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📅 Book Now Link</h3></div>',
	// )
	// );

	// Book Now URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'link',
			'settings'  => 'services_book_now_url',
			'label'     => esc_html__( 'Book Now Button URL', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 153,
			'default'   => get_site_url() . '/homerix-book-now',
			'transport' => 'postMessage',
		)
	);

	// ===== SUB-SERVICES SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_sub_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 155,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🔧 Sub-Services (Linked to Parent)</h3></div>',
		)
	);

	// Sub-Services Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'services_sub_services',
			'label'     => esc_html__( 'Sub-Services', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 160,
			'default'   => array(
				// Plumbing Services
				array(
					'parent_service' => 'plumbing',
					'name'           => 'Leak Detection & Repair',
					'description'    => 'Find and fix hidden leaks before they cause water damage.',
					'price'          => '$99+',
					'features'       => 'Pipe leak repairs|Faucet and fixture leaks|Water damage prevention',
				),
				array(
					'parent_service' => 'plumbing',
					'name'           => 'Drain Cleaning',
					'description'    => 'Clear clogged drains and prevent future blockages.',
					'price'          => '$129+',
					'features'       => 'Kitchen sink clogs|Bathroom drain clearing|Main line cleaning',
				),
				array(
					'parent_service' => 'plumbing',
					'name'           => 'Water Heater Services',
					'description'    => 'Installation, repair, and maintenance for all water heater types.',
					'price'          => '$199+',
					'features'       => 'Tank and tankless systems|Leak repairs|Full replacements',
				),
				// Electrical Services
				array(
					'parent_service' => 'electrical',
					'name'           => 'Lighting Installation',
					'description'    => 'Professional installation of all lighting fixtures.',
					'price'          => '$89+',
					'features'       => 'Ceiling lights & chandeliers|Outdoor lighting|Smart lighting systems',
				),
				array(
					'parent_service' => 'electrical',
					'name'           => 'Outlet & Switch Repair',
					'description'    => 'Fix faulty outlets and switches for safer home.',
					'price'          => '$129+',
					'features'       => 'GFCI outlet installation|Three-way switch wiring|Circuit troubleshooting',
				),
				array(
					'parent_service' => 'electrical',
					'name'           => 'Panel Upgrades',
					'description'    => 'Modern electrical panel solutions for safer homes.',
					'price'          => '$199+',
					'features'       => '100-200 amp service|Circuit breaker replacements|Safety inspections',
				),
				// HVAC Services
				array(
					'parent_service' => 'hvac',
					'name'           => 'AC Repair & Maintenance',
					'description'    => 'Keep your cooling system running efficiently.',
					'price'          => '$79+',
					'features'       => 'Diagnostic services|Refrigerant recharge|Seasonal tune-ups',
				),
				array(
					'parent_service' => 'hvac',
					'name'           => 'Heating System Services',
					'description'    => 'Furnace and boiler repairs for winter warmth.',
					'price'          => '$129+',
					'features'       => 'Furnace repairs|Boiler maintenance|Pilot light issues',
				),
				array(
					'parent_service' => 'hvac',
					'name'           => 'Duct Cleaning',
					'description'    => 'Improve air quality and system efficiency.',
					'price'          => '$199+',
					'features'       => 'Full system cleaning|Mold inspection|Air quality testing',
				),
				// Handyman Services
				array(
					'parent_service' => 'handyman',
					'name'           => 'Drywall Repair',
					'description'    => 'Fix holes, cracks, and damage to walls and ceilings.',
					'price'          => '$65+',
					'features'       => 'Patch small to large holes|Water damage repair|Texture matching',
				),
				array(
					'parent_service' => 'handyman',
					'name'           => 'Door & Window Repair',
					'description'    => 'Fix sticking doors, broken locks, and window issues.',
					'price'          => '$89+',
					'features'       => 'Adjustment and alignment|Lock installation|Screen replacement',
				),
				array(
					'parent_service' => 'handyman',
					'name'           => 'Deck & Fence Repair',
					'description'    => 'Restore outdoor structures to like-new condition.',
					'price'          => '$129+',
					'features'       => 'Loose board repair|Staining and sealing|Structural reinforcement',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Sub-Service Name', 'homerix' ),
				'field' => 'name',
			),
			'fields'    => array(
				'parent_service' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Parent Service ID (plumbing/electrical/hvac/handyman)', 'homerix' ),
				),
				'name'           => array(
					'type'  => 'text',
					'label' => esc_html__( 'Sub-Service Name', 'homerix' ),
				),
				'description'    => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Sub-Service Description', 'homerix' ),
				),
				'price'          => array(
					'type'  => 'text',
					'label' => esc_html__( 'Price (e.g., $99+)', 'homerix' ),
				),
				'features'       => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Features (separated by |)', 'homerix' ),
				),
			),
		)
	);

	// ===== EMERGENCY SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_emergency_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 195,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🚨 Emergency Section</h3></div>',
		)
	);

	// Show Emergency Section
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'services_show_emergency',
			'label'    => esc_html__( 'Show Emergency Section', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 200,
			'default'  => true,
		)
	);

	// Emergency Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_emergency_title',
			'label'           => esc_html__( 'Emergency Title', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 210,
			'default'         => __( '24/7 Emergency Repair Services', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Emergency Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'services_emergency_subtitle',
			'label'           => esc_html__( 'Emergency Subtitle', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 220,
			'default'         => __( 'Got a home emergency? We\'re available around the clock to handle urgent repairs when you need them most.', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Emergency Phone
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_emergency_phone',
			'label'           => esc_html__( 'Emergency Phone Number', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 230,
			'default'         => '(555) 123-4567',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable Emergency Phone Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'services_emergency_phone_enabled',
			'label'           => esc_html__( 'Enable Emergency Phone Button', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 235,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable Emergency Book Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'services_emergency_btn_enabled',
			'label'           => esc_html__( 'Enable Emergency Book Button', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 236,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Emergency Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_emergency_btn_text',
			'label'           => esc_html__( 'Emergency Button Text', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 240,
			'default'         => __( 'Book Emergency Service', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_emergency_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Emergency Button URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'link',
			'settings'        => 'services_emergency_btn_url',
			'label'           => esc_html__( 'Emergency Button URL', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 245,
			'default'         => get_site_url() . '/homerix-book-now',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_emergency',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_emergency_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== SERVICE AREAS SECTION FIELDS =====

	// Service Areas Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'repeater',
			'settings'        => 'services_areas_list',
			'label'           => esc_html__( 'Service Areas', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 295,
			'default'         => array(
				array(
					'area_title'     => 'Metro Area',
					'area_locations' => 'Downtown|Midtown|Uptown|East Side|West End',
				),
				array(
					'area_title'     => 'Suburbs',
					'area_locations' => 'Green Valley|Lakeview|Pine Hills|Oak Brook|Riverdale',
				),
				array(
					'area_title'     => 'Surrounding Areas',
					'area_locations' => 'Springfield|Fairview|Maplewood|Clinton|Franklin',
				),
			),
			'row_label'       => array(
				'type'  => 'field',
				'value' => esc_html__( 'Area Title', 'homerix' ),
				'field' => 'area_title',
			),
			'fields'          => array(
				'area_title'     => array(
					'type'  => 'text',
					'label' => esc_html__( 'Area Title', 'homerix' ),
				),
				'area_locations' => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Locations (separated by |)', 'homerix' ),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== SERVICE AREAS SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_areas_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 250,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📍 Service Areas</h3></div>',
		)
	);

	// Show Service Areas
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'services_show_areas',
			'label'    => esc_html__( 'Show Service Areas Section', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 260,
			'default'  => true,
		)
	);

	// Areas Title (moved below Show Service Areas Section)
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_areas_title',
			'label'           => esc_html__( 'Areas Title', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 261,
			'default'         => __( 'Our Service Areas', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Areas Subtitle (moved below Areas Title)
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'services_areas_subtitle',
			'label'           => esc_html__( 'Areas Subtitle', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 262,
			'default'         => __( 'Proudly serving homeowners throughout the region with reliable home repair services.', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Areas CTA Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_areas_cta_text',
			'label'           => esc_html__( 'Areas CTA Text', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 315,
			'default'         => __( 'Don\'t see your neighborhood listed? Give us a call to check availability.', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable Areas CTA Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'services_areas_btn_enabled',
			'label'           => esc_html__( 'Enable Areas CTA Button', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 318,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Areas CTA Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_areas_btn_text',
			'label'           => esc_html__( 'Areas CTA Button Text', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 320,
			'default'         => __( 'Call to Verify Service Area', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_areas_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Areas CTA Button Phone
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_areas_btn_phone',
			'label'           => esc_html__( 'Areas CTA Phone Number', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 325,
			'default'         => '(555) 123-4567',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_areas',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_areas_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== WHY CHOOSE SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_why_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 395,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">⭐ Why Choose Us</h3></div>',
		)
	);

	// Show Why Choose
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'services_show_why_choose',
			'label'    => esc_html__( 'Show Why Choose Section', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 400,
			'default'  => true,
		)
	);

	// Why Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_why_title',
			'label'           => esc_html__( 'Why Choose Title', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 410,
			'default'         => __( 'Why Choose Homerix Pro', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_why_choose',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Why Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'services_why_subtitle',
			'label'           => esc_html__( 'Why Choose Subtitle', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 420,
			'default'         => __( 'We\'re committed to delivering exceptional service with every repair.', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_show_why_choose',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Why Choose Items Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'repeater',
			'settings'        => 'services_why_items',
			'label'           => esc_html__( 'Why Choose Items', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 430,
			'default'         => array(
				array(
					'icon'        => 'fas fa-user-shield',
					'icon_color'  => '#2563eb',
					'title'       => 'Vetted Professionals',
					'description' => 'All technicians are licensed, insured, and background-checked.',
				),
				array(
					'icon'        => 'fas fa-dollar-sign',
					'icon_color'  => '#16a34a',
					'title'       => 'Upfront Pricing',
					'description' => 'No hidden fees - know the cost before we start any work.',
				),
				array(
					'icon'        => 'fas fa-clock',
					'icon_color'  => '#eab308',
					'title'       => 'On-Time Guarantee',
					'description' => 'We arrive when promised or your service is discounted.',
				),
				array(
					'icon'        => 'fas fa-medal',
					'icon_color'  => '#dc2626',
					'title'       => 'Satisfaction Guaranteed',
					'description' => 'We stand behind our work with a 100% satisfaction guarantee.',
				),
			),
			'row_label'       => array(
				'type'  => 'field',
				'value' => esc_html__( 'Why Choose Item', 'homerix' ),
				'field' => 'title',
			),
			'fields'          => array(
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
				),
				'icon_color'  => array(
					'type'  => 'color',
					'label' => esc_html__( 'Icon Color', 'homerix' ),
				),
				'title'       => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'homerix' ),
				),
				'description' => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Description', 'homerix' ),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'services_show_why_choose',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== CTA SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_cta_heading',
			'section'  => 'homerix_services_page_settings',
			'priority' => 495,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📢 Call to Action</h3></div>',
		)
	);

	// CTA Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'services_cta_title',
			'label'     => esc_html__( 'CTA Title', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 500,
			'default'   => __( 'Ready to Get Your Home Repairs Done?', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'services_cta_subtitle',
			'label'     => esc_html__( 'CTA Subtitle', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 510,
			'default'   => __( 'Schedule your service online or give us a call today.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Enable CTA Primary Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'services_cta_btn_enabled',
			'label'    => esc_html__( 'Enable Primary CTA Button', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 515,
			'default'  => true,
		)
	);

	// CTA Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_cta_btn_text',
			'label'           => esc_html__( 'CTA Button Text', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 520,
			'default'         => __( 'Book Online Now', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_cta_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'link',
			'settings'        => 'services_cta_btn_url',
			'label'           => esc_html__( 'CTA Button URL', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 530,
			'default'         => get_site_url() . '/homerix-book-now',
			'active_callback' => array(
				array(
					'setting'  => 'services_cta_btn_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable CTA Secondary Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'services_cta_btn2_enabled',
			'label'    => esc_html__( 'Enable Secondary CTA Button', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 535,
			'default'  => true,
		)
	);

	// CTA Button 2 Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_cta_btn2_text',
			'label'           => esc_html__( 'Secondary CTA Button Text', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 540,
			'default'         => __( 'Call: (555) 123-4567', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_cta_btn2_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Button 2 URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'link',
			'settings'        => 'services_cta_btn2_url',
			'label'           => esc_html__( 'Secondary CTA Button URL', 'homerix' ),
			'section'         => 'homerix_services_page_settings',
			'priority'        => 545,
			'default'         => 'tel:+15551234567',
			'active_callback' => array(
				array(
					'setting'  => 'services_cta_btn2_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Secondary Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'services_cta_btn2_text',
			'label'     => esc_html__( 'CTA Secondary Button Text', 'homerix' ),
			'section'   => 'homerix_services_page_settings',
			'priority'  => 540,
			'default'   => __( 'Call: (555) 123-4567', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Secondary Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'link',
			'settings' => 'services_cta_btn2_url',
			'label'    => esc_html__( 'CTA Secondary Button URL', 'homerix' ),
			'section'  => 'homerix_services_page_settings',
			'priority' => 550,
			'default'  => 'tel:+15551234567',
		)
	);
}

// Call the function directly during file inclusion if Kirki is available.
if ( class_exists( 'Kirki' ) ) {
	homerix_add_services_page_section();
}
