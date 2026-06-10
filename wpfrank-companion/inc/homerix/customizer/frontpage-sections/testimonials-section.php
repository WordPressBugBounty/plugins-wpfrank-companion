<?php
/**
 * Testimonials Section Enhanced Customizer Controls
 * Advanced Kirki-powered customizer integration for testimonials section
 *
 * @package Homerix_Pro
 * @since 1.0.0
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
 * Add Testimonials Section to Homepage Sections Panel
 */
add_action( 'init', 'homerix_add_testimonials_section' );
function homerix_add_testimonials_section() {

	// Add Testimonials Section to the existing homerix_sections panel.
	Kirki::add_section(
		'homerix_testimonials',
		array(
			'title'       => esc_html__( 'Testimonials Section', 'homerix' ),
			'description' => esc_html__( 'Configure the customer testimonials section on your homepage.', 'homerix' ),
			'panel'       => 'homerix_sections',
			'priority'    => apply_filters( 'section_priority', 60, 'homerix_testimonials' ),
		)
	);
}

/**
 * Add Testimonials Section Controls
 */
add_action( 'init', 'homerix_testimonials_section_customizer' );
function homerix_testimonials_section_customizer() {

	// Set default values if not already set.
	if ( ! get_theme_mod( 'testimonials_section_settings' ) ) {
		set_theme_mod(
			'testimonials_section_settings',
			array(
				'section_enabled'  => true,
				'section_title'    => esc_html__( 'What Our Customers Say', 'homerix' ),
				'section_subtitle' => esc_html__( 'Real feedback from satisfied homeowners', 'homerix' ),
				'show_subtitle'    => true,
				'layout_columns'   => 3,
				'background_color' => 'light',
			)
		);
	}

	if ( ! get_theme_mod( 'testimonials_items' ) ) {
		set_theme_mod(
			'testimonials_items',
			array(
				array(
					'testimonial_enabled'  => true,
					'testimonial_name'     => esc_html__( 'Sarah Johnson', 'homerix' ),
					'testimonial_content'  => esc_html__( 'Excellent service! The plumber arrived on time and fixed our kitchen sink quickly. Very professional and reasonably priced.', 'homerix' ),
					'testimonial_rating'   => 5,
					'testimonial_image'    => '',
					'testimonial_location' => esc_html__( 'Downtown', 'homerix' ),
				),
				array(
					'testimonial_enabled'  => true,
					'testimonial_name'     => esc_html__( 'Mike Chen', 'homerix' ),
					'testimonial_content'  => esc_html__( 'Great experience with their electrical services. The technician was knowledgeable and explained everything clearly.', 'homerix' ),
					'testimonial_rating'   => 5,
					'testimonial_image'    => '',
					'testimonial_location' => esc_html__( 'Westside', 'homerix' ),
				),
				array(
					'testimonial_enabled'  => true,
					'testimonial_name'     => esc_html__( 'Lisa Rodriguez', 'homerix' ),
					'testimonial_content'  => esc_html__( 'Outstanding HVAC repair service. They diagnosed the problem quickly and had our heating working the same day.', 'homerix' ),
					'testimonial_rating'   => 5,
					'testimonial_image'    => '',
					'testimonial_location' => esc_html__( 'Northside', 'homerix' ),
				),
			)
		);
	}

	// Container Size
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'testimonials_container_size',
			'label'           => esc_html__( 'Container Size', 'homerix' ),
			'description'     => esc_html__( 'Choose the width of the testimonials section container.', 'homerix' ),
			'section'         => 'homerix_testimonials',
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
					'setting'  => 'testimonials_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Enable/Disable.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'testimonials_section_enabled',
			'label'           => esc_html__( 'Enable Testimonials Section', 'homerix' ),
			'description'     => esc_html__( 'Show or hide the testimonials section on your homepage.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 10,
			'default'         => true,
			'partial_refresh' => array(
				'testimonials_section_enabled' => array(
					'selector'            => '.homerix-testimonials',
					'container_inclusive' => false,
					'render_callback'     => '',
				),
			),
		)
	);

	// Section Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'testimonials_section_title',
			'label'           => esc_html__( 'Section Title', 'homerix' ),
			'description'     => esc_html__( 'Enter the main heading for the testimonials section.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 20,
			'default'         => esc_html__( 'What Our Customers Say', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
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
			'type'            => 'text',
			'settings'        => 'testimonials_section_subtitle',
			'label'           => esc_html__( 'Section Subtitle', 'homerix' ),
			'description'     => esc_html__( 'Optional subtitle text below the main heading.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 30,
			'default'         => esc_html__( 'Real feedback from satisfied homeowners', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Subtitle Toggle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'testimonials_show_subtitle',
			'label'           => esc_html__( 'Show Subtitle', 'homerix' ),
			'description'     => esc_html__( 'Display the subtitle below the main heading.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 35,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Layout Columns.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio-buttonset',
			'settings'        => 'testimonials_layout_columns',
			'label'           => esc_html__( 'Layout Columns', 'homerix' ),
			'description'     => esc_html__( 'Choose how many columns to display on desktop.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 40,
			'default'         => '3',
			'choices'         => array(
				'1' => esc_html__( '1 Col', 'homerix' ),
				'2' => esc_html__( '2 Col', 'homerix' ),
				'3' => esc_html__( '3 Col', 'homerix' ),
				'4' => esc_html__( '4 Col', 'homerix' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Background Color (using Homerix Colors).
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'select',
			'settings'        => 'testimonials_background_color',
			'label'           => esc_html__( 'Background Color', 'homerix' ),
			'description'     => esc_html__( 'Select the background color from Homerix color palette.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 50,
			'default'         => 'light',
			'choices'         => array(
				'primary'   => esc_html__( 'Primary Color', 'homerix' ),
				'secondary' => esc_html__( 'Secondary Color', 'homerix' ),
				'base'      => esc_html__( 'Base Color', 'homerix' ),
				'light'     => esc_html__( 'Light Color', 'homerix' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
	// Testimonials Items Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'repeater',
			'settings'        => 'testimonials_items',
			'label'           => esc_html__( 'Testimonials', 'homerix' ),
			'description'     => esc_html__( 'Add, remove, and customize your testimonials. Drag to reorder.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 80,
			'row_label'       => array(
				'type'  => 'field',
				'value' => esc_html__( 'Testimonial', 'homerix' ),
				'field' => 'testimonial_name',
			),
			'button_label'    => esc_html__( 'Add New Testimonial', 'homerix' ),
			'fields'          => array(
				'testimonial_enabled'  => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Enable Testimonial', 'homerix' ),
					'description' => esc_html__( 'Show or hide this testimonial.', 'homerix' ),
					'default'     => true,
				),
				'testimonial_name'     => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Customer Name', 'homerix' ),
					'description' => esc_html__( 'Enter the customer\'s name.', 'homerix' ),
					'default'     => esc_html__( 'Customer Name', 'homerix' ),
				),
				'testimonial_content'  => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Testimonial Content', 'homerix' ),
					'description' => esc_html__( 'Enter the testimonial text.', 'homerix' ),
					'default'     => esc_html__( 'Great service and professional work!', 'homerix' ),
				),
				'testimonial_rating'   => array(
					'type'        => 'slider',
					'label'       => esc_html__( 'Rating', 'homerix' ),
					'description' => esc_html__( 'Customer rating (1-5 stars).', 'homerix' ),
					'default'     => 5,
					'choices'     => array(
						'min'  => 1,
						'max'  => 5,
						'step' => 1,
					),
				),
				'testimonial_location' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Location', 'homerix' ),
					'description' => esc_html__( 'Customer location (optional).', 'homerix' ),
					'default'     => '',
				),
				'testimonial_image'    => array(
					'type'        => 'image',
					'label'       => esc_html__( 'Customer Photo', 'homerix' ),
					'description' => esc_html__( 'Upload customer photo (optional).', 'homerix' ),
					'default'     => '',
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	/**
	 * Testimonials Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'testimonials_color_override_separator',
			'section'         => 'homerix_testimonials',
			'priority'        => 100,
			'default'         => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
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
			'settings'        => 'testimonials_color_override_enabled',
			'label'           => esc_html__( 'Enable Color Override', 'homerix' ),
			'description'     => esc_html__( 'Enable custom colors for this section.', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 101,
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_section_enabled',
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
			'settings'        => 'testimonials_section_bg_color',
			'label'           => esc_html__( 'Section Background', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 102,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'light' ) : '#f3f4f6',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
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
			'settings'        => 'testimonials_title_color',
			'label'           => esc_html__( 'Title Color', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 103,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
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
			'settings'        => 'testimonials_subtitle_color',
			'label'           => esc_html__( 'Subtitle Color', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#6b7280',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
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
			'settings'        => 'testimonials_card_bg_color',
			'label'           => esc_html__( 'Card Background', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Quote Text Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'testimonials_quote_color',
			'label'           => esc_html__( 'Quote Text Color', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#4b5563',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Name Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'testimonials_name_color',
			'label'           => esc_html__( 'Author Name Color', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
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
			'settings'        => 'testimonials_star_color',
			'label'           => esc_html__( 'Star Rating Color', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 108,
			'default'         => '#fbbf24',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Location Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'testimonials_location_color',
			'label'           => esc_html__( 'Location Color', 'homerix' ),
			'section'         => 'homerix_testimonials',
			'priority'        => 109,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#6b7280',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'testimonials_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}
