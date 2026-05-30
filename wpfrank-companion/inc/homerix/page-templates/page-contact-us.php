<?php
/**
 * Template Name: Homerix Contact Us
 * Template Post Type: page
 *
 * Contact Us page template for Homerix Pro theme.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

get_header();

// Hero Section Settings.
$hero_title           = get_theme_mod( 'contact_hero_title', __( 'Contact Homerix Pro', 'homerix' ) );
$hero_subtitle        = get_theme_mod( 'contact_hero_subtitle', __( "We're here to help with all your home repair questions and service needs", 'homerix' ) );
$hero_btn_text        = get_theme_mod( 'contact_hero_button_text', __( 'Send Us a Message', 'homerix' ) );
$hero_btn_url         = get_theme_mod( 'contact_hero_button_url', '#contact-form' );
$hero_bg_color        = get_theme_mod( 'contact_hero_bg_color', '#1e3a5f' );
$hero_bg_image        = get_theme_mod( 'contact_hero_bg_image', get_template_directory_uri() . '/assets/img/contact-bg.jpg' );
$hero_overlay_enabled = get_theme_mod( 'contact_hero_overlay_enabled', true );
$hero_overlay_opacity = get_theme_mod( 'contact_hero_overlay_opacity', 50 );

// Contact Form Settings.
$form_title       = get_theme_mod( 'contact_form_title', __( 'Send Us a Message', 'homerix' ) );
$form_description = get_theme_mod( 'contact_form_description', __( 'Have questions about our services or need to schedule a repair? Fill out the form below and we\'ll get back to you promptly.', 'homerix' ) );
$form_shortcode   = get_theme_mod( 'contact_form_shortcode', '' );
$consent_text     = get_theme_mod( 'contact_form_consent_text', __( 'I agree to the <a href="{terms_of_service}" target="_blank">Terms of Service</a> and <a href="{privacy_policy}" target="_blank">Privacy Policy</a>, and consent to being contacted about my inquiry.', 'homerix' ) );

// Get theme page URLs for Privacy Policy and TOS.
$privacy_policy_url = homerix_get_page_url_by_template( 'page-templates/page-privacy-policy.php' );
if ( empty( $privacy_policy_url ) ) {
	$privacy_policy_url = get_privacy_policy_url(); // Fallback to WP default.
}
$tos_url = homerix_get_page_url_by_template( 'page-templates/page-terms-of-service.php' );
if ( empty( $tos_url ) ) {
	$tos_url = home_url( '/terms-of-service/' ); // Fallback.
}

// Replace placeholders with actual URLs.
$consent_text = str_replace( '{privacy_policy}', esc_url( $privacy_policy_url ), $consent_text );
$consent_text = str_replace( '{terms_of_service}', esc_url( $tos_url ), $consent_text );

// Map Settings.
$map_title         = get_theme_mod( 'contact_map_title', __( 'Our Location', 'homerix' ) );
$map_embed         = get_theme_mod( 'contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215373510576!2d-73.987844924533!3d40.74844047138911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzU0LjQiTiA3M8KwNTknMTQuMiJX!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus' );
$area_title        = get_theme_mod( 'contact_service_area_title', __( 'Service Area', 'homerix' ) );
$area_desc         = get_theme_mod( 'contact_service_area_desc', __( 'We proudly serve the following areas with our home repair services:', 'homerix' ) );
$service_areas_raw = get_theme_mod(
	'contact_service_areas',
	array(
		array( 'area' => 'Cityville' ),
		array( 'area' => 'Townsville' ),
		array( 'area' => 'Metro County' ),
		array( 'area' => 'North District' ),
		array( 'area' => 'South Borough' ),
		array( 'area' => 'West Township' ),
	)
);
// Handle both simple array and repeater format.
$service_areas = array();
if ( is_array( $service_areas_raw ) ) {
	foreach ( $service_areas_raw as $item ) {
		if ( is_array( $item ) && isset( $item['area'] ) ) {
			$service_areas[] = $item['area'];
		} elseif ( is_string( $item ) ) {
			$service_areas[] = $item;
		}
	}
}
$area_note = get_theme_mod( 'contact_area_note', __( '*Some services may not be available in all areas. Call to confirm.', 'homerix' ) );


// CTA Settings.
$cta_title     = get_theme_mod( 'contact_cta_title', __( 'Ready to Schedule Your Service?', 'homerix' ) );
$cta_subtitle  = get_theme_mod( 'contact_cta_subtitle', __( 'Contact us today for fast, reliable home repairs.', 'homerix' ) );
$cta_btn1_text = get_theme_mod( 'contact_cta_button1_text', __( 'Book Online Now', 'homerix' ) );
$cta_btn1_url  = get_theme_mod( 'contact_cta_button1_url', '#booking' );
$cta_btn2_text = get_theme_mod( 'contact_cta_button2_text', __( 'Call: (555) 123-4567', 'homerix' ) );
$cta_btn2_url  = get_theme_mod( 'contact_cta_button2_url', 'tel:+15551234567' );
$cta_bg_color  = get_theme_mod( 'contact_cta_bg_color', '#2563EB' );
?>

<main id="primary" tabindex="-1" class="site-main">

<!-- Contact Hero Section -->
<section class="contact-hero hero-text py-24 relative overflow-hidden" style="background: <?php echo esc_attr( $hero_bg_color ); ?>; <?php echo ! empty( $hero_bg_image ) ? 'background-image: url(' . esc_url( $hero_bg_image ) . '); background-size: cover; background-position: center;' : ''; ?>">
	<?php if ( $hero_overlay_enabled ) : ?>
		<div class="absolute inset-0 bg-black z-0" style="opacity: <?php echo esc_attr( $hero_overlay_opacity / 100 ); ?>;"></div>
	<?php endif; ?>
	<div class="container mx-auto px-4 text-center relative z-10">
		<h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="contact-hero-subtitle text-xl md:text-2xl mb-8 max-w-3xl mx-auto"><?php echo esc_html( $hero_subtitle ); ?></p>
		<?php if ( ! empty( trim( $hero_btn_text ) ) && ! empty( trim( $hero_btn_url ) ) ) : ?>
			<a href="<?php echo esc_url( $hero_btn_url ); ?>" class="contact-hero-btn btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 inline-block">
				<?php echo esc_html( $hero_btn_text ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<!-- Contact Options Section -->
<section class="py-16 card-base">
	<div class="container mx-auto px-4">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			<?php
			// Get contact cards from repeater.
			$contact_cards = get_theme_mod( 'contact_cards', array() );

			// Handle JSON string from Kirki repeater.
			if ( is_string( $contact_cards ) ) {
				$contact_cards = json_decode( $contact_cards, true );
				if ( ! is_array( $contact_cards ) ) {
					$contact_cards = array();
				}
			}

			// Default cards if none are set.
			if ( empty( $contact_cards ) ) {
				$contact_cards = array(
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
				);
			}

			// Render each enabled card.
			// Inline limit (obfuscated var).
			$card_max   = HOMERIX_IS_PRO() ? 999 : 3;
			$card_shown = 0;

			foreach ( $contact_cards as $card ) :
				// Skip disabled cards.
				$card_enabled = isset( $card['card_enabled'] ) ? $card['card_enabled'] : true;
				if ( ! $card_enabled ) {
					continue;
				}

				// Check limit.
				$card_shown++;
				if ( $card_shown > $card_max ) {
					break;
				}

				$card_icon       = isset( $card['card_icon'] ) ? $card['card_icon'] : 'fas fa-info-circle';
				$card_icon_color = isset( $card['card_icon_color'] ) ? $card['card_icon_color'] : '#2563EB';
				$card_title      = isset( $card['card_title'] ) ? $card['card_title'] : '';
				$card_desc       = isset( $card['card_description'] ) ? $card['card_description'] : '';

				// Generate light background from icon color.
				$bg_color = $card_icon_color . '20'; // 12% opacity.

				// Build items array from simple fields.
				$items = array();
				for ( $i = 1; $i <= 3; $i++ ) {
					$icon      = isset( $card[ "item{$i}_icon" ] ) ? $card[ "item{$i}_icon" ] : '';
					$value     = isset( $card[ "item{$i}_value" ] ) ? $card[ "item{$i}_value" ] : '';
					$link_type = isset( $card[ "item{$i}_link_type" ] ) ? $card[ "item{$i}_link_type" ] : 'none';

					// Only add item if value is not empty.
					if ( ! empty( trim( $value ) ) ) {
						$items[] = array(
							'icon'      => $icon,
							'value'     => $value,
							'link_type' => $link_type,
						);
					}
				}
				?>
				<div class="contact-card card-light p-6 rounded-lg shadow-sm">
					<div class="p-4 rounded-full inline-block mb-4" style="background: <?php echo esc_attr( $bg_color ); ?>; color: <?php echo esc_attr( $card_icon_color ); ?>;">
						<i class="<?php echo esc_attr( $card_icon ); ?> text-2xl"></i>
					</div>
					<h3 class="text-xl font-bold mb-3"><?php echo esc_html( $card_title ); ?></h3>
					<p class="text-muted mb-4"><?php echo esc_html( $card_desc ); ?></p>
					<?php if ( ! empty( $items ) ) : ?>
						<div class="space-y-2">
							<?php
							foreach ( $items as $item ) :
								$item_icon      = ! empty( $item['icon'] ) ? $item['icon'] : 'fas fa-circle';
								$item_value     = $item['value'];
								$item_link_type = $item['link_type'];

								// Generate link href based on type.
								$link_href = '';
								if ( 'tel' === $item_link_type ) {
									$link_href = 'tel:' . preg_replace( '/[^0-9+]/', '', $item_value );
								} elseif ( 'mailto' === $item_link_type ) {
									$link_href = 'mailto:' . $item_value;
								} elseif ( 'url' === $item_link_type ) {
									$link_href = $item_value;
								}
								?>
								<div class="flex items-start">
									<i class="<?php echo esc_attr( $item_icon ); ?> text-muted mr-2 mt-1"></i>
									<?php if ( ! empty( $link_href ) ) : ?>
										<a href="<?php echo esc_url( $link_href ); ?>" class="text-primary hover:underline"><?php echo nl2br( esc_html( $item_value ) ); ?></a>
									<?php else : ?>
										<span class="text-body"><?php echo nl2br( esc_html( $item_value ) ); ?></span>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Contact Form Section -->
<section id="contact-form" class="py-16 card-light">
	<div class="container mx-auto px-4">
		<div class="flex flex-col lg:flex-row gap-12">
			<!-- Form Column -->
			<div class="lg:w-1/2">
				<h2 class="contact-form-title text-3xl font-bold mb-6"><?php echo esc_html( $form_title ); ?></h2>
				<p class="contact-form-desc text-lg text-muted mb-8"><?php echo esc_html( $form_description ); ?></p>

				<?php if ( ! empty( trim( $form_shortcode ) ) ) : ?>
					<?php // Custom shortcode provided - use it instead of built-in form. ?>
					<div class="contact-form-shortcode">
						<?php echo do_shortcode( $form_shortcode ); ?>
					</div>
				<?php else : ?>
					<form class="space-y-6 contact-form" method="post" action="">
					<?php wp_nonce_field( 'homerix_contact_form', 'homerix_contact_nonce' ); ?>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
						<div>
							<label for="first-name" class="block text-sm font-medium text-body mb-1"><?php esc_html_e( 'First Name*', 'homerix' ); ?></label>
							<input type="text" id="first-name" name="first_name" class="form-input w-full px-4 py-3 border rounded-lg focus:outline-none" required>
						</div>
						<div>
							<label for="last-name" class="block text-sm font-medium text-body mb-1"><?php esc_html_e( 'Last Name*', 'homerix' ); ?></label>
							<input type="text" id="last-name" name="last_name" class="form-input w-full px-4 py-3 border rounded-lg focus:outline-none" required>
						</div>
					</div>

					<div>
						<label for="email" class="block text-sm font-medium text-body mb-1"><?php esc_html_e( 'Email*', 'homerix' ); ?></label>
						<input type="email" id="email" name="email" class="form-input w-full px-4 py-3 border rounded-lg focus:outline-none" required>
					</div>

					<div>
						<label for="phone" class="block text-sm font-medium text-body mb-1"><?php esc_html_e( 'Phone Number', 'homerix' ); ?></label>
						<input type="tel" id="phone" name="phone" class="form-input w-full px-4 py-3 border rounded-lg focus:outline-none">
					</div>

					<div>
						<label for="subject" class="block text-sm font-medium text-body mb-1"><?php esc_html_e( 'Subject*', 'homerix' ); ?></label>
						<select id="subject" name="subject" class="form-input w-full px-4 py-3 border rounded-lg focus:outline-none" required>
							<option value=""><?php esc_html_e( 'Select a subject', 'homerix' ); ?></option>
							<?php
							// Get subjects from customizer.
							$default_subjects = array(
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
							);
							$subjects         = get_theme_mod( 'contact_form_subjects', $default_subjects );

							foreach ( $subjects as $subject ) :
								if ( ! empty( $subject['value'] ) && ! empty( $subject['label'] ) ) :
									?>
									<option value="<?php echo esc_attr( $subject['value'] ); ?>"><?php echo esc_html( $subject['label'] ); ?></option>
									<?php
								endif;
							endforeach;
							?>
						</select>
					</div>

					<div>
						<label for="message" class="block text-sm font-medium text-body mb-1"><?php esc_html_e( 'Message*', 'homerix' ); ?></label>
						<textarea id="message" name="message" rows="5" class="form-input w-full px-4 py-3 border rounded-lg focus:outline-none" required></textarea>
					</div>

					<div class="flex items-start">
						<input type="checkbox" id="consent" name="consent" required class="mt-1 mr-2">
						<label for="consent" class="text-sm text-body">
							<?php
							// Output the customizable consent text (already has HTML link).
							echo wp_kses(
								$consent_text . '*',
								array(
									'a' => array(
										'href'   => array(),
										'class'  => array(),
										'target' => array(),
									),
								)
							);
							?>
						</label>
					</div>

					<button type="submit" name="homerix_contact_submit" class="btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 w-full md:w-auto">
						<?php esc_html_e( 'Send Message', 'homerix' ); ?>
					</button>
				</form>
				<?php endif; ?>
			</div>

			<!-- Map Column -->
			<div class="lg:w-1/2">
				<h2 class="contact-map-title text-3xl font-bold mb-6"><?php echo esc_html( $map_title ); ?></h2>
				<div class="map-container rounded-lg shadow-lg overflow-hidden mb-6">
					<iframe src="<?php echo esc_url( $map_embed ); ?>"
							width="100%"
							height="100%"
							style="border:0;"
							allowfullscreen=""
							loading="lazy"></iframe>
				</div>

				<div class="card-base p-6 rounded-lg shadow-sm">
					<h3 class="contact-area-title text-xl font-bold mb-4"><?php echo esc_html( $area_title ); ?></h3>
					<p class="contact-area-desc text-muted mb-4"><?php echo esc_html( $area_desc ); ?></p>
					<ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-body">
						<?php
						// Inline limit (obfuscated).
						$areas_cap     = HOMERIX_IS_PRO() ? 999 : 4;
						$limited_areas = array_slice( $service_areas, 0, $areas_cap );
						foreach ( $limited_areas as $area ) :
							?>
							<li class="flex items-center">
								<i class="fas fa-check text-success mr-2"></i>
								<span><?php echo esc_html( $area ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
					<p class="contact-area-note text-sm text-muted mt-4"><?php echo esc_html( $area_note ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- CTA Section -->
<section class="contact-cta-section py-16 hero-text" style="background: <?php echo esc_attr( $cta_bg_color ); ?>;">
	<div class="container mx-auto px-4 text-center">
		<h2 class="contact-cta-title text-2xl md:text-3xl font-bold mb-4"><?php echo esc_html( $cta_title ); ?></h2>
		<p class="contact-cta-subtitle text-xl mb-8"><?php echo esc_html( $cta_subtitle ); ?></p>
		<div class="flex flex-col sm:flex-row justify-center gap-4">
			<a href="<?php echo esc_url( $cta_btn1_url ); ?>" class="contact-cta-btn1 btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300">
				<?php echo esc_html( $cta_btn1_text ); ?>
			</a>
			<a href="<?php echo esc_url( $cta_btn2_url ); ?>" class="contact-cta-btn2 btn find-btn font-bold py-3 px-8 rounded-lg transition duration-300 backdrop-blur-sm">
				<?php echo esc_html( $cta_btn2_text ); ?>
			</a>
		</div>
	</div>
</section>

<?php
// Enqueue contact form script if not using custom shortcode.
if ( empty( trim( $form_shortcode ) ) ) {
	wp_enqueue_script(
		'homerix-contact-form',
		get_template_directory_uri() . '/assets/js/frontend/contact-form.js',
		array(),
		defined( 'HOMERIX_VERSION' ) ? HOMERIX_VERSION : '1.0.0',
		true
	);
	wp_localize_script(
		'homerix-contact-form',
		'HomerixContact',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		)
	);
}

?>
</main><!-- #primary -->
<?php
get_footer();

