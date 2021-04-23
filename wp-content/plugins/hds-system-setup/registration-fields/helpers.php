<?php
/**
 * ---------------------
 * Additional functions
 * ---------------------
 */

/**
 * Check user exist  with role doctor or clinic in database
 *
 * @param $medical_id
 * @return bool
 */
function check_user_exist_by_id( $medical_id ) {
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

/**
 * Sanitize and save field 'medical_id'
 */
function hds_user_registration( $user_id ) {
	if ( ! empty( $_POST['medical_id'] ) ) {
		update_user_meta( $user_id, 'medical_id', intval( $_POST['medical_id'] ) );
	}
}