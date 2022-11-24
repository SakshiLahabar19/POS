<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use foxizElementorControl\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class List_Small_1
 * @package foxizElementor\Widgets
 */
class List_Small_1 extends Widget_Base {

	public function get_name() {

		return 'foxiz-list-small-1';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Small List 1', 'foxiz-core' );
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
			'block_pagination', array(
				'label' => esc_html__( 'Ajax Pagination', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'pagination',
			array(
				'label'       => esc_html__( 'Pagination Type', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::pagination_description(),
				'options'     => Options::pagination_dropdown(),
				'default'     => '0',
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
			'entry_category_section', array(
				'label' => esc_html__( 'Entry Category', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'entry_category',
			array(
				'label'       => esc_html__( 'Entry Category', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::entry_category_description(),
				'options'     => Options::extended_entry_category_dropdown( false ),
				'default'     => '-1',
			)
		);
		$this->add_responsive_control(
			'entry_category_size', array(
				'label'       => esc_html__( 'Entry Category Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_category_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .p-category' => 'font-size: {{VALUE}}px !important;' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Custom Entry Category Font', 'foxiz-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .p-categories',
			)
		);
		$this->add_control(
			'hide_category',
			array(
				'label'       => esc_html__( 'Hide Entry Category', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_category_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_title_section', array(
				'label' => esc_html__( 'Post Title', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
				'selectors'   => array( '{{WRAPPER}} .entry-title' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Custom Post Title Font', 'foxiz-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .entry-title',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_meta_section', array(
				'label' => esc_html__( 'Entry Meta', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'entry_meta',
			array(
				'label'       => esc_html__( 'Entry Meta Tags', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => Options::entry_meta_tags_description(),
				'placeholder' => Options::entry_meta_tags_placeholder(),
				'default'     => 'date'
			)
		);
		$this->add_control(
			'review',
			array(
				'label'       => esc_html__( 'Review Meta', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::review_description(),
				'options'     => Options::review_dropdown( false ),
				'default'     => 'replace',
			)
		);
		$this->add_control(
			'review_meta',
			array(
				'label'       => esc_html__( 'Review Meta Description', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::review_meta_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			)
		);
		$this->add_control(
			'sponsor_meta',
			array(
				'label'       => esc_html__( 'Sponsored Meta', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::sponsor_meta_description(),
				'options'     => Options::sponsor_dropdown( false ),
				'default'     => '-1',
			)
		);
		$this->add_responsive_control(
			'entry_meta_size', array(
				'label'       => esc_html__( 'Entry Meta Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_category_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .is-meta' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'avatar_size', array(
				'label'       => esc_html__( 'Author Avatar Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::avatar_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( 'body {{WRAPPER}} .meta-avatar img' => 'width: {{VALUE}}px; height: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'tablet_hide_meta',
			array(
				'label'       => esc_html__( 'Hide Entry Meta on Tablet', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => Options::tablet_hide_meta_description(),
				'placeholder' => esc_html__( 'avatar, author', 'foxiz-core' ),
				'default'     => array()
			)
		);
		$this->add_control(
			'mobile_hide_meta',
			array(
				'label'       => esc_html__( 'Hide Entry Meta on Mobile', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => Options::mobile_hide_meta_description(),
				'placeholder' => esc_html__( 'avatar, author', 'foxiz-core' ),
				'default'     => array()
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'block_design', array(
				'label' => esc_html__( 'Bookmark', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'bookmark',
			array(
				'label'       => esc_html__( 'Bookmark Icon', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::bookmark_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_format_section', array(
				'label' => esc_html__( 'Post Format', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'entry_format',
			array(
				'label'       => esc_html__( 'Post Format Icon', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::entry_format_description(),
				'options'     => array(
					'after-category' => esc_html__( 'After Entry Category', 'foxiz-core' ),
					'-1'             => esc_html__( 'Disable', 'foxiz-core' )
				),
				'default'     => '-1',
			)
		);
		$this->add_responsive_control(
			'entry_format_size', array(
				'label'       => esc_html__( 'Icon Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_format_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .p-format' => 'font-size: {{VALUE}}px !important;' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'excerpt_section', array(
				'label' => esc_html__( 'Excerpt', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'excerpt_length',
			array(
				'label'       => esc_html__( 'Excerpt - Max Length', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::max_excerpt_description(),
				'default'     => '',
			)
		);
		$this->add_control(
			'excerpt_source',
			array(
				'label'       => esc_html__( 'Excerpt - Source', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::excerpt_source_description(),
				'options'     => Options::excerpt_source_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_responsive_control(
			'entry_excerpt_size', array(
				'label'       => esc_html__( 'Entry Excerpt Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::excerpt_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .entry-summary' => 'font-size: {{VALUE}}px;' ),
			)
		);
		$this->add_control(
			'hide_excerpt',
			array(
				'label'       => esc_html__( 'Hide Excerpt', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_excerpt_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'readmore_section', array(
				'label' => esc_html__( 'Read More', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'readmore',
			array(
				'label'       => esc_html__( 'Read More Button', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::readmore_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'counter_section', array(
				'label' => esc_html__( 'Index Counter', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'counter',
			array(
				'label'       => esc_html__( 'Show Counter', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::counter_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			)
		);
		$this->add_control(
			'counter_set',
			array(
				'label'       => esc_html__( 'Counter Offset', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::counter_set_description(),
				'selectors'   => array(
					'{{WRAPPER}} .block-wrap' => 'counter-increment: trend-counter {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'counter_size', array(
				'label'       => esc_html__( 'Font Size', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::counter_size_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .counter-el:before' => 'font-size: {{VALUE}}px;' ),
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
			'layout_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This layout is best suited for putting to section 25 ~ 33% of width with 1 column.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			)
		);
		$this->add_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns on Desktop', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_description(),
				'options'     => Options::columns_dropdown( array( 0, 1, 2, 3, 4, 5, 6 ) ),
				'default'     => '0',
			)
		);
		$this->add_control(
			'columns_tablet',
			array(
				'label'       => esc_html__( 'Columns on Tablet', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_tablet_description(),
				'options'     => Options::columns_dropdown( array( 0, 1, 2, 3, 4, 5, 6 ) ),
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
		$this->end_controls_section();
		$this->start_controls_section(
			'border_section', array(
				'label' => esc_html__( 'Grid Borders', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
		$this->add_control(
			'border_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'The settings below require all responsive column values to be set.', 'foxiz-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
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
		$this->add_control(
			'bottom_border',
			array(
				'label'       => esc_html__( 'Bottom Border', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::bottom_border_description(),
				'options'     => Options::column_border_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_control(
			'last_bottom_border',
			array(
				'label'       => esc_html__( 'Last Bottom Border', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::last_bottom_border_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
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
			'el_spacing', array(
				'label'       => esc_html__( 'Custom Element Spacing', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_spacing_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .p-wrap' => '--el-spacing: {{VALUE}}px;' ),
			)
		);
		$this->add_responsive_control(
			'bottom_margin', array(
				'label'       => esc_html__( 'Custom Bottom Margin', 'foxiz-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_margin_description(),
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'   => array( '{{WRAPPER}} .block-wrap' => '--bottom-spacing: {{VALUE}}px;' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'scroll_section', array(
				'label' => esc_html__( 'Scrolling Mode', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
		$this->add_control(
			'scroll',
			array(
				'label'       => esc_html__( 'Scroll Bar', 'foxiz-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::scroll_description(),
				'options'     => Options::switch_dropdown(),
				'default'     => '0',
			)
		);
		$this->add_control(
			'scroll_height',
			array(
				'label'       => esc_html__( 'Block Height', 'foxiz-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::scroll_height_description(),
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}} .scroll-holder' => 'max-height: {{VALUE}}px;'
				)
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'foxiz_get_list_small_1' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			echo \foxiz_get_list_small_1( $settings );
		}
	}
}