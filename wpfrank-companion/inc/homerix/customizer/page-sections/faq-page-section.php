<?php
/**
 * Homerix FAQ Page Settings Customizer
 *
 * Handles all customizer settings for the FAQ page.
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
 * Add FAQ Page Settings Section
 */
function homerix_faq_page_section() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-faq.php' );
	$description = esc_html__( 'Configure the FAQ page settings and appearance.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit FAQ Page', 'homerix' ) . '</a>';
	}

	// Main FAQ Page Settings Section.
	Kirki::add_section(
		'homerix_faq_page_settings',
		array(
			'title'       => esc_html__( 'FAQ Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 30,
		)
	);
}

/**
 * Add FAQ Page Controls
 */
function homerix_faq_page_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'faq_hero_heading',
			'section'  => 'homerix_faq_page_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'faq_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 10,
			'default'   => __( 'Frequently Asked Questions', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'faq_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 20,
			'default'   => __( 'Find answers to common questions about our services', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'faq_hero_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 30,
			'default'   => '#2563EB',
			'transport' => 'postMessage',
		)
	);

	// ===== FAQ CATEGORIES HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'faq_categories_heading',
			'section'  => 'homerix_faq_page_settings',
			'priority' => 35,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">📂 FAQ Categories</h3></div>',
		)
	);

	// FAQ Categories Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'faq_categories',
			'label'     => esc_html__( 'FAQ Categories', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 40,
			'default'   => array(
				array(
					'name' => __( 'Booking', 'homerix' ),
					'slug' => 'booking',
				),
				array(
					'name' => __( 'Payment', 'homerix' ),
					'slug' => 'payment',
				),
				array(
					'name' => __( 'Technicians', 'homerix' ),
					'slug' => 'technicians',
				),
				array(
					'name' => __( 'Services', 'homerix' ),
					'slug' => 'services',
				),
			),
			'fields'    => array(
				'name' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Category Name', 'homerix' ),
					'default' => '',
				),
				'slug' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Category Slug', 'homerix' ),
					'description' => esc_html__( 'Lowercase, no spaces (e.g., booking)', 'homerix' ),
					'default'     => '',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Category', 'homerix' ),
				'field' => 'name',
			),
		)
	);

	// ===== FAQ ITEMS HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'faq_items_heading',
			'section'  => 'homerix_faq_page_settings',
			'priority' => 45,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">❓ FAQ Items</h3></div>',
		)
	);

	// FAQ Items Repeater.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'faq_items',
			'label'     => esc_html__( 'FAQ Items', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 50,
			'default'   => array(
				array(
					'question' => __( 'How do I book a service?', 'homerix' ),
					'answer'   => __( 'You can book a service by clicking the "Book Now" button, selecting your service type, choosing a technician, and scheduling an appointment. You\'ll receive confirmation via email and SMS.', 'homerix' ),
					'category' => 'booking',
				),
				array(
					'question' => __( 'Can I cancel or reschedule my appointment?', 'homerix' ),
					'answer'   => __( 'Yes, you can cancel or reschedule your appointment up to 24 hours before the scheduled time without any fees. For cancellations within 24 hours, a small fee may apply.', 'homerix' ),
					'category' => 'booking',
				),
				array(
					'question' => __( 'How far in advance can I book?', 'homerix' ),
					'answer'   => __( 'You can book services up to 30 days in advance. For urgent repairs, we also offer same-day and next-day appointments based on technician availability.', 'homerix' ),
					'category' => 'booking',
				),
				array(
					'question' => __( 'What payment methods do you accept?', 'homerix' ),
					'answer'   => __( 'We accept all major credit cards (Visa, MasterCard, American Express), debit cards, PayPal, and bank transfers. Payment is processed securely through our platform.', 'homerix' ),
					'category' => 'payment',
				),
				array(
					'question' => __( 'When do I pay for the service?', 'homerix' ),
					'answer'   => __( 'Payment is typically made after the service is completed and you\'re satisfied with the work. Some technicians may require a deposit for large jobs or expensive materials.', 'homerix' ),
					'category' => 'payment',
				),
				array(
					'question' => __( 'Are your technicians licensed and insured?', 'homerix' ),
					'answer'   => __( 'Yes, all technicians on our platform are required to have proper licensing, insurance, and background checks. We verify their credentials before they can offer services through Homerix Pro.', 'homerix' ),
					'category' => 'technicians',
				),
				array(
					'question' => __( 'How do you vet your technicians?', 'homerix' ),
					'answer'   => __( 'Our vetting process includes background checks, license verification, insurance confirmation, reference checks, and skills assessments. We also monitor customer reviews and ratings continuously.', 'homerix' ),
					'category' => 'technicians',
				),
				array(
					'question' => __( 'What types of services do you offer?', 'homerix' ),
					'answer'   => __( 'We offer a wide range of home repair and maintenance services including plumbing, electrical work, HVAC, carpentry, painting, appliance repair, and general handyman services.', 'homerix' ),
					'category' => 'services',
				),
				array(
					'question' => __( 'Do you offer emergency services?', 'homerix' ),
					'answer'   => __( 'Yes, we offer 24/7 emergency services for urgent issues like burst pipes, electrical emergencies, and HVAC failures. Emergency services may have additional fees.', 'homerix' ),
					'category' => 'services',
				),
				array(
					'question' => __( 'What if I\'m not satisfied with the work?', 'homerix' ),
					'answer'   => __( 'We have a satisfaction guarantee. If you\'re not happy with the work, contact us within 48 hours and we\'ll work with the technician to resolve the issue or arrange for another qualified professional to fix it.', 'homerix' ),
					'category' => 'services',
				),
				array(
					'question' => __( 'How do I contact customer support?', 'homerix' ),
					'answer'   => __( 'You can contact our customer support team via phone at (555) 123-4567, email at support@example.com, or through the live chat feature on our website. We\'re available 24/7.', 'homerix' ),
					'category' => 'general',
				),
				array(
					'question' => __( 'Do you serve my area?', 'homerix' ),
					'answer'   => __( 'We currently serve major metropolitan areas across the United States. Enter your zip code on our website to check if we serve your area and see available technicians nearby.', 'homerix' ),
					'category' => 'general',
				),
			),
			'fields'    => array(
				'question' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Question', 'homerix' ),
					'default' => '',
				),
				'answer'   => array(
					'type'    => 'textarea',
					'label'   => esc_html__( 'Answer', 'homerix' ),
					'default' => '',
				),
				'category' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Category Slug', 'homerix' ),
					'description' => esc_html__( 'Must match a category slug from above', 'homerix' ),
					'default'     => 'general',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'FAQ', 'homerix' ),
				'field' => 'question',
			),
		)
	);

	// ===== CTA SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'faq_cta_heading',
			'section'  => 'homerix_faq_page_settings',
			'priority' => 55,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🚀 Still Have Questions CTA</h3></div>',
		)
	);

	// CTA Title.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'faq_cta_title',
			'label'     => esc_html__( 'CTA Title', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 60,
			'default'   => __( 'Still have questions?', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Description.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'faq_cta_description',
			'label'     => esc_html__( 'CTA Description', 'homerix' ),
			'section'   => 'homerix_faq_page_settings',
			'priority'  => 65,
			'default'   => __( "Can't find the answer you're looking for? Our customer support team is here to help.", 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Enable Contact Support Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'faq_cta_button_enabled',
			'label'    => esc_html__( 'Enable Contact Support Button', 'homerix' ),
			'section'  => 'homerix_faq_page_settings',
			'priority' => 68,
			'default'  => true,
		)
	);

	// CTA Button Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'faq_cta_button_text',
			'label'           => esc_html__( 'Button Text', 'homerix' ),
			'section'         => 'homerix_faq_page_settings',
			'priority'        => 70,
			'default'         => __( 'Contact Support', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'faq_cta_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Button URL.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'faq_cta_button_url',
			'label'           => esc_html__( 'Button URL', 'homerix' ),
			'section'         => 'homerix_faq_page_settings',
			'priority'        => 75,
			'default'         => '/homerix-contact-us/',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'faq_cta_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Enable Phone Button.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'faq_cta_phone_enabled',
			'label'    => esc_html__( 'Enable Phone Button', 'homerix' ),
			'section'  => 'homerix_faq_page_settings',
			'priority' => 78,
			'default'  => true,
		)
	);

	// CTA Phone Text.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'faq_cta_phone_text',
			'label'           => esc_html__( 'Phone Button Text', 'homerix' ),
			'section'         => 'homerix_faq_page_settings',
			'priority'        => 80,
			'default'         => __( 'Call (555) 123-4567', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'faq_cta_phone_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Phone Number.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'faq_cta_phone_url',
			'label'           => esc_html__( 'Phone URL', 'homerix' ),
			'section'         => 'homerix_faq_page_settings',
			'priority'        => 85,
			'default'         => 'tel:+15551234567',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'faq_cta_phone_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

// Initialize functions.
homerix_faq_page_section();
homerix_faq_page_controls();

