<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_render_single_custom_type' ) ) {
	function foxiz_render_single_custom_type() {
		$classes   = array();
		$classes[] = 'single-standard-1 without-sidebar optimal-line-length'; ?>
        <div class="<?php echo join( ' ', $classes ); ?>">
            <div class="rb-container edge-padding">
				<?php foxiz_single_open_tag(); ?>
                <div class="grid-container">
                    <div class="block-inner">
                        <div class="s-ct">
                            <header class="single-header">
								<?php
								foxiz_single_breadcrumb();
								foxiz_single_title();
								foxiz_single_tagline();
								foxiz_single_header_meta();
								?>
                            </header>
							<?php foxiz_single_simple_content(); ?>
                        </div>
                    </div>
                </div>
				<?php
				foxiz_single_close_tag(); ?>
            </div>
        </div>
		<?php
	}
}