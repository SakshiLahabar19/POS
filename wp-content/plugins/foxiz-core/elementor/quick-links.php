<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class
 * @package foxizElementor\Widgets
 */
class Quick_links extends Widget_Base {

	public function get_name() {

		return 'foxiz-quick-links';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Quick Links', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-favorite';
	}

	public function get_categories() {

		return array( 'foxiz' );
	}

	protected function register_controls() {

		$quick_links = new Repeater();

		$this->start_controls_section(
			'general', array(
				'label' => esc_html__( 'General Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'header',
			array(
				'label'   => esc_html__( 'Heading Label', 'foxiz-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Quick Links', 'foxiz-core' ),
			)
		);
		$quick_links->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Quick Link Title', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'placeholder' => esc_html__( 'Hot News', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$quick_links->add_control(
			'url',
			array(
				'label' => esc_html__( 'Quick Link URL', 'foxiz-core' ),
				'type'  => Controls_Manager::URL,
			)
		);

		$this->add_control(
			'quick_links',
			array(
				'label'       => esc_html__( 'Add Quick Link', 'foxiz-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $quick_links->get_controls(),
				'default'     => array(
					array(
						'url'   => '',
						'title' => esc_html__( 'Quick Link #1', 'foxiz-core' ),
						'image' => ''
					)
				),
				'title_field' => '{{{ title }}}',
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
				'default'     => '0',
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
				'label'    => esc_html__( 'Header Label Font', 'foxiz-core' ),
				'name'     => 'heading_font',
				'selector' => '{{WRAPPER}} .qlinks-heading',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Quick link Item Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .qlink a',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section', array(
				'label' => esc_html__( 'Layout', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'foxiz-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1' => esc_html__( '- Default -', 'foxiz-core' ),
					'2' => esc_html__( 'Layout 2', 'foxiz-core' ),
				),
				'default' => '1'
			)
		);
		$this->add_control(
			'hover_effect',
			array(
				'label'     => esc_html__( 'Hover Effect', 'foxiz-core' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => array(
					'layout' => '1',
				),
				'options'   => array(
					'underline' => esc_html__( 'Underline Line', 'foxiz-core' ),
					'dotted'    => esc_html__( 'Underline Dotted', 'foxiz-core' ),
					'color'     => esc_html__( 'Text Color', 'foxiz-core' ),
				),
				'default'   => 'underline'
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_get_quick_links' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo \foxiz_get_quick_links( $settings );
		}
	}
}