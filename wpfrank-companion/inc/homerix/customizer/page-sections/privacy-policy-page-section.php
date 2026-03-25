<?php
/**
 * Homerix Privacy Policy Page Settings Customizer
 *
 * Handles all customizer settings for the Privacy Policy page.
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
 * Add Privacy Policy Page Settings Section
 */
function homerix_privacy_policy_page_section() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-privacy-policy.php' );
	$description = esc_html__( 'Configure the Privacy Policy page settings and content.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit Privacy Policy Page', 'homerix' ) . '</a>';
	}

	Kirki::add_section(
		'homerix_privacy_policy_page_settings',
		array(
			'title'       => esc_html__( 'Privacy Policy Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 35,
		)
	);
}

/**
 * Add Privacy Policy Page Controls
 */
function homerix_privacy_policy_page_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'privacy_hero_heading',
			'section'  => 'homerix_privacy_policy_page_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'privacy_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 10,
			'default'   => __( 'Privacy Policy', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'privacy_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 20,
			'default'   => __( 'Your privacy is important to us', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'privacy_hero_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 30,
			'default'   => '#2563EB',
			'transport' => 'postMessage',
		)
	);

	// ===== CONTENT SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'privacy_content_heading',
			'section'  => 'homerix_privacy_policy_page_settings',
			'priority' => 35,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📄 Content Settings</h3></div>',
		)
	);

	// Last Updated Date.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'privacy_last_updated',
			'label'     => esc_html__( 'Last Updated Date', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 40,
			'default'   => __( 'January 1, 2024', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Intro Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'privacy_intro_text',
			'label'     => esc_html__( 'Introduction Text', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 45,
			'default'   => __( 'Homerix Pro ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by Homerix Pro when you use our website and services.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Privacy Sections Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'privacy_sections',
			'label'     => esc_html__( 'Privacy Policy Sections', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 50,
			'default'   => array(
				array(
					'title'   => __( 'Information We Collect', 'homerix' ),
					'content' => __( "We may collect personal information that you provide to us, including:\n• Name and contact information (email address, phone number, mailing address)\n• Account credentials (username and password)\n• Payment information (credit card details, billing address)\n• Service preferences and requirements\n• Communication records and feedback\n\nWe also automatically collect device information, usage data, location information (with consent), and cookies.", 'homerix' ),
				),
				array(
					'title'   => __( 'How We Use Your Information', 'homerix' ),
					'content' => __( "We use the information we collect to:\n• Provide and maintain our services\n• Process transactions and send related information\n• Connect you with qualified technicians\n• Send you technical notices, updates, and support messages\n• Respond to your comments, questions, and customer service requests\n• Communicate with you about products, services, and promotional offers\n• Monitor and analyze trends, usage, and activities\n• Detect, investigate, and prevent fraudulent transactions", 'homerix' ),
				),
				array(
					'title'   => __( 'Information Sharing and Disclosure', 'homerix' ),
					'content' => __( 'We may share your information with qualified technicians and service providers to fulfill your service requests. We may also share information with third-party vendors who perform services on our behalf, such as payment processing, data analysis, and customer service. We may disclose your information if required by law or in response to valid requests by public authorities.', 'homerix' ),
				),
				array(
					'title'   => __( 'Data Security', 'homerix' ),
					'content' => __( 'We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure.', 'homerix' ),
				),
				array(
					'title'   => __( 'Your Rights and Choices', 'homerix' ),
					'content' => __( "You have the right to:\n• Access and update your personal information\n• Request deletion of your personal information\n• Opt-out of marketing communications\n• Disable cookies through your browser settings\n• Request a copy of your personal information", 'homerix' ),
				),
				array(
					'title'   => __( 'Cookies and Tracking Technologies', 'homerix' ),
					'content' => __( 'We use cookies and similar tracking technologies to collect and use personal information about you. You can control cookies through your browser settings and other tools.', 'homerix' ),
				),
				array(
					'title'   => __( "Children's Privacy", 'homerix' ),
					'content' => __( 'Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.', 'homerix' ),
				),
				array(
					'title'   => __( 'Changes to This Privacy Policy', 'homerix' ),
					'content' => __( 'We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.', 'homerix' ),
				),
			),
			'fields'    => array(
				'title'   => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Section Title', 'homerix' ),
					'default' => '',
				),
				'content' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Section Content', 'homerix' ),
					'description' => esc_html__( 'Use bullet points with • for lists', 'homerix' ),
					'default'     => '',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Section', 'homerix' ),
				'field' => 'title',
			),
		)
	);

	// ===== CONTACT SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'privacy_contact_heading',
			'section'  => 'homerix_privacy_policy_page_settings',
			'priority' => 55,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📞 Contact Information</h3></div>',
		)
	);

	// Contact Section Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'privacy_contact_title',
			'label'     => esc_html__( 'Contact Section Title', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 56,
			'default'   => __( 'Contact Us', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Contact Section Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'privacy_contact_subtitle',
			'label'     => esc_html__( 'Contact Section Subtitle', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 57,
			'default'   => __( 'If you have any questions about this Privacy Policy, please contact us:', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Contact Email.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'privacy_contact_email',
			'label'     => esc_html__( 'Contact Email', 'homerix' ),
			'section'   => 'homerix_privacy_policy_page_settings',
			'priority'  => 60,
			'default'   => 'privacy@Homerixpro.com',
			'transport' => 'postMessage',
		)
	);

	// Enable Contact Phone.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'privacy_contact_phone_enabled',
			'label'    => esc_html__( 'Show Contact Phone', 'homerix' ),
			'section'  => 'homerix_privacy_policy_page_settings',
			'priority' => 63,
			'default'  => true,
		)
	);

	// Contact Phone.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'privacy_contact_phone',
			'label'           => esc_html__( 'Contact Phone', 'homerix' ),
			'section'         => 'homerix_privacy_policy_page_settings',
			'priority'        => 65,
			'default'         => '(555) 123-4567',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'privacy_contact_phone_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable Contact Address.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'privacy_contact_address_enabled',
			'label'    => esc_html__( 'Show Contact Address', 'homerix' ),
			'section'  => 'homerix_privacy_policy_page_settings',
			'priority' => 68,
			'default'  => true,
		)
	);

	// Contact Address.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'privacy_contact_address',
			'label'           => esc_html__( 'Contact Address', 'homerix' ),
			'section'         => 'homerix_privacy_policy_page_settings',
			'priority'        => 70,
			'default'         => __( '123 Main Street, City, State 12345', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'privacy_contact_address_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Additional Content (Editor).
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'editor',
			'settings'    => 'privacy_additional_content',
			'label'       => esc_html__( 'Additional Content', 'homerix' ),
			'description' => esc_html__( 'Add any additional content below the contact information section.', 'homerix' ),
			'section'     => 'homerix_privacy_policy_page_settings',
			'priority'    => 75,
			'default'     => '',
		)
	);
}

// Initialize functions.
homerix_privacy_policy_page_section();
homerix_privacy_policy_page_controls();
