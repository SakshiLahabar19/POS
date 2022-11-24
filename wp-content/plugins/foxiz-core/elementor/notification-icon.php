<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Header_Notification
 * @package foxizElementor\Widgets
 */
class Header_Notification extends Widget_Base {

	public function get_name() {

		return 'foxiz-notification-icon';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Notification Icon', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-header';
	}

	public function get_categories() {

		return array( 'foxiz_header' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general-section', array(
				'label' => esc_html__( 'General Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'header_notification_url',
			array(
				'label'       => esc_html__( 'Destination Link', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input a destination URL for the notification panel.', 'foxiz-core' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style-section', array(
				'label' => esc_html__( 'Style Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the notification icon.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} i.wnav-icon'   => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} span.wnav-svg' => 'width: {{VALUE}}px;',
				),
			)
		);
		$this->add_control(
			'icon_height',
			array(
				'label'       => esc_html__( 'Icon Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the notification icon.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .notification-icon-inner' => 'min-height: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'align', array(
				'label'     => esc_html__( 'Alignment', 'foxiz-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'foxiz-core' ),
						'icon'  => 'eicon-align-start-h',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'foxiz-core' ),
						'icon'  => 'eicon-align-center-h',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'foxiz-core' ),
						'icon'  => 'eicon-align-end-h',
					),
				),
				'selectors' => array( '{{WRAPPER}} .notification-icon' => 'justify-content: {{VALUE}};', ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color-section', array(
				'label' => esc_html__( 'Color Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'color',
			array(
				'label'       => esc_html__( 'Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the notification icon.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} i.wnav-icon' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the notification icon in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} i.wnav-icon' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'notification_color',
			array(
				'label'       => esc_html__( 'Notification Dot Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the notification dot icon.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .notification-info' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown-section', array(
				'label' => esc_html__( 'Dropdown Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'form_position',
			array(
				'label'       => esc_html__( 'Dropdown Right Position', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'input a right relative position for notification dropdown, for example: -200', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ),
			)
		);
		$this->add_control(
			'bg_from',
			array(
				'label'       => esc_html__( 'Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .header-dropdown-outer .notification-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'bg_to',
			array(
				'label'       => esc_html__( 'Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown-outer .notification-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_from',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown-outer .notification-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_to',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section in the dark mode.', 'foxiz-core' ),
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown-outer .notification-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'header_notification_scheme',
			array(
				'label'       => esc_html__( 'Text Color Scheme', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select color scheme for the search form to fit with your background.', 'foxiz-core' ),
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

		if ( function_exists( 'foxiz_header_notification' ) ) {
			\foxiz_header_notification( $this->get_settings() );
		}
	}
}