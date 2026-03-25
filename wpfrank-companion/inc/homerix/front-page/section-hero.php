<?php
/**
 * Enhanced Hero Section Template Part
 * Always uses slider mode - users can add single slide for static effect
 */

// Get customizer settings.
$section_enabled = get_theme_mod( 'hero_section_enabled', true );

// Exit if section is disabled.
if ( ! $section_enabled ) {
	return;
}

// Slider variables.
$slider_slides           = get_theme_mod( 'hero_slider_slides', array() );
$slider_autoplay         = get_theme_mod( 'hero_slider_autoplay', true );
$slider_navigation       = get_theme_mod( 'hero_slider_navigation', true );
$slider_navigation_hover = get_theme_mod( 'hero_slider_navigation_hover', true );
$slider_speed            = get_theme_mod( 'hero_slider_speed', 5 );
$slider_effect           = get_theme_mod( 'hero_slider_effect', 'slide' );
$hero_show_search        = get_theme_mod( 'hero_show_search', true );

// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$hero_colors            = apply_filters( 'homerix_hero_color_overrides', array() );
$color_override_enabled = ! empty( $hero_colors );

// Get dynamic defaults from theme colors.
$hero_defaults = function_exists( 'homerix_get_section_color_defaults' ) ? homerix_get_section_color_defaults( 'hero' ) : array();

// Debug: Check if we have slides data (remove this in production).
if ( current_user_can( 'manage_options' ) && isset( $_GET['debug_slides'] ) ) {
	echo '<pre style="background: #000; color: #0f0; padding: 10px; margin: 10px; z-index: 9999; position: relative;">';
	echo 'Slider Slides Data: ' . print_r( $slider_slides, true );
	echo '</pre>';
}
?>

	<?php if ( $color_override_enabled ) : ?>
	<!-- Hero Section Color Overrides -->
	<style>
		.hero-section .hero-title {
			color: <?php echo esc_attr( $hero_colors['title_color'] ); ?>;
		}
		.hero-section .hero-subs {
			color: <?php echo esc_attr( $hero_colors['subtitle_color'] ); ?>;
		}
		.hero-section .book-btn {
			background: <?php echo esc_attr( $hero_colors['button1_bg_color'] ); ?>;
			color: <?php echo esc_attr( $hero_colors['button1_text_color'] ); ?>;
		border: 1px solid <?php echo esc_attr( $hero_colors['button1_bg_color'] ); ?>;
		}
		.hero-section .book-btn:hover {
			background: <?php echo esc_attr( $hero_colors['button1_text_color'] ); ?>;
			color: <?php echo esc_attr( $hero_colors['button1_bg_color'] ); ?>;
		border: 1px solid <?php echo esc_attr( $hero_colors['button1_bg_color'] ); ?>;
		}
		.hero-section .find-btn {
			background: <?php echo esc_attr( $hero_colors['button2_bg_color'] ); ?>;
			color: <?php echo esc_attr( $hero_colors['button2_text_color'] ); ?>;
		border: 1px solid <?php echo esc_attr( $hero_colors['button2_text_color'] ); ?>;
		}
		.hero-section .find-btn:hover {
			background: <?php echo esc_attr( $hero_colors['button2_text_color'] ); ?>;
			color: <?php echo esc_attr( $hero_colors['button2_bg_color'] ); ?>;
		border: 1px solid <?php echo esc_attr( $hero_colors['button2_bg_color'] ); ?>;
		}
		.hero-section .swiper-button-next,
		.hero-section .swiper-button-prev {
			color: <?php echo esc_attr( $hero_colors['arrow_color'] ); ?>;
		}
		.hero-section .search-submit {
			background: <?php echo esc_attr( $hero_colors['search_button_bg_color'] ); ?>;
			color: <?php echo esc_attr( $hero_colors['search_button_text_color'] ); ?>;
		}
		.hero-section .swiper-pagination-bullet {
			background: <?php echo esc_attr( $hero_colors['pagination_color'] ); ?>;
		}
		.hero-section .swiper-pagination-bullet-active {
			background: <?php echo esc_attr( $hero_colors['pagination_active_color'] ); ?>;
		}
	</style>
	<?php endif; ?>

	<!-- Hero Slider Section -->
	<section id="home" class="hero-section hero-slider relative">
		<div class="swiper homerix-hero-swiper">
			<div class="swiper-wrapper">
				<?php
				// Slide limit for free version (different var name for obfuscation).
				$max_hero_items = HOMERIX_IS_PRO() ? 999 : 3;
				$rendered_count = 0;
				$enabled_total  = 0;

				// Ensure we have slides data, if not use defaults.
				if ( empty( $slider_slides ) || ! is_array( $slider_slides ) ) {
					$slider_slides = array(
						array(
							'slide_enabled'    => true,
							'slide_title'      => __( 'Professional Home Repair Services', 'homerix' ),
							'slide_subtitle'   => __( 'Fast, reliable, and affordable services in your area', 'homerix' ),
							'media_type'       => 'image',
							'background_image' => get_template_directory_uri() . '/assets/img/hero-bg.jpg',
							'background_video' => '',
							'button1_enabled'  => true,
							'button1_text'     => __( 'Book Now', 'homerix' ),
							'button1_url'      => home_url( '/homerix-book-now' ),
							'button2_enabled'  => true,
							'button2_text'     => __( 'Find a Technician', 'homerix' ),
							'button2_url'      => home_url( '/homerix-find-a-technician' ),
							'overlay_enabled'  => true,
							'overlay_opacity'  => 40,
						),
						array(
							'slide_enabled'    => true,
							'slide_title'      => __( 'Expert Technicians Available 24/7', 'homerix' ),
							'slide_subtitle'   => __( 'Emergency repairs and scheduled maintenance services', 'homerix' ),
							'media_type'       => 'image',
							'background_image' => get_template_directory_uri() . '/assets/img/about-3.jpg',
							'background_video' => '',
							'button1_enabled'  => true,
							'button1_text'     => __( 'Emergency Service', 'homerix' ),
							'button1_url'      => '#',
							'button2_enabled'  => false,
							'button2_text'     => '',
							'button2_url'      => '',
							'overlay_enabled'  => true,
							'overlay_opacity'  => 50,
						),
						array(
							'slide_enabled'    => true,
							'slide_title'      => __( 'Trusted by Thousands of Homeowners', 'homerix' ),
							'slide_subtitle'   => __( 'Quality workmanship with satisfaction guarantee', 'homerix' ),
							'media_type'       => 'image',
							'background_image' => get_template_directory_uri() . '/assets/img/about-bg.jpg',
							'background_video' => '',
							'button1_enabled'  => true,
							'button1_text'     => __( 'Get Quote', 'homerix' ),
							'button1_url'      => '#',
							'button2_enabled'  => true,
							'button2_text'     => __( 'View Portfolio', 'homerix' ),
							'button2_url'      => '#',
							'overlay_enabled'  => true,
							'overlay_opacity'  => 45,
						),
					);
				}

				if ( ! empty( $slider_slides ) && is_array( $slider_slides ) ) :
					// Count enabled slides first.
					foreach ( $slider_slides as $s ) {
						if ( ! isset( $s['slide_enabled'] ) || $s['slide_enabled'] ) {
							$enabled_total++;
						}
					}

					foreach ( $slider_slides as $slide ) :
						// Skip disabled slides.
						if ( isset( $slide['slide_enabled'] ) && ! $slide['slide_enabled'] ) {
							continue;
						}

						// Check slide limit.
						$rendered_count++;
						if ( $rendered_count > $max_hero_items ) {
							break;
						}

						$slide_title      = isset( $slide['slide_title'] ) ? $slide['slide_title'] : '';
						$slide_subtitle   = isset( $slide['slide_subtitle'] ) ? $slide['slide_subtitle'] : '';
						$media_type       = isset( $slide['media_type'] ) ? $slide['media_type'] : 'image';
						$background_image = isset( $slide['background_image'] ) ? $slide['background_image'] : '';
						$background_video = isset( $slide['background_video'] ) ? $slide['background_video'] : '';
						$overlay_enabled  = isset( $slide['overlay_enabled'] ) ? $slide['overlay_enabled'] : true;
						$overlay_opacity  = isset( $slide['overlay_opacity'] ) ? ( is_numeric( $slide['overlay_opacity'] ) ? intval( $slide['overlay_opacity'] ) : 40 ) : 40;

						// Button settings.
						$button1_enabled = isset( $slide['button1_enabled'] ) ? $slide['button1_enabled'] : true;
						$button1_text    = isset( $slide['button1_text'] ) ? $slide['button1_text'] : '';
						$button1_url     = isset( $slide['button1_url'] ) ? $slide['button1_url'] : '#';
						$button2_enabled = isset( $slide['button2_enabled'] ) ? $slide['button2_enabled'] : true;
						$button2_text    = isset( $slide['button2_text'] ) ? $slide['button2_text'] : '';
						$button2_url     = isset( $slide['button2_url'] ) ? $slide['button2_url'] : '#';

						// Auto-detect video platform if media_type is video.
						if ( ! empty( $background_video ) && 'video' === $media_type ) {
							$detected_platform = homerix_detect_video_platform( $background_video );
							if ( 'unknown' !== $detected_platform ) {
								$media_type = $detected_platform;
							}
						}

						// Skip empty slides.
						if ( empty( $slide_title ) && empty( $slide_subtitle ) && empty( $background_image ) && empty( $background_video ) ) {
							continue;
						}
						?>
				<div class="swiper-slide">
					<div class="hero-slide-content flex items-center justify-center hero-text-light relative min-h-screen">
						<!-- Background Media -->
						<?php if ( in_array( $media_type, array( 'video', 'youtube', 'vimeo', 'dailymotion', 'wistia', 'html5' ) ) && ! empty( $background_video ) ) : ?>
							<?php
							// Generate video embed HTML.
							$video_html = homerix_get_video_embed_html( $background_video, $media_type, $overlay_opacity );
							if ( ! empty( $video_html ) ) {
								// Use wp_kses with iframe and video allowed tags.
								$allowed_html = array(
									'iframe' => array(
										'src'             => array(),
										'class'           => array(),
										'frameborder'     => array(),
										'allow'           => array(),
										'allowfullscreen' => array(),
										'style'           => array(),
									),
									'video'  => array(
										'class'       => array(),
										'autoplay'    => array(),
										'muted'       => array(),
										'loop'        => array(),
										'playsinline' => array(),
									),
									'source' => array(
										'src'  => array(),
										'type' => array(),
									),
								);
								echo wp_kses( $video_html, $allowed_html );
							}
							?>
							<?php if ( $overlay_enabled ) : ?>
								<div class="absolute inset-0 hero-overlay" style="opacity: <?php echo esc_attr( $overlay_opacity / 100 ); ?>;"></div>
							<?php endif; ?>
						<?php elseif ( ! empty( $background_image ) ) : ?>
							<div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
								style="background-image: url('<?php echo esc_url( $background_image ); ?>');">
							</div>
							<?php if ( $overlay_enabled ) : ?>
								<div class="absolute inset-0 hero-overlay" style="opacity: <?php echo esc_attr( $overlay_opacity / 100 ); ?>;"></div>
							<?php endif; ?>
						<?php else : ?>
							<div class="absolute inset-0 bg-gradient-to-r hero-overlay bg-opacity-20"></div>
						<?php endif; ?>

						<!-- Content -->
						<div class="container mx-auto px-4 text-center relative z-10">
							<?php if ( ! empty( $slide_title ) ) : ?>
								<h1 class="hero-title text-4xl md:text-5xl font-bold mb-4 animate-fade-in">
									<?php echo esc_html( $slide_title ); ?>
								</h1>
							<?php endif; ?>

							<?php if ( ! empty( $slide_subtitle ) ) : ?>
								<p class="hero-subs text-xl md:text-2xl mb-8 animate-fade-in delay-100">
									<?php echo esc_html( $slide_subtitle ); ?>
								</p>
							<?php endif; ?>

							<?php if ( ( $button1_enabled && $button1_text ) || ( $button2_enabled && $button2_text ) ) : ?>
							<div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in delay-200">
								<?php if ( $button1_enabled && $button1_text ) : ?>
									<a href="<?php echo esc_url( $button1_url ); ?>" class="btn book-btn text-black font-bold py-3 px-6 rounded-lg transition duration-300">
										<?php echo esc_html( $button1_text ); ?>
									</a>
								<?php endif; ?>

								<?php if ( $button2_enabled && $button2_text ) : ?>
									<a href="<?php echo esc_url( $button2_url ); ?>" class="btn find-btn font-bold py-3 px-6 rounded-lg transition duration-300">
										<?php echo esc_html( $button2_text ); ?>
									</a>
								<?php endif; ?>
							</div>
							<?php endif; ?>

							<?php if ( $hero_show_search ) : ?>
							<div class="mt-8 max-w-2xl mx-auto animate-fade-in delay-300">
								<?php get_search_form(); ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
						<?php
				endforeach;
				else :
					?>
					<!-- Default slide when no slides are configured -->
					<div class="swiper-slide">
						<div class="hero-slide-content flex items-center justify-center hero-text-light relative min-h-screen">
							<div class="absolute inset-0 bg-gradient-to-r"></div>
							<div class="container mx-auto px-4 text-center relative z-10">
								<h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in">
									<?php echo esc_html__( 'Welcome to Homerix Pro', 'homerix' ); ?>
								</h1>
								<p class="text-xl md:text-2xl mb-8 animate-fade-in delay-100">
									<?php echo esc_html__( 'Configure your hero slides in the customizer', 'homerix' ); ?>
								</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- Navigation -->
	  <?php if ( $slider_navigation_hover ) : ?>
		<style>
		  .homerix-hero-swiper .swiper-button-next,
		.homerix-hero-swiper .swiper-button-prev {
			  opacity: 0;
			  transition: opacity 0.3s ease;
		  }
		  .homerix-hero-swiper:hover .swiper-button-next,
		  .homerix-hero-swiper:hover .swiper-button-prev {
			  opacity: 1;
		  }
		</style>
	  <?php endif; ?>
			<div class="swiper-pagination"></div>
			<?php if ( $slider_navigation ) : ?>
				<div class="swiper-button-next" aria-label="Next slide"></div>
				<div class="swiper-button-prev" aria-label="Previous slide"></div>
			<?php endif; ?>
		</div>
	</section>

