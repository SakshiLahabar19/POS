<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_header_style' ) ) {
	/**
	 * @return false|mixed|string|void
	 */
	function foxiz_get_header_style() {

		$header_style   = foxiz_get_option( 'header_style' );
		$template_style = 'rb_template';

		if ( is_singular( 'post' ) ) {
			if ( rb_get_meta( 'header_template' ) ) {
				return $template_style;
			}
			$single_header_style = rb_get_meta( 'header_style' );
			if ( empty( $single_header_style ) || 'default' === (string) $single_header_style ) {
				$single_header_style = foxiz_get_option( 'single_post_header_style' );
			}
			if ( ! empty( $single_header_style ) && 'default' !== (string) $single_header_style ) {
				$header_style = $single_header_style;
			}
		} elseif ( is_page() ) {
			if ( rb_get_meta( 'header_template' ) ) {
				return $template_style;
			}
			$page_header_style = rb_get_meta( 'header_style' );
			if ( ! empty( $page_header_style ) && 'default' !== (string) $page_header_style ) {
				$header_style = $page_header_style;
			}
		} elseif ( is_category() ) {
			global $wp_query;
			$data        = get_option( 'foxiz_category_meta', array() );
			$category_id = $wp_query->get_queried_object_id();
			if ( ! empty( $data[ $category_id ]['header_template'] ) || foxiz_get_option( 'category_header_template' ) ) {
				return $template_style;
			}
			if ( ! empty( $data[ $category_id ]['header_style'] ) ) {
				$header_style = $data[ $category_id ]['header_style'];
			} else {
				if ( ! empty( $category_header_style ) ) {
					$header_style = $category_header_style;
				}
			}
		} elseif ( is_search() ) {
			if ( foxiz_get_option( 'search_header_template' ) ) {
				return $template_style;
			}
			$search_header_style = foxiz_get_option( 'search_header_style' );
			if ( ! empty( $search_header_style ) ) {
				$header_style = $search_header_style;
			}
		} elseif ( is_home() ) {
			if ( foxiz_get_option( 'blog_header_template' ) ) {
				return $template_style;
			}
			$blog_header_style = foxiz_get_option( 'blog_header_style' );
			if ( ! empty( $blog_header_style ) ) {
				$header_style = $blog_header_style;
			}
		}

		if ( empty( $header_style ) ) {
			$header_style = '1';
		}

		return $header_style;
	}
}

if ( ! function_exists( 'foxiz_get_header_settings' ) ) {
	/**
	 * @param $prefix
	 *
	 * @return array
	 * get header settings
	 */
	function foxiz_get_header_settings( $prefix ) {

		$prefix = trim( $prefix ) . '_';

		$settings = foxiz_get_option();

		$settings['more']       = foxiz_get_option( $prefix . 'more' );
		$settings['sub_scheme'] = foxiz_get_option( $prefix . 'sub_scheme' );
		$settings['nav_style']  = foxiz_get_option( $prefix . 'nav_style' );

		if ( is_singular() ) {
			$nav_style = rb_get_meta( 'nav_style' );
			if ( ! empty( $nav_style ) && 'default' !== $nav_style ) {
				$settings['nav_style'] = $nav_style;
			}
		} elseif ( is_category() ) {
			$nav_style = foxiz_get_option( 'category_nav_style' );
			if ( ! empty( $nav_style ) ) {
				$settings['nav_style'] = $nav_style;
			}
		} elseif ( is_search() ) {
			$nav_style = foxiz_get_option( 'search_nav_style' );
			if ( ! empty( $nav_style ) ) {
				$settings['nav_style'] = $nav_style;
			}
		} elseif ( is_home() ) {
			$nav_style = foxiz_get_option( 'blog_nav_style' );
			if ( ! empty( $nav_style ) ) {
				$settings['nav_style'] = $nav_style;
			}
		}
		$settings['header_socials'] = foxiz_get_option( $prefix . 'header_socials' );

		if ( empty( $settings['transprent_mobile_logo']['url'] ) ) {
			$settings['transprent_mobile_logo'] = foxiz_get_option( 'transparent_retina_logo' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_design_standard_block' ) ) {
	/**
	 * @param array $settings
	 * @param string $prefix
	 *
	 * @return array|mixed
	 * get module settings
	 */
	function foxiz_get_design_standard_block( $settings = array(), $prefix = '' ) {

		if ( ! empty( $settings['design_override'] ) ) {
			return $settings;
		}

		if ( '_' !== substr( $prefix, - 1 ) ) {
			$prefix = $prefix . '_';
		}
		if ( ! is_array( $settings ) ) {
			$settings = array();
		}

		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = foxiz_get_option( $prefix . 'crop_size' );
		}

		if ( empty( $settings['featured_position'] ) ) {
			$settings['featured_position'] = foxiz_get_option( $prefix . 'featured_position' );
		}

		if ( empty( $settings['entry_category'] ) ) {
			$settings['entry_category'] = foxiz_get_option( $prefix . 'entry_category' );
		} elseif ( '-1' === (string) $settings['entry_category'] ) {
			$settings['entry_category'] = false;
		}

		if ( empty( $settings['hide_category'] ) ) {
			$settings['hide_category'] = foxiz_get_option( $prefix . 'hide_category' );
		} elseif ( '-1' === (string) $settings['hide_category'] ) {
			$settings['hide_category'] = false;
		}

		if ( ! empty( $settings['entry_meta_bar'] ) && '-1' === (string) $settings['entry_meta_bar'] ) {
			$settings['entry_meta'] = [];
		} else {
			if ( empty( $settings['entry_meta_bar'] ) || 'custom' !== (string) $settings['entry_meta_bar'] ) {
				$settings['entry_meta'] = foxiz_get_option( $prefix . 'entry_meta' );
			} else {
				$settings['entry_meta'] = explode( ',', trim( strval( $settings['entry_meta'] ) ) );
				$settings['entry_meta'] = array_map( 'trim', $settings['entry_meta'] );
			}
		}
		if ( empty( $settings['tablet_hide_meta'] ) ) {
			$settings['tablet_hide_meta'] = foxiz_get_option( $prefix . 'tablet_hide_meta' );
		} else {
			if ( '-1' !== (string) $settings['tablet_hide_meta'] ) {
				$settings['tablet_hide_meta'] = explode( ',', trim( strval( $settings['tablet_hide_meta'] ) ) );
				$settings['tablet_hide_meta'] = array_map( 'trim', $settings['tablet_hide_meta'] );
			} else {
				$settings['tablet_hide_meta'] = false;
			}
		}
		if ( empty( $settings['mobile_hide_meta'] ) ) {
			$settings['mobile_hide_meta'] = foxiz_get_option( $prefix . 'mobile_hide_meta' );
		} else {
			if ( '-1' !== (string) $settings['mobile_hide_meta'] ) {
				$settings['mobile_hide_meta'] = explode( ',', trim( strval( $settings['mobile_hide_meta'] ) ) );
				$settings['mobile_hide_meta'] = array_map( 'trim', $settings['mobile_hide_meta'] );
			} else {
				$settings['mobile_hide_meta'] = false;
			}
		}
		if ( empty( $settings['review'] ) ) {
			$settings['review'] = foxiz_get_option( $prefix . 'review' );
		} elseif ( '-1' === (string) $settings['review'] ) {
			$settings['review'] = false;
		}

		if ( empty( $settings['review_meta'] ) ) {
			$settings['review_meta'] = foxiz_get_option( $prefix . 'review_meta' );
		} elseif ( '-1' === (string) $settings['review_meta'] ) {
			$settings['review_meta'] = false;
		}

		if ( empty( $settings['entry_format'] ) ) {
			$settings['entry_format'] = foxiz_get_option( $prefix . 'entry_format' );
		} elseif ( '-1' === (string) $settings['entry_format'] ) {
			$settings['entry_format'] = false;
		}

		if ( empty( $settings['bookmark'] ) ) {
			$settings['bookmark'] = foxiz_get_option( $prefix . 'bookmark' );
		} elseif ( '-1' === (string) $settings['bookmark'] ) {
			$settings['bookmark'] = false;
		}

		if ( empty( $settings['excerpt'] ) ) {
			$settings['excerpt_length'] = foxiz_get_option( $prefix . 'excerpt_length' );
			$settings['excerpt_source'] = foxiz_get_option( $prefix . 'excerpt_source' );
		}

		if ( empty( $settings['hide_excerpt'] ) ) {
			$settings['hide_excerpt'] = foxiz_get_option( $prefix . 'hide_excerpt' );
		} elseif ( '-1' === (string) $settings['hide_excerpt'] ) {
			$settings['hide_excerpt'] = false;
		}

		if ( empty( $settings['readmore'] ) ) {
			$settings['readmore'] = foxiz_get_option( $prefix . 'readmore' );
		} elseif ( '-1' === (string) $settings['readmore'] ) {
			$settings['readmore'] = false;
		}

		if ( ! empty( $settings['readmore'] ) ) {
			$settings['readmore'] = foxiz_get_option( 'readmore_label' );
			if ( empty( $settings['readmore'] ) ) {
				$settings['readmore'] = foxiz_html__( 'Read More', 'foxiz' );
			} else {
				/** make sure this string compatible with WPML plugins */
				$settings['readmore'] = apply_filters( 'the_title_rss', $settings['readmore'], 10 );
			}
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = foxiz_get_option( $prefix . 'title_tag' );
		}

		if ( empty( $settings['sub_title_tag'] ) ) {
			$settings['sub_title_tag'] = foxiz_get_option( $prefix . 'sub_title_tag' );
		}

		if ( empty( $settings['sub_sub_title_tag'] ) ) {
			$settings['sub_sub_title_tag'] = foxiz_get_option( $prefix . 'sub_sub_title_tag' );
		}

		if ( ! empty( $settings['sponsor_meta'] ) && '-1' === (string) $settings['sponsor_meta'] ) {
			$settings['sponsor_meta'] = false;
		} elseif ( empty( $settings['sponsor_meta'] ) ) {
			$settings['sponsor_meta'] = foxiz_get_option( $prefix . 'sponsor_meta' );
		}

		if ( empty( $settings['title_classes'] ) ) {
			$settings['title_classes'] = foxiz_get_option( $prefix . 'title_classes' );
		}
		if ( empty( $settings['counter'] ) ) {
			$settings['counter'] = foxiz_get_option( $prefix . 'counter' );
		} elseif ( '-1' === (string) $settings['counter'] ) {
			$settings['counter'] = false;
		}
		if ( empty( $settings['box_style'] ) ) {
			$settings['box_style'] = foxiz_get_option( $prefix . 'box_style' );
		}
		if ( empty( $settings['center_mode'] ) ) {
			$settings['center_mode'] = foxiz_get_option( $prefix . 'center_mode' );
		} elseif ( '-1' === (string) $settings['center_mode'] ) {
			$settings['center_mode'] = false;
		}
		if ( empty( $settings['middle_mode'] ) ) {
			$settings['middle_mode'] = foxiz_get_option( $prefix . 'middle_mode' );
		}
		if ( ! empty( $settings['slider'] ) && '-1' === (string) $settings['slider'] ) {
			$settings['slider'] = false;
		}
		if ( ! empty( $settings['carousel'] ) && '-1' === (string) $settings['carousel'] ) {
			$settings['carousel'] = false;
		}
		if ( ! empty( $settings['carousel_dot'] ) && '-1' === (string) $settings['carousel_dot'] ) {
			$settings['carousel_dot'] = false;
		}
		if ( ! empty( $settings['carousel_nav'] ) && '-1' === (string) $settings['carousel_nav'] ) {
			$settings['carousel_nav'] = false;
		}
		if ( empty( $settings['slider_play'] ) ) {
			$settings['slider_play'] = foxiz_get_option( 'slider_play' );
		} elseif ( '-1' === (string) $settings['slider_play'] ) {
			$settings['slider_play'] = false;
		}
		if ( empty( $settings['slider_speed'] ) ) {
			$settings['slider_speed'] = foxiz_get_option( 'slider_speed' );
		}
		if ( empty( $settings['slider_fmode'] ) ) {
			$settings['slider_fmode'] = foxiz_get_option( 'slider_fmode' );
		} elseif ( '-1' === (string) $settings['slider_fmode'] ) {
			$settings['slider_fmode'] = false;
		}

		/** disable carousel & sliders */
		if ( foxiz_is_amp() ) {
			$settings['carousel'] = false;
			$settings['slider']   = false;
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_design_builder_block' ) ) {
	/**
	 * @param $settings
	 * @param $prefix
	 *
	 * @return array|mixed
	 */
	function foxiz_get_design_builder_block( $settings ) {

		if ( ! is_array( $settings ) ) {
			$settings = array();
		}

		if ( ! empty( $settings['entry_category'] ) && '-1' === (string) $settings['entry_category'] ) {
			$settings['entry_category'] = false;
		}

		if ( ! empty( $settings['entry_format'] ) && '-1' === (string) $settings['entry_format'] ) {
			$settings['entry_format'] = false;
		}

		if ( ! empty( $settings['entry_meta'] ) ) {
			$settings['entry_meta'] = explode( ',', trim( strval( $settings['entry_meta'] ) ) );
			$settings['entry_meta'] = array_map( 'trim', $settings['entry_meta'] );
		}

		if ( ! empty( $settings['tablet_hide_meta'] ) ) {
			if ( '-1' !== (string) $settings['tablet_hide_meta'] ) {
				$settings['tablet_hide_meta'] = explode( ',', trim( strval( $settings['tablet_hide_meta'] ) ) );
				$settings['tablet_hide_meta'] = array_map( 'trim', $settings['tablet_hide_meta'] );
			} else {
				$settings['tablet_hide_meta'] = false;
			}
		}

		if ( ! empty( $settings['mobile_hide_meta'] ) ) {
			if ( '-1' !== (string) $settings['mobile_hide_meta'] ) {
				$settings['mobile_hide_meta'] = explode( ',', trim( strval( $settings['mobile_hide_meta'] ) ) );
				$settings['mobile_hide_meta'] = array_map( 'trim', $settings['mobile_hide_meta'] );
			} else {
				$settings['mobile_hide_meta'] = false;
			}
		}

		if ( ! empty( $settings['review'] ) && ( '-1' === (string) $settings['review'] ) ) {
			$settings['review'] = false;
		}

		if ( ! empty( $settings['review_meta'] ) && ( '-1' === (string) $settings['review_meta'] ) ) {
			$settings['review_meta'] = false;
		}

		if ( ! empty( $settings['bookmark'] ) && ( '-1' === (string) $settings['bookmark'] ) ) {
			$settings['bookmark'] = false;
		}

		if ( ! empty( $settings['counter'] ) && ( '-1' === (string) $settings['counter'] ) ) {
			$settings['counter'] = false;
		}
		if ( empty( $settings['readmore'] ) || '-1' === (string) $settings['readmore'] ) {
			$settings['readmore'] = false;
		} else {
			$settings['readmore'] = foxiz_get_option( 'readmore_label' );
			if ( empty( $settings['readmore'] ) ) {
				$settings['readmore'] = foxiz_html__( 'Read More', 'foxiz' );
			}
		}
		if ( ! empty( $settings['sponsor_meta'] ) && ( '-1' === (string) $settings['sponsor_meta'] ) ) {
			$settings['sponsor_meta'] = false;
		} elseif ( empty( $settings['sponsor_meta'] ) ) {
			$settings['sponsor_meta'] = 1;
		}
		if ( ! empty( $settings['center_mode'] ) && ( '-1' === (string) $settings['center_mode'] ) ) {
			$settings['center_mode'] = false;
		}
		if ( ! empty( $settings['slider'] ) && '-1' === (string) $settings['slider'] ) {
			$settings['slider'] = false;
		}
		if ( ! empty( $settings['carousel'] ) && '-1' === (string) $settings['carousel'] ) {
			$settings['carousel'] = false;
		}
		if ( ! empty( $settings['carousel_dot'] ) && '-1' === (string) $settings['carousel_dot'] ) {
			$settings['carousel_dot'] = false;
		}
		if ( ! empty( $settings['carousel_nav'] ) && '-1' === (string) $settings['carousel_nav'] ) {
			$settings['carousel_nav'] = false;
		}
		if ( empty( $settings['slider_play'] ) ) {
			$settings['slider_play'] = foxiz_get_option( 'slider_play' );
		} elseif ( '-1' === (string) $settings['slider_play'] ) {
			$settings['slider_play'] = false;
		}
		if ( empty( $settings['slider_speed'] ) ) {
			$settings['slider_speed'] = foxiz_get_option( 'slider_speed' );
		}
		if ( empty( $settings['slider_fmode'] ) ) {
			$settings['slider_fmode'] = foxiz_get_option( 'slider_fmode' );
		} elseif ( '-1' === (string) $settings['slider_fmode'] ) {
			$settings['slider_fmode'] = false;
		}

		/** disable carousel & sliders */
		if ( foxiz_is_amp() ) {
			$settings['carousel'] = false;
			$settings['slider']   = false;
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_is_featured_image' ) ) {
	/**
	 * @param string $size
	 *
	 * @return bool
	 * check featured image
	 */
	function foxiz_is_featured_image( $size = 'full' ) {

		if ( ! has_post_thumbnail() ) {
			return false;
		}
		$thumbnail = get_the_post_thumbnail( null, $size );
		if ( empty( $thumbnail ) ) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'foxiz_detect_dynamic_query' ) ) {
	/**
	 * @param $settings
	 *
	 * @return mixed
	 * foxiz_detect_query
	 */
	function foxiz_detect_dynamic_query( $settings ) {

		if ( ! empty( $settings['category'] ) && 'dynamic' === (string) $settings['category'] ) {
			if ( is_category() ) {
				global $wp_query;
				$settings['category'] = $wp_query->get_queried_object_id();
			}
		}

		if ( empty( $settings['unique'] ) || '-1' === (string) $settings['unique'] ) {
			$settings['unique'] = false;
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_single_setting' ) ) {
	/**
	 * @param $name
	 * @param string $opt_name
	 * @param string $post_id
	 *
	 * @return false|mixed|void
	 */
	function foxiz_get_single_setting( $name, $opt_name = '', $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$setting = rb_get_meta( $name, $post_id );

		if ( empty( $setting ) || 'default' === $setting ) {
			if ( empty( $opt_name ) ) {
				$opt_name = 'single_post_' . $name;
			}
			$setting = foxiz_get_option( $opt_name );
		}

		if ( ! is_array( $setting ) && '-1' === (string) $setting ) {
			return false;
		}

		return $setting;
	}
}

if ( ! function_exists( 'foxiz_is_review_post' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return bool
	 */
	function foxiz_is_review_post( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$review = rb_get_meta( 'review', $post_id );
		if ( empty( $review ) || '-1' === (string) $review ) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'foxiz_get_review_settings' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return array|false
	 */
	function foxiz_get_review_settings( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( ! foxiz_is_review_post( $post_id ) ) {
			return false;
		}

		$settings = array(
			'average'     => '',
			'title'       => rb_get_meta( 'review_title', $post_id ),
			'type'        => foxiz_get_single_setting( 'review_type' ),
			'criteria'    => rb_get_meta( 'review_criteria', $post_id ),
			'user'        => foxiz_get_single_setting( 'user_can_review' ),
			'image'       => foxiz_get_single_setting( 'review_image' ),
			'meta'        => rb_get_meta( 'review_meta', $post_id ),
			'pros'        => rb_get_meta( 'review_pros', $post_id ),
			'cons'        => rb_get_meta( 'review_cons', $post_id ),
			'summary'     => rb_get_meta( 'review_summary', $post_id ),
			'button'      => rb_get_meta( 'review_button', $post_id ),
			'destination' => rb_get_meta( 'review_destination', $post_id ),
			'price'       => rb_get_meta( 'review_price', $post_id ),
			'currency'    => rb_get_meta( 'review_currency', $post_id ),
			'schema'      => foxiz_get_single_setting( 'review_schema' ),
			'user_rating' => get_post_meta( $post_id, 'foxiz_user_rating', true )
		);

		if ( is_array( $settings['criteria'] ) ) {
			$index = 0;
			$total = 0;
			foreach ( $settings['criteria'] as $item ) {
				if ( ! empty( $item['rating'] ) ) {
					$value = floatval( $item['rating'] );
					if ( empty( $settings['type'] ) || 'star' === $settings['type'] ) {
						if ( $value > 5 ) {
							$value = 5;
						}
					} else {
						if ( $value > 10 ) {
							$value = 10;
						}
					}

					$total += $value;
					$index ++;
				}
			}

			if ( ! empty( $index ) && ! empty( $total ) ) {
				$settings['average'] = round( $total / $index, 1 );
			}
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_single_sidebar_position' ) ) {
	/**
	 * @param string $name
	 * @param string $opt_name
	 * @param string $post_id
	 *
	 * @return false|mixed|string|void
	 */
	function foxiz_get_single_sidebar_position( $name = 'sidebar_position', $opt_name = '', $post_id = '' ) {

		if ( foxiz_is_amp() && foxiz_get_option( 'amp_disable_single_sidebar' ) ) {
			return 'none';
		}

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$setting = '';
		if ( ! empty( $name ) ) {
			$setting = rb_get_meta( $name, $post_id );
		}

		if ( empty( $setting ) || 'default' === $setting ) {
			if ( empty( $opt_name ) ) {
				$opt_name = 'single_post_' . $name;
			}
			$setting = foxiz_get_option( $opt_name );
		}

		if ( empty( $setting ) || 'default' === $setting ) {
			$setting = foxiz_get_option( 'global_sidebar_position' );
		}

		return $setting;
	}
}

if ( ! function_exists( 'foxiz_get_single_layout' ) ) {
	/**
	 * @return false|mixed|void
	 */
	function foxiz_get_single_layout() {

		$post_format = get_post_format( get_the_ID() );
		switch ( $post_format ) {
			case 'video' :
				$layout = foxiz_get_single_setting( 'video_layout' );

				break;
			case 'audio' :
				$layout = foxiz_get_single_setting( 'audio_layout' );

				break;
			case 'gallery' :
				$layout = foxiz_get_single_setting( 'gallery_layout' );

				break;
			default:
				$layout = foxiz_get_single_setting( 'layout' );
		}

		if ( empty( $layout ) ) {
			$layout = 'standard_1';
		}

		return $layout;
	}
}

if ( ! function_exists( 'foxiz_is_sponsored_post' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return bool
	 */
	function foxiz_is_sponsored_post( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$sponsor = rb_get_meta( 'sponsor_post', $post_id );
		if ( ! empty( $sponsor ) && '1' === (string) $sponsor ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_get_related_data' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return WP_Query
	 */
	function foxiz_get_related_data( $settings = array() ) {

		$params = array(
			'no_found_rows' => true,
		);
		if ( ! empty( $settings['total'] ) ) {
			$params['posts_per_page'] = $settings['total'];
		}
		if ( ! empty( $settings['offset'] ) ) {
			$params['offset'] = $settings['offset'];
		}
		if ( ! empty( $settings['ids'] ) ) {
			$params['post_in'] = esc_attr( $settings['ids'] );
		}
		if ( ! empty( $settings['post_id'] ) ) {
			$params['post_id'] = esc_attr( $settings['post_id'] );
		}

		return foxiz_query_related( $params );
	}
}

if ( ! function_exists( 'foxiz_get_single_sticky_sidebar' ) ) {
	/**
	 * @param string $prefix
	 *
	 * @return bool
	 */
	function foxiz_get_single_sticky_sidebar( $prefix = 'single_post_' ) {

		$setting = foxiz_get_option( $prefix . 'sticky_sidebar' );
		if ( empty( $setting ) || 'default' === $setting ) {
			$setting = foxiz_get_option( 'sticky_sidebar' );
		};

		if ( '1' === (string) $setting ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_get_category_page_settings' ) ) {
	function foxiz_get_category_page_settings( $category_id = '' ) {

		if ( ! is_category() ) {
			return false;
		}

		if ( empty( $category_id ) ) {
			global $wp_query;
			$category_id = $wp_query->get_queried_object_id();
		}

		$prefix = 'category_';
		$data   = get_option( 'foxiz_category_meta', array() );
		if ( ! isset( $data[ $category_id ] ) ) {
			$data[ $category_id ] = array();
		}

		$settings                  = $data[ $category_id ];
		$settings['category']      = $category_id;
		$settings['category_name'] = get_cat_name( $category_id );
		$settings['uuid']          = 'uid_c' . $category_id;

		if ( empty( $settings['category_header'] ) ) {
			$settings['category_header'] = foxiz_get_option( $prefix . 'category_header' );
		}
		if ( empty( $settings['breadcrumb'] ) ) {
			$settings['breadcrumb'] = foxiz_get_option( $prefix . 'breadcrumb' );
		}

		if ( '-1' === (string) $settings['breadcrumb'] ) {
			$settings['breadcrumb'] = false;
		}

		if ( empty( $settings['featured_image'] ) || ! is_array( $settings['featured_image'] ) || ! count( $settings['featured_image'] ) ) {
			$settings['featured_image'] = foxiz_get_option( $prefix . 'featured_image' );
			if ( ! empty( $settings['featured_image'] ) ) {
				$settings['featured_image'] = explode( ',', $settings['featured_image'] );
			}
		}
		if ( empty( $settings['pattern'] ) ) {
			$settings['pattern'] = foxiz_get_option( $prefix . 'pattern' );
		}
		if ( empty( $settings['subcategory'] ) ) {
			$settings['subcategory'] = foxiz_get_option( $prefix . 'subcategory' );
		}
		if ( '-1' === (string) $settings['subcategory'] ) {
			$settings['subcategory'] = false;
		}

		if ( empty( $settings['template'] ) ) {
			$settings['template'] = foxiz_get_option( $prefix . 'template' );
		}
		if ( empty( $settings['template_display'] ) ) {
			$settings['template_display'] = foxiz_get_option( $prefix . 'template_display' );
		}
		if ( empty( $settings['template_global'] ) ) {
			$settings['template_global'] = foxiz_get_option( $prefix . 'template_global' );
		}
		if ( empty( $settings['blog_heading'] ) ) {
			$settings['blog_heading'] = foxiz_get_option( $prefix . 'blog_heading' );
		}

		if ( empty( $settings['blog_heading_layout'] ) ) {
			$settings['blog_heading_layout'] = foxiz_get_option( $prefix . 'blog_heading_layout' );
		}

		if ( empty( $settings['blog_heading_tag'] ) ) {
			$settings['blog_heading_tag'] = foxiz_get_option( $prefix . 'blog_heading_tag' );
		}

		if ( empty( $settings['posts_per_page'] ) ) {
			$settings['posts_per_page'] = foxiz_get_option( $prefix . 'posts_per_page' );
		}

		if ( empty( $settings['pagination'] ) ) {
			$settings['pagination'] = foxiz_get_option( $prefix . 'pagination' );
		}

		if ( empty( $settings['layout'] ) ) {
			$settings['layout'] = foxiz_get_option( $prefix . 'layout' );
		}

		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = foxiz_get_option( $prefix . 'columns' );
		}
		if ( empty( $settings['columns_tablet'] ) ) {
			$settings['columns_tablet'] = foxiz_get_option( $prefix . 'columns_tablet' );
		}
		if ( empty( $settings['columns_mobile'] ) ) {
			$settings['columns_mobile'] = foxiz_get_option( $prefix . 'columns_mobile' );
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = foxiz_get_option( $prefix . 'column_gap' );
		}
		if ( empty( $settings['sidebar_position'] ) ) {
			$settings['sidebar_position'] = foxiz_get_option( $prefix . 'sidebar_position' );
		}
		if ( empty( $settings['sidebar_name'] ) || 'default' === $settings['sidebar_name'] ) {
			$settings['sidebar_name'] = foxiz_get_option( $prefix . 'sidebar_name' );
		}
		if ( empty( $settings['sticky_sidebar'] ) ) {
			$settings['sticky_sidebar'] = foxiz_get_option( $prefix . 'sticky_sidebar' );
			if ( empty( $settings['sticky_sidebar'] ) ) {
				$settings['sticky_sidebar'] = foxiz_get_option( 'sticky_sidebar' );
			}
		}

		if ( '-1' === (string) $settings['sticky_sidebar'] ) {
			$settings['sticky_sidebar'] = false;
		}

		/** blog design */
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = foxiz_get_option( $prefix . 'crop_size' );
		}
		if ( empty( $settings['entry_category'] ) ) {
			$settings['entry_category'] = foxiz_get_option( $prefix . 'entry_category' );
		}

		if ( empty( $settings['entry_meta_bar'] ) ) {
			$settings['entry_meta_bar'] = foxiz_get_option( $prefix . 'entry_meta_bar' );
			if ( ! empty( $settings['entry_meta_bar'] ) && 'custom' === $settings['entry_meta_bar'] ) {
				$settings['entry_meta'] = foxiz_get_option( $prefix . 'entry_meta' );
				if ( is_array( $settings['entry_meta'] ) ) {
					$settings['entry_meta'] = implode( ',', $settings['entry_meta'] );
				}
			}
		}

		if ( empty( $settings['review'] ) ) {
			$settings['review'] = foxiz_get_option( $prefix . 'review' );
		}
		if ( empty( $settings['review_meta'] ) ) {
			$settings['review_meta'] = foxiz_get_option( $prefix . 'review_meta' );
		}
		if ( empty( $settings['entry_format'] ) ) {
			$settings['entry_format'] = foxiz_get_option( $prefix . 'entry_format' );
		}
		if ( empty( $settings['bookmark'] ) ) {
			$settings['bookmark'] = foxiz_get_option( $prefix . 'bookmark' );
		}

		if ( empty( $settings['excerpt'] ) ) {
			$settings['excerpt'] = foxiz_get_option( $prefix . 'excerpt' );
			if ( ! empty( $settings['excerpt'] ) ) {
				$settings['excerpt_length'] = foxiz_get_option( $prefix . 'excerpt_length' );
				$settings['excerpt_source'] = foxiz_get_option( $prefix . 'excerpt_source' );
			}
		}
		if ( empty( $settings['readmore'] ) ) {
			$settings['readmore'] = foxiz_get_option( $prefix . 'readmore' );
		}
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = foxiz_get_option( $prefix . 'title_tag' );
		}
		if ( empty( $settings['hide_category'] ) ) {
			$settings['hide_category'] = foxiz_get_option( $prefix . 'hide_category' );
		}
		if ( empty( $settings['tablet_hide_meta'] ) ) {
			$settings['tablet_hide_meta'] = foxiz_get_option( $prefix . 'tablet_hide_meta' );
		}
		if ( empty( $settings['mobile_hide_meta'] ) ) {
			$settings['mobile_hide_meta'] = foxiz_get_option( $prefix . 'mobile_hide_meta' );
		}
		if ( empty( $settings['hide_excerpt'] ) ) {
			$settings['hide_excerpt'] = foxiz_get_option( $prefix . 'hide_excerpt' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_archive_page_settings' ) ) {
	/**
	 * @param string $prefix
	 * @param array $settings
	 *
	 * @return array|mixed
	 */
	function foxiz_get_archive_page_settings( $prefix = '', $settings = array() ) {

		if ( empty( $prefix ) ) {
			$prefix = 'archive_';
		}

		if ( empty( $settings['uuid'] ) ) {
			$settings['uuid'] = 'uid_' . $prefix . get_queried_object_id();
		}

		$settings['blog_heading']        = foxiz_get_option( $prefix . 'blog_heading' );
		$settings['blog_heading_layout'] = foxiz_get_option( $prefix . 'blog_heading_layout' );
		$settings['blog_heading_tag']    = foxiz_get_option( $prefix . 'blog_heading_tag' );

		$settings['pattern']          = foxiz_get_option( $prefix . 'pattern' );
		$settings['template']         = foxiz_get_option( $prefix . 'template' );
		$settings['template_bottom']  = foxiz_get_option( $prefix . 'template_bottom' );
		$settings['template_display'] = foxiz_get_option( $prefix . 'template_display' );
		$settings['template_global']  = foxiz_get_option( $prefix . 'template_global' );
		$settings['breadcrumb']       = foxiz_get_option( $prefix . 'breadcrumb' );
		$settings['posts_per_page']   = foxiz_get_option( $prefix . 'posts_per_page' );
		if ( empty( $settings['posts_per_page'] ) ) {
			$settings['posts_per_page'] = get_option( 'posts_per_page' );
		}
		$settings['pagination'] = foxiz_get_option( $prefix . 'pagination' );
		if ( empty( $settings['pagination'] ) ) {
			$settings['pagination'] = 'number';
		}

		$settings['layout']           = foxiz_get_option( $prefix . 'layout' );
		$settings['columns']          = foxiz_get_option( $prefix . 'columns' );
		$settings['columns_tablet']   = foxiz_get_option( $prefix . 'columns_tablet' );
		$settings['columns_mobile']   = foxiz_get_option( $prefix . 'columns_mobile' );
		$settings['column_gap']       = foxiz_get_option( $prefix . 'column_gap' );
		$settings['sidebar_position'] = foxiz_get_option( $prefix . 'sidebar_position' );
		$settings['sidebar_name']     = foxiz_get_option( $prefix . 'sidebar_name' );

		$settings['sticky_sidebar'] = foxiz_get_option( $prefix . 'sticky_sidebar' );
		if ( empty( $settings['sticky_sidebar'] ) ) {
			$settings['sticky_sidebar'] = foxiz_get_option( 'sticky_sidebar' );
		}
		if ( '-1' === (string) $settings['sticky_sidebar'] ) {
			$settings['sticky_sidebar'] = false;
		}

		$settings['crop_size']      = foxiz_get_option( $prefix . 'crop_size' );
		$settings['entry_category'] = foxiz_get_option( $prefix . 'entry_category' );

		$settings['entry_meta_bar'] = foxiz_get_option( $prefix . 'entry_meta_bar' );
		if ( ! empty( $settings['entry_meta_bar'] ) && 'custom' === $settings['entry_meta_bar'] ) {
			$settings['entry_meta'] = foxiz_get_option( $prefix . 'entry_meta' );
			if ( is_array( $settings['entry_meta'] ) ) {
				$settings['entry_meta'] = implode( ',', $settings['entry_meta'] );
			}
		}

		$settings['review']       = foxiz_get_option( $prefix . 'review' );
		$settings['review_meta']  = foxiz_get_option( $prefix . 'review_meta' );
		$settings['entry_format'] = foxiz_get_option( $prefix . 'entry_format' );
		$settings['bookmark']     = foxiz_get_option( $prefix . 'bookmark' );
		$settings['excerpt']      = foxiz_get_option( $prefix . 'excerpt' );
		if ( ! empty( $settings['excerpt'] ) ) {
			$settings['excerpt_length'] = foxiz_get_option( $prefix . 'excerpt_length' );
			$settings['excerpt_source'] = foxiz_get_option( $prefix . 'excerpt_source' );
		}
		$settings['readmore']         = foxiz_get_option( $prefix . 'readmore' );
		$settings['title_tag']        = foxiz_get_option( $prefix . 'title_tag' );
		$settings['hide_category']    = foxiz_get_option( $prefix . 'hide_category' );
		$settings['tablet_hide_meta'] = foxiz_get_option( $prefix . 'tablet_hide_meta' );
		$settings['mobile_hide_meta'] = foxiz_get_option( $prefix . 'mobile_hide_meta' );
		$settings['hide_excerpt']     = foxiz_get_option( $prefix . 'hide_excerpt' );

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_search_page_settings' ) ) {
	/**
	 * @return array
	 */
	function foxiz_get_search_page_settings() {

		$settings                    = foxiz_get_archive_page_settings( 'search_' );
		$settings['s']               = get_search_query( 's' );
		$settings['posts_per_page']  = foxiz_get_option( 'search_posts_per_page' );
		$settings['template_global'] = foxiz_get_option( 'search_template_global' );

		if ( empty( $settings['posts_per_page'] ) ) {
			$settings['posts_per_page'] = get_option( 'posts_per_page' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_get_page_header_style' ) ) {
	/**
	 * @param string $page_id
	 *
	 * @return false|mixed|string|void
	 */
	function foxiz_get_page_header_style( $page_id = '' ) {

		if ( empty( $page_id ) ) {
			$page_id = get_the_ID();
		}

		$setting = rb_get_meta( 'page_header_style', $page_id );
		if ( empty( $setting ) || 'default' === $setting ) {
			$setting = foxiz_get_option( 'page_page_header_style' );
		}

		if ( empty( $setting ) ) {
			$setting = '1';
		}

		return $setting;
	}
}

if ( ! function_exists( 'foxiz_get_page_content_width' ) ) {
	/**
	 * @param string $page_id
	 *
	 * @return false|mixed|void
	 */
	function foxiz_get_page_content_width( $page_id = '' ) {

		if ( empty( $page_id ) ) {
			$page_id = get_the_ID();
		}
		$setting = rb_get_meta( 'width_wo_sb', $page_id );
		if ( empty( $setting ) || 'default' === $setting ) {
			$setting = foxiz_get_option( 'page_width_wo_sb' );
		} elseif ( '-1' === (string) $setting ) {
			return false;
		}

		return $setting;
	}
}

/**
 * @param array $settings
 */
if ( ! function_exists( 'foxiz_carousel_footer' ) ) {
	function foxiz_carousel_footer( $settings = array() ) {

		if ( ! empty( $settings['carousel_dot'] ) || ! empty( $settings['carousel_nav'] ) ) :
			$classes = 'slider-footer';
			if ( ! empty( $settings['color_scheme'] ) ) {
				$classes .= ' light-scheme';
			} ?>
            <div class="<?php echo esc_attr( $classes ); ?>">
				<?php if ( ! empty( $settings['carousel_nav'] ) ) : ?>
                    <div class="slider-prev rbi rbi-cleft"></div>
				<?php endif;
				if ( ! empty( $settings['carousel_dot'] ) ) : ?>
                    <div class="slider-pagination"></div>
				<?php endif;
				if ( ! empty( $settings['carousel_nav'] ) ) : ?>
                    <div class="slider-next rbi rbi-cright"></div>
				<?php endif; ?>
            </div>
		<?php endif;
	}
}

/**
 * @param array $settings
 */
if ( ! function_exists( 'foxiz_carousel_attrs' ) ) {
	function foxiz_carousel_attrs( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'columns'             => '3',
			'columns_tablet'      => '2',
			'columns_mobile'      => '1',
			'carousel_gap'        => '',
			'carousel_gap_tablet' => '',
			'carousel_gap_mobile' => '',
			'slider_play'         => '',
			'slider_fmode'        => '',
			'slider_centered'     => '',
		) );

		if ( (string) $settings['carousel_gap'] === '-1' ) {
			$settings['carousel_gap'] = 0;
		}
		if ( (string) $settings['carousel_gap_tablet'] === '-1' ) {
			$settings['carousel_gap_tablet'] = 0;
		}
		if ( (string) $settings['carousel_gap_mobile'] === '-1' ) {
			$settings['carousel_gap_mobile'] = 0;
		}
		if ( ! empty( $settings['carousel_columns'] ) ) {
			$settings['columns'] = $settings['carousel_columns'];
		}
		if ( ! empty( $settings['carousel_columns_tablet'] ) ) {
			$settings['columns_tablet'] = $settings['carousel_columns_tablet'];
		}
		if ( ! empty( $settings['carousel_columns_mobile'] ) ) {
			$settings['columns_mobile'] = $settings['carousel_columns_mobile'];
		}
		if ( empty( $settings['carousel_wide_columns'] ) ) {
			$settings['carousel_wide_columns'] = $settings['columns'];
		}
		if ( empty( $settings['slider_speed'] ) ) {
			$settings['slider_speed'] = 5000;
		}
		if ( empty( $settings['slider_centered'] ) || '-1' === (string) $settings['slider_centered'] ) {
			$settings['slider_centered'] = 0;
		} else {
			$settings['slider_centered'] = 1;
		}

		/** disable on editor */
		if ( is_admin() ) {
			$settings['slider_speed'] = 999999;
			$settings['slider_play']  = '';
		}

		echo ' data-wcol="' . esc_attr( $settings['carousel_wide_columns'] ) . '"';
		echo ' data-col="' . esc_attr( $settings['columns'] ) . '" data-tcol="' . esc_attr( $settings['columns_tablet'] ) . '" data-mcol="' . esc_attr( $settings['columns_mobile'] ) . '"';
		echo ' data-gap="' . esc_attr( $settings['carousel_gap'] ) . '" data-tgap="' . esc_attr( $settings['carousel_gap_tablet'] ) . '" data-mgap="' . esc_attr( $settings['carousel_gap_mobile'] ) . '"';
		echo ' data-play="' . esc_attr( $settings['slider_play'] ) . '" data-speed="' . esc_attr( $settings['slider_speed'] ) . '" data-fmode="' . esc_attr( $settings['slider_fmode'] ) . '" data-centered="' . esc_attr( $settings['slider_centered'] ) . '" ';
	}
}

/**
 * @param array $settings
 */
if ( ! function_exists( 'foxiz_slider_attrs' ) ) {
	function foxiz_slider_attrs( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'slider_play' => '0'
		) );

		if ( empty( $settings['slider_speed'] ) ) {
			$settings['slider_speed'] = 5000;
		}

		echo ' data-play="' . esc_attr( $settings['slider_play'] ) . '" data-speed="' . esc_attr( $settings['slider_speed'] ) . '"';
	}
}

if ( ! function_exists( 'foxiz_get_single_crop_size' ) ) {
	/**
	 * @param string $default
	 *
	 * @return array|false|mixed|string|void
	 */
	function foxiz_get_single_crop_size( $default = 'full' ) {

		$crop_size = rb_get_meta( 'featured_crop_size' );
		if ( empty( $crop_size ) ) {
			$crop_size = foxiz_get_option( 'single_crop_size' );
		}

		if ( empty( $crop_size ) ) {
			$crop_size = $default;
		}

		return $crop_size;
	}
}

if ( ! function_exists( 'foxiz_clear_settings_assets' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return array|mixed
	 * remove params out get methods
	 */
	function foxiz_clear_settings_assets( $settings = array() ) {

		$default = array(
			'uuid'               => '',
			'category'           => '',
			'name'               => '',
			'categories'         => '',
			'tags'               => '',
			'tag_not_in'         => '',
			'format'             => '',
			'author'             => '',
			'post_not_in'        => '',
			'order'              => '',
			'posts_per_page'     => '',
			'offset'             => '',
			'query_mode'         => '',
			'builder_pagination' => '',
			'pagination'         => '',
			'unique'             => '',
			'crop_size'          => '',
			'feat_hover'         => '',
			'entry_category'     => '',
			'hide_category'      => '',
			'title_tag'          => '',
			'entry_meta_bar'     => '',
			'entry_meta'         => '',
			'review'             => '',
			'review_meta'        => '',
			'sponsor_meta'       => '',
			'tablet_hide_meta'   => '',
			'mobile_hide_meta'   => '',
			'bookmark'           => '',
			'entry_format'       => '',
			'excerpt'            => '',
			'excerpt_length'     => '',
			'excerpt_source'     => '',
			'hide_excerpt'       => '',
			'readmore'           => '',
			'counter'            => '',
			'color_scheme'       => '',
			'box_style'          => '',
			'center_mode'        => '',
			'middle_mode'        => '',
			'block_structure'    => '',
			'divider_style'      => '',
			'query_for_template' => '',
			'live_block'         => '',
		);

		return shortcode_atts( $default, $settings );
	}
}

if ( ! function_exists( 'foxiz_clear_settings_query' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return array|mixed
	 * clear query for global templates in ajax
	 */
	function foxiz_clear_settings_query( $settings = array() ) {

		unset( $settings['category'] );
		unset( $settings['categories'] );
		unset( $settings['tags'] );
		unset( $settings['tag_not_in'] );
		unset( $settings['format'] );
		unset( $settings['author'] );
		unset( $settings['post_not_in'] );
		unset( $settings['post_in'] );
		$settings['order'] = 'date_posts';

		return $settings;
	}
}

if ( ! function_exists( 'foxiz_live_block_localize' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_live_block_localize( $settings ) {

		$settings    = foxiz_clear_settings_assets( $settings );
		$js_settings = array();
		$localize    = 'foxiz-global';
		foreach ( $settings as $key => $val ) {
			if ( ! empty( $val ) ) {
				$js_settings[ $key ] = $val;
			}
		}
		if ( ! empty( $settings['localize'] ) ) {
			$localize = $settings['localize'];
		}
		wp_localize_script( $localize, $settings['uuid'], $js_settings );
	}
}
