<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'rb_admin_get_template_part' ) ) {
	/**
	 * @param       $slug
	 * @param null  $name
	 * @param array $params
	 *
	 * @return bool|string
	 * load template
	 */
	function rb_admin_get_template_part( $slug, $name = null, $params = array() ) {

		$name = (string) $name;
		if ( '' !== $name ) {
			$template = "{$slug}-{$name}.php";
		} else {
			$template = "{$slug}.php";
		}
		$template = FOXIZ_CORE_PATH . $template;

		if ( file_exists( $template ) ) {
			if ( is_array( $params ) && count( $params ) ) {
				extract( $params, EXTR_SKIP );
			}

			ob_start();
			include( $template );

			return ob_get_clean();
		}

		return false;
	}

}

if ( ! function_exists( 'rb_admin_hide_code' ) ) {
	/**
	 * @param string $code
	 *
	 * @return bool|string
	 * hide purchase info
	 */
	function rb_admin_hide_code( $code = '' ) {
		if ( $code ) {
			return preg_replace( '[[a-z0-9]]', '*', substr( esc_attr( $code ), 0, - 9 ) ) . substr( esc_attr( $code ), - 9, 9 );
		}

		return false;
	}
}

