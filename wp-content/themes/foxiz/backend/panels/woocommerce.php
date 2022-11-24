<?php
if ( ! function_exists( 'foxiz_wc_plugin_status_info' ) ) {
	/**
	 * @param string $id
	 *
	 * @return array|null
	 */
	function foxiz_wc_plugin_status_info( $id = 'wc_shop_info' ) {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return array(
				'id'    => $id,
				'type'  => 'info',
				'style' => 'warning',
				'desc'  => html_entity_decode( esc_html__( 'Woocommerce plugin not found! Please install and active <a href=\'https://wordpress.org/plugins/woocommerce/\'>Woocommerce</a> to active settings below.', 'foxiz' ) ),
			);
		}

		return null;
	}
}

if ( ! function_exists( 'foxiz_register_options_woocommerce' ) ) {
	function foxiz_register_options_woocommerce() {

		return array(
			'id'    => 'foxiz_config_section_woocommerce',
			'title' => esc_html__( 'WooCommerce', 'foxiz' ),
			'desc'  => esc_html__( 'Select options for the shop.', 'foxiz' ),
			'icon'  => 'el el-shopping-cart'
		);
	}
}

/**
 * @return array
 * single product
 */
if ( ! function_exists( 'foxiz_register_options_wc_page' ) ) {
	function foxiz_register_options_wc_page() {

		return array(
			'id'         => 'foxiz_config_section_wc_page',
			'title'      => esc_html__( 'WooCommerce Pages', 'foxiz' ),
			'desc'       => esc_html__( 'Select options for the shop and archive and single product pages.', 'foxiz' ),
			'icon'       => 'el el-folder-open',
			'subsection' => true,
			'fields'     => array(
				foxiz_wc_plugin_status_info(),
				array(
					'id'     => 'section_start_wc_shop',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Shop Page Options', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'          => 'wc_shop_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Header Template Shortcode', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input your template shortcode you would like to use Elementor builder to create a featured section at the top of shop page.', 'foxiz' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'rows'        => '2',
					'default'     => ''
				),
				array(
					'id'       => 'wc_shop_posts_per_page',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Products per Page', 'foxiz' ),
					'subtitle' => esc_html__( 'Select number of products per page, leave blank if you want to set as Settings default.', 'foxiz' ),
					'switch'   => true,
					'default'  => ''
				),
				array(
					'id'       => 'wc_shop_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Shop Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select sidebar position for the shop page if you enabled the sidebar.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position( false ),
					'default'  => 'none'
				),
				array(
					'id'       => 'wc_shop_sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Shop Sidebar Name', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar for the shop page if you enabled the sidebar.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name(),
					'default'  => 'foxiz_sidebar_default',
				),
				array(
					'id'     => 'section_end_wc_shop',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_wc_archive',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Shop - Archive Pages Options', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'wc_archive_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Archive Sidebar Position', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar position for product category and archive pages if you enabled the sidebar.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_position( false ),
					'default'  => 'none'
				),
				array(
					'id'       => 'wc_archive_sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Archive Sidebar Name', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a sidebar for product category and archive pages if you enabled the sidebar.', 'foxiz' ),
					'options'  => foxiz_config_sidebar_name(),
					'default'  => 'foxiz_sidebar_default',
				),
				array(
					'id'     => 'section_end_wc_archive',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_wc_single',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Single Product Page', 'foxiz' ),
					'indent' => true
				),
				array(
					'id'       => 'wc_box_review',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Review Box', 'foxiz' ),
					'subtitle' => esc_html__( 'enable or disable the review box in the single product page.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'wc_related_posts_per_page',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Total Related Products', 'foxiz' ),
					'subtitle' => esc_html__( 'Select total related product to show at once. leave blank if you want to set as default.', 'foxiz' ),
					'switch'   => true,
					'default'  => '4'
				),
				array(
					'id'     => 'section_end_wc_single',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}

/**
 * @return array
 * styling
 */
if ( ! function_exists( 'foxiz_register_options_wc_style' ) ) {
	function foxiz_register_options_wc_style() {

		return array(
			'id'         => 'foxiz_config_section_wc_style',
			'title'      => esc_html__( 'Elements Styling', 'foxiz' ),
			'desc'       => esc_html__( 'Select styling options of your shop.', 'foxiz' ),
			'icon'       => 'el el-adjust-alt',
			'subsection' => true,
			'fields'     => array(
				foxiz_wc_plugin_status_info( 'wc_page_info' ),
				array(
					'id'       => 'wc_sale_percent',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Percentage Saved', 'foxiz' ),
					'subtitle' => esc_html__( 'Display Percentage saved on WooCommerce sale products', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'          => 'wc_price_color',
					'title'       => esc_html__( 'Price Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the product price.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color'
				),
				array(
					'id'          => 'wc_dark_price_color',
					'title'       => esc_html__( 'Dark - Price Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the product price in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color'
				),
				array(
					'id'          => 'wc_star_color',
					'title'       => esc_html__( 'Review Start Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the stars review.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color'
				),
				array(
					'id'          => 'wc_dark_star_color',
					'title'       => esc_html__( 'Dark - Review Start Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a color value for the stars review in the dark mode.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color'
				),
				array(
					'id'          => 'wc_sale_color',
					'title'       => esc_html__( 'Sale Icon Background', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color value for the sale icon.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'          => 'wc_add_cart_color',
					'title'       => esc_html__( 'Add to Cart Color', 'foxiz' ),
					'subtitle'    => esc_html__( 'Select a background color for the "Add to Cart" button.', 'foxiz' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				),
				array(
					'id'       => 'wc_responsive_list',
					'type'     => 'switch',
					'title'    => esc_html__( 'Responsive List Layout', 'foxiz' ),
					'subtitle' => esc_html__( 'Display product list in the gird layout on the mobile devices.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'             => 'font_product',
					'type'           => 'typography',
					'title'          => esc_html__( 'Product Title Font', 'foxiz' ),
					'subtitle'       => esc_html__( 'Select a custom font for the product listing title.', 'foxiz' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => array()
				),
				array(
					'id'       => 'font_product_size_mobile',
					'type'     => 'text',
					'validate' => 'number',
					'title'    => esc_html__( 'Product Title - Mobile Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for the product listing title on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'foxiz' ),
				),
				array(
					'id'       => 'font_product_size_tablet',
					'type'     => 'text',
					'validate' => 'number',
					'title'    => esc_html__( 'Product Title - Tablet Font Size', 'foxiz' ),
					'subtitle' => esc_html__( 'Select a font size (px) for product listing title on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'foxiz' ),
				),
				array(
					'id'             => 'font_price',
					'type'           => 'typography',
					'title'          => esc_html__( 'Price Font', 'foxiz' ),
					'subtitle'       => esc_html__( 'Select a custom font for the product price.', 'foxiz' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => array()
				),
			)
		);
	}
}
