<?php
/**
 * Contact Form AJAX Handler
 *
 * Handles contact form submission via AJAX and sends email notifications.
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle contact form submission via AJAX.
 */
add_action( 'wp_ajax_submit_contact', 'homerix_handle_contact_submission' );
add_action( 'wp_ajax_nopriv_submit_contact', 'homerix_handle_contact_submission' );

/**
 * Process contact form submission.
 */
function homerix_handle_contact_submission() {
	// Verify nonce.
	if ( ! isset( $_POST['homerix_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['homerix_contact_nonce'] ) ), 'homerix_contact_form' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security verification failed. Please try again.', 'homerix' ) ) );
	}

	// Get and sanitize form data.
	$first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last_name  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$subject    = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message    = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Validate required fields.
	if ( empty( $first_name ) || empty( $last_name ) || empty( $email ) || empty( $subject ) || empty( $message ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'homerix' ) ) );
	}

	// Validate email.
	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'homerix' ) ) );
	}

	// Prepare contact data.
	$contact_data = array(
		'first_name' => $first_name,
		'last_name'  => $last_name,
		'full_name'  => $first_name . ' ' . $last_name,
		'email'      => $email,
		'phone'      => $phone,
		'subject'    => $subject,
		'message'    => $message,
		'date'       => current_time( 'mysql' ),
		'ip_address' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
	);

	// Send email.
	$email_sent = homerix_send_contact_email( $contact_data );

	// Get messages from customizer.
	$success_message = get_theme_mod( 'contact_form_success_message', __( 'Thank you for your message! We will get back to you within 24 hours.', 'homerix' ) );

	if ( $email_sent ) {
		wp_send_json_success(
			array(
				'message' => $success_message,
			)
		);
	} else {
		// Email failed - return error so modal shows properly.
		wp_send_json_error(
			array(
				'message' => __( 'We were unable to send your message. Please try again later or contact us directly.', 'homerix' ),
			)
		);
	}
}

/**
 * Send contact form email to admin.
 *
 * @param array $contact_data Contact form data.
 * @return bool True if email sent successfully.
 */
function homerix_send_contact_email( $contact_data ) {
	// Get admin email - custom email is Pro only, otherwise use WordPress admin email.
	$admin_email = HOMERIX_IS_PRO() ? get_theme_mod( 'contact_form_admin_email', '' ) : '';
	if ( empty( $admin_email ) ) {
		$admin_email = get_option( 'admin_email' );
	}

	// Get site name.
	$site_name = get_bloginfo( 'name' );

	// Subject label mapping - get from customizer.
	$default_subjects = array(
		array(
			'value' => 'service-request',
			'label' => __( 'Service Request', 'homerix' ),
		),
		array(
			'value' => 'estimate',
			'label' => __( 'Request an Estimate', 'homerix' ),
		),
		array(
			'value' => 'emergency',
			'label' => __( 'Emergency Service', 'homerix' ),
		),
		array(
			'value' => 'general',
			'label' => __( 'General Inquiry', 'homerix' ),
		),
		array(
			'value' => 'billing',
			'label' => __( 'Billing Question', 'homerix' ),
		),
		array(
			'value' => 'feedback',
			'label' => __( 'Feedback/Suggestion', 'homerix' ),
		),
		array(
			'value' => 'careers',
			'label' => __( 'Careers', 'homerix' ),
		),
		array(
			'value' => 'other',
			'label' => __( 'Other', 'homerix' ),
		),
	);
	$subjects         = get_theme_mod( 'contact_form_subjects', $default_subjects );

	// Build subject label mapping from customizer data.
	$subject_labels = array();
	foreach ( $subjects as $subject ) {
		if ( ! empty( $subject['value'] ) && ! empty( $subject['label'] ) ) {
			$subject_labels[ $subject['value'] ] = $subject['label'];
		}
	}
	$subject_label = isset( $subject_labels[ $contact_data['subject'] ] ) ? $subject_labels[ $contact_data['subject'] ] : $contact_data['subject'];

	// Email subject.
	/* translators: 1: Subject type, 2: Site name, 3: Sender name */
	$email_subject = sprintf( __( '[%2$s Contact] %1$s from %3$s', 'homerix' ), $subject_label, $site_name, $contact_data['full_name'] );

	// Build email content.
	$email_content = homerix_get_contact_email_content( $contact_data, $subject_label );

	// Get From email from SMTP settings.
	$from_email = get_theme_mod( 'HOMERIX_SMTP_FROM_email', '' );
	if ( empty( $from_email ) ) {
		$from_email = get_theme_mod( 'HOMERIX_SMTP_USERname', '' );
	}
	if ( empty( $from_email ) ) {
		$from_email = get_option( 'admin_email' );
	}
	$from_name = get_theme_mod( 'HOMERIX_SMTP_FROM_name', $site_name );

	// Email headers.
	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . $from_name . ' <' . $from_email . '>',
		'Reply-To: ' . $contact_data['full_name'] . ' <' . $contact_data['email'] . '>',
	);

	// Debug log before sending.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( 'Homerix Contact Form: Attempting to send email to: ' . $admin_email );
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( 'Homerix Contact Form: Subject: ' . $email_subject );
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( 'Homerix Contact Form: From: ' . $contact_data['email'] );
	}

	// Send email.
	$sent = wp_mail( $admin_email, $email_subject, $email_content, $headers );

	// Debug log result.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		if ( $sent ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( 'Homerix Contact Form: Email sent successfully!' );
		} else {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( 'Homerix Contact Form: Email FAILED to send.' );
			// Get the last mail error if available.
			global $phpmailer;
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			if ( isset( $phpmailer ) && is_object( $phpmailer ) && ! empty( $phpmailer->ErrorInfo ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log, WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				error_log( 'Homerix Contact Form: PHPMailer Error: ' . $phpmailer->ErrorInfo );
			}
		}
	}

	return $sent;
}

/**
 * Get contact email HTML content.
 *
 * @param array  $contact_data Contact form data.
 * @param string $subject_label Subject label.
 * @return string HTML email content.
 */
function homerix_get_contact_email_content( $contact_data, $subject_label ) {
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url();

	ob_start();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f5f5f5; padding: 30px 0;">
			<tr>
				<td align="center">
					<table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
						<!-- Header -->
						<tr>
							<td style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 30px; text-align: center;">
								<h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">
									<?php esc_html_e( 'New Contact Form Submission', 'homerix' ); ?>
								</h1>
							</td>
						</tr>
						<!-- Content -->
						<tr>
							<td style="padding: 30px;">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="padding: 15px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 20px;">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
														<strong style="color: #64748b;"><?php esc_html_e( 'Subject Type:', 'homerix' ); ?></strong><br>
														<span style="color: #1e293b; font-size: 16px;"><?php echo esc_html( $subject_label ); ?></span>
													</td>
												</tr>
												<tr>
													<td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
														<strong style="color: #64748b;"><?php esc_html_e( 'From:', 'homerix' ); ?></strong><br>
														<span style="color: #1e293b; font-size: 16px;"><?php echo esc_html( $contact_data['full_name'] ); ?></span>
													</td>
												</tr>
												<tr>
													<td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
														<strong style="color: #64748b;"><?php esc_html_e( 'Email:', 'homerix' ); ?></strong><br>
														<a href="mailto:<?php echo esc_attr( $contact_data['email'] ); ?>" style="color: #2563eb; text-decoration: none; font-size: 16px;"><?php echo esc_html( $contact_data['email'] ); ?></a>
													</td>
												</tr>
												<?php if ( ! empty( $contact_data['phone'] ) ) : ?>
												<tr>
													<td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
														<strong style="color: #64748b;"><?php esc_html_e( 'Phone:', 'homerix' ); ?></strong><br>
														<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_data['phone'] ) ); ?>" style="color: #2563eb; text-decoration: none; font-size: 16px;"><?php echo esc_html( $contact_data['phone'] ); ?></a>
													</td>
												</tr>
												<?php endif; ?>
												<tr>
													<td style="padding: 8px 0;">
														<strong style="color: #64748b;"><?php esc_html_e( 'Date:', 'homerix' ); ?></strong><br>
														<span style="color: #1e293b; font-size: 16px;"><?php echo esc_html( gmdate( 'F j, Y \a\t g:i a', strtotime( $contact_data['date'] ) ) ); ?></span>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding-top: 20px;">
											<h3 style="color: #1e293b; margin: 0 0 10px 0; font-size: 16px;"><?php esc_html_e( 'Message:', 'homerix' ); ?></h3>
											<div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #2563eb;">
												<p style="color: #1e293b; margin: 0; line-height: 1.6; white-space: pre-wrap;"><?php echo esc_html( $contact_data['message'] ); ?></p>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<!-- Footer -->
						<tr>
							<td style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;">
								<p style="color: #64748b; margin: 0; font-size: 14px;">
									<?php
									/* translators: %s: Site name */
									printf( esc_html__( 'This message was sent via the contact form on %s', 'homerix' ), '<a href="' . esc_url( $site_url ) . '" style="color: #2563eb; text-decoration: none;">' . esc_html( $site_name ) . '</a>' );
									?>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
	</html>
	<?php
	return ob_get_clean();
}
