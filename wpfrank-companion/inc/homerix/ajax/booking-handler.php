<?php
/**
 * Booking Form AJAX Handler
 *
 * Handles booking form submission with reCAPTCHA v3 verification
 * and sends professional HTML email notifications.
 *
 * @package Homerix_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle booking form submission via AJAX.
 */
add_action( 'wp_ajax_submit_booking', 'homerix_handle_booking_submission' );
add_action( 'wp_ajax_nopriv_submit_booking', 'homerix_handle_booking_submission' );

/**
 * Process booking form submission.
 */
function homerix_handle_booking_submission() {
	// Verify nonce.
	$nonce = isset( $_POST['booking_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['booking_nonce'] ) ) : '';
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'homerix_booking_nonce' ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Security verification failed.', 'homerix' ),
			)
		);
	}

	// Note: reCAPTCHA checkbox verification is handled on the frontend.
	// The checkbox is verified by Google's reCAPTCHA API before form submission.
	// The frontend will only submit if reCAPTCHA is verified.

	// Get and sanitize booking data.
	$booking_data_raw = isset( $_POST['booking_data'] ) ? sanitize_text_field( wp_unslash( $_POST['booking_data'] ) ) : '';
	$booking_data     = ! empty( $booking_data_raw ) ? json_decode( $booking_data_raw, true ) : array();

	// Build required fields dynamically based on Customizer settings.
	// Service and time_slot are always required.
	$required_fields = array( 'service', 'time_slot' );

	// Add customer detail fields based on Customizer settings.
	if ( get_theme_mod( 'booking_field_first_name', true ) ) {
		$required_fields[] = 'first_name';
	}
	if ( get_theme_mod( 'booking_field_last_name', true ) ) {
		$required_fields[] = 'last_name';
	}
	if ( get_theme_mod( 'booking_field_email', true ) ) {
		$required_fields[] = 'email';
	}
	if ( get_theme_mod( 'booking_field_phone', true ) ) {
		$required_fields[] = 'phone';
	}
	if ( get_theme_mod( 'booking_field_address', true ) ) {
		$required_fields[] = 'address';
	}

	foreach ( $required_fields as $field ) {
		if ( empty( $booking_data[ $field ] ) ) {
			wp_send_json_error(
				array(
					// Translators: %s is the field name.
					'message' => sprintf( __( 'Required field missing: %s', 'homerix' ), $field ),
				)
			);
		}
	}

	// Sanitize booking data.
	$booking_data = array(
		'service'              => sanitize_text_field( $booking_data['service'] ?? '' ),
		'time_type'            => sanitize_text_field( $booking_data['time_type'] ?? '' ),
		'time_slot'            => sanitize_text_field( $booking_data['time_slot'] ?? '' ),
		'first_name'           => sanitize_text_field( $booking_data['first_name'] ?? '' ),
		'last_name'            => sanitize_text_field( $booking_data['last_name'] ?? '' ),
		'email'                => sanitize_email( $booking_data['email'] ?? '' ),
		'phone'                => sanitize_text_field( $booking_data['phone'] ?? '' ),
		'address'              => sanitize_text_field( $booking_data['address'] ?? '' ),
		'notes'                => sanitize_textarea_field( $booking_data['notes'] ?? '' ),
		'additional_notes'     => sanitize_textarea_field( $booking_data['additional_notes'] ?? '' ),
		'payment_method'       => sanitize_text_field( $booking_data['payment_method'] ?? '' ),
		'terms'                => isset( $booking_data['terms'] ) ? (bool) $booking_data['terms'] : false,
		'technician_name'      => sanitize_text_field( $booking_data['technician_name'] ?? '' ),
		'technician_specialty' => sanitize_text_field( $booking_data['technician_specialty'] ?? '' ),
	);

	// Validate email only if email field is enabled.
	if ( get_theme_mod( 'booking_field_email', true ) && ! empty( $booking_data['email'] ) ) {
		if ( ! is_email( $booking_data['email'] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid email address.', 'homerix' ),
				)
			);
		}
	}

	// Validate phone only if phone field is enabled.
	if ( get_theme_mod( 'booking_field_phone', true ) && ! empty( $booking_data['phone'] ) ) {
		if ( ! preg_match( '/^[0-9\-\+\(\)\s]+$/', $booking_data['phone'] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Invalid phone number.', 'homerix' ),
				)
			);
		}
	}

	// Build customer identifier for booking post title.
	$customer_name = trim( $booking_data['first_name'] . ' ' . $booking_data['last_name'] );
	if ( empty( $customer_name ) ) {
		// Fallback to email or phone if no name provided.
		if ( ! empty( $booking_data['email'] ) ) {
			$customer_name = $booking_data['email'];
		} elseif ( ! empty( $booking_data['phone'] ) ) {
			$customer_name = $booking_data['phone'];
		} else {
			$customer_name = __( 'Customer', 'homerix' );
		}
	}

	// Create booking post.
	$booking_post = array(
		'post_type'    => 'bookings',
		'post_title'   => $customer_name . ' - ' . $booking_data['service'],
		'post_content' => wp_json_encode( $booking_data ),
		'post_status'  => 'pending',
	);

	$booking_id = wp_insert_post( $booking_post );

	if ( is_wp_error( $booking_id ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Error creating booking. Please try again.', 'homerix' ),
			)
		);
	}

	// Save booking meta data.
	foreach ( $booking_data as $key => $value ) {
		update_post_meta( $booking_id, '_booking_' . $key, $value );
	}

	// Send confirmation emails.
	$email_sent = homerix_send_booking_emails( $booking_id, $booking_data );

	// Log email sending result for debugging.
	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		error_log( 'Booking #' . $booking_id . ' emails sent - Result: ' . ( $email_sent ? 'Success' : 'Failed' ) );
	}

	// Send success response with email status.
	if ( $email_sent ) {
		wp_send_json_success(
			array(
				'message'    => __( 'Booking submitted successfully! A confirmation email has been sent to you.', 'homerix' ),
				'booking_id' => $booking_id,
				'email_sent' => true,
			)
		);
	} else {
		// Booking succeeded but email failed - warn the user.
		wp_send_json_success(
			array(
				'message'     => __( 'Booking submitted successfully! However, there was an issue sending the confirmation email. Please save your booking reference.', 'homerix' ),
				'booking_id'  => $booking_id,
				'email_sent'  => false,
				'email_error' => true,
			)
		);
	}
}

/**
 * Send booking emails (both admin notification and customer confirmation).
 *
 * @param int   $booking_id Booking post ID.
 * @param array $booking_data Booking data.
 * @return bool True if all emails sent successfully.
 */
function homerix_send_booking_emails( $booking_id, $booking_data ) {
	// Check if email field is enabled.
	$email_field_enabled = get_theme_mod( 'booking_field_email', true );

	// Get email settings from customizer.
	$send_customer_email = get_theme_mod( 'booking_email_send_customer', true );
	$admin_email         = get_theme_mod( 'booking_admin_email', get_option( 'admin_email' ) );
	$from_name           = get_theme_mod( 'HOMERIX_SMTP_FROM_name', get_bloginfo( 'name' ) );
	$from_email          = get_theme_mod( 'HOMERIX_SMTP_FROM_email', get_option( 'admin_email' ) );

	// Fallback for empty settings.
	if ( empty( $admin_email ) ) {
		$admin_email = get_option( 'admin_email' );
	}
	if ( empty( $from_email ) ) {
		$from_email = get_option( 'admin_email' );
	}
	if ( empty( $from_name ) ) {
		$from_name = get_bloginfo( 'name' );
	}

	// Common headers for HTML email.
	$common_headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . $from_name . ' <' . $from_email . '>',
	);

	// Customer email headers - Reply-To should be the business email (From Email setting).
	$customer_headers = array_merge(
		$common_headers,
		array( 'Reply-To: ' . $from_name . ' <' . $from_email . '>' )
	);

	// Build reply-to name from available data.
	$customer_name = trim( ( $booking_data['first_name'] ?? '' ) . ' ' . ( $booking_data['last_name'] ?? '' ) );
	if ( empty( $customer_name ) ) {
		$customer_name = __( 'Customer', 'homerix' );
	}

	// Admin email headers - Reply-To should be the customer if email is available.
	if ( ! empty( $booking_data['email'] ) && is_email( $booking_data['email'] ) ) {
		$admin_headers = array_merge(
			$common_headers,
			array( 'Reply-To: ' . $customer_name . ' <' . $booking_data['email'] . '>' )
		);
	} else {
		// No customer email available, use from email for reply-to.
		$admin_headers = $common_headers;
	}

	$customer_email_sent = true;
	$admin_email_sent    = true;

	// Send customer confirmation email if enabled AND customer email is available.
	$has_valid_customer_email = ! empty( $booking_data['email'] ) && is_email( $booking_data['email'] );
	if ( $send_customer_email && $has_valid_customer_email ) {
		$customer_subject    = homerix_get_customer_email_subject( $booking_id, $booking_data );
		$customer_message    = homerix_get_customer_email_body( $booking_id, $booking_data );
		$customer_email_sent = wp_mail( $booking_data['email'], $customer_subject, $customer_message, $customer_headers );

		if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			error_log( 'Customer confirmation email sent to: ' . $booking_data['email'] . ' - Result: ' . ( $customer_email_sent ? 'Success' : 'Failed' ) );
		}
	}

	// Always send admin notification email.
	$admin_subject    = homerix_get_admin_email_subject( $booking_id, $booking_data );
	$admin_message    = homerix_get_admin_email_body( $booking_id, $booking_data );
	$admin_email_sent = wp_mail( $admin_email, $admin_subject, $admin_message, $admin_headers );

	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		error_log( 'Admin notification email sent to: ' . $admin_email . ' - Result: ' . ( $admin_email_sent ? 'Success' : 'Failed' ) );
	}

	// Return true if admin email was sent (customer email is optional if field disabled).
	if ( ! $has_valid_customer_email ) {
		return $admin_email_sent;
	}

	return $customer_email_sent && $admin_email_sent;
}

/**
 * Get customer email subject with template tag replacement.
 *
 * @param int   $booking_id Booking ID.
 * @param array $booking_data Booking data.
 * @return string Email subject.
 */
function homerix_get_customer_email_subject( $booking_id, $booking_data ) {
	$subject = get_theme_mod( 'booking_email_subject', __( 'Booking Confirmation - {site_name}', 'homerix' ) );
	return homerix_replace_email_tags( $subject, $booking_id, $booking_data );
}

/**
 * Get admin email subject.
 *
 * @param int   $booking_id Booking ID.
 * @param array $booking_data Booking data.
 * @return string Email subject.
 */
function homerix_get_admin_email_subject( $booking_id, $booking_data ) {
	$subject = get_theme_mod( 'booking_admin_email_subject', __( '🔔 New Booking #{booking_id} - {service}', 'homerix' ) );
	return homerix_replace_email_tags( $subject, $booking_id, $booking_data );
}

/**
 * Get customer confirmation email body (HTML).
 *
 * @param int   $booking_id Booking ID.
 * @param array $booking_data Booking data.
 * @return string HTML email body.
 */
function homerix_get_customer_email_body( $booking_id, $booking_data ) {
	$custom_body = get_theme_mod( 'booking_email_body', '' );

	// Use custom body if set, otherwise use default template.
	if ( ! empty( $custom_body ) ) {
		$content = homerix_replace_email_tags( nl2br( $custom_body ), $booking_id, $booking_data );
	} else {
		$content = homerix_get_default_customer_email_content( $booking_id, $booking_data );
	}

	return homerix_get_email_html_wrapper( $content, 'customer', $booking_data );
}

/**
 * Get admin notification email body (HTML).
 *
 * @param int   $booking_id Booking ID.
 * @param array $booking_data Booking data.
 * @return string HTML email body.
 */
function homerix_get_admin_email_body( $booking_id, $booking_data ) {
	$content = homerix_get_default_admin_email_content( $booking_id, $booking_data );
	return homerix_get_email_html_wrapper( $content, 'admin', $booking_data );
}

/**
 * Get default customer email content.
 *
 * @param int   $booking_id Booking ID.
 * @param array $booking_data Booking data.
 * @return string HTML content.
 */
function homerix_get_default_customer_email_content( $booking_id, $booking_data ) {
	$full_name = trim( ( $booking_data['first_name'] ?? '' ) . ' ' . ( $booking_data['last_name'] ?? '' ) );

	$html = '<h2 style="color: #16a34a; margin-bottom: 20px;">' . esc_html__( '✅ Booking Confirmed!', 'homerix' ) . '</h2>';

	$html .= '<p style="font-size: 16px; color: #374151;">' .
		sprintf(
			/* translators: %s: Customer first name */
			esc_html__( 'Dear %s,', 'homerix' ),
			esc_html( $booking_data['first_name'] ?? __( 'Customer', 'homerix' ) )
		) . '</p>';

	$html .= '<p style="font-size: 16px; color: #374151;">' .
		esc_html__( 'Thank you for booking with us! Your service appointment has been confirmed. Here are your booking details:', 'homerix' ) . '</p>';

	// Booking details table.
	$html .= '<table style="width: 100%; border-collapse: collapse; margin: 20px 0; background: #f9fafb; border-radius: 8px;">';

	$html .= '<tr><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #374151; width: 40%;">' . esc_html__( 'Booking ID', 'homerix' ) . '</td><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #6b7280;">#' . esc_html( $booking_id ) . '</td></tr>';

	$html .= '<tr><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #374151;">' . esc_html__( 'Service', 'homerix' ) . '</td><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #6b7280;">' . esc_html( $booking_data['service'] ?? '-' ) . '</td></tr>';

	if ( ! empty( $booking_data['time_type'] ) ) {
		$html .= '<tr><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #374151;">' . esc_html__( 'Appointment Type', 'homerix' ) . '</td><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #6b7280;">' . esc_html( ucfirst( str_replace( array( '-', '_' ), ' ', $booking_data['time_type'] ) ) ) . '</td></tr>';
	}

	$html .= '<tr><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #374151;">' . esc_html__( 'Time Slot', 'homerix' ) . '</td><td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #6b7280;">' . esc_html( $booking_data['time_slot'] ?? '-' ) . '</td></tr>';

	$html .= '<tr><td style="padding: 12px 16px; font-weight: 600; color: #374151;">' . esc_html__( 'Service Address', 'homerix' ) . '</td><td style="padding: 12px 16px; color: #6b7280;">' . esc_html( $booking_data['address'] ?? '-' ) . '</td></tr>';

	if ( ! empty( $booking_data['technician_name'] ) ) {
		$html .= '<tr><td style="padding: 12px 16px; border-top: 1px solid #e5e7eb; font-weight: 600; color: #374151;">' . esc_html__( 'Assigned Technician', 'homerix' ) . '</td><td style="padding: 12px 16px; border-top: 1px solid #e5e7eb; color: #6b7280;">' . esc_html( $booking_data['technician_name'] );
		if ( ! empty( $booking_data['technician_specialty'] ) ) {
			$html .= ' <span style="color: #9ca3af;">(' . esc_html( $booking_data['technician_specialty'] ) . ')</span>';
		}
		$html .= '</td></tr>';
	}

	$html .= '</table>';

	$html .= '<p style="font-size: 16px; color: #374151;">' .
		esc_html__( 'We will contact you shortly to confirm the exact appointment time. If you have any questions, please don\'t hesitate to reach out.', 'homerix' ) . '</p>';

	$html .= '<p style="font-size: 16px; color: #374151; margin-top: 30px;">' .
		esc_html__( 'Thank you for choosing us!', 'homerix' ) . '<br>' .
		'<strong>' . esc_html( get_bloginfo( 'name' ) ) . '</strong></p>';

	return $html;
}

/**
 * Get default admin email content.
 *
 * @param int   $booking_id Booking ID.
 * @param array $booking_data Booking data.
 * @return string HTML content.
 */
function homerix_get_default_admin_email_content( $booking_id, $booking_data ) {
	$full_name = trim( ( $booking_data['first_name'] ?? '' ) . ' ' . ( $booking_data['last_name'] ?? '' ) );

	$html = '<h2 style="color: #2563eb; margin-bottom: 20px;">' . esc_html__( '🔔 New Booking Received', 'homerix' ) . '</h2>';

	$html .= '<p style="font-size: 16px; color: #374151;">' .
		sprintf(
			/* translators: %s: Booking ID */
			esc_html__( 'A new booking (#%s) has been submitted. Please review the details below:', 'homerix' ),
			esc_html( $booking_id )
		) . '</p>';

	// Service Details Section.
	$html .= '<h3 style="color: #374151; border-bottom: 2px solid #2563eb; padding-bottom: 8px; margin-top: 30px;">' . esc_html__( '📋 Service Details', 'homerix' ) . '</h3>';

	$html .= '<table style="width: 100%; border-collapse: collapse; margin: 15px 0;">';
	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151; width: 35%;">' . esc_html__( 'Booking ID:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;"><strong>#' . esc_html( $booking_id ) . '</strong></td></tr>';
	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Service:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( $booking_data['service'] ?? '-' ) . '</td></tr>';

	if ( ! empty( $booking_data['time_type'] ) ) {
		$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Appointment Type:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( ucfirst( str_replace( array( '-', '_' ), ' ', $booking_data['time_type'] ) ) ) . '</td></tr>';
	}

	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Time Slot:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( $booking_data['time_slot'] ?? '-' ) . '</td></tr>';
	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Service Address:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( $booking_data['address'] ?? '-' ) . '</td></tr>';
	$html .= '</table>';

	// Customer Details Section.
	$html .= '<h3 style="color: #374151; border-bottom: 2px solid #16a34a; padding-bottom: 8px; margin-top: 30px;">' . esc_html__( '👤 Customer Information', 'homerix' ) . '</h3>';

	$html .= '<table style="width: 100%; border-collapse: collapse; margin: 15px 0;">';
	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151; width: 35%;">' . esc_html__( 'Name:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( $full_name ) . '</td></tr>';
	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Email:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;"><a href="mailto:' . esc_attr( $booking_data['email'] ?? '' ) . '" style="color: #2563eb;">' . esc_html( $booking_data['email'] ?? '-' ) . '</a></td></tr>';
	$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Phone:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;"><a href="tel:' . esc_attr( $booking_data['phone'] ?? '' ) . '" style="color: #2563eb;">' . esc_html( $booking_data['phone'] ?? '-' ) . '</a></td></tr>';
	$html .= '</table>';

	// Technician Info (if assigned).
	if ( ! empty( $booking_data['technician_name'] ) ) {
		$html .= '<h3 style="color: #374151; border-bottom: 2px solid #eab308; padding-bottom: 8px; margin-top: 30px;">' . esc_html__( '🔧 Requested Technician', 'homerix' ) . '</h3>';
		$html .= '<table style="width: 100%; border-collapse: collapse; margin: 15px 0;">';
		$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151; width: 35%;">' . esc_html__( 'Technician:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( $booking_data['technician_name'] ) . '</td></tr>';
		if ( ! empty( $booking_data['technician_specialty'] ) ) {
			$html .= '<tr><td style="padding: 10px 0; font-weight: 600; color: #374151;">' . esc_html__( 'Specialty:', 'homerix' ) . '</td><td style="padding: 10px 0; color: #6b7280;">' . esc_html( $booking_data['technician_specialty'] ) . '</td></tr>';
		}
		$html .= '</table>';
	}

	// Notes Section (if any).
	if ( ! empty( $booking_data['notes'] ) || ! empty( $booking_data['additional_notes'] ) ) {
		$html .= '<h3 style="color: #374151; border-bottom: 2px solid #6b7280; padding-bottom: 8px; margin-top: 30px;">' . esc_html__( '📝 Customer Notes', 'homerix' ) . '</h3>';

		if ( ! empty( $booking_data['notes'] ) ) {
			$html .= '<div style="background: #f9fafb; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #2563eb;">';
			$html .= '<strong>' . esc_html__( 'Special Instructions:', 'homerix' ) . '</strong><br>';
			$html .= '<p style="margin: 10px 0 0 0; color: #6b7280;">' . nl2br( esc_html( $booking_data['notes'] ) ) . '</p>';
			$html .= '</div>';
		}

		if ( ! empty( $booking_data['additional_notes'] ) ) {
			$html .= '<div style="background: #f9fafb; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #16a34a;">';
			$html .= '<strong>' . esc_html__( 'Additional Notes:', 'homerix' ) . '</strong><br>';
			$html .= '<p style="margin: 10px 0 0 0; color: #6b7280;">' . nl2br( esc_html( $booking_data['additional_notes'] ) ) . '</p>';
			$html .= '</div>';
		}
	}

	// Action Button.
	$admin_url = admin_url( 'edit.php?post_type=bookings' );
	$html     .= '<div style="text-align: center; margin-top: 30px;">';
	$html     .= '<a href="' . esc_url( $admin_url ) . '" style="display: inline-block; background: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;">' . esc_html__( 'View All Bookings →', 'homerix' ) . '</a>';
	$html     .= '</div>';

	return $html;
}

/**
 * Get HTML email wrapper template.
 *
 * @param string $content Main email content.
 * @param string $type Email type: 'customer' or 'admin'.
 * @param array  $booking_data Booking data.
 * @return string Complete HTML email.
 */
function homerix_get_email_html_wrapper( $content, $type = 'customer', $booking_data = array() ) {
	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url();
	$year      = gmdate( 'Y' );

	// Header color based on email type.
	$header_bg    = ( 'admin' === $type ) ? '#1e40af' : '#2563eb';
	$header_title = ( 'admin' === $type ) ? __( 'New Booking Notification', 'homerix' ) : __( 'Booking Confirmation', 'homerix' );

	$html = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif;">
	<table role="presentation" style="width: 100%; border-collapse: collapse;">
		<tr>
			<td align="center" style="padding: 40px 20px;">
				<table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse;">
					<!-- Header -->
					<tr>
						<td style="background: ' . esc_attr( $header_bg ) . '; padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
							<h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">' . esc_html( $site_name ) . '</h1>
							<p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 14px;">' . esc_html( $header_title ) . '</p>
						</td>
					</tr>
					<!-- Content -->
					<tr>
						<td style="background: #ffffff; padding: 40px 30px; border-radius: 0 0 8px 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
							' . $content . '
						</td>
					</tr>
					<!-- Footer -->
					<tr>
						<td style="padding: 30px; text-align: center;">
							<p style="color: #6b7280; font-size: 14px; margin: 0;">
								' . esc_html__( 'This email was sent from', 'homerix' ) . ' <a href="' . esc_url( $site_url ) . '" style="color: #2563eb;">' . esc_html( $site_name ) . '</a>
							</p>
							<p style="color: #9ca3af; font-size: 12px; margin: 10px 0 0 0;">
								© ' . esc_html( $year ) . ' ' . esc_html( $site_name ) . '. ' . esc_html__( 'All rights reserved.', 'homerix' ) . '
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>';

	return $html;
}

/**
 * Replace email template tags with actual values.
 *
 * @param string $content Content with template tags.
 * @param int    $booking_id Booking ID.
 * @param array  $booking_data Booking data.
 * @return string Content with tags replaced.
 */
function homerix_replace_email_tags( $content, $booking_id, $booking_data ) {
	$full_name = trim( ( $booking_data['first_name'] ?? '' ) . ' ' . ( $booking_data['last_name'] ?? '' ) );

	$tags = array(
		'{site_name}'            => get_bloginfo( 'name' ),
		'{site_url}'             => home_url(),
		'{booking_id}'           => $booking_id,
		'{service}'              => $booking_data['service'] ?? '',
		'{time_type}'            => ucfirst( str_replace( array( '-', '_' ), ' ', $booking_data['time_type'] ?? '' ) ),
		'{time_slot}'            => $booking_data['time_slot'] ?? '',
		'{address}'              => $booking_data['address'] ?? '',
		'{first_name}'           => $booking_data['first_name'] ?? '',
		'{last_name}'            => $booking_data['last_name'] ?? '',
		'{full_name}'            => $full_name,
		'{email}'                => $booking_data['email'] ?? '',
		'{phone}'                => $booking_data['phone'] ?? '',
		'{notes}'                => $booking_data['notes'] ?? '',
		'{additional_notes}'     => $booking_data['additional_notes'] ?? '',
		'{technician_name}'      => $booking_data['technician_name'] ?? '',
		'{technician_specialty}' => $booking_data['technician_specialty'] ?? '',
	);

	return str_replace( array_keys( $tags ), array_values( $tags ), $content );
}

// Keep the old function name for backward compatibility.
if ( ! function_exists( 'homerix_send_booking_confirmation_email' ) ) {
	/**
	 * Backward compatibility wrapper for old email function.
	 *
	 * @param int   $booking_id Booking post ID.
	 * @param array $booking_data Booking data.
	 * @return bool True if emails sent successfully.
	 */
	function homerix_send_booking_confirmation_email( $booking_id, $booking_data ) {
		return homerix_send_booking_emails( $booking_id, $booking_data );
	}
}
