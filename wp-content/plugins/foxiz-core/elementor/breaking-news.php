<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Breaking_News
 * @package foxizElementor\Widgets
 */
class Breaking_News extends Widget_Base {

	public function get_name() {

		return 'foxiz-breaking-news';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Breaking News', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-favorite';
	}

	public function get_categories() {

		return array( 'foxiz' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'query_filters', array(
				'label' => esc_html__( 'Query Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		if ( \foxiz_is_ruby_template() ) {
			$this->add_control(
				'dynamic_query_info',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::dynamic_query_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
				)
			);
			$this->add_control(
				'dynamic_query_category_info',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::dynamic_query_category_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				)
			);
			$this->add_control(
				'category',
				array(
					'label'       => esc_html__( 'Category Filter', 'foxiz-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => Options::category_description(),
					'options'     => Options::cat_dropdown( true ),
					'default'     => '0',
				)
			);
		} else {
			$this->add_control(
				'category',
				array(
					'label'       => esc_html__( 'Category Filter', 'foxiz-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => Options::category_description(),
					'options'     => Options::cat_dropdown(),
					'default'     => '0',
				)
			);
		}

		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Categories Filter', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::categories_description(),
				'default'     => '',
			)
		);
		$this->add_control(
			'tags',
			array(
				'label'       => esc_html__( 'Tags Slug Filter', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::tags_description(),
				'default'     => '',
			)
		);
		$this->add_control(
			'tag_not_in',
			array(
				'label'       => esc_html__( 'Exclude Tags Slug', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::tag_not_in_description(),
				'default'     => '',
			)
		);
		$this->add_control(
			'format',
			array(
				'label'       => esc_html__( 'Post Format', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::format_description(),
				'options'     => Options::format_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_control(
			'author',
			array(
				'label'       => esc_html__( 'Author Filter', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::author_description(),
				'options'     => Options::author_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_control(
			'post_not_in',
			array(
				'label'       => esc_html__( 'Exclude Post IDs', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::post_not_in_description(),
				'default'     => '',
			)
		);
		$this->add_control(
			'post_in',
			array(
				'label'       => esc_html__( 'Post IDs Filter', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::post_in_description(),
				'default'     => '',
			)
		);
		$this->add_control(
			'order',
			array(
				'label'       => esc_html__( 'Sort Order', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::order_description(),
				'options'     => Options::order_dropdown(),
				'default'     => 'date_post',
			)
		);
		$this->add_control(
			'posts_per_page',
			array(
				'label'       => esc_html__( 'Number of Posts', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::posts_per_page_description(),
				'default'     => '5',
			)
		);
		$this->add_control(
			'offset',
			array(
				'label'       => esc_html__( 'Post Offset', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::offset_description(),
				'default'     => '',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'unique_section', array(
				'label' => esc_html__( 'Unique Post', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'unique',
			array(
				'label'       => esc_html__( 'Unique Post', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::unique_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
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
			'layout_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This layout is best suited for all sections.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_control(
			'heading', array(
				'label'       => esc_html__( 'Heading Label', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'input a heading label for this block.', 'foxiz-core' ),
				'default'     => esc_html__( 'Hot News', 'foxiz-core' ),
			)
		);
		$this->add_responsive_control(
			'label_size', array(
				'label'       => esc_html__( 'Label Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size for the label', 'foxiz-core' ),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .breaking-news-heading' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Heading Label Font', 'foxiz-core' ),
				'name'     => 'font_label',
				'selector' => '{{WRAPPER}} .breaking-news-heading',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_title_section', array(
				'label' => esc_html__( 'Post Title', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'title_tag_size', array(
				'label'       => esc_html__( 'Post Title Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .entry-title' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Post Title Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .entry-title',
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
			'slider_section', array(
				'label' => esc_html__( 'Slider', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
		$this->add_control(
			'slider_play',
			array(
				'label'       => esc_html__( 'Auto Play Next Slides', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_autoplay_description(),
				'options'     => Options::switch_dropdown(),
				'default'     => 0,
			)
		);
		$this->add_responsive_control(
			'slider_speed',
			array(
				'label'       => esc_html__( 'Auto Play Speed', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::carousel_speed_description(),
				'default'     => '',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'foxiz_get_breaking_news' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo \foxiz_get_breaking_news( $settings );
		}
	}
}