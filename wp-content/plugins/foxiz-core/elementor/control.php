<?php

namespace foxizElementorControl;
/**
 * Class Options
 * @package foxizElementorControl
 * options
 */
class Options {

	static function switch_dropdown( $default = true ) {

		if ( $default ) {
			return array(
				'0'  => esc_html__( '- Default -', 'foxiz-core' ),
				'1'  => esc_html__( 'Enable', 'foxiz-core' ),
				'-1' => esc_html__( 'Disable', 'foxiz-core' )
			);
		} else {
			return array(
				'1'  => esc_html__( 'Enable', 'foxiz-core' ),
				'-1' => esc_html__( 'Disable', 'foxiz-core' )
			);
		}
	}

	/**
	 * @param false $dynamic
	 * @param string $post_type
	 *
	 * @return array
	 */
	static function cat_dropdown( $dynamic = false, $post_type = 'post' ) {

		$data = array(
			'0' => esc_html__( '-- All categories --', 'foxiz-core' ),
		);

		if ( $dynamic ) {
			$data['dynamic'] = esc_html__( 'Dynamic Query', 'foxiz-core' );
		}

		$categories = get_categories( array(
			'hide_empty' => 0,
			'type'       => $post_type,
			'parent'     => '0'
		) );

		$pos = 1;
		foreach ( $categories as $index => $item ) {
			$children = get_categories( array(
				'hide_empty' => 0,
				'type'       => $post_type,
				'child_of'   => $item->term_id,
			) );
			if ( ! empty( $children ) ) {
				array_splice( $categories, $pos + $index, 0, $children );
				$pos += count( $children );
			}
		}

		foreach ( $categories as $item ) {
			$deep = '';
			if ( ! empty( $item->parent ) ) {
				$deep = '--';
			}

			$data[ $item->term_id ] = $deep . ' ' . esc_attr( $item->name ) . ' - [ID: ' . esc_attr( $item->term_id ) . ' / Posts: ' . foxiz_count_posts_category( $item ) . ']';
		}

		return $data;
	}

	static function cat_slug_dropdown( $post_type = 'post', $empty_label = '' ) {

		if ( empty( $empty_label ) ) {
			$empty_label = esc_html__( '-- All categories --', 'foxiz-core' );
		}

		$data = array(
			0 => $empty_label,
		);

		$categories = get_categories( array(
			'hide_empty' => 0,
			'type'       => $post_type,
			'parent'     => '0'
		) );

		$pos = 1;
		foreach ( $categories as $index => $item ) {
			$children = get_categories( array(
				'hide_empty' => 0,
				'type'       => $post_type,
				'child_of'   => $item->term_id,
			) );
			if ( ! empty( $children ) ) {
				array_splice( $categories, $pos + $index, 0, $children );
				$pos += count( $children );
			}
		}

		foreach ( $categories as $item ) {

			$deep = '';
			if ( ! empty( $item->parent ) ) {
				$deep = '--';
			}
			$data[ $item->slug ] = $deep . ' ' . $item->name . ' [Posts: ' . \foxiz_count_posts_category( $item ) . ']';
		}

		return $data;
	}

	static function order_dropdown() {

		return \foxiz_query_order_selection();
	}

	static function format_dropdown() {

		return array(
			'0'       => esc_html__( '-- All --', 'foxiz-core' ),
			'default' => esc_html__( '- Default -', 'foxiz-core' ),
			'gallery' => esc_html__( 'Gallery', 'foxiz-core' ),
			'video'   => esc_html__( 'Video', 'foxiz-core' ),
			'audio'   => esc_html__( 'Audio', 'foxiz-core' )
		);
	}

	static function author_dropdown() {

		$blogusers = get_users( array(
			'role__not_in' => array( 'subscriber' ),
			'fields'       => array( 'ID', 'display_name' )
		) );

		$dropdown = array(
			'0' => esc_html__( '-- All Authors --', 'foxiz-core' )
		);

		if ( is_array( $blogusers ) ) {
			foreach ( $blogusers as $user ):
				$dropdown[ esc_attr( $user->ID ) ] = esc_attr( $user->display_name );
			endforeach;
		}

		return $dropdown;
	}

	/**
	 * @param bool $default
	 *
	 * @return array|string[]
	 */
	static function heading_html_dropdown( $default = true ) {

		$settings = array(
			'0'    => esc_html__( '- Default -', 'foxiz-core' ),
			'h1'   => esc_html__( 'H1', 'foxiz-core' ),
			'h2'   => esc_html__( 'H2', 'foxiz-core' ),
			'h3'   => esc_html__( 'H3', 'foxiz-core' ),
			'h4'   => esc_html__( 'H4', 'foxiz-core' ),
			'h5'   => esc_html__( 'H5', 'foxiz-core' ),
			'h6'   => esc_html__( 'H6', 'foxiz-core' ),
			'p'    => esc_html__( 'p tag', 'foxiz-core' ),
			'span' => esc_html__( 'span', 'foxiz-core' )
		);

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	static function excerpt_dropdown() {

		return array(
			'0' => esc_html__( '- Default -', 'foxiz-core' ),
			'1' => esc_html__( 'Custom Settings Below', 'foxiz-core' )
		);
	}

	static function excerpt_source_dropdown() {

		return array(
			'0'       => esc_html__( 'Use Post Excerpt', 'foxiz-core' ),
			'tagline' => esc_html__( 'Use Title Tagline', 'foxiz-core' ),
		);
	}

	/** featured dropdown */
	static function feat_hover_dropdown() {

		return array(
			'0'         => esc_html__( '- Disable -', 'foxiz-core' ),
			'scale'     => esc_html__( 'Scale', 'foxiz-core' ),
			'fade'      => esc_html__( 'Fade Out', 'foxiz-core' ),
			'bw'        => esc_html__( 'Black & White', 'foxiz-core' ),
			'bw-invert' => esc_html__( 'Black & White Invert', 'foxiz-core' ),
		);
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function standard_entry_category_dropdown( $default = true ) {

		$settings = array(
			'0'        => esc_html__( 'Default from Theme Option', 'foxiz-core' ),
			'bg-1'     => esc_html__( 'Background 1', 'foxiz-core' ),
			'bg-1,big' => esc_html__( 'Background 1 (Big)', 'foxiz-core' ),
			'bg-2'     => esc_html__( 'Background 2', 'foxiz-core' ),
			'bg-2,big' => esc_html__( 'Background 2 (Big)', 'foxiz-core' ),
			'bg-3'     => esc_html__( 'Background 3', 'foxiz-core' ),
			'bg-3,big' => esc_html__( 'Background 3 (Big)', 'foxiz-core' ),
			'bg-4'     => esc_html__( 'Background 4', 'foxiz-core' ),
			'bg-4,big' => esc_html__( 'Background 4 (Big)', 'foxiz-core' ),
			'-1'       => esc_html__( 'Disable', 'foxiz-core' )
		);

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}

	static function extended_entry_category_dropdown( $default = true ) {

		$settings = array(
			'0'            => esc_html__( 'Default from Theme Option', 'foxiz-core' ),
			'bg-1'         => esc_html__( 'Background 1', 'foxiz-core' ),
			'bg-1,big'     => esc_html__( 'Background 1 (Big)', 'foxiz-core' ),
			'bg-2'         => esc_html__( 'Background 2', 'foxiz-core' ),
			'bg-2,big'     => esc_html__( 'Background 2 (Big)', 'foxiz-core' ),
			'bg-3'         => esc_html__( 'Background 3', 'foxiz-core' ),
			'bg-3,big'     => esc_html__( 'Background 3 (Big)', 'foxiz-core' ),
			'bg-4'         => esc_html__( 'Background 4', 'foxiz-core' ),
			'bg-4,big'     => esc_html__( 'Background 4 (Big)', 'foxiz-core' ),
			'text'         => esc_html__( 'Only Text', 'foxiz-core' ),
			'text,big'     => esc_html__( 'Only Text (Big)', 'foxiz-core' ),
			'border'       => esc_html__( 'Border', 'foxiz-core' ),
			'border,big'   => esc_html__( 'Border (Big)', 'foxiz-core' ),
			'b-dotted'     => esc_html__( 'Bottom Dotted', 'foxiz-core' ),
			'b-dotted,big' => esc_html__( 'Bottom Dotted (Big)', 'foxiz-core' ),
			'b-border'     => esc_html__( 'Bottom Border', 'foxiz-core' ),
			'b-border,big' => esc_html__( 'Bottom Border (Big)', 'foxiz-core' ),
			'l-dot'        => esc_html__( 'Left Dot', 'foxiz-core' ),
			'-1'           => esc_html__( 'Disable', 'foxiz-core' )
		);

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}

	static function entry_meta_dropdown() {

		return array(
			'0'      => esc_html__( 'Default from Theme Option', 'foxiz-core' ),
			'custom' => esc_html__( 'Custom Below', 'foxiz-core' ),
			'-1'     => esc_html__( 'Disable', 'foxiz-core' )
		);
	}

	static function sponsor_dropdown( $default = true ) {

		if ( $default ) {
			return array(
				'0'  => esc_html__( '- Default -', 'foxiz-core' ),
				'1'  => esc_html__( 'Enable', 'foxiz-core' ),
				'2'  => esc_html__( 'Enable without Label', 'foxiz-core' ),
				'-1' => esc_html__( 'Disable', 'foxiz-core' )
			);
		} else {
			return array(
				'1'  => esc_html__( 'Enable', 'foxiz-core' ),
				'2'  => esc_html__( 'Enable without Label', 'foxiz-core' ),
				'-1' => esc_html__( 'Disable', 'foxiz-core' )
			);
		}
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function entry_format_dropdown( $default = true ) {

		$settings = array(
			'0'              => esc_html__( 'Default from Theme Option', 'foxiz-core' ),
			'bottom'         => esc_html__( 'Bottom Right', 'foxiz-core' ),
			'bottom,big'     => esc_html__( 'Bottom Right (Big Icon) ', 'foxiz-core' ),
			'top'            => esc_html__( 'Top', 'foxiz-core' ),
			'top,big'        => esc_html__( 'Top (Big Icon)', 'foxiz-core' ),
			'center'         => esc_html__( 'Center', 'foxiz-core' ),
			'center,big'     => esc_html__( 'Center (Big Icon)', 'foxiz-core' ),
			'after-category' => esc_html__( 'After Entry Category', 'foxiz-core' ),
			'-1'             => esc_html__( 'Disable', 'foxiz-core' )
		);

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function review_dropdown( $default = true ) {

		$settings = array(
			'0'       => esc_html__( 'Default from Theme Option', 'foxiz-core' ),
			'1'       => esc_html__( 'Enable', 'foxiz-core' ),
			'replace' => esc_html__( 'Replace for Entry Meta', 'foxiz-core' ),
			'-1'      => esc_html__( 'Disable', 'foxiz-core' )
		);

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}

	/**
	 * @param array $configs
	 *
	 * @return array
	 * columns_dropdown
	 */
	static function columns_dropdown( $configs = array() ) {

		$settings = array();

		$default = array(
			'0' => esc_html__( '- Default -', 'foxiz-core' ),
			'1' => esc_html__( '1 Column', 'foxiz-core' ),
			'2' => esc_html__( '2 Columns', 'foxiz-core' ),
			'3' => esc_html__( '3 Columns', 'foxiz-core' ),
			'4' => esc_html__( '4 Columns', 'foxiz-core' ),
			'5' => esc_html__( '5 Columns', 'foxiz-core' ),
			'6' => esc_html__( '6 Columns', 'foxiz-core' ),
			'7' => esc_html__( '7 Columns', 'foxiz-core' ),
		);

		if ( ! is_array( $configs ) || ! count( $configs ) ) {
			return $default;
		}
		foreach ( $configs as $item ) {
			$settings[ $item ] = $default[ $item ];
		}

		return $settings;
	}

	/**
	 * @return array
	 * column_gap_dropdown
	 */
	static function column_gap_dropdown() {

		return array(
			'0'      => esc_html__( '- Default -', 'foxiz-core' ),
			'none'   => esc_html__( 'No Gap', 'foxiz-core' ),
			'5'      => esc_html__( '10px', 'foxiz-core' ),
			'7'      => esc_html__( '14px', 'foxiz-core' ),
			'10'     => esc_html__( '20px', 'foxiz-core' ),
			'15'     => esc_html__( '30px', 'foxiz-core' ),
			'20'     => esc_html__( '40px', 'foxiz-core' ),
			'25'     => esc_html__( '50px', 'foxiz-core' ),
			'30'     => esc_html__( '60px', 'foxiz-core' ),
			'35'     => esc_html__( '70px', 'foxiz-core' ),
			'custom' => esc_html__( 'Custom Value', 'foxiz-core' )
		);
	}

	/**
	 * @param array $disabled
	 *
	 * @return array
	 * pagination dropdown
	 */
	static function pagination_dropdown( $disabled = array() ) {

		$settings = array(
			'0'               => esc_html__( '- Disable -', 'foxiz-core' ),
			'next_prev'       => esc_html__( 'Next Prev', 'foxiz-core' ),
			'load_more'       => esc_html__( 'Show More', 'foxiz-core' ),
			'infinite_scroll' => esc_html__( 'Infinite Scroll', 'foxiz-core' )
		);

		if ( count( $disabled ) ) {
			foreach ( $disabled as $key ) {
				unset( $settings[ $key ] );
			}
		}

		return $settings;
	}

	/**
	 * @return array
	 */
	static function template_builder_pagination_dropdown() {

		return array(
			'0'              => esc_html__( '- Disable -', 'foxiz-core' ),
			'number'          => esc_html__( 'Numeric', 'foxiz-core' ),
			'simple'          => esc_html__( 'Simple', 'foxiz-core' ),
			'load_more'       => esc_html__( 'Show More (ajax)', 'foxiz-core' ),
			'infinite_scroll' => esc_html__( 'Infinite Scroll (ajax)', 'foxiz-core' ),
		);
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function crop_size_dropdown( $default = true ) {

		$settings = array();
		if ( $default ) {
			$settings['0'] = esc_html__( '- Default -', 'foxiz-core' );
		}

		$sizes = foxiz_calc_crop_sizes();
		foreach ( $sizes as $size => $data ) {
			if ( isset( $data[0] ) && isset( $data[1] ) ) {
				$settings[ $size ] = $data[0] . 'x' . $data[1];
			}
		}

		return $settings;
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function featured_position_dropdown( $default = true ) {

		$settings = array(
			'0'     => esc_html__( '- Default -', 'foxiz-core' ),
			'left'  => esc_html__( 'Left', 'foxiz-core' ),
			'right' => esc_html__( 'Right', 'foxiz-core' ),
		);

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function hide_dropdown( $default = true ) {

		if ( $default ) {
			return array(
				'0'      => esc_html__( '- Default -', 'foxiz-core' ),
				'mobile' => esc_html__( 'On Mobile', 'foxiz-core' ),
				'tablet' => esc_html__( 'On Tablet', 'foxiz-core' ),
				'all'    => esc_html__( 'On Tablet & Mobile', 'foxiz-core' ),
				'-1'     => esc_html__( 'Disable', 'foxiz-core' )
			);
		} else {
			return array(
				'0'      => esc_html__( '- Disable -', 'foxiz-core' ),
				'mobile' => esc_html__( 'On Mobile', 'foxiz-core' ),
				'tablet' => esc_html__( 'On Tablet', 'foxiz-core' ),
				'all'    => esc_html__( 'Tablet & Mobile', 'foxiz-core' )
			);
		}
	}

	static function box_style_dropdown() {

		return array(
			'0'      => esc_html__( '- Default -', 'foxiz-core' ),
			'bg'     => esc_html__( 'Background', 'foxiz-core' ),
			'border' => esc_html__( 'Border', 'foxiz-core' ),
			'shadow' => esc_html__( 'Shadow', 'foxiz' )
		);
	}

	static function column_border_dropdown() {

		return array(
			'0'         => esc_html__( '- Disable -', 'foxiz-core' ),
			'gray'      => esc_html__( 'Gray Solid', 'foxiz-core' ),
			'dark'      => esc_html__( 'Dark Solid', 'foxiz-core' ),
			'gray-dot'  => esc_html__( 'Gray Dotted', 'foxiz-core' ),
			'dark-dot'  => esc_html__( 'Dark Dotted', 'foxiz-core' ),
			'gray-dash' => esc_html__( 'Gray Dashed', 'foxiz-core' ),
			'dark-dash' => esc_html__( 'Dark Dashed', 'foxiz-core' ),
		);
	}

	/**
	 * @return array
	 */
	static function ad_size_dropdown() {

		return array(
			'1'  => esc_html__( 'Leaderboard (728x90)', 'foxiz-core' ),
			'2'  => esc_html__( 'Banner (468x60)', 'foxiz-core' ),
			'3'  => esc_html__( 'Half banner (234x60)', 'foxiz-core' ),
			'4'  => esc_html__( 'Button (125x125)', 'foxiz-core' ),
			'5'  => esc_html__( 'Skyscraper (120x600)', 'foxiz-core' ),
			'6'  => esc_html__( 'Wide Skyscraper (160x600)', 'foxiz-core' ),
			'7'  => esc_html__( 'Small Rectangle (180x150)', 'foxiz-core' ),
			'8'  => esc_html__( 'Vertical Banner (120 x 240)', 'foxiz-core' ),
			'9'  => esc_html__( 'Small Square (200x200)', 'foxiz-core' ),
			'10' => esc_html__( 'Square (250x250)', 'foxiz-core' ),
			'11' => esc_html__( 'Medium Rectangle (300x250)', 'foxiz-core' ),
			'12' => esc_html__( 'Large Rectangle (336x280)', 'foxiz-core' ),
			'13' => esc_html__( 'Half Page (300x600)', 'foxiz-core' ),
			'14' => esc_html__( 'Portrait (300x1050)', 'foxiz-core' ),
			'15' => esc_html__( 'Mobile Banner (320x50)', 'foxiz-core' ),
			'16' => esc_html__( 'Large Leaderboard (970x90)', 'foxiz-core' ),
			'17' => esc_html__( 'Billboard (970x250)', 'foxiz-core' ),
			'18' => esc_html__( 'Mobile Banner (320x100)', 'foxiz-core' ),
			'19' => esc_html__( 'Mobile Friendly (300x100)', 'foxiz-core' ),
			'-1' => esc_html__( 'Hide on Desktop', 'foxiz-core' ),
		);
	}

	static function vertical_align_dropdown( $default = true ) {

		if ( $default ) {
			return array(
				'0'  => esc_html__( '- Default -', 'foxiz-core' ),
				'1'  => esc_html__( 'Middle', 'foxiz-core' ),
				'-1' => esc_html__( 'Bottom', 'foxiz-core' ),
				'2'  => esc_html__( 'Top', 'foxiz-core' ),
			);
		} else {
			return array(
				'1'  => esc_html__( 'Middle', 'foxiz-core' ),
				'-1' => esc_html__( 'Bottom', 'foxiz-core' ),
				'2'  => esc_html__( 'Top', 'foxiz-core' ),
			);
		}
	}

	/** settings subtitle & description */
	static function category_description() {

		return esc_html__( 'Filter posts by category.', 'foxiz-core' );
	}

	static function categories_description() {

		return esc_html__( 'Filter posts by multiple category IDs, separated category IDs by commas (for example: 1,2,3).', 'foxiz-core' );
	}

	static function tags_description() {

		return esc_html__( 'Filter posts by tag slugs, separated by commas (for example: tagslug1,tagslug2,tagslug3).', 'foxiz-core' );
	}

	static function tag_not_in_description() {

		return esc_html__( 'Exclude tag slugs, separated by commas (for example: tagslug1,tagslug2,tagslug3).', 'foxiz-core' );
	}

	static function format_description() {

		return esc_html__( 'Filter posts by post format.', 'foxiz-core' );
	}

	static function author_description() {

		return esc_html__( 'Filter posts by post author.', 'foxiz-core' );
	}

	static function post_not_in_description() {

		return esc_html__( 'Exclude posts by Post IDs, separated by commas (for example: 1,2,3).', 'foxiz-core' );
	}

	static function post_in_description() {

		return esc_html__( 'Filter posts by post IDs. separated by commas (for example: 1,2,3).', 'foxiz-core' );
	}

	static function order_description() {

		return esc_html__( 'Select a sort order type for queried posts.', 'foxiz-core' );
	}

	static function posts_per_page_description() {

		return esc_html__( 'Select a number of posts to show at once.', 'foxiz-core' );
	}

	static function offset_description() {

		return esc_html__( 'Select number of posts to pass over. Leave this option blank to set at the beginning.', 'foxiz-core' );
	}

	static function heading_html_description() {

		return esc_html__( 'Select a title HTML tag for the main title.', 'foxiz-core' );
	}

	static function sub_heading_html_description() {

		return esc_html__( 'Select a title HTML tag for the secondary titles.', 'foxiz-core' );
	}

	static function crop_size() {

		return esc_html__( 'Select a featured image size to optimize with the columns setting.', 'foxiz-core' );
	}

	static function featured_position_description() {

		return esc_html__( 'Select a position of the featured image for this layout.', 'foxiz-core' );
	}

	static function display_ratio_description() {

		return esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. For example: 50', 'foxiz-core' );
	}

	static function feat_hover_description() {

		return esc_html__( 'Select a hover effect for this block featured images.', 'foxiz-core' );
	}

	static function entry_category_description() {

		return esc_html__( 'Enable or disable category info on the post featured image.', 'foxiz-core' );
	}

	static function entry_category_size_description() {

		return esc_html__( 'Input custom font size value for the entry category of this layout. Leave blank if you would like to set it as the default.', 'foxiz-core' );
	}

	static function entry_meta_description() {

		return esc_html__( 'Enable or disable the post entry meta.', 'foxiz-core' );
	}

	static function entry_meta_tags_description() {

		return esc_html__( 'Input custom entry meta tags to show, separate by comma. For example: avatar,author,update. Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]', 'foxiz-core' );
	}

	static function entry_meta_tags_placeholder() {

		return 'avatar, author, date, category, tag, view, comment, update, read, custom';
	}

	static function flex_1_structure_placeholder() {

		return 'title, thumbnail, meta, review, excerpt, readmore';
	}

	static function flex_2_structure_placeholder() {

		return 'category, title, thumbnail, meta, review, excerpt, readmore';
	}

	static function entry_meta_size_description() {

		return esc_html__( 'Input custom font size value for the entry meta of this layout. Leave blank if you would like to set it as the default.', 'foxiz-core' );
	}

	static function avatar_size_description() {

		return esc_html__( 'Input custom avatar size for this layout. Leave blank if you would like to set it as the default (22px).', 'foxiz-core' );
	}

	static function review_description() {

		return esc_html__( 'Disable or select setting for the post review meta.', 'foxiz-core' );
	}

	static function entry_format_description() {

		return esc_html__( 'Enable or disable the post format icon.', 'foxiz-core' );
	}

	static function entry_format_size_description() {

		return esc_html__( 'Input custom font size value for the post format icon of this layout. Leave blank if you would like to set it as the default.', 'foxiz-core' );
	}

	static function excerpt_size_description() {

		return esc_html__( 'Input custom font size value for the post excerpt. Leave blank if you would like to set it as the default.', 'foxiz-core' );
	}

	static function review_meta_description() {

		return esc_html__( 'Enable or disable the short meta description in the entry review bar.', 'foxiz-core' );
	}

	static function bookmark_description() {

		return esc_html__( 'Enable or disable the bookmark icon. Request to enable at least one entry meta in order to work.', 'foxiz-core' );
	}

	static function excerpt_description() {

		return esc_html__( 'Select settings for the post excerpt.', 'foxiz-core' );
	}

	static function max_excerpt_description() {

		return esc_html__( 'Leave this option blank or set 0 to disable. Choose "Custom Settings Below" in the above "Excerpt" option to activate this setting.', 'foxiz-core' );
	}

	static function excerpt_source_description() {

		return esc_html__( 'Select a source of content to display for the post excerpt. Choose "Custom Settings Below" in the above "Excerpt" option to activate this setting.', 'foxiz-core' );
	}

	static function readmore_description() {

		return esc_html__( 'Enable or disable the read more button.', 'foxiz-core' );
	}

	static function columns_description() {

		return esc_html__( 'Select total columns to show per row.', 'foxiz-core' );
	}

	static function columns_tablet_description() {

		return esc_html__( 'Select total columns to show per row on the tablet device.', 'foxiz-core' );
	}

	static function columns_mobile_description() {

		return esc_html__( 'Select total columns to show per row on the mobile device.', 'foxiz-core' );
	}

	static function column_gap_description() {

		return esc_html__( 'Select a spacing between columns. Select "Custom Value" if you would like input it manually.', 'foxiz-core' );
	}

	static function column_gap_custom_description() {

		return esc_html__( 'Input 1/2 value of the custom gap between columns (in px) for desktop, tablet and mobile devices. The spacing will be 2x your input value.', 'foxiz-core' );
	}

	static function column_border_description() {

		return esc_html__( 'Display vertical borders between columns.', 'foxiz-core' );
	}

	static function pagination_description() {

		return esc_html__( 'Select a ajax pagination type.', 'foxiz-core' );
	}

	static function unique_description() {

		return esc_html__( 'Avoid duplicate posts that were been queried before this block.', 'foxiz-core' );
	}

	static function dynamic_query_info() {

		return esc_html__( 'If you assign this template for category or archive. The dynamic query helps you to only filter posts that base on current category page it\'s display on.', 'foxiz-core' );
	}

	static function dynamic_query_category_info() {

		return esc_html__( 'Dynamic query cannot execute in this live editor. The latest posts will be displayed. Your change will be effect when you assign this template to a category page.', 'foxiz-core' );
	}

	static function scroll_description() {

		return esc_html__( 'Enable the scroll bar.', 'foxiz-core' );
	}

	static function scroll_height_description() {

		return esc_html__( 'Input the max block height (in px) when you would like to enable scrollbar. Leave this option blank to disable the scroll bar.', 'foxiz-core' );
	}

	static function color_scheme_description() {

		return esc_html__( 'Select a text color scheme for this block.', 'foxiz-core' );
	}

	static function box_style_description() {

		return esc_html__( 'Select a box style for the post listing .', 'foxiz-core' );
	}

	static function box_color_description() {

		return esc_html__( 'Select a color for the background or border style.', 'foxiz-core' );
	}

	static function box_dark_color_description() {

		return esc_html__( 'Select a color in the dark mode or light scheme mode for the background or border style.', 'foxiz-core' );
	}

	static function color_scheme_info_description() {

		return esc_html__( 'In case you would like to switch layout and text to light when set a dark background for this section.', 'foxiz-core' );
	}

	static function custom_font_info_description() {

		return esc_html__( 'The settings below will override on theme option settings and the above font size settings.', 'foxiz-core' );
	}

	static function counter_description() {

		return esc_html__( 'Display counter in the post listing. It will not compatible with the slider or carousel mode.', 'foxiz-core' );
	}

	static function counter_set_description() {

		return esc_html__( 'Set a start value (index -1) for the counter.', 'foxiz-core' );
	}

	static function counter_size_description() {

		return esc_html__( 'Input custom font sizes for the counter. Please blank to set it as the default.', 'foxiz-core' );
	}

	static function title_size_description() {

		return esc_html__( 'Input custom font size values (px) for the post title for displaying in this block.', 'foxiz-core' );
	}

	static function sub_title_size_description() {

		return esc_html__( 'Input custom font size values (px) for the secondary post title for displaying in this block.', 'foxiz-core' );
	}

	static function sponsor_meta_description() {

		return esc_html__( 'Enable or disable the "sponsored by" meta for this post listing.', 'foxiz-core' );
	}

	static function hide_category_description() {

		return esc_html__( 'Hide the entry category of this block on the tablet and mobile devices.', 'foxiz-core' );
	}

	static function hide_excerpt_description() {

		return esc_html__( 'Hide the post excerpt of this block on the tablet and mobile devices.', 'foxiz-core' );
	}

	static function tablet_hide_meta_description() {

		return esc_html__( 'Input entry meta tags to hide on the tablet devices, separate by comma. For example: avatar, author Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all meta.', 'foxiz-core' );
	}

	static function mobile_hide_meta_description() {

		return esc_html__( 'Input entry meta tags to hide on the mobile devices, separate by comma. For example: avatar, author Keys include: [avatar, author, date, category, tag, view, comment, update, read, custom]. Input -1 to re-enable all meta', 'foxiz-core' );
	}

	static function slider_mode_description() {

		return esc_html__( 'Display this block in the slider layout if it has more than one post.', 'foxiz-core' );
	}

	static function carousel_mode_description() {

		return esc_html__( 'Display this block in the carousel layout.', 'foxiz-core' );
	}

	static function carousel_columns_description() {

		return esc_html__( 'Input total slides to show for the carousel. This value will be override on the columns settings, Allowing decimal value, i.e: 2.3, 2.4....', 'foxiz-core' );
	}

	static function wide_carousel_columns_description() {

		return esc_html__( 'Input total slides to show for the carousel on the wide screen devices (wider than 1500px). Leave blank to use the above settings.', 'foxiz-core' );
	}

	static function carousel_gap_description() {

		return esc_html__( 'Input a custom spacing value between carousel items. The spacing will be same as your input value. Set "-1" to disable the gap.', 'foxiz-core' );
	}

	static function carousel_dot_description() {

		return esc_html__( 'Enable or disable the pagination dot for this carousel.', 'foxiz-core' );
	}

	static function carousel_nav_description() {

		return esc_html__( 'Enable or disable the next/prev navigation dot for this carousel.', 'foxiz-core' );
	}

	static function carousel_nav_spacing_description() {

		return esc_html__( 'Input a custom spacing for the carousel navigation bar.', 'foxiz-core' );
	}

	static function carousel_autoplay_description() {

		return esc_html__( 'Enable or disable autoplay for this slider.', 'foxiz-core' );
	}

	static function carousel_speed_description() {

		return esc_html__( 'Input a custom time to next a slide in milliseconds. Leave blank if you would like to set it as the default (Theme Options).', 'foxiz-core' );
	}

	static function carousel_freemode_description() {

		return esc_html__( 'Enable or disable free mode when scrolling on for this carousel.', 'foxiz-core' );
	}

	static function carousel_centered_description() {

		return esc_html__( 'Enable centered mode for this carousel in case you set decimal sliders.', 'foxiz-core' );
	}

	static function carousel_nav_color_description() {

		return esc_html__( 'Select a color for the slider navigation at the footer of this carousel.', 'foxiz-core' );
	}

	static function el_spacing_description() {

		return esc_html__( 'Input custom spacing values (px) between elements for displaying in this block.', 'foxiz-core' );
	}

	static function featured_spacing_description() {

		return esc_html__( 'Input custom spacing values (px) between elements and featured image for displaying in this block.', 'foxiz-core' );
	}

	static function el_margin_description() {

		return esc_html__( 'Input custom bottom margin values (px) between posts listing.', 'foxiz-core' );
	}

	static function bottom_border_description() {

		return esc_html__( 'Show a border at the bottom of each post in the listing. The bottom spacing will be x2 if you enable this option.', 'foxiz-core' );
	}

	static function last_bottom_border_description() {

		return esc_html__( 'Disable border for the last posts in this listing.', 'foxiz-core' );
	}

	static function center_mode_description() {

		return esc_html__( 'Centering text and content for the post listing.', 'foxiz-core' );
	}

	static function middle_mode_description() {

		return esc_html__( 'Vertical align middle elements for the post listing.', 'foxiz-core' );
	}

	static function border_description() {

		return esc_html__( 'Input a custom border radius (in px) for the featured image or boxed layout. Set 0 to disable it.', 'foxiz-core' );
	}

	static function list_gap_description() {

		return esc_html__( 'Input 1/2 value of the custom gap between the featured image and list post content (in px) for desktop, tablet devices. The spacing will be 2x your input value.', 'foxiz-core' );
	}

	static function template_builder_info() {

		return esc_html__( 'Settings below allow you to apply the global query loop to this block and show it as a the main listing for the index blog, category, archive, single related, reading list etc...', 'foxiz-core' );
	}

	static function template_builder_unique_info() {

		return esc_html__( 'Don\'t apply the WP global query mode for more than one block in a template to avoid duplicated query loop.', 'foxiz-core' );
	}

	static function template_builder_available_info() {

		return esc_html__( 'The "Query Settings" & "Unique Filter" will be not available in the "WP global query" mode.', 'foxiz-core' );
	}

	static function template_builder_pagination_info() {

		return esc_html__( 'Use "WP Global Query Pagination" because the "Ajax Pagination" settings will be not available when you enable "WP global query" mode.', 'foxiz-core' );
	}

	static function template_builder_admin_info() {

		return esc_html__( 'The "WP global query mode" layout cannot execute in this live editor. Please check the frontend to see your changes.', 'foxiz-core' );
	}

	static function template_builder_posts_info() {

		return esc_html__( '"Number of posts" in the frontend will be set in the Theme Options panel. Base on the section has been assigned this template shortcode.', 'foxiz-core' );
	}

	static function template_builder_total_posts_info() {

		return esc_html__( 'Tips: You can change the "Number of Posts" setting in "Query Settings" the same as the frontend (in Theme Options panel). It will help you to easy to edit but that value will not apply in the frontend.', 'foxiz-core' );
	}

	static function archive_pagination_info() {

		return esc_html__( 'This is the main blog pagination for the category and archive pages. It is only available on the archive builder template. Please don\'t place this block into a standard page.', 'foxiz-core' );
	}

	static function archive_pagination_admin_info() {

		return esc_html__( 'The pagination cannot execute in this live editor. You can check these changes in the frontend when assign this template for a category or archive page', 'foxiz-core' );
	}

	static function template_pagination_description() {

		return esc_html__( 'Some pagination types may not be available in some cases, depending on where you put this template. The theme will automatically return a appropriate setting.', 'foxiz-core' );
	}

	static function query_mode_description() {

		return esc_html__( 'Choose to use the global query or use the "Query settings" panel. Please read the above notices for further information.', 'foxiz-core' );
	}
}
