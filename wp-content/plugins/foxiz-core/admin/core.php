<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** admin core */
if ( ! class_exists( 'RB_ADMIN_CORE', false ) ) {
	class RB_ADMIN_CORE {

		protected static $instance = null;
		private $params = [];
		private $purchase_info = FOXIZ_LICENSE_ID;
		private $import_info = FOXIZ_IMPORT_ID;
		private $apiSever = RB_API_URL . '/wp-json/market/validate';

		private static $sub_pages = array(
			'Import'       => 'admin/import/import.php',
			'ThemeOptions' => 'admin/tops/tops.php',
			'Translation'  => 'admin/translation/translation.php',
			'AdobeFonts'   => 'admin/fonts/fonts.php',
			'SystemInfo'   => 'admin/system-info/system-info.php',
		);

		static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			self::$instance = $this;

			$this->set_panel();
			$this->load_sub_pages();
			$this->get_params();

			add_action( 'admin_menu', array( $this, 'register_admin' ) );
			add_action( 'admin_init', array( 'RB_AJAX_IMPORTER', 'get_instance' ) );
			add_action( 'wp_ajax_rb_register_theme', array( $this, 'register_theme' ) );
			add_action( 'wp_ajax_rb_deregister_theme', array( $this, 'deregister_theme' ) );
			add_action( 'wp_ajax_rb_fetch_translation', array( $this, 'reload_translation' ) );
			add_action( 'wp_ajax_rb_update_translation', array( $this, 'update_translation' ) );

			add_action( 'admin_init', array( $this, 'welcome_redirect' ) );
		}

		/** set panel */
		public function set_panel() {
			$this->panel_slug      = 'admin/templates/template';
			$this->panel_name      = 'panel';
			$this->panel_title     = esc_html__( 'Foxiz Admin', 'foxiz-core' );
			$this->panel_menu_slug = 'foxiz-admin';
			$this->panel_icon      = 'dashicons-awards';
			$this->panel_template  = 'admin_template';
		}

		/** get params */
		public function get_params() {
			$this->params = wp_parse_args( $this->get_purchase_data(), array(
				'purchase_code' => '',
				'is_activated'  => '',
				'system_info'   => rbSubPageSystemInfo::system_info()
			) );

			return false;
		}

		/** register admin */
		public function register_admin() {

			if ( ! defined( 'FOXIZ_THEME_VERSION' ) ) {
				return false;
			}

			$panel_hook_suffix = add_menu_page( $this->panel_title, $this->panel_title, 'administrator', $this->panel_menu_slug,
				array( $this, $this->panel_template ), $this->panel_icon, 3 );
			add_action( 'load-' . $panel_hook_suffix, array( $this, 'register_assets' ) );

			foreach ( self::$sub_pages as $name => $path ) {
				$sub_page_class = 'rbSubPage' . $name;
				$sub_page       = new $sub_page_class();
				if ( ! empty( $sub_page->menu_slug ) ) {
					$page_hook_suffix = add_submenu_page( $this->panel_menu_slug, $sub_page->page_title, $sub_page->menu_title, $sub_page->capability, $sub_page->menu_slug,
						array( $sub_page, 'render' ) );
					add_action( 'load-' . $page_hook_suffix, array( $this, 'register_assets' ) );
				}
			}
		}

		/** load sub page */
		public function load_sub_pages() {
			self::$sub_pages = apply_filters( 'rb_register_sub_page', self::$sub_pages );

			foreach ( self::$sub_pages as $name => $path ) {
				$file_name = FOXIZ_CORE_PATH . $path;
				if ( file_exists( $file_name ) ) {
					require_once $file_name;
				} else {
					unset( self::$sub_pages[ $name ] );
				}
			}

			return false;
		}

		/** purchase data */
		public function get_purchase_data() {
			return get_option( $this->purchase_info );
		}

		/** get purchase code */
		public function get_purchase_code() {
			$data = $this->get_purchase_data();
			if ( is_array( $data ) && isset( $data['purchase_code'] ) ) {
				return $data['purchase_code'];
			}

			return false;
		}

		/** get import */
		public function get_imports() {
			$data = get_option( $this->import_info, [] );

			if ( is_array( $data ) && isset( $data['listing'] ) ) {
				return $data['listing'];
			}

			return false;
		}

		/** load js and css */
		public function register_assets() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/** enqueue style */
		public function enqueue_styles() {
			wp_enqueue_style( 'rb-panel-styles', plugins_url( FOXIZ_REL_PATH . '/admin/assets/panel.css' ) );
		}

		/** enqueue script */
		public function enqueue_scripts() {

			wp_register_script( 'rb-admin-core', plugins_url( FOXIZ_REL_PATH . '/admin/assets/panel.js' ), array( 'jquery' ), FOXIZ_CORE_VERSION, true );
			wp_localize_script( 'rb-admin-core', 'foxizAdminCore', $this->localize_params() );
			wp_enqueue_script( 'rb-admin-core' );
		}

		/** admin template */
		public function admin_template() {
			echo rb_admin_get_template_part( $this->panel_slug, $this->panel_name, $this->params );
		}

		/** localize params */
		public function localize_params() {
			return apply_filters( 'rb_admin_localize_data', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );
		}

		/** register theme */
		public function register_theme() {

			if ( empty( $_POST ) || empty ( $_POST['_nonce'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'rb-core' ) ) {
				wp_send_json_error( esc_html__( 'Sorry, you are not allowed to do this action.', 'foxiz-core' ), 404 );
				die();
			}

			if ( empty( $_POST['purchase_code'] ) || empty( $_POST['email'] ) ) {
				wp_send_json_error( esc_html__( 'Empty data! Please check input form.', 'foxiz-core' ), 404 );
				die();
			}

			if ( ! is_email( $_POST['email'] ) ) {
				wp_send_json_error( esc_html__( 'Wrong email format! Please check input form.', 'foxiz-core' ), 404 );
				die();
			}

			$url = add_query_arg( array(
				'purchase_code' => sanitize_text_field( $_POST['purchase_code'] ),
				'email'         => esc_html( $_POST['email'] ),
				'theme'         => wp_get_theme()->get( 'Name' ),
				'action'        => 'register'
			), $this->apiSever );

			$response = $this->validation_api( $url );

			if ( empty( $response['code'] ) || 200 !== $response['code'] ) {
				wp_send_json_error( esc_html( $response['message'] ), 404 );
				die();
			} else {
				if ( ! empty( $response['data']['purchase_info'] ) ) {
					update_option( $this->purchase_info, $response['data']['purchase_info'] );
				}
				if ( ! empty( $response['data']['import'] ) ) {
					update_option( $this->import_info, $response['data']['import'] );
				}
				wp_send_json_success( esc_html( $response['message'] ), 200 );
				die();
			}
		}

		/** deregister_theme */
		public function deregister_theme() {

			if ( empty( $_POST ) || empty ( $_POST['_nonce'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'rb-core' ) || ! $this->get_purchase_code() ) {
				wp_send_json_error( esc_html__( 'Sorry, you are not allowed to do this action.', 'foxiz-core' ), 404 );
				die();
			}

			$url = add_query_arg( array(
				'purchase_code' => $this->get_purchase_code(),
				'action'        => 'deregister'
			), $this->apiSever );

			$response = $this->validation_api( $url );
			delete_option( $this->purchase_info );
			delete_option( $this->import_info );
			if ( empty( $response['code'] ) || 200 !== $response['code'] ) {
				wp_send_json_error( esc_html( $response['message'] ), 404 );
			} else {
				wp_send_json_success( esc_html( $response['message'] ), 200 );
			}

			die();
		}

		/** validate  */
		public function validation_api( $url ) {

			$params   = array(
				'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' ),
				'timeout'    => 60
			);
			$response = wp_remote_get( $url, $params );
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				wp_send_json_error( esc_html__( 'Bad Request.', 'foxiz-core' ), 404 );
				die();
			}

			$response = wp_remote_retrieve_body( $response );

			return json_decode( $response, true );
		}

		/**
		 * welcome redirect
		 */
		public function welcome_redirect() {

			$redirect = get_transient( '_rb_welcome_page_redirect' );
			delete_transient( '_rb_welcome_page_redirect' );
			if ( ! empty( $redirect ) ) {
				wp_safe_redirect( add_query_arg( array( 'page' => $this->panel_menu_slug ), esc_url( admin_url( 'admin.php' ) ) ) );
			}
		}

		/**
		 * reload translation
		 */
		function reload_translation() {

			if ( empty( $_POST ) || empty ( $_POST['_nonce'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'rb-core' ) ) {
				wp_send_json_error( esc_html__( 'Sorry, you are not allowed to do this action.', 'foxiz-core' ), 404 );
				die();
			}

			delete_option( 'rb_translation_data' );
			wp_send_json_success( 'OK' );
		}

		/**
		 * update translation
		 */
		public function update_translation() {

			if ( empty( $_POST ) || empty ( $_POST['_nonce'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'rb-core' ) ) {
				wp_send_json_error( esc_html__( 'Sorry, you are not allowed to do this action.', 'foxiz-core' ), 404 );
				die();
			}

			$data = $_POST;
			unset( $data['_nonce'] );
			unset( $data['action'] );
			$data = array_map( 'sanitize_text_field', $data );
			update_option( 'rb_translated_data', $data );
			wp_send_json_success( esc_html__( 'OK', 'foxiz-core' ) );
			die();
		}
	}
}


