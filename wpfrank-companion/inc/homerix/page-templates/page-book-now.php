<?php
/**
 * Template Name: Homerix Book Now
 *
 * Free version of the booking form with limits:
 * - Max 4 services
 * - Max 4 time types
 * - reCAPTCHA disabled (Pro only)
 * - Form field toggles disabled (Pro only)
 *
 * @package Homerix
 */

get_header();

// Check if Pro plugin provides the content.
if ( has_action( 'homerix_book_now_content' ) ) {
	do_action( 'homerix_book_now_content' );
	get_footer();
	return;
}

// Free version limits.
$free_services_limit   = 4;
$free_time_types_limit = 4;

// Get booking customizer settings - Hero Section.
$booking_hero_title    = get_theme_mod( 'booking_hero_title', esc_html__( 'Book Your Service', 'homerix' ) );
$booking_hero_subtitle = get_theme_mod( 'booking_hero_subtitle', esc_html__( 'Schedule your home repair service in just a few simple steps', 'homerix' ) );
$booking_hero_bg_color = get_theme_mod( 'booking_hero_bg_color', '#2563eb' );
$booking_hero_bg_image = get_theme_mod( 'booking_hero_bg_image', get_template_directory_uri() . '/assets/img/services-bg.jpg' );

// Hero overlay settings.
$hero_overlay_enabled = get_theme_mod( 'booking_hero_overlay_enabled', true );
$hero_overlay_opacity = get_theme_mod( 'booking_hero_overlay_opacity', 40 );

// Build hero background style.
$hero_bg_style = $booking_hero_bg_color;
if ( ! empty( $booking_hero_bg_image ) ) {
	$hero_bg_style = $booking_hero_bg_color . " url('" . esc_url( $booking_hero_bg_image ) . "') center/cover no-repeat";
}

// Get Step 1 - Service Selection settings.
$booking_step1_title = get_theme_mod( 'booking_step1_title', esc_html__( 'What service do you need?', 'homerix' ) );
$all_services        = get_theme_mod(
	'booking_services',
	array(
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
	)
);

// Filter enabled services and apply limit.
$enabled_services  = array_filter(
	$all_services,
	function ( $s ) {
		return ! empty( $s['service_enabled'] );
	}
);
$total_services    = count( $enabled_services );
$services          = array_slice( $enabled_services, 0, $free_services_limit );
$has_more_services = $total_services > $free_services_limit;

// Get Step 2 - Time Selection settings.
$booking_step2_title = get_theme_mod( 'booking_step2_title', esc_html__( 'When do you need service?', 'homerix' ) );
$all_time_types      = get_theme_mod(
	'booking_time_types',
	array(
		array(
			'time_type_label'   => esc_html__( 'ASAP (Emergency)', 'homerix' ),
			'time_type_value'   => 'asap',
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
			'time_type_value'   => 'this_week',
			'time_type_enabled' => true,
		),
		array(
			'time_type_label'   => esc_html__( 'Next Week', 'homerix' ),
			'time_type_value'   => 'next_week',
			'time_type_enabled' => true,
		),
	)
);

// Filter enabled time types and apply limit.
$enabled_time_types  = array_filter(
	$all_time_types,
	function ( $t ) {
		return ! empty( $t['time_type_enabled'] );
	}
);
$total_time_types    = count( $enabled_time_types );
$time_types          = array_slice( $enabled_time_types, 0, $free_time_types_limit );
$has_more_time_types = $total_time_types > $free_time_types_limit;

$time_slots_string = get_theme_mod( 'booking_time_slots', '8:00 AM, 10:00 AM, 12:00 PM, 2:00 PM, 4:00 PM, 6:00 PM' );
$time_slots        = array_map( 'trim', explode( ',', $time_slots_string ) );

// Get Step 3 - Customer Details (always enabled in free version).
$booking_step3_title = get_theme_mod( 'booking_step3_title', esc_html__( 'Tell us about yourself', 'homerix' ) );

// Get Step 4 - Review & Confirmation settings.
$booking_step4_title = get_theme_mod( 'booking_step4_title', esc_html__( 'Review Your Appointment', 'homerix' ) );

// Get form styling settings.
$booking_form_width = get_theme_mod( 'booking_form_width', 'max-w-4xl' );

// Pro upgrade URL.
$pro_url = homerix_get_pro_url( 'book-now-page', 'upgrade-card' );
?>

<main id="primary" tabindex="-1" class="site-main">

<!-- Booking Hero -->
<section class="booking-hero hero-text py-16 relative" style="background: <?php echo esc_attr( $hero_bg_style ); ?>;">
	<?php if ( $hero_overlay_enabled && ! empty( $booking_hero_bg_image ) ) : ?>
	<!-- Hero Overlay -->
	<div class="absolute inset-0" style="background: rgba(0,0,0,<?php echo esc_attr( $hero_overlay_opacity / 100 ); ?>);"></div>
	<?php endif; ?>
	<div class="container mx-auto px-4 text-center relative z-10">
		<h1 class="text-4xl font-bold mb-4 booking-hero-title"><?php echo esc_html( $booking_hero_title ); ?></h1>
		<p class="text-xl max-w-3xl mx-auto booking-hero-subtitle"><?php echo esc_html( $booking_hero_subtitle ); ?></p>
	</div>
</section>

<section class="py-16 card-light">
	<div class="container mx-auto px-4">
		<div class="<?php echo esc_attr( $booking_form_width ); ?> mx-auto">

			<!-- Progress Indicator -->
			<div class="progress-indicator-container flex justify-between items-center mb-12 relative max-w-2xl mx-auto">
				<!-- Progress Line Background -->
				<div class="absolute top-5 left-0 right-0 h-1 progress-bg -z-10"></div>
				<!-- Progress Line Active (filled by JS) -->
				<div class="progress-line absolute top-5 left-0 h-1 bg-primary -z-10 transition-all duration-500" style="width: 0%;"></div>
				
				<div class="flex flex-col items-center step-wrapper" data-step="1">
					<div class="step-indicator active mb-2 px-2">1</div>
					<span class="step-label text-sm font-medium"><?php esc_html_e( 'Service', 'homerix' ); ?></span>
				</div>
				
				<div class="flex flex-col items-center step-wrapper" data-step="2">
					<div class="step-indicator mb-2 px-2">2</div>
					<span class="step-label text-sm font-medium step-label-inactive"><?php esc_html_e( 'Time', 'homerix' ); ?></span>
				</div>
				
				<div class="flex flex-col items-center step-wrapper" data-step="3">
					<div class="step-indicator mb-2 px-2">3</div>
					<span class="step-label text-sm font-medium step-label-inactive"><?php esc_html_e( 'Details', 'homerix' ); ?></span>
				</div>
				
				<div class="flex flex-col items-center step-wrapper" data-step="4">
					<div class="step-indicator mb-2 px-2">4</div>
					<span class="step-label text-sm font-medium step-label-inactive"><?php esc_html_e( 'Confirm', 'homerix' ); ?></span>
				</div>
			</div>
			
			<form id="booking-form" class="bg-white rounded-lg shadow-sm p-8">
				<?php wp_nonce_field( 'homerix_booking_nonce', 'booking_nonce' ); ?>
				
				<!-- Step 1: Service Selection -->
				<div class="form-step" id="step-1">
					<h2 class="text-2xl font-bold mb-6"><?php echo esc_html( $booking_step1_title ); ?></h2>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 services-grid">
						<?php
						foreach ( $services as $service ) :
							$name        = isset( $service['service_name'] ) ? $service['service_name'] : '';
							$description = isset( $service['service_description'] ) ? $service['service_description'] : '';
							$icon        = isset( $service['service_icon'] ) ? $service['service_icon'] : 'fas fa-tools';
							$color       = isset( $service['service_color'] ) ? $service['service_color'] : '#2563EB';
							?>
						<div class="service-option p-4 rounded-lg selection-border cursor-pointer transition" data-service="<?php echo esc_attr( $name ); ?>">
							<div class="flex items-start">
								<div class="p-3 rounded-full mr-4 hero-text text-xl" style="background: <?php echo esc_attr( $color ); ?>;">								<i class="<?php echo esc_attr( $icon ); ?>"></i>
								</div>
								<div>
									<h3 class="font-bold mb-1"><?php echo esc_html( $name ); ?></h3>
									<p class="text-sm text-muted"><?php echo esc_html( $description ); ?></p>
								</div>
							</div>
						</div>
							<?php
						endforeach;

						// Show upgrade card if more services exist.
						if ( $has_more_services ) :
							?>
						<div class="service-option p-4 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 cursor-default">
							<div class="flex items-start">
								<div class="p-3 rounded-full mr-4 bg-gray-200 text-gray-500 text-xl">
									<i class="fas fa-lock"></i>
								</div>
								<div>
									<h3 class="font-bold mb-1 text-gray-600"><?php esc_html_e( 'More Services Available', 'homerix' ); ?></h3>
									<p class="text-sm text-gray-500 mb-2">
										<?php
										printf(
											/* translators: %d: number of additional services */
											esc_html__( '+%d more services in Pro', 'homerix' ),
											$total_services - $free_services_limit
										);
										?>
									</p>
									<a href="<?php echo esc_url( $pro_url ); ?>" target="_blank" class="text-sm text-primary font-medium hover:underline"><?php esc_html_e( 'Upgrade to Pro →', 'homerix' ); ?></a>
								</div>
							</div>
						</div>
							<?php
						endif;
						?>
					</div>
					
					<div class="flex justify-end">
						<button type="button" class="next-step bg-primary hover-bg-primary-dark hero-text font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Next: Choose Time', 'homerix' ); ?>
						</button>
					</div>
				</div>
				
				<!-- Step 2: Time Selection -->
				<div class="form-step hidden" id="step-2">
					<h2 class="text-2xl font-bold mb-6"><?php echo esc_html( $booking_step2_title ); ?></h2>

					<div class="mb-8">
						<div class="flex flex-wrap gap-2 mb-4 time-types-container">
							<?php
							foreach ( $time_types as $time_type ) :
								$label = isset( $time_type['time_type_label'] ) ? $time_type['time_type_label'] : '';
								$value = isset( $time_type['time_type_value'] ) ? $time_type['time_type_value'] : '';
								?>
								<button type="button" class="time-type-btn px-4 py-2 rounded-lg text-sm font-medium transition" data-type="<?php echo esc_attr( $value ); ?>">
									<?php echo esc_html( $label ); ?>
								</button>
								<?php
							endforeach;

							// Show upgrade indicator if more time types exist.
							if ( $has_more_time_types ) :
								?>
								<span class="px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-500 border border-dashed border-gray-300">
									<?php
									printf(
										/* translators: %d: number of additional time types */
										esc_html__( '+%d more (Pro)', 'homerix' ),
										$total_time_types - $free_time_types_limit
									);
									?>
								</span>
								<?php
							endif;
							?>
						</div>

						<div class="border rounded-lg p-4">
							<h3 class="font-bold mb-4"><?php esc_html_e( 'Available Time Slots', 'homerix' ); ?></h3>
							<div class="grid grid-cols-2 md:grid-cols-4 gap-2 time-slots-container" id="time-slots">
								<?php
								foreach ( $time_slots as $slot ) :
									?>
									<div class="time-slot selection-border py-2 px-3 rounded text-center text-sm cursor-pointer hover-border-primary hover-bg-primary-light transition" data-slot="<?php echo esc_attr( $slot ); ?>">
										<?php echo esc_html( $slot ); ?>
									</div>
									<?php
								endforeach;
								?>
							</div>
						</div>
					</div>
					
					<div class="flex justify-between">
						<button type="button" class="prev-step btn-secondary font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Back', 'homerix' ); ?>
						</button>
						<button type="button" class="next-step bg-primary hover-bg-primary-dark hero-text font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Next: Your Details', 'homerix' ); ?>
						</button>
					</div>
				</div>
				
				<!-- Step 3: Customer Details (All fields always shown in free version) -->
				<div class="form-step hidden" id="step-3">
					<h2 class="text-2xl font-bold mb-6"><?php echo esc_html( $booking_step3_title ); ?></h2>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
						<div>
							<label for="first-name" class="block text-sm font-medium mb-1"><?php esc_html_e( 'First Name*', 'homerix' ); ?></label>
							<input type="text" id="first-name" name="first_name" required class="form-input w-full px-4 py-3 rounded-lg">
						</div>

						<div>
							<label for="last-name" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Last Name*', 'homerix' ); ?></label>
							<input type="text" id="last-name" name="last_name" required class="form-input w-full px-4 py-3 rounded-lg">
						</div>

						<div>
							<label for="email" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Email*', 'homerix' ); ?></label>
							<input type="email" id="email" name="email" required class="form-input w-full px-4 py-3 rounded-lg">
						</div>

						<div>
							<label for="phone" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Phone*', 'homerix' ); ?></label>
							<input type="tel" id="phone" name="phone" required class="form-input w-full px-4 py-3 rounded-lg">
						</div>
					</div>

					<div class="mb-6">
						<label for="address" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Service Address*', 'homerix' ); ?></label>
						<input type="text" id="address" name="address" required class="form-input w-full px-4 py-3 rounded-lg">
					</div>

					<div class="mb-6">
						<label for="notes" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Special Instructions', 'homerix' ); ?></label>
						<textarea id="notes" name="notes" rows="4" class="form-input w-full px-4 py-3 rounded-lg" placeholder="<?php esc_attr_e( 'Describe the issue or any special instructions...', 'homerix' ); ?>"></textarea>
					</div>
					
					<div class="flex justify-between">
						<button type="button" class="prev-step btn-secondary font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Back', 'homerix' ); ?>
						</button>
						<button type="button" class="next-step bg-primary hover-bg-primary-dark hero-text font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Next: Review & Confirm', 'homerix' ); ?>
						</button>
					</div>
				</div>
				
				<!-- Step 4: Confirmation -->
				<div class="form-step hidden" id="step-4">
					<h2 class="text-2xl font-bold mb-6"><?php echo esc_html( $booking_step4_title ); ?></h2>

					<div class="card-light rounded-lg p-6 mb-6">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<div>
								<h3 class="font-bold mb-4"><?php esc_html_e( 'Service Details', 'homerix' ); ?></h3>
								<div class="space-y-2 text-sm">
									<div><strong><?php esc_html_e( 'Service:', 'homerix' ); ?></strong> <span id="review-service">-</span></div>
									<div><strong><?php esc_html_e( 'Date & Time:', 'homerix' ); ?></strong> <span id="review-time">-</span></div>
									<div><strong><?php esc_html_e( 'Address:', 'homerix' ); ?></strong> <span id="review-address">-</span></div>
								</div>
							</div>

							<div>
								<h3 class="font-bold mb-4"><?php esc_html_e( 'Customer Information', 'homerix' ); ?></h3>
								<div class="space-y-2 text-sm">
									<div><strong><?php esc_html_e( 'Name:', 'homerix' ); ?></strong> <span id="review-name">-</span></div>
									<div><strong><?php esc_html_e( 'Email:', 'homerix' ); ?></strong> <span id="review-email">-</span></div>
									<div><strong><?php esc_html_e( 'Phone:', 'homerix' ); ?></strong> <span id="review-phone">-</span></div>
								</div>
							</div>
						</div>
					</div>

					<div class="mb-6">
						<div class="flex items-start">
							<input type="checkbox" id="terms" name="terms" required class="mt-1 mr-2">
							<label for="terms" class="text-sm">
								<?php
								printf(
									/* translators: 1: Terms link, 2: Privacy link */
									esc_html__( 'I agree to the %1$s and %2$s*', 'homerix' ),
									'<a href="' . esc_url( get_permalink( get_page_by_path( 'homerix-terms-of-service' ) ) ) . '" class="text-primary hover:underline" target="_blank">' . esc_html__( 'Terms of Service', 'homerix' ) . '</a>',
									'<a href="' . esc_url( get_permalink( get_page_by_path( 'homerix-privacy-policy' ) ) ) . '" class="text-primary hover:underline" target="_blank">' . esc_html__( 'Privacy Policy', 'homerix' ) . '</a>'
								);
								?>
							</label>
						</div>
					</div>
					
					<div class="flex justify-between">
						<button type="button" class="prev-step btn-secondary font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Back', 'homerix' ); ?>
						</button>
						<button type="submit" class="book-btn bg-success hover-bg-success-dark hero-text font-bold py-2 px-6 rounded-lg transition duration-300">
							<?php esc_html_e( 'Confirm Booking', 'homerix' ); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<?php
// Enqueue booking form script.
wp_enqueue_script( 'homerix-booking-form', get_template_directory_uri() . '/assets/js/frontend/booking-form.js', array(), defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0', true );

// Localize script with AJAX URL (reCAPTCHA disabled in free version).
wp_localize_script(
	'homerix-booking-form',
	'HomerixBooking',
	array(
		'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
		'recaptchaSiteKey' => '',
		'recaptchaEnabled' => false,
		'fieldConfig'      => array(
			'firstName'    => true,
			'lastName'     => true,
			'email'        => true,
			'phone'        => true,
			'address'      => true,
			'instructions' => true,
		),
	)
);
?>

</main><!-- #primary -->

<?php
get_footer();
