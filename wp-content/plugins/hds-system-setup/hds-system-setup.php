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
	private_id  bigint(20) unsigned NOT NULL auto_increment,
	user_id  bigint(20) unsigned NOT NULL,
	PRIMARY KEY  (private_id),
	FOREIGN KEY  (user_id) REFERENCES {$users_table}(id)
    )
    auto_increment=10001
	{$charset_collate};";

    dbDelta($sql);
}

register_activation_hook( __FILE__, 'create_table_users_relationship' );























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
