<?php
/**
 * Blog Page Customizer Settings for Homerix Pro Theme
 *
 * Adds Kirki customizer controls for Blog page-specific settings.
 * Note: Contact Us, FAQ, Privacy Policy, and Terms of Service have
 * dedicated files in this directory.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Add page sections to the Homerix Pages Settings panel
 * Called directly during file inclusion (no add_action needed).
 */
function homerix_add_pages_customizer_sections() {

	// ===== BLOG PAGE SECTION =====
	Kirki::add_section(
		'homerix_blog_settings',
		array(
			'title'       => esc_html__( 'Blog Page Settings', 'homerix' ),
			'description' => esc_html__( 'Configure the Blog page appearance and content.', 'homerix' ),
			'panel'       => 'homerix_pages_settings',
			'priority'    => 50,
		)
	);

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'blog_hero_heading',
			'section'  => 'homerix_blog_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'homerix_blog_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 10,
			'default'   => __( 'Homerix Pro Blog', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'homerix_blog_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 20,
			'default'   => __( 'Expert tips, maintenance guides, and home repair advice', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Show Search Bar.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'toggle',
			'settings'  => 'homerix_blog_show_search',
			'label'     => esc_html__( 'Show Search Bar', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 30,
			'default'   => true,
			'transport' => 'postMessage',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'homerix_blog_hero_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 40,
			'default'   => '#2563eb',
			'transport' => 'auto',
			'output'    => array(
				array(
					'element'  => '.blog-hero',
					'property' => 'background-color',
				),
			),
		)
	);

	// Hero Background Image.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'image',
			'settings'  => 'homerix_blog_hero_bg_image',
			'label'     => esc_html__( 'Background Image (Optional)', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 50,
			'default'   => get_template_directory_uri() . '/assets/img/hero-bg.jpg',
			'transport' => 'postMessage',
		)
	);

	// Hero Overlay Enabled.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'homerix_blog_hero_overlay_enabled',
			'label'    => esc_html__( 'Enable Hero Overlay', 'homerix' ),
			'section'  => 'homerix_blog_settings',
			'priority' => 60,
			'default'  => true,
		)
	);

	// Hero Overlay Opacity.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'homerix_blog_hero_overlay_opacity',
			'label'           => esc_html__( 'Overlay Opacity', 'homerix' ),
			'section'         => 'homerix_blog_settings',
			'priority'        => 70,
			'default'         => 0.5,
			'choices'         => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.1,
			),
			'active_callback' => array(
				array(
					'setting'  => 'homerix_blog_hero_overlay_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== BLOG CONTENT SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'blog_content_heading',
			'section'  => 'homerix_blog_settings',
			'priority' => 75,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📝 Blog Content</h3></div>',
		)
	);

	// Posts Per Page.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'number',
			'settings' => 'homerix_blog_posts_per_page',
			'label'    => esc_html__( 'Posts Per Page', 'homerix' ),
			'section'  => 'homerix_blog_settings',
			'priority' => 80,
			'default'  => 5,
			'choices'  => array(
				'min'  => 1,
				'max'  => 50,
				'step' => 1,
			),
		)
	);

	// Grid Columns.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'radio_buttonset',
			'settings'  => 'homerix_blog_grid_columns',
			'label'     => esc_html__( 'Grid Columns', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 90,
			'default'   => '2',
			'choices'   => array(
				'1' => esc_html__( '1 Column', 'homerix' ),
				'2' => esc_html__( '2 Columns', 'homerix' ),
			),
			'transport' => 'postMessage',
		)
	);

	// Show Featured Post.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'homerix_blog_show_featured',
			'label'       => esc_html__( 'Show Featured Post', 'homerix' ),
			'description' => esc_html__( 'Display the first post as a large featured post.', 'homerix' ),
			'section'     => 'homerix_blog_settings',
			'priority'    => 100,
			'default'     => true,
			'transport'   => 'postMessage',
		)
	);

	// Show Post Excerpt.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'toggle',
			'settings'  => 'homerix_blog_show_excerpt',
			'label'     => esc_html__( 'Show Post Excerpt', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 110,
			'default'   => true,
			'transport' => 'postMessage',
		)
	);

	// Excerpt Length.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'number',
			'settings'        => 'homerix_blog_excerpt_length',
			'label'           => esc_html__( 'Excerpt Length (words)', 'homerix' ),
			'section'         => 'homerix_blog_settings',
			'priority'        => 120,
			'default'         => 20,
			'choices'         => array(
				'min'  => 10,
				'max'  => 100,
				'step' => 5,
			),
			'active_callback' => array(
				array(
					'setting'  => 'homerix_blog_show_excerpt',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Show Reading Time.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'toggle',
			'settings'  => 'homerix_blog_show_reading_time',
			'label'     => esc_html__( 'Show Reading Time', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 130,
			'default'   => true,
			'transport' => 'postMessage',
		)
	);

	// Show Author Info.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'toggle',
			'settings'  => 'homerix_blog_show_author',
			'label'     => esc_html__( 'Show Author Info', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 140,
			'default'   => true,
			'transport' => 'postMessage',
		)
	);

	// Show Categories.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'toggle',
			'settings'  => 'homerix_blog_show_categories',
			'label'     => esc_html__( 'Show Categories', 'homerix' ),
			'section'   => 'homerix_blog_settings',
			'priority'  => 150,
			'default'   => true,
			'transport' => 'postMessage',
		)
	);
}


// Call the function directly during file inclusion.
homerix_add_pages_customizer_sections();

/**
 * Enqueue customizer preview scripts for Blog page.
 *
 * @return void
 */
function homerix_blog_page_customize_preview_js() {
	wp_enqueue_script(
		'homerix-blog-customizer-preview',
		get_template_directory_uri() . '/assets/js/customizer/blog-customizer-preview.js',
		array( 'jquery', 'customize-preview' ),
		defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0',
		true
	);
}
add_action( 'customize_preview_init', 'homerix_blog_page_customize_preview_js' );
