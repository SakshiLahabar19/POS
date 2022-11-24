<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_W_Follower', false ) ) :
	class Foxiz_W_Follower extends WP_Widget {

		private $params = array();
		private $widgetID = 'widget-follower';

		function __construct() {

			$this->params = array(
				'title'            => 'Stay Connected',
				'style'            => '',
				'facebook_page'    => '',
				'facebook_count'   => '',
				'twitter_user'     => '',
				'twitter_count'    => '',
				'pinterest_user'   => '',
				'pinterest_count'  => '',
				'instagram_user'   => '',
				'instagram_count'  => '',
				'youtube_link'     => '',
				'youtube_count'    => '',
				'telegram_link'    => '',
				'telegram_count'   => '',
				'soundcloud_user'  => '',
				'soundcloud_count' => '',
				'vimeo_user'       => '',
				'vimeo_count'      => '',
				'dribbble_user'    => '',
				'dribbble_count'   => '',
				'font_size'        => '',
			);

			parent::__construct( $this->widgetID, esc_html__( 'Foxiz - Widget Social Counter', 'foxiz-core' ), array(
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display your media socials with total of followers in the sidebars.', 'foxiz-core' )
			) );
		}

		function update( $new_instance, $old_instance ) {

			if ( current_user_can( 'unfiltered_html' ) ) {
				return wp_parse_args( (array) $new_instance, $this->params );
			} else {
				$instance = array();
				foreach ( $new_instance as $id => $value ) {
					$instance[ $id ] = sanitize_text_field( $value );
				}

				return wp_parse_args( $instance, $this->params );
			}
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'title' ),
				'name'  => $this->get_field_name( 'title' ),
				'title' => esc_html__( 'Title', 'foxiz-core' ),
				'value' => $instance['title']
			) );

			foxiz_create_widget_select_field( array(
				'id'      => $this->get_field_id( 'style' ),
				'name'    => $this->get_field_name( 'style' ),
				'title'   => esc_html__( 'Style', 'foxiz-core' ),
				'options' => array(
					'1'  => esc_html__( 'Style 1', 'foxiz-core' ),
					'2'  => esc_html__( 'Style 2', 'foxiz-core' ),
					'3'  => esc_html__( 'Style 3', 'foxiz-core' ),
					'4'  => esc_html__( 'Style 4', 'foxiz-core' ),
					'5'  => esc_html__( 'Style 5', 'foxiz-core' ),
					'6'  => esc_html__( 'Style 6', 'foxiz-core' ),
					'7'  => esc_html__( 'Style 7', 'foxiz-core' ),
					'8'  => esc_html__( 'Style 8', 'foxiz-core' ),
					'9'  => esc_html__( 'Style 9', 'foxiz-core' ),
					'10' => esc_html__( 'Style 10', 'foxiz-core' ),
					'11' => esc_html__( 'Style 11', 'foxiz-core' ),
					'12' => esc_html__( 'Style 12', 'foxiz-core' ),
					'13' => esc_html__( 'Style 13', 'foxiz-core' ),
					'14' => esc_html__( 'Style 14', 'foxiz-core' ),
					'15' => esc_html__( 'Style 15', 'foxiz-core' ),
				),
				'value'   => $instance['style'],
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_facebook' ),
				'name'  => $this->get_field_name( 'head_facebook' ),
				'title' => esc_html__( 'Facebook Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'facebook_page' ),
				'name'  => $this->get_field_name( 'facebook_page' ),
				'title' => esc_html__( 'FanPage Name', 'foxiz-core' ),
				'value' => $instance['facebook_page']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'facebook_count' ),
				'name'  => $this->get_field_name( 'facebook_count' ),
				'title' => esc_html__( 'Facebook Likes Value', 'foxiz-core' ),
				'value' => $instance['facebook_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_twitter' ),
				'name'  => $this->get_field_name( 'head_twitter' ),
				'title' => esc_html__( 'Twitter Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'twitter_user' ),
				'name'  => $this->get_field_name( 'twitter_user' ),
				'title' => esc_html__( 'Twitter Name', 'foxiz-core' ),
				'value' => $instance['twitter_user']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'twitter_count' ),
				'name'  => $this->get_field_name( 'twitter_count' ),
				'title' => esc_html__( 'Twitter Followers Value', 'foxiz-core' ),
				'value' => $instance['twitter_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_pinterest' ),
				'name'  => $this->get_field_name( 'head_pinterest' ),
				'title' => esc_html__( 'Pinterest Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'pinterest_user' ),
				'name'  => $this->get_field_name( 'pinterest_user' ),
				'title' => esc_html__( 'Pinterest Name', 'foxiz-core' ),
				'value' => $instance['pinterest_user']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'pinterest_count' ),
				'name'  => $this->get_field_name( 'pinterest_count' ),
				'title' => esc_html__( 'Pinterest Followers Value', 'foxiz-core' ),
				'value' => $instance['pinterest_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_instagram' ),
				'name'  => $this->get_field_name( 'head_instagram' ),
				'title' => esc_html__( 'Instagram Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'instagram_user' ),
				'name'  => $this->get_field_name( 'instagram_user' ),
				'title' => esc_html__( 'Instagram Name', 'foxiz-core' ),
				'value' => $instance['instagram_user']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'instagram_count' ),
				'name'  => $this->get_field_name( 'instagram_count' ),
				'title' => esc_html__( 'Instagram Followers Value', 'foxiz-core' ),
				'value' => $instance['instagram_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_youtube' ),
				'name'  => $this->get_field_name( 'head_youtube' ),
				'title' => esc_html__( 'Youtube Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'youtube_link' ),
				'name'  => $this->get_field_name( 'youtube_link' ),
				'title' => esc_html__( 'Youtube Channel or User URL', 'foxiz-core' ),
				'value' => $instance['youtube_link']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'youtube_count' ),
				'name'  => $this->get_field_name( 'youtube_count' ),
				'title' => esc_html__( 'Youtube Subscribers Value', 'foxiz-core' ),
				'value' => $instance['youtube_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_soundcloud' ),
				'name'  => $this->get_field_name( 'head_soundcloud' ),
				'title' => esc_html__( 'SoundCloud Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'soundcloud_user' ),
				'name'  => $this->get_field_name( 'soundcloud_user' ),
				'title' => esc_html__( 'Soundcloud User Name', 'foxiz-core' ),
				'value' => $instance['soundcloud_user']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'soundcloud_count' ),
				'name'  => $this->get_field_name( 'soundcloud_count' ),
				'title' => esc_html__( 'SoundCloud Followers Value', 'foxiz-core' ),
				'value' => $instance['soundcloud_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_telegram' ),
				'name'  => $this->get_field_name( 'head_telegram' ),
				'title' => esc_html__( 'Telegram Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'telegram_link' ),
				'name'  => $this->get_field_name( 'telegram_link' ),
				'title' => esc_html__( 'Telegram Channel or Invite URL', 'foxiz-core' ),
				'value' => $instance['telegram_link']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'telegram_count' ),
				'name'  => $this->get_field_name( 'telegram_count' ),
				'title' => esc_html__( 'Telegram Members Value', 'foxiz-core' ),
				'value' => $instance['telegram_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_vimeo' ),
				'name'  => $this->get_field_name( 'head_vimeo' ),
				'title' => esc_html__( 'Vimeo Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'vimeo_user' ),
				'name'  => $this->get_field_name( 'vimeo_user' ),
				'title' => esc_html__( 'Vimeo User Name', 'foxiz-core' ),
				'value' => $instance['vimeo_user']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'vimeo_count' ),
				'name'  => $this->get_field_name( 'vimeo_count' ),
				'title' => esc_html__( 'Vimeo Followers Value', 'foxiz-core' ),
				'value' => $instance['vimeo_count']
			) );

			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_dribbble' ),
				'name'  => $this->get_field_name( 'head_dribbble' ),
				'title' => esc_html__( 'Dribbble Settings', 'foxiz-core' )
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'dribbble_user' ),
				'name'  => $this->get_field_name( 'dribbble_user' ),
				'title' => esc_html__( 'Dribbble User Name', 'foxiz-core' ),
				'value' => $instance['dribbble_user']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'dribbble_count' ),
				'name'  => $this->get_field_name( 'dribbble_count' ),
				'title' => esc_html__( 'Dribbble Followers Value', 'foxiz-core' ),
				'value' => $instance['dribbble_count']
			) );
			foxiz_create_widget_heading_field( array(
				'id'    => $this->get_field_id( 'head_font_size' ),
				'name'  => $this->get_field_name( 'head_font_size' ),
				'title' => esc_html__( 'Font Size Settings', 'foxiz-core' )
			) );
			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'font_size' ),
				'name'  => $this->get_field_name( 'font_size' ),
				'title' => esc_html__( 'Widget Font Size', 'foxiz-core' ),
				'value' => $instance['font_size']
			) );
		}

		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			echo $args['before_widget'];

			if ( ! empty( $instance['font_size'] ) ) {
				echo '<style> [id="' . $args['widget_id'] . '"] .social-follower .follower-el .follower-inner {';
				echo 'font-size: ' . intval( $instance['font_size'] ) . 'px;';
				echo '} </style>';
			}
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . $instance['title'] . $args['after_title'];
			}
			echo rb_social_follower( $instance, $instance['style'] );

			echo $args['after_widget'];
		}
	}
endif;