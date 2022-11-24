<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_footer' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_footer() {

		return array(
			'id'     => 'foxiz_config_section_footer',
			'title'  => esc_html__( 'Footer', 'foxiz' ),
			'desc'   => esc_html__( 'Select options for your website footer. Navigate to Appearance > Widgets to add widgets to footer sections.', 'foxiz' ),
			'icon'   => 'el el-credit-card',
			'fields' => array(
				array(
					'id'     => 'section_start_footer_style',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Footer Style', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'footer_background',
					'type'        => 'background',
					'transparent' => false,
					'title'       => esc_html__( 'Footer Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background for the footer: image, color, etc', 'foxiz' ),
					'default'     => array(
						'background-color' => '#88888812'
					)
				),
				array(
					'id'          => 'dark_footer_background',
					'type'        => 'background',
					'transparent' => false,
					'title'       => esc_html__( 'Dark Mode - Footer Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background for the footer in the dark mode: image, color, etc', 'foxiz' )
				),
				array(
					'id'       => 'footer_dot',
					'type'     => 'switch',
					'title'    => esc_html__( 'Left Dotted Style', 'foxiz' ),
					'subtitle' => esc_html__( 'A dotted area for display at the left of the footer.', 'foxiz' ),
					'default'  => true
				),
				array(
					'id'          => 'footer_border',
					'type'        => 'switch',
					'title'       => esc_html__( 'Top Border', 'foxiz' ),
					'subtitle'    => esc_html__( 'Show a gray border a the top footer.', 'foxiz' ),
					'description' => esc_html__( 'It will be helpful if you have not set up footer background.', 'foxiz' ),
					'default'     => false
				),
				array(
					'id'          => 'footer_color_scheme',
					'type'        => 'select',
					'title'       => esc_html__( 'Text Color Scheme', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a text color scheme for the footer.', 'foxiz' ),
					'description' => esc_html__( 'Text color scheme will be set to light in the dark mode.', 'foxiz' ),
					'options'     => array(
						'0' => esc_html__( 'Default (Dark Text)', 'foxiz' ),
						'1' => esc_html__( 'Light Text', 'foxiz' )
					),
					'default'     => '0'
				),
				array(
					'id'     => 'section_end_footer_style',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_footer_widget_section',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Footer Widget Section', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'Select "Use Ruby Template" under the "Footer Widgets Layout" setting if you use Ruby Template shortcode.', 'foxiz' ),
						esc_html__( '"Column Border" and "Widget Menu Font Size" and "Text Color Scheme" will not apply to Ruby template shortcode.', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'          => 'footer_layout',
					'type'        => 'select',
					'title'       => esc_html__( 'Footer Widgets Layout', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a layout for the footer widget area.', 'foxiz' ),
					'description' => esc_html__( 'To add content, please navigate to Appearance > Widgets.', 'foxiz' ),
					'options'     => array(
						'0'         => esc_html__( '4 Columns (3/2/2/3)', 'foxiz' ),
						'5'         => esc_html__( '5 Columns (1/1/1/1/1)', 'foxiz' ),
						'51'        => esc_html__( '5 Columns (40/15/15/15/15)', 'foxiz' ),
						'3'         => esc_html__( '3 Columns (1/2/1)', 'foxiz' ),
						'shortcode' => esc_html__( 'Use Ruby Template', 'foxiz' ),
						'none'      => esc_html__( 'Disable', 'foxiz' )
					),
					'default'     => '5'
				),
				array(
					'id'       => 'footer_column_border',
					'type'     => 'switch',
					'title'    => esc_html__( 'Column Border', 'foxiz' ),
					'subtitle' => esc_html__( 'Show gray borders between widget columns.', 'foxiz' ),
					'default'  => false
				),
				array(
					'id'          => 'footer_columns_size',
					'type'        => 'text',
					'title'       => esc_html__( 'Widget Menu Font Size', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a font size value (in px) for the default menu widgets are displaying in the footer.', 'foxiz' ),
					'description' => esc_html__( 'Leave blank if you use the "Archive & Menu Widgets" font size setting.', 'foxiz' ),
				),
				array(
					'id'          => 'footer_template_shortcode',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Footer Widgets - Template Shortcode', 'foxiz' ),
					'placeholder' => esc_html__( '[Ruby_E_Template id="1"]', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input your template shortcode you would like to use Elementor builder.', 'foxiz' ),
					'rows'        => '2',
					'default'     => '',
				),
				array(
					'id'     => 'section_end_footer_widget_section',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_footer_bottom',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Footer Bottom Section', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'footer_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Footer Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a small logo to display at bottom of the footer.', 'foxiz' )
				),
				array(
					'id'       => 'dark_footer_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Copyright Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a small dark logo to display at bottom of the footer in the dark mode.', 'foxiz' )
				),
				array(
					'id'       => 'footer_logo_height',
					'type'     => 'text',
					'title'    => esc_html__( 'Logo Height', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a height for value for the footer logo, Default is 50px.', 'foxiz' )
				),
				array(
					'id'       => 'footer_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Social Icons', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the social list in this section.', 'foxiz' ),
					'default'  => true
				),
				array(
					'id'       => 'footer_bottom_center',
					'type'     => 'switch',
					'title'    => esc_html__( 'Centered Mode', 'foxiz' ),
					'subtitle' => esc_html__( 'Centering this section.', 'foxiz' ),
					'default'  => false
				),
				array(
					'id'     => 'section_end_footer_bottom',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_footer_copyright',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Copyright Section', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'copyright',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Copyright Text', 'foxiz' ),
					'subtitle' => esc_html__( 'input your copyright text or HTML.', 'foxiz' ),
					'rows'     => '4',
					'default'  => '',
				),
				array(
					'id'          => 'footer_menu',
					'type'        => 'select',
					'title'       => esc_html__( 'Copyright Menu', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a menu to display in the footer copyright bar.', 'foxiz' ),
					'description' => esc_html__( 'Navigate to Typography > Archive & Menu Widgets > Footer Menus to set the font values.', 'foxiz' ),
					'data'        => 'menus'
				),
				array(
					'id'       => 'footer_copyright_text_size',
					'type'     => 'text',
					'title'    => esc_html__( 'Copyright - Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a font size value (in px) for the copy right text.', 'foxiz' ),
				),
				array(
					'id'          => 'footer_copyright_size',
					'type'        => 'text',
					'title'       => esc_html__( 'Copyright Menu - Font Size', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a font size value (in px) for the footer copyright menu.', 'foxiz' ),
					'description' => esc_html__( 'Leave blank if you use the "Archive & Menu Widgets" font size setting.', 'foxiz' ),
				),
				array(
					'id'     => 'section_end_footer_copyright',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}
