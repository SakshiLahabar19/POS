<?php
/** support wc */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
add_action( 'woocommerce_before_shop_loop', 'foxiz_wc_before_shop_loop', 5 );
add_action( 'woocommerce_no_products_found', 'foxiz_wc_before_shop_loop', 5 );
add_action( 'woocommerce_after_main_content', 'foxiz_wc_after_main_content', 10 );
add_action( 'woocommerce_after_main_content', 'woocommerce_get_sidebar', 5 );
add_action( 'woocommerce_after_shop_loop', 'foxiz_wc_after_shop_loop', 99 );
add_action( 'woocommerce_no_products_found', 'foxiz_wc_after_shop_loop', 99 );

/** changes columns */
add_filter( 'loop_shop_columns', 'foxiz_wc_shop_columns' );

/** remove zipcode request */
add_filter( 'woocommerce_default_address_fields', 'foxiz_optional_postcode_checkout' );

/** posts per page */
add_filter( 'woocommerce_output_related_products_args', 'foxiz_wc_related_posts_per_page' );
add_filter( 'loop_shop_per_page', 'foxiz_wc_shop_products_per_page', 99 );

/** sale percent */
add_filter( 'woocommerce_sale_flash', 'foxiz_wc_sale_percent', 10, 3 );

/** single related columns */
add_filter( 'woocommerce_cross_sells_columns', 'foxiz_wc_cross_sells_columns' );

/** review box */
add_filter( 'woocommerce_product_tabs', 'foxiz_wc_review_box' );

/** quantity button */
add_action( 'woocommerce_after_quantity_input_field', 'foxiz_wc_quantity_button' );

/** remove single breadcrumb */
add_action( 'woocommerce_before_main_content', 'foxiz_remove_single_breadcrumb', 1 );

/** change single rating position */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 12 );

/** remove additional information heading */
add_filter( 'woocommerce_product_additional_information_heading', 'foxiz_additional_information_heading' );

/** change add cart button position */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 100 );

/** cross sell position */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 25 );

/** add category */
add_filter( 'woocommerce_shop_loop_item_title', 'foxiz_wc_product_category', 1 );

/** change rating position */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/** css */
add_filter( 'woocommerce_enqueue_styles', 'foxiz_wc_enqueue_styles' );

/** checkout layout */
add_action( 'woocommerce_checkout_before_customer_details', 'foxiz_checkout_customer_details_before' );
add_action( 'woocommerce_checkout_after_customer_details', 'foxiz_checkout_customer_details_after' );
add_action( 'woocommerce_checkout_after_order_review', 'foxiz_checkout_order_after' );

/** mini cart */
add_filter( 'woocommerce_add_to_cart_fragments', 'foxiz_wc_add_to_cart_fragments', 10 );

/** single  */
add_action( 'woocommerce_single_product_summary', 'foxiz_wc_single_breadcrumb', 4 );
add_action( 'foxiz_wc_header_template', 'foxiz_wc_template', 10 );

/** shop wrapper */
if ( ! function_exists( 'foxiz_wc_before_shop_loop' ) ) {
	function foxiz_wc_before_shop_loop() {

		if ( is_shop() ) {
			$sidebar_position = foxiz_get_option( 'wc_shop_sidebar_position' );
		} elseif ( is_product_category() ) {
			$sidebar_position = foxiz_get_option( 'wc_archive_sidebar_position' );
		}

		if ( ! empty( $sidebar_position ) && 'none' !== $sidebar_position ) {
			if ( ! empty( $template ) ) {

			}
			echo '<div class="shop-page is-sidebar-' . esc_attr( $sidebar_position ) . '">';
		} else {
			echo '<div class="shop-page without-sidebar">';
		}
		echo '<div class="rb-container edge-padding">';
		echo '<div class="grid-container"><div class="shop-page-content">';
	}
}

/** close site-main */
if ( ! function_exists( 'foxiz_wc_template' ) ) {
	function foxiz_wc_template() {

		if ( ! is_shop() ) {
			return false;
		}

		$template = foxiz_get_option( 'wc_shop_template' );
		if ( ! empty( $template ) ) {
			echo do_shortcode( $template );
		}
	}
}

/** close site-main */
if ( ! function_exists( 'foxiz_wc_after_shop_loop' ) ) {
	function foxiz_wc_after_shop_loop() {

		echo '</div>';
	}
}

/** close wrapper page-content */
if ( ! function_exists( 'foxiz_wc_after_main_content' ) ) {
	function foxiz_wc_after_main_content() {

		echo '</div></div></div>';
	}
}

/** shop posts per page */
if ( ! function_exists( 'foxiz_wc_related_posts_per_page' ) ) {
	function foxiz_wc_related_posts_per_page( $args ) {

		$total                  = foxiz_get_option( 'wc_related_posts_per_page' );
		$args['posts_per_page'] = $total;
		$args['columns']        = 4;

		return $args;
	}
}

/** remove zip code */
if ( ! function_exists( 'foxiz_optional_postcode_checkout' ) ) {
	function foxiz_optional_postcode_checkout( $fields ) {

		$fields['postcode']['required'] = false;

		return $fields;
	}
}

if ( ! function_exists( 'foxiz_checkout_customer_details_before' ) ) {
	function foxiz_checkout_customer_details_before() {

		?>
        <div class="checkout-col col-left">
		<?php
	}
}

if ( ! function_exists( 'foxiz_checkout_customer_details_after' ) ) {
	function foxiz_checkout_customer_details_after() { ?>
        </div><div class="checkout-col col-right">
		<?php
	}
}

if ( ! function_exists( 'foxiz_checkout_order_after' ) ) {
	function foxiz_checkout_order_after() { ?>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_cart_after' ) ) {
	function foxiz_cart_after() { ?>
        <div class="clearfix"></div>
		<?php
	}
}

/**
 * before product page
 */
if ( ! function_exists( 'foxiz_single_product_before' ) ) {
	function foxiz_single_product_before() { ?>
        <div class="single-product-wrap clearfix">
		<?php
	}
}

/*
 * after product page
 */
if ( ! function_exists( 'foxiz_single_product_after' ) ) {
	function foxiz_single_product_after() { ?>
        </div>
		<?php
	}
}

/**
 * @param $args
 *
 * @return mixed
 * breadcrumb filter
 */
if ( ! function_exists( 'foxiz_wc_breadcrumb' ) ) {
	function foxiz_wc_breadcrumb( $args ) {

		$args['wrap_before'] = '<aside id="site-breadcrumb" class="breadcrumb breadcrumb-wc"><div class="breadcrumb-inner rb-container"> ';
		$args['wrap_after']  = '</div></aside>';
		$args['delimiter']   = '&nbsp;&gt;&nbsp;';

		return $args;
	}
}

/** remove description */
if ( ! function_exists( 'foxiz_additional_information_heading' ) ) {
	function foxiz_additional_information_heading( $heading ) {

		return false;
	}
}

/** product review box */
if ( ! function_exists( 'foxiz_wc_review_box' ) ) {
	function foxiz_wc_review_box( $tabs ) {

		$check = foxiz_get_option( 'wc_box_review' );
		if ( empty( $check ) ) {
			unset( $tabs['reviews'] );
		}

		return $tabs;
	}
}

/** cross sell */
if ( ! function_exists( 'foxiz_wc_cross_sells_columns' ) ) {
	function foxiz_wc_cross_sells_columns( $columns ) {

		return 4;
	}
}

/** listing columns */
if ( ! function_exists( 'foxiz_wc_shop_columns' ) ) {
	function foxiz_wc_shop_columns() {

		if ( is_shop() ) {
			$sidebar_position = foxiz_get_option( 'wc_shop_sidebar_position' );
		} elseif ( is_product_category() ) {
			$sidebar_position = foxiz_get_option( 'wc_archive_sidebar_position' );
		}

		if ( ! empty( $sidebar_position ) && 'none' === $sidebar_position ) {
			return 4;
		} else {
			return 3;
		}
	}
}

if ( ! function_exists( 'foxiz_wc_sale_percent' ) ) {
	function foxiz_wc_sale_percent( $html, $post, $product ) {

		if ( ! foxiz_get_option( 'wc_sale_percent' ) || empty( $product->get_regular_price() ) ) {
			return $html;
		}

		if ( $product->is_on_sale() ) {
			$attachment_ids = $product->get_gallery_image_ids();
			$class_name     = 'onsale percent ';
			if ( empty( $attachment_ids ) ) {
				$class_name = 'onsale percent without-gallery';
			}
			$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );

			return '<span class="' . esc_attr( $class_name ) . '"><span class="onsale-inner"><strong>' . '-' . esc_html( $percentage ) . '</strong><i>&#37;' . '</i></span></span>';
		}
	}
}

if ( ! function_exists( 'foxiz_wc_add_to_cart_fragments' ) ) {
	function foxiz_wc_add_to_cart_fragments( $fragments ) {

		if ( ! foxiz_get_option( 'wc_mini_cart' ) ) {
			return $fragments;
		}
		$fragments['span.cart-counter'] = '<span class="cart-counter">' . WC()->cart->cart_contents_count . '</span>';
		$fragments['span.total-amount'] = '<span class="total-amount">' . WC()->cart->get_cart_subtotal()  . '</span>';

		$mini_cart = $fragments['div.widget_shopping_cart_content'];
		unset( $fragments['div.widget_shopping_cart_content'] );
		$fragments['div.mini-cart-wrap'] = '<div class="mini-cart-wrap woocommerce">' . $mini_cart . '</div>';

		return $fragments;
	}
}

if ( ! function_exists( 'foxiz_wc_shop_products_per_page' ) ) {
	function foxiz_wc_shop_products_per_page( $total ) {

		$posts_per_page = foxiz_get_option( 'wc_shop_posts_per_page' );
		if ( ! empty( $posts_per_page ) ) {
			$total = $posts_per_page;
		}

		return $total;
	}
}

if ( ! function_exists( 'foxiz_remove_single_breadcrumb' ) ) {
	function foxiz_remove_single_breadcrumb() {

		if ( is_product() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		}
	}
}

if ( ! function_exists( 'foxiz_wc_quantity_button' ) ) {
	function foxiz_wc_quantity_button() { ?>
        <span class="quantity-btn up"></span>
        <span class="quantity-btn down"></span>
		<?php
	}
}

if ( ! function_exists( 'foxiz_wc_product_category' ) ) {
	function foxiz_wc_product_category( $args = array() ) {

		$terms = get_the_terms( get_the_ID(), 'product_cat' );

		if ( $terms ) {
			echo '<div class="product-top">';
			echo '<div class="product-entry-categories p-categories">';
			foreach ( $terms as $term ) {
				echo '<a href="' . esc_url( get_term_link( $term ) ) . '" class="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</a>';
				echo '</a>';
			}
			echo '</div>';

			if ( function_exists( 'wc_get_template' ) ) {
				wc_get_template( 'loop/rating.php' );
			}
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'foxiz_wc_enqueue_styles' ) ) {
	function foxiz_wc_enqueue_styles( $styles ) {

		unset( $styles['woocommerce-general'] );
		return $styles;
	}
}

if ( ! function_exists( 'foxiz_wc_single_breadcrumb' ) ) {
	function foxiz_wc_single_breadcrumb() {

		if ( function_exists( 'woocommerce_breadcrumb' ) ) {
			woocommerce_breadcrumb();
		}
	}
}

