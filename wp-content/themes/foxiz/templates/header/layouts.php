<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_render_header_1' ) ) {
	function foxiz_render_header_1() {

		$settings  = foxiz_get_header_settings( 'hd1' );
		$classes   = array();
		$classes[] = 'header-wrap rb-section header-set-1 header-1';
		if ( ! empty( $settings['hd1_width'] ) ) {
			$classes[] = 'header-fw';
		} else {
			$classes[] = 'header-wrapper';
		}
		if ( ! empty( $settings['nav_style'] ) ) {
			$classes[] = 'style-' . $settings['nav_style'];
		} else {
			$classes[] = 'style-shadow';
		}
		if ( foxiz_get_mobile_quick_access() ) {
			$classes[] = 'has-quick-menu';
		}
		?>
        <header id="site-header" class="<?php echo join( ' ', $classes ); ?>">
			<?php foxiz_render_top_site();
			foxiz_reading_process_indicator();
			?>
            <div id="navbar-outer" class="navbar-outer">
                <div id="sticky-holder" class="sticky-holder">
                    <div class="navbar-wrap">
                        <div class="rb-container edge-padding">
                            <div class="navbar-inner">
                                <div class="navbar-left">
									<?php
									foxiz_render_logo( $settings );
									foxiz_render_main_menu( false, $settings['sub_scheme'] );
									foxiz_header_more( $settings );
									foxiz_single_sticky();
									?>
                                </div>
                                <div class="navbar-right">
									<?php foxiz_render_nav_right( $settings ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
					foxiz_header_mobile( $settings );
					foxiz_header_alert( $settings );
					?>
                </div>
            </div>
			<?php
			if ( is_active_sidebar( 'foxiz_header_ad' ) ) {
				dynamic_sidebar( 'foxiz_header_ad' );
			} ?>
        </header>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_header_2' ) ) {
	function foxiz_render_header_2() {

		$settings  = foxiz_get_header_settings( 'hd1' );
		$classes   = array();
		$classes[] = 'header-wrap rb-section header-set-1 header-2';
		if ( ! empty( $settings['hd1_width'] ) ) {
			$classes[] = 'header-fw';
		} else {
			$classes[] = 'header-wrapper';
		}
		if ( ! empty( $settings['nav_style'] ) ) {
			$classes[] = 'style-' . $settings['nav_style'];
		} else {
			$classes[] = 'style-shadow';
		}
		if ( foxiz_get_mobile_quick_access() ) {
			$classes[] = 'has-quick-menu';
		}
		?>
        <header id="site-header" class="<?php echo join( ' ', $classes ); ?>">
			<?php foxiz_render_top_site();
			foxiz_reading_process_indicator();
			?>
            <div id="navbar-outer" class="navbar-outer">
                <div id="sticky-holder" class="sticky-holder">
                    <div class="navbar-wrap">
                        <div class="rb-container edge-padding">
                            <div class="navbar-inner">
                                <div class="navbar-left">
									<?php foxiz_render_logo( $settings ); ?>
                                </div>
                                <div class="navbar-center">
									<?php
									foxiz_render_main_menu( false, $settings['sub_scheme'] );
									foxiz_header_more( $settings );
									foxiz_single_sticky();
									?>
                                </div>
                                <div class="navbar-right">
									<?php foxiz_render_nav_right( $settings ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
					foxiz_header_mobile( $settings );
					foxiz_header_alert( $settings );
					?>
                </div>
            </div>
			<?php
			if ( is_active_sidebar( 'foxiz_header_ad' ) ) {
				dynamic_sidebar( 'foxiz_header_ad' );
			} ?>
        </header>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_header_3' ) ) {
	function foxiz_render_header_3() {

		$settings  = foxiz_get_header_settings( 'hd1' );
		$classes   = array();
		$classes[] = 'header-wrap rb-section header-set-1 header-3';
		if ( ! empty( $settings['hd1_width'] ) ) {
			$classes[] = 'header-fw';
		} else {
			$classes[] = 'header-wrapper';
		}
		if ( ! empty( $settings['nav_style'] ) ) {
			$classes[] = 'style-' . $settings['nav_style'];
		} else {
			$classes[] = 'style-shadow';
		}
		if ( foxiz_get_mobile_quick_access() ) {
			$classes[] = 'has-quick-menu';
		}
		?>
        <header id="site-header" class="<?php echo join( ' ', $classes ); ?>">
			<?php foxiz_render_top_site();
			foxiz_reading_process_indicator();
			?>
            <div id="navbar-outer" class="navbar-outer">
                <div id="sticky-holder" class="sticky-holder">
                    <div class="navbar-wrap">
                        <div class="rb-container edge-padding">
                            <div class="navbar-inner">
                                <div class="navbar-left">
									<?php foxiz_render_logo( $settings ); ?>
                                </div>
                                <div class="navbar-center">
									<?php
									foxiz_render_main_menu( false, $settings['sub_scheme'] );
									foxiz_header_more( $settings );
									foxiz_single_sticky();
									?>
                                </div>
                                <div class="navbar-right">
									<?php foxiz_render_nav_right( $settings ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
					foxiz_header_mobile( $settings );
					foxiz_header_alert( $settings );
					?>
                </div>
            </div>
			<?php
			if ( is_active_sidebar( 'foxiz_header_ad' ) ) {
				dynamic_sidebar( 'foxiz_header_ad' );
			} ?>
        </header>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_header_4' ) ) {
	function foxiz_render_header_4() {

		$settings  = foxiz_get_header_settings( 'hd4' );
		$classes   = array();
		$classes[] = 'header-wrap rb-section header-4';
		if ( ! empty( $settings['hd4_width'] ) && 'full' === $settings['hd4_width'] ) {
			$classes[] = 'header-fw';
		} else {
			$classes[] = 'header-wrapper';
		}
		if ( foxiz_get_mobile_quick_access() ) {
			$classes[] = 'has-quick-menu';
		}
		?>
        <header id="site-header" class="<?php echo join( ' ', $classes ); ?>">
			<?php
			foxiz_render_top_site();
			foxiz_reading_process_indicator();
			?>
            <div class="logo-sec">
                <div class="logo-sec-inner rb-container edge-padding">
                    <div class="logo-sec-left"><?php foxiz_render_logo( $settings ); ?></div>
                    <div class="logo-sec-right">
						<?php
						if ( ! empty( $settings['header_socials'] ) ) {
							foxiz_header_socials( $settings );
						}
						if ( ! empty( $settings['header_search_icon'] ) ) {
							$settings['header_search_heading'] = '';
							foxiz_header_search_form( $settings );
						}
						?>
                    </div>
                </div>
            </div>
            <div id="navbar-outer" class="navbar-outer">
                <div id="sticky-holder" class="sticky-holder">
                    <div class="navbar-wrap">
                        <div class="rb-container edge-padding">
                            <div class="navbar-inner">
                                <div class="navbar-left">
									<?php
									foxiz_render_main_menu( false, $settings['sub_scheme'] );
									foxiz_header_more( $settings );
									foxiz_single_sticky();
									?>
                                </div>
                                <div class="navbar-right">
									<?php
									if ( ! empty( $settings['header_login_icon'] ) ) {
										foxiz_header_user( $settings );
									}
									foxiz_header_mini_cart();
									if ( ! empty( $settings['header_notification'] ) ) {
										foxiz_header_notification( $settings );
									}
									if ( ! empty( $settings['single_font_resizer'] ) ) {
										foxiz_header_font_resizer();
									}
									foxiz_dark_mode_switcher( $settings );
									?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
					foxiz_header_mobile( $settings );
					foxiz_header_alert( $settings );
					?>
                </div>
            </div>
			<?php
			if ( is_active_sidebar( 'foxiz_header_ad' ) ) {
				dynamic_sidebar( 'foxiz_header_ad' );
			} ?>
        </header>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_header_5' ) ) {
	function foxiz_render_header_5() {

		$settings  = foxiz_get_header_settings( 'hd5' );
		$classes   = array();
		$classes[] = 'header-wrap rb-section header-5';

		if ( empty( $settings['hd5_width'] ) ) {
			$classes[] = 'header-fw';
		} else {
			$classes[] = 'header-wrapper';
		}
		if ( ! empty( $settings['nav_style'] ) ) {
			$classes[] = 'style-' . $settings['nav_style'];
		}
		if ( foxiz_get_mobile_quick_access() ) {
			$classes[] = 'has-quick-menu';
		}
		?>
        <header id="site-header" class="<?php echo join( ' ', $classes ); ?>">
			<?php
			foxiz_render_top_site();
			foxiz_reading_process_indicator();
			?>
            <div class="logo-sec">
                <div class="logo-sec-inner rb-container edge-padding">
                    <div class="logo-sec-left">
						<?php
						if ( ! empty( $settings['header_login_icon'] ) ) {
							foxiz_header_user( $settings );
						}
						if ( ! empty( $settings['header_socials'] ) ) {
							foxiz_header_socials( $settings );
						}
						?>
                    </div>
                    <div class="logo-sec-center"><?php foxiz_render_logo( $settings ); ?></div>
                    <div class="logo-sec-right">
                        <div class="navbar-right">
							<?php
							foxiz_header_mini_cart();
							if ( ! empty( $settings['header_notification'] ) ) {
								foxiz_header_notification( $settings );
							}
							if ( ! empty( $settings['header_search_icon'] ) ) {
								$settings['header_search_mode'] = 'search';
								foxiz_header_search( $settings );
							}
							if ( ! empty( $settings['single_font_resizer'] ) ) {
								foxiz_header_font_resizer();
							}
							foxiz_dark_mode_switcher( $settings );
							?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="navbar-outer" class="navbar-outer">
                <div id="sticky-holder" class="sticky-holder">
                    <div class="navbar-wrap">
                        <div class="rb-container edge-padding">
                            <div class="navbar-inner">
                                <div class="navbar-center">
									<?php
									foxiz_render_main_menu( false, $settings['sub_scheme'] );
									foxiz_header_more( $settings );
									foxiz_single_sticky();
									?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
					foxiz_header_mobile( $settings );
					foxiz_header_alert( $settings );
					?>
                </div>
            </div>
			<?php
			if ( is_active_sidebar( 'foxiz_header_ad' ) ) {
				dynamic_sidebar( 'foxiz_header_ad' );
			} ?>
        </header>
		<?php
	}
}

/** amp header */
if ( ! function_exists( 'foxiz_render_header_amp' ) ) {
	function foxiz_render_header_amp() {

		$classes   = array();
		$settings  = foxiz_get_option();
		$classes[] = 'header-wrap header-set-1 rb-section';
		if ( foxiz_get_mobile_quick_access() ) {
			$classes[] = 'has-quick-menu';
		} ?>
        <header id="amp-header" class="<?php echo join( ' ', $classes ); ?>">
            <div id="navbar-outer" class="navbar-outer">
				<?php
				foxiz_header_mobile( $settings );
				foxiz_header_alert( $settings );
				?>
            </div>
        </header>
		<?php
		if ( function_exists( 'foxiz_amp_ad' ) ) {
			foxiz_amp_ad( array(
				'type'      => foxiz_get_option( 'amp_header_ad_type' ),
				'client'    => foxiz_get_option( 'amp_header_adsense_client' ),
				'slot'      => foxiz_get_option( 'amp_header_adsense_slot' ),
				'size'      => foxiz_get_option( 'amp_header_adsense_size' ),
				'custom'    => foxiz_get_option( 'amp_header_ad_code' ),
				'classname' => 'header-amp-ad amp-ad-wrap'
			) );
		}
	}
}

if ( ! function_exists( 'foxiz_render_header_rb_template' ) ) {
	/**
	 * @return false
	 * header builder
	 */
	function foxiz_render_header_rb_template() {

		$settings  = foxiz_get_option();
		$shortcode = '';

		if ( is_home() ) {
			if ( ! empty( $settings['blog_header_template'] ) ) {
				$shortcode = $settings['blog_header_template'];
			}
		} elseif ( is_category() ) {
			global $wp_query;
			$data        = get_option( 'foxiz_category_meta', array() );
			$category_id = $wp_query->get_queried_object_id();
			if ( ! empty( $data[ $category_id ]['header_template'] ) ) {
				$shortcode = $data[ $category_id ]['header_template'];
			} elseif ( ! empty( $settings['category_header_template'] ) ) {
				$shortcode = $settings['category_header_template'];
			}
		} elseif ( is_search() ) {
			if ( ! empty( $settings['search_header_template'] ) ) {
				$shortcode = $settings['search_header_template'];
			}
		} elseif ( is_singular() || is_page() ) {
			$shortcode = rb_get_meta( 'header_template', get_the_ID() );
		}

		/** global value */
		if ( empty( $shortcode ) ) {
			$shortcode = foxiz_get_option( 'header_template' );
		}
		if ( empty( $shortcode ) ) {
			foxiz_render_header_1();

			return false;
		} ?>
        <header id="site-header" class="header-wrap rb-section header-template">
			<?php
			foxiz_render_top_site();
			foxiz_reading_process_indicator(); ?>
            <div class="navbar-outer">
                <div id="header-template-holder"><?php
					echo '<div class="header-template-inner">' . do_shortcode( $shortcode ) . '</div>';
					foxiz_header_mobile( $settings );
					?></div>
            </div>
        </header>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_header_none' ) ) {
	function foxiz_render_header_none() {

		$settings = foxiz_get_option(); ?>
        <header id="site-header" class="header-none">
            <div class="navbar-outer">
                <div id="header-template-holder"><?php foxiz_header_mobile( $settings ); ?></div>
            </div>
        </header>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_header_none_mobile' ) ) {
	function foxiz_render_header_none_mobile() { ?>
        <header id="site-header" class="header-none"></header>
		<?php
	}
}
