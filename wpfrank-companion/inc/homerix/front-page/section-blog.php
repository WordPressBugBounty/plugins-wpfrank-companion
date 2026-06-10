<?php
/**
 * Blog Section Template Part
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


// Get customizer settings.
$section_enabled = get_theme_mod( 'blog_section_enabled', true );
$section_title   = get_theme_mod( 'blog_title', __( 'Latest Tips & Advice', 'homerix' ) );
$posts_count     = get_theme_mod( 'blog_count', 3 );
$layout_columns  = get_theme_mod( 'blog_layout_columns', 3 );
$button_text     = get_theme_mod( 'blog_button_text', __( 'Read More Articles', 'homerix' ) );
$container_size  = get_theme_mod( 'blog_container_size', 'container mx-auto px-4' );
// Color Overrides - provided by Pro plugin via filter (empty array if no Pro).
$blog_colors            = apply_filters( 'homerix_blog_color_overrides', array() );
$color_override_enabled = ! empty( $blog_colors );

// Post display settings.
$show_image     = get_theme_mod( 'blog_show_image', true );
$show_category  = get_theme_mod( 'blog_show_category', true );
$show_date      = get_theme_mod( 'blog_show_date', true );
$show_excerpt   = get_theme_mod( 'blog_show_excerpt', true );
$excerpt_length = get_theme_mod( 'blog_excerpt_length', 20 );
$show_author    = get_theme_mod( 'blog_show_author', true );
$show_read_more = get_theme_mod( 'blog_show_read_more', true );

// Return if section is disabled or blog page is not set.
if ( ! $section_enabled || ! get_option( 'page_for_posts' ) ) {
	return;
}

// Generate grid classes based on column setting.
$grid_classes = 'grid grid-cols-1 md:grid-cols-2';
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
	case 5:
		$grid_classes .= ' lg:grid-cols-5';
		break;
	case 6:
		$grid_classes .= ' lg:grid-cols-6';
		break;
	default:
		$grid_classes .= ' lg:grid-cols-3';
}

// Get color override values from filter data.
$section_bg_color    = $color_override_enabled && isset( $blog_colors['section_bg_color'] ) ? $blog_colors['section_bg_color'] : '';
$title_color         = $color_override_enabled && isset( $blog_colors['title_color'] ) ? $blog_colors['title_color'] : '';
$card_bg_color       = $color_override_enabled && isset( $blog_colors['card_bg_color'] ) ? $blog_colors['card_bg_color'] : '';
$post_title_color    = $color_override_enabled && isset( $blog_colors['post_title_color'] ) ? $blog_colors['post_title_color'] : '';
$category_bg_color   = $color_override_enabled && isset( $blog_colors['category_bg_color'] ) ? $blog_colors['category_bg_color'] : '';
$category_text_color = $color_override_enabled && isset( $blog_colors['category_text_color'] ) ? $blog_colors['category_text_color'] : '';
$date_color          = $color_override_enabled && isset( $blog_colors['date_color'] ) ? $blog_colors['date_color'] : '';
$excerpt_color       = $color_override_enabled && isset( $blog_colors['excerpt_color'] ) ? $blog_colors['excerpt_color'] : '';
$author_color        = $color_override_enabled && isset( $blog_colors['author_color'] ) ? $blog_colors['author_color'] : '';
$button_bg_color     = $color_override_enabled && isset( $blog_colors['button_bg_color'] ) ? $blog_colors['button_bg_color'] : '';
$button_text_color   = $color_override_enabled && isset( $blog_colors['button_text_color'] ) ? $blog_colors['button_text_color'] : '';
$link_color          = $color_override_enabled && isset( $blog_colors['link_color'] ) ? $blog_colors['link_color'] : '';
$link_hover_color    = $color_override_enabled && isset( $blog_colors['link_hover_color'] ) ? $blog_colors['link_hover_color'] : '';

// Build button inline style content.
$button_style_content = '';
if ( $button_bg_color ) {
	$button_style_content .= 'background: ' . $button_bg_color . ';';
}
if ( $button_text_color ) {
	$button_style_content .= ' color: ' . $button_text_color . ';';
}

?>

<?php if ( $color_override_enabled && ( $card_bg_color || $post_title_color || $category_bg_color || $category_text_color || $date_color || $excerpt_color || $author_color || $link_color || $link_hover_color ) ) : ?>
<!-- Blog Section Styles (for child elements and pseudo-classes) -->
<style>
	<?php if ( $card_bg_color ) : ?>
		.homerix-blog-section .blog-card { background: <?php echo esc_attr( $card_bg_color ); ?>; }
	<?php endif; ?>
	<?php if ( $post_title_color ) : ?>
		.homerix-blog-section .blog-post-title-link { color: <?php echo esc_attr( $post_title_color ); ?>; }
	<?php endif; ?>
	<?php if ( $category_bg_color ) : ?>
		.homerix-blog-section .blog-category-badge { background: <?php echo esc_attr( $category_bg_color ); ?>; }
	<?php endif; ?>
	<?php if ( $category_text_color ) : ?>
		.homerix-blog-section .blog-category-badge { color: <?php echo esc_attr( $category_text_color ); ?>; }
	<?php endif; ?>
	<?php if ( $date_color ) : ?>
		.homerix-blog-section .blog-date { color: <?php echo esc_attr( $date_color ); ?>; }
	<?php endif; ?>
	<?php if ( $excerpt_color ) : ?>
		.homerix-blog-section .blog-excerpt { color: <?php echo esc_attr( $excerpt_color ); ?>; }
	<?php endif; ?>
	<?php if ( $author_color ) : ?>
		.homerix-blog-section .blog-author { color: <?php echo esc_attr( $author_color ); ?>; }
	<?php endif; ?>
	<?php if ( $link_color ) : ?>
		.homerix-blog-section .blog-read-more { color: <?php echo esc_attr( $link_color ); ?>; }
	<?php endif; ?>
	<?php if ( $link_hover_color ) : ?>
		.homerix-blog-section .blog-read-more:hover { color: <?php echo esc_attr( $link_hover_color ); ?>; }
	<?php endif; ?>
</style>
<?php endif; ?>

<section class="homerix-blog-section py-16"<?php echo $section_bg_color ? ' style="background: ' . esc_attr( $section_bg_color ) . ';"' : ''; ?>>
	<div class="<?php echo esc_attr( $container_size ); ?>">

		<!-- Section Header -->
		<?php if ( ! empty( $section_title ) ) : ?>
		<div class="text-center mb-12">
			<h2 class="blog-title text-3xl font-bold"<?php echo $title_color ? ' style="color: ' . esc_attr( $title_color ) . ';"' : ''; ?>><?php echo esc_html( $section_title ); ?></h2>
		</div>
		<?php endif; ?>
		<!-- Blog Posts Grid -->
		<div class="<?php echo esc_attr( $grid_classes ); ?> gap-8">
			<?php
			$recent_posts = new WP_Query(
				array(
					'posts_per_page' => $posts_count,
					'post_status'    => 'publish',
				)
			);

			if ( $recent_posts->have_posts() ) :
				while ( $recent_posts->have_posts() ) :
					$recent_posts->the_post();

					// Pass display settings to blog-card template.
					set_query_var( 'blog_show_image', $show_image );
					set_query_var( 'blog_show_category', $show_category );
					set_query_var( 'blog_show_date', $show_date );
					set_query_var( 'blog_show_excerpt', $show_excerpt );
					set_query_var( 'blog_excerpt_length', $excerpt_length );
					set_query_var( 'blog_show_author', $show_author );
					set_query_var( 'blog_show_read_more', $show_read_more );

					get_template_part( 'template-parts/blog', 'card' );
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<!-- View All Button -->
		<?php if ( ! empty( $button_text ) ) : ?>
		<div class="text-center mt-12">
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn book-btn px-8 py-3 rounded-lg transition duration-300"<?php echo $button_style_content ? ' style="' . esc_attr( $button_style_content ) . '"' : ''; ?>>
				<?php echo esc_html( $button_text ); ?>
			</a>
		</div>
		<?php endif; ?>
	</div>
</section>
