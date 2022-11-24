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
class Ad_Image extends Widget_Base {

	public function get_name() {

		return 'foxiz-ad-image';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Ad Image', 'foxiz-core' );
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
			'image',
			array(
				'label'       => esc_html__( 'Ad Image', 'foxiz-core' ),
				'description' => esc_html__( 'Upload your ad image.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->add_control(
			'dark_image',
			array(
				'label'       => esc_html__( 'Dark Mode - Ad Image', 'foxiz-core' ),
				'description' => esc_html__( 'Upload your ad image in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->add_control(
			'destination',
			array(
				'label'       => esc_html__( 'Ad Destination', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input your ad destination URL.', 'foxiz-core' ),
				'default'     => ''
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'image_width_section', array(
				'label' => esc_html__( 'Image Max Width', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'image_width',
			array(
				'label'       => esc_html__( 'Image Max Width', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a max width value (in px) for your ad image, leave blank set full size.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .ad-image' => 'max-width: {{VALUE}}px',
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
				'default'     => '0',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_get_ad_image' ) ) {
			$settings               = $this->get_settings();
			$settings['uuid']       = 'uid_' . $this->get_id();
			$settings['no_spacing'] = true;

			if ( ! empty( $settings['image']['id'] ) ) {
				$medata = wp_get_attachment_metadata( $settings['image']['id'] );
				if ( ! empty( $medata['width'] ) && ! empty( $medata['height'] ) ) {
					$settings['image']['width']  = $medata['width'];
					$settings['image']['height'] = $medata['height'];
				}
			}
			echo \foxiz_get_ad_image( $settings );
		}
	}
}