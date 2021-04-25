<?php
/**
 * ----------------------------------------
 * Functions with custom fields on frontend.
 * ---------------------------------------
 */

/**
 * Add 'medical_id' field for user with role - customer (registration form)
 */
function hds_registration_form() {

    $medical_id = ! empty( $_POST['medical_id'] ) ? intval( $_POST['medical_id'] ) : '';

    ?>
    <p>
        <label for="medical_id"><?php esc_html_e( 'ID клиники / врача (опционально)', 'hds-settings' ) ?><br/>
            <input type="text" id="medical_id" name="medical_id"
                   value="<?php echo esc_attr( $medical_id ); ?>" class="input">
        </label>
    </p>
    <?php
}
add_action( 'register_form', 'hds_registration_form' );

/**
 * Validation field 'medical_id' (registration form)
 */
function hds_registration_errors( $errors, $sanitized_user_login, $user_email ) {

	if ( ! empty( $_POST['medical_id'] ) ) {
		if ( ! check_user_exist_by_id( $_POST['medical_id'] ) ) {
			$errors->add( 'medical_id_error', __( '<strong>ОШИБКА</strong>: Некорректный ID клиники/врача.', 'hds-settings' ) );
		}
	}

	return $errors;
}
add_filter( 'registration_errors', 'hds_registration_errors', 10, 3 );

add_action( 'user_register', 'hds_user_registration' );
