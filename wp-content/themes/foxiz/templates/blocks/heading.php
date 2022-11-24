<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_heading' ) ) {
	/**
	 * @param $attrs
	 *
	 * @return string
	 * heading
	 */
	function foxiz_get_heading( $attrs = array() ) {

		$settings = wp_parse_args( $attrs, array(
			'uuid'          => '',
			'layout'        => '',
			'title'         => '',
			'link'          => array(),
			'html_tag'      => '',
			'tagline'       => '',
			'tagline_arrow' => '',
			'classes'       => ''
		) );

		if ( empty( $settings['title'] ) ) {
			return false;
		}

		if ( strpos( $settings['title'], '{category}' ) !== false && is_category() ) {
			$settings['title'] = str_replace( '{category}', get_queried_object()->name, $settings['title'] );
		} elseif ( strpos( $settings['title'], '{tag}' ) !== false && is_tag() ) {
			$settings['title'] = str_replace( '{tag}', get_queried_object()->name, $settings['title'] );
		} elseif ( strpos( $settings['title'], '{search}' ) !== false && is_search() ) {
			$settings['title'] = str_replace( '{search}', get_search_query( 's' ), $settings['title'] );
		} elseif ( strpos( $settings['title'], '{author}' ) !== false && is_author() ) {
			$settings['title'] = str_replace( '{author}', get_queried_object()->display_name, $settings['title'] );
		}

		$class_name = 'block-h';
		if ( empty( $settings['layout'] ) ) {
			$settings['layout'] = foxiz_get_option( 'heading_layout', 1 );
		}
		$class_name .= ' heading-layout-' . $settings['layout'];
		if ( ! empty( $settings['color_scheme'] ) ) {
			$class_name .= ' light-scheme';
		}

		$title_class_name = 'heading-title';
		if ( ! empty( $settings['classes'] ) ) {
			$title_class_name .= ' ' . $settings['classes'];
		}
		if ( empty( $settings['html_tag'] ) ) {
			$settings['html_tag'] = 'h3';
		}

		$output = '<div';
		if ( ! empty( $settings['uuid'] ) ) {
			$output .= ' id="' . esc_attr( $settings['uuid'] ) . '"';
		}
		$output .= ' class="' . esc_attr( $class_name ) . '">';
		$output .= '<div class="heading-inner">';
		$output .= '<' . $settings['html_tag'] . ' class="' . esc_attr( $title_class_name ) . '">';
		if ( ! empty( $settings['link']['url'] ) ) {
			$output .= foxiz_render_elementor_link( $settings['link'], $settings['title'] );
		} else {
			$output .= '<span>' . wp_kses( $settings['title'], 'foxiz' ) . '</span>';
		}
		$output .= '</' . $settings['html_tag'] . '>';

		if ( ! empty( $settings['tagline'] ) ) {
			$output .= '<div class="heading-tagline h6">';
			if ( ! empty( $settings['link']['url'] ) ) {
				$output .= foxiz_render_elementor_link( $settings['link'], $settings['tagline'], 'heading-tagline-label' );
			} else {
				$output .= '<span class="heading-tagline-label">' . esc_html( $settings['tagline'] ) . '</span>';
			}
			if ( ! empty( $settings['tagline_arrow'] ) ) {
				$output .= '<i class="rbi rbi-cright heading-tagline-icon"></i>';
			}
			$output .= '</div>';
		}

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_start_widget_heading' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return string
	 */
	function foxiz_get_start_widget_heading( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'layout'   => '',
			'html_tag' => ''
		) );

		$class_name = 'block-h widget-heading';
		$class_name .= ' heading-layout-' . $settings['layout'];
		if ( empty( $settings['html_tag'] ) ) {
			$settings['html_tag'] = 'h4';
		}

		$output = '<div';
		$output .= ' class="' . esc_attr( $class_name ) . '">';
		$output .= '<div class="heading-inner">';
		$output .= '<' . $settings['html_tag'] . ' class="heading-title"><span>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_end_widget_heading' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return string
	 */
	function foxiz_get_end_widget_heading( $settings = array() ) {

		if ( empty( $settings['html_tag'] ) ) {
			$settings['html_tag'] = 'h4';
		}
		$output = '</span></' . $settings['html_tag'] . '>';
		$output .= '</div></div>';

		return $output;
	}
}