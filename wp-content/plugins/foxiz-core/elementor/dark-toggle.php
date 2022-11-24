<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Dark_Mode_Toggle
 * @package foxizElementor\Widgets
 */
class Dark_Mode_Toggle extends Widget_Base {

	public function get_name() {

		return 'foxiz-dark-mode-toggle';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Dark Mode Toggle', 'foxiz-core' );
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
			'icon_size',
			array(
				'label'       => esc_html__( 'Switcher Size Scale', 'foxiz-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Change the dark mode switcher size.', 'foxiz-core' ),
				'size_units'  => [ '%' ],
				'range'       => [
					'%' => [
						'min' => 50,
						'max' => 150,
					],
				],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'   => [
					'{{WRAPPER}} .dark-mode-slide' => 'transform: scale({{SIZE}}{{UNIT}}); -webkit-transform: scale({{SIZE}}{{UNIT}});',
				],
			)
		);
		$this->add_control(
			'light_color',
			array(
				'label'       => esc_html__( 'Mode Switcher - Light Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the light mode icon (Sun icon) of the dark mode switcher button to fit with the main navigation color.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .dark-mode-slide .svg-mode-light' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_color',
			array(
				'label'       => esc_html__( 'Mode Switcher - Dark Icon Background', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the dark mode icon (Moon icon) of the dark mode switcher button to fit with the main navigation color.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .dark-mode-slide .mode-icon-dark' => 'background: {{VALUE}};' ),
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
				'selectors' => array( '{{WRAPPER}} .dark-mode-toggle' => 'justify-content: {{VALUE}};', ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_dark_mode_switcher' ) ) {
			\foxiz_dark_mode_switcher( array( 'dark_mode' => '1' ) );
		}
	}
}