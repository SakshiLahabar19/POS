<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_my_bookmarks' ) ) {
	function foxiz_my_bookmarks() {

		echo '<div class="my-bookmark-section">';
		foxiz_reading_list();
		foxiz_user_interests_category();
		foxiz_user_interests_author();
		echo '</div>';
	}
}

if ( ! function_exists( 'foxiz_reading_list' ) ) {
	function foxiz_reading_list() {

		$image_description      = foxiz_get_option( 'saved_image' );
		$image_description_dark = foxiz_get_option( 'saved_image_dark' );
		$pattern                = foxiz_get_option( 'saved_pattern' );

		$heading_classes = 'bookmark-section-header';
		if ( ! empty( $pattern ) && '-1' !== (string) $pattern ) {
			$heading_classes .= ' is-pattern pattern-' . esc_attr( $pattern );
		} else {
			$heading_classes .= ' solid-bg';
		} ?>
        <div class="saved-section">
            <div class="<?php echo esc_attr( $heading_classes ); ?>">
                <div class="rb-container edge-padding">
					<?php if ( ! empty( $image_description['url'] ) ) : ?>
                        <div class="bookmark-section-header-image">
							<?php if ( ! empty( $image_description_dark['url'] ) ) : ?>
                                <img data-mode="default" src="<?php echo esc_url( $image_description['url'] ); ?>" alt="<?php echo esc_attr( $image_description['alt'] ); ?>" height="<?php echo esc_attr( $image_description['height'] ); ?>" width="<?php echo esc_attr( $image_description['width'] ); ?>">
                                <img data-mode="dark" src="<?php echo esc_url( $image_description_dark['url'] ); ?>" alt="<?php echo esc_attr( $image_description_dark['alt'] ); ?>" height="<?php echo esc_attr( $image_description_dark['height'] ); ?>" width="<?php echo esc_attr( $image_description_dark['width'] ); ?>">
							<?php else : ?>
                                <img src="<?php echo esc_url( $image_description['url'] ); ?>" alt="<?php echo esc_attr( $image_description['alt'] ); ?>" height="<?php echo esc_attr( $image_description['height'] ); ?>" width="<?php echo esc_attr( $image_description['width'] ); ?>">
							<?php endif; ?>
                        </div>
					<?php endif; ?>
                    <div class="bookmark-section-header-inner">
                        <h2 class="bookmark-section-title"><?php echo esc_html( foxiz_get_option( 'saved_heading' ) ); ?></h2>
						<?php if ( foxiz_get_option( 'saved_description' ) ) : ?>
                            <p class="bookmark-section-decs is-meta"><?php echo esc_html( foxiz_get_option( 'saved_description' ) ); ?></p>
						<?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="my-bookmarks" class="my-bookmarks">
                <div class="rb-container edge-padding"><?php foxiz_render_svg( 'loading', '', 'animation' ); ?></div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_user_interests_category' ) ) {
	function foxiz_user_interests_category() {

		if ( ! foxiz_get_option( 'interest_category' ) ) {
			return false;
		}
		$heading_classes = 'bookmark-section-header';
		$pattern         = foxiz_get_option( 'interest_pattern' );
		if ( ! empty( $pattern ) && ( '-1' !== (string) $pattern ) ) {
			$heading_classes .= ' is-pattern pattern-' . esc_attr( $pattern );
		} else {
			$heading_classes .= ' solid-bg';
		}
		$image_description      = foxiz_get_option( 'interest_image' );
		$image_description_dark = foxiz_get_option( 'interest_image_dark' );
		?>
        <div class="interest-section">
            <div class="<?php echo esc_attr( $heading_classes ); ?>">
                <div class="rb-container edge-padding">
					<?php if ( ! empty( $image_description['url'] ) ) : ?>
                        <div class="bookmark-section-header-image">
							<?php if ( ! empty( $image_description_dark['url'] ) ) : ?>
                                <img data-mode="default" src="<?php echo esc_url( $image_description['url'] ); ?>" alt="<?php echo esc_attr( $image_description['alt'] ); ?>" height="<?php echo esc_attr( $image_description['height'] ); ?>" width="<?php echo esc_attr( $image_description['width'] ); ?>">
                                <img data-mode="dark" src="<?php echo esc_url( $image_description_dark['url'] ); ?>" alt="<?php echo esc_attr( $image_description_dark['alt'] ); ?>" height="<?php echo esc_attr( $image_description_dark['height'] ); ?>" width="<?php echo esc_attr( $image_description_dark['width'] ); ?>">
							<?php else : ?>
                                <img src="<?php echo esc_url( $image_description['url'] ); ?>" alt="<?php echo esc_attr( $image_description['alt'] ); ?>" height="<?php echo esc_attr( $image_description['height'] ); ?>" width="<?php echo esc_attr( $image_description['width'] ); ?>">
							<?php endif; ?>
                        </div>
					<?php endif; ?>
                    <div class="bookmark-section-header-inner">
                        <h2 class="bookmark-section-title"><?php echo esc_html( foxiz_get_option( 'interest_heading' ) ); ?></h2>
						<?php if ( foxiz_get_option( 'saved_description' ) ) : ?>
                            <p class="bookmark-section-decs is-meta"><?php echo esc_html( foxiz_get_option( 'interest_description' ) ); ?></p>
						<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="interest-content">
                <div id="my-categories" class="rb-container edge-padding">
                    <div class="interest-loader"><?php foxiz_render_svg( 'loading', '', 'animation' ); ?></div>
                    <div class="interest-loader"><?php foxiz_render_svg( 'loading', '', 'animation' ); ?></div>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_user_interests_author' ) ) {
	function foxiz_user_interests_author() {

		if ( ! foxiz_get_option( 'interest_author' ) ) {
			return false;
		}

		$heading_classes = 'bookmark-section-header';
		$pattern         = foxiz_get_option( 'interest_pattern' );
		if ( ! empty( $pattern ) && ( '-1' !== (string) $pattern ) ) {
			$heading_classes .= ' is-pattern pattern-' . esc_attr( $pattern );
		} else {
			$heading_classes .= ' solid-bg';
		}
		$image_description      = foxiz_get_option( 'interest_author_image' );
		$image_description_dark = foxiz_get_option( 'interest_author_image_dark' );
		?>
        <div class="interest-section">
            <div class="<?php echo esc_attr( $heading_classes ); ?>">
                <div class="rb-container edge-padding">
					<?php if ( ! empty( $image_description['url'] ) ) : ?>
                        <div class="bookmark-section-header-image">
							<?php if ( ! empty( $image_description_dark['url'] ) ) : ?>
                                <img data-mode="default" src="<?php echo esc_url( $image_description['url'] ); ?>" alt="<?php echo esc_attr( $image_description['alt'] ); ?>" height="<?php echo esc_attr( $image_description['height'] ); ?>" width="<?php echo esc_attr( $image_description['width'] ); ?>">
                                <img data-mode="dark" src="<?php echo esc_url( $image_description_dark['url'] ); ?>" alt="<?php echo esc_attr( $image_description_dark['alt'] ); ?>" height="<?php echo esc_attr( $image_description_dark['height'] ); ?>" width="<?php echo esc_attr( $image_description_dark['width'] ); ?>">
							<?php else : ?>
                                <img src="<?php echo esc_url( $image_description['url'] ); ?>" alt="<?php echo esc_attr( $image_description['alt'] ); ?>" height="<?php echo esc_attr( $image_description['height'] ); ?>" width="<?php echo esc_attr( $image_description['width'] ); ?>">
							<?php endif; ?>
                        </div>
					<?php endif; ?>
                    <div class="bookmark-section-header-inner">
                        <h2 class="bookmark-section-title"><?php echo esc_html( foxiz_get_option( 'interest_author_heading' ) ); ?></h2>
						<?php if ( foxiz_get_option( 'saved_description' ) ) : ?>
                            <p class="bookmark-section-decs is-meta"><?php echo esc_html( foxiz_get_option( 'interest_author_description' ) ); ?></p>
						<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="interest-content">
                <div id="my-authors" class="rb-container edge-padding"><?php foxiz_render_svg( 'loading', '', 'animation' ); ?></div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_follow_categories_list' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_follow_categories_list( $settings = array() ) {

		$data                = Foxiz_Bookmark::get_instance()->get_user_categories();
		$update_flag         = false;
		$settings['classes'] = 'block-categories block-categories-1';
		$settings['uuid']    = 'categories-followed';
		$settings['follow']  = 1;

		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 5;
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 10;
		}
		foxiz_block_open_tag( $settings ); ?>
        <div class="block-inner">
			<?php if ( ! empty( $data ) && is_array( $data ) ) {
				foreach ( $data as $index => $id ) {
					$settings['cid'] = $id;
					if ( ! get_category( $settings['cid'] ) ) {
						unset( $data[ $index ] );
						$update_flag = true;
						continue;
					}
					foxiz_category_item_1( $settings );
				}
				/** reload data */
				if ( $update_flag ) {
					Foxiz_Bookmark::get_instance()->update_user_categories( $data );
				}
			}
			foxiz_render_follow_redirect( $settings ); ?>
        </div>
		<?php
		foxiz_block_close_tag();
	}
}

if ( ! function_exists( 'foxiz_follow_authors_list' ) ) {
	function foxiz_follow_authors_list( $settings = array() ) {

		$data        = Foxiz_Bookmark::get_instance()->get_user_authors();
		$update_flag = false;

		$settings['classes']            = 'block-authors is-box-shadow';
		$settings['uuid']               = 'authors-followed';
		$settings['follow']             = 1;
		$settings['count_posts']        = 1;
		$settings['description_length'] = 20;
		$settings['columns']            = 2;
		$settings['columns_tablet']     = 1;
		$settings['columns_mobile']     = 1;

		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 20;
		}
		foxiz_block_open_tag( $settings ); ?>
        <div class="block-inner">
			<?php if ( ! empty( $data ) && is_array( $data ) ) {
				foreach ( $data as $index => $id ) {
					$settings['author'] = $id;
					if ( ! get_user_by( 'id', $settings['author'] ) ) {
						unset( $data[ $index ] );
						$update_flag = true;
						continue;
					}
					foxiz_author_card_1( $settings );
				}
				if ( $update_flag ) {
					Foxiz_Bookmark::get_instance()->update_user_authors( $data );
				}
			}
			foxiz_render_follow_redirect( $settings );
			?>
        </div>
		<?php foxiz_block_close_tag();
	}
}

if ( ! function_exists( 'foxiz_recommended_section' ) ) {
	/**
	 * @return false
	 */
	function foxiz_recommended_section() {

		if ( ! foxiz_get_option( 'recommended_interested' ) ) {
			return false;
		} ?>
        <div id="my-recommended" class="my-recommended">
            <div class="rb-container edge-padding"><?php foxiz_render_svg( 'loading', '', 'animation' ); ?></div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_recommended_posts' ) ) {
	function foxiz_recommended_posts() {

		$template = foxiz_get_option( 'recommended_template' );
		$settings = array(
			'uuid' => 'uid_recommended',
		);

		$_query = Foxiz_Bookmark::get_instance()->recommended_query( $settings );
		if ( empty( $_query ) || ! $_query->have_posts() ) {
			return false;
		}
		if ( ! empty( $template ) ) : ?>
            <div class="rec-builder-section">
				<?php
				$GLOBALS['ruby_template_query'] = $_query;
				echo do_shortcode( $template );
				?></div>
		<?php else :
			$settings = foxiz_get_archive_page_settings( 'recommended_', $settings ); ?>
            <div class="rec-section light-scheme">
				<?php foxiz_the_blog( $settings, $_query ) ?>
            </div>
		<?php endif;
	}
}
