<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Social_List
 * @package foxizElementor\Widgets
 */
class Social_List extends Widget_Base {

	public function get_name() {

		return 'foxiz-social-list';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Social List', 'foxiz-core' );
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
			'layout_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block will get information from Theme Options > Social Profiles to show.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the social icons.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-social-list i' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'icon_height',
			array(
				'label'       => esc_html__( 'Icon Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the social icons.', 'foxiz-core' ),
				'selectors'    => array( '{{WRAPPER}} .header-social-list i' => 'line-height: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'item_spacing', array(
				'label'       => esc_html__( 'Item Spacing', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing between social list item (in px). Default is 5.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-social-list > a' => 'padding-left: {{VALUE}}px; padding-right: {{VALUE}}px;' ),
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
				'selectors' => array( '{{WRAPPER}} .header-social-list' => 'text-align: {{VALUE}};', ),
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
				'description' => esc_html__( 'Select a color for the social icons.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .header-social-list' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_icon_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the social icons in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-social-list' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'stitle-section', array(
				'label' => esc_html__( 'Headline Sticky', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'hide_on_stitle',
			array(
				'label'       => esc_html__( 'Hide when Stick Single Headline', 'foxiz-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'This option is useful (avoid duplicate icons) if you enable share on socials list when single headline is sticking.', 'foxiz-core' ),
				'default'     => false,
				'selectors'   => array( '.yes-tstick.sticky-on {{WRAPPER}}' => 'display: none;' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		\foxiz_elementor_social_list();
	}
}