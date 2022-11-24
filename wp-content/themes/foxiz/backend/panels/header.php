<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_header' ) ) {
	/**
	 * @return array
	 * header settings
	 */
	function foxiz_register_options_header() {

		return array(
			'id'    => 'foxiz_config_section_header',
			'title' => esc_html__( 'Header', 'foxiz' ),
			'desc'  => esc_html__( 'Select options for your website header.', 'foxiz' ),
			'icon'  => 'el el-th'
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_general' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_general() {

		return array(
			'id'         => 'foxiz_config_section_header_general',
			'title'      => esc_html__( 'General', 'foxiz' ),
			'icon'       => 'el el-cog',
			'subsection' => true,
			'desc'       => esc_html__( 'Select the style and other settings for your website header.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'       => 'section_start_header_style',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global Site Header', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The global settings will apply whole the website.', 'foxiz' ),
						esc_html__( 'Select "Use Ruby Template" under the "Global Header Style" setting if you use Ruby Template shortcode.', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'          => 'header_style',
					'type'        => 'select',
					'title'       => esc_html__( 'Global Header Style', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select the global header style for your website header.', 'foxiz' ),
					'options'     => foxiz_config_header_style( false, false, true ),
					'description' => esc_html__( 'Please select setting panel corresponding to the layout you choose for setting up background, color and other settings.', 'foxiz' ),
					'default'     => '1'
				),
				array(
					'id'          => 'header_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Global Header Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header.', 'foxiz' ),
					'description' => esc_html__( 'This setting requires to set "Use Ruby Template" in the setting above in order to work.', 'foxiz' ),
					'placeholder' => esc_html__( '[Ruby_E_Template id="1"]', 'foxiz' ),
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_header_style',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_header_sticky',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Sticky Menu', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'sticky',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sticky Menu', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the sticky feature for the main menu bar.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'       => 'smart_sticky',
					'type'     => 'switch',
					'title'    => esc_html__( 'Smart Sticky', 'foxiz' ),
					'subtitle' => esc_html__( 'Only stick the main menu when scrolling up.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_header_sticky',
					'type'   => 'section',
					'class'  => 'no-border ruby-section-end',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_more' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_more() {

		return array(
			'id'         => 'foxiz_config_section_header_more',
			'title'      => esc_html__( 'More Menu Item', 'foxiz' ),
			'icon'       => 'el el-braille',
			'subsection' => true,
			'desc'       => esc_html__( 'Select options for the more menu and enable/disable it for each header style.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'    => 'info_more_section',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To add column widgets, navigate to "Dashboard > Appearance > Widgets > More Menu Section". Please read the documentation for further information.', 'foxiz' ),
				),
				array(
					'id'          => 'more_column',
					'type'        => 'select',
					'title'       => esc_html__( 'Columns per Row', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select columns per row for this section.', 'foxiz' ),
					'description' => esc_html__( 'Each widget is added in "Appearance >Widgets > More Menu Section" will be corresponding to a column.', 'foxiz' ),
					'options'     => array(
						'2' => esc_html__( '2 Columns', 'foxiz' ),
						'3' => esc_html__( '3 Columns', 'foxiz' ),
						'4' => esc_html__( '4 Columns', 'foxiz' ),
						'5' => esc_html__( '5 Columns', 'foxiz' )
					),
					'default'     => '3'
				),
				array(
					'id'       => 'more_width',
					'type'     => 'text',
					'class'    => 'small-text',
					'title'    => esc_html__( 'Section Width', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a width value (in px) for this section. Leave blank to set a the default.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'more_footer_menu',
					'type'     => 'select',
					'options'  => foxiz_config_menu_slug(),
					'title'    => esc_html__( 'Footer Menu', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a footer menu to display at the bottom of this section.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'more_footer_copyright',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Footer Copyright', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the footer copyright text to display at the bottom of this section, allow raw HTML.', 'foxiz' ),
					'default'  => ''
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_search' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_search() {

		return array(
			'id'         => 'foxiz_config_section_header_search',
			'title'      => esc_html__( 'Header Search', 'foxiz' ),
			'icon'       => 'el el-search',
			'subsection' => true,
			'desc'       => esc_html__( 'Select settings for search form to display in the website header.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'    => 'info_search_placeholder',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the placeholder text of the search form, navigate to "Theme Options > General > Search Placeholder".', 'foxiz' ),
				),
				array(
					'id'          => 'header_search_heading',
					'type'        => 'text',
					'title'       => esc_html__( 'Search Heading', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a heading for displaying above the search form.', 'foxiz' ),
					'description' => esc_html__( 'The heading will show in the "More" section and "Mobile Header Collapse" section.', 'foxiz' ),
					'default'     => esc_html__( 'Search', 'foxiz' )
				),
				array(
					'id'       => 'header_search_icon',
					'type'     => 'switch',
					'title'    => esc_html__( 'Header Search Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the search icon in the header.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'          => 'header_search_mode',
					'type'        => 'select',
					'title'       => esc_html__( 'Toggle Mode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select mode for the search button when clicking on.', 'foxiz' ),
					'description' => esc_html__( 'Ensure the option "More Menu - Search Form" is enabled when you select the "More Menu Triggered" option.', 'foxiz' ),
					'options'     => array(
						'search' => esc_html__( 'Standard Search Form', 'foxiz' ),
						'more'   => esc_html__( 'More Menu Triggered', 'foxiz' )
					),
					'default'     => 'search'
				),
				array(
					'id'       => 'ajax_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'Live Search Result', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable live search result when typing.', 'foxiz' ),
					'default'  => 0
				),
				array(
					'id'       => 'more_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'More Menu - Search Form', 'foxiz' ),
					'subtitle' => esc_html__( 'Show search form at the top of the more section.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'mobile_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'Mobile Header - Search Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable search icon in the mobile header.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'mobile_amp_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'AMP Header - Search Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable search icon the AMP header.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'          => 'header_search_custom_icon',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Custom Search SVG', 'foxiz' ),
					'subtitle'    => esc_html__( 'Override default search icon with a SVG icon.', 'foxiz' ),
					'description' => esc_html__( 'Enable the option in "Theme Design > SVG Upload > SVG Supported" if you cannot upload .SVG files.', 'foxiz' ),
				),
				array(
					'id'       => 'header_search_custom_icon_size',
					'title'    => esc_html__( 'SVG Icon Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom font size (in px) for your SVG icon. Default is 20px', 'foxiz' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'default'  => '',
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_notification' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_notification() {

		return array(
			'id'         => 'foxiz_config_section_header_notification',
			'title'      => esc_html__( 'Notification', 'foxiz' ),
			'icon'       => 'el el-bell',
			'subsection' => true,
			'desc'       => esc_html__( 'This section will show the user bookmark list and latest blog listing.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'       => 'header_notification',
					'type'     => 'switch',
					'title'    => esc_html__( 'Notification Section', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the notification section on the header.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'header_notification_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Destination Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a destination URL for the notification panel.', 'foxiz' ),
					'default'  => '#'
				),
				array(
					'id'          => 'header_notification_scheme',
					'type'        => 'select',
					'title'       => esc_html__( 'Text Color Scheme', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a text color scheme to fit with the sub menu background.', 'foxiz' ),
					'description' => esc_html__( 'Ensure this section set to Light Text if you select a dark sub-menu background.', 'foxiz' ),
					'options'     => array(
						'0' => esc_html__( 'Default (Dark Text)', 'foxiz' ),
						'1' => esc_html__( 'Light Text', 'foxiz' )
					),
					'default'     => 0
				),
				array(
					'id'          => 'notification_custom_icon',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Custom Notification SVG', 'foxiz' ),
					'subtitle'    => esc_html__( 'Override the bell icon with a SVG icon.', 'foxiz' ),
					'description' => esc_html__( 'Enable the option in "Theme Design > SVG Upload > SVG Supported" if you cannot upload .SVG files.', 'foxiz' )
				),
				array(
					'id'       => 'notification_custom_icon_size',
					'title'    => esc_html__( 'SVG Icon Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom font size (in px) for your SVG icon. Default is 20px', 'foxiz' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'default'  => ''
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_mobile' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_mobile() {

		return array(
			'id'         => 'foxiz_config_section_header_mobile',
			'title'      => esc_html__( 'Mobile Header', 'foxiz' ),
			'icon'       => 'el el-iphone-home',
			'subsection' => true,
			'desc'       => esc_html__( 'The settings below apply to the mobile header.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'    => 'info_mobile_navbar_typo',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the typography, navigate to "Typography > Menu > Mobile Menu Settings". Navigate to "Social Profiles" for the social list.', 'foxiz' ),
				),
				array(
					'id'    => 'info_mobile_header_color',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Color settings will apply to the tablet and mobile header. Leave blank to set as the desktop navigation colors.', 'foxiz' ),
				),
				array(
					'id'    => 'info_mobile_header_dark_color',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'Ensure you have also set "Dark Mode Colors" if you use custom colors for the default mode.', 'foxiz' ),
				),
				array(
					'id'       => 'section_start_mh_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Mobile Header Style', 'foxiz' ),
					'subtitle' => esc_html__( 'The center logo style is best suited for small width logos.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => 'mh_layout',
					'type'     => 'select',
					'title'    => esc_html__( 'Mobile Header Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a layout for the mobile header.', 'foxiz' ),
					'options'  => array(
						'0' => esc_html__( 'Left Logo', 'foxiz' ),
						'1' => esc_html__( 'Center Logo', 'foxiz' ),
						'2' => esc_html__( 'Left Logo 2', 'foxiz' ),
					),
					'default'  => 0
				),
				array(
					'id'       => 'mobile_height',
					'type'     => 'text',
					'class'    => 'small-text',
					'title'    => esc_html__( 'Mobile Navigation Height', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom height value for the mobile navigation, Default is 40px.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'     => 'section_end_mh_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_mobile_collapse',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Collapse Section', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'mobile_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Socials List', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the socials list.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'mobile_footer_menu',
					'type'     => 'select',
					'options'  => foxiz_config_menu_slug(),
					'title'    => esc_html__( 'Footer Menu', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a footer menu to display at the bottom of this section.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'mobile_copyright',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Footer Copyright', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the footer copyright text to display at the bottom of this section, allow raw HTML.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'     => 'section_end_mobile_collapse',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_mh_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Mobile Header Colors', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'mobile_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Header Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for the mobile navigation bar and quick view mobile menu.', 'foxiz' ),
					'description' => esc_html__( 'use the option "To" to set a gradient background.', 'foxiz' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => array(
						'from' => '',
						'to'   => '',
					),
				),
				array(
					'id'          => 'mobile_color',
					'title'       => esc_html__( 'Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a text color for toggle button, search, quick view menu for displaying on the mobile header.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'mobile_sub_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Collapse Section Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for the collapse section.', 'foxiz' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => array(
						'from' => '',
						'to'   => '',
					),
				),
				array(
					'id'          => 'mobile_sub_color',
					'title'       => esc_html__( 'Collapse Section - Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a text color for menu item, sub menu item and other elements for displaying in the collapse section.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_mh_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_mh_dark_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Dark Mode Colors', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'dark_mobile_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Header Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for the mobile navigation bar and quick view mobile menu in the dark mode.', 'foxiz' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => array(
						'from' => '',
						'to'   => '',
					),
				),
				array(
					'id'          => 'dark_mobile_color',
					'title'       => esc_html__( 'Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a text color for toggle button, search, quick view menu for displaying on the mobile header in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_mobile_sub_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Collapse Section Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for the collapse section in the dark mode.', 'foxiz' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => array(
						'from' => '',
						'to'   => '',
					),
				),
				array(
					'id'          => 'dark_mobile_sub_color',
					'title'       => esc_html__( 'Collapse Section - Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a text color for menu item, sub menu item and other elements for displaying in the collapse section in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_mh_dark_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_login' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_login() {

		return array(
			'id'         => 'foxiz_config_section_header_login',
			'title'      => esc_html__( 'Popup Sign In', 'foxiz' ),
			'icon'       => 'el el-user',
			'desc'       => esc_html__( 'Select settings for the popup sign in form.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'login_popup_info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To config the popup login form. Please navigate to "Theme Options > Login > Popup Sign In".', 'foxiz' ),
				),
				array(
					'id'    => 'login_popup_redirect_info',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'Redirect links should be inner links.', 'foxiz' ),
				),
				array(
					'id'       => 'header_login_icon',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sign In Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the sign in button on the header.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'mobile_login',
					'type'     => 'switch',
					'title'    => esc_html__( 'Mobile Header - Sign In', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the sign in button on the mobile header.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'header_login_layout',
					'type'     => 'select',
					'title'    => esc_html__( 'Trigger Button Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a layout for the sign in trigger button.', 'foxiz' ),
					'options'  => array(
						'0' => esc_html__( 'Icon', 'foxiz' ),
						'1' => esc_html__( 'Text Button', 'foxiz' ),
						'2' => esc_html__( 'Text with Icon Button', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'          => 'header_login_menu',
					'type'        => 'select',
					'title'       => esc_html__( 'User Dashboard Menu', 'foxiz' ),
					'subtitle'    => esc_html__( 'Assign a menu for displaying when hovering on the login icon if user logged.', 'foxiz' ),
					'options'     => foxiz_config_menu_slug(),
					'placeholder' => esc_html__( '- Assign a Menu -', 'foxiz' ),
					'default'     => '',
				),
				array(
					'id'          => 'login_custom_icon',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Custom Login SVG', 'foxiz' ),
					'subtitle'    => esc_html__( 'Override the user icon with a SVG icon.', 'foxiz' ),
					'description' => esc_html__( 'Enable the option in "Theme Design > SVG Upload > SVG Supported" if you cannot upload .SVG files.', 'foxiz' ),
				),
				array(
					'id'       => 'login_custom_icon_size',
					'title'    => esc_html__( 'SVG Icon Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom font size (in px) for your SVG icon. Default is 20px', 'foxiz' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'default'  => '',
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_alert' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_alert() {

		return array(
			'id'         => 'foxiz_config_section_header_alert',
			'title'      => esc_html__( 'Alert Bar', 'foxiz' ),
			'icon'       => 'el el-bell',
			'subsection' => true,
			'desc'       => esc_html__( 'This section will show a small alert or event at the bottom of the navigation.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'       => 'alert_bar_info',
					'type'     => 'info',
					'style'    => 'warning',
					'subtitle' => esc_html__( 'The alert bar will not be available if you use a header template. The theme provides other ways for you to add any info into the header template via HTML, text and button and other blocks.', 'foxiz' ),
					'default'  => false,
				),
				array(
					'id'       => 'alert_bar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Alert Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the alert bar below the header. This option will be overridden by the setting in individual post/page.', 'foxiz' ),
					'default'  => false,
				),
				array(
					'id'       => 'alert_home',
					'type'     => 'switch',
					'title'    => esc_html__( 'Only Homepage', 'foxiz' ),
					'subtitle' => esc_html__( 'Only show the bar in the homepage.', 'foxiz' ),
					'switch'   => true,
					'default'  => true
				),
				array(
					'id'       => 'alert_content',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Alert Content', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your alert content to show.', 'foxiz' ),
					'rows'     => 3,
					'default'  => ''
				),
				array(
					'id'       => 'alert_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Alert URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your alert URL.', 'foxiz' ),
					'default'  => '#'
				),
				array(
					'id'          => 'alert_bg',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Background Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select background color for the bar.', 'foxiz' )
				),
				array(
					'id'          => 'alert_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select text color for the bar.', 'foxiz' )
				),
				array(
					'id'          => 'dark_alert_bg',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Dark Mode - Background Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select background color for the bar in the dark mode.', 'foxiz' ),
				),
				array(
					'id'          => 'dark_alert_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Dark Mode - Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select text color for the bar in the dark mode.', 'foxiz' ),
				),
				array(
					'id'       => 'alert_sticky_hide',
					'title'    => esc_html__( 'Hide when Sticky', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide this bar on the sticky navigation.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_header_cart' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_header_cart() {

		return array(
			'id'         => 'foxiz_config_section_mini_cart',
			'title'      => esc_html__( 'Mini Cart', 'foxiz' ),
			'icon'       => 'el el-shopping-cart',
			'subsection' => true,
			'desc'       => esc_html__( 'Show a cart icon at the website header.', 'foxiz' ),
			'fields'     => array(
				foxiz_wc_plugin_status_info( 'header_mini_cart_info' ),
				array(
					'id'       => 'wc_mini_cart',
					'type'     => 'switch',
					'title'    => esc_html__( 'Header Mini Cart', 'foxiz' ),
					'subtitle' => esc_html__( 'Show mini cart icon in the header.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'wc_mobile_mini_cart',
					'type'     => 'switch',
					'title'    => esc_html__( 'Mobile Header - Mini Cart', 'foxiz' ),
					'subtitle' => esc_html__( 'Show mini cart icon in the mobile header.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'cart_counter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Cart Counter', 'foxiz' ),
					'subtitle' => esc_html__( 'Show number of products in the cart.', 'foxiz' ),
					'default'  => true
				),
				array(
					'id'       => 'total_amount',
					'type'     => 'switch',
					'title'    => esc_html__( 'Total Amount', 'foxiz' ),
					'subtitle' => esc_html__( 'Show total amount after the cart icon.', 'foxiz' ),
					'switch'   => true,
					'default'  => false
				),
				array(
					'id'       => 'cart_custom_icon',
					'type'     => 'media',
					'title'    => esc_html__( 'Custom Cart SVG Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Override default cart icon with a SVG icon.', 'foxiz' ),
				),
				array(
					'id'       => 'cart_custom_icon_size',
					'title'    => esc_html__( 'SVG Icon Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom font size (in px) for your SVG icon. Default is 20px', 'foxiz' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'default'  => '',
				)
			)
		);
	}
}