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
class Block_Social_Follower extends Widget_Base {

	public function get_name() {

		return 'foxiz-social-follower';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Social Follower', 'foxiz-core' );
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
				'label' => esc_html__( 'Social Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'facebook_page',
			array(
				'label' => esc_html__( 'FanPage Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'facebook_count',
			array(
				'label' => esc_html__( 'Facebook Likes Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'twitter_user',
			array(
				'label' => esc_html__( 'Twitter Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'twitter_count',
			array(
				'label' => esc_html__( 'Twitter Followers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'pinterest_user',
			array(
				'label' => esc_html__( 'Pinterest Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'pinterest_count',
			array(
				'label' => esc_html__( 'Pinterest Followers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'instagram_user',
			array(
				'label' => esc_html__( 'Instagram Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'instagram_count',
			array(
				'label' => esc_html__( 'Instagram Followers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'youtube_link',
			array(
				'label' => esc_html__( 'Youtube Channel or User URL', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'youtube_count',
			array(
				'label' => esc_html__( 'Youtube Subscribers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'soundcloud_user',
			array(
				'label' => esc_html__( 'Soundcloud User Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'soundcloud_count',
			array(
				'label' => esc_html__( 'SoundCloud Followers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'telegram_link',
			array(
				'label' => esc_html__( 'Telegram Channel or Invite URL', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'telegram_count',
			array(
				'label' => esc_html__( 'Telegram Members Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'vimeo_user',
			array(
				'label' => esc_html__( 'Vimeo User Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'vimeo_count',
			array(
				'label' => esc_html__( 'Vimeo Followers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'dribbble_user',
			array(
				'label' => esc_html__( 'Dribbble User Name', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->add_control(
			'dribbble_count',
			array(
				'label' => esc_html__( 'Dribbble Followers Value', 'foxiz-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 1
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section', array(
				'label' => esc_html__( 'Widget Style', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Style', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a style for this widget.', 'foxiz-core' ),
				'options'     => array(
					'1'  => esc_html__( 'Style 1', 'foxiz-core' ),
					'2'  => esc_html__( 'Style 2', 'foxiz-core' ),
					'3'  => esc_html__( 'Style 3', 'foxiz-core' ),
					'4'  => esc_html__( 'Style 4', 'foxiz-core' ),
					'5'  => esc_html__( 'Style 5', 'foxiz-core' ),
					'6'  => esc_html__( 'Style 6', 'foxiz-core' ),
					'7'  => esc_html__( 'Style 7', 'foxiz-core' ),
					'8'  => esc_html__( 'Style 8', 'foxiz-core' ),
					'9'  => esc_html__( 'Style 9', 'foxiz-core' ),
					'10' => esc_html__( 'Style 10', 'foxiz-core' ),
					'11' => esc_html__( 'Style 11', 'foxiz-core' ),
					'12' => esc_html__( 'Style 12', 'foxiz-core' ),
					'13' => esc_html__( 'Style 13', 'foxiz-core' ),
					'14' => esc_html__( 'Style 14', 'foxiz-core' ),
					'15' => esc_html__( 'Style 15', 'foxiz-core' ),
				),
				'default'     => '1',
			)
		);
		$this->add_responsive_control(
			'widget_font_size', array(
				'label'       => esc_html__( 'Custom Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom font size for this widget.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .social-follower .follower-el .follower-inner' => ' font-size : {{VALUE}}px;' ),
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
				'label'    => esc_html__( 'Total Fans Text Font', 'foxiz-core' ),
				'name'     => 'fan_font',
				'selector' => '{{WRAPPER}} .follower-el .fntotal, {{WRAPPER}} .follower-el .fnlabel',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Description Font', 'foxiz-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .follower-el .text-count',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'block_columns', array(
				'label' => esc_html__( 'Columns', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
		$this->add_control(
			'custom_columns',
			array(
				'label'        => esc_html__( 'Custom Columns', 'foxiz-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no'
			)
		);
		$this->add_responsive_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select number of columns for the social counter layout.', 'foxiz-core' ),
				'options'     => array(
					'100'  => esc_html__( '1 Column', 'foxiz-core' ),
					'50'   => esc_html__( '2 Columns', 'foxiz-core' ),
					'33.3' => esc_html__( '3 Columns', 'foxiz-core' ),
					'25'   => esc_html__( '4 Columns', 'foxiz-core' ),
					'20'   => esc_html__( '5 Columns', 'foxiz-core' ),
					'16.6' => esc_html__( '6 Columns', 'foxiz-core' ),
					'14.2' => esc_html__( '7 Columns', 'foxiz-core' ),
					'12.5' => esc_html__( '8 Columns', 'foxiz-core' ),
					'11.1' => esc_html__( '9 Columns', 'foxiz-core' ),
				),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'default'     => '100',
				'condition'   => array(
					'custom_columns' => 'yes',
				),
				'selectors'   => array( '{{WRAPPER}} .follower-el ' => 'flex: 0 0 {{VALUE}}% !important; max-width: {{VALUE}}% !important;' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_get_heading' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			$style            = $settings['style'];
			echo \rb_social_follower( $settings, $style );
		}
	}
}