<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Yoast\WP\SEO\Generators\Schema\FAQ;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Mini_Cart
 * @package foxizElementor\Widgets
 */
class Mini_Cart extends Widget_Base {

	public function get_name() {

		return 'foxiz-mini-cart';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Mini Cart', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-header';
	}

	public function get_categories() {

		return array( 'foxiz_header' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'style-section', array(
				'label' => esc_html__( 'Styles', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the mini cart icon.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} i.wnav-icon'   => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} span.wnav-svg' => 'width: {{VALUE}}px;',
				),
			)
		);
		$this->add_control(
			'icon_height',
			array(
				'label'       => esc_html__( 'Icon Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the mini cart icon.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .cart-link' => 'height: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
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
				'selectors' => array( '{{WRAPPER}} .cart-link' => 'justify-content: {{VALUE}};', ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color-section', array(
				'label' => esc_html__( 'Colors', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'       => esc_html__( 'Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the mini cart icon.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} i.wnav-icon' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'count_color',
			array(
				'label'       => esc_html__( 'Cart Counter Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the cart counter dot.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .cart-counter' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_icon_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the mini cart icon in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} i.wnav-icon' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_count_color',
			array(
				'label'       => esc_html__( 'Count Dot Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the cart counter dot in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .cart-counter' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dropdown-section', array(
				'label' => esc_html__( 'Dropdown Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'form_position',
			array(
				'label'       => esc_html__( 'Dropdown Right Position', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'input a right relative position for the mini cart dropdown, for example: -200', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ),
			)
		);
		$this->add_control(
			'dropdown_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the mini cart dropdown.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'bg_from',
			array(
				'label'       => esc_html__( 'Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'bg_to',
			array(
				'label'       => esc_html__( 'Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_dropdown_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the mini cart dropdown in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_from',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_to',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section in the dark mode.', 'foxiz-core' ),
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		\foxiz_elementor_mini_cart( $this->get_settings() );
	}
}