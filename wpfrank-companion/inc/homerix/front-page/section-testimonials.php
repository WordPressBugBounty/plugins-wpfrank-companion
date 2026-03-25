<?php
/**
 * Testimonials Section Template Part
 * Enhanced with Kirki customizer integration
 *
 * @package Homerix_Pro
 */

// Check if testimonials section is enabled.
$section_enabled = get_theme_mod( 'testimonials_section_enabled', true );
if ( ! $section_enabled ) {
	return;
}

// Get customizer settings.
$section_title      = get_theme_mod( 'testimonials_section_title', __( 'What Our Customers Say', 'homerix' ) );
$section_subtitle   = get_theme_mod( 'testimonials_section_subtitle', __( 'Real feedback from satisfied homeowners', 'homerix' ) );
$show_subtitle      = get_theme_mod( 'testimonials_show_subtitle', true );
$layout_columns     = get_theme_mod( 'testimonials_layout_columns', 3 );
$container_size     = get_theme_mod( 'testimonials_container_size', 'container mx-auto px-4' );
$background_color   = get_theme_mod( 'testimonials_background_color', 'light' );
$testimonials_items = get_theme_mod( 'testimonials_items', array() );

// Generate grid classes based on column layout.
$grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
switch ( $layout_columns ) {
	case 1:
		$grid_classes = 'grid grid-cols-1';
		break;
	case 2:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2';
		break;
	case 3:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
		break;
	case 4:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4';
		break;
}

// Generate CSS classes based on Homerix color selection.
$background_class = '';
switch ( $background_color ) {
	case 'primary':
		$background_class = 'homerix-bg-primary text-white';
		break;
	case 'secondary':
		$background_class = 'homerix-bg-secondary text-white';
		break;
	case 'base':
		$background_class = 'homerix-bg-base text-white';
		break;
	case 'light':
	default:
		$background_class = 'homerix-bg-light';
		break;
}

// Default testimonials if none are set.
if ( empty( $testimonials_items ) ) {
	$testimonials_items = array(
		array(
			'testimonial_enabled'  => true,
			'testimonial_name'     => __( 'Sarah Johnson', 'homerix' ),
			'testimonial_content'  => __( 'Excellent service! The plumber arrived on time and fixed our kitchen sink quickly. Very professional and reasonably priced.', 'homerix' ),
			'testimonial_rating'   => 5,
			'testimonial_image'    => '',
			'testimonial_location' => __( 'Downtown', 'homerix' ),
		),
		array(
			'testimonial_enabled'  => true,
			'testimonial_name'     => __( 'Mike Chen', 'homerix' ),
			'testimonial_content'  => __( 'Great experience with their electrical services. The technician was knowledgeable and explained everything clearly.', 'homerix' ),
			'testimonial_rating'   => 5,
			'testimonial_image'    => '',
			'testimonial_location' => __( 'Westside', 'homerix' ),
		),
		array(
			'testimonial_enabled'  => true,
			'testimonial_name'     => __( 'Lisa Rodriguez', 'homerix' ),
			'testimonial_content'  => __( 'Outstanding HVAC repair service. They diagnosed the problem quickly and had our heating working the same day.', 'homerix' ),
			'testimonial_rating'   => 5,
			'testimonial_image'    => '',
			'testimonial_location' => __( 'Northside', 'homerix' ),
		),
	);
}

// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$testimonials_colors    = apply_filters( 'homerix_testimonials_color_overrides', array() );
$color_override_enabled = ! empty( $testimonials_colors );

// Get color override values from filter data.
$section_bg_color = $color_override_enabled && isset( $testimonials_colors['section_bg_color'] ) ? $testimonials_colors['section_bg_color'] : '';
$title_color      = $color_override_enabled && isset( $testimonials_colors['title_color'] ) ? $testimonials_colors['title_color'] : '';
$subtitle_color   = $color_override_enabled && isset( $testimonials_colors['subtitle_color'] ) ? $testimonials_colors['subtitle_color'] : '';
$card_bg_color    = $color_override_enabled && isset( $testimonials_colors['card_bg_color'] ) ? $testimonials_colors['card_bg_color'] : '';
$quote_color      = $color_override_enabled && isset( $testimonials_colors['quote_color'] ) ? $testimonials_colors['quote_color'] : '';
$name_color       = $color_override_enabled && isset( $testimonials_colors['name_color'] ) ? $testimonials_colors['name_color'] : '';
$star_color       = $color_override_enabled && isset( $testimonials_colors['star_color'] ) ? $testimonials_colors['star_color'] : '';
$location_color   = $color_override_enabled && isset( $testimonials_colors['location_color'] ) ? $testimonials_colors['location_color'] : '';

?>

<!-- Testimonials Section -->
<section class="homerix-testimonials py-16 <?php echo esc_attr( $background_class ); ?>"<?php echo $section_bg_color ? ' style="background: ' . esc_attr( $section_bg_color ) . ';"' : ''; ?>>
	<div class="<?php echo esc_attr( $container_size ); ?>">

		<!-- Section Header -->
		<div class="text-center mb-12">
			<?php if ( ! empty( $section_title ) ) : ?>
				<h2 class="testimonials-title text-3xl md:text-4xl font-bold mb-4"<?php echo $title_color ? ' style="color: ' . esc_attr( $title_color ) . ';"' : ''; ?>><?php echo esc_html( $section_title ); ?></h2>
			<?php endif; ?>

			<?php if ( $show_subtitle && ! empty( $section_subtitle ) ) : ?>
				<p class="testimonials-subtitle text-lg max-w-3xl mx-auto"<?php echo $subtitle_color ? ' style="color: ' . esc_attr( $subtitle_color ) . ';"' : ''; ?>><?php echo esc_html( $section_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Testimonials Grid -->
		<div class="<?php echo esc_attr( $grid_classes ); ?> gap-8">
			<?php
			// Inline limit (obfuscated var name).
			$reviews_cap        = HOMERIX_IS_PRO() ? 999 : 3;
			$testimonials_count = 0;
			$total_enabled      = 0;

			// Count total enabled testimonials.
			foreach ( $testimonials_items as $testimonial ) {
				if ( isset( $testimonial['testimonial_enabled'] ) && $testimonial['testimonial_enabled'] ) {
					$total_enabled++;
				}
			}

			foreach ( $testimonials_items as $testimonial ) :
				// Skip if testimonial is disabled.
				if ( ! isset( $testimonial['testimonial_enabled'] ) || ! $testimonial['testimonial_enabled'] ) {
					continue;
				}

				// Check limit.
				$testimonials_count++;
				if ( $testimonials_count > $reviews_cap ) {
					break;
				}

				$testimonial_name     = isset( $testimonial['testimonial_name'] ) ? $testimonial['testimonial_name'] : '';
				$testimonial_content  = isset( $testimonial['testimonial_content'] ) ? $testimonial['testimonial_content'] : '';
				$testimonial_rating   = isset( $testimonial['testimonial_rating'] ) ? intval( $testimonial['testimonial_rating'] ) : 5;
				$testimonial_image    = isset( $testimonial['testimonial_image'] ) ? $testimonial['testimonial_image'] : '';
				$testimonial_location = isset( $testimonial['testimonial_location'] ) ? $testimonial['testimonial_location'] : '';

				// Skip if essential fields are empty.
				if ( empty( $testimonial_name ) || empty( $testimonial_content ) ) {
					continue;
				}
				?>

				<div class="testimonial-item card-base p-6 rounded-lg shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md"<?php echo $card_bg_color ? ' style="background: ' . esc_attr( $card_bg_color ) . ';"' : ''; ?>>

					<!-- Testimonial Content -->
					<div class="testimonial-content mb-4">
						<!-- Rating Stars -->
						<div class="testimonial-rating mb-3">
							<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
								<i class="fas fa-star <?php echo $i <= $testimonial_rating ? 'star-filled' : 'star-empty'; ?>"<?php echo ( $i <= $testimonial_rating && $star_color ) ? ' style="color: ' . esc_attr( $star_color ) . ';"' : ''; ?>></i>
							<?php endfor; ?>
						</div>

						<!-- Testimonial Text -->
						<p class="testimonial-text text-muted italic mb-4"<?php echo $quote_color ? ' style="color: ' . esc_attr( $quote_color ) . ';"' : ''; ?>>
							"<?php echo esc_html( $testimonial_content ); ?>"
						</p>
					</div>

					<!-- Testimonial Author -->
					<div class="testimonial-author flex items-center">
						<!-- Author Image -->
						<?php if ( ! empty( $testimonial_image ) ) : ?>
							<img src="<?php echo esc_url( $testimonial_image ); ?>"
								 alt="<?php echo esc_attr( $testimonial_name ); ?>"
								 class="testimonial-avatar w-12 h-12 rounded-full mr-3 object-cover">
						<?php else : ?>
							<div class="testimonial-avatar w-12 h-12 rounded-full avatar-primary flex items-center justify-center mr-3">
								<i class="fas fa-user"></i>
							</div>
						<?php endif; ?>

						<!-- Author Info -->
						<div class="testimonial-info">
							<h4 class="testimonial-name font-semibold text-heading"<?php echo $name_color ? ' style="color: ' . esc_attr( $name_color ) . ';"' : ''; ?>>
								<?php echo esc_html( $testimonial_name ); ?>
							</h4>
							<?php if ( ! empty( $testimonial_location ) ) : ?>
								<p class="testimonial-location text-sm text-muted"<?php echo $location_color ? ' style="color: ' . esc_attr( $location_color ) . ';"' : ''; ?>>
									<?php echo esc_html( $testimonial_location ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>

				</div>

				<?php
			endforeach;

			// Show upgrade message if there are more testimonials than the limit allows.
			if ( ! HOMERIX_IS_PRO() && $total_enabled > $reviews_cap ) :
				?>
			<!-- Pro Upgrade Notice -->
			<div class="testimonial-item card-base p-6 rounded-lg shadow-md bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-dashed border-purple-200">
				<div class="text-center py-4">
					<div class="w-14 h-14 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
						<i class="fas fa-star text-white text-xl"></i>
					</div>
					<h4 class="text-lg font-bold mb-2 text-purple-800"><?php echo esc_html( sprintf( __( '+%d More Reviews', 'homerix' ), $total_enabled - $reviews_cap ) ); ?></h4>
					<p class="text-purple-600 mb-4 text-sm"><?php esc_html_e( 'Show all your customer testimonials', 'homerix' ); ?></p>
					<a href="<?php echo esc_url( homerix_get_pro_url( 'testimonials-section', 'upgrade-card' ) ); ?>" target="_blank" class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium px-5 py-2 rounded-lg text-sm hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
						<?php esc_html_e( 'Upgrade to Pro', 'homerix' ); ?>
					</a>
				</div>
			</div>
			<?php endif; ?>
		</div>

	</div>
</section>

