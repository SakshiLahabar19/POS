<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_single_open_tag' ) ) {
	/**
	 * @param string $classes
	 */
	function foxiz_single_open_tag( $classes = '' ) {

		if ( is_sticky() ) {
			$classes .= ' sticky';
		}

		$classes = trim( $classes );

		if ( foxiz_get_single_setting( 'article_markup' ) && ! foxiz_conflict_schema() ) {
			echo '<article id="post-' . get_the_ID() . '" class="' . esc_attr( implode( ' ', get_post_class( $classes ) ) ) . '" itemscope itemtype="' . foxiz_protocol() . '://schema.org/Article">';
		} else {
			echo '<article id="post-' . get_the_ID() . '" class="' . esc_attr( implode( ' ', get_post_class( $classes ) ) ) . '">';
		}
	}
}

if ( ! function_exists( 'foxiz_single_close_tag' ) ) {
	function foxiz_single_close_tag() {

		echo '</article>';
	}
}

if ( ! function_exists( 'foxiz_single_title' ) ) {
	/**
	 * @param string $classes
	 */
	function foxiz_single_title( $classes = '' ) {

		$class_name = 's-title';
		if ( ! empty( $classes ) ) {
			$class_name .= ' ' . esc_attr( $classes );
		}
		if ( foxiz_get_single_setting( 'article_markup' ) && ! foxiz_conflict_schema() ) :
			?><h1 class="<?php echo trim( $class_name ); ?>" itemprop="headline"><?php the_title(); ?></h1><?php
		else : ?>
            <h1 class="<?php echo trim( $class_name ); ?>"><?php the_title(); ?></h1>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_single_tagline' ) ) {
	/**
	 * @param string $classes
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_tagline( $classes = '', $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$tagline  = rb_get_meta( 'tagline', $post_id );
		$html_tag = rb_get_meta( 'tagline_tag', $post_id );
		if ( empty( $tagline ) ) {
			return false;
		}
		if ( empty( $html_tag ) ) {
			$html_tag = foxiz_get_option( 'tagline_tag' );
		}
		if ( empty( $html_tag ) ) {
			$html_tag = 'h3';
		}
		$class_name = 's-tagline';
		if ( ! empty( $classes ) ) {
			$class_name .= ' ' . $classes;
		} ?>
        <<?php echo esc_attr( $html_tag ); ?> class="<?php echo esc_attr( $class_name ); ?>"><?php echo wp_kses( $tagline, 'foxiz' ); ?></<?php echo esc_attr( $html_tag ); ?>>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_entry_category' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_entry_category() {

		$entry_category = foxiz_get_option( 'single_post_entry_category' );
		if ( empty( $entry_category ) ) {
			return false;
		}

		$classes = 's-cats';
		$parse   = explode( ',', $entry_category );
		if ( ! empty( $parse[0] ) ) {
			$classes .= ' ecat-' . $parse[0];
		}
		if ( ! empty( $parse[1] ) ) {
			$classes .= ' ecat-size-' . $parse[1];
		}
		if ( foxiz_get_option( 'single_post_entry_category_size' ) ) {
			$classes .= ' custom-size';
		}
		$settings = array( 'entry_category' => true );
		if ( empty( foxiz_get_option( 'single_post_primary_category' ) ) ) {
			$settings['is_singular'] = true;
		}
		?>
        <div class="<?php echo esc_attr( $classes ); ?>">
			<?php echo foxiz_get_entry_categories( $settings ); ?>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_single_sidebar' ) ) {
	function foxiz_single_sidebar( $name = '' ) {

		global $wp_query;

		if ( empty( $name ) ) {
			return false;
		}
		if ( isset( $wp_query->query_vars['rbsnp'] ) && foxiz_get_option( 'ajax_next_sidebar_name' ) ) {
			$name = foxiz_get_option( 'ajax_next_sidebar_name' );
		}
		if ( is_active_sidebar( $name ) ) { ?>
            <div class="sidebar-wrap single-sidebar">
                <div class="sidebar-inner clearfix">
					<?php dynamic_sidebar( $name ); ?>
                </div>
            </div>
		<?php }
	}
}

if ( ! function_exists( 'foxiz_single_standard_featured' ) ) {
	/**
	 * @param string $size
	 * @param string $classes
	 *
	 * @return false
	 */
	function foxiz_single_standard_featured( $size = 'full', $classes = '' ) {

		if ( ! has_post_thumbnail() ) {
			return false;
		}
		$class_name   = array();
		$class_name[] = 's-feat';
		if ( ! empty( $classes ) ) {
			$class_name[] = $classes;
		} ?>
        <div class="<?php echo join( ' ', $class_name ); ?>">
			<?php the_post_thumbnail( $size ); ?>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_single_featured_caption' ) ) {
	/**
	 * @param string $post_id
	 */
	function foxiz_get_single_featured_caption( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$caption     = rb_get_meta( 'featured_caption', $post_id );
		$attribution = rb_get_meta( 'featured_attribution', $post_id );
		if ( empty( $caption ) ) {
			$caption = get_the_post_thumbnail_caption();
		}

		if ( empty( $caption ) ) {
			return false;
		}

		$output = '<div class="feat-caption meta-text">';
		$output .= '<span class="caption-text meta-bold">' . $caption . '</span>';
		if ( ! empty( $attribution ) ) {
			$output .= '<em class="attribution">' . $attribution . '</em>';
		}
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_single_featured_caption' ) ) {
	/**
	 * @param string $post_id
	 */
	function foxiz_single_featured_caption( $post_id = '' ) {

		echo foxiz_get_single_featured_caption( $post_id );
	}
}

if ( ! function_exists( 'foxiz_single_sponsor' ) ) {
	/**
	 * @param string $post_id
	 * @param string $class_name
	 */
	function foxiz_single_sponsor( $post_id = '', $class_name = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		} ?>
        <aside class="smeta-in single-sponsor">
			<?php echo foxiz_get_entry_sponsored( $post_id ); ?>
        </aside>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_single_share_left' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_get_single_share_left( $post_id = '' ) {

		if ( foxiz_is_amp() && foxiz_get_option( 'amp_disable_left_share' ) ) {
			return false;
		}

		if ( ! foxiz_get_option( 'share_left' ) || ! function_exists( 'foxiz_render_share_list' ) ) {
			return false;
		}

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$settings = array(
			'facebook'      => foxiz_get_option( 'share_left_facebook' ),
			'twitter'       => foxiz_get_option( 'share_left_twitter' ),
			'pinterest'     => foxiz_get_option( 'share_left_pinterest' ),
			'whatsapp'      => foxiz_get_option( 'share_left_whatsapp' ),
			'linkedin'      => foxiz_get_option( 'share_left_linkedin' ),
			'tumblr'        => foxiz_get_option( 'share_left_tumblr' ),
			'reddit'        => foxiz_get_option( 'share_left_reddit' ),
			'vk'            => foxiz_get_option( 'share_left_vk' ),
			'telegram'      => foxiz_get_option( 'share_left_telegram' ),
			'email'         => foxiz_get_option( 'share_left_email' ),
			'copy'          => foxiz_get_option( 'share_left_copy' ),
			'print'         => foxiz_get_option( 'share_left_print' ),
			'tipsy_gravity' => 'w'
		);

		if ( is_rtl() ) {
			$settings['tipsy_gravity'] = 'e';
		}
		if ( ! array_filter( $settings ) ) {
			return false;
		}
		$settings['post_id'] = $post_id;

		$classes       = 'l-shared-sec-outer';
		$inner_classes = 'l-shared-items effect-fadeout';

		if ( foxiz_get_option( 'share_left_color', false ) ) {
			$inner_classes .= ' is-color';
		}
		if ( foxiz_get_option( 'share_left_mobile' ) ) {
			$classes .= ' show-mobile';
		}
		ob_start();
		?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <div class="l-shared-sec">
                <div class="l-shared-header meta-text">
                    <i class="rbi rbi-share"></i><span class="share-label"><?php foxiz_html_e( 'SHARE', 'foxiz' ); ?></span>
                </div>
                <div class="<?php echo esc_attr( $inner_classes ); ?>">
					<?php foxiz_render_share_list( $settings ); ?>
                </div>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_single_share_top' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_share_top( $post_id = '' ) {

		$share_top = foxiz_get_option( 'share_top' );
		if ( empty( $share_top ) || ! function_exists( 'foxiz_render_share_list' ) ) {
			return false;
		}
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$settings = array(
			'facebook'  => foxiz_get_option( 'share_top_facebook' ),
			'twitter'   => foxiz_get_option( 'share_top_twitter' ),
			'pinterest' => foxiz_get_option( 'share_top_pinterest' ),
			'whatsapp'  => foxiz_get_option( 'share_top_whatsapp' ),
			'linkedin'  => foxiz_get_option( 'share_top_linkedin' ),
			'tumblr'    => foxiz_get_option( 'share_top_tumblr' ),
			'reddit'    => foxiz_get_option( 'share_top_reddit' ),
			'vk'        => foxiz_get_option( 'share_top_vk' ),
			'telegram'  => foxiz_get_option( 'share_top_telegram' ),
			'email'     => foxiz_get_option( 'share_top_email' ),
			'copy'      => foxiz_get_option( 'share_top_copy' ),
			'print'     => foxiz_get_option( 'share_top_print' ),
		);
		if ( ! array_filter( $settings ) ) {
			return false;
		}
		$settings['post_id'] = $post_id;
		$classes             = 't-shared-sec tooltips-n';
		if ( foxiz_get_option( 'single_post_min_read' ) ) {
			$classes .= ' has-read-meta';
		}
		if ( foxiz_get_option( 'share_top_color', false ) ) {
			$classes .= ' is-color';
		} ?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <div class="t-shared-header is-meta">
                <i class="rbi rbi-share"></i><span class="share-label"><?php foxiz_html_e( 'Share', 'foxiz' ); ?></span>
            </div>
            <div class="effect-fadeout"><?php foxiz_render_share_list( $settings ); ?></div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_header_meta' ) ) {
	function foxiz_single_header_meta() {

		$post_id      = get_the_ID();
		$class_name   = array();
		$class_name[] = 'single-meta';
		if ( ! foxiz_get_option( 'single_post_avatar' ) ) {
			$class_name[] = 'none-avatar';
		}
		if ( ! foxiz_get_option( 'single_post_updated_meta' ) ) {
			$class_name[] = 'none-updated';
		} ?>
        <div class="<?php echo join( ' ', $class_name ); ?>">
			<?php if ( foxiz_is_sponsored_post( $post_id ) ) :
				foxiz_single_sponsor( $post_id );
			else : ?>
                <div class="smeta-in">
					<?php foxiz_single_meta_avatar(); ?>
                    <div class="smeta-sec">
						<?php foxiz_single_meta_updated( $post_id ); ?>
                        <div class="p-meta">
                            <div class="meta-inner is-meta"><?php echo '' . foxiz_get_single_entry_meta() . ''; ?></div>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
            <div class="smeta-extra">
				<?php
				foxiz_single_share_top( $post_id );
				foxiz_single_meta_time_read( $post_id );
				?>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_meta_avatar' ) ) {
	function foxiz_single_meta_avatar() {

		if ( ! foxiz_get_option( 'single_post_avatar' ) ) {
			return false;
		}
		foxiz_entry_meta_avatar( array(
			'avatar_size' => 120
		) );
	}
}

if ( ! function_exists( 'foxiz_get_single_entry_meta' ) ) {
	/**
	 * @return false|string
	 */
	function foxiz_get_single_entry_meta() {

		$meta = foxiz_get_option( 'single_post_entry_meta' );
		if ( ! is_array( $meta ) || ! array_filter( $meta ) ) {
			return false;
		}
		$settings = array(
			'tablet_hide_meta' => foxiz_get_option( 'single_post_tablet_hide_meta' ),
			'mobile_hide_meta' => foxiz_get_option( 'single_post_mobile_hide_meta' ),
			'is_single_meta'   => true
		);

		ob_start();
		foreach ( $meta as $key ) {
			switch ( $key ) {
				case 'avatar' :
					foxiz_entry_meta_avatar( $settings );
					break;
				case 'date' :
					foxiz_entry_meta_date( $settings );
					break;
				case 'author' :
					foxiz_entry_meta_author( $settings, foxiz_get_option( 'single_post_author_job' ) );
					break;
				case 'category' :
					foxiz_entry_meta_category( $settings );
					break;
				case 'tag' :
					foxiz_entry_meta_tag( $settings );
					break;
				case 'comment' :
					foxiz_entry_meta_comment( $settings );
					break;
				case 'view' :
					foxiz_entry_meta_view( $settings );
					break;
				case 'update' :
					foxiz_entry_meta_updated( $settings );
					break;
				case 'read' :
					foxiz_entry_meta_read_time( $settings );
					break;
				case 'custom' :
					foxiz_entry_meta_user_custom( $settings );
					break;
			};
		}

		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_single_meta_updated' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_meta_updated( $post_id = '' ) {

		$updated = foxiz_get_option( 'single_post_updated_meta' );
		$format  = foxiz_get_option( 'single_post_update_format' );
		if ( empty( $updated ) ) {
			return false;
		}
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		if ( empty( $format ) ) {
			$format = 'Y/m/d \a\t g:i A';
		}
		?>
        <div class="single-updated-info meta-text">
            <time class="updated-date" datetime="<?php echo date( DATE_W3C, get_the_modified_date( 'U', get_the_ID() ) ); ?>"><?php echo foxiz_html__( 'Last updated:', 'foxiz' ) . ' ' . get_the_modified_date( $format, $post_id ); ?></time>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_single_meta_time_read' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_meta_time_read( $post_id = '' ) {

		if ( ! foxiz_get_option( 'single_post_min_read' ) ) {
			return false;
		}
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		} ?>
        <div class="single-time-read is-meta">
			<?php foxiz_entry_meta_read_time( $post_id ); ?>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_content' ) ) {
	/**
	 * single entry
	 */
	function foxiz_single_content() {

		$class_name = 's-ct-wrap';
		if ( foxiz_get_single_share_left() ) {
			$class_name .= ' has-lsl';
		}
		$entry_class_name = 'entry-content rbct clearfix';
		if ( foxiz_get_option( 'single_post_highlight_shares' ) ) {
			$entry_class_name .= ' is-highlight-shares';
		} ?>
        <div class="<?php echo esc_attr( $class_name ); ?>">
            <div class="s-ct-inner">
				<?php if ( foxiz_get_single_share_left() ) {
					echo foxiz_get_single_share_left();
				} ?>
                <div class="e-ct-outer">
					<?php
					foxiz_single_entry_top();
					foxiz_single_highlights();
					foxiz_single_page_selected();
					foxiz_single_quick_info();
					echo '<div class="' . esc_attr( $entry_class_name ) . '" itemprop="articleBody">';
					the_content();
					echo '</div>';
					foxiz_single_review();
					foxiz_single_link_pages();
					foxiz_single_entry_bottom();
					if ( ! empty ( foxiz_get_single_entry_footer() ) ) {
						echo foxiz_get_single_entry_footer();
					}
					foxiz_single_newsletter();
					if ( class_exists( 'Foxiz_Optimized' ) ) {
						Foxiz_Optimized::get_instance()->article_markup();
					} ?>
                </div>
            </div>
			<?php
			foxiz_single_share_bottom();
			if ( foxiz_get_single_setting( 'ajax_next_post' ) && foxiz_get_option( 'share_sticky' ) ) {
				echo '<div class="sticky-share-list-buffer">' . foxiz_get_single_share_sticky( get_the_ID() ) . '</div>';
			}
			foxiz_single_reaction();
			?>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_single_link_pages' ) ) {
	function foxiz_single_link_pages() {

		/** make theme check happy */
		if ( false ) {
			wp_link_pages();

			return;
		}

		echo foxiz_get_single_link_pages();
	}
}

if ( ! function_exists( 'foxiz_get_single_link_pages' ) ) {
	/**
	 * @return false|string
	 */
	function foxiz_get_single_link_pages() {

		global $page, $numpages, $multipage, $more;

		if ( ! $multipage ) {
			return false;
		}
		$prev = $page - 1;
		$next = $page + 1;

		$output = '<aside class="pagination-wrap page-links">';
		if ( $prev > 0 ) {
			$output .= '<span class="text-link-prev">';
			$output .= _wp_link_page( $prev ) . '<i class="rbi rbi-cleft"></i><span>' . foxiz_html__( 'Previous Page', 'foxiz' ) . '</span></a>';
			$output .= '</span>';
		}
		$output .= '<span class="number-links">';
		for ( $i = 1; $i <= $numpages; $i ++ ) {
			$link = str_replace( '%', $i, '%' );
			if ( $i !== $page || ! $more && 1 === $page ) {
				$link = _wp_link_page( $i ) . $link . '</a>';
			} elseif ( $i === $page ) {
				$link = '<span class="post-page-numbers current" aria-current="page">' . $link . '</span>';
			}
			$output .= $link;
		}
		$output .= '</span>';
		if ( $next <= $numpages ) {
			$output .= '<span class="text-link-next">';
			$output .= _wp_link_page( $next ) . '<span>' . foxiz_html__( 'Next Page', 'foxiz' ) . '</span><i class="rbi rbi-cright"></i></a>';
			$output .= '</span>';
		}
		$output .= '</aside>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_single_simple_content' ) ) {
	function foxiz_single_simple_content() {

		$entry_classes = 'entry-content rbct';
		if ( foxiz_is_wc_pages() ) {
			$entry_classes = 'wc-entry-content';
		} ?>
        <div class="s-ct-inner">
            <div class="e-ct-outer">
                <div class="<?php echo esc_attr( $entry_classes ); ?>">
					<?php
					the_content();
					echo '<div class="clearfix"></div>';
					foxiz_single_link_pages();
					?>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_get_single_entry_footer' ) ) {
	/**
	 * @return false
	 */
	function foxiz_get_single_entry_footer() {

		ob_start();
		foxiz_single_tags();
		foxiz_single_sources();
		foxiz_single_via();
		$output = ob_get_clean();
		if ( ! empty( $output ) ) {
			return '<div class="efoot">' . $output . '</div>';
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'foxiz_single_tags' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_tags() {

		if ( ! foxiz_get_option( 'single_post_tags' ) || ! get_the_tag_list() ) {
			return false;
		} ?>
        <div class="efoot-bar tag-bar">
            <span class="blabel is-meta"><i class="rbi rbi-tag"></i><?php echo foxiz_html__( 'TAGGED:', 'foxiz' ); ?></span>
            <span class="tags-list h5"><?php echo get_the_tag_list( '', ', ' ); ?></span>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_sources' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_sources() {

		if ( ! foxiz_get_option( 'single_post_sources' ) ) {
			return false;
		}
		$sources = rb_get_meta( 'source_data' );
		if ( ! is_array( $sources ) || ! count( $sources ) ) {
			return false;
		}
		$links = array();
		foreach ( $sources as $source ) {
			if ( ! empty( $source['name'] ) && ! empty( $source['url'] ) ) {
				$links[] = '<a href="' . esc_url( $source['url'] ) . '" rel="nofollow" target="_blank">' . esc_html( $source['name'] ) . '</a>';
			}
		}
		if ( empty( $links ) ) {
			return false;
		}
		?>
        <div class="efoot-bar source-bar">
            <span class="blabel is-meta"><i class="rbi rbi-archive"></i><?php echo foxiz_html__( 'SOURCES:', 'foxiz' ); ?></span>
            <span class="sources-list h5"><?php echo implode( ', ', $links ); ?></span>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_via' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_via() {

		if ( ! foxiz_get_option( 'single_post_via' ) ) {
			return false;
		}
		$via = rb_get_meta( 'via_data' );
		if ( ! is_array( $via ) || ! count( $via ) ) {
			return false;
		}
		$links = array();
		foreach ( $via as $item ) {
			if ( ! empty( $item['name'] ) && ! empty( $item['url'] ) ) {
				$links[] = '<a href="' . esc_url( $item['url'] ) . '" rel="nofollow" target="_blank">' . esc_html( $item['name'] ) . '</a>';
			}
		}
		if ( empty( $links ) ) {
			return false;
		}
		?>
        <div class="efoot-bar via-bar">
            <span class="blabel is-meta"><i class="rbi rbi-via"></i><?php echo foxiz_html__( 'VIA:', 'foxiz' ); ?></span>
            <span class="sources-list h5"><?php echo implode( ', ', $links ); ?></span>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_author_box' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_author_box() {

		if ( foxiz_is_amp() && foxiz_get_option( 'amp_disable_author' ) ) {
			return false;
		}

		if ( ! foxiz_get_option( 'single_post_author_card' ) ) {
			return false;
		}

		if ( function_exists( 'get_post_authors' ) ) {
			$author_data = get_post_authors( get_the_ID() );
			if ( is_array( $author_data ) && count( $author_data ) > 1 ) {
				echo '<div class="usr-holder multiple-ubox entry-sec">';
				foreach ( $author_data as $author ) {
					echo foxiz_get_author_info( $author->ID );
				}
				echo '</div>';

				return false;
			}
		}

		if ( foxiz_get_author_info( get_the_author_meta( 'ID' ) ) ) {
			echo '<div class="usr-holder entry-sec">' . foxiz_get_author_info( get_the_author_meta( 'ID' ) ) . '</div>';
		}
	}
}

if ( ! function_exists( 'foxiz_single_reaction' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_reaction() {

		if ( ! shortcode_exists( 'ruby_reaction' ) || ! foxiz_get_single_setting( 'reaction' ) || foxiz_is_amp() ) {
			return false;
		}

		$reaction_title = foxiz_get_option( 'single_post_reaction_title' );
		if ( empty( $reaction_title ) ) {
			$reaction_title = foxiz_html__( 'What do you think?', 'foxiz' );
		} ?>
        <aside class="reaction-sec entry-sec">
            <div class="reaction-heading">
                <span class="h3"><?php echo esc_html( apply_filters( 'the_title', $reaction_title, 12 ) ); ?></span>
            </div>
            <div class="reaction-sec-content">
				<?php echo do_shortcode( '[ruby_reaction]' ); ?>
            </div>
        </aside>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_share_bottom' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_share_bottom( $post_id = '' ) {

		$share_bottom = foxiz_get_option( 'share_bottom' );
		if ( empty( $share_bottom ) || ! function_exists( 'foxiz_render_share_list' ) ) {
			return false;
		}
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$settings = array(
			'facebook'  => foxiz_get_option( 'share_bottom_facebook' ),
			'twitter'   => foxiz_get_option( 'share_bottom_twitter' ),
			'pinterest' => foxiz_get_option( 'share_bottom_pinterest' ),
			'whatsapp'  => foxiz_get_option( 'share_bottom_whatsapp' ),
			'linkedin'  => foxiz_get_option( 'share_bottom_linkedin' ),
			'tumblr'    => foxiz_get_option( 'share_bottom_tumblr' ),
			'reddit'    => foxiz_get_option( 'share_bottom_reddit' ),
			'vk'        => foxiz_get_option( 'share_bottom_vk' ),
			'telegram'  => foxiz_get_option( 'share_bottom_telegram' ),
			'email'     => foxiz_get_option( 'share_bottom_email' ),
			'copy'      => foxiz_get_option( 'share_bottom_copy' ),
			'print'     => foxiz_get_option( 'share_bottom_print' ),
		);
		if ( ! array_filter( $settings ) ) {
			return false;
		}
		$settings['post_id']     = $post_id;
		$settings['social_name'] = true;

		$class_name = 'rbbsl tooltips-n effect-fadeout';
		if ( foxiz_get_option( 'share_bottom_color', false ) ) {
			$class_name .= ' is-bg';
		} ?>
        <div class="e-shared-sec entry-sec">
            <div class="e-shared-header h4">
                <i class="rbi rbi-share"></i><span><?php foxiz_html_e( 'Share this Article', 'foxiz' ); ?></span>
            </div>
            <div class="<?php echo esc_attr( $class_name ); ?>">
				<?php foxiz_render_share_list( $settings ); ?>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_comment' ) ) {
	/**
	 * @param false $is_page
	 *
	 * @return false
	 */
	function foxiz_single_comment( $is_page = false ) {

		if ( post_password_required() || ! comments_open() || foxiz_get_option( 'single_post_comment' ) || ( foxiz_is_amp() && foxiz_get_option( 'amp_disable_comment' ) ) ) {
			return false;
		}

		$user_rating = foxiz_get_single_setting( 'user_can_review' );

		if ( ( '1' === (string) $user_rating && foxiz_is_review_post() ) || '2' === (string) $user_rating ) {
			comments_template( '/templates/single/review-comment.php' );

			return false;
		}

		global $wp_query;
		$button = foxiz_get_option( 'single_post_comment_button' );
		if ( isset( $wp_query->query_vars['rbsnp'] ) ) {
			$button = foxiz_get_option( 'ajax_next_comment_button' );
		}

		/** disable button amp */
		if ( foxiz_is_amp() ) {
			$button = false;
		}

		$class_name = 'comment-holder';
		if ( ! get_comments_number() ) {
			$class_name .= ' no-comment';
		}
		if ( ! empty( $button ) && ! is_page() ) {
			$class_name .= ' is-hidden';
		} ?>
        <div class="comment-box-wrap entry-sec">
            <div class="comment-box-header">
				<?php if ( $button ) : ?>
                    <span class="comment-box-title h3"><i class="rbi rbi-comment"></i><span class="is-invisible"><?php echo foxiz_get_comment_heading( get_the_ID() ); ?></span></span>
                    <a href="#" class="show-post-comment"><i class="rbi rbi-comment"></i><?php echo foxiz_get_comment_heading( get_the_ID() ); ?>
                    </a>
				<?php else: ?>
                    <span class="h3"><i class="rbi rbi-comment"></i><?php echo foxiz_get_comment_heading( get_the_ID() ); ?></span>
				<?php endif; ?>
            </div>
            <div class="<?php echo esc_attr( $class_name ); ?>"><?php comments_template(); ?></div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_review_heading' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return mixed|string
	 */
	function foxiz_get_review_heading( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$output = foxiz_html__( 'Leave a review', 'foxiz' );
		$count  = intval( get_comments_number( $post_id ) );
		if ( $count > 1 ) {
			$output = sprintf( foxiz_html__( '%s Reviews', 'foxiz' ), $count );
		} elseif ( 1 === $count ) {
			$output = foxiz_html__( '1 Review', 'foxiz' );
		}

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_comment_heading' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return mixed|string
	 */
	function foxiz_get_comment_heading( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$output = foxiz_html__( 'Leave a comment', 'foxiz' );
		$count  = intval( get_comments_number( $post_id ) );

		if ( $count > 1 ) {
			$output = sprintf( foxiz_html__( '%s Comments', 'foxiz' ), $count );
		} elseif ( 1 === $count ) {
			$output = foxiz_html__( '1 Comment', 'foxiz' );
		}

		return $output;
	}
}

if ( ! function_exists( 'foxiz_single_newsletter' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_newsletter() {

		if ( ! foxiz_get_option( 'single_post_newsletter' ) || ! do_shortcode( '[ruby_static_newsletter]' ) ) {
			return false;
		} ?>
        <div class="entry-newsletter"><?php echo do_shortcode( '[ruby_static_newsletter]' ); ?></div>
	<?php }
}

if ( ! function_exists( 'foxiz_user_review_list' ) ) {
	/**
	 * @param $comment
	 * @param $args
	 * @param $depth
	 */
	function foxiz_user_review_list( $comment, $args, $depth ) {

		$commenter = wp_get_current_commenter();
		if ( $commenter['comment_author_email'] ) {
			$moderation_note = foxiz_html__( 'Your review is awaiting moderation.', 'foxiz' );
		} else {
			$moderation_note = foxiz_html__( 'Your review is awaiting moderation. This is a preview, your review will be visible after it has been approved.', 'foxiz' );
		}
		$rating_value = get_comment_meta( $comment->comment_ID, 'rbrating', true ); ?>
        <li class="comment_container" id="comment-<?php comment_ID(); ?>">
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment-author vcard">
					<?php if ( ! $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					printf( '%s <span class="says">says:</span>', sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
                </div>
				<?php if ( '0' === (string) $comment->comment_approved ) : ?>
                    <em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
                <div class="comment-meta comment-metadata commentmetadata">
					<?php if ( ! empty( $rating_value ) ) : ?>
                        <span class="review-stars">
						<?php for ( $i = 1; $i <= 5; $i ++ ) {
							if ( $i <= $rating_value ) {
								echo '<i class="rbi rbi-star"></i>';
							} else {
								echo '<i class="rbi rbi-star-o"></i>';
							}
						} ?>
					</span>
					<?php endif;
					edit_comment_link( foxiz_html__( 'Edit', 'foxiz' ) ); ?>
                </div>
                <div class="comment-content">
					<?php comment_text(); ?>
                </div>
				<?php echo get_comment_reply_link(
					array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="comment-reply">',
							'after'     => '</span>',
						)
					)
				); ?>
            </article>
        </li>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_next_prev' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_next_prev() {

		if ( ! foxiz_get_option( 'single_post_next_prev' ) || ( foxiz_is_amp() && foxiz_get_option( 'amp_disable_single_pagination' ) ) ) {
			return false;
		}
		$post_previous = get_adjacent_post( false, '', true );
		$post_next     = get_adjacent_post( false, '', false );
		if ( empty( $post_previous ) && empty( $post_next ) ) {
			return false;
		}
		$classes = 'entry-sec entry-pagination e-pagi';
		if ( foxiz_get_option( 'single_post_next_prev_mobile' ) ) {
			$classes .= ' mobile-hide';
		}
		?>
        <div class="<?php echo esc_attr( $classes ); ?>">
            <div class="inner">
				<?php if ( ! empty( $post_previous ) ) : ?>
                    <div class="nav-el nav-left">
                        <a href="<?php echo get_permalink( $post_previous->ID ); ?>">
                            <span class="nav-label is-meta">
                                <i class="rbi rbi-angle-left"></i><span><?php echo foxiz_html__( 'Previous Article', 'foxiz' ); ?></span>
                            </span>
                            <span class="nav-inner">
								<?php echo get_the_post_thumbnail( $post_previous->ID, 'thumbnail' ); ?>
                                <span class="h4"><span class="p-url"><?php echo get_the_title( $post_previous->ID ); ?></span></span>
                            </span>
                        </a>
                    </div>
				<?php endif;
				if ( ! empty( $post_next ) ) : ?>
                    <div class="nav-el nav-right">
                        <a href="<?php echo get_permalink( $post_next->ID ); ?>">
                            <span class="nav-label is-meta">
                                <span><?php echo foxiz_html__( 'Next Article', 'foxiz' ); ?></span><i class="rbi rbi-angle-right"></i>
                            </span>
                            <span class="nav-inner">
                              <?php echo get_the_post_thumbnail( $post_next->ID, 'thumbnail' ); ?>
                             <span class="h4"><span class="p-url"><?php echo get_the_title( $post_next->ID ); ?></span></span>
                            </span>
                        </a>
                    </div>
				<?php endif; ?>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_single_entry_top' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_entry_top() {

		if ( foxiz_is_amp() ) {
			if ( function_exists( 'foxiz_amp_ad' ) ) {
				foxiz_amp_ad( array(
					'type'      => foxiz_get_option( 'amp_top_single_ad_type' ),
					'client'    => foxiz_get_option( 'amp_top_single_adsense_client' ),
					'slot'      => foxiz_get_option( 'amp_top_single_adsense_slot' ),
					'size'      => foxiz_get_option( 'amp_top_single_adsense_size' ),
					'custom'    => foxiz_get_option( 'amp_top_single_ad_code' ),
					'classname' => 'top-single-amp-ad amp-ad-wrap'
				) );
			}

			return false;
		}

		$setting = rb_get_meta( 'entry_top', get_the_ID() );
		if ( ( empty( $setting ) || '-1' !== (string) $setting ) && is_active_sidebar( 'foxiz_entry_top' ) ) : ?>
            <div class="entry-top">
				<?php dynamic_sidebar( 'foxiz_entry_top' ); ?>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_single_entry_bottom' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_entry_bottom() {

		if ( foxiz_is_amp() ) {
			if ( function_exists( 'foxiz_amp_ad' ) ) {
				foxiz_amp_ad( array(
					'type'      => foxiz_get_option( 'amp_bottom_single_ad_type' ),
					'client'    => foxiz_get_option( 'amp_bottom_single_adsense_client' ),
					'slot'      => foxiz_get_option( 'amp_bottom_single_adsense_slot' ),
					'size'      => foxiz_get_option( 'amp_bottom_single_adsense_size' ),
					'custom'    => foxiz_get_option( 'amp_bottom_single_ad_code' ),
					'classname' => 'bottom-single-amp-ad amp-ad-wrap'
				) );
			}

			return false;
		}

		$setting = rb_get_meta( 'entry_bottom', get_the_ID() );
		if ( ( empty( $setting ) || '-1' !== (string) $setting ) && is_active_sidebar( 'foxiz_entry_bottom' ) ) : ?>
            <div class="entry-bottom">
				<?php dynamic_sidebar( 'foxiz_entry_bottom' ); ?>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_single_highlights' ) ) {
	function foxiz_single_highlights() {

		$highlights = rb_get_meta( 'highlights', get_the_ID() );
		if ( ! is_array( $highlights ) || ! count( $highlights ) ) {
			return false;
		}
		$highlight_heading = foxiz_get_option( 'highlight_heading' );
		?>
        <div class="s-hl">
			<?php if ( ! empty( $highlight_heading ) ) : ?>
                <div class="s-hl-heading h1"><span><?php echo esc_html( $highlight_heading ); ?></span>
                </div>
			<?php endif; ?>
            <ul class="s-hl-content">
				<?php foreach ( $highlights as $data ) :
					if ( ! empty( $data['point'] ) ) : ?>
                        <li class="hl-point h5"><span><?php echo wp_kses( $data['point'], 'foxiz' ); ?></span>
                        </li>
					<?php endif;
				endforeach; ?>
            </ul>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_quick_info' ) ) {
	function foxiz_single_quick_info() {

		if ( ! foxiz_get_option( 'single_post_quick_view' ) ) {
			return false;
		}
		$post_id = get_the_ID();
		if ( foxiz_get_quick_view_sponsored( $post_id ) || foxiz_get_quick_view_review( $post_id ) ) { ?>
            <div class="sqview">
				<?php echo foxiz_get_quick_view_sponsored( $post_id ); ?>
				<?php echo foxiz_get_quick_view_review( $post_id ); ?>
            </div>
		<?php }
	}
}

if ( ! function_exists( 'foxiz_get_quick_view_sponsored' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_get_quick_view_sponsored( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		if ( ! foxiz_is_sponsored_post( $post_id ) ) {
			return false;
		}
		ob_start() ?>
        <div class="qview-box spon-qview">
			<?php echo foxiz_get_entry_sponsored( $post_id ); ?>
        </div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_quick_view_review' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false|string
	 */
	function foxiz_get_quick_view_review( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$settings = foxiz_get_review_settings( $post_id );
		if ( empty( $settings ) || ! is_array( $settings ) ) {
			return false;
		}
		ob_start(); ?>
        <div class="qview-box review-intro">
			<?php if ( ! empty( $settings['image'] ) ) : ?>
				<?php if ( ! is_array( $settings['image'] ) ) :
					if ( wp_get_attachment_image( $settings['image'] ) ) {
						echo '<div class="review-feat">' . wp_get_attachment_image( $settings['image'] ) . '</div>';
					} else if ( ! empty( $settings['image']['url'] ) ) : ?>
                        <div class="review-feat">
                            <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['image']['url'] ); ?>" height="<?php echo esc_attr( $settings['image']['height'] ); ?>" width="<?php echo esc_attr( $settings['image']['width'] ); ?>">
                        </div>
					<?php endif;
				endif;
			endif; ?>
            <div class="inner">
                <div class="review-heading">
					<?php if ( ! empty( $settings['title'] ) ) : ?>
                        <span class="h4"><?php echo esc_html( $settings['title'] ); ?></span>
					<?php endif;
					if ( 'star' === $settings['type'] )  :
						echo foxiz_get_review_stars( $settings['average'] );
					else:
						echo foxiz_get_review_line( $settings['average'] );
					endif;
					?>
                </div>
                <div class="meta-info">
					<?php if ( ! empty( $settings['average'] ) ) : ?>
                        <span class="average"><?php if ( ! empty( $settings['meta'] ) ) : ?>
                                <span class="meta-text"><span class="meta-description"><?php echo wp_kses( $settings['meta'], 'foxiz' ); ?></span></span>
							<?php endif; ?><span class="h2"><?php echo esc_html( $settings['average'] ); ?></span></span>
					<?php endif;
					if ( ! empty( $settings['button'] ) && ! empty( $settings['destination'] ) ) : ?>
                        <div class="review-action">
                            <a class="review-btn is-btn" href="<?php echo esc_url( $settings['destination'] ); ?>" target="_blank" rel="nofollow noreferrer"><?php
								echo wp_kses( $settings['button'], 'foxiz' ); ?></a>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_single_video_embed' ) ) {
	/**
	 * foxiz_single_video_embed
	 */
	function foxiz_single_video_embed() {

		$class_name = 'featured-embed embed-video';
		$floating   = foxiz_get_option( 'single_post_video_float' );
		if ( foxiz_get_single_setting( 'video_autoplay' ) && empty( get_query_var( 'rbsnp' ) ) ) {
			$class_name .= ' is-autoplay';
		}
		if ( $floating ) {
			$class_name .= ' floating-video';
		}
		if ( ! empty( foxiz_get_video_embed( get_the_ID() ) ) ) : ?>
            <div class="<?php echo esc_attr( $class_name ); ?>">
				<?php if ( foxiz_is_amp() ) :
					echo foxiz_get_video_embed( get_the_ID() );
				else : ?>
                    <div class="embed-holder">
						<?php if ( $floating ) : ?>
                            <div class="float-holder"><?php echo foxiz_get_video_embed( get_the_ID() ); ?></div>
						<?php else : ?>
							<?php echo foxiz_get_video_embed( get_the_ID() ); ?>
						<?php endif; ?>
                    </div>
				<?php endif; ?>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_single_audio_embed' ) ) {
	/**
	 * foxiz_single_audio_embed
	 */
	function foxiz_single_audio_embed() {

		$class_name = 'featured-embed embed-audio';
		if ( foxiz_get_single_setting( 'audio_autoplay' ) ) {
			$class_name .= ' is-autoplay';
		}
		if ( ! empty( foxiz_get_audio_embed( get_the_ID() ) ) ) : ?>
            <div class="<?php echo esc_attr( $class_name ); ?>">
                <div class="embed-holder"><?php echo foxiz_get_audio_embed( get_the_ID() ); ?></div>
            </div>
		<?php endif;
	}
}

/**
 * @param $data
 * @param $crop_size
 */
if ( ! function_exists( 'foxiz_amp_gallery' ) ) {
	function foxiz_amp_gallery( $data, $crop_size ) { ?>
        <div class="amp-gallery-wrap">
            <amp-carousel async width="1240" height="695" layout="responsive" type="slides">
				<?php foreach ( $data as $attachment_id ) {
					$image = wp_get_attachment_image_src( $attachment_id, 'full' );
					if ( $image ) {
						list( $src, $width, $height ) = $image;
						$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
						echo '<amp-img src="' . esc_html( $src ) . '" ' . image_hwstring( $width, $height ) . ' alt="' . esc_attr( $alt ) . '"></amp-img>';
					}
				} ?>
            </amp-carousel>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_single_gallery_slider' ) ) {
	/**
	 * @param string $crop_size
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_gallery_slider( $crop_size = 'full', $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$data = rb_get_meta( 'gallery_data', $post_id );
		if ( empty( $data ) ) {
			return false;
		}
		$data = explode( ',', $data );

		/** amp */
		if ( foxiz_is_amp() ) {
			foxiz_amp_gallery( $data, $crop_size );

			return false;
		}
		?>
        <div class="featured-gallery-wrap format-gallery-slider" data-gallery="<?php echo esc_attr( $post_id ); ?>">
            <div id="gallery-slider-<?php echo esc_attr( $post_id ); ?>" class="swiper-container gallery-slider pre-load">
                <div class="swiper-wrapper">
					<?php foreach ( $data as $attachment_id ) : ?>
                        <div class="swiper-slide">
                            <div class="slider-img-holder"><?php echo wp_get_attachment_image( $attachment_id, $crop_size ); ?></div>
							<?php echo foxiz_get_attachment_caption( $attachment_id, 'slider-caption' ); ?>
                        </div>
					<?php endforeach; ?>
                </div>
                <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $post_id ); ?>"></div>
            </div>
            <div class="gallery-slider-nav-outer">
                <div class="gallery-slider-info">
					<?php foxiz_render_svg( 'gallery' ); ?>
                    <div class="current-slider-info">
                        <span class="h4"><?php echo foxiz_html__( 'List of Images', 'foxiz' ); ?></span>
                        <span><span class="current-slider-count">1</span><?php echo '/' . esc_html( count( $data ) ); ?></span>
                    </div>
                </div>
                <div class="gallery-slider-nav-holder">
                    <div id="gallery-slider-nav-<?php echo esc_attr( $post_id ); ?>" class="swiper-container gallery-slider-nav">
                        <div class="swiper-wrapper pre-load">
							<?php foreach ( $data as $attachment_id ) : ?>
                                <div class="swiper-slide">
                                    <div class="slider-img-holder"><?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?></div>
                                </div>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_gallery_carousel' ) ) {
	/**
	 * @param string $crop_size
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_gallery_carousel( $crop_size = 'full', $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$data = rb_get_meta( 'gallery_data', $post_id );
		if ( empty( $data ) ) {
			return false;
		}
		$data = explode( ',', $data );

		/** amp */
		if ( foxiz_is_amp() ) {
			foxiz_amp_gallery( $data, $crop_size );

			return false;
		}
		?>
        <div class="featured-gallery-wrap format-gallery-carousel" data-gallery="<?php echo esc_attr( $post_id ); ?>">
            <div id="gallery-carousel-<?php echo esc_attr( $post_id ); ?>" class="swiper-container gallery-carousel pre-load">
                <div class="swiper-wrapper">
					<?php foreach ( $data as $attachment_id ) : ?>
                        <div class="swiper-slide">
                            <div class="carousel-img-holder"><?php echo wp_get_attachment_image( $attachment_id, $crop_size ); ?></div>
							<?php echo foxiz_get_attachment_caption( $attachment_id, 'slider-caption' ); ?>
                        </div>
					<?php endforeach; ?>
                </div>
                <div class="swiper-scrollbar swiper-scrollbar-<?php echo esc_attr( $post_id ); ?>"></div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_gallery_coverflow' ) ) {
	/**
	 * @param string $crop_size
	 * @param string $post_id
	 *
	 * @return false
	 */
	function foxiz_single_gallery_coverflow( $crop_size = 'full', $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$data = rb_get_meta( 'gallery_data', $post_id );
		if ( empty( $data ) ) {
			return false;
		}
		$data = explode( ',', $data );

		/** amp */
		if ( foxiz_is_amp() ) {
			foxiz_amp_gallery( $data, $crop_size );

			return false;
		}
		?>
        <div class="featured-gallery-wrap format-gallery-coverflow" data-gallery="<?php echo esc_attr( $post_id ); ?>">
            <div id="gallery-coverflow-<?php echo esc_attr( $post_id ); ?>" class="swiper-container gallery-coverflow pre-load">
                <div class="swiper-wrapper pre-load">
					<?php foreach ( $data as $attachment_id ) : ?>
                        <div class="swiper-slide">
                            <div class="coverflow-img-holder"><?php echo wp_get_attachment_image( $attachment_id, $crop_size ); ?></div>
                        </div>
					<?php endforeach; ?>
                </div>
                <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $post_id ); ?>"></div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_single_breadcrumb' ) ) {
	/**
	 * @return false|string
	 */
	function foxiz_get_single_breadcrumb() {

		if ( ! foxiz_get_option( 'single_post_breadcrumb' ) ) {
			return false;
		}

		return foxiz_get_breadcrumb( 's-breadcrumb' );
	}
}

if ( ! function_exists( 'foxiz_single_breadcrumb' ) ) {
	function foxiz_single_breadcrumb() {

		echo foxiz_get_single_breadcrumb();
	}
}

if ( ! function_exists( 'foxiz_single_sticky' ) ) {
	/**
	 * @return false
	 */
	function foxiz_single_sticky() {

		if ( ! is_singular( 'post' ) || ! foxiz_get_option( 'single_post_sticky_title' ) || foxiz_is_amp() ) {
			return false;
		}
		foxiz_single_sticky_html();
	}
}

if ( ! function_exists( 'foxiz_single_sticky_html' ) ) {
	function foxiz_single_sticky_html() {

		$post_id = get_queried_object_id();
		?>
        <div id="s-title-sticky" class="s-title-sticky">
            <div class="s-title-sticky-left">
                <span class="sticky-title-label"><?php foxiz_html_e( 'Reading:', 'foxiz' ); ?></span>
                <span class="h4 sticky-title"><?php echo get_the_title( $post_id ); ?></span>
            </div>
			<?php echo foxiz_get_single_share_sticky( $post_id ); ?>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_get_single_share_sticky' ) ) {
	/**
	 * @param $post_id
	 *
	 * @return false|string
	 */
	function foxiz_get_single_share_sticky( $post_id ) {

		if ( ! foxiz_get_option( 'share_sticky' ) || ! function_exists( 'foxiz_render_share_list' ) || foxiz_is_amp() || empty( $post_id ) ) {
			return false;
		}

		$settings = array(
			'facebook'      => foxiz_get_option( 'share_sticky_facebook' ),
			'twitter'       => foxiz_get_option( 'share_sticky_twitter' ),
			'pinterest'     => foxiz_get_option( 'share_sticky_pinterest' ),
			'whatsapp'      => foxiz_get_option( 'share_sticky_whatsapp' ),
			'linkedin'      => foxiz_get_option( 'share_sticky_linkedin' ),
			'tumblr'        => foxiz_get_option( 'share_sticky_tumblr' ),
			'reddit'        => foxiz_get_option( 'share_sticky_reddit' ),
			'vk'            => foxiz_get_option( 'share_sticky_vk' ),
			'telegram'      => foxiz_get_option( 'share_sticky_telegram' ),
			'email'         => foxiz_get_option( 'share_sticky_email' ),
			'copy'          => foxiz_get_option( 'share_sticky_copy' ),
			'print'         => foxiz_get_option( 'share_sticky_print' ),
			'tipsy_gravity' => 'n'
		);
		if ( ! array_filter( $settings ) ) {
			return false;
		}
		$settings['post_id'] = $post_id;
		$class_name          = 'sticky-share-list-items effect-fadeout';
		if ( foxiz_get_option( 'share_sticky_color' ) ) {
			$class_name .= ' is-color';
		}
		ob_start();
		?>
        <div class="sticky-share-list">
            <div class="t-shared-header meta-text">
                <i class="rbi rbi-share"></i><?php if ( foxiz_get_option( 'share_sticky_label' ) ) : ?>
                    <span class="share-label"><?php foxiz_html_e( 'Share', 'foxiz' ); ?></span><?php endif; ?>
            </div>
            <div class="<?php echo esc_attr( $class_name ); ?>"><?php foxiz_render_share_list( $settings ); ?></div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_reading_process_indicator' ) ) {
	/**
	 * @return false
	 */
	function foxiz_reading_process_indicator() {

		if ( ! is_singular( 'post' ) || ! foxiz_get_option( 'single_post_reading_indicator' ) || foxiz_is_amp() ) {
			return false;
		}

		$classes = 'reading-indicator';
		?>
        <div class="<?php echo esc_attr( $classes ); ?>"><span id="reading-progress"></span></div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_single_page_selected' ) ) {
	function foxiz_single_page_selected() {

		echo foxiz_get_single_page_selected();
	}
}

if ( ! function_exists( 'foxiz_get_single_page_selected' ) ) {
	/**
	 * @return string
	 */
	function foxiz_get_single_page_selected() {

		if ( foxiz_is_amp() ) {
			return false;
		}

		global $page, $numpages, $multipage, $more;

		$prev = $page - 1;
		$next = $page + 1;

		$headings = rb_get_meta( 'page_selected' );

		if ( ! $multipage || ! is_array( $headings ) || count( $headings ) < $numpages ) {
			return false;
		}

		$output = '<div class="page-selected-outer">';
		$output .= '<div class="page-selected-title meta-text"><span>' . foxiz_html__( 'Section', 'foxiz' ) . '</span></div>';
		$output .= '<div class="page-selected">';
		$output .= '<div class="page-selected-current">';
		if ( ! empty( $headings[ $prev ]['title'] ) ) {
			$output .= '<span class="h4">' . esc_html( $page . ' - ' . $headings[ $prev ]['title'] ) . '</span>';
		}
		$output .= '</div>';
		$output .= '<div class="page-selected-list">';
		$output .= '<div class="page-selected-list-inner">';
		for ( $i = 1; $i <= $numpages; $i ++ ) {
			$link  = '';
			$index = $i - 1;
			if ( ! empty( $headings[ $index ]['title'] ) ) {
				$link = $i . ' - ' . esc_html( $headings[ $index ]['title'] );
			}
			if ( $i !== $page || ! $more && 1 === $page ) {
				$link = '<div class="page-list-item h4">' . _wp_link_page( $i ) . $link . '</a></div>';
			} elseif ( $i === $page ) {
				$link = '<div class="page-list-item h4"><span class="post-page-numbers current">' . $link . '</span></div>';
			}
			$output .= $link;
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="page-selected-nav page-links">';
		$output .= '<div class="text-link-prev">';
		if ( $prev > 0 ) {
			$output .= _wp_link_page( $prev ) . '<i class="rbi rbi-cleft"></i></a>';
		} else {
			$output .= '<span class="post-page-numbers empty-link"><i class="rbi rbi-cleft"></i></span>';
		}
		$output .= '</div>';

		$output .= '<div class="text-link-next">';
		if ( $next <= $numpages ) {
			$output .= _wp_link_page( $next ) . '<i class="rbi rbi-cright"></i></a>';
		} else {
			$output .= '<span class="post-page-numbers empty-link"><i class="rbi rbi-cright"></i></span>';
		}
		$output .= '</div>';
		$output .= '</div>';

		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_single_inline_ad' ) ) {
	/**
	 * @return false|void
	 */
	function foxiz_get_single_inline_ad() {

		if ( ! foxiz_get_option( 'ad_single_code' ) && ! foxiz_get_option( 'ad_single_image' ) ) {
			return false;
		}

		$classes = 'inline-single-ad align' . foxiz_get_option( 'ad_single_align' );

		if ( foxiz_get_option( 'ad_single_type' ) ) {
			$settings = array(
				'code'         => foxiz_get_option( 'ad_single_code' ),
				'description'  => foxiz_get_option( 'ad_single_description' ),
				'size'         => foxiz_get_option( 'ad_single_size' ),
				'desktop_size' => foxiz_get_option( 'ad_single_desktop_size' ),
				'tablet_size'  => foxiz_get_option( 'ad_single_tablet_size' ),
				'mobile_size'  => foxiz_get_option( 'ad_single_mobile_size' ),
				'no_spacing'   => 1
			);
			if ( foxiz_get_adsense( $settings ) ) {
				return '<div class="' . esc_attr( $classes ) . '">' . foxiz_get_adsense( $settings ) . '</div>';
			}
		} else {
			$settings = array(
				'description' => foxiz_get_option( 'ad_single_description' ),
				'image'       => foxiz_get_option( 'ad_single_image' ),
				'dark_image'  => foxiz_get_option( 'ad_single_dark_image' ),
				'destination' => foxiz_get_option( 'ad_single_destination' ),
				'no_spacing'  => 1
			);
			if ( foxiz_get_ad_image( $settings ) ) {
				return '<div class="' . esc_attr( $classes ) . '">' . foxiz_get_ad_image( $settings ) . '</div>';
			}
		}
	}
}

add_filter( 'the_content', 'foxiz_add_single_inline_ad', 100 );

if ( ! function_exists( 'foxiz_add_single_inline_ad' ) ) {
	function foxiz_add_single_inline_ad( $content ) {

		if ( ! is_singular( 'post' ) ) {
			return $content;
		}

		$tag = '</p>';

		/** amp inline ad */
		if ( foxiz_is_amp() ) {
			$amp_buffer = foxiz_get_single_inline_amp_ad();
			if ( empty( $amp_buffer ) ) {
				return $content;
			}
			$amp_positions = foxiz_get_option( 'amp_ad_single_positions' );
			if ( empty( $amp_positions ) ) {
				$amp_positions = '4';
			};
			$amp_positions = explode( ',', $amp_positions );
			$content       = explode( $tag, $content );
			foreach ( $content as $index => $paragraph ) {
				if ( in_array( $index, $amp_positions ) ) {
					$content[ $index ] = $amp_buffer . $paragraph;
				}
				if ( trim( $paragraph ) ) {
					$content[ $index ] .= $tag;
				}
			}

			return implode( '', $content );
		}

		$buffer = foxiz_get_single_inline_ad();
		if ( empty( $buffer ) ) {
			return $content;
		}
		$positions = foxiz_get_option( 'ad_single_positions' );
		if ( empty( $positions ) ) {
			$positions = '4';
		};

		$positions = explode( ',', $positions );
		$content   = explode( $tag, $content );
		foreach ( $content as $index => $paragraph ) {
			if ( in_array( $index, $positions ) ) {
				$content[ $index ] = $buffer . $paragraph;
			}
			if ( trim( $paragraph ) ) {
				$content[ $index ] .= $tag;
			}
		}

		return implode( '', $content );
	}
}

if ( ! function_exists( 'foxiz_get_single_inline_amp_ad' ) ) {
	/**
	 * @return false|string
	 */
	function foxiz_get_single_inline_amp_ad() {

		if ( ! function_exists( 'foxiz_amp_ad' ) ) {
			return false;
		}
		ob_start();
		foxiz_amp_ad( array(
			'type'      => foxiz_get_option( 'amp_inline_single_ad_type' ),
			'client'    => foxiz_get_option( 'amp_inline_single_adsense_client' ),
			'slot'      => foxiz_get_option( 'amp_inline_single_adsense_slot' ),
			'size'      => foxiz_get_option( 'amp_inline_single_adsense_size' ),
			'custom'    => foxiz_get_option( 'amp_inline_single_ad_code' ),
			'classname' => 'inline-single-amp-ad amp-ad-wrap'
		) );

		return ob_get_clean();
	}
}
