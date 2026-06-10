<?php
/**
 * ReCAPTCHA Settings
 *
 * Adds reCAPTCHA v3 configuration to WordPress admin via Kirki
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if Kirki is available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

add_action( 'init', 'homerix_add_recaptcha_settings_kirki' );
/**
 * Add reCAPTCHA settings to Booking Options section via Kirki.
 */
function homerix_add_recaptcha_settings_kirki() {

	// ===== RECAPTCHA SETTINGS HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_recaptcha_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 420,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🔒 reCAPTCHA Settings</h3><p style="margin: 5px 0 0; font-size: 12px; color: #666;">Protect your booking form from spam with Google reCAPTCHA v2 Checkbox.</p></div>',
		)
	);

	// Enable reCAPTCHA.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_recaptcha_enabled',
			'label'       => esc_html__( 'Enable reCAPTCHA', 'homerix' ),
			'description' => esc_html__( 'Require users to verify they are not a robot before submitting the booking form.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 425,
			'default'     => false,
		)
	);

	// reCAPTCHA Site Key.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_recaptcha_site_key',
			'label'       => esc_html__( 'reCAPTCHA Site Key', 'homerix' ),
			'description' => esc_html__( 'Enter your Google reCAPTCHA v2 Checkbox site key. Get keys from https://www.google.com/recaptcha/admin', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 430,
			'default'     => '',
		)
	);

	// reCAPTCHA Secret Key.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_recaptcha_secret_key',
			'label'       => esc_html__( 'reCAPTCHA Secret Key', 'homerix' ),
			'description' => esc_html__( 'Enter your Google reCAPTCHA v2 Checkbox secret key. Keep this private.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 435,
			'default'     => '',
		)
	);
}
