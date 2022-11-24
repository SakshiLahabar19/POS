<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Foxiz_Heading
 * @package foxizElementor\Widgets
 */
class Covid_Data extends Widget_Base {

	public function get_name() {

		return 'foxiz-covid-data';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Covid Data Tracker', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-favorite';
	}

	public function get_categories() {

		return array( 'foxiz' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title', array(
				'label' => esc_html__( 'Covid Data Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'country_code',
			array(
				'label'       => esc_html__( 'Country Code', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input a country code you would like to display, e.g: US. Leave blank if you would like to display global data.', 'foxiz-core' ),
				'default'     => '',
			)
		);

		$this->add_control(
			'country_name',
			array(
				'label'       => esc_html__( 'Country Name', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Input the country name of the code you have just added.', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'heading_style', array(
				'label' => esc_html__( 'Block Design', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Virus Icon', 'foxiz-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Show a virus icon in this block.', 'foxiz-core' ),
				'default'     => 'yes'
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'       => esc_html__( 'Name HTML Tag', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a title HTML tag for the country name.', 'foxiz-core' ),
				'options'     => Options::heading_html_dropdown(),
				'default'     => '0',
			)
		);

		$this->add_responsive_control(
			'title_tag_size', array(
				'label'       => esc_html__( 'Name Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__('Input custom font size values (px) for the country name for displaying in this block.', 'foxiz-core'),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .country-name > *' => 'font-size: {{VALUE}}px;' ),
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
				'label'    => esc_html__( 'Label Text Font', 'foxiz-core' ),
				'name'     => 'label_font',
				'selector' => '{{WRAPPER}} .description-text',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Total Number Font', 'foxiz-core' ),
				'name'     => 'count_font',
				'selector' => '{{WRAPPER}} .data-item-value',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_render_covid_data' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			echo \foxiz_render_covid_data( $settings );
		}
	}
}