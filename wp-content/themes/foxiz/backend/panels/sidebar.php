<?php
/** sidebar config */
if ( ! function_exists( 'foxiz_register_options_sidebar' ) ) {
	function foxiz_register_options_sidebar() {
		return array(
			'id'     => 'foxiz_theme_ops_section_sidebar',
			'title'  => esc_html__( 'Sidebar Area', 'foxiz' ),
			'desc'   => esc_html__( 'Select settings for your website sidebars, The settings below apply to all sidebars.', 'foxiz' ),
			'icon'   => 'el el-align-right',
			'fields' => array(
				array(
					'id'    => 'multi_sidebar_notice',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'Refresh your browser after creating new sidebars to update your changes.', 'foxiz' ),
				),
				array(
					'id'    => 'widget_heading_layout_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the widget heading layout, navigate to "Heading Design > Sidebar Widget Heading".', 'foxiz' ),
				),
				array(
					'id'          => 'global_sidebar_position',
					'type'        => 'image_select',
					'title'       => esc_html__( 'Global Sidebar Position', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select the default sidebar position for your website.', 'foxiz' ),
					'description' => esc_html__( 'This is the global option and will be overridden by individual "Sidebar Position" settings.', 'foxiz' ),
					'options'     => foxiz_config_sidebar_position( false ),
					'default'     => 'right'
				),
				array(
					'id'         => 'multi_sidebars',
					'type'       => 'multi_text',
					'class'      => 'medium-text',
					'show_empty' => false,
					'title'      => esc_html__( 'Unlimited Sidebars', 'foxiz' ),
					'label'      => esc_html__( 'Add a Sidebar ID', 'foxiz' ),
					'subtitle'   => esc_html__( 'Create new or delete exist sidebars.', 'foxiz' ),
					'desc'       => esc_html__( 'Click on the "Create Sidebar" button, then input a name/ID (without special charsets and spacing) into the field to create a new sidebar.', 'foxiz' ),
					'add_text'   => esc_html__( 'Click then Input ID to Create a Sidebar', 'foxiz' ),
					'default'    => array(),
				),
				array(
					'id'          => 'sticky_sidebar',
					'type'        => 'switch',
					'title'       => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle'    => esc_html__( 'Making sidebars permanently visible when scrolling up and down.', 'foxiz' ),
					'description' => esc_html__( 'Useful when a sidebar is too tall or too short compared to the rest of the content.', 'foxiz' ),
					'default'     => '0'
				),
				array(
					'id'       => 'widget_block_editor',
					'type'     => 'switch',
					'title'    => esc_html__( 'Widget Block Editor', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable widget block editor (WordPress 5.8 or above).', 'foxiz' ),
					'default'  => 0
				),
			)
		);
	}
}