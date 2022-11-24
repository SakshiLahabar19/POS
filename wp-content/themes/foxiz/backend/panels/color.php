<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_color' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_color() {

		return array(
			'id'     => 'foxiz_config_section_color',
			'title'  => esc_html__( 'Global Colors', 'foxiz' ),
			'desc'   => esc_html__( 'Select colors for your website. To organize the panel and make it easy to use, you may also see color settings for each elements in it\'s panel.', 'foxiz' ),
			'icon'   => 'el el-tint',
			'fields' => array(
				array(
					'id'     => 'section_start_global_color',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Highlight Colors', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'global_color',
					'title'       => esc_html__( 'Global Highlight Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a global color, This setting apply to all links, menu, category overlays, main page and many contrasting elements.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_global_color',
					'title'       => esc_html__( 'Dark Mode - Global Highlight Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a global color in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_global_color',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_accent_color',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Dark Accent Colors', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'accent_color',
					'title'       => esc_html__( 'Dark Accent Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a dark accent color for your website, This setting apply to single header background, gradient colors.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_accent_color',
					'title'       => esc_html__( 'Dark Mode - Dark Accent Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select dark accent color in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_accent_color',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_dark_bg_color',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Dark Mode Colors', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'dark_background',
					'title'       => esc_html__( 'Dark Mode Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a dark solid background for the dark mode. Leave blank to set it as the default.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'light_switcher_color',
					'title'       => esc_html__( 'Mode Switcher - Light Icon Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for the light mode icon (Sun icon) of the dark mode switcher button to fit with the main navigation color.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_switcher_bg',
					'title'       => esc_html__( 'Mode Switcher - Dark Icon Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background for the dark mode icon (Moon icon) of the dark mode switcher button to fit with the main navigation color.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_dark_bg_color',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_miscellaneous_color',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Miscellaneous', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'review_color',
					'title'       => esc_html__( 'Review Star Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the star icons.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_miscellaneous_color',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}
