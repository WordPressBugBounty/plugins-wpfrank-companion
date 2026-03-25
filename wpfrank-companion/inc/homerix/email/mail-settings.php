<?php
/**
 * Booking Mail Settings
 *
 * Unified email and SMTP configuration for booking notifications.
 * Combines email templates, recipients, and SMTP delivery settings.
 *
 * @package Homerix_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configure SMTP settings for WordPress emails.
 *
 * Uses Customizer settings first, falls back to wp-config.php constants.
 *
 * @param PHPMailer\PHPMailer\PHPMailer $phpmailer PHPMailer instance.
 */
function homerix_configure_smtp( $phpmailer ) {
	// Check if SMTP is enabled in customizer.
	$smtp_enabled = get_theme_mod( 'homerix_smtp_enabled', false );

	// Also check wp-config.php constant as fallback.
	if ( ! $smtp_enabled && ! defined( 'HOMERIX_SMTP_HOST' ) ) {
		return; // SMTP not configured, use default PHP mail.
	}

	// Get SMTP settings from Customizer (with wp-config.php fallbacks).
	$smtp_host       = get_theme_mod( 'HOMERIX_SMTP_HOST', defined( 'HOMERIX_SMTP_HOST' ) ? HOMERIX_SMTP_HOST : '' );
	$smtp_port       = get_theme_mod( 'HOMERIX_SMTP_PORT', defined( 'HOMERIX_SMTP_PORT' ) ? HOMERIX_SMTP_PORT : 587 );
	$smtp_encryption = get_theme_mod( 'HOMERIX_SMTP_ENCRYPTION', defined( 'HOMERIX_SMTP_ENCRYPTION' ) ? HOMERIX_SMTP_ENCRYPTION : 'tls' );
	$smtp_auth       = get_theme_mod( 'homerix_smtp_auth', true );
	$smtp_username   = get_theme_mod( 'HOMERIX_SMTP_USERname', defined( 'HOMERIX_SMTP_USER' ) ? HOMERIX_SMTP_USER : '' );
	$smtp_password   = get_theme_mod( 'HOMERIX_SMTP_PASSword', defined( 'HOMERIX_SMTP_PASS' ) ? HOMERIX_SMTP_PASS : '' );
	$smtp_from_email = get_theme_mod( 'HOMERIX_SMTP_FROM_email', defined( 'HOMERIX_SMTP_FROM' ) ? HOMERIX_SMTP_FROM : get_option( 'admin_email' ) );
	$smtp_from_name  = get_theme_mod( 'HOMERIX_SMTP_FROM_name', defined( 'HOMERIX_SMTP_NAME' ) ? HOMERIX_SMTP_NAME : get_bloginfo( 'name' ) );

	// Skip if essential settings are missing.
	if ( empty( $smtp_host ) || empty( $smtp_username ) || empty( $smtp_password ) ) {
		return;
	}

	// Configure PHPMailer for SMTP.
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- PHPMailer uses PascalCase properties.
	$phpmailer->isSMTP();
	$phpmailer->Host       = $smtp_host;
	$phpmailer->Port       = absint( $smtp_port );
	$phpmailer->SMTPSecure = $smtp_encryption;
	$phpmailer->SMTPAuth   = $smtp_auth;
	$phpmailer->Username   = $smtp_username;
	$phpmailer->Password   = $smtp_password;

	// Set From email and name.
	if ( ! empty( $smtp_from_email ) ) {
		$phpmailer->From = $smtp_from_email;
	}
	if ( ! empty( $smtp_from_name ) ) {
		$phpmailer->FromName = $smtp_from_name;
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

	// Enable debug logging in development only.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase,WordPress.PHP.DevelopmentFunctions.error_log_error_log
		$phpmailer->SMTPDebug   = 2;
		$phpmailer->Debugoutput = function( $str, $level ) {
			error_log( "SMTP Debug [$level]: $str" );
		};
		// phpcs:enable
	}
}
add_action( 'phpmailer_init', 'homerix_configure_smtp', 10, 1 );

// Only proceed with Kirki settings if available.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Add Booking Mail Settings section via Kirki.
 */
add_action( 'init', 'homerix_add_booking_mail_section' );

function homerix_add_booking_mail_section() {
	Kirki::add_section(
		'homerix_booking_mail',
		array(
			'title'       => esc_html__( '📧 Booking Mail Settings', 'homerix' ),
			'description' => esc_html__( 'Configure email notifications and SMTP for booking confirmations.', 'homerix' ),
			'panel'       => 'homerix_pages_settings',
			'priority'    => 15,
		)
	);
}

/**
 * Add all email and SMTP settings to Booking Mail section via Kirki.
 */
add_action( 'init', 'homerix_add_booking_mail_settings' );

function homerix_add_booking_mail_settings() {

	// =====================================================================
	// CUSTOMER EMAIL SETTINGS
	// =====================================================================
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_email_customer_heading',
			'section'  => 'homerix_booking_mail',
			'priority' => 10,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📨 Customer Email</h3></div>',
		)
	);

	// Send Confirmation Email to Customer.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_email_send_customer',
			'label'       => esc_html__( 'Send Confirmation to Customer', 'homerix' ),
			'description' => esc_html__( 'Send a booking confirmation email to the customer.', 'homerix' ),
			'section'     => 'homerix_booking_mail',
			'priority'    => 15,
			'default'     => true,
		)
	);

	// Email Subject.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'text',
			'settings' => 'booking_email_subject',
			'label'    => esc_html__( 'Customer Email Subject', 'homerix' ),
			'section'  => 'homerix_booking_mail',
			'priority' => 20,
			'default'  => esc_html__( 'Booking Confirmation - {site_name}', 'homerix' ),
		)
	);

	// Email Body.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'textarea',
			'settings'    => 'booking_email_body',
			'label'       => esc_html__( 'Custom Email Body (Optional)', 'homerix' ),
			'description' => esc_html__( 'Leave empty to use the default HTML template.', 'homerix' ),
			'section'     => 'homerix_booking_mail',
			'priority'    => 25,
			'default'     => '',
		)
	);

	// =====================================================================
	// ADMIN EMAIL SETTINGS
	// =====================================================================
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_email_admin_heading',
			'section'  => 'homerix_booking_mail',
			'priority' => 30,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🔔 Admin Notification</h3></div>',
		)
	);

	// Admin Email Address.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_admin_email',
			'label'       => esc_html__( 'Admin Email Address', 'homerix' ),
			'description' => esc_html__( 'Leave empty to use WordPress admin email.', 'homerix' ),
			'section'     => 'homerix_booking_mail',
			'priority'    => 35,
			'default'     => '',
			'input_attrs' => array(
				'placeholder' => get_option( 'admin_email' ),
			),
		)
	);

	// Admin Email Subject.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'text',
			'settings' => 'booking_admin_email_subject',
			'label'    => esc_html__( 'Admin Email Subject', 'homerix' ),
			'section'  => 'homerix_booking_mail',
			'priority' => 40,
			'default'  => esc_html__( '🔔 New Booking #{booking_id} - {service}', 'homerix' ),
		)
	);

	// Template Tags Info.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_email_tags_info',
			'section'  => 'homerix_booking_mail',
			'priority' => 45,
			'default'  => '<div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 6px; padding: 12px; margin: 10px 0;">
				<strong style="color: #0369a1;">Template Tags:</strong><br>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{site_name}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{booking_id}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{service}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{time_slot}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{first_name}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{last_name}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{email}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{phone}</code>
				<code style="font-size: 10px; background: #e0f2fe; padding: 2px 4px; border-radius: 3px; margin: 1px;">{address}</code>
			</div>',
		)
	);

	// =====================================================================
	// SMTP SETTINGS
	// =====================================================================
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_smtp_heading',
			'section'  => 'homerix_booking_mail',
			'priority' => 50,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">⚙️ SMTP Settings</h3><p style="margin: 5px 0 0; font-size: 12px; color: #666;">Configure SMTP for reliable email delivery. No plugin needed!</p></div>',
		)
	);

	// Enable SMTP.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'homerix_smtp_enabled',
			'label'       => esc_html__( 'Enable SMTP', 'homerix' ),
			'description' => esc_html__( 'Use SMTP instead of PHP mail() for sending emails.', 'homerix' ),
			'section'     => 'homerix_booking_mail',
			'priority'    => 55,
			'default'     => false,
		)
	);

	// SMTP Host.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'HOMERIX_SMTP_HOST',
			'label'           => esc_html__( 'SMTP Host', 'homerix' ),
			'description'     => esc_html__( 'e.g., smtp.gmail.com', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 60,
			'default'         => '',
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// SMTP Port.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'select',
			'settings'        => 'HOMERIX_SMTP_PORT',
			'label'           => esc_html__( 'SMTP Port', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 65,
			'default'         => 587,
			'choices'         => array(
				25   => '25 (Unencrypted)',
				465  => '465 (SSL)',
				587  => '587 (TLS) - Recommended',
				2525 => '2525 (Alternative)',
			),
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// SMTP Encryption.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'radio-buttonset',
			'settings'        => 'HOMERIX_SMTP_ENCRYPTION',
			'label'           => esc_html__( 'Encryption', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 70,
			'default'         => 'tls',
			'choices'         => array(
				'none' => esc_html__( 'None', 'homerix' ),
				'ssl'  => esc_html__( 'SSL', 'homerix' ),
				'tls'  => esc_html__( 'TLS', 'homerix' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// SMTP Username.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'HOMERIX_SMTP_USERname',
			'label'           => esc_html__( 'SMTP Username', 'homerix' ),
			'description'     => esc_html__( 'Usually your email address', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 75,
			'default'         => '',
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// SMTP Password.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'HOMERIX_SMTP_PASSword',
			'label'           => esc_html__( 'SMTP Password', 'homerix' ),
			'description'     => esc_html__( 'For Gmail, use an App Password', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 80,
			'default'         => '',
			'input_attrs'     => array(
				'type' => 'password',
			),
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// From Email.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'HOMERIX_SMTP_FROM_email',
			'label'           => esc_html__( 'From Email', 'homerix' ),
			'description'     => esc_html__( 'Note: Gmail ignores this and uses SMTP username. To use a different From email with Gmail, add it as "Send mail as" alias in Gmail settings.', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 85,
			'default'         => '',
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// From Name.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'HOMERIX_SMTP_FROM_name',
			'label'           => esc_html__( 'From Name', 'homerix' ),
			'section'         => 'homerix_booking_mail',
			'priority'        => 90,
			'default'         => get_bloginfo( 'name' ),
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Gmail Help Info.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'custom',
			'settings'        => 'homerix_smtp_help_info',
			'section'         => 'homerix_booking_mail',
			'priority'        => 95,
			'default'         => '<div style="background: #ecfdf5; border: 1px solid #10b981; border-radius: 6px; padding: 12px; margin: 10px 0;">
				<strong style="color: #065f46;">📧 Gmail Settings:</strong><br>
				<span style="font-size: 12px; color: #047857;">
					Host: <code>smtp.gmail.com</code> | Port: <code>587</code> | Encryption: <code>TLS</code><br>
					<a href="https://myaccount.google.com/apppasswords" target="_blank" style="color: #059669;">Create Gmail App Password →</a>
				</span>
			</div>',
			'active_callback' => array(
				array(
					'setting'  => 'homerix_smtp_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}
