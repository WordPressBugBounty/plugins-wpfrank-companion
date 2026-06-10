<?php
/**
 * Technicians Section Template
 * Dynamic template with Kirki customizer integration
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


// Get Book Now URL from theme settings.
$book_now_settings = homerix_get_book_now_settings();
$book_now_url      = $book_now_settings['url'];

// Get customizer settings.
$section_enabled   = get_theme_mod( 'technicians_section_enabled', true );
$section_title     = get_theme_mod( 'technicians_section_title', __( 'Featured Technicians', 'homerix' ) );
$section_subtitle  = get_theme_mod( 'technicians_section_subtitle', __( 'Meet our certified professionals ready to help you', 'homerix' ) );
$layout_columns    = get_theme_mod( 'technicians_layout_columns', 4 );
$container_size    = get_theme_mod( 'technicians_container_size', 'container mx-auto px-4' );
$background_type   = get_theme_mod( 'technicians_background_type', 'theme_colors' );
$background_choice = get_theme_mod( 'technicians_background_choice', 'light' );
$background_color  = get_theme_mod( 'technicians_background_color', '#f8fafc' );
$show_view_all_btn = get_theme_mod( 'technicians_show_view_all_btn', true );
$view_all_btn_text = get_theme_mod( 'technicians_view_all_btn_text', __( 'View All Technicians', 'homerix' ) );
$view_all_btn_url  = get_theme_mod( 'technicians_view_all_btn_url', home_url( '/homerix-find-technician' ) );
$technicians_items = get_theme_mod( 'technicians_items', array() );

// Determine background styling.
$background_style = '';
$background_class = '';

if ( 'theme_colors' === $background_type ) {
	switch ( $background_choice ) {
		case 'main':
			$background_class = 'technicians-bg-main';
			break;
		case 'base':
			$background_class = 'technicians-bg-base';
			break;
		case 'light':
			$background_class = 'technicians-bg-light';
			break;
		case 'primary':
			$background_class = 'technicians-bg-primary';
			break;
		default:
			$background_class = 'technicians-bg-light';
			break;
	}
} else {
	$background_style = 'background: ' . esc_attr( $background_color ) . ';';
}

// Exit if section is disabled.
if ( ! $section_enabled ) {
	return;
}

// Generate grid classes based on column layout.
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
		$grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6';
		break;
}

// Default technicians if none are set.
if ( empty( $technicians_items ) ) {
	$theme_img_url     = defined( 'HOMERIX_URI' ) ? HOMERIX_URI : get_template_directory_uri();
	$technicians_items = array(
		array(
			'technician_enabled'      => true,
			'technician_name'         => __( 'Michael Johnson', 'homerix' ),
			'technician_specialty'    => __( 'Licensed Plumber', 'homerix' ),
			'technician_image'        => $theme_img_url . '/assets/img/technician-1.jpg',
			'technician_rating'       => '4.9',
			'technician_hourly_rate'  => '$85/hr',
			'technician_service_area' => '10 miles radius',
			'technician_book_url'     => $book_now_url,
		),
		array(
			'technician_enabled'      => true,
			'technician_name'         => __( 'Sarah Williams', 'homerix' ),
			'technician_specialty'    => __( 'Master Electrician', 'homerix' ),
			'technician_image'        => $theme_img_url . '/assets/img/about-team-volunteering.jpg',
			'technician_rating'       => '4.8',
			'technician_hourly_rate'  => '$95/hr',
			'technician_service_area' => '15 miles radius',
			'technician_book_url'     => $book_now_url,
		),
		array(
			'technician_enabled'      => true,
			'technician_name'         => __( 'David Rodriguez', 'homerix' ),
			'technician_specialty'    => __( 'HVAC Specialist', 'homerix' ),
			'technician_image'        => $theme_img_url . '/assets/img/technician-3.jpg',
			'technician_rating'       => '5.0',
			'technician_hourly_rate'  => '$110/hr',
			'technician_service_area' => '20 miles radius',
			'technician_book_url'     => $book_now_url,
		),
		array(
			'technician_enabled'      => true,
			'technician_name'         => __( 'James Wilson', 'homerix' ),
			'technician_specialty'    => __( 'Finish Carpenter', 'homerix' ),
			'technician_image'        => $theme_img_url . '/assets/img/technician-4.jpg',
			'technician_rating'       => '4.7',
			'technician_hourly_rate'  => '$75/hr',
			'technician_service_area' => '25 miles radius',
			'technician_book_url'     => $book_now_url,
		),
	);
}

// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$technicians_colors     = apply_filters( 'homerix_technicians_color_overrides', array() );
$color_override_enabled = ! empty( $technicians_colors );

?>

<?php if ( $color_override_enabled ) : ?>
<!-- Technicians Section Color Overrides -->
<style>
	.homerix-technicians {
		background: <?php echo esc_attr( isset( $technicians_colors['section_bg_color'] ) ? $technicians_colors['section_bg_color'] : '#ffffff' ); ?>;
	}
	.homerix-technicians .technicians-title {
		color: <?php echo esc_attr( isset( $technicians_colors['title_color'] ) ? $technicians_colors['title_color'] : '#111827' ); ?>;
	}
	.homerix-technicians .technicians-subtitle {
		color: <?php echo esc_attr( isset( $technicians_colors['subtitle_color'] ) ? $technicians_colors['subtitle_color'] : '#6b7280' ); ?>;
	}
	.homerix-technicians .technician-card {
		background: <?php echo esc_attr( isset( $technicians_colors['card_bg_color'] ) ? $technicians_colors['card_bg_color'] : '#ffffff' ); ?>;
	}
	.homerix-technicians .technician-name {
		color: <?php echo esc_attr( isset( $technicians_colors['name_color'] ) ? $technicians_colors['name_color'] : '#111827' ); ?>;
	}
	.homerix-technicians .technician-specialty {
		color: <?php echo esc_attr( isset( $technicians_colors['designation_color'] ) ? $technicians_colors['designation_color'] : '#2563EB' ); ?>;
	}
	.homerix-technicians .rating-badge i.fa-star,
	.homerix-technicians .technician-rating .fa-star {
		color: <?php echo esc_attr( isset( $technicians_colors['star_color'] ) ? $technicians_colors['star_color'] : '#fbbf24' ); ?>;
	}
	.homerix-technicians .book-btn,
	.homerix-technicians .view-all-btn {
		background: <?php echo esc_attr( isset( $technicians_colors['badge_bg_color'] ) ? $technicians_colors['badge_bg_color'] : '#2563EB' ); ?>;
		color: <?php echo esc_attr( isset( $technicians_colors['badge_text_color'] ) ? $technicians_colors['badge_text_color'] : '#ffffff' ); ?>;
	}
</style>
<?php endif; ?>

<!-- Featured Technicians Section -->
<section id="technicians" class="homerix-technicians py-16 <?php echo esc_attr( $background_class ); ?>"
	<?php
	if ( $background_style ) {
		echo 'style="' . esc_attr( $background_style ) . '"'; }
	?>
>
	<div class="<?php echo esc_attr( $container_size ); ?>">

		<!-- Section Header -->
		<div class="text-center mb-12">
			<?php if ( ! empty( $section_title ) ) : ?>
				<h2 class="technicians-title text-3xl font-bold mb-4"><?php echo esc_html( $section_title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $section_subtitle ) ) : ?>
				<p class="technicians-subtitle text-lg max-w-3xl mx-auto"><?php echo esc_html( $section_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Technicians Grid -->
		<div class="<?php echo esc_attr( $grid_classes ); ?> pt-8 gap-8">
			<?php
			// Inline limit (obfuscated var name).
			$tech_cap          = HOMERIX_IS_PRO() ? 999 : 4;
			$technicians_count = 0;
			$total_enabled     = 0;

			// Count total enabled technicians.
			foreach ( $technicians_items as $technician ) {
				if ( isset( $technician['technician_enabled'] ) && $technician['technician_enabled'] ) {
					++$total_enabled;
				}
			}

			foreach ( $technicians_items as $index => $technician ) :
				// Skip if technician is disabled.
				if ( ! isset( $technician['technician_enabled'] ) || ! $technician['technician_enabled'] ) {
					continue;
				}

				// Check limit.
				++$technicians_count;
				if ( $technicians_count > $tech_cap ) {
					break;
				}

				$technician_name         = isset( $technician['technician_name'] ) ? $technician['technician_name'] : '';
				$technician_specialty    = isset( $technician['technician_specialty'] ) ? $technician['technician_specialty'] : '';
				$technician_image        = isset( $technician['technician_image'] ) ? $technician['technician_image'] : '';
				$technician_rating       = isset( $technician['technician_rating'] ) ? $technician['technician_rating'] : '5.0';
				$technician_hourly_rate  = isset( $technician['technician_hourly_rate'] ) ? $technician['technician_hourly_rate'] : '$85/hr';
				$technician_service_area = isset( $technician['technician_service_area'] ) ? $technician['technician_service_area'] : '10 miles radius';
				$technician_book_url     = isset( $technician['technician_book_url'] ) ? $technician['technician_book_url'] : $book_now_url;

				// Animation delay for staggered effect.
				$delay_class = 'delay-' . ( ( $index + 1 ) * 100 );
				?>

				<!-- Technician Card -->
				<div class="technician-card rounded-lg shadow-md overflow-hidden slide-up <?php echo esc_attr( $delay_class ); ?> transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
					<!-- Technician Image -->
					<div class="relative">
						<?php if ( ! empty( $technician_image ) ) : ?>
							<img src="<?php echo esc_url( $technician_image ); ?>" alt="<?php echo esc_attr( $technician_name ); ?>" class="w-full h-48 object-cover">
						<?php else : ?>
							<div class="w-full h-48 flex items-center justify-center">
								<i class="fas fa-user text-4xl"></i>
							</div>
						<?php endif; ?>

						<!-- Rating Badge -->
						<?php if ( ! empty( $technician_rating ) ) : ?>
							<div class="rating-badge absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-bold flex items-center">
								<i class="fas fa-star mr-1"></i> <?php echo esc_html( $technician_rating ); ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Technician Info -->
					<div class="p-6">
						<?php if ( ! empty( $technician_name ) ) : ?>
							<h3 class="technician-name text-xl font-bold mb-1"><?php echo esc_html( $technician_name ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $technician_specialty ) ) : ?>
							<p class="technician-specialty mb-2"><?php echo esc_html( $technician_specialty ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $technician_service_area ) ) : ?>
							<div class="flex mb-4">
								<i class="fas fa-map-marker-alt text-muted-light mr-2"></i>
								<span class="technician-service-area">Serving: <?php echo esc_html( $technician_service_area ); ?></span>
							</div>
						<?php endif; ?>

						<!-- Rate and Book Button -->
						<div class="flex justify-between items-center">
							<?php if ( ! empty( $technician_hourly_rate ) ) : ?>
								<span class="technician-rate font-bold"><?php echo esc_html( $technician_hourly_rate ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $technician_book_url ) ) : ?>
								<?php
								// Build Book Now URL with technician info (matching Find Technician page pattern).
								$tech_book_url = add_query_arg(
									array(
										'technician' => $technician_name,
										'specialty'  => $technician_specialty,
									),
									$technician_book_url
								);
								?>
								<a href="<?php echo esc_url( $tech_book_url ); ?>" class="btn book-btn px-4 py-2 rounded-lg text-sm transition duration-300">
									<?php esc_html_e( 'Book Now', 'homerix' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<?php
			endforeach;

			// Show upgrade message if there are more technicians than the limit allows.
			if ( ! HOMERIX_IS_PRO() && $total_enabled > $tech_cap ) :
				?>
			<!-- Pro Upgrade Notice -->
			<div class="technician-card rounded-lg shadow-md overflow-hidden bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-dashed border-purple-200">
				<div class="p-8 text-center">
					<div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
						<i class="fas fa-users text-white text-2xl"></i>
					</div>
					<h3 class="text-xl font-bold mb-2 text-purple-800">
						<?php
						/* translators: %d: number of additional technicians */
						echo esc_html( sprintf( __( '+%d More Technicians', 'homerix' ), $total_enabled - $tech_cap ) );
						?>
					</h3>
					<p class="text-purple-600 mb-4"><?php esc_html_e( 'Showcase your entire team', 'homerix' ); ?></p>
					<a href="<?php echo esc_url( homerix_get_pro_url( 'technicians-section', 'upgrade-card' ) ); ?>" target="_blank" class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium px-6 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
						<?php esc_html_e( 'Upgrade to Pro', 'homerix' ); ?>
					</a>
				</div>
			</div>
			<?php endif; ?>
		</div>

		<!-- View All Button -->
		<?php if ( $show_view_all_btn && ! empty( $view_all_btn_text ) && ! empty( $view_all_btn_url ) ) : ?>
			<div class="view-all-container text-center mt-16 mb-8">
				<a href="<?php echo esc_url( $view_all_btn_url ); ?>" class="btn view-all-btn inline-block font-bold py-3 px-6 rounded-lg transition duration-300">
					<?php echo esc_html( $view_all_btn_text ); ?>
				</a>
			</div>
		<?php endif; ?>

	</div>
</section>
