<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** system info */
if ( ! class_exists( 'rbSubPageThemeOptions', false ) ) {
	class rbSubPageThemeOptions extends RB_ADMIN_SUB_PAGE {

		private static $instance;

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

			$this->page_title = esc_html__( 'Theme Options', 'foxiz-core' );
			$this->menu_title = esc_html__( 'Theme Options', 'foxiz-core' );

			if ( ! $this->validate() ) {
				$this->menu_slug = 'rb-validation-redirect';
			} else {
				$this->menu_slug = 'ruby-options';
			}
			$this->capability = 'administrator';
		}

		public function get_slug() {
			if ( ! $this->validate() ) {
				return 'admin/templates/validate';
			}

			return false;
		}

		public function get_name() {
			if ( ! $this->validate() ) {
				return 'redirect';
			}

			return false;
		}
	}
}