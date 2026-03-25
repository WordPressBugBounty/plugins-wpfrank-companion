<?php
/**
 * Homerix Pro Default Content
 *
 * Creates default pages, posts, and menus on theme activation.
 *
 * @package Homerix_Pro
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup all default theme pages on theme activation.
 *
 * Creates all required pages for the Homerix theme with proper templates assigned.
 *
 * @since 1.0.0
 * @return void
 */
function homerix_setup_default_pages() {
	// Check if pages were already created once - don't recreate if user deletes them.
	if ( get_option( 'homerix_default_pages_created' ) ) {
		return;
	}

	// Define all theme pages with their templates.
	$theme_pages = array(
		array(
			'title'    => __( 'Homerix Home', 'homerix' ),
			'slug'     => 'homerix-home',
			'template' => '',
		),
		array(
			'title'    => __( 'Homerix Blog', 'homerix' ),
			'slug'     => 'homerix-blog',
			'template' => '',
		),
		array(
			'title'    => __( 'Homerix About Us', 'homerix' ),
			'slug'     => 'homerix-about-us',
			'template' => 'homerix-companion/page-about-us.php',
		),
		array(
			'title'    => __( 'Homerix Book Now', 'homerix' ),
			'slug'     => 'homerix-book-now',
			'template' => 'homerix-companion/page-book-now.php',
		),
		array(
			'title'    => __( 'Homerix Contact Us', 'homerix' ),
			'slug'     => 'homerix-contact-us',
			'template' => 'homerix-companion/page-contact-us.php',
		),
		array(
			'title'    => __( 'Homerix FAQ', 'homerix' ),
			'slug'     => 'homerix-faq',
			'template' => 'homerix-companion/page-faq.php',
		),
		array(
			'title'    => __( 'Homerix Find a Technician', 'homerix' ),
			'slug'     => 'homerix-find-technician',
			'template' => 'homerix-companion/page-find-technician.php',
		),
		array(
			'title'    => __( 'Homerix Privacy Policy', 'homerix' ),
			'slug'     => 'homerix-privacy-policy',
			'template' => 'homerix-companion/page-privacy-policy.php',
		),
		array(
			'title'    => __( 'Homerix Services', 'homerix' ),
			'slug'     => 'homerix-services',
			'template' => 'homerix-companion/page-site-services.php',
		),
		array(
			'title'    => __( 'Homerix Terms of Service', 'homerix' ),
			'slug'     => 'homerix-terms-of-service',
			'template' => 'homerix-companion/page-terms-of-service.php',
		),
	);

	// Create each page if it doesn't exist.
	foreach ( $theme_pages as $page_data ) {
		$existing_page = get_page_by_path( $page_data['slug'] );

		if ( ! $existing_page ) {
			$page_id = wp_insert_post(
				array(
					'post_title'   => $page_data['title'],
					'post_name'    => $page_data['slug'],
					'post_content' => '',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_author'  => 1,
				)
			);

			if ( ! is_wp_error( $page_id ) && ! empty( $page_data['template'] ) ) {
				update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
			}
		}
	}

	// Mark pages as created.
	update_option( 'homerix_default_pages_created', true );

	// Configure WordPress Reading Settings.
	$home_page = get_page_by_path( 'homerix-home' );
	$blog_page = get_page_by_path( 'homerix-blog' );

	if ( $home_page && $blog_page ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_page->ID );
		update_option( 'page_for_posts', $blog_page->ID );
	}

	// Set up default menus with these pages.
	homerix_setup_default_menu();
}
add_action( 'after_switch_theme', 'homerix_setup_default_pages' );

/**
 * Also trigger default page setup when the companion plugin is activated.
 * This ensures defaults are created even if the plugin is activated after the theme.
 */
function homerix_companion_activation_setup() {
	if ( 'Homerix' === wp_get_theme()->name ) {
		homerix_setup_default_pages();
		homerix_create_default_blog_posts();
	}
}
register_activation_hook( dirname( dirname( __DIR__ ) ) . '/wpfrank-companion.php', 'homerix_companion_activation_setup' );

/**
 * Migrate old page template slugs to new plugin-based paths.
 * Runs once on init to update existing pages from old format to new format.
 *
 * @since 0.3.3
 */
function homerix_migrate_page_template_slugs() {
	if ( get_option( 'homerix_template_slugs_migrated' ) ) {
		return;
	}

	$old_to_new = array(
		'page-templates/page-about-us.php'        => 'homerix-companion/page-about-us.php',
		'page-templates/page-book-now.php'         => 'homerix-companion/page-book-now.php',
		'page-templates/page-contact-us.php'       => 'homerix-companion/page-contact-us.php',
		'page-templates/page-faq.php'              => 'homerix-companion/page-faq.php',
		'page-templates/page-find-technician.php'  => 'homerix-companion/page-find-technician.php',
		'page-templates/page-privacy-policy.php'   => 'homerix-companion/page-privacy-policy.php',
		'page-templates/page-site-services.php'    => 'homerix-companion/page-site-services.php',
		'page-templates/page-terms-of-service.php' => 'homerix-companion/page-terms-of-service.php',
	);

	foreach ( $old_to_new as $old_slug => $new_slug ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $old_slug,
			)
		);
		if ( ! empty( $pages ) ) {
			foreach ( $pages as $page ) {
				update_post_meta( $page->ID, '_wp_page_template', $new_slug );
			}
		}
	}

	update_option( 'homerix_template_slugs_migrated', true );
}
add_action( 'init', 'homerix_migrate_page_template_slugs' );

/**
 * Fix Reading Settings for existing installations.
 *
 * @since 1.0.0
 * @return void
 */
function homerix_fix_reading_settings() {
	if ( get_option( 'homerix_reading_settings_fixed' ) ) {
		return;
	}

	$home_page = get_page_by_path( 'homerix-home' );
	$blog_page = get_page_by_path( 'homerix-blog' );

	if ( ! $home_page || ! $blog_page ) {
		return;
	}

	$show_on_front  = get_option( 'show_on_front' );
	$page_on_front  = get_option( 'page_on_front' );
	$page_for_posts = get_option( 'page_for_posts' );

	$is_home_correct = ( 'page' === $show_on_front && (int) $page_on_front === $home_page->ID );
	$is_blog_correct = ( (int) $page_for_posts === $blog_page->ID );

	if ( $is_home_correct && $is_blog_correct ) {
		update_option( 'homerix_reading_settings_fixed', true );
		return;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_page->ID );
	update_option( 'page_for_posts', $blog_page->ID );
	update_option( 'homerix_reading_settings_fixed', true );
}
add_action( 'init', 'homerix_fix_reading_settings' );

/**
 * Setup default navigation menu with theme pages.
 *
 * @since 1.0.0
 * @return void
 */
function homerix_setup_default_menu() {
	$menu_name   = 'Homerix Header Menu';
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	// Always ensure menu location is assigned if the menu exists.
	if ( $menu_exists ) {
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		if ( empty( $locations['homerix_header_menu'] ) ) {
			$locations['homerix_header_menu'] = $menu_exists->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	// Check if menu was already created (prevents recreation after user deletion).
	if ( get_option( 'homerix_default_menu_created' ) ) {
		return;
	}

	if ( $menu_exists ) {
		// Menu exists but flag wasn't set, mark as created.
		update_option( 'homerix_default_menu_created', true );
		return;
	}

	$menu_id = wp_create_nav_menu( $menu_name );

	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	$menu_items = array(
		array(
			'title' => __( 'Home', 'homerix' ),
			'url'   => home_url( '/' ),
		),
		array(
			'title' => __( 'Services', 'homerix' ),
			'url'   => home_url( '/homerix-services/' ),
		),
		array(
			'title' => __( 'Find Technician', 'homerix' ),
			'url'   => home_url( '/homerix-find-technician/' ),
		),
		array(
			'title' => __( 'About Us', 'homerix' ),
			'url'   => home_url( '/homerix-about-us/' ),
		),
		array(
			'title' => __( 'Blog', 'homerix' ),
			'url'   => home_url( '/homerix-blog/' ),
		),
		array(
			'title' => __( 'Contact Us', 'homerix' ),
			'url'   => home_url( '/homerix-contact-us/' ),
		),
	);

	$menu_order = 1;
	foreach ( $menu_items as $item ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'    => $item['title'],
				'menu-item-url'      => $item['url'],
				'menu-item-status'   => 'publish',
				'menu-item-type'     => 'custom',
				'menu-item-position' => $menu_order,
			)
		);
		++$menu_order;
	}

	$locations                        = get_theme_mod( 'nav_menu_locations', array() );
	$locations['homerix_header_menu'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	update_option( 'homerix_default_menu_created', true );
}

/**
 * Create default blog posts on theme activation.
 *
 * @since 1.0.0
 * @return void
 */
function homerix_create_default_blog_posts() {
	if ( get_option( 'homerix_default_posts_created' ) ) {
		return;
	}

	$existing_posts = wp_count_posts( 'post' );
	if ( isset( $existing_posts->publish ) && $existing_posts->publish > 0 ) {
		update_option( 'homerix_default_posts_created', true );
		return;
	}

	// Default posts array (shortened for brevity - full content in original).
	$default_posts = array(
		array(
			'title'    => __( '5 Essential Home Maintenance Tips for Every Season', 'homerix' ),
			'content'  => '<p>Regular home maintenance is crucial for preserving your property\'s value and preventing costly repairs.</p>',
			'category' => 'Home Maintenance',
		),
		array(
			'title'    => __( 'When to Call a Professional Plumber vs. DIY Fixes', 'homerix' ),
			'content'  => '<p>Knowing when to tackle a plumbing issue yourself and when to call a professional can save you time and money.</p>',
			'category' => 'Plumbing',
		),
		array(
			'title'    => __( 'How to Prepare Your Home for Winter: A Complete Checklist', 'homerix' ),
			'content'  => '<p>Winter can be harsh on your home. Proper preparation protects your property and keeps your family comfortable.</p>',
			'category' => 'Seasonal Tips',
		),
	);

	foreach ( $default_posts as $post_data ) {
		$existing_post = get_posts(
			array(
				'post_type'      => 'post',
				'title'          => $post_data['title'],
				'post_status'    => 'all',
				'posts_per_page' => 1,
			)
		);

		if ( ! empty( $existing_post ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $post_data['title'],
				'post_content' => $post_data['content'],
				'post_status'  => 'publish',
				'post_type'    => 'post',
				'post_author'  => 1,
			)
		);

		if ( ! is_wp_error( $post_id ) ) {
			$category = get_term_by( 'name', $post_data['category'], 'category' );
			if ( ! $category ) {
				$new_category = wp_insert_term( $post_data['category'], 'category' );
				if ( ! is_wp_error( $new_category ) ) {
					$category_id = $new_category['term_id'];
				}
			} else {
				$category_id = $category->term_id;
			}

			if ( ! empty( $category_id ) ) {
				wp_set_post_categories( $post_id, array( $category_id ) );
			}
		}
	}

	update_option( 'homerix_default_posts_created', true );
}
add_action( 'after_switch_theme', 'homerix_create_default_blog_posts' );

/**
 * Run default content setup on init if not yet created.
 * This ensures defaults are created when plugin is activated on an existing Homerix install.
 *
 * @since 0.3.3
 */
function homerix_ensure_defaults_on_init() {
	// Only run if theme is Homerix and defaults haven't been created.
	if ( 'Homerix' !== wp_get_theme()->name ) {
		return;
	}
	if ( ! get_option( 'homerix_default_pages_created' ) ) {
		homerix_setup_default_pages();
	}
	if ( ! get_option( 'homerix_default_posts_created' ) ) {
		homerix_create_default_blog_posts();
	}
}
add_action( 'init', 'homerix_ensure_defaults_on_init', 20 );
