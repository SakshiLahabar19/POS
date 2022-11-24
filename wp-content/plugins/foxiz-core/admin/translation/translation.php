<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** quick translation */
if ( ! class_exists( 'rbSubPageTranslation', false ) ) {
	class rbSubPageTranslation extends RB_ADMIN_SUB_PAGE {

		private static $instance;
		private $creds = array();

		public function __construct() {
			self::$instance = $this;

			parent::__construct();
		}

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function set_sub_page() {

			$this->page_title = esc_html__( 'Quick Translation', 'foxiz-core' );
			$this->menu_title = esc_html__( 'Quick Translation', 'foxiz-core' );

			$this->menu_slug = 'rb-translation';
			if ( $this->validate() ) {
				$this->set_params( [
					'data' => $this::get_data(),
				] );
			}

			$this->capability = 'administrator';
		}

		public function get_slug() {
			if ( ! $this->validate() ) {
				return 'admin/templates/validate';
			}

			return 'admin/translation/template';
		}

		public function get_name() {
			if ( ! $this->validate() ) {
				return 'redirect';
			}

			return false;
		}

		/**
		 * @param $url
		 * @param string $method
		 * @param false $context
		 * @param null $fields
		 *
		 * @return bool
		 * init file
		 */
		public function init_filesystem( $url, $method = '', $context = false, $fields = null ) {

			if ( ! empty( $this->creds ) ) {
				return true;
			}

			require_once ABSPATH . '/wp-admin/includes/template.php';
			require_once ABSPATH . '/wp-includes/pluggable.php';
			require_once ABSPATH . '/wp-admin/includes/file.php';

			if ( false === ( $this->creds = request_filesystem_credentials( $url, '', false, $context, null ) ) ) {
				return false;
			}

			if ( ! WP_Filesystem( $this->creds ) ) {
				request_filesystem_credentials( $url, '', true, $context, null );

				return false;
			}

			return true;
		}

		public function get_data() {

			$data       = get_option( 'rb_translation_data', array() );
			$translated = get_option( 'rb_translated_data', array() );

			if ( ! is_array( $data ) || ! count( $data ) ) {
				$data = $this->generate_data();
				update_option( 'rb_translation_data', $data );
			}

			foreach ( $data as $index => $item ) {
				if ( ! empty( $translated[ $item['id'] ] ) ) {
					$data[ $index ]['translated'] = $translated[ $item['id'] ];
				}
			}

			return apply_filters( 'rb_translation_data', $data );
		}

		public function generate_data() {

			$data   = array();
			$prefix = apply_filters( 'rb_translate_file_prefix', 'quick-' );
			$files  = array(
				FOXIZ_CORE_PATH . 'languages/' . $prefix . 'foxiz-core.pot',
			);

			$files  = apply_filters( 'rb_translation_files', $files );
			$this->init_filesystem( wp_nonce_url( '?page=' . $this->menu_slug ) );
			global $wp_filesystem;

			foreach ( $files as $file ) {
				if ( file_exists( $file ) ) {
					$content      = $wp_filesystem->get_contents( $file );;
					$translations = $this->parse( $content );
					if ( ! empty( $translations ) ) {
						foreach ( $translations as $str ) {
							if ( ! empty( $str ) ) {
								$str_id = foxiz_convert_to_id( $str );
								array_push( $data, array(
									'id'  => $str_id,
									'str' => $str
								) );
							}
						}
					}
				}
			}

			return $data;
		}

		public function get_translate( $str_id ) {
			$translated = get_option( 'rb_translated_data', array() );
			if ( ! empty( $translated[ $str_id ] ) ) {
				return $translated[ $str_id ];
			}

			return '';
		}

		public function parse( $content ) {
			if ( preg_match_all( '/msgid\s*"(.*?)"\s*msgstr/', $content, $matches ) ) { ;
				return $matches[1];
			}

			return false;
		}
	}
}