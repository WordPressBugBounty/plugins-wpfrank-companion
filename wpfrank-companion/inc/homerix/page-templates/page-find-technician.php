<?php
/**
 * Template Name: Homerix Find Technician
 *
 * Free version of the technician directory with limits:
 * - Max 4 services in filter
 * - Max 4 locations in filter
 * - Max 4 technicians displayed
 *
 * @package Homerix
 */

get_header();

// Check if Pro plugin provides the content.
if ( has_action( 'homerix_find_technician_content' ) ) {
	do_action( 'homerix_find_technician_content' );
	get_footer();
	return;
}

// Free version limits.
$free_services_limit    = 4;
$free_locations_limit   = 4;
$free_technicians_limit = 4;

// Get find technician customizer settings.
$hero_title           = get_theme_mod( 'find_tech_hero_title', __( 'Meet Our Certified Technicians', 'homerix' ) );
$hero_subtitle        = get_theme_mod( 'find_tech_hero_subtitle', __( 'Skilled professionals ready to handle your home repair needs', 'homerix' ) );
$hero_bg_image        = get_theme_mod( 'find_tech_hero_bg_image', get_template_directory_uri() . '/assets/img/hero-tech.jpg' );
$hero_overlay_enabled = get_theme_mod( 'find_tech_hero_overlay_enabled', true );
$hero_overlay_opacity = get_theme_mod( 'find_tech_hero_overlay_opacity', 40 );
$hero_btn_enabled     = get_theme_mod( 'find_tech_hero_btn_enabled', true );
$hero_btn_text        = get_theme_mod( 'find_tech_hero_btn_text', __( 'Browse Technicians', 'homerix' ) );
$hero_btn_url         = get_theme_mod( 'find_tech_hero_btn_url', '#technician-list' );

// Search section settings.
$search_title       = get_theme_mod( 'find_tech_search_title', __( 'Find Your Perfect Technician', 'homerix' ) );
$search_placeholder = get_theme_mod( 'find_tech_search_placeholder', __( "e.g. 'John' or 'plumbing'", 'homerix' ) );

// Services for filter (with limit).
$all_services = get_theme_mod(
	'find_tech_services',
	array(
		array(
			'name'  => 'Plumbing',
			'value' => 'plumbing',
		),
		array(
			'name'  => 'Electrical',
			'value' => 'electrical',
		),
		array(
			'name'  => 'HVAC',
			'value' => 'hvac',
		),
		array(
			'name'  => 'Handyman',
			'value' => 'handyman',
		),
	)
);
if ( is_string( $all_services ) ) {
	$all_services = json_decode( $all_services, true ) ?: array();
}
$total_services    = count( $all_services );
$services          = array_slice( $all_services, 0, $free_services_limit );
$has_more_services = $total_services > $free_services_limit;

// Locations for filter (with limit).
$all_locations = get_theme_mod(
	'find_tech_locations',
	array(
		array(
			'name'  => 'Downtown',
			'value' => 'downtown',
		),
		array(
			'name'  => 'Midtown',
			'value' => 'midtown',
		),
		array(
			'name'  => 'Suburbs',
			'value' => 'suburbs',
		),
		array(
			'name'  => 'North Area',
			'value' => 'north',
		),
	)
);
if ( is_string( $all_locations ) ) {
	$all_locations = json_decode( $all_locations, true ) ?: array();
}
$total_locations    = count( $all_locations );
$locations          = array_slice( $all_locations, 0, $free_locations_limit );
$has_more_locations = $total_locations > $free_locations_limit;

// Technicians list (with limit).
$all_technicians = get_theme_mod( 'find_tech_technicians_list', array() );
if ( is_string( $all_technicians ) ) {
	$all_technicians = json_decode( $all_technicians, true ) ?: array();
}

// Provide fallback defaults if no data exists.
if ( empty( $all_technicians ) && function_exists( 'homerix_get_default_technicians' ) ) {
	$all_technicians = homerix_get_default_technicians();
}

$total_technicians    = count( $all_technicians );
$technicians          = array_slice( $all_technicians, 0, $free_technicians_limit );
$has_more_technicians = $total_technicians > $free_technicians_limit;

// Why section settings.
$why_title = get_theme_mod( 'find_tech_why_title', __( 'Why Choose Our Technicians', 'homerix' ) );
$why_items = get_theme_mod(
	'find_tech_why_items',
	array(
		array(
			'icon'        => 'fas fa-user-shield',
			'icon_color'  => '#2563EB',
			'title'       => __( 'Rigorous Vetting Process', 'homerix' ),
			'description' => __( 'Every technician undergoes background checks and skills assessment.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-medal',
			'icon_color'  => '#22c55e',
			'title'       => __( 'Proven Track Record', 'homerix' ),
			'description' => __( 'We only work with technicians who maintain high customer ratings.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-graduation-cap',
			'icon_color'  => '#eab308',
			'title'       => __( 'Continuous Training', 'homerix' ),
			'description' => __( 'Our technicians receive ongoing training on latest techniques.', 'homerix' ),
		),
	)
);

// CTA section settings.
$cta_title    = get_theme_mod( 'find_tech_cta_title', __( 'Are You a Skilled Technician?', 'homerix' ) );
$cta_subtitle = get_theme_mod( 'find_tech_cta_subtitle', __( 'Join our network of trusted home service professionals', 'homerix' ) );
$cta_btn_text = get_theme_mod( 'find_tech_cta_btn_text', __( 'Apply to Join Our Team', 'homerix' ) );
$cta_btn_url  = get_theme_mod( 'find_tech_cta_btn_url', '#apply' );
$cta_bg_color = get_theme_mod( 'find_tech_cta_bg_color', function_exists( 'homerix_get_theme_color' ) ? homerix_get_theme_color( 'primary' ) : '#2563eb' );

// Get Book Now button URL.
$book_now_url = function_exists( 'homerix_get_book_now_settings' )
	? homerix_get_book_now_settings()['url']
	: home_url( '/homerix-book-now/' );

// Pro upgrade URL.
$pro_url = homerix_get_pro_url( 'find-technician-page', 'upgrade-card' );
?>

<main id="primary" tabindex="-1" class="site-main">

<!-- Technician Hero Section -->
<section class="find-tech-hero py-32 relative overflow-hidden" style="background-image: url('<?php echo esc_url( $hero_bg_image ); ?>'); background-size: cover; background-position: center;">
	<?php if ( $hero_overlay_enabled ) : ?>
		<div class="absolute inset-0 bg-black" style="opacity: <?php echo esc_attr( $hero_overlay_opacity / 100 ); ?>;"></div>
	<?php endif; ?>
	<div class="container mx-auto px-4 text-center relative z-10">
		<h1 class="text-4xl md:text-5xl font-bold mb-4 hero-text"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto hero-text"><?php echo esc_html( $hero_subtitle ); ?></p>
		<?php if ( $hero_btn_enabled && ! empty( $hero_btn_text ) ) : ?>
			<a href="<?php echo esc_url( $hero_btn_url ); ?>" class="btn book-btn inline-block font-bold py-3 px-8 rounded-lg transition duration-300">
				<?php echo esc_html( $hero_btn_text ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<!-- Technician Search and Filter Section -->
<section class="find-tech-search py-12">
	<div class="container mx-auto px-4">
		<div class="rounded-xl p-6 md:p-8 shadow-sm">
			<h2 class="text-2xl font-bold mb-6"><?php echo esc_html( $search_title ); ?></h2>
			
			<div class="flex flex-col md:flex-row gap-6">
				<!-- Search Field -->
				<div class="flex-1">
					<label for="technician-search" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Search by Name or Specialty', 'homerix' ); ?></label>
					<div class="relative">
						<input type="text" id="technician-search" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" class="form-input w-full py-3 px-4 rounded-lg">
						<button class="absolute right-3 top-3"><i class="fas fa-search"></i></button>
					</div>
				</div>
				
				<!-- Service Filter -->
				<div class="flex-1">
					<label for="service-filter" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Filter by Service', 'homerix' ); ?></label>
					<select id="service-filter" class="w-full py-3 px-4 border rounded-lg">
						<option value=""><?php esc_html_e( 'All Services', 'homerix' ); ?></option>
						<?php foreach ( $services as $service ) : ?>
							<option value="<?php echo esc_attr( $service['value'] ); ?>"><?php echo esc_html( $service['name'] ); ?></option>
						<?php endforeach; ?>
						<?php if ( $has_more_services ) : ?>
							<option value="" disabled>── <?php printf( esc_html__( '+%d more (Pro)', 'homerix' ), absint( $total_services - $free_services_limit ) ); ?> ──</option>
						<?php endif; ?>
					</select>
				</div>
				
				<!-- Location Filter -->
				<div class="flex-1">
					<label for="location-filter" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Filter by Location', 'homerix' ); ?></label>
					<select id="location-filter" class="w-full py-3 px-4 border rounded-lg">
						<option value=""><?php esc_html_e( 'All Areas', 'homerix' ); ?></option>
						<?php foreach ( $locations as $location ) : ?>
							<option value="<?php echo esc_attr( $location['value'] ); ?>"><?php echo esc_html( $location['name'] ); ?></option>
						<?php endforeach; ?>
						<?php if ( $has_more_locations ) : ?>
							<option value="" disabled>── <?php printf( esc_html__( '+%d more (Pro)', 'homerix' ), absint( $total_locations - $free_locations_limit ) ); ?> ──</option>
						<?php endif; ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Technician List Section -->
<section id="technician-list" class="py-12 card-light">
	<div class="container mx-auto px-4">
		<div class="flex justify-between items-center mb-8">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Available Technicians', 'homerix' ); ?></h2>
			<div class="text-sm text-muted">
				<?php esc_html_e( 'Showing', 'homerix' ); ?> <span class="font-bold"><?php echo count( $technicians ); ?></span> <?php esc_html_e( 'technicians', 'homerix' ); ?>
			</div>
		</div>

		<?php if ( empty( $technicians ) ) : ?>
			<div class="text-center py-12">
				<p class="text-muted"><?php esc_html_e( 'No technicians available at the moment.', 'homerix' ); ?></p>
			</div>
		<?php else : ?>
			<!-- Technicians Grid -->
			<div id="technicians-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php foreach ( $technicians as $tech ) : ?>
					<!-- Technician Card -->
					<div class="technician-card card-base p-6 rounded-lg shadow-sm relative" data-service="<?php echo esc_attr( $tech['tech_service'] ?? '' ); ?>" data-location="<?php echo esc_attr( $tech['tech_service_area'] ?? '' ); ?>">
						<div class="flex items-start mb-4">
							<?php if ( ! empty( $tech['tech_image'] ) ) : ?>
								<img src="<?php echo esc_url( $tech['tech_image'] ); ?>" alt="<?php echo esc_attr( $tech['tech_name'] ); ?>" class="w-16 h-16 rounded-full border-2 border-primary mr-4">
							<?php else : ?>
								<div class="w-16 h-16 avatar-placeholder rounded-full border-2 border-primary mr-4 flex items-center justify-center">
									<i class="fas fa-user text-muted text-2xl"></i>
								</div>
							<?php endif; ?>
							<div>
								<h3 class="text-xl font-bold"><?php echo esc_html( $tech['tech_name'] ?? '' ); ?></h3>
								<p class="text-primary font-medium"><?php echo esc_html( $tech['tech_specialty'] ?? '' ); ?></p>
							</div>
						</div>

						<div class="mb-4">
							<?php if ( ! empty( $tech['tech_bio'] ) ) : ?>
								<p class="text-body mb-3"><?php echo esc_html( $tech['tech_bio'] ); ?></p>
							<?php endif; ?>
						</div>
						<div class="border-t border-light pt-4">
							<div class="flex justify-between items-center">
								<?php if ( ! empty( $tech['tech_service_area'] ) ) : ?>
									<div class="flex items-center text-sm text-muted">
										<i class="fas fa-map-marker-alt mr-2"></i>
										<span><?php echo esc_html( $tech['tech_service_area'] ); ?></span>
									</div>
								<?php endif; ?>
								<?php
								$tech_book_url = add_query_arg(
									array(
										'technician' => $tech['tech_name'] ?? '',
										'specialty'  => $tech['tech_specialty'] ?? '',
									),
									$book_now_url
								);
								?>
								<a href="<?php echo esc_url( $tech_book_url ); ?>" class="btn book-btn text-center font-bold py-2 px-4 rounded-lg transition duration-300"><?php esc_html_e( 'Book Now', 'homerix' ); ?></a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

				<?php if ( $has_more_technicians ) : ?>
					<!-- Upgrade Card -->
					<div class="technician-card card-base p-6 rounded-lg shadow-sm border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center text-center">
						<div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mb-4">
							<i class="fas fa-lock text-gray-500 text-2xl"></i>
						</div>
						<h3 class="text-xl font-bold text-gray-600 mb-2"><?php esc_html_e( 'More Technicians Available', 'homerix' ); ?></h3>
						<p class="text-gray-500 mb-4">
							<?php
							printf(
								/* translators: %d: number of additional technicians */
								esc_html__( '+%d more technicians in Pro', 'homerix' ),
								absint( $total_technicians - $free_technicians_limit )
							);
							?>
						</p>
						<a href="<?php echo esc_url( $pro_url ); ?>" target="_blank" class="btn book-btn font-bold py-2 px-6 rounded-lg"><?php esc_html_e( 'Upgrade to Pro', 'homerix' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Why Our Technicians Section -->
<section class="find-tech-why py-16 card-base">
	<div class="container mx-auto px-4">
		<div class="text-center mb-12">
			<h2 class="text-3xl font-bold mb-4"><?php echo esc_html( $why_title ); ?></h2>
		</div>
		
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
			<?php if ( ! empty( $why_items ) && is_array( $why_items ) ) : ?>
				<?php foreach ( $why_items as $item ) : ?>
					<?php
					$icon_color = ! empty( $item['icon_color'] ) ? $item['icon_color'] : '#2563EB';
					$bg_color   = $icon_color . '26';
					?>
					<div class="why-card text-center p-6">
						<div class="why-icon-wrapper p-4 rounded-full inline-block mb-4" style="background: <?php echo esc_attr( $bg_color ); ?>; color: <?php echo esc_attr( $icon_color ); ?>;">
							<i class="<?php echo esc_attr( $item['icon'] ?? 'fas fa-star' ); ?> text-3xl"></i>
						</div>
						<h3 class="text-xl font-semibold mb-3"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
						<p class="text-muted"><?php echo esc_html( $item['description'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Become a Technician CTA -->
<section class="find-tech-cta py-16 hero-text" style="background: <?php echo esc_attr( $cta_bg_color ); ?>">
	<div class="container mx-auto px-4 text-center">
		<h2 class="text-2xl md:text-3xl font-bold mb-4"><?php echo esc_html( $cta_title ); ?></h2>
		<p class="text-xl mb-8"><?php echo esc_html( $cta_subtitle ); ?></p>
		<a href="<?php echo esc_url( $cta_btn_url ); ?>" class="btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300">
			<?php echo esc_html( $cta_btn_text ); ?>
		</a>
	</div>
</section>

<?php
// Enqueue find technician script.
wp_enqueue_script( 'homerix-find-technician', get_template_directory_uri() . '/assets/js/frontend/find-technician.js', array(), defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0', true );
?>

</main><!-- #primary -->

<?php
get_footer();
