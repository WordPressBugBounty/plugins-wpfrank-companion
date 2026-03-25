<?php
/**
 * Enhanced Hero Section with Slider Support
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Initialize Enhanced Hero Section
 */
add_action( 'init', 'homerix_hero_section_enhanced_init' );
function homerix_hero_section_enhanced_init() {

	/**
	 * Hero Slides Configuration
	 */

	// Hero Slides Repeater
	$slides_limit_note = '';
	if ( function_exists( 'HOMERIX_IS_PRO' ) && ! HOMERIX_IS_PRO() ) {
		$slides_limit_note = ' <strong>' . esc_html__( '(Free: max 3 slides)', 'homerix' ) . '</strong>';
	}
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'         => 'repeater',
			'settings'     => 'hero_slider_slides',
			'label'        => esc_html__( 'Hero Slides', 'homerix' ),
			'description'  => esc_html__( 'Add and configure slides for your hero slider.', 'homerix' ) . $slides_limit_note,
			'section'      => 'homerix_hero',
			'priority'     => 11,
			'row_label'    => array(
				'type'  => 'field',
				'value' => esc_html__( 'Slide', 'homerix' ),
				'field' => 'slide_title',
			),
			'button_label' => esc_html__( 'Add New Slide', 'homerix' ),
			'default'      => array(
				array(
					'slide_enabled'    => true,
					'slide_title'      => esc_html__( 'Professional Home Repair Services', 'homerix' ),
					'slide_subtitle'   => esc_html__( 'Fast, reliable, and affordable services in your area', 'homerix' ),
					'media_type'       => 'image',
					'background_image' => get_template_directory_uri() . '/assets/img/hero-bg.jpg',
					'background_video' => '',
					'button1_enabled'  => true,
					'button1_text'     => esc_html__( 'Book Now', 'homerix' ),
					'button1_url'      => '#',
					'button2_enabled'  => true,
					'button2_text'     => esc_html__( 'Find a Technician', 'homerix' ),
					'button2_url'      => '#',
					'overlay_enabled'  => true,
					'overlay_opacity'  => 40,
				),
				array(
					'slide_enabled'    => true,
					'slide_title'      => esc_html__( 'Expert Technicians Available 24/7', 'homerix' ),
					'slide_subtitle'   => esc_html__( 'Emergency repairs and scheduled maintenance services', 'homerix' ),
					'media_type'       => 'image',
					'background_image' => get_template_directory_uri() . '/assets/img/about-3.jpg',
					'background_video' => '',
					'button1_enabled'  => true,
					'button1_text'     => esc_html__( 'Emergency Service', 'homerix' ),
					'button1_url'      => '#',
					'button2_enabled'  => false,
					'button2_text'     => '',
					'button2_url'      => '',
					'overlay_enabled'  => true,
					'overlay_opacity'  => 50,
				),
				array(
					'slide_enabled'    => true,
					'slide_title'      => esc_html__( 'Trusted by Thousands of Homeowners', 'homerix' ),
					'slide_subtitle'   => esc_html__( 'Quality workmanship with satisfaction guarantee', 'homerix' ),
					'media_type'       => 'image',
					'background_image' => get_template_directory_uri() . '/assets/img/about-bg.jpg',
					'background_video' => '',
					'button1_enabled'  => true,
					'button1_text'     => esc_html__( 'Get Quote', 'homerix' ),
					'button1_url'      => '#',
					'button2_enabled'  => true,
					'button2_text'     => esc_html__( 'View Portfolio', 'homerix' ),
					'button2_url'      => '#',
					'overlay_enabled'  => true,
					'overlay_opacity'  => 45,
				),
			),
			'fields'       => array(
				'slide_enabled'    => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Enable Slide', 'homerix' ),
					'description' => esc_html__( 'Toggle to enable or disable this slide.', 'homerix' ),
					'default'     => true,
				),
				'slide_title'      => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Slide Title', 'homerix' ),
					'description' => esc_html__( 'Enter the main heading for this slide.', 'homerix' ),
					'default'     => '',
				),
				'slide_subtitle'   => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Slide Subtitle', 'homerix' ),
					'description' => esc_html__( 'Enter the subtitle or description for this slide.', 'homerix' ),
					'default'     => '',
				),
				'media_type'       => array(
					'type'        => 'radio',
					'label'       => esc_html__( 'Background Media Type', 'homerix' ),
					'description' => esc_html__( 'Choose between image or video background.', 'homerix' ),
					'default'     => 'image',
					'choices'     => array(
						'image' => esc_html__( 'Image', 'homerix' ),
						'video' => esc_html__( 'Video', 'homerix' ),
					),
				),
				'background_image' => array(
					'type'        => 'image',
					'label'       => esc_html__( 'Background Image', 'homerix' ),
					'description' => esc_html__( 'Upload a background image for this slide.', 'homerix' ),
					'default'     => '',
				),
				'background_video' => array(
					'type'        => 'url',
					'label'       => esc_html__( 'Video URL', 'homerix' ),
					'description' => esc_html__( 'Enter video URL. Supports: MP4 files, YouTube (watch or embed URLs), Vimeo URLs, and other platforms.', 'homerix' ),
					'default'     => '',
				),
				'button1_enabled'  => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Enable Button 1', 'homerix' ),
					'description' => esc_html__( 'Check to show the first button on this slide.', 'homerix' ),
					'default'     => true,
				),
				'button1_text'     => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Button 1 Text', 'homerix' ),
					'description' => esc_html__( 'Enter the text for the first button.', 'homerix' ),
					'default'     => esc_html__( 'Book Now', 'homerix' ),
				),
				'button1_url'      => array(
					'type'        => 'url',
					'label'       => esc_html__( 'Button 1 URL', 'homerix' ),
					'description' => esc_html__( 'Enter the URL for the first button.', 'homerix' ),
					'default'     => home_url( '/homerix-book-now' ),
				),
				'button2_enabled'  => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Enable Button 2', 'homerix' ),
					'description' => esc_html__( 'Check to show the second button on this slide.', 'homerix' ),
					'default'     => true,
				),
				'button2_text'     => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Button 2 Text', 'homerix' ),
					'description' => esc_html__( 'Enter the text for the second button.', 'homerix' ),
					'default'     => esc_html__( 'Find a Technician', 'homerix' ),
				),
				'button2_url'      => array(
					'type'        => 'url',
					'label'       => esc_html__( 'Button 2 URL', 'homerix' ),
					'description' => esc_html__( 'Enter the URL for the second button.', 'homerix' ),
					'default'     => home_url( '/homerix-find-a-technician' ),
				),
				'overlay_enabled'  => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Enable Overlay', 'homerix' ),
					'description' => esc_html__( 'Check to add a dark overlay for better text readability.', 'homerix' ),
					'default'     => true,
				),
				'overlay_opacity'  => array(
					'type'        => 'slider',
					'label'       => esc_html__( 'Overlay Opacity', 'homerix' ),
					'description' => esc_html__( 'Adjust the opacity level for the overlay.', 'homerix' ),
					'default'     => 40,
					'choices'     => array(
						'min'  => 0,
						'max'  => 80,
						'step' => 5,
					),
				),
			),
		)
	);

	// Slider Autoplay
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'hero_slider_autoplay',
			'label'       => esc_html__( 'Enable Autoplay', 'homerix' ),
			'description' => esc_html__( 'Automatically advance slides.', 'homerix' ),
			'section'     => 'homerix_hero',
			'priority'    => 15,
			'default'     => false,

		)
	);

	// Slider Navigation
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'hero_slider_navigation',
			'label'       => esc_html__( 'Show Navigation Arrows', 'homerix' ),
			'description' => esc_html__( 'Display previous/next navigation arrows.', 'homerix' ),
			'section'     => 'homerix_hero',
			'priority'    => 16,
			'default'     => true,
		)
	);
	// Slider Navigation on hover
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'hero_slider_navigation_hover',
			'label'       => esc_html__( 'Show Navigation On Hover', 'homerix' ),
			'description' => esc_html__( 'On hover display previous/next navigation arrows.', 'homerix' ),
			'section'     => 'homerix_hero',
			'priority'    => 18,
			'default'     => true,
		)
	);

	// Slider Speed
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'hero_slider_speed',
			'label'           => esc_html__( 'Slide Duration (seconds)', 'homerix' ),
			'description'     => esc_html__( 'How long each slide is displayed.', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 20,
			'default'         => 5,
			'choices'         => array(
				'min'  => 2,
				'max'  => 15,
				'step' => 1,
			),
			'active_callback' => array(
				array(
					'setting'  => 'hero_slider_autoplay',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Slider Transition Effect
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'select',
			'settings'    => 'hero_slider_effect',
			'label'       => esc_html__( 'Transition Effect', 'homerix' ),
			'description' => esc_html__( 'Choose the slide transition effect.', 'homerix' ),
			'section'     => 'homerix_hero',
			'priority'    => 25,
			'default'     => 'slide',
			'choices'     => array(
				'slide'     => esc_html__( 'Slide', 'homerix' ),
				'fade'      => esc_html__( 'Fade', 'homerix' ),
				'cube'      => esc_html__( 'Cube', 'homerix' ),
				'coverflow' => esc_html__( 'Coverflow', 'homerix' ),
				'flip'      => esc_html__( 'Flip', 'homerix' ),
			),

		)
	);

	// Enable Search Box on Slides
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'hero_show_search',
			'label'       => esc_html__( 'Enable Search Box on Slides', 'homerix' ),
			'description' => esc_html__( 'Show or hide the search box on hero slides.', 'homerix' ),
			'section'     => 'homerix_hero',
			'priority'    => 26,
			'default'     => true,
		)
	);

	/**
	 * Hero Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'hero_color_override_separator',
			'section'  => 'homerix_hero',
			'priority' => 100,
			'default'  => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
		)
	);

	// Enable Color Override Toggle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'hero_color_override_enabled',
			'label'       => esc_html__( 'Enable Color Override', 'homerix' ),
			'description' => esc_html__( 'Enable custom colors for this section. When disabled, theme colors will be used.', 'homerix' ),
			'section'     => 'homerix_hero',
			'priority'    => 101,
			'default'     => false,
		)
	);

	// Hero Title Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_title_color',
			'label'           => esc_html__( 'Title Color', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 102,
			'default'         => '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Subtitle Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_subtitle_color',
			'label'           => esc_html__( 'Subtitle Color', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 103,
			'default'         => '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button 1 Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_button1_bg_color',
			'label'           => esc_html__( 'Button 1 Background', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#fbbf24',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button 1 Text Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_button1_text_color',
			'label'           => esc_html__( 'Button 1 Text Color', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#000000',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button 2 Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_button2_bg_color',
			'label'           => esc_html__( 'Button 2 Background', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Button 2 Text Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_button2_text_color',
			'label'           => esc_html__( 'Button 2 Text Color', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Slider Arrow Icon Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_arrow_color',
			'label'           => esc_html__( 'Slider Arrow Icon Color', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 114,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#1d4ed8',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Search Button Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_search_button_bg_color',
			'label'           => esc_html__( 'Search Button Background', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 115,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Search Button Text Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_search_button_text_color',
			'label'           => esc_html__( 'Search Button Text', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 116,
			'default'         => '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Pagination Bullet Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_pagination_color',
			'label'           => esc_html__( 'Pagination Bullet Color', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 117,
			'default'         => 'rgba(255,255,255,0.5)',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Pagination Active Bullet Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'hero_pagination_active_color',
			'label'           => esc_html__( 'Pagination Active Bullet', 'homerix' ),
			'section'         => 'homerix_hero',
			'priority'        => 118,
			'default'         => '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'hero_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

