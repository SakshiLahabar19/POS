<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_layout_related_1' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_get_layout_related_1( $settings ) {

		if ( empty( $settings['post_id'] ) ) {
			$settings['post_id'] = get_the_ID();
		}
		if ( empty( $settings['heading_tag'] ) ) {
			$settings['heading_tag'] = 'h4';
		}
		$flag   = true;
		$_query = foxiz_get_related_data( $settings );
		if ( empty( $_query ) || ! method_exists( $_query, 'have_posts' ) || ! $_query->have_posts() ) {
			return false;
		} ?>
        <div class="related-sec related-1">
            <div class="inner">
				<?php if ( ! empty( $settings['heading'] ) ) {
					echo foxiz_get_heading( array(
						'title'    => $settings['heading'],
						'layout'   => $settings['heading_layout'],
						'html_tag' => $settings['heading_tag']
					) );
				} ?>
                <div class="block-inner">
					<?php while ( $_query->have_posts() ) :
						$_query->the_post();
						if ( $flag ) {
							foxiz_list_small_2( array(
								'featured_position' => 'right',
								'crop_size'         => 'thumbnail',
								'title_tag'         => 'h5',
							) );
							$flag = false;
						} else {
							foxiz_list_inline( array(
								'title_tag' => 'h6',
							) );
						}
					endwhile;
					wp_reset_postdata();
					?>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_layout_related_2' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_get_layout_related_2( $settings ) {

		if ( empty( $settings['post_id'] ) ) {
			$settings['post_id'] = get_the_ID();
		}
		if ( empty( $settings['heading_tag'] ) ) {
			$settings['heading_tag'] = 'h4';
		}
		$_query = foxiz_get_related_data( $settings );
		if ( empty( $_query ) || ! method_exists( $_query, 'have_posts' ) || ! $_query->have_posts() ) {
			return false;
		} ?>
        <div class="related-sec related-2">
            <div class="inner block-list-small-2">
				<?php if ( ! empty( $settings['heading'] ) ) {
					echo foxiz_get_heading( array(
						'title'    => $settings['heading'],
						'layout'   => $settings['heading_layout'],
						'html_tag' => $settings['heading_tag']
					) );
				} ?>
                <div class="block-inner">
					<?php while ( $_query->have_posts() ) :
						$_query->the_post();
						foxiz_list_small_2( array(
							'featured_position' => 'right',
							'crop_size'         => 'thumbnail',
							'title_tag'         => 'h5',
						) );
					endwhile;
					wp_reset_postdata();
					?></div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_layout_related_3' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_get_layout_related_3( $settings ) {

		if ( empty( $settings['post_id'] ) ) {
			$settings['post_id'] = get_the_ID();
		}
		if ( empty( $settings['heading_tag'] ) ) {
			$settings['heading_tag'] = 'h4';
		}
		$_query = foxiz_get_related_data( $settings );
		if ( empty( $_query ) || ! method_exists( $_query, 'have_posts' ) || ! $_query->have_posts() ) {
			return false;
		} ?>
        <div class="related-sec related-3">
            <div class="inner block-small block-hrc hrc-1">
				<?php if ( ! empty( $settings['heading'] ) ) {
					echo foxiz_get_heading( array(
						'title'    => $settings['heading'],
						'layout'   => $settings['heading_layout'],
						'html_tag' => $settings['heading_tag']
					) );
				} ?>
                <div class="block-inner">
					<?php foxiz_loop_hierarchical_1( array(
						'title_tag'     => 'h4',
						'sub_title_tag' => 'h6',
						'crop_size'     => 'foxiz_crop_g1',
					), $_query );
					wp_reset_postdata();
					?>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_layout_related_4' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_get_layout_related_4( $settings ) {

		if ( empty( $settings['post_id'] ) ) {
			$settings['post_id'] = get_the_ID();
		}
		if ( empty( $settings['heading_tag'] ) ) {
			$settings['heading_tag'] = 'h4';
		}
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h5';
		}

		$_query = foxiz_get_related_data( $settings );
		if ( empty( $_query ) || ! method_exists( $_query, 'have_posts' ) || ! $_query->have_posts() ) {
			return false;
		} ?>
        <div class="related-sec related-4">
            <div class="inner">
				<?php if ( ! empty( $settings['heading'] ) ) {
					echo foxiz_get_heading( array(
						'title'    => $settings['heading'],
						'layout'   => $settings['heading_layout'],
						'html_tag' => $settings['heading_tag']
					) );
				} ?>
                <div class="block-inner">
					<?php while ( $_query->have_posts() ) :
						$_query->the_post();
						foxiz_list_inline( $settings );
					endwhile;
					wp_reset_postdata();
					?>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_layout_related_5' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_get_layout_related_5( $settings ) {

		if ( empty( $settings['post_id'] ) ) {
			$settings['post_id'] = get_the_ID();
		}
		if ( empty( $settings['heading_tag'] ) ) {
			$settings['heading_tag'] = 'h3';
		}
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h4';
		}
		$_query = foxiz_get_related_data( $settings );
		if ( empty( $_query ) || ! method_exists( $_query, 'have_posts' ) || ! $_query->have_posts() ) {
			return false;
		}
		?>
        <div class="related-sec related-5">
            <div class="inner">
				<?php if ( ! empty( $settings['heading'] ) ) {
					echo foxiz_get_heading( array(
						'title'    => $settings['heading'],
						'layout'   => $settings['heading_layout'],
						'html_tag' => $settings['heading_tag']
					) );
				} ?>
                <div class="block-inner">
					<?php while ( $_query->have_posts() ) :
						$_query->the_post();
						foxiz_list_inline( $settings );
					endwhile;
					wp_reset_postdata();
					?></div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_get_layout_related_6' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_get_layout_related_6( $settings ) {

		if ( empty( $settings['post_id'] ) ) {
			$settings['post_id'] = get_the_ID();
		}
		if ( empty( $settings['heading_tag'] ) ) {
			$settings['heading_tag'] = 'h4';
		}
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h5';
		}

		$_query = foxiz_get_related_data( $settings );
		if ( empty( $_query ) || ! method_exists( $_query, 'have_posts' ) || ! $_query->have_posts() ) {
			return false;
		} ?>
        <div class="related-sec related-6">
            <div class="inner block-grid-small-1 rb-columns rb-col-3 is-gap-10">
				<?php if ( ! empty( $settings['heading'] ) ) {
					echo foxiz_get_heading( array(
						'title'    => $settings['heading'],
						'layout'   => $settings['heading_layout'],
						'html_tag' => $settings['heading_tag']
					) );
				} ?>
                <div class="block-inner">
					<?php foxiz_loop_grid_small_1( array(
						'title_tag'       => $settings['title_tag'],
						'columns'         => 3,
						'columns_tablet'  => 3,
						'columns_mobile'  => 1,
						'crop_size'       => 'foxiz_crop_g1',
						'design_override' => true,
					), $_query );
					wp_reset_postdata();
					?>
                </div>
            </div>
        </div>
		<?php
	}
}

/** inline related */
add_filter( 'the_content', 'foxiz_inline_content_related', 101 );

if ( ! function_exists( 'foxiz_inline_content_related' ) ) {
	function foxiz_inline_content_related( $content ) {

		$shortcode = foxiz_get_option( 'single_post_inline_related' );
		if ( empty( $shortcode ) || strpos( $content, '[ruby_related' ) || ! is_singular( 'post' ) ) {
			return $content;
		}
		if ( empty( $shortcode ) || strpos( $content, '[ruby_related' ) ) {
			return $content;
		}

		$position = absint( foxiz_get_option( 'single_post_inline_related_pos' ) );
		if ( empty( $position ) ) {
			$position = 5;
		}

		$tag     = '</p>';
		$content = explode( $tag, $content );
		foreach ( $content as $index => $paragraph ) {
			if ( $position === $index ) {
				$content[ $index ] = do_shortcode( $shortcode ) . $paragraph;
			}
			if ( trim( $paragraph ) ) {
				$content[ $index ] .= $tag;
			}
		}

		return implode( '', $content );
	}
}