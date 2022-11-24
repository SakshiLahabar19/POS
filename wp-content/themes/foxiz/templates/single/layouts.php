<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_single_post' ) ) {
	function foxiz_single_post() {

		if ( 'post' !== get_post_type() ) {
			foxiz_render_single_custom_type();
			return;
		}

		$post_prev = get_previous_post();
		if ( ! empty( foxiz_get_option( 'ajax_next_cat' ) ) ) {
			$post_prev = get_previous_post( true );
		}

		if ( ( ( foxiz_get_single_setting( 'ajax_next_post' ) && ! empty( $post_prev ) ) || get_query_var( 'rbsnp' ) ) && ! foxiz_is_amp() ) :
			$class_name = 'single-post-infinite';
			if ( ! empty( foxiz_get_option( 'ajax_next_hide_sidebar' ) ) ) {
				$class_name .= ' none-mobile-sb';
			} ?>
			<div id="single-post-infinite" class="<?php echo esc_attr( $class_name ); ?>" data-nextposturl="<?php echo esc_url( get_permalink( $post_prev ) ); ?>">
				<div class="single-post-outer activated" data-postid="<?php echo get_the_ID(); ?>" data-postlink="<?php echo esc_url( get_permalink() ); ?>">
					<?php foxiz_render_single_post(); ?>
				</div>
			</div>
			<div id="single-infinite-point" class="single-infinite-point pagination-wrap"><i class="rb-loader"></i>
			</div>
		<?php else :
			foxiz_render_single_post();
		endif;
	}
}

if ( ! function_exists( 'foxiz_render_single_post' ) ) {
	/**
	 * single layout
	 */
	function foxiz_render_single_post() {
		$func = 'foxiz_render_single_' . foxiz_get_single_layout();
		if ( function_exists( $func ) ) {
			call_user_func($func);
		} else {
			foxiz_render_single_standard_1();
		}
	}
}




