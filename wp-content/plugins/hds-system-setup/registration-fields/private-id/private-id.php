<?php
/**
 * --------------------------------------------------------
 * Functions with custom field 'private_id' on backend.
 * --------------------------------------------------------
 */

/**
 * Add 'private_id' for registered user with role - doctor, clinic or med_pred
 * @param $user_id
 */
function hds_add_private_id ( $user_id ) {
    if ( user_can( $user_id, 'hds_doctor' ) ||
        user_can( $user_id, 'hds_clinic' ) ||
        user_can( $user_id, 'hds_med_pred' )
    ) {
        update_user_meta( $user_id, 'private_id', '100' . $user_id );
    } else {
        delete_user_meta( $user_id, 'private_id' );
    }
}
add_action( 'user_register', 'hds_add_private_id' );

/**
 * Update 'private_id' for updated user with role - doctor, clinic or med_pred
 * @param $user_id
 */
function hds_update_private_id( $user_id, $old_user_data ){
    if ( user_can( $user_id, 'hds_doctor' ) ||
        user_can( $user_id, 'hds_clinic' ) ||
        user_can( $user_id, 'hds_med_pred' )
    ) {
        update_user_meta( $user_id, 'private_id', '100' . $user_id );
    } else {
        delete_user_meta( $user_id, 'private_id' );
    }
}
add_action( 'profile_update', 'hds_update_private_id', 10, 2 );
