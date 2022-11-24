<?php
namespace foxizElementor\Widgets;

use Elementor\Repeater;
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
class Plan extends Widget_Base {

	public function get_name() {

		return 'foxiz-plan';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Plan Subscription', 'foxiz-core' );
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
			'title',
			array(
				'label'       => esc_html__( 'Title', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Input a title for this banner.', 'foxiz-core' ),
				'default'     => 'Get <span>unlimited</span> access to everything',
			)
		);
		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'foxiz-core' ),
				'description' => esc_html__( 'Input a description for this plan.', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => 'Plans starting at less than $9/month. <strong>Cancel anytime.</strong>',
			)
		);
		$this->add_control(
			'price',
			array(
				'label'       => esc_html__( 'Price', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input a price for this plan.', 'foxiz-core' ),
				'default'     => '9',
			)
		);
		$this->add_control(
			'unit',
			array(
				'label'       => esc_html__( 'Price Unit', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input a price unit for this plan.', 'foxiz-core' ),
				'default'     => '$',
			)
		);
		$this->add_control(
			'tenure',
			array(
				'label'       => esc_html__( 'Price Tenure', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input a price tenure for this plan.', 'foxiz-core' ),
				'default'     => '/month',
			)
		);
		$features = new Repeater();
		$features->add_control(
			'feature',
			array(
				'label'       => esc_html__( 'Plan Feature', 'foxiz-core' ),
				'description' => esc_html__( 'Input a feature for this plan.', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 1,
				'default'     => '',
			)
		);
		$this->add_control(
			'features',
			array(
				'label'       => esc_html__( 'Plan Features', 'foxiz-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $features->get_controls(),
				'title_field' => '{{{ feature }}}',

			)
		);
		$this->add_control(
			'shortcode',
			array(
				'label'       => esc_html__( 'Membership Payment Button Shortcode', 'foxiz-core' ),
				'description' => esc_html__( 'Input a payment button shortcode. Use button text if you would like to custom label. for example [swpm_payment_button id=1 button_text="Buy Now"]', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => '[swpm_payment_button id=1]',
				'rows'        => 2,
				'default'     => '',

			)
		);
		$this->add_control(
			'register_button',
			array(
				'label'       => esc_html__( 'or Free Button', 'foxiz-core' ),
				'description' => esc_html__( 'Input a free button label to navigate to the user to the register page. Leave blank the payment shortcode filed to use this setting.', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'Join Now',
				'rows'        => 1,
				'default'     => '',

			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'box_style_section', array(
				'label' => esc_html__( 'Box Style', 'foxiz-core' ),
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
					'shadow' => esc_html__( 'Shadow', 'foxiz-core' ),
					'border' => esc_html__( 'Border', 'foxiz-core' ),
					'bg'     => esc_html__( 'Background', 'foxiz-core' ),
				),
				'default'     => 'shadow',
			)
		);
		$this->add_control(
			'box_style_color',
			array(
				'label'       => esc_html__( 'Box Style Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for your box style.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}}' => '--plan-box-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_box_style_color',
			array(
				'label'       => esc_html__( 'Dark - Box Style Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for this plan box in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}}' => '--plan-box-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'button_bg',
			array(
				'label'       => esc_html__( 'Button Background', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .plan-button-wrap' => '--plan-button-bg: {{VALUE}}; --plan-button-bg-opacity: {{VALUE}}ee;' ),
			)
		);
		$this->add_control(
			'dark_button_bg',
			array(
				'label'       => esc_html__( 'Dark - Button Background', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .plan-button-wrap' => '--plan-button-bg: {{VALUE}}; --plan-button-bg-opacity: {{VALUE}}ee;' ),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'       => esc_html__( 'Button Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '{{WRAPPER}} .plan-button-wrap' => '--plan-button-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'dark_button_color',
			array(
				'label'       => esc_html__( 'Dark - Button Color', 'foxiz-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button in the dark mode.', 'foxiz-core' ),
				'default'     => '',
				'selectors'   => array( '[data-theme="dark"] {{WRAPPER}} .plan-button-wrap' => '--plan-button-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'size_section', array(
				'label' => esc_html__( 'Font Size', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'title_size',
			array(
				'label'       => esc_html__( 'Heading Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the plan heading.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .plan-heading' => 'font-size: {{VALUE}}px',
				),
			)
		);
		$this->add_responsive_control(
			'desc_size',
			array(
				'label'       => esc_html__( 'Description Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the description.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .plan-description' => 'font-size: {{VALUE}}px',
				),
			)
		);
		$this->add_responsive_control(
			'feature_size',
			array(
				'label'       => esc_html__( 'Feature List Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the description.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .plan-features' => 'font-size: {{VALUE}}px',
				),
			)
		);
		$this->add_responsive_control(
			'button_size',
			array(
				'label'       => esc_html__( 'Button Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the payment button.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .plan-button-wrap' => '--plan-button-size: {{VALUE}}px',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'spacing_section', array(
				'label' => esc_html__( 'Spacing', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'el_spacing',
			array(
				'label'       => esc_html__( 'Spacing', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing value(px) between element.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .plan-inner > *:not(:last-child)' => 'margin-bottom: {{VALUE}}px',
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
				'label'    => esc_html__( 'Heading Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .plan-heading',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Description Font', 'foxiz-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .plan-description',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Plan Features Font', 'foxiz-core' ),
				'name'     => 'feature_font',
				'selector' => '{{WRAPPER}} .plan-features',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'foxiz_render_pricing_plan' ) ) {
			echo \foxiz_render_pricing_plan( $this->get_settings() );
		}
	}
}