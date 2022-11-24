<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Categories_List_4
 * @package foxizElementor\Widgets
 */
class Categories_List_4 extends Widget_Base {

	public function get_name() {

		return 'foxiz-categories-4';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Categories List 4', 'foxiz-core' );
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
				'label' => esc_html__( 'Categories', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'category_list_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'To set featured images for each category, navigate to "Posts > Categories > Edit > Featured Images".', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$categories = new Repeater();
		$categories->add_control(
			'category',
			array(
				'label'   => esc_html__( 'Select a Category', 'foxiz-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::cat_slug_dropdown( 'post', esc_html__( '- Select a category -', 'foxiz-core' ) ),
				'default' => '',
			)
		);
		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Add Categories', 'foxiz-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $categories->get_controls(),
				'default'     => array(
					array(
						'category' => '',
						'image'    => ''
					)
				),
				'title_field' => '{{{ category }}}',

			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'design_section', array(
				'label' => esc_html__( 'Block Design', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'crop_size',
			array(
				'label'       => esc_html__( 'Featured Image Size', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::crop_size(),
				'options'     => Options::crop_size_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_responsive_control(
			'display_ratio', array(
				'label'       => esc_html__( 'Custom Featured Ratio', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::display_ratio_description(),
				'selectors'   => array(
					'{{WRAPPER}} .cbox-4 .cbox-featured' => 'padding-bottom: {{VALUE}}%',
				),
			)
		);
		$this->add_control(
			'title_tag',
			array(
				'label'       => esc_html__( 'Title HTML Tag', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::heading_html_description(),
				'options'     => Options::heading_html_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_responsive_control(
			'title_tag_size', array(
				'label'       => esc_html__( 'Title Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .cbox-title' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'count_posts',
			array(
				'label'       => esc_html__( 'Count Posts', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Enable or disable total posts information of each category.', 'foxiz-core' ),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
			)
		);
		$this->add_control(
			'follow',
			array(
				'label'       => esc_html__( 'Follow Button', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::switch_dropdown( false ),
				'description' => esc_html__( 'Enable or disable follow button.', 'foxiz-core' ),
				'default'     => '-1',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'rounded_section', array(
				'label' => esc_html__( 'Rounded Corner', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'box_border',
			array(
				'label'       => esc_html__( 'Border Radius', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::border_description(),
				'selectors'   => array(
					'{{WRAPPER}}' => '--wrap-border: {{VALUE}}px;',
				),
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
				'label'    => esc_html__( 'Category Name Font', 'foxiz-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .cbox-title > *',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Count Posts Font', 'foxiz-core' ),
				'name'     => 'count_font',
				'selector' => '{{WRAPPER}} .cbox-count.is-meta',
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
			'columns',
			array(
				'label'       => esc_html__( 'Columns on Desktop', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_description(),
				'options'     => Options::columns_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_control(
			'columns_tablet',
			array(
				'label'       => esc_html__( 'Columns on Tablet', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_tablet_description(),
				'options'     => Options::columns_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_control(
			'columns_mobile',
			array(
				'label'       => esc_html__( 'Columns on Mobile', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_mobile_description(),
				'options'     => Options::columns_dropdown( array( 0, 1, 2 ) ),
				'default'     => '0',
			)
		);
		$this->add_control(
			'column_gap',
			array(
				'label'       => esc_html__( 'Columns Gap', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::column_gap_description(),
				'options'     => Options::column_gap_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_responsive_control(
			'column_gap_custom', array(
				'label'       => esc_html__( '1/2 Custom Gap Value', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::column_gap_custom_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array(
					'{{WRAPPER}} .is-gap-custom'                  => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px; --column-gap: {{VALUE}}px;',
					'{{WRAPPER}} .is-gap-custom .block-inner > *' => 'padding-left: {{VALUE}}px; padding-right: {{VALUE}}px;'
				),
			)
		);
		$this->add_control(
			'column_border',
			array(
				'label'       => esc_html__( 'Column Border', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::column_border_description(),
				'options'     => Options::column_border_dropdown(),
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
			'bottom_margin', array(
				'label'       => esc_html__( 'Custom Bottom Margin', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom bottom margin values (px) between category items.', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .block-wrap' => '--bottom-spacing: {{VALUE}}px;' ),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'foxiz_get_categories_4' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo \foxiz_get_categories_4( $settings );
		}
	}
}