<?php
/**
 * Template Name: Homerix Site Services
 *
 * @package Homerix
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


get_header();
?>

<?php
// Get services page customizer settings.
$show_hero     = get_theme_mod( 'services_show_hero', true );
$hero_title    = get_theme_mod( 'services_hero_title', __( 'Professional Home Repair Services', 'homerix' ) );
$hero_subtitle = get_theme_mod( 'services_hero_subtitle', __( 'Quality repairs done right the first time by certified local technicians', 'homerix' ) );
$hero_bg_image = get_theme_mod( 'services_hero_bg_image', get_template_directory_uri() . '/assets/img/services-bg.jpg' );
$hero_bg_color = get_theme_mod( 'services_hero_bg_color', '#2563eb' );
$hero_btn_text = get_theme_mod( 'services_hero_btn_text', __( 'Book a Service', 'homerix' ) );
$hero_btn_url  = get_theme_mod( 'services_hero_btn_url', get_site_url() . '/homerix-book-now' );

// Main section settings.
$main_title    = get_theme_mod( 'services_main_title', __( 'Our Comprehensive Services', 'homerix' ) );
$main_subtitle = get_theme_mod( 'services_main_subtitle', __( 'From emergency repairs to planned renovations, we handle all your home maintenance needs with expertise and care.', 'homerix' ) );

// Parent services list.
$parent_services = get_theme_mod(
	'services_parent_services',
	array(
		array(
			'name'        => 'Plumbing Services',
			'value'       => 'plumbing',
			'icon'        => 'fas fa-faucet',
			'color'       => '#2563EB',
			'description' => 'Our licensed plumbers provide reliable solutions for all your plumbing needs, from simple leaks to complete pipe replacements.',
		),
		array(
			'name'        => 'Electrical Services',
			'value'       => 'electrical',
			'icon'        => 'fas fa-bolt',
			'color'       => '#eab308',
			'description' => 'Certified electricians for safe and code-compliant electrical repairs and installations.',
		),
		array(
			'name'        => 'HVAC Services',
			'value'       => 'hvac',
			'icon'        => 'fas fa-thermometer-half',
			'color'       => '#ef4444',
			'description' => 'Heating and cooling solutions to keep your home comfortable year-round.',
		),
		array(
			'name'        => 'Handyman Services',
			'value'       => 'handyman',
			'icon'        => 'fas fa-tools',
			'color'       => '#22c55e',
			'description' => 'General home repairs and maintenance for all your household needs.',
		),
	)
);

// Sub-services list.
$sub_services = get_theme_mod(
	'services_sub_services',
	array(
		array(
			'name'           => 'Leak Repair',
			'description'    => 'Fix leaking pipes, faucets, and fixtures quickly and reliably.',
			'price'          => '$75+',
			'features'       => 'Pipe leak detection|Faucet repair|Fixture replacement',
			'parent_service' => 'plumbing',
		),
		array(
			'name'           => 'Drain Cleaning',
			'description'    => 'Professional drain cleaning to restore flow and prevent clogs.',
			'price'          => '$95+',
			'features'       => 'Kitchen sinks|Bathroom drains|Main sewer line',
			'parent_service' => 'plumbing',
		),
		array(
			'name'           => 'Water Heater',
			'description'    => 'Installation, repair, and maintenance of water heaters.',
			'price'          => '$150+',
			'features'       => 'Tank replacement|Tankless install|Maintenance',
			'parent_service' => 'plumbing',
		),
		array(
			'name'           => 'Wiring & Rewiring',
			'description'    => 'Safe and code-compliant electrical wiring services.',
			'price'          => '$100+',
			'features'       => 'New wiring|Rewiring old homes|Code upgrades',
			'parent_service' => 'electrical',
		),
		array(
			'name'           => 'Panel Upgrades',
			'description'    => 'Upgrade your electrical panel for safety and capacity.',
			'price'          => '$200+',
			'features'       => 'Panel replacement|Circuit additions|Safety inspection',
			'parent_service' => 'electrical',
		),
		array(
			'name'           => 'Lighting Installation',
			'description'    => 'Professional indoor and outdoor lighting installation.',
			'price'          => '$80+',
			'features'       => 'Recessed lighting|Outdoor fixtures|Smart lighting',
			'parent_service' => 'electrical',
		),
		array(
			'name'           => 'AC Repair & Install',
			'description'    => 'Air conditioning repair, replacement, and new installations.',
			'price'          => '$125+',
			'features'       => 'AC unit repair|New installation|Refrigerant recharge',
			'parent_service' => 'hvac',
		),
		array(
			'name'           => 'Heating Systems',
			'description'    => 'Furnace and heating system repair and maintenance.',
			'price'          => '$120+',
			'features'       => 'Furnace repair|Heat pump service|Boiler maintenance',
			'parent_service' => 'hvac',
		),
		array(
			'name'           => 'Duct Cleaning',
			'description'    => 'Improve air quality with professional duct cleaning.',
			'price'          => '$150+',
			'features'       => 'Full duct cleaning|Air quality test|Filter replacement',
			'parent_service' => 'hvac',
		),
		array(
			'name'           => 'Furniture Repair',
			'description'    => 'Restore and repair damaged furniture and woodwork.',
			'price'          => '$65+',
			'features'       => 'Chair & table repair|Cabinet fixing|Wood restoration',
			'parent_service' => 'handyman',
		),
		array(
			'name'           => 'Door & Window Repair',
			'description'    => 'Fix sticking doors, broken windows, and hardware issues.',
			'price'          => '$70+',
			'features'       => 'Door adjustment|Window repair|Lock replacement',
			'parent_service' => 'handyman',
		),
		array(
			'name'           => 'General Maintenance',
			'description'    => 'Regular home maintenance to keep everything in top shape.',
			'price'          => '$55+',
			'features'       => 'Painting touch-ups|Shelf mounting|Minor repairs',
			'parent_service' => 'handyman',
		),
	)
);

// Book Now URL.
$book_now_url = get_theme_mod( 'services_book_now_url', get_site_url() . '/homerix-book-now' );

// Emergency section settings.
$show_emergency          = get_theme_mod( 'services_show_emergency', true );
$emergency_title         = get_theme_mod( 'services_emergency_title', __( '24/7 Emergency Repair Services', 'homerix' ) );
$emergency_subtitle      = get_theme_mod( 'services_emergency_subtitle', __( 'Got a home emergency? We\'re available around the clock to handle urgent repairs when you need them most.', 'homerix' ) );
$emergency_phone         = get_theme_mod( 'services_emergency_phone', '(555) 123-4567' );
$emergency_phone_enabled = get_theme_mod( 'services_emergency_phone_enabled', true );
$emergency_btn_enabled   = get_theme_mod( 'services_emergency_btn_enabled', true );
$emergency_btn_text      = get_theme_mod( 'services_emergency_btn_text', __( 'Book Emergency Service', 'homerix' ) );
$emergency_btn_url       = get_theme_mod( 'services_emergency_btn_url', get_site_url() . '/homerix-book-now' );

// Service areas settings.
$show_areas        = get_theme_mod( 'services_show_areas', true );
$areas_title       = get_theme_mod( 'services_areas_title', __( 'Our Service Areas', 'homerix' ) );
$areas_subtitle    = get_theme_mod( 'services_areas_subtitle', __( 'Proudly serving homeowners throughout the region with reliable home repair services.', 'homerix' ) );
$areas_cta_text    = get_theme_mod( 'services_areas_cta_text', __( 'Don\'t see your neighborhood listed? Give us a call to check availability.', 'homerix' ) );
$areas_btn_enabled = get_theme_mod( 'services_areas_btn_enabled', true );
$areas_btn_text    = get_theme_mod( 'services_areas_btn_text', __( 'Call to Verify Service Area', 'homerix' ) );
$areas_btn_phone   = get_theme_mod( 'services_areas_btn_phone', '(555) 123-4567' );
$areas_list        = get_theme_mod(
	'services_areas_list',
	array(
		array(
			'area_title'     => 'Metro Area',
			'area_locations' => 'Downtown|Midtown|Uptown|East Side|West End',
		),
		array(
			'area_title'     => 'Suburbs',
			'area_locations' => 'Green Valley|Lakeview|Pine Hills|Oak Brook|Riverdale',
		),
		array(
			'area_title'     => 'Surrounding Areas',
			'area_locations' => 'Springfield|Fairview|Maplewood|Clinton|Franklin',
		),
	)
);

// Why choose section settings.
$show_why_choose = get_theme_mod( 'services_show_why_choose', true );
$why_title       = get_theme_mod( 'services_why_title', __( 'Why Choose Homerix Pro', 'homerix' ) );
$why_subtitle    = get_theme_mod( 'services_why_subtitle', __( 'We\'re committed to delivering exceptional service with every repair.', 'homerix' ) );
$why_items       = get_theme_mod(
	'services_why_items',
	array(
		array(
			'icon'        => 'fas fa-user-shield',
			'icon_color'  => '#2563eb',
			'title'       => 'Vetted Professionals',
			'description' => 'All technicians are licensed, insured, and background-checked.',
		),
		array(
			'icon'        => 'fas fa-dollar-sign',
			'icon_color'  => '#16a34a',
			'title'       => 'Upfront Pricing',
			'description' => 'No hidden fees - know the cost before we start any work.',
		),
		array(
			'icon'        => 'fas fa-clock',
			'icon_color'  => '#eab308',
			'title'       => 'On-Time Guarantee',
			'description' => 'We arrive when promised or your service is discounted.',
		),
		array(
			'icon'        => 'fas fa-medal',
			'icon_color'  => '#dc2626',
			'title'       => 'Satisfaction Guaranteed',
			'description' => 'We stand behind our work with a 100% satisfaction guarantee.',
		),
	)
);

// CTA section settings.
$cta_title        = get_theme_mod( 'services_cta_title', __( 'Ready to Get Your Home Repairs Done?', 'homerix' ) );
$cta_subtitle     = get_theme_mod( 'services_cta_subtitle', __( 'Schedule your service online or give us a call today.', 'homerix' ) );
$cta_btn_enabled  = get_theme_mod( 'services_cta_btn_enabled', true );
$cta_btn_text     = get_theme_mod( 'services_cta_btn_text', __( 'Book Online Now', 'homerix' ) );
$cta_btn_url      = get_theme_mod( 'services_cta_btn_url', get_site_url() . '/homerix-book-now' );
$cta_btn2_enabled = get_theme_mod( 'services_cta_btn2_enabled', true );
$cta_btn2_text    = get_theme_mod( 'services_cta_btn2_text', __( 'Call: (555) 123-4567', 'homerix' ) );
$cta_btn2_url     = get_theme_mod( 'services_cta_btn2_url', 'tel:+15551234567' );

// Styling settings.
$primary_btn_color  = get_theme_mod( 'services_primary_btn_color', '#2563eb' );
$emergency_bg_color = get_theme_mod( 'services_emergency_bg_color', 'rgba(59, 130, 246, 0.1)' );

// Hero overlay settings.
$hero_overlay_enabled = get_theme_mod( 'services_hero_overlay_enabled', true );
$hero_overlay_opacity = get_theme_mod( 'services_hero_overlay_opacity', 40 );
?>

<main id="primary" tabindex="-1" class="site-main">

<?php if ( $show_hero ) : ?>
<!-- Services Hero Section -->
<section class="services-hero py-24 relative" style="background: <?php echo esc_attr( $hero_bg_color ); ?> url('<?php echo esc_url( $hero_bg_image ); ?>') center/cover no-repeat;">
	<?php if ( $hero_overlay_enabled ) : ?>
	<!-- Hero Overlay -->
	<div class="absolute inset-0" style="background: rgba(0,0,0,<?php echo esc_attr( $hero_overlay_opacity / 100 ); ?>);"></div>
	<?php endif; ?>

	<!-- Hero Content -->
	<div class="container mx-auto px-4 text-center relative z-10">
		<h1 class="text-4xl md:text-5xl font-bold mb-4 hero-text hero-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto hero-text hero-subs"><?php echo esc_html( $hero_subtitle ); ?></p>
		<?php
		$hero_btn_hidden = empty( $hero_btn_text ) ? ' hidden' : '';
		?>
		<a href="<?php echo esc_url( $hero_btn_url ); ?>" class="btn book-btn hero-btn inline-block font-bold py-3 px-8 rounded-lg transition duration-300<?php echo esc_attr( $hero_btn_hidden ); ?>">
			<?php echo esc_html( $hero_btn_text ); ?>
		</a>
	</div>
</section>
<?php endif; ?>

<!-- Main Services Section -->
	<section class="py-16 homerix-services-page">
		<div class="container mx-auto px-4">
			<div class="text-center mb-16">
				<h2 class="text-3xl font-bold mb-4 services-heading"><?php echo esc_html( $main_title ); ?></h2>
				<p class="text-lg max-w-3xl mx-auto services-description"><?php echo esc_html( $main_subtitle ); ?></p>
			</div>

			<?php
			// Loop through parent services.
			$ps_cap = HOMERIX_IS_PRO() ? 999 : 4;
			$ps_idx = 0;
			foreach ( $parent_services as $parent ) :
				++$ps_idx;
				if ( $ps_idx > $ps_cap ) {
					break;
				}
				$parent_value = isset( $parent['value'] ) ? $parent['value'] : '';
				$parent_name  = isset( $parent['name'] ) ? $parent['name'] : '';
				$parent_icon  = isset( $parent['icon'] ) ? $parent['icon'] : 'fas fa-wrench';
				$parent_color = isset( $parent['color'] ) ? $parent['color'] : '#2563EB';
				$parent_desc  = isset( $parent['description'] ) ? $parent['description'] : '';

				// Get sub-services for this parent
				$parent_subs = array_filter(
					$sub_services,
					function ( $sub ) use ( $parent_value ) {
						return isset( $sub['parent_service'] ) && $sub['parent_service'] === $parent_value;
					}
				);
				?>
			<!-- <?php echo esc_html( $parent_name ); ?> Services -->
			<div class="mb-20" id="<?php echo esc_attr( $parent_value ); ?>">
				<div class="flex flex-col md:flex-row items-center mb-8">
					<div class="md:w-1/3 mb-6 md:mb-0">
						<div class="p-4 rounded-full inline-block" style="background: <?php echo esc_attr( $parent_color ); ?>26; color: <?php echo esc_attr( $parent_color ); ?>;">
							<i class="<?php echo esc_attr( $parent_icon ); ?> text-4xl"></i>
						</div>
						<h3 class="text-2xl font-bold mt-4"><?php echo esc_html( $parent_name ); ?></h3>
					</div>
					<div class="md:w-2/3">
						<p class="text-lg mb-6"><?php echo esc_html( $parent_desc ); ?></p>

						<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
							<?php
							// Display sub-services for this parent.
							$ss_cap = HOMERIX_IS_PRO() ? 999 : 9;
							$ss_idx = 0;
							foreach ( $parent_subs as $sub ) :
								++$ss_idx;
								if ( $ss_idx > $ss_cap ) {
									break;
								}
								$sub_name     = isset( $sub['name'] ) ? $sub['name'] : '';
								$sub_desc     = isset( $sub['description'] ) ? $sub['description'] : '';
								$sub_price    = isset( $sub['price'] ) ? $sub['price'] : '$0+';
								$sub_features = isset( $sub['features'] ) ? explode( '|', $sub['features'] ) : array();
								?>
							<div class="service-card p-6 rounded-lg relative">
								<div class="price-badge px-3 py-1 rounded-full text-sm font-bold hero-text" style="background: <?php echo esc_attr( $parent_color ); ?>;"><?php echo esc_html( $sub_price ); ?></div>
								<h4 class="text-xl font-semibold mb-3"><?php echo esc_html( $sub_name ); ?></h4>
								<p class="mb-4"><?php echo esc_html( $sub_desc ); ?></p>
								<ul class="text-sm space-y-2 mb-4">
									<?php foreach ( $sub_features as $feature ) : ?>
									<li class="flex items-start">
										<i class="fas fa-check text-success mr-2 mt-1"></i>
										<span><?php echo esc_html( trim( $feature ) ); ?></span>
									</li>
									<?php endforeach; ?>
								</ul>
								<a href="<?php echo esc_url( $book_now_url ); ?>" style="color: <?php echo esc_attr( $parent_color ); ?>;" class="font-medium inline-flex items-center">Book Now <i class="fas fa-arrow-right ml-2"></i></a>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>

		</div>
	</section>

<?php if ( $show_emergency ) : ?>
<!-- Emergency Services Banner -->
<section class="services-emergency py-12" style="background: <?php echo esc_attr( $emergency_bg_color ); ?>;">
	<div class="container mx-auto px-4 text-center">
		<div class="max-w-4xl mx-auto">
			<h2 class="text-2xl md:text-3xl font-bold mb-4"><?php echo esc_html( $emergency_title ); ?></h2>
			<p class="text-lg mb-6"><?php echo esc_html( $emergency_subtitle ); ?></p>
			<div class="flex flex-col sm:flex-row justify-center gap-4">
				<?php if ( $emergency_phone_enabled && ! empty( $emergency_phone ) ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $emergency_phone ) ); ?>" class="btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 flex items-center justify-center gap-2 emergency-phone-btn">
					<i class="fas fa-phone-alt"></i> <span><?php echo esc_html( $emergency_phone ); ?></span>
				</a>
				<?php endif; ?>
				<?php if ( $emergency_btn_enabled && ! empty( $emergency_btn_text ) ) : ?>
				<a href="<?php echo esc_url( $emergency_btn_url ); ?>" class="btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 flex items-center justify-center gap-2 backdrop-blur-sm emergency-book-btn">
					<i class="fas fa-calendar-alt"></i> <span><?php echo esc_html( $emergency_btn_text ); ?></span>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $show_areas ) : ?>
<!-- Service Area Section -->
	<section class="py-16 services-areas card-base">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<h2 class="text-3xl font-bold mb-4"><?php echo esc_html( $areas_title ); ?></h2>
				<p class="text-lg max-w-3xl mx-auto "><?php echo esc_html( $areas_subtitle ); ?></p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
				<?php
				$sa_cap = HOMERIX_IS_PRO() ? 999 : 3;
				$sa_idx = 0;
				?>
				<?php foreach ( $areas_list as $area ) : ?>
					<?php
					++$sa_idx;
					if ( $sa_idx > $sa_cap ) {
						continue;
					}
					$area_title     = isset( $area['area_title'] ) ? $area['area_title'] : '';
					$area_locations = isset( $area['area_locations'] ) ? $area['area_locations'] : '';
					$locations      = array_map( 'trim', explode( '|', $area_locations ) );
					?>
					<div class="area-card p-6 rounded-lg">
						<h3 class="text-xl font-semibold mb-4 text-center"><?php echo esc_html( $area_title ); ?></h3>
						<ul class="space-y-2 text-center">
							<?php foreach ( $locations as $location ) : ?>
								<li><?php echo esc_html( $location ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( ! empty( $areas_cta_text ) || ( $areas_btn_enabled && ! empty( $areas_btn_text ) ) ) : ?>
			<div class="mt-12 text-center services-areas-cta">
				<?php if ( ! empty( $areas_cta_text ) ) : ?>
				<p class="mb-4 areas-cta-text"><?php echo esc_html( $areas_cta_text ); ?></p>
				<?php endif; ?>
				<?php if ( $areas_btn_enabled && ! empty( $areas_btn_text ) && ! empty( $areas_btn_phone ) ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $areas_btn_phone ) ); ?>" class="btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 inline-flex items-center justify-center gap-2 areas-cta-btn">
					<i class="fas fa-phone-alt"></i> <span><?php echo esc_html( $areas_btn_text ); ?></span>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $show_why_choose ) : ?>
<!-- Why Choose Us Section -->
<section class="py-16 services-why card-light">
		<div class="container mx-auto px-4">
			<div class="text-center mb-12">
				<h2 class="text-3xl font-bold mb-4"><?php echo esc_html( $why_title ); ?></h2>
				<p class="text-lg max-w-3xl mx-auto"><?php echo esc_html( $why_subtitle ); ?></p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
				<?php foreach ( $why_items as $item ) : ?>
					<?php
						$icon        = isset( $item['icon'] ) ? $item['icon'] : 'fas fa-star';
						$icon_color  = isset( $item['icon_color'] ) ? $item['icon_color'] : '#2563eb';
						$item_title  = isset( $item['title'] ) ? $item['title'] : '';
						$description = isset( $item['description'] ) ? $item['description'] : '';
					?>
					<div class="card-base p-6 rounded-lg shadow-sm text-center">
						<div class="p-4 rounded-full inline-block mb-4" style="background: <?php echo esc_attr( $icon_color ); ?>26; color: <?php echo esc_attr( $icon_color ); ?>;">							<i class="<?php echo esc_attr( $icon ); ?> text-3xl"></i>
						</div>
						<h3 class="text-xl font-semibold mb-3"><?php echo esc_html( $item_title ); ?></h3>
						<p class=""><?php echo esc_html( $description ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- Booking CTA Section -->
<section class="py-16 services-cta hero-text" style="background: var(--homerix-primary-color);">
		<div class="container mx-auto px-4 text-center">
			<h2 class="text-2xl md:text-3xl font-bold mb-4"><?php echo esc_html( $cta_title ); ?></h2>
			<p class="text-xl mb-8"><?php echo esc_html( $cta_subtitle ); ?></p>
			<div class="flex flex-col sm:flex-row justify-center gap-4">
				<?php if ( $cta_btn_enabled && ! empty( $cta_btn_text ) ) : ?>
				<a href="<?php echo esc_url( $cta_btn_url ); ?>" class="btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 flex items-center justify-center gap-2 cta-primary-btn">
					<i class="fas fa-calendar-alt"></i> <span><?php echo esc_html( $cta_btn_text ); ?></span>
				</a>
				<?php endif; ?>
				<?php if ( $cta_btn2_enabled && ! empty( $cta_btn2_text ) ) : ?>
				<a href="<?php echo esc_url( $cta_btn2_url ); ?>" class="btn find-btn font-bold py-3 px-8 rounded-lg transition duration-300 flex items-center justify-center gap-2 backdrop-blur-sm cta-secondary-btn">
					<i class="fas fa-phone-alt"></i> <span><?php echo esc_html( $cta_btn2_text ); ?></span>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</section>

<?php
// Note: Services page is now rendered entirely from Customizer data via PHP.
// The services.js AJAX calls are no longer needed.
?>

</main><!-- #primary -->

<?php get_footer(); ?>
