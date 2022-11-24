<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_ads' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_ads() {

		return array(
			'id'    => 'foxiz_config_section_ads',
			'title' => esc_html__( 'Ads & Slide Up', 'foxiz' ),
			'desc'  => esc_html__( 'Select ad settings for your website.', 'foxiz' ),
			'icon'  => 'el el-usd',
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_ad_auto' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_ad_auto() {

		return array(
			'id'         => 'foxiz_config_section_ad_auto',
			'title'      => esc_html__( 'Adsense - Auto Ads', 'foxiz' ),
			'desc'       => esc_html__( 'Auto ads will scan your site and automatically place ads where they are likely to perform well and potentially generate more revenue.', 'foxiz' ),
			'icon'       => 'el el-usd',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'info_adsense_auto',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'If you use auto ads code, you need to disable any other adsense units code.', 'foxiz' ),
				),
				array(
					'id'    => 'info_adsense_auto_duplicate',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'Do not place more than one auto ads code in the website.', 'foxiz' ),
				),
				array(
					'id'          => 'ad_auto_code',
					'title'       => esc_html__( 'Auto Adsense Ads Code', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input your auto ads code.', 'foxiz' ),
					'type'        => 'textarea',
					'placeholder' => esc_html( '<script async src="... crossorigin="anonymous"></script>' ),
					'description' => esc_html__( 'Leave this option blank to use unit ads code.', 'foxiz' ),
					'rows'        => 3,
					'default'     => ''
				),
				array(
					'id'       => 'disable_ad_auto_wc',
					'title'    => esc_html__( 'Disable on Woocommerce Pages', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable auto Adsense on Woocommerce such as shop, product, cart, checkout....', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_ad_top' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_ad_top() {

		return array(
			'id'         => 'foxiz_config_section_ad_top',
			'title'      => esc_html__( 'Top Site', 'foxiz' ),
			'desc'       => esc_html__( 'Select ad settings for displaying at the top of your website.', 'foxiz' ),
			'icon'       => 'el el-usd',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'info_ad_top_site',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'This section supports ads in the top header website. For other ad spots, please read the theme documentation for further info.', 'foxiz' ),
				),
				array(
					'id'     => 'section_start_ad_top_type',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Ad Type', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'ad_top_type',
					'title'    => esc_html__( 'Ad Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a ad type for displaying in the top of the website.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Script', 'foxiz' ),
						'0' => esc_html__( 'Custom Image', 'foxiz' ),
					),
					'default'  => '1'
				),
				array(
					'id'     => 'section_end_ad_top_type',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_ad_top_script',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Script Settings', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will apply if you choose the "Script" ad type.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => 'ad_top_code',
					'type'        => 'textarea',
					'rows'     => 3,
					'title'       => esc_html__( 'Script - Ad/Adsense Code', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input your ad script code.', 'foxiz' ),
					'description' => esc_html__( 'Use Adsense units code to ensure it display exactly where you put.', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => 'ad_top_size',
					'title'    => esc_html__( 'Script - Ad Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a custom size for this ad if you use adsense ad units.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0' => esc_html__( 'Do not Override', 'foxiz' ),
						'1' => esc_html__( 'Custom Size Below', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => 'ad_top_desktop_size',
					'title'    => esc_html__( 'Script - Size on Desktop', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a size on the desktop device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_ad_size_dropdown(),
					'default'  => '1'
				),
				array(
					'id'       => 'ad_top_tablet_size',
					'title'    => esc_html__( 'Script - Size on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a size on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_ad_size_dropdown(),
					'default'  => '2'
				),
				array(
					'id'       => 'ad_top_mobile_size',
					'title'    => esc_html__( 'Script - Size on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a size on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_ad_size_dropdown(),
					'default'  => '3'
				),
				array(
					'id'     => 'section_end_ad_top_script',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_ad_top_image',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Custom Image Settings', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will apply if you choose the "Custom Image" ad type.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => 'ad_top_image',
					'title'    => esc_html__( 'Custom Image - Ad Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload your ad image.', 'foxiz' ),
					'type'     => 'media',
					'default'  => ''
				),
				array(
					'id'       => 'ad_top_dark_image',
					'title'    => esc_html__( 'Custom Image - Dark Mode Ad Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload your ad image in the dark mode.', 'foxiz' ),
					'type'     => 'media',
					'default'  => ''
				),
				array(
					'id'       => 'ad_top_destination',
					'title'    => esc_html__( 'Custom Image - Ad Destination', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your ad destination URL.', 'foxiz' ),
					'type'     => 'text',
					'default'  => '#'
				),
				array(
					'id'       => 'ad_top_width',
					'title'    => esc_html__( 'Custom Image - Max Width', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a max width value (in px) for your ad image, leave blank set full size.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'     => 'section_end_ad_top_image',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_ad_top_style',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Style Settings', 'foxiz' ),
					'indent' => true
				),

				array(
					'id'          => 'ad_top_bg',
					'title'       => esc_html__( 'Section Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background for this ad section.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'default'     => ''
				),
				array(
					'id'          => 'ad_top_dark_bg',
					'title'       => esc_html__( 'Dark Mode - Section Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background for this ad section in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'default'     => ''
				),
				array(
					'id'       => 'ad_top_spacing',
					'title'    => esc_html__( 'Spacing', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a top and bottom spacing for the advert.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0' => esc_html__( '15px', 'foxiz' ),
						'1' => esc_html__( 'No spacing', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_ad_top_style',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_ad_single' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_ad_single() {

		return array(
			'id'         => 'foxiz_config_section_ad_single',
			'title'      => esc_html__( 'Inline Single Content', 'foxiz' ),
			'desc'       => esc_html__( 'Select ad settings for displaying inside the single post content.', 'foxiz' ),
			'icon'       => 'el el-usd',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'info_single_ad',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'This section supports ads inside single post content, after x paragraphs. For other ad spots, please read the theme documentation for further info.', 'foxiz' ),
				),
				array(
					'id'     => 'section_start_ad_single_type',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Ad Type', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'ad_single_type',
					'title'       => esc_html__( 'Ad Type', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a ad type for displaying inside the single post content.', 'foxiz' ),
					'description' => esc_html__( 'Setup below settings corresponding to your ad type.', 'foxiz' ),
					'type'        => 'select',
					'options'     => array(
						'1' => esc_html__( 'Script', 'foxiz' ),
						'0' => esc_html__( 'Custom Image', 'foxiz' ),
					),
					'default'     => '1'
				),
				array(
					'id'     => 'section_end_ad_single_type',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_ad_single_script',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Script Settings', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will apply if you choose the "Script" ad type.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => 'ad_single_code',
					'type'        => 'textarea',
					'rows'     => 3,
					'title'       => esc_html__( 'Script - Ad/Adsense Code', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input your custom ad script code or Adsense.', 'foxiz' ),
					'description' => esc_html__( 'Use Adsense units code to ensure it display exactly where you put.', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => 'ad_single_size',
					'title'    => esc_html__( 'Script - Ad Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a custom size for this ad if you use adsense ad units.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0' => esc_html__( 'Do not Override', 'foxiz' ),
						'1' => esc_html__( 'Custom Size Below', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => 'ad_single_desktop_size',
					'title'    => esc_html__( 'Script - Size on Desktop', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a size on the desktop device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_ad_size_dropdown(),
					'default'  => '1'
				),
				array(
					'id'       => 'ad_single_tablet_size',
					'title'    => esc_html__( 'Script - Size on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a size on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_ad_size_dropdown(),
					'default'  => '2'
				),
				array(
					'id'       => 'ad_single_mobile_size',
					'title'    => esc_html__( 'Script - Size on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a size on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_ad_size_dropdown(),
					'default'  => '3'
				),
				array(
					'id'     => 'section_end_ad_single_script',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_ad_single_image',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Custom Image Settings', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will apply if you choose the "Custom Image" ad type.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => 'ad_single_image',
					'title'    => esc_html__( 'Custom Image - Ad Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload your ad image.', 'foxiz' ),
					'type'     => 'media',
					'default'  => ''
				),
				array(
					'id'       => 'ad_single_dark_image',
					'title'    => esc_html__( 'Custom Image - Dark Mode Ad Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload your ad image in the dark mode.', 'foxiz' ),
					'type'     => 'media',
					'default'  => ''
				),
				array(
					'id'       => 'ad_single_destination',
					'title'    => esc_html__( 'Custom Image - Ad Destination', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your ad destination URL.', 'foxiz' ),
					'type'     => 'text',
					'default'  => '#'
				),
				array(
					'id'       => 'ad_single_width',
					'title'    => esc_html__( 'Custom Image - Max Width', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a max width value (in px) for your ad image, leave blank set full size.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'     => 'section_end_ad_single_image',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_ad_single_style',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Style Settings', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'ad_single_description',
					'title'    => esc_html__( 'Ad Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a description for the adverting box.', 'foxiz' ),
					'type'     => 'text',
					'default'  => esc_html__( '- Advertisement -', 'foxiz' )
				),
				array(
					'id'       => 'ad_single_align',
					'title'    => esc_html__( 'Ad Align', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a align style for the adverts.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'full'  => esc_html__( 'Full Width', 'foxiz' ),
						'left'  => esc_html__( 'Float Left', 'foxiz' ),
						'right' => esc_html__( 'Float Right', 'foxiz' ),
					),
					'default'  => 'full'
				),
				array(
					'id'          => 'ad_single_positions',
					'title'       => esc_html__( 'Display Positions', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a position (after x paragraphs) to display your ads.', 'foxiz' ),
					'description' => esc_html__( 'Allow multiple positions, separated by commas. For example: 4,9', 'foxiz' ),
					'type'        => 'text',
					'placeholder' => esc_html__( '4,9', 'foxiz' ),
					'default'     => 4
				),
				array(
					'id'     => 'section_end_ad_single_style',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_footer_slide_up' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_footer_slide_up() {

		return array(
			'id'         => 'foxiz_config_section_footer_slide_up',
			'title'      => esc_html__( 'Footer Slide Up', 'foxiz' ),
			'desc'       => esc_html__( 'Show ads or any shortcode in the slide up footer section.', 'foxiz' ),
			'icon'       => 'el el-chevron-up',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'footer_slide_up',
					'type'     => 'switch',
					'title'    => esc_html__( 'Footer Slide Up Section', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the footer slide up section.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'          => 'slide_up_shortcode',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Slide Up Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a template shortcode or any other shortcode you would like to show in this section.', 'foxiz' ),
					'placeholder' => esc_html__( '[Ruby_E_Template id="1"]', 'foxiz' ),
					'rows'        => '3',
				),
				array(
					'id'       => 'slide_up_expired',
					'type'     => 'select',
					'title'    => esc_html__( 'Side Up Expired', 'foxiz' ),
					'subtitle' => esc_html__( 'The period to redisplay the popup when visitors closed it.', 'foxiz' ),
					'options'  => array(
						'1'  => esc_html__( '1 Day', 'foxiz' ),
						'2'  => esc_html__( '2 Days', 'foxiz' ),
						'3'  => esc_html__( '3 Days', 'foxiz' ),
						'7'  => esc_html__( '1 Week', 'foxiz' ),
						'14' => esc_html__( '2 Weeks', 'foxiz' ),
						'21' => esc_html__( '3 Weeks', 'foxiz' ),
						'30' => esc_html__( '1 Month', 'foxiz' ),
						'-1' => esc_html__( 'Always Display', 'foxiz' ),
					),
					'default'  => 1
				),
				array(
					'id'       => 'slide_up_delay',
					'type'     => 'text',
					'title'    => esc_html__( 'Delay Time', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a delay time (ms) value to show the slide up after the site loaded.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'slide_up_bg',
					'title'    => esc_html__( 'Slide Up Background', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background for this section.', 'foxiz' ),
					'type'     => 'color_rgba',
				),
				array(
					'id'       => 'dark_slide_up_bg',
					'title'    => esc_html__( 'Dark Mode - Slide Up Background', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background for this section in the dark mode.', 'foxiz' ),
					'type'     => 'color_rgba',
				),
				array(
					'id'          => 'slide_up_icon_color',
					'title'       => esc_html__( 'Button Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for the slide up toggle button when activated.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_slide_up_icon_color',
					'title'       => esc_html__( 'Dark Mode - Button Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for the slide up toggle button when activated in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'slide_up_na_icon_color',
					'title'       => esc_html__( 'Not Activate - Button Text Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for the slide up toggle button when not activated.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'slide_up_na_icon_bg',
					'title'       => esc_html__( 'Not Activate - Button Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for the slide up toggle button when not activated.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
			)
		);
	}
}