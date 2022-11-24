<?php

namespace foxizElementor;

/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	private static $instance = null;
	private $path;

	/** load elementor */
	public function __construct() {

		self::$instance = $this;

		if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
			return false;
		}

		$this->path = FOXIZ_CORE_PATH . 'elementor/';

		require_once $this->path . 'standard.php';
		require_once $this->path . 'templates.php';

		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ), 0 );
		add_action( 'elementor/element/section/section_background/after_section_end', 'foxiz_section_background_dark_mode', 10, 2 );
		add_action( 'elementor/element/section/section_structure/after_section_end', 'foxiz_section_header_sticky', 11, 2 );
		add_action( 'elementor/element/section/section_border/after_section_end', 'foxiz_section_border_dark_mode', 12, 2 );
		add_action( 'elementor/element/heading/section_title_style/after_section_end', 'foxiz_block_heading_dark_mode', 10, 2 );
		add_action( 'elementor/element/text-editor/section_style/after_section_end', 'foxiz_block_text_dark_mode', 10, 2 );
		add_action( 'elementor/element/button/section_style/after_section_end', 'foxiz_block_button_dark_mode', 10, 2 );
		add_action( 'elementor/element/divider/section_divider_style/after_section_end', 'foxiz_block_divider_dark_mode', 10, 2 );
		add_action( 'elementor/element/image-box/section_style_content/after_section_end', 'foxiz_block_image_dark_mode', 10, 2 );
		add_action( 'elementor/element/icon/section_style_icon/after_section_end', 'foxiz_block_icon_dark_mode', 10, 2 );
		add_action( 'elementor/element/icon-box/section_style_content/after_section_end', 'foxiz_block_icon_box_dark_mode', 10, 2 );
		add_action( 'elementor/element/icon-list/section_text_style/after_section_end', 'foxiz_block_icon_list_dark_mode', 10, 2 );
		add_action( 'elementor/element/common/_section_background/after_section_end', 'foxiz_widget_background_dark_mode', 10, 2 );
		add_action( 'elementor/element/common/_section_border/after_section_end', 'foxiz_widget_border_dark_mode', 11, 2 );
	}

	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @param $elements_manager
	 * register category
	 */
	public function register_categories( $elements_manager ) {

		$elements_manager->add_category( 'foxiz',
			array(
				'title' => esc_html__( 'Foxiz Blocks', 'foxiz-core' ),
				'icon'  => 'eicon-section',
			)
		);

		$elements_manager->add_category( 'foxiz_header',
			array(
				'title' => esc_html__( 'Foxiz Header', 'foxiz-core' ),
				'icon'  => 'eicon-header',
			)
		);
	}

	/** register widgets */
	public function register_widgets() {

		$this->load_controls();
		$this->load_files();

		$widgets = array(
			'Block_Heading',
			'Classic_1',
			'Grid_1',
			'Grid_2',
			'Grid_Box_1',
			'Grid_Box_2',
			'Grid_Flex_1',
			'Grid_Flex_2',
			'Grid_Recommended_1',
			'Grid_Recommended_2',
			'Grid_Small_1',
			'List_1',
			'List_2',
			'list_Box_1',
			'list_Box_2',
			'List_Small_1',
			'List_Small_2',
			'List_Small_3',
			'Overlay_1',
			'Overlay_2',
			'Hierarchical_1',
			'Hierarchical_2',
			'Hierarchical_3',
			'Categories_List_1',
			'Categories_List_2',
			'Categories_List_3',
			'Categories_List_4',
			'Categories_List_5',
			'Authors_List_1',
			'Authors_List_2',
			'Newsletter_1',
			'Newsletter_2',
			'Newsletter_3',
			'Playlist',
			'Quick_Links',
			'Breaking_News',
			'Covid_Data',
			'Ad_Image',
			'Ad_Script',
			'Block_Weather',
			'Block_Social_Follower',
			'Banner',
			'Plan',
			'Logo',
			'Dark_Mode_Toggle',
			'Navigation',
			'Social_List',
			'Header_Search_Icon',
			'Header_Notification',
			'Mini_Cart',
			'Header_Login_Icon',
			'Font_Resizer_Icon',
			'Footer_Menu'
		);

		foreach ( $widgets as $widget ) {
			$widget_name = 'foxizElementor\Widgets\\' . $widget;
			if ( class_exists( $widget_name ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register( new $widget_name() );
			}
		}
	}

	private function load_controls() {

		require_once( FOXIZ_CORE_PATH . 'elementor/control.php' );
	}

	private function load_files() {

		$sources = array(
			'heading',
			'classic-1',
			'grid-1',
			'grid-2',
			'grid-box-1',
			'grid-box-2',
			'grid-flex-1',
			'grid-flex-2',
			'grid-recommended-1',
			'grid-recommended-2',
			'grid-small-1',
			'list-1',
			'list-2',
			'list-box-1',
			'list-box-2',
			'list-small-1',
			'list-small-2',
			'list-small-3',
			'overlay-1',
			'overlay-2',
			'hierarchical-1',
			'hierarchical-2',
			'hierarchical-3',
			'quick-links',
			'categories-1',
			'categories-2',
			'categories-3',
			'categories-4',
			'categories-5',
			'authors-1',
			'authors-2',
			'covid-data',
			'newsletter-1',
			'newsletter-2',
			'newsletter-3',
			'videos',
			'ad-image',
			'ad-script',
			'breaking-news',
			'weather',
			'social-follower',
			'banner',
			'plan',
			'logo',
			'dark-toggle',
			'navigation',
			'social-list',
			'search-icon',
			'notification-icon',
			'mini-cart',
			'login-icon',
			'font-resizer',
			'menu'
		);

		foreach ( $sources as $name ) {
			$file = $this->path . trim( $name ) . '.php';
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}
	}
}

/** load plugin */
Plugin::get_instance();