<?php
/**
 * Homerix Blog Section Customizer
 *
 * Handles all customizer settings for the Blog section on homepage.
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
 * Add Blog Section to Homepage Sections Panel
 */
add_action( 'init', 'homerix_add_blog_section' );
function homerix_add_blog_section() {

	// Add Blog Section to the existing homerix_sections panel.
	Kirki::add_section(
		'homerix_blog',
		array(
			'title'       => esc_html__( 'Blog Section', 'homerix' ),
			'description' => esc_html__( 'Configure the blog section on your homepage.', 'homerix' ),
			'panel'       => 'homerix_sections',
			'priority'    => apply_filters( 'section_priority', 70, 'homerix_blog' ),
		)
	);
}

/**
 * Add Blog Section Controls
 */
add_action( 'init', 'homerix_blog_section_customizer' );
function homerix_blog_section_customizer() {

	// Set default values if not already set.
	if ( ! get_theme_mod( 'blog_section_settings' ) ) {
		set_theme_mod(
			'blog_section_settings',
			array(
				'section_enabled' => true,
				'section_title'   => esc_html__( 'Latest Tips & Advice', 'homerix' ),
				'posts_count'     => 3,
				'button_text'     => esc_html__( 'Read More Articles', 'homerix' ),
				'background_type' => 'theme_colors',
				'bg_choice'       => 'base',
			)
		);
	}

	// Container Size
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio_buttonset',
			'settings'        => 'blog_container_size',
			'label'           => esc_html__( 'Container Size', 'homerix' ),
			'section'         => 'homerix_blog',
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
					'setting'  => 'blog_section_enabled',
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
			'settings'        => 'blog_section_enabled',
			'label'           => esc_html__( 'Enable Blog Section', 'homerix' ),
			'description'     => esc_html__( 'Show or hide the blog section on your homepage.', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 10,
			'default'         => true,
			'partial_refresh' => array(
				'blog_section_enabled' => array(
					'selector'            => '.homerix-blog-section',
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
			'settings'        => 'blog_title',
			'label'           => esc_html__( 'Section Title', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 20,
			'default'         => esc_html__( 'Latest Tips & Advice', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Posts Count.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'number',
			'settings'        => 'blog_count',
			'label'           => esc_html__( 'Number of Posts', 'homerix' ),
			'description'     => esc_html__( 'How many recent posts to display.', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 30,
			'default'         => 3,
			'choices'         => array(
				'min'  => 1,
				'max'  => 12,
				'step' => 1,
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
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
			'type'            => 'radio_buttonset',
			'settings'        => 'blog_layout_columns',
			'label'           => esc_html__( 'Layout Columns', 'homerix' ),
			'description'     => esc_html__( 'Number of columns for the blog posts grid.', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 35,
			'default'         => '3',
			'choices'         => array(
				2 => esc_html__( '2', 'homerix' ),
				3 => esc_html__( '3', 'homerix' ),
				4 => esc_html__( '4', 'homerix' ),
				5 => esc_html__( '5', 'homerix' ),
				6 => esc_html__( '6', 'homerix' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
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
			'settings'        => 'blog_button_text',
			'label'           => esc_html__( 'Button Text', 'homerix' ),
			'description'     => esc_html__( 'Text for the "View All" button. Leave empty to hide button.', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 40,
			'default'         => esc_html__( 'Read More Articles', 'homerix' ),
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	/**
	 * Post Display Settings Separator.
	 */
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'blog_post_display_separator',
			'section'         => 'homerix_blog',
			'priority'        => 50,
			'default'         => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Post Display Settings', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Control what elements are shown on blog cards.', 'homerix' ) . '</p>',
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Featured Image.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'blog_show_image',
			'label'           => esc_html__( 'Show Featured Image', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 51,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Category.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'blog_show_category',
			'label'           => esc_html__( 'Show Category Badge', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 52,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Date.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'blog_show_date',
			'label'           => esc_html__( 'Show Date', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 53,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Excerpt.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'blog_show_excerpt',
			'label'           => esc_html__( 'Show Excerpt', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 54,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Excerpt Length.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'blog_excerpt_length',
			'label'           => esc_html__( 'Excerpt Length (words)', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 55,
			'default'         => 20,
			'choices'         => array(
				'min'  => 5,
				'max'  => 50,
				'step' => 1,
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'blog_show_excerpt',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Author.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'blog_show_author',
			'label'           => esc_html__( 'Show Author', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 56,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Read More Link.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'blog_show_read_more',
			'label'           => esc_html__( 'Show Read More Link', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 57,
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	/**
	 * Blog Section Color Overrides
	 */

	// Color Override Separator
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'blog_color_override_separator',
			'section'         => 'homerix_blog',
			'priority'        => 100,
			'default'         => '<hr style="margin: 20px 0; border-top: 2px solid #0073aa;"><h3 style="margin: 0; color: #0073aa;">' . esc_html__( 'Color Overrides', 'homerix' ) . '</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p>',
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
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
			'settings'        => 'blog_color_override_enabled',
			'label'           => esc_html__( 'Enable Color Override', 'homerix' ),
			'description'     => esc_html__( 'Enable custom colors for this section.', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 101,
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'blog_section_enabled',
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
			'settings'        => 'blog_section_bg_color',
			'label'           => esc_html__( 'Section Background', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 102,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'light' ) : '#f3f4f6',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
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
			'settings'        => 'blog_title_color',
			'label'           => esc_html__( 'Section Title Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 103,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
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
			'settings'        => 'blog_card_bg_color',
			'label'           => esc_html__( 'Card Background', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 104,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Post Title Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_post_title_color',
			'label'           => esc_html__( 'Post Title Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 105,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'heading' ) : '#111827',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Category Badge Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_category_bg_color',
			'label'           => esc_html__( 'Category Badge Background', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 106,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Category Badge Text Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_category_text_color',
			'label'           => esc_html__( 'Category Badge Text', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 107,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Date Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_date_color',
			'label'           => esc_html__( 'Date Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 108,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#6b7280',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Excerpt Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_excerpt_color',
			'label'           => esc_html__( 'Excerpt Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 109,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#4b5563',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Author Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_author_color',
			'label'           => esc_html__( 'Author Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 110,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'text' ) : '#6b7280',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
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
			'settings'        => 'blog_button_bg_color',
			'label'           => esc_html__( 'Button Background', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 111,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
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
			'settings'        => 'blog_button_text_color',
			'label'           => esc_html__( 'Button Text Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 112,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Read More Link Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_link_color',
			'label'           => esc_html__( 'Read More Link Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 113,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563EB',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Read More Link Hover Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'blog_link_hover_color',
			'label'           => esc_html__( 'Read More Hover Color', 'homerix' ),
			'section'         => 'homerix_blog',
			'priority'        => 114,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'link_hover' ) : '#1d4ed8',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'blog_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

}
