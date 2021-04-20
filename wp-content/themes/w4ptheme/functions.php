<?php
/**
 * W4P Theme Functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage W4P-Theme
 * @since W4P Theme 1.0
 */

/**
 * Theme Setup.
 */
function w4ptheme_setup() {
	load_theme_textdomain( 'w4ptheme', get_template_directory() . '/languages' );
	add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );
	add_theme_support( 'post-formats', array(
			'aside',
			'audio',
			'chat',
			'gallery',
			'image',
			'quote',
			'status',
		)
	);
	register_nav_menu( 'primary', __( 'Navigation Menu', 'w4ptheme' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'w4ptheme_setup' );

/**
 * Scripts & Styles.
 */
function w4ptheme_scripts_styles() {
	global $wp_styles;

	// Load Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load Stylesheets.
	wp_enqueue_style( 'w4ptheme-style', get_template_directory_uri() . '/css/application.css' );

	// Jquery
	wp_enqueue_script( 'jquery' );

	// TODO: Delete if not used in project
	// Modernizr.
	// This is an un-minified, complete version of Modernizr. Before you move to production, you should generate a custom build that only has the detects you need.
	wp_enqueue_script( 'w4ptheme-modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.8.0.dev.js', array( 'jquery' ), null, true );

	// This is where we put our custom JS functions.
	wp_enqueue_script( 'w4ptheme-application', get_template_directory_uri() . '/js/custom/app.js', array( 'jquery' ), null, true );
}

add_action( 'wp_enqueue_scripts', 'w4ptheme_scripts_styles' );

/**
 * WP Title.
 *
 * @param string $title Where something interesting takes place.
 * @param string $sep Separator string.
 *
 * @return string
 */
function w4ptheme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'w4ptheme' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'w4ptheme_wp_title', 10, 2 );

// Custom Menu.
register_nav_menu( 'primary', __( 'Navigation Menu', 'w4ptheme' ) );


/**
 * Navigation - update coming from twentythirteen.
 */
function post_navigation() {
	echo '<div class="navigation">';
	echo '<div class="next-posts">' . get_next_posts_link( '&laquo; Older Entries' ) . '</div>';
	echo '<div class="prev-posts">' . get_previous_posts_link( 'Newer Entries &raquo;' ) . '</div>';
	echo '</div>';
}

// Include theme options.
require_once( get_template_directory() . '/inc/options.php' );

// Widgets and Sidebars.
require_once( get_template_directory() . '/inc/widgets-sidebars.php' );

// Custom post types & Taxonomies.
require_once( get_template_directory() . '/inc/custom-post-types.php' );
require_once( get_template_directory() . '/inc/custom-taxonomies.php' );

// Filters and functions to manipulate content.
require_once( get_template_directory() . '/inc/filters.php' );

// Custom shortcodes.
require_once( get_template_directory() . '/inc/shortcodes.php' );

// TODO: Delete ACF options page if not used
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> __( 'Theme General Settings', 'w4ptheme' ),
		'menu_title'	=> __( 'Theme Settings', 'w4ptheme' ),
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __( 'Theme Header Settings', 'w4ptheme' ),
		'menu_title'	=> __( 'Header', 'w4ptheme' ),
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __( 'Theme Footer Settings', 'w4ptheme' ),
		'menu_title'	=> __( 'Footer', 'w4ptheme' ),
		'parent_slug'	=> 'theme-general-settings',
	));

}