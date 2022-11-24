<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_breadcrumb' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_breadcrumb() {

		return array(
			'title'  => esc_html__( 'Breadcrumb Bar', 'foxiz' ),
			'id'     => 'foxiz_config_section_breadcrumb',
			'desc'   => esc_html__( 'The theme supports Navxt plugin Yoast SEO and Rank Math SEO breadcrumbs.', 'foxiz' ),
			'icon'   => 'el el-random',
			'fields' => array(
				array(
					'id'       => 'section_start_breadcrumb_global',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global', 'foxiz' ),
					'subtitle' => esc_html__( 'These settings below require to activate Navxt plugin Yoast SEO and Rank Math SEO breadcrumbs in order to work.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => 'breadcrumb',
					'type'     => 'switch',
					'title'    => esc_html__( 'Breadcrumb Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb bar for your website.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'breadcrumb_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Breadcrumb Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a style for your site breadcrumb.', 'foxiz' ),
					'options'  => array(
						'0'    => esc_html__( 'No Wrap', 'foxiz' ),
						'wrap' => esc_html__( 'Re Wrap', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_breadcrumb_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_page_breadcrumb',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Page Breadcrumbs', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_breadcrumb',
					'title'    => esc_html__( 'Single Post Breadcrumb', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb bar in the single post.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '1'
				),
				array(
					'id'       => 'single_page_breadcrumb',
					'title'    => esc_html__( 'Single Page Breadcrumb', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb bar in the single page.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'       => 'category_breadcrumb',
					'title'    => esc_html__( 'Category Breadcrumb', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb in the category pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '1'
				),
				array(
					'id'       => 'author_breadcrumb',
					'title'    => esc_html__( 'Author Breadcrumb', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb in the author pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '1'
				),
				array(
					'id'       => 'archive_breadcrumb',
					'title'    => esc_html__( 'Archive Breadcrumb', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb in the archive pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '1'
				),
				array(
					'id'     => 'section_end_page_breadcrumb',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			),
		);
	}
}