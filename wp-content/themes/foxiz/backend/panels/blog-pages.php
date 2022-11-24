<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_category' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_category() {

		$prefix = 'category_';

		return array(
			'id'     => 'foxiz_config_section_category',
			'title'  => esc_html__( 'Category', 'foxiz' ),
			'icon'   => 'el el-folder-open',
			'desc'   => esc_html__( 'These are global category settings. The settings below will apply to all category pages.', 'foxiz' ),
			'fields' => array(
				array(
					'id'    => $prefix . 'settings_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit for individual category, navigate to "Admin Dashboard > Posts > Categories > Edit".', 'foxiz' ),
				),
				array(
					'id'     => 'section_start_category_site_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Site Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'header_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Header Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a website header style for the category pages.', 'foxiz' ),
					'options'  => foxiz_config_header_style( true, true ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'nav_style',
					'type'        => 'select',
					'title'       => esc_html__( 'Navigation Bar Style', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select navigation bar style for the site header in the category pages.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on the setting in the header panel. It will not apply to the header style 4.', 'foxiz' ),
					'options'     => array(
						'0'        => esc_html__( 'Default', 'foxiz' ),
						'shadow'   => esc_html__( 'Shadow', 'foxiz' ),
						'border'   => esc_html__( 'Bottom Border', 'foxiz' ),
						'd-border' => esc_html__( 'Dark Bottom Border', 'foxiz' ),
						'none'     => esc_html__( 'None', 'foxiz' )
					),
					'default'     => '0'
				),
				array(
					'id'          => $prefix . 'header_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Header Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header for the category pages.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on the "Header Style" setting, Leave it blank if you would like to use the "Header Style" setting.', 'foxiz' ),
					'placeholder' => esc_html__( '[Ruby_E_Template id="1"]', 'foxiz' ),
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_category_site_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_category_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Category Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'category_header',
					'title'    => esc_html__( 'Category Header', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select a category header style for the category pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_category_header(),
					'default'  => '1'
				),
				array(
					'id'       => $prefix . 'pattern',
					'title'    => esc_html__( 'Header Background Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background style for this category header.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_archive_header_bg(),
					'default'  => 'dot'
				),
				array(
					'id'       => $prefix . 'subcategory',
					'title'    => esc_html__( 'Sub Categories List', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the sub category list in the category header.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'     => 'section_end_category_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_category_template',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Top Template Builder', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'template',
					'title'       => esc_html__( 'Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to embed it after the category header, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'description' => esc_html__( 'This setting will be overridden by "template shortcode" in the individual category setting panel.', 'foxiz' ),
					'type'        => 'textarea',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => 2,
					'default'     => '',
				),
				array(
					'id'       => $prefix . 'template_display',
					'title'    => esc_html__( 'Template Display', 'foxiz' ),
					'subtitle' => esc_html__( 'Show template in the first or all pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Show in the first page', 'foxiz' ),
						'2' => esc_html__( 'Show in all pages', 'foxiz' )
					),
					'default'  => '1',
				),
				array(
					'id'     => 'section_end_category_template',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_category_template_global',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global Blog Query - Template Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is the main query.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template_global',
					'title'       => esc_html__( 'Global WP Query Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to display as the main blog posts, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'description' => esc_html__( 'This setting will be overridden by "Global WP Query Template Shortcode" in the individual category setting panel.', 'foxiz' ),
					'type'        => 'textarea',
					'rows'        => '2',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'default'     => '',
				),
				array(
					'id'     => 'section_end_category_template_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_category_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Posts per Page', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'posts_per_page',
					'title'       => esc_html__( 'Posts per Page', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select posts per page for the categories. Leave this option blank to set the default.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on "Dashboard > Settings > Reading > Blog pages show at most" setting. It also apply to the "Global WP Query Template Shortcode".', 'foxiz' ),
					'type'        => 'text',
					'class'       => 'small-text',
					'validate'    => 'numeric',
					'default'     => ''
				),
				array(
					'id'     => 'section_end_category_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_category_blog_header',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Latest Posts - Heading', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme supports heading dynamic content, Please read the documentation for further information.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'blog_heading',
					'title'    => esc_html__( 'Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for the post listing. Leave blank to disable this section', 'foxiz' ),
					'type'     => 'text',
					'default'  => 'Latest {category} News',
				),
				array(
					'id'       => $prefix . 'blog_heading_layout',
					'title'    => esc_html__( 'Heading Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a heading layout for the heading.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_layout( true ),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'blog_heading_tag',
					'title'    => esc_html__( 'Heading HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a HTML tag for this heading. Leave this option blank to set the default.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0',
				),
				array(
					'id'          => $prefix . 'blog_heading_size',
					'title'       => esc_html__( 'Heading Font Size (Desktop)', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a custom font size value for the category heading (px) on the desktop.', 'foxiz' ),
					'description' => esc_html__( 'Navigate to "Heading Design" panel to edit font size for table and mobile device.', 'foxiz' ),
					'type'        => 'text',
					'validate'    => 'numeric',
					'default'     => '',
				),
				array(
					'id'     => 'section_end_category_blog_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_category_blog_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Latest Posts - Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the category pages.', 'foxiz' ),
					'type'     => 'image_select',
					'options'  => foxiz_config_blog_layout(),
					'default'  => 'grid_1'
				),
				array(
					'id'       => $prefix . 'columns',
					'title'    => esc_html__( 'Columns on Desktop', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_tablet',
					'title'    => esc_html__( 'Columns on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_mobile',
					'title'    => esc_html__( 'Columns on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns( array( '0', '1', '2' ) ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'column_gap',
					'title'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a spacing between columns.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_column_gap(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_category_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_category_blog_sidebar',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Latest Posts - Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the latest blog section', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'none'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the latest blog section if it is enabled.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the category pages.', 'foxiz' ),
					'options'  => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_category_blog_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_category_design',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Design', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'crop_size',
					'title'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a featured image size to optimize with the columns setting.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_crop_size(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'display_ratio',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Featured Ratio', 'foxiz' ),
					'subtitle' => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'          => $prefix . 'entry_category',
					'title'       => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'description' => esc_html__( 'The setting will not apply if the selected blog layout does not support the selected entry category.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_extended_entry_category( true ),
					'default'     => '0'
				),
				array(
					'id'       => $prefix . 'hide_category',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the entry category on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_tag',
					'title'    => esc_html__( 'Title HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a title HTML tag for the post title.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_size',
					'title'    => esc_html__( 'Desktop - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the desktop device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_tablet',
					'title'    => esc_html__( 'Tablet - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the table devices. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_mobile',
					'title'    => esc_html__( 'Mobile - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the mobile device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'entry_meta_bar',
					'type'     => 'select',
					'title'    => esc_html__( 'Entry Meta Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select settings for the entry meta bar.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_bar(),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'entry_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'required' => array( $prefix . 'entry_meta_bar', '=', 'custom' ),
					'subtitle' => esc_html__( 'Organize how you want the entry meta to appear. Leave blank to set it as the default.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array(),
				),
				array(
					'id'       => $prefix . 'review',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for entry review meta.', 'foxiz' ),
					'options'  => foxiz_config_entry_review( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'review_meta',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the meta description at the end of the review bar.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'tablet_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'          => $prefix . 'mobile_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'bookmark',
					'type'     => 'select',
					'title'    => esc_html__( 'Bookmark Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bookmark icon.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select settings for the post excerpt.', 'foxiz' ),
					'options'  => foxiz_config_excerpt_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt_length',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Excerpt - Max Length', 'foxiz' ),
					'required' => array( $prefix . 'excerpt', '=', '1' ),
					'subtitle' => esc_html__( 'select max length of the post excerpt.', 'foxiz' ),
					'desc'     => esc_html__( 'Leave this option blank or set 0 to disable.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'excerpt_source',
					'title'       => esc_html__( 'Excerpt - Source', 'foxiz' ),
					'subtitle'    => esc_html__( 'Where to get the post excerpt.', 'foxiz' ),
					'description' => esc_html__( 'When you select "use title tagline". if it is empty, it will fallback to the post excerpt or content.', 'foxiz' ),
					'required'    => array( $prefix . 'excerpt', '=', '1' ),
					'type'        => 'select',
					'options'     => foxiz_config_excerpt_source(),
					'default'     => 'tagline'
				),
				array(
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_category_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_category_blog_pagination',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Latest Posts - Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'pagination',
					'title'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select pagination type for the category pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_pagination(),
					'default'  => 'number'
				),
				array(
					'id'     => 'section_end_category_blog_pagination',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_blog_pages' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_blog_pages() {

		return array(
			'title' => esc_html__( 'Blog & Archive', 'foxiz' ),
			'id'    => 'foxiz_config_section_blog_archives',
			'icon'  => 'el el-hdd',
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_blog' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_blog() {

		$prefix = 'blog_';

		return array(
			'id'         => 'foxiz_config_section_blog',
			'title'      => esc_html__( 'Blog Index', 'foxiz' ),
			'icon'       => 'el el-bold',
			'desc'       => esc_html__( 'The settings below apply the blog page.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_blog_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Site Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'header_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Header Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a website header style for the blog page.', 'foxiz' ),
					'options'  => foxiz_config_header_style( true, true ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'nav_style',
					'type'        => 'select',
					'title'       => esc_html__( 'Navigation Bar Style', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select navigation bar style for the site header in the blog index page.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on the setting in the header panel. It will not apply to the header style 4.', 'foxiz' ),
					'options'     => array(
						'0'        => esc_html__( 'Default', 'foxiz' ),
						'shadow'   => esc_html__( 'Shadow', 'foxiz' ),
						'border'   => esc_html__( 'Bottom Border', 'foxiz' ),
						'd-border' => esc_html__( 'Dark Bottom Border', 'foxiz' ),
						'none'     => esc_html__( 'None', 'foxiz' )
					),
					'default'     => '0'
				),
				array(
					'id'          => $prefix . 'header_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Header Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header for the blog page.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on the "Header Style" setting, Leave it blank if you would like to use the "Header Style" setting.', 'foxiz' ),
					'placeholder' => esc_html__( '[Ruby_E_Template id="1"]', 'foxiz' ),
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_blog_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_blog_template_global',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global Blog Query - Template Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is the main query.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template_global',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Global WP Query Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to show it as a the main blog listing.', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'description' => esc_html__( 'Leave this option blank if you want to use standard blog layout settings.', 'foxiz' ),
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_global_builder',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_blog_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Posts Per Page', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'posts_per_page',
					'title'       => esc_html__( 'Posts per Page', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select posts per page for the blog. Leave this option blank to set the default.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on "Dashboard > Settings > Reading > Blog pages show at most" setting. It also apply to the "Global WP Query Template Shortcode".', 'foxiz' ),
					'type'        => 'text',
					'class'       => 'small-text',
					'validate'    => 'numeric',
					'default'     => ''
				),
				array(
					'id'     => 'section_end_blog_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_blog_builder',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Top & Bottom Area Template Builder', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Top Area Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to embed it the top of the blog page, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'          => $prefix . 'template_bottom',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Bottom Area Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to embed it the bottom of the blog page, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'template_display',
					'title'    => esc_html__( 'Template Display', 'foxiz' ),
					'subtitle' => esc_html__( 'Show template in the first or all pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Show in the first page', 'foxiz' ),
						'2' => esc_html__( 'Show in all pages', 'foxiz' )
					),
					'default'  => '1',
				),
				array(
					'id'     => 'section_end_blog_builder',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),

				array(
					'id'       => 'section_start_blog_blog_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the blog.', 'foxiz' ),
					'type'     => 'image_select',
					'options'  => foxiz_config_blog_layout(),
					'default'  => 'classic_1'
				),
				array(
					'id'       => $prefix . 'columns',
					'title'    => esc_html__( 'Columns on Desktop', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_tablet',
					'title'    => esc_html__( 'Columns on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_mobile',
					'title'    => esc_html__( 'Columns on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns( array( '0', '1', '2' ) ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'column_gap',
					'title'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a spacing between columns.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_column_gap(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_blog_blog_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_blog_sidebar',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the latest blog section', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the latest blog section if it is enabled.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the blog page.', 'foxiz' ),
					'options'  => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_blog_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_blog_design',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Design', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'crop_size',
					'title'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a featured image size to optimize with the columns setting.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_crop_size(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'display_ratio',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Featured Ratio', 'foxiz' ),
					'subtitle' => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'          => $prefix . 'entry_category',
					'title'       => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'description' => esc_html__( 'The setting will not apply if the selected blog layout does not support the selected entry category.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_extended_entry_category( true ),
					'default'     => '0'
				),
				array(
					'id'       => $prefix . 'hide_category',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the entry category on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_tag',
					'title'    => esc_html__( 'Title HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a title HTML tag for the post title.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_size',
					'title'    => esc_html__( 'Desktop - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the desktop device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_tablet',
					'title'    => esc_html__( 'Tablet - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the table devices. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_mobile',
					'title'    => esc_html__( 'Mobile - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the mobile device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'entry_meta_bar',
					'type'     => 'select',
					'title'    => esc_html__( 'Entry Meta Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select settings for the entry meta bar.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_bar(),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'entry_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'required' => array( $prefix . 'entry_meta_bar', '=', 'custom' ),
					'subtitle' => esc_html__( 'Organize how you want the entry meta to appear. Leave blank to set it as the default.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array(),
				),
				array(
					'id'       => $prefix . 'review',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for entry review meta.', 'foxiz' ),
					'options'  => foxiz_config_entry_review( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'review_meta',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the meta description at the end of the review bar.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'tablet_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'          => $prefix . 'mobile_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'bookmark',
					'type'     => 'select',
					'title'    => esc_html__( 'Bookmark Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bookmark icon.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select settings for the post excerpt.', 'foxiz' ),
					'options'  => foxiz_config_excerpt_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt_length',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Excerpt - Max Length', 'foxiz' ),
					'required' => array( $prefix . 'excerpt', '=', '1' ),
					'subtitle' => esc_html__( 'select max length of the post excerpt.', 'foxiz' ),
					'desc'     => esc_html__( 'Leave this option blank or set 0 to disable.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'excerpt_source',
					'title'       => esc_html__( 'Excerpt - Source', 'foxiz' ),
					'subtitle'    => esc_html__( 'Where to get the post excerpt.', 'foxiz' ),
					'description' => esc_html__( 'When you select "use title tagline". if it is empty, it will fallback to the post excerpt or content.', 'foxiz' ),
					'required'    => array( $prefix . 'excerpt', '=', '1' ),
					'type'        => 'select',
					'options'     => foxiz_config_excerpt_source(),
					'default'     => 'tagline'
				),
				array(
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_blog_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_blog_pagination',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'pagination',
					'title'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select pagination type for the blog.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_pagination(),
					'default'  => 'number'
				),
				array(
					'id'     => 'section_end_blog_pagination',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),

			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_author' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_author() {

		$prefix = 'author_';

		return array(
			'id'         => 'foxiz_config_section_author',
			'title'      => esc_html__( 'Author', 'foxiz' ),
			'icon'       => 'el el-user',
			'subsection' => true,
			'desc'       => esc_html__( 'The settings below apply to the author pages.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'     => 'section_start_author_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Author Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'bio',
					'title'    => esc_html__( 'Author Bio', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the author bio in the author pages.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'       => $prefix . 'pattern',
					'title'    => esc_html__( 'Header Background Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background style for the author header.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_archive_header_bg(),
					'default'  => 'dot'
				),
				array(
					'id'     => 'section_end_author_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),

				array(
					'id'       => 'section_start_author_template_global',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global Blog Query - Template Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is the main query.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template_global',
					'title'       => esc_html__( 'Global WP Query Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to display as the main blog posts, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'type'        => 'textarea',
					'rows'        => '2',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'default'     => '',
				),
				array(
					'id'     => 'section_end_author_template_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_author_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Posts per Page', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'posts_per_page',
					'title'       => esc_html__( 'Posts per Page', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select posts per page for the authors. Leave this option blank to set the default.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on "Dashboard > Settings > Reading > Blog pages show at most" setting. It also apply to the "Global WP Query Template Shortcode".', 'foxiz' ),
					'type'        => 'text',
					'validate'    => 'numeric',
					'default'     => ''
				),
				array(
					'id'     => 'section_end_author_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_author_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the author pages.', 'foxiz' ),
					'type'     => 'image_select',
					'options'  => foxiz_config_blog_layout(),
					'default'  => 'grid_1'
				),
				array(
					'id'       => $prefix . 'columns',
					'title'    => esc_html__( 'Columns per Row', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_tablet',
					'title'    => esc_html__( 'Columns on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_mobile',
					'title'    => esc_html__( 'Columns on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns( array( '0', '1', '2' ) ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'column_gap',
					'title'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a spacing between columns.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_column_gap(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_author_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_author_sidebar',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the latest blog section', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'none'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the latest blog section if it is enabled.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the author pages.', 'foxiz' ),
					'options'  => array(
						'0'  => esc_html__( 'Use Global Setting', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_author_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_author_design',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Design', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'crop_size',
					'title'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a featured image size to optimize with the columns setting.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_crop_size(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'display_ratio',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Featured Ratio', 'foxiz' ),
					'subtitle' => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'          => $prefix . 'entry_category',
					'title'       => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'description' => esc_html__( 'The setting will not apply if the selected blog layout does not support the selected entry category.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_extended_entry_category( true ),
					'default'     => '0'
				),
				array(
					'id'       => $prefix . 'hide_category',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the entry category on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_tag',
					'title'    => esc_html__( 'Title HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a title HTML tag for the post title.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_size',
					'title'    => esc_html__( 'Desktop - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the desktop device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_tablet',
					'title'    => esc_html__( 'Tablet - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the table devices. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_mobile',
					'title'    => esc_html__( 'Mobile - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the mobile device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'entry_meta_bar',
					'type'     => 'select',
					'title'    => esc_html__( 'Entry Meta Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select settings for the entry meta bar.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_bar(),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'entry_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'required' => array( $prefix . 'entry_meta_bar', '=', 'custom' ),
					'subtitle' => esc_html__( 'Organize how you want the entry meta to appear. Leave blank to set it as the default.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array(),
				),
				array(
					'id'       => $prefix . 'review',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for entry review meta.', 'foxiz' ),
					'options'  => foxiz_config_entry_review( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'review_meta',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the meta description at the end of the review bar.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'tablet_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'          => $prefix . 'mobile_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'bookmark',
					'type'     => 'select',
					'title'    => esc_html__( 'Bookmark Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bookmark icon.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select settings for the post excerpt.', 'foxiz' ),
					'options'  => foxiz_config_excerpt_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt_length',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Excerpt - Max Length', 'foxiz' ),
					'required' => array( $prefix . 'excerpt', '=', '1' ),
					'subtitle' => esc_html__( 'select max length of the post excerpt.', 'foxiz' ),
					'desc'     => esc_html__( 'Leave this option blank or set 0 to disable.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'excerpt_source',
					'title'       => esc_html__( 'Excerpt - Source', 'foxiz' ),
					'subtitle'    => esc_html__( 'Where to get the post excerpt.', 'foxiz' ),
					'description' => esc_html__( 'When you select "use title tagline". if it is empty, it will fallback to the post excerpt or content.', 'foxiz' ),
					'required'    => array( $prefix . 'excerpt', '=', '1' ),
					'type'        => 'select',
					'options'     => foxiz_config_excerpt_source(),
					'default'     => 'tagline'
				),
				array(
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_author_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_author_pagination',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'pagination',
					'title'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select pagination type for the author pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'number' => esc_html__( 'Numeric', 'foxiz' ),
						'simple' => esc_html__( 'Simple', 'foxiz' ),
					),
					'default'  => 'number'
				),
				array(
					'id'     => 'section_end_author_pagination',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_archive' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_archive() {

		$prefix = 'archive_';

		return array(
			'id'         => 'foxiz_config_section_archive',
			'title'      => esc_html__( 'Tags & Archives', 'foxiz' ),
			'icon'       => 'el el-inbox-box',
			'subsection' => true,
			'desc'       => esc_html__( 'The settings below apply to the tags and other archive pages.', 'foxiz' ),
			'fields'     => array(
				array(
					'id'     => 'section_start_archive_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Archive Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'pattern',
					'title'    => esc_html__( 'Header Background Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background style for the archive header.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_archive_header_bg(),
					'default'  => 'dot'
				),

				array(
					'id'     => 'section_end_archive_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_archive_template_global',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global Blog Query - Template Builder', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is the main query.', 'foxiz' ),
						esc_html__( 'The ajax types in the builder pagination setting of the global query block are only available for the tags page. The numeric pagination will be a fallback option for other archive pages.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template_global',
					'title'       => esc_html__( 'Global WP Query Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to display as the main blog posts, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'type'        => 'textarea',
					'rows'        => '2',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'default'     => '',
				),
				array(
					'id'     => 'section_end_archive_template_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_archive_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Posts per Page', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'posts_per_page',
					'title'    => esc_html__( 'Posts per Page', 'foxiz' ),
					'subtitle' => esc_html__( 'Select posts per page for the archives. Leave this option blank to set the default.', 'foxiz' ),
					'type'     => 'text',
					'validate' => 'numeric',
					'default'  => ''
				),
				array(
					'id'     => 'section_end_archive_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_archive_blog_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the archive pages.', 'foxiz' ),
					'type'     => 'image_select',
					'options'  => foxiz_config_blog_layout(),
					'default'  => 'grid_1'
				),
				array(
					'id'       => $prefix . 'columns',
					'title'    => esc_html__( 'Columns on Desktop', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_tablet',
					'title'    => esc_html__( 'Columns on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_mobile',
					'title'    => esc_html__( 'Columns on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns( array( '0', '1', '2' ) ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'column_gap',
					'title'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a spacing between columns.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_column_gap(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_archive_blog_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_archive_sidebar',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the latest blog section', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'none'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the latest blog section if it is enabled.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the archive pages.', 'foxiz' ),
					'options'  => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_archive_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_archive_design',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Design', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'crop_size',
					'title'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a featured image size to optimize with the columns setting.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_crop_size(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'display_ratio',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Featured Ratio', 'foxiz' ),
					'subtitle' => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'          => $prefix . 'entry_category',
					'title'       => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'description' => esc_html__( 'The setting will not apply if the selected blog layout does not support the selected entry category.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_extended_entry_category( true ),
					'default'     => '0'
				),
				array(
					'id'       => $prefix . 'hide_category',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the entry category on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_tag',
					'title'    => esc_html__( 'Title HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a title HTML tag for the post title.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_size',
					'title'    => esc_html__( 'Desktop - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the desktop device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_tablet',
					'title'    => esc_html__( 'Tablet - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the table devices. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_mobile',
					'title'    => esc_html__( 'Mobile - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the mobile device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'entry_meta_bar',
					'type'     => 'select',
					'title'    => esc_html__( 'Entry Meta Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select settings for the entry meta bar.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_bar(),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'entry_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'required' => array( $prefix . 'entry_meta_bar', '=', 'custom' ),
					'subtitle' => esc_html__( 'Organize how you want the entry meta to appear. Leave blank to set it as the default.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array(),
				),
				array(
					'id'       => $prefix . 'review',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for entry review meta.', 'foxiz' ),
					'options'  => foxiz_config_entry_review( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'review_meta',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the meta description at the end of the review bar.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'tablet_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'          => $prefix . 'mobile_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'bookmark',
					'type'     => 'select',
					'title'    => esc_html__( 'Bookmark Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bookmark icon.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select settings for the post excerpt.', 'foxiz' ),
					'options'  => foxiz_config_excerpt_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt_length',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Excerpt - Max Length', 'foxiz' ),
					'required' => array( $prefix . 'excerpt', '=', '1' ),
					'subtitle' => esc_html__( 'select max length of the post excerpt.', 'foxiz' ),
					'desc'     => esc_html__( 'Leave this option blank or set 0 to disable.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'excerpt_source',
					'title'       => esc_html__( 'Excerpt - Source', 'foxiz' ),
					'subtitle'    => esc_html__( 'Where to get the post excerpt.', 'foxiz' ),
					'description' => esc_html__( 'When you select "use title tagline". if it is empty, it will fallback to the post excerpt or content.', 'foxiz' ),
					'required'    => array( $prefix . 'excerpt', '=', '1' ),
					'type'        => 'select',
					'options'     => foxiz_config_excerpt_source(),
					'default'     => 'tagline'
				),
				array(
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_archive_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_archive_pagination',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'pagination',
					'title'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select pagination type for the archive pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'number' => esc_html__( 'Numeric', 'foxiz' ),
						'simple' => esc_html__( 'Simple', 'foxiz' ),
					),
					'default'  => 'number'
				),
				array(
					'id'     => 'section_end_archive_pagination',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_search' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_search() {

		$prefix = 'search_';

		return array(
			'id'         => 'foxiz_config_section_search',
			'title'      => esc_html__( 'Search', 'foxiz' ),
			'icon'       => 'el el-search',
			'desc'       => esc_html__( 'The settings below apply to the search page.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_search_filter',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Search Filter', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'only_post',
					'title'    => esc_html__( 'Only Search Posts', 'foxiz' ),
					'subtitle' => esc_html__( 'Only display posts in the search results.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => true
				),
				array(
					'id'     => 'section_end_search_filter',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_search_site_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Site Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'header_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Header Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a website header style for the search page.', 'foxiz' ),
					'options'  => foxiz_config_header_style( true, true ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'nav_style',
					'type'        => 'select',
					'title'       => esc_html__( 'Navigation Bar Style', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select navigation bar style for the site header in the search page.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on the setting in the header panel. It will not apply to the header style 4.', 'foxiz' ),
					'options'     => array(
						'0'        => esc_html__( 'Default', 'foxiz' ),
						'shadow'   => esc_html__( 'Shadow', 'foxiz' ),
						'border'   => esc_html__( 'Bottom Border', 'foxiz' ),
						'd-border' => esc_html__( 'Dark Bottom Border', 'foxiz' ),
						'none'     => esc_html__( 'None', 'foxiz' )
					),
					'default'     => '0'
				),
				array(
					'id'          => $prefix . 'header_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Header Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header for the search page.', 'foxiz' ),
					'description' => esc_html__( 'This setting will override on the "Header Style" setting, Leave it blank if you would like to use the "Header Style" setting.', 'foxiz' ),
					'placeholder' => esc_html__( '[Ruby_E_Template id="1"]', 'foxiz' ),
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_search_site_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_search_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Search Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'header_background',
					'type'        => 'background',
					'transparent' => false,
					'title'       => esc_html__( 'Header Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Upload a background image for the search header.', 'foxiz' ),
					'default'     => array(
						'background-color'      => '',
						'background-size'       => 'cover',
						'background-attachment' => 'scroll',
						'background-position'   => 'center center',
						'background-repeat'     => 'no-repeat'
					)
				),
				array(
					'id'          => 'dark_' . $prefix . 'header_background',
					'type'        => 'background',
					'transparent' => false,
					'title'       => esc_html__( 'Dark Mode - Header Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Upload a background image for the search header in the dark mode.', 'foxiz' ),
					'default'     => array(
						'background-color'      => '',
						'background-size'       => 'cover',
						'background-attachment' => 'scroll',
						'background-position'   => 'center center',
						'background-repeat'     => 'no-repeat'
					)
				),
				array(
					'id'     => 'section_end_search_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_search_template_global',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Global Blog Query - Template Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is the main query.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template_global',
					'title'       => esc_html__( 'Global WP Query Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to display as the main blog posts, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'type'        => 'textarea',
					'rows'        => '2',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'default'     => '',
				),
				array(
					'id'     => 'section_end_search_template_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_search_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Posts per Page', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'posts_per_page',
					'title'    => esc_html__( 'Posts per Page', 'foxiz' ),
					'subtitle' => esc_html__( 'Select posts per page for the search result listing. Leave this option blank to set the default.', 'foxiz' ),
					'type'     => 'text',
					'validate' => 'numeric',
					'default'  => ''
				),
				array(
					'id'     => 'section_end_search_posts_per_page',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_search_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the search result listing.', 'foxiz' ),
					'type'     => 'image_select',
					'options'  => foxiz_config_blog_layout(),
					'default'  => 'grid_small_1'
				),
				array(
					'id'       => $prefix . 'columns',
					'title'    => esc_html__( 'Columns on Desktop', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_tablet',
					'title'    => esc_html__( 'Columns on Tablet', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the tablet device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'columns_mobile',
					'title'    => esc_html__( 'Columns on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total columns to show per row on the mobile device.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_columns( array( '0', '1', '2' ) ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'column_gap',
					'title'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a spacing between columns.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_column_gap(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_search_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_search_sidebar',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the search result listing.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'none'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the latest blog section if it is enabled.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the search pages.', 'foxiz' ),
					'options'  => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_search_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_search_design',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Design', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' )
					),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'crop_size',
					'title'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a featured image size to optimize with the columns setting.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_crop_size(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'display_ratio',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Featured Ratio', 'foxiz' ),
					'subtitle' => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'          => $prefix . 'entry_category',
					'title'       => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'description' => esc_html__( 'The setting will not apply if the selected blog layout does not support the selected entry category.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_extended_entry_category( true ),
					'default'     => '0'
				),
				array(
					'id'       => $prefix . 'hide_category',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the entry category on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_tag',
					'title'    => esc_html__( 'Title HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a title HTML tag for the post title.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'title_size',
					'title'    => esc_html__( 'Desktop - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the desktop device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_tablet',
					'title'    => esc_html__( 'Tablet - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the table devices. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'title_size_mobile',
					'title'    => esc_html__( 'Mobile - Title Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the post title in the mobile device. Leave blank to set it as the default.', 'foxiz' ),
					'type'     => 'text',
					'default'  => ''
				),
				array(
					'id'       => $prefix . 'entry_meta_bar',
					'type'     => 'select',
					'title'    => esc_html__( 'Entry Meta Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select settings for the entry meta bar.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_bar(),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'entry_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'required' => array( $prefix . 'entry_meta_bar', '=', 'custom' ),
					'subtitle' => esc_html__( 'Organize how you want the entry meta to appear. Leave blank to set it as the default.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array(),
				),
				array(
					'id'       => $prefix . 'review',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for entry review meta.', 'foxiz' ),
					'options'  => foxiz_config_entry_review( true ),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'review_meta',
					'type'     => 'select',
					'title'    => esc_html__( 'Review Meta Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the meta description at the end of the review bar.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'tablet_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'          => $prefix . 'mobile_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'bookmark',
					'type'     => 'select',
					'title'    => esc_html__( 'Bookmark Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bookmark icon.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
				),

				array(
					'id'       => $prefix . 'excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select settings for the post excerpt.', 'foxiz' ),
					'options'  => foxiz_config_excerpt_dropdown(),
					'default'  => '0'
				),
				array(
					'id'       => $prefix . 'excerpt_length',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Excerpt - Max Length', 'foxiz' ),
					'required' => array( $prefix . 'excerpt', '=', '1' ),
					'subtitle' => esc_html__( 'select max length of the post excerpt.', 'foxiz' ),
					'desc'     => esc_html__( 'Leave this option blank or set 0 to disable.', 'foxiz' ),
					'default'  => '0'
				),
				array(
					'id'          => $prefix . 'excerpt_source',
					'title'       => esc_html__( 'Excerpt - Source', 'foxiz' ),
					'subtitle'    => esc_html__( 'Where to get the post excerpt.', 'foxiz' ),
					'description' => esc_html__( 'When you select "use title tagline". if it is empty, it will fallback to the post excerpt or content.', 'foxiz' ),
					'required'    => array( $prefix . 'excerpt', '=', '1' ),
					'type'        => 'select',
					'options'     => foxiz_config_excerpt_source(),
					'default'     => 'tagline'
				),
				array(
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_search_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_search_pagination',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the search pages.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'pagination',
					'title'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select pagination type for the search result listing.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_pagination(),
					'default'  => 'number'
				),
				array(
					'id'     => 'section_end_search_pagination',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_page_404' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_page_404() {

		$prefix = 'page_404_';

		return array(
			'id'     => 'foxiz_config_section_page_404',
			'title'  => esc_html__( '404 Page', 'foxiz' ),
			'icon'   => 'el el-info-circle',
			'desc'   => esc_html__( 'The settings below apply to the 404 page.', 'foxiz' ),
			'fields' => array(
				array(
					'id'    => $prefix . 'featured_info',
					'type'  => 'info',
					'title' => esc_html__( 'The image will be limited at 300px of height. Recommend for image height is about 600px for the retina screen.', 'foxiz' ),
					'style' => 'info'
				),
				array(
					'id'       => $prefix . 'featured',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Header Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a header image for the 404 page.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'dark_featured',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Header Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a header image for the 404 page in the dark mode.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for the 404 page. Leave this option blank to set it as the default.', 'foxiz' ),
					'default'  => '',
				),
				array(
					'id'       => $prefix . 'description',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your description for the 404 page. Leave this option blank to set it as the default.', 'foxiz' ),
					'default'  => '',
				),
				array(
					'id'       => $prefix . 'search',
					'type'     => 'switch',
					'title'    => esc_html__( 'Search Form', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the search form.', 'foxiz' ),
					'default'  => 1,
				),
			)
		);
	}
}