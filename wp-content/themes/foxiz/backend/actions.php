<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_switch_theme', 'foxiz_get_tos_defaults', 1 );
add_action( 'after_switch_theme', 'foxiz_redirect_plugin_activation', 2 );
add_action( 'after_setup_theme', array( 'Foxiz_Register_Options', 'get_instance' ), 0 );
add_action( 'tgmpa_register', 'foxiz_register_required_plugins' );
add_action( 'admin_init', 'foxiz_register_category_settings' );
add_action( 'admin_enqueue_scripts', 'foxiz_enqueue_admin' );
add_action( 'enqueue_block_editor_assets', 'foxiz_enqueue_editor', 90 );

/** register admin scripts */
if ( ! function_exists( 'foxiz_enqueue_admin' ) ) {
	function foxiz_enqueue_admin( $hook ) {

		if ( $hook === 'post.php' || $hook === 'post-new.php' || 'widgets.php' === $hook || 'nav-menus.php' === $hook || 'term.php' === $hook ) {
			wp_register_style( 'foxiz-admin-style', get_theme_file_uri( 'assets/admin/admin.css' ), array(), FOXIZ_THEME_VERSION, 'all' );
			wp_enqueue_style( 'foxiz-admin-style' );

			wp_register_script( 'foxiz-admin', get_theme_file_uri( 'assets/admin/admin.js' ), array( 'jquery' ), FOXIZ_THEME_VERSION, true );
			wp_enqueue_script( 'foxiz-admin' );
		}
	}
}

/** register editor scripts */
if ( ! function_exists( 'foxiz_enqueue_editor' ) ) {
	function foxiz_enqueue_editor() {

		wp_enqueue_style( 'foxiz-google-font-editor', esc_url_raw( Foxiz_Font::get_instance()->get_font_url() ), array(), FOXIZ_THEME_VERSION, 'all' );
		wp_enqueue_style( 'foxiz-editor-style', get_theme_file_uri( 'assets/admin/editor.css' ), array( 'foxiz-google-font-editor' ), FOXIZ_THEME_VERSION, 'all' );
		if ( is_rtl() ) {
			wp_enqueue_style( 'foxiz-editor-rtl-style', get_theme_file_uri( 'assets/admin/editor-rtl.css' ), array( 'foxiz-editor-style' ), FOXIZ_THEME_VERSION, 'all' );
		}
	}
}

/** set default options */
if ( ! function_exists( 'foxiz_get_tos_defaults' ) ) {
	function foxiz_get_tos_defaults() {

		$file = get_theme_file_path( 'assets/admin/defaults.json' );
		if ( ! is_file( $file ) ) {
			return false;
		}

		ob_start();
		include $file;
		$response = ob_get_clean();
		$data     = json_decode( $response, true );

		if ( is_array( $data ) ) {
			update_option( FOXIZ_TOS_ID, $data );
		}
	}
}

if ( ! function_exists( 'foxiz_redirect_plugin_activation' ) ) {
	/**
	 * redirect to activate plugin
	 */
	function foxiz_redirect_plugin_activation() {

		global $pagenow;

		if ( is_admin() && ! is_network_admin() && 'themes.php' === $pagenow && isset( $_GET['activated'] ) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=foxiz-plugins' ) );
		}
	}
}
