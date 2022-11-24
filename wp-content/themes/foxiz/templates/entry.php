<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_post_classes' ) ) {
	/**
	 * @param $settings
	 *
	 * @return string
	 */
	function foxiz_get_post_classes( $settings ) {

		$classes = array();
		$classes[] = 'p-wrap';
		if ( is_sticky() ) {
			$classes[] = 'sticky';
		}
		if ( ! empty( $settings['post_classes'] ) ) {
			$classes[] = $settings['post_classes'];
		}
		if ( ( ! empty( $settings['carousel'] ) && '1' === (string) $settings['carousel'] ) || ( ! empty( $settings['slider'] ) && '1' === (string) $settings['slider'] ) ) {
			$classes[] = 'swiper-slide';
		}

		if ( has_post_format( 'video' ) && rb_get_meta( 'video_preview' ) ) {
			$classes[] = 'preview-trigger';
		}

		return join( ' ', $classes );
	}
}

if ( ! function_exists( 'foxiz_entry_title' ) ) {
	/**
	 * @param array $settings
	 * render post title
	 */
	function foxiz_entry_title( $settings = array() ) {

		$classes = 'entry-title';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( ! empty( $settings['title_classes'] ) ) {
			$classes .= ' ' . $settings['title_classes'];
		}

		$classes    = apply_filters( 'foxiz_entry_title_classes', $classes, get_the_ID() );
		$post_title = get_the_title();
		$rel_attr   = 'bookmark';
		$link       = get_permalink();
		if ( foxiz_is_sponsored_post() && foxiz_get_single_setting( 'sponsor_redirect' ) ) {
			$rel_attr = 'noopener nofollow';
			$link     = rb_get_meta( 'sponsor_url' );
		}
		echo '<' . esc_attr( $settings['title_tag'] ) . ' class="' . esc_attr( $classes ) . '">';
		if ( ! empty( $settings['title_prefix'] ) ) {
			echo wp_kses( $settings['title_prefix'], 'foxiz' );
		} ?>
        <a class="p-url" href="<?php echo esc_url( $link ); ?>" rel="<?php echo esc_attr( $rel_attr ); ?>"><?php
		if ( ! empty( $post_title ) ) {
			the_title();
		} else {
			echo get_the_date( '', get_the_ID() );
		} ?></a><?php
		echo '</' . esc_attr( $settings['title_tag'] ) . '>';
	}
}

if ( ! function_exists( 'foxiz_entry_readmore' ) ) {
	/**
	 * @param array $settings
	 * render read more
	 */
	function foxiz_entry_readmore( $settings = array() ) {

		if ( empty( $settings['readmore'] ) ) {
			return;
		} ?>
        <div class="p-link">
            <a class="p-readmore" href="<?php echo get_permalink(); ?>"><span><?php echo esc_html( $settings['readmore'] ); ?></span><?php
				if ( foxiz_get_option( 'readmore_icon' ) ) : ?><i class="rbi rbi-cright"></i>
				<?php endif; ?></a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_excerpt' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_entry_excerpt( $settings = array() ) {

		$classes = 'entry-summary';
		if ( ! empty( $settings['hide_excerpt'] ) ) {
			switch ( $settings['hide_excerpt'] ) {
				case 'mobile' :
					$classes .= ' mobile-hide';
					break;
				case 'tablet' :
					$classes .= ' tablet-hide';
					break;
				case 'all' :
					$classes .= ' mobile-hide tablet-hide';
					break;
			}
		}

		if ( ! empty( $settings['excerpt_source'] ) && 'moretag' === $settings['excerpt_source'] ) :
			$classes .= ' entry-content rbct'; ?>
            <p class="<?php echo esc_attr( $classes ); ?>"><?php the_content( '' ); ?></p>
		<?php else :
			if ( empty( $settings['excerpt_length'] ) || 0 > $settings['excerpt_length'] ) {
				return false;
			}
			if ( ! empty( $settings['excerpt_source'] ) && 'tagline' === $settings['excerpt_source'] && rb_get_meta( 'tagline' ) ) :
				$tagline = wp_trim_words( rb_get_meta( 'tagline' ), intval( $settings['excerpt_length'] ), '<span class="summary-dot">&hellip;</span>' ); ?>
                <p class="<?php echo esc_attr( $classes ); ?>"><?php echo wp_kses( $tagline, 'foxiz' ); ?></p>
			<?php else :
				$excerpt = get_post_field( 'post_excerpt', get_the_ID() );
				if ( ! empty( $excerpt ) ) {
					$output = wp_trim_words( $excerpt, intval( $settings['excerpt_length'] ), '<span class="summary-dot">&hellip;</span>' );
				}
				if ( empty( $output ) ) {
					$output = get_the_content( '' );
					$output = strip_shortcodes( $output );
					$output = excerpt_remove_blocks( $output );
					$output = preg_replace( "~(?:\[/?)[^/\]]+/?\]~s", '', $output );
					$output = str_replace( ']]>', ']]&gt;', $output );
					$output = wp_strip_all_tags( $output );
					$output = wp_trim_words( $output, intval( $settings['excerpt_length'] ), '<span class="summary-dot">&hellip;</span>' );
				}
				if ( empty( $output ) ) {
					return false;
				}
				?><p class="<?php echo esc_attr( $classes ); ?>"><?php echo wp_kses( $output, 'foxiz' ); ?></p>
			<?php endif;
		endif;
	}
}

if ( ! function_exists( 'foxiz_get_entry_meta' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_entry_meta( $settings = array() ) {

		if ( empty( $settings['entry_meta'] ) || ! is_array( $settings['entry_meta'] ) || ! array_filter( $settings['entry_meta'] ) ) {
			return false;
		}
		ob_start();
		foreach ( $settings['entry_meta'] as $key ) {
			switch ( $key ) {
				case 'avatar' :
					foxiz_entry_meta_avatar( $settings );
					break;
				case 'date' :
					foxiz_entry_meta_date( $settings );
					break;
				case 'author' :
					foxiz_entry_meta_author( $settings );
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

if ( ! function_exists( 'foxiz_entry_meta' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false|void
	 */
	function foxiz_entry_meta( $settings ) {

		if ( foxiz_is_sponsored_post() && ! empty( $settings['sponsor_meta'] ) ) {
			echo foxiz_get_entry_sponsored( $settings );

			return false;
		}

		if ( ! empty( $settings['review'] ) && ( 'replace' === $settings['review'] ) && ! empty( foxiz_get_entry_review( $settings ) ) ) {
			echo foxiz_get_entry_review( $settings );

			return false;
		}

		if ( foxiz_get_entry_meta( $settings ) ) {
			$class_name   = array();
			$class_name[] = 'p-meta';
			if ( ! empty( $settings['entry_meta']['avatar'] ) ) {
				$class_name[] = 'has-avatar';
			}
			if ( ! empty( $settings['bookmark'] ) ) {
				$class_name[] = 'has-bookmark';
			} ?>
            <div class="<?php echo join( ' ', $class_name ); ?>">
				<?php do_action( 'foxiz_before_entry_meta', $settings ); ?>
                <div class="meta-inner is-meta">
					<?php echo foxiz_get_entry_meta( $settings ); ?>
                </div>
				<?php if ( ! empty( $settings['bookmark'] ) ) {
					foxiz_bookmark_trigger( get_the_ID() );
				} ?>
            </div>
		<?php }
	}
}

if ( ! function_exists( 'foxiz_entry_meta_date' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_entry_meta_date( $settings ) {

		$post_id = get_the_ID();
		$label   = '';
		$classes = array();

		$human_time = foxiz_get_option( 'human_time' );
		if ( ! empty( $human_time ) ) {
			$timestamp = get_post_timestamp();
		}
		if ( ! empty( $settings['is_single_meta'] ) && ! empty( foxiz_get_option( 'single_post_meta_date_label' ) ) ) {
			$label = foxiz_html__( 'Published', 'foxiz' ) . ' ';
		}
		$classes[] = 'meta-el meta-date';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'date', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'date', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?><span class="<?php echo implode( ' ', $classes ); ?>">
		<?php if ( foxiz_get_option( 'meta_date_icon' ) ) {
			echo '<i class="rbi rbi-clock"></i>';
		}
		if ( ! empty( $timestamp ) ) : ?>
            <time class="date published" datetime="<?php echo get_the_date( DATE_W3C, $post_id ); ?>"><?php echo sprintf( foxiz_html__( '%s ago', 'foxiz' ), human_time_diff( $timestamp ) ); ?></time>
		<?php else : ?>
            <time class="date published" datetime="<?php echo get_the_date( DATE_W3C, $post_id ); ?>"><?php echo esc_html( $label ) . get_the_date( null, $post_id ); ?></time>
		<?php endif; ?>
        </span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_author' ) ) {
	/**
	 * @param $settings
	 * @param false $job
	 *
	 * @return false|void
	 */
	function foxiz_entry_meta_author( $settings, $job = false ) {

		$post_id = get_the_ID();

		/** multiple authors supported */
		if ( function_exists( 'get_post_authors' ) ) {
			$author_data = get_post_authors( $post_id );
			if ( is_array( $author_data ) && count( $author_data ) > 1 ) {
				foxiz_entry_meta_authors( $settings, $author_data, $job );

				return false;
			}
		}

		/** single author */
		$classes   = array();
		$author_id = get_post_field( 'post_author', $post_id );
		$label     = foxiz_get_option( 'meta_author_label' );
		if ( is_singular( 'post' ) ) {
			$label = foxiz_get_option( 'single_post_meta_author_label' );
		}

		$classes[] = 'meta-el meta-author';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'author', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'author', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?><span class="<?php echo implode( ' ', $classes ); ?>">
		<?php if ( ! empty( $label ) ): ?>
            <em class="meta-label"><?php foxiz_html_e( 'By', 'foxiz' ); ?></em>
		<?php endif; ?>
        <a href="<?php echo get_author_posts_url( $author_id ) ?>"><?php the_author_meta( 'display_name', $author_id ); ?></a>
		<?php if ( ! empty( $job ) && get_the_author_meta( 'job', $author_id ) ) : ?>
            <span class="meta-label meta-author-label">&nbsp;&#45;&nbsp;<?php the_author_meta( 'job', $author_id ); ?></span>
		<?php endif; ?>
        </span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_authors' ) ) {
	/**
	 * @param $settings
	 * @param array $author_data
	 * @param false $job
	 */
	function foxiz_entry_meta_authors( $settings, $author_data = array(), $job = false ) {

		$classes = array();
		$label   = foxiz_get_option( 'meta_author_label' );
		if ( is_singular( 'post' ) ) {
			$label = foxiz_get_option( 'single_post_meta_author_label' );
		}

		$classes[] = 'meta-el meta-author co-authors';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'author', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'author', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?><span class="<?php echo implode( ' ', $classes ); ?>">
		<?php if ( ! empty( $label ) ): ?>
            <em class="meta-label"><?php echo foxiz_html__( 'Posted', 'foxiz' ); ?></em>
		<?php endif;
		foreach ( $author_data as $author ) :
			?>
            <span class="co-author">
                <a href="<?php echo get_author_posts_url( $author->ID ) ?>"><?php the_author_meta( 'display_name', $author->ID ); ?></a>
				<?php if ( ! empty( $job ) && get_the_author_meta( 'job', $author->ID ) ) : ?>
                    <span class="meta-label meta-author-label">&nbsp;&#45;&nbsp;<?php the_author_meta( 'job', $author->ID ); ?></span>
				<?php endif; ?>
                </span>
		<?php endforeach; ?>
        </span>
	<?php }
}

if ( ! function_exists( 'foxiz_entry_meta_avatar' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_entry_meta_avatar( $settings ) {

		$post_id = get_the_ID();
		$classes = array();
		if ( empty( $settings['avatar_size'] ) ) {
			$settings['avatar_size'] = 44;
		}
		$classes[] = 'meta-avatar';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'avatar', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'avatar', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		if ( function_exists( 'get_post_authors' ) ) {
			$author_data = get_post_authors( $post_id );
			if ( is_array( $author_data ) && count( $author_data ) > 1 ) {
				$classes[] = 'multiple-meta-avatar';
				?>
                <span class="<?php echo implode( ' ', $classes ); ?>">
					<?php foreach ( $author_data as $author ) : ?>
						<?php echo get_avatar( get_the_author_meta( 'user_email', $author->ID ), absint( $settings['avatar_size'] ), '', get_the_author_meta( 'display_name', $author->ID ) ); ?>
					<?php endforeach; ?>
			    </span>
				<?php return;
			}
		}
		$author_id = get_post_field( 'post_author', $post_id ); ?>
        <a class="<?php echo implode( ' ', $classes ); ?>" href="<?php echo get_author_posts_url( $author_id ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email', $author_id ), absint( $settings['avatar_size'] ), '', get_the_author_meta( 'display_name', $author_id ) ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_category' ) ) {
	/**
	 * @param $settings
	 * @param bool $primary
	 *
	 * @return false|void
	 */
	function foxiz_entry_meta_category( $settings, $primary = true ) {

		$post_id    = get_the_ID();
		$classes    = array();
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) {
			return false;
		}
		if ( $primary ) {
			$primary_category = rb_get_meta( 'primary_category' );
		}
		$classes[] = 'meta-el meta-category meta-bold';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'category', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'category', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		if ( empty( $primary_category ) ) :
			if ( array( $categories ) ) : ?>
                <span class="<?php echo implode( ' ', $classes ); ?>">
					<?php if ( foxiz_get_option( 'meta_category_icon', false ) ) {
						echo '<i class="rbi rbi-archive"></i>';
					}
					foreach ( $categories as $category ) : ?>
                        <a class="category-<?php echo esc_attr( $category->term_id ); ?>" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
					<?php endforeach; ?>
				</span>
			<?php endif;
		else :
			$primary_category_name = get_cat_name( $primary_category ); ?>
            <span class="meta-el meta-category meta-bold">
                <?php if ( foxiz_get_option( 'meta_category_icon', false ) ) {
	                echo '<i class="rbi rbi-archive"></i>';
                }
                ?><a class="category-<?php echo esc_attr( $primary_category ); ?>" href="<?php echo esc_url( get_category_link( $primary_category ) ); ?>"><?php echo esc_html( $primary_category_name ); ?></a>
			</span>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_entry_meta_tag' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_entry_meta_tag( $settings ) {

		$tags          = get_the_tags( get_the_ID() );

		if ( is_array( $tags ) ) :
			$classes = array();
			$classes[] = 'meta-el meta-tag';
			if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'tag', $settings['tablet_hide_meta'] ) ) {
				$classes[] = 'tablet-hide';
			}
			if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'tag', $settings['mobile_hide_meta'] ) ) {
				$classes[] = 'mobile-hide';
			}
			?><span class="<?php echo implode( ' ', $classes ); ?>">
            <em class="meta-label"><?php echo esc_html__( 'Tags:', 'foxiz' ) . ' '; ?></em>
			<?php foreach ( $tags as $tag ) : ?>
            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" rel="tag"><?php echo esc_attr( $tag->name ); ?></a>
		<?php endforeach; ?>
            </span>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_entry_meta_comment' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_entry_meta_comment( $settings ) {

		$post_id = get_the_ID();
		if ( ! comments_open( $post_id ) ) {
			return;
		}
		$classes   = array();
		$classes[] = 'meta-el meta-comment';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'comment', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'comment', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		$count = get_comments_number( $post_id );
		?><span class="<?php echo implode( ' ', $classes ); ?>">
        <a href="<?php echo get_comments_link( $post_id ) ?>">
				<?php if ( foxiz_get_option( 'meta_comment_icon', false ) ) {
					echo '<i class="rbi rbi-comment"></i>';
				}
				if ( '0' === (string) $count ) {
					foxiz_html_e( 'Add a Comment', 'foxiz' );
				} elseif ( '1' === (string) $count ) {
					foxiz_html_e( '1 comment', 'foxiz' );
				} else {
					echo sprintf( foxiz_html__( '%s comments', 'foxiz' ), foxiz_pretty_number( $count ) );
				} ?></a>
        </span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_view' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false|void
	 */
	function foxiz_entry_meta_view( $settings ) {

		if ( ! function_exists( 'pvc_get_post_views' ) || ! class_exists( 'Post_Views_Counter' ) ) {
			return false;
		}

		$post_id = get_the_ID();
		$classes = array();

		$count     = pvc_get_post_views( $post_id );
		$fake_view = rb_get_meta( 'start_view', $post_id );
		if ( ! empty( $fake_view ) ) {
			$count = intval( $count ) + intval( $fake_view );
		}
		if ( empty( $count ) ) {
			return false;
		}

		$classes[] = 'meta-el meta-view';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'view', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'view', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?><span class="<?php echo implode( ' ', $classes ); ?>">
        <a href="<?php echo get_permalink() ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
				<?php if ( foxiz_get_option( 'meta_view_icon', false ) ) {
					echo '<i class="rbi rbi-chart"></i>';
				}
				if ( '1' === (string) $count ) {
					foxiz_html_e( '1 View', 'foxiz' );
				} else {
					echo sprintf( foxiz_html__( '%s Views' ), foxiz_pretty_number( $count ) );
				} ?></a>
        </span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_updated' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_entry_meta_updated( $settings ) {

		$post_id = get_the_ID();
		$classes = array();

		$human_time = foxiz_get_option( 'human_time' );
		if ( ! empty( $human_time ) ) {
			$timestamp = get_post_timestamp( null, 'modified' );
		}
		$classes[] = 'meta-el meta-update';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'update', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'update', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?><span class="<?php echo implode( ' ', $classes ); ?>">
		<?php if ( foxiz_get_option( 'meta_updated_icon', false ) ) {
			echo '<i class="rbi rbi-time"></i>';
		}
		if ( ! empty( $timestamp ) ) : ?>
            <abbr class="date date-updated" title="<?php echo get_the_modified_date( DATE_W3C, $post_id ); ?>"><?php echo sprintf( foxiz_html__( 'Ago', 'foxiz' ), human_time_diff( $timestamp, current_time( 'timestamp' ) ) ); ?></abbr>
		<?php else : ?>
            <abbr class="date date-updated" title="<?php echo get_the_modified_date( DATE_W3C, $post_id ); ?>"><?php echo get_the_modified_date( '', $post_id ); ?></abbr>
		<?php endif; ?>
        </span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_read_time' ) ) {
	function foxiz_entry_meta_read_time( $settings ) {

		$post_id    = get_the_ID();
		$classes    = array();
		$count      = get_post_meta( $post_id, 'foxiz_content_total_word', true );
		$read_speed = intval( foxiz_get_option( 'read_speed' ) );
		if ( empty( $count ) && function_exists( 'foxiz_update_word_count' ) ) {
			$count = foxiz_update_word_count( $post_id );
		};
		if ( empty( $count ) ) {
			return false;
		}
		if ( empty( $read_speed ) ) {
			$read_speed = 130;
		}
		$minutes = floor( $count / $read_speed );
		$second  = floor( ( $count / $read_speed ) * 60 ) % 60;
		if ( $second > 30 ) {
			$minutes ++;
		}
		$classes[] = 'meta-el meta-read';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'read', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'read', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?>
        <span class="<?php echo implode( ' ', $classes ); ?>"><?php if ( foxiz_get_option( 'meta_read_icon', false ) ) {
				echo '<i class="rbi rbi-watch"></i>';
			}
			echo sprintf( foxiz_html__( '%s Min Read', 'foxiz' ), $minutes ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_meta_user_custom' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_entry_meta_user_custom( $settings ) {

		$post_id = get_the_ID();
		$classes = array();

		$custom_info = rb_get_meta( 'meta_custom', $post_id );
		if ( empty( $custom_info ) ) {
			return foxiz_entry_meta_user_custom_fallback( $settings );
		}
		$meta_custom_icon = foxiz_get_option( 'meta_custom_icon' );
		$meta_custom_text = foxiz_get_option( 'meta_custom_text' );
		$meta_custom_pos  = foxiz_get_option( 'meta_custom_pos' );
		$output           = $custom_info . ' ' . $meta_custom_text;
		if ( ! empty( $meta_custom_pos ) && 'begin' === $meta_custom_pos ) {
			$output = $meta_custom_text . ' ' . $custom_info;
		}
		$classes[] = 'meta-el meta-custom';
		if ( ! empty( $settings['tablet_hide_meta'] ) && is_array( $settings['tablet_hide_meta'] ) && in_array( 'custom', $settings['tablet_hide_meta'] ) ) {
			$classes[] = 'tablet-hide';
		}
		if ( ! empty( $settings['mobile_hide_meta'] ) && is_array( $settings['mobile_hide_meta'] ) && in_array( 'custom', $settings['mobile_hide_meta'] ) ) {
			$classes[] = 'mobile-hide';
		}
		?><span class="<?php echo implode( ' ', $classes ); ?>">
		<?php if ( ! empty( $meta_custom_icon ) ) : ?>
        <i class="<?php echo esc_attr( $meta_custom_icon ); ?>"></i><?php
			echo esc_html( $output );
		else :
			echo esc_html( $output );
		endif; ?>
        </span>
		<?php
	}
}

/**
 * @param $settings
 *
 * @return false
 */
if ( ! function_exists( 'foxiz_entry_meta_user_custom_fallback' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_entry_meta_user_custom_fallback( $settings ) {

		$meta = foxiz_get_option( 'meta_custom_fallback' );
		if ( empty( $meta ) ) {
			return false;
		}
		switch ( $meta ) {
			case 'date' :
				foxiz_entry_meta_date( $settings );
				break;
			case 'author' :
				foxiz_entry_meta_author( $settings );
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
		};
	}
}

if ( ! function_exists( 'foxiz_entry_featured_image' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_entry_featured_image( $settings = array() ) {

		$url = get_permalink();
		if ( foxiz_is_sponsored_post() && foxiz_get_single_setting( 'sponsor_redirect' ) && rb_get_meta( 'sponsor_url' ) ) {
			$url = rb_get_meta( 'sponsor_url' );
		} ?>
        <a class="p-flink" href="<?php echo esc_url( $url ); ?>" title="<?php echo wp_strip_all_tags( get_the_title() ); ?>">
			<?php the_post_thumbnail( $settings['crop_size'], array( 'class' => 'featured-img' ) ); ?>
        </a>
		<?php
	}
}

if ( ! function_exists( 'foxiz_entry_featured' ) ) {
	/**
	 * @param array $settings
	 * render featured image
	 */
	function foxiz_entry_featured( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'featured_classes' => '',
			'crop_size'        => '1536x1536',
			'format'           => ''
		) );

		$classes   = array();
		$classes[] = 'p-featured';
		if ( ! empty( $settings['featured_classes'] ) ) {
			$classes[] = $settings['featured_classes'];
		}
		if ( has_post_format( 'video' ) ) {
			$video_preview = wp_get_attachment_url( rb_get_meta( 'video_preview' ) );
		}
		?>
        <div class="<?php echo join( ' ', $classes ); ?>">
			<?php
			foxiz_entry_featured_image( $settings );
			foxiz_entry_format_absolute( $settings );
			/** edit post link */
			if ( current_user_can( 'edit_posts' ) ) {
				if ( ! isset( $settings['edit_link'] ) ) {
					$edit = foxiz_get_option( 'edit_link' );
				} else {
					$edit = $settings['edit_link'];
				}
				if ( ! empty( $edit ) ) {
					edit_post_link( esc_html__( 'edit', 'foxiz' ) );
				}
			}
			if ( ! empty( $video_preview ) )  : ?>
                <div class="preview-video" data-source="<?php echo esc_url( $video_preview ); ?>" data-type="<?php echo foxiz_get_video_mine_type( $video_preview ); ?>"></div>
			<?php endif;
			?>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_grid_1_featured' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_grid_1_featured( $settings = array() ) {

		if ( foxiz_is_featured_image( $settings['crop_size'] ) ) : ?>
            <div class="feat-holder">
				<?php
				foxiz_entry_featured( $settings );
				foxiz_entry_top( $settings ); ?>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_grid_2_featured' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_grid_2_featured( $settings = array() ) {

		if ( foxiz_is_featured_image( $settings['crop_size'] ) ) : ?>
            <div class="feat-holder">
				<?php
				foxiz_entry_featured( $settings ); ?>
            </div>
		<?php endif;
	}
}


if ( ! function_exists( 'foxiz_get_entry_format' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 * entry post format
	 */
	function foxiz_get_entry_format( $settings ) {

		$classes   = array();
		$classes[] = 'p-format';

		switch ( get_post_format() ) {
			case 'video' :
				if ( ! foxiz_get_option( 'post_icon_video' ) ) {
					return false;
				}
				$classes[] = 'format-video';

				return '<span class="' . join( ' ', $classes ) . '"><i class="rbi rbi-video"></i></span>';

			case 'gallery' :
				if ( ! foxiz_get_option( 'post_icon_gallery' ) ) {
					return false;
				}
				$gallery   = rb_get_meta( 'gallery_data' );
				$gallery   = explode( ',', $gallery );
				$classes[] = 'format-gallery';

				return '<span class="' . join( ' ', $classes ) . '"><i class="rbi rbi-gallery"></i><span class="gallery-count meta-text">' . count( $gallery ) . '</span></span>';
			case 'audio' :
				if ( ! foxiz_get_option( 'post_icon_audio' ) ) {
					return false;
				}
				$classes[] = 'format-radio';

				return '<span class="' . join( ' ', $classes ) . '"><i class="rbi rbi-audio"></i></span>';
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'foxiz_get_entry_categories' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_entry_categories( $settings ) {

		if ( empty( $settings['entry_category'] ) ) {
			return false;
		}
		$output                = '';
		$classes               = array();
		$categories            = get_the_category();
		$primary_category      = '';
		$primary_category_name = '';

		if ( ! isset( $settings['is_singular'] ) ) {
			$primary_category      = rb_get_meta( 'primary_category' );
			$primary_category_name = get_cat_name( $primary_category );
		}
		$max = absint( foxiz_get_option( 'max_categories' ) );
		if ( empty( $max ) ) {
			$max = 99999;
		}
		$index     = 1;
		$classes[] = 'p-categories';
		if ( ! empty( $primary_category_name ) ) {
			$classes[] = 'is-primary';
		}
		if ( ! empty( $settings['category_classes'] ) ) {
			$classes[] = $settings['category_classes'];
		}
		$classes = join( ' ', $classes );
		$output  .= '<div class="' . esc_attr( $classes ) . '">';
		if ( empty( $primary_category ) || empty ( $primary_category_name ) ) :
			if ( ! empty( $categories ) && is_array( $categories ) ) :
				foreach ( $categories as $category ) :
					$output .= '<a class="p-category category-id-' . esc_attr( $category->term_id ) . '" href="' . get_category_link( $category->term_id ) . '" rel="category">';
					$output .= esc_html( $category->name );
					$output .= '</a>';

					$index ++;
					if ( $index > $max ) {
						break;
					}
				endforeach;
			endif;
		else :
			$output .= '<a class="p-category category-id-' . esc_attr( $primary_category ) . '" href="' . get_category_link( $primary_category ) . '" rel="category">';
			$output .= esc_html( $primary_category_name );
			$output .= '</a>';
		endif;
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_entry_format_absolute' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_entry_format_absolute( $settings = array() ) {

		if ( empty( $settings['entry_format'] ) || 'after-category' === $settings['entry_format'] ) {
			return false;
		}

		$layout    = explode( ',', $settings['entry_format'] );
		$classes   = array();
		$classes[] = 'entry-format-absolute format-style-' . $layout[0];
		if ( ! empty( $layout[1] ) ) {
			$classes[] = 'format-size-' . $layout[1];
		}
		if ( foxiz_get_entry_format( $settings ) ) {
			echo '<aside class="' . join( ' ', $classes ) . '">' . foxiz_get_entry_format( $settings ) . '</aside>';
		}
	}
}

if ( ! function_exists( 'foxiz_get_entry_top' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_entry_top( $settings = array() ) {

		if ( ! empty( $settings['entry_format'] ) && 'after-category' === $settings['entry_format'] ) {
			$entry_format_buffer = foxiz_get_entry_format( $settings );
		}
		if ( ! empty( $settings['entry_category'] ) ) {
			$entry_category_buffer = foxiz_get_entry_categories( $settings );
		}
		if ( empty( $entry_format_buffer ) && empty( $entry_category_buffer ) ) {
			return false;
		}

		$settings['top_classes'] = 'p-top';

		if ( ! empty( $settings['hide_category'] ) ) {
			switch ( $settings['hide_category'] ) {
				case 'mobile' :
					$settings['top_classes'] .= ' mobile-hide';
					break;
				case 'tablet' :
					$settings['top_classes'] .= ' tablet-hide';
					break;
				case 'all' :
					$settings['top_classes'] .= ' mobile-hide tablet-hide';
					break;
			}
		}
		if ( ! empty ( $entry_format_buffer ) ) {
			$output = '<div class="' . esc_attr( $settings['top_classes'] ) . '">';
			$output .= foxiz_get_entry_categories( $settings );
			$output .= '<aside class="entry-format-relative">' . foxiz_get_entry_format( $settings ) . '</aside>';
			$output .= '</div>';
		} else {
			$settings['category_classes'] = $settings['top_classes'];
			$output                       = foxiz_get_entry_categories( $settings );
		}

		if ( ! empty( $settings['top_spacing'] ) ) {
			$output .= '<div class="spacing"></div>';
		}

		return $output;
	}
}

if ( ! function_exists( 'foxiz_entry_top' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_entry_top( $settings = array() ) {

		echo foxiz_get_entry_top( $settings );
	}
}

if ( ! function_exists( 'foxiz_entry_counter' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_entry_counter( $settings = array() ) {

		if ( ! empty( $settings['counter'] ) ) {
			echo '<span class="counter-el"></span>';
		}
	}
}

if ( ! function_exists( 'foxiz_entry_divider' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_entry_divider( $settings = array() ) {

		if ( empty( $settings['divider_style'] ) ) {
			$settings['divider_style'] = 'solid';
		}
		echo '<div class="p-divider is-divider-' . esc_attr( $settings['divider_style'] ) . '"></div>';
	}
}

if ( ! function_exists( 'foxiz_entry_review' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false|void
	 */
	function foxiz_entry_review( $settings ) {

		if ( empty( $settings['review'] ) || 'replace' === $settings['review'] ) {
			return false;
		}
		echo foxiz_get_entry_review( $settings );
	}
}

if ( ! function_exists( 'foxiz_get_entry_review' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_entry_review( $settings ) {

		if ( empty( $settings['review'] ) ) {
			return false;
		}

		$review = foxiz_get_review_settings();

		if ( ! is_array( $review ) ) {
			return false;
		}

		if ( empty( $review['average'] ) ) {
			$review['average'] = 0;
		}

		$class_name = 'review-meta is-meta';
		if ( ! empty( $review['type'] ) && 'score' === $review['type'] ) {
			$class_name .= ' type-score';
		} else {
			$class_name .= ' type-star';
		}
		if ( 'replace' === $settings['review'] && ! empty( $settings['bookmark'] ) ) {
			$class_name .= ' has-bookmark';
		}

		$output = '<div class="' . esc_attr( $class_name ) . '">';
		$output .= '<div class="review-meta-inner">';
		if ( ! empty( $review['type'] ) && 'score' === $review['type'] ) {
			$output .= foxiz_get_review_line( $review['average'] );
			$output .= '<span class="review-description"><strong class="meta-bold">' . $review['average'] . '</strong> ' . foxiz_html__( 'out of 10' ) . '</span>';
		} else {
			$output .= foxiz_get_review_stars( $review['average'] );
			$output .= '<span class="review-description"><strong class="meta-bold">' . $review['average'] . '</strong> ' . foxiz_html__( 'out of 5' ) . '</span>';
		}
		if ( ! empty( $settings['review_meta'] ) && ! empty( $review['meta'] ) ) {
			$output .= '<div class="extra-meta meta-bold"><span>' . esc_html( $review['meta'] ) . '</span></div>';
		}
		$output .= '</div>';
		if ( 'replace' === $settings['review'] && ! empty( $settings['bookmark'] ) ) {
			$output .= foxiz_get_bookmark_trigger( get_the_ID() );
		}
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_review_line' ) ) {
	/**
	 * @param int $average
	 *
	 * @return string
	 */
	function foxiz_get_review_line( $average = 0 ) {

		$output = '<span class="rline-wrap">';
		for ( $i = 1; $i <= 5; $i ++ ) {
			if ( ceil( floatval( $average ) / 2 ) >= $i ) {
				$output .= '<span class="rline activated"></span>';
			} else {
				$output .= '<span class="rline"></span>';
			}
		}
		$output .= '</span>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_review_stars' ) ) {
	/**
	 * @param int $average
	 *
	 * @return string
	 */
	function foxiz_get_review_stars( $average = 0 ) {

		$output = '<span class="rstar-wrap">';
		$output .= '<span class="rstar-bg" style="width:' . floatval( $average ) * 100 / 5 . '%"></span>';
		for ( $i = 1; $i <= 5; $i ++ ) {
			$output .= '<span class="rstar"><i class="rbi rbi-star"></i></span>';
		}
		$output .= '</span>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_get_author_info' ) ) {
	function foxiz_get_author_info( $author_id = '' ) {

		if ( empty( $author_id ) || ! get_the_author_meta( 'description', $author_id ) ) {
			return false;
		}

		ob_start();
		?><div class="ubox">
            <div class="ubox-header">
                <div class="author-info-wrap">
                    <a class="author-avatar" href="<?php echo get_author_posts_url( $author_id ); ?>"><?php echo get_avatar( $author_id, 120 ); ?></a>
                    <div class="is-meta">
                        <span class="nname-info meta-author">
                            <span class="meta-label"><?php foxiz_html_e( 'Posted by', 'foxiz' ); ?></span>
                            <?php if ( ! is_author() ) : ?>
                                <a class="nice-name" href="<?php echo get_author_posts_url( $author_id ); ?>"><?php the_author_meta( 'display_name', $author_id ); ?></a>
                            <?php else : ?>
                                <span class="nice-name"><?php the_author_meta( 'display_name', $author_id ); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="author-job"><?php the_author_meta( 'job', $author_id ); ?></span>
                    </div>
                </div>
				<?php if ( foxiz_get_social_list( foxiz_get_user_socials( $author_id ), true, false ) ) : ?>
                    <div class="usocials tooltips-n meta-text">
                        <span class="ef-label"><?php foxiz_html_e( 'Follow: ', 'foxiz' ); ?></span><?php echo foxiz_get_social_list( foxiz_get_user_socials( $author_id ), true, false ); ?>
                    </div>
				<?php endif; ?>
            </div>
            <div class="ubio description-text"><?php echo wp_kses( get_the_author_meta( 'description', $author_id ), 'foxiz' ); ?></div>
        </div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_entry_sponsored' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string|void
	 */
	function foxiz_get_entry_sponsored( $settings = array() ) {

		$post_id = get_the_ID();
		if ( ! foxiz_is_sponsored_post( $post_id ) ) {
			return;
		}

		if ( ! empty( $settings['sponsor_meta'] ) && '2' === (string) $settings['sponsor_meta'] ) {
			$label = false;
		} else {
			$label = foxiz_get_option( 'sponsor_meta_text' );
			if ( empty( $label ) ) {
				$label = foxiz_html__( 'Sponsored by', 'foxiz' );
			}
		}
		$sponsor_url        = rb_get_meta( 'sponsor_url', $post_id );
		$sponsor_name       = rb_get_meta( 'sponsor_name', $post_id );
		$sponsor_logo       = rb_get_meta( 'sponsor_logo', $post_id );
		$sponsor_logo_light = rb_get_meta( 'sponsor_logo_light', $post_id );

		if ( ! empty( $sponsor_logo ) ) {
			$sponsor_attachment = wp_get_attachment_image_src( $sponsor_logo, 'full' );
		}
		if ( ! empty( $sponsor_logo_light ) ) {
			$sponsor_light_attachment = wp_get_attachment_image_src( $sponsor_logo_light, 'full' );
		}
		if ( empty( $sponsor_url ) ) {
			$sponsor_url = '#';
		}
		ob_start(); ?>
        <div class="sponsor-meta meta-text">
            <div class="sponsor-inner">
                <span class="sponsor-icon"><i class="rbi rbi-notification"></i></span>
				<?php if ( ! empty( $label ) ) : ?>
                    <span class="sponsor-label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>
                <span class="sponlogo-wrap meta-bold">
                <a class="sponsor-link" href="<?php echo esc_url( $sponsor_url ); ?>" target="_blank" rel="noopener nofollow">
                    <?php if ( ! empty( $sponsor_attachment[0] ) ) :
	                    ?><img class="sponsor-brand-default is-logo" data-mode="default" src="<?php
                    if ( ! empty( $sponsor_attachment[0] ) ) {
	                    echo esc_url( $sponsor_attachment[0] );
                    } ?>" width="<?php
                    if ( ! empty( $sponsor_attachment[1] ) ) {
	                    echo esc_attr( $sponsor_attachment[1] );
                    } ?>" height="<?php
                    if ( ! empty( $sponsor_attachment[2] ) ) {
	                    echo esc_attr( $sponsor_attachment[2] );
                    } ?>" alt="<?php esc_attr( $sponsor_name ); ?>"/>
                    <?php else :
	                    echo '<span class="sponsor-brand-default is-text" data-mode="default">' . esc_html( $sponsor_name ) . '</span>';
                    endif;
                    if ( ! empty( $sponsor_light_attachment[0] ) ) :
	                    ?><img class="sponsor-brand-light is-logo" data-mode="dark" src="<?php
                    if ( ! empty( $sponsor_light_attachment[0] ) ) {
	                    echo esc_url( $sponsor_light_attachment[0] );
                    } ?>" width="<?php
                    if ( ! empty( $sponsor_light_attachment[1] ) ) {
	                    echo esc_attr( $sponsor_light_attachment[1] );
                    } ?>" height="<?php
                    if ( ! empty( $sponsor_light_attachment[2] ) ) {
	                    echo esc_attr( $sponsor_light_attachment[2] );
                    } ?>" alt="<?php esc_attr( $sponsor_name ); ?>"/>
                    <?php else :
	                    echo '<span class="sponsor-brand-light is-text" data-mode="dark">' . esc_html( $sponsor_name ) . '</span>';
                    endif; ?>
                 </a>
                </span>
            </div>
			<?php if ( ! empty( $settings['bookmark'] ) ) {
				foxiz_bookmark_trigger( $post_id );
			} ?>
        </div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_video_embed' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false|mixed|string|void
	 */
	function foxiz_get_video_embed( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		if ( 'video' !== get_post_format( $post_id ) ) {
			return false;
		}
		$self_hosted_video_id = rb_get_meta( 'video_hosted', $post_id );
		$auto_play            = foxiz_get_single_setting( 'auto_play', '', $post_id );
		if ( ! empty( $auto_play ) ) {
			$auto_play = 'on';
		} else {
			$auto_play = 'off';
		}
		if ( ! empty( $self_hosted_video_id ) ) {

			$wp_version = floatval( get_bloginfo( 'version' ) );
			if ( $wp_version < "3.6" ) {
				return '<p class="rb-error">' . esc_html__( 'Please update WordPress to the latest version to display this video.', 'foxiz' ) . '</p>';
			}
			$self_hosted_video_url = wp_get_attachment_url( $self_hosted_video_id );
			$params                = array(
				'src'      => $self_hosted_video_url,
				'width'    => 740,
				'height'   => 415,
				'autoplay' => $auto_play
			);

			return wp_video_shortcode( $params );
		} else {

			$params    = array(
				'width'  => 740,
				'height' => 415
			);
			$video_url = rb_get_meta( 'video_url', $post_id );
			$video_url = trim( $video_url );
			$embed     = wp_oembed_get( $video_url, $params );
			if ( ! empty( $embed ) ) {
				return $embed;
			} else {
				$embed = rb_get_meta( 'video_embed', $post_id );
				if ( ! empty( $embed ) ) {
					return $embed;
				} else {
					return false;
				}
			}
		}
	}
}

if ( ! function_exists( 'foxiz_get_audio_embed' ) ) {
	/**
	 * @param string $post_id
	 *
	 * @return false|mixed|string|void
	 */
	function foxiz_get_audio_embed( $post_id = '' ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		if ( 'audio' !== get_post_format( $post_id ) ) {
			return false;
		}
		$self_hosted_audio_id = rb_get_meta( 'audio_hosted', $post_id );
		if ( ! empty( $self_hosted_audio_id ) ) {

			$wp_version = floatval( get_bloginfo( 'version' ) );
			if ( $wp_version < "3.6" ) {
				return '<p class="ruby-error">' . esc_html__( 'Please update WordPress to the latest version to display this audio.', 'foxiz' ) . '</p>';
			}
			$self_hosted_audio_url = wp_get_attachment_url( $self_hosted_audio_id );
			$params                = array(
				'src' => $self_hosted_audio_url,
			);

			return wp_audio_shortcode( $params );
		} else {
			$audio_url = rb_get_meta( 'audio_url', $post_id );
			$audio_url = trim( $audio_url );
			$embed     = wp_oembed_get( $audio_url, array( 'height' => 400, 'width' => 900 ) );
			if ( ! empty( $embed ) ) {
				return $embed;
			} else {
				$embed = rb_get_meta( 'audio_embed', $post_id );
				if ( ! empty( $embed ) ) {
					return $embed;
				} else {
					return false;
				}
			}
		}
	}
}

if ( ! function_exists( 'foxiz_get_attachment_caption' ) ) {
	/**
	 * @param string $attachment_id
	 * @param string $classes
	 *
	 * @return false|string
	 */
	function foxiz_get_attachment_caption( $attachment_id = '', $classes = '' ) {

		if ( ! wp_get_attachment_caption( $attachment_id ) ) {
			return false;
		}
		$class_name = 'feat-caption meta-text';
		if ( ! empty( $classes ) ) {
			$class_name .= ' ' . $classes;
		}

		return '<div class="' . esc_attr( $class_name ) . '"><span class="caption-text meta-bold">' . wp_get_attachment_caption( $attachment_id ) . '</span></div>';
	}
}
