<?php
/**
 * CTA Banner Section Enhanced Customizer Controls
 * Advanced Kirki-powered customizer integration for CTA section
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Add CTA Section to Homepage Sections Panel
 */
add_action( 'init', 'homerix_add_cta_section' );
function homerix_add_cta_section() {

	// Add CTA Section to the existing homerix_sections panel.
	Kirki::add_section(
		'homerix_cta',
		array(
			'title'       => esc_html__( 'CTA Banner Section', 'homerix' ),
			'description' => esc_html__( 'Configure the call-to-action banner section on your homepage.', 'homerix' ),
			'panel'       => 'homerix_sections',
			'priority'    => 50,
		)
	);
}

/**
 * Add CTA Section Controls
 */
add_action( 'init', 'homerix_cta_section_customizer' );
function homerix_cta_section_customizer() {

	// Set default values if not already set.
	if ( ! get_theme_mod( 'cta_section_settings' ) ) {
		set_theme_mod(
			'cta_section_settings',
			array(
				'section_enabled'     => true,
				'section_title'       => esc_html__( 'Need Urgent Repairs? Book Now!', 'homerix' ),
				'section_description' => esc_html__( 'Our emergency technicians are available 24/7 to handle your home repair emergencies.', 'homerix' ),
				'button_text'         => esc_html__( 'Call Now', 'homerix' ),
				'phone_number'        => '(555) 123-4567',
				'background_type'     => 'color',
				'background_color'    => '#2563eb',
				'text_color'          => '#ffffff',
			)
		);
	}

	// Container Size
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'cta_container_size',
			'label'           => esc_html__( 'Container Size', 'homerix' ),
			'description'     => esc_html__( 'Choose the width of the CTA section container.', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 11,
			'default'         => 'w-full px-4',
			'choices'         => array(
				'w-full px-4'            => esc_html__( 'Full Width', 'homerix' ),
				'container mx-auto px-4' => esc_html__( 'Container', 'homerix' ),
				'max-w-md mx-auto px-4'  => esc_html__( 'Narrow', 'homerix' ),
			),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
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
			'settings'        => 'cta_section_enabled',
			'label'           => esc_html__( 'Enable CTA Section', 'homerix' ),
			'description'     => esc_html__( 'Show or hide the CTA banner section on your homepage.', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 10,
			'default'         => true,
			'partial_refresh' => array(
				'cta_section_enabled' => array(
					'selector'            => '.homerix-cta',
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
			'settings'        => 'cta_title',
			'label'           => esc_html__( 'CTA Title', 'homerix' ),
			'description'     => esc_html__( 'Enter the main heading for your CTA section.', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 20,
			'default'         => esc_html__( 'Need Urgent Repairs? Book Now!', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Description.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'cta_description',
			'label'           => esc_html__( 'CTA Description', 'homerix' ),
			'description'     => esc_html__( 'Enter the description text for your CTA section.', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 30,
			'default'         => esc_html__( 'Our emergency technicians are available 24/7 to handle your home repair emergencies.', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'cta_button_text',
			'label'           => esc_html__( 'Button Text', 'homerix' ),
			'description'     => esc_html__( 'Text displayed on the CTA button.', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 40,
			'default'         => esc_html__( 'Call Now', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Phone Number.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'cta_phone',
			'label'           => esc_html__( 'Phone Number', 'homerix' ),
			'description'     => esc_html__( 'Phone number for the CTA button (will be used in tel: link).', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 50,
			'default'         => '(555) 123-4567',
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	/**
	 * CTA Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'cta_color_override_separator',
			'section'         => 'homerix_cta',
			'priority'        => 100,
			'default'         => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
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
			'settings'        => 'cta_color_override_enabled',
			'label'           => esc_html__( 'Enable Color Override', 'homerix' ),
			'description'     => esc_html__( 'Enable custom colors for this section.', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 101,
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'cta_section_enabled',
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
			'settings'        => 'cta_section_bg_color',
			'label'           => esc_html__( 'Section Background', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 102,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'background' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
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
			'settings'        => 'cta_title_color',
			'label'           => esc_html__( 'Title Color', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 103,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Description Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'cta_description_color',
			'label'           => esc_html__( 'Description Color', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
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
			'settings'        => 'cta_button_bg_color',
			'label'           => esc_html__( 'Button Background', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
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
			'settings'        => 'cta_button_text_color',
			'label'           => esc_html__( 'Button Text Color', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Hover Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'cta_button_hover_bg_color',
			'label'           => esc_html__( 'Button Hover Background', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button Hover Text Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'cta_button_hover_text_color',
			'label'           => esc_html__( 'Button Hover Text Color', 'homerix' ),
			'section'         => 'homerix_cta',
			'priority'        => 108,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'cta_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

}
