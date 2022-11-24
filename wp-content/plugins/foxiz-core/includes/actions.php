<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** actions */
add_action( 'wp_head', 'foxiz_bookmarklet_icons', 1 );
add_action( 'wp_head', 'foxiz_pingback_supported', 5 );
add_action( 'pre_get_posts', 'foxiz_blog_posts_per_page', 10 );
add_action( 'pre_get_posts', 'foxiz_filter_search', 20 );
add_action( 'init', 'foxiz_remove_plugin_hooks' );
add_action( 'save_post', 'foxiz_update_word_count', 100, 1 );
add_action( 'comment_post', 'foxiz_add_user_rating', 1 );
remove_filter( 'pre_term_description', 'wp_filter_kses' );

/** filters */
add_filter( 'upload_mimes', 'foxiz_svg_upload_supported', 10, 1 );
add_filter( 'wp_get_attachment_image_src', 'foxiz_gif_supported', 10, 4 );
add_filter( 'edit_comment_misc_actions', 'foxiz_edit_comment_review_form', 10, 2 );
add_filter( 'the_content', 'foxiz_filter_load_next_content', 999 );
add_filter( 'pvc_post_views_html', 'foxiz_remove_pvc_post_views', 999 );
add_filter( 'bcn_pick_post_term', 'foxiz_bcn_primary_category', 10, 4 );
add_filter( 'wpcf7_autop_or_not', '__return_false', 999 );

if ( ! function_exists( 'foxiz_pingback_supported' ) ):

	function foxiz_pingback_supported() {

		if ( is_singular() && pings_open() ) : ?>
            <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
		<?php endif;
	}
endif;

if ( ! function_exists( 'foxiz_bookmarklet_icons' ) ) :
	/**
	 * foxiz_bookmarklet_icon
	 */
	function foxiz_bookmarklet_icons() {

		$apple_icon = foxiz_get_option( 'icon_touch_apple' );
		$metro_icon = foxiz_get_option( 'icon_touch_metro' );

		if ( ! empty( $apple_icon['url'] ) ) : ?>
            <link rel="apple-touch-icon" href="<?php echo esc_url( $apple_icon['url'] ); ?>"/>
		<?php endif;

		if ( ! empty( $metro_icon['url'] ) ) : ?>
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="<?php echo esc_url( $metro_icon['url'] ); ?>"/>
		<?php endif;
	}
endif;

if ( ! function_exists( 'foxiz_svg_upload_supported' ) ) {
	/**
	 * @param $mime_types
	 *
	 * @return mixed
	 */
	function foxiz_svg_upload_supported( $mime_types ) {

		if ( foxiz_get_option( 'svg_supported' ) && current_user_can( 'administrator' ) ) {
			$mime_types['svg']  = 'image/svg+xml';
			$mime_types['svgz'] = 'image/svg+xml';
		}

		return $mime_types;
	}
}

if ( ! function_exists( 'foxiz_gif_supported' ) ) {
	/**
	 * @param $image
	 * @param $attachment_id
	 * @param $size
	 * @param $icon
	 *
	 * @return array|false
	 * gif support
	 */
	function foxiz_gif_supported( $image, $attachment_id, $size, $icon ) {

		if ( foxiz_get_option( 'gif_supported' ) && ! empty( $image[0] ) ) {
			$format = wp_check_filetype( $image[0] );

			if ( ! empty( $format ) && 'gif' === $format['ext'] && 'full' !== $size ) {
				return wp_get_attachment_image_src( $attachment_id, $size = 'full', $icon );
			}
		}

		return $image;
	}
}

if ( ! function_exists( 'foxiz_remove_plugin_hooks' ) ) {
	/**
	 * remove multiple authors
	 */
	function foxiz_remove_plugin_hooks() {

		global $multiple_authors_addon;
		if ( ! empty( $multiple_authors_addon ) ) {
			remove_filter( 'the_content', array( $multiple_authors_addon, 'filter_the_content' ) );
		}
	}
}

if ( ! function_exists( 'foxiz_update_word_count' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false|int|string[]
	 */
	function foxiz_update_word_count( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$content = get_post_field( 'post_content', $post_id );
		$count   = foxiz_count_content( $content );
		update_post_meta( $post_id, 'foxiz_content_total_word', $count );

		return $count;
	}
}

if ( ! function_exists( 'foxiz_remove_pvc_post_views' ) ) {
	/**
	 * @param $html
	 *
	 * @return false
	 */
	function foxiz_remove_pvc_post_views( $html ) {

		if ( is_single() ) {
			return false;
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'foxiz_add_user_rating' ) ) {
	/**
	 * @param $comment_id
	 * user rating
	 */
	function foxiz_add_user_rating( $comment_id ) {

		if ( ! empty( $_POST['comment_parent'] ) ) {
			return;
		}
		if ( isset( $_POST['rbrating'] ) && isset( $_POST['comment_post_ID'] ) && 'post' === get_post_type( absint( $_POST['comment_post_ID'] ) ) ) {

			if ( $_POST['rbrating'] > 5 || $_POST['rbrating'] < 0 ) {
				return;
			}
			update_comment_meta( $comment_id, 'rbrating', intval( $_POST['rbrating'] ), true );
			foxiz_calc_average_rating( absint( $_POST['comment_post_ID'] ) );
		}

		return;
	}
}

if ( ! function_exists( 'foxiz_edit_comment_review_form' ) ) {
	/**
	 * @param $output
	 * @param $comment
	 *
	 * @return mixed|string
	 */
	function foxiz_edit_comment_review_form( $output, $comment ) {

		$rating = get_comment_meta( $comment->comment_ID, 'rbrating', true );
		if ( empty( $rating ) ) {
			return $output;
		}

		$output .= '<div class="misc-pub-section rb-form-rating">';
		$output .= '<label id="rating-' . $comment->comment_ID . '">' . foxiz_html__( 'Your Rating', 'foxiz-core' ) . '</label>';
		$output .= '<select name="comment_meta[rbrating]" id="rating-' . get_the_ID() . '" class="rb-rating-selection">';
		for ( $i = 1; $i <= 5; $i ++ ) {
			if ( $i === intval( $rating ) ) {
				$output .= '<option value="' . $i . '" selected>' . $i . '</option>';
			} else {
				$output .= '<option value="' . $i . '">' . $i . '</option>';
			};
		}
		$output .= '</select></div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_filter_load_next_content' ) ) {
	/**
	 * @param $content
	 *
	 * @return array|mixed|string|string[]
	 */
	function foxiz_filter_load_next_content( $content ) {

		global $wp_query;
		if ( ! isset( $wp_query->query_vars['rbsnp'] ) || ! is_single() ) {
			return $content;
		} else {
			return str_replace( "(adsbygoogle = window.adsbygoogle || []).push({});", '', $content );
		}
	}
}

if ( ! function_exists( 'foxiz_blog_posts_per_page' ) ) {
	function foxiz_blog_posts_per_page( $query ) {

		if ( is_admin() ) {
			return false;
		}

		if ( $query->is_main_query() ) {

			/** set post_status */
			if ( $query->is_search() || $query->is_category() || $query->is_tag() || $query->is_author() || $query->is_archive() ) {

			}

			if ( $query->is_home() ) {
				$blog_posts_per_page = foxiz_get_option( 'blog_posts_per_page' );
				if ( ! empty( $blog_posts_per_page ) ) {
					$query->set( 'posts_per_page', intval( $blog_posts_per_page ) );
				}
			} elseif ( $query->is_search() ) {
				$posts_per_page = foxiz_get_option( 'search_posts_per_page' );
				if ( ! empty( $posts_per_page ) ) {
					$query->set( 'posts_per_page', absint( $posts_per_page ) );
				}
			} elseif ( $query->is_category() ) {

				$query->set( 'post_status', 'publish' );
				$category = $query->get_queried_object_id();

				$data = get_option( 'foxiz_category_meta', array() );
				if ( ! empty( $data[ $category ]['posts_per_page'] ) ) {
					$posts_per_page = $data[ $category ]['posts_per_page'];
				} else {
					$posts_per_page = foxiz_get_option( 'category_posts_per_page' );
				}
				if ( ! empty( $posts_per_page ) ) {
					$query->set( 'posts_per_page', absint( $posts_per_page ) );
				}
				if ( ! empty( $data[ $category ]['tag_not_in'] ) ) {
					$tags    = explode( ',', $data[ $category ]['tag_not_in'] );
					$tags    = array_unique( $tags );
					$tag_ids = array();
					foreach ( $tags as $tag ) {
						$tag = get_term_by( 'slug', trim( $tag ), 'post_tag' );
						if ( ! empty( $tag->term_id ) ) {
							array_push( $tag_ids, $tag->term_id );
						}
					}
					if ( count( $tag_ids ) ) {
						$query->set( 'tag__not_in', $tag_ids );
					}
				}
			} elseif ( $query->is_author() ) {
				$author_posts_per_page = foxiz_get_option( 'author_posts_per_page' );
				if ( ! empty( $author_posts_per_page ) ) {
					$query->set( 'posts_per_page', intval( $author_posts_per_page ) );
				}
			} elseif ( $query->is_archive() ) {
				$query->set( 'post_status', 'publish' );

				$posts_per_page = foxiz_get_option( 'archive_posts_per_page' );
				if ( ! empty( $posts_per_page ) ) {
					$query->set( 'posts_per_page', absint( $posts_per_page ) );
				}
			}
		}

		return false;
	}
}

if ( ! function_exists( 'foxiz_filter_search' ) ) {
	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	function foxiz_filter_search( $query ) {

		if ( is_admin() ) {
			return $query;
		}

		$only_post = foxiz_get_option( 'search_only_post' );
		if ( ! empty( $only_post ) && $query->is_search() && $query->is_main_query() ) {
			$query->set( 'post_type', 'post' );
		}

		return $query;
	}
}

if ( ! function_exists( 'foxiz_bcn_primary_category' ) ) {
	/**
	 * @param $terms
	 * @param $id
	 * @param $type
	 * @param $taxonomy
	 *
	 * @return array|false|WP_Error|WP_Term|null
	 */
	function foxiz_bcn_primary_category( $terms, $id, $type, $taxonomy ) {

		if ( 'post' === $type ) {
			$primary_category = rb_get_meta( 'primary_category', $id );

			if ( empty( $primary_category ) ) {
				return $terms;
			};

			return get_term_by( 'id', $primary_category, $taxonomy );
		}

		return $terms;
	}
}