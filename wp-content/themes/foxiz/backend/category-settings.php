<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_category_settings' ) ) {
	/**
	 * @return false
	 */
	function foxiz_register_category_settings() {

		if ( ! class_exists( 'RW_Custom_Taxonomy_Meta' ) ) {
			return false;
		}

		$configs = array(
			'title'      => esc_html__( 'Foxiz - Individual Category Settings', 'foxiz' ),
			'info'       => esc_html__( 'The settings below will override on the default settings in "Theme Options > Category".', 'foxiz' ),
			'taxonomies' => array( 'category' ),
			'id'         => 'foxiz_category_meta',
			'fields'     => array(
				array(
					'id'   => 'category_color_info',
					'name' => esc_html__( 'Entry Category Colors', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'   => 'highlight_color',
					'name' => esc_html__( 'Highlight Color', 'foxiz' ),
					'desc' => esc_html__( 'Select a highlight color for the entry category to display in the post listing.', 'foxiz' ),
					'type' => 'color',
					'std'  => '',
				),
				array(
					'id'   => 'color',
					'name' => esc_html__( 'Accent Color', 'foxiz' ),
					'desc' => esc_html__( 'Select an accent (text) color for the entry category to display in the post listing. Leave blank to set it as the default.', 'foxiz' ),
					'type' => 'color',
					'std'  => '',
				),
				array(
					'id'   => 'dark_highlight_color',
					'name' => esc_html__( 'Dark - Highlight Color', 'foxiz' ),
					'desc' => esc_html__( 'Select a highlight color for the entry category to display in the post listing in the dark mode.', 'foxiz' ),
					'type' => 'color',
					'std'  => '',
				),
				array(
					'id'   => 'dark_color',
					'name' => esc_html__( 'Dark Mode - Accent Color', 'foxiz' ),
					'desc' => esc_html__( 'Select an accent (text) color for the entry category to display in the post listing in the dark mode.', 'foxiz' ),
					'type' => 'color',
					'std'  => '',
				),
				array(
					'id'   => 'header_info',
					'name' => esc_html__( 'Site Header', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'      => 'header_style',
					'name'    => esc_html__( 'Header Style', 'foxiz' ),
					'desc'    => esc_html__( 'Select a header style for this category.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_header_style( true, true ),
					'std'     => '0'
				),
				array(
					'id'          => 'header_template',
					'name'        => esc_html__( 'Header Template Shortcode', 'foxiz' ),
					'desc'        => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header for this category. Leave blank to use the above setting.', 'foxiz' ),
					'type'        => 'textarea',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => '2',
					'std'         => ''
				),
				array(
					'id'   => 'category_header_info',
					'name' => esc_html__( 'Category Header', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'      => 'category_header',
					'name'    => esc_html__( 'Category Header', 'foxiz' ),
					'desc'    => esc_html__( 'Disable or select a category header style for this category page.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_category_header( true ),
					'std'     => '0'
				),
				array(
					'id'   => 'featured_image',
					'name' => esc_html__( 'Featured Images', 'foxiz' ),
					'desc' => esc_html__( 'Upload featured images (maximum: 2 images) for this category.', 'foxiz' ),
					'type' => 'image'
				),
				array(
					'id'      => 'pattern',
					'name'    => esc_html__( 'Header Background Style', 'foxiz' ),
					'desc'    => esc_html__( 'Select a background style for this category header.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_archive_header_bg( true ),
					'std'     => '0'
				),
				array(
					'id'      => 'breadcrumb',
					'name'    => esc_html__( 'Breadcrumb', 'foxiz' ),
					'desc'    => esc_html__( 'Enable or disable the breadcrumb in this category header.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Use Global Setting', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' )
					),
					'std'     => '0'
				),
				array(
					'id'      => 'subcategory',
					'name'    => esc_html__( 'Sub Categories List', 'foxiz' ),
					'desc'    => esc_html__( 'Enable or disable the sub category list in this category header.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' )
					),
					'std'     => '0'
				),
				array(
					'id'   => 'builder_info',
					'name' => esc_html__( 'Top Template Builder', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'          => 'template',
					'name'        => esc_html__( 'Top Area Template Shortcode', 'foxiz' ),
					'desc'        => esc_html__( 'Input a "Ruby Template" shortcode to embed it after this category header, e.g: [Ruby_E_Template id="1"]', 'foxiz' ),
					'type'        => 'textarea',
					'rows'        => '2',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'std'         => ''
				),
				array(
					'id'      => 'template_display',
					'name'    => esc_html__( 'Template Display', 'foxiz' ),
					'desc'    => esc_html__( 'Show template in the first or all pages.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0' => esc_html__( '- Default -', 'foxiz' ),
						'1' => esc_html__( 'Show in the first page', 'foxiz' ),
						'2' => esc_html__( 'Show in all pages', 'foxiz' )
					),
					'std'     => '0'
				),
				array(
					'id'   => 'template_global_info',
					'name' => esc_html__( 'Global Blog Query - Template Builder', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'          => 'template_global',
					'name'        => esc_html__( 'Global WP Query Template Shortcode', 'foxiz' ),
					'desc'        => esc_html__( 'Input a "Ruby Template" shortcode to show it as a the main blog listing for this category.', 'foxiz' ),
					'type'        => 'textarea',
					'rows'        => '2',
					'placeholder' => '[Ruby_E_Template id="1"]',
					'std'         => ''
				),
				array(
					'id'   => 'posts_per_page_info',
					'name' => esc_html__( 'Posts Per Page', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'      => 'posts_per_page',
					'name'    => esc_html__( 'Posts per Page', 'foxiz' ),
					'desc'    => esc_html__( 'Select posts per page for this category. Leave this option blank to set the default.', 'foxiz' ),
					'type'    => 'text',
					'classes' => 'small',
					'std'     => '',
				),
				array(
					'id'   => 'blog_info',
					'name' => esc_html__( 'Latest Posts - Heading', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'   => 'blog_heading',
					'name' => esc_html__( 'Heading', 'foxiz' ),
					'desc' => esc_html__( 'Input a heading for the post listing. Leave this option blank to set the default.', 'foxiz' ),
					'type' => 'text',
					'std'  => '',
				),
				array(
					'id'      => 'blog_heading_layout',
					'name'    => esc_html__( 'Heading Layout', 'foxiz' ),
					'desc'    => esc_html__( 'Select a heading layout for the heading.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_heading_layout( true ),
					'std'     => '',
				),
				array(
					'id'      => 'blog_heading_tag',
					'name'    => esc_html__( 'Heading HTML Tag', 'foxiz' ),
					'desc'    => esc_html__( 'Select a HTML tag for this heading. Leave this option blank to set the default.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_heading_tag(),
					'std'     => '',
				),
				array(
					'id'      => 'blog_heading_size',
					'name'    => esc_html__( 'Heading Font Size (Desktop)', 'foxiz' ),
					'desc'    => esc_html__( 'Input a custom font size value for this heading (px) on the desktop. Leave this option blank to set the default value.', 'foxiz' ),
					'type'    => 'text',
					'classes' => 'small',
					'std'     => '',
				),
				array(
					'id'   => 'pagination_info',
					'name' => esc_html__( 'Latest Posts - Pagination', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'   => 'tag_not_in',
					'name' => esc_html__( 'Exclude Tags Slug', 'foxiz' ),
					'desc' => esc_html__( 'Exclude tag slugs for the latest blog. Separated by commas (for example: tagslug1,tagslug2,tagslug3).', 'foxiz' ),
					'type' => 'text',
					'std'  => '',
				),
				array(
					'id'      => 'pagination',
					'name'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'desc'    => esc_html__( 'Select pagination type for this category.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_blog_pagination( true ),
					'std'     => '0'
				),
				array(
					'id'   => 'column_info',
					'name' => esc_html__( 'Latest Posts - Layout', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'      => 'layout',
					'name'    => esc_html__( 'Blog Listing Layout', 'foxiz' ),
					'desc'    => esc_html__( 'Select blog listing layout for this category.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'            => esc_html__( '- Default -', 'foxiz' ),
						'classic_1'    => esc_html__( 'Classic (Standard)', 'foxiz' ),
						'grid_1'       => esc_html__( 'Grid 1 (Standard)', 'foxiz' ),
						'grid_2'       => esc_html__( 'Grid 2', 'foxiz' ),
						'grid_box_1'   => esc_html__( 'Boxed Grid 1', 'foxiz' ),
						'grid_box_2'   => esc_html__( 'Boxed Grid 2', 'foxiz' ),
						'grid_small_1' => esc_html__( 'Small Grid', 'foxiz' ),
						'list_1'       => esc_html__( 'List 1', 'foxiz' ),
						'list_2'       => esc_html__( 'List 2', 'foxiz' ),
						'list_box_1'   => esc_html__( 'Boxed List 1', 'foxiz' ),
						'list_box_2'   => esc_html__( 'Boxed List 2', 'foxiz' ),
					),
					'std'     => '0'
				),
				array(
					'id'      => 'columns',
					'name'    => esc_html__( 'Columns on Desktop', 'foxiz' ),
					'desc'    => esc_html__( 'Select total columns to show per row for the blog listing layout on the desktop device.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_blog_columns(),
					'std'     => '0'
				),
				array(
					'id'      => 'columns_tablet',
					'name'    => esc_html__( 'Columns on Tablet', 'foxiz' ),
					'desc'    => esc_html__( 'Select total columns to show per row for the blog listing layout on the tablet device.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_blog_columns(),
					'std'     => '0'
				),
				array(
					'id'      => 'columns_mobile',
					'name'    => esc_html__( 'Columns on Mobile', 'foxiz' ),
					'desc'    => esc_html__( 'Select total columns to show per row for the blog listing layout on the mobile device.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_blog_columns( array( '0', '1', '2' ) ),
					'std'     => '0'
				),
				array(
					'id'      => 'column_gap',
					'name'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'desc'    => esc_html__( 'Select a spacing between columns for the blog listing layout.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_blog_column_gap(),
					'std'     => '0'
				),
				array(
					'id'   => 'sidebar_info',
					'name' => esc_html__( 'Latest Posts - Sidebar', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'      => 'sidebar_position',
					'name'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'desc'    => esc_html__( 'Select a sidebar position or disable it for the latest blog section.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_category_sidebar_position(),
					'std'     => '0'
				),
				array(
					'id'      => 'sidebar_name',
					'name'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'desc'    => esc_html__( 'Assign a widget section for the sidebar for the latest blog section if it is enabled.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_sidebar_name(),
					'std'     => '0'
				),
				array(
					'id'      => 'sticky_sidebar',
					'name'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'desc'    => esc_html__( 'Making this sidebar permanently visible when scrolling up and down.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' )
					),
					'std'     => '0'
				),
				array(
					'id'   => 'design_info',
					'name' => esc_html__( 'Blog Design', 'foxiz' ),
					'type' => 'info'
				),
				array(
					'id'   => 'design_featured_image',
					'name' => esc_html__( 'Featured Image', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'crop_size',
					'name'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'desc'    => esc_html__( 'Select a crop size for the featured image to displaying in this category.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_crop_size(),
					'std'     => '0'
				),
				array(
					'id'          => 'display_ratio',
					'name'        => esc_html__( 'Custom Featured Ratio', 'foxiz' ),
					'desc'        => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz' ),
					'type'        => 'text',
					'placeholder' => '50',
					'classes'     => 'small',
					'std'         => ''
				),
				array(
					'id'   => 'design_entry_meta',
					'name' => esc_html__( 'Entry Category', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'hide_category',
					'name'    => esc_html__( 'Responsive - Hide Entry Category', 'foxiz' ),
					'desc'    => esc_html__( 'Hide the entry category on the tablet and mobile devices.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'      => esc_html__( 'Default from Category Settings', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'std'     => '0'
				),
				array(
					'id'   => 'design_entry_title',
					'name' => esc_html__( 'Post Title', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'title_tag',
					'name'    => esc_html__( 'Title HTML Tag', 'foxiz' ),
					'desc'    => esc_html__( 'Select a title HTML tag for the post title.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_heading_tag(),
					'std'     => 0
				),
				array(
					'id'      => 'title_size',
					'name'    => esc_html__( 'Desktop - Title Font Size', 'foxiz' ),
					'desc'    => esc_html__( 'Select a font size (px) for the post title in the desktop device. Leave blank to set it as the default.', 'foxiz' ),
					'type'    => 'text',
					'classes' => 'small',
					'std'     => ''
				),
				array(
					'id'      => 'title_size_tablet',
					'name'    => esc_html__( 'Tablet - Title Font Size', 'foxiz' ),
					'desc'    => esc_html__( 'Select a font size (px) for the post title in the table devices. Leave blank to set it as the default.', 'foxiz' ),
					'type'    => 'text',
					'classes' => 'small',
					'std'     => ''
				),
				array(
					'id'      => 'title_size_mobile',
					'name'    => esc_html__( 'Mobile - Title Font Size', 'foxiz' ),
					'desc'    => esc_html__( 'Select a font size (px) for the post title in the mobile device. Leave blank to set it as the default.', 'foxiz' ),
					'type'    => 'text',
					'classes' => 'small',
					'std'     => ''
				),
				array(
					'id'   => 'design_entry_meta',
					'name' => esc_html__( 'Entry Meta', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'entry_meta_bar',
					'name'    => esc_html__( 'Entry Meta Bar', 'foxiz' ),
					'desc'    => esc_html__( 'Select settings for the entry meta bar.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'      => esc_html__( '- Default -', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' ),
						'custom' => esc_html__( 'Custom Below', 'foxiz' ),
					),
					'std'     => '0'
				),
				array(
					'id'          => 'entry_meta',
					'type'        => 'text',
					'name'        => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'desc'        => esc_html__( 'Input entry meta tags to show. Separated by commas (for example: author,date). All meta keys include: [author, date, category, tag, view, comment, update, read, custom]', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author,update', 'foxiz' ),
					'std'         => ''
				),
				array(
					'id'      => 'review',
					'name'    => esc_html__( 'Review Meta', 'foxiz' ),
					'desc'    => esc_html__( 'Disable or select setting for entry review meta.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_entry_review( true ),
					'std'     => '0'
				),
				array(
					'id'      => 'review_meta',
					'name'    => esc_html__( 'Review Meta Description', 'foxiz' ),
					'desc'    => esc_html__( 'Enable or disable the meta description at the end of the review bar.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_switch_dropdown(),
					'std'     => '0'
				),
				array(
					'id'          => 'tablet_hide_meta',
					'name'        => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'desc'        => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all meta.', 'foxiz' ),
					'type'        => 'text',
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'          => 'mobile_hide_meta',
					'name'        => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'desc'        => esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all meta.', 'foxiz' ),
					'type'        => 'text',
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'   => 'design_entry_bookmark',
					'name' => esc_html__( 'Bookmark', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'bookmark',
					'name'    => esc_html__( 'Bookmark Icon', 'foxiz' ),
					'desc'    => esc_html__( 'Enable or disable the bookmark icon.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_switch_dropdown(),
					'std'     => '0'
				),
				array(
					'id'   => 'design_entry_format',
					'name' => esc_html__( 'Post Format', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'entry_format',
					'name'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'desc'    => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_entry_format( true ),
					'std'     => '0'
				),
				array(
					'id'   => 'design_entry_excerpt',
					'name' => esc_html__( 'Excerpt', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'excerpt',
					'name'    => esc_html__( 'Excerpt', 'foxiz' ),
					'desc'    => esc_html__( 'Select settings for the post excerpt.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0' => esc_html__( '- Default -', 'foxiz' ),
						'1' => esc_html__( 'Custom Settings Below', 'foxiz' ),
					),
					'std'     => '0'
				),
				array(
					'id'      => 'excerpt_length',
					'name'    => esc_html__( 'Excerpt - Max Length', 'foxiz' ),
					'desc'    => esc_html__( 'select max length of the post excerpt.', 'foxiz' ),
					'type'    => 'text',
					'classes' => 'small',
					'std'     => '0'
				),
				array(
					'id'          => 'excerpt_source',
					'name'        => esc_html__( 'Excerpt - Source', 'foxiz' ),
					'desc'        => esc_html__( 'Where to get the post excerpt.', 'foxiz' ),
					'description' => esc_html__( 'When you select "use title tagline". if it is empty, it will fallback to the post excerpt or content.', 'foxiz' ),
					'type'        => 'select',
					'options'     => foxiz_config_excerpt_source(),
					'std'         => 'tagline'
				),
				array(
					'id'      => 'hide_excerpt',
					'name'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'desc'    => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'type'    => 'select',
					'options' => array(
						'0'      => esc_html__( 'Default from Category Settings', 'foxiz' ),
						'mobile' => esc_html__( 'On Mobile', 'foxiz' ),
						'tablet' => esc_html__( 'On Tablet', 'foxiz' ),
						'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz' ),
						'-1'     => esc_html__( 'Disable', 'foxiz' )
					),
					'std'     => '0'
				),
				array(
					'id'   => 'design_entry_readmore',
					'name' => esc_html__( 'Read More', 'foxiz' ),
					'type' => 'info',
					'css'  => 'inner-info'
				),
				array(
					'id'      => 'readmore',
					'name'    => esc_html__( 'Read More Button', 'foxiz' ),
					'desc'    => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'type'    => 'select',
					'options' => foxiz_config_switch_dropdown(),
					'std'     => '0'
				),
			)
		);

		new RW_Custom_Taxonomy_Meta( $configs );
	}
}