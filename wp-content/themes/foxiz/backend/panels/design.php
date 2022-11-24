<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_design' ) ) {
	/**
	 * @return array
	 * theme design
	 */
	function foxiz_register_options_design() {

		return array(
			'id'    => 'foxiz_config_section_design',
			'title' => esc_html__( 'Theme Design', 'foxiz' ),
			'icon'  => 'el el-idea'
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_category' ) ) {
	/**
	 * @return array
	 * post entry meta
	 */
	function foxiz_register_options_design_category() {

		return array(
			'id'         => 'foxiz_config_section_design_category',
			'title'      => esc_html__( 'Entry Category', 'foxiz' ),
			'desc'       => esc_html__( 'The category label display in the post listing.', 'foxiz' ),
			'icon'       => 'el el-folder-open',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'    => 'category_color_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit color for individual category, navigate to "Admin Dashboard > Posts > Categories > Edit".', 'foxiz' ),
				),
				array(
					'id'          => 'category_highlight_color',
					'title'       => esc_html__( 'Highlight Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a highlight color for the entry category to display in the post listing.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'default'     => '',
				),
				array(
					'id'          => 'category_color',
					'title'       => esc_html__( 'Accent Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select an accent (text) color for the entry category to display in the post listing. Leave blank to set it as the default.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'default'     => '',
				),
				array(
					'id'          => 'category_dark_highlight_color',
					'title'       => esc_html__( 'Dark Mode - Highlight Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a highlight color for the entry category to display in the post listing in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'default'     => '',
				),
				array(
					'id'          => 'category_dark_color',
					'title'       => esc_html__( 'Dark Mode - Accent Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select an accent (text) color for the entry category to display in the post listing in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'default'     => '',
				),
				array(
					'id'          => 'max_categories',
					'title'       => esc_html__( 'Maximum Entry Categories', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a value to limited numbers of entry category show on all post listing layout, useful in case you have many categories per post.', 'foxiz' ),
					'description' => esc_html__( 'Please blank to display all categories', 'foxiz' ),
					'type'        => 'text',
					'class'       => 'small-text',
					'default'     => '',
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_meta' ) ) {
	/**
	 * @return array
	 * post entry meta
	 */
	function foxiz_register_options_design_meta() {

		return array(
			'id'         => 'foxiz_config_section_meta_style',
			'title'      => esc_html__( 'Entry Meta', 'foxiz' ),
			'desc'       => esc_html__( 'These are small elements that display in the post listing e.g: author name, date, total views, total comments...', 'foxiz' ),
			'icon'       => 'el el-adjust-alt',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_meta_icons',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Entry Meta Icons', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'meta_author_label',
					'title'    => esc_html__( '"By" Author Label', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the "By" text before the post author meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'meta_date_icon',
					'title'    => esc_html__( 'Published Date Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the icon before the post date meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'meta_updated_icon',
					'title'    => esc_html__( 'Updated Date Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the clock icon before the post updated meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'meta_comment_icon',
					'title'    => esc_html__( 'Comment Meta Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the icon before the post comment meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'meta_view_icon',
					'title'    => esc_html__( 'Post View Meta Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the icon before the post view meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'meta_read_icon',
					'title'    => esc_html__( 'Reading Time Meta Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the icon before the reading time meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'       => 'meta_category_icon',
					'title'    => esc_html__( 'Category Meta Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the icon before the post category meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => false,
				),
				array(
					'id'     => 'section_end_meta_icons',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_reading_speed',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Reading Speed', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'read_speed',
					'title'    => esc_html__( 'Words per Minute', 'foxiz' ),
					'subtitle' => esc_html__( 'Input number of words per minute to calculate the reading time. Default is 130', 'foxiz' ),
					'type'     => 'text',
					'default'  => 130,
				),
				array(
					'id'     => 'section_end_reading_speed',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_human_time',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Human Time Format', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'human_time',
					'title'    => esc_html__( 'Display Human Time (Ago)', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the human time format ("ago") for the data post entry meta.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_human_time',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_edit_link',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Edit Post Link', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'edit_post_link',
					'title'    => esc_html__( 'Edit Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Display the edit post link for the logged users on the featured image.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'     => 'section_end_edit_link',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_meta_custom' ) ) {
	/**
	 * @return array
	 * post entry meta
	 */
	function foxiz_register_options_design_meta_custom() {

		return array(
			'id'         => 'foxiz_config_section_meta_custom',
			'title'      => esc_html__( 'Custom Entry Meta', 'foxiz' ),
			'desc'       => esc_html__( 'Setup your custom meta to display in the post listing and single post page.', 'foxiz' ),
			'icon'       => 'el el-asterisk',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'meta_custom_text',
					'title'    => esc_html__( 'Meta Label', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the label for this meta.', 'foxiz' ),
					'type'     => 'text',
					'default'  => '',
				),
				array(
					'id'          => 'meta_custom_icon',
					'title'       => esc_html__( 'Meta Icon ClassName', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input your custom CSS icon classname to display at the beginning of the meta.', 'foxiz' ),
					'description' => esc_html__( 'If you use font Awesome. ensure that the setting in "Theme Design > Font Awesome" is enabled.', 'foxiz' ),
					'type'        => 'text',
					'placeholder' => 'rbi-time',
					'default'     => '',
				),
				array(
					'id'       => 'meta_custom_pos',
					'type'     => 'select',
					'title'    => esc_html__( 'Meta Label Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select position for the custom meta label at the beginning or end.', 'foxiz' ),
					'options'  => array(
						'begin' => esc_html__( 'Prefix', 'foxiz' ),
						'end'   => esc_html__( 'Suffix', 'foxiz' )
					),
					'default'  => 'end'
				),
				array(
					'id'       => 'meta_custom_fallback',
					'type'     => 'select',
					'title'    => esc_html__( 'Fallback Meta', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a fallback meta for displaying when if the post does not have custom meta value.', 'foxiz' ),
					'options'  => array(
						'author'   => esc_html__( 'author (Author)', 'foxiz' ),
						'date'     => esc_html__( 'date (Publish Date)', 'foxiz' ),
						'category' => esc_html__( 'category (Categories)', 'foxiz' ),
						'tag'      => esc_html__( 'tag (Tags)', 'foxiz' ),
						'view'     => esc_html__( 'view (Post Views)', 'foxiz' ),
						'comment'  => esc_html__( 'comment (Comments)', 'foxiz' ),
						'update'   => esc_html__( 'update  (Last Updated)', 'foxiz' ),
						'read'     => esc_html__( 'read (Reading Time)', 'foxiz' ),
						'0'        => esc_html__( 'None', 'foxiz' ),
					),
					'default'  => 'date'
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_featured' ) ) {
	/**
	 * @return array
	 * featured image
	 */
	function foxiz_register_options_design_featured() {

		return array(
			'id'         => 'foxiz_config_section_featured_image',
			'title'      => esc_html__( 'Featured Image', 'foxiz' ),
			'icon'       => 'el el-picture',
			'desc'       => esc_html__( 'Select settings for the post featured image on your website.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'section_start_lazy_load',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'General Settings', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'Run regenerate thumbnail if you add/remove crop sizes. Please read documentation for further information.', 'foxiz' ),
						esc_html__( 'Assigning correct size for layouts is important for the look and give the best performance of your website..', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'       => 'crop_position',
					'type'     => 'select',
					'title'    => esc_html__( 'Crop Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select position to crop the featured image.', 'foxiz' ),
					'desc'     => esc_html__( 'Recommended select the top position if you have people images.', 'foxiz' ),
					'options'  => array(
						'top'    => esc_html__( 'From The Top', 'foxiz' ),
						'center' => esc_html__( 'From The Center', 'foxiz' )
					),
					'default'  => 'top'
				),
				array(
					'id'         => 'featured_crop_sizes',
					'type'       => 'multi_text',
					'class'      => 'medium-text',
					'show_empty' => false,
					'title'      => esc_html__( 'Define Custom Crop Sizes', 'foxiz' ),
					'label'      => esc_html__( 'Add a Crop Size', 'foxiz' ),
					'subtitle'   => esc_html__( 'This option will help you optimize the site speed or increase image quality on your website.', 'foxiz' ),
					'desc'       => esc_html__( 'Input a custom crop size: width x height. For example: 300x200', 'foxiz' ),
					'add_text'   => esc_html__( 'Create a New Crop Size', 'foxiz' ),
					'default'    => array(),
				),
				array(
					'id'       => 'edit_link',
					'type'     => 'switch',
					'title'    => esc_html__( 'Edit Post Link', 'foxiz' ),
					'subtitle' => esc_html__( 'Show the edit post link in the featured image for logged users.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_lazy_load',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'       => 'section_start_feat_size',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Default Crop Size Settings', 'foxiz' ),
					'subtitle' => array(
						esc_html__( 'WordPress will crop uploaded images to ensure your website use the best image size for the blog layouts.', 'foxiz' ),
						esc_html__( 'Below is the list of image sizes. Enable or disable any size you would like.', 'foxiz' ),
					),
					'indent'   => true
				),
				array(
					'id'       => 'foxiz_crop_g1',
					'type'     => 'switch',
					'title'    => esc_html__( 'G1- 330x220', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this image crop size.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'foxiz_crop_g2',
					'type'     => 'switch',
					'title'    => esc_html__( 'G2 - 420x280', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this image crop size.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'foxiz_crop_g3',
					'type'     => 'switch',
					'title'    => esc_html__( 'G3 - 615x410', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this image crop size.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'foxiz_crop_o1',
					'type'     => 'switch',
					'title'    => esc_html__( 'Original Ratio - 860x0', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this image crop size.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'foxiz_crop_o2',
					'type'     => 'switch',
					'title'    => esc_html__( 'Original Ratio - 1536x0', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable this image crop size.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_feat_size',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_slider' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_design_slider() {

		return array(
			'id'         => 'foxiz_config_section_slider',
			'title'      => esc_html__( 'Slider Animation', 'foxiz' ),
			'desc'       => esc_html__( 'Select settings for post sliders on your website.', 'foxiz' ),
			'icon'       => 'el el-resize-horizontal',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'slider_play',
					'type'     => 'switch',
					'title'    => esc_html__( 'Auto Play Next Slides', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable autoplay for the sliders.', 'foxiz' ),
					'switch'   => true,
					'default'  => '1'
				),
				array(
					'id'       => 'slider_speed',
					'type'     => 'text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Auto Play Speed', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a custom time value to next a slide in milliseconds (default is 5000).', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'slider_effect',
					'type'     => 'select',
					'title'    => esc_html__( 'Slide Effect', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a effect for the sliders. This setting will be not available for the carousel mode.', 'foxiz' ),
					'options'  => array(
						'0' => esc_html__( 'Slide', 'foxiz' ),
						'1' => esc_html__( 'Fade', 'foxiz' ),
					),
					'default'  => '0'
				),
				array(
					'id'       => 'slider_fmode',
					'type'     => 'switch',
					'title'    => esc_html__( 'Carousel Free Scroll', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable free mode when scrolling on the carousels.', 'foxiz' ),
					'default'  => true
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_format' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_design_format() {

		return array(
			'id'         => 'foxiz_config_section_post_format',
			'title'      => esc_html__( 'Post Format Icons', 'foxiz' ),
			'desc'       => esc_html__( 'Select settings for your post entry meta.', 'foxiz' ),
			'icon'       => 'el el-record',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'post_icon_video',
					'title'    => esc_html__( 'Video Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable icon for the video post format.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'       => 'post_icon_gallery',
					'title'    => esc_html__( 'Gallery Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable icon for the gallery post format.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => '0'
				),
				array(
					'id'       => 'post_icon_audio',
					'title'    => esc_html__( 'Audio Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable icon for the audio post format.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => '0'
				),
				array(
					'id'          => 'icon_video_color',
					'title'       => esc_html__( 'Video Icon Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the video icon. This setting will not apply to bottom right layout', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),

				array(
					'id'          => 'icon_gallery_color',
					'title'       => esc_html__( 'Gallery Icon Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the gallery icon. This setting will not apply to bottom right layout', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'icon_audio_color',
					'title'       => esc_html__( 'Audio Icon Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the audio icon. This setting will not apply to bottom right layout.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_readmore' ) ) {
	/**
	 * @return array
	 * read more settings
	 */
	function foxiz_register_options_design_readmore() {

		return array(
			'id'         => 'foxiz_config_section_readmore',
			'title'      => esc_html__( 'Read More Button', 'foxiz' ),
			'desc'       => esc_html__( 'Select settings for the read more button on your website. You can enable/disable this part per module via Modules Design section.', 'foxiz' ),
			'icon'       => 'el el-arrow-right',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'readmore_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Read More Label', 'foxiz' ),
					'subtitle' => esc_html__( 'Input the read more label to display on your website. Default is "Read More".', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'readmore_icon',
					'title'    => esc_html__( 'Read More Icon', 'foxiz' ),
					'subtitle' => esc_html__( 'Show a icon after the read more label.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => 1
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_hover' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_design_hover() {

		return array(
			'id'         => 'foxiz_config_section_design_hover',
			'title'      => esc_html__( 'Hover Effects', 'foxiz' ),
			'icon'       => 'el el-hand-up',
			'desc'       => esc_html__( 'Select hover effect settings for your website.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'hover_effect',
					'title'    => esc_html__( 'Link Hover Effect', 'foxiz' ),
					'subtitle' => esc_html__( 'The setting below applies to the post title and hyperlinks.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'1' => esc_html__( '- Default -', 'foxiz' ),
						'2' => esc_html__( 'Style 2', 'foxiz' ),
						'3' => esc_html__( 'Style 3', 'foxiz' ),
						'4' => esc_html__( 'Style 4', 'foxiz' ),
						'5' => esc_html__( 'Style 5', 'foxiz' ),
						'6' => esc_html__( 'Style 6', 'foxiz' ),
						'7' => esc_html__( 'Style 7', 'foxiz' ),
						'8' => esc_html__( 'Style 8', 'foxiz' )
					),
					'default'  => '1',
				),
				array(
					'id'       => 'menu_hover_effect',
					'type'     => 'select',
					'title'    => esc_html__( 'Menu Hover Effect', 'foxiz' ),
					'subtitle' => esc_html__( 'The setting below applies to top level menu items.', 'foxiz' ),
					'options'  => array(
						'1' => esc_html__( '- Default -', 'foxiz' ),
						'2' => esc_html__( 'Style 2 (Opacity)', 'foxiz' )
					),
					'default'  => 1
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_svg' ) ) {
	/**
	 * @return array
	 * font icons settings
	 */
	function foxiz_register_options_design_svg() {

		return array(
			'id'         => 'foxiz_config_section_svg_supported',
			'title'      => esc_html__( 'SVG Upload', 'foxiz' ),
			'icon'       => 'el el-upload',
			'desc'       => esc_html__( 'Please ensure that you are using trusted svg sources to avoid XML vulnerabilities.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'svg_supported',
					'title'    => esc_html__( 'SVG Supported', 'foxiz' ),
					'subtitle' => esc_html__( 'Support upload file type SVG for your website.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => true
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_gif' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_design_gif() {

		return array(
			'id'         => 'foxiz_config_section_gif_supported',
			'title'      => esc_html__( 'Featured GIF', 'foxiz' ),
			'icon'       => 'el el-photo',
			'desc'       => esc_html__( 'Prevent WordPress convert gif to a static image when uploading.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'gif_supported',
					'type'     => 'switch',
					'title'    => esc_html__( 'GIF Supported', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable GIF supported for your website.', 'foxiz' ),
					'default'  => 1
				),
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_border' ) ) {
	/**
	 * @return array
	 * font icons settings
	 */
	function foxiz_register_options_design_border() {

		return array(
			'id'         => 'foxiz_config_section_design_border',
			'title'      => esc_html__( 'Round Corner', 'foxiz' ),
			'icon'       => 'el el-record',
			'desc'       => esc_html__( 'The small border style in featured images and other element whole the website.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'design_border',
					'title'    => esc_html__( 'Round Corner', 'foxiz' ),
					'subtitle' => esc_html__( 'Disable round corner style for whole the website.', 'foxiz' ),
					'type'     => 'select',
					'options'  => array(
						'0'    => esc_html__( 'Default', 'foxiz' ),
						'none' => esc_html__( 'No Border', 'foxiz' )
					),
					'default'  => '0',
				),
				array(
					'id'          => 'custom_border',
					'class'       => 'small-text',
					'type'        => 'text',
					'title'       => esc_html__( 'Custom Round Corner', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input a custom round corner (in px) for your website.', 'foxiz' ),
					'description' => esc_html__( 'The recommended value is 1 to 20. Leave blank to set it as the default.', 'foxiz' ),
					'default'     => ''
				)
			)
		);
	}
}

if ( ! function_exists( 'foxiz_register_options_design_icons' ) ) {
	/**
	 * @return array
	 * font icons settings
	 */
	function foxiz_register_options_design_icons() {

		return array(
			'id'         => 'foxiz_config_section_font_icons',
			'title'      => esc_html__( 'Font Awesome', 'foxiz' ),
			'icon'       => 'el el-fontsize',
			'desc'       => esc_html__( 'Load font Awesome icons library. Enabling this option may affect to the site performance.', 'foxiz' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'font_awesome',
					'title'    => esc_html__( 'Load Font Awesome', 'foxiz' ),
					'subtitle' => esc_html__( 'Load font Awesome icons library to your website. This will help you can embed this font icons to your widgets and content.', 'foxiz' ),
					'type'     => 'switch',
					'default'  => '0',
				)
			)
		);
	}
}