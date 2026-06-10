<?php
/**
 * Enhanced Technicians Section Customizer Controls
 * Uses Kirki for advanced controls with repeater functionality
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Add Technicians Section to Homepage Sections Panel
 */
add_action( 'init', 'homerix_add_technicians_section' );
function homerix_add_technicians_section() {

	// Add Technicians Section to the existing homerix_sections panel.
	Kirki::add_section(
		'homerix_technicians',
		array(
			'title'       => esc_html__( 'Technicians Section', 'homerix' ),
			'description' => esc_html__( 'Configure the featured technicians section on your homepage.', 'homerix' ),
			'panel'       => 'homerix_sections',
			'priority'    => apply_filters( 'section_priority', 30, 'homerix_technicians' ),
		)
	);
}

/**
 * Add Technicians Section Controls
 */
add_action( 'init', 'homerix_technicians_section_customizer' );
function homerix_technicians_section_customizer() {

	// Set default values if not already set.
	if ( ! get_theme_mod( 'technicians_section_settings' ) ) {
		set_theme_mod(
			'technicians_section_settings',
			array(
				'section_enabled'   => true,
				'section_title'     => esc_html__( 'Featured Technicians', 'homerix' ),
				'section_subtitle'  => esc_html__( 'Meet our certified professionals ready to help you', 'homerix' ),
				'layout_columns'    => 4,
				'background_color'  => '#ffffff',
				'show_view_all_btn' => true,
				'view_all_btn_text' => esc_html__( 'View All Technicians', 'homerix' ),
				'view_all_btn_url'  => home_url( '/homerix-technicians' ),
			)
		);
	}

	if ( ! get_theme_mod( 'technicians_items' ) ) {
		set_theme_mod(
			'technicians_items',
			array(
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'Michael Johnson', 'homerix' ),
					'technician_specialty'    => esc_html__( 'Licensed Plumber', 'homerix' ),
					'technician_image'        => get_stylesheet_directory_uri() . '/assets/img/technician-1.jpg',
					'technician_rating'       => '4.9',
					'technician_hourly_rate'  => '$85/hr',
					'technician_service_area' => '10 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'Sarah Williams', 'homerix' ),
					'technician_specialty'    => esc_html__( 'Master Electrician', 'homerix' ),
					'technician_image'        => get_stylesheet_directory_uri() . '/assets/img/about-team-volunteering.jpg',
					'technician_rating'       => '4.8',
					'technician_hourly_rate'  => '$95/hr',
					'technician_service_area' => '15 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'David Rodriguez', 'homerix' ),
					'technician_specialty'    => esc_html__( 'HVAC Specialist', 'homerix' ),
					'technician_image'        => get_stylesheet_directory_uri() . '/assets/img/technician-3.jpg',
					'technician_rating'       => '5.0',
					'technician_hourly_rate'  => '$110/hr',
					'technician_service_area' => '20 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'James Wilson', 'homerix' ),
					'technician_specialty'    => esc_html__( 'Finish Carpenter', 'homerix' ),
					'technician_image'        => get_stylesheet_directory_uri() . '/assets/img/technician-4.jpg',
					'technician_rating'       => '4.7',
					'technician_hourly_rate'  => '$75/hr',
					'technician_service_area' => '25 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
			)
		);
	}

	// Section Enable/Disable.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'technicians_section_enabled',
			'label'           => esc_html__( 'Enable Technicians Section', 'homerix' ),
			'description'     => esc_html__( 'Show or hide the technicians section on your homepage.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 10,
			'default'         => true,
			'partial_refresh' => array(
				'technicians_section_enabled' => array(
					'selector'            => '.homerix-technicians',
					'container_inclusive' => false,
					'render_callback'     => '',
				),
			),
		)
	);
	// Container Size
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'technicians_container_size',
			'label'           => esc_html__( 'Container Size', 'homerix' ),
			'description'     => esc_html__( 'Choose the width of the technicians section container.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 11,
			'default'         => 'container mx-auto px-4',
			'choices'         => array(
				'container mx-auto px-4'             => esc_html__( 'Container', 'homerix' ),
				'w-full px-4 max-w-[1600px] mx-auto' => esc_html__( 'Full Container', 'homerix' ),
				'w-full px-4'                        => esc_html__( 'Fluid', 'homerix' ),
			),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'technicians_section_title',
			'label'           => esc_html__( 'Section Title', 'homerix' ),
			'description'     => esc_html__( 'Enter the main title for the technicians section.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 15,
			'default'         => esc_html__( 'Featured Technicians', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'technicians_section_subtitle',
			'label'           => esc_html__( 'Section Subtitle', 'homerix' ),
			'description'     => esc_html__( 'Optional subtitle text below the main title.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 20,
			'default'         => esc_html__( 'Meet our certified professionals ready to help you', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Technicians Items Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'repeater',
			'settings'        => 'technicians_items',
			'label'           => esc_html__( 'Technicians', 'homerix' ),
			'description'     => esc_html__( 'Add, remove, and customize your technicians. Drag to reorder.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 25,
			'row_label'       => array(
				'type'  => 'field',
				'value' => esc_html__( 'Technician', 'homerix' ),
				'field' => 'technician_name',
			),
			'button_label'    => esc_html__( 'Add New Technician', 'homerix' ),
			'fields'          => array(
				'technician_enabled'      => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Enable Technician', 'homerix' ),
					'description' => esc_html__( 'Show or hide this technician.', 'homerix' ),
					'default'     => true,
				),
				'technician_name'         => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Technician Name', 'homerix' ),
					'description' => esc_html__( 'Enter the technician\'s full name.', 'homerix' ),
					'default'     => esc_html__( 'John Doe', 'homerix' ),
				),
				'technician_specialty'    => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Specialty/Title', 'homerix' ),
					'description' => esc_html__( 'Enter the technician\'s specialty or job title.', 'homerix' ),
					'default'     => esc_html__( 'Licensed Professional', 'homerix' ),
				),
				'technician_image'        => array(
					'type'        => 'image',
					'label'       => esc_html__( 'Technician Photo', 'homerix' ),
					'description' => esc_html__( 'Upload a professional photo of the technician.', 'homerix' ),
					'default'     => '',
				),
				'technician_rating'       => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Rating', 'homerix' ),
					'description' => esc_html__( 'Enter the technician\'s rating (e.g., 4.9).', 'homerix' ),
					'default'     => '5.0',
				),
				'technician_hourly_rate'  => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Hourly Rate', 'homerix' ),
					'description' => esc_html__( 'Enter the hourly rate (e.g., $85/hr).', 'homerix' ),
					'default'     => '$85/hr',
				),
				'technician_service_area' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Service Area', 'homerix' ),
					'description' => esc_html__( 'Enter the service area coverage.', 'homerix' ),
					'default'     => '10 miles radius',
				),
				'technician_book_url'     => array(
					'type'        => 'url',
					'label'       => esc_html__( 'Book Now URL', 'homerix' ),
					'description' => esc_html__( 'URL for booking this technician.', 'homerix' ),
					'default'     => home_url( '/homerix-book-now' ),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
			'default'         => array(
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'Michael Johnson', 'homerix' ),
					'technician_specialty'    => esc_html__( 'Licensed Plumber', 'homerix' ),
					'technician_image'        => '',
					'technician_rating'       => '4.9',
					'technician_hourly_rate'  => '$85/hr',
					'technician_service_area' => '10 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'Sarah Williams', 'homerix' ),
					'technician_specialty'    => esc_html__( 'Master Electrician', 'homerix' ),
					'technician_image'        => '',
					'technician_rating'       => '4.8',
					'technician_hourly_rate'  => '$95/hr',
					'technician_service_area' => '15 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'David Rodriguez', 'homerix' ),
					'technician_specialty'    => esc_html__( 'HVAC Specialist', 'homerix' ),
					'technician_image'        => '',
					'technician_rating'       => '5.0',
					'technician_hourly_rate'  => '$110/hr',
					'technician_service_area' => '20 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
				array(
					'technician_enabled'      => true,
					'technician_name'         => esc_html__( 'James Wilson', 'homerix' ),
					'technician_specialty'    => esc_html__( 'Finish Carpenter', 'homerix' ),
					'technician_image'        => '',
					'technician_rating'       => '4.7',
					'technician_hourly_rate'  => '$75/hr',
					'technician_service_area' => '25 miles radius',
					'technician_book_url'     => home_url( '/homerix-book-now' ),
				),
			),
		)
	);

	// Layout Columns
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'technicians_layout_columns',
			'label'           => esc_html__( 'Layout Columns', 'homerix' ),
			'description'     => esc_html__( 'Choose how many columns to display on desktop.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 30,
			'default'         => '4',
			'choices'         => array(
				'2' => esc_html__( '2 Col', 'homerix' ),
				'3' => esc_html__( '3 Col', 'homerix' ),
				'4' => esc_html__( '4 Col', 'homerix' ),
				'6' => esc_html__( '6 Col', 'homerix' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show View All Button
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'technicians_show_view_all_btn',
			'label'           => esc_html__( 'Show View All Button', 'homerix' ),
			'description'     => esc_html__( 'Display a "View All" button below the technicians.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 40,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// View All Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'technicians_view_all_btn_text',
			'label'           => esc_html__( 'View All Button Text', 'homerix' ),
			'description'     => esc_html__( 'Text for the view all button.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 45,
			'default'         => esc_html__( 'View All Technicians', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'technicians_show_view_all_btn',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// View All Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'url',
			'settings'        => 'technicians_view_all_btn_url',
			'label'           => esc_html__( 'View All Button URL', 'homerix' ),
			'description'     => esc_html__( 'URL for the view all button.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 50,
			'default'         => home_url( '/homerix-find-technician' ),
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'technicians_show_view_all_btn',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	/**
	 * Technicians Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'technicians_color_override_separator',
			'section'         => 'homerix_technicians',
			'priority'        => 100,
			'default'         => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable Color Override Toggle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'technicians_color_override_enabled',
			'label'           => esc_html__( 'Enable Color Override', 'homerix' ),
			'description'     => esc_html__( 'Enable custom colors for this section.', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 101,
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'technicians_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_section_bg_color',
			'label'           => esc_html__( 'Section Background', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 102,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'background' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Title Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_title_color',
			'label'           => esc_html__( 'Title Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 103,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Subtitle Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_subtitle_color',
			'label'           => esc_html__( 'Subtitle Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#6b7280',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Card Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_card_bg_color',
			'label'           => esc_html__( 'Card Background', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Technician Name Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_name_color',
			'label'           => esc_html__( 'Technician Name Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Specialty Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_specialty_color',
			'label'           => esc_html__( 'Specialty Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Star Rating Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_star_color',
			'label'           => esc_html__( 'Star Rating Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 108,
			'default'         => '#fbbf24',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_button_bg_color',
			'label'           => esc_html__( 'Button Background', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 109,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Text Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_button_text_color',
			'label'           => esc_html__( 'Button Text Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 110,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Hover Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_button_hover_bg_color',
			'label'           => esc_html__( 'Button Hover Background', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 111,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Hover Text Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'technicians_button_hover_text_color',
			'label'           => esc_html__( 'Button Hover Text Color', 'homerix' ),
			'section'         => 'homerix_technicians',
			'priority'        => 112,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'technicians_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

/**
 * Customizer live preview JavaScript for technicians section
 */
add_action( 'customize_preview_init', 'homerix_technicians_customize_preview_js' );
function homerix_technicians_customize_preview_js() {
	wp_enqueue_script(
		'homerix-technicians-customizer-preview',
		get_template_directory_uri() . '/assets/js/customizer/technicians-customizer-preview.js',
		array( 'jquery', 'customize-preview' ),
		defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0',
		true
	);
}
