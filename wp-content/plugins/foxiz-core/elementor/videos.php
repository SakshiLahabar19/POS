<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use foxizElementorControl\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Youtube_Playlist
 * @package foxizElementor\Widgets
 */
class Playlist extends Widget_Base {

	public function get_name() {

		return 'foxiz-playlist';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Youtube Videos', 'foxiz-core' );
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
				'label' => esc_html__( 'Videos Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'playlist_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: Due to play/stop API control button so this block only supports Youtube videos.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);

		$playlist = new Repeater();
		$playlist->add_control(
			'url',
			array(
				'label'       => esc_html__( 'Youtube Video URL', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Input video url...', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$playlist->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Video Title', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Input video title...', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$playlist->add_control(
			'meta',
			array(
				'label'   => esc_html__( 'Meta/Channel Name', 'foxiz-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$playlist->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Custom Thumbnail (Optional)', 'foxiz-core' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				)
			)
		);
		$this->add_control(
			'videos',
			array(
				'label'       => esc_html__( 'Add Videos', 'foxiz-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $playlist->get_controls(),
				'default'     => array(
					array(
						'url'   => '',
						'title' => esc_html__( 'Video Title #1', 'foxiz-core' ),
						'image' => ''
					)
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'block_design', array(
				'label' => esc_html__( 'Block Design', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'title_tag_size', array(
				'label'       => esc_html__( 'Playlist Title Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .plist-item-title' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'play_title_size', array(
				'label'       => esc_html__( 'Playing Title Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom font size values (px) for the playing title for displaying in this block.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .play-title' => 'font-size: {{VALUE}}px;' ),
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
				'label'    => esc_html__( 'Playlist Title', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} span.plist-item-title',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Playing Title Font', 'foxiz-core' ),
				'name'     => 'playing_title_font',
				'selector' => '{{WRAPPER}} .play-title',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'foxiz_get_playlist' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo \foxiz_get_playlist( $settings );
		}
	}
}