<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_table_contents' ) ) {
	/**
	 * @return array
	 * table of contents
	 */
	function foxiz_register_options_table_contents() {

		return array(
			'title'  => esc_html__( 'Table of Contents', 'foxiz' ),
			'id'     => 'foxiz_config_section_table_contents',
			'desc'   => esc_html__( 'Select settings for table of contents.', 'foxiz' ),
			'icon'   => 'el el-th-list',
			'fields' => array(
				array(
					'id'     => 'section_start_table_contents_ptype',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Post Type Supported', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'table_contents_post',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support Single Post', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the table of content for the single post.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_page',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support Single Page', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the table of content for the single.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_table_contents_ptype',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_table_contents_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Heading Tag Supported', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'table_contents_h1',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support H1', 'foxiz' ),
					'subtitle' => esc_html__( 'Support H1 tag, Turn this option off if you would like to exclude H1 tag out of the table of contents.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_h2',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support H2', 'foxiz' ),
					'subtitle' => esc_html__( 'Support H2 tag, Turn this option off if you would like to exclude H2 tag out of the table of contents.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_h3',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support H3', 'foxiz' ),
					'subtitle' => esc_html__( 'Support H3 tag, Turn this option off if you would like to exclude H3 tag out of the table of contents.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_h4',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support H4', 'foxiz' ),
					'subtitle' => esc_html__( 'Support H4 tag, Turn this option off if you would like to exclude H4 tag out of the table of contents.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_h5',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support H5', 'foxiz' ),
					'subtitle' => esc_html__( 'Support H5 tag, Turn this option off if you would like to exclude H5 tag out of the table of contents.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_h6',
					'type'     => 'switch',
					'title'    => esc_html__( 'Support H6', 'foxiz' ),
					'subtitle' => esc_html__( 'Support H6 tag, Turn this option off if you would like to exclude H6 tag out of the table of contents.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'     => 'section_end_table_contents_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_table_contents_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Layout Settings', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'table_contents_layout',
					'title'    => esc_html__( 'layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a layout for the table of contents.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Full Width (2 Columns)', 'foxiz' ),
						'2' => esc_html__( 'Half Width', 'foxiz' ),
						'3' => esc_html__( 'Full Width (1 Column)', 'foxiz' ),
					),
					'default'  => '1'
				),
				array(
					'id'       => 'table_contents_enable',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Enable When', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a minimum value for total heading tags to show the table of contents box.', 'foxiz' ),
					'default'  => 2
				),
				array(
					'id'       => 'table_contents_heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Table of Contents Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the heading for the table of contents box.', 'foxiz' ),
					'default'  => esc_html__( 'Contents', 'foxiz' )
				),
				array(
					'id'       => 'table_contents_position',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'type'     => 'text',
					'title'    => esc_html__( 'Display Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a position (after x paragraphs) to display the table of contents box.', 'foxiz' ),
					'default'  => '1'
				),
				array(
					'id'          => 'table_contents_hierarchy',
					'type'        => 'switch',
					'title'       => esc_html__( 'Show Hierarchy', 'foxiz' ),
					'subtitle'    => esc_html__( 'Enable or disable hierarchy for the table of contents box.', 'foxiz' ),
					'description' => esc_html__( 'This setting will not apply to the full width 2 columns layout.', 'foxiz' ),
					'default'     => 1
				),
				array(
					'id'       => 'table_contents_numlist',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Number list', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the number list items.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_scroll',
					'type'     => 'switch',
					'title'    => esc_html__( 'Smooth Scroll', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable smooth scroll effect to jump to the anchor link.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'table_contents_toggle',
					'type'     => 'switch',
					'title'    => esc_html__( 'Collapse Toggle', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable the collapse toggle button.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'     => 'section_end_table_contents_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}