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
class Ad_Script extends Widget_Base {

	public function get_name() {

		return 'foxiz-ad-script';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Ad Script', 'foxiz-core' );
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
			'description',
			array(
				'label'       => esc_html__( 'Description', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input a description for this adverting box.', 'foxiz-core' ),
				'default'     => esc_html__( '- Advertisement -', 'foxiz-core' ),
			)
		);
		$this->add_control(
			'code',
			array(
				'label'       => esc_html__( 'Ad/Adsense Code', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Input your custom ad or Adsense code. Use Adsense units code to ensure it display exactly where you put. The widget will not work if you are using auto ads.', 'foxiz-core' ),
				'default'     => ''
			)
		);
		$this->add_control(
			'size',
			array(
				'label'       => esc_html__( 'Ad Size', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a custom size for this ad if you use adsense ad units.', 'foxiz-core' ),
				'options'     => array(
					'0' => esc_html__( 'Do not Override', 'foxiz-core' ),
					'1' => esc_html__( 'Custom Size Below', 'foxiz-core' )
				),
				'default'     => '0',
			)
		);

		$this->add_control(
			'desktop_size',
			array(
				'label'       => esc_html__( 'Size on Desktop', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a size on the desktop device.', 'foxiz-core' ),
				'options'     => Options::ad_size_dropdown(),
				'default'     => '1',
			)
		);
		$this->add_control(
			'tablet_size',
			array(
				'label'       => esc_html__( 'Size on Tablet', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a size on the tablet device.', 'foxiz-core' ),
				'options'     => Options::ad_size_dropdown(),
				'default'     => '1',
			)
		);
		$this->add_control(
			'mobile_size',
			array(
				'label'       => esc_html__( 'Size on Mobile', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a size on the mobile device.', 'foxiz-core' ),
				'options'     => Options::ad_size_dropdown(),
				'default'     => '1',
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
	}

	/**
	 * render layout
	 */
	protected function render() {
		if ( function_exists( 'foxiz_get_adsense' ) ) {
			$settings               = $this->get_settings();
			$settings['uuid']       = 'uid_' . $this->get_id();
			$settings['no_spacing'] = true;
			echo \foxiz_get_adsense( $settings );
		}
	}
}