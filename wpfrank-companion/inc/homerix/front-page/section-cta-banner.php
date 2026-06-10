<?php
/**
 * CTA Banner Section Template Part
 * Enhanced with Kirki customizer integration
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


// Check if CTA section is enabled.
$cta_enabled = get_theme_mod( 'cta_section_enabled', true );
if ( ! $cta_enabled ) {
	return;
}

// Get customizer settings.
$container_size  = get_theme_mod( 'cta_container_size', 'w-full px-4' );
$cta_title       = get_theme_mod( 'cta_title', __( 'Need Urgent Repairs? Book Now!', 'homerix' ) );
$cta_description = get_theme_mod( 'cta_description', __( 'Our emergency technicians are available 24/7 to handle your home repair emergencies.', 'homerix' ) );
$cta_phone       = get_theme_mod( 'cta_phone', '(555) 123-4567' );
$cta_button_text = get_theme_mod( 'cta_button_text', __( 'Call Now', 'homerix' ) );

// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$cta_colors             = apply_filters( 'homerix_cta_color_overrides', array() );
$color_override_enabled = ! empty( $cta_colors );

// Get color override values from filter data.
$section_bg_color  = $color_override_enabled && isset( $cta_colors['section_bg_color'] ) ? $cta_colors['section_bg_color'] : '';
$title_color       = $color_override_enabled && isset( $cta_colors['title_color'] ) ? $cta_colors['title_color'] : '';
$description_color = $color_override_enabled && isset( $cta_colors['description_color'] ) ? $cta_colors['description_color'] : '';
$button_bg_color   = $color_override_enabled && isset( $cta_colors['button_bg_color'] ) ? $cta_colors['button_bg_color'] : '';
$button_text_color = $color_override_enabled && isset( $cta_colors['button_text_color'] ) ? $cta_colors['button_text_color'] : '';
$button_hover_bg   = $color_override_enabled && isset( $cta_colors['button_hover_bg_color'] ) ? $cta_colors['button_hover_bg_color'] : '';
$button_hover_text = $color_override_enabled && isset( $cta_colors['button_hover_text_color'] ) ? $cta_colors['button_hover_text_color'] : '';

?>

<?php if ( $color_override_enabled ) : ?>
<!-- CTA Section Color Overrides -->
<style>
	<?php if ( $section_bg_color ) : ?>
	.homerix-cta {
		background: <?php echo esc_attr( $section_bg_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( $title_color ) : ?>
	.homerix-cta .cta-title {
		color: <?php echo esc_attr( $title_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( $description_color ) : ?>
	.homerix-cta .cta-description {
		color: <?php echo esc_attr( $description_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( $button_bg_color || $button_text_color ) : ?>
	.homerix-cta .book-btn {
		<?php
		if ( $button_bg_color ) :
			?>
			background: <?php echo esc_attr( $button_bg_color ); ?>;<?php endif; ?>
		<?php
		if ( $button_text_color ) :
			?>
			color: <?php echo esc_attr( $button_text_color ); ?>;<?php endif; ?>
	}
	<?php endif; ?>
	<?php if ( $button_hover_bg || $button_hover_text ) : ?>
	.homerix-cta .book-btn:hover {
		<?php
		if ( $button_hover_bg ) :
			?>
			background: <?php echo esc_attr( $button_hover_bg ); ?>;<?php endif; ?>
		<?php
		if ( $button_hover_text ) :
			?>
			color: <?php echo esc_attr( $button_hover_text ); ?>;<?php endif; ?>
	}
	<?php endif; ?>
</style>
<?php endif; ?>

<!-- CTA Banner Section -->
<section class="homerix-cta py-12">
	<div class="<?php echo esc_attr( $container_size ); ?> text-center">

		<!-- CTA Header -->
		<?php if ( ! empty( $cta_title ) ) : ?>
			<h2 class="cta-title text-2xl md:text-3xl font-bold mb-4"><?php echo esc_html( $cta_title ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $cta_description ) ) : ?>
			<p class="cta-description text-xl mb-6"><?php echo esc_html( $cta_description ); ?></p>
		<?php endif; ?>

		<!-- CTA Button -->
		<?php if ( ! empty( $cta_phone ) && ! empty( $cta_button_text ) ) : ?>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $cta_phone ) ); ?>"
				class="btn book-btn inline-block font-bold py-3 px-8 rounded-lg transition duration-300">
				<?php echo esc_html( $cta_button_text ); ?>: <?php echo esc_html( $cta_phone ); ?>
			</a>
		<?php endif; ?>

	</div>
</section>

