<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Rb_Init_Fonts', false ) ) {
	/**
	 * Class Rb_Init_Fonts
	 */
	class Rb_Init_Fonts {

		private static $instance;

		public $settings;
		public $supported_headings;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		function __construct() {
			self::$instance = $this;

			add_action( 'init', array( $this, 'load_project' ) );
			add_action( 'init', array( $this, 'update_font_settings' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_font' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'css_output' ), 9999 );
			add_action( 'admin_notices', array( $this, 'notification' ) );
		}

		public function load_project() {

			if ( isset( $_POST['rb-fonts-nonce'] ) && wp_verify_nonce( $_POST['rb-fonts-nonce'], 'rb-fonts' ) ) {
				if ( isset( $_POST['action'] ) && 'delete' === $_POST['action'] ) {
					delete_option( 'rb_adobe_fonts' );
					$_POST['rb-project-delete-notice'] = true;

					return false;
				}

				if ( isset( $_POST['rb_fonts_project_id'] ) && current_user_can( 'manage_options' ) ) {
					$project_id = sanitize_text_field( $_POST['rb_fonts_project_id'] );
					$fonts      = $this->get_data( $project_id );
					if ( ! empty( $fonts ) && is_array( $fonts ) ) {
						update_option( 'rb_adobe_fonts', array(
							'project_id' => $project_id,
							'fonts'      => $fonts
						) );
					}
				}
			}
		}

		public function load_font() {

			$settings = get_option( 'rb_adobe_font_settings', array() );
			$fonts    = get_option( 'rb_adobe_fonts', array() );

			if ( count( $settings ) && ! empty( $fonts['project_id'] ) ) {
				wp_enqueue_style( 'adobe-fonts', esc_url_raw( 'https://use.typekit.net/' . esc_html( $fonts['project_id'] ) . '.css' ), array(), false, 'all' );
			}
		}

		/**
		 * @param $project_id
		 *
		 * @return array
		 *
		 */
		public function get_data( $project_id ) {

			$data     = array();
			$api_url  = 'https://typekit.com/api/v1/json/kits/' . $project_id . '/published';
			$response = wp_remote_get( $api_url, array( 'timeout' => 60 ) );

			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
				$_POST['rb-project-id-notice'] = true;

				return $data;
			}

			$response      = wp_remote_retrieve_body( $response );
			$response      = json_decode( $response, true );
			$font_families = $response['kit']['families'];

			if ( is_array( $font_families ) && count( $font_families ) ) {

				foreach ( $font_families as $font_family ) {
					$family_name          = $font_family['slug'];
					$data[ $family_name ] = array(
						'family'     => $font_family['name'],
						'backup'     => str_replace( '"', '', $font_family['css_stack'] ),
						'variations' => array(),
					);

					if ( isset( $font_family['css_names'][0] ) ) {
						$data[ $family_name ]['css_names'] = $font_family['css_names'][0];
					}
					foreach ( $font_family['variations'] as $variation ) {

						$variations = str_split( $variation );
						if ( $variations[0] === 'n' ) {
							$font_variation = $variations[1] . '00';
						} else {
							$font_variation = $variations[1] . '00' . $variations[0];
						}

						array_push( $data[ $family_name ]['variations'], $font_variation );
					}
				}
			} else {
				$_POST['rb-project-empty-notice'] = true;
			}

			return $data;
		}

		/** notification */
		public function notification() {

			if ( isset( $_POST['rb-fonts-nonce'] ) && wp_verify_nonce( $_POST['rb-fonts-nonce'], 'rb-fonts' ) ) :
				if ( ! empty( $_POST['rb-project-id-notice'] ) ) : ?>
					<div class="notice notice-error is-dismissible">
						<p><?php esc_html_e( 'Project ID is invalid. Please check again!', 'foxiz-core' ); ?></p>
					</div>
				<?php elseif ( ! empty( $_POST['rb-project-empty-notice'] ) ) : ?>
					<div class="notice notice-error is-dismissible">
						<p><?php esc_html_e( 'Project is empty. Please add some fonts to your project.', 'foxiz-core' ); ?></p>
					</div>
				<?php elseif ( ! empty( $_POST['rb-project-delete-notice'] ) ) : ?>
					<div class="notice notice-error is-dismissible">
						<p><?php esc_html_e( 'Adobe Fonts have been successfully deleted.', 'foxiz-core' ); ?></p>
					</div>
				<?php else : ?>
					<div class="notice notice-success is-dismissible">
						<p><?php esc_html_e( 'Adobe Fonts have been successfully loaded.', 'foxiz-core' ); ?></p>
					</div>
				<?php endif;
			endif;

			if ( isset( $_POST['rb-font-settings-nonce'] ) && wp_verify_nonce( $_POST['rb-font-settings-nonce'], 'rb-font-settings' ) ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Font settings have been successfully saved.', 'foxiz-core' ); ?></p>
				</div>
			<?php endif;
		}

		/** update fonts */
		public function update_font_settings() {

			if ( isset( $_POST['rb-font-settings-nonce'] ) && wp_verify_nonce( $_POST['rb-font-settings-nonce'], 'rb-font-settings' ) ) {
				if ( isset( $_POST['rb_font_settings'] ) && is_array( $_POST['rb_font_settings'] ) && current_user_can( 'manage_options' ) ) {
					$settings = array_map( 'sanitize_text_field', $_POST['rb_font_settings'] );
					update_option( 'rb_adobe_font_settings', $settings );
				}
			}
		}

		/**
		 * @param $setting
		 *
		 * @return string
		 */
		public function parse_setting( $setting ) {

			$params    = explode( '::', $setting );
			$font_data = get_option( 'rb_adobe_fonts', array() );
			$output    = '';

			if ( isset( $params[0] ) ) {
				if ( ! empty( $font_data['fonts'][ $params[0] ]['backup'] ) ) {
					$output .= 'font-family:' . $font_data['fonts'][ $params[0] ]['backup'] . ';';
				} else {
					$output .= 'font-family:' . $params[0] . ';';
				}
			}

			if ( ! empty( $params[1] ) ) {
				$output .= 'font-weight:' . intval( $params[1] ) . ';';
			}

			if ( substr( $params[1], - 1 ) === 'i' ) {
				$output .= 'font-style: italic;';
			}

			return $output;
		}

		/** css output */
		public function css_output() {

			$settings   = get_option( 'rb_adobe_font_settings', array() );
			$css_output = '';
			if ( count( $settings ) ) {
				foreach ( $settings as $tag => $setting ) {
					if ( ! empty( $setting ) ) {
						$css_output .= $tag . '{' . $this->parse_setting( $setting ) . '}';
					}
				}
			}

			if ( ! wp_style_is( 'foxiz-style' ) ) {
				wp_add_inline_style( 'adobe-fonts', $css_output );
			} else {
				wp_add_inline_style( 'foxiz-style', $css_output );
			}
		}
	}
}

/** load */
Rb_Init_Fonts::get_instance();
