<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_dark_mode' ) ) {
	/**
	 * @return array
	 * dark mode settings
	 */
	function foxiz_register_options_dark_mode() {

		return array(
			'id'     => 'foxiz_config_section_dark_mode',
			'title'  => esc_html__( 'Dark Mode', 'foxiz' ),
			'desc'   => esc_html__( 'Select settings for the dark mode.', 'foxiz' ),
			'icon'   => 'el el-adjust',
			'fields' => array(
				array(
					'id'    => 'dark_mode_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'You can set custom dark mode background in "Global Colors > Dark Mode Background".', 'foxiz' ),
				),
				array(
					'id'       => 'dark_mode',
					'title'    => esc_html__( 'Dark Mode', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the dark mode whole your website.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1,
				),
				array(
					'id'       => 'dark_mode_image_opacity',
					'title'    => esc_html__( 'Image Opacity', 'foxiz' ),
					'subtitle' => esc_html__( 'Reduce the featured image opacity when enabled the dark mode.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => '0',
				),
				array(
					'id'       => 'dark_mode_default',
					'title'    => esc_html__( 'Default Dark Mode', 'foxiz' ),
					'subtitle' => esc_html__( 'Set the dark mode as the default color scheme when users visit your website a the first time.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 0,
				),
				array(
					'id'          => 'dark_mode_cookie',
					'title'       => esc_html__( 'Preventing Dark Mode Flickering', 'foxiz' ),
					'subtitle'    => esc_html__( 'Use cookie to prevent background flickering on page load.', 'foxiz' ),
					'description' => esc_html__( 'The theme use localstorage as the default for the dark mode to reduce the server usages.', 'foxiz' ),
					'type'        => 'switch',
					'default'     => 0,
				)
			)
		);
	}
}