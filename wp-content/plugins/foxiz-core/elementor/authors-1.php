<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Authors_List_1 extends Widget_Base {

	public function get_name() {

		return 'foxiz-authors-1';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Authors List 1', 'foxiz-core' );
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
				'label' => esc_html__( 'Authors', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'category_list_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block use user Gravatar image to display.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$categories = new Repeater();
		$categories->add_control(
			'author',
			array(
				'label'   => esc_html__( 'Select a Author', 'foxiz-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::author_dropdown(),
				'default' => '',
			)
		);
		$this->add_control(
			'authors',
			array(
				'label'       => esc_html__( 'Add Authors', 'foxiz-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $categories->get_controls(),
				'default'     => array(
					array(
						'author' => ''
					)
				),
				'title_field' => 'Author ID: {{{ author }}}',

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
		$this->add_control(
			'description_length',
			array(
				'label'       => esc_html__( 'Description Length', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Maximum number of words of description to show.', 'foxiz-core' ),
				'default'     => '',
			)
		);
		$this->add_responsive_control(
			'featured_width', array(
				'label'       => esc_html__( 'Custom Featured Width', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'devices'     => array( 'desktop', 'tablet' ),
				'description' => esc_html__( 'Input custom width values (px) for the author avatar. Leave blank to set it as the default.', 'foxiz-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .a-card' => '--featured-width: {{VALUE}}px;',
				),
			)
		);
		$this->add_responsive_control(
			'title_tag_size', array(
				'label'       => esc_html__( 'Title Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .nice-name' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'desc_size', array(
				'label'       => esc_html__( 'Description Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .description-text' => 'font-size: {{VALUE}}px;' ),
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
				'default'     => 'shadow'
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

		if ( function_exists( 'foxiz_get_authors_1' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo \foxiz_get_authors_1( $settings );
		}
	}
}