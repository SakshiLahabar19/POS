<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_Ajax', false ) ) {
	class Foxiz_Ajax {

		private static $instance;
		public $style = '';

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_action( 'wp_ajax_nopriv_livep', array( $this, 'pagination' ) );
			add_action( 'wp_ajax_livep', array( $this, 'pagination' ) );
			add_action( 'wp_ajax_get_embed', array( $this, 'embed' ) );
			add_action( 'wp_ajax_nopriv_get_embed', array( $this, 'embed' ) );
			add_action( 'wp_ajax_nopriv_live_search', array( $this, 'live_search' ) );
			add_action( 'wp_ajax_live_search', array( $this, 'live_search' ) );
			add_action( 'wp_ajax_nopriv_liveb', array( $this, 'live_block' ) );
			add_action( 'wp_ajax_liveb', array( $this, 'live_block' ) );

			add_action( 'template_redirect', array( $this, 'load_next_redirect' ) );
		}

		public function pagination() {

			if ( empty( $_GET['data'] ) || empty( $_GET['data']['name'] ) ) {
				die( '-1' );
			}

			$settings                  = $this->validate( $_GET['data'] );
			$settings['no_found_rows'] = false;
			$paged                     = 2;

			if ( isset( $settings['page_next'] ) ) {
				$paged = absint( $settings['page_next'] );
			}
			if ( empty( $settings['posts_per_page'] ) ) {
				$settings['posts_per_page'] = get_option( 'posts_per_page' );
			}

			/** ajax for custom query */
			if ( ! empty( $settings['query_for_template'] ) ) {
				switch ( $settings['query_for_template'] ) {
					case 'related':
						$_query = foxiz_query_related( $settings, $paged );
						break;
					case 'recommended_interest':
						$settings['paged'] = $paged;
						$_query            = Foxiz_Bookmark::get_instance()->recommended_query( $settings );
						break;
				}
			} else {
				$_query = foxiz_query( $settings, $paged );
			}

			$response = array();
			if ( ! empty( $_query ) && $_query->have_posts() ) {
				if ( ! empty( $_query->paged ) ) {
					$response['paged'] = $_query->paged;
				} else {
					$response['paged'] = $paged;
				}
				if ( $response['paged'] >= $settings['page_max'] ) {
					$response['notice'] = $this->end_list_info();
				}
				$response['content'] = $this->render( $settings, $_query );
				wp_reset_postdata();
			} else {
				$response['paged']   = $settings['page_max'] + 99;
				$response['content'] = $this->end_list_info();
			}

			wp_send_json( $response, null );
		}

		/**
		 * @param $settings
		 *
		 * @return array|mixed|string
		 * validate input
		 */
		function validate( $settings ) {

			if ( is_array( $settings ) ) {
				foreach ( $settings as $key => $val ) {
					$key = sanitize_text_field( $key );
					if ( ! is_array( $settings[ $key ] ) ) {
						$settings[ $key ] = sanitize_text_field( $val );
					}
				}
			} elseif ( is_string( $settings ) ) {
				$settings = sanitize_text_field( $settings );
			} else {
				$settings = '';
			}

			return $settings;
		}

		/**
		 * @param $settings
		 * @param $_query
		 *
		 * @return false|string
		 * render
		 */
		function render( $settings, $_query ) {

			ob_start();
			$func = 'foxiz_loop_' . trim( $settings['name'] );

			if ( function_exists( $func ) ) {
				call_user_func_array( $func, array( $settings, $_query ) );
			}

			return ob_get_clean();
		}

		/**
		 * @return string
		 * end list info
		 */
		function end_list_info() {

			$output = '<div class="p-wrap end-list-info is-meta"><i class="rbi rbi-chart"></i><span>';
			$output .= foxiz_html__( 'You\'ve reached the end of the list!', 'foxiz' );
			$output .= '</span></div>';

			return $output;
		}

		/** get embed iframe */
		public function embed() {

			if ( empty( $_POST['data'] ) || empty( $_POST['data']['url'] ) ) {
				die( '-1' );
			}

			wp_send_json( wp_oembed_get( esc_url( $_POST['data']['url'] ), array(
				'height' => 450,
				'width'  => 800
			) ), null );
		}

		function load_next_redirect() {

			global $wp_query;
			if ( empty( $wp_query->query_vars['rbsnp'] ) || ! is_singular( 'post' ) ) {
				return;
			}
			$file     = '/templates/single/next-posts.php';
			$template = locate_template( $file );
			if ( $template ) {
				include( $template );
			}
			exit;
		}

		/** live search */
		function live_search() {

			if ( empty( $_GET['s'] ) ) {
				wp_send_json( '', null );
			}

			$input    = sanitize_text_field( $_GET['s'] );
			$_query   = new WP_Query( array(
					's'              => $input,
					'posts_per_page' => 4,
					'post_type'      => 'post',
					'post_status'    => 'publish'
				)
			);
			$response = '<div class="block-inner live-search-inner p-middle">';
			if ( $_query->have_posts() ) {
				ob_start();
				while ( $_query->have_posts() ) :
					$_query->the_post();
					foxiz_list_small_2(
						array(
							'featured_position' => 'left',
							'entry_meta'        => array( 'category' ),
							'middle_mode'       => '1',
							'edit_link'         => false,
							'bookmark'          => false,
						) );
				endwhile;
				$response .= ob_get_clean();
				$response .= '<div class="live-search-link"><a class="is-btn" href="' . get_search_link( $input ) . '">' . foxiz_html__( 'More Results', 'foxiz' ) . '</a></div>';
			} else {
				$response .= '<div class="live-search-no-result"><p>' . foxiz_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'foxiz' ) . '</p></div>';
			}

			$response .= '</div>';
			wp_send_json( $response, null );
		}

		/** load block in ajax */
		public function live_block() {

			if ( empty( $_GET['data'] ) || empty( $_GET['data']['name'] ) ) {
				die( '-1' );
			}

			$settings = $this->validate( $_GET['data'] );

			if ( ! empty( $settings['live_block'] ) && 'recommended' === $settings['live_block'] ) {
				$_query = Foxiz_Bookmark::get_instance()->recommended_query( $settings );
			} else {
				$_query = foxiz_query( $settings );
			}
			ob_start();
			$func = 'foxiz_live_block_' . trim( $settings['name'] );

			if ( function_exists( $func ) ) {
				call_user_func_array( $func, array( $settings, $_query ) );
			}

			wp_send_json( ob_get_clean(), null );
		}
	}
}
