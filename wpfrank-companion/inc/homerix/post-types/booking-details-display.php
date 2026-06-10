<?php
/**
 * Booking Details Display
 *
 * Displays booking details in WordPress admin with custom columns and metabox
 *
 * @package Homerix_Pro
 */

// phpcs:disable Squiz.Commenting.InlineComment.InvalidEndChar, Squiz.Commenting.FunctionComment.Missing, Squiz.Commenting.FileComment.MissingPackageTag, Squiz.Commenting.FileComment.Missing, WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom columns to bookings list
 *
 * @param array $columns Existing columns.
 * @return array Modified columns.
 */
function homerix_booking_columns( $columns ) {
	$new_columns = array();

	foreach ( $columns as $key => $value ) {
		if ( 'title' === $key ) {
			$new_columns['title']      = $value;
			$new_columns['customer']   = __( 'Customer', 'homerix' );
			$new_columns['service']    = __( 'Service', 'homerix' );
			$new_columns['technician'] = __( 'Technician', 'homerix' );
			$new_columns['time_type']  = __( 'Time Type', 'homerix' );
			$new_columns['time_slot']  = __( 'Time Slot', 'homerix' );
			$new_columns['phone']      = __( 'Phone', 'homerix' );
			$new_columns['email']      = __( 'Email', 'homerix' );
		} else {
			$new_columns[ $key ] = $value;
		}
	}

	return $new_columns;
}
add_filter( 'manage_bookings_posts_columns', 'homerix_booking_columns' );

/**
 * Display custom column values
 *
 * @param string $column Column name.
 * @param int    $post_id Post ID.
 */
function homerix_booking_column_values( $column, $post_id ) {
	switch ( $column ) {
		case 'customer':
			$first_name = get_post_meta( $post_id, '_booking_first_name', true );
			$last_name  = get_post_meta( $post_id, '_booking_last_name', true );
			echo esc_html( $first_name . ' ' . $last_name );
			break;

		case 'service':
			$service = get_post_meta( $post_id, '_booking_service', true );
			echo esc_html( $service );
			break;

		case 'technician':
			$tech_name      = get_post_meta( $post_id, '_booking_technician_name', true );
			$tech_specialty = get_post_meta( $post_id, '_booking_technician_specialty', true );
			if ( $tech_name ) {
				echo '<strong>' . esc_html( $tech_name ) . '</strong>';
				if ( $tech_specialty ) {
					echo '<br><small>' . esc_html( $tech_specialty ) . '</small>';
				}
			} else {
				echo '<span style="color:#999;">—</span>';
			}
			break;

		case 'time_type':
			$time_type = get_post_meta( $post_id, '_booking_time_type', true );
			echo esc_html( ucfirst( str_replace( '_', ' ', $time_type ) ) );
			break;

		case 'time_slot':
			$time_slot = get_post_meta( $post_id, '_booking_time_slot', true );
			echo esc_html( $time_slot );
			break;

		case 'phone':
			$phone = get_post_meta( $post_id, '_booking_phone', true );
			echo esc_html( $phone );
			break;

		case 'email':
			$email = get_post_meta( $post_id, '_booking_email', true );
			echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
			break;
	}
}
add_action( 'manage_bookings_posts_custom_column', 'homerix_booking_column_values', 10, 2 );

/**
 * Make columns sortable
 *
 * @param array $sortable_columns Sortable columns.
 * @return array Modified sortable columns.
 */
function homerix_booking_sortable_columns( $sortable_columns ) {
	$sortable_columns['customer']  = 'title';
	$sortable_columns['service']   = '_booking_service';
	$sortable_columns['time_type'] = '_booking_time_type';
	$sortable_columns['time_slot'] = '_booking_time_slot';
	$sortable_columns['phone']     = '_booking_phone';
	$sortable_columns['email']     = '_booking_email';

	return $sortable_columns;
}
add_filter( 'manage_edit-bookings_sortable_columns', 'homerix_booking_sortable_columns' );

/**
 * Add metabox to booking edit page
 */
function homerix_add_booking_details_metabox() {
	add_meta_box(
		'homerix_booking_details',
		__( '📋 Booking Details', 'homerix' ),
		'homerix_booking_details_metabox_callback',
		'bookings',
		'normal',
		'high'
	);

	add_meta_box(
		'homerix_booking_contact',
		__( '📞 Contact Information', 'homerix' ),
		'homerix_booking_contact_metabox_callback',
		'bookings',
		'normal',
		'high'
	);

	add_meta_box(
		'homerix_booking_notes',
		__( '📝 Notes', 'homerix' ),
		'homerix_booking_notes_metabox_callback',
		'bookings',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_bookings', 'homerix_add_booking_details_metabox' );

/**
 * Booking details metabox callback
 *
 * @param WP_Post $post Post object.
 */
function homerix_booking_details_metabox_callback( $post ) {
	$service        = get_post_meta( $post->ID, '_booking_service', true );
	$time_type      = get_post_meta( $post->ID, '_booking_time_type', true );
	$time_slot      = get_post_meta( $post->ID, '_booking_time_slot', true );
	$address        = get_post_meta( $post->ID, '_booking_address', true );
	$tech_name      = get_post_meta( $post->ID, '_booking_technician_name', true );
	$tech_specialty = get_post_meta( $post->ID, '_booking_technician_specialty', true );
	?>
	<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
		<div>
			<p><strong><?php esc_html_e( 'Service:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php echo esc_html( $service ); ?>
			</p>
		</div>
		<div>
			<p><strong><?php esc_html_e( 'Requested Technician:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php
				if ( $tech_name ) {
					echo esc_html( $tech_name );
					if ( $tech_specialty ) {
						echo ' <em>(' . esc_html( $tech_specialty ) . ')</em>';
					}
				} else {
					esc_html_e( 'No preference', 'homerix' );
				}
				?>
			</p>
		</div>
		<div>
			<p><strong><?php esc_html_e( 'Time Type:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php echo esc_html( ucfirst( $time_type ) ); ?>
			</p>
		</div>
		<div>
			<p><strong><?php esc_html_e( 'Time Slot:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php echo esc_html( $time_slot ); ?>
			</p>
		</div>
		<div style="grid-column: span 2;">
			<p><strong><?php esc_html_e( 'Address:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php echo esc_html( $address ); ?>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Booking contact metabox callback
 *
 * @param WP_Post $post Post object.
 */
function homerix_booking_contact_metabox_callback( $post ) {
	$first_name = get_post_meta( $post->ID, '_booking_first_name', true );
	$last_name  = get_post_meta( $post->ID, '_booking_last_name', true );
	$email      = get_post_meta( $post->ID, '_booking_email', true );
	$phone      = get_post_meta( $post->ID, '_booking_phone', true );
	?>
	<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
		<div>
			<p><strong><?php esc_html_e( 'First Name:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php echo esc_html( $first_name ); ?>
			</p>
		</div>
		<div>
			<p><strong><?php esc_html_e( 'Last Name:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<?php echo esc_html( $last_name ); ?>
			</p>
		</div>
		<div>
			<p><strong><?php esc_html_e( 'Email:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<a href="mailto:<?php echo esc_attr( $email ); ?>">
					<?php echo esc_html( $email ); ?>
				</a>
			</p>
		</div>
		<div>
			<p><strong><?php esc_html_e( 'Phone:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
				<a href="tel:<?php echo esc_attr( $phone ); ?>">
					<?php echo esc_html( $phone ); ?>
				</a>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Booking notes metabox callback
 *
 * @param WP_Post $post Post object.
 */
function homerix_booking_notes_metabox_callback( $post ) {
	$notes            = get_post_meta( $post->ID, '_booking_notes', true );
	$additional_notes = get_post_meta( $post->ID, '_booking_additional_notes', true );
	?>
	<?php if ( ! empty( $notes ) ) : ?>
		<div style="margin-bottom: 20px;">
			<p><strong><?php esc_html_e( 'Notes:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px; white-space: pre-wrap;">
				<?php echo esc_html( $notes ); ?>
			</p>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $additional_notes ) ) : ?>
		<div>
			<p><strong><?php esc_html_e( 'Additional Notes:', 'homerix' ); ?></strong></p>
			<p style="background: #f5f5f5; padding: 10px; border-radius: 4px; white-space: pre-wrap;">
				<?php echo esc_html( $additional_notes ); ?>
			</p>
		</div>
	<?php endif; ?>

	<?php if ( empty( $notes ) && empty( $additional_notes ) ) : ?>
		<p style="color: #999;">
			<?php esc_html_e( 'No notes provided.', 'homerix' ); ?>
		</p>
	<?php endif; ?>
	<?php
}

