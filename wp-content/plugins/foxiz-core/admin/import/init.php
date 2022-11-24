<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RB_INIT_IMPORTER', false ) ) {
	/**
	 * Class RB_INIT_IMPORTER
	 * init importer
	 */
	class RB_INIT_IMPORTER extends RB_Radium_Theme_Importer {
		private static $instance;

		public $main_path;
		public $content_demo;
		public $content_pages;
		public $widgets;
		public $theme_options_file;
		public $theme_option_name;
		public $categories_file;
		public $directory;
		public $selection_data;
		public $widget_import_results;

		public function __construct( $data ) {

			if ( ! defined( 'RB_API_URL' ) ) {
				wp_die( esc_html__( 'An error occurred during import.', 'foxiz-core' ) );
			}

			self::$instance = $this;
			if ( ! empty( $data['path'] ) ) {
				$this->main_path = $data['path'];
			};
			$this->content_demo       = $data['content'];
			$this->content_pages      = $data['pages'];
			$this->widgets            = trailingslashit( RB_API_URL ) . $data['widgets'];
			$this->theme_options_file = trailingslashit( RB_API_URL ) . $data['theme_options'];
			$this->categories_file    = trailingslashit( RB_API_URL ) . $data['categories'];
			$this->directory          = $data['directory'];
			$this->theme_option_name  = $data['theme_option_name'];
			$this->selection_data     = $data;

			parent::__construct();
		}
	}
}