<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_render_header' ) ) {
	/**
	 * @return mixed
	 */
	function foxiz_render_header() {

		if ( foxiz_is_amp() ) {
			foxiz_render_header_amp();
		} else {
			$func = 'foxiz_render_header_' . foxiz_get_header_style();
			if ( function_exists( $func ) ) {
				return call_user_func( $func );
			} else {
				foxiz_render_header_1();
			}
		}
	}
}

if ( ! function_exists( 'foxiz_render_text_logo' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_render_text_logo( $settings = array() ) {

		$blog_name  = get_bloginfo( 'name' );
		$class_name = 'logo-wrap is-text-logo site-branding';
		if ( ! empty( $settings['transparent'] ) ) {
			$class_name = ' is-logo-transparent';
		}
		?>
    <div class="<?php echo esc_attr( $class_name ); ?>">
		<?php if ( is_front_page() ) : ?>
            <h1 class="logo-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $blog_name ) ?>"><?php echo esc_html( $blog_name ); ?></a>
            </h1>
		<?php else: ?>
            <p class="logo-title h1">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $blog_name ) ?>"><?php echo esc_html( $blog_name ); ?></a>
            </p>
		<?php endif;
		if ( get_bloginfo( 'description' ) ) : ?>
            <p class="site-description is-hidden"><?php bloginfo( 'description' ); ?></p>
		<?php endif; ?>
        </div><?php
	}
}

if ( ! function_exists( 'foxiz_get_logo_html' ) ) {
	/**
	 * @param $logo
	 * @param false $retina_logo
	 * @param string $classes
	 * @param string $mode
	 *
	 * @return false|string
	 */
	function foxiz_get_logo_html( $logo, $retina_logo = false, $classes = 'logo-default', $mode = 'default' ) {

		if ( empty( $logo['url'] ) && empty( $retina_logo['url'] ) ) {
			return false;
		}

		if ( empty( $retina_logo['url'] ) ) {

			$output = '<img class="' . esc_attr( $classes ) . '"';
			if ( ! empty( $mode ) ) {
				$output .= ' data-mode="' . esc_attr( $mode ) . '"';
			}
			if ( ! empty( $logo['height'] ) ) {
				$output .= ' height="' . esc_attr( $logo['height'] ) . '"';
			}
			if ( ! empty( $logo['width'] ) ) {
				$output .= ' width="' . esc_attr( $logo['width'] ) . '"';
			}

			$output .= ' src="' . esc_url( $logo['url'] ) . '"';
			$output .= ' alt="' . get_bloginfo( 'name' ) . '">';

			return $output;
		} elseif ( empty( $logo['url'] ) ) {

			$logo = $retina_logo;

			$output = '<img class="' . esc_attr( $classes ) . '"';
			if ( ! empty( $mode ) ) {
				$output .= ' data-mode="' . esc_attr( $mode ) . '"';
			}
			if ( ! empty( $logo['height'] ) ) {
				$output .= ' height="' . intval( $logo['height'] / 2 ) . '"';
			}
			if ( ! empty( $logo['width'] ) ) {
				$output .= ' width="' . intval( $logo['width'] / 2 ) . '"';
			}

			$output .= ' src="' . esc_url( $logo['url'] ) . '"';
			$output .= ' alt="' . get_bloginfo( 'name' ) . '">';

			return $output;
		}

		$output = '<img class="' . esc_attr( $classes ) . '"';
		if ( ! empty( $mode ) ) {
			$output .= ' data-mode="' . esc_attr( $mode ) . '"';
		}
		if ( ! empty( $logo['height'] ) ) {
			$output .= ' height="' . esc_attr( $logo['height'] ) . '"';
		}
		if ( ! empty( $logo['width'] ) ) {
			$output .= ' width="' . esc_attr( $logo['width'] ) . '"';
		}
		$output .= ' src="' . esc_url( $logo['url'] ) . '" srcset="' . esc_url( $logo['url'] ) . ' 1x,' . esc_url( $retina_logo['url'] ) . ' 2x"';
		$output .= ' alt="' . get_bloginfo( 'name' ) . '">';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_render_logo' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_render_logo( $settings = array() ) {

		if ( empty( $settings['logo']['url'] ) && empty( $settings['retina_logo']['url'] ) ) {
			foxiz_render_text_logo();

			return false;
		}

		$blog_name    = get_bloginfo( 'name' );
		$class_name   = array();
		$class_name[] = 'logo-wrap';
		if ( ! empty( $settings['classes'] ) ) {
			$class_name[] = $settings['classes'];
		}
		$class_name[] = 'is-image-logo site-branding';
		if ( foxiz_is_svg( $settings['logo']['url'] ) ) {
			$class_name[] = 'is-logo-svg';
		}
		?>
        <div class="<?php echo implode( ' ', $class_name ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" title="<?php echo esc_attr( $blog_name ); ?>">
				<?php echo foxiz_get_logo_html( $settings['logo'], $settings['retina_logo'] );
				if ( foxiz_dark_mode() ) {
					echo foxiz_get_logo_html( $settings['dark_logo'], $settings['dark_retina_logo'], 'logo-dark', 'dark' );
				}
				if ( ! empty( $settings['transparent'] ) ) {
					echo foxiz_get_logo_html( $settings['transparent_logo'], $settings['transparent_retina_logo'], 'logo-transparent', false );
				}
				if ( is_front_page() && empty( $settings['disable_info'] ) ) : ?>
                    <h1 class="logo-title hidden"><?php echo esc_html( $blog_name ); ?></h1>
					<?php if ( get_bloginfo( 'description' ) ) : ?>
                        <p class="site-description hidden"><?php bloginfo( 'description' ); ?></p>
					<?php endif;
				endif; ?>
            </a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_mobile_logo' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_render_mobile_logo( $settings = array() ) {

		if ( empty( $settings['mobile_logo']['url'] ) ) {
			$settings['classes'] = 'mobile-logo-wrap';
			foxiz_render_logo( $settings );

			return false;
		}

		$blog_name    = get_bloginfo( 'name' );
		$class_name   = array();
		$class_name[] = 'mobile-logo-wrap is-image-logo site-branding';
		if ( foxiz_is_svg( $settings['mobile_logo']['url'] ) ) {
			$class_name[] = 'is-logo-svg';
		}
		?>
        <div class="<?php echo implode( ' ', $class_name ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $blog_name ) ?>">
				<?php
				echo foxiz_get_logo_html( $settings['mobile_logo'] );
				if ( foxiz_dark_mode() ) {
					if ( empty( $settings['dark_mobile_logo']['url'] ) ) {
						$settings['dark_mobile_logo'] = $settings['dark_logo'];
					}
					echo foxiz_get_logo_html( $settings['dark_mobile_logo'], false, 'logo-dark', 'dark' );
				} ?>
            </a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_top_site' ) ) {
	/**
	 * render top site
	 */
	function foxiz_render_top_site() {

		do_action( 'foxiz_top_site' );
	}
}

if ( ! function_exists( 'foxiz_render_main_menu' ) ) {
	/**
	 * @param string $classes
	 * @param false $sub_scheme
	 */
	function foxiz_render_main_menu( $classes = '', $sub_scheme = false ) {

		$class_name = 'main-menu-wrap';
		if ( ! empty( $classes ) ) {
			$class_name .= ' ' . $classes;
		}

		$args = array(
			'theme_location' => 'foxiz_main',
			'menu_id'        => false,
			'container'      => '',
			'menu_class'     => 'main-menu rb-menu large-menu',
			'walker'         => new Foxiz_Walker_Nav_Menu(),
			'depth'          => 4,
			'items_wrap'     => '<ul id="%1$s" class="%2$s" itemscope itemtype="' . foxiz_protocol() . '://www.schema.org/SiteNavigationElement">%3$s</ul>',
			'echo'           => true,
			'fallback_cb'    => 'foxiz_navigation_fallback',
			'fallback_name'  => esc_html__( 'Main Menu', 'foxiz' )
		);

		if ( ! empty( $sub_scheme ) ) {
			$args['sub_scheme'] = 'light-scheme';
		}
		?>
        <nav id="site-navigation" class="<?php echo esc_attr( $class_name ); ?>" aria-label="<?php esc_attr_e( 'main menu', 'foxiz' ); ?>"><?php wp_nav_menu( $args ); ?></nav>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_nav_right' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_render_nav_right( $settings ) {

		if ( ! empty( $settings['header_login_icon'] ) ) {
			foxiz_header_user( $settings );
		}
		if ( ! empty( $settings['header_socials'] ) ) {
			foxiz_header_socials( $settings );
		}
		foxiz_header_mini_cart();
		if ( ! empty( $settings['header_notification'] ) ) {
			foxiz_header_notification( $settings );
		}
		if ( ! empty( $settings['header_search_icon'] ) ) {
			foxiz_header_search( $settings );
		}
		if ( ! empty( $settings['single_font_resizer'] ) ) {
			foxiz_header_font_resizer();
		}
		foxiz_dark_mode_switcher( $settings );
	}
}

if ( ! function_exists( 'foxiz_header_user' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_header_user( $settings = array() ) {

		$login_redirect  = foxiz_get_option( 'login_redirect' );
		$logout_redirect = foxiz_get_option( 'logout_redirect' );
		$icon            = foxiz_get_option( 'login_custom_icon' );

		if ( empty( $login_redirect ) ) {
			$login_redirect = foxiz_get_current_permalink();
		}
		if ( empty( $logout_redirect ) ) {
			$logout_redirect = foxiz_get_current_permalink();
		}
		if ( empty( $settings['login_icon'] ) && ! empty( $icon['url'] ) ) {
			$settings['login_icon'] = $icon['url'];
		} ?>
        <div class="wnav-holder widget-h-login header-dropdown-outer">
			<?php if ( is_user_logged_in() && ! is_admin() ) :
				global $current_user; ?>
                <a class="dropdown-trigger is-logged header-element" href="#">
                    <span class="logged-avatar"><?php echo get_avatar( $current_user->ID, 60 ); ?></span>
                    <span class="logged-welcome"><?php echo foxiz_html__( 'Hi,', 'foxiz' ) . '<strong>' . $current_user->display_name . '</strong>'; ?></span>
                </a>
                <div class="header-dropdown user-dropdown">
					<?php if ( ! empty( $settings['header_login_menu'] ) ) {
						wp_nav_menu( array(
							'menu'        => $settings['header_login_menu'],
							'menu_class'  => 'logged-user-menu',
							'menu_id'     => false,
							'container'   => false,
							'depth'       => 1,
							'echo'        => true,
							'fallback_cb' => '__return_false',
						) );
					}
					?>
                    <div class="logout-wrap">
                        <a class="logout-url" href="<?php echo wp_logout_url( $logout_redirect ); ?>"><?php echo foxiz_html__( 'Sign Out', 'foxiz' ) . foxiz_get_svg( 'logout' ); ?></a>
                    </div>
                </div>
			<?php else : ?>
				<?php if ( empty( $settings['header_login_layout'] ) ) : ?>
                    <a href="<?php echo wp_login_url( $login_redirect ); ?>" class="login-toggle is-login header-element" data-title="<?php foxiz_html_e( 'Sign In', 'foxiz' ); ?>"><?php
						if ( ! empty( $settings['login_icon'] ) ) {
							echo '<span class="login-icon-svg"></span>';
						} else {
							foxiz_render_svg( 'user' );
						} ?></a>
				<?php elseif ( '1' === $settings['header_login_layout'] ) : ?>
                    <a href="<?php echo wp_login_url( $login_redirect ); ?>" class="login-toggle is-login is-btn header-element"><span><?php foxiz_html_e( 'Sign In', 'foxiz' ); ?></span></a>
				<?php else : ?>
                    <a href="<?php echo wp_login_url( $login_redirect ); ?>" class="login-toggle is-login is-btn is-btn-icon header-element"><?php
						if ( ! empty( $settings['login_icon'] ) ) {
							echo '<span class="login-icon-svg"></span>';
						} else {
							foxiz_render_svg( 'user' );
						} ?><span><?php foxiz_html_e( 'Sign In', 'foxiz' ); ?></span></a>
				<?php endif; ?>
			<?php endif; ?>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_header_search' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_header_search( $settings = array() ) {

		$classes = array();
		if ( ! empty( $settings['header_search_custom_icon']['url'] ) ) {
			$search_icon = array(
				'url' => $settings['header_search_custom_icon']
			);
		} else {
			$search_icon = foxiz_get_option( 'header_search_custom_icon' );
		}
		$classes[] = 'icon-holder header-element search-btn';
		if ( empty( $settings['header_search_mode'] ) || 'search' === $settings['header_search_mode'] ) {
			$classes[] = 'search-trigger';
		} else {
			$classes[] = 'more-trigger';
		}
		$dropdown_classes = 'header-dropdown';
		if ( ! empty( $settings['header_search_scheme'] ) ) {
			$dropdown_classes .= ' light-scheme';
		}
		?>
        <div class="wnav-holder w-header-search header-dropdown-outer">
            <a href="#" data-title="<?php foxiz_html_e( 'Search', 'foxiz' ); ?>" class="<?php echo join( ' ', $classes ); ?>">
				<?php if ( ! empty( $search_icon['url'] ) ) {
					echo '<span class="search-icon-svg"></span>';
				} else {
					echo '<i class="rbi rbi-search wnav-icon"></i>';
				} ?>
            </a>
			<?php if ( empty( $settings['header_search_mode'] ) || 'search' === $settings['header_search_mode'] ) :
				$form_classes = 'header-search-form';
				if ( ! empty( $settings['ajax_search'] ) ) {
					$form_classes .= ' live-search-form';
				}
				?>
                <div class="<?php echo esc_attr( $dropdown_classes ); ?>">
                <div class="<?php echo esc_attr( $form_classes ); ?>">
					<?php foxiz_search_form( $placeholder = '', $label = '', $icon = true, $search_icon ); ?>
					<?php if ( ! empty( $settings['ajax_search'] ) ) : ?>
                        <span class="live-search-animation rb-loader"></span>
                        <div class="live-search-response"></div>
					<?php endif; ?>
                </div>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_header_search_form' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_header_search_form( $settings = array() ) {

		$class_name = 'header-search-form';
		if ( foxiz_get_option( 'ajax_search' ) ) {
			$class_name .= ' live-search-form';
		}
		?>
        <div class="<?php echo esc_attr( $class_name ); ?>">
			<?php if ( ! empty( $settings['header_search_heading'] ) ) : ?>
                <span class="h5"><?php echo esc_html( $settings['header_search_heading'] ); ?></span>
			<?php endif;
			if ( foxiz_get_option( 'ajax_search' ) ) : ?>
                <div class="live-search-form-outer">
					<?php foxiz_search_form(); ?>
                    <span class="live-search-animation rb-loader"></span>
                    <div class="live-search-absolute live-search-response"></div>
                </div>
			<?php else : foxiz_search_form();
			endif; ?></div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_burger_icon' ) ) {
	function foxiz_burger_icon() { ?>
        <span class="burger-icon"><span></span><span></span><span></span></span>
	<?php }
}

if ( ! function_exists( 'foxiz_header_more' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_header_more( $settings ) {

		if ( empty( $settings['more'] ) ) {
			return false;
		} ?>
        <div class="more-section-outer menu-has-child-flex menu-has-child-mega-columns layout-col-<?php echo foxiz_get_option( 'more_column', 2 ); ?>">
            <a class="more-trigger icon-holder" href="#" data-title="<?php foxiz_html_e( 'More', 'foxiz' ); ?>">
                <span class="dots-icon"><span></span><span></span><span></span></span>
            </a>
            <div id="rb-more" class="more-section flex-dropdown">
                <div class="more-section-inner">
                    <div class="more-content">
						<?php if ( ! empty( $settings['more_search'] ) ) {
							foxiz_header_search_form( $settings );
						}
						if ( is_active_sidebar( 'foxiz_sidebar_more' ) ) : ?>
                            <div class="mega-columns">
								<?php dynamic_sidebar( 'foxiz_sidebar_more' ); ?>
                            </div>
						<?php endif; ?>
                    </div>
					<?php if ( ! empty( $settings['more_footer_menu'] ) || ! empty( $settings['more_footer_copyright'] ) ) : ?>
                        <div class="collapse-footer">
							<?php if ( ! empty( $settings['more_footer_menu'] ) ) : ?>
                                <div class="collapse-footer-menu"><?php
									wp_nav_menu( array(
										'menu'        => $settings['more_footer_menu'],
										'menu_id'     => false,
										'container'   => false,
										'menu_class'  => 'collapse-footer-menu-inner',
										'depth'       => 1,
										'echo'        => true,
										'fallback_cb' => '__return_false',
									) );
									?></div>
							<?php endif;
							if ( ! empty( $settings['more_footer_copyright'] ) ) : ?>
                                <div class="collapse-copyright"><?php echo wp_kses( $settings['more_footer_copyright'], 'foxiz' ); ?></div>
							<?php endif; ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_header_mobile' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_header_mobile( $settings = array() ) {

		?>
        <div id="header-mobile" class="header-mobile">
            <div class="header-mobile-wrap">
				<?php if ( empty( $settings['mh_layout'] ) ) {
					foxiz_header_mobile_layout_default( $settings );
				} elseif ( '1' === (string) $settings['mh_layout'] ) {
					foxiz_header_mobile_layout_center( $settings );
				} elseif ( '2' === (string) $settings['mh_layout'] ) {
					foxiz_header_mobile_layout_left_logo( $settings );
				}
				echo foxiz_get_mobile_quick_access(); ?>
            </div>
			<?php foxiz_mobile_collapse( $settings ); ?>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_get_mobile_quick_access' ) ) {
	function foxiz_get_mobile_quick_access() {

		return wp_nav_menu( array(
			'theme_location'  => 'foxiz_mobile_quick',
			'container_class' => 'mobile-qview',
			'menu_class'      => 'mobile-qview-inner',
			'depth'           => 1,
			'echo'            => false,
			'fallback_cb'     => '__return_false',
		) );
	}
}

if ( ! function_exists( 'foxiz_header_mobile_layout_default' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_header_mobile_layout_default( $settings = array() ) { ?>
        <div class="mbnav edge-padding">
            <div class="navbar-left">
                <div class="mobile-toggle-wrap">
					<?php if ( ! foxiz_is_amp() ) : ?>
                        <a href="#" class="mobile-menu-trigger"><?php foxiz_burger_icon(); ?></a>
					<?php else : ?>
                        <span class="mobile-menu-trigger" on="tap:AMP.setState({collapse: !collapse})"><?php foxiz_burger_icon(); ?></span>
					<?php endif; ?>
                </div>
				<?php foxiz_render_mobile_logo( $settings ); ?>
            </div>
            <div class="navbar-right">
				<?php
				foxiz_mobile_header_mini_cart();
				foxiz_mobile_search_icon();
				if ( ! empty( $settings['single_font_resizer'] ) ) {
					foxiz_header_font_resizer();
				}
				foxiz_dark_mode_switcher( $settings ); ?>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_header_mobile_layout_center' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_header_mobile_layout_center( $settings = array() ) { ?>
        <div class="mbnav mbnav-center edge-padding">
            <div class="navbar-left">
                <div class="mobile-toggle-wrap">
					<?php if ( ! foxiz_is_amp() ) : ?>
                        <a href="#" class="mobile-menu-trigger"><?php foxiz_burger_icon(); ?></a>
					<?php else : ?>
                        <span class="mobile-menu-trigger" on="tap:AMP.setState({collapse: !collapse})"><?php foxiz_burger_icon(); ?></span>
					<?php endif; ?>
                </div>
				<?php if ( ! empty( $settings['single_font_resizer'] ) ) {
					foxiz_header_font_resizer();
				} ?>
            </div>
            <div class="navbar-center">
				<?php foxiz_render_mobile_logo( $settings ); ?>
            </div>
            <div class="navbar-right">
				<?php
				foxiz_mobile_header_mini_cart();
				foxiz_mobile_search_icon();
				foxiz_dark_mode_switcher( $settings ); ?>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_header_mobile_layout_left_logo' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_header_mobile_layout_left_logo( $settings = array() ) { ?>
        <div class="mbnav edge-padding">
            <div class="navbar-left">
				<?php foxiz_render_mobile_logo( $settings ); ?>
            </div>
            <div class="navbar-right">
				<?php
				foxiz_mobile_header_mini_cart();
				foxiz_mobile_search_icon();
				if ( ! empty( $settings['single_font_resizer'] ) ) {
					foxiz_header_font_resizer();
				}
				foxiz_dark_mode_switcher( $settings ); ?>
                <div class="mobile-toggle-wrap">
					<?php if ( ! foxiz_is_amp() ) : ?>
                        <a href="#" class="mobile-menu-trigger"><?php foxiz_burger_icon(); ?></a>
					<?php else : ?>
                        <span class="mobile-menu-trigger" on="tap:AMP.setState({collapse: !collapse})"><?php foxiz_burger_icon(); ?></span>
					<?php endif; ?>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_mobile_collapse' ) ) {
	/**
	 * @param $settings
	 */
	function foxiz_mobile_collapse( $settings = array() ) {

		$login_redirect = foxiz_get_option( 'login_redirect' );
		if ( empty( $login_redirect ) ) {
			$login_redirect = foxiz_get_current_permalink();
		}
		?>
        <div class="mobile-collapse">
        <div class="mobile-collapse-holder">
            <div class="mobile-collapse-inner">
                <div class="mobile-search-form edge-padding"><?php foxiz_header_search_form( $settings ); ?></div>
                <nav class="mobile-menu-wrap edge-padding">
					<?php wp_nav_menu( array(
						'theme_location' => 'foxiz_mobile',
						'menu_id'        => 'mobile-menu',
						'menu_class'     => 'mobile-menu',
						'container'      => false,
						'depth'          => 2,
						'echo'           => true,
						'fallback_cb'    => 'foxiz_navigation_fallback',
						'fallback_name'  => esc_html__( 'Mobile Menu', 'foxiz' )
					) ); ?>
                </nav>
                <div class="mobile-collapse-sections edge-padding">
					<?php if ( ! empty( $settings['mobile_login'] ) && ! is_user_logged_in() && ! foxiz_is_amp() ) : ?>
                        <div class="mobile-login">
                            <span class="mobile-login-title h6"><?php foxiz_html_e( 'Have an existing account?', 'foxiz' ); ?></span>
                            <a href="<?php echo wp_login_url( $login_redirect ); ?>" class="login-toggle is-login is-btn"><?php foxiz_html_e( 'Sign In', 'foxiz' ); ?></a>
                        </div>
					<?php endif;
					if ( ! empty( $settings['mobile_social'] ) ) : ?>
                        <div class="mobile-social-list">
                            <span class="mobile-social-list-title h6"><?php foxiz_html_e( 'Follow US', 'foxiz' ); ?></span>
							<?php echo foxiz_get_social_list( $settings ); ?>
                        </div>
					<?php endif; ?>
                </div>
				<?php if ( ! empty( $settings['mobile_footer_menu'] ) || ! empty( $settings['mobile_copyright'] ) ) : ?>
                    <div class="collapse-footer">
						<?php if ( ! empty( $settings['mobile_footer_menu'] ) ) : ?>
                            <div class="collapse-footer-menu"><?php
								wp_nav_menu( array(
									'menu'        => $settings['mobile_footer_menu'],
									'menu_id'     => false,
									'container'   => false,
									'menu_class'  => 'collapse-footer-menu-inner',
									'depth'       => 1,
									'echo'        => true,
									'fallback_cb' => '__return_false',
								) );
								?></div>
						<?php endif;
						if ( ! empty( $settings['mobile_copyright'] ) ) : ?>
                            <div class="collapse-copyright"><?php echo wp_kses( $settings['mobile_copyright'], 'foxiz' ); ?></div>
						<?php endif; ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_dark_mode_switcher' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_dark_mode_switcher( $settings = array() ) {

		if ( empty( $settings['dark_mode'] ) || foxiz_is_amp() ) {
			return false;
		} ?>
        <div class="dark-mode-toggle-wrap">
            <div class="dark-mode-toggle">
                <span class="dark-mode-slide">
                    <i class="dark-mode-slide-btn mode-icon-dark" data-title="<?php foxiz_html_e( 'Switch to Light', 'foxiz' ); ?>"><?php foxiz_render_svg( 'mode-dark' ); ?></i>
                    <i class="dark-mode-slide-btn mode-icon-default" data-title="<?php foxiz_html_e( 'Switch to Dark', 'foxiz' ); ?>"><?php foxiz_render_svg( 'mode-light' ); ?></i>
                </span>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_header_notification' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_header_notification( $settings = array() ) {

		if ( foxiz_is_amp() ) {
			return false;
		}
		$new_notification = get_option( 'rb_push_notification' );
		$icon             = foxiz_get_option( 'notification_custom_icon' );
		$classes          = 'notification-popup';
		if ( ! empty( $settings['header_notification_scheme'] ) ) {
			$classes .= ' light-scheme';
		} ?>
        <div class="wnav-holder header-dropdown-outer">
            <a href="#" class="dropdown-trigger notification-icon" data-notification="<?php echo esc_attr( $new_notification ); ?>">
                <span class="notification-icon-inner" data-title="<?php foxiz_html_e( 'Notification', 'foxiz' ); ?>">
                    <?php if ( ! empty( $icon['url'] ) ) : ?>
                        <span class="notification-icon-svg"></span>
                    <?php else : ?>
                        <i class="rbi rbi-notification wnav-icon"></i>
                    <?php endif; ?>
                    <span class="notification-info"></span>
                </span>
            </a>
            <div class="header-dropdown notification-dropdown">
                <div class="<?php echo esc_attr( $classes ); ?>">
                    <div class="notification-header">
                        <span class="h4"><?php foxiz_html_e( 'Notification', 'foxiz' ); ?></span>
						<?php if ( ! empty( $settings['header_notification_url'] ) ) : ?>
                            <a class="notification-url meta-text" href="<?php echo esc_url( $settings['header_notification_url'] ); ?>"><?php foxiz_html_e( 'Show More', 'foxiz' ); ?>
                                <i class="rbi rbi-cright"></i></a>
						<?php endif; ?>
                    </div>
                    <div class="notification-content">
                        <div class="scroll-holder">
							<?php
							$bookmark_query = Foxiz_Bookmark::get_instance()->saved_posts_query( array( 'posts_per_page' => 9 ) );
							if ( ! empty( $bookmark_query ) && $bookmark_query->have_posts() ) : ?>
                                <div class="notification-bookmark">
                                    <span class="h4 notification-content-title"><i class="rbi rbi-bookmark-fill"></i><?php foxiz_html_e( 'Recent Saved', 'foxiz' ); ?></span>
                                    <div class="block-inner p-middle">
										<?php
										foxiz_loop_list_small_2(
											array(
												'design_override' => true,
												'edit_link'       => false,
												'bookmark'        => false,
												'entry_meta'      => array('category'),
											),
											$bookmark_query );
										wp_reset_postdata();
										?>
                                    </div>
                                </div>
							<?php endif; ?>
                            <div class="notification-latest">
                                <span class="h5 notification-content-title"><i class="rbi rbi-clock"></i><?php foxiz_html_e( 'Latest News', 'foxiz' ); ?></span>
                                <?php echo foxiz_get_list_small_2(
									array(
										'design_override'   => true,
										'uuid'              => 'uid_notification',
										'edit_link'         => false,
										'bookmark'          => false,
										'pagination'        => 'infinite_scroll',
										'entry_meta'        => 'category',
										'middle_mode'       => '1',
										'posts_per_page'    => 5,
										'order'             => 'post_date',
										'duplicate_allowed' => 1,
									) ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_header_font_resizer' ) ) {
	/**
	 * @return false|void
	 */
	function foxiz_header_font_resizer() {

		if ( ! is_singular( array( 'post', 'rb-etemplate' ) ) || foxiz_is_amp() ) {
			return false;
		} ?>
        <div class="wnav-holder font-resizer">
            <a href="#" class="font-resizer-trigger" data-title="<?php foxiz_html_e( 'Resizer', 'foxiz' ) ?>"><strong><?php echo foxiz_html__( 'Aa', 'foxiz' ) ?></strong></a>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_header_alert' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false
	 */
	function foxiz_header_alert( $settings ) {

		$alert_bar = rb_get_meta( 'alert_bar', get_the_ID() );

		if ( ! empty( $alert_bar ) && '-1' === (string) $alert_bar ) {
			return false;
		}

		if ( ! empty( $alert_bar ) && '1' === (string) $alert_bar ) {
			echo foxiz_get_header_alert( $settings );

			return false;
		}

		if ( empty( $settings['alert_bar'] ) || ( ! empty( $settings['alert_home'] ) && ! is_front_page() ) ) {
			return false;
		}

		echo foxiz_get_header_alert( $settings );
	}
}

if ( ! function_exists( 'foxiz_get_header_alert' ) ) {
	/**
	 * @param $settings
	 *
	 * @return string
	 */
	function foxiz_get_header_alert( $settings ) {

		if ( empty( $settings['alert_content'] ) || empty( $settings['alert_url'] ) ) {
			return false;
		}

		$class_name = 'header-alert edge-padding';
		if ( ! empty( $settings['alert_sticky_hide'] ) ) {
			$class_name .= ' is-sticky-hide';
		}
		$output = '<a id="header-alert" class="' . esc_attr( $class_name ) . '" href="' . esc_url( $settings['alert_url'] ) . '" target="_blank" rel="noreferrer nofollow">';
		$output .= esc_html( trim( $settings['alert_content'] ) );
		$output .= '</a>';

		return $output;
	}
}

if ( ! function_exists( 'foxiz_top_ad' ) ) {
	/**
	 * @return false|void
	 */
	function foxiz_top_ad() {

		if ( ! foxiz_get_option( 'ad_top_code' ) && ! foxiz_get_option( 'ad_top_image' ) ) {
			return false;
		}

		$disable_top_ad = rb_get_meta( 'disable_top_ad', get_the_ID() );

		if ( ! empty( $disable_top_ad ) && '-1' === (string) $disable_top_ad ) {
			return false;
		}

		$classes = 'top-site-ad';
		if ( foxiz_get_option( 'ad_top_spacing' ) ) {
			$classes .= ' no-spacing';
		}

		if ( foxiz_get_option( 'ad_top_type' ) ) {
			$settings = array(
				'code'         => foxiz_get_option( 'ad_top_code' ),
				'size'         => foxiz_get_option( 'ad_top_size' ),
				'desktop_size' => foxiz_get_option( 'ad_top_desktop_size' ),
				'tablet_size'  => foxiz_get_option( 'ad_top_tablet_size' ),
				'mobile_size'  => foxiz_get_option( 'ad_top_mobile_size' )
			);
			if ( foxiz_get_adsense( $settings ) ) {
				echo '<div class="' . esc_attr( $classes ) . '">' . foxiz_get_adsense( $settings ) . '</div>';
			}
		} else {
			$settings = array(
				'image'       => foxiz_get_option( 'ad_top_image' ),
				'dark_image'  => foxiz_get_option( 'ad_top_dark_image' ),
				'destination' => foxiz_get_option( 'ad_top_destination' )
			);
			if ( foxiz_get_ad_image( $settings ) ) {
				echo '<div class="' . esc_attr( $classes ) . '">' . foxiz_get_ad_image( $settings ) . '</div>';
			}
		}
	}
}

if ( ! function_exists( 'foxiz_header_socials' ) ) {
	function foxiz_header_socials( $settings = array() ) {

		if ( ! empty( $settings['header_socials'] ) ) :
			?>
            <div class="header-social-list wnav-holder"><?php echo foxiz_get_social_list( $settings ); ?></div>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_header_mini_cart' ) ) {
	/**
	 * @return false
	 */
	function foxiz_header_mini_cart() {

		if ( ! foxiz_get_option( 'wc_mini_cart' ) || ! class_exists( 'Woocommerce' ) || ! function_exists( 'wc_get_cart_url' ) || foxiz_is_amp() ) {
			return false;
		}
		foxiz_header_mini_cart_html();
	}
}

if ( ! function_exists( 'foxiz_mobile_header_mini_cart' ) ) {
	/**
	 * @return false
	 */
	function foxiz_mobile_header_mini_cart() {

		if ( ! foxiz_get_option( 'wc_mobile_mini_cart' ) || ! class_exists( 'Woocommerce' ) || ! function_exists( 'wc_get_cart_url' ) || foxiz_is_amp() ) {
			return false;
		}

		foxiz_header_mini_cart_html( false );
	}
}

if ( ! function_exists( 'foxiz_header_mini_cart_html' ) ) {
	function foxiz_header_mini_cart_html( $dropdown_section = true ) {

		$class_name = 'cart-link';
		$cart_icon  = foxiz_get_option( 'cart_custom_icon' );
		if ( ! empty( $dropdown_section ) ) {
			$class_name .= ' dropdown-trigger';
		}
		?>
        <aside class="header-mini-cart wnav-holder header-dropdown-outer">
            <a class="<?php echo esc_attr( $class_name ); ?>" href="<?php echo esc_url( wc_get_cart_url() ) ?>" data-title="<?php foxiz_attr_e( 'View Cart', 'foxiz' ); ?>">
                <span class="cart-icon"><?php
	                if ( ! empty( $cart_icon['url'] ) ) : ?><span class="cart-icon-svg"></span><?php
	                else: ?><i class="wnav-icon rbi rbi-cart"></i><?php
	                endif;
	                if ( foxiz_get_option( 'cart_counter' ) ) : ?>
                        <span class="cart-counter"><?php echo esc_attr( ( is_object( WC()->cart ) ) ? WC()->cart->cart_contents_count : '0' ); ?></span>
	                <?php endif; ?></span>
				<?php if ( foxiz_get_option( 'total_amount' ) ) : ?>
                    <span class="total-amount"><?php echo ( is_object( WC()->cart ) ) ? WC()->cart->get_cart_subtotal() : '0'; ?></span>
				<?php endif; ?>
            </a>
			<?php if ( $dropdown_section && function_exists( 'woocommerce_mini_cart' ) && ! is_admin() ): ?>
                <div class="header-dropdown nav-mini-cart">
                    <div class="mini-cart-wrap woocommerce">
                        <div class="widget_shopping_cart_content">
							<?php woocommerce_mini_cart(); ?>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
        </aside>
	<?php }
}

if ( ! function_exists( 'foxiz_get_search_icon_svg' ) ) {
	function foxiz_get_search_icon_svg() {

		$icon = foxiz_get_option( 'header_search_custom_icon' );
		if ( ! empty( $icon['url'] ) ) {
			return '<span class="search-icon-svg"></span>';
		} else {
			return '<i class="rbi rbi-search"></i>';
		}
	}
}

if ( ! function_exists( 'foxiz_mobile_search_icon' ) ) {
	function foxiz_mobile_search_icon() { ?>
		<?php if ( foxiz_is_amp() && foxiz_get_option( 'mobile_amp_search' ) ) : ?>
            <span class="mobile-menu-trigger mobile-search-icon" on="tap:AMP.setState({collapse: !collapse})"><?php echo foxiz_get_search_icon_svg(); ?></span>
		<?php elseif ( foxiz_get_option( 'mobile_search' ) ) : ?>
            <a href="#" class="mobile-menu-trigger mobile-search-icon"><?php echo foxiz_get_search_icon_svg(); ?></a>
		<?php endif; ?>
	<?php }
}