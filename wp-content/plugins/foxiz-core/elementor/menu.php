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
class Footer_Menu extends Widget_Base {

	public function get_name() {

		return 'foxiz-sidebar-menu';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Sidebar Menu', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-nav-menu';
	}

	public function get_categories() {

		return array( 'foxiz' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section', array(
				'label' => esc_html__( 'Menu Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$menus = $this->get_menus();
		$this->add_control(
			'menu', array(
				'label'        => esc_html__( 'Assign Menu', 'foxiz-core' ),
				'description'  => esc_html__( 'Select a menu for this block.', 'foxiz-core' ),
				'type'         => Controls_Manager::SELECT,
				'multiple'     => false,
				'options'      => $menus,
				'default'      => ! empty( array_keys( $menus )[0] ) ? array_keys( $menus )[0] : '',
				'save_default' => true,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style-section', array(
				'label' => esc_html__( 'Style Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'menu_item_spacing', array(
				'label'       => esc_html__( 'Item Padding', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing between menu item.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .sidebar-menu a' => 'padding-bottom: {{VALUE}}px; margin-bottom: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'align', array(
				'label'     => esc_html__( 'Alignment', 'foxiz-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'foxiz-core' ),
						'icon'  => 'eicon-align-start-h',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'foxiz-core' ),
						'icon'  => 'eicon-align-center-h',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'foxiz-core' ),
						'icon'  => 'eicon-align-end-h',
					),
				),
				'selectors' => array( '{{WRAPPER}} .sidebar-menu' => 'text-align: {{VALUE}};', ),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'color-section', array(
				'label' => esc_html__( 'Color Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'menu_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .sidebar-menu a > span' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'menu_hover_color',
			array(
				'label'       => esc_html__( 'Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color when hovering.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .sidebar-menu a:hover > span' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();

		/** dark mode */
		$this->start_controls_section(
			'dark-color-section', array(
				'label' => esc_html__( 'Dark Mode - Color Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'menu_dark_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .sidebar-menu a > span' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'menu_dark_hover_color',
			array(
				'label'       => esc_html__( 'Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .sidebar-menu a:hover > span' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'font_section', array(
				'label' => esc_html__( 'Font & Font Size', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Menu Font', 'foxiz-core' ),
				'name'     => 'menu_font',
				'selector' => '{{WRAPPER}} .sidebar-menu a',
			)
		);
		$this->add_responsive_control(
			'sub_font_size', array(
				'label'       => esc_html__( 'Sub Menu Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size value for the sub menu item.' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .sidebar-menu ul.sub-menu a' => 'font-size: {{VALUE}}px !important;' ),
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
		\foxiz_elementor_sidebar_menu( $settings );
	}
}