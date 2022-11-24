<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_Register_Metaboxes', false ) ) {
	/**
	 * Class FOXIZ_CORE
	 * load plugin
	 */
	class Foxiz_Register_Metaboxes {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_filter( 'rb_meta_boxes', array( $this, 'register' ) );
		}

		function register( $metaboxes = array() ) {

			$metaboxes[] = $this->single_post_metaboxes();
			$metaboxes[] = $this->page_metaboxes();

			return $metaboxes;
		}

		public function page_metaboxes() {

			return array(
				'id'         => 'foxiz_page_settings',
				'title'      => esc_html__( 'Single Page Settings', 'foxiz' ),
				'desc'       => esc_html__( 'Options below will apply to the single page and Elementor page. To config for the blog page, navigate to Theme Options > Blog & Achives.', 'foxiz' ),
				'context'    => 'normal',
				'post_types' => array( 'page' ),
				'tabs'       => array(
					array(
						'id'     => 'section-page-general',
						'title'  => esc_html__( 'General Settings', 'foxiz' ),
						'icon'   => 'dashicons-align-full-width',
						'fields' => array(
							array(
								'id'      => 'page_header_style',
								'name'    => esc_html__( 'Page Header Style', 'foxiz' ),
								'desc'    => esc_html__( 'Select a top header style for this page. This option is used for the single page (not Elementor page).', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Style 1', 'foxiz' ),
									'2'       => esc_html__( 'Style 2', 'foxiz' ),
									'-1'      => esc_html__( 'No Header', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'width_wo_sb',
								'name'    => esc_html__( 'Max Width Content without Sidebar', 'foxiz' ),
								'desc'    => esc_html__( 'Select a max-width for the content area without sidebar.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'small'   => esc_html__( 'Small - 860px', 'foxiz' ),
									'-1'      => esc_html__( 'Full Width', 'foxiz' )
								),
								'default' => 'default'
							),
						)
					),
					array(
						'id'     => 'section-sidebar',
						'title'  => esc_html__( 'Sidebar Area', 'foxiz' ),
						'icon'   => 'dashicons-align-pull-right',
						'fields' => array(
							array(
								'id'      => 'sidebar_position',
								'name'    => esc_html__( 'Sidebar Position', 'foxiz' ),
								'desc'    => esc_html__( 'Select a position for the sidebar of this page. It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'class'   => 'sidebar-select',
								'type'    => 'image_select',
								'options' => foxiz_config_sidebar_position( true, true ),
								'default' => 'default'
							),
							array(
								'id'      => 'sidebar_name',
								'name'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
								'desc'    => esc_html__( 'Assign a sidebar for this page. It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'type'    => 'select',
								'options' => foxiz_config_sidebar_name(),
								'default' => 'default'
							),
						)
					),
					array(
						'id'     => 'section-header',
						'title'  => esc_html__( 'Site Header', 'foxiz' ),
						'icon'   => 'dashicons-heading',
						'desc'   => esc_html__( 'The transparent headers is only suitable with the page has a sliders or wide image at the top.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'header_style',
								'name'    => esc_html__( 'Site Header', 'foxiz' ),
								'desc'    => esc_html__( 'Select a site header style for this page', 'foxiz' ),
								'type'    => 'select',
								'options' => foxiz_config_header_style( true, true, false, true ),
								'default' => '0'
							),
							array(
								'id'      => 'header_template',
								'name'    => esc_html__( 'Header Template Shortcode', 'foxiz' ),
								'desc'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header for this page. Leave this option blank to set as the above setting.', 'foxiz' ),
								'type'    => 'textarea',
								'default' => ''
							),
							array(
								'id'      => 'nav_style',
								'type'    => 'select',
								'name'    => esc_html__( 'Navigation Bar Style', 'foxiz' ),
								'desc'    => esc_html__( 'Select navigation bar style for the header of this page. This setting will only apply to predefined header styles.', 'foxiz' ),
								'options' => array(
									'default'  => esc_html__( '- Default -', 'foxiz' ),
									'shadow'   => esc_html__( 'Shadow', 'foxiz' ),
									'border'   => esc_html__( 'Bottom Border', 'foxiz' ),
									'd-border' => esc_html__( 'Dark Bottom Border', 'foxiz' ),
									'none'     => esc_html__( 'None', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'disable_top_ad',
								'name'    => esc_html__( 'Top Site Advert', 'foxiz' ),
								'desc'    => esc_html__( 'Disable the top ad site for this page.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( 'Default', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'alert_bar',
								'name'    => esc_html__( 'Header Alert Bar', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the alert bar below the header.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( 'Default', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
						)
					),
					array(
						'id'     => 'section-footer',
						'title'  => esc_html__( 'Site Footer', 'foxiz' ),
						'icon'   => 'dashicons-align-full-width',
						'fields' => array(
							array(
								'id'      => 'footer_template',
								'name'    => esc_html__( 'Footer Template Shortcode', 'foxiz' ),
								'desc'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website footer for this page, Leave blank to set it as the default from the Theme Options panel.', 'foxiz' ),
								'type'    => 'textarea',
								'default' => ''
							)
						)
					)
				)
			);
		}

		public function single_post_metaboxes() {

			return array(
				'id'         => 'foxiz_post_options',
				'title'      => esc_html__( 'Post Options', 'foxiz' ),
				'context'    => 'normal',
				'post_types' => array( 'post' ),
				'tabs'       => array(
					array(
						'id'     => 'section-tagline',
						'title'  => esc_html__( 'Tagline & Highlights', 'foxiz' ),
						'icon'   => 'dashicons-edit-large',
						'fields' => array(
							array(
								'id'      => 'tagline',
								'name'    => esc_html__( 'Tagline', 'foxiz' ),
								'desc'    => esc_html__( 'Input a tagline for this post, It will display under the single post title.', 'foxiz' ),
								'type'    => 'textarea',
								'default' => ''
							),
							array(
								'id'     => 'highlights',
								'name'   => esc_html__( 'Post highlights', 'foxiz' ),
								'desc'   => esc_html__( 'Input highlights for this post. This section will appear a the top of content. To edit this section heading, Navigate to Theme Options > Single Post > Tagline & highlights', 'foxiz' ),
								'type'   => 'group',
								'button' => esc_html__( '+Add Highlight', 'foxiz' ),
								'fields' => array(
									array(
										'id'      => 'point',
										'name'    => esc_html__( 'Highlight Point', 'foxiz' ),
										'default' => '',
									),
								)
							),
							array(
								'id'      => 'tagline_tag',
								'name'    => esc_html__( 'Tagline HTML Tag', 'foxiz' ),
								'desc'    => esc_html__( 'Select a HTML tag for this tagline.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'0'    => esc_html__( '- Default -', 'foxiz' ),
									'h2'   => esc_html__( 'H2', 'foxiz' ),
									'h3'   => esc_html__( 'H3', 'foxiz' ),
									'h4'   => esc_html__( 'H4', 'foxiz' ),
									'h5'   => esc_html__( 'H5', 'foxiz' ),
									'h6'   => esc_html__( 'H6', 'foxiz' ),
									'p'    => esc_html__( 'p', 'foxiz' ),
									'span' => esc_html__( 'span', 'foxiz' )
								),
								'default' => '0'
							)
						)
					),
					array(
						'id'     => 'section-featured',
						'title'  => esc_html__( 'Featured Image', 'foxiz' ),
						'icon'   => 'dashicons-format-image',
						'fields' => array(
							array(
								'id'      => 'featured_crop_size',
								'name'    => esc_html__( 'Featured Crop Size', 'foxiz' ),
								'desc'    => esc_html__( 'Select a custom crop size for the featured image or gallery images.', 'foxiz' ),
								'type'    => 'select',
								'options' => foxiz_config_crop_size(),
								'default' => 'default'
							),
							array(
								'id'      => 'featured_caption',
								'name'    => esc_html__( 'Featured Caption', 'foxiz' ),
								'desc'    => esc_html__( 'Input caption text for the featured image.', 'foxiz' ),
								'type'    => 'textarea',
								'default' => ''
							),
							array(
								'id'      => 'featured_attribution',
								'name'    => esc_html__( 'Attribution', 'foxiz' ),
								'desc'    => esc_html__( 'Input an attribution for the featured image.', 'foxiz' ),
								'type'    => 'text',
								'default' => ''
							)
						)
					),
					array(
						'id'     => 'section-category',
						'title'  => esc_html__( 'Primary Category', 'foxiz' ),
						'icon'   => 'dashicons-admin-network',
						'fields' => array(
							array(
								'name'        => esc_html__( 'Select Primary Category', 'foxiz' ),
								'id'          => 'primary_category',
								'type'        => 'category_select',
								'taxonomy'    => 'category',
								'placeholder' => esc_html__( 'Select a Primary Category for this post.', 'foxiz' ),
								'desc'        => esc_html__( 'It is useful in case this post has a lot of categories and you want to display only one in listings.', 'foxiz' ),
								'default'     => ''
							),
						)
					),
					array(
						'id'     => 'section-custom-meta',
						'title'  => esc_html__( 'Custom Entry Meta', 'foxiz' ),
						'desc'   => esc_html__( 'This option is useful in case you would like to create a custom entry meta.', 'foxiz' ),
						'icon'   => 'dashicons-plus-alt',
						'fields' => array(
							array(
								'id'      => 'meta_custom',
								'name'    => esc_html__( 'Custom Entry Meta', 'foxiz' ),
								'desc'    => esc_html__( 'Input value or text for the custom meta that you created in Theme Options panel.', 'foxiz' ),
								'type'    => 'text',
								'default' => ''
							),
						)
					),
					array(
						'id'     => 'section-standard',
						'title'  => esc_html__( 'Standard Format', 'foxiz' ),
						'icon'   => 'dashicons-menu-alt',
						'desc'   => esc_html__( 'The settings below apply to the standard post format. Using the corresponding panel if you select another post format for this post.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'layout',
								'name'    => esc_html__( 'Standard Layout', 'foxiz' ),
								'desc'    => esc_html__( 'Select a standard layout for this post, It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'type'    => 'image_select',
								'class'   => 'big',
								'options' => foxiz_config_single_standard_layouts(),
								'default' => 'default'
							),
						)
					),
					/** post video */
					array(
						'id'     => 'section-video',
						'title'  => esc_html__( 'Video Format', 'foxiz' ),
						'icon'   => 'dashicons-format-video',
						'desc'   => esc_html__( 'Please ensure that the "Video" option is chosen under "Post Format" selection box when you use this panel.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'video_layout',
								'name'    => esc_html__( 'Video Layout', 'foxiz' ),
								'desc'    => esc_html__( 'Select a video layout for this post, It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'type'    => 'image_select',
								'class'   => 'big',
								'options' => foxiz_config_single_video_layouts(),
								'default' => 'default'
							),
							array(
								'id'      => 'video_url',
								'name'    => esc_html__( 'Video URL', 'foxiz' ),
								'desc'    => esc_html__( 'Input your video link, support: Youtube, Vimeo, DailyMotion.', 'foxiz' ),
								'type'    => 'text',
								'default' => ''
							),
							array(
								'id'   => 'video_preview',
								'name' => esc_html__( 'Preview Video', 'foxiz' ),
								'desc' => esc_html__( 'Upload your preview video. Keep video short and lightweight as possible to save server bandwidth.', 'foxiz' ),
								'type' => 'file'
							),
							array(
								'id'   => 'video_embed',
								'name' => esc_html__( 'Iframe Embed Code', 'foxiz' ),
								'desc' => esc_html__( 'Input iframe embed code if WordPress cannot support your video URL.', 'foxiz' ),
								'type' => 'textarea'
							),
							array(
								'id'   => 'video_hosted',
								'name' => esc_html__( 'Self-Hosted Video', 'foxiz' ),
								'desc' => esc_html__( 'Upload your video file, support: mp4, m4v, webm, ogv, wmv, flv files.', 'foxiz' ),
								'type' => 'file'
							),
							array(
								'id'      => 'video_autoplay',
								'name'    => esc_html__( 'Autoplay Video', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable autoplay video for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
						)
					),
					/** post audio */
					array(
						'id'     => 'section-audio',
						'title'  => esc_html__( 'Audio Format', 'foxiz' ),
						'icon'   => 'dashicons-format-audio',
						'desc'   => esc_html__( 'Please ensure that the "Audio" option is chosen under "Post Format" selection box when you use this panel.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'audio_layout',
								'name'    => esc_html__( 'Audio Layout', 'foxiz' ),
								'desc'    => esc_html__( 'Select a audio layout for this post, It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'type'    => 'image_select',
								'class'   => 'big',
								'options' => foxiz_config_single_audio_layouts(),
								'default' => 'default'
							),
							array(
								'id'   => 'audio_url',
								'name' => esc_html__( 'Audio URL', 'foxiz' ),
								'desc' => esc_html__( 'Input your audio URL, support: SoundCloud, MixCloud. Do not forget to check "Audio" in Post Format section.', 'foxiz' ),
								'type' => 'text'
							),
							array(
								'id'   => 'audio_embed',
								'name' => esc_html__( 'Iframe Embed Code', 'foxiz' ),
								'desc' => esc_html__( 'Input iframe embed code if WordPress cannot support your audio URL.', 'foxiz' ),
								'type' => 'textarea'
							),
							array(
								'id'   => 'audio_hosted',
								'name' => esc_html__( 'Self-Hosted Audio', 'foxiz' ),
								'desc' => esc_html__( 'Upload your audio file, support: mp3, ogg, wma, m4a, wav files.', 'foxiz' ),
								'type' => 'file'
							),
							array(
								'id'      => 'audio_autoplay',
								'name'    => esc_html__( 'Autoplay Audio', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable autoplay audio for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
						)
					),
					array(
						'id'     => 'section-gallery',
						'title'  => esc_html__( 'Gallery Format', 'foxiz' ),
						'icon'   => 'dashicons-format-gallery',
						'desc'   => esc_html__( 'Please ensure that the "Gallery" option is chosen under "Post Format" selection box when you use this panel.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'gallery_layout',
								'name'    => esc_html__( 'Gallery Layout', 'foxiz' ),
								'desc'    => esc_html__( 'Select a gallery layout for this post, It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'type'    => 'image_select',
								'class'   => 'big',
								'options' => foxiz_config_single_gallery_layouts(),
								'default' => 'default'
							),
							array(
								'id'      => 'gallery_data',
								'name'    => esc_html__( 'Upload Gallery', 'foxiz' ),
								'desc'    => esc_html__( 'Upload your images for this gallery.', 'foxiz' ),
								'type'    => 'images',
								'default' => ''
							),
						)
					),
					array(
						'id'     => 'section-sidebar',
						'title'  => esc_html__( 'Sidebar Area', 'foxiz' ),
						'icon'   => 'dashicons-align-pull-right',
						'fields' => array(
							array(
								'id'      => 'sidebar_position',
								'name'    => esc_html__( 'Sidebar Position', 'foxiz' ),
								'desc'    => esc_html__( 'Select a position for the sidebar of this post. It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'class'   => 'sidebar-select',
								'type'    => 'image_select',
								'options' => foxiz_config_sidebar_position(),
								'default' => 'default'
							),
							array(
								'id'      => 'sidebar_name',
								'name'    => esc_html__( 'Assign a Sidebar', 'foxiz' ),
								'desc'    => esc_html__( 'Assign a sidebar for this post. It will override on the default settings in the Theme Options panel.', 'foxiz' ),
								'type'    => 'select',
								'options' => foxiz_config_sidebar_name(),
								'default' => 'default'
							),
						)
					),
					array(
						'id'     => 'section-review',
						'title'  => esc_html__( 'Review', 'foxiz' ),
						'icon'   => 'dashicons-star-filled',
						'desc'   => esc_html__( 'The box will appear at the bottom. Use shortcode [ruby_review_box] and input it to the post content if you would like to set the review box position.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'review',
								'name'    => esc_html__( 'Post Review', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the review feature for this post.', 'foxiz' ),
								'type'    => 'select',
								'class'   => 'ruby-review-checkbox',
								'options' => array(
									'-1' => esc_html__( '- Disable -', 'foxiz' ),
									'1'  => esc_html__( 'Enable', 'foxiz' )
								),
								'default' => '-1'
							),
							array(
								'id'      => 'user_can_review',
								'name'    => esc_html__( 'User Rating in Comments', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable visitors can rate and review this post in the comment box.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' ),
									'1'       => esc_html__( 'Enable with Review', 'foxiz' ),
									'2'       => esc_html__( 'Force Enable for This Post', 'foxiz' ),
								),
								'default' => 'default'
							),
							array(
								'id'      => 'review_title',
								'name'    => esc_html__( 'Review Title', 'foxiz' ),
								'desc'    => esc_html__( 'Input a title for this review section.', 'foxiz' ),
								'type'    => 'text',
								'default' => esc_html__( 'Review Overview', 'foxiz' )
							),
							array(
								'id'      => 'review_type',
								'name'    => esc_html__( 'Review Type', 'foxiz' ),
								'desc'    => esc_html__( 'Select a type of review for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'star'    => esc_html__( 'Stars (1 > 5)', 'foxiz' ),
									'score'   => esc_html__( 'Score (1 > 10)', 'foxiz' ),
								),
								'default' => 'default'
							),
							array(
								'id'     => 'review_criteria',
								'name'   => esc_html__( 'Add Criteria', 'foxiz' ),
								'desc'   => esc_html__( 'Create your review criteria based on the type you choose.', 'foxiz' ),
								'type'   => 'group',
								'button' => '+ Add Criteria',
								'fields' => array(
									array(
										'name'    => esc_html__( 'Item Label', 'foxiz' ),
										'id'      => 'label',
										'default' => esc_html__( 'Criteria', 'foxiz' ),
									),
									array(
										'name'    => esc_html__( 'Score (1 > 10) or Rating (1 > 5)', 'foxiz' ),
										'id'      => 'rating',
										'default' => '',
									)
								)
							),
							array(
								'id'   => 'review_image',
								'name' => esc_html__( 'Review Image', 'foxiz' ),
								'desc' => esc_html__( 'Upload a background header image for this review section.', 'foxiz' ),
								'type' => 'file'
							),
							array(
								'id'   => 'review_meta',
								'name' => esc_html__( 'Meta Description', 'foxiz' ),
								'desc' => esc_html__( 'Input a short description to display before the review score, For example: Good, Bad...', 'foxiz' ),
								'type' => 'text'
							),
							array(
								'id'     => 'review_pros',
								'name'   => esc_html__( 'Advantages', 'foxiz' ),
								'desc'   => esc_html__( 'Input advantages for this review.', 'foxiz' ),
								'type'   => 'group',
								'button' => '+ Add Pros',
								'fields' => array(
									array(
										'name'    => esc_html__( 'Item', 'foxiz' ),
										'id'      => 'pros_item',
										'default' => esc_html__( 'advantage item', 'foxiz' ),
									)
								)
							),
							array(
								'id'     => 'review_cons',
								'name'   => esc_html__( 'Disadvantages', 'foxiz' ),
								'desc'   => esc_html__( 'Input disadvantages for this review.', 'foxiz' ),
								'type'   => 'group',
								'button' => '+ Add Cons',
								'fields' => array(
									array(
										'name'    => esc_html__( 'Item', 'foxiz' ),
										'id'      => 'cons_item',
										'default' => esc_html__( 'disadvantage item', 'foxiz' ),
									)
								)
							),
							array(
								'id'   => 'review_summary',
								'name' => esc_html__( 'Final Summary', 'foxiz' ),
								'desc' => esc_html__( 'Input final summary for this review.', 'foxiz' ),
								'type' => 'textarea'
							),
							array(
								'id'   => 'review_button',
								'name' => esc_html__( 'Offer Label', 'foxiz' ),
								'desc' => esc_html__( 'Input a offer label (Call to action) for this product review.', 'foxiz' ),
								'type' => 'text'
							),
							array(
								'id'   => 'review_destination',
								'name' => esc_html__( 'Offer Destination URL', 'foxiz' ),
								'desc' => esc_html__( 'Input the destination URL of the offer.', 'foxiz' ),
								'type' => 'text'
							),
							array(
								'id'   => 'review_price',
								'name' => esc_html__( 'Price Offer', 'foxiz' ),
								'desc' => esc_html__( 'Input the price of the offer.', 'foxiz' ),
								'type' => 'text'
							),
							array(
								'id'   => 'review_currency',
								'name' => esc_html__( 'Currency', 'foxiz' ),
								'desc' => esc_html__( 'Input the currency of the price.', 'foxiz' ),
								'type' => 'text'
							)
						)
					),
					array(
						'id'     => 'section-sponsor',
						'title'  => esc_html__( 'Sponsored Post', 'foxiz' ),
						'icon'   => 'dashicons-bell',
						'fields' => array(
							array(
								'id'      => 'sponsor_post',
								'name'    => esc_html__( 'Sponsored Post', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable sponsored content for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'-1' => esc_html__( '- Disable -', 'foxiz' ),
									'1'  => esc_html__( 'Enable', 'foxiz' )
								),
								'default' => '-1'
							),
							array(
								'id'      => 'sponsor_url',
								'name'    => esc_html__( 'Sponsor URL', 'foxiz' ),
								'desc'    => esc_html__( 'Input the sponsor website URL.', 'foxiz' ),
								'type'    => 'text',
								'default' => ''
							),
							array(
								'id'      => 'sponsor_name',
								'name'    => esc_html__( 'Sponsor Name', 'foxiz' ),
								'desc'    => esc_html__( 'Input the sponsor brand name for this post', 'foxiz' ),
								'type'    => 'text',
								'default' => ''
							),
							array(
								'id'   => 'sponsor_logo',
								'name' => esc_html__( 'Sponsor Logo', 'foxiz' ),
								'desc' => esc_html__( 'Upload the sponsor logo for this post, recommended height for the logo is 52px.', 'foxiz' ),
								'type' => 'file'
							),
							array(
								'id'   => 'sponsor_logo_light',
								'name' => esc_html__( 'Sponsor Light Logo', 'foxiz' ),
								'desc' => esc_html__( 'Upload the sponsor light logo for this post, recommended height for the logo is 52px.', 'foxiz' ),
								'type' => 'file'
							),
							array(
								'id'      => 'sponsor_redirect',
								'name'    => esc_html__( 'Directly Redirect', 'foxiz' ),
								'desc'    => esc_html__( 'Directly redirect to the sponsor website when clicking on the post listing title.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' )
								),
								'default' => 'default'
							)
						)
					),
					array(
						'id'     => 'section-shares',
						'title'  => 'Fake Post Views',
						'icon'   => 'dashicons-visibility',
						'fields' => array(
							array(
								'id'      => 'start_view',
								'name'    => esc_html__( 'Fake View Value', 'foxiz' ),
								'desc'    => esc_html__( 'Input a starting view value for this post. Leave blank if you want to display real data.', 'foxiz' ),
								'type'    => 'text',
								'default' => ''
							),
						)
					),
					array(
						'id'     => 'section-widget',
						'title'  => esc_html__( 'Entry Widgets', 'foxiz' ),
						'icon'   => 'dashicons-editor-insertmore',
						'fields' => array(
							array(
								'id'      => 'entry_top',
								'name'    => esc_html__( 'Top Entry Widgets Area', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the top entry widgets for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'1'  => esc_html__( 'Enable', 'foxiz' ),
									'-1' => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => '1'
							),
							array(
								'id'      => 'entry_bottom',
								'name'    => esc_html__( 'Bottom Entry Widgets Area', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the bottom entry widgets for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'1'  => esc_html__( 'Enable', 'foxiz' ),
									'-1' => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => '1'
							),
						)
					),
					array(
						'id'     => 'section-toc',
						'title'  => esc_html__( 'Table of Content', 'foxiz' ),
						'icon'   => 'dashicons-editor-ol',
						'fields' => array(
							array(
								'id'      => 'table_contents_post',
								'name'    => esc_html__( 'Table of Contents', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the table content for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'table_contents_layout',
								'name'    => esc_html__( 'layout', 'foxiz' ),
								'desc'    => esc_html__( 'Select a layout for the table of contents of this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Full Width (2 Columns)', 'foxiz' ),
									'2'       => esc_html__( 'Half Width', 'foxiz' ),
									'3'       => esc_html__( 'Full Width (1 Column)', 'foxiz' ),
								),
								'default' => 'default'
							),
							array(
								'id'      => 'table_contents_position',
								'type'    => 'text',
								'name'    => esc_html__( 'Display Position', 'foxiz' ),
								'desc'    => esc_html__( 'Input a position (after x paragraphs) to display the table of contents box. Leave blank to use the theme option setting, Set "-1" for displaying at the top.', 'foxiz' ),
								'default' => ''
							),
						),
					),
					array(
						'id'     => 'section-pages-selected',
						'title'  => esc_html__( 'Break Page Selection', 'foxiz' ),
						'desc'   => esc_html__( 'Display page selected section when you use break pages for a lengthy content post.', 'foxiz' ),
						'icon'   => 'dashicons-admin-page',
						'fields' => array(
							array(
								'id'     => 'page_selected',
								'name'   => esc_html__( 'Headings Table', 'foxiz' ),
								'desc'   => esc_html__( 'Input the heading for each page corresponding to the page break tags. Please input all headings for pages to show the section.', 'foxiz' ),
								'type'   => 'group',
								'button' => esc_html__( '+Add Heading', 'foxiz' ),
								'fields' => array(
									array(
										'id'      => 'title',
										'name'    => esc_html__( 'Input Heading', 'foxiz' ),
										'default' => '',
									),
								)
							),
						)
					),
					array(
						'id'     => 'section-via',
						'title'  => esc_html__( 'Sources/Via', 'foxiz' ),
						'icon'   => 'dashicons-paperclip',
						'fields' => array(
							array(
								'id'     => 'source_data',
								'name'   => esc_html__( 'Post Sources', 'foxiz' ),
								'desc'   => esc_html__( 'Input the post source if it has, it will display at the bottom of post content', 'foxiz' ),
								'type'   => 'group',
								'class'  => 'small-item',
								'button' => esc_html__( '+Add Post Source', 'foxiz' ),
								'fields' => array(
									array(
										'name'    => esc_html__( 'Source Name', 'foxiz' ),
										'id'      => 'name',
										'default' => '',
									),
									array(
										'name'    => esc_html__( 'Source URL', 'foxiz' ),
										'id'      => 'url',
										'default' => '',
									)

								)
							),
							array(
								'id'     => 'via_data',
								'name'   => esc_html__( 'Post Via', 'foxiz' ),
								'desc'   => esc_html__( 'Input the post via if it has, it will display at the bottom of post content', 'foxiz' ),
								'type'   => 'group',
								'class'  => 'small-item',
								'button' => esc_html__( '+Add Post Via', 'foxiz' ),
								'fields' => array(
									array(
										'name'    => esc_html__( 'Via Name', 'foxiz' ),
										'id'      => 'name',
										'default' => '',
									),
									array(
										'name'    => esc_html__( 'Via URL', 'foxiz' ),
										'id'      => 'url',
										'default' => '',
									)

								)
							)
						)
					),
					array(
						'id'     => 'section-ajax',
						'title'  => 'Auto Load Next Posts',
						'icon'   => 'dashicons-update',
						'fields' => array(
							array(
								'id'      => 'ajax_next_post',
								'name'    => esc_html__( 'Auto Load Next Posts', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable ajax load next posts for this post. This setting will override on the global setting.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							)
						)
					),
					array(
						'id'     => 'section-reaction',
						'title'  => 'Reaction',
						'icon'   => 'dashicons-heart',
						'fields' => array(
							array(
								'id'      => 'reaction',
								'name'    => esc_html__( 'User Reaction', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the reaction section at the end of this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							)
						)
					),
					array(
						'id'     => 'section-seo',
						'title'  => 'SEO Settings',
						'icon'   => 'dashicons-chart-area',
						'fields' => array(
							array(
								'id'      => 'article_markup',
								'name'    => esc_html__( 'Article Schema Markup', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable Schema markup for this article. Disable default schema markup for this post if you use a 3rd plugin to create another post type for example Recipe, Videos.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'review_markup',
								'name'    => esc_html__( 'Review Schema Markup', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable review markup for this review. This option is useful in case you are using 3rd party markup plugin.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( '- Default -', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
								),
								'default' => 'default'
							)
						)
					),
					array(
						'id'     => 'section-header',
						'title'  => 'Site Header',
						'icon'   => 'dashicons-heading',
						'desc'   => esc_html__( 'The transparent headers is only suitable for layouts: Standard 2, Standard 5, Video 2 and Audio 2.', 'foxiz' ),
						'fields' => array(
							array(
								'id'      => 'header_style',
								'name'    => esc_html__( 'Header Style', 'foxiz' ),
								'desc'    => esc_html__( 'Select a site header style for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => foxiz_config_header_style( true, true ),
								'default' => 'default'
							),
							array(
								'id'      => 'header_template',
								'name'    => esc_html__( 'Header Template Shortcode', 'foxiz' ),
								'desc'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website header for this page. This setting requests to select "Use Ruby Template" in site header setting in order to work.', 'foxiz' ),
								'type'    => 'textarea',
								'default' => ''
							),
							array(
								'id'      => 'nav_style',
								'type'    => 'select',
								'name'    => esc_html__( 'Navigation Bar Style', 'foxiz' ),
								'desc'    => esc_html__( 'Select navigation bar style for the header of this post.', 'foxiz' ),
								'options' => array(
									'default'  => esc_html__( '- Default -', 'foxiz' ),
									'shadow'   => esc_html__( 'Shadow', 'foxiz' ),
									'border'   => esc_html__( 'Bottom Border', 'foxiz' ),
									'd-border' => esc_html__( 'Dark Bottom Border', 'foxiz' ),
									'none'     => esc_html__( 'None', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'disable_top_ad',
								'name'    => esc_html__( 'Top Site Advert', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the top ad site for this post.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( 'Default', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
							array(
								'id'      => 'alert_bar',
								'name'    => esc_html__( 'Header Alert Bar', 'foxiz' ),
								'desc'    => esc_html__( 'Enable or disable the alert bar below the header.', 'foxiz' ),
								'type'    => 'select',
								'options' => array(
									'default' => esc_html__( 'Default', 'foxiz' ),
									'1'       => esc_html__( 'Enable', 'foxiz' ),
									'-1'      => esc_html__( 'Disable', 'foxiz' )
								),
								'default' => 'default'
							),
						)
					),
					array(
						'id'     => 'section-footer',
						'title'  => esc_html__( 'Site Footer', 'foxiz' ),
						'icon'   => 'dashicons-align-full-width',
						'fields' => array(
							array(
								'id'      => 'footer_template',
								'name'    => esc_html__( 'Footer Template Shortcode', 'foxiz' ),
								'desc'    => esc_html__( 'Input a Ruby Template shortcode for displaying as the website footer for this post, Leave blank to set it as the default from the Theme Options panel.', 'foxiz' ),
								'type'    => 'textarea',
								'default' => ''
							)
						)
					)
				)
			);
		}
	}
}