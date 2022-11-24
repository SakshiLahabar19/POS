<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FOXIZ_GUTENBERG_BLOCKS', false ) ) {
	/**
	 * Class FOXIZ_BLOCKS
	 */
	class FOXIZ_GUTENBERG_BLOCKS {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;
			add_action( 'init', [ $this, 'init_blocks' ] );
		}

		public function init_blocks() {

			$dependencies = array(
				'wp-block-editor',
				'wp-blocks',
				'wp-components',
				'wp-data',
				'wp-element',
				'wp-i18n',
				'wp-server-side-render'
			);

			$asset_path = plugin_dir_path( __FILE__ ) . 'index.js';
			$asset_file = plugins_url( 'index.js', __FILE__ );
			if ( is_admin() ) {
				wp_register_script( 'foxiz-gutenberg-core', $asset_file, $dependencies, filemtime( $asset_path ) );
				wp_enqueue_script( 'foxiz-gutenberg-core' );
			}

			register_block_type( __DIR__ . '/related', array(
				'render_callback' => [ $this, 'gutenberg_related' ],
			) );
		}

		function gutenberg_related( $settings ) {

			if ( empty( $settings['layout'] ) ) {
				$settings['layout'] = 1;
			}
			if ( empty( $settings['total'] ) ) {
				$settings['total'] = 4;
			}
			if ( empty( $settings['offset'] ) ) {
				$settings['offset'] = 0;
			}
			if ( empty( $settings['heading_tag'] ) ) {
				$settings['heading_tag'] = 'h4';
			}
			if ( empty( $settings['ids'] ) ) {
				$settings['ids'] = '';
			}
			if ( empty( $settings['where'] ) ) {
				$settings['where'] = 'all';
			}
			$output = '<div class="rb-gutenberg-related">';
			$output .= do_shortcode(
				'[ruby_related heading_tag ="' . $settings['heading_tag']
				. '" heading="' . esc_html( $settings['heading'] )
				. '" total="' . $settings['total']
				. '" offset="' . $settings['offset']
				. ' layout="' . $settings['layout']
				. '" where="' . $settings['where'] . '" ]' );
			$output .= '</div>';

			return $output;
		}

	}
}

FOXIZ_GUTENBERG_BLOCKS::get_instance();
