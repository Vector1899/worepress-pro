<?php
/**
 * Theme functions
 *
 * @package Custom
 */

// Define theme's images URI.
if ( ! defined( 'IMAGES_URI' ) ) {
	define( 'IMAGES_URI', get_stylesheet_directory_uri() . '/images/' );
}

// Define theme's functions directory.
if ( ! defined( 'THEME_LIB_DIR' ) ) {
	define( 'THEME_LIB_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR );
}

/**
 * Load all functions which are placed in theme's folder
 *
 * @param string $dir Directory to load files from.
 * @return void
 */
function load_includes( $dir ) {
	$it = new RecursiveDirectoryIterator( $dir );
	$it = new RecursiveIteratorIterator( $it );
	$it = new RegexIterator( $it, '#.php$#' );
	foreach ( $it as $include ) {
		if ( $include->isReadable() ) {
			require_once( $include->getPathname() );
		}
	}
}

load_includes( THEME_LIB_DIR );

/**
 * Redirect to login page if not logged in
 */
function redirect_non_logged_users_to_login_page() {
	if ( getenv( 'REQUIRE_LOGIN' ) ) {
		global $pagenow;
		if ( ! is_user_logged_in() && 'wp-login.php' != $pagenow ) {
			wp_redirect( wp_login_url() );
		}
	}
}
add_action( 'wp', 'redirect_non_logged_users_to_login_page' );
