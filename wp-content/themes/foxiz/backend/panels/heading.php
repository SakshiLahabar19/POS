<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_heading' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_heading() {

		return array(
			'id'     => 'foxiz_config_section_heading',
			'title'  => esc_html__( 'Heading Design', 'foxiz' ),
			'icon'   => 'el el-minus',
			'desc'   => esc_html__( 'The global heading settings for blocks, widgets, archives.', 'foxiz' ),
			'fields' => array(
				array(
					'id'    => 'heading_layout_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'You can also choose layouts and colors for individual heading the page builder.', 'foxiz' ),
				),
				array(
					'id'    => 'heading_typo_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the heading typography, navigate to "Typography > Block Heading".', 'foxiz' ),
				),
				array(
					'id'     => 'section_start_global_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Global Heading', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'heading_layout',
					'title'       => esc_html__( 'Global Heading Layout', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a default heading layout for the archives and Elementor blocks for your website.', 'foxiz' ),
					'description' => esc_html__( 'Navigate to "Typography Settings > Block Heading" to set the font values.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_heading_layout(),
					'default'     => '1',
				),
				array(
					'id'          => 'heading_color',
					'title'       => esc_html__( 'Primary Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a primary color for the heading.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'heading_sub_color',
					'title'       => esc_html__( 'Accent Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a accent color for the heading.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_heading_color',
					'title'       => esc_html__( 'Dark Mode - Primary Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a primary color for the heading in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_heading_sub_color',
					'title'       => esc_html__( 'Dark Mode - Accent Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a accent color for the heading in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_global_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_widget_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Sidebar Widget Heading', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'widget_heading_layout',
					'title'       => esc_html__( 'Widget Heading Layout', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a heading layout for the sidebar widgets.', 'foxiz' ),
					'description' => esc_html__( 'Default layout is based on the "Global Heading Layout" setting.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_heading_layout( true ),
					'default'     => '0',
				),
				array(
					'id'          => 'footer_widget_heading_layout',
					'title'       => esc_html__( 'Footer Widget Heading Layout', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a heading layout for the footer column widgets.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_heading_layout( true ),
					'default'     => '10',
				),
				array(
					'id'          => 'widget_heading_tag',
					'title'       => esc_html__( 'Widget Heading HTML Tag', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a title HTML tag for the sidebar widget heading.', 'foxiz' ),
					'description' => esc_html__( 'The default tag is H4.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_heading_tag(),
					'default'     => '0'
				),
				array(
					'id'     => 'section_end_widget_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_heading_color',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Heading Color', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'heading_color',
					'title'       => esc_html__( 'Primary Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a primary color for the heading.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'heading_sub_color',
					'title'       => esc_html__( 'Accent Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a accent color for the heading.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),

				array(
					'id'          => 'dark_heading_color',
					'title'       => esc_html__( 'Dark Mode - Primary Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a primary color for the heading in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_heading_sub_color',
					'title'       => esc_html__( 'Dark Mode - Accent Heading Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a accent color for the heading in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_heading_color',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}
