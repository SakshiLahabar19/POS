<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_page' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_page() {
		$prefix = 'page_';

		return array(
			'id'     => 'foxiz_config_section_page',
			'title'  => esc_html__( 'Single Page', 'foxiz' ),
			'icon'   => 'el el-list-alt',
			'desc'   => esc_html__( 'The settings below apply to the single page.', 'foxiz' ),
			'fields' => array(
				array(
					'id'     => 'section_start_page_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'General Settings', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'page_header_style',
					'type'     => 'select',
					'title'    => esc_html__( ' Page Header Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a header style for the single page.', 'foxiz' ),
					'options'  => array(
						'1' => esc_html__( 'Style 1', 'foxiz' ),
						'2' => esc_html__( 'Style 2', 'foxiz' ),
						'-1' => esc_html__( 'No Header', 'foxiz' )
					),
					'default'  => '1'
				),
				array(
					'id'       => $prefix . 'width_wo_sb',
					'type'     => 'select',
					'title'    => esc_html__( 'Max Width Content without Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a max-width for the content area without sidebar.', 'foxiz' ),
					'options'  => array(
						'small' => esc_html__( 'Small - 860px', 'foxiz' ),
						'0'     => esc_html__( 'Full Width', 'foxiz' )
					),
					'default'  => 'small'
				),
				array(
					'id'     => 'section_end_page_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_page_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Sidebar Area', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the single page.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'none'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the single page if it is enabled.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature for the single page.', 'foxiz' ),
					'options'  => array(
						'default' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'1'       => esc_html__( 'Enable', 'foxiz' ),
						'-1'      => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_page_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}