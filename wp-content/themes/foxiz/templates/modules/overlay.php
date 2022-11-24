<?php
if ( ! function_exists( 'foxiz_overlay_1' ) ) {
	/**
	 * @param array $settings
	 *
	 */
	function foxiz_overlay_1( $settings = array() ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h2';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g2';
		}
		$settings['post_classes'] = 'p-highlight p-overlay-1';
		foxiz_post_open_tag( $settings );
		?>
        <div class="overlay-holder">
			<?php foxiz_entry_featured( $settings ); ?>
            <div class="overlay-wrap overlay-text">
                <div class="p-content overlay-inner p-gradient">
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
        </div>
		<?php foxiz_post_close_tag();
	}
}

if ( ! function_exists( 'foxiz_overlay_2' ) ) {
	/**
	 * @param array $settings
	 *
	 */
	function foxiz_overlay_2( $settings = array() ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_g1';
		}
		$settings['post_classes'] = 'p-overlay p-overlay-2';

		foxiz_post_open_tag( $settings );
		?>
        <div class="overlay-holder">
			<?php foxiz_entry_featured( $settings ); ?>
            <div class="overlay-wrap overlay-text">
                <div class="p-content overlay-inner p-gradient">
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
        </div>
		<?php foxiz_post_close_tag();
	}
}
