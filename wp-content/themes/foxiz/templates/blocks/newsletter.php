<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_newsletter' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return string
	 */
	function foxiz_get_newsletter( $settings = array() ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h2';
		}

		$classes = array();

		$classes[] = 'newsletter-box newsletter-style';

		if ( empty( $settings['box_style'] ) ) {
			$classes[] = 'is-box-shadow';
		} else {
			$classes[] = 'is-box-' . esc_attr( $settings['box_style'] );
		}
		if ( ! empty( $settings['color_scheme'] ) ) {
			$classes[] = 'light-scheme';
		}
		if ( ! empty( $settings['classes'] ) ) {
			$classes[] = $settings['classes'];
		}

		$output = '<div class="' . implode( ' ', $classes ) . '">';
		$output .= '<div class="newsletter-inner">';

		if ( ! empty( $settings['featured']['id'] ) ) {
			$featured = wp_get_attachment_image_src( $settings['featured']['id'], 'full' );
		}
		if ( ! empty( $featured[0] ) ) {
			$output .= '<div class="newsletter-featured">';
			if ( ! empty( $settings['dark_featured']['id'] ) ) {
				$dark_featured = wp_get_attachment_image_src( $settings['dark_featured']['id'], 'full' );
			}

			if ( ! empty( $dark_featured[0] ) ) {
				$output .= '<img data-mode="default" src="' . esc_url( $featured[0] ) . '" alt="' . esc_attr__( 'newsletter featured', 'foxiz' ) . '"';
				$output .= ' width="' . $featured[1] . '" height="' . $featured[2] . '">';
				$output .= '<img data-mode="dark" src="' . esc_url( $dark_featured[0] ) . '" alt="' . esc_attr__( 'newsletter featured', 'foxiz' ) . '"';
				$output .= ' width="' . $dark_featured[1] . '" height="' . $dark_featured[2] . '">';
			} else {
				$output .= '<img src="' . esc_url( $featured[0] ) . '" alt="' . esc_attr__( 'newsletter featured', 'foxiz' ) . '"';
				$output .= ' width="' . $featured[1] . '" height="' . $featured[2] . '">';
			}
			$output .= '</div>';
		}
		$output .= '<div class="newsletter-content">';
		if ( ! empty( $settings['title'] ) ) {
			$output .= '<' . $settings['title_tag'] . ' class="newsletter-title">' . wp_kses( $settings['title'], 'foxiz' );
			$output .= '</' . $settings['title_tag'] . '>';
		}
		if ( ! empty( $settings['description'] ) ) {
			$output .= '<p class="newsletter-description">' . wp_kses( $settings['description'], 'foxiz' ) . '</p>';
		}
		$output .= '</div>';
		$output .= '<div class="newsletter-form">';
		if ( ! empty( $settings['shortcode'] ) ) {
			$output .= do_shortcode( $settings['shortcode'] );
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}



if ( ! function_exists( 'foxiz_get_sidebar_newsletter' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return string
	 */
	function foxiz_get_sidebar_newsletter( $settings = array() ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h2';
		}

		$classes = array();
		$classes[] = 'newsletter-sb newsletter-style';

		if ( empty( $settings['box_style'] ) ) {
			$classes[] = 'is-box-gray-dash';
		} else {
			$classes[] = 'is-box-' . esc_attr( $settings['box_style'] );
		}
		if ( ! empty( $settings['color_scheme'] ) ) {
			$classes[] = 'light-scheme';
		}
		if ( ! empty( $settings['classes'] ) ) {
			$classes[] = $settings['classes'];
		}

		$output = '<div class="' . implode( ' ', $classes ). '">';
		$output .= '<div class="newsletter-sb-inner">';

		if ( ! empty( $settings['featured']['id'] ) ) {
			$featured = wp_get_attachment_image_src( $settings['featured']['id'], 'full' );
		}
		if ( ! empty( $featured[0] ) ) {
			$output .= '<div class="newsletter-sb-featured">';
			if ( ! empty( $settings['dark_featured']['id'] ) ) {
				$dark_featured = wp_get_attachment_image_src( $settings['dark_featured']['id'], 'full' );
			}
			if ( ! empty( $dark_featured[0] ) ) {
				$output .= '<img data-mode="default" src="' . esc_url( $featured[0] ) . '" alt="' . esc_attr__( 'newsletter featured', 'foxiz' ) . '"';
				$output .= ' width="' . $featured[1] . '" height="' . $featured[2] . '">';
				$output .= '<img data-mode="dark" src="' . esc_url( $dark_featured[0] ) . '" alt="' . esc_attr__( 'newsletter featured', 'foxiz' ) . '"';
				$output .= ' width="' . $dark_featured[1] . '" height="' . $dark_featured[2] . '">';
			} else {
				$output .= '<img src="' . esc_url( $featured[0] ) . '" alt="' . esc_attr__( 'newsletter featured', 'foxiz' ) . '"';
				$output .= ' width="' . $featured[1] . '" height="' . $featured[2] . '">';
			}
			$output .= '</div>';
		}

		if ( ! empty( $settings['title'] ) ) {
			$output .= '<' . $settings['title_tag'] . ' class="newsletter-title">' . esc_html( $settings['title'] );
			$output .= '</' . $settings['title_tag'] . '>';
		}
		if ( ! empty( $settings['description'] ) ) {
			$output .= '<p class="newsletter-description">' . $settings['description'] . '</p>';
		}
		$output .= '<div class="newsletter-sb-form">';
		if ( ! empty( $settings['shortcode'] ) ) {
			$output .= do_shortcode( $settings['shortcode'] );
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}