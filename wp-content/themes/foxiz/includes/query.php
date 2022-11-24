<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param array $data
 * @param string $paged
 * custom query for this theme
 */
if ( ! function_exists( 'foxiz_query' ) ) {
	function foxiz_query( $data = array(), $paged = null ) {

		if ( ! empty( $data['query_mode'] ) && 'global' === $data['query_mode'] && ! foxiz_is_template_preview() ) {

			/** custom query for dynamic templates */
			if ( ! empty( $GLOBALS['ruby_template_query'] ) ) {
				$_query = $GLOBALS['ruby_template_query'];
				unset( $GLOBALS['ruby_template_query'] );

				return $_query;
			}

			/** global query builder */
			global $wp_query;

			return $wp_query;
		}

		$data = shortcode_atts( array(
			'categories'          => '',
			'category'            => '',
			'author'              => '',
			'author_in'           => '',
			'format'              => '',
			'tags'                => '',
			'tag_in'              => '',
			'posts_per_page'      => '',
			'no_found_rows'       => false,
			'offset'              => '',
			'order'               => 'date_post',
			'post_type'           => 'post',
			'meta_key'            => '',
			'post_in'             => '',
			'post_not_in'         => '',
			'tag_not_in'          => '',
			's'                   => '',
			'duplicate_allowed'   => '',
			'tax_query'           => array(),
			'unique'              => '',
			'ignore_sticky_posts' => 1
		), $data );

		if ( ! class_exists( 'Post_Views_Counter' ) ) {
			if ( 'popular' === $data['order'] || 'popular_m' === $data['order'] || 'popular_w' === $data['order'] ) {
				$data['order'] = 'comment_count';
			}
		}

		$params = array();
		/** set foxiz_queried_ids */
		if ( ! isset( $GLOBALS['foxiz_queried_ids'] ) ) {
			$GLOBALS['foxiz_queried_ids'] = array();
		}

		$params['post_status']         = 'publish';
		$params['ignore_sticky_posts'] = $data['ignore_sticky_posts'];
		$params['post_type']           = $data['post_type'];
		$params['no_found_rows']       = boolval( $data['no_found_rows'] );
		$params['tax_query']           = array();

		if ( ! empty( $data['posts_per_page'] ) ) {
			$params['posts_per_page'] = intval( $data['posts_per_page'] );
		}

		if ( ! empty( $data['post_in'] ) ) {
			if ( is_string( $data['post_in'] ) ) {
				$params['post__in'] = explode( ',', $data['post_in'] );
			} elseif ( is_array( $data['post_in'] ) ) {
				$params['post__in'] = $data['post_in'];
			}
		} else {

			$excluded_ids = array();

			if ( ! empty( $data['post_not_in'] ) && is_string( $data['post_not_in'] ) ) {
				$excluded_ids = explode( ',', $data['post_not_in'] );
			} elseif ( is_array( $data['post_not_in'] ) ) {
				$excluded_ids = $data['post_not_in'];
			}

			if ( count( $GLOBALS['foxiz_queried_ids'] ) && ! empty( $data['unique'] ) ) {
				$excluded_ids = array_merge( $excluded_ids, $GLOBALS['foxiz_queried_ids'] );
			}

			if ( is_array( $excluded_ids ) ) {
				$params['post__not_in'] = $excluded_ids;
			}
		}

		if ( ! empty( $data['categories'] ) && 'all' !== $data['categories'] ) {
			if ( is_array( $data['categories'] ) ) {
				$params['cat'] = implode( ',', $data['categories'] );
			} else {
				$params['cat'] = trim( $data['categories'] );
			}
		} elseif ( ! empty( $data['category'] ) && 'all' !== $data['category'] ) {
			$params['cat'] = $data['category'];
		}

		if ( ! empty( $data['author'] ) ) {
			$params['author'] = $data['author'];
		} elseif ( ! empty( $data['author_in'] ) && is_array( $data['author_in'] ) ) {
			$params['author__in'] = $data['author_in'];
		};

		if ( ! empty( $data['format'] ) && 'post' === $data['post_type'] ) {
			if ( 'default' !== $data['format'] ) {
				$params['tax_query'][] = array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-' . trim( $data['format'] ) ),
				);
			} else {
				$params['tax_query'][] = array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-gallery', 'post-format-video', 'post-format-audio' ),
					'operator' => 'NOT IN',
				);
			}
		}

		if ( ! empty( $data['tax_query'] ) ) {
			$params['tax_query'][] = $data['tax_query'];
		}

		if ( ! empty( $paged ) && $paged > 1 ) {
			$params['paged'] = absint( $paged );
		}

		if ( ! empty( $data['offset'] ) ) {
			if ( $paged > 1 ) {
				$params['offset'] = absint( $data['offset'] ) + absint( ( $paged - 1 ) * absint( $data['posts_per_page'] ) );
			} else {
				$params['offset'] = absint( $data['offset'] );
			}
			unset( $params['paged'] );
		}

		if ( ! empty( $data['tags'] ) ) {
			$data['tags']  = preg_replace( '/\s+/', '', $data['tags'] );
			$params['tag'] = $data['tags'];
		} else {
			if ( ! empty( $data['tag_not_in'] ) ) {
				if ( ! is_array( $data['tag_not_in'] ) ) {
					$data['tag_not_in'] = explode( ',', $data['tag_not_in'] );
				}

				$data['tag_not_in'] = array_unique( $data['tag_not_in'] );
				foreach ( $data['tag_not_in'] as $tag_slug ) {
					$params['tax_query'][] = array(
						'taxonomy' => 'post_tag',
						'field'    => 'slug',
						'terms'    => trim( $tag_slug ),
						'operator' => 'NOT IN',
					);
				}
			}
		}

		if ( ! empty( $data['tag_in'] ) && is_array( $data['tag_in'] ) ) {
			$params['tag__in'] = $data['tag_in'];
		}

		if ( ! empty( $data['meta_key'] ) ) {
			$params['meta_key'] = $data['meta_key'];
			$params['orderby']  = 'meta_value_num';
		}

		/** set search query */
		if ( ! empty( $data['s'] ) ) {
			$params['s']   = $data['s'];
			$data['order'] = 'relevance';
		}

		switch ( $data['order'] ) {

			case 'date_post' :
				$params['orderby'] = 'date';
				$params['order']   = 'DESC';
				break;

			case 'update' :
				$params['orderby'] = 'modified';
				$params['order']   = 'DESC';
				break;

			case 'comment_count' :
				$params['orderby'] = 'comment_count';
				$params['order']   = 'DESC';
				break;

			case 'post_type' :
				$params['orderby'] = 'type';
				break;

			case 'popular':
				$params['suppress_filters'] = false;
				$params['fields']           = '';
				$params['orderby']          = 'post_views';
				$params['order']            = 'DESC';
				break;
			case 'popular_w':
				$params['suppress_filters'] = false;
				$params['fields']           = '';
				$params['orderby']          = 'post_views';
				$params['order']            = 'DESC';
				$params['date_query']       = array(
					array(
						'after'  => '7 days ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'popular_m':
				$params['suppress_filters'] = false;
				$params['fields']           = '';
				$params['orderby']          = 'post_views';
				$params['order']            = 'DESC';
				$params['date_query']       = array(
					array(
						'after'  => '1 month ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'popular_3m':
				$params['suppress_filters'] = false;
				$params['fields']           = '';
				$params['orderby']          = 'post_views';
				$params['order']            = 'DESC';
				$params['date_query']       = array(
					array(
						'after'  => '3 months ago',
						'column' => 'post_date_gmt',
					)
				);
				break;

			case 'popular_6m':
				$params['suppress_filters'] = false;
				$params['fields']           = '';
				$params['orderby']          = 'post_views';
				$params['order']            = 'DESC';
				$params['date_query']       = array(
					array(
						'after'  => '6 months ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'popular_y':
				$params['suppress_filters'] = false;
				$params['fields']           = '';
				$params['orderby']          = 'post_views';
				$params['order']            = 'DESC';
				$params['date_query']       = array(
					array(
						'after'  => '1 year ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'top_review' :
				$params['meta_key'] = 'foxiz_review_average';
				$params['orderby']  = 'meta_value';
				$params['order']    = 'DESC';

				break;

			case 'last_review' :
				$params['meta_key'] = 'foxiz_review_average';
				$params['orderby']  = 'date';
				$params['order']    = 'DESC';
				break;

			case 'sponsored' :
				$params['meta_key'] = 'foxiz_sponsored';
				$params['orderby']  = 'date';
				$params['order']    = 'DESC';
				break;

			case 'rand':
				$params['orderby'] = 'rand';
				break;
			case 'rand_w':
				$params['orderby']    = 'rand';
				$params['date_query'] = array(
					array(
						'after'  => '1 week ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'rand_m':
				$params['orderby']    = 'rand';
				$params['date_query'] = array(
					array(
						'after'  => '1 month ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'rand_3m':
				$params['orderby']    = 'rand';
				$params['date_query'] = array(
					array(
						'after'  => '3 months ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'rand_6m':
				$params['orderby']    = 'rand';
				$params['date_query'] = array(
					array(
						'after'  => '6 months ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'rand_y':
				$params['orderby']    = 'rand';
				$params['date_query'] = array(
					array(
						'after'  => '1 year ago',
						'column' => 'post_date_gmt',
					)
				);
				break;
			case 'alphabetical_order_decs':
				$params['orderby'] = 'title';
				$params['order']   = 'DECS';
				break;

			case 'alphabetical_order_asc':
				$params['orderby'] = 'title';
				$params['order']   = 'ASC';
				break;

			case 'by_input' :
				$params['orderby'] = 'post__in';
				break;

			case 'relevance' :
				$params['orderby'] = 'relevance';
				break;

			default :
				$params['orderby'] = 'date';
				break;
		}

		$_query = new WP_Query( $params );

		if ( count( $GLOBALS['foxiz_queried_ids'] ) ) {
			$_query->set( 'foxiz_queried_ids', $GLOBALS['foxiz_queried_ids'] );
		}
		if ( ! empty( $_query->posts ) && empty( $data['duplicate_allowed'] ) ) {
			$post_ids = wp_list_pluck( $_query->posts, 'ID' );
			if ( is_array( $post_ids ) ) {
				$GLOBALS['foxiz_queried_ids'] = array_unique( array_merge( $GLOBALS['foxiz_queried_ids'], $post_ids ) );
			}
		}

		do_action( 'foxiz_after_query', $_query, $data );

		return $_query;
	}
}

if ( ! function_exists( 'foxiz_query_related' ) ) {
	/**
	 * @param array $data
	 * @param int $paged
	 *
	 * @return WP_Query
	 */
	function foxiz_query_related( $data = array(), $paged = 1 ) {

		$defaults = array(
			'related_id'    => '',
			'no_found_rows' => false,
			'orderby'       => 'date'
		);

		$data                   = wp_parse_args( $data, $defaults );
		$data['where']          = foxiz_get_option( 'single_post_related_where', 'all' );
		$data['posts_per_page'] = foxiz_get_option( 'single_post_related_total' );
		if ( empty( $data['related_id'] ) ) {
			$data['related_id'] = get_the_ID();
		}

		$params                        = array();
		$params['ignore_sticky_posts'] = 1;
		$params['post_status']         = 'publish';
		$params['post_type']           = 'post';
		$params['orderby']             = $data['orderby'];
		$params['no_found_rows']       = boolval( $data['no_found_rows'] );
		$params['post__not_in']        = explode( ',', $data['related_id'] );

		if ( ! empty( $paged ) ) {
			$params['paged'] = $paged;
		}
		if ( ! empty( $data['offset'] ) ) {
			$params['offset'] = $data['offset'];
		}
		if ( ! empty( $data['posts_per_page'] ) ) {
			$params['posts_per_page'] = $data['posts_per_page'];
		} else {
			$params['posts_per_page'] = get_option( 'posts_per_page' );
		}

		if ( empty( $data['categories'] ) ) {
			$data['categories'] = array();
			$categories         = get_the_category( $data['related_id'] );
			if ( is_array( $categories ) ) {
				foreach ( $categories as $category ) {
					array_push( $data['categories'], $category->term_id );
				}
			}
		}

		if ( empty( $data['tags'] ) ) {
			$data['tags'] = array();
			$tags         = get_the_tags( $data['related_id'] );
			if ( is_array( $tags ) ) {
				foreach ( $tags as $tag ) {
					array_push( $data['tags'], $tag->slug );
				}
			}
		}

		if ( ! empty( $data['meta_key'] ) ) {
			$params['meta_key'] = $data['meta_key'];
		}

		switch ( $data['where'] ) {
			case 'all':
				if ( ! empty( $data['categories'] ) && ! empty( $data['tags'] ) ) {
					if ( empty( $data['format'] ) ) {
						$params['tax_query'] = array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'category',
								'field'    => 'term_id',
								'terms'    => $data['categories'],
							),
							array(
								'taxonomy' => 'post_tag',
								'field'    => 'slug',
								'terms'    => $data['tags'],
							),
						);
					} else {
						$params['tax_query'] = array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms'    => array( 'post-format-' . esc_attr( $data['format'] ) ),
							),
							array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'category',
									'field'    => 'term_id',
									'terms'    => $data['categories'],
								),
								array(
									'taxonomy' => 'post_tag',
									'field'    => 'slug',
									'terms'    => $data['tags'],
								),
							)
						);
					}
				} elseif ( empty( $data['categories'] ) && ! empty( $data['tags'] ) ) {
					$params['tag'] = $data['tags'];

					if ( ! empty( $data['format'] ) ) {
						$params['tax_query'] = array(
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms'    => array( 'post-format-' . esc_attr( $data['format'] ) ),
							),
						);
					}
				} elseif ( ! empty( $data['categories'] ) && empty( $data['tags'] ) ) {
					$params['cat'] = $data['categories'];
					if ( ! empty( $data['format'] ) ) {
						$params['tax_query'] = array(
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms'    => array( 'post-format-' . esc_attr( $data['format'] ) ),
							),
						);
					}
				}
				break;

			case 'tag' :
				if ( ! empty( $data['tags'] ) ) {
					$params['tag_slug__in'] = $data['tags'];
					if ( ! empty( $data['format'] ) ) {
						$params['tax_query'] = array(
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms'    => array( 'post-format-' . esc_attr( $data['format'] ) ),
							),
						);
					}
				}
				break;

			default :
				if ( ! empty( $data['categories'] ) ) {
					$params['cat'] = $data['categories'];
					if ( ! empty( $data['format'] ) ) {
						$params['tax_query'] = array(
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms'    => array( 'post-format-' . esc_attr( $data['format'] ) ),
							),
						);
					}
				}
				break;
		}

		$_query = new WP_Query( $params );

		/** set for pagination */
		$_query->set( 'query_for_template', 'related' );
		$_query->set( 'related_id', $data['related_id'] );

		return $_query;
	}
}