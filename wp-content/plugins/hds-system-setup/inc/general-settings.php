<?php
/**
 * ------------------------------
 * General Settings is here.
 * ------------------------------
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
