<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_single_post' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post() {

		return array(
			'title' => esc_html__( 'Single Post', 'foxiz' ),
			'id'    => 'foxiz_config_section_sp',
			'icon'  => 'el el-file',
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_layout' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_layout() {

		return array(
			'title'      => esc_html__( 'Layouts', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_layout',
			'desc'       => esc_html__( 'Select layouts for the single post that based on the post formats.', 'foxiz' ),
			'icon'       => 'el el-laptop',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'foxiz_config_section_start_sp_default',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Standard Post Format Layout', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_layout',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Single Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a default layout for the single post pages.', 'foxiz' ),
					'desc'     => esc_html__( 'The layout automatically rollback to the "Classic" if featured image isn\'t set.', 'foxiz' ),
					'options'  => foxiz_config_single_standard_layouts( false ),
					'default'  => 'standard_1',
				),
				array(
					'id'     => 'foxiz_config_section_end_sp_default',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'foxiz_config_section_start_sp_video',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Video Post Format Layout', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_video_layout',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Video Post Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a global layout for the video post format.', 'foxiz' ),
					'options'  => foxiz_config_single_video_layouts( false ),
					'default'  => 'video_1'
				),
				array(
					'id'       => 'single_post_video_autoplay',
					'type'     => 'switch',
					'title'    => esc_html__( 'Autoplay Video', 'foxiz' ),
					'subtitle' => esc_html__( 'Autoplay the featured video when the visitors scrolling to it.', 'foxiz' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'single_post_video_float',
					'type'     => 'switch',
					'title'    => esc_html__( 'Floating Video', 'foxiz' ),
					'subtitle' => esc_html__( 'Floating video on the screen on scroll.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'foxiz_config_section_end_sp_video',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'foxiz_config_section_start_sp_audio',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Audio Post Format Layout', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_audio_layout',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Audio Post Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a global layout for the audio post format.', 'foxiz' ),
					'options'  => foxiz_config_single_audio_layouts( false ),
					'default'  => 'audio_1'
				),
				array(
					'id'       => 'single_post_audio_autoplay',
					'type'     => 'switch',
					'title'    => esc_html__( 'Autoplay Audio', 'foxiz' ),
					'subtitle' => esc_html__( 'Autoplay the featured audio when the visitors scrolling to it.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'foxiz_config_section_end_sp_audio',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'foxiz_config_section_start_sp_gallery',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Gallery Post Format Layout', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_gallery_layout',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Gallery Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a global layout for the gallery post format.', 'foxiz' ),
					'options'  => foxiz_config_single_gallery_layouts( false ),
					'default'  => 'gallery_1'
				),
				array(
					'id'     => 'foxiz_config_section_end_sp_gallery',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_sections' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_sections() {

		return array(
			'title'      => esc_html__( 'Content Area', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_section',
			'desc'       => esc_html__( 'Select options for content area.', 'foxiz' ),
			'icon'       => 'el el-th-list',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_single_content_width',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Width Settings', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_line_length',
					'type'     => 'select',
					'title'    => esc_html__( 'Paragraph Line Length', 'foxiz' ),
					'subtitle' => esc_html__( 'Optimized the line length of the post content for reading (max width: 730px).', 'foxiz' ),
					'options'  => array(
						'0' => esc_html__( 'Full Width', 'foxiz' ),
						'1' => esc_html__( 'Optimal Line Length', 'foxiz' ),
					),
					'default'  => 1
				),
				array(
					'id'       => 'single_post_width_wo_sb',
					'type'     => 'select',
					'title'    => esc_html__( 'Max Width Content without Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a max-width for the content area without sidebar.', 'foxiz' ),
					'options'  => array(
						'small' => esc_html__( 'Small - 860px', 'foxiz' ),
						'0'     => esc_html__( 'Full Width', 'foxiz' )
					),
					'default'  => 'small'
				),
				array(
					'id'     => 'section_end_start_single_content_width',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_hyperlink',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Hyperlink Settings', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'hyperlink_style',
					'title'    => esc_html__( 'Hyperlink Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font style for the post hyperlinks.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0'           => esc_html__( 'Bold', 'foxiz' ),
						'bold_italic' => esc_html__( 'Bold Italic', 'foxiz' ),
						'italic'      => esc_html__( 'Normal Italic', 'foxiz' ),
						'normal'      => esc_html__( 'Normal', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'          => 'hyperlink_color',
					'title'       => esc_html__( 'Hyperlink Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for post hyperlinks.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_hyperlink_color',
					'title'       => esc_html__( 'Dark Mode - Hyperlink Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for post hyperlinks in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'       => 'hyperlink_line',
					'title'    => esc_html__( 'Hyperlink Underline', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a color value for the post hyperlinks.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Enable', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' )
					),
					'default'  => '1'
				),
				array(
					'id'          => 'hyperlink_line_color',
					'title'       => esc_html__( 'Underline Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for the hyperlink underline. Leave blank to set as the global color.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'dark_hyperlink_line_color',
					'title'       => esc_html__( 'Dark Mode - Underline Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color for the hyperlink underline in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'     => 'section_end_single_hyperlink',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_section_qv',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Quick View Info', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_quick_view',
					'type'     => 'switch',
					'title'    => esc_html__( 'Quick View Info', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable quick view info bar (review & sponsor meta) at the top of the content.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_section_qv',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_section_footer',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Footer Area', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_tags',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post Tags Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the post tags bar at the bottom of the post content.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_sources',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sources Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the sources bar at the bottom of the post content.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_via',
					'type'     => 'switch',
					'title'    => esc_html__( 'Via Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the via bar at the bottom of the post content.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_section_footer',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_newsletter',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Bottom Newsletter', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_newsletter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Bottom Newsletter', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the newsletter form at bottom entry content.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'single_post_newsletter_title',
					'type'     => 'text',
					'title'    => esc_html__( 'Newsletter Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your a heading for your newsletter section.', 'foxiz' ),
					'default'  => esc_html__( 'Sign Up For Daily Newsletter', 'foxiz' )
				),
				array(
					'id'       => 'single_post_newsletter_description',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Newsletter Description', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your a description for your newsletter.', 'foxiz' ),
					'default'  => esc_html__( 'Be keep up! Get the latest breaking news delivered straight to your inbox.', 'foxiz' )
				),
				array(
					'id'       => 'single_post_newsletter_code',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Newsletter Shortcode', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your a newsletter (subscribe) shortcode or script to show at bottom entry content.', 'foxiz' ),
					'default'  => '[mc4wp_form]'
				),
				array(
					'id'       => 'single_post_newsletter_policy',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Policy Text', 'foxiz' ),
					'subtitle' => esc_html__( 'Input your policy text for the newsletter form, row HTML allowed.', 'foxiz' ),
					'default'  => 'By signing up, you agree to our <a href="#">Terms of Use</a> and acknowledge the data practices in our <a href="#">Privacy Policy</a>. You may unsubscribe at any time.'
				),
				array(
					'id'     => 'section_end_single_newsletter',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),

				array(
					'id'     => 'section_start_single_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Author Card & Next/Prev Pagination', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_author_card',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author Card', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the author information in the bottom of the content.', 'foxiz' ),
					'desc'     => esc_html__( 'The author box requests author information (Users > Profile) for displaying.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_next_prev',
					'type'     => 'switch',
					'title'    => esc_html__( 'Next/Prev Post Pagination', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the next/previous link navigation in single post pages.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'single_post_next_prev_mobile',
					'type'     => 'switch',
					'required' => array( 'single_post_next_prev', '=', 1 ),
					'title'    => esc_html__( 'Next/Prev - Mobile Hide', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide Next/Prev Post pagination on the mobile device.', 'foxiz' ),
					'switch'   => true,
					'default'  => '1'
				),
				array(
					'id'     => 'section_end_single_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_sidebar' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_sidebar() {

		return array(
			'title'      => esc_html__( 'Sidebar Area', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_sidebar',
			'desc'       => esc_html__( 'Select settings for the single sidebar.', 'foxiz' ),
			'icon'       => 'el el-align-right',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a sidebar if you select a single layout which has the sidebar. You can set an individual sidebar for each post in the post editor page.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name( false ),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => 'single_post_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a position for the single sidebar. You can set an individual sidebar position for each post in the post editor page.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'       => 'single_post_sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature. This option will only apply to the single post.', 'foxiz' ),
					'options'  => array(
						'default' => esc_html__( 'Use Global Setting', 'foxiz' ),
						'1'       => esc_html__( 'Enable', 'foxiz' ),
						'-1'      => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => 'default'
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_category' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_category() {

		return array(
			'title'      => esc_html__( 'Entry Category', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_category',
			'desc'       => esc_html__( 'Select settings for the entry category.', 'foxiz' ),
			'icon'       => 'el el-folder-open',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_entry_category',
					'type'     => 'select',
					'title'    => esc_html__( 'Entry Category', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable entry category info in the single post.', 'foxiz' ),
					'options'  => foxiz_config_extended_entry_category(),
					'default'  => 'bg-1,big'
				),
				array(
					'id'          => 'single_post_primary_category',
					'type'        => 'switch',
					'title'       => esc_html__( 'Primary Category', 'foxiz' ),
					'subtitle'    => esc_html__( 'By default, Primary category setting will only apply to the post listing.', 'foxiz' ),
					'description' => esc_html__( 'Enable this option if you would like to only show the primary category in the single post.', 'foxiz' ),
					'switch'      => true,
					'default'     => 0
				),
				array(
					'id'          => 'single_post_entry_category_size',
					'type'        => 'text',
					'validate'    => 'number',
					'title'       => esc_html__( 'Entry Category Font Size', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a custom font size value (in px) for the single entry category.', 'foxiz' ),
					'description' => esc_html__( 'This setting will only apply on the desktop devices. Navigate to "Typography > Entry Category" to set for tablet mobile devices.', 'foxiz' ),
					'default'     => ''
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_tagline' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_tagline() {

		return array(
			'title'      => esc_html__( 'Single Tagline', 'foxiz' ),
			'id'         => 'foxiz_config_section_single_tagline',
			'desc'       => esc_html__( 'Select a HTML tag for the single tagline to optimize your SEO settings.', 'foxiz' ),
			'icon'       => 'el el-pencil',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'info_tagline_typo',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the tagline typography, navigate to "Typography > Headline & Tagline > Single Tagline".', 'foxiz' ),
				),
				array(
					'id'       => 'tagline_tag',
					'type'     => 'select',
					'title'    => esc_html__( 'HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a HTML tag for the single tagline.', 'foxiz' ),
					'options'  => array(
						'h2'   => esc_html__( 'H2', 'foxiz' ),
						'h3'   => esc_html__( 'H3', 'foxiz' ),
						'h4'   => esc_html__( 'H4', 'foxiz' ),
						'h5'   => esc_html__( 'H5', 'foxiz' ),
						'h6'   => esc_html__( 'H6', 'foxiz' ),
						'span' => esc_html__( 'span', 'foxiz' )
					),
					'default'  => 'h2'
				),
				array(
					'id'       => 'highlight_heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Highlight Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for the highlights section if it is existing.', 'foxiz' ),
					'default'  => esc_html__( 'Highlights', 'foxiz' )
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_meta' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_meta() {

		return array(
			'title'      => esc_html__( 'Entry Meta', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_style',
			'desc'       => esc_html__( 'Select styles, layouts and other settings for the single post meta.', 'foxiz' ),
			'icon'       => 'el el-adjust-alt',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_single_meta_info',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Entry Meta Settings', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_avatar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Big Avatar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the author avatars before the entry meta bar.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_entry_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Entry Meta Tags', 'foxiz' ),
					'subtitle' => esc_html__( 'Organize how you want the entry meta info to appear in the single post pages.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array( 'author' ),
				),
				array(
					'id'       => 'single_post_meta_author_label',
					'title'    => esc_html__( '"By" Author Label', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the "By" text before the single post author meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'single_post_author_job',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author Job', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the author job info.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_meta_date_label',
					'title'    => esc_html__( '"Published" Date Label', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the "Published" text before the post date meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1,
				),
				array(
					'id'          => 'single_post_tablet_hide_meta',
					'type'        => 'text',
					'title'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'placeholder' => esc_html__( 'avatar,author', 'foxiz' ),
					'default'     => ''
				),
				array(
					'id'       => 'single_post_mobile_hide_meta',
					'type'     => 'select',
					'multi'    => true,
					'title'    => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author... Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all tags.', 'foxiz' ),
					'options'  => foxiz_config_entry_meta_tags(),
					'default'  => array(),
				),
				array(
					'id'     => 'section_end_single_meta_info',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_updated_meta',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Last Updated Date', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_updated_meta',
					'type'     => 'switch',
					'title'    => esc_html__( 'Last Updated Date', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the last updated meta info in the single post.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'          => 'single_post_update_format',
					'type'        => 'text',
					'title'       => esc_html__( 'Date Format', 'foxiz' ),
					'subtitle'    => esc_html__( 'Custom date format for the last updated info.', 'foxiz' ),
					'placeholder' => 'Y/m/d \a\t g:i A',
					'default'     => ''
				),
				array(
					'id'     => 'section_end_single_updated_meta',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_min_read',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Reading Time', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_min_read',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reading Time', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the reading time info in the single post.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_min_read',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			),
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_shares' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_shares() {

		return array(
			'title'      => esc_html__( 'Share on Socials', 'foxiz' ),
			'id'         => 'foxiz_config_section_single_shares',
			'desc'       => esc_html__( 'Select socials you would like to show the share button.', 'foxiz' ),
			'icon'       => 'el el-share',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_single_post_social_top',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'At the Top', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'share_top',
					'type'     => 'switch',
					'title'    => esc_html__( 'Top Share Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable top share section.  This section will display below the single entry meta info.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_top_color',
					'type'     => 'switch',
					'title'    => esc_html__( 'Colorful Icons', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable color for social icons.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_top_facebook',
					'type'     => 'switch',
					'title'    => esc_html__( 'Facebook', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Facebook.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_top_twitter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Twitter', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Twitter.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_top_pinterest',
					'type'     => 'switch',
					'title'    => esc_html__( 'Pinterest', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Pinterest.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_whatsapp',
					'type'     => 'switch',
					'title'    => esc_html__( 'WhatsApp', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on WhatsApp.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_linkedin',
					'type'     => 'switch',
					'title'    => esc_html__( 'LinkedIn', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on LinkedIn.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_tumblr',
					'type'     => 'switch',
					'title'    => esc_html__( 'Tumblr', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Tumblr.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_reddit',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reddit', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Reddit.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_vk',
					'type'     => 'switch',
					'title'    => esc_html__( 'Vkontakte', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Vkontakte.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_telegram',
					'type'     => 'switch',
					'title'    => esc_html__( 'Telegram', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Telegram.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_top_email',
					'type'     => 'switch',
					'title'    => esc_html__( 'Email', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Email.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'share_top_copy',
					'type'     => 'switch',
					'title'    => esc_html__( 'Copy Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the copy post link icon.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_top_print',
					'type'     => 'switch',
					'title'    => esc_html__( 'Print', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the print post button.', 'foxiz' ),
					'required' => array( 'share_top', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_post_social_top',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				/** bottom shares */
				array(
					'id'     => 'section_start_single_post_social_bottom',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'At Bottom of Post Content', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'share_bottom',
					'type'     => 'switch',
					'title'    => esc_html__( 'Bottom Content Share Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the bottom share bar, This section is displayed at below of the post content.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_bottom_color',
					'type'     => 'switch',
					'title'    => esc_html__( 'Colorful Icons', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable color for social icons.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_bottom_facebook',
					'type'     => 'switch',
					'title'    => esc_html__( 'Facebook', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Facebook.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_bottom_twitter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Twitter', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Twitter.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_bottom_pinterest',
					'type'     => 'switch',
					'title'    => esc_html__( 'Pinterest', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Pinterest.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_whatsapp',
					'type'     => 'switch',
					'title'    => esc_html__( 'WhatsApp', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on WhatsApp.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_linkedin',
					'type'     => 'switch',
					'title'    => esc_html__( 'LinkedIn', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on LinkedIn.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_tumblr',
					'type'     => 'switch',
					'title'    => esc_html__( 'Tumblr', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Tumblr.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_reddit',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reddit', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Reddit.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_vk',
					'type'     => 'switch',
					'title'    => esc_html__( 'Vkontakte', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Vkontakte.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_telegram',
					'type'     => 'switch',
					'title'    => esc_html__( 'Telegram', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Telegram.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_bottom_email',
					'type'     => 'switch',
					'title'    => esc_html__( 'Email', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Email.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'share_bottom_copy',
					'type'     => 'switch',
					'title'    => esc_html__( 'Copy Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the copy post link button.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_bottom_print',
					'type'     => 'switch',
					'title'    => esc_html__( 'Print', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the print button.', 'foxiz' ),
					'required' => array( 'share_bottom', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_post_social_bottom',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_post_social_left',
					'title'  => esc_html__( 'Fixed Left Area', 'foxiz' ),
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'indent' => true
				),
				array(
					'id'       => 'share_left',
					'type'     => 'switch',
					'title'    => esc_html__( 'Fixed Left Share Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on socials at the fixed left section.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_left_mobile',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this section on the mobile devices.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_left_color',
					'type'     => 'switch',
					'title'    => esc_html__( 'Colorful Icons', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable color for social icons.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_left_facebook',
					'type'     => 'switch',
					'title'    => esc_html__( 'Facebook', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Facebook.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_left_twitter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Twitter', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Twitter.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_left_pinterest',
					'type'     => 'switch',
					'title'    => esc_html__( 'Pinterest', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Pinterest.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_whatsapp',
					'type'     => 'switch',
					'title'    => esc_html__( 'WhatsApp', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on WhatsApp.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_linkedin',
					'type'     => 'switch',
					'title'    => esc_html__( 'LinkedIn', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on LinkedIn.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_tumblr',
					'type'     => 'switch',
					'title'    => esc_html__( 'Tumblr', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Tumblr.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_reddit',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reddit', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Reddit.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_vk',
					'type'     => 'switch',
					'title'    => esc_html__( 'Vkontakte', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Vkontakte.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_telegram',
					'type'     => 'switch',
					'title'    => esc_html__( 'Telegram', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Telegram.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_left_email',
					'type'     => 'switch',
					'title'    => esc_html__( 'Email', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Email.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'share_left_copy',
					'type'     => 'switch',
					'title'    => esc_html__( 'Copy Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the copy post link icon.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_left_print',
					'type'     => 'switch',
					'title'    => esc_html__( 'Print', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the print button.', 'foxiz' ),
					'required' => array( 'share_left', '=', '1' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_post_social_left',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_sponsored' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_sponsored() {

		return array(
			'title'      => esc_html__( 'Sponsored Post', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_sponsored',
			'desc'       => esc_html__( 'Select settings for the sponsored posts.', 'foxiz' ),
			'icon'       => 'el el-bell',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'sponsor_meta_text',
					'type'     => 'text',
					'title'    => esc_html__( 'Sponsored Meta Text', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a meta text for the sponsored posts.', 'foxiz' ),
					'default'  => foxiz_html__( 'Sponsored by', 'foxiz' )
				),
				array(
					'id'       => 'single_post_sponsor_redirect',
					'type'     => 'switch',
					'title'    => esc_html__( 'Directly Redirect', 'foxiz' ),
					'subtitle' => esc_html__( 'Directly redirect to the sponsored URL when visitors click on the post title in the blog listing.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_review' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_review() {

		return array(
			'title'      => esc_html__( 'Review & Rating', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_review',
			'desc'       => esc_html__( 'Select options for the review system.', 'foxiz' ),
			'icon'       => 'el el-star',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_review_type',
					'title'    => esc_html__( 'Default Review Type', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a default review type for your website.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'star'  => esc_html__( 'The Star (1 > 5)', 'foxiz' ),
						'score' => esc_html__( 'The Score (1 > 10)', 'foxiz' ),
					),
					'default'  => 'star'
				),
				array(
					'id'       => 'user_can_review',
					'title'    => esc_html__( 'User Rating in Comments', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable visitors can rate and review on the post review.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( 'Enable', 'foxiz' ),
						'2' => esc_html__( 'Enable without Post Review', 'foxiz' ),
						'0' => esc_html__( 'Disable', 'foxiz' ),
					),
					'default'  => 1
				),
				array(
					'id'       => 'single_post_review_image',
					'title'    => esc_html__( 'Default Review Image', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a default featured image for the review box.', 'foxiz' ),
					'type'     => 'media',
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_comment' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_comment() {

		return array(
			'title'      => esc_html__( 'Comments', 'foxiz' ),
			'id'         => 'foxiz_config_section_single_comment',
			'desc'       => esc_html__( 'Select settings for the comment box.', 'foxiz' ),
			'icon'       => 'el el-comment',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_comment_button',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show/Hide Comment Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the button show/hide comment box in the single post pages.', 'foxiz' ),
					'switch'   => true,
					'default'  => '1'
				),
				array(
					'id'       => 'single_post_user_can_review',
					'title'    => esc_html__( 'User Rating in Comments', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable visitors can rate and review all posts in the comment box.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0' => esc_html__( 'Disable', 'foxiz' ),
						'1' => esc_html__( 'Enable for Review Posts', 'foxiz' ),
						'2' => esc_html__( 'Enable for All Posts', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'       => 'single_post_comment',
					'type'     => 'switch',
					'title'    => esc_html__( 'Disable All Comments', 'foxiz' ),
					'subtitle' => esc_html__( 'This is a global option to disable all comments on posts & page...', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_footer' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_footer() {

		return array(
			'title'      => esc_html__( 'Related & Popular', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_footer',
			'desc'       => esc_html__( 'Select options for the related and popular section at the footer of the single post page.', 'foxiz' ),
			'icon'       => 'el el-flag',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_single_post_related',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Related Section', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'single_post_related',
					'type'     => 'select',
					'title'    => esc_html__( 'Related Section', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the related section at the footer in single post pages.', 'foxiz' ),
					'options'  => array(
						'0'           => esc_html__( '- Disable -', 'foxiz' ),
						'standard'    => esc_html__( 'Standard Layout', 'foxiz' ),
						'rb_template' => esc_html__( 'Use Ruby Template', 'foxiz' )
					),
					'default'  => 'standard',
				),
				array(
					'id'       => 'single_post_related_where',
					'type'     => 'select',
					'title'    => esc_html__( 'Posts from Where', 'foxiz' ),
					'subtitle' => esc_html__( 'What posts should be displayed in the related section.', 'foxiz' ),
					'options'  => array(
						'all'      => esc_html__( 'Same Tags & Categories', 'foxiz' ),
						'tag'      => esc_html__( 'Same Tags', 'foxiz' ),
						'category' => esc_html__( 'Same Categories', 'foxiz' ),
					),
					'default'  => 'all'
				),
				array(
					'id'       => 'single_post_related_total',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Number of Posts', 'foxiz' ),
					'subtitle' => esc_html__( 'Select number of posts to show at once.', 'foxiz' ),
					'default'  => 4
				),
				array(
					'id'     => 'section_end_single_post_related',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_single_post_related_template',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Related Template', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'Select "Use Ruby Template" under the "Related Section" setting if you use Ruby Template shortcode.', 'foxiz' ),
						esc_html__( 'Ensure "Use WP Global Query" under "Template Builder - Global Query > Query Mode" has been set in a block of your template to help the system understand that it is related section.', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'          => 'single_post_related_shortcode',
					'type'        => 'textarea',
					'rows'        => 2,
					'title'       => esc_html__( 'Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Add a ruby template shortcode you would like to display for this section.', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]'
				),
				array(
					'id'     => 'section_end_single_post_related_template',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_single_post_related_blog',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Related Template', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'The settings below will be not available if you use Ruby Template to build this section.', 'foxiz' ),
						esc_html__( 'Select "Standard Layout" under the "Related Section" setting if you use settings below.', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'       => 'single_post_related_blog_heading',
					'type'     => 'text',
					'title'    => esc_html__( 'Related Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a heading for this section. Leave -1 to disable this heading.', 'foxiz' ),
					'switch'   => true,
					'default'  => 'You Might Also Like',
				),
				array(
					'id'       => 'single_post_related_blog_heading_layout',
					'title'    => esc_html__( 'Heading Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a heading layout for the heading.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_layout( true ),
					'default'  => '0',
				),
				array(
					'id'       => 'single_post_related_heading_tag',
					'title'    => esc_html__( 'Heading HTML Tag', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a HTML tag for this heading.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_heading_tag(),
					'default'  => '0',
				),
				array(
					'id'       => 'single_post_related_blog_heading_size',
					'title'    => esc_html__( 'Heading Font Size (Desktop)', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom font size value for this heading (px) on the desktop. Leave this option blank to set the default.', 'foxiz' ),
					'type'     => 'text',
					'validate' => 'numeric',
					'default'  => '',
				),
				array(
					'id'       => 'single_post_related_layout',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Blog Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Select blog listing layout for the related section.', 'foxiz' ),
					'options'  => array(
						'grid_1'       => array(
							'img'   => foxiz_get_asset_image( 'grid-1.jpg' ),
							'title' => esc_html__( 'Grid 1 (Standard)', 'foxiz' )
						),
						'grid_2'       => array(
							'img'   => foxiz_get_asset_image( 'grid-1.jpg' ),
							'title' => esc_html__( 'Grid 2', 'foxiz' )
						),
						'grid_box_1'   => array(
							'img'   => foxiz_get_asset_image( 'grid-box-1.jpg' ),
							'title' => esc_html__( 'Boxed Grid 1', 'foxiz' )
						),
						'grid_box_2'   => array(
							'img'   => foxiz_get_asset_image( 'grid-box-2.jpg' ),
							'title' => esc_html__( 'Boxed Grid 2', 'foxiz' )
						),
						'grid_small_1' => array(
							'img'   => foxiz_get_asset_image( 'grid-small-1.jpg' ),
							'title' => esc_html__( 'Small Grid', 'foxiz' )
						),
					),
					'default'  => 'grid_small_1'
				),

				array(
					'id'       => 'single_post_related_pagination',
					'title'    => esc_html__( 'Pagination Style', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a pagination type for the related section.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0'               => esc_html__( '- Disable -', 'foxiz' ),
						'next_prev'       => esc_html__( 'Next Prev', 'foxiz' ),
						'load_more'       => esc_html__( 'Show More', 'foxiz' ),
						'infinite_scroll' => esc_html__( 'Infinite Scroll', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_single_post_related_blog',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_single_inline_related',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Inner Content Related', 'foxiz' ),
					'subtitle' => esc_html__( 'Automatically add a related section into post content after x paragraphs. To use the shortcode, read the documentation "Related Box Shortcode" for further information.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => 'single_post_inline_related',
					'type'        => 'textarea',
					'rows'        => 2,
					'title'       => esc_html__( 'Related Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a related shortcode you want to display.', 'foxiz' ),
					'description' => esc_html__( 'The setting will not apply to posts have been added shortcode directly into content.', 'foxiz' ),
					'placeholder' => '[ruby_related heading="More Read" total="5" layout="1" where="all"]'
				),
				array(
					'id'          => 'single_post_inline_related_pos',
					'type'        => 'text',
					'class'       => 'small-text',
					'title'       => esc_html__( 'Display Position', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a position (after x paragraphs) to display the related bõ.', 'foxiz' ),
					'description' => esc_html__( 'The related box will not appear on post content have number of paragraph less than this setting.', 'foxiz' ),
					'default'     => 5
				),
				array(
					'id'     => 'section_end_single_inline_related',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_single_post_popular',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Popular Section', 'foxiz' ),
					'subtitle' => esc_html__( 'Display a template at the bottom of single post page. Choose popular in your block query settings to show popular articles.', 'foxiz' ),
					'indent'   => true
				),
				array(
					'id'          => 'single_post_popular_shortcode',
					'type'        => 'textarea',
					'rows'        => 2,
					'title'       => esc_html__( 'Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Add a ruby template shortcode you would like to display for this section.', 'foxiz' ),
					'description' => esc_html__( 'Leave blank if you would like to disable it.', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]'
				),
				array(
					'id'     => 'section_end_single_post_popular',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_ajax' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_ajax() {

		return array(
			'title'      => esc_html__( 'Auto Load Next Posts', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_ajax',
			'desc'       => esc_html__( 'Select options for the ajax load next posts feature.', 'foxiz' ),
			'icon'       => 'el el-refresh',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_ajax_next_post',
					'type'     => 'switch',
					'title'    => esc_html__( 'Auto Load Next Posts', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable ajax load next posts when visitors reached end of the post content.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'ajax_next_button',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Continue Reading', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide a part of content of next posts and show the button to increase page views.', 'foxiz' ),
					'switch'   => true,
					'default'  => '1'
				),
				array(
					'id'       => 'ajax_next_cat',
					'type'     => 'switch',
					'title'    => esc_html__( 'Same Categories', 'foxiz' ),
					'subtitle' => esc_html__( 'Only load posts which has same categories with the current post.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'ajax_next_sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
					'subtitle' => esc_html__( 'Assign a special sidebar for all next load posts, Recommended use simple or advert content.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name(),
					'default'  => 'foxiz_sidebar_default'
				),
				array(
					'id'       => 'ajax_next_hide_sidebar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Hide Sidebar on Mobile', 'foxiz' ),
					'subtitle' => esc_html__( 'Hide the post sidebar on the mobile devices when load next posts.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'ajax_next_comment_button',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show/Hide Comment Button', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the button show/hide comment box when load next posts.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_highlight' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_highlight() {

		return array(
			'title'      => esc_html__( 'Highlight Shares', 'foxiz' ),
			'id'         => 'foxiz_config_section_highlight_share',
			'desc'       => esc_html__( 'Show the popup shares bar when the user highlight text in the post content.', 'foxiz' ),
			'icon'       => 'el el-share-alt',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_highlight_shares',
					'type'     => 'switch',
					'title'    => esc_html__( 'Highlight Shares', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the highlight shares feature.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_highlight_share_facebook',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share on Facebook', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Facebook.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_highlight_share_twitter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share on Twitter', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Twitter.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_post_highlight_share_reddit',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share on Reddit', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Reddit.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_header' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_header() {

		return array(
			'title'      => esc_html__( 'Site Header', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_header',
			'desc'       => esc_html__( 'The setting below will apply to the single post pages.', 'foxiz' ),
			'icon'       => 'el el-th',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'single_post_header_settings_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit for individual post, navigate to "Posts > Edit > Post Options > Site Header".', 'foxiz' ),
				),
				array(
					'id'          => 'single_post_header_style',
					'type'        => 'select',
					'title'       => esc_html__( 'Header Style', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a site header style for the single post.', 'foxiz' ),
					'options'     => foxiz_config_header_style( true, true ),
					'description' => esc_html__( 'The transparent headers is only suitable with layouts: Standard 2, Video 2 and Audio 2.', 'foxiz' ),
					'default'     => '0'
				),
				array(
					'id'       => 'single_font_resizer',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reading Font Resizer', 'foxiz' ),
					'subtitle' => esc_html__( 'Show a font size icon that give visitors of your site the option to change the font size of your text.', 'foxiz' ),
					'default'  => '1'
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_sticky' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_post_sticky() {

		return array(
			'title'      => esc_html__( 'Sticky Headline', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_sticky',
			'desc'       => esc_html__( 'Sticky the single heading and share on socials list when scrolling down.', 'foxiz' ),
			'icon'       => 'el el-arrow-down',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'section_start_single_sticky',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'General', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'Set the option "Set as Main Menu" in the "Main Navigation" Elementor block to "Yes" if you are using a template for your header if you enable this option.', 'foxiz' ),
						esc_html__( 'Ensure that there is enough spacing for the headline if you are using a template for your header.', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'       => 'single_post_sticky_title',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sticky Headline', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable sticky the single post headline (post title).', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_sticky',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_sticky_share',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Share on Socials', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'share_sticky',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Share Bar', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on socials list in this bar.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_sticky_label',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Label', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the left label.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_sticky_color',
					'type'     => 'switch',
					'title'    => esc_html__( 'Colorful Icons', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable color for social icons.', 'foxiz' ),
					'switch'   => true,
					'default'  => false,
				),
				array(
					'id'     => 'section_end_single_sticky_share',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_single_sticky_socials',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Socials List', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'share_sticky_facebook',
					'type'     => 'switch',
					'title'    => esc_html__( 'Facebook', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Facebook.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_sticky_twitter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Twitter', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Twitter.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_sticky_pinterest',
					'type'     => 'switch',
					'title'    => esc_html__( 'Pinterest', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Pinterest.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_whatsapp',
					'type'     => 'switch',
					'title'    => esc_html__( 'WhatsApp', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on WhatsApp.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_linkedin',
					'type'     => 'switch',
					'title'    => esc_html__( 'LinkedIn', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on LinkedIn.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_tumblr',
					'type'     => 'switch',
					'title'    => esc_html__( 'Tumblr', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Tumblr.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_reddit',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reddit', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Reddit.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_vk',
					'type'     => 'switch',
					'title'    => esc_html__( 'Vkontakte', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Vkontakte.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_telegram',
					'type'     => 'switch',
					'title'    => esc_html__( 'Telegram', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Telegram.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'share_sticky_email',
					'type'     => 'switch',
					'title'    => esc_html__( 'Email', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable share on Email.', 'foxiz' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'share_sticky_copy',
					'type'     => 'switch',
					'title'    => esc_html__( 'Copy Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the copy post link icon.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_sticky_print',
					'type'     => 'switch',
					'title'    => esc_html__( 'Print', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the print button.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_sticky_social',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_reading_indicator' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_single_reading_indicator() {

		return array(
			'title'      => esc_html__( 'Reading Indicator', 'foxiz' ),
			'id'         => 'foxiz_config_section_sp_indicator.',
			'desc'       => esc_html__( 'Display the reading indicator bar at the top site.', 'foxiz' ),
			'icon'       => 'el el-road',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_post_reading_indicator',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reading Indicator', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the reading indicator bar.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'reading_indicator_height',
					'type'     => 'text',
					'title'    => esc_html__( 'Bar Height', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom height value (px) for this bar. Leave blank to set it as the default.', 'foxiz' ),
					'class'    => 'small-text',
					'default'  => ''
				),
				array(
					'id'          => 'reading_indicator_color',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Bar Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for this bar.', 'foxiz' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => array(
						'from' => '',
						'to'   => '',
					),
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_single_post_featured' ) ) {
	function foxiz_register_options_single_post_featured() {

		return array(
			'id'         => 'foxiz_config_section_single_featured',
			'title'      => esc_html__( 'Featured Image', 'foxiz' ),
			'icon'       => 'el el-picture',
			'desc'       => esc_html__( 'Select settings for the single feature images.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'single_crop_size',
					'title'    => esc_html__( 'Featured Image Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a featured image size for single post pages.', 'foxiz' ),
					'type'     => 'select',
					'options'  => foxiz_config_crop_size(),
					'default'  => '0'
				),
				array(
					'id'          => 'single_6_ratio',
					'title'       => esc_html__( 'Layout 6 - Featured Ratio', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a custom featured image ratio for the single layout 6.', 'foxiz' ),
					'description' => esc_html__( 'This setting applies for the layout 6 only. Default is 150.', 'foxiz' ),
					'validate'    => 'numeric',
					'type'        => 'text',
					'class'       => 'small-text',
					'default'     => ''
				),
			)
		);
	}
}
