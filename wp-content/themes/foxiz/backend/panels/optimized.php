<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_performance' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_performance() {

		return array(
			'id'     => 'foxiz_config_section_performance',
			'title'  => esc_html__( 'Performance', 'foxiz' ),
			'desc'   => esc_html__( 'Select options to optimize your website speed.', 'foxiz' ),
			'icon'   => 'el el-dashboard',
			'fields' => array(
				array(
					'id'    => 'performance_info',
					'type'  => 'info',
					'title' => sprintf( esc_html__( 'We recommend you to refer this <a target="_blank" href="%s">DOCUMENTATION</a> to optimize for you website', 'foxiz' ), 'https://help.themeruby.com/foxiz/optimizing-your-site-speed-and-google-pagespeed-insights/' ),
					'style' => 'info',
				),
				array(
					'id'       => 'lazy_load',
					'type'     => 'switch',
					'title'    => esc_html__( 'Lazy Load Featured Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the lazy load for the featured image.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'disable_srcset',
					'type'     => 'switch',
					'title'    => esc_html__( 'Disable Srcset', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable Srcset to optimize page speed score on mobile device.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'disable_dashicons',
					'type'     => 'switch',
					'title'    => esc_html__( 'Disable Dashicons', 'foxiz' ),
					'subtitle' => esc_html__( 'Some 3rd party plugins will load this font icon. Disable it if you have not plan to use it.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'disable_block_style',
					'type'     => 'switch',
					'title'    => esc_html__( 'Disable Gutenberg Style on Page Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable the block style css on the page built with Page Builder.', 'foxiz' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'          => 'disable_polyfill',
					'type'        => 'switch',
					'title'       => esc_html__( 'Disable Polyfill Script', 'foxiz' ),
					'subtitle'    => esc_html__( 'Disable wp-polyfill script (supporting older browsers that do not understand ES6) to improve the page speed score.', 'foxiz' ),
					'description' => esc_html__( 'Disable this script can cause issues with some features on Elementor Pro.', 'foxiz' ),
					'switch'      => true,
					'default'     => 0
				),
				array(
					'id'       => 'preload_gfonts',
					'type'     => 'switch',
					'title'    => esc_html__( 'Preload Google Fonts', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable preload Google fonts to increase the site speed score.', 'foxiz' ),
					'default'  => 1,
				),
				array(
					'id'       => 'preload_font_icon',
					'type'     => 'switch',
					'title'    => esc_html__( 'Preload Font Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable preload font icons to increase the site speed score.', 'foxiz' ),
					'default'  => 1,
				),
				array(
					'id'          => 'disable_default_fonts',
					'type'        => 'switch',
					'title'       => esc_html__( 'Disable Default Fonts', 'foxiz' ),
					'subtitle'    => esc_html__( 'The theme will load default fonts to render some elements as heading tags, body, meta.', 'foxiz' ),
					'description' => esc_html__( 'Enable this option if all fonts in Typography panels is set.', 'foxiz' ),
					'switch'      => true,
					'default'     => 0
				),
				array(
					'id'       => 'css_file',
					'type'     => 'switch',
					'title'    => esc_html__( 'Force write Dynamic CSS to file', 'foxiz' ),
					'subtitle' => esc_html__( 'Write CSS to file to reduce CPU usage and reduce the load time.', 'foxiz' ),
					'desc'     => esc_html__( 'The dynamic file CSS may not apply immediately on some servers due to the server cache.', 'foxiz' ),
					'default'  => 0,
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_seo' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_seo() {

		return array(
			'id'     => 'foxiz_config_section_seo',
			'title'  => esc_html__( 'SEO Optimized', 'foxiz' ),
			'desc'   => esc_html__( 'Select SEO options for your website. This panel helps your website optimized for SEO and appear better on the search engines.', 'foxiz' ),
			'icon'   => 'el el-graph',
			'fields' => array(
				array(
					'id'       => 'section_start_seo_snippets',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'SEO Snippets', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'Duplicate meta description, Schema markup, and other SEO tags may cause issues. The theme will automatically optimize settings for popular SEO plugins. However, please double check the below settings to ensure.', 'foxiz' ),
						esc_html__( 'We suggest you to use Google rich results test tool here: search.google.com/test/rich-results', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'       => 'organization_markup',
					'type'     => 'switch',
					'title'    => esc_html__( 'Organization Schema Markup', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable schema markup for the website, helps generate brand signals. Disable this option if you want to use 3rd party plugin.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'website_markup',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sitelinks Search Box', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable website markup, helps to show the Search Box feature for brand SERPs and can help your website name to appear in search results.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'site_breadcrumb',
					'type'     => 'switch',
					'title'    => esc_html__( 'Breadcrumbs bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Breadcrumbs are a hierarchy of links displayed in search engines and your website. This option requests the "Breadcrumb NavXT".', 'foxiz' ),
					'default'  => 1,
				),
				array(
					'id'       => 'site_itemlist',
					'type'     => 'switch',
					'title'    => esc_html__( 'ItemList (Carousel) Markup', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable the Carousels (Item List) schema markup for your Homepage.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'website_description',
					'type'     => 'switch',
					'title'    => esc_html__( 'Meta Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Automatically generate meta description tag for your website. Disable if you use a 3rd party SEO plugin.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_article_markup',
					'type'     => 'switch',
					'title'    => esc_html__( 'Article Markup', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the default schema markup for single post page if you want to use 3rd party plugin.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_review_markup',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post Review Markup', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable review product markup for single post page if you want to use 3rd party plugin.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_seo_snippets',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_seo_information',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Organization Info', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'site_description',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Home Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Short description will display when searching your main site URL. Leave blank if you use 3rd plugins.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'site_phone',
					'type'     => 'text',
					'title'    => esc_html__( 'Phone Number', 'foxiz' ),
					'subtitle' => esc_html__( 'input your company phone number.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'site_email',
					'type'     => 'text',
					'title'    => esc_html__( 'Email', 'foxiz' ),
					'subtitle' => esc_html__( 'input your company main email.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'site_locality',
					'type'     => 'text',
					'title'    => esc_html__( 'Locality Address', 'foxiz' ),
					'subtitle' => esc_html__( 'input your company city and country address.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'site_street',
					'type'     => 'text',
					'title'    => esc_html__( 'Street Address', 'foxiz' ),
					'subtitle' => esc_html__( 'input your company street address.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'postal_code',
					'type'     => 'text',
					'title'    => esc_html__( 'Postal Code', 'foxiz' ),
					'subtitle' => esc_html__( 'input your company local postal code.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'     => 'section_end_seo_information',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_og_tag',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Open Graph', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'open_graph',
					'type'     => 'switch',
					'title'    => esc_html__( 'Open Graph', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable Open Graph (share on socials). This option will be automatically disabled if you use Yoast SEO.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'facebook_app_id',
					'type'     => 'text',
					'title'    => esc_html__( 'Facebook APP ID', 'foxiz' ),
					'subtitle' => esc_html__( 'input your facebook app ID for OG tags.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'facebook_default_img',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Fallback Share Image', 'foxiz' ),
					'subtitle' => esc_html__( 'This image is used as a fallback option if the page being shared does not contain a featured image.', 'foxiz' ),
				),
				array(
					'id'     => 'section_end_og_tag',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}