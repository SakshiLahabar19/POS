<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** load includes */
include_once get_theme_file_path( 'includes/fallbacks.php' );
include_once get_theme_file_path( 'includes/helpers.php' );

/** bookmarks */
include_once get_theme_file_path( 'bookmark/bookmark.php' );
include_once get_theme_file_path( 'bookmark/template-helpers.php' );
include_once get_theme_file_path( 'bookmark/templates.php' );
/** functions */
include_once get_theme_file_path( 'includes/sidebars.php' );
include_once get_theme_file_path( 'includes/menu.php' );
include_once get_theme_file_path( 'includes/actions.php' );
include_once get_theme_file_path( 'includes/query.php' );
include_once get_theme_file_path( 'includes/css.php' );
include_once get_theme_file_path( 'includes/fonts.php' );
include_once get_theme_file_path( 'includes/woocommerce.php' );

