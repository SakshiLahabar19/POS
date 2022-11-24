<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ruby_Reaction', false ) ) {
	/**
	 * Class Ruby_Reaction
	 * post reactions
	 */
	class Ruby_Reaction {

		private static $instance;
		public $defaults = array();

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		/**
		 * Ruby_Reaction constructor.
		 */
		public function __construct() {

			self::$instance = $this;

			$this->register_reaction();

			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 10 );
			add_action( 'wp_ajax_nopriv_rb_add_reaction', array( $this, 'add_reaction' ) );
			add_action( 'wp_ajax_rb_add_reaction', array( $this, 'add_reaction' ) );
			add_action( 'wp_ajax_nopriv_rb_load_reaction', array( $this, 'get_reactions' ) );
			add_action( 'wp_ajax_rb_load_reaction', array( $this, 'get_reactions' ) );
			add_shortcode( 'ruby_reaction', array( $this, 'render' ) );
		}

		/**
		 * @return bool
		 *  check AMP
		 */
		public function is_amp() {

			if ( function_exists( 'foxiz_is_amp' ) ) {
				return foxiz_is_amp();
			}

			return false;
		}

		/**
		 * register scripts
		 */
		function register_scripts() {

			if ( ! $this->is_amp() ) {
				wp_register_script( 'rb-reaction', plugin_dir_url( __FILE__ ) . 'reaction.js', array( 'jquery' ), FOXIZ_CORE_VERSION, true );
			}
		}

		/**
		 * enqueue_scripts
		 */
		public function enqueue_scripts() {

			if ( ! wp_script_is( 'rb-reaction' ) ) {
				wp_enqueue_script( 'rb-reaction' );
			}
		}

		/**
		 * register_reaction
		 */
		function register_reaction() {

			$this->defaults = array(
				'love'      => array(
					'id'    => 'love',
					'title' => foxiz_html__( 'Love', 'foxiz-core' ),
					'icon'  => 'icon-love'
				),
				'sad'       => array(
					'id'    => 'sad',
					'title' => foxiz_html__( 'Sad', 'foxiz-core' ),
					'icon'  => 'icon-sad'
				),
				'happy'     => array(
					'id'    => 'happy',
					'title' => foxiz_html__( 'Happy', 'foxiz-core' ),
					'icon'  => 'icon-happy'
				),
				'sleepy'    => array(
					'id'    => 'sleepy',
					'title' => foxiz_html__( 'Sleepy', 'foxiz-core' ),
					'icon'  => 'icon-sleepy'
				),
				'angry'     => array(
					'id'    => 'angry',
					'title' => foxiz_html__( 'Angry', 'foxiz-core' ),
					'icon'  => 'icon-angry'
				),
				'dead'      => array(
					'id'    => 'dead',
					'title' => foxiz_html__( 'Dead', 'foxiz-core' ),
					'icon'  => 'icon-dead'
				),
				'wink'      => array(
					'id'    => 'wink',
					'title' => foxiz_html__( 'Wink', 'foxiz-core' ),
					'icon'  => 'icon-wink'
				),
				'cry'       => array(
					'id'    => 'cry',
					'title' => foxiz_html__( 'Cry', 'foxiz-core' ),
					'icon'  => 'icon-cry'
				),
				'embarrass' => array(
					'id'    => 'embarrass',
					'title' => foxiz_html__( 'Embarrass', 'foxiz-core' ),
					'icon'  => 'icon-embarrass'
				),
				'joy'       => array(
					'id'    => 'cry',
					'title' => foxiz_html__( 'Joy', 'foxiz-core' ),
					'icon'  => 'icon-joy'
				),
				'shy'       => array(
					'id'    => 'shy',
					'title' => foxiz_html__( 'Shy', 'foxiz-core' ),
					'icon'  => 'icon-shy'
				),
				'surprise'  => array(
					'id'    => 'surprise',
					'title' => foxiz_html__( 'Surprise', 'foxiz-core' ),
					'icon'  => 'icon-surprise'
				),
			);
		}

		/**
		 * @return string|string[]|null
		 * get IPs
		 */
		function get_ip() {

			if ( function_exists( 'foxiz_get_user_ip' ) ) {
				return foxiz_get_user_ip();
			} else {
				return '127.0.0.1';
			}
		}

		/**
		 * add reaction
		 */
		function add_reaction() {

			if ( empty( $_POST['uid'] ) || empty( $_POST['reaction'] ) || empty( $_POST['push'] ) ) {
				wp_send_json( '', null );
			}

			$current_user = get_current_user_id();
			if ( ! empty( $current_user ) ) {
				$user_ip = $current_user;
			} else {
				$user_ip = $this->get_ip();
			}

			$uid      = esc_attr( $_POST['uid'] );
			$reaction = esc_attr( $_POST['reaction'] );
			$push     = esc_attr( $_POST['push'] );

			$data = get_post_meta( $uid, 'ruby_reactions', true );

			if ( ! is_array( $data ) ) {
				$data = array();
			}

			if ( ! is_array( $data[ $reaction ] ) ) {
				$data[ $reaction ] = array();
			}

			if ( $push > 0 ) {
				$data[ $reaction ][] = $user_ip;
				$data[ $reaction ]   = array_unique( $data[ $reaction ] );
			} else {
				if ( ( $key = array_search( $user_ip, $data[ $reaction ] ) ) !== false ) {
					unset( $data[ $reaction ][ $key ] );
				}
			}

			update_post_meta( $uid, 'ruby_reactions', $data );
			wp_send_json( true, null );
		}

		/**
		 * load reactions
		 */
		function get_reactions() {

			if ( empty( $_POST['uid'] ) ) {
				wp_send_json( '', null );
			}

			$current_user = get_current_user_id();

			if ( ! empty( $current_user ) ) {
				$user_ip = $current_user;
			} else {
				$user_ip = $this->get_ip();
			}

			$uid      = esc_attr( $_POST['uid'] );
			$data     = get_post_meta( $uid, 'ruby_reactions', true );
			$response = array(
				'user' => array(),
				'data' => array(),
			);

			if ( is_array( $data ) ) {
				foreach ( $data as $reaction => $stored_data ) {
					$response['data'][ $reaction ] = count( $stored_data );
					if ( in_array( $user_ip, $stored_data ) ) {
						array_push( $response['user'], $reaction );
					}
				}
			}

			wp_send_json( $response, null );
		}

		/**
		 * @param $reaction
		 * @param $post_id
		 *
		 * @return int
		 * count reactions
		 */
		function count_reaction( $reaction, $post_id ) {

			$data = get_post_meta( $post_id, 'ruby_reactions', true );

			if ( ! empty( $data[ $reaction ] ) ) {
				return count( $data[ $reaction ] );
			} else {
				return 0;
			}
		}

		/**
		 * @param $attrs
		 *
		 * @return false|string
		 * render reactions
		 */
		function render( $attrs ) {

			if ( $this->is_amp() ) {
				return false;
			}

			$attrs = shortcode_atts( array(
				'id' => '',
			), $attrs );

			$post_id = $attrs['id'];

			if ( empty( $post_id ) ) {
				$post_id = get_the_ID();
			}

			if ( empty( $post_id ) ) {
				return false;
			}

			$this->enqueue_scripts();
			$output    = '';
			$reactions = $this->get_settings();

			if ( is_array( $reactions ) && count( $reactions ) ) {
				$output .= '<aside id="reaction-' . $post_id . '" class="rb-reaction reaction-wrap" data-reaction_uid="' . esc_attr( $post_id ) . '">';
				foreach ( $reactions as $reaction ) {
					if ( empty( $reaction['id'] ) ) {
						continue;
					}
					$output .= '<div class="reaction" data-reaction="' . $reaction['id'] . '" data-reaction_uid="' . esc_attr( $post_id ) . '">';
					$output .= '<span class="reaction-content">';
					$output .= '<i class="reaction-icon">' . $this->get_svg( $reaction['icon'] ) . '</i>';
					$output .= '<span class="reaction-title h6">' . esc_html( $reaction['title'] ) . '</span>';
					$output .= '</span>';
					$output .= '<span class="reaction-count">' . $this->count_reaction( $reaction['id'], $post_id ) . '</span>';
					$output .= '</div>';
				}

				$output .= '</aside>';
			}

			return $output;
		}

		/**
		 * @param $icon
		 *
		 * @return false|string
		 * get svg
		 */
		public function get_svg( $icon ) {

			if ( function_exists( 'foxiz_get_svg' ) ) {
				return foxiz_get_svg( $icon, '', 'reaction' );
			}

			return false;
		}

		/**
		 * @return false|mixed|void
		 * get settings
		 */
		public function get_settings() {

			if ( ! function_exists( 'foxiz_get_option' ) ) {
				return false;
			}

			$settings  = array();
			$reactions = foxiz_get_option( 'reaction_items' );

			if ( isset( $reactions['enabled']['placebo'] ) ) {
				unset( $reactions['enabled']['placebo'] );
			}

			if ( empty( $reactions['enabled'] ) || ! is_array( $reactions['enabled'] ) ) {
				return false;
			}

			foreach ( array_keys( $reactions['enabled'] ) as $reaction ) {
				if ( isset( $this->defaults[ $reaction ] ) ) {
					array_push( $settings, $this->defaults[ $reaction ] );
				}
			}

			return apply_filters( 'ruby_reactions', $settings );
		}
	}
}