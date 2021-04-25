<?php
/**
 * ----------------------------------------
 * Functions with custom fields on backend.
 * ---------------------------------------
 */

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
function hds_user_profile_update_errors( $errors, $update, $user ) {
	if ( ! empty( $_POST['medical_id'] ) && 'customer' === $user->role ) {
		if ( ! check_user_exist_by_id( $_POST['medical_id'] ) ) {
			$errors->add( 'medical_id_error', __( '<strong>ОШИБКА</strong>: Некорректный ID клиники/врача.', 'hds-settings' ) );
		}
	}
}
add_action( 'user_profile_update_errors', 'hds_user_profile_update_errors', 0, 3 );

/**
 * Save medical_id for registered user
 */
add_action( 'edit_user_created_user', 'hds_user_registration' );

/**
 * Update 'medical_id' for updated user with role - customer
 * @param $user_id
 */
function hds_update_medical_id( $user_id, $old_user_data ){
    if ( user_can( $user_id, 'customer' )
    ) {
        update_user_meta( $user_id, 'medical_id', intval( $_POST['medical_id'] ) );
    } else {
        delete_user_meta( $user_id, 'medical_id' );
    }
}
add_action( 'profile_update', 'hds_update_medical_id', 10, 2 );

/**
 * Render medical_id on user edit pages
 * @param $user
 */
function hds_show_extra_profile_fields_edit_page( $user ) {
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
add_action( 'edit_user_profile', 'hds_show_extra_profile_fields_edit_page' );

/**
 * Render medical_id on user profile pages
 * @param $user
 */
function hds_show_extra_profile_fields_profile_page( $user ) {
    ?>
    <?php $medical_id = get_the_author_meta( 'medical_id', $user->ID ); ?>
    <?php if ( ! empty( $medical_id ) || in_array( 'customer', $user->roles ) ) : ?>
		<table class="form-table medical-table">
			<tr>
				<th><label for="medical_id"><?php esc_html_e( 'ID клиники / врача', 'hds-settings' ); ?></label></th>
				<td><?php echo esc_attr( $medical_id ); ?></td>
			</tr>
		</table>
    <?php endif; ?>
    <?php
}
add_action( 'show_user_profile', 'hds_show_extra_profile_fields_profile_page' );
