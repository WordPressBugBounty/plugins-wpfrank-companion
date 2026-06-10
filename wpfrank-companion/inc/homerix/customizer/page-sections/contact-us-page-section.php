<?php
/**
 * Homerix Contact Us Page Settings Customizer
 *
 * Handles all customizer settings for the Contact Us page.
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
 * Add Contact Us Page Settings Section
 */
function homerix_contact_us_page_section() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-contact-us.php' );
	$description = esc_html__( 'Configure the Contact Us page settings and appearance.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit Contact Us Page', 'homerix' ) . '</a>';
	}

	// Main Contact Us Page Settings Section.
	Kirki::add_section(
		'homerix_contact_us_page_settings',
		array(
			'title'       => esc_html__( 'Contact Us Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 20,
		)
	);
}

/**
 * Add Contact Us Page Controls
 */
function homerix_contact_us_page_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'contact_hero_heading',
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 10,
			'default'   => __( 'Contact Homerix Pro', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'contact_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 20,
			'default'   => __( "We're here to help with all your home repair questions and service needs", 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Button Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_hero_button_text',
			'label'     => esc_html__( 'Button Text', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 30,
			'default'   => __( 'Send Us a Message', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Button URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_hero_button_url',
			'label'     => esc_html__( 'Button URL', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 40,
			'default'   => '#contact-form',
			'transport' => 'postMessage',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'contact_hero_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 50,
			'default'   => '#1e3a5f',
			'transport' => 'postMessage',
		)
	);

	// Hero Background Image.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'image',
			'settings'  => 'contact_hero_bg_image',
			'label'     => esc_html__( 'Background Image (Optional)', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 60,
			'default'   => get_template_directory_uri() . '/assets/img/contact-bg.jpg',
			'transport' => 'postMessage',
		)
	);

	// Hero Overlay Enabled.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'contact_hero_overlay_enabled',
			'label'    => esc_html__( 'Enable Hero Overlay', 'homerix' ),
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 61,
			'default'  => true,
		)
	);

	// Hero Overlay Opacity.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'contact_hero_overlay_opacity',
			'label'           => esc_html__( 'Hero Overlay Opacity (%)', 'homerix' ),
			'section'         => 'homerix_contact_us_page_settings',
			'priority'        => 62,
			'default'         => 50,
			'choices'         => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
			),
			'active_callback' => array(
				array(
					'setting'  => 'contact_hero_overlay_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== CONTACT CARDS SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'contact_cards_heading',
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 65,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📇 Contact Cards</h3></div>',
		)
	);

	// Contact Cards Repeater with simple item fields.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'         => 'repeater',
			'settings'     => 'contact_cards',
			'label'        => esc_html__( 'Contact Cards', 'homerix' ),
			'description'  => esc_html__( 'Add contact cards with custom icons and up to 3 items each.', 'homerix' ),
			'section'      => 'homerix_contact_us_page_settings',
			'priority'     => 70,
			'button_label' => esc_html__( 'Add Card', 'homerix' ),
			'row_label'    => array(
				'type'  => 'field',
				'value' => esc_html__( 'Card', 'homerix' ),
				'field' => 'card_title',
			),
			'default'      => array(
				// Call Us Card.
				array(
					'card_enabled'     => true,
					'card_icon'        => 'fas fa-phone-alt',
					'card_icon_color'  => '#2563EB',
					'card_title'       => __( 'Call Us', 'homerix' ),
					'card_description' => __( 'Speak directly with our customer service team during business hours.', 'homerix' ),
					'item1_icon'       => 'fas fa-clock',
					'item1_value'      => __( 'Mon-Fri: 8:00 AM - 6:00 PM', 'homerix' ),
					'item1_link_type'  => 'none',
					'item2_icon'       => 'fas fa-phone',
					'item2_value'      => '(555) 123-4567',
					'item2_link_type'  => 'tel',
					'item3_icon'       => 'fas fa-exclamation-triangle',
					'item3_value'      => '(555) 765-4321 (Emergency)',
					'item3_link_type'  => 'tel',
				),
				// Email Us Card.
				array(
					'card_enabled'     => true,
					'card_icon'        => 'fas fa-envelope',
					'card_icon_color'  => '#22C55E',
					'card_title'       => __( 'Email Us', 'homerix' ),
					'card_description' => __( "Send us a message and we'll respond within 24 hours.", 'homerix' ),
					'item1_icon'       => 'fas fa-inbox',
					'item1_value'      => 'info@example.com',
					'item1_link_type'  => 'mailto',
					'item2_icon'       => 'fas fa-headset',
					'item2_value'      => 'support@example.com',
					'item2_link_type'  => 'mailto',
					'item3_icon'       => 'fas fa-briefcase',
					'item3_value'      => 'careers@example.com',
					'item3_link_type'  => 'mailto',
				),
				// Visit Us Card.
				array(
					'card_enabled'     => true,
					'card_icon'        => 'fas fa-map-marker-alt',
					'card_icon_color'  => '#EF4444',
					'card_title'       => __( 'Visit Us', 'homerix' ),
					'card_description' => __( 'Our headquarters and service center location.', 'homerix' ),
					'item1_icon'       => 'fas fa-building',
					'item1_value'      => __( '123 Repair Way, Cityville, ST 12345', 'homerix' ),
					'item1_link_type'  => 'none',
					'item2_icon'       => 'fas fa-clock',
					'item2_value'      => __( 'Office Hours: Mon-Fri 9AM-5PM', 'homerix' ),
					'item2_link_type'  => 'none',
					'item3_icon'       => '',
					'item3_value'      => '',
					'item3_link_type'  => 'none',
				),
			),
			'fields'       => array(
				'card_enabled'     => array(
					'type'    => 'checkbox',
					'label'   => esc_html__( 'Enable Card', 'homerix' ),
					'default' => true,
				),
				'card_icon'        => array(
					'type'    => 'iconpicker',
					'label'   => esc_html__( 'Card Icon', 'homerix' ),
					'default' => 'fas fa-phone-alt',
				),
				'card_icon_color'  => array(
					'type'    => 'color',
					'label'   => esc_html__( 'Icon Color', 'homerix' ),
					'default' => '#2563EB',
				),
				'card_title'       => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Card Title', 'homerix' ),
					'default' => '',
				),
				'card_description' => array(
					'type'    => 'textarea',
					'label'   => esc_html__( 'Card Description', 'homerix' ),
					'default' => '',
				),
				// Item 1.
				'item1_icon'       => array(
					'type'    => 'iconpicker',
					'label'   => esc_html__( '— Item 1 Icon', 'homerix' ),
					'default' => '',
				),
				'item1_value'      => array(
					'type'    => 'text',
					'label'   => esc_html__( '— Item 1 Value', 'homerix' ),
					'default' => '',
				),
				'item1_link_type'  => array(
					'type'    => 'select',
					'label'   => esc_html__( '— Item 1 Link Type', 'homerix' ),
					'default' => 'none',
					'choices' => array(
						'none'   => esc_html__( 'Plain Text', 'homerix' ),
						'tel'    => esc_html__( 'Phone (tel:)', 'homerix' ),
						'mailto' => esc_html__( 'Email (mailto:)', 'homerix' ),
						'url'    => esc_html__( 'URL', 'homerix' ),
					),
				),
				// Item 2.
				'item2_icon'       => array(
					'type'    => 'iconpicker',
					'label'   => esc_html__( '— Item 2 Icon', 'homerix' ),
					'default' => '',
				),
				'item2_value'      => array(
					'type'    => 'text',
					'label'   => esc_html__( '— Item 2 Value', 'homerix' ),
					'default' => '',
				),
				'item2_link_type'  => array(
					'type'    => 'select',
					'label'   => esc_html__( '— Item 2 Link Type', 'homerix' ),
					'default' => 'none',
					'choices' => array(
						'none'   => esc_html__( 'Plain Text', 'homerix' ),
						'tel'    => esc_html__( 'Phone (tel:)', 'homerix' ),
						'mailto' => esc_html__( 'Email (mailto:)', 'homerix' ),
						'url'    => esc_html__( 'URL', 'homerix' ),
					),
				),
				// Item 3.
				'item3_icon'       => array(
					'type'    => 'iconpicker',
					'label'   => esc_html__( '— Item 3 Icon', 'homerix' ),
					'default' => '',
				),
				'item3_value'      => array(
					'type'    => 'text',
					'label'   => esc_html__( '— Item 3 Value', 'homerix' ),
					'default' => '',
				),
				'item3_link_type'  => array(
					'type'    => 'select',
					'label'   => esc_html__( '— Item 3 Link Type', 'homerix' ),
					'default' => 'none',
					'choices' => array(
						'none'   => esc_html__( 'Plain Text', 'homerix' ),
						'tel'    => esc_html__( 'Phone (tel:)', 'homerix' ),
						'mailto' => esc_html__( 'Email (mailto:)', 'homerix' ),
						'url'    => esc_html__( 'URL', 'homerix' ),
					),
				),
			),
		)
	);

	// ===== CONTACT FORM SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'contact_form_heading',
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 130,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📝 Contact Form Section</h3></div>',
		)
	);

	// Form Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_form_title',
			'label'     => esc_html__( 'Form Title', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 135,
			'default'   => __( 'Send Us a Message', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Form Description.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'contact_form_description',
			'label'     => esc_html__( 'Form Description', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 140,
			'default'   => __( "Have questions about our services or need to schedule a repair? Fill out the form below and we'll get back to you promptly.", 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Contact Form Subjects.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'repeater',
			'settings'    => 'contact_form_subjects',
			'label'       => esc_html__( 'Subject Options', 'homerix' ),
			'description' => esc_html__( 'Define the subject options for the contact form dropdown.', 'homerix' ),
			'section'     => 'homerix_contact_us_page_settings',
			'priority'    => 141,
			'default'     => array(
				array(
					'value' => 'service-request',
					'label' => __( 'Service Request', 'homerix' ),
				),
				array(
					'value' => 'estimate',
					'label' => __( 'Request an Estimate', 'homerix' ),
				),
				array(
					'value' => 'emergency',
					'label' => __( 'Emergency Service', 'homerix' ),
				),
				array(
					'value' => 'general',
					'label' => __( 'General Inquiry', 'homerix' ),
				),
				array(
					'value' => 'billing',
					'label' => __( 'Billing Question', 'homerix' ),
				),
				array(
					'value' => 'feedback',
					'label' => __( 'Feedback/Suggestion', 'homerix' ),
				),
				array(
					'value' => 'careers',
					'label' => __( 'Careers', 'homerix' ),
				),
				array(
					'value' => 'other',
					'label' => __( 'Other', 'homerix' ),
				),
			),
			'fields'      => array(
				'value' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Value (Internal)', 'homerix' ),
					'description' => esc_html__( 'Lowercase, no spaces (e.g., service-request)', 'homerix' ),
					'default'     => '',
				),
				'label' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Label (Displayed)', 'homerix' ),
					'default' => '',
				),
			),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_html__( 'Subject', 'homerix' ),
				'field' => 'label',
			),
		)
	);

	// Contact Form Shortcode.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'contact_form_shortcode',
			'label'       => esc_html__( 'Custom Form Shortcode', 'homerix' ),
			'description' => esc_html__( 'Enter a shortcode to replace the built-in form (e.g., [contact-form-7 id="123"]). Leave empty to use the built-in form.', 'homerix' ),
			'section'     => 'homerix_contact_us_page_settings',
			'priority'    => 142,
			'default'     => '',
		)
	);

	// Consent Checkbox Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'editor',
			'settings'    => 'contact_form_consent_text',
			'label'       => esc_html__( 'Consent Checkbox Text', 'homerix' ),
			'description' => esc_html__( 'Use {privacy_policy} and {terms_of_service} to insert links. HTML is supported.', 'homerix' ),
			'section'     => 'homerix_contact_us_page_settings',
			'priority'    => 143,
			'default'     => __( 'I agree to the <a href="{terms_of_service}" target="_blank">Terms of Service</a> and <a href="{privacy_policy}" target="_blank">Privacy Policy</a>, and consent to being contacted about my inquiry.', 'homerix' ),
		)
	);

	// Admin Email.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'contact_form_admin_email',
			'label'       => esc_html__( 'Admin Email for Submissions', 'homerix' ),
			'description' => esc_html__( 'Leave empty to use the site admin email.', 'homerix' ),
			'section'     => 'homerix_contact_us_page_settings',
			'priority'    => 144,
			'default'     => '',
		)
	);

	// Success Message.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'textarea',
			'settings' => 'contact_form_success_message',
			'label'    => esc_html__( 'Success Message', 'homerix' ),
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 145,
			'default'  => __( 'Thank you for your message! We will get back to you within 24 hours.', 'homerix' ),
		)
	);

	// ===== MAP SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'contact_map_heading',
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 145,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🗺️ Map & Service Area</h3></div>',
		)
	);

	// Map Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_map_title',
			'label'     => esc_html__( 'Map Section Title', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 150,
			'default'   => __( 'Our Location', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Map Embed URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'text',
			'settings'    => 'contact_map_embed',
			'label'       => esc_html__( 'Google Maps Embed URL', 'homerix' ),
			'description' => esc_html__( 'Paste the src URL from Google Maps embed code', 'homerix' ),
			'section'     => 'homerix_contact_us_page_settings',
			'priority'    => 155,
			'default'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215373510576!2d-73.987844924533!3d40.74844047138911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzU0LjQiTiA3M8KwNTknMTQuMiJX!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus',
			'transport'   => 'postMessage',
		)
	);

	// Service Area Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_service_area_title',
			'label'     => esc_html__( 'Service Area Title', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 160,
			'default'   => __( 'Service Area', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Service Area Description.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'contact_service_area_desc',
			'label'     => esc_html__( 'Service Area Description', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 165,
			'default'   => __( 'We proudly serve the following areas with our home repair services:', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Service Areas List (Repeater).
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'contact_service_areas',
			'label'     => esc_html__( 'Service Areas', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 170,
			'default'   => array(
				array( 'area' => 'Cityville' ),
				array( 'area' => 'Townsville' ),
				array( 'area' => 'Metro County' ),
				array( 'area' => 'North District' ),
				array( 'area' => 'South Borough' ),
				array( 'area' => 'West Township' ),
			),
			'fields'    => array(
				'area' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Area Name', 'homerix' ),
					'default' => '',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Area', 'homerix' ),
				'field' => 'area',
			),
		)
	);

	// Service Area Note.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_area_note',
			'label'     => esc_html__( 'Service Area Note', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 175,
			'default'   => __( '*Some services may not be available in all areas. Call to confirm.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// ===== CTA SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'contact_cta_heading',
			'section'  => 'homerix_contact_us_page_settings',
			'priority' => 200,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🚀 CTA Section</h3></div>',
		)
	);

	// CTA Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_cta_title',
			'label'     => esc_html__( 'CTA Title', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 205,
			'default'   => __( 'Ready to Schedule Your Service?', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'contact_cta_subtitle',
			'label'     => esc_html__( 'CTA Subtitle', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 210,
			'default'   => __( 'Contact us today for fast, reliable home repairs.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Button 1 Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_cta_button1_text',
			'label'     => esc_html__( 'Button 1 Text', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 215,
			'default'   => __( 'Book Online Now', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Button 1 URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_cta_button1_url',
			'label'     => esc_html__( 'Button 1 URL', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 220,
			'default'   => '#booking',
			'transport' => 'postMessage',
		)
	);

	// CTA Button 2 Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_cta_button2_text',
			'label'     => esc_html__( 'Button 2 Text', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 225,
			'default'   => __( 'Call: (555) 123-4567', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Button 2 URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'contact_cta_button2_url',
			'label'     => esc_html__( 'Button 2 URL', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 230,
			'default'   => 'tel:+15551234567',
			'transport' => 'postMessage',
		)
	);

	// CTA Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'contact_cta_bg_color',
			'label'     => esc_html__( 'CTA Background Color', 'homerix' ),
			'section'   => 'homerix_contact_us_page_settings',
			'priority'  => 235,
			'default'   => '#2563EB',
			'transport' => 'postMessage',
		)
	);
}

// Initialize sections and controls.
add_action( 'init', 'homerix_contact_us_page_section' );
add_action( 'init', 'homerix_contact_us_page_controls' );
