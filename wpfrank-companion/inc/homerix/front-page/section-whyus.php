<?php
/**
 * Why Us Section Template
 * Dynamic template with Kirki customizer integration
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


// Get customizer settings
$section_enabled  = get_theme_mod( 'whyus_section_enabled', true );
$section_title    = get_theme_mod( 'whyus_section_title', __( 'Why Choose Homerix Pro', 'homerix' ) );
$section_subtitle = get_theme_mod( 'whyus_section_subtitle', __( 'Discover what makes us the trusted choice for home repairs', 'homerix' ) );
$layout_columns   = get_theme_mod( 'whyus_layout_columns', 4 );
$container_size   = get_theme_mod( 'whyus_container_size', 'container mx-auto px-4' );
$whyus_items      = get_theme_mod( 'whyus_items', array() );

// Exit if section is disabled
if ( ! $section_enabled ) {
	return;
}

// Generate grid classes based on column layout
$grid_classes = 'grid grid-cols-1 md:grid-cols-2';
switch ( $layout_columns ) {
	case 2:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2';
		break;
	case 3:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
		break;
	case 4:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4';
		break;
	case 6:
		$grid_classes = 'grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6';
		break;
}

// Default features if none are set
if ( empty( $whyus_items ) ) {
	$whyus_items = array(
		array(
			'feature_enabled'     => true,
			'feature_title'       => __( 'Vetted Technicians', 'homerix' ),
			'feature_description' => __( 'All technicians undergo thorough background checks and skills verification.', 'homerix' ),
			'feature_icon'        => 'fas fa-user-shield',
		),
		array(
			'feature_enabled'     => true,
			'feature_title'       => __( '24/7 Emergency Services', 'homerix' ),
			'feature_description' => __( 'Available round the clock for urgent home repair needs.', 'homerix' ),
			'feature_icon'        => 'fas fa-clock',
		),
		array(
			'feature_enabled'     => true,
			'feature_title'       => __( 'Transparent Pricing', 'homerix' ),
			'feature_description' => __( 'No hidden fees. Get upfront pricing before any work begins.', 'homerix' ),
			'feature_icon'        => 'fas fa-dollar-sign',
		),
		array(
			'feature_enabled'     => true,
			'feature_title'       => __( 'Satisfaction Guarantee', 'homerix' ),
			'feature_description' => __( 'We stand behind our work with a 100% satisfaction guarantee.', 'homerix' ),
			'feature_icon'        => 'fas fa-thumbs-up',
		),
	);
}

// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$whyus_colors           = apply_filters( 'homerix_whyus_color_overrides', array() );
$color_override_enabled = ! empty( $whyus_colors );

?>

<?php if ( $color_override_enabled ) : ?>
<!-- Why Us Section Color Overrides -->
<style>
	.homerix-whyus {
		background: <?php echo esc_attr( isset( $whyus_colors['section_bg_color'] ) ? $whyus_colors['section_bg_color'] : '#ffffff' ); ?>;
	}
	.homerix-whyus .whyus-title {
		color: <?php echo esc_attr( isset( $whyus_colors['title_color'] ) ? $whyus_colors['title_color'] : '#111827' ); ?>;
	}
	.homerix-whyus .whyus-subtitle {
		color: <?php echo esc_attr( isset( $whyus_colors['subtitle_color'] ) ? $whyus_colors['subtitle_color'] : '#4b5563' ); ?>;
	}
	.homerix-whyus .feature-card {
		background: <?php echo esc_attr( isset( $whyus_colors['card_bg_color'] ) ? $whyus_colors['card_bg_color'] : '#ffffff' ); ?>;
	}
	.homerix-whyus .feature-icon-container {
		background: <?php echo esc_attr( isset( $whyus_colors['icon_bg_color'] ) ? $whyus_colors['icon_bg_color'] : 'rgba(37, 99, 235, 0.1)' ); ?>;
	}
	.homerix-whyus .feature-icon-container i {
		color: <?php echo esc_attr( isset( $whyus_colors['icon_color'] ) ? $whyus_colors['icon_color'] : '#2563EB' ); ?>;
	}
	.homerix-whyus .feature-title {
		color: <?php echo esc_attr( isset( $whyus_colors['card_title_color'] ) ? $whyus_colors['card_title_color'] : '#2563EB' ); ?>;
	}
	.homerix-whyus .feature-description {
		color: <?php echo esc_attr( isset( $whyus_colors['card_desc_color'] ) ? $whyus_colors['card_desc_color'] : '#4b5563' ); ?>;
	}
</style>
<?php endif; ?>

<!-- Why Choose Us Section -->
<section class="homerix-whyus py-16">
	<div class="<?php echo esc_attr( $container_size ); ?>">

		<!-- WhyUS Header -->
		<div class="text-center mb-12 my-8">
			<?php if ( ! empty( $section_title ) ) : ?>
				<h2 class="whyus-title text-3xl font-bold mb-4"><?php echo esc_html( $section_title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $section_subtitle ) ) : ?>
				<p class="whyus-subtitle text-lg max-w-3xl mx-auto"><?php echo esc_html( $section_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Why Us Grid -->
		<div class="<?php echo esc_attr( $grid_classes ); ?> gap-8 py-8">
			<?php
			// Inline limit (obfuscated variable name).
			$items_cap       = HOMERIX_IS_PRO() ? 999 : 4;
			$shown_items     = 0;
			$active_features = 0;

			// Count active features first.
			foreach ( $whyus_items as $feature_item ) {
				if ( isset( $feature_item['feature_enabled'] ) && $feature_item['feature_enabled'] ) {
					++$active_features;
				}
			}

			foreach ( $whyus_items as $feature ) :
				// Skip if feature is disabled.
				if ( ! isset( $feature['feature_enabled'] ) || ! $feature['feature_enabled'] ) {
					continue;
				}

				// Check limit.
				++$shown_items;
				if ( $shown_items > $items_cap ) {
					break;
				}

				$feature_title       = isset( $feature['feature_title'] ) ? $feature['feature_title'] : '';
				$feature_description = isset( $feature['feature_description'] ) ? $feature['feature_description'] : '';
				$feature_icon        = isset( $feature['feature_icon'] ) ? $feature['feature_icon'] : 'fas fa-star';
				?>

				<div class="feature-card text-center p-6 rounded-lg shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
					<!-- WhyUS Icon -->
					<div class="feature-icon-container w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
						<i class="<?php echo esc_attr( $feature_icon ); ?> text-2xl"></i>
					</div>

					<!-- WhyUS Content -->
					<?php if ( ! empty( $feature_title ) ) : ?>
						<h3 class="feature-title text-xl font-bold mb-2"><?php echo esc_html( $feature_title ); ?></h3>
					<?php endif; ?>

					<?php if ( ! empty( $feature_description ) ) : ?>
						<p class="feature-description"><?php echo esc_html( $feature_description ); ?></p>
					<?php endif; ?>
				</div>

			<?php endforeach; ?>

			<?php
			// Show upgrade notice if more features than limit.
			if ( ! HOMERIX_IS_PRO() && $active_features > $items_cap ) :
				?>
			<!-- Pro Upgrade Notice -->
			<div class="feature-card text-center p-6 rounded-lg shadow-md bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-dashed border-purple-200">
				<div class="w-14 h-14 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
					<i class="fas fa-star text-white text-xl"></i>
				</div>
				<h3 class="text-lg font-bold mb-2 text-purple-800">
					<?php
					/* translators: %d: number of additional features */
					echo esc_html( sprintf( __( '+%d More Features', 'homerix' ), $active_features - $items_cap ) );
					?>
				</h3>
				<p class="text-purple-600 mb-4 text-sm"><?php esc_html_e( 'Showcase all your advantages', 'homerix' ); ?></p>
				<a href="<?php echo esc_url( homerix_get_pro_url( 'whyus-section', 'upgrade-card' ) ); ?>" target="_blank" class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium px-5 py-2 rounded-lg text-sm hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
					<?php esc_html_e( 'Upgrade to Pro', 'homerix' ); ?>
				</a>
			</div>
			<?php endif; ?>
		</div>

	</div>
</section>
