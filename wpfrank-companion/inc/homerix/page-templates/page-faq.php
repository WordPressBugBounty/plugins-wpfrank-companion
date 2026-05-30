<?php
/**
 * Template Name: Homerix FAQ
 * Template Post Type: page
 *
 * FAQ page template for Homerix Pro theme.
 *
 * @package Homerix_Pro
 * @since 1.0.0
 */

get_header();

// Hero Section Settings.
$hero_title    = get_theme_mod( 'faq_hero_title', __( 'Frequently Asked Questions', 'homerix' ) );
$hero_subtitle = get_theme_mod( 'faq_hero_subtitle', __( 'Find answers to common questions about our services', 'homerix' ) );
$hero_bg_color = get_theme_mod( 'faq_hero_bg_color', '#2563EB' );

// FAQ Categories.
$categories = get_theme_mod(
	'faq_categories',
	array(
		array(
			'name' => __( 'Booking', 'homerix' ),
			'slug' => 'booking',
		),
		array(
			'name' => __( 'Payment', 'homerix' ),
			'slug' => 'payment',
		),
		array(
			'name' => __( 'Technicians', 'homerix' ),
			'slug' => 'technicians',
		),
		array(
			'name' => __( 'Services', 'homerix' ),
			'slug' => 'services',
		),
	)
);

// FAQ Items.
$faq_items = get_theme_mod(
	'faq_items',
	array(
		array(
			'question' => __( 'How do I book a service?', 'homerix' ),
			'answer'   => __( 'You can book a service by clicking the "Book Now" button, selecting your service type, choosing a technician, and scheduling an appointment. You\'ll receive confirmation via email and SMS.', 'homerix' ),
			'category' => 'booking',
		),
		array(
			'question' => __( 'Can I cancel or reschedule my appointment?', 'homerix' ),
			'answer'   => __( 'Yes, you can cancel or reschedule your appointment up to 24 hours before the scheduled time without any fees. For cancellations within 24 hours, a small fee may apply.', 'homerix' ),
			'category' => 'booking',
		),
		array(
			'question' => __( 'How far in advance can I book?', 'homerix' ),
			'answer'   => __( 'You can book services up to 30 days in advance. For urgent repairs, we also offer same-day and next-day appointments based on technician availability.', 'homerix' ),
			'category' => 'booking',
		),
		array(
			'question' => __( 'What payment methods do you accept?', 'homerix' ),
			'answer'   => __( 'We accept all major credit cards (Visa, MasterCard, American Express), debit cards, PayPal, and bank transfers. Payment is processed securely through our platform.', 'homerix' ),
			'category' => 'payment',
		),
		array(
			'question' => __( 'When do I pay for the service?', 'homerix' ),
			'answer'   => __( 'Payment is typically made after the service is completed and you\'re satisfied with the work. Some technicians may require a deposit for large jobs or expensive materials.', 'homerix' ),
			'category' => 'payment',
		),
		array(
			'question' => __( 'Are your technicians licensed and insured?', 'homerix' ),
			'answer'   => __( 'Yes, all technicians on our platform are required to have proper licensing, insurance, and background checks. We verify their credentials before they can offer services through Homerix Pro.', 'homerix' ),
			'category' => 'technicians',
		),
		array(
			'question' => __( 'How do you vet your technicians?', 'homerix' ),
			'answer'   => __( 'Our vetting process includes background checks, license verification, insurance confirmation, reference checks, and skills assessments. We also monitor customer reviews and ratings continuously.', 'homerix' ),
			'category' => 'technicians',
		),
		array(
			'question' => __( 'What types of services do you offer?', 'homerix' ),
			'answer'   => __( 'We offer a wide range of home repair and maintenance services including plumbing, electrical work, HVAC, carpentry, painting, appliance repair, and general handyman services.', 'homerix' ),
			'category' => 'services',
		),
		array(
			'question' => __( 'Do you offer emergency services?', 'homerix' ),
			'answer'   => __( 'Yes, we offer 24/7 emergency services for urgent issues like burst pipes, electrical emergencies, and HVAC failures. Emergency services may have additional fees.', 'homerix' ),
			'category' => 'services',
		),
		array(
			'question' => __( 'What if I\'m not satisfied with the work?', 'homerix' ),
			'answer'   => __( 'We have a satisfaction guarantee. If you\'re not happy with the work, contact us within 48 hours and we\'ll work with the technician to resolve the issue or arrange for another qualified professional to fix it.', 'homerix' ),
			'category' => 'services',
		),
		array(
			'question' => __( 'How do I contact customer support?', 'homerix' ),
			'answer'   => __( 'You can contact our customer support team via phone at (555) 123-4567, email at support@example.com, or through the live chat feature on our website. We\'re available 24/7.', 'homerix' ),
			'category' => 'general',
		),
		array(
			'question' => __( 'Do you serve my area?', 'homerix' ),
			'answer'   => __( 'We currently serve major metropolitan areas across the United States. Enter your zip code on our website to check if we serve your area and see available technicians nearby.', 'homerix' ),
			'category' => 'general',
		),
	)
);

// CTA Settings.
$cta_title         = get_theme_mod( 'faq_cta_title', __( 'Still have questions?', 'homerix' ) );
$cta_description   = get_theme_mod( 'faq_cta_description', __( "Can't find the answer you're looking for? Our customer support team is here to help.", 'homerix' ) );
$cta_btn_enabled   = get_theme_mod( 'faq_cta_button_enabled', true );
$cta_btn_text      = get_theme_mod( 'faq_cta_button_text', __( 'Contact Support', 'homerix' ) );
$cta_btn_url       = get_theme_mod( 'faq_cta_button_url', '/homerix-contact-us/' );
$cta_phone_enabled = get_theme_mod( 'faq_cta_phone_enabled', true );
$cta_phone_text    = get_theme_mod( 'faq_cta_phone_text', __( 'Call (555) 123-4567', 'homerix' ) );
$cta_phone_url     = get_theme_mod( 'faq_cta_phone_url', 'tel:+15551234567' );
?>

<main id="primary" tabindex="-1" class="site-main">

<!-- FAQ Hero Section -->
<section class="faq-hero hero-text py-16" style="background: <?php echo esc_attr( $hero_bg_color ); ?>;">
	<div class="container mx-auto px-4">
		<div class="max-w-3xl mx-auto text-center">
			<h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="faq-hero-subtitle text-xl"><?php echo esc_html( $hero_subtitle ); ?></p>
		</div>
	</div>
</section>

<!-- FAQ Content -->
<section class="py-12 card-light">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<!-- Search Bar -->
			<div class="mb-8">
				<div class="relative">
					<input type="text" id="faq-search" placeholder="<?php esc_attr_e( 'Search FAQs...', 'homerix' ); ?>" class="form-input w-full pl-12 pr-4 py-3 border rounded-lg">
					<i class="fas fa-search absolute left-4 top-4 text-muted"></i>
				</div>
			</div>

			<!-- FAQ Categories -->
			<?php if ( ! empty( $categories ) && is_array( $categories ) ) : ?>
				<?php
				// Inline limit (obfuscated).
				$cat_max      = HOMERIX_IS_PRO() ? 999 : 4;
				$limited_cats = array_slice( $categories, 0, $cat_max );
				?>
				<div class="mb-8">
					<div class="flex flex-wrap gap-2">
						<button class="faq-category-btn active bg-primary text-white border border-primary px-4 py-2 rounded-lg" data-category="all"><?php esc_html_e( 'All', 'homerix' ); ?></button>
						<?php foreach ( $limited_cats as $category ) : ?>
							<?php if ( ! empty( $category['name'] ) && ! empty( $category['slug'] ) ) : ?>
								<button class="faq-category-btn card-light border px-4 py-2 rounded-lg" data-category="<?php echo esc_attr( $category['slug'] ); ?>"><?php echo esc_html( $category['name'] ); ?></button>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- FAQ Items -->
			<div class="space-y-4">
				<?php if ( ! empty( $faq_items ) && is_array( $faq_items ) ) : ?>
					<?php
					// Inline limit (obfuscated).
					$qa_max   = HOMERIX_IS_PRO() ? 999 : 12;
					$qa_shown = 0;
					?>
					<?php foreach ( $faq_items as $faq ) : ?>
						<?php
						$qa_shown++;
						if ( $qa_shown > $qa_max ) {
							break;
						}
						?>
						<?php if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) : ?>
							<div class="faq-item card-base rounded-lg shadow-sm border border-transparent hover:border-primary transition" data-category="<?php echo esc_attr( $faq['category'] ?? 'general' ); ?>">
								<button class="faq-question w-full text-left p-6 flex justify-between items-center">
									<span class="text-lg font-semibold text-heading"><?php echo esc_html( $faq['question'] ); ?></span>
									<i class="fas fa-chevron-down transform transition-transform text-muted"></i>
								</button>
								<div class="faq-answer hidden px-6 pb-6">
									<p class="text-body"><?php echo esc_html( $faq['answer'] ); ?></p>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<!-- Still Have Questions CTA -->
			<div class="faq-cta-section mt-12 text-center">
				<div class="card-base border rounded-lg p-8">
					<h3 class="faq-cta-title text-2xl font-bold text-heading mb-4"><?php echo esc_html( $cta_title ); ?></h3>
					<p class="faq-cta-desc text-body mb-6"><?php echo esc_html( $cta_description ); ?></p>
					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<?php if ( $cta_btn_enabled && ! empty( $cta_btn_text ) ) : ?>
						<a href="<?php echo esc_url( $cta_btn_url ); ?>" class="faq-cta-btn btn book-btn font-bold px-6 py-3 rounded-lg transition">
							<?php echo esc_html( $cta_btn_text ); ?>
						</a>
						<?php endif; ?>
						<?php if ( $cta_phone_enabled && ! empty( $cta_phone_text ) ) : ?>
						<a href="<?php echo esc_url( $cta_phone_url ); ?>" class="faq-cta-phone btn find-btn font-bold px-6 py-3 rounded-lg transition">
							<?php echo esc_html( $cta_phone_text ); ?>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// FAQ accordion functionality
	const faqQuestions = document.querySelectorAll('.faq-question');
	faqQuestions.forEach(question => {
		question.addEventListener('click', function() {
			const answer = this.nextElementSibling;
			const icon = this.querySelector('i');
			
			if (answer.classList.contains('hidden')) {
				answer.classList.remove('hidden');
				icon.style.transform = 'rotate(180deg)';
			} else {
				answer.classList.add('hidden');
				icon.style.transform = 'rotate(0deg)';
			}
		});
	});

	// Category filtering
	const categoryBtns = document.querySelectorAll('.faq-category-btn');
	const faqItems = document.querySelectorAll('.faq-item');
	
	categoryBtns.forEach(btn => {
		btn.addEventListener('click', function() {
			const category = this.dataset.category;
			
			// Update active button
			categoryBtns.forEach(b => {
				b.classList.remove('active');
			});
			this.classList.add('active');
			
			// Filter FAQ items
			faqItems.forEach(item => {
				if (category === 'all' || item.dataset.category === category) {
					item.style.display = 'block';
				} else {
					item.style.display = 'none';
				}
			});
		});
	});

	// Search functionality
	const searchInput = document.getElementById('faq-search');
	if (searchInput) {
		searchInput.addEventListener('input', function() {
			const searchTerm = this.value.toLowerCase();
			
			faqItems.forEach(item => {
				const question = item.querySelector('.faq-question span').textContent.toLowerCase();
				const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();
				
				if (question.includes(searchTerm) || answer.includes(searchTerm)) {
					item.style.display = 'block';
				} else {
					item.style.display = 'none';
				}
			});
		});
	}
});
</script>

</main><!-- #primary -->

<?php
get_footer();

