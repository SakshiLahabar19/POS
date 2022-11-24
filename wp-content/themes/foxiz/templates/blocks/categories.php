<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_categories_1' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_categories_1( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'uuid'       => '',
			'name'       => 'categories_1',
			'categories' => array(),
		) );

		$settings['classes'] = 'block-categories block-categories-1';
		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 4;
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 10;
		}

		ob_start();
		foxiz_block_open_tag( $settings );
		?>
        <div class="block-inner">
			<?php foreach ( $settings['categories'] as $category ) :
				if ( ! empty( $category['category'] ) ) {
					$settings['slug'] = $category['category'];
					foxiz_category_item_1( $settings );
				}
			endforeach; ?>
        </div>
		<?php
		foxiz_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_categories_2' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_categories_2( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'uuid'       => '',
			'name'       => 'categories_2',
			'categories' => array(),
		) );

		$settings['classes'] = 'block-categories block-categories-2';
		if ( ! empty( $settings['gradient'] ) && '-1' === (string) $settings['gradient'] ) {
			$settings['classes'] .= ' no-gradient';
		}

		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 4;
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 5;
		}

		ob_start();
		foxiz_block_open_tag( $settings );
		?>
        <div class="block-inner">
			<?php foreach ( $settings['categories'] as $category ) :
				if ( ! empty( $category['category'] ) ) {
					$settings['slug'] = $category['category'];
					foxiz_category_item_2( $settings );
				}
			endforeach; ?>
        </div>
		<?php
		foxiz_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_categories_3' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_categories_3( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'uuid'       => '',
			'name'       => 'categories_3',
			'categories' => array(),
		) );

		$settings['classes'] = 'block-categories block-categories-3';
		if ( ! empty( $settings['gradient'] ) && '-1' === (string) $settings['gradient'] ) {
			$settings['classes'] .= ' no-gradient';
		}
		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 4;
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 5;
		}

		ob_start();
		foxiz_block_open_tag( $settings );
		?>
        <div class="block-inner">
			<?php foreach ( $settings['categories'] as $category ) :
				if ( ! empty( $category['category'] ) ) {
					$settings['slug'] = $category['category'];
					foxiz_category_item_3( $settings );
				}
			endforeach; ?>
        </div>
		<?php
		foxiz_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_categories_4' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_categories_4( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'uuid'       => '',
			'name'       => 'categories_4',
			'categories' => array(),
		) );

		$settings['classes'] = 'block-categories block-categories-4';
		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 4;
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 10;
		}

		ob_start();
		foxiz_block_open_tag( $settings );
		?>
        <div class="block-inner">
			<?php foreach ( $settings['categories'] as $category ) :
				if ( ! empty( $category['category'] ) ) {
					$settings['slug'] = $category['category'];
					foxiz_category_item_4( $settings );
				}
			endforeach; ?>
        </div>
		<?php
		foxiz_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'foxiz_get_categories_5' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_categories_5( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'uuid'       => '',
			'name'       => 'categories_1',
			'categories' => array(),
		) );

		$settings['classes'] = 'block-categories block-categories-5';
		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 4;
		}
		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 10;
		}

		ob_start();
		foxiz_block_open_tag( $settings );
		?>
        <div class="block-inner">
			<?php foreach ( $settings['categories'] as $category ) :
				if ( ! empty( $category['category'] ) ) {
					$settings['slug'] = $category['category'];
					foxiz_category_item_5( $settings );
				}
			endforeach; ?>
        </div>
		<?php
		foxiz_block_close_tag();

		return ob_get_clean();
	}
}