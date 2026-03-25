<?php
/**
 * Enhanced Services Section Customizer Controls
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
 * Add Services Section Panel and Controls
 */
add_action( 'init', 'homerix_services_section_customizer' );
function homerix_services_section_customizer() {

	// Set default values if not already set.
	if ( ! get_theme_mod( 'services_section_settings' ) ) {
		set_theme_mod(
			'services_section_settings',
			array(
				'section_enabled'   => true,
				'section_title'     => esc_html__( 'Our Popular Services', 'homerix' ),
				'section_subtitle'  => esc_html__( 'Professional home repair and maintenance services you can trust', 'homerix' ),
				'show_subtitle'     => false,
				'layout_columns'    => 4,
				'show_view_all_btn' => true,
				'view_all_btn_text' => esc_html__( 'View All Services', 'homerix' ),
				'view_all_btn_url'  => '#',
			)
		);
	}

	if ( ! get_theme_mod( 'services_items' ) ) {
		set_theme_mod(
			'services_items',
			array(
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'Plumbing', 'homerix' ),
					'service_description' => esc_html__( 'Leaky faucets, pipe repairs, drain cleaning, and more from certified plumbers.', 'homerix' ),
					'service_icon'        => 'fas fa-faucet',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'Electrical', 'homerix' ),
					'service_description' => esc_html__( 'Wiring, lighting, panel upgrades, and electrical repairs by licensed electricians.', 'homerix' ),
					'service_icon'        => 'fas fa-bolt',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'HVAC', 'homerix' ),
					'service_description' => esc_html__( 'Heating, ventilation, and air conditioning installation, repair, and maintenance.', 'homerix' ),
					'service_icon'        => 'fas fa-fire',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'Carpentry', 'homerix' ),
					'service_description' => esc_html__( 'Custom woodwork, furniture repair, framing, and finish carpentry services.', 'homerix' ),
					'service_icon'        => 'fas fa-hammer',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
			)
		);
	}
	// Section Enable/Disable
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'services_section_enabled',
			'label'           => esc_html__( 'Enable Services Section', 'homerix' ),
			'description'     => esc_html__( 'Show or hide the services section on your homepage.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 10,
			'default'         => true,
			'partial_refresh' => array(
				'services_section_enabled' => array(
					'selector'            => '.homerix-services',
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
			'type'        => 'radio_buttonset',
			'settings'    => 'services_container_size',
			'label'       => esc_html__( 'Container Size', 'homerix' ),
			'description' => esc_html__( 'Choose the width of the services section container.', 'homerix' ),
			'section'     => 'homerix_services',
			'priority'    => 10,
			'default'     => 'container mx-auto px-4',
			'choices'     => array(
				'container mx-auto px-4'             => esc_html__( 'Container', 'homerix' ),
				'w-full px-4 max-w-[1600px] mx-auto' => esc_html__( 'Full Container', 'homerix' ),
				'w-full px-4'                        => esc_html__( 'Fluid', 'homerix' ),
			),
			'transport'   => 'postMessage',
		)
	);

	// Section Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'services_section_title',
			'label'           => esc_html__( 'Section Title', 'homerix' ),
			'description'     => esc_html__( 'Enter the main title for the services section.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 15,
			'default'         => esc_html__( 'Our Popular Services', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'services_section_enabled',
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
			'settings'        => 'services_section_subtitle',
			'label'           => esc_html__( 'Section Subtitle', 'homerix' ),
			'description'     => esc_html__( 'Optional subtitle text below the main title.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 20,
			'default'         => esc_html__( 'Professional home repair and maintenance services you can trust', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'services_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
	// Services Items Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'repeater',
			'settings'        => 'services_items',
			'label'           => esc_html__( 'Service Items', 'homerix' ),
			'description'     => esc_html__( 'Add and configure service items. You can add unlimited services.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 25,
			'row_label'       => array(
				'type'  => 'field',
				'value' => esc_html__( 'Service', 'homerix' ),
				'field' => 'service_title',
			),
			'button_label'    => esc_html__( 'Add New Service', 'homerix' ),
			'default'         => array(
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'Plumbing', 'homerix' ),
					'service_description' => esc_html__( 'Leaky faucets, pipe repairs, drain cleaning, and more from certified plumbers.', 'homerix' ),
					'service_icon'        => 'fas fa-faucet',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'Electrical', 'homerix' ),
					'service_description' => esc_html__( 'Wiring, lighting, panel upgrades, and electrical repairs by licensed electricians.', 'homerix' ),
					'service_icon'        => 'fas fa-bolt',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'HVAC', 'homerix' ),
					'service_description' => esc_html__( 'Heating, ventilation, and air conditioning installation, repair, and maintenance.', 'homerix' ),
					'service_icon'        => 'fas fa-fire',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
				array(
					'service_enabled'     => true,
					'service_title'       => esc_html__( 'Carpentry', 'homerix' ),
					'service_description' => esc_html__( 'Custom woodwork, furniture repair, framing, and finish carpentry services.', 'homerix' ),
					'service_icon'        => 'fas fa-hammer',
					'service_link_url'    => home_url( '/homerix-services' ),
					'service_link_text'   => esc_html__( 'Learn More', 'homerix' ),
					'service_link_target' => '_self',
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'services_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
			'fields'          => array(
				'service_enabled'     => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Enable Service', 'homerix' ),
					'description' => esc_html__( 'Show or hide this service item.', 'homerix' ),
					'default'     => true,
				),
				'service_title'       => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Service Title', 'homerix' ),
					'description' => esc_html__( 'Enter the service name.', 'homerix' ),
					'default'     => esc_html__( 'Service Name', 'homerix' ),
				),
				'service_description' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Service Description', 'homerix' ),
					'description' => esc_html__( 'Brief description of the service.', 'homerix' ),
					'default'     => esc_html__( 'Service description goes here.', 'homerix' ),
				),
				'service_icon_type'   => array(
					'type'        => 'select',
					'label'       => esc_html__( 'Icon Type', 'homerix' ),
					'description' => esc_html__( 'Choose between FontAwesome icon or custom image.', 'homerix' ),
					'default'     => 'icon',
					'choices'     => array(
						'icon'  => esc_html__( 'FontAwesome Icon', 'homerix' ),
						'image' => esc_html__( 'Custom Image', 'homerix' ),
					),
				),
				'service_icon'        => array(
					'type'        => 'iconpicker',
					'label'       => esc_html__( 'FontAwesome Icon Class', 'homerix' ),
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
					'default'     => 'fas fa-tools',
				),
				'service_image'       => array(
					'type'        => 'image',
					'label'       => esc_html__( 'Service Image', 'homerix' ),
					'description' => esc_html__( 'Upload an image to use instead of icon. Recommended size: 80x80px or larger.', 'homerix' ),
					'default'     => '',
				),
				'service_link_url'    => array(
					'type'        => 'url',
					'label'       => esc_html__( 'Service Link URL', 'homerix' ),
					'description' => esc_html__( 'URL for the service link.', 'homerix' ),
					'default'     => '#',
				),
				'service_link_text'   => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Link Text', 'homerix' ),
					'description' => esc_html__( 'Text for the service link.', 'homerix' ),
					'default'     => esc_html__( 'Learn More', 'homerix' ),
				),
				'service_link_target' => array(
					'type'        => 'select',
					'label'       => esc_html__( 'Link Target', 'homerix' ),
					'description' => esc_html__( 'Choose how the link should open.', 'homerix' ),
					'default'     => '_self',
					'choices'     => array(
						'_self'  => esc_html__( 'Same Window', 'homerix' ),
						'_blank' => esc_html__( 'New Window', 'homerix' ),
					),
				),
			),
		),
	);
}

	// Layout Columns
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio-buttonset',
			'settings'        => 'services_layout_columns',
			'label'           => esc_html__( 'Layout Columns', 'homerix' ),
			'description'     => esc_html__( 'Choose how many columns to display on desktop.', 'homerix' ),
			'section'         => 'homerix_services',
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
					'setting'  => 'services_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// View All Button Toggle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'services_show_view_all_btn',
			'label'           => esc_html__( 'Show "View All" Button', 'homerix' ),
			'description'     => esc_html__( 'Display a button to view all services.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 35,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'services_section_enabled',
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
			'settings'        => 'services_view_all_btn_text',
			'label'           => esc_html__( 'View All Button Text', 'homerix' ),
			'description'     => esc_html__( 'Text for the view all services button.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 40,
			'default'         => esc_html__( 'View All Services', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'services_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_show_view_all_btn',
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
			'settings'        => 'services_view_all_btn_url',
			'label'           => esc_html__( 'View All Button URL', 'homerix' ),
			'description'     => esc_html__( 'URL for the view all services button.', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 45,
			'default'         => '#',
			'active_callback' => array(
				array(
					'setting'  => 'services_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'services_show_view_all_btn',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	/**
	 * Services Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'services_color_override_separator',
			'section'  => 'homerix_services',
			'priority' => 100,
			'default'  => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
		)
	);

	// Enable Color Override Toggle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'services_color_override_enabled',
			'label'       => esc_html__( 'Enable Color Override', 'homerix' ),
			'description' => esc_html__( 'Enable custom colors for this section. When disabled, theme colors will be used.', 'homerix' ),
			'section'     => 'homerix_services',
			'priority'    => 101,
			'default'     => false,
		)
	);

	// Section Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_section_bg_color',
			'label'           => esc_html__( 'Section Background', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 102,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'background' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
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
			'settings'        => 'services_title_color',
			'label'           => esc_html__( 'Title Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 103,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
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
			'settings'        => 'services_subtitle_color',
			'label'           => esc_html__( 'Subtitle Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#4b5563',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
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
			'settings'        => 'services_card_bg_color',
			'label'           => esc_html__( 'Card Background', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Icon Container Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_icon_bg_color',
			'label'           => esc_html__( 'Icon Container Background', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary_light' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
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
			'settings'        => 'services_icon_color',
			'label'           => esc_html__( 'Icon Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Card Title Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_card_title_color',
			'label'           => esc_html__( 'Card Title Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 108,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Card Description Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_card_desc_color',
			'label'           => esc_html__( 'Card Description Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 109,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#4b5563',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Link Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_link_color',
			'label'           => esc_html__( 'Link Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 110,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'link' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'services_link_hover_color',
			'label'           => esc_html__( 'Link Hover Color', 'homerix' ),
			'section'         => 'homerix_services',
			'priority'        => 111,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'link_hover' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'services_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
