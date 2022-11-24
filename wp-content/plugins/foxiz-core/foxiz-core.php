<?php
/**
 * Plugin Name:    Foxiz Core
 * Plugin URI:     https://themeforest.net/user/theme-ruby/
 * Description:    Features for Foxiz, this is required plugin (important) for this theme.
 * Version:        1.5.0
 * Requires at least: 5.3
 * Tested up to:   6.0.1
 * Requires PHP:   5.6
 * Text Domain:    foxiz-core
 * Domain Path:    /languages/
 * Author:         Theme-Ruby
 * Author URI:     https://themeforest.net/user/theme-ruby/
 * @package        foxiz-core
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'FOXIZ_CORE_VERSION' ) ) {
	define( 'FOXIZ_CORE_VERSION', '1.5.0' );
}

if ( ! defined( 'FOXIZ_TOS_ID' ) ) {
	define( 'FOXIZ_TOS_ID', 'foxiz_theme_options' );
}
define( 'FOXIZ_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'FOXIZ_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'FOXIZ_REL_PATH', dirname( plugin_basename( __FILE__ ) ) );

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

include_once FOXIZ_CORE_PATH . 'include-files.php';
if ( ! is_plugin_active( 'redux-framework/redux-framework.php' ) ) {
	include_once FOXIZ_CORE_PATH . 'lib/redux-framework/framework.php';
}

if ( ! class_exists( 'FOXIZ_CORE', false ) ) {
	class FOXIZ_CORE {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {
			self::$instance = $this;
			add_action( 'plugins_loaded', array( $this, 'plugins_support' ), 0 );
			add_action( 'init', array( $this, 'load_components' ), 2 );
			add_action( 'wp_enqueue_scripts', array( $this, 'core_enqueue' ), 1 );
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );
			add_filter( 'user_contactmethods', array( $this, 'user_contactmethods' ) );
			add_action( 'redux/page/' . FOXIZ_TOS_ID . '/enqueue', array( $this, 'enqueue_theme_options' ), 99 );

			register_activation_hook( __FILE__, array( $this, 'on_activate' ) );
		}

		function plugins_support() {

			$this->translation();
			RB_ADMIN_CORE::get_instance();
			Foxiz_AMP::get_instance();

			if ( class_exists( 'SimpleWpMembership' ) ) {
				Foxiz_Membership::get_instance();
			}
		}

		function load_components() {
			Foxiz_Table_Contents::get_instance();
			Ruby_Reaction::get_instance();
			Foxiz_Optimized::get_instance();
		}

		function translation() {
			$loaded = load_plugin_textdomain( 'foxiz-core', false, FOXIZ_CORE_PATH . 'languages/' );
			if ( ! $loaded ) {
				$locale = apply_filters( 'plugin_locale', get_locale(), 'foxiz-core' );
				$mofile = FOXIZ_CORE_PATH . 'languages/foxiz-core-' . $locale . '.mo';
				load_textdomain( 'foxiz-core', $mofile );
			}
		}

		function on_activate() {
			if ( ! is_network_admin() ) {
				set_transient( '_rb_welcome_page_redirect', true, 30 );
			}
		}

		function enqueue_theme_options() {
			wp_dequeue_script( 'redux-rtl-css' );
			wp_register_style( 'foxiz-panel', FOXIZ_CORE_URL . 'admin/assets/theme-options.css', array( 'redux-admin-css' ), FOXIZ_CORE_VERSION, 'all' );
			wp_enqueue_style( 'foxiz-panel' );
		}

		function core_enqueue() {

			if ( is_admin() || foxiz_is_amp() ) {
				return false;
			}

			$deps = array( 'jquery' );

			wp_register_script( 'foxiz-core', FOXIZ_CORE_URL . 'assets/core.js', $deps, FOXIZ_CORE_VERSION, true );
			$js_params               = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
			$js_params['darkModeID'] = $this->get_dark_mode_id();
			if ( foxiz_get_option( 'dark_mode_cookie' ) ) {
				$js_params['darkCookieMode'] = 'on';
			}
			wp_localize_script( 'foxiz-core', 'foxizCoreParams', $js_params );
			wp_enqueue_script( 'foxiz-core' );
		}

		public function get_dark_mode_id() {

			if ( is_multisite() ) {
				return 'D_' . trim( str_replace( '/', '_', preg_replace( '/https?:\/\/(www\.)?/', '', get_site_url() ) ) );
			}

			return 'RubyDarkMode';
		}

		/**
		 * @return false
		 */
		public function register_widgets() {

			$widgets = array(
				'Foxiz_W_Post',
				'Foxiz_W_Follower',
				'Foxiz_W_Weather',
				'Foxiz_Fw_Instagram',
				'Foxiz_W_Twitter',
				'Foxiz_W_Social_Icon',
				'Foxiz_W_Youtube_Subscribe',
				'Foxiz_W_Flickr',
				'Foxiz_W_Address',
				'Foxiz_W_Instagram',
				'Foxiz_Fw_Mc',
				'Foxiz_Ad_Image',
				'Foxiz_FW_Banner',
				'Foxiz_W_Facebook',
				'Foxiz_Ad_Script',
				'Foxiz_W_Ruby_Template'
			);

			foreach ( $widgets as $widget ) {
				if ( class_exists( $widget ) ) {
					register_widget( $widget );
				}
			}

			return false;
		}

		function user_contactmethods( $user ) {

			if ( ! is_array( $user ) ) {
				$user = array();
			}

			$data = array(
				'job'         => esc_html__( 'Job Name', 'foxiz-core' ),
				'facebook'    => esc_html__( 'Facebook profile URL', 'foxiz-core' ),
				'twitter_url' => esc_html__( 'Twitter profile URL', 'foxiz-core' ),
				'instagram'   => esc_html__( 'Instagram profile URL', 'foxiz-core' ),
				'pinterest'   => esc_html__( 'Pinterest profile URL', 'foxiz-core' ),
				'linkedin'    => esc_html__( 'LinkedIn profile URL', 'foxiz-core' ),
				'tumblr'      => esc_html__( 'Tumblr profile URL', 'foxiz-core' ),
				'flickr'      => esc_html__( 'Flickr profile URL', 'foxiz-core' ),
				'skype'       => esc_html__( 'Skype profile URL', 'foxiz-core' ),
				'snapchat'    => esc_html__( 'Snapchat profile URL', 'foxiz-core' ),
				'myspace'     => esc_html__( 'Myspace profile URL', 'foxiz-core' ),
				'youtube'     => esc_html__( 'Youtube profile URL', 'foxiz-core' ),
				'bloglovin'   => esc_html__( 'Bloglovin profile URL', 'foxiz-core' ),
				'digg'        => esc_html__( 'Digg profile URL', 'foxiz-core' ),
				'dribbble'    => esc_html__( 'Dribbble profile URL', 'foxiz-core' ),
				'soundcloud'  => esc_html__( 'Soundcloud profile URL', 'foxiz-core' ),
				'vimeo'       => esc_html__( 'Vimeo profile URL', 'foxiz-core' ),
				'reddit'      => esc_html__( 'Reddit profile URL', 'foxiz-core' ),
				'vkontakte'   => esc_html__( 'Vkontakte profile URL', 'foxiz-core' ),
				'telegram'    => esc_html__( 'Telegram profile URL', 'foxiz-core' ),
				'whatsapp'    => esc_html__( 'Whatsapp profile URL', 'foxiz-core' ),
				'rss'         => esc_html__( 'Rss', 'foxiz-core' ),
			);

			return array_merge( $user, $data );
		}

	}
}

/** init */
FOXIZ_CORE::get_instance();
