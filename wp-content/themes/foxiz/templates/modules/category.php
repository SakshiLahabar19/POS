<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_render_follow_redirect' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_render_follow_redirect( $settings = array() ) {

		if ( empty( $settings['url'] ) ) {
			return false;
		}
		?>
        <div class="follow-redirect-wrap">
            <a href="<?php echo esc_url( $settings['url'] ); ?>" class="follow-redirect">
                <i class="rbi rbi-plus"></i><span class="meta-text"><?php esc_html_e( 'Add More', 'foxiz' ); ?></span>
            </a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_category_item_1' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_category_item_1( $settings = array() ) {

		if ( ! empty( $settings['cid'] ) ) {
			$category = get_category( $settings['cid'] );
		} elseif ( ! empty( $settings['slug'] ) ) {
			$category = get_category_by_slug( $settings['slug'] );
		}

		if ( empty( $category ) ) {
			return false;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h4';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g1';
		}
		$link                = get_category_link( $category );
		$id                  = $category->term_id;
		$meta                = get_option( 'foxiz_category_meta', array() );
		$featured_array      = array();
		$featured_urls_array = array();

		if ( ! empty( $meta[ $id ]['featured_image'] ) ) {
			$featured_array = $meta[ $id ]['featured_image'];
		}
		if ( ! empty( $meta[ $id ]['featured_image_urls'] ) ) {
			$featured_urls_array = $meta[ $id ]['featured_image_urls'];
		} ?>
        <div class="<?php echo 'cbox cbox-1 is-cbox-' . $category->term_id; ?>">
            <div class="cbox-inner">
                <a class="cbox-featured" href="<?php echo esc_url( $link ); ?>"><?php foxiz_render_category_featured( $featured_array, $featured_urls_array, $settings['crop_size'] ); ?></a>
                <div class="cbox-body">
                    <div class="cbox-content">
						<?php echo '<' . esc_attr( $settings['title_tag'] ) . ' class="cbox-title">';
						echo '<a class="p-url" href="' . esc_url( $link ) . '" rel="category">' . esc_html( $category->name ) . '</a>';
						echo '</' . esc_attr( $settings['title_tag'] ) . '>';
						if ( ! empty( $settings['count_posts'] ) && '1' === (string) $settings['count_posts'] ) :
							$count = $category->category_count . ' ' . foxiz_html__( 'Articles', 'foxiz' );
							if ( '1' === (string) $category->category_count ) {
								$count = $settings['count_posts'] . ' ' . foxiz_html__( 'Article', 'foxiz' );
							} ?>
                            <span class="cbox-count is-meta"><?php echo esc_html( $count ) ?></span>
						<?php endif; ?>
                    </div>
					<?php if ( ! empty( $settings['follow'] ) && '1' === (string) $settings['follow'] ) {
						foxiz_follow_trigger( array( 'id' => $id, 'type' => 'category' ) );
					} ?>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_category_item_2' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_category_item_2( $settings = array() ) {

		if ( ! empty( $settings['cid'] ) ) {
			$category = get_category( $settings['cid'] );
		} elseif ( ! empty( $settings['slug'] ) ) {
			$category = get_category_by_slug( $settings['slug'] );
		}
		if ( empty( $category ) ) {
			return false;
		}
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g1';
		}
		$link                = get_category_link( $category );
		$id                  = $category->term_id;
		$meta                = get_option( 'foxiz_category_meta', array() );
		$featured_array      = array();
		$featured_urls_array = array();
		if ( ! empty( $meta[ $id ]['featured_image'] ) ) {
			$featured_array = $meta[ $id ]['featured_image'];
		}
		if ( ! empty( $meta[ $id ]['featured_image_urls'] ) ) {
			$featured_urls_array = $meta[ $id ]['featured_image_urls'];
		}
		?>
        <div class="<?php echo 'cbox cbox-2 is-cbox-' . $category->term_id; ?>">
            <div class="cbox-inner">
                <a class="cbox-featured-overlay" href="<?php echo esc_url( $link ); ?>"><?php foxiz_render_category_featured( $featured_array, $featured_urls_array, $settings['crop_size'] ); ?></a>
                <div class="cbox-overlay overlay-wrap light-scheme">
                    <div class="cbox-body">
                        <div class="cbox-content">
							<?php echo '<' . esc_attr( $settings['title_tag'] ) . ' class="cbox-title">';
							echo '<a class="p-url" href="' . esc_url( $link ) . '" rel="category">' . esc_html( $category->name ) . '</a>';
							echo '</' . esc_attr( $settings['title_tag'] ) . '>';
							if ( ! empty( $settings['count_posts'] ) && '1' === (string) $settings['count_posts'] ) :
								$count = $category->category_count . ' ' . foxiz_html__( 'Articles', 'foxiz' );
								if ( '1' === (string) $category->category_count ) {
									$count = $settings['count_posts'] . ' ' . foxiz_html__( 'Article', 'foxiz' );
								} ?>
                                <span class="cbox-count is-meta"><?php echo esc_html( $count ) ?></span>
							<?php endif; ?>
                        </div>
						<?php if ( ! empty( $settings['follow'] ) && '1' === (string) $settings['follow'] ) {
							foxiz_follow_trigger( array( 'id' => $id, 'type' => 'category', 'classes' => 'is-light' ) );
						} ?>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_category_item_3' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_category_item_3( $settings = array() ) {

		if ( ! empty( $settings['cid'] ) ) {
			$category = get_category( $settings['cid'] );
		} elseif ( ! empty( $settings['slug'] ) ) {
			$category = get_category_by_slug( $settings['slug'] );
		}
		if ( empty( $category ) ) {
			return false;
		}
		$description = true;
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		if ( ! empty( $settings['description'] ) && '-1' === (string) $settings['description'] ) {
			$description = false;
		}

		$link                = get_category_link( $category );
		$id                  = $category->term_id;
		$meta                = get_option( 'foxiz_category_meta', array() );
		$featured_array      = array();
		$featured_urls_array = array();
		if ( ! empty( $meta[ $id ]['featured_image'] ) ) {
			$featured_array = $meta[ $id ]['featured_image'];
		}
		if ( ! empty( $meta[ $id ]['featured_image_urls'] ) ) {
			$featured_urls_array = $meta[ $id ]['featured_image_urls'];
		}
		?>
        <div class="<?php echo 'cbox cbox-3 is-cbox-' . $category->term_id; ?>">
            <div class="cbox-inner">
                <a class="cbox-featured-overlay" href="<?php echo esc_url( $link ); ?>"><?php foxiz_render_category_featured( $featured_array, $featured_urls_array, $settings['crop_size'] ); ?></a>
                <div class="cbox-overlay overlay-wrap light-scheme">
                    <div class="cbox-body">
                        <div class="cbox-top cbox-content">
							<?php if ( ! empty( $settings['count_posts'] ) && '1' === (string) $settings['count_posts'] ) :
								$count = $category->category_count . ' ' . foxiz_html__( 'Articles', 'foxiz' );
								if ( '1' === (string) $category->category_count ) {
									$count = $settings['count_posts'] . ' ' . foxiz_html__( 'Article', 'foxiz' );
								} ?>
                                <span class="cbox-count is-meta"><?php echo esc_html( $count ) ?></span>
							<?php endif;
							echo '<' . esc_attr( $settings['title_tag'] ) . ' class="cbox-title">';
							echo '<a class="p-url" href="' . esc_url( $link ) . '" rel="category">' . esc_html( $category->name ) . '</a>';
							echo '</' . esc_attr( $settings['title_tag'] ) . '>';
							?>
                        </div>
						<?php if ( ! empty( $category->description ) && $description ): ?>
                            <div class="cbox-center cbox-description">
								<?php echo wp_trim_words( $category->description, 25 ); ?>
                            </div>
						<?php endif;
						if ( ! empty( $settings['follow'] ) && '1' === (string) $settings['follow'] ) {
							echo '<div class="cbox-bottom">';
							foxiz_follow_trigger( array( 'id' => $id, 'type' => 'category', 'classes' => 'is-light' ) );
							echo '</div>';
						} ?>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_category_item_4' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_category_item_4( $settings = array() ) {

		if ( ! empty( $settings['cid'] ) ) {
			$category = get_category( $settings['cid'] );
		} elseif ( ! empty( $settings['slug'] ) ) {
			$category = get_category_by_slug( $settings['slug'] );
		}

		if ( empty( $category ) ) {
			return false;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g1';
		}
		$link                = get_category_link( $category );
		$id                  = $category->term_id;
		$meta                = get_option( 'foxiz_category_meta', array() );
		$featured_array      = array();
		$featured_urls_array = array();

		if ( ! empty( $meta[ $id ]['featured_image'] ) ) {
			$featured_array = $meta[ $id ]['featured_image'];
		}
		if ( ! empty( $meta[ $id ]['featured_image_urls'] ) ) {
			$featured_urls_array = $meta[ $id ]['featured_image_urls'];
		} ?>
        <div class="<?php echo 'cbox cbox-4 is-cbox-' . $category->term_id; ?>">
            <div class="cbox-inner">
				<?php if ( ! empty( $settings['follow'] ) && '1' === (string) $settings['follow'] ) {
					foxiz_follow_trigger( array( 'id' => $id, 'type' => 'category', 'classes' => 'is-light' ) );
				} ?>
                <a class="cbox-featured" href="<?php echo esc_url( $link ); ?>"><?php foxiz_render_category_featured( $featured_array, $featured_urls_array, $settings['crop_size'] ); ?></a>
                <div class="cbox-body">
                    <div class="cbox-content">
						<?php if ( ! empty( $settings['count_posts'] ) && '1' === (string) $settings['count_posts'] ) :
							$count = $category->category_count . ' ' . foxiz_html__( 'Articles', 'foxiz' );
							if ( '1' === (string) $category->category_count ) {
								$count = $settings['count_posts'] . ' ' . foxiz_html__( 'Article', 'foxiz' );
							} ?>
                            <span class="cbox-count is-meta"><?php echo esc_html( $count ) ?></span>
						<?php endif;
						echo '<' . esc_attr( $settings['title_tag'] ) . ' class="cbox-title">';
						echo '<a class="p-url" href="' . esc_url( $link ) . '" rel="category">' . esc_html( $category->name ) . '</a>';
						echo '</' . esc_attr( $settings['title_tag'] ) . '>';
						?>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_category_item_5' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_category_item_5( $settings = array() ) {

		if ( ! empty( $settings['cid'] ) ) {
			$category = get_category( $settings['cid'] );
		} elseif ( ! empty( $settings['slug'] ) ) {
			$category = get_category_by_slug( $settings['slug'] );
		}

		if ( empty( $category ) ) {
			return false;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h4';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g1';
		}
		$link                = get_category_link( $category );
		$id                  = $category->term_id;
		$meta                = get_option( 'foxiz_category_meta', array() );
		$featured_array      = array();
		$featured_urls_array = array();

		if ( ! empty( $meta[ $id ]['featured_image'] ) ) {
			$featured_array = $meta[ $id ]['featured_image'];
		}
		if ( ! empty( $meta[ $id ]['featured_image_urls'] ) ) {
			$featured_urls_array = $meta[ $id ]['featured_image_urls'];
		} ?>
        <div class="<?php echo 'cbox cbox-5 is-cbox-' . $category->term_id; ?>">
            <div class="cbox-featured-holder">
				<?php if ( ! empty( $settings['follow'] ) && '1' === (string) $settings['follow'] ) : ?>
                    <span class="cbox-featured"><?php foxiz_render_category_featured( $featured_array, $featured_urls_array, $settings['crop_size'] ); ?></span>
					<?php foxiz_follow_trigger( array(
						'id'      => $id,
						'type'    => 'category',
						'classes' => 'is-light'
					) ); ?>
				<?php else : ?>
                    <a class="cbox-featured" href="<?php echo esc_url( $link ); ?>"><?php foxiz_render_category_featured( $featured_array, $featured_urls_array, $settings['crop_size'] ); ?></a>
				<?php endif; ?>
            </div>
            <div class="cbox-content">
				<?php echo '<' . esc_attr( $settings['title_tag'] ) . ' class="cbox-title">';
				echo '<a class="p-url" href="' . esc_url( $link ) . '" rel="category">' . esc_html( $category->name ) . '</a>';
				echo '</' . esc_attr( $settings['title_tag'] ) . '>';
				if ( ! empty( $settings['count_posts'] ) && '1' === (string) $settings['count_posts'] ) :
					$count = $category->category_count . ' ' . foxiz_html__( 'Articles', 'foxiz' );
					if ( '1' === (string) $category->category_count ) {
						$count = $settings['count_posts'] . ' ' . foxiz_html__( 'Article', 'foxiz' );
					} ?>
                    <span class="cbox-count is-meta"><?php echo esc_html( $count ) ?></span>
				<?php endif; ?>
            </div>
        </div>
	<?php }
}