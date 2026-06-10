<?php
/**
 * Homerix Booking Settings Customizer
 *
 * Handles all customizer settings for the Book Now page.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Book Now Page Settings Section using Kirki
 */
function homerix_add_booking_sections() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-book-now.php' );
	$description = esc_html__( 'Configure the Book Now page settings and appearance.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit Book Now Page', 'homerix' ) . '</a>';
	}

	// Main Book Now Page Settings Section
	Kirki::add_section(
		'homerix_booking_settings',
		array(
			'title'       => esc_html__( 'Book Now Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 10,
		)
	);
}

/**
 * Add Booking Section Controls
 */
function homerix_booking_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_hero_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Section Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_hero_title',
			'label'       => esc_html__( 'Hero Title', 'homerix' ),
			'description' => esc_html__( 'Main heading for the booking page hero section.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 10,
			'default'     => esc_html__( 'Book Your Service', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Hero Section Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'textarea',
			'settings'    => 'booking_hero_subtitle',
			'label'       => esc_html__( 'Hero Subtitle', 'homerix' ),
			'description' => esc_html__( 'Subtitle text for the booking page hero section.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 20,
			'default'     => esc_html__( 'Schedule your home repair service in just a few simple steps', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'color',
			'settings'    => 'booking_hero_bg_color',
			'label'       => esc_html__( 'Hero Background Color', 'homerix' ),
			'description' => esc_html__( 'Background color for the hero section (fallback if no image).', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 30,
			'default'     => '#2563eb',
			'choices'     => array(
				'alpha' => true,
			),
			'transport'   => 'postMessage',
			'output'      => array(
				array(
					'element'  => '.booking-hero',
					'property' => 'background-color',
				),
			),
		)
	);

	// Hero Background Image.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'image',
			'settings'    => 'booking_hero_bg_image',
			'label'       => esc_html__( 'Hero Background Image', 'homerix' ),
			'description' => esc_html__( 'Optional background image for the hero section.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 35,
			'default'     => get_template_directory_uri() . '/assets/img/services-bg.jpg',
			'transport'   => 'postMessage',
		)
	);

	// Hero Overlay Toggle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_hero_overlay_enabled',
			'label'       => esc_html__( 'Enable Hero Overlay', 'homerix' ),
			'description' => esc_html__( 'Add a semi-transparent overlay for better text readability.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 40,
			'default'     => true,
			'transport'   => 'postMessage',
		)
	);

	// Hero Overlay Opacity.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'booking_hero_overlay_opacity',
			'label'           => esc_html__( 'Hero Overlay Opacity', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 45,
			'default'         => 40,
			'choices'         => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
			),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_hero_overlay_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== STEP 1 SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_step1_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 95,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📋 Step 1: Service Selection</h3></div>',
		)
	);

	// Step 1 Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_step1_title',
			'label'       => esc_html__( 'Step 1 Title', 'homerix' ),
			'description' => esc_html__( 'Title for service selection step.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 100,
			'default'     => esc_html__( 'What service do you need?', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Services Repeater for Step 1.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'         => 'repeater',
			'settings'     => 'booking_services',
			'label'        => esc_html__( 'Available Services', 'homerix' ),
			'description'  => esc_html__( 'Add and manage services available for booking. Users will select one of these services.', 'homerix' ),
			'section'      => 'homerix_booking_settings',
			'priority'     => 110,
			'row_label'    => array(
				'type'  => 'field',
				'value' => esc_html__( 'Service', 'homerix' ),
				'field' => 'service_name',
			),
			'button_label' => esc_html__( 'Add Service', 'homerix' ),
			'default'      => array(
				array(
					'service_name'        => esc_html__( 'Plumbing', 'homerix' ),
					'service_description' => esc_html__( 'Leaks, clogs, water heaters, and pipe repairs', 'homerix' ),
					'service_icon'        => 'fas fa-faucet',
					'service_color'       => '#2563EB',
					'service_enabled'     => true,
				),
				array(
					'service_name'        => esc_html__( 'Electrical', 'homerix' ),
					'service_description' => esc_html__( 'Wiring, lighting, outlets, and panel upgrades', 'homerix' ),
					'service_icon'        => 'fas fa-bolt',
					'service_color'       => '#eab308',
					'service_enabled'     => true,
				),
				array(
					'service_name'        => esc_html__( 'HVAC', 'homerix' ),
					'service_description' => esc_html__( 'AC repair, heating systems, and duct cleaning', 'homerix' ),
					'service_icon'        => 'fas fa-thermometer-half',
					'service_color'       => '#ef4444',
					'service_enabled'     => true,
				),
				array(
					'service_name'        => esc_html__( 'Handyman', 'homerix' ),
					'service_description' => esc_html__( 'Drywall, doors, windows, and general repairs', 'homerix' ),
					'service_icon'        => 'fas fa-tools',
					'service_color'       => '#22c55e',
					'service_enabled'     => true,
				),
			),
			'fields'       => array(
				'service_name'        => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Service Name', 'homerix' ),
					'description' => esc_html__( 'e.g., Plumbing, Electrical, HVAC', 'homerix' ),
					'default'     => '',
				),
				'service_description' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Service Description', 'homerix' ),
					'description' => esc_html__( 'Brief description of what this service includes', 'homerix' ),
					'default'     => '',
				),
				'service_icon'        => array(
					'type'        => 'iconpicker',
					'label'       => esc_html__( 'Icon Class', 'homerix' ),
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
				'service_color'       => array(
					'type'        => 'color',
					'label'       => esc_html__( 'Icon Background Color', 'homerix' ),
					'description' => esc_html__( 'Background color for the service icon', 'homerix' ),
					'default'     => '#2563EB',
					'choices'     => array(
						'alpha' => true,
					),
				),
				'service_enabled'     => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Enable Service', 'homerix' ),
					'description' => esc_html__( 'Show or hide this service option', 'homerix' ),
					'default'     => true,
				),
			),
		)
	);

	// ===== STEP 2 SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_step2_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 195,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">⏰ Step 2: Time Selection</h3></div>',
		)
	);

	// Step 2 Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_step2_title',
			'label'       => esc_html__( 'Step 2 Title', 'homerix' ),
			'description' => esc_html__( 'Title for time selection step.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 200,
			'default'     => esc_html__( 'When do you need service?', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Time Type Options Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'         => 'repeater',
			'settings'     => 'booking_time_types',
			'label'        => esc_html__( 'Time Type Options', 'homerix' ),
			'description'  => esc_html__( 'Configure available time type options (ASAP, Today, Tomorrow, etc.). Users will select one of these.', 'homerix' ),
			'section'      => 'homerix_booking_settings',
			'priority'     => 210,
			'row_label'    => array(
				'type'  => 'field',
				'value' => esc_html__( 'Time Type', 'homerix' ),
				'field' => 'time_type_label',
			),
			'button_label' => esc_html__( 'Add Time Type', 'homerix' ),
			'default'      => array(
				array(
					'time_type_label'   => esc_html__( 'ASAP (Emergency)', 'homerix' ),
					'time_type_value'   => 'emergency',
					'time_type_enabled' => true,
				),
				array(
					'time_type_label'   => esc_html__( 'Today', 'homerix' ),
					'time_type_value'   => 'today',
					'time_type_enabled' => true,
				),
				array(
					'time_type_label'   => esc_html__( 'Tomorrow', 'homerix' ),
					'time_type_value'   => 'tomorrow',
					'time_type_enabled' => true,
				),
				array(
					'time_type_label'   => esc_html__( 'This Week', 'homerix' ),
					'time_type_value'   => 'this-week',
					'time_type_enabled' => true,
				),
				array(
					'time_type_label'   => esc_html__( 'Next Week', 'homerix' ),
					'time_type_value'   => 'next-week',
					'time_type_enabled' => true,
				),
			),
			'fields'       => array(
				'time_type_label'   => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Label', 'homerix' ),
					'description' => esc_html__( 'Display label for this time type', 'homerix' ),
					'default'     => '',
				),
				'time_type_value'   => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Value', 'homerix' ),
					'description' => esc_html__( 'Internal value (no spaces, use hyphens)', 'homerix' ),
					'default'     => '',
				),
				'time_type_enabled' => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Enable', 'homerix' ),
					'description' => esc_html__( 'Show or hide this time type option', 'homerix' ),
					'default'     => true,
				),
			),
		)
	);

	// Available Time Slots.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'textarea',
			'settings'    => 'booking_time_slots',
			'label'       => esc_html__( 'Available Time Slots', 'homerix' ),
			'description' => esc_html__( 'Enter time slots separated by commas (e.g., 8:00 AM, 10:00 AM, 12:00 PM, 2:00 PM, 4:00 PM, 6:00 PM)', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 220,
			'default'     => '8:00 AM, 10:00 AM, 12:00 PM, 2:00 PM, 4:00 PM, 6:00 PM',
			'transport'   => 'postMessage',
		)
	);

	// ===== STEP 3 SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_step3_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 295,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">👤 Step 3: Customer Details</h3></div>',
		)
	);

	// Step 3 Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_step3_title',
			'label'       => esc_html__( 'Step 3 Title', 'homerix' ),
			'description' => esc_html__( 'Title for customer details step.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 300,
			'default'     => esc_html__( 'Tell us about yourself', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Enable First Name Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_field_first_name',
			'label'       => esc_html__( 'Enable First Name Field', 'homerix' ),
			'description' => esc_html__( 'Show first name input field', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 310,
			'default'     => true,
		)
	);

	// Enable Last Name Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_field_last_name',
			'label'       => esc_html__( 'Enable Last Name Field', 'homerix' ),
			'description' => esc_html__( 'Show last name input field', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 320,
			'default'     => true,
		)
	);

	// Enable Email Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_field_email',
			'label'       => esc_html__( 'Enable Email Field', 'homerix' ),
			'description' => esc_html__( 'Show email input field', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 330,
			'default'     => true,
		)
	);

	// Enable Phone Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_field_phone',
			'label'       => esc_html__( 'Enable Phone Field', 'homerix' ),
			'description' => esc_html__( 'Show phone number input field', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 340,
			'default'     => true,
		)
	);

	// Enable Address Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_field_address',
			'label'       => esc_html__( 'Enable Address Field', 'homerix' ),
			'description' => esc_html__( 'Show service address input field', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 350,
			'default'     => true,
		)
	);

	// Enable Special Instructions Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_field_instructions',
			'label'       => esc_html__( 'Enable Special Instructions Field', 'homerix' ),
			'description' => esc_html__( 'Show special instructions textarea', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 360,
			'default'     => true,
		)
	);

	// ===== STEP 4 SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_step4_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 395,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">✅ Step 4: Review & Confirmation</h3></div>',
		)
	);

	// Step 4 Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'booking_step4_title',
			'label'       => esc_html__( 'Step 4 Title', 'homerix' ),
			'description' => esc_html__( 'Title for confirmation step.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 400,
			'default'     => esc_html__( 'Review Your Appointment', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Confirmation Message.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'textarea',
			'settings'    => 'booking_confirmation_message',
			'label'       => esc_html__( 'Confirmation Message', 'homerix' ),
			'description' => esc_html__( 'Message displayed after successful booking confirmation.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 410,
			'default'     => esc_html__( 'Thank you for booking with us! Your appointment has been confirmed. You will receive a confirmation email shortly.', 'homerix' ),
			'transport'   => 'postMessage',
		)
	);

	// Note: reCAPTCHA settings are defined in inc/recaptcha-settings.php

	// ===== FORM STYLING HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_styling_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 495,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎨 Form Styling & Color Overrides</h3><p style="margin-top: 5px; font-style: italic; color: #666;">' . esc_html__( 'Override theme colors for this section only.', 'homerix' ) . '</p></div>',
		)
	);

	// Enable Color Override Toggle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_form_color_override_enabled',
			'label'       => esc_html__( 'Enable Color Override', 'homerix' ),
			'description' => esc_html__( 'Enable custom colors for the booking form. When disabled, theme colors will be used.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 496,
			'default'     => false,
		)
	);

	// Form Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_form_bg_color',
			'label'           => esc_html__( 'Form Background Color', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 497,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Form Border Radius.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'booking_form_border_radius',
			'label'           => esc_html__( 'Form Border Radius', 'homerix' ),
			'description'     => esc_html__( 'Corner radius for the form container (px).', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 498,
			'default'         => 8,
			'choices'         => array(
				'min'  => 0,
				'max'  => 32,
				'step' => 2,
			),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Form Shadow Toggle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'toggle',
			'settings'        => 'booking_form_shadow_enabled',
			'label'           => esc_html__( 'Enable Form Shadow', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 499,
			'default'         => true,
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Input Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_input_bg_color',
			'label'           => esc_html__( 'Input Background Color', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 500,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Input Border Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_input_border_color',
			'label'           => esc_html__( 'Input Border Color', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 501,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'border' ) : '#e5e7eb',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Input Focus Border Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_input_focus_color',
			'label'           => esc_html__( 'Input Focus Border Color', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 502,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563eb',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Selection Highlight Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_selection_color',
			'label'           => esc_html__( 'Selection Highlight Color', 'homerix' ),
			'description'     => esc_html__( 'Color for selected services and time slots.', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 503,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563eb',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Step Indicator Active Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_step_indicator_color',
			'label'           => esc_html__( 'Step Indicator Active Color', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 504,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563eb',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Primary Button Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_primary_btn_bg_color',
			'label'           => esc_html__( 'Primary Button Background', 'homerix' ),
			'description'     => esc_html__( 'Background color for Next buttons.', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 510,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563eb',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Primary Button Text Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_primary_btn_text_color',
			'label'           => esc_html__( 'Primary Button Text', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 511,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Success Button Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_success_btn_bg_color',
			'label'           => esc_html__( 'Confirm Button Background', 'homerix' ),
			'description'     => esc_html__( 'Background color for Confirm Booking button.', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 512,
			'default'         => '#16a34a',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Success Button Text Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_success_btn_text_color',
			'label'           => esc_html__( 'Confirm Button Text', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 513,
			'default'         => '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Secondary Button Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_secondary_btn_bg_color',
			'label'           => esc_html__( 'Back Button Background', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 514,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'base' ) : '#ffffff',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Secondary Button Text Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'color',
			'settings'        => 'booking_secondary_btn_text_color',
			'label'           => esc_html__( 'Back Button Text', 'homerix' ),
			'section'         => 'homerix_booking_settings',
			'priority'        => 515,
			'default'         => function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563eb',
			'choices'         => array( 'alpha' => true ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'booking_form_color_override_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== FORM OPTIONS HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'booking_options_heading',
			'section'  => 'homerix_booking_settings',
			'priority' => 595,
			'default'  => '<div style="padding: 15px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 10px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">⚙️ Form Options</h3></div>',
		)
	);

	// Form Container Width.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'radio-buttonset',
			'settings'    => 'booking_form_width',
			'label'       => esc_html__( 'Form Container Width', 'homerix' ),
			'description' => esc_html__( 'Choose the width of the booking form container.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 600,
			'default'     => 'max-w-4xl',
			'choices'     => array(
				'max-w-2xl' => esc_html__( 'Small', 'homerix' ),
				'max-w-4xl' => esc_html__( 'Medium', 'homerix' ),
				'max-w-6xl' => esc_html__( 'Large', 'homerix' ),
				'w-full'    => esc_html__( 'Full Width', 'homerix' ),
			),
		)
	);

	// Enable Emergency Service Option.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_enable_emergency',
			'label'       => esc_html__( 'Enable Emergency Service Option', 'homerix' ),
			'description' => esc_html__( 'Show ASAP (Emergency) option in time selection.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 610,
			'default'     => true,
		)
	);

	// Enable Terms & Conditions.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_enable_terms',
			'label'       => esc_html__( 'Require Terms & Conditions', 'homerix' ),
			'description' => esc_html__( 'Require users to accept terms before booking.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 620,
			'default'     => true,
		)
	);

	// Enable Additional Notes Field.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'booking_enable_notes',
			'label'       => esc_html__( 'Enable Additional Notes Field', 'homerix' ),
			'description' => esc_html__( 'Allow customers to add additional notes about their service.', 'homerix' ),
			'section'     => 'homerix_booking_settings',
			'priority'    => 630,
			'default'     => true,
		)
	);
}

// Call the functions directly during file inclusion if Kirki is available.
if ( class_exists( 'Kirki' ) ) {
	homerix_add_booking_sections();
	homerix_booking_controls();
}
