<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_user_socials' ) ) {
	/**
	 * @param string $author_id
	 *
	 * @return array|false
	 */
	function foxiz_get_user_socials( $author_id = '' ) {

		if ( empty( $author_id ) ) {
			return false;
		}

		$data               = array();
		$data['website']    = get_the_author_meta( 'user_url', $author_id );
		$data['facebook']   = get_the_author_meta( 'facebook', $author_id );
		$data['twitter']    = get_the_author_meta( 'twitter_url', $author_id );
		$data['instagram']  = get_the_author_meta( 'instagram', $author_id );
		$data['pinterest']  = get_the_author_meta( 'pinterest', $author_id );
		$data['linkedin']   = get_the_author_meta( 'linkedin', $author_id );
		$data['tumblr']     = get_the_author_meta( 'tumblr', $author_id );
		$data['flickr']     = get_the_author_meta( 'flickr', $author_id );
		$data['skype']      = get_the_author_meta( 'skype', $author_id );
		$data['snapchat']   = get_the_author_meta( 'snapchat', $author_id );
		$data['myspace']    = get_the_author_meta( 'myspace', $author_id );
		$data['youtube']    = get_the_author_meta( 'youtube', $author_id );
		$data['bloglovin']  = get_the_author_meta( 'bloglovin', $author_id );
		$data['digg']       = get_the_author_meta( 'digg', $author_id );
		$data['dribbble']   = get_the_author_meta( 'dribbble', $author_id );
		$data['soundcloud'] = get_the_author_meta( 'soundcloud', $author_id );
		$data['vimeo']      = get_the_author_meta( 'vimeo', $author_id );
		$data['reddit']     = get_the_author_meta( 'reddit', $author_id );
		$data['vkontakte']  = get_the_author_meta( 'vkontakte', $author_id );
		$data['telegram']   = get_the_author_meta( 'telegram', $author_id );
		$data['whatsapp']   = get_the_author_meta( 'whatsapp', $author_id );
		$data['rss']        = get_the_author_meta( 'rss', $author_id );

		return $data;
	}
}

if ( ! function_exists( 'foxiz_is_wc_pages' ) ) {
	function foxiz_is_wc_pages() {

		if ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_is_template_preview' ) ) {
	/**
	 * @return bool
	 */
	function foxiz_is_template_preview() {
		if ( ( class_exists( 'Elementor\Plugin' ) && Elementor\Plugin::$instance->editor->is_edit_mode() ) || is_singular( 'rb-etemplate' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_get_video_mine_type' ) ) {
	/**
	 * @param $url
	 *
	 * @return string
	 */
	function foxiz_get_video_mine_type( $url ) {

		/** set default */
		if ( empty( $url ) ) {
			return 'video/mp4';
		}

		if ( false !== strpos( $url, '.webm' ) ) {
			return 'video/webm';
		} elseif ( false !== strpos( $url, '.ogv' ) ) {
			return 'video/ogg';
		} elseif ( false !== strpos( $url, '.avi' ) ) {
			return 'video/avi';
		} elseif ( false !== strpos( $url, '.mpeg' ) || false !== strpos( $url, '.mpg' ) || false !== strpos( $url, '.mpe' ) ) {
			return 'video/mpeg';
		}

		return 'video/mp4';
	}
}

if ( ! function_exists( 'foxiz_get_current_permalink' ) ) {
	/**
	 * @return string|void
	 */
	function foxiz_get_current_permalink() {

		global $wp;

		return home_url( add_query_arg( array(), $wp->request ) );
	}
}
