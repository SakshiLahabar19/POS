<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** system info */
if ( ! class_exists( 'rbSubPageImport', false ) ) {
	class rbSubPageImport extends RB_ADMIN_SUB_PAGE {

		private static $instance;
		private $creds = array();
		private $filesystem = array();
		public $demos = array();
		public $demos_path;
		public $demos_url;

		/** get_instance */
		static function get_instance() {
			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {
			self::$instance = $this;

			parent::__construct();
			$this->demos_path = apply_filters( 'rb_importer_demos_path', trailingslashit( plugin_dir_path( __FILE__ ) . 'demos' ) );
			$this->demos_url  = apply_filters( 'rb_importer_demos_url', trailingslashit( plugin_dir_url( __FILE__ ) . 'demos' ) );
			$this->demos      = RB_ADMIN_CORE::get_instance()->get_imports();
		}

		/** set sub page */
		public function set_sub_page() {
			$this->page_title = esc_html__( 'Demo Importer', 'foxiz-core' );
			$this->menu_title = esc_html__( 'Demo Importer', 'foxiz-core' );

			$this->menu_slug  = 'rb-demo-importer';
			$this->capability = 'administrator';
		}

		public function get_slug() {
			if ( ! $this->validate() ) {
				return 'admin/templates/validate';
			} else {
				return 'admin/import/template';
			}
		}

		public function get_name() {
			if ( ! $this->validate() ) {
				return 'redirect';
			} else {
				return false;
			}
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

		/** create index */
		public function create_index() {
			$this->init_filesystem( wp_nonce_url( '?page=' . $this->menu_slug ) );
			global $wp_filesystem;
			$this->filesystem = $wp_filesystem;

			$index_path = trailingslashit( $this->demos_path ) . 'index.php';
			if ( ! file_exists( $index_path ) ) {
				$this->filesystem->put_contents( $index_path, '<?php' . PHP_EOL . '// Silence is golden.', FS_CHMOD_FILE );
			}
		}

		/**get params */
		public function get_params() {

			/** load importer library */
			require_once plugin_dir_path( __FILE__ ) . 'parts.php';

			$this->create_index();
			$params          = array();
			$imported        = get_option( 'rb_imported_demos' );
			$params['demos'] = $this->demos;
			if ( is_array( $params['demos'] ) && count( $params['demos'] ) ) {
				foreach ( $params['demos'] as $directory => $values ) {
					if ( empty( $params['demos'][ $directory ]['preview'] ) ) {
						$params['demos'][ $directory ]['preview'] = $this->demos_url . $directory . '.jpg';
					}
					if ( is_array( $imported ) && ! empty( $imported[ $directory ] ) ) {
						$params['demos'][ $directory ]['imported'] = $imported[ $directory ];
					} else {
						$params['demos'][ $directory ]['imported'] = 'none';
					}
				}
			}
			$params = apply_filters( 'rb_importer_params', $params );

			return $params;
		}
	}
}