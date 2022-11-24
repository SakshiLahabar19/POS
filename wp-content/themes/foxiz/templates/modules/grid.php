<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_grid_1' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_1( $settings = array() ) {

		$settings['post_classes'] = 'p-grid p-grid-1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		$settings['top_spacing'] = true;
		foxiz_post_open_tag( $settings );
		foxiz_grid_1_featured( $settings );
		?>
        <div class="p-content">
			<?php
			foxiz_entry_counter( $settings );
			foxiz_entry_title( $settings );
			foxiz_entry_review( $settings );
			foxiz_entry_excerpt( $settings );
			foxiz_entry_meta( $settings );
			foxiz_entry_readmore( $settings );
			?></div>
		<?php foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_grid_2' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_2( $settings = array() ) {

		$settings['post_classes'] = 'p-grid p-grid-2';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		foxiz_post_open_tag( $settings );
		foxiz_grid_2_featured( $settings ); ?>
        <div class="p-content">
			<?php
			foxiz_entry_counter( $settings );
			foxiz_entry_top( $settings );
			foxiz_entry_title( $settings );
			foxiz_entry_review( $settings );
			foxiz_entry_excerpt( $settings );
			foxiz_entry_meta( $settings );
			foxiz_entry_readmore( $settings );
			?>
        </div>
		<?php foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_grid_small_1' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_small_1( $settings = array() ) {

		$settings['post_classes'] = 'p-grid p-grid-small-1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h4';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g1';
		}
		$settings['top_spacing'] = true;

		foxiz_post_open_tag( $settings );
		if ( foxiz_is_featured_image( $settings['crop_size'] ) ) : ?>
            <div class="feat-holder">
				<?php
				foxiz_entry_featured( $settings );
				foxiz_entry_top( $settings );
				?>
            </div>
		<?php endif;
		if ( ! empty( $settings['counter'] ) ) : ?>
            <div class="counter-holder">
            <div class="counter-el"></div>
		<?php endif; ?>
        <div class="p-content">
			<?php
			foxiz_entry_title( $settings );
			foxiz_entry_review( $settings );
			foxiz_entry_excerpt( $settings );
			foxiz_entry_meta( $settings );
			foxiz_entry_readmore( $settings );
			?>
        </div>
		<?php if ( ! empty( $settings['counter'] ) ) : ?>
            </div>
		<?php endif;
		foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_grid_box_1' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_box_1( $settings = array() ) {

		if ( empty( $settings['box_style'] ) ) {
			$settings['box_style'] = 'bg';
		}
		$settings['post_classes'] = 'p-grid p-box p-grid-box-1 box-' . $settings['box_style'];

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		$settings['top_spacing'] = true;

		foxiz_post_open_tag( $settings ); ?>
        <div class="grid-box">
			<?php if ( foxiz_is_featured_image( $settings['crop_size'] ) ) : ?>
                <div class="feat-holder">
					<?php
					foxiz_entry_featured( $settings );
					foxiz_entry_top( $settings ); ?>
                </div>
			<?php endif; ?>
            <div class="p-content">
				<?php
				foxiz_entry_counter( $settings );
				foxiz_entry_title( $settings );
				foxiz_entry_review( $settings );
				foxiz_entry_excerpt( $settings );
				foxiz_entry_meta( $settings );
				foxiz_entry_readmore( $settings );
				?>
            </div>
        </div>
		<?php foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_grid_box_2' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_box_2( $settings = array() ) {

		$settings['post_classes'] = 'p-grid p-box p-grid-box-2 box-' . $settings['box_style'];

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}

		foxiz_post_open_tag( $settings );
		?>
        <div class="grid-box">
			<?php if ( foxiz_is_featured_image( $settings['crop_size'] ) ) : ?>
                <div class="feat-holder">
					<?php
					foxiz_entry_featured( $settings ); ?>
                </div>
			<?php endif; ?>
            <div class="p-content">
				<?php
				foxiz_entry_counter( $settings );
				foxiz_entry_top( $settings );
				foxiz_entry_title( $settings );
				foxiz_entry_review( $settings );
				foxiz_entry_excerpt( $settings );
				foxiz_entry_meta( $settings );
				foxiz_entry_readmore( $settings );
				?>
            </div>
        </div>
		<?php foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_grid_flex_1' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_flex_1( $settings = array() ) {

		if ( ! is_array( $settings['block_structure'] ) ) {
			return;
		}
		$settings['post_classes'] = 'p-grid p-grid-1 p-grid-flex-1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		$settings['top_spacing'] = true;

		foxiz_post_open_tag( $settings );
		foxiz_entry_counter( $settings );
		foreach ( $settings['block_structure'] as $element ) :
			switch ( $element ) {
				case 'thumbnail' :
					foxiz_grid_1_featured( $settings );
					break;
				case 'title' :
					foxiz_entry_title( $settings );
					break;
				case 'excerpt' :
					foxiz_entry_excerpt( $settings );
					break;
				case 'meta' :
					foxiz_entry_meta( $settings );
					break;
				case 'readmore' :
					foxiz_entry_readmore( $settings );
					break;
				case 'divider' :
					foxiz_entry_divider( $settings );
					break;
				default:
					break;
			}
		endforeach;
		foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_grid_flex_2' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_grid_flex_2( $settings = array() ) {

		if ( ! is_array( $settings['block_structure'] ) ) {
			return;
		}
		$settings['post_classes'] = 'p-grid p-grid-2 p-grid-flex-2';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		foxiz_post_open_tag( $settings );
		foxiz_entry_counter( $settings );
		foreach ( $settings['block_structure'] as $element ) :
			switch ( $element ) {
				case 'thumbnail' :
					foxiz_grid_2_featured( $settings );
					break;
				case 'category' :
					foxiz_entry_top( $settings );
					break;
				case 'title' :
					foxiz_entry_title( $settings );
					break;
				case 'excerpt' :
					foxiz_entry_excerpt( $settings );
					break;
				case 'meta' :
					foxiz_entry_meta( $settings );
					break;
				case 'readmore' :
					foxiz_entry_readmore( $settings );
					break;
				case 'divider' :
					foxiz_entry_divider( $settings );
					break;
				default:
					break;
			}
		endforeach;
		foxiz_post_close_tag();
	}
}