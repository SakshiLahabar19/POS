<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_section_background_dark_mode' ) ) {
	function foxiz_section_background_dark_mode( $section, $args ) {

		/* header options */
		$section->start_controls_section(
			'foxiz_section_bg_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode Background', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_group_control(
			\Elementor\Group_Control_Background::get_type(), array(
				'label'    => esc_html__( 'Dark Mode Background', 'foxiz-core' ),
				'name'     => 'dark_mode_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '[data-theme="dark"] {{WRAPPER}}.elementor-section',
			)
		);
		$section->end_controls_section();
	}
}

if ( ! function_exists( 'foxiz_section_header_sticky' ) ) {
	function foxiz_section_header_sticky( $section, $args ) {

		if ( foxiz_is_ruby_template() ) {
			$section->start_controls_section(
				'foxiz_section_header', array(
					'label'         => esc_html__( 'Foxiz - for Header Template', 'foxiz-core' ),
					'tab'           => \Elementor\Controls_Manager::TAB_LAYOUT,
					'hide_in_inner' => true,
				)
			);
			$section->add_control(
				'sticky_info',
				array(
					'type'            => \Elementor\Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'The settings below are used for the header template.', 'foxiz' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
				)
			);
			$section->add_control(
				'header_sticky',
				array(
					'label'              => esc_html__( 'Sticky Header', 'foxiz-core' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'description'        => esc_html__( 'Enable or disable the sticky for this section.', 'foxiz-core' ),
					'return_value'       => 'section-sticky',
					'prefix_class'       => 'e-',
					'render_type'        => 'none',
					'frontend_available' => true,
					'default'            => '',
				)
			);
			$section->add_control(
				'header_smart_sticky',
				array(
					'label'        => esc_html__( 'Smart Sticky', 'foxiz-core' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'description'  => esc_html__( 'Only stick the main menu when scrolling up.', 'foxiz-core' ),
					'condition'    => array( 'header_sticky' => 'section-sticky' ),
					'return_value' => 'is-smart-sticky',
					'prefix_class' => ''
				)
			);
			$section->add_control(
				'sticky_bg_info',
				array(
					'type'            => \Elementor\Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'Header Sticky Background.', 'foxiz' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
				)
			);
			$section->add_group_control(
				\Elementor\Group_Control_Background::get_type(), array(
					'name'     => 'header_sticky_bg',
					'label'    => esc_html__( 'Sticky Background', 'foxiz-core' ),
					'types'    => array( 'classic', 'gradient' ),
					'selector' => '.sticky-on {{WRAPPER}}.elementor-section'
				)
			);
			$section->add_control(
				'dark_sticky_bg_info',
				array(
					'type'            => \Elementor\Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'Dark Mode - Header Sticky Background.', 'foxiz' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
				)
			);
			$section->add_group_control(
				\Elementor\Group_Control_Background::get_type(), array(
					'name'     => 'dark_header_sticky_bg',
					'label'    => esc_html__( 'Sticky Background', 'foxiz-core' ),
					'types'    => array( 'classic', 'gradient' ),
					'selector' => '.sticky-on[data-theme="dark"] {{WRAPPER}}.elementor-section'
				)
			);
			$section->end_controls_section();
		}
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_heading_dark_mode' ) ) {
	function foxiz_block_heading_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_heading_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_title_color', array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the text in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
				),
				'default'     => '#ffffff'
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_text_dark_mode' ) ) {
	function foxiz_block_text_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_heading_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_title_color', array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the text in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}' => 'color: {{VALUE}};',
				),
				'default'     => '#ffffff'
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_button_dark_mode' ) ) {
	function foxiz_block_button_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_button_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_button_text_color', array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the text button in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_button_bg_color', array(
				'label'       => esc_html__( 'Background Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color for the button in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-button' => 'background: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_button_border_color', array(
				'label'       => esc_html__( 'Border Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a border color for the button in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}}',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_button_text_color_hover', array(
				'label'       => esc_html__( 'Hover - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the text button when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'[data-theme="dark"] {{WRAPPER}} .elementor-button:hover, [data-theme="dark"] {{WRAPPER}} .elementor-button:focus'         => 'color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}} .elementor-button:hover svg, [data-theme="dark"] {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				],
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_button_bg_color_hover', array(
				'label'       => esc_html__( 'Hover - Background Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a background color for the button when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-button:hover, [data-theme="dark"] {{WRAPPER}} .elementor-button:focus' => 'background: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_button_border_color_hover', array(
				'label'       => esc_html__( 'Hover - Border Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a border color for the button when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-button:hover, [data-theme="dark"] {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}}',
				),
				'default'     => ''
			)
		);

		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_divider_dark_mode' ) ) {
	function foxiz_block_divider_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_divider_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_divider_color', array(
				'label'       => esc_html__( 'Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the divider in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--divider-color: {{VALUE}}', ),
				'default'     => ''
			)
		);

		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_image_dark_mode' ) ) {
	function foxiz_block_image_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_divider_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_title_color', array(
				'label'       => esc_html__( 'Title Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the title in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .elementor-image-box-title' => 'color: {{VALUE}};', ),
				'default'     => '#ffffff'
			)
		);

		$section->add_control(
			'dark_desc_color', array(
				'label'       => esc_html__( 'Description Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the description in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .elementor-image-box-description' => 'color: {{VALUE}};', ),
				'default'     => '#eeeeee'
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_icon_dark_mode' ) ) {
	function foxiz_block_icon_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_divider_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_icon_color', array(
				'label'       => esc_html__( 'Primary Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a primary color for the icon in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon'                                                                            => 'background-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon, [data-theme="dark"] {{WRAPPER}}.elementor-view-default .elementor-icon'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon, [data-theme="dark"] {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
				),
				'default'     => '#ffffff'
			)
		);
		$section->add_control(
			'dark_icon_secondary_color', array(
				'label'       => esc_html__( 'Secondary Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a secondary color for the icon in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon'      => 'background-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon'     => 'color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
				),
				'default'     => '',
				'condition'   => array( 'view!' => 'default', ),
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_icon_box_dark_mode' ) ) {
	function foxiz_block_icon_box_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_divider_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_icon_color', array(
				'label'       => esc_html__( 'Icon Primary Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a primary color for the icon in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon'                                                                        => 'background-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon, [data-theme="dark"] {{WRAPPER}}.elementor-view-default .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_icon_s_color', array(
				'label'       => esc_html__( 'Icon Secondary Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a secondary color for the icon in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'background-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}};'
				),
				'default'     => ''
			)
		);

		$section->add_control(
			'dark_hover_icon_color', array(
				'label'       => esc_html__( 'Hover - Icon Primary Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a primary color for the icon when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon:hover'                                                                              => 'background-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon:hover, [data-theme="dark"] {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_hover_icon_s_color', array(
				'label'       => esc_html__( 'Hover - Icon Secondary Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a secondary color for the icon when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-framed .elementor-icon:hover'  => 'background-color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_title_color', array(
				'label'       => esc_html__( 'Title Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the title in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-box-title' => 'color: {{VALUE}};'
				),
				'default'     => '#ffffff'
			)
		);
		$section->add_control(
			'dark_description_color', array(
				'label'       => esc_html__( 'Title Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the title in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-box-description' => 'color: {{VALUE}};',
				),
				'default'     => '#eeeeee'
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_block_icon_list_dark_mode' ) ) {
	function foxiz_block_icon_list_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_divider_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_icon_color', array(
				'label'       => esc_html__( 'Icon Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for icons in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-icon i'   => 'color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				),
				'default'     => '#ffffff'
			)
		);
		$section->add_control(
			'dark_hover_icon_color', array(
				'label'       => esc_html__( 'Hover - Icon Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for icons when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i'   => 'color: {{VALUE}};',
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_text_color', array(
				'label'       => esc_html__( 'Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for text in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
				),
				'default'     => '#ffffff'
			)
		);
		$section->add_control(
			'dark_hover_text_color', array(
				'label'       => esc_html__( 'Hover - Text Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for text when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
				),
				'default'     => ''
			)
		);
		$section->add_control(
			'dark_divider_color', array(
				'label'       => esc_html__( 'Divider Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the divider in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'condition'   => array( 'divider' => 'yes' ),
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
				),
				'default'     => '#444444'
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_section_border_dark_mode' ) ) {
	function foxiz_section_border_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_border_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode Border', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$section->add_control(
			'dark_border_color', array(
				'label'       => esc_html__( 'Border Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the border in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}' => 'border-color: {{VALUE}}',
				)
			)
		);
		$section->add_control(
			'dark_border_hover_color', array(
				'label'       => esc_html__( 'Hover - Border Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the border when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}:hover' => 'border-color: {{VALUE}}',
				)
			)
		);
		$section->end_controls_section();
	}
}

if ( ! function_exists( 'foxiz_widget_background_dark_mode' ) ) {
	function foxiz_widget_background_dark_mode( $section, $args ) {

		/* header options */
		$section->start_controls_section(
			'foxiz_widget_bg_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode Background', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);
		$section->add_group_control(
			\Elementor\Group_Control_Background::get_type(), array(
				'label'    => esc_html__( 'Dark Mode Background', 'foxiz-core' ),
				'name'     => 'dark_mode_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '[data-theme="dark"] {{WRAPPER}} > .elementor-widget-container',
			)
		);
		$section->end_controls_section();
	}
}

/**
 * @param $section
 * @param $args
 */
if ( ! function_exists( 'foxiz_widget_border_dark_mode' ) ) {
	function foxiz_widget_border_dark_mode( $section, $args ) {

		$section->start_controls_section(
			'foxiz_border_dark_mode', array(
				'label' => esc_html__( 'Foxiz - Dark Mode Border', 'foxiz-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);
		$section->add_control(
			'dark_border_color', array(
				'label'       => esc_html__( 'Border Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the border in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}} > .elementor-widget-container' => 'border-color: {{VALUE}}',
				)
			)
		);
		$section->add_control(
			'dark_border_hover_color', array(
				'label'       => esc_html__( 'Hover - Border Color', 'foxiz-core' ),
				'description' => esc_html__( 'Select a color for the border when hovering in the dark mode.', 'foxiz-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'[data-theme="dark"] {{WRAPPER}}:hover > .elementor-widget-container' => 'border-color: {{VALUE}}',
				)
			)
		);
		$section->end_controls_section();
	}
}