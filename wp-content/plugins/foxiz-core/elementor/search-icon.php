<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Header_Search_Icon
 * @package foxizElementor\Widgets
 */
class Header_Search_Icon extends Widget_Base {

	public function get_name() {

		return 'foxiz-search-icon';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Header Search Icon', 'foxiz-core' );
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
			'ajax_search',
			array(
				'label'       => esc_html__( 'Live Search Result', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Enable live search result when typing.', 'foxiz-core' ),
				'options'     => array(
					'0' => esc_html__( '- Disable -', 'foxiz-core' ),
					'1' => esc_html__( 'Enable', 'foxiz-core' )
				),
				'default'     => '0',
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
				'description' => esc_html__( 'Select a custom font size for the search icon.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} i.wnav-icon'                    => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} .search-btn > .search-icon-svg' => 'font-size: {{VALUE}}px;'
				),
			)
		);
		$this->add_control(
			'icon_height',
			array(
				'label'       => esc_html__( 'Icon Height', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the search icon.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} i.wnav-icon'   => 'line-height: {{VALUE}}px;',
					'{{WRAPPER}} span.wnav-svg' => 'height: {{VALUE}}px;',
				),
			)
		);
		$this->add_control(
			'header_search_custom_icon',
			array(
				'label'       => esc_html__( 'Custom Search SVG Attachment', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Override default search icon with a SVG icon, Input the file URL of your svg icon.', 'foxiz-core' ),
				'placeholder' => esc_html__( 'https://yourdomain.com/wp-content/uploads/....filename.svg', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .search-icon-svg' => 'mask-image: url({{VALUE}}); -webkit-mask-image: url({{VALUE}}); background-image: none;'
				),
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
				'selectors' => array( '{{WRAPPER}} .w-header-search > .icon-holder' => 'justify-content: {{VALUE}};', ),
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
			'icon_color',
			array(
				'label'       => esc_html__( 'Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the search icon.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}} i.wnav-icon'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .icon-holder > .search-icon-svg' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'dark_icon_color',
			array(
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the search icon in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} i.wnav-icon'      => 'color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}} .icon-holder > .search-icon-svg' => 'color: {{VALUE}};'
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dropdown-section', array(
				'label' => esc_html__( 'Popup Form Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'form_position',
			array(
				'label'       => esc_html__( 'Popup Right Position', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'input a right relative position for the popup search form, for example: -200', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ),
			)
		);
		$this->add_control(
			'bg_from',
			array(
				'label'       => esc_html__( 'Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the popup search form.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '{{WRAPPER}} .w-header-search .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'bg_to',
			array(
				'label'       => esc_html__( 'Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the popup search form.', 'foxiz-core' ),
				'selectors'   => array( '{{WRAPPER}} .w-header-search .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_from',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the popup search form in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .w-header-search .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_bg_to',
			array(
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the popup search form in the dark mode.', 'foxiz-core' ),
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .w-header-search .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'header_search_scheme',
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

		$settings = $this->get_settings();
		if ( ! empty( $settings['header_search_custom_icon'] ) ) {
			$settings['header_search_custom_icon'] = array(
				'url' => $settings['header_search_custom_icon'],
			);
		}

		\foxiz_elementor_header_search( $settings );
	}
}