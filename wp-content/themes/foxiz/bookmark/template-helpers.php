<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_bookmark' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false|string
	 * get bookmark
	 */
	function foxiz_get_bookmark( $post_id = '' ) {

		if ( foxiz_is_amp() ) {
			return false;
		}

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$output = '<span class="rb-bookmark bookmark-trigger"';
		if ( is_rtl() ) {
			$output .= ' dir="rtl"';
		}
		$output .= ' data-pid="' . $post_id . '">';
		$output .= '<i data-title="' . foxiz_html__( 'Save it', 'foxiz' ) . '" class="rbi rbi-bookmark"></i>';
		$output .= '<i data-title="' . foxiz_html__( 'Remove', 'foxiz' ) . '" class="bookmarked-icon rbi rbi-bookmark-fill"></i>';
		$output .= '</span>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_wologin_bookmark' ) ) {
	/**
	 * @param string $redirect
	 *
	 * @return false|string
	 */
	function foxiz_get_wologin_bookmark( $redirect = '' ) {

		if ( function_exists( 'foxiz_is_amp' ) && foxiz_is_amp() ) {
			return false;
		}

		$output = '<span class="rb-bookmark"';
		if ( is_rtl() ) {
			$output .= ' dir="rtl"';
		}
		$output .= ' data-title="' . foxiz_html__( 'Sign In to Save', 'foxiz' ) . '">';
		$output .= '<a class="login-toggle" href="' . wp_login_url( $redirect ) . '">';
		$output .= '<i class="rbi rbi-bookmark"></i>';
		$output .= '</a>';
		$output .= '</span>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_bookmark_trigger' ) ) {
	/**
	 * @param string $post_id
	 */
	function foxiz_bookmark_trigger( $post_id = '' ) {

		echo foxiz_get_bookmark_trigger( $post_id );
	}
}

if ( ! function_exists( 'foxiz_get_bookmark_trigger' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false|string
	 */
	function foxiz_get_bookmark_trigger( $post_id = '' ) {

		if ( foxiz_is_amp() || ! class_exists( 'Foxiz_Bookmark' ) || ! foxiz_get_option( 'bookmark_system' ) ) {
			return false;
		}

		$when = foxiz_get_option( 'bookmark_enable_when' );

		if ( empty( $when ) ) {
			return foxiz_get_bookmark( $post_id );
		}

		if ( 'ask_login' === $when && ! is_user_logged_in() ) {
			return foxiz_get_wologin_bookmark( foxiz_get_current_permalink() );
		} elseif ( is_user_logged_in() ) {
			return foxiz_get_bookmark( $post_id );
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_get_follow_trigger' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_follow_trigger( $settings = array() ) {

		if ( foxiz_is_amp() || ! class_exists( 'Foxiz_Bookmark' ) || ! foxiz_get_option( 'bookmark_system' ) ) {
			return false;
		}

		$when = foxiz_get_option( 'follow_enable_when' );

		if ( empty( $when ) ) {
			return foxiz_get_follow( $settings );
		}

		if ( 'ask_login' === $when && ! is_user_logged_in() ) {
			return foxiz_get_wologin_follow( $settings );
		} elseif ( is_user_logged_in() ) {
			return foxiz_get_follow( $settings );
		}

		if ( ! is_user_logged_in() ) {
			return foxiz_get_follow( $settings );
		}
	}
}

if ( ! function_exists( 'foxiz_get_follow' ) ) {
	function foxiz_get_follow( $settings = array() ) {

		$classes   = array();
		$classes[] = 'follow-button follow-trigger';

		if ( ! empty( $settings['classes'] ) ) {
			$classes[] = $settings['classes'];
		}
		if ( ! empty( $settings['type'] ) && 'author' === $settings['type'] ) {
			$attrs = 'data-uid="' . $settings['id'] . '"';
		} else {
			$attrs = 'data-cid="' . $settings['id'] . '"';
		}
		$output = '<a href="#" class="' . join( ' ', $classes ) . '" ' . $attrs . '>';
		$output .= '<i class="follow-icon rbi rbi-plus" data-title="' . foxiz_html__( 'Follow', 'foxiz' ) . '"></i>';
		$output .= '<i class="followed-icon rbi rbi-bookmark-fill" data-title="' . foxiz_html__( 'Unfollow', 'foxiz' ) . '"></i>';
		$output .= '</a>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_wologin_follow' ) ) {
	function foxiz_get_wologin_follow( $settings = array() ) {

		$classes   = array();
		$classes[] = 'follow-button login-toggle';
		if ( ! empty( $settings['classes'] ) ) {
			$classes[] = $settings['classes'];
		}

		$output = '<a href="' . wp_login_url( foxiz_get_current_permalink() ) . '" class="' . join( ' ', $classes ) . '">';
		$output .= '<i class="follow-icon rbi rbi-plus" data-title="' . foxiz_html__( 'Sign In to Follow', 'foxiz' ) . '"></i>';
		$output .= '</a>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_follow_trigger' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_follow_trigger( $settings = array() ) {

		echo foxiz_get_follow_trigger( $settings );
	}
}
