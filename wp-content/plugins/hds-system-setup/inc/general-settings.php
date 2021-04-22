<?php
/**
 * ------------------------------
 * General Settings is here.
 * ------------------------------
 */

//Add options page in admin
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title' => __( 'Theme General Settings', 'w4ptheme' ),
			'menu_title' => __( 'Theme Settings', 'w4ptheme' ),
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => __( 'Theme Header Settings', 'w4ptheme' ),
			'menu_title'  => __( 'Header', 'w4ptheme' ),
			'parent_slug' => 'theme-general-settings',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => __( 'Theme Footer Settings', 'w4ptheme' ),
			'menu_title'  => __( 'Footer', 'w4ptheme' ),
			'parent_slug' => 'theme-general-settings',
		)
	);
}

//Add read-only attribute for text fields
function hds_add_readonly_to_text_field($field) {
    acf_render_field_setting( $field, array(
        'label'        => __( 'Только для чтения','acf' ),
        'instructions' => '',
        'type'         => 'true_false',
        'name'         => 'readonly',
        'ui'		   => 1,
        'class'	       => 'acf-field-object-true-false-ui'
    ));
}
add_action('acf/render_field_settings/type=text', 'hds_add_readonly_to_text_field');

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

