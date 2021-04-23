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
require_once (__DIR__ . '/registration-fields/helpers.php');
/**
 * Add custom fields on frontend
 */
require_once( __DIR__ . '/registration-fields/frontend-fields.php' );
/**
 * Add custom fields on backend
 */
require_once( __DIR__ . '/registration-fields/backend-fields.php' );
