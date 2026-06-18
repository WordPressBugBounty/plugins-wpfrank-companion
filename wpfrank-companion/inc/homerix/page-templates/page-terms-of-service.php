<?php
/**
 * Template Name: Homerix TOS
 * Template Post Type: page
 *
 * Terms of Service page template for Homerix Pro theme.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


get_header();

// Hero Section Settings.
$hero_title    = get_theme_mod( 'terms_hero_title', __( 'Terms of Service', 'homerix' ) );
$hero_subtitle = get_theme_mod( 'terms_hero_subtitle', __( 'Please read these terms carefully before using our services', 'homerix' ) );
$hero_bg_color = get_theme_mod( 'terms_hero_bg_color', '#2563EB' );

// Content Settings.
$last_updated = get_theme_mod( 'terms_last_updated', __( 'January 1, 2024', 'homerix' ) );
$intro_text   = get_theme_mod( 'terms_intro_text', __( 'Welcome to Homerix Pro. These Terms of Service ("Terms") govern your use of our website and services. By accessing or using our services, you agree to be bound by these Terms.', 'homerix' ) );

// Terms Sections.
$sections = get_theme_mod(
	'terms_sections',
	array(
		array(
			'title'   => __( 'Acceptance of Terms', 'homerix' ),
			'content' => __( 'By accessing and using Homerix Pro\'s services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.', 'homerix' ),
		),
		array(
			'title'   => __( 'Description of Service', 'homerix' ),
			'content' => __( 'Homerix Pro is a platform that connects homeowners with qualified technicians for home repair and maintenance services. We facilitate the connection between customers and service providers but are not directly responsible for the services performed.', 'homerix' ),
		),
		array(
			'title'   => __( 'User Accounts', 'homerix' ),
			'content' => __( "To use certain features of our service, you must create an account. You agree to:\n• Provide accurate, current, and complete information\n• Maintain and update your information to keep it accurate\n• Maintain the security of your password and account\n• Accept responsibility for all activities under your account\n• Notify us immediately of any unauthorized use of your account", 'homerix' ),
		),
		array(
			'title'   => __( 'User Conduct', 'homerix' ),
			'content' => __( "You agree not to use the service to:\n• Violate any applicable laws or regulations\n• Infringe on the rights of others\n• Transmit harmful, offensive, or inappropriate content\n• Interfere with or disrupt the service or servers\n• Attempt to gain unauthorized access to any part of the service\n• Use the service for any commercial purpose without our consent", 'homerix' ),
		),
		array(
			'title'   => __( 'Service Provider Relationships', 'homerix' ),
			'content' => __( 'Homerix Pro acts as an intermediary between customers and independent service providers. We do not employ the technicians and are not responsible for their actions, work quality, or any damages that may occur during service provision. All service agreements are directly between you and the service provider.', 'homerix' ),
		),
		array(
			'title'   => __( 'Payment Terms', 'homerix' ),
			'content' => __( "Payment terms include:\n• Service fees are determined by individual service providers\n• Platform fees may apply for booking services\n• Payment processing is handled through secure third-party providers\n• Refund policies vary by service provider\n• Disputed charges should be reported within 30 days", 'homerix' ),
		),
		array(
			'title'   => __( 'Intellectual Property', 'homerix' ),
			'content' => __( 'The service and its original content, features, and functionality are owned by Homerix Pro and are protected by international copyright, trademark, patent, trade secret, and other intellectual property laws.', 'homerix' ),
		),
		array(
			'title'   => __( 'Product Licensing', 'homerix' ),
			'content' => __( "All WordPress themes, plugins, and related add-ons distributed by us (including the Homerix theme, Homerix Pro, and WPFrank Companion), whether free or paid, are 100% GPL-compatible and licensed under the GNU General Public License (GPL) version 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html). You are granted full rights to use, modify, and redistribute the software in accordance with the terms of this license.", 'homerix' ),
		),
		array(
			'title'   => __( 'Privacy Policy', 'homerix' ),
			'content' => __( 'Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the service, to understand our practices.', 'homerix' ),
		),
		array(
			'title'   => __( 'Disclaimers', 'homerix' ),
			'content' => __( 'The service is provided "as is" without warranties of any kind. We disclaim all warranties, express or implied, including but not limited to implied warranties of merchantability and fitness for a particular purpose.', 'homerix' ),
		),
		array(
			'title'   => __( 'Limitation of Liability', 'homerix' ),
			'content' => __( 'Homerix Pro shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses.', 'homerix' ),
		),
		array(
			'title'   => __( 'Termination', 'homerix' ),
			'content' => __( 'We may terminate or suspend your account and bar access to the service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever, including without limitation if you breach the Terms.', 'homerix' ),
		),
		array(
			'title'   => __( 'Changes to Terms', 'homerix' ),
			'content' => __( 'We reserve the right to modify or replace these Terms at any time. If a revision is material, we will provide at least 30 days notice prior to any new terms taking effect.', 'homerix' ),
		),
	)
);

// Contact Information.
$contact_title           = get_theme_mod( 'terms_contact_title', __( 'Contact Information', 'homerix' ) );
$contact_subtitle        = get_theme_mod( 'terms_contact_subtitle', __( 'If you have any questions about these Terms, please contact us:', 'homerix' ) );
$contact_email           = get_theme_mod( 'terms_contact_email', 'legal@example.com' );
$contact_phone_enabled   = get_theme_mod( 'terms_contact_phone_enabled', true );
$contact_phone           = get_theme_mod( 'terms_contact_phone', '(555) 123-4567' );
$contact_address_enabled = get_theme_mod( 'terms_contact_address_enabled', true );
$contact_address         = get_theme_mod( 'terms_contact_address', __( '123 Main Street, City, State 12345', 'homerix' ) );
$additional_content      = HOMERIX_IS_PRO() ? get_theme_mod( 'terms_additional_content', '' ) : ''; // Pro only - guarded at backend level.
?>

<main id="primary" tabindex="-1" class="site-main">

<!-- Terms of Service Hero Section -->
<section class="terms-hero text-white py-16" style="background: <?php echo esc_attr( $hero_bg_color ); ?>;">
	<div class="container mx-auto px-4">
		<div class="max-w-3xl mx-auto text-center">
			<h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="terms-hero-subtitle text-xl hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		</div>
	</div>
</section>

<!-- Terms of Service Content -->
<section class="py-12 card-light">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<div class="card-base rounded-lg shadow-md p-8">
				<!-- Last Updated & Introduction -->
				<div class="mb-8">
					<p class="text-muted mb-4"><strong><?php esc_html_e( 'Last updated:', 'homerix' ); ?></strong> <span class="terms-last-updated"><?php echo esc_html( $last_updated ); ?></span></p>
					<p class="terms-intro-text text-body leading-relaxed"><?php echo esc_html( $intro_text ); ?></p>
				</div>

				<!-- Terms Sections -->
				<?php if ( ! empty( $sections ) && is_array( $sections ) ) : ?>
					<?php
					// Inline limit (obfuscated).
					$tos_max     = HOMERIX_IS_PRO() ? 999 : 12;
					$tos_shown   = 0;
					$section_num = 1;
					?>
					<?php foreach ( $sections as $section ) : ?>
						<?php
						++$tos_shown;
						if ( $tos_shown > $tos_max ) {
							break;
						}
						?>
						<?php if ( ! empty( $section['title'] ) ) : ?>
							<section class="mb-8">
								<h2 class="text-2xl font-bold text-heading mb-4"><?php echo esc_html( $section_num . '. ' . $section['title'] ); ?></h2>
								<?php if ( ! empty( $section['content'] ) ) : ?>
									<div class="text-body leading-relaxed">
										<?php
										// Convert bullet points and newlines to proper HTML.
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
							<?php ++$section_num; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<!-- Contact Information Section -->
				<section class="mb-8">
					<h2 class="text-2xl font-bold text-heading mb-4"><?php echo esc_html( $section_num . '. ' . $contact_title ); ?></h2>
					<p class="text-body mb-4"><?php echo esc_html( $contact_subtitle ); ?></p>
					<div class="card-light p-6 rounded-lg">
						<p class="text-body mb-2"><strong><?php esc_html_e( 'Email:', 'homerix' ); ?></strong> <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="terms-contact-email"><?php echo esc_html( $contact_email ); ?></a></p>
						<?php if ( $contact_phone_enabled && ! empty( $contact_phone ) ) : ?>
						<p class="text-body mb-2"><strong><?php esc_html_e( 'Phone:', 'homerix' ); ?></strong> <span class="terms-contact-phone"><?php echo esc_html( $contact_phone ); ?></span></p>
						<?php endif; ?>
						<?php if ( $contact_address_enabled && ! empty( $contact_address ) ) : ?>
						<p class="text-body mb-2"><strong><?php esc_html_e( 'Address:', 'homerix' ); ?></strong> <span class="terms-contact-address"><?php echo esc_html( $contact_address ); ?></span></p>
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

