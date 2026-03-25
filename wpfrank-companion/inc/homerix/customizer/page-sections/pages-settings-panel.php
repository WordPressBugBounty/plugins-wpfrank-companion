<?php
/**
 * Homerix Pages Settings Panel
 *
 * Creates a unified panel for all page-specific customizer settings.
 * This panel contains sections for:
 * - Booking Page Settings
 * - Find Technician Page Settings
 * - Services Page Settings
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Add Homerix Pages Settings Panel using Kirki
 *
 * Called directly during file inclusion.
 */
Kirki::add_panel(
	'homerix_pages_settings',
	array(
		'title'       => esc_html__( 'Homerix Pages Settings', 'homerix' ),
		'description' => esc_html__( 'Configure settings for individual pages including Booking, Find Technician, and Services pages.', 'homerix' ),
		'priority'    => 20,
	)
);

