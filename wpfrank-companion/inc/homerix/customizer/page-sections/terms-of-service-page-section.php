<?php
/**
 * Homerix Terms of Service Page Settings Customizer
 *
 * Handles all customizer settings for the Terms of Service page.
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
 * Add Terms of Service Page Settings Section
 */
function homerix_terms_of_service_page_section() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-terms-of-service.php' );
	$description = esc_html__( 'Configure the Terms of Service page settings and content.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit Terms of Service Page', 'homerix' ) . '</a>';
	}

	Kirki::add_section(
		'homerix_terms_of_service_page_settings',
		array(
			'title'       => esc_html__( 'Terms of Service Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 40,
		)
	);
}

/**
 * Add Terms of Service Page Controls
 */
function homerix_terms_of_service_page_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'terms_hero_heading',
			'section'  => 'homerix_terms_of_service_page_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'terms_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 10,
			'default'   => __( 'Terms of Service', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'terms_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 20,
			'default'   => __( 'Please read these terms carefully before using our services', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'terms_hero_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
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
			'settings' => 'terms_content_heading',
			'section'  => 'homerix_terms_of_service_page_settings',
			'priority' => 35,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📄 Content Settings</h3></div>',
		)
	);

	// Last Updated Date.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'terms_last_updated',
			'label'     => esc_html__( 'Last Updated Date', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
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
			'settings'  => 'terms_intro_text',
			'label'     => esc_html__( 'Introduction Text', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 45,
			'default'   => __( 'Welcome to Homerix Pro. These Terms of Service ("Terms") govern your use of our website and services. By accessing or using our services, you agree to be bound by these Terms.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Terms Sections Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'terms_sections',
			'label'     => esc_html__( 'Terms Sections', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 50,
			'default'   => array(
				array(
					'title'   => __( 'Acceptance of Terms', 'homerix' ),
					'content' => __( 'By accessing and using Homerix Pro\'s services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.', 'homerix' ),
				),
				array(
					'title'   => __( 'Description of Service', 'homerix' ),
					'content' => __( 'Homerix Pro is a platform that connects homeowners with qualified technicians for home repair and maintenance services. We facilitate the connection between customers and service providers but are not directly responsible for the services performed.', 'homerix' ),
				),
				array(
					'title'   => __( 'User Accounts', 'homerix' ),
					'content' => __( "To use certain features of our service, you must create an account. You agree to:\n• Provide accurate, current, and complete information\n• Maintain and update your information to keep it accurate\n• Maintain the security of your password and account\n• Accept responsibility for all activities under your account\n• Notify us immediately of any unauthorized use of your account", 'homerix' ),
				),
				array(
					'title'   => __( 'User Conduct', 'homerix' ),
					'content' => __( "You agree not to use the service to:\n• Violate any applicable laws or regulations\n• Infringe on the rights of others\n• Transmit harmful, offensive, or inappropriate content\n• Interfere with or disrupt the service or servers\n• Attempt to gain unauthorized access to any part of the service\n• Use the service for any commercial purpose without our consent", 'homerix' ),
				),
				array(
					'title'   => __( 'Service Provider Relationships', 'homerix' ),
					'content' => __( 'Homerix Pro acts as an intermediary between customers and independent service providers. We do not employ the technicians and are not responsible for their actions, work quality, or any damages that may occur during service provision. All service agreements are directly between you and the service provider.', 'homerix' ),
				),
				array(
					'title'   => __( 'Payment Terms', 'homerix' ),
					'content' => __( "Payment terms include:\n• Service fees are determined by individual service providers\n• Platform fees may apply for booking services\n• Payment processing is handled through secure third-party providers\n• Refund policies vary by service provider\n• Disputed charges should be reported within 30 days", 'homerix' ),
				),
				array(
					'title'   => __( 'Intellectual Property', 'homerix' ),
					'content' => __( 'The service and its original content, features, and functionality are owned by Homerix Pro and are protected by international copyright, trademark, patent, trade secret, and other intellectual property laws.', 'homerix' ),
				),
				array(
					'title'   => __( 'Product Licensing', 'homerix' ),
					'content' => __( "All WordPress themes, plugins, and related add-ons distributed by us (including the Homerix theme, Homerix Pro, and WPFrank Companion), whether free or paid, are 100% GPL-compatible and licensed under the GNU General Public License (GPL) version 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html). You are granted full rights to use, modify, and redistribute the software in accordance with the terms of this license.", 'homerix' ),
				),
				array(
					'title'   => __( 'Privacy Policy', 'homerix' ),
					'content' => __( 'Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the service, to understand our practices.', 'homerix' ),
				),
				array(
					'title'   => __( 'Disclaimers', 'homerix' ),
					'content' => __( 'The service is provided "as is" without warranties of any kind. We disclaim all warranties, express or implied, including but not limited to implied warranties of merchantability and fitness for a particular purpose.', 'homerix' ),
				),
				array(
					'title'   => __( 'Limitation of Liability', 'homerix' ),
					'content' => __( 'Homerix Pro shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses.', 'homerix' ),
				),
				array(
					'title'   => __( 'Termination', 'homerix' ),
					'content' => __( 'We may terminate or suspend your account and bar access to the service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever, including without limitation if you breach the Terms.', 'homerix' ),
				),
				array(
					'title'   => __( 'Changes to Terms', 'homerix' ),
					'content' => __( 'We reserve the right to modify or replace these Terms at any time. If a revision is material, we will provide at least 30 days notice prior to any new terms taking effect.', 'homerix' ),
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
			'settings' => 'terms_contact_heading',
			'section'  => 'homerix_terms_of_service_page_settings',
			'priority' => 55,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📞 Contact Information</h3></div>',
		)
	);

	// Contact Section Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'terms_contact_title',
			'label'     => esc_html__( 'Contact Section Title', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 56,
			'default'   => __( 'Contact Information', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Contact Section Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'terms_contact_subtitle',
			'label'     => esc_html__( 'Contact Section Subtitle', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 57,
			'default'   => __( 'If you have any questions about these Terms, please contact us:', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Contact Email.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'terms_contact_email',
			'label'     => esc_html__( 'Contact Email', 'homerix' ),
			'section'   => 'homerix_terms_of_service_page_settings',
			'priority'  => 60,
			'default'   => 'legal@example.com',
			'transport' => 'postMessage',
		)
	);

	// Enable Contact Phone.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'terms_contact_phone_enabled',
			'label'    => esc_html__( 'Show Contact Phone', 'homerix' ),
			'section'  => 'homerix_terms_of_service_page_settings',
			'priority' => 63,
			'default'  => true,
		)
	);

	// Contact Phone.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'terms_contact_phone',
			'label'           => esc_html__( 'Contact Phone', 'homerix' ),
			'section'         => 'homerix_terms_of_service_page_settings',
			'priority'        => 65,
			'default'         => '(555) 123-4567',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'terms_contact_phone_enabled',
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
			'settings' => 'terms_contact_address_enabled',
			'label'    => esc_html__( 'Show Contact Address', 'homerix' ),
			'section'  => 'homerix_terms_of_service_page_settings',
			'priority' => 68,
			'default'  => true,
		)
	);

	// Contact Address.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'terms_contact_address',
			'label'           => esc_html__( 'Contact Address', 'homerix' ),
			'section'         => 'homerix_terms_of_service_page_settings',
			'priority'        => 70,
			'default'         => __( '123 Main Street, City, State 12345', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'terms_contact_address_enabled',
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
			'settings'    => 'terms_additional_content',
			'label'       => esc_html__( 'Additional Content', 'homerix' ),
			'description' => esc_html__( 'Add any additional content below the contact information section.', 'homerix' ),
			'section'     => 'homerix_terms_of_service_page_settings',
			'priority'    => 75,
			'default'     => '',
		)
	);
}

// Initialize functions.
homerix_terms_of_service_page_section();
homerix_terms_of_service_page_controls();
