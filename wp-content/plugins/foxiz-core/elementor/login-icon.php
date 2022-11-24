<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Header_Login
 * @package foxizElementor\Widgets
 */
class Header_Login_Icon extends Widget_Base {

	public function get_name() {

		return 'foxiz-login-icon';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Login Icon', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-header';
	}

	public function get_categories() {

		return array( 'foxiz_header' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'layout_section', array(
				'label' => esc_html__( 'Layout', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'login_popup_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'To config the popup login form. Please navigate to "Theme Options > Login > Popup Sign In".', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_control(
			'header_login_layout',
			array(
				'label'       => esc_html__( 'Sign In Layout', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a layout for the sign in trigger button.', 'foxiz-core' ),
				'options'     => array(
					'0' => esc_html__( 'Icon', 'foxiz' ),
					'1' => esc_html__( 'Text Button', 'foxiz' ),
					'2' => esc_html__( 'Text with Icon Button', 'foxiz' )
				),
				'default'     => '0'
			)
		);
		$this->add_control(
			'login_icon',
			array(
				'label'       => esc_html__( 'Custom Login Icon (SVG Attachment)', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Override default login icon with a SVG icon, Input the file URL of your svg icon.', 'foxiz-core' ),
				'placeholder' => esc_html__( 'https://yourdomain.com/wp-content/uploads/....filename.svg', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .login-icon-svg' => 'mask-image: url({{VALUE}}); -webkit-mask-image: url({{VALUE}}); background-image: none;'
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style-section', array(
				'label' => esc_html__( 'Mode Icon Styles', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'       => esc_html__( 'Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the login icon.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .login-toggle' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_icon_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the login icon in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .login-toggle' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'text-button-section', array(
				'label' => esc_html__( 'Mode Button Styles', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text login button.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .login-toggle span' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'button_bg',
			array(
				'label'       => esc_html__( 'Button Background', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the button.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .login-toggle' => '--g-color: {{VALUE}}; --g-color-90: {{VALUE}}e6;' ),
			)
		);
		$this->add_control(
			'button_border',
			array(
				'label'       => esc_html__( 'Button Border', 'foxiz-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Enable or disable the border for the login button.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .login-toggle.is-btn' => 'border: 1px solid currentColor' ),
			)
		);
		$this->add_control(
			'border_color',
			array(
				'label'       => esc_html__( 'Button Border Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the button border.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .login-toggle.is-btn' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_text_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Text Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text login button.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .login-toggle span' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_button_bg',
			array(
				'label'       => esc_html__( 'Dark Mode - Button Background', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the login button in the dark mode.', 'foxiz-core' ),
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .login-toggle' => '--g-color: {{VALUE}}; --g-color-90: {{VALUE}}e6;' ),
			)
		);
		$this->add_control(
			'dark_border_color',
			array(
				'label'       => esc_html__( 'Dark Mode -Button Border Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the button border in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .login-toggle.is-btn' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Button Text Font', 'foxiz-core' ),
				'name'     => 'button_font',
				'selector' => '{{WRAPPER}} .login-toggle.header-element span',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dimension-section', array(
				'label' => esc_html__( 'Dimensions', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'size',
			array(
				'label'       => esc_html__( 'Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the login icon/button.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .login-toggle svg'  => 'width: {{VALUE}}px; height: {{VALUE}}px;',
					'{{WRAPPER}} .login-toggle span' => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} a.is-logged'        => 'line-height: {{VALUE}}px;'
				),
			)
		);
		$this->add_control(
			'icon_height',
			array(
				'label'       => esc_html__( 'Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the login button.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .login-toggle' => 'line-height: {{VALUE}}px; height: {{VALUE}}px;', ),
			)
		);
		$this->add_control(
			'padding',
			array(
				'label'       => esc_html__( 'Padding', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom left right padding for the login button.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .login-toggle' => '--login-btn-padding: {{VALUE}}px;', ),
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
				'selectors' => array( '{{WRAPPER}} .widget-h-login' => 'text-align: {{VALUE}};', ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dropdown-section', array(
				'label' => esc_html__( 'Logged User Dropdown', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'logged_size',
			array(
				'label'       => esc_html__( 'Welcome Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for welcome text.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .logged-welcome' => 'font-size: {{VALUE}}px;',
				),
			)
		);
		$this->add_control(
			'header_login_menu', array(
				'label'       => esc_html__( 'User Dashboard Menu', 'foxiz-core' ),
				'description' => esc_html__( 'Assign a menu for displaying when hovering on the login icon if user logged.', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'multiple'    => false,
				'options'     => $this->get_menus(),
				'default'     => '0'
			)
		);
		$this->add_control(
			'form_position',
			array(
				'label'       => esc_html__( 'Dropdown Right Position', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'input a right relative position for the logged dropdown, for example: -200', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ),
			)
		);
		$this->add_control(
			'dropdown_color',
			array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .user-dropdown a' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'hover_dropdown_color',
			array(
				'label'       => esc_html__( 'Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown when hovering.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .user-dropdown a:hover' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'bg_from',
			array(
				'label'       => esc_html__( 'Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'bg_to',
			array(
				'label'       => esc_html__( 'Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_dropdown_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .user-dropdown a' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_hover_dropdown_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Hover Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .user-dropdown a:hover' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_from',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_to',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section in the dark mode.', 'foxiz-core' ),
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	protected function get_menus() {

		$menus   = wp_get_nav_menus();
		$options = array(
			'0' => esc_html__( '- Assign a Menu -', 'foxiz-core' )
		);

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings = $this->get_settings();
		if ( function_exists( 'foxiz_header_user' ) ) {
			\foxiz_header_user( $settings );
		}
	}
}