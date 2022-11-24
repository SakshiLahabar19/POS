<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class
 * @package foxizElementor\Widgets
 */
class Navigation extends Widget_Base {

	public function get_name() {

		return 'foxiz-navigation';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Menu Navigation', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-header';
	}

	public function get_categories() {

		return array( 'foxiz_header' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section', array(
				'label' => esc_html__( 'Menu', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$menus = $this->get_menus();
		$this->add_control(
			'main_menu', array(
				'label'        => esc_html__( 'Assign Menu', 'foxiz-core' ),
				'description'  => esc_html__( 'Select a menu for your website.', 'foxiz-core' ),
				'type'         => Controls_Manager::SELECT,
				'multiple'     => false,
				'options'      => $menus,
				'default'      => ! empty( array_keys( $menus )[0] ) ? array_keys( $menus )[0] : '',
				'save_default' => true,
			)
		);
		$this->add_control(
			'is_main_menu',
			array(
				'label'       => esc_html__( 'Set as Main Menu', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set this is the main site menu, This option help the site to understand where to add the single sticky headline.', 'foxiz-core' ),
				'default'     => 'yes',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'root_level_section', array(
				'label' => esc_html__( 'Main Level Items', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Main Menu Font', 'foxiz-core' ),
				'name'     => 'menu_font',
				'selector' => '{{WRAPPER}} .main-menu > li > a',
			)
		);
		$this->add_control(
			'menu_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--nav-color: {{VALUE}}; --nav-color-10: {{VALUE}}1a;' ),
			)
		);
		$this->add_control(
			'menu_hover_color',
			array(
				'label'       => esc_html__( 'Hover - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color when hovering.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--nav-color-h: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'menu_hover_color_accent',
			array(
				'label'       => esc_html__( 'Hover - Accent Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a accent color when hovering.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--nav-color-h-accent: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'menu_height', array(
				'label'       => esc_html__( 'Menu Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom height value (px) for this menu. Default is 60.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}}' => '--nav-height: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'menu_item_spacing', array(
				'label'       => esc_html__( 'Item Spacing', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing between menu item. Default is 12.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}}' => '--menu-item-spacing: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'align', array(
				'label'     => esc_html__( 'Alignment', 'foxiz-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'foxiz-core' ),
						'icon'  => 'eicon-align-start-h',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'foxiz-core' ),
						'icon'  => 'eicon-align-center-h',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'foxiz-core' ),
						'icon'  => 'eicon-align-end-h',
					),
				),
				'selectors' => array( '{{WRAPPER}} .main-menu-wrap' => 'justify-content: {{VALUE}};', ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dark_root_level_section', array(
				'label' => esc_html__( 'Dark Mode - Main Level Items', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'menu_dark_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--nav-color: {{VALUE}}; --nav-color-10: {{VALUE}}1a;' ),
			)
		);
		$this->add_control(
			'menu_dark_hover_color',
			array(
				'label'       => esc_html__( 'Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--nav-color-h: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'menu_dark_hover_color_accent',
			array(
				'label'       => esc_html__( 'Hover Accent Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a accent color when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--nav-color-h-accent: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'sub_menu_section', array(
				'label' => esc_html__( 'Sub Menu', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Sub Menu Font', 'foxiz-core' ),
				'name'     => 'submenu_font',
				'selector' => '{{WRAPPER}} .main-menu .sub-menu > .menu-item a, {{WRAPPER}} .user-dropdown a, {{WRAPPER}} .more-col .menu a, {{WRAPPER}} .collapse-footer-menu a',
			)
		);
		$this->add_control(
			'submenu_bg_from',
			array(
				'label'       => esc_html__( 'Sub Menu - Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the sub menu dropdown section.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'submenu_bg_to',
			array(
				'label'       => esc_html__( 'Sub Menu - Background Gradient (To)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the sub menu dropdown section.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'submenu_color',
			array(
				'label'       => esc_html__( 'Sub Menu - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the sub menu dropdown section.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--subnav-color: {{VALUE}}; --subnav-color-10: {{VALUE}}1a;' ),
			)
		);
		$this->add_control(
			'submenu_hover_color',
			array(
				'label'       => esc_html__( 'Sub Menu - Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color when hovering.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}}' => '--subnav-color-h: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dark_sub_menu_section', array(
				'label' => esc_html__( 'Dark Mode - Sub Menu', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'dark_submenu_bg_from',
			array(
				'label'       => esc_html__( 'Sub Menu - Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the sub menu dropdown section in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_submenu_bg_to',
			array(
				'label'       => esc_html__( 'Sub Menu - Background Gradient (To)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the sub menu dropdown section in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_submenu_color',
			array(
				'label'       => esc_html__( 'Sub Menu - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the sub menu dropdown section in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--subnav-color: {{VALUE}}; --subnav-color-10: {{VALUE}}1a;' ),
			)
		);
		$this->add_control(
			'dark_submenu_hover_color',
			array(
				'label'       => esc_html__( 'Sub Menu - Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--subnav-color-h: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mega-menu-section', array(
				'label' => esc_html__( 'Mega Menu - Color Scheme', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'color_scheme',
			array(
				'label'       => esc_html__( 'Color Scheme', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'In case you would like to switch layout and text to light when set a dark background for sub menu in light mode.', 'foxiz-core' ),
				'options'     => array(
					'0' => esc_html__( 'Default (Dark Text)', 'foxiz-core' ),
					'1' => esc_html__( 'Light Text', 'foxiz-core' )
				),
				'default'     => '0',
			)
		);
		$this->end_controls_section();
	}

	protected function get_menus() {

		$menus   = wp_get_nav_menus();
		$options = array();

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings = $this->get_settings();
		\foxiz_elementor_main_menu( $settings );
	}
}