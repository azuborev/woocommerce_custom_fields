<?php
/**
 * ------------------------------
 * General Settings is here.
 * ------------------------------
 */

/**
 * Add Options Page in Admin
 */
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

/**
 * Add read-only attribute for text fields
 * @param $field
 */
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

/**
 * Add column to user's admin list
 *
 * @param $column
 * @return mixed
 */
function hds_modify_user_table( $column ) {
    $column['private_id'] = __( 'Идентификатор', 'hds-settings' );
	$column['medical_id'] = __( 'ID врача/клиники', 'hds-settings' );
    return $column;
}
add_filter( 'manage_users_columns', 'hds_modify_user_table' );

/**
 * Insert value key to user list table
 *
 * @param $val
 * @param $column_name
 * @param $private_id
 * @return mixed|string
 */
function hds_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'private_id' :

            return get_user_meta( $user_id, 'private_id', true ) ? : '';
	    case 'medical_id' :

		    return get_user_meta( $user_id, 'medical_id', true ) ? : '';
        default:
    }

    return $val;
}
add_filter( 'manage_users_custom_column', 'hds_modify_user_table_row', 10, 3 );
