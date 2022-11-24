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
class Block_Weather extends Widget_Base {

	public function get_name() {

		return 'foxiz-weather';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Weather', 'foxiz-core' );
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
				'label' => esc_html__( 'General', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'rows'        => 2,
				'description' => esc_html__( 'Input your title.', 'foxiz-core' ),
				'default'     => esc_html__( 'Weather', 'foxiz-core' ),
			)
		);

		$this->add_control(
			'units',
			array(
				'label'   => esc_html__( 'Units:', 'foxiz-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'C' => esc_html__( '&deg;C', 'foxiz-core' ),
					'F' => esc_html__( '&deg;F', 'foxiz-core' ),
				),
				'default' => 'C',
			)
		);

		$this->add_control(
			'location',
			array(
				'label'       => esc_html__( 'Location:', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'rows'        => 2,
				'description' => '<a target="_blank" href="https://openweathermap.org/find/">' . esc_html__( 'Find your location', 'foxiz-core' ) . '</a>&nbsp;&nbsp;' . esc_html__( '(i.e: London, GB)', 'foxiz-core' ),
				'default'     => esc_html__( 'London', 'foxiz-core' ),
			)
		);

		$this->add_control(
			'api_key',
			array(
				'label'       => esc_html__( 'Weather API Key:', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => '<a target="_blank" href="//openweathermap.org/appid#get">' . esc_html__( 'How to get API key', 'foxiz-core' ) . '</a>',
				'default'     => ''
			)
		);

		$this->add_control(
			'forecast_days',
			array(
				'label'   => esc_html__( 'Forecast:', 'foxiz-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1'    => esc_html__( '1 day', 'foxiz-core' ),
					'2'    => esc_html__( '2 days', 'foxiz-core' ),
					'3'    => esc_html__( '3 days', 'foxiz-core' ),
					'4'    => esc_html__( '4 days', 'foxiz-core' ),
					'5'    => esc_html__( '5 days', 'foxiz-core' ),
					'hide' => esc_html__( 'Do not display', 'foxiz-core' ),
				),
				'default' => '5',
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
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Title Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .rb-w-title.h4',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Location Font', 'foxiz-core' ),
				'name'     => 'location_font',
				'selector' => '{{WRAPPER}} .rb-header-name',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Current Temperature Font', 'foxiz-core' ),
				'name'     => 'temp_font',
				'selector' => '{{WRAPPER}} .rb-w-header .rb-w-units span',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'rb_weather_data' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			echo \rb_weather_data(
				array(
					'title'         => $settings['title'],
					'location'      => $settings['location'],
					'api_key'       => $settings['api_key'],
					'units'         => $settings['units'],
					'forecast_days' => $settings['forecast_days'],
					'color_scheme'  => $settings['color_scheme'],
				) );
		}
	}
}