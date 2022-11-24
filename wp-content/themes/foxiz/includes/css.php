<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_Css', false ) ) {
	/**
	 * Class Foxiz_Css
	 */
	class Foxiz_Css {

		private static $instance;
		protected $debug = false;
		protected $settings;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			$this->settings = foxiz_get_option();

			add_action( 'redux/options/' . FOXIZ_TOS_ID . '/saved', array( $this, 'write_css' ), 999 );
			add_action( 'redux/options/' . FOXIZ_TOS_ID . '/reset', array( $this, 'write_css' ), 999 );
			add_action( 'redux/options/' . FOXIZ_TOS_ID . '/section/reset', array( $this, 'write_css' ), 999 );
			add_action( 'upgrader_process_complete', array( $this, 'write_css' ) );
			add_action( 'create_category ', array( $this, 'write_css' ) );
			add_action( 'edited_category', array( $this, 'write_css' ) );
			add_action( 'after_switch_theme', array( $this, 'write_css' ), 999 );
			add_action( 'activated_plugin', array( $this, 'write_css' ), 999 );
			add_action( 'wp_update_nav_menu', array( $this, 'write_css' ), 999 );
			add_action( 'enqueue_block_editor_assets', array( $this, 'admin_load' ), 999 );
			add_action( 'wp_enqueue_scripts', array( $this, 'load' ), 999 );
		}

		/**
		 * @param $css
		 *
		 * @return string|string[]|null
		 */
		function minify_css( $css ) {

			return preg_replace( '@({)\s+|(\;)\s+|/\*.+?\*\/|\R@is', '$1$2 ', $css );
		}

		/**
		 * @return string
		 */
		function write_css() {

			$this->settings = foxiz_get_option();
			$writable       = false;
			$output         = $this->output();

			if ( foxiz_get_option( 'css_file' ) ) {

				$folder_path = get_theme_file_path( 'assets/css' );
				$file_path   = $folder_path . '/dynamic.css';

				if ( is_multisite() ) {
					global $blog_id;
					$file_path = $folder_path . '/dynamic-blog-' . $blog_id . '.css';
				}
				$writable = $this->writable_css( $output, $folder_path, $file_path );
			}

			if ( empty( $writable ) ) {
				update_option( 'foxiz_style_cache', addslashes( $output ) );
			}

			return $output;
		}

		/**
		 * @param string $css
		 * @param $folder_path
		 * @param $file_path
		 *
		 * @return bool
		 */
		function writable_css( $css, $folder_path, $file_path ) {

			global $wp_filesystem;

			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			if ( $wp_filesystem ) {
				$content = "/** Compiled CSS - Do not edit */\n" . $css;
				if ( is_readable( $folder_path ) || ( file_exists( $file_path ) && is_writable( $file_path ) ) ) {
					if ( $wp_filesystem->put_contents( $file_path, $content, FS_CHMOD_FILE ) ) {
						update_option( 'foxiz_dynamic_ctime', time() );

						return true;
					}
				}
			}

			return false;
		}

		/**
		 * @param $handle
		 */
		function load( $handle ) {

			if ( empty( $handle ) ) {
				$handle = 'foxiz-style';
			}

			$file_path = '';
			$file_uri  = '';
			$version   = get_option( 'foxiz_dynamic_ctime' );

			if ( foxiz_get_option( 'css_file' ) ) {
				global $blog_id;

				if ( ! defined( 'FOXIZ_DTHEME_DIR' ) || ! defined( 'FOXIZ_DTHEME_URI' ) ) {
					$file_path = get_theme_file_path( 'assets/css/dynamic.css' );
					$file_uri  = get_theme_file_uri( 'assets/css/dynamic.css' );
					if ( is_multisite() ) {
						$file_path = get_theme_file_path( 'assets/css/dynamic-blog-' . $blog_id . '.css' );
						$file_uri  = get_theme_file_uri( 'assets/css/dynamic-blog-' . $blog_id . '.css' );
					}
				} else {
					$file_path = FOXIZ_DTHEME_DIR . 'assets/css/dynamic.css';
					$file_uri  = FOXIZ_DTHEME_URI . 'assets/css/dynamic.css';

					if ( is_multisite() ) {
						$file_path = FOXIZ_DTHEME_DIR . 'assets/css/dynamic-blog-' . $blog_id . '.css';
						$file_uri  = FOXIZ_DTHEME_URI . 'assets/css/dynamic-blog-' . $blog_id . '.css';
					}
				}
			}

			if ( ! empty( $file_path ) && ! empty( $file_uri ) && file_exists( $file_path ) ) {
				wp_enqueue_style( 'foxiz-dynamic-css', $file_uri, array( $handle ), $version );
			} else {

				if ( $this->debug ) {
					$output = $this->output();
				} else {
					$output = get_option( 'foxiz_style_cache' );
					if ( empty( $output ) ) {
						$output = $this->write_css();
					} else {
						$output = stripslashes( $output );
					}
				}
				/** load  */
				wp_add_inline_style( $handle, $output );
			}
		}

		function admin_load() {

			$this->load( 'foxiz-editor-style' );
		}

		/**
		 * @param $settings
		 * @param $config_id
		 *
		 * @return string
		 */
		public function css_background( $settings, $config_id ) {

			if ( ! isset( $settings[ $config_id ] ) || ! is_array( $settings[ $config_id ] ) ) {
				return '';
			}

			$background = $settings[ $config_id ];
			$output     = '';
			if ( ! empty( $background['background-color'] ) ) {
				$output .= 'background-color : ' . $background['background-color'] . ';';
			}
			if ( ! empty( $background['background-repeat'] ) ) {
				$output .= 'background-repeat : ' . $background['background-repeat'] . ';';
			}
			if ( ! empty( $background['background-size'] ) ) {
				$output .= 'background-size : ' . $background['background-size'] . ';';
			}
			if ( ! empty( $background['background-image'] ) ) {
				$output .= 'background-image : url(' . esc_url( $background['background-image'] ) . ');';
			}
			if ( ! empty( $background['background-attachment'] ) ) {
				$output .= 'background-attachment : ' . $background['background-attachment'] . ';';
			}
			if ( ! empty( $background['background-position'] ) ) {
				$output .= 'background-position : ' . $background['background-position'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 * @param string $prefix
		 * @param string $config_id
		 *
		 * @return false|string
		 */
		public function font_var( $settings = array(), $prefix = '', $config_id = '' ) {

			if ( empty( $settings[ $config_id ] ) || ! is_array( $settings[ $config_id ] ) ) {
				return false;
			}

			$output     = '';
			$font_array = shortcode_atts( array(
				'font-family'    => '',
				'font-weight'    => '',
				'text-transform' => '',
				'color'          => '',
				'font-style'     => '',
				'font-size'      => '',
				'letter-spacing' => ''
			), $settings[ $config_id ] );

			foreach ( $font_array as $name => $value ) {
				if ( ! empty( $value ) ) {
					$output .= '--' . $prefix . '-' . $this->compact_font_name( $name ) . ':' . $value . ';';
				}
			}

			return $output;
		}

		/**
		 * @param $name
		 *
		 * @return string
		 */
		public function compact_font_name( $name ) {

			$name = trim( $name );
			switch ( $name ) {
				case 'font-family' :
					return 'family';
				case 'font-weight' :
					return 'fweight';
				case 'text-transform' :
					return 'transform';
				case 'color' :
					return 'fcolor';
				case 'font-style' :
					return 'fstyle';
				case 'font-size' :
					return 'fsize';
				case 'letter-spacing' :
					return 'fspace';
				case 'line-height' :
					return 'fheight';
				default :
					return $name;
			}
		}

		/**
		 * @param array $settings
		 * @param string $name
		 * @param string $config_id
		 *
		 * @return false|string
		 */
		function font_size_var( $settings = array(), $name = '', $config_id = '' ) {

			if ( empty( $name ) || empty( $settings[ $config_id ] ) ) {
				return false;
			}

			if ( is_array( $settings[ $config_id ] ) ) {
				if ( ! empty( $settings[ $config_id ]['font-size'] ) ) {
					return '--' . $name . '-fsize : ' . floatval( $settings[ $config_id ]['font-size'] ) . 'px;';
				}

				return false;
			} else {
				return '--' . $name . '-fsize : ' . floatval( $settings[ $config_id ] ) . 'px;';
			}
		}

		/**
		 * @param array $settings
		 * @param string $name
		 * @param string $config_id
		 *
		 * @return string
		 */
		function get_gradient_background_var( $settings = array(), $name = '', $config_id = '' ) {

			if ( empty( $name ) || empty( $settings[ $config_id ] ) ) {
				return false;
			}

			$output = '';
			if ( ! empty( $settings[ $config_id ]['from'] ) && ! empty( $settings[ $config_id ]['to'] ) ) {
				$output .= '--' . $name . '-bg: ' . $settings[ $config_id ]['from'] . ';';
				$output .= '--' . $name . '-bg-from: ' . $settings[ $config_id ]['from'] . ';';
				$output .= '--' . $name . '-bg-to: ' . $settings[ $config_id ]['to'] . ';';
			} elseif ( ! empty( $settings[ $config_id ]['from'] ) ) {
				$output .= '--' . $name . '-bg: ' . $settings[ $config_id ]['from'] . ';';
				$output .= '--' . $name . '-bg-from: ' . $settings[ $config_id ]['from'] . ';';
				$output .= '--' . $name . '-bg-to: ' . $settings[ $config_id ]['from'] . ';';
			} elseif ( ! empty( $settings[ $config_id ]['to'] ) ) {
				$output .= '--' . $name . '-bg: ' . $settings[ $config_id ]['to'] . ';';
				$output .= '--' . $name . '-bg-from: ' . $settings[ $config_id ]['to'] . ';';
				$output .= '--' . $name . '-bg-to: ' . $settings[ $config_id ]['to'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_typography_var( $settings = array() ) {

			$output = '';
			$buffer = '';

			$buffer .= $this->font_var( $settings, 'body', 'font_body' );
			$buffer .= $this->font_var( $settings, 'h1', 'font_h1' );
			$buffer .= $this->font_var( $settings, 'h2', 'font_h2' );
			$buffer .= $this->font_var( $settings, 'h3', 'font_h3' );
			$buffer .= $this->font_var( $settings, 'h4', 'font_h4' );
			$buffer .= $this->font_var( $settings, 'h5', 'font_h5' );
			$buffer .= $this->font_var( $settings, 'h6', 'font_h6' );
			$buffer .= $this->font_var( $settings, 'cat', 'font_ecat' );
			$buffer .= $this->font_var( $settings, 'meta', 'font_emeta' );
			$buffer .= $this->font_var( $settings, 'meta-b', 'font_eauthor' );
			$buffer .= $this->font_var( $settings, 'input', 'font_input' );
			$buffer .= $this->font_var( $settings, 'btn', 'font_button' );
			$buffer .= $this->font_var( $settings, 'menu', 'font_main_menu' );
			$buffer .= $this->font_var( $settings, 'submenu', 'font_main_sub_menu' );
			$buffer .= $this->font_var( $settings, 'dwidgets', 'font_widget' );
			$buffer .= $this->font_var( $settings, 'headline', 'font_headline' );
			$buffer .= $this->font_var( $settings, 'tagline', 'font_tagline' );
			$buffer .= $this->font_var( $settings, 'heading', 'font_heading' );
			$buffer .= $this->font_var( $settings, 'subheading', 'font_sub_heading' );
			$buffer .= $this->font_var( $settings, 'quote', 'font_quote' );
			$buffer .= $this->font_size_var( $settings, 'readmore', 'font_readmore' );
			$buffer .= $this->font_size_var( $settings, 'bcrumb', 'font_breadcrumb' );
			$buffer .= $this->font_size_var( $settings, 'excerpt', 'font_excerpt_size' );
			$buffer .= $this->font_size_var( $settings, 'headline-s', 'font_headline_size_content' );
			$buffer .= $this->font_size_var( $settings, 'tagline-s', 'font_tagline_size_content' );

			if ( ! empty( $buffer ) ) {
				$output .= ':root {' . $buffer . '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_font_size_tablet( $settings = array() ) {

			$output = '';
			$buffer = '';

			$buffer .= $this->font_size_var( $settings, 'body', 'font_body_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'h1', 'font_h1_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'h2', 'font_h2_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'h3', 'font_h3_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'h4', 'font_h4_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'h5', 'font_h5_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'h6', 'font_h6_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'cat', 'font_ecat_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'meta', 'font_emeta_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'readmore', 'font_readmore_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'input', 'font_input_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'btn', 'font_button_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'bcrumb', 'font_breadcrumb_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'heading', 'font_heading_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'excerpt', 'font_excerpt_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'dwidgets', 'font_widget_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'headline', 'font_headline_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'headline-s', 'font_headline_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'tagline', 'font_tagline_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'tagline-s', 'font_tagline_size_tablet' );
			$buffer .= $this->font_size_var( $settings, 'product', 'font_product_size_tablet' );

			if ( ! empty( $buffer ) ) {
				$output .= '@media (max-width: 1024px) {';
				$output .= 'body {' . $buffer . '}';
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_font_size_mobile( $settings = array() ) {

			$output = '';
			$buffer = '';

			$buffer .= $this->font_size_var( $settings, 'body', 'font_body_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'h1', 'font_h1_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'h2', 'font_h2_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'h3', 'font_h3_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'h4', 'font_h4_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'h5', 'font_h5_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'h6', 'font_h6_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'cat', 'font_ecat_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'meta', 'font_emeta_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'readmore', 'font_readmore_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'input', 'font_input_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'btn', 'font_button_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'bcrumb', 'font_breadcrumb_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'heading', 'font_heading_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'excerpt', 'font_excerpt_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'dwidgets', 'font_widget_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'headline', 'font_headline_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'headline-s', 'font_headline_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'tagline', 'font_tagline_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'tagline-s', 'font_tagline_size_mobile' );
			$buffer .= $this->font_size_var( $settings, 'product', 'font_product_size_mobile' );

			if ( ! empty( $buffer ) ) {
				$output .= '@media (max-width: 767px) {';
				$output .= 'body {' . $buffer . '}';
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_colors_var_data( $settings = array() ) {

			$output = '';

			if ( ! empty( $settings['global_color'] ) ) {
				$output .= '--g-color :' . $settings['global_color'] . ';';
				$output .= '--g-color-90 :' . $settings['global_color'] . 'e6;';
			}
			if ( ! empty( $settings['accent_color'] ) ) {
				$output .= '--dark-accent :' . $settings['accent_color'] . ';';
				$output .= '--dark-accent-90 :' . $settings['accent_color'] . 'e6;';
				$output .= '--dark-accent-0 :' . $settings['accent_color'] . '00;';
			}
			if ( ! empty( $settings['review_color'] ) ) {
				$output .= '--review-color :' . $settings['review_color'] . ';';
			}
			if ( ! empty( $settings['hyperlink_color'] ) ) {
				$output .= '--hyperlink-color :' . $settings['hyperlink_color'] . ';';
			}
			if ( ! empty( $settings['icon_video_color'] ) ) {
				$output .= '--video-color :' . $settings['icon_video_color'] . ';';
			}
			if ( ! empty( $settings['icon_gallery_color'] ) ) {
				$output .= '--gallery-color :' . $settings['icon_gallery_color'] . ';';
			}
			if ( ! empty( $settings['icon_audio_color'] ) ) {
				$output .= '--audio-color :' . $settings['icon_audio_color'] . ';';
			}
			if ( ! empty( $settings['excerpt_color'] ) ) {
				$output .= '--excerpt-color :' . $settings['excerpt_color'] . ';';
			}
			if ( ! empty( $settings['breadcrumb_color'] ) ) {
				$output .= '--bcrumb-color :' . $settings['breadcrumb_color'] . ';';
			}
			if ( ! empty( $settings['reading_indicator_color']['from'] ) ) {
				$output .= '--indicator-bg-from :' . $settings['reading_indicator_color']['from'] . ';';
			}
			if ( ! empty( $settings['reading_indicator_color']['to'] ) ) {
				$output .= '--indicator-bg-to :' . $settings['reading_indicator_color']['to'] . ';';
			}
			if ( ! empty( $settings['reading_indicator_height'] ) ) {
				$output .= '--indicator-height :' . absint( $settings['reading_indicator_height'] ) . 'px;';
			}
			if ( ! empty( $settings['alert_bg'] ) ) {
				$output .= '--alert-bg :' . $settings['alert_bg'] . ';';
			}
			if ( ! empty( $settings['alert_color'] ) ) {
				$output .= '--alert-color :' . $settings['alert_color'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_colors_var_data_dark( $settings = array() ) {

			$output = '';
			if ( ! empty( $settings['dark_global_color'] ) ) {
				$output .= '--g-color :' . $settings['dark_global_color'] . ';';
				$output .= '--g-color-90 :' . $settings['dark_global_color'] . 'e6;';
			}
			if ( ! empty( $settings['dark_background'] ) ) {
				$output .= '--solid-white :' . $settings['dark_background'] . ';';
			}
			if ( ! empty( $settings['dark_accent_color'] ) ) {
				$output .= '--dark-accent :' . $settings['dark_accent_color'] . ';';
				$output .= '--dark-accent-90 :' . $settings['dark_accent_color'] . 'e6;';
				$output .= '--dark-accent-0 :' . $settings['dark_accent_color'] . '00;';
			}
			if ( ! empty( $settings['dark_alert_bg'] ) ) {
				$output .= '--alert-bg :' . $settings['dark_alert_bg'] . ';';
			}
			if ( ! empty( $settings['dark_alert_color'] ) ) {
				$output .= '--alert-color :' . $settings['dark_alert_color'] . ';';
			}

			if ( ! empty( $settings['dark_excerpt_color'] ) ) {
				$output .= '--excerpt-color :' . $settings['dark_excerpt_color'] . ';';
			}

			if ( ! empty( $settings['dark_breadcrumb_color'] ) ) {
				$output .= '--bcrumb-color :' . $settings['dark_breadcrumb_color'] . ';';
			}

			if ( ! empty( $settings['dark_emeta_color'] ) ) {
				$output .= '--meta-fcolor :' . $settings['dark_emeta_color'] . ';';
			}
			if ( ! empty( $settings['dark_eauthor_color'] ) ) {
				$output .= '--meta-b-fcolor :' . $settings['dark_eauthor_color'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_colors_var( $settings = array() ) {

			$output = '';

			if ( $this->get_colors_var_data( $settings ) ) {
				$output .= ':root {';
				$output .= $this->get_colors_var_data( $settings );
				$output .= '}';
			}

			if ( $this->get_colors_var_data_dark( $settings ) ) {
				$output .= '[data-theme="dark"], .light-scheme {';
				$output .= $this->get_colors_var_data_dark( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_1_var_data( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'nav', 'hd1_background' );
			$output .= $this->get_gradient_background_var( $settings, 'subnav', 'hd1_sub_background' );

			if ( ! empty( $settings['hd1_color'] ) ) {
				$output .= '--nav-color :' . $settings['hd1_color'] . ';';
				$output .= '--nav-color-10 :' . $settings['hd1_color'] . '1a;';
			}
			if ( ! empty( $settings['hd1_sub_color'] ) ) {
				$output .= '--subnav-color :' . $settings['hd1_sub_color'] . ';';
				$output .= '--subnav-color-10 :' . $settings['hd1_sub_color'] . '1a;';
			}
			if ( ! empty( $settings['hd1_color_hover'] ) ) {
				$output .= '--nav-color-h :' . $settings['hd1_color_hover'] . ';';
			}
			if ( ! empty( $settings['hd1_color_hover_accent'] ) ) {
				$output .= '--nav-color-h-accent :' . $settings['hd1_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['hd1_sub_color_hover'] ) ) {
				$output .= '--subnav-color-h :' . $settings['hd1_sub_color_hover'] . ';';
			}
			if ( ! empty( $settings['transparent_hd1_color'] ) ) {
				$output .= '--transparent-nav-color :' . $settings['transparent_hd1_color'] . ';';
			}
			if ( ! empty( $settings['transparent_hd1_color_hover'] ) ) {
				$output .= '--transparent-nav-color-hover :' . $settings['transparent_hd1_color_hover'] . ';';
			}
			if ( ! empty( $settings['transparent_hd1_color_hover_accent'] ) ) {
				$output .= '--transparent-nav-color-h-accent :' . $settings['transparent_hd1_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['hd1_height'] ) ) {
				$output .= '--nav-height :' . floatval( $settings['hd1_height'] ) . 'px;';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_1_var_data_dark( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'nav', 'dark_hd1_background' );
			$output .= $this->get_gradient_background_var( $settings, 'subnav', 'dark_hd1_sub_background' );

			if ( ! empty( $settings['dark_hd1_color'] ) ) {
				$output .= '--nav-color :' . $settings['dark_hd1_color'] . ';';
				$output .= '--nav-color-10 :' . $settings['dark_hd1_color'] . '1a;';
			}
			if ( ! empty( $settings['dark_hd1_sub_color'] ) ) {
				$output .= '--subnav-color :' . $settings['dark_hd1_sub_color'] . ';';
				$output .= '--subnav-color-10 :' . $settings['dark_hd1_sub_color'] . '1a;';
			}
			if ( ! empty( $settings['dark_hd1_color_hover'] ) ) {
				$output .= '--nav-color-h :' . $settings['dark_hd1_color_hover'] . ';';
			}
			if ( ! empty( $settings['dark_hd1_color_hover_accent'] ) ) {
				$output .= '--nav-color-h-accent :' . $settings['dark_hd1_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['dark_hd1_sub_color_hover'] ) ) {
				$output .= '--subnav-color-h :' . $settings['dark_hd1_sub_color_hover'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_4_var_data( $settings = array() ) {

			$output = '';

			$output .= $this->get_gradient_background_var( $settings, 'nav', 'hd4_background' );
			$output .= $this->get_gradient_background_var( $settings, 'subnav', 'hd4_sub_background' );

			if ( ! empty( $settings['hd4_color'] ) ) {
				$output .= '--nav-color :' . $settings['hd4_color'] . ';';
				$output .= '--nav-color-10 :' . $settings['hd4_color'] . '1a;';
			}
			if ( ! empty( $settings['hd4_sub_color'] ) ) {
				$output .= '--subnav-color :' . $settings['hd4_sub_color'] . ';';
				$output .= '--subnav-color-10 :' . $settings['hd4_sub_color'] . '1a;';
			}
			if ( ! empty( $settings['hd4_color_hover'] ) ) {
				$output .= '--nav-color-h :' . $settings['hd4_color_hover'] . ';';
			}
			if ( ! empty( $settings['hd4_color_hover_accent'] ) ) {
				$output .= '--nav-color-h-accent :' . $settings['hd4_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['hd4_sub_color_hover'] ) ) {
				$output .= '--subnav-color-h :' . $settings['hd4_sub_color_hover'] . ';';
			}
			if ( ! empty( $settings['hd4_height'] ) ) {
				$output .= '--nav-height :' . floatval( $settings['hd4_height'] ) . 'px;';
			}
			if ( ! empty( $settings['hd4_logo_height'] ) ) {
				$output .= '--hd4-logo-height :' . floatval( $settings['hd4_logo_height'] ) . 'px;';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_4_var_data_dark( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'nav', 'dark_hd4_background' );
			$output .= $this->get_gradient_background_var( $settings, 'subnav', 'dark_hd4_sub_background' );

			if ( ! empty( $settings['dark_hd4_color'] ) ) {
				$output .= '--nav-color :' . $settings['dark_hd4_color'] . ';';
				$output .= '--nav-color-10 :' . $settings['dark_hd4_color'] . '1a;';
			}
			if ( ! empty( $settings['dark_hd4_sub_color'] ) ) {
				$output .= '--subnav-color :' . $settings['dark_hd4_sub_color'] . ';';
				$output .= '--subnav-color-10 :' . $settings['dark_hd4_sub_color'] . '1a;';
			}
			if ( ! empty( $settings['dark_hd4_color_hover'] ) ) {
				$output .= '--nav-color-h :' . $settings['dark_hd4_color_hover'] . ';';
			}
			if ( ! empty( $settings['dark_hd4_color_hover_accent'] ) ) {
				$output .= '--nav-color-h-accent :' . $settings['dark_hd4_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['dark_hd4_sub_color_hover'] ) ) {
				$output .= '--subnav-color-h :' . $settings['dark_hd4_sub_color_hover'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_5_var_data( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'nav', 'hd5_background' );
			$output .= $this->get_gradient_background_var( $settings, 'subnav', 'hd5_sub_background' );

			if ( ! empty( $settings['hd5_color'] ) ) {
				$output .= '--nav-color :' . $settings['hd5_color'] . ';';
				$output .= '--nav-color-10 :' . $settings['hd5_color'] . '1a;';
			}
			if ( ! empty( $settings['hd5_sub_color'] ) ) {
				$output .= '--subnav-color :' . $settings['hd5_sub_color'] . ';';
				$output .= '--subnav-color-10 :' . $settings['hd5_sub_color'] . '1a;';
			}
			if ( ! empty( $settings['hd5_color_hover'] ) ) {
				$output .= '--nav-color-h :' . $settings['hd5_color_hover'] . ';';
			}
			if ( ! empty( $settings['hd5_color_hover_accent'] ) ) {
				$output .= '--nav-color-h-accent :' . $settings['hd5_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['hd5_sub_color_hover'] ) ) {
				$output .= '--subnav-color-h :' . $settings['hd5_sub_color_hover'] . ';';
			}
			if ( ! empty( $settings['hd5_height'] ) ) {
				$output .= '--nav-height :' . floatval( $settings['hd5_height'] ) . 'px;';
			}
			if ( ! empty( $settings['hd5_logo_height'] ) ) {
				$output .= '--hd5-logo-height :' . floatval( $settings['hd5_logo_height'] ) . 'px;';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_5_var_data_dark( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'nav', 'dark_hd5_background' );
			$output .= $this->get_gradient_background_var( $settings, 'subnav', 'dark_hd5_sub_background' );

			if ( ! empty( $settings['dark_hd5_color'] ) ) {
				$output .= '--nav-color :' . $settings['dark_hd5_color'] . ';';
				$output .= '--nav-color-10 :' . $settings['dark_hd5_color'] . '1a;';
			}
			if ( ! empty( $settings['dark_hd5_sub_color'] ) ) {
				$output .= '--subnav-color :' . $settings['dark_hd5_sub_color'] . ';';
			}
			if ( ! empty( $settings['dark_hd5_color_hover'] ) ) {
				$output .= '--nav-color-h :' . $settings['dark_hd5_color_hover'] . ';';
			}
			if ( ! empty( $settings['dark_hd5_color_hover_accent'] ) ) {
				$output .= '--nav-color-h-accent :' . $settings['dark_hd5_color_hover_accent'] . ';';
			}
			if ( ! empty( $settings['dark_hd5_sub_color_hover'] ) ) {
				$output .= '--subnav-color-h :' . $settings['dark_hd5_sub_color_hover'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_1_var( $settings = array() ) {

			$output = '';
			if ( $this->get_header_1_var_data( $settings ) ) {
				$output .= '.is-hd-1, .is-hd-2, .is-hd-3 {';
				$output .= $this->get_header_1_var_data( $settings );
				$output .= '}';
			}

			if ( $this->get_header_1_var_data_dark( $settings ) ) {
				$output .= '[data-theme="dark"].is-hd-1, [data-theme="dark"].is-hd-2,[data-theme="dark"].is-hd-3 {';
				$output .= $this->get_header_1_var_data_dark( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_4_var( $settings = array() ) {

			$output = '';
			if ( $this->get_header_4_var_data( $settings ) ) {
				$output .= '.is-hd-4 {';
				$output .= $this->get_header_4_var_data( $settings );
				$output .= '}';
			}

			if ( $this->get_header_4_var_data_dark( $settings ) ) {
				$output .= '[data-theme="dark"].is-hd-4 {';
				$output .= $this->get_header_4_var_data_dark( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_header_5_var( $settings = array() ) {

			$output = '';
			if ( $this->get_header_5_var_data( $settings ) ) {
				$output .= '.is-hd-5, body.is-hd-5:not(.sticky-on) {';
				$output .= $this->get_header_5_var_data( $settings );
				$output .= '}';
			}

			if ( $this->get_header_5_var_data_dark( $settings ) ) {
				$output .= '[data-theme="dark"].is-hd-5, [data-theme="dark"].is-hd-5:not(.sticky-on) {';
				$output .= $this->get_header_5_var_data_dark( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_mobile_header_var_data( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'mbnav', 'mobile_background' );
			$output .= $this->get_gradient_background_var( $settings, 'submbnav', 'mobile_sub_background' );

			if ( ! empty( $settings['mobile_color'] ) ) {
				$output .= '--mbnav-color :' . $settings['mobile_color'] . ';';
			}
			if ( ! empty( $settings['mobile_sub_color'] ) ) {
				$output .= '--submbnav-color :' . $settings['mobile_sub_color'] . ';';
				$output .= '--submbnav-color-10 :' . $settings['mobile_sub_color'] . '1a;';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_mobile_header_var_data_dark( $settings = array() ) {

			$output = '';
			$output .= $this->get_gradient_background_var( $settings, 'mbnav', 'dark_mobile_background' );
			$output .= $this->get_gradient_background_var( $settings, 'submbnav', 'dark_mobile_sub_background' );

			if ( ! empty( $settings['dark_mobile_color'] ) ) {
				$output .= '--mbnav-color :' . $settings['dark_mobile_color'] . ';';
			}
			if ( ! empty( $settings['dark_mobile_sub_color'] ) ) {
				$output .= '--submbnav-color :' . $settings['dark_mobile_sub_color'] . ';';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_mobile_header_var( $settings = array() ) {

			$output = '';
			if ( $this->get_mobile_header_var_data( $settings ) ) {
				$output .= ':root {';
				$output .= $this->get_mobile_header_var_data( $settings );
				$output .= '}';
			}

			if ( $this->get_mobile_header_var_data_dark( $settings ) ) {
				$output .= '[data-theme="dark"] {';
				$output .= $this->get_mobile_header_var_data_dark( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_global_var_data( $settings = array() ) {

			$output = '';
			if ( ! empty( $settings['privacy_bg_color'] ) ) {
				$output .= '--privacy-bg-color :' . $settings['privacy_bg_color'] . ';';
			}
			if ( ! empty( $settings['privacy_text_color'] ) ) {
				$output .= '--privacy-color :' . $settings['privacy_text_color'] . ';';
			}
			if ( ! empty( $settings['single_post_width_wo_sb'] ) ) {
				$output .= '--max-width-wo-sb : 860px;';
			}
			if ( ! empty( $settings['ad_top_bg'] ) ) {
				$output .= '--top-site-bg :' . $settings['ad_top_bg'] . ';';
			}
			if ( ! empty( $settings['custom_border'] ) ) {
				$settings['custom_border'] = absint( $settings['custom_border'] );
				$custom_small_border       = $settings['custom_border'] - 3;
				$custom_big_border         = $settings['custom_border'] + 5;

				if ( $custom_small_border < 2 ) {
					$custom_small_border = 2;
				}
				$output .= '--round-3 :' . $custom_small_border . 'px;';
				$output .= '--round-5 :' . $settings['custom_border'] . 'px;';
				$output .= '--round-7 :' . $custom_big_border . 'px;';
			} elseif ( ! empty( $settings['design_border'] ) ) {
				$output .= '--round-3 :0px;';
				$output .= '--round-5 :0px;';
				$output .= '--round-7 :0px;';
			}

			if ( ! empty( $settings['hyperlink_line'] ) ) {
				if ( empty( $settings['hyperlink_line_color'] ) ) {
					$settings['hyperlink_line_color'] = 'var(--g-color)';
				}
				if ( empty( $settings['dark_hyperlink_line_color'] ) ) {
					$settings['dark_hyperlink_line_color'] = 'var(--g-color)';
				}
			} else {
				unset( $settings['hyperlink_line_color'] );
				unset( $settings['dark_hyperlink_line_color'] );
			}
			if ( ! empty( $settings['hyperlink_color'] ) ) {
				$output .= '--hyperlink-color :' . $settings['hyperlink_color'] . ';';
			}
			if ( ! empty( $settings['hyperlink_line_color'] ) ) {
				$output .= '--hyperlink-line-color :' . $settings['hyperlink_line_color'] . ';';
			}
			if ( ! empty( $settings['hyperlink_style'] ) ) {
				switch ( $settings['hyperlink_style'] ) {
					case 'bold_italic' :
						$output .= '--hyperlink-weight :700;';
						$output .= '--hyperlink-style :italic;';
						break;
					case 'italic' :
						$output .= '--hyperlink-weight :400;';
						$output .= '--hyperlink-style :italic;';
						break;
					case 'bold' :
						$output .= '--hyperlink-weight :700;';
						break;
					case 'normal' :
						$output .= '--hyperlink-weight :400;';
						break;
				}
			}

			if ( ! empty( $settings['mobile_height'] ) ) {
				$output .= '--mbnav-height :' . $settings['mobile_height'] . 'px;';
			}
			if ( ! empty( $settings['footer_logo_height'] ) ) {
				$output .= '--flogo-height :' . $settings['footer_logo_height'] . 'px;';
			}
			if ( ! empty( $settings['single_post_entry_category_size'] ) ) {
				$output .= '--single-category-fsize :' . $settings['single_post_entry_category_size'] . 'px;';
			}
			/** heading */
			if ( ! empty( $settings['heading_color'] ) ) {
				$output .= '--heading-color :' . $settings['heading_color'] . ';';
			}
			if ( ! empty( $settings['heading_sub_color'] ) ) {
				$output .= '--heading-sub-color :' . $settings['heading_sub_color'] . ';';
			}
			/** wc */
			$output .= $this->font_var( $settings, 'price', 'font_price' );
			$output .= $this->font_var( $settings, 'product', 'font_product' );

			if ( ! empty( $settings['wc_price_color'] ) ) {
				$output .= '--wc-price-color :' . $settings['wc_price_color'] . ';';
			}
			if ( ! empty( $settings['wc_sale_color'] ) ) {
				$output .= '--wc-sale-bg :' . $settings['wc_sale_color'] . ';';
			}
			if ( ! empty( $settings['wc_star_color'] ) ) {
				$output .= '--wc-star-color :' . $settings['wc_star_color'] . ';';
			}
			if ( ! empty( $settings['wc_add_cart_color'] ) ) {
				$output .= '--wc-add-cart-bg :' . $settings['wc_add_cart_color'] . ';';
				$output .= '--wc-add-cart-bg-90 :' . $settings['wc_add_cart_color'] . 'e6;';
			}
			if ( ! empty( $settings['more_width'] ) ) {
				$output .= '--more-width :' . absint( $settings['more_width'] ) . 'px;';
			}
			if ( ! empty( $settings['slide_up_bg']['rgba'] ) ) {
				$output .= '--slideup-bg :' . $settings['slide_up_bg']['rgba'] . ';';
			}
			if ( ! empty( $settings['slide_up_icon_color'] ) ) {
				$output .= '--slideup-icon-color :' . $settings['slide_up_icon_color'] . ';';
			}
			if ( ! empty( $settings['slide_up_na_icon_color'] ) ) {
				$output .= '--slideup-icon-na-color :' . $settings['slide_up_na_icon_color'] . ';';
			}
			if ( ! empty( $settings['slide_up_na_icon_bg'] ) ) {
				$output .= '--slideup-icon-na-bg :' . $settings['slide_up_na_icon_bg'] . ';';
				$output .= '--slideup-icon-na-bg-90 :' . $settings['slide_up_na_icon_bg'] . 'e6;';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_global_var( $settings = array() ) {

			$output = '';
			if ( $this->get_global_var_data( $settings ) ) {
				$output .= ':root {';
				$output .= $this->get_global_var_data( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_categories_var( $settings = array() ) {

			$output            = '';
			$category_settings = get_option( 'foxiz_category_meta', array() );

			if ( ! empty( $settings['category_highlight_color'] ) || ! empty( $settings['category_color'] ) ) {
				$output .= '.p-category {';
				if ( ! empty( $settings['category_highlight_color'] ) && strlen( $settings['category_highlight_color'] ) > 3 ) {
					$output .= '--cat-highlight : ' . $settings['category_highlight_color'] . ';';
					$output .= '--cat-highlight-90 : ' . $settings['category_highlight_color'] . 'e6;';
				}
				if ( ! empty( $settings['category_color'] ) && strlen( $settings['category_color'] ) > 3 ) {
					$output .= '--cat-fcolor : ' . $settings['category_color'] . ';';
				}
				$output .= '}';
			}

			if ( ! empty( $settings['category_dark_highlight_color'] ) || ! empty( $settings['category_dark_color'] ) ) {
				$output .= '[data-theme="dark"] .p-category, .light-scheme .p-category {';
				if ( ! empty( $settings['category_dark_highlight_color'] ) && strlen( $settings['category_dark_highlight_color'] ) > 3 ) {
					$output .= '--cat-highlight : ' . $settings['category_dark_highlight_color'] . ';';
					$output .= '--cat-highlight-90 : ' . $settings['category_dark_highlight_color'] . 'e6;';
				}
				if ( ! empty( $settings['category_dark_color'] ) && strlen( $settings['category_dark_color'] ) > 3 ) {
					$output .= '--cat-fcolor : ' . $settings['category_dark_color'] . ';';
				}
				$output .= '}';
			}

			if ( ! empty( $settings['category_blog_heading_size'] ) ) {
				$output .= 'body.category .blog-content {';
				$output .= '--heading-size-desktop : ' . floatval( $settings['category_blog_heading_size'] ) . 'px;';
				$output .= '}';
			}

			foreach ( $category_settings as $id => $values ) {

				$highlight         = '';
				$dark_highlight    = '';
				$color             = '';
				$dark_color        = '';
				$title_size        = '';
				$title_size_mobile = '';
				$title_size_tablet = '';
				$ratio             = '';

				if ( ! empty( $values['highlight_color'] ) && strlen( $values['highlight_color'] ) > 3 ) {
					$highlight = $values['highlight_color'];
				}
				if ( ! empty( $values['dark_highlight_color'] ) && strlen( $values['dark_highlight_color'] ) > 3 ) {
					$dark_highlight = $values['dark_highlight_color'];
				}
				if ( ! empty( $values['color'] ) && strlen( $values['color'] ) > 3 ) {
					$color = $values['color'];
				}
				if ( ! empty( $values['dark_color'] ) && strlen( $values['dark_color'] ) > 3 ) {
					$dark_color = $values['dark_color'];
				}
				if ( ! empty( $values['title_size'] ) ) {
					$title_size = $values['title_size'];
				} elseif ( ! empty( $settings['category_title_size'] ) ) {
					$title_size = $settings['category_title_size'];
				}

				if ( ! empty( $values['title_size_mobile'] ) ) {
					$title_size_mobile = $values['title_size_mobile'];
				} elseif ( ! empty( $settings['category_title_size_mobile'] ) ) {
					$title_size_mobile = $settings['category_title_size_mobile'];
				}

				if ( ! empty( $values['title_size_tablet'] ) ) {
					$title_size_tablet = $values['title_size_tablet'];
				} elseif ( ! empty( $settings['category_title_size_table'] ) ) {
					$title_size_tablet = $settings['category_title_size_table'];
				}

				if ( ! empty( $values['display_ratio'] ) ) {
					$ratio = $values['display_ratio'];
				} elseif ( ! empty( $settings['category_display_ratio'] ) ) {
					$ratio = $settings['category_display_ratio'];
				}

				/** category color */
				if ( ! empty( $highlight ) || ( ! empty( $color ) && strlen( $color ) > 3 ) ) {
					$output .= '.p-category.category-id-' . $id . ', .meta-category .category-' . $id . ' {';
					if ( ! empty( $highlight ) ) {
						$output .= '--cat-highlight : ' . $highlight . ';';
						$output .= '--cat-highlight-90 : ' . $highlight . 'e6;';
					}
					if ( ! empty( $color ) && strlen( $color ) > 3 ) {
						$output .= '--cat-fcolor : ' . $color . ';';
					}
					$output .= '}';
				}

				if ( ! empty( $dark_highlight ) || ( ! empty( $dark_color ) && strlen( $dark_color ) > 3 ) ) {
					$output .= '[data-theme="dark"] .p-category.category-id-' . $id . ',';
					$output .= '.light-scheme .p-category.category-id-' . $id . '{';
					if ( ! empty( $dark_highlight ) && strlen( $dark_highlight ) > 3 ) {
						$output .= '--cat-highlight : ' . $dark_highlight . ';';
						$output .= '--cat-highlight-90 : ' . $dark_highlight . 'e6;';
					}
					if ( ! empty( $dark_color ) && strlen( $dark_color ) > 3 ) {
						$output .= '--cat-fcolor : ' . $dark_color . ';';
					}
					$output .= '}';
				}

				/** add heading color */
				if ( ! empty( $highlight ) ) {
					$output .= '.category-' . $id . ' .blog-content {';
					$output .= '--heading-sub-color : ' . $highlight . ';';
					$output .= '}';
				}
				if ( ! empty( $highlight ) && strlen( $highlight ) > 3 ) {
					$output .= '.is-cbox-' . $id . ' {';
					$output .= '--cbox-bg : ' . $highlight . 'e6;';
					$output .= '}';
				}

				if ( ! empty( $dark_highlight ) && strlen( $dark_highlight ) > 3 ) {
					$output .= '[data-theme="dark"] .is-cbox-' . $id . ' {';
					$output .= '--cbox-bg : ' . $dark_highlight . 'e6;';
					$output .= '}';
				}

				/** featured */
				if ( ! empty( $ratio ) ) {
					$output .= 'body.category-' . $id . ' .blog-content .p-featured {';
					$output .= 'padding-bottom : ' . floatval( $ratio ) . '%;';
					$output .= '}';
				}

				if ( ! empty( $values['blog_heading_size'] ) ) {
					$output .= 'body.category-' . $id . ' .blog-content {';
					$output .= '--heading-size-desktop : ' . floatval( $values['blog_heading_size'] ) . 'px;';
					$output .= '}';
				}

				/** category title font size */
				if ( ! empty( $title_size ) ) {
					$output .= 'body.category-' . $id . ' .blog-content {';
					$output .= '--title-size: ' . floatval( $title_size ) . 'px;';
					$output .= '}';
				}

				if ( ! empty( $title_size_tablet ) ) {
					$output .= '@media (max-width: 1024px){';
					$output .= 'body.category-' . $id . ' .blog-content {';
					$output .= '--title-size: ' . floatval( $title_size_tablet ) . 'px;';
					$output .= '}}';
				}

				if ( ! empty( $title_size_mobile ) ) {
					$output .= '@media (max-width: 767px){';
					$output .= 'body.category-' . $id . ' .blog-content {';
					$output .= '--title-size: ' . floatval( $title_size_mobile ) . 'px;';
					$output .= '}}';
				}
			}

			return $output;
		}

		/**
		 * @param $settings
		 *
		 * @return string
		 */
		function get_archive_var( $settings ) {

			$output = '';

			if ( ! empty( $settings['archive_title_size'] ) ) {
				$output .= '.archive .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['archive_title_size'] ) . 'px;';
				$output .= '}';
			}

			if ( ! empty( $settings['archive_title_size_tablet'] ) ) {
				$output .= '@media (max-width: 1024px){';
				$output .= '.archive .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['archive_title_size_tablet'] ) . 'px;';
				$output .= '}}';
			}
			if ( ! empty( $settings['archive_title_size_mobile'] ) ) {
				$output .= '@media (max-width: 767px){';
				$output .= '.archive .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['archive_title_size_mobile'] ) . 'px;';
				$output .= '}}';
			}

			/** search page */
			if ( ! empty( $settings['search_title_size'] ) ) {
				$output .= 'body.search .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['search_title_size'] ) . 'px;';
				$output .= '}';
			}
			if ( ! empty( $settings['search_title_size_tablet'] ) ) {
				$output .= '@media (max-width: 1024px){';
				$output .= 'body.search .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['search_title_size_tablet'] ) . 'px;';
				$output .= '}}';
			}

			if ( ! empty( $settings['search_title_size_mobile'] ) ) {
				$output .= '@media (max-width: 767px){';
				$output .= 'body.search .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['search_title_size_mobile'] ) . 'px;';
				$output .= '}}';
			}

			/** blog */
			if ( ! empty( $settings['blog_title_size'] ) ) {
				$output .= 'body.blog .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['blog_title_size'] ) . 'px;';
				$output .= '}';
			}
			if ( ! empty( $settings['blog_title_size_tablet'] ) ) {
				$output .= '@media (max-width: 1024px){';
				$output .= 'body.blog .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['blog_title_size_tablet'] ) . 'px;';
				$output .= '}}';
			}
			if ( ! empty( $settings['blog_title_size_mobile'] ) ) {
				$output .= '@media (max-width: 767px){';
				$output .= 'body.blog .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['blog_title_size_mobile'] ) . 'px;';
				$output .= '}}';
			}

			/** saved section */
			if ( ! empty( $settings['saved_title_size'] ) ) {
				$output .= '.saved-section .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['saved_title_size'] ) . 'px;';
				$output .= '}';
			}
			if ( ! empty( $settings['saved_title_size_tablet'] ) ) {
				$output .= '@media (max-width: 1024px){';
				$output .= '.saved-section .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['saved_title_size_tablet'] ) . 'px;';
				$output .= '}}';
			}
			if ( ! empty( $settings['saved_title_size_mobile'] ) ) {
				$output .= '@media (max-width: 767px){';
				$output .= '.saved-section .blog-content {';
				$output .= '--title-size: ' . floatval( $settings['saved_title_size_mobile'] ) . 'px;';
				$output .= '}}';
			}

			if ( ! empty( $settings['archive_display_ratio'] ) ) {
				$output .= 'body.archive:not(.author):not(.category) .blog-content .p-featured {';
				$output .= 'padding-bottom : ' . floatval( $settings['archive_display_ratio'] ) . '%;';
				$output .= '}';
			}

			if ( ! empty( $settings['search_display_ratio'] ) ) {
				$output .= 'body.search .blog-content .p-featured {';
				$output .= 'padding-bottom : ' . floatval( $settings['search_display_ratio'] ) . '%;';
				$output .= '}';
			}

			if ( ! empty( $settings['author_display_ratio'] ) ) {
				$output .= 'body.author .blog-content .p-featured {';
				$output .= 'padding-bottom : ' . floatval( $settings['author_display_ratio'] ) . '%;';
				$output .= '}';
			}

			if ( ! empty( $settings['blog_display_ratio'] ) ) {
				$output .= 'body.blog .blog-content .p-featured {';
				$output .= 'padding-bottom : ' . floatval( $settings['blog_display_ratio'] ) . '%;';
				$output .= '}';
			}

			if ( ! empty( $settings['saved_display_ratio'] ) ) {
				$output .= '.saved-section .blog-content .p-featured {';
				$output .= 'padding-bottom : ' . floatval( $settings['saved_display_ratio'] ) . '%;';
				$output .= '}';
			}

			if ( ! empty( $settings['recommended_display_ratio'] ) ) {
				$output .= '.rec-section .blog-content .p-featured {';
				$output .= 'padding-bottom : ' . floatval( $settings['recommended_display_ratio'] ) . '%;';
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param $settings
		 *
		 * @return string
		 */
		function get_heading_var( $settings ) {

			$output = '';
			if ( ! empty( $settings['single_post_related_blog_heading_size'] ) ) {
				$output .= '.single-related {';
				$output .= '--heading-size-desktop :' . floatval( $settings['single_post_related_blog_heading_size'] ) . 'px;';
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_global_var_dark_data( $settings = array() ) {

			$output = '';
			/** privacy box */
			if ( ! empty( $settings['dark_privacy_bg_color'] ) ) {
				$output .= '--privacy-bg-color :' . $settings['dark_privacy_bg_color'] . ';';
			}
			if ( ! empty( $settings['dark_privacy_text_color'] ) ) {
				$output .= '--privacy-color :' . $settings['dark_privacy_text_color'] . ';';
			}
			/** heading color */
			if ( ! empty( $settings['dark_heading_color'] ) ) {
				$output .= '--heading-color :' . $settings['dark_heading_color'] . ';';
			}
			if ( ! empty( $settings['dark_heading_sub_color'] ) ) {
				$output .= '--heading-sub-color :' . $settings['dark_heading_sub_color'] . ';';
			}
			if ( ! empty( $settings['ad_top_dark_bg'] ) ) {
				$output .= '--top-site-bg :' . $settings['ad_top_dark_bg'] . ';';
			}
			if ( ! empty( $settings['dark_hyperlink_color'] ) ) {
				$output .= '--hyperlink-color :' . $settings['dark_hyperlink_color'] . ';';
			}
			if ( ! empty( $settings['dark_hyperlink_line_color'] ) ) {
				$output .= '--hyperlink-line-color :' . $settings['dark_hyperlink_line_color'] . ';';
			}

			if ( ! empty( $settings['wc_dark_price_color'] ) ) {
				$output .= '--wc-price-color :' . $settings['wc_dark_price_color'] . ';';
			}
			if ( ! empty( $settings['wc_dark_star_color'] ) ) {
				$output .= '--wc-star-color :' . $settings['wc_dark_star_color'] . ';';
			}
			if ( ! empty( $settings['dark_slide_up_bg']['rgba'] ) ) {
				$output .= '--slideup-bg :' . $settings['dark_slide_up_bg']['rgba'] . ';';
			}
			if ( ! empty( $settings['dark_slide_up_icon_color'] ) ) {
				$output .= '--slideup-icon-color :' . $settings['dark_slide_up_icon_color'] . ';';
			}

			return $output;
		}

		/**
		 * @param $settings
		 *
		 * @return string
		 */
		function get_global_var_dark( $settings = array() ) {

			$output = '';
			if ( $this->get_global_var_dark_data( $settings ) ) {
				$output .= '[data-theme="dark"], .light-scheme {';
				$output .= $this->get_global_var_dark_data( $settings );
				$output .= '}';
			}

			return $output;
		}

		/**
		 * @param $settings
		 * @param $config_id
		 * @param false $font_size
		 *
		 * @return false|string
		 */
		function font_css( $settings, $config_id, $font_size = false ) {

			if ( empty( $settings[ $config_id ] ) || ! is_array( $settings[ $config_id ] ) ) {
				return false;
			}

			$setting = $settings[ $config_id ];

			if ( isset( $setting['google'] ) ) {
				unset ( $setting['google'] );
			}

			if ( isset( $setting['subsets'] ) ) {
				unset ( $setting['subsets'] );
			}
			if ( isset( $setting['font-options'] ) ) {
				unset ( $setting['font-options'] );
			}

			/** control font size via variable */
			if ( ! $font_size && isset( $setting['font-size'] ) ) {
				unset( $setting['font-size'] );
			}

			$output = '';

			if ( ! empty( $setting['font-backup'] ) && ! empty( $setting['font-family'] ) ) {
				$setting['font-family'] = $setting['font-family'] . ',' . $setting['font-backup'];
				unset ( $setting['font-backup'] );
			}

			foreach ( $setting as $key => $val ) {
				if ( '' !== trim( $val ) ) {
					$output .= $key . ':' . $val . ';';
				}
			}

			return $output;
		}

		/**
		 * @param array $settings
		 *
		 * @return string
		 */
		function get_dynamic_style( $settings = array() ) {

			$output = '';

			/** optimize css size for AMP */
			$font_breadcrumb_css = $this->font_css( $settings, 'font_breadcrumb' );
			$font_readmore_css   = $this->font_css( $settings, 'font_readmore' );

			$font_mobile_menu_css       = $this->font_css( $settings, 'font_mobile_menu', true );
			$font_sub_mobile_menu_css   = $this->font_css( $settings, 'font_mobile_sub_menu', true );
			$font_quick_access_menu_css = $this->font_css( $settings, 'font_quick_access_menu', true );

			if ( ! empty( $font_breadcrumb_css ) ) {
				$output .= '.breadcrumb-inner, .woocommerce-breadcrumb { ' . $font_breadcrumb_css . '}';
			}
			if ( ! empty( $font_readmore_css ) ) {
				$output .= '.p-readmore { ' . $font_readmore_css . '}';
			}
			if ( ! empty( $font_mobile_menu_css ) ) {
				$output .= '.mobile-menu > li > a  { ' . $font_mobile_menu_css . '}';
			}
			if ( ! empty( $font_sub_mobile_menu_css ) ) {
				$output .= '.mobile-menu .sub-menu a { ' . $font_sub_mobile_menu_css . '}';
			}
			if ( ! empty( $font_quick_access_menu_css ) ) {
				$output .= '.mobile-qview a { ' . $font_quick_access_menu_css . '}';
			}

			/**  background $search_header_bg */
			$search_header_bg      = $this->css_background( $settings, 'search_header_background' );
			$dark_search_header_bg = $this->css_background( $settings, 'dark_search_header_background' );
			if ( ! empty( $search_header_bg ) ) {
				$output .= '.search-header:before { ' . $search_header_bg . '}';
			}
			if ( ! empty( $dark_search_header_bg ) ) {
				$output .= '[data-theme="dark"] .search-header:before { ' . $dark_search_header_bg . '}';
			}

			$footer_bg      = $this->css_background( $settings, 'footer_background' );
			$dark_footer_bg = $this->css_background( $settings, 'dark_footer_background' );
			if ( ! empty( $footer_bg ) ) {
				$output .= '.footer-has-bg { ' . $footer_bg . '}';
			}
			if ( ! empty( $footer_bg ) ) {
				$output .= '[data-theme="dark"] .footer-has-bg { ' . $dark_footer_bg . '}';
			}
			if ( ! empty( $settings['ad_top_width'] ) ) {
				$output .= '.top-site-ad .ad-image { max-width: ' . intval( $settings['ad_top_width'] ) . 'px; }';
			}
			if ( ! empty( $settings['ad_single_width'] ) ) {
				$output .= '.single-inline-ad .ad-image { max-width: ' . intval( $settings['ad_top_width'] ) . 'px; }';
			}
			if ( ! empty( $settings['ad_top_dark_bg'] ) ) {
				$output .= '.yes-hd-transparent .top-site-ad {--top-site-bg :' . $settings['ad_top_dark_bg'] . ';}';
			}
			if ( ! empty( $settings['grid_box_1_box_color'] ) ) {
				$output .= '.grid-box {--box-color :' . $settings['grid_box_1_box_color'] . ';}';
			}
			if ( ! empty( $settings['grid_box_1_dark_box_color'] ) ) {
				$output .= '.grid-box {--dark-box-color :' . $settings['grid_box_1_dark_box_color'] . ';}';
			}
			if ( ! empty( $settings['list_box_1_box_color'] ) ) {
				$output .= '.list-box {--box-color :' . $settings['list_box_1_box_color'] . ';}';
			}
			if ( ! empty( $settings['list_box_1_dark_box_color'] ) ) {
				$output .= '.list-box {--dark-box-color :' . $settings['list_box_1_dark_box_color'] . ';}';
			}
			if ( ! empty( $settings['exclusive_label'] ) ) {
				$output .= '.entry-title.is-p-protected a:before {';
				$output .= 'content: "' . esc_html( $settings['exclusive_label'] ) . '";  display: inline-block;';
				$output .= '}';
			}
			if ( ! empty( $settings['footer_copyright_size'] ) ) {
				$output .= '.copyright-menu a { font-size:' . $settings['footer_copyright_size'] . 'px; }';
			}
			if ( ! empty( $settings['footer_copyright_text_size'] ) ) {
				$output .= '.copyright-inner .copyright { font-size:' . $settings['footer_copyright_text_size'] . 'px; }';
			}
			if ( ! empty( $settings['footer_columns_size'] ) ) {
				$output .= '.footer-col .widget_nav_menu a span { font-size:' . $settings['footer_columns_size'] . 'px; }';
			}
			if ( ! empty( $settings['light_switcher_color'] ) ) {
				$output .= '.svg-mode-light { color:' . $settings['light_switcher_color'] . '; }';
			}
			if ( ! empty( $settings['dark_switcher_bg'] ) ) {
				$output .= '.mode-icon-dark { background-color:' . $settings['dark_switcher_bg'] . '; }';
			}

			if ( ! empty( $settings['amp_footer_logo_height'] ) ) {
				$output .= '.amp-footer .footer-logo { height :' . $settings['amp_footer_logo_height'] . 'px; }';
			}
			if ( ! empty( $settings['remove_amp_switcher'] ) ) {
				$output .= '#amp-mobile-version-switcher { display: none; }';
			}
			if ( ! empty( $settings['single_6_ratio'] ) ) {
				$output .= '.single .featured-vertical { padding-bottom: ' . absint( $settings['single_6_ratio'] ) . '%; }';
			}

			if ( ! empty( $settings['header_search_custom_icon']['url'] ) ) {
				if ( foxiz_is_svg( $settings['header_search_custom_icon']['url'] ) ) {
					$output .= '.search-icon-svg { -webkit-mask-image: url(' . esc_url( $settings['header_search_custom_icon']['url'] ) . ');';
					$output .= 'mask-image: url(' . esc_url( $settings['header_search_custom_icon']['url'] ) . ');';
					$output .= ' }';
				} else {
					/** image fallback */
					$output .= '.search-icon-svg { background-image: url(' . esc_url( $settings['header_search_custom_icon']['url'] ) . ');';
					$output .= ' background-size: cover; background-color: transparent;';
					$output .= ' }';
				}

				if ( ! empty( $settings['header_search_custom_icon_size'] ) ) {
					$output .= '.search-btn > .search-icon-svg { font-size: ' . floatval( $settings['header_search_custom_icon_size'] ) . 'px;}';
				}
			}

			if ( ! empty( $settings['cart_custom_icon']['url'] ) ) {
				if ( foxiz_is_svg( $settings['cart_custom_icon']['url'] ) ) {
					$output .= '.cart-icon-svg { -webkit-mask-image: url(' . esc_url( $settings['cart_custom_icon']['url'] ) . ');';
					$output .= 'mask-image: url(' . esc_url( $settings['cart_custom_icon']['url'] ) . ');';
					$output .= ' }';
				} else {
					$output .= '.cart-icon-svg { background-image: url(' . esc_url( $settings['cart_custom_icon']['url'] ) . ');';
					$output .= ' background-size: cover; background-color: transparent;';
					$output .= ' }';
				}
				if ( ! empty( $settings['cart_custom_icon_size'] ) ) {
					$output .= '.cart-icon-svg { font-size: ' . floatval( $settings['cart_custom_icon_size'] ) . 'px;}';
				}
			}

			if ( ! empty( $settings['notification_custom_icon']['url'] ) ) {
				if ( foxiz_is_svg( $settings['notification_custom_icon']['url'] ) ) {
					$output .= '.notification-icon-svg { -webkit-mask-image: url(' . esc_url( $settings['notification_custom_icon']['url'] ) . ');';
					$output .= 'mask-image: url(' . esc_url( $settings['notification_custom_icon']['url'] ) . ');';
					$output .= ' }';
				} else {
					$output .= '.notification-icon-svg { background-image: url(' . esc_url( $settings['notification_custom_icon']['url'] ) . ');';
					$output .= ' background-size: cover; background-color: transparent;';
					$output .= ' }';
				}
				if ( ! empty( $settings['notification_custom_icon_size'] ) ) {
					$output .= '.notification-icon-svg { font-size: ' . floatval( $settings['notification_custom_icon_size'] ) . 'px;}';
				}
			}

			if ( ! empty( $settings['login_custom_icon']['url'] ) ) {
				if ( foxiz_is_svg( $settings['login_custom_icon']['url'] ) ) {
					$output .= '.login-icon-svg { -webkit-mask-image: url(' . esc_url( $settings['login_custom_icon']['url'] ) . ');';
					$output .= 'mask-image: url(' . esc_url( $settings['login_custom_icon']['url'] ) . ');';
					$output .= ' }';
				} else {
					$output .= '.login-icon-svg { background-image: url(' . esc_url( $settings['login_custom_icon']['url'] ) . ');';
					$output .= ' background-size: cover; background-color: transparent;';
					$output .= ' }';
				}
				if ( ! empty( $settings['login_custom_icon_size'] ) ) {
					$output .= '.login-icon-svg { font-size: ' . floatval( $settings['login_custom_icon_size'] ) . 'px;}';
				}
			}

			/** menus */
			$menus = wp_get_nav_menus();
			if ( ! empty( $menus ) ) {
				foreach ( $menus as $menu ) {
					$menu_id       = $menu->term_id;
					$menu_settings = get_option( 'rb_menu_settings_' . $menu_id, array() );
					if ( count( $menu_settings ) ) {
						foreach ( $menu_settings as $item_id => $item_data ) {
							if ( ! empty( $item_data['sub_label_color'] ) ) {
								$output .= '.menu-item-' . esc_attr( $item_id ) . ' span.menu-sub-title { color: ' . esc_attr( $item_data['sub_label_color'] ) . ' !important;}';
							}
							if ( ! empty( $item_data['sub_label_bg'] ) ) {
								$output .= '.menu-item-' . esc_attr( $item_id ) . ' span.menu-sub-title { background-color: ' . esc_attr( $item_data['sub_label_bg'] ) . ';}';
							}
							if ( ! empty( $item_data['sub_label_dark_color'] ) ) {
								$output .= '[data-theme="dark"] .menu-item-' . esc_attr( $item_id ) . ' span.menu-sub-title { color: ' . esc_attr( $item_data['sub_label_dark_color'] ) . ' !important;}';
							}
							if ( ! empty( $item_data['sub_label_dark_bg'] ) ) {
								$output .= '[data-theme="dark"] .menu-item-' . esc_attr( $item_id ) . ' span.menu-sub-title { background-color: ' . esc_attr( $item_data['sub_label_dark_bg'] ) . ';}';
							}
						}
					}
				}
			}

			return $output;
		}

		/**
		 * @return string
		 * generate CSS
		 */
		function output() {

			$output = $this->get_typography_var( $this->settings );
			$output .= $this->get_font_size_tablet( $this->settings );
			$output .= $this->get_font_size_mobile( $this->settings );
			$output .= $this->get_colors_var( $this->settings );
			$output .= $this->get_header_1_var( $this->settings );
			$output .= $this->get_header_4_var( $this->settings );
			$output .= $this->get_header_5_var( $this->settings );
			$output .= $this->get_mobile_header_var( $this->settings );
			$output .= $this->get_archive_var( $this->settings );
			$output .= $this->get_categories_var( $this->settings );
			$output .= $this->get_heading_var( $this->settings );
			$output .= $this->get_global_var( $this->settings );
			$output .= $this->get_global_var_dark( $this->settings );
			$output .= $this->get_dynamic_style( $this->settings );

			return $this->minify_css( $output );
		}

	}
}

/** load */
Foxiz_Css::get_instance();

