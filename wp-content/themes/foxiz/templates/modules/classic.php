<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_classic_1' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_classic_1( $settings = array() ) {

		$settings['post_classes']  = 'p-classic p-classic-1';
		$settings['title_classes'] = 'h1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h2';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'foxiz_crop_o1';
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
		<?php foxiz_post_close_tag();
	}
}
