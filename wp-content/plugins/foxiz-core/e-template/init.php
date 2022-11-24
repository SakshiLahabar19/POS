<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Rb_E_Template' ) ) {
	/**
	 * Class Rb_E_Template
	 */
	class Rb_E_Template {

		protected static $instance = null;

		static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function __construct() {

			self::$instance = $this;

			if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
				return false;
			}

			add_action( 'init', array( $this, 'register_post_type' ), 2 );
			add_action( 'elementor/init', array( $this, 'enable_support' ) );
			add_shortcode( 'Ruby_E_Template', array( $this, 'render' ) );
			add_action( 'add_meta_boxes', array( $this, 'shortcode_info' ) );
			add_filter( 'manage_rb-etemplate_posts_columns', array( $this, 'add_column' ) );
			add_action( 'manage_rb-etemplate_posts_custom_column', array( $this, 'column_shortcode_info' ), 10, 2 );
			add_filter( 'template_include', array( $this, 'template' ), 99 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ), 500 );
		}

		public function template( $template ) {

			global $post;
			if ( ! $post || ( 'rb-etemplate' !== get_post_type( $post ) ) ) {
				return $template;
			}

			$file_path = FOXIZ_CORE_PATH . 'e-template/single.php';
			if ( file_exists( $file_path ) ) {
				return $file_path;
			}
		}

		/**
		 * @param $attrs
		 *
		 * @return false|string
		 */
		function render( $attrs ) {

			$settings = shortcode_atts( array(
				'id'   => '',
				'slug' => ''
			), $attrs );

			if ( ( empty( $settings['id'] ) && empty( $settings['slug'] ) ) || ! class_exists( 'Elementor\Plugin' ) || ! did_action( 'elementor/loaded' ) ) {
				return false;
			}

			/** fallback to slug if empty ID */
			if ( empty( $settings['id'] ) && ! empty( $settings['slug'] ) ) {
				$ids = get_posts( array(
					'post_type'      => 'rb-etemplate',
					'posts_per_page' => 1,
					'name'           => $settings['slug'],
					'fields'         => 'ids',
				) );
				if ( ! empty( $ids[0] ) ) {
					$settings['id'] = $ids[0];
				}
			}

			if ( empty( $settings['id'] ) ) {
				return false;
			}

			return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings['id'] );
		}

		/**
		 * load style
		 */
		function enqueue_style() {

			if ( ! class_exists( '\Elementor\Core\Files\CSS\Post' ) || foxiz_is_amp() ) {
				return;
			}

			$shortcodes = array();
			if ( foxiz_get_option( 'header_template' ) ) {
				$shortcodes['header_template'] = foxiz_get_option( 'header_template' );
			}
			if ( foxiz_get_option( 'footer_template_shortcode' ) ) {
				$shortcodes[] = foxiz_get_option( 'footer_template_shortcode' );
			}
			if ( is_singular() || is_page() ) {

				if ( is_page_template( 'bookmark.php' ) ) {
					$shortcodes[] = foxiz_get_option( 'saved_template' );
				}
				$header = rb_get_meta( 'header_template', get_the_ID() );
				$footer = rb_get_meta( 'footer_template', get_the_ID() );
				if ( ! empty( $header ) ) {
					$shortcodes[] = $header;
					unset( $shortcodes['header_template'] );
				}
				if ( ! empty( $footer ) ) {
					$shortcodes[] = $footer;
				}
			}
			if ( is_category() ) {
				$cat_id            = get_queried_object_id();
				$category_settings = get_option( 'foxiz_category_meta', array() );

				if ( ! empty( $category_settings[ $cat_id ]['template'] ) ) {
					$shortcodes[] = $category_settings[ $cat_id ]['template'];
				} else {
					$shortcodes[] = foxiz_get_option( 'category_template' );
				}
				if ( ! empty( $category_settings[ $cat_id ]['template_global'] ) ) {
					$shortcodes[] = $category_settings[ $cat_id ]['template_global'];
				} elseif ( foxiz_get_option( 'category_template_global' ) ) {
					$shortcodes[] = foxiz_get_option( 'category_template_global' );
				}
				if ( foxiz_get_option( 'category_header_template' ) ) {
					$shortcodes[] = foxiz_get_option( 'category_header_template' );
					unset( $shortcodes['header_template'] );
				}
			} elseif ( is_search() ) {
				if ( foxiz_get_option( 'search_header_template' ) ) {
					$shortcodes[] = foxiz_get_option( 'search_header_template' );
					unset( $shortcodes['header_template'] );
				}
				if ( foxiz_get_option( 'search_template_global' ) ) {
					$shortcodes[] = foxiz_get_option( 'search_template_global' );
				}
			} elseif ( is_singular( 'post' ) ) {
				if ( foxiz_get_option( 'single_post_popular_shortcode' ) ) {
					$shortcodes[] = foxiz_get_option( 'single_post_related_shortcode' );
					$shortcodes[] = foxiz_get_option( 'single_post_popular_shortcode' );
				}
			} elseif ( is_home() ) {
				if ( foxiz_get_option( 'blog_header_template' ) ) {
					$shortcodes[] = foxiz_get_option( 'blog_header_template' );
					unset( $shortcodes['header_template'] );
				}
				if ( foxiz_get_option( 'blog_template' ) ) {
					$shortcodes[] = foxiz_get_option( 'blog_template' );
				}
				if ( foxiz_get_option( 'blog_template_bottom' ) ) {
					$shortcodes[] = foxiz_get_option( 'blog_template_bottom' );
				}
				if ( foxiz_get_option( 'blog_template_global' ) ) {
					$shortcodes[] = foxiz_get_option( 'blog_template_global' );
				}
			} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
				if ( foxiz_get_option( 'wc_shop_template' ) ) {
					$shortcodes[] = foxiz_get_option( 'wc_shop_template' );
				}
			}

			if ( count( $shortcodes ) ) {
				$elementor = \Elementor\Plugin::instance();
				$elementor->frontend->enqueue_styles();
				foreach ( $shortcodes as $shortcode ) {
					if ( ! empty( $shortcode ) ) {
						preg_match( '/' . get_shortcode_regex() . '/s', $shortcode, $matches );
						if ( ! empty( $matches[3] ) ) {
							$atts = shortcode_parse_atts( $matches[3] );
							if ( ! empty( $atts['id'] ) ) {
								$css_file = new \Elementor\Core\Files\CSS\Post( $atts['id'] );
								$css_file->enqueue();
							} elseif ( ! empty( $atts['slug'] ) ) {
								$ids = get_posts( array(
									'post_type'      => 'rb-etemplate',
									'posts_per_page' => 1,
									'name'           => $atts['slug'],
									'fields'         => 'ids',
								) );
								if ( ! empty( $ids[0] ) ) {
									$css_file = new \Elementor\Core\Files\CSS\Post( $ids[0] );
									$css_file->enqueue();
								}
							}
						}
					}
				}
			}
		}

		/** enable support for Elementor */
		function enable_support() {

			add_post_type_support( 'rb-etemplate', 'elementor' );
		}

		public function register_post_type() {

			register_post_type( 'rb-etemplate', array(
				'labels'              => array(
					'name'               => esc_html__( 'Ruby Templates', 'foxiz-core' ),
					'all_items'          => esc_html__( 'All Templates', 'foxiz-core' ),
					'menu_name'          => esc_html__( 'Ruby Templates', 'foxiz-core' ),
					'singular_name'      => esc_html__( 'Template', 'foxiz-core' ),
					'add_new'            => esc_html__( 'Add Template', 'foxiz-core' ),
					'add_item'           => esc_html__( 'New Template', 'foxiz-core' ),
					'add_new_item'       => esc_html__( 'Add New Template', 'foxiz-core' ),
					'new_item'           => esc_html__( 'Add New Template', 'foxiz-core' ),
					'edit_item'          => esc_html__( 'Edit Template', 'foxiz-core' ),
					'not_found'          => esc_html__( 'No template item found.', 'foxiz-core' ),
					'not_found_in_trash' => esc_html__( 'No template item found in Trash.', 'foxiz-core' ),
					'parent_item_colon'  => ''
				),
				'public'              => true,
				'has_archive'         => true,
				'can_export'          => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'menu_position'       => 5,
				'show_ui'             => true,
				'menu_icon'           => 'dashicons-art',
				'supports'            => array( 'title', 'editor' ),
			) );
		}

		function shortcode_info() {

			add_meta_box( 'rb_etemplate_info', 'Template Shortcode', array(
				$this,
				'render_info'
			), 'rb-etemplate', 'side', 'high' );
		}

		function render_info( $post ) { ?>
            <h4 style="margin-bottom:5px;">shortcode Text</h4>
            <input type='text' class='widefat' value='[Ruby_E_Template id="<?php echo $post->ID; ?>"]' readonly="">
			<?php
		}

		function add_column( $columns ) {

			$columns['rb_e_shortcode'] = esc_html__( 'Template Shortcode', 'foxiz-core' );

			return $columns;
		}

		function column_shortcode_info( $column, $post_id ) {

			if ( 'rb_e_shortcode' === $column ) {
				echo '<input type="text" class="widefat" value=\'[Ruby_E_Template id="' . $post_id . '"]\' readonly="">';
			}
		}
	}
}

/** LOAD */
Rb_E_Template::get_instance();