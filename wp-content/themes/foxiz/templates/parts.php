<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_block_open_tag' ) ) {
	/**
	 * @param array $settings
	 * @param null $_query
	 *
	 * @return string
	 * get block open tag
	 */
	function foxiz_get_block_open_tag( $settings = array(), $_query = null ) {

		$uuid      = '';
		$tag       = 'div';
		$classes   = array();
		$classes[] = 'block-wrap';

		if ( ! empty( $settings['carousel'] ) && '1' === (string) $settings['carousel'] ) {
			unset( $settings['column_gap'] );
			unset( $settings['columns'] );
			unset( $settings['columns_tablet'] );
			unset( $settings['columns_mobile'] );
		}

		if ( ! empty( $settings['block_tag'] ) ) {
			$tag = $settings['block_tag'];
		}

		if ( ! empty( $settings['uuid'] ) ) {
			$uuid = $settings['uuid'];
		}

		if ( ! empty( $settings['classes'] ) ) {
			$classes[] = $settings['classes'];
		}

		if ( ! empty( $settings['columns'] ) ) {
			$classes[] = 'rb-columns rb-col-' . $settings['columns'];
		}

		if ( ! empty( $settings['columns_tablet'] ) ) {
			$classes[] = 'rb-tcol-' . $settings['columns_tablet'];
		}

		if ( ! empty( $settings['columns_mobile'] ) ) {
			$classes[] = 'rb-mcol-' . $settings['columns_mobile'];
		}

		if ( ! empty( $settings['column_gap'] ) ) {
			$classes[] = 'is-gap-' . $settings['column_gap'];
		}

		if ( ! empty( $settings['color_scheme'] ) ) {
			$classes[] = 'light-scheme';
		}

		if ( ! empty( $settings['column_border'] ) ) {
			$classes[] = 'col-border is-border-' . $settings['column_border'];
		}
		if ( ! empty( $settings['feat_hover'] ) ) {
			$classes[] = 'hovering-' . $settings['feat_hover'];
		}

		if ( ! empty( $settings['bottom_border'] ) ) {
			$classes[] = 'bottom-border is-b-border-' . $settings['bottom_border'];
			if ( ! empty( $settings['last_bottom_border'] ) && '-1' === (string) $settings['last_bottom_border'] ) {
				$classes[] = 'no-last-bb';
			}
		}

		if ( ! empty( $settings['center_mode'] ) ) {
			$classes[] = 'p-center';
		}

		if ( ! empty( $settings['middle_mode'] ) ) {
			switch ( $settings['middle_mode'] ) {
				case  '1' :
					$classes[] = 'p-middle';
					break;
				case  '2' :
					$classes[] = 'p-vtop';
					break;
				case  '-1' :
					$classes[] = 'p-vbottom';
					break;
			}
		}

		if ( ! empty( $settings['entry_category'] ) ) {
			$parse = explode( ',', $settings['entry_category'] );
			if ( ! empty( $parse[0] ) ) {
				$classes[] = 'ecat-' . $parse[0];
			}
			if ( ! empty( $parse[1] ) ) {
				$classes[] = 'ecat-size-' . $parse[1];
			}
		}
		if ( ! empty( $settings['featured_position'] ) ) {
			$classes[] = 'featured-' . esc_attr( $settings['featured_position'] );
		}

		return '<' . $tag . ' id="' . $uuid . '" class="' . join( ' ', $classes ) . '">';
	}
}

if ( ! function_exists( 'foxiz_block_open_tag' ) ) {
	/**
	 * @param array $settings
	 * @param null $_query
	 * render block open tag
	 */
	function foxiz_block_open_tag( $settings = array(), $_query = null ) {

		echo foxiz_get_block_open_tag( $settings, $_query );
	}
}

if ( ! function_exists( 'foxiz_block_close_tag' ) ) {
	/**
	 * @param array $settings
	 * render block close tag
	 */
	function foxiz_block_close_tag( $settings = array() ) {

		$tag = 'div';

		if ( ! empty( $settings['block_tag'] ) ) {
			$tag = $settings['block_tag'];
		}
		echo '</' . esc_attr( $tag ) . '>';
	}
}

if ( ! function_exists( 'foxiz_error_posts' ) ) {
	/**
	 * @param null $_query
	 * @param string $min
	 * render error posts
	 */
	function foxiz_error_posts( $_query = null, $min = '' ) {

		if ( current_user_can( 'edit_pages' ) ) :
			if ( ! $_query->have_posts() || ! $_query->post_count ) {
				$messenger = esc_html__( 'No found posts, Please add a new post for this query or change the block settings: ', 'foxiz' );
			} else {
				$messenger = sprintf( esc_html__( 'This block requests at least %s posts, Please add new posts for this query or change the block settings: ', 'foxiz' ), $min );
			} ?>
            <p class="rb-error"><?php
				echo esc_html( $messenger );
				edit_post_link( esc_html__( 'Edit Page', 'foxiz' ), null, null, null, 'page-edit-link' );
				?></p>
		<?php
		endif;
	}
}

if ( ! function_exists( 'foxiz_block_inner_open_tag' ) ) {
	/**
	 * @param array $settings
	 * render block inner open tag
	 */
	function foxiz_block_inner_open_tag( $settings = array() ) {

		$classes = 'block-inner';
		if ( ! empty( $settings['inner_classes'] ) ) {
			$classes .= ' ' . $settings['inner_classes'];
		}
		if ( ! empty( $settings['scroll_height'] ) ) {
			echo '<div class="scroll-holder">';
		}
		echo '<div class="' . esc_attr( $classes ) . '">';
	}
}

if ( ! function_exists( 'foxiz_block_inner_close_tag' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_block_inner_close_tag( $settings = array() ) {

		echo '</div>';

		if ( ! empty( $settings['scroll_height'] ) ) {
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'foxiz_is_ajax_pagination' ) ) {
	function foxiz_is_ajax_pagination( $pagination ) {

		if ( ! empty( $pagination ) && ( 'load_more' === $pagination || 'infinite_scroll' === $pagination || 'next_prev' === $pagination ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_dynamic_preview_pagination' ) ) {
	/**
	 * @param string $pagination
	 */
	function foxiz_dynamic_preview_pagination( $pagination = '' ) {

		echo '<div class="admin-template-info">' . sprintf( esc_html__( 'Dynamic %s pagination', 'foxiz' ), $pagination ) . '</div>';
	}
}

if ( ! function_exists( 'foxiz_render_pagination' ) ) {
	/**
	 * @param $settings
	 * @param null $_query
	 *
	 * @return false
	 * render pagination
	 */
	function foxiz_render_pagination( $settings, $_query = null ) {

		if ( ! $_query ) {
			return false;
		}

		/** clear up */
		$settings = foxiz_clear_settings_assets( $settings );

		/** ajax pagination for template builder */
		if ( ! empty( $settings['query_mode'] ) && 'global' === $settings['query_mode'] ) {
			if ( empty( $settings['builder_pagination'] ) ) {
				return false;
			}

			/** edit mode */
			if ( foxiz_is_template_preview() ) {
				foxiz_dynamic_preview_pagination( $settings['builder_pagination'] );

				return false;
			}

			/** remove affected query settings */
			$settings['pagination'] = $settings['builder_pagination'];
			unset( $settings['builder_pagination'] );
			unset( $settings['query_mode'] );

			$settings                   = foxiz_clear_settings_query( $settings );
			$settings['posts_per_page'] = $_query->get( 'posts_per_page' );

			/** template for default wordpress templates */
			if ( is_category() ) {
				$settings['category'] = $_query->get_queried_object_id();
			} elseif ( is_tag() ) {
				$settings['tag_in'] = array( $_query->get_queried_object_id() );
			} elseif ( is_author() ) {
				$settings['author'] = $_query->get_queried_object_id();
			} elseif ( is_search() ) {
				$settings['s'] = get_search_query();
			} elseif ( is_archive() ) {
				/** disable ajax */
				if ( foxiz_is_ajax_pagination( $settings['pagination'] ) ) {
					$settings['pagination'] = 'number';
				}
			}

			/** AMP fallback */
			if ( foxiz_is_amp() && foxiz_is_ajax_pagination( $settings['pagination'] ) ) {
				$settings['pagination'] = 'number';
			}
		}

		if ( empty( $settings['pagination'] ) || empty( $settings['uuid'] ) || ( foxiz_is_amp() && foxiz_is_ajax_pagination( $settings['pagination'] ) ) ) {
			return false;
		}

		/** set ajax params */
		if ( ! empty( $settings['unique'] ) ) {
			$queried_ids = $_query->get( 'foxiz_queried_ids' );
			if ( is_array( $queried_ids ) ) {
				$queried_ids = implode( ',', $queried_ids );
				if ( empty( $settings['post_not_in'] ) ) {
					$settings['post_not_in'] = $queried_ids;
				} else {
					$settings['post_not_in'] .= ',' . $queried_ids;
				}
			}
		}

		if ( ! empty( $settings['post_not_in'] ) ) {
			$settings['post_not_in'] = str_replace( ',,', ',', $settings['post_not_in'] );
		}

		if ( $_query->query_vars['paged'] > 1 ) {
			$settings['paged'] = $_query->query_vars['paged'];
		} elseif ( ! empty( get_query_var( 'paged' ) ) && get_query_var( 'paged' ) > 1 ) {
			$settings['paged'] = get_query_var( 'paged' );
		} else {
			$settings['paged'] = 1;
		}

		if ( ! empty( $_query->max_num_pages ) ) {
			$settings['page_max'] = $_query->max_num_pages;
		}
		if ( ! empty( $settings['offset'] ) && ! empty( $_query->found_posts ) && ! empty( $settings['posts_per_page'] ) ) {
			$settings['page_max'] = ceil( ( $_query->found_posts - $settings['offset'] ) / $settings['posts_per_page'] );
		}

		/** set params for custom template sections */
		$settings['query_for_template'] = $_query->get( 'query_for_template' );

		if ( ! empty( $settings['query_for_template'] ) ) {
			switch ( $settings['query_for_template'] ) {
				case 'related' :
					$settings['related_id'] = $_query->get( 'related_id' );
					if ( 'simple' == $settings['pagination'] || 'number' == $settings['pagination'] ) {
						$settings['pagination'] = 'load_more';
					}
					break;
                case 'recommended_interest' :
	                if ( 'simple' == $settings['pagination'] || 'number' == $settings['pagination'] ) {
		                $settings['pagination'] = 'infinite_scroll';
	                }
	                break;
				default:
					break;
			}
		}

		/** js settings */
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

		if ( ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) && function_exists( 'foxiz_ajax_localize_script' ) ) {
			foxiz_ajax_localize_script( $settings['uuid'], $js_settings );
		}

		/** render */
		switch ( $settings['pagination'] ) {
			case 'next_prev' :
				foxiz_render_pagination_nextprev( $_query );
				break;
			case 'load_more' :
				foxiz_render_pagination_load_more( $_query );
				break;
			case 'infinite_scroll' :
				foxiz_render_pagination_infinite( $_query );
				break;
			case 'simple' :
				foxiz_render_pagination_simple( $_query );
				break;
			case 'number' :
				foxiz_render_pagination_number( $_query );
				break;
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'foxiz_render_pagination_load_more' ) ) {
	/**
	 * @param null $_query
	 *
	 * @return false
	 */
	function foxiz_render_pagination_load_more( $_query = null ) {

		if ( empty( $_query ) || ! is_object( $_query ) ) {
			global $wp_query;
			$_query = $wp_query;
		}

		if ( $_query->max_num_pages < 2 ) {
			return false;
		}  ?>
        <div class="pagination-wrap pagination-loadmore">
            <a href="#" class="loadmore-trigger"><span><?php foxiz_html_e( 'Show More', 'foxiz' ); ?></span><i class="rb-loader"></i></a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_pagination_nextprev' ) ) {
	/**
	 * @param null $_query
	 *
	 * @return false
	 */
	function foxiz_render_pagination_nextprev( $_query = null ) {

		if ( empty( $_query ) || ! is_object( $_query ) ) {
			global $wp_query;
			$_query = $wp_query;
		}
		if ( $_query->max_num_pages < 2 ) {
			return false;
		} ?>
        <div class="pagination-wrap pagination-nextprev">
            <a href="#" class="pagination-trigger ajax-prev is-disable" data-type="prev"><i class="rbi rbi-angle-left"></i><span><?php foxiz_html_e( 'Previous', 'foxiz' ); ?></span></a>
            <a href="#" class="pagination-trigger ajax-next" data-type="next"><span><?php foxiz_html_e( 'Next', 'foxiz' ); ?></span><i class="rbi rbi-angle-right"></i></a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_pagination_infinite' ) ) {
	/**
	 * @param null $_query
	 *
	 * @return false
	 */
	function foxiz_render_pagination_infinite( $_query = null ) {

		if ( empty( $_query ) || ! is_object( $_query ) ) {
			global $wp_query;
			$_query = $wp_query;
		}
		if ( $_query->max_num_pages < 2 ) {
			return false;
		} ?>
        <div class="pagination-wrap pagination-infinite">
            <div class="infinite-trigger"><i class="rb-loader"></i></div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_pagination_simple' ) ) {
	/**
	 * @param null $_query
	 *
	 * @return false
	 */
	function foxiz_render_pagination_simple( $_query = null ) {

		if ( empty( $_query ) || ! is_object( $_query ) ) {
			global $wp_query;
			$_query = $wp_query;
		}

		if ( $_query->max_num_pages < 2 ) {
			return false;
		} ?>
        <nav class="pagination-wrap pagination-simple clearfix">
			<?php if ( get_previous_posts_link() ) : ?>
                <span class="newer"><?php previous_posts_link( '<i class="rbi rbi-cleft"></i>' . foxiz_html__( 'Newer Articles', 'foxiz' ) ); ?></span>
			<?php endif;
			if ( get_next_posts_link() ) : ?>
                <span class="older"><?php next_posts_link( foxiz_html__( 'Older Articles', 'foxiz' ) . '<i class="rbi rbi-cright"></i>' ); ?></span>
			<?php endif; ?>
        </nav>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_pagination_number' ) ) {
	/**
	 * @param null $_query
	 * @param int $offset
	 *
	 * @return false
	 */
	function foxiz_render_pagination_number( $_query = null, $offset = 0 ) {

		if ( empty( $_query ) || ! is_object( $_query ) ) {
			global $wp_query;
			$_query = $wp_query;
		}

		if ( $_query->max_num_pages < 2 ) {
			return false;
		}

		$current = 1;
		$total   = $_query->max_num_pages;
		if ( $_query->query_vars['paged'] > 1 ) {
			$current = $_query->query_vars['paged'];
		} elseif ( ! empty( get_query_var( 'paged' ) ) && get_query_var( 'paged' ) > 1 ) {
			$current = get_query_var( 'paged' );
		}

		if ( ! empty( $offset ) ) {
			$post_per_page = $_query->query_vars['posts_per_page'];
			$total         = $_query->max_num_pages - floor( $offset / $post_per_page );
			$found_posts   = $_query->found_posts;
			if ( $found_posts < ( $total * $post_per_page ) ) {
				$total = $total - 1;
			}
		}

		$params = array(
			'total'     => $total,
			'current'   => $current,
			'end_size'  => 2,
			'mid_size'  => 2,
			'prev_text' => '<i class="rbi-cleft"></i>',
			'next_text' => '<i class="rbi-cright"></i>',
			'type'      => 'plain'
		);

		if ( ! empty( $_query->query_vars['s'] ) ) {
			$params['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
		} ?>
        <nav class="pagination-wrap pagination-number">
			<?php echo paginate_links( $params ); ?>
        </nav>
		<?php
	}
}

if ( ! function_exists( 'foxiz_search_form' ) ) {
	/**
	 * @param string $placeholder
	 * @param string $label
	 * @param bool $icon
	 * @param string $custom_svg
	 */
	function foxiz_search_form( $placeholder = '', $label = '', $icon = true, $custom_svg = '' ) {

		if ( empty( $placeholder ) ) {
			$placeholder = foxiz_get_option( 'search_placeholder' );
		}
		if ( empty( $placeholder ) ) {
			$placeholder = foxiz_html__( 'Search and hit enter...', 'foxiz' );
		}
		if ( empty( $label ) ) {
			$label = foxiz_html__( 'Search', 'foxiz' );
		}
		if ( empty( $placeholder ) ) {
			$placeholder = foxiz_html__( 'Search Headlines, News...', 'foxiz' );
		}
		if ( empty( $custom_svg ) ) {
			$custom_svg = foxiz_get_option( 'header_search_custom_icon' );
		}
		?>
        <form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="rb-search-form">
            <div class="search-form-inner">
				<?php if ( ! empty( $custom_svg['url'] ) ) : ?>
                    <span class="search-icon"><span class="search-icon-svg"></span></span>
				<?php else : ?>
                    <span class="search-icon"><i class="rbi rbi-search"></i></span>
				<?php endif; ?>
                <span class="search-text"><input type="text" class="field" placeholder="<?php echo esc_html( $placeholder ) ?>" value="<?php echo get_search_query(); ?>" name="s"/></span>
                <span class="rb-search-submit"><input type="submit" value="<?php echo esc_html( $label ); ?>"/><?php if ( $icon ) : ?>
                        <i class="rbi rbi-cright"></i><?php endif; ?></span>
            </div>
        </form>
	<?php }
}

if ( ! function_exists( 'foxiz_render_elementor_link' ) ) {
	/**
	 * @param $link
	 * @param string $title
	 * @param string $classes
	 *
	 * @return string
	 */
	function foxiz_render_elementor_link( $link, $title = '', $classes = '' ) {

		$output = '';
		$output .= '<a';
		if ( ! empty( $classes ) ) {
			$output .= ' class="' . esc_attr( $classes ) . '"';
		}
		if ( ! empty( $link['is_external'] ) ) {
			$output .= ' target="_blank"';
		}
		if ( ! empty( $link['nofollow'] ) ) {
			$output .= ' rel="nofollow"';
		}
		if ( ! empty( $link['custom_attributes'] ) ) {
			$attrs = explode( ',', $link['custom_attributes'] );
			foreach ( $attrs as $attr ) {
				$attr = explode( '|', $attr );
				if ( ! empty( $attr[0] && ! empty( $attr[1] ) ) ) {
					$output .= ' ' . esc_attr( $attr[0] ) . '="' . esc_attr( $attr[1] ) . '"';
				}
			}
		}
		if ( ! empty( $link['url'] ) ) {
			$output .= ' href="' . esc_url( $link['url'] ) . '"';
		}
		$output .= '>';
		if ( ! empty( $title ) ) {
			$output .= esc_html( $title );
		}
		$output .= '</a>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_social_list' ) ) {
	/**
	 * @param array $data
	 * @param bool $new_tab
	 * @param bool $custom
	 *
	 * @return false|string
	 */
	function foxiz_get_social_list( $data = array(), $new_tab = true, $custom = true ) {

		if ( empty( $data ) ) {
			return false;
		}

		if ( true === $new_tab ) {
			$new_tab = 'target="_blank" rel="noopener nofollow"';
		} else {
			$new_tab = 'rel="noopener nofollow"';
		}

		extract( shortcode_atts( array(
			'website'    => '',
			'facebook'   => '',
			'twitter'    => '',
			'youtube'    => '',
			'instagram'  => '',
			'pinterest'  => '',
			'linkedin'   => '',
			'tumblr'     => '',
			'flickr'     => '',
			'skype'      => '',
			'snapchat'   => '',
			'myspace'    => '',
			'bloglovin'  => '',
			'digg'       => '',
			'dribbble'   => '',
			'soundcloud' => '',
			'vimeo'      => '',
			'reddit'     => '',
			'vkontakte'  => '',
			'telegram'   => '',
			'whatsapp'   => '',
			'rss'        => '',
		), $data ) );

		$output = '';

		if ( ! empty( $website ) ) {
			$output .= '<a class="social-link-website" data-title="' . foxiz_attr__( 'Website', 'foxiz' ) . '" href="' . esc_url( $website ) . '" ' . $new_tab . '><i class="rbi rbi-portfolio-o"></i></a>';
		}
		if ( ! empty( $facebook ) ) {
			$output .= '<a class="social-link-facebook" data-title="' . foxiz_attr__( 'Facebook', 'foxiz' ) . '" href="' . esc_url( $facebook ) . '" ' . $new_tab . '><i class="rbi rbi-facebook"></i></a>';
		}
		if ( ! empty( $twitter ) ) {
			$output .= '<a class="social-link-twitter" data-title="' . foxiz_attr__( 'Twitter', 'foxiz' ) . '" href="' . esc_url( $twitter ) . '" ' . $new_tab . '><i class="rbi rbi-twitter"></i></a>';
		}
		if ( ! empty( $youtube ) ) {
			$output .= '<a class="social-link-youtube" data-title="' . foxiz_attr__( 'YouTube', 'foxiz' ) . '" href="' . esc_url( $youtube ) . '" ' . $new_tab . '><i class="rbi rbi-youtube"></i></a>';
		}
		if ( ! empty( $pinterest ) ) {
			$output .= '<a class="social-link-pinterest" data-title="' . foxiz_attr__( 'Pinterest', 'foxiz' ) . '" href="' . esc_url( $pinterest ) . '" ' . $new_tab . '><i class="rbi rbi-pinterest"></i></a>';
		}
		if ( ! empty( $instagram ) ) {
			$output .= '<a class="social-link-instagram" data-title="' . foxiz_attr__( 'Instagram', 'foxiz' ) . '" href="' . esc_url( $instagram ) . '" ' . $new_tab . '><i class="rbi rbi-instagram"></i></a>';
		}
		if ( ! empty( $linkedin ) ) {
			$output .= '<a class="social-link-linkedin" data-title="' . foxiz_attr__( 'LinkedIn', 'foxiz' ) . '" href="' . esc_url( $linkedin ) . '" ' . $new_tab . '><i class="rbi rbi-linkedin"></i></a>';
		}
		if ( ! empty( $tumblr ) ) {
			$output .= '<a class="social-link-tumblr" data-title="' . foxiz_attr__( 'Tumblr', 'foxiz' ) . '" href="' . esc_url( $tumblr ) . '" ' . $new_tab . '><i class="rbi rbi-tumblr"></i></a>';
		}
		if ( ! empty( $flickr ) ) {
			$output .= '<a class="social-link-flickr" data-title="' . foxiz_attr__( 'Flickr', 'foxiz' ) . '" href="' . esc_url( $flickr ) . '" ' . $new_tab . '><i class="rbi rbi-flickr"></i></a>';
		}
		if ( ! empty( $skype ) ) {
			$output .= '<a class="social-link-skype" data-title="' . foxiz_attr__( 'Skype', 'foxiz' ) . '" href="' . esc_url( $skype ) . '" ' . $new_tab . '><i class="rbi rbi-skype"></i></a>';
		}
		if ( ! empty( $snapchat ) ) {
			$output .= '<a class="social-link-snapchat" data-title="' . foxiz_attr__( 'SnapChat', 'foxiz' ) . '" href="' . esc_url( $snapchat ) . '" ' . $new_tab . '><i class="rbi rbi-snapchat"></i></a>';
		}
		if ( ! empty( $myspace ) ) {
			$output .= '<a class="social-link-myspace" data-title="' . foxiz_attr__( 'Myspace', 'foxiz' ) . '" href="' . esc_url( $myspace ) . '" ' . $new_tab . '><i class="rbi rbi-myspace"></i></a>';
		}
		if ( ! empty( $bloglovin ) ) {
			$output .= '<a class="social-link-bloglovin" data-title="' . foxiz_attr__( 'Bloglovin', 'foxiz' ) . '" href="' . esc_url( $bloglovin ) . '" ' . $new_tab . '><i class="rbi rbi-heart"></i></a>';
		}
		if ( ! empty( $digg ) ) {
			$output .= '<a class="social-link-digg" data-title="' . foxiz_attr__( 'Digg', 'foxiz' ) . '" href="' . esc_url( $digg ) . '" ' . $new_tab . '><i class="rbi rbi-digg"></i></a>';
		}
		if ( ! empty( $dribbble ) ) {
			$output .= '<a class="social-link-dribbble" data-title="' . foxiz_attr__( 'Dribbble', 'foxiz' ) . '" href="' . esc_url( $dribbble ) . '" ' . $new_tab . '><i class="rbi rbi-dribbble"></i></a>';
		}
		if ( ! empty( $soundcloud ) ) {
			$output .= '<a class="social-link-soundcloud" data-title="' . foxiz_attr__( 'SoundCloud', 'foxiz' ) . '" href="' . esc_url( $soundcloud ) . '" ' . $new_tab . '><i class="rbi rbi-soundcloud"></i></a>';
		}
		if ( ! empty( $vimeo ) ) {
			$output .= '<a class="social-link-vimeo" data-title="' . foxiz_attr__( 'Vimeo', 'foxiz' ) . '" href="' . esc_url( $vimeo ) . '" ' . $new_tab . '><i class="rbi rbi-vimeo"></i></a>';
		}
		if ( ! empty( $reddit ) ) {
			$output .= '<a class="social-link-reddit" data-title="' . foxiz_attr__( 'Reddit', 'foxiz' ) . '" href="' . esc_url( $reddit ) . '" ' . $new_tab . '><i class="rbi rbi-reddit"></i></a>';
		}
		if ( ! empty( $vkontakte ) ) {
			$output .= '<a class="social-link-vk" data-title="' . foxiz_attr__( 'Vkontakte', 'foxiz' ) . '" href="' . esc_url( $vkontakte ) . '" ' . $new_tab . '><i class="rbi rbi-vk"></i></a>';
		}
		if ( ! empty( $telegram ) ) {
			$output .= '<a class="social-link-telegram" data-title="' . foxiz_attr__( 'Telegram', 'foxiz' ) . '" href="' . esc_url( $telegram ) . '" ' . $new_tab . '><i class="rbi rbi-telegram"></i></a>';
		}
		if ( ! empty( $whatsapp ) ) {
			$output .= '<a class="social-link-whatsapp" data-title="' . foxiz_attr__( 'WhatsApp', 'foxiz' ) . '" href="' . esc_url( $whatsapp ) . '" ' . $new_tab . '><i class="rbi rbi-whatsapp"></i></a>';
		}
		if ( ! empty( $rss ) ) {
			$output .= '<a class="social-link-rss" data-title="' . foxiz_attr__( 'Rss', 'foxiz' ) . '" href="' . esc_url( $rss ) . '" ' . $new_tab . '><i class="rbi rbi-rss"></i></a>';
		}

		if ( $custom ) {

			$social_1_url  = foxiz_get_option( 'custom_social_1_url' );
			$social_1_name = foxiz_get_option( 'custom_social_1_name' );
			$social_1_icon = foxiz_get_option( 'custom_social_1_icon' );

			$social_2_url  = foxiz_get_option( 'custom_social_2_url' );
			$social_2_name = foxiz_get_option( 'custom_social_2_name' );
			$social_2_icon = foxiz_get_option( 'custom_social_2_icon' );

			$social_3_url  = foxiz_get_option( 'custom_social_3_url' );
			$social_3_name = foxiz_get_option( 'custom_social_3_name' );
			$social_3_icon = foxiz_get_option( 'custom_social_3_icon' );

			if ( ! empty( $social_1_url ) && ! empty( $social_1_name ) ) {
				$output .= '<a class="social-link-custom social-link-1 social-link-' . esc_attr( $social_1_name ) . '" data-title="' . esc_attr( $social_1_name ) . '" href="' . esc_url( $social_1_url ) . '" ' . $new_tab . '><i class="' . esc_attr( $social_1_icon ) . '"></i></a>';
			}
			if ( ! empty( $social_2_url ) && ! empty( $social_2_name ) ) {
				$output .= '<a class="social-link-custom social-link-2 social-link-' . esc_attr( $social_2_name ) . '" data-title="' . esc_attr( $social_2_name ) . '" href="' . esc_url( $social_2_url ) . '" ' . $new_tab . '><i class="' . esc_attr( $social_2_icon ) . '"></i></a>';
			}
			if ( ! empty( $social_3_url ) && ! empty( $social_3_name ) ) {
				$output .= '<a class="social-link-custom social-link-3 social-link-' . esc_attr( $social_3_name ) . '" data-title="' . esc_attr( $social_3_name ) . '" href="' . esc_url( $social_3_url ) . '" ' . $new_tab . '><i class="' . esc_attr( $social_3_icon ) . '"></i></a>';
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_category_hero' ) ) {
	/**
	 * @param array $featured_array
	 * @param array $featured_urls_array
	 * @param string $size
	 *
	 * @return false|string
	 */
	function foxiz_get_category_hero( $featured_array = array(), $featured_urls_array = array(), $size = 'foxiz_crop_o1' ) {

		if ( ! is_array( $featured_array ) || ! count( $featured_array ) ) {
			return false;
		}

		if ( 1 === count( $featured_array ) ) {
			$featured_array[1] = $featured_array[0];
		}
		$counter = 0;
		$output  = '<div class="category-hero-wrap">';
		foreach ( $featured_array as $index => $id ) {
			$url = wp_get_attachment_image_url( $id, $size );
			$alt = get_post_meta( $url, '_wp_attachment_image_alt', true );
			if ( empty( $url ) && ! empty( $featured_urls_array[ $index ] ) ) {
				$url = $featured_urls_array[ $index ];
			}
			$output .= '<div class="category-hero-item">';
			$output .= '<div class="category-hero-item-inner">';
			$output .= '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '">';
			$output .= '</div>';
			$output .= '</div>';

			$counter ++;
			if ( $counter > 1 ) {
				break;
			}
		}
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_render_category_hero' ) ) {
	/**
	 * @param array $featured_array
	 * @param array $featured_urls_array
	 * @param string $size
	 */
	function foxiz_render_category_hero( $featured_array = array(), $featured_urls_array = array(), $size = '' ) {

		echo foxiz_get_category_hero( $featured_array, $featured_urls_array, $size );
	}
}

if ( ! function_exists( 'foxiz_get_category_featured' ) ) {
	/**
	 * @param array $featured_array
	 * @param array $featured_urls_array
	 * @param string $size
	 *
	 * @return false|string
	 */
	function foxiz_get_category_featured( $featured_array = array(), $featured_urls_array = array(), $size = 'foxiz_crop_g1' ) {

		if ( empty( $featured_array[0] ) && empty( $featured_urls_array[0] ) ) {
			return false;
		}

		$output = '<span class="featured-category-img">';

		if ( ! empty( $featured_array[0] ) ) {
			$output .= wp_get_attachment_image( $featured_array[0], $size );
		} else {
			$output .= '<img src="' . esc_url( $featured_urls_array[0] ) . ' alt="' . esc_html__( 'category featured', 'foxiz' ) . '" loading="lazy">';
		}

		$output .= '</span>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_render_category_featured' ) ) {
	/**
	 * @param array $featured_array
	 * @param array $featured_urls_image
	 * @param string $size
	 */
	function foxiz_render_category_featured( $featured_array = array(), $featured_urls_image = array(), $size = '' ) {

		echo foxiz_get_category_featured( $featured_array, $featured_urls_image, $size );
	}
}

if ( ! function_exists( 'foxiz_post_open_tag' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_post_open_tag( $settings = array() ) { ?>
        <div class="<?php echo foxiz_get_post_classes( $settings ); ?>" data-pid="<?php echo get_the_ID(); ?>">
	<?php }
}

if ( ! function_exists( 'foxiz_post_close_tag' ) ) {
	function foxiz_post_close_tag() { ?>
        </div>
	<?php }
}