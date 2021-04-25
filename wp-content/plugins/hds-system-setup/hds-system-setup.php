<?php
/*
 * Plugin Name: HDS SYSTEM SETUP
 * Description: Plugin for adding HDS settings
 * Author: W4P AZuborev
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add general settings, custom pages in admin
 */
require_once( __DIR__ . '/general/general-settings.php' );


function create_table_users_relationship()
{
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->get_blog_prefix() . 'hds_user_relationship';
    $users_table = $wpdb->get_blog_prefix() . 'users';
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    $sql = "CREATE TABLE {$table_name} (
    user_id  bigint(20) unsigned NOT NULL,
	private_id  bigint(20) unsigned NOT NULL auto_increment,
	PRIMARY KEY  (private_id),
	FOREIGN KEY  (user_id) REFERENCES {$users_table}(id)
    )
    auto_increment=10001
	{$charset_collate};";

    dbDelta($sql);
}

register_activation_hook( __FILE__, 'create_table_users_relationship' );

/**
 * Add 'private_id' for registered user with role - doctor, clinic or med_pred
 * @param $user_id
 */
function hds_add_private_id1 ( $user_id ) {
    if ( user_can( $user_id, 'hds_doctor' ) ||
        user_can( $user_id, 'hds_clinic' ) ||
        user_can( $user_id, 'hds_med_pred' )
    ) {


        global $wpdb;
        $table = $wpdb->prefix.'hds_user_relationship';
        $data = array('user_id' => $user_id);
        $format = array('%d');
        $wpdb->insert($table,$data,$format);


    } else {
        delete_user_meta( $user_id, 'private_id' );
    }
}
add_action( 'user_register', 'hds_add_private_id1' );



/**
 * Render private_id on user profile pages
 * @param $user
 */
function hds_show_user_private_id( $user ) {
    ?>
    <?php $private_id = get_the_author_meta( 'medical_id', $user->ID ); ?>
        <?php if ( ! empty( $private_id ) || in_array( 'customer', $user->roles ) ) : ?>
    <table class="form-table medical-table">
        <tr>
            <th><label for="medical_id"><?php esc_html_e( 'ID клиники / врача 1', 'hds-settings' ); ?></label></th>
            <td><?php echo esc_attr( $private_id ); ?></td>
        </tr>
    </table>
        <?php endif; ?>
    <?php
}
add_action( 'show_user_profile', 'hds_show_user_private_id' );
add_action( 'edit_user_profile', 'hds_show_user_private_id' );





















/**
 * File with helper functions
 */
require_once (__DIR__ . '/registration-fields/medical-id/helpers.php');
/**
 * Add custom fields on frontend
 */
require_once( __DIR__ . '/registration-fields/medical-id/frontend-fields.php' );
/**
 * Add custom fields on backend
 */
require_once( __DIR__ . '/registration-fields/medical-id/backend-fields.php' );
/**
 * File with custom functions for CRUD operation linked_user_id
 */
require_once(__DIR__ . '/registration-fields/private-id/private-id.php');
