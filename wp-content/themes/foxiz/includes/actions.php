<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/** actions & filters */
add_action( 'init', 'foxiz_single_load_next_endpoint', 10 );
add_action( 'save_post', 'foxiz_update_metaboxes', 10, 1 );
add_filter( 'body_class', 'foxiz_set_body_classes', 20 );
add_action( 'foxiz_top_site', 'foxiz_render_privacy', 1 );
add_action( 'wp_footer', 'foxiz_footer_slide_up', 9 );
add_action( 'wp_footer', 'foxiz_popup_newsletter', 10 );
add_action( 'wp_footer', 'foxiz_adblock_popup', 11 );
add_action( 'wp_footer', 'foxiz_render_user_form_popup', 12 );
add_filter( 'get_archives_link', 'foxiz_archives_widget_span' );
add_filter( 'wp_list_categories', 'foxiz_cat_widget_span' );
add_filter( 'widget_tag_cloud_args', 'foxiz_widget_tag_cloud_args' );
add_filter( 'comment_form_defaults', 'foxiz_add_comment_placeholder', 10 );
add_filter( 'wp_kses_allowed_html', 'foxiz_kses_allowed_html', 10, 2 );

if ( ! function_exists( 'foxiz_single_load_next_endpoint' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_load_next_endpoint() {

		add_rewrite_endpoint( 'rbsnp', EP_PERMALINK );
		flush_rewrite_rules();

		return false;
	}
}

if ( ! function_exists( 'foxiz_add_comment_placeholder' ) ) {
	/**
	 * @param $defaults
	 *
	 * @return mixed
	 * add comment placeholder
	 */
	function foxiz_add_comment_placeholder( $defaults ) {

		if ( ! empty( $defaults['fields']['author'] ) ) {
			$defaults['fields']['author'] = str_replace( '<input', '<input placeholder="' . foxiz_html__( 'Your name', 'foxiz' ) . '"', $defaults['fields']['author'] );
		}
		if ( ! empty( $defaults['fields']['email'] ) ) {
			$defaults['fields']['email'] = str_replace( '<input', '<input placeholder="' . foxiz_html__( 'Your email', 'foxiz' ) . '"', $defaults['fields']['email'] );
		}

		if ( ! empty( $defaults['fields']['url'] ) ) {
			$defaults['fields']['url'] = str_replace( '<input', '<input placeholder="' . foxiz_html__( 'Your Website', 'foxiz' ) . '"', $defaults['fields']['url'] );
		}

		if ( ! empty( $defaults['comment_field'] ) ) {
			$defaults['comment_field'] = str_replace( '<textarea', '<textarea placeholder="' . foxiz_html__( 'Leave a comment', 'foxiz' ) . '"', $defaults['comment_field'] );
		}

		return $defaults;
	}
}

if ( ! function_exists( 'foxiz_get_js_settings' ) ) {
	/**
	 * @return array
	 */
	function foxiz_get_js_settings() {

		$settings              = foxiz_get_option();
		$params                = array();
		$params['ajaxurl']     = admin_url( 'admin-ajax.php' );
		$params['twitterName'] = foxiz_get_twitter_name();

		if ( is_single() ) {
			if ( ! empty( $settings['single_post_highlight_shares'] ) ) {
				$params['highlightShares'] = 1;
			}
			if ( ! empty( $settings['single_post_highlight_share_facebook'] ) ) {
				$params['highlightShareFacebook'] = 1;
			}
			if ( ! empty( $settings['single_post_highlight_share_twitter'] ) ) {
				$params['highlightShareTwitter'] = 1;
			}
			if ( ! empty( $settings['single_post_highlight_share_reddit'] ) ) {
				$params['highlightShareReddit'] = 1;
			}
		}
		if ( empty( $settings['slider_speed'] ) ) {
			$params['sliderSpeed'] = 5000;
		} else {
			$params['sliderSpeed'] = intval( $settings['slider_speed'] );
		}

		if ( ! empty( $settings['slider_effect'] ) ) {
			$params['sliderEffect'] = 'fade';
		} else {
			$params['sliderEffect'] = 'slide';
		}

		if ( ! empty( $settings['slider_fmode'] ) ) {
			$params['sliderFMode'] = true;
		} else {
			$params['sliderFMode'] = false;
		}

		return $params;
	}
}

if ( ! function_exists( 'foxiz_set_body_classes' ) ) {
	/**
	 * @param $classes
	 *
	 * @return mixed
	 */
	function foxiz_set_body_classes( $classes ) {

		$classes[] = 'menu-ani-' . trim( foxiz_get_option( 'menu_hover_effect', 1 ) );
		$classes[] = 'hover-ani-' . trim( foxiz_get_option( 'hover_effect', 1 ) );

		if ( foxiz_get_option( 'wc_responsive_list' ) ) {
			$classes[] = 'wc-res-list';
		}

		$header_style = foxiz_get_header_style();

		$classes[] = 'is-hd-' . $header_style;

		switch ( $header_style ) {
			case  't1' :
				$classes[] = 'yes-hd-transparent is-hd-1';
				break;
			case  't2' :
				$classes[] = 'yes-hd-transparent is-hd-2';
				break;
			case  't3' :
				$classes[] = 'yes-hd-transparent is-hd-3';
				break;
		}

		if ( is_single() ) {
			$classes[] = 'is-' . str_replace( '_', '-', foxiz_get_single_layout() );
		}

		if ( foxiz_get_option( 'back_top' ) ) {
			$classes[] = 'is-backtop';
		}

		if ( foxiz_get_option( 'exclusive_style' ) ) {
			$classes[] = 'exclusive-style-' . trim( foxiz_get_option( 'exclusive_style' ) );
		}

		if ( foxiz_get_option( 'sticky' ) ) {
			$classes[] = 'is-mstick';

			if ( foxiz_get_option( 'smart_sticky' ) ) {
				$classes[] = 'is-smart-sticky';
			}
		}

		if ( is_singular( 'post' ) && foxiz_get_option( 'single_post_sticky_title' ) ) {
			$classes[] = 'is-mstick';
			$classes[] = 'yes-tstick';
		}

		if ( foxiz_get_option( 'dark_mode_image_opacity' ) ) {
			$classes[] = 'dark-opacity';
		}
		if ( foxiz_get_option( 'ad_top_code' ) || foxiz_get_option( 'ad_top_image' ) ) {
			$classes[] = 'top-spacing';
		}

		return $classes;
	}
}

/**
 * add span tag for default categories widget
 */
if ( ! function_exists( 'foxiz_cat_widget_span' ) ) {
	function foxiz_cat_widget_span( $str ) {

		$pos = strpos( $str, '</a> (' );
		if ( false !== $pos ) {
			$str = str_replace( '</a> (', '<span class="count">', $str );
			$str = str_replace( ')', '</span></a>', $str );
		}

		return $str;
	}
};

/**
 * add span tag for default archive widget
 */
if ( ! function_exists( 'foxiz_archives_widget_span' ) ) {
	function foxiz_archives_widget_span( $str ) {

		$pos = strpos( $str, '</a>&nbsp;(' );
		if ( false !== $pos ) {
			$str = str_replace( '</a>&nbsp;(', '<span class="count">', $str );
			$str = str_replace( ')', '</span></a>', $str );
		}

		return $str;
	}
}

/**
 * @param $args
 *
 * @return mixed
 * tag filter
 */
if ( ! function_exists( 'foxiz_widget_tag_cloud_args' ) ) {
	function foxiz_widget_tag_cloud_args( $args ) {

		$args['largest']  = 1;
		$args['smallest'] = 1;

		return $args;
	}
}

if ( ! function_exists( 'foxiz_update_metaboxes' ) ) {
	/**
	 * @param $post_id
	 */
	function foxiz_update_metaboxes( $post_id ) {

		if ( foxiz_is_sponsored_post( $post_id ) ) {
			update_post_meta( $post_id, 'foxiz_sponsored', 1 );
		}

		$review = foxiz_get_review_settings( $post_id );
		if ( ! empty( $review['average'] ) ) {
			if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
				update_post_meta( $post_id, 'foxiz_review_average', $review['average'] );
			} else {
				update_post_meta( $post_id, 'foxiz_review_average', floatval( $review['average'] ) * 2 );
			}
		}
	}
}

/**
 * @param $tags
 * @param $context
 *
 * @return array|mixed
 */
if ( ! function_exists( 'foxiz_kses_allowed_html' ) ) {
	function foxiz_kses_allowed_html( $tags, $context ) {

		switch ( $context ) {
			case 'foxiz':
				$tags = array(
					'a'      => array(
						'href'   => array(),
						'title'  => array(),
						'target' => array(),
					),
					'br'     => array(),
					'em'     => array(),
					'strong' => array(),
					'i'      => array(
						'class' => array(),
					),
					'p'      => array(),
					'span'   => array(),
					'div'    => array(
						'class' => array(),
					),
				);

				return $tags;
			default:
				return $tags;
		}
	}
}