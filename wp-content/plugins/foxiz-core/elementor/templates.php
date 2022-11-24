<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_elementor_main_menu' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_elementor_main_menu( $settings = array() ) {

		if ( empty( $settings['main_menu'] ) ) {
			return false;
		}

		$args = array(
			'menu'          => $settings['main_menu'],
			'menu_id'       => false,
			'container'     => '',
			'menu_class'    => 'main-menu rb-menu large-menu',
			'walker'        => new Foxiz_Walker_Nav_Menu(),
			'depth'         => 4,
			'items_wrap'    => '<ul id="%1$s" class="%2$s" itemscope itemtype="' . foxiz_protocol() . '://www.schema.org/SiteNavigationElement">%3$s</ul>',
			'echo'          => true,
			'fallback_cb'   => 'foxiz_navigation_fallback',
			'fallback_name' => esc_html__( 'Main Menu', 'foxiz' )
		);
		if ( ! empty( $settings['color_scheme'] ) ) {
			$args['sub_scheme'] = 'light-scheme';
		}
		?>
        <nav id="site-navigation" class="main-menu-wrap template-menu" aria-label="<?php esc_attr_e( 'main menu', 'foxiz-core' ); ?>"><?php wp_nav_menu( $args ); ?></nav>
		<?php
		if ( ! empty( $settings['is_main_menu'] ) && foxiz_get_option( 'single_post_sticky_title' ) && is_singular( 'post' ) && ! foxiz_is_amp() && function_exists( 'foxiz_single_sticky_html' ) ) {
			foxiz_single_sticky_html();
		}
	}
}

if ( ! function_exists( 'foxiz_elementor_social_list' ) ) {
	function foxiz_elementor_social_list() { ?>
        <div class="header-social-list wnav-holder"><?php echo foxiz_get_social_list( foxiz_get_option() ); ?></div>
	<?php }
}

if ( ! function_exists( 'foxiz_elementor_header_search' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_elementor_header_search( $settings = array() ) {

		if ( function_exists( 'foxiz_header_search' ) ) {
			foxiz_header_search( $settings );
		}
	}
}

if ( ! function_exists( 'foxiz_elementor_mini_cart' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_elementor_mini_cart( $settings = array() ) {

		if ( ! function_exists( 'foxiz_header_mini_cart_html' ) || ! class_exists( 'Woocommerce' ) || ! function_exists( 'wc_get_cart_url' ) || foxiz_is_amp() ) {
			if ( is_admin() ) {
				echo '<div class="rb-error">' . esc_html__( 'Woocommerce not found' ) . '</div>';
			}

			return false;
		}

		foxiz_header_mini_cart_html();
	}
}

if ( ! function_exists( 'foxiz_elementor_sidebar_menu' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_elementor_sidebar_menu( $settings = array() ) {
		wp_nav_menu( array(
			'menu'       => $settings['menu'],
			'menu_id'    => false,
			'container'  => '',
			'menu_class' => 'sidebar-menu',
			'depth'      => 4,
			'echo'       => true
		) );
	}
}
