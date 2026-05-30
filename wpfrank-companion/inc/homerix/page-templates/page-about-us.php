<?php
/**
 * Template Name: Homerix About Us
 * Template Post Type: page
 *
 * About Us page template for Homerix Pro theme.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" tabindex="-1" class="site-main">

<?php

// Get customizer settings.
$hero_title           = get_theme_mod( 'about_hero_title', __( 'Our Story', 'homerix' ) );
$hero_subtitle        = get_theme_mod( 'about_hero_subtitle', __( 'Building trust one repair at a time since 2010', 'homerix' ) );
$hero_btn_text        = get_theme_mod( 'about_hero_button_text', __( 'Learn About Our Mission', 'homerix' ) );
$hero_btn_url         = get_theme_mod( 'about_hero_button_url', '#our-mission' );
$hero_bg_color        = get_theme_mod( 'about_hero_bg_color', '#2563EB' );
$hero_bg_image        = get_theme_mod( 'about_hero_bg_image', get_template_directory_uri() . '/assets/img/about-bg.jpg' );
$hero_overlay_enabled = get_theme_mod( 'about_hero_overlay_enabled', true );
$hero_overlay_opacity = get_theme_mod( 'about_hero_overlay_opacity', 40 );

// Button visibility from toggle settings.
$show_hero_btn = get_theme_mod( 'about_hero_button_enabled', true );
?>

<!-- About Hero Section -->
<section class="about-hero py-24 relative overflow-hidden" style="background: <?php echo esc_attr( $hero_bg_color ); ?>; <?php echo ! empty( $hero_bg_image ) ? 'background-image: url(' . esc_url( $hero_bg_image ) . '); background-size: cover; background-position: center;' : ''; ?>">
  <?php if ( $hero_overlay_enabled ) : ?>
		<div class="absolute inset-0 bg-black z-0" style="opacity: <?php echo esc_attr( $hero_overlay_opacity / 100 ); ?>;"></div>
	<?php endif; ?>
	<div class="container mx-auto px-4 text-center relative z-10">
		<h1 class="page-about-title text-4xl md:text-5xl font-bold mb-4"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="page-about-subs page-text-xl md:text-2xl mb-8 max-w-3xl mx-auto"><?php echo esc_html( $hero_subtitle ); ?></p>
	<?php if ( $show_hero_btn ) : ?>
		<a href="<?php echo esc_url( $hero_btn_url ); ?>" class="about-hero-btn btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 inline-block">
			<?php echo esc_html( $hero_btn_text ); ?>
		</a>
	<?php endif; ?>
	</div>
</section>

<!-- Our Mission Section -->
<?php
$mission_title     = get_theme_mod( 'about_mission_title', __( 'Our Mission', 'homerix' ) );
$mission_image     = get_theme_mod( 'about_mission_image', get_template_directory_uri() . '/assets/img/about-3.jpg' );
$mission_text1     = get_theme_mod( 'about_mission_text_1', __( 'At Homerix Pro, we believe every homeowner deserves access to reliable, affordable home repair services from professionals they can trust.', 'homerix' ) );
$mission_text2     = get_theme_mod( 'about_mission_text_2', __( 'Founded in 2010 by master plumber Michael Johnson, what began as a one-man operation has grown into the area\'s most trusted home repair service with over 50 technicians serving thousands of satisfied customers.', 'homerix' ) );
$mission_text3     = get_theme_mod( 'about_mission_text_3', __( 'We\'re not just fixing homes - we\'re restoring peace of mind by delivering quality workmanship, transparent pricing, and exceptional customer service.', 'homerix' ) );
$mission_btn1_text = get_theme_mod( 'about_mission_button1_text', __( 'Book a Service', 'homerix' ) );
$mission_btn1_url  = get_theme_mod( 'about_mission_button1_url', '#booking' );
$mission_btn2_text = get_theme_mod( 'about_mission_button2_text', __( 'Meet Our Team', 'homerix' ) );
$mission_btn2_url  = get_theme_mod( 'about_mission_button2_url', '#our-team' );

// Button visibility from toggle settings.
$show_mission_btn1 = get_theme_mod( 'about_mission_button1_enabled', true );
$show_mission_btn2 = get_theme_mod( 'about_mission_button2_enabled', true );
?>
<section id="our-mission" class="py-16">
	<div class="container mx-auto px-4">
		<div class="flex flex-col md:flex-row items-center gap-12">
			<div class="md:w-1/2">
				<img src="<?php echo esc_url( $mission_image ); ?>"
					 alt="<?php echo esc_attr( $mission_title ); ?>"
					 class="about-mission-img rounded-lg shadow-xl w-full h-auto">
			</div>
			<div class="md:w-1/2">
				<h2 class="about-mission-title text-3xl font-bold mb-6"><?php echo esc_html( $mission_title ); ?></h2>
				<p class="about-mission-text-1 text-lg mb-6"><?php echo esc_html( $mission_text1 ); ?></p>
				<p class="about-mission-text-2 mb-6"><?php echo esc_html( $mission_text2 ); ?></p>
				<p class="about-mission-text-3 mb-8"><?php echo esc_html( $mission_text3 ); ?></p>
				<div class="flex flex-col sm:flex-row gap-4">
		  <?php if ( $show_mission_btn1 ) : ?>
					<a href="<?php echo esc_url( $mission_btn1_url ); ?>" class="about-mission-btn1 btn book-btn font-bold py-3 px-6 rounded-lg transition duration-300 text-center">
						<?php echo esc_html( $mission_btn1_text ); ?>
					</a>
		  <?php endif; ?>
		  <?php if ( $show_mission_btn2 ) : ?>
					<a href="<?php echo esc_url( $mission_btn2_url ); ?>" class="about-mission-btn2 btn find-btn font-bold py-3 px-6 rounded-lg border transition duration-300 text-center">
						<?php echo esc_html( $mission_btn2_text ); ?>
					</a>
		  <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Our Timeline Section -->
<?php
$timeline_title    = get_theme_mod( 'about_timeline_title', __( 'Our Journey', 'homerix' ) );
$timeline_subtitle = get_theme_mod( 'about_timeline_subtitle', __( 'From humble beginnings to becoming your trusted home repair partner', 'homerix' ) );
$timeline_items    = get_theme_mod(
	'about_timeline_items',
	array(
		array(
			'icon'        => 'fas fa-lightbulb',
			'year'        => '2010',
			'title'       => __( 'The Beginning', 'homerix' ),
			'description' => __( 'Michael Johnson starts Homerix Pro as a solo plumbing service.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-users',
			'year'        => '2013',
			'title'       => __( 'Team Expansion', 'homerix' ),
			'description' => __( 'Grew to 10 technicians covering plumbing, electrical, and HVAC services.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-award',
			'year'        => '2016',
			'title'       => __( 'Industry Recognition', 'homerix' ),
			'description' => __( 'Received "Best Home Services Provider" award from the local chamber of commerce.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-mobile-alt',
			'year'        => '2019',
			'title'       => __( 'Digital Innovation', 'homerix' ),
			'description' => __( 'Launched our online booking platform and mobile app for customer convenience.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-heart',
			'year'        => '2021',
			'title'       => __( 'Community Focus', 'homerix' ),
			'description' => __( 'Started Homerix Cares program, providing free repairs to families in need.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-rocket',
			'year'        => '2023',
			'title'       => __( 'Continued Growth', 'homerix' ),
			'description' => __( 'Now serving over 5,000 customers annually with a team of 50+ certified technicians.', 'homerix' ),
		),
	)
);
?>
<section id="about-timeline" class="py-16 card-light">
	<div class="container mx-auto px-4">
		<div class="text-center mb-16">
			<h2 class="about-timeline-title text-3xl font-bold mb-4"><?php echo esc_html( $timeline_title ); ?></h2>
			<p class="about-timeline-subtitle text-lg max-w-3xl mx-auto"><?php echo esc_html( $timeline_subtitle ); ?></p>
		</div>

		<div id="about-timeline-container" class="max-w-2xl mx-auto">
			<?php if ( ! empty( $timeline_items ) && is_array( $timeline_items ) ) : ?>
				<?php foreach ( $timeline_items as $item ) : ?>
					<div class="timeline-item">
						<div class="timeline-icon">
							<i class="<?php echo esc_attr( $item['icon'] ?? 'fas fa-star' ); ?>"></i>
						</div>
						<h3 class="text-xl font-bold mb-2">
							<?php echo esc_html( $item['year'] ?? '' ); ?> - <?php echo esc_html( $item['title'] ?? '' ); ?>
						</h3>
						<p class="text-muted"><?php echo esc_html( $item['description'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Our Team Section -->
<?php
$team_title       = get_theme_mod( 'about_team_title', __( 'Meet Our Leadership Team', 'homerix' ) );
$team_subtitle    = get_theme_mod( 'about_team_subtitle', __( 'The experienced professionals guiding Homerix Pro\'s success', 'homerix' ) );
$team_members     = get_theme_mod(
	'about_team_members',
	array(
		array(
			'image'       => get_template_directory_uri() . '/assets/img/customer-1.jpg',
			'name'        => __( 'Michael Johnson', 'homerix' ),
			'position'    => __( 'Founder & CEO', 'homerix' ),
			'description' => __( 'Master plumber with 25+ years of experience. Michael founded Homerix Pro with a vision to provide honest, reliable home repair services.', 'homerix' ),
			'linkedin'    => '#',
			'email'       => 'michael@example.com',
		),
		array(
			'image'       => get_template_directory_uri() . '/assets/img/customer-2.jpg',
			'name'        => __( 'Sarah Chen', 'homerix' ),
			'position'    => __( 'Operations Director', 'homerix' ),
			'description' => __( 'Sarah ensures every job runs smoothly and every customer receives exceptional service. 15 years in operations management.', 'homerix' ),
			'linkedin'    => '#',
			'email'       => 'sarah@example.com',
		),
		array(
			'image'       => get_template_directory_uri() . '/assets/img/customer-3.jpg',
			'name'        => __( 'David Rodriguez', 'homerix' ),
			'position'    => __( 'Lead Electrician', 'homerix' ),
			'description' => __( 'Licensed master electrician with expertise in residential and commercial electrical systems. 20 years of experience.', 'homerix' ),
			'linkedin'    => '#',
			'email'       => 'david@example.com',
		),
		array(
			'image'       => get_template_directory_uri() . '/assets/img/customer-1.jpg',
			'name'        => __( 'Emily Wilson', 'homerix' ),
			'position'    => __( 'Customer Success Manager', 'homerix' ),
			'description' => __( 'Emily leads our customer service team, ensuring every client has a positive experience from booking to completion.', 'homerix' ),
			'linkedin'    => '#',
			'email'       => 'emily@example.com',
		),
	)
);
$team_bottom_text = get_theme_mod( 'about_team_bottom_text', __( 'Behind our leadership team stands a crew of over 50 skilled technicians, customer service representatives, and support staff.', 'homerix' ) );
$team_btn_text    = get_theme_mod( 'about_team_button_text', __( 'Meet Our Technicians', 'homerix' ) );
$team_btn_url     = get_theme_mod( 'about_team_button_url', '#technicians' );
?>
<section id="our-team" class="py-16 card-base">
	<div class="container mx-auto px-4">
		<div class="text-center mb-16">
			<h2 class="about-team-title text-3xl font-bold mb-4"><?php echo esc_html( $team_title ); ?></h2>
			<p class="about-team-subtitle text-lg text-muted max-w-3xl mx-auto"><?php echo esc_html( $team_subtitle ); ?></p>
		</div>

		<div id="about-team-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
			<?php if ( ! empty( $team_members ) && is_array( $team_members ) ) : ?>
				<?php foreach ( $team_members as $member ) : ?>
					<div class="team-card card-base p-6 rounded-lg shadow-md transition duration-300">
						<?php if ( ! empty( $member['image'] ) ) : ?>
							<img src="<?php echo esc_url( $member['image'] ); ?>"
								 alt="<?php echo esc_attr( $member['name'] ?? '' ); ?>"
								 class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 team-member-image">
						<?php endif; ?>
						<h3 class="text-xl font-bold text-center mb-1"><?php echo esc_html( $member['name'] ?? '' ); ?></h3>
						<p class="text-primary font-medium text-center mb-4"><?php echo esc_html( $member['position'] ?? '' ); ?></p>
						<p class="text-muted text-sm text-center"><?php echo esc_html( $member['description'] ?? '' ); ?></p>
						<div class="flex justify-center mt-4 space-x-3">
							<?php if ( ! empty( $member['linkedin'] ) ) : ?>
								<a href="<?php echo esc_url( $member['linkedin'] ); ?>" class="text-muted-light hover-text-primary">
									<i class="fab fa-linkedin-in"></i>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $member['email'] ) ) : ?>
								<a href="mailto:<?php echo esc_attr( $member['email'] ); ?>" class="text-muted-light hover-text-primary">
									<i class="fas fa-envelope"></i>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="mt-12 text-center">
			<?php
			// Button visibility from toggle settings.
			$show_team_btn = get_theme_mod( 'about_team_button_enabled', true );
			?>
			<?php if ( ! empty( $team_bottom_text ) ) : ?>
				<p class="about-team-bottom-text text-muted mb-6"><?php echo esc_html( $team_bottom_text ); ?></p>
			<?php endif; ?>
			<?php if ( $show_team_btn ) : ?>
				<a href="<?php echo esc_url( $team_btn_url ); ?>" class="about-team-btn btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 inline-block">
					<?php echo esc_html( $team_btn_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Our Values Section -->
<?php
$values_title    = get_theme_mod( 'about_values_title', __( 'Our Core Values', 'homerix' ) );
$values_subtitle = get_theme_mod( 'about_values_subtitle', __( 'The principles that guide every service we provide', 'homerix' ) );
$values_items    = get_theme_mod(
	'about_values_items',
	array(
		array(
			'icon'        => 'fas fa-shield-alt',
			'icon_color'  => '#2563EB',
			'title'       => __( 'Integrity', 'homerix' ),
			'description' => __( 'We believe in honest pricing, transparent communication, and doing what\'s right for our customers.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-star',
			'icon_color'  => '#eab308',
			'title'       => __( 'Excellence', 'homerix' ),
			'description' => __( 'We strive for perfection in every repair, using quality materials and proven techniques.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-heart',
			'icon_color'  => '#ef4444',
			'title'       => __( 'Community', 'homerix' ),
			'description' => __( 'We\'re committed to giving back and supporting the neighborhoods we serve.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-lightbulb',
			'icon_color'  => '#a855f7',
			'title'       => __( 'Innovation', 'homerix' ),
			'description' => __( 'We embrace new technologies and methods to provide better, faster service.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-users',
			'icon_color'  => '#22c55e',
			'title'       => __( 'Teamwork', 'homerix' ),
			'description' => __( 'Our success comes from collaboration, respect, and supporting each other.', 'homerix' ),
		),
		array(
			'icon'        => 'fas fa-clock',
			'icon_color'  => '#f97316',
			'title'       => __( 'Reliability', 'homerix' ),
			'description' => __( 'We show up on time, complete jobs as promised, and stand behind our work.', 'homerix' ),
		),
	)
);
?>
<section id="about-values" class="py-16 card-light">
	<div class="container mx-auto px-4">
		<div class="text-center mb-16">
			<h2 class="about-values-title text-3xl font-bold mb-4"><?php echo esc_html( $values_title ); ?></h2>
			<p class="about-values-subtitle text-lg text-muted max-w-3xl mx-auto"><?php echo esc_html( $values_subtitle ); ?></p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			<?php if ( ! empty( $values_items ) && is_array( $values_items ) ) : ?>
				<?php foreach ( $values_items as $value ) : ?>
					<?php
					$icon_color = ! empty( $value['icon_color'] ) ? $value['icon_color'] : '#2563EB';
					// Create light background by adding 15% opacity.
					$bg_color = $icon_color . '26'; // Adds 15% opacity in hex.
					?>
					<div class="value-card card-base p-8 rounded-lg shadow-sm text-center">
						<div class="value-icon-wrapper p-4 rounded-full inline-block mb-4" style="background: <?php echo esc_attr( $bg_color ); ?>; color: <?php echo esc_attr( $icon_color ); ?>;">
							<i class="<?php echo esc_attr( $value['icon'] ?? 'fas fa-star' ); ?> text-3xl"></i>
						</div>
						<h3 class="text-xl font-semibold mb-3"><?php echo esc_html( $value['title'] ?? '' ); ?></h3>
						<p class="text-muted"><?php echo esc_html( $value['description'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Community Involvement Section -->
<?php
$community_title    = get_theme_mod( 'about_community_title', __( 'Giving Back to Our Community', 'homerix' ) );
$community_text1    = get_theme_mod( 'about_community_text_1', __( 'At Homerix Pro, we believe in supporting the communities that support us.', 'homerix' ) );
$community_text2    = get_theme_mod( 'about_community_text_2', __( 'Each year, we donate hundreds of hours of free repair services to local shelters, community centers, and families in need through our Homerix Cares program.', 'homerix' ) );
$community_text3    = get_theme_mod( 'about_community_text_3', __( 'We also partner with vocational schools to train the next generation of skilled tradespeople through our apprenticeship program.', 'homerix' ) );
$community_btn_text = get_theme_mod( 'about_community_button_text', __( 'Learn About Our Community Programs', 'homerix' ) );
$community_btn_url  = get_theme_mod( 'about_community_button_url', '#' );
$community_image    = get_theme_mod( 'about_community_image', get_template_directory_uri() . '/assets/img/about-3.jpg' );
?>
<section id="about-community" class="py-16 card-base">
	<div class="container mx-auto px-4">
		<div class="flex flex-col md:flex-row items-center gap-12">
			<div class="md:w-1/2">
				<h2 class="about-community-title text-3xl font-bold mb-6"><?php echo esc_html( $community_title ); ?></h2>
				<p class="about-community-text-1 text-lg text-body mb-6"><?php echo esc_html( $community_text1 ); ?></p>
				<p class="about-community-text-2 text-muted mb-6"><?php echo esc_html( $community_text2 ); ?></p>
				<p class="about-community-text-3 text-muted mb-8"><?php echo esc_html( $community_text3 ); ?></p>
				<?php
				// Button visibility from toggle settings.
				$show_community_btn = get_theme_mod( 'about_community_button_enabled', true );
				?>
				<?php if ( $show_community_btn ) : ?>
					<a href="<?php echo esc_url( $community_btn_url ); ?>" class="about-community-btn btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300 inline-block">
						<?php echo esc_html( $community_btn_text ); ?>
					</a>
				<?php endif; ?>
			</div>
			<div class="md:w-1/2">
				<img src="<?php echo esc_url( $community_image ); ?>"
					 alt="<?php echo esc_attr( $community_title ); ?>"
					 class="about-community-img rounded-lg shadow-xl w-full h-auto">
			</div>
		</div>
	</div>
</section>

<!-- CTA Section -->
<?php
$cta_title     = get_theme_mod( 'about_cta_title', __( 'Ready to Experience the Homerix Pro Difference?', 'homerix' ) );
$cta_subtitle  = get_theme_mod( 'about_cta_subtitle', __( 'Join thousands of satisfied customers who trust us with their home repair needs.', 'homerix' ) );
$cta_btn1_text = get_theme_mod( 'about_cta_button1_text', __( 'Book a Service', 'homerix' ) );
$cta_btn1_url  = get_theme_mod( 'about_cta_button1_url', '#booking' );
$cta_btn2_text = get_theme_mod( 'about_cta_button2_text', __( 'Call: (555) 123-4567', 'homerix' ) );
$cta_btn2_url  = get_theme_mod( 'about_cta_button2_url', 'tel:+15551234567' );
$cta_bg_color  = get_theme_mod( 'about_cta_bg_color', '#2563EB' );
?>
<section class="about-cta-section py-16 hero-text" style="background: <?php echo esc_attr( $cta_bg_color ); ?>;">
	<div class="container mx-auto px-4 text-center">
		<h2 class="about-cta-title text-2xl md:text-3xl font-bold mb-4"><?php echo esc_html( $cta_title ); ?></h2>
		<p class="about-cta-subtitle text-xl mb-8"><?php echo esc_html( $cta_subtitle ); ?></p>
		<?php
		// Button visibility from toggle settings.
		$show_cta_btn1 = get_theme_mod( 'about_cta_button1_enabled', true );
		$show_cta_btn2 = get_theme_mod( 'about_cta_button2_enabled', true );
		?>
		<div class="flex flex-col sm:flex-row justify-center gap-4">
			<?php if ( $show_cta_btn1 ) : ?>
				<a href="<?php echo esc_url( $cta_btn1_url ); ?>" class="about-cta-btn1 btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300">
					<?php echo esc_html( $cta_btn1_text ); ?>
				</a>
			<?php endif; ?>
			<?php if ( $show_cta_btn2 ) : ?>
				<a href="<?php echo esc_url( $cta_btn2_url ); ?>" class="about-cta-btn2 btn find-btn font-bold py-3 px-8 rounded-lg transition duration-300 backdrop-blur-sm">
					<?php echo esc_html( $cta_btn2_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>


</main><!-- #primary -->

<?php
get_footer();

