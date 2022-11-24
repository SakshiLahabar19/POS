<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_logo' ) ) {
	/**
	 * @return array
	 * site logo
	 */
	function foxiz_register_options_logo() {

		return array(
			'id'    => 'foxiz_config_section_site_logo',
			'title' => esc_html__( 'Logo', 'foxiz' ),
			'icon'  => 'el el-barcode'
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_logo_global' ) ) {
	/**
	 * @return array
	 * global logo
	 */
	function foxiz_register_options_logo_global() {
		return array(
			'id'         => 'foxiz_config_section_global_logo',
			'title'      => esc_html__( 'Default Logos', 'foxiz' ),
			'desc'       => esc_html__( 'The settings below apply to whole your website.', 'foxiz' ),
			'icon'       => 'el el-laptop',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'info_add_favico',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To add the favicon, navigate to "Appearance > Customize > Site Identity > Site Icon". Please read the documentation for further information.', 'foxiz' ),
				),
				array(
					'id'       => 'logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Main Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Select or upload site logo. Recommended for logo height value is 60px, allowed extensions are .jpg, .png and .gif.', 'foxiz' ),
				),
				array(
					'id'       => 'dark_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Main Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Select or upload a light logo for displaying in the dark mode. It should be same dimensions with the site logo.', 'foxiz' ),
				),
				array(
					'id'       => 'retina_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Retina Main Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Select or upload retina (2x) logo. Recommended for logo height value is 120px, allowed extensions are .jpg, .png and .gif', 'foxiz' )
				),
				array(
					'id'       => 'dark_retina_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Retina Main Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Select or upload a light retina logo for displaying in the dark mode. It should be same dimensions with the retina site logo', 'foxiz' )
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_logo_mobile' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_logo_mobile() {
		return array(
			'id'         => 'foxiz_config_section_mobile_logo',
			'title'      => esc_html__( 'Mobile Logos', 'foxiz' ),
			'desc'       => esc_html__( 'Select or upload logos for displaying in the mobile device.', 'foxiz' ),
			'icon'       => 'el el-iphone-home',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'mobile_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Mobile Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a logo for the mobile device. Recommended for logo height value is 84px, allowed extensions are .jpg, .png and .gif', 'foxiz' )
				),
				array(
					'id'       => 'dark_mobile_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Mobile Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a light retina logo for displaying in mobile device. It should be same dimensions with the mobile logo.', 'foxiz' )
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_logo_transparent' ) ) {
	function foxiz_register_options_logo_transparent() {
		return array(
			'id'         => 'foxiz_config_section_transparent_logo',
			'title'      => esc_html__( 'Transparent Logos', 'foxiz' ),
			'desc'       => esc_html__( 'Select or upload logos for displaying in the transparent headers.', 'foxiz' ),
			'icon'       => 'el el-photo',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'transparent_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Transparent Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a light logo for transparent headers. Recommended for logo height value is 60px, allowed extensions are .jpg, .png and .gif.', 'foxiz' )
				),
				array(
					'id'       => 'transparent_retina_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Transparent Retina Logo', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a light retina logo for transparent headers. Recommended for logo height value is 120px.', 'foxiz' )
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_logo_favicon' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_logo_favicon() {

		return array(
			'id'         => 'foxiz_config_section_logo_favicon',
			'title'      => esc_html__( 'Bookmarklet', 'foxiz' ),
			'desc'       => esc_html__( 'Select or upload bookmarklet icons for iOS and Android devices.', 'foxiz' ),
			'icon'       => 'el el-bookmark',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'icon_touch_apple',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'iOS Bookmarklet Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload icon for the Apple touch (72 x 72px), allowed extensions are .jpg, .png, .gif', 'foxiz' )
				),
				array(
					'id'       => 'icon_touch_metro',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Metro UI Bookmarklet Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload icon for the Metro interface (144 x 144px), allowed extensions are .jpg, .png, .gif', 'foxiz' )
				),
			)
		);
	}
}
