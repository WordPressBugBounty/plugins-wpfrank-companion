<?php
/**
 * Homerix About Us Page Settings Customizer
 *
 * Handles all customizer settings for the About Us page.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add About Us Page Settings Section
 */
function homerix_about_us_page_section() {
	$page_url    = homerix_get_page_url_by_template( 'page-templates/page-about-us.php' );
	$description = esc_html__( 'Configure the About Us page settings and appearance.', 'homerix' );
	if ( $page_url ) {
		$description .= ' <a href="' . esc_url( $page_url ) . '" class="homerix-customize-navigate">' . esc_html__( 'Visit About Us Page', 'homerix' ) . '</a>';
	}

	// Main About Us Page Settings Section
	Kirki::add_section(
		'homerix_about_us_settings',
		array(
			'title'       => esc_html__( 'About Us Page Settings', 'homerix' ),
			'description' => $description,
			'panel'       => 'homerix_pages_settings',
			'priority'    => 15,
		)
	);
}

/**
 * Add About Us Page Controls
 */
function homerix_about_us_page_controls() {

	// ===== HERO SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_hero_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 5,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Hero Section</h3></div>',
		)
	);

	// Hero Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_hero_title',
			'label'     => esc_html__( 'Hero Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 10,
			'default'   => __( 'Our Story', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_hero_subtitle',
			'label'     => esc_html__( 'Hero Subtitle', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 20,
			'default'   => __( 'Building trust one repair at a time since 2010', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Hero Button Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'        => 'toggle',
			'settings'    => 'about_hero_button_enabled',
			'label'       => esc_html__( 'Show Hero Button', 'homerix' ),
			'description' => esc_html__( 'Enable/disable the hero section button.', 'homerix' ),
			'section'     => 'homerix_about_us_settings',
			'priority'    => 25,
			'default'     => true,
		)
	);

	// Hero Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_hero_button_text',
			'label'           => esc_html__( 'Button Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 30,
			'default'         => __( 'Learn About Our Mission', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_hero_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_hero_button_url',
			'label'           => esc_html__( 'Button URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 40,
			'default'         => '#our-mission',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_hero_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Hero Background Color
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'about_hero_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 50,
			'default'   => '#2563EB',
			'transport' => 'postMessage',
			'output'    => array(
				array(
					'element'  => '.about-hero',
					'property' => 'background-color',
				),
			),
		)
	);

	// Hero Background Image
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'image',
			'settings'  => 'about_hero_bg_image',
			'label'     => esc_html__( 'Background Image (Optional)', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 60,
			'default'   => get_template_directory_uri() . '/assets/img/about-bg.jpg',
			'transport' => 'postMessage',
		)
	);

	// Hero Overlay Enabled.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_hero_overlay_enabled',
			'label'    => esc_html__( 'Enable Hero Overlay', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 61,
			'default'  => true,
		)
	);

	// Hero Overlay Opacity.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'slider',
			'settings'        => 'about_hero_overlay_opacity',
			'label'           => esc_html__( 'Hero Overlay Opacity (%)', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 62,
			'default'         => 40,
			'choices'         => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
			),
			'active_callback' => array(
				array(
					'setting'  => 'about_hero_overlay_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== MISSION SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_mission_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 65,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Our Mission Section</h3></div>',
		)
	);

	// Mission Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_mission_title',
			'label'     => esc_html__( 'Mission Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 70,
			'default'   => __( 'Our Mission', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Mission Image
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'image',
			'settings'  => 'about_mission_image',
			'label'     => esc_html__( 'Mission Image', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 80,
			'default'   => get_template_directory_uri() . '/assets/img/about-3.jpg',
			'transport' => 'postMessage',
		)
	);

	// Mission Text 1
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_mission_text_1',
			'label'     => esc_html__( 'Mission Text 1', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 90,
			'default'   => __( 'At Homerix Pro, we believe every homeowner deserves access to reliable, affordable home repair services from professionals they can trust.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Mission Text 2
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_mission_text_2',
			'label'     => esc_html__( 'Mission Text 2', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 100,
			'default'   => __( 'Founded in 2010 by master plumber Michael Johnson, what began as a one-man operation has grown into the area\'s most trusted home repair service with over 50 technicians serving thousands of satisfied customers.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Mission Text 3
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_mission_text_3',
			'label'     => esc_html__( 'Mission Text 3', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 110,
			'default'   => __( 'We\'re not just fixing homes - we\'re restoring peace of mind by delivering quality workmanship, transparent pricing, and exceptional customer service.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Mission Button 1 Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_mission_button1_enabled',
			'label'    => esc_html__( 'Show Mission Button 1', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 115,
			'default'  => true,
		)
	);

	// Mission Button 1 Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_mission_button1_text',
			'label'           => esc_html__( 'Button 1 Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 120,
			'default'         => __( 'Book a Service', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_mission_button1_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Mission Button 1 URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_mission_button1_url',
			'label'           => esc_html__( 'Button 1 URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 130,
			'default'         => '#booking',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_mission_button1_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Mission Button 2 Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_mission_button2_enabled',
			'label'    => esc_html__( 'Show Mission Button 2', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 135,
			'default'  => true,
		)
	);

	// Mission Button 2 Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_mission_button2_text',
			'label'           => esc_html__( 'Button 2 Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 140,
			'default'         => __( 'Meet Our Team', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_mission_button2_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Mission Button 2 URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_mission_button2_url',
			'label'           => esc_html__( 'Button 2 URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 150,
			'default'         => '#our-team',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_mission_button2_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== TIMELINE SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_timeline_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 155,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Our Journey Timeline</h3></div>',
		)
	);

	// Timeline Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_timeline_title',
			'label'     => esc_html__( 'Timeline Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 160,
			'default'   => __( 'Our Journey', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Timeline Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_timeline_subtitle',
			'label'     => esc_html__( 'Timeline Subtitle', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 170,
			'default'   => __( 'From humble beginnings to becoming your trusted home repair partner', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Timeline Items Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'about_timeline_items',
			'label'     => esc_html__( 'Timeline Items', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 180,
			'default'   => array(
				array(
					'icon'        => 'fas fa-lightbulb',
					'year'        => '2010',
					'title'       => 'The Beginning',
					'description' => 'Michael Johnson starts Homerix Pro as a solo plumbing service.',
				),
				array(
					'icon'        => 'fas fa-users',
					'year'        => '2013',
					'title'       => 'Team Expansion',
					'description' => 'Grew to 10 technicians covering plumbing, electrical, and HVAC services.',
				),
				array(
					'icon'        => 'fas fa-award',
					'year'        => '2016',
					'title'       => 'Industry Recognition',
					'description' => 'Received "Best Home Services Provider" award from the local chamber of commerce.',
				),
				array(
					'icon'        => 'fas fa-mobile-alt',
					'year'        => '2019',
					'title'       => 'Digital Innovation',
					'description' => 'Launched our online booking platform and mobile app for customer convenience.',
				),
				array(
					'icon'        => 'fas fa-heart',
					'year'        => '2021',
					'title'       => 'Community Focus',
					'description' => 'Started Homerix Cares program, providing free repairs to families in need.',
				),
				array(
					'icon'        => 'fas fa-rocket',
					'year'        => '2023',
					'title'       => 'Continued Growth',
					'description' => 'Now serving over 5,000 customers annually with a team of 50+ certified technicians.',
				),
			),
			'fields'    => array(
				'icon'        => array(
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
					'default'     => 'fas fa-star',
				),
				'year'        => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Year', 'homerix' ),
					'default' => '2023',
				),
				'title'       => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title', 'homerix' ),
					'default' => '',
				),
				'description' => array(
					'type'    => 'textarea',
					'label'   => esc_html__( 'Description', 'homerix' ),
					'default' => '',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Title', 'homerix' ),
				'field' => 'title',
			),
		)
	);

	// ===== TEAM SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_team_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 185,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Leadership Team</h3></div>',
		)
	);

	// Team Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_team_title',
			'label'     => esc_html__( 'Team Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 190,
			'default'   => __( 'Meet Our Leadership Team', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Team Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_team_subtitle',
			'label'     => esc_html__( 'Team Subtitle', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 200,
			'default'   => __( 'The dedicated professionals behind Homerix Pro', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Team Members Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'about_team_members',
			'label'     => esc_html__( 'Team Members', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 210,
			'default'   => array(
				array(
					'image'       => get_template_directory_uri() . '/assets/img/customer-1.jpg',
					'name'        => 'Michael Johnson',
					'position'    => 'Founder & CEO',
					'description' => 'Master plumber with 25+ years of experience. Michael founded Homerix Pro with a vision to provide honest, reliable home repair services.',
					'linkedin'    => '#',
					'email'       => 'michael@example.com',
				),
				array(
					'image'       => get_template_directory_uri() . '/assets/img/customer-2.jpg',
					'name'        => 'Sarah Chen',
					'position'    => 'Operations Director',
					'description' => 'Sarah ensures every job runs smoothly and every customer receives exceptional service. 15 years in operations management.',
					'linkedin'    => '#',
					'email'       => 'sarah@example.com',
				),
				array(
					'image'       => get_template_directory_uri() . '/assets/img/customer-3.jpg',
					'name'        => 'David Rodriguez',
					'position'    => 'Lead Electrician',
					'description' => 'Licensed master electrician with expertise in residential and commercial electrical systems. 20 years of experience.',
					'linkedin'    => '#',
					'email'       => 'david@example.com',
				),
				array(
					'image'       => get_template_directory_uri() . '/assets/img/customer-1.jpg',
					'name'        => 'Emily Wilson',
					'position'    => 'Customer Success Manager',
					'description' => 'Emily leads our customer service team, ensuring every client has a positive experience from booking to completion.',
					'linkedin'    => '#',
					'email'       => 'emily@example.com',
				),
			),
			'fields'    => array(
				'image'       => array(
					'type'    => 'image',
					'label'   => esc_html__( 'Photo', 'homerix' ),
					'default' => '',
				),
				'name'        => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Name', 'homerix' ),
					'default' => '',
				),
				'position'    => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Position', 'homerix' ),
					'default' => '',
				),
				'description' => array(
					'type'    => 'textarea',
					'label'   => esc_html__( 'Description', 'homerix' ),
					'default' => '',
				),
				'linkedin'    => array(
					'type'    => 'text',
					'label'   => esc_html__( 'LinkedIn URL', 'homerix' ),
					'default' => '',
				),
				'email'       => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Email', 'homerix' ),
					'default' => '',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Name', 'homerix' ),
				'field' => 'name',
			),
		)
	);

	// Team Bottom Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_team_bottom_text',
			'label'     => esc_html__( 'Bottom Text', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 220,
			'default'   => __( 'Want to join our team? We\'re always looking for talented, passionate professionals.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Team Button Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_team_button_enabled',
			'label'    => esc_html__( 'Show Team Button', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 225,
			'default'  => true,
		)
	);

	// Team Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_team_button_text',
			'label'           => esc_html__( 'Button Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 230,
			'default'         => __( 'View Career Opportunities', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_team_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Team Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_team_button_url',
			'label'           => esc_html__( 'Button URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 240,
			'default'         => '#careers',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_team_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// ===== VALUES SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_values_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 245,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Core Values</h3></div>',
		)
	);

	// Values Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_values_title',
			'label'     => esc_html__( 'Values Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 250,
			'default'   => __( 'Our Core Values', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Values Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_values_subtitle',
			'label'     => esc_html__( 'Values Subtitle', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 260,
			'default'   => __( 'The principles that guide everything we do', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Values Items Repeater
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'repeater',
			'settings'  => 'about_values_items',
			'label'     => esc_html__( 'Values', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 270,
			'default'   => array(
				array(
					'icon'        => 'fas fa-shield-alt',
					'icon_color'  => '#2563EB',
					'title'       => 'Integrity',
					'description' => 'We believe in honest pricing, transparent communication, and doing what\'s right for our customers.',
				),
				array(
					'icon'        => 'fas fa-star',
					'icon_color'  => '#eab308',
					'title'       => 'Excellence',
					'description' => 'We strive for perfection in every repair, using quality materials and proven techniques.',
				),
				array(
					'icon'        => 'fas fa-heart',
					'icon_color'  => '#ef4444',
					'title'       => 'Community',
					'description' => 'We\'re committed to giving back and supporting the neighborhoods we serve.',
				),
				array(
					'icon'        => 'fas fa-lightbulb',
					'icon_color'  => '#a855f7',
					'title'       => 'Innovation',
					'description' => 'We embrace new technologies and methods to provide better, faster service.',
				),
				array(
					'icon'        => 'fas fa-users',
					'icon_color'  => '#22c55e',
					'title'       => 'Teamwork',
					'description' => 'Our success comes from collaboration, respect, and supporting each other.',
				),
				array(
					'icon'        => 'fas fa-clock',
					'icon_color'  => '#f97316',
					'title'       => 'Reliability',
					'description' => 'We show up on time, complete jobs as promised, and stand behind our work.',
				),
			),
			'row_label' => array(
				'type'  => 'field',
				'value' => esc_html__( 'Value', 'homerix' ),
				'field' => 'title',
			),
			'fields'    => array(
				'icon'        => array(
					'type'    => 'iconpicker',
					'label'   => esc_html__( 'Icon Class (Font Awesome)', 'homerix' ),
					'default' => 'fas fa-star',
				),
				'icon_color'  => array(
					'type'        => 'color',
					'label'       => esc_html__( 'Icon Color', 'homerix' ),
					'description' => esc_html__( 'Icon fill color. A lighter version will be used as background.', 'homerix' ),
					'default'     => '#2563EB',
				),
				'title'       => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title', 'homerix' ),
					'default' => '',
				),
				'description' => array(
					'type'    => 'textarea',
					'label'   => esc_html__( 'Description', 'homerix' ),
					'default' => '',
				),
			),
		)
	);

	// ===== COMMUNITY SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_community_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 275,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Community Involvement</h3></div>',
		)
	);

	// Community Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_community_title',
			'label'     => esc_html__( 'Community Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 280,
			'default'   => __( 'Giving Back to Our Community', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Community Text 1
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_community_text_1',
			'label'     => esc_html__( 'Community Text 1', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 290,
			'default'   => __( 'At Homerix Pro, we believe in supporting the communities that support us.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Community Text 2
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_community_text_2',
			'label'     => esc_html__( 'Community Text 2', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 300,
			'default'   => __( 'Each year, we donate hundreds of hours of free repair services to local shelters, community centers, and families in need through our Homerix Cares program.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Community Text 3
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_community_text_3',
			'label'     => esc_html__( 'Community Text 3', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 310,
			'default'   => __( 'We also partner with vocational schools to train the next generation of skilled tradespeople through our apprenticeship program.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// Community Button Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_community_button_enabled',
			'label'    => esc_html__( 'Show Community Button', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 315,
			'default'  => true,
		)
	);

	// Community Button Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_community_button_text',
			'label'           => esc_html__( 'Button Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 320,
			'default'         => __( 'Learn About Our Community Programs', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_community_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Community Button URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_community_button_url',
			'label'           => esc_html__( 'Button URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 330,
			'default'         => '#',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_community_button_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// Community Image
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'image',
			'settings'  => 'about_community_image',
			'label'     => esc_html__( 'Community Image', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 340,
			'default'   => get_template_directory_uri() . '/assets/img/about-3.jpg',
			'transport' => 'postMessage',
		)
	);

	// ===== CTA SECTION HEADING =====
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'custom',
			'settings' => 'about_cta_heading',
			'section'  => 'homerix_about_us_settings',
			'priority' => 345,
			'default'  => '<div style="padding: 5px 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; margin: 15px 0 5px 0;"><h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">🎯 Call to Action</h3></div>',
		)
	);

	// CTA Title
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'text',
			'settings'  => 'about_cta_title',
			'label'     => esc_html__( 'CTA Title', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 350,
			'default'   => __( 'Ready to Experience the Homerix Pro Difference?', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Subtitle
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'textarea',
			'settings'  => 'about_cta_subtitle',
			'label'     => esc_html__( 'CTA Subtitle', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 360,
			'default'   => __( 'Join thousands of satisfied customers who trust us with their home repair needs.', 'homerix' ),
			'transport' => 'postMessage',
		)
	);

	// CTA Button 1 Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_cta_button1_enabled',
			'label'    => esc_html__( 'Show CTA Button 1', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 365,
			'default'  => true,
		)
	);

	// CTA Button 1 Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_cta_button1_text',
			'label'           => esc_html__( 'Button 1 Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 370,
			'default'         => __( 'Book a Service', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_cta_button1_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Button 1 URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_cta_button1_url',
			'label'           => esc_html__( 'Button 1 URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 380,
			'default'         => '#booking',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_cta_button1_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Button 2 Enabled
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'     => 'toggle',
			'settings' => 'about_cta_button2_enabled',
			'label'    => esc_html__( 'Show CTA Button 2', 'homerix' ),
			'section'  => 'homerix_about_us_settings',
			'priority' => 385,
			'default'  => true,
		)
	);

	// CTA Button 2 Text
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_cta_button2_text',
			'label'           => esc_html__( 'Button 2 Text', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 390,
			'default'         => __( 'Call: (555) 123-4567', 'homerix' ),
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_cta_button2_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Button 2 URL
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'            => 'text',
			'settings'        => 'about_cta_button2_url',
			'label'           => esc_html__( 'Button 2 URL', 'homerix' ),
			'section'         => 'homerix_about_us_settings',
			'priority'        => 400,
			'default'         => 'tel:+15551234567',
			'transport'       => 'postMessage',
			'active_callback' => array(
				array(
					'setting'  => 'about_cta_button2_enabled',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	// CTA Background Color.
	Kirki::add_field(
		'homerix_theme_config',
		array(
			'type'      => 'color',
			'settings'  => 'about_cta_bg_color',
			'label'     => esc_html__( 'Background Color', 'homerix' ),
			'section'   => 'homerix_about_us_settings',
			'priority'  => 410,
			'default'   => '#2563EB',
			'transport' => 'postMessage',
		)
	);
}

// Initialize sections and controls
add_action( 'init', 'homerix_about_us_page_section' );
add_action( 'init', 'homerix_about_us_page_controls' );


