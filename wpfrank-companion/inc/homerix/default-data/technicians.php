<?php
/**
 * Homerix Default Technicians Data
 *
 * Initializes default technician data for the Find Technician page.
 * Free version: 4 default technicians (within free limit).
 * Pro active: 15 default technicians (with pagination).
 *
 * IMPORTANT: Defaults are only seeded when NO data exists.
 * Customer-saved data is never overwritten.
 *
 * @package Homerix_Pro
 * @since   1.2.0
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the full list of default technicians.
 *
 * @since 1.3.0
 * @return array Full list of 15 default technicians.
 */
function homerix_get_all_default_technicians() {
	$theme_url = HOMERIX_URI;
	return array(
		array(
			'tech_name'         => 'Michael Johnson',
			'tech_specialty'    => 'Licensed Plumber',
			'tech_image'        => $theme_url . '/assets/img/customer-2.jpg',
			'tech_experience'   => 'Plumbing, Repairs, Installation',
			'tech_service_area' => 'downtown',
			'tech_bio'          => 'Experienced plumber with 15+ years in residential and commercial plumbing.',
			'tech_service'      => 'plumbing',
		),
		array(
			'tech_name'         => 'Sarah Williams',
			'tech_specialty'    => 'Electrical Specialist',
			'tech_image'        => $theme_url . '/assets/img/customer-3.jpg',
			'tech_experience'   => 'Electrical, Wiring, Troubleshooting',
			'tech_service_area' => 'midtown',
			'tech_bio'          => 'Certified electrician with expertise in residential and commercial electrical systems.',
			'tech_service'      => 'electrical',
		),
		array(
			'tech_name'         => 'David Martinez',
			'tech_specialty'    => 'HVAC Technician',
			'tech_image'        => $theme_url . '/assets/img/customer-1.jpg',
			'tech_experience'   => 'HVAC, Maintenance, Installation',
			'tech_service_area' => 'suburbs',
			'tech_bio'          => 'Expert HVAC technician with 12+ years of experience in heating and cooling systems.',
			'tech_service'      => 'hvac',
		),
		array(
			'tech_name'         => 'James Anderson',
			'tech_specialty'    => 'General Handyman',
			'tech_image'        => $theme_url . '/assets/img/customer-2.jpg',
			'tech_experience'   => 'Repairs, Maintenance, Carpentry',
			'tech_service_area' => 'north',
			'tech_bio'          => 'Versatile handyman skilled in various home repair and maintenance tasks.',
			'tech_service'      => 'handyman',
		),
		array(
			'tech_name'         => 'Emily Chen',
			'tech_specialty'    => 'Plumbing Expert',
			'tech_image'        => $theme_url . '/assets/img/customer-2.jpg',
			'tech_experience'   => 'Plumbing, Leak Detection, Drain Cleaning',
			'tech_service_area' => 'south',
			'tech_bio'          => 'Specialized in residential plumbing with focus on leak detection and prevention.',
			'tech_service'      => 'plumbing',
		),
		array(
			'tech_name'         => 'Robert Taylor',
			'tech_specialty'    => 'Electrical Contractor',
			'tech_image'        => $theme_url . '/assets/img/customer-3.jpg',
			'tech_experience'   => 'Electrical, Panel Upgrades, Safety Inspections',
			'tech_service_area' => 'downtown',
			'tech_bio'          => 'Licensed electrical contractor with expertise in panel upgrades and safety inspections.',
			'tech_service'      => 'electrical',
		),
		array(
			'tech_name'         => 'Lisa Thompson',
			'tech_specialty'    => 'HVAC Specialist',
			'tech_image'        => $theme_url . '/assets/img/customer-1.jpg',
			'tech_experience'   => 'HVAC, Energy Efficiency, Maintenance',
			'tech_service_area' => 'midtown',
			'tech_bio'          => 'HVAC specialist focused on energy-efficient solutions and preventive maintenance.',
			'tech_service'      => 'hvac',
		),
		array(
			'tech_name'         => 'Christopher Lee',
			'tech_specialty'    => 'Master Plumber',
			'tech_image'        => $theme_url . '/assets/img/customer-2.jpg',
			'tech_experience'   => 'Plumbing, Water Heaters, Sewer Lines',
			'tech_service_area' => 'suburbs',
			'tech_bio'          => 'Master plumber with extensive experience in complex plumbing installations.',
			'tech_service'      => 'plumbing',
		),
		array(
			'tech_name'         => 'Amanda Rodriguez',
			'tech_specialty'    => 'Electrical Technician',
			'tech_image'        => $theme_url . '/assets/img/customer-3.jpg',
			'tech_experience'   => 'Electrical, Lighting, Smart Home',
			'tech_service_area' => 'north',
			'tech_bio'          => 'Skilled electrician specializing in modern lighting and smart home installations.',
			'tech_service'      => 'electrical',
		),
		array(
			'tech_name'         => 'Kevin Brown',
			'tech_specialty'    => 'HVAC Master',
			'tech_image'        => $theme_url . '/assets/img/customer-1.jpg',
			'tech_experience'   => 'HVAC, Ductwork, Thermostat Installation',
			'tech_service_area' => 'south',
			'tech_bio'          => 'Master HVAC technician with expertise in ductwork and system optimization.',
			'tech_service'      => 'hvac',
		),
		array(
			'tech_name'         => 'Jessica White',
			'tech_specialty'    => 'Plumbing Technician',
			'tech_image'        => $theme_url . '/assets/img/customer-2.jpg',
			'tech_experience'   => 'Plumbing, Fixtures, Bathroom Remodeling',
			'tech_service_area' => 'downtown',
			'tech_bio'          => 'Experienced plumber specializing in fixture installation and bathroom remodeling.',
			'tech_service'      => 'plumbing',
		),
		array(
			'tech_name'         => 'Mark Davis',
			'tech_specialty'    => 'Electrical Expert',
			'tech_image'        => $theme_url . '/assets/img/customer-3.jpg',
			'tech_experience'   => 'Electrical, Generators, Backup Power',
			'tech_service_area' => 'midtown',
			'tech_bio'          => 'Electrical expert specializing in generator installation and backup power systems.',
			'tech_service'      => 'electrical',
		),
		array(
			'tech_name'         => 'Nicole Harris',
			'tech_specialty'    => 'HVAC Technician',
			'tech_image'        => $theme_url . '/assets/img/customer-1.jpg',
			'tech_experience'   => 'HVAC, Air Quality, Maintenance Plans',
			'tech_service_area' => 'suburbs',
			'tech_bio'          => 'HVAC technician focused on air quality improvement and preventive maintenance.',
			'tech_service'      => 'hvac',
		),
		array(
			'tech_name'         => 'Thomas Wilson',
			'tech_specialty'    => 'Master Electrician',
			'tech_image'        => $theme_url . '/assets/img/customer-2.jpg',
			'tech_experience'   => 'Electrical, Commercial, Industrial',
			'tech_service_area' => 'north',
			'tech_bio'          => 'Master electrician with experience in commercial and industrial electrical work.',
			'tech_service'      => 'electrical',
		),
		array(
			'tech_name'         => 'Rachel Green',
			'tech_specialty'    => 'Plumbing Specialist',
			'tech_image'        => $theme_url . '/assets/img/customer-3.jpg',
			'tech_experience'   => 'Plumbing, Gas Lines, Inspections',
			'tech_service_area' => 'south',
			'tech_bio'          => 'Plumbing specialist with expertise in gas line installation and safety inspections.',
			'tech_service'      => 'plumbing',
		),
	);
}

/**
 * Get default technicians based on Pro status.
 *
 * @since 1.3.0
 * @return array Default technicians (4 for free, 15 for Pro).
 */
function homerix_get_default_technicians() {
	$all = homerix_get_all_default_technicians();
	if ( function_exists( 'HOMERIX_IS_PRO' ) && HOMERIX_IS_PRO() ) {
		return $all;
	}
	return array_slice( $all, 0, 4 );
}

/**
 * Initialize default technician data on customizer load.
 *
 * Only seeds data when NO technician data exists at all.
 * Never overwrites customer-saved data.
 *
 * @since 1.0.0
 */
function homerix_init_technician_data() {
	$current_technicians = get_theme_mod( 'find_tech_technicians_list' );

	// Only seed if no data exists — never overwrite customer data.
	if ( empty( $current_technicians ) ) {
		$default_technicians = homerix_get_default_technicians();
		set_theme_mod( 'find_tech_technicians_list', $default_technicians );
	}
}
add_action( 'customize_register', 'homerix_init_technician_data' );
add_action( 'init', 'homerix_init_technician_data' );

/**
 * Seed full technician data when Pro plugin is first activated.
 *
 * Only seeds if NO data exists (empty). If the customer already has
 * their own saved data (even just 4 custom technicians), it is preserved.
 *
 * @since 1.3.0
 */
function homerix_pro_seed_technicians_on_init() {
	if ( ! function_exists( 'HOMERIX_IS_PRO' ) || ! HOMERIX_IS_PRO() ) {
		return;
	}
	$current = get_theme_mod( 'find_tech_technicians_list' );

	// Only seed if no data at all — never overwrite customer data.
	if ( empty( $current ) ) {
		$all_defaults = homerix_get_all_default_technicians();
		set_theme_mod( 'find_tech_technicians_list', $all_defaults );
	}
}
add_action( 'init', 'homerix_pro_seed_technicians_on_init' );

/**
 * One-time migration: reset old 15-technician default data for free version.
 *
 * Only resets if data appears to be unmodified defaults (first tech = Michael Johnson).
 * Customer-customized data is never touched.
 *
 * @since 1.3.0
 */
function homerix_migrate_technician_defaults() {
	if ( get_option( 'homerix_tech_data_v2' ) ) {
		return;
	}
	// Only migrate for free version (Pro should keep all technicians).
	if ( function_exists( 'HOMERIX_IS_PRO' ) && HOMERIX_IS_PRO() ) {
		update_option( 'homerix_tech_data_v2', true );
		return;
	}
	$current = get_theme_mod( 'find_tech_technicians_list' );
	if ( is_array( $current ) && count( $current ) > 4 ) {
		$first_name = isset( $current[0]['tech_name'] ) ? $current[0]['tech_name'] : '';
		if ( 'Michael Johnson' === $first_name ) {
			remove_theme_mod( 'find_tech_technicians_list' );
		}
	}
	update_option( 'homerix_tech_data_v2', true );
}
add_action( 'init', 'homerix_migrate_technician_defaults' );
