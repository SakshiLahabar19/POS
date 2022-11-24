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
class Newsletter_1 extends Widget_Base {

	public function get_name() {

		return 'foxiz-newsletter-1';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - FW Newsletter 1', 'foxiz-core' );
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
				'label' => esc_html__( 'Content', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Heading', 'foxiz-core' ),
				'description' => esc_html__( 'Input a heading for the newsletter box.', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 1,
				'default'     => esc_html__( 'Always Stay Up to Date', 'foxiz-core' ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Input a description for the newsletter box.', 'foxiz-core' ),
				'default'     => esc_html__( 'Subscribe to our newsletter to get our newest articles instantly!', 'foxiz-core' ),
			)
		);
		$this->add_control(
			'shortcode',
			array(
				'label'       => esc_html__( 'Form Shortcode', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input your newsletter form shortcode.', 'foxiz-core' ),
				'placeholder' => esc_html__( '[mc4wp_form]', 'foxiz-core' ),
				'default'     => '[mc4wp_form]'
			)
		);
		$this->add_control(
			'featured',
			array(
				'label'       => esc_html__( 'Featured Image', 'foxiz-core' ),
				'description' => esc_html__( 'Input a featured image attachment URL for the newsletter box.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->add_control(
			'dark_featured',
			array(
				'label'       => esc_html__( 'Dark Mode - Featured Image', 'foxiz-core' ),
				'description' => esc_html__( 'Input a featured attachment URL for the newsletter box in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'heading_section', array(
				'label' => esc_html__( 'Heading', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__( 'Heading HTML Tag', 'foxiz-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::heading_html_dropdown(),
				'default' => '0',
			)
		);
		$this->add_responsive_control(
			'title_tag_size', array(
				'label'       => esc_html__( 'Heading Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom font size values (px) for this newsletter heading.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .newsletter-title' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Custom Heading Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .newsletter-title',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_section', array(
				'label' => esc_html__( 'Content', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'description_size', array(
				'label'       => esc_html__( 'Description Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom font size values (px) for the description of this newsletter block', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .newsletter-description' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Custom Description Font', 'foxiz-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .newsletter-description',
			)
		);
		$this->add_responsive_control(
			'input_size', array(
				'label'       => esc_html__( 'Text Input Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom font size values (px) for the text input fields of this newsletter block', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} input[type="text"], {{WRAPPER}} input[type="email"]' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'button_size', array(
				'label'       => esc_html__( 'Button Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom font size values (px) for the mailchimp button of this newsletter block', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} input[type="submit"]' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'box_section', array(
				'label' => esc_html__( 'Box Styles', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'box_style',
			array(
				'label'       => esc_html__( 'Box Style', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a box style for this block.', 'foxiz-core' ),
				'options'     => array(
					'shadow'    => esc_html__( 'Shadow', 'foxiz-core' ),
					'gray'      => esc_html__( 'Gray Solid', 'foxiz-core' ),
					'dark'      => esc_html__( 'Dark Solid', 'foxiz-core' ),
					'gray-dot'  => esc_html__( 'Gray Dotted', 'foxiz-core' ),
					'dark-dot'  => esc_html__( 'Dark Dotted', 'foxiz-core' ),
					'gray-dash' => esc_html__( 'Gray Dashed', 'foxiz-core' ),
					'dark-dash' => esc_html__( 'Dark Dashed', 'foxiz-core' ),
					'none'      => esc_html__( 'None', 'foxiz-core' ),
				),
				'default'     => 'gray-dash',
			)
		);
		$this->add_control(
			'background',
			array(
				'label'       => esc_html__( 'Background Image', 'foxiz-core' ),
				'description' => esc_html__( 'Input a background image attachment URL for the newsletter box.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA,
				'selectors'   => array( '{{WRAPPER}} .newsletter-box' => 'background-image: url("{{URL}}");' )
			)
		);
		$this->add_control(
			'dark_background',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Image', 'foxiz-core' ),
				'description' => esc_html__( 'Input a background attachment URL for the newsletter box in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .newsletter-box' => 'background-image: url("{{URL}}");' )
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
			'spacing_section', array(
				'label' => esc_html__( 'Spacing', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
		$this->add_responsive_control(
			'inner_padding', array(
				'label'       => esc_html__( 'Inner Padding', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom inner padding for this block.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .newsletter-box .newsletter-inner' => 'padding: {{VALUE}}px;' ),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'foxiz_get_newsletter' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			echo \foxiz_get_newsletter( $settings );
		}
	}
}