<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Load backend */
include_once get_theme_file_path( 'backend/class-tgm-plugin-activation.php' );
include_once get_theme_file_path( 'backend/install-plugins.php' );
include_once get_theme_file_path( 'backend/configs.php' );
include_once get_theme_file_path( 'backend/theme-options.php' );
include_once get_theme_file_path( 'backend/category-settings.php' );
include_once get_theme_file_path( 'backend/single-metaboxes.php' );
include_once get_theme_file_path( 'backend/actions.php' );
include_once get_theme_file_path( 'backend/mega-menu.php' );