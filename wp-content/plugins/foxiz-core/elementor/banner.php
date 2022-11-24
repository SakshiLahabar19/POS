<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class
 * @package foxizElementor\Widgets
 */
class Banner extends Widget_Base {

	public function get_name() {

		return 'foxiz-banner';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Sidebar Banner', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-favorite';
	}

	public function get_categories() {

		return array( 'foxiz' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', array(
				'label' => esc_html__( 'General Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Input a title for this banner.', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Input a description for this banner.', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$this->add_control(
			'url',
			array(
				'label'   => esc_html__( 'Button Destination URL', 'foxiz-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$this->add_control(
			'submit',
			array(
				'label'   => esc_html__( 'Button Label', 'foxiz-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$this->add_control(
			'e_image',
			array(
				'label'       => esc_html__( 'Background Image URL', 'foxiz-core' ),
				'description' => esc_html__( 'Input a background image (attachment URL) for this banner.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->add_control(
			'e_dark_image',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Image URL', 'foxiz-core' ),
				'description' => esc_html__( 'Input a background image (attachment URL) for this banner in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'spacing_section', array(
				'label' => esc_html__( 'Spacing', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'padding',
			array(
				'label'       => esc_html__( 'Inner Padding', 'foxiz-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Input a custom inner padding value this block.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'size_units'  => array( 'px', 'em', '%' ),
				'selectors'   => [
					'{{WRAPPER}} .w-banner'         => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .w-banner-content' => 'min-height: auto'
				],
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'size_section', array(
				'label' => esc_html__( 'Font Size', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'title_size',
			array(
				'label'       => esc_html__( 'Title Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the title.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .w-banner-title' => 'font-size: {{VALUE}}px',
				),
			)
		);
		$this->add_responsive_control(
			'desc_size',
			array(
				'label'       => esc_html__( 'Description Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the description.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .w-banner-desc.element-desc' => 'font-size: {{VALUE}}px',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color_section', array(
				'label' => esc_html__( 'Text Color Scheme', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'color_scheme_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::color_scheme_info_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_control(
			'color_scheme',
			array(
				'label'       => esc_html__( 'Text Color Scheme', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::color_scheme_description(),
				'options'     => array(
					'0' => esc_html__( 'Default (Dark Text)', 'foxiz-core' ),
					'1' => esc_html__( 'Light Text', 'foxiz-core' )
				),
				'default'     => '1',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'font_section', array(
				'label' => esc_html__( 'Custom Font', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'custom_font_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::custom_font_info_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Title Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .w-banner-title',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Description Font', 'foxiz-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .w-banner-desc.element-desc',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'rb_sidebar_banner' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			\rb_sidebar_banner( $settings );
		}
	}
}