<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Font_Resizer_Icon
 * @package foxizElementor\Widgets
 */
class Font_Resizer_Icon extends Widget_Base {

	public function get_name() {

		return 'foxiz-font-resizer';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Font Resizer', 'foxiz-core' );
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
				'label' => esc_html__( 'Style Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'layout_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block is only display in the single post page.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the font resizer icon.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .font-resizer-trigger' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'icon_height',
			array(
				'label'       => esc_html__( 'Icon Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the font resizer icon.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .font-resizer-trigger' => 'line-height: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'align', array(
				'label'     => esc_html__( 'Alignment', 'foxiz-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'foxiz-core' ),
						'icon'  => 'eicon-align-start-h',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'foxiz-core' ),
						'icon'  => 'eicon-align-center-h',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'foxiz-core' ),
						'icon'  => 'eicon-align-end-h',
					),
				),
				'selectors' => array( '{{WRAPPER}} .font-resizer' => 'text-align: {{VALUE}};', ),
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
			'icon_color',
			array(
				'label'       => esc_html__( 'Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the font resizer icon.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .font-resizer-trigger' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_icon_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the font resizer icon in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .font-resizer-trigger' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_header_font_resizer' ) ) {
			\foxiz_header_font_resizer();
		}
	}
}