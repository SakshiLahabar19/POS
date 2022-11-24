<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_bookmark' ) ) {
	/**
	 * @return array
	 * bookmark settings
	 */
	function foxiz_register_options_bookmark() {

		return array(
			'title' => esc_html__( 'Bookmark System', 'foxiz' ),
			'id'    => 'foxiz_config_section_bookmark',
			'desc'  => esc_html__( 'Select settings for the bookmark system.', 'foxiz' ),
			'icon'  => 'el el-bookmark',
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_bookmark_general' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_bookmark_general() {

		return array(
			'title'      => esc_html__( 'General', 'foxiz' ),
			'id'         => 'foxiz_config_section_bookmark_general',
			'desc'       => esc_html__( 'Select general settings for the bookmark system.', 'foxiz' ),
			'icon'       => 'el el-cog',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_bookmark_general',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'General', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'bookmark_system',
					'type'     => 'switch',
					'title'    => esc_html__( 'Bookmark System', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bookmark feature. This is global option and will apply to whole the website.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'       => 'bookmark_expiration',
					'type'     => 'text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Guest Expiration', 'foxiz' ),
					'subtitle' => esc_html__( 'Input max expiration (days) to save bookmarks and follow archives data for the guest users. Set 0 for no expiration.', 'foxiz' ),
					'default'  => '60'
				),
				array(
					'id'       => 'bookmark_limit',
					'type'     => 'text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Bookmark Limit', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a limit of posts or categories and writer can be saved per user.', 'foxiz' ),
					'default'  => '50'
				),
				array(
					'id'       => 'bookmark_notification',
					'type'     => 'switch',
					'title'    => esc_html__( 'Popup Notification', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the popup notification when bookmarking.', 'foxiz' ),
					'default'  => 1
				),
				array(
					'id'     => 'section_end_bookmark_general',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_bookmark_posts',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Bookmark Articles', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'bookmark_enable_when',
					'type'     => 'select',
					'title'    => esc_html__( 'Enable When', 'foxiz' ),
					'subtitle' => esc_html__( 'Allow or disallow guest users can bookmark posts.', 'foxiz' ),
					'options'  => array(
						'0'         => esc_html__( 'Guest and Logged Users', 'foxiz' ),
						'logged'    => esc_html__( 'Only Logged Users', 'foxiz' ),
						'ask_login' => esc_html__( 'Redirect to Login for Guest Users', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_bookmark_posts',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_follow_archives',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Follow Categories & Writers', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'follow_enable_when',
					'type'     => 'select',
					'title'    => esc_html__( 'Enable When', 'foxiz' ),
					'subtitle' => esc_html__( 'Allow or disallow guest users can follow categories and writers.', 'foxiz' ),
					'options'  => array(
						'0'         => esc_html__( 'Guest and Logged Users', 'foxiz' ),
						'logged'    => esc_html__( 'Only Logged Users', 'foxiz' ),
						'ask_login' => esc_html__( 'Redirect to Login for Guest Users', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'       => 'bookmark_author_admin',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Administrator', 'foxiz' ),
					'subtitle' => esc_html__( 'Show or hide administrator roles in the suggestion list.', 'foxiz' ),
					'default'  => false,
				),
				array(
					'id'     => 'section_end_follow_archives',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_bookmark_reading' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_bookmark_reading() {

		$prefix = 'saved_';

		return array(
			'title'      => esc_html__( 'Reading List', 'foxiz' ),
			'id'         => 'foxiz_config_section_bookmark_reading',
			'desc'       => esc_html__( 'Select settings for the reading list section. This section will use Ajax load.', 'foxiz' ),
			'icon'       => 'el el-bookmark',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_bookmark_saved',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Reading List Header', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Section Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for this section.', 'foxiz' ),
					'default'  => esc_html__( 'Reading List', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'description',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Section Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Input description for this section.', 'foxiz' ),
					'default'  => esc_html__( 'you\'ll find all saved articles here.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'image',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Description Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a image for displaying at the top heading. Image height is 60px.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'image_dark',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Description Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a image for displaying at the top heading in the dark mode.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'pattern',
					'title'    => esc_html__( 'Heading background Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background style for this heading.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_archive_header_bg(),
					'default'  => 'dot'
				),
				array(
					'id'     => 'section_end_bookmark_saved',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_saved_template',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Template Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is reading list section.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to display it as this section layout.', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_saved_template',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_saved_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the saved pages.', 'foxiz' ),
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
					'id'     => 'section_end_saved_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_saved_sidebar',
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
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This setting applies to the category pages.', 'foxiz' ),
					'options'  => array(
						'0'  => esc_html__( '- Default -', 'foxiz' ),
						'1'  => esc_html__( 'Enable', 'foxiz' ),
						'-1' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_saved_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_saved_design',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Design', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
						esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' ),
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
					'id'       => $prefix . 'entry_category',
					'title'    => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_standard_entry_category( true ),
					'default'  => '0'
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
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
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
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
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
					'id'          => $prefix . 'mobile_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select entry meta you would like to hide on the mobile devices. In case long meta it would be useful.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0' => esc_html__( '- Default -', 'foxiz' ),
						'1' => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_saved_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_bookmark_interests' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_bookmark_interests() {

		$prefix = 'interest_';

		return array(
			'title'      => esc_html__( 'User Interests', 'foxiz' ),
			'id'         => 'foxiz_config_section_bookmark_interests',
			'desc'       => esc_html__( 'Select settings for the user interests section.', 'foxiz' ),
			'icon'       => 'el el-heart',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_interest_general',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'General', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => $prefix . 'url',
					'type'        => 'text',
					'title'       => esc_html__( 'Follow Page URL', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input the a custom follow page URL for your customers to add their interests.', 'foxiz' ),
					'description' => esc_html__( 'You can use Elementor to build this page.', 'foxiz' ),
					'default'     => '#',
				),
				array(
					'id'       => $prefix . 'pattern',
					'title'    => esc_html__( 'Background Pattern', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a background style for section headings.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_archive_header_bg(),
					'default'  => 'dot'
				),
				array(
					'id'     => 'section_end_interest_general',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_interest_category',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Categories', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'category',
					'type'     => 'switch',
					'title'    => esc_html__( 'Category Interested', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this section.', 'foxiz' ),
					'default'  => true,
				),
				array(
					'id'       => $prefix . 'heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Section Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for this section.', 'foxiz' ),
					'default'  => esc_html__( 'Your Categories', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'description',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Section Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Input description for this section.', 'foxiz' ),
					'default'  => esc_html__( 'Follow categories that you\'re interested in', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'image',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Description Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a image for displaying at the top heading. Image height is 60px.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'image_dark',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Description Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a image for displaying at the top heading in the dark mode.', 'foxiz' ),
				),
				array(
					'id'     => 'section_end_interest_category',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_interest_author',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Authors', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'author',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author Interested', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this section.', 'foxiz' ),
					'default'  => true,
				),
				array(
					'id'       => $prefix . 'author_heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Section Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for this section.', 'foxiz' ),
					'default'  => esc_html__( 'Writers Followed', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'author_description',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Section Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Input description for this section.', 'foxiz' ),
					'default'  => esc_html__( 'Follow writers that you\'re interested in', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'author_image',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Description Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a image for displaying at the top heading. Image height is 60px.', 'foxiz' ),
				),
				array(
					'id'       => $prefix . 'author_image_dark',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Description Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Upload a image for displaying at the top heading in the dark mode.', 'foxiz' ),
				),
				array(
					'id'     => 'section_end_interest_author',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_bookmark_recommended' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_bookmark_recommended() {

		$prefix = 'recommended_';

		return array(
			'title'      => esc_html__( 'Recommended', 'foxiz' ),
			'id'         => 'foxiz_config_section_bookmark_recommended',
			'desc'       => esc_html__( 'Select settings for the recommended section.', 'foxiz' ),
			'icon'       => 'el el-fire',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_recommended_general',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'General', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => $prefix . 'interested',
					'type'     => 'switch',
					'title'    => esc_html__( 'Users Recommended', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this section', 'foxiz' ),
					'default'  => true
				),
				array(
					'id'       => $prefix . 'posts_per_page',
					'title'    => esc_html__( 'Posts per Page', 'foxiz' ),
					'subtitle' => esc_html__( 'Select posts per page for this section.', 'foxiz' ),
					'type'     => 'text',
					'validate' => 'numeric',
					'default'  => '9'
				),
				array(
					'id'     => 'section_end_recommended_general',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_recommended_template',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Template Builder', 'foxiz' ),
					'subtitle' => esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is the recommend section.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => $prefix . 'template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a "Ruby Template" shortcode to display it as this section layout.', 'foxiz' ),
					'desc'    => esc_html__( 'Leave this section blank to use below standard layouts.', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => 2,
					'default'     => ''
				),
				array(
					'id'     => 'section_end_recommended_template',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_recommended_heading',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'blog_heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Section Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for this section.', 'foxiz' ),
					'default'  => esc_html__( 'Recommended for You', 'foxiz' ),
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
					'subtitle' => esc_html__( 'Select a HTML tag for this heading.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0',
				),
				array(
					'id'       => $prefix . 'blog_heading_size',
					'title'    => esc_html__( 'Heading Font Size (Desktop)', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom font size value for this heading (px) on the desktop. Leave this option blank to set the default.', 'foxiz' ),
					'type'     => 'text',
					'validate' => 'numeric',
					'default'  => '',
				),
				array(
					'id'     => 'section_end_recommended_heading',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_recommended_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'layout',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for this section.', 'foxiz' ),
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
					'id'       => $prefix . 'column_gap',
					'title'    => esc_html__( 'Columns Gap', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a spacing between columns.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_blog_column_gap(),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_recommended_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_recommended_sidebar',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'The theme will use "Standard Blog Design" settings to render block. You can override settings in the panel below.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for this section.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'none'
				),
				array(
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for this section if it is enabled.', 'foxiz' ),
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
					'id'     => 'section_end_recommended_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_recommended_design',
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
					'id'       => $prefix . 'entry_category',
					'title'    => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a layout for the entry category to display in the post listing.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_standard_entry_category( true ),
					'default'  => '0'
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
					'id'       => $prefix . 'entry_format',
					'type'     => 'select',
					'title'    => esc_html__( 'Post Format Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable or select setting for the post format.', 'foxiz' ),
					'options'  => foxiz_config_entry_format( true ),
					'default'  => '0'
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
					'id'       => $prefix . 'readmore',
					'type'     => 'select',
					'title'    => esc_html__( 'Read More Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the read more button.', 'foxiz' ),
					'options'  => foxiz_config_switch_dropdown(),
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
					'id'       => $prefix . 'hide_excerpt',
					'type'     => 'select',
					'title'    => esc_html__( 'Responsive - Hide Excerpt', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post excerpt on the tablet and mobile devices.', 'foxiz' ),
					'options'  => array(
						'0' => esc_html__( '- Default -', 'foxiz' ),
						'1' => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_recommended_design',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_recommended_pagination',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Blog Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'The settings below will be not available if you use "Global WP Query Template Shortcode" to build the blog listing.', 'foxiz' ),
					'indent'   => true
				),

				array(
					'id'       => $prefix . 'pagination',
					'title'    => esc_html__( 'Pagination Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select pagination type for this section.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0'               => esc_html__( '- Disable -', 'foxiz' ),
						'load_more'       => esc_html__( 'Load More (Ajax)', 'foxiz' ),
						'infinite_scroll' => esc_html__( 'Infinite Scroll (Ajax)', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_recommended_pagination',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}