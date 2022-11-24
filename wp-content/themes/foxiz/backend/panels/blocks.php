<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_blocks' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_blocks() {
		return array(
			'id'    => 'foxiz_config_section_block_design',
			'title' => esc_html__( 'Standard Blog Design', 'foxiz' ),
			'icon'  => 'el el-puzzle'
		);
	}
}
