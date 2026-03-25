<?php
/**
 * Template Name: Homerix Privacy Policy
 * Template Post Type: page
 *
 * Privacy Policy page template for Homerix Pro theme.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

get_header();

// Hero Section Settings.
$hero_title    = get_theme_mod( 'privacy_hero_title', __( 'Privacy Policy', 'homerix' ) );
$hero_subtitle = get_theme_mod( 'privacy_hero_subtitle', __( 'Your privacy is important to us', 'homerix' ) );
$hero_bg_color = get_theme_mod( 'privacy_hero_bg_color', '#2563EB' );

// Content Settings.
$last_updated = get_theme_mod( 'privacy_last_updated', __( 'January 1, 2024', 'homerix' ) );
$intro_text   = get_theme_mod( 'privacy_intro_text', __( 'Homerix Pro ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by Homerix Pro when you use our website and services.', 'homerix' ) );

// Privacy Sections.
$sections = get_theme_mod(
	'privacy_sections',
	array(
		array(
			'title'   => __( 'Information We Collect', 'homerix' ),
			'content' => __( "We may collect personal information that you provide to us, including:\n• Name and contact information (email address, phone number, mailing address)\n• Account credentials (username and password)\n• Payment information (credit card details, billing address)\n• Service preferences and requirements\n• Communication records and feedback\n\nWe also automatically collect device information, usage data, location information (with consent), and cookies.", 'homerix' ),
		),
		array(
			'title'   => __( 'How We Use Your Information', 'homerix' ),
			'content' => __( "We use the information we collect to:\n• Provide and maintain our services\n• Process transactions and send related information\n• Connect you with qualified technicians\n• Send you technical notices, updates, and support messages\n• Respond to your comments, questions, and customer service requests\n• Communicate with you about products, services, and promotional offers\n• Monitor and analyze trends, usage, and activities\n• Detect, investigate, and prevent fraudulent transactions", 'homerix' ),
		),
		array(
			'title'   => __( 'Information Sharing and Disclosure', 'homerix' ),
			'content' => __( 'We may share your information with qualified technicians and service providers to fulfill your service requests. We may also share information with third-party vendors who perform services on our behalf, such as payment processing, data analysis, and customer service. We may disclose your information if required by law or in response to valid requests by public authorities.', 'homerix' ),
		),
		array(
			'title'   => __( 'Data Security', 'homerix' ),
			'content' => __( 'We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure.', 'homerix' ),
		),
		array(
			'title'   => __( 'Your Rights and Choices', 'homerix' ),
			'content' => __( "You have the right to:\n• Access and update your personal information\n• Request deletion of your personal information\n• Opt-out of marketing communications\n• Disable cookies through your browser settings\n• Request a copy of your personal information", 'homerix' ),
		),
		array(
			'title'   => __( 'Cookies and Tracking Technologies', 'homerix' ),
			'content' => __( 'We use cookies and similar tracking technologies to collect and use personal information about you. You can control cookies through your browser settings and other tools.', 'homerix' ),
		),
		array(
			'title'   => __( "Children's Privacy", 'homerix' ),
			'content' => __( 'Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.', 'homerix' ),
		),
		array(
			'title'   => __( 'Changes to This Privacy Policy', 'homerix' ),
			'content' => __( 'We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.', 'homerix' ),
		),
	)
);

// Contact Information.
$contact_title           = get_theme_mod( 'privacy_contact_title', __( 'Contact Us', 'homerix' ) );
$contact_subtitle        = get_theme_mod( 'privacy_contact_subtitle', __( 'If you have any questions about this Privacy Policy, please contact us:', 'homerix' ) );
$contact_email           = get_theme_mod( 'privacy_contact_email', 'privacy@Homerixpro.com' );
$contact_phone_enabled   = get_theme_mod( 'privacy_contact_phone_enabled', true );
$contact_phone           = get_theme_mod( 'privacy_contact_phone', '(555) 123-4567' );
$contact_address_enabled = get_theme_mod( 'privacy_contact_address_enabled', true );
$contact_address         = get_theme_mod( 'privacy_contact_address', __( '123 Main Street, City, State 12345', 'homerix' ) );
$additional_content      = HOMERIX_IS_PRO() ? get_theme_mod( 'privacy_additional_content', '' ) : ''; // Pro only - guarded at backend level.
?>

<main id="primary" tabindex="-1" class="site-main">

<!-- Privacy Policy Hero Section -->
<section class="privacy-hero hero-text py-16" style="background: <?php echo esc_attr( $hero_bg_color ); ?>;">
	<div class="container mx-auto px-4">
		<div class="max-w-3xl mx-auto text-center">
			<h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="privacy-hero-subtitle text-xl hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		</div>
	</div>
</section>

<!-- Privacy Policy Content -->
<section class="py-12 card-light">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<div class="card-base rounded-lg shadow-md p-8">
				<!-- Last Updated & Introduction -->
				<div class="mb-8">
					<p class="text-muted mb-4"><strong><?php esc_html_e( 'Last updated:', 'homerix' ); ?></strong> <span class="privacy-last-updated"><?php echo esc_html( $last_updated ); ?></span></p>
					<p class="privacy-intro-text text-body leading-relaxed"><?php echo esc_html( $intro_text ); ?></p>
				</div>

				<!-- Privacy Sections -->
				<?php if ( ! empty( $sections ) && is_array( $sections ) ) : ?>
					<?php
					// Inline limit (obfuscated).
					$pp_max   = HOMERIX_IS_PRO() ? 999 : 8;
					$pp_shown = 0;
					?>
					<?php foreach ( $sections as $section ) : ?>
						<?php
						$pp_shown++;
						if ( $pp_shown > $pp_max ) {
							break;
						}
						?>
						<?php if ( ! empty( $section['title'] ) ) : ?>
							<section class="mb-8">
								<h2 class="text-2xl font-bold text-heading mb-4"><?php echo esc_html( $section['title'] ); ?></h2>
								<?php if ( ! empty( $section['content'] ) ) : ?>
									<div class="text-body leading-relaxed">
										<?php
										// Convert bullet points and newlines to proper HTML.
										$content = esc_html( $section['content'] );
										$content = nl2br( $content );
										// Convert bullet points to list items.
										$lines   = explode( "\n", $section['content'] );
										$in_list = false;
										$output  = '';
										foreach ( $lines as $line ) {
											$line = trim( $line );
											if ( strpos( $line, '•' ) === 0 || strpos( $line, '-' ) === 0 ) {
												if ( ! $in_list ) {
													$output .= '<ul class="list-disc pl-6 mb-4 text-body">';
													$in_list = true;
												}
												$output .= '<li>' . esc_html( ltrim( $line, '•- ' ) ) . '</li>';
											} else {
												if ( $in_list ) {
													$output .= '</ul>';
													$in_list = false;
												}
												if ( ! empty( $line ) ) {
													$output .= '<p class="mb-4">' . esc_html( $line ) . '</p>';
												}
											}
										}
										if ( $in_list ) {
											$output .= '</ul>';
										}
										echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped above.
										?>
									</div>
								<?php endif; ?>
							</section>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<!-- Contact Us Section -->
				<section class="mb-8">
					<h2 class="text-2xl font-bold text-heading mb-4"><?php echo esc_html( $contact_title ); ?></h2>
					<p class="text-body mb-4"><?php echo esc_html( $contact_subtitle ); ?></p>
					<div class="card-light p-6 rounded-lg">
						<p class="text-body mb-2"><strong><?php esc_html_e( 'Email:', 'homerix' ); ?></strong> <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="privacy-contact-email"><?php echo esc_html( $contact_email ); ?></a></p>
						<?php if ( $contact_phone_enabled && ! empty( $contact_phone ) ) : ?>
						<p class="text-body mb-2"><strong><?php esc_html_e( 'Phone:', 'homerix' ); ?></strong> <span class="privacy-contact-phone"><?php echo esc_html( $contact_phone ); ?></span></p>
						<?php endif; ?>
						<?php if ( $contact_address_enabled && ! empty( $contact_address ) ) : ?>
						<p class="text-body mb-2"><strong><?php esc_html_e( 'Address:', 'homerix' ); ?></strong> <span class="privacy-contact-address"><?php echo esc_html( $contact_address ); ?></span></p>
						<?php endif; ?>
					</div>
				</section>

				<?php if ( ! empty( $additional_content ) ) : ?>
				<!-- Additional Content -->
				<section class="mb-8">
					<div class="text-body leading-relaxed">
						<?php echo wp_kses_post( $additional_content ); ?>
					</div>
				</section>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

</main><!-- #primary -->

<?php
get_footer();
