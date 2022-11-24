<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_socials' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_socials() {
		return array(
			'id'     => 'social_theme_options_section_socials',
			'title'  => esc_html__( 'Social Profiles', 'foxiz' ),
			'icon'   => 'el el-facebook',
			'desc'   => esc_html__( 'Adding social profiles for your website.', 'foxiz' ),
			'fields' => array(
				array(
					'id'     => 'section_start_socials',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Social Profiles', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'facebook',
					'type'     => 'text',
					'title'    => esc_html__( 'Facebook URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' ),
					'default'  => '#'
				),
				array(
					'id'       => 'twitter',
					'type'     => 'text',
					'title'    => esc_html__( 'Twitter URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' ),
					'default'  => '#'
				),
				array(
					'id'       => 'youtube',
					'type'     => 'text',
					'title'    => esc_html__( 'Youtube URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' ),
					'default' => '#',
				),
				array(
					'id'       => 'instagram',
					'type'     => 'text',
					'title'    => esc_html__( 'Instagram URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' ),
				),
				array(
					'id'       => 'pinterest',
					'type'     => 'text',
					'title'    => esc_html__( 'Pinterest URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'linkedin',
					'type'     => 'text',
					'title'    => esc_html__( 'LinkedIn URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'tumblr',
					'type'     => 'text',
					'title'    => esc_html__( 'Tumblr URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'flickr',
					'type'     => 'text',
					'title'    => esc_html__( 'Flickr URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'skype',
					'type'     => 'text',
					'title'    => esc_html__( 'Skype URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'snapchat',
					'type'     => 'text',
					'title'    => esc_html__( 'Snapchat URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'myspace',
					'type'     => 'text',
					'title'    => esc_html__( 'Myspace URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'bloglovin',
					'type'     => 'text',
					'title'    => esc_html__( 'Bloglovin URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'digg',
					'type'     => 'text',
					'title'    => esc_html__( 'Digg URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'dribbble',
					'type'     => 'text',
					'title'    => esc_html__( 'Dribbble URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'soundcloud',
					'type'     => 'text',
					'title'    => esc_html__( 'Soundcloud URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'vimeo',
					'type'     => 'text',
					'title'    => esc_html__( 'Vimeo URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'reddit',
					'type'     => 'text',
					'title'    => esc_html__( 'Reddit URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'vk',
					'type'     => 'text',
					'title'    => esc_html__( 'VKontakte URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'telegram',
					'type'     => 'text',
					'title'    => esc_html__( 'Telegram URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'whatsapp',
					'type'     => 'text',
					'title'    => esc_html__( 'Whatsapp URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'       => 'rss',
					'type'     => 'text',
					'title'    => esc_html__( 'Rss URL ', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL, Leave blank if you want to disable it.', 'foxiz' )
				),
				array(
					'id'     => 'section_end_socials',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_custom_socials',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Custom Social Profiles', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'    => 'custom_socials_info',
					'type'  => 'info',
					'title' => esc_html__( 'Please ensure that Font Awesome is enabled in "Theme Options > Theme Design > Font Awesome" if you use this font icon classname.', 'foxiz' ),
					'style' => 'info'
				),
				array(
					'id'       => 'custom_social_1_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom social 1 - URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_1_name',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Social 1 - Name', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the name of the social, for example: facebook, twitter.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_1_icon',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Social 1 - Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the name of font icon, for example: "fab fa-facebook".', 'foxiz' ),
					'default'  => '',
				),
				array(
					'id'          => 'custom_social_1_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Custom Social 1 - Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for this social icon.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_2_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom social 2 - URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_2_name',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Social 2 - Name', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the name of the social, for example: facebook, twitter.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_2_icon',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Social 2 - Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the name of font icon, for example: "fab fa-facebook".', 'foxiz' ),
					'default'  => '',
				),
				array(
					'id'          => 'custom_social_2_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Custom Social 2 - Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for this social icon.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_3_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom social 3 - URL', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your social profile URL.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_3_name',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Social 3 - Name', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the name of the social, for example: facebook, twitter.', 'foxiz' )
				),
				array(
					'id'       => 'custom_social_3_icon',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Social 3 - Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the name of font icon, for example: "fab fa-facebook".', 'foxiz' ),
					'default'  => '',
				),
				array(
					'id'          => 'custom_social_3_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Custom Social 3 - Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for this social icon.', 'foxiz' )
				),
				array(
					'id'     => 'section_end_custom_socials',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}