<?php
/**
 * Enhanced Why Us Section Customizer Controls
 * Uses Kirki for advanced controls with repeater functionality
 *
 * @package Homerix_Pro
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
 * Add Why Us Section Panel and Controls
 */
add_action( 'init', 'homerix_whyus_section_customizer' );
function homerix_whyus_section_customizer() {
	// Add Why Us Section to the existing homerix_sections panel.
	Kirki::add_section(
		'homerix_whyus',
		array(
			'title'       => esc_html__( 'Why Choose Us Section', 'homerix' ),
			'description' => esc_html__( 'Configure the "Why Choose Us" section on your homepage.', 'homerix' ),
			'panel'       => 'homerix_sections',
			'priority'    => apply_filters( 'section_priority', 25, 'homerix_whyus' ),
		)
	);

	// Set default values if not already set
	if ( ! get_theme_mod( 'whyus_section_settings' ) ) {
		set_theme_mod(
			'whyus_section_settings',
			array(
				'section_enabled'  => true,
				'section_title'    => esc_html__( 'Why Choose Homerix Pro', 'homerix' ),
				'section_subtitle' => esc_html__( 'Discover what makes us the trusted choice for home repairs', 'homerix' ),
				'show_subtitle'    => false,
				'layout_columns'   => 4,
			)
		);
	}

	if ( ! get_theme_mod( 'whyus_items' ) ) {
		set_theme_mod(
			'whyus_items',
			array(
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( 'Vetted Technicians', 'homerix' ),
					'feature_description' => esc_html__( 'All technicians undergo thorough background checks and skills verification.', 'homerix' ),
					'feature_icon'        => 'fas fa-user-shield',
				),
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( '24/7 Emergency Services', 'homerix' ),
					'feature_description' => esc_html__( 'Available round the clock for urgent home repair needs.', 'homerix' ),
					'feature_icon'        => 'fas fa-clock',
				),
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( 'Transparent Pricing', 'homerix' ),
					'feature_description' => esc_html__( 'No hidden fees. Get upfront pricing before any work begins.', 'homerix' ),
					'feature_icon'        => 'fas fa-dollar-sign',
				),
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( 'Satisfaction Guarantee', 'homerix' ),
					'feature_description' => esc_html__( 'We stand behind our work with a 100% satisfaction guarantee.', 'homerix' ),
					'feature_icon'        => 'fas fa-thumbs-up',
				),
			)
		);
	}

	// Container Size
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'whyus_container_size',
			'label'           => esc_html__( 'Container Size', 'homerix' ),
			'description'     => esc_html__( 'Choose the width of the why us section container.', 'homerix' ),
			'section'         => 'homerix_whyus',
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
					'setting'  => 'whyus_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Enable/Disable
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'whyus_section_enabled',
			'label'           => esc_html__( 'Enable Why Us Section', 'homerix' ),
			'description'     => esc_html__( 'Show or hide the why us section on your homepage.', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 10,
			'default'         => true,
			'partial_refresh' => array(
				'whyus_section_enabled' => array(
					'selector'            => '.homerix-whyus',
					'container_inclusive' => false,
					'render_callback'     => '',
				),
			),
		)
	);

	// Section Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'whyus_section_title',
			'label'           => esc_html__( 'Section Title', 'homerix' ),
			'description'     => esc_html__( 'Enter the main title for the why us section.', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 15,
			'default'         => esc_html__( 'Why Choose Homerix Pro', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'whyus_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'textarea',
			'settings'        => 'whyus_section_subtitle',
			'label'           => esc_html__( 'Section Subtitle', 'homerix' ),
			'description'     => esc_html__( 'Optional subtitle text below the main title.', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 20,
			'default'         => esc_html__( 'Discover what makes us the trusted choice for home repairs', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'whyus_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Layout Columns
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'whyus_layout_columns',
			'label'           => esc_html__( 'Layout Columns', 'homerix' ),
			'description'     => esc_html__( 'Choose how many columns to display on desktop.', 'homerix' ),
			'section'         => 'homerix_whyus',
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
					'setting'  => 'whyus_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Features Items Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'repeater',
			'settings'        => 'whyus_items',
			'label'           => esc_html__( 'Why Us Features', 'homerix' ),
			'description'     => esc_html__( 'Add, remove, and customize your why us features. Drag to reorder.', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 40,
			'row_label'       => array(
				'type'  => 'field',
				'value' => esc_html__( 'Feature', 'homerix' ),
				'field' => 'feature_title',
			),
			'button_label'    => esc_html__( 'Add New Feature', 'homerix' ),
			'fields'          => array(
				'feature_enabled'     => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Enable Feature', 'homerix' ),
					'description' => esc_html__( 'Show or hide this feature.', 'homerix' ),
					'default'     => true,
				),
				'feature_title'       => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Feature Title', 'homerix' ),
					'description' => esc_html__( 'Enter the title for this feature.', 'homerix' ),
					'default'     => esc_html__( 'Feature Title', 'homerix' ),
				),
				'feature_description' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Feature Description', 'homerix' ),
					'description' => esc_html__( 'Enter a brief description of this feature.', 'homerix' ),
					'default'     => esc_html__( 'Feature description goes here.', 'homerix' ),
				),
				'feature_icon'        => array(
					'type'        => 'text',
					'label'       => esc_html__( 'FontAwesome Icon Class', 'homerix' ),
					'description' => esc_html__( 'Enter FontAwesome icon class (e.g., fas fa-user-shield).', 'homerix' ),
					'default'     => 'fas fa-star',
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'whyus_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
			'default'         => array(
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( 'Vetted Technicians', 'homerix' ),
					'feature_description' => esc_html__( 'All technicians undergo thorough background checks and skills verification.', 'homerix' ),
					'feature_icon'        => 'fas fa-user-shield',
					'feature_icon_color'  => '#2563EB',
					'feature_bg_color'    => '#dbeafe',
				),
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( '24/7 Emergency Services', 'homerix' ),
					'feature_description' => esc_html__( 'Available round the clock for urgent home repair needs.', 'homerix' ),
					'feature_icon'        => 'fas fa-clock',
					'feature_icon_color'  => '#2563EB',
					'feature_bg_color'    => '#dbeafe',
				),
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( 'Transparent Pricing', 'homerix' ),
					'feature_description' => esc_html__( 'No hidden fees. Get upfront pricing before any work begins.', 'homerix' ),
					'feature_icon'        => 'fas fa-dollar-sign',
					'feature_icon_color'  => '#2563EB',
					'feature_bg_color'    => '#dbeafe',
				),
				array(
					'feature_enabled'     => true,
					'feature_title'       => esc_html__( 'Satisfaction Guarantee', 'homerix' ),
					'feature_description' => esc_html__( 'We stand behind our work with a 100% satisfaction guarantee.', 'homerix' ),
					'feature_icon'        => 'fas fa-thumbs-up',
					'feature_icon_color'  => '#2563EB',
					'feature_bg_color'    => '#dbeafe',
				),
			),
		)
	);

	/**
	 * Why Us Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'whyus_color_override_separator',
			'section'         => 'homerix_whyus',
			'priority'        => 100,
			'active_callback' => array(
				array(
					'setting'  => 'whyus_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
			'default'         => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
		)
	);

	// Enable Color Override Toggle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'whyus_color_override_enabled',
			'label'           => esc_html__( 'Enable Color Override', 'homerix' ),
			'description'     => esc_html__( 'Enable custom colors for this section. When disabled, theme colors will be used.', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 101,
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'whyus_section_enabled',
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
			'settings'        => 'whyus_section_bg_color',
			'label'           => esc_html__( 'Section Background', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 102,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'light' ) : '#f3f4f6',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Title Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'whyus_title_color',
			'label'           => esc_html__( 'Title Color', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 103,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Section Subtitle Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'whyus_subtitle_color',
			'label'           => esc_html__( 'Subtitle Color', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#4b5563',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
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
			'settings'        => 'whyus_card_bg_color',
			'label'           => esc_html__( 'Card Background', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Icon Container Background
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'whyus_icon_bg_color',
			'label'           => esc_html__( 'Icon Container Background', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary_light' ) : 'rgba(37, 99, 235, 0.1)',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Icon Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'whyus_icon_color',
			'label'           => esc_html__( 'Icon Color', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Feature Title Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'whyus_feature_title_color',
			'label'           => esc_html__( 'Feature Title Color', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 108,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Feature Description Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'whyus_feature_desc_color',
			'label'           => esc_html__( 'Feature Description Color', 'homerix' ),
			'section'         => 'homerix_whyus',
			'priority'        => 109,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#4b5563',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'whyus_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

}
