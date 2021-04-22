<?php
/**
 *
 */

/**
 * Front end registration
 */
add_action( 'register_form', 'hds_registration_form' );
function hds_registration_form() {

    $medical_id = ! empty( $_POST['medical_id'] ) ? intval( $_POST['medical_id'] ) : '';

    ?>
    <p>
        <label for="medical_id"><?php esc_html_e( 'ID клиники / врача (опционально)', 'hds-settings' ) ?><br/>
            <input type="text" id="medical_id" name="medical_id"
                   value="<?php echo esc_attr( $medical_id ); ?>" class="input"/>
        </label>
    </p>
    <?php
}

//Validation field
add_filter( 'registration_errors', 'hds_registration_errors', 10, 3 );
function hds_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( ! empty( $_POST['medical_id'] ) ) {
        if ( ! check_medical_id( $_POST['medical_id'] ) ) {
            $errors->add( 'medical_id_error', __( '<strong>ОШИБКА</strong>: Некорректный ID клиники/врача.', 'hds-settings' ) );
        }
    }

    return $errors;
}

//Check user with role doctor or clinic in database
function check_medical_id( $medical_id ) {
    $user = get_userdata( trim( substr( $medical_id, 3 ) ) );
    if ( ! empty( $user ) ) {
        $user_roles = $user->roles;
        if ( in_array('hds_doctor', $user_roles, true ) ||
             in_array('hds_clinic', $user_roles, true )) {
            return true;
        }
    }
    return false;
}

//Sanitize and save field
add_action( 'user_register', 'hds_user_registration' );
function hds_user_registration( $user_id ) {
    if ( ! empty( $_POST['medical_id'] ) ) {
        update_user_meta( $user_id, 'medical_id', intval( $_POST['medical_id'] ) );
    }
}

/**
 * Back end registration
 */
add_action( 'user_new_form', 'hds_admin_registration_form' );
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
                       value="<?php echo esc_attr( $medical_id ); ?>" class="input"/>
        </tr>
    </table>
    <?php
}

//add script js to user-new page in admin
function hds_enqueue( $hook ) {
    if ( 'user-new.php' !== $hook ||  'user-edit.php' !== $hook || 'profile.php' !== $hook) {
        return;
    }
    wp_enqueue_script('hds_custom_fields_script', plugin_dir_url(__FILE__) . '../js/custom-fields.js', array( 'jquery' ), null, true );
}
add_action('admin_enqueue_scripts', 'hds_enqueue');

//validate field
add_action( 'user_profile_update_errors', 'hds_user_profile_update_errors', 10, 3 );
function hds_user_profile_update_errors( $errors, $update, $user ) {
    if ( $update ) {
        return;
    }

    if ( ! empty( $_POST['medical_id'] ) ) {
        if ( ! check_medical_id( $_POST['medical_id'] ) ) {
            $errors->add( 'medical_id_error', __( '<strong>ОШИБКА</strong>: Некорректный ID клиники/врача.', 'hds-settings' ) );
        }
    }
}
//Save data field
add_action( 'edit_user_created_user', 'hds_user_registration' );


//Show medical ID on user page
function hds_show_extra_profile_fields( $user ) {
    ?>
	<table class="form-table medical-table">
		<tr>
			<th><label for="medical_id"><?php esc_html_e( 'ID клиники / врача', 'hds-settings' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'medical_id', $user->ID ) ); ?></td>
		</tr>
	</table>
    <?php
}
add_action( 'show_user_profile', 'hds_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'hds_show_extra_profile_fields' );
