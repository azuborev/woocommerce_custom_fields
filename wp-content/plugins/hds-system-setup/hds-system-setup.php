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
