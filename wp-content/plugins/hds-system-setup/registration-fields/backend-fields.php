<?php
/**
 * ----------------------------------------
 * Functions with custom fields on backend.
 * ---------------------------------------
 */

/**
 * Add 'user_key' for registered user with role - doctor, clinic or med_pred
 * @param $user_id
 */
function hds_add_user_key ( $user_id ) {
	if ( user_can( $user_id, 'hds_doctor' ) ||
		user_can( $user_id, 'hds_clinic' ) ||
		user_can( $user_id, 'hds_med_pred' )
	) {
		update_user_meta( $user_id, 'user_key', '100' . $user_id );
	}
}
add_action( 'user_register', 'hds_add_user_key' );

/**
 * Back end registration - add 'medical_id' field
 */
function hds_admin_registration_form( $operation ) {
	if ( 'add-new-user' !== $operation ) {

		return;
	}

	$medical_id = ! empty( $_POST['medical_id'] ) ? intval( $_POST['medical_id'] ) : '';

	?>
	<table class="form-table medical-table">
		<tr>
			<th>
				<label for="medical_id"><?php esc_html_e( 'ID клиники / врача', 'hds-settings' ); ?></label>
				<span class="description"><?php esc_html_e( '(опционально)', 'hds-settings' ); ?></span>
			</th>
			<td>
				<input type="text" id="medical_id" name="medical_id"
				       value="<?php echo esc_attr( $medical_id ); ?>" class="input regular-text">
		</tr>
	</table>
	<?php
}
add_action( 'user_new_form', 'hds_admin_registration_form' );

/**
 * Add js script to User-New Page in admin
 * @param $hook
 */
function hds_enqueue( $hook ) {
	if ( 'user-new.php' !== $hook ) {

		return;
	}
	wp_enqueue_script('hds_custom_fields_script', plugin_dir_url(__FILE__) . '/js/custom-fields.js', array( 'jquery' ),true );
}
add_action('admin_enqueue_scripts', 'hds_enqueue');

/**
 * Validate 'medical_id' field
 */
add_action( 'user_profile_update_errors', 'hds_user_profile_update_errors', 10, 3 );
function hds_user_profile_update_errors( $errors, $update, $user ) {

	if ( ! empty( $_POST['medical_id'] ) ) {
		if ( ! check_user_exist_by_id( $_POST['medical_id'] ) ) {
			$errors->add( 'medical_id_error', __( '<strong>ОШИБКА</strong>: Некорректный ID клиники/врача.', 'hds-settings' ) );
		}
	}
}

/**
 * Save medical_id for registered user
 */
add_action( 'edit_user_created_user', 'hds_user_registration' );

/**
 * Save medical_id for updated user
 */
add_action( 'edit_user_profile_update', 'hds_user_registration' );

/**
 * Render medical_id on user profile and edit pagers
 * @param $user
 */
function hds_show_extra_profile_fields( $user ) {
	?>
	<?php $medical_id = get_the_author_meta( 'medical_id', $user->ID ); ?>
	<?php if ( ! empty( $medical_id ) || in_array( 'customer', $user->roles ) ) : ?>
		<table class="form-table medical-table">
			<tr>
				<th><label for="medical_id"><?php esc_html_e( 'ID клиники / врача', 'hds-settings' ); ?></label></th>
				<td>
					<input type="text" id="medical_id" name="medical_id" value="<?php echo esc_attr( $medical_id ); ?>" class="input regular-text">
				</td>
			</tr>
		</table>
	<?php endif; ?>
	<?php
}
add_action( 'show_user_profile', 'hds_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'hds_show_extra_profile_fields' );
