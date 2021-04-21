<?php
/**
 * File with functions for work with meta user's fields
 */

//Add column to user's admin list
function hds_modify_user_table( $column ) {
    $column['key'] = __( 'Идентификатор', 'hds-settings' );

    return $column;
}
add_filter( 'manage_users_columns', 'hds_modify_user_table' );

//Insert value key to user list table
function hds_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'key' :

            return get_user_meta( $user_id, 'user_key', true ) ? : '';
        default:
    }

    return $val;
}
add_filter( 'manage_users_custom_column', 'hds_modify_user_table_row', 10, 3 );

//Add user_key for registered user
function hds_add_user_key ( $user_id ) {
    if ( user_can( $user_id, 'hds_doctor' ) ||
         user_can( $user_id, 'hds_clinic' ) ||
         user_can( $user_id, 'hds_med_pred' )
    ) {
        update_user_meta( $user_id, 'user_key', '100' . $user_id );
    }
}
add_action( 'user_register', 'hds_add_user_key' );
