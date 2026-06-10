<?php
/**
 * Homerix Theme Companion Support
 *
 * Provides homepage sections, customizer settings, page templates,
 * AJAX handlers, and default content for the Homerix theme.
 *
 * @package wpfrank-companion
 * @since   0.3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Homerix companion constants.
 */
define( 'WPFRANK_HOMERIX_DIR', wpfrank_companion_plugin_dir . 'inc/homerix/' );
define( 'WPFRANK_HOMERIX_URL', wpfrank_companion_plugin_url . 'inc/homerix/' );

/**
 * Load Homerix Customizer sections.
 * These provide the Customizer controls for homepage sections and page templates.
 */
if ( class_exists( 'Kirki' ) ) {
	// Homepage section customizer files.
	$homerix_customizer_files = array(
		'customizer/frontpage-sections/hero-section.php',
		'customizer/frontpage-sections/services-section.php',
		'customizer/frontpage-sections/whyus-section.php',
		'customizer/frontpage-sections/technicians-section.php',
		'customizer/frontpage-sections/testimonials-section.php',
		'customizer/frontpage-sections/cta-section.php',
		'customizer/frontpage-sections/blog-section.php',
	);

	// Section order customizer.
	$homerix_customizer_files[] = 'customizer/sections-order/customizer-sections-order.php';

	// Page template customizer files.
	$homerix_page_customizer_files = array(
		'customizer/page-sections/pages-settings-panel.php',
		'customizer/page-sections/booking-section.php',
		'customizer/page-sections/find-technician-section.php',
		'customizer/page-sections/services-page-section.php',
		'customizer/page-sections/about-us-page-section.php',
		'customizer/page-sections/contact-us-page-section.php',
		'customizer/page-sections/faq-page-section.php',
		'customizer/page-sections/privacy-policy-page-section.php',
		'customizer/page-sections/terms-of-service-page-section.php',
		'customizer/page-sections/pages-customizer.php',
	);

	$homerix_customizer_files = array_merge( $homerix_customizer_files, $homerix_page_customizer_files );

	foreach ( $homerix_customizer_files as $file ) {
		$file_path = WPFRANK_HOMERIX_DIR . $file;
		if ( file_exists( $file_path ) ) {
			require_once $file_path;
		}
	}
}

/**
 * Load AJAX handlers.
 */
$homerix_ajax_files = array(
	'ajax/booking-handler.php',
	'ajax/contact-handler.php',
	'ajax/find-technician-handler.php',
	'ajax/services-handler.php',
);

foreach ( $homerix_ajax_files as $file ) {
	$file_path = WPFRANK_HOMERIX_DIR . $file;
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}

/**
 * Load post types.
 */
$homerix_posttype_path = WPFRANK_HOMERIX_DIR . 'post-types/booking-details-display.php';
if ( file_exists( $homerix_posttype_path ) ) {
	require_once $homerix_posttype_path;
}

/**
 * Load integrations.
 */
$homerix_integration_files = array(
	'integrations/recaptcha.php',
	'integrations/newsletter.php',
);

// Newsletter admin only in admin context.
if ( is_admin() ) {
	$homerix_integration_files[] = 'integrations/newsletter-admin.php';
}

foreach ( $homerix_integration_files as $file ) {
	$file_path = WPFRANK_HOMERIX_DIR . $file;
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}

/**
 * Load email functionality.
 */
$homerix_email_path = WPFRANK_HOMERIX_DIR . 'email/mail-settings.php';
if ( file_exists( $homerix_email_path ) ) {
	require_once $homerix_email_path;
}

/**
 * Load default data.
 */
$homerix_default_data_path = WPFRANK_HOMERIX_DIR . 'default-data/technicians.php';
if ( file_exists( $homerix_default_data_path ) ) {
	require_once $homerix_default_data_path;
}

/**
 * Load default content creation (pages, posts, menus).
 */
$homerix_default_content_path = WPFRANK_HOMERIX_DIR . 'default-content.php';
if ( file_exists( $homerix_default_content_path ) ) {
	require_once $homerix_default_content_path;
}

/**
 * Register page templates from the plugin.
 * This allows page templates from the plugin to appear in the page template dropdown.
 *
 * @param array $templates Existing page templates.
 * @return array Modified page templates.
 */
function wpfrank_homerix_register_page_templates( $templates ) {
	$plugin_templates = array(
		'homerix-companion/page-about-us.php'         => __( 'Homerix About Us', 'wpfrank-companion' ),
		'homerix-companion/page-book-now.php'         => __( 'Homerix Book Now', 'wpfrank-companion' ),
		'homerix-companion/page-contact-us.php'       => __( 'Homerix Contact Us', 'wpfrank-companion' ),
		'homerix-companion/page-faq.php'              => __( 'Homerix FAQ', 'wpfrank-companion' ),
		'homerix-companion/page-find-technician.php'  => __( 'Homerix Find Technician', 'wpfrank-companion' ),
		'homerix-companion/page-site-services.php'    => __( 'Homerix Services', 'wpfrank-companion' ),
		'homerix-companion/page-privacy-policy.php'   => __( 'Homerix Privacy Policy', 'wpfrank-companion' ),
		'homerix-companion/page-terms-of-service.php' => __( 'Homerix Terms of Service', 'wpfrank-companion' ),
	);

	return array_merge( $templates, $plugin_templates );
}
add_filter( 'theme_page_templates', 'wpfrank_homerix_register_page_templates' );

/**
 * Load page templates from the plugin directory.
 *
 * @param string $template The path to the template.
 * @return string Modified template path.
 */
function wpfrank_homerix_load_page_template( $template ) {
	$page_template = get_page_template_slug();

	if ( strpos( $page_template, 'homerix-companion/' ) === 0 ) {
		$plugin_template = WPFRANK_HOMERIX_DIR . 'page-templates/' . str_replace( 'homerix-companion/', '', $page_template );
		if ( file_exists( $plugin_template ) ) {
			return $plugin_template;
		}
	}

	// Backward compatibility: also handle old theme template slugs.
	$old_template_map = array(
		'page-templates/page-about-us.php'         => 'page-templates/page-about-us.php',
		'page-templates/page-book-now.php'         => 'page-templates/page-book-now.php',
		'page-templates/page-contact-us.php'       => 'page-templates/page-contact-us.php',
		'page-templates/page-faq.php'              => 'page-templates/page-faq.php',
		'page-templates/page-find-technician.php'  => 'page-templates/page-find-technician.php',
		'page-templates/page-site-services.php'    => 'page-templates/page-site-services.php',
		'page-templates/page-privacy-policy.php'   => 'page-templates/page-privacy-policy.php',
		'page-templates/page-terms-of-service.php' => 'page-templates/page-terms-of-service.php',
	);

	if ( isset( $old_template_map[ $page_template ] ) ) {
		$plugin_template = WPFRANK_HOMERIX_DIR . $old_template_map[ $page_template ];
		if ( file_exists( $plugin_template ) ) {
			return $plugin_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'wpfrank_homerix_load_page_template' );

if ( ! function_exists( 'wpfrank_homerix_frontpage_sections' ) ) :
	/**
	 * Render Homerix frontpage sections.
	 * This is the main function called by the theme via do_action('wpfrank_homerix_frontpage').
	 */
	function wpfrank_homerix_frontpage_sections() {
		// Get section order from customizer.
		$section_order = homerix_get_section_order();

		// Loop through sections in custom order.
		foreach ( $section_order as $section ) {
			// Map section name for visibility check (cta-banner -> cta).
			$visibility_section = ( 'cta-banner' === $section ) ? 'cta' : $section;

			// Check if section is enabled.
			$section_enabled = get_theme_mod( "homerix_{$visibility_section}_enabled", true );

			if ( $section_enabled ) {
				$section_file = WPFRANK_HOMERIX_DIR . 'front-page/section-' . $section . '.php';
				if ( file_exists( $section_file ) ) {
					require $section_file;
				}
			}
		}
	}
	add_action( 'wpfrank_homerix_frontpage', 'wpfrank_homerix_frontpage_sections' );
endif;
