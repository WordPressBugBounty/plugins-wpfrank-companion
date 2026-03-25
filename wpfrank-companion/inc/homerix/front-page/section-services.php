<?php
/**
 * Enhanced Services Section Template Part
 * Uses Kirki customizer settings for dynamic content
 */

// Get customizer settings.
$section_enabled = get_theme_mod( 'services_section_enabled', true );

// Exit if section is disabled.
if ( ! $section_enabled ) {
	return;
}

// Container size setting.
$container_size = get_theme_mod( 'services_container_size', 'container mx-auto px-4' );

$section_title     = get_theme_mod( 'services_section_title', __( 'Our Popular Services', 'homerix' ) );
$section_subtitle  = get_theme_mod( 'services_section_subtitle', __( 'Professional home repair and maintenance services you can trust', 'homerix' ) );
$layout_columns    = get_theme_mod( 'services_layout_columns', 4 );
$show_view_all_btn = get_theme_mod( 'services_show_view_all_btn', true );
$view_all_btn_text = get_theme_mod( 'services_view_all_btn_text', __( 'View All Services', 'homerix' ) );
$view_all_btn_url  = get_theme_mod( 'services_view_all_btn_url', home_url( '/homerix-services' ) );

// Get services items.
$services_items = get_theme_mod( 'services_items', array() );

// Fallback to default services if none set.
if ( empty( $services_items ) ) {
	$services_items = array(
		array(
			'service_enabled'     => true,
			'service_title'       => __( 'Plumbing', 'homerix' ),
			'service_description' => __( 'Leaky faucets, pipe repairs, drain cleaning, and more from certified plumbers.', 'homerix' ),
			'service_icon'        => 'fas fa-faucet',
			'service_link_url'    => home_url( '/homerix-services' ),
			'service_link_text'   => __( 'Learn More', 'homerix' ),
			'service_link_target' => '_self',
		),
		array(
			'service_enabled'     => true,
			'service_title'       => __( 'Electrical', 'homerix' ),
			'service_description' => __( 'Wiring, lighting, panel upgrades, and electrical repairs by licensed electricians.', 'homerix' ),
			'service_icon'        => 'fas fa-bolt',
			'service_link_url'    => home_url( '/homerix-services' ),
			'service_link_text'   => __( 'Learn More', 'homerix' ),
			'service_link_target' => '_self',
		),
		array(
			'service_enabled'     => true,
			'service_title'       => __( 'HVAC', 'homerix' ),
			'service_description' => __( 'Heating, ventilation, and air conditioning installation, repair, and maintenance.', 'homerix' ),
			'service_icon'        => 'fas fa-fire',
			'service_link_url'    => home_url( '/homerix-services' ),
			'service_link_text'   => __( 'Learn More', 'homerix' ),
			'service_link_target' => '_self',
		),
		array(
			'service_enabled'     => true,
			'service_title'       => __( 'Carpentry', 'homerix' ),
			'service_description' => __( 'Custom woodwork, furniture repair, framing, and finish carpentry services.', 'homerix' ),
			'service_icon'        => 'fas fa-hammer',
			'service_link_url'    => home_url( '/homerix-services' ),
			'service_link_text'   => __( 'Learn More', 'homerix' ),
			'service_link_target' => '_self',
		),
	);
}

// Generate grid classes based on column setting
$grid_classes = 'grid grid-cols-1 sm:grid-cols-2';
switch ( $layout_columns ) {
	case 2:
		$grid_classes .= ' lg:grid-cols-2';
		break;
	case 3:
		$grid_classes .= ' lg:grid-cols-3';
		break;
	case 4:
		$grid_classes .= ' lg:grid-cols-4';
		break;
	case 6:
		$grid_classes .= ' lg:grid-cols-6';
		break;
	default:
		$grid_classes .= ' lg:grid-cols-4';
}

// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$services_colors        = apply_filters( 'homerix_services_color_overrides', array() );
$color_override_enabled = ! empty( $services_colors );

?>

<?php if ( $color_override_enabled ) : ?>
<!-- Services Section Color Overrides -->
<style>
	.homerix-services {
		background: <?php echo esc_attr( $services_colors['section_bg_color'] ); ?>;
	}
	.homerix-services .service-title {
		color: <?php echo esc_attr( $services_colors['title_color'] ); ?>;
	}
	.homerix-services .service-desc {
		color: <?php echo esc_attr( $services_colors['subtitle_color'] ); ?>;
	}
	.homerix-services .service-card {
		background: <?php echo esc_attr( $services_colors['card_bg_color'] ); ?>;
	}
	.homerix-services .service-icon-container {
		background: <?php echo esc_attr( $services_colors['icon_bg_color'] ); ?>;
	}
	.homerix-services .service-icon {
		color: <?php echo esc_attr( $services_colors['icon_color'] ); ?>;
	}
	.homerix-services .service-text h3 {
		color: <?php echo esc_attr( $services_colors['card_title_color'] ); ?>;
	}
	.homerix-services .service-text p {
		color: <?php echo esc_attr( $services_colors['card_desc_color'] ); ?>;
	}
	.homerix-services .link-color {
		color: <?php echo esc_attr( $services_colors['link_color'] ); ?> !important;
	}
	.homerix-services .link-color:hover {
		color: <?php echo esc_attr( $services_colors['link_hover_color'] ); ?> !important;
	}
</style>
<?php endif; ?>

<!-- Enhanced Services Section -->
<section class="homerix-services py-16">
	<div class="<?php echo esc_attr( $container_size ); ?> my-8">
		<!-- Section Header -->
		<div class="text-center mb-12">
			<?php if ( ! empty( $section_title ) ) : ?>
				<h2 class="service-title text-3xl font-bold mb-4"><?php echo esc_html( $section_title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $section_subtitle ) ) : ?>
				<p class="service-desc text-lg max-w-3xl mx-auto"><?php echo esc_html( $section_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Services Grid -->
		<div class="<?php echo esc_attr( $grid_classes ); ?> gap-8 my-16">
			<?php
			// Loop through services items.
			if ( ! empty( $services_items ) && is_array( $services_items ) ) :
				$delay_counter = 100;
				// Inline limit (different var name for obfuscation).
				$svc_max        = HOMERIX_IS_PRO() ? 999 : 4;
				$services_count = 0;
				$total_enabled  = 0;

				// Count total enabled services for showing upgrade message.
				foreach ( $services_items as $service ) {
					if ( ! empty( $service['service_enabled'] ) ) {
						$total_enabled++;
					}
				}

				foreach ( $services_items as $service ) :
					// Skip if service is disabled.
					if ( empty( $service['service_enabled'] ) ) {
						continue;
					}

					// Check limit.
					$services_count++;
					if ( $services_count > $svc_max ) {
						break;
					}

					// Get service data with fallbacks.
					$service_title       = ! empty( $service['service_title'] ) ? $service['service_title'] : __( 'Service', 'homerix' );
					$service_description = ! empty( $service['service_description'] ) ? $service['service_description'] : '';
					$service_icon_type   = ! empty( $service['service_icon_type'] ) ? $service['service_icon_type'] : 'icon';
					$service_icon        = ! empty( $service['service_icon'] ) ? $service['service_icon'] : 'fas fa-tools';
					$service_image       = ! empty( $service['service_image'] ) ? $service['service_image'] : '';
					$service_link_url    = ! empty( $service['service_link_url'] ) ? $service['service_link_url'] : home_url( '/homerix-services' );
					$service_link_text   = isset( $service['service_link_text'] ) ? $service['service_link_text'] : __( 'Learn More', 'homerix' );
					$service_link_target = ! empty( $service['service_link_target'] ) ? $service['service_link_target'] : '_self';

					// Generate target attribute.
					$target_attr = ( $service_link_target === '_blank' ) ? ' target="_blank" rel="noopener"' : '';
					?>
					<!-- Dynamic Service Card -->
					<div class="service-card rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
						<div class="service-icon-container p-8 min-h-[120px] flex items-center justify-center">
							<?php if ( 'image' === $service_icon_type && ! empty( $service_image ) ) : ?>
								<img src="<?php echo esc_url( $service_image ); ?>" alt="<?php echo esc_attr( $service_title ); ?>" class="service-image w-16 h-16 object-contain transition-transform duration-300 hover:scale-110">
							<?php else : ?>
								<i class="service-icon <?php echo esc_attr( $service_icon ); ?> text-5xl transition-transform duration-300 hover:scale-110" aria-hidden="true"></i>
							<?php endif; ?>
						</div>
						<div class="service-text p-6 flex flex-col h-auto">
							<h3 class="text-xl font-bold mb-2"><?php echo esc_html( $service_title ); ?></h3>
							<?php if ( ! empty( $service_description ) ) : ?>
								<p class="mb-4 flex-grow"><?php echo esc_html( $service_description ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $service_link_text ) && $service_link_url !== '#' ) : ?>
								<a href="<?php echo esc_url( $service_link_url ); ?>" class="link-color font-medium flex items-center transition-colors duration-300"<?php echo wp_kses_post( $target_attr ); ?>>
									<?php echo esc_html( $service_link_text ); ?> <i class="fas fa-arrow-right ml-2 text-sm" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
						</div>
					</div>
					<?php
					$delay_counter += 100;
				endforeach;
			endif;

			// Show upgrade message if there are more services than the limit allows.
			if ( ! HOMERIX_IS_PRO() && $total_enabled > $svc_max ) :
				?>
			<!-- Pro Upgrade Notice -->
			<div class="service-card rounded-lg shadow-md overflow-hidden bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-dashed border-purple-200">
				<div class="p-8 text-center">
					<div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
						<i class="fas fa-lock text-white text-2xl"></i>
					</div>
					<h3 class="text-xl font-bold mb-2 text-purple-800"><?php echo esc_html( sprintf( __( '+%d More Services', 'homerix' ), $total_enabled - $svc_max ) ); ?></h3>
					<p class="text-purple-600 mb-4"><?php esc_html_e( 'Upgrade to Pro for unlimited services', 'homerix' ); ?></p>
					<a href="<?php echo esc_url( homerix_get_pro_url( 'services-section', 'upgrade-card' ) ); ?>" target="_blank" class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium px-6 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
						<?php esc_html_e( 'Upgrade to Pro', 'homerix' ); ?>
					</a>
				</div>
			</div>
			<?php endif; ?>
		</div>

		<?php if ( $show_view_all_btn && ! empty( $view_all_btn_url ) ) : ?>
			<!-- View All Button -->
			<div class="text-center mt-12">
				<a href="<?php echo esc_url( $view_all_btn_url ); ?>" class="btn book-btn inline-flex items-center px-6 py-3 rounded-lg font-medium transition duration-300">
					<?php echo esc_html( $view_all_btn_text ); ?>
					<!-- <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i> -->
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
