<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nav_menu_item_title', 'foxiz_add_menu_title', 10, 4 );

if ( ! function_exists( 'foxiz_add_menu_title' ) ) {
	/**
	 * @param $title
	 * @param $item
	 * @param $args
	 * @param $depth
	 *
	 * @return string
	 */
	function foxiz_add_menu_title( $title, $item, $args, $depth ) {

		$settings = get_option( 'rb_menu_settings_' . Foxiz_Walker_Nav_Menu::get_menu_id( $args ), array() );
		$output   = '<span>';
		if ( ! empty( $settings[ $item->ID ]['icon'] ) ) {
			$output .= '<i class="menu-item-icon ' . esc_attr( $settings[ $item->ID ]['icon'] ) . '"></i>';
		} elseif ( ! empty( $settings[ $item->ID ]['icon_image'] ) ) {
			if ( ! empty( $settings[ $item->ID ]['dark_icon_image'] ) ) {
				$output .= '<span class="menu-item-svg">';
				$output .= '<img data-mode="default" src="' . esc_url( $settings[ $item->ID ]['icon_image'] ) . '" alt="' . esc_attr( $title ) . '">';
				$output .= '<img data-mode="dark" src="' . esc_url( $settings[ $item->ID ]['icon_image'] ) . '" alt="' . esc_attr( $title ) . '">';
				$output .= '</span>';
			} else {
				$output .= '<img class="icon-svg" src="' . esc_url( $settings[ $item->ID ]['icon_image'] ) . '" alt="' . esc_attr( $title ) . '">';
			}
		}
		$output .= $title;
		if ( ! empty( $settings[ $item->ID ]['sub_label'] ) ) {
			$output .= '<span class="menu-sub-title meta-text">' . esc_html( $settings[ $item->ID ]['sub_label'] ) . '</span>';
		}
		$output .= '</span>';

		return $output;
	}
}

if ( ! class_exists( 'Foxiz_Walker_Nav_Menu', false ) ) {
	/**
	 * Class Foxiz_Walker_Nav_Menu
	 */
	class Foxiz_Walker_Nav_Menu extends Walker_Nav_Menu {

		static function get_menu_id( $args ) {

			if ( ! empty( $args->menu->term_id ) ) {
				return intval( $args->menu->term_id );
			} elseif ( ! empty( $args->menu ) ) {
				$menu = wp_get_nav_menu_object( $args->menu );

				return $menu->term_id;
			}

			return false;
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

			$rb_settings = get_option( 'rb_menu_settings_' . self::get_menu_id( $args ), array() );
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			if ( empty( $depth ) && 'category' === $item->object && ! empty( $rb_settings[ $item->ID ]['category'] ) ) {
				$classes[] = 'menu-item-has-children menu-has-child-mega is-child-wide';
				if ( ! empty ( $rb_settings[ $item->ID ]['layout'] ) ) {
					$classes[] = 'mega-hierarchical';
				}
			} elseif ( empty( $depth ) && ( 'custom' === $item->object ) && ! empty ( $rb_settings[ $item->ID ]['mega_shortcode'] ) ) {
				$classes[] = 'menu-item-has-children menu-has-child-mega menu-has-child-mega-template';
				if ( empty( $rb_settings[ $item->ID ]['mega_width'] ) ) {
					$classes[] = 'is-child-wide';
				}
			} elseif ( empty( $depth ) && ( 'custom' === $item->object ) && ( ! empty ( $rb_settings[ $item->ID ]['columns'] ) ) ) {
				$classes[] = 'menu-item-has-children menu-has-child-mega menu-has-child-mega-columns';
				if ( empty( $rb_settings[ $item->ID ]['mega_width'] ) ) {
					$classes[] = 'is-child-wide';
				}
				if ( ! empty( $rb_settings[ $item->ID ]['mega_shortcode'] ) ) {
					$rb_settings[ $item->ID ]['columns_per_row'] = 1;
				}
				if ( ! empty ( $rb_settings[ $item->ID ]['columns_per_row'] ) ) {
					$classes[] = 'layout-col-' . $rb_settings[ $item->ID ]['columns_per_row'];
				}
			}

			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			if ( '_blank' === $item->target && empty( $item->xfn ) ) {
				$atts['rel'] = 'noopener';
			} else {
				$atts['rel'] = $item->xfn;
			}
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );

			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			if ( empty( $depth ) && 'category' === $item->object && ! empty( $rb_settings[ $item->ID ]['category'] ) ) {

				/** mega category */
				$mega_category_classes = 'mega-dropdown is-mega-category';
				$inner_classes         = 'mega-dropdown-inner';
				if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
					$mega_category_classes .= ' mega-menu-has-children';
				}

				if ( empty( $rb_settings[ $item->ID ]['sub_scheme'] ) ) {
					if ( ! empty( $args->sub_scheme ) ) {
						$inner_classes .= ' ' . esc_attr( $args->sub_scheme );
					}
				} elseif ( '1' === $rb_settings[ $item->ID ]['sub_scheme'] ) {
					$inner_classes .= ' light-scheme';
				}
				$item_output .= '<div class="' . esc_attr( $mega_category_classes ) . '">';
				$item_output .= '<div class="rb-container edge-padding">';
				$item_output .= '<div class="' . esc_attr( $inner_classes ) . '">';
			} elseif ( empty( $depth ) && ( 'custom' === $item->object ) && ! empty ( $rb_settings[ $item->ID ]['mega_shortcode'] ) ) {
				/** mega template */
				if ( ! empty( $rb_settings[ $item->ID ]['mega_width'] ) ) {
					$item_output .= '<div class="flex-dropdown is-mega-template" style="width:' . absint( $rb_settings[ $item->ID ]['mega_width'] ) . 'px">';
				} else {
					$item_output .= '<div class="mega-dropdown is-mega-template">';
				}
				$item_output   .= '<div class="mega-template-inner">';
			} elseif ( empty( $depth ) && ( 'custom' === $item->object ) && ! empty ( $rb_settings[ $item->ID ]['columns'] ) ) {

				/** mega columns */
				$inner_classes = 'mega-dropdown-inner';
				if ( empty( $rb_settings[ $item->ID ]['sub_scheme'] ) ) {
					if ( ! empty( $args->sub_scheme ) ) {
						$inner_classes .= ' ' . esc_attr( $args->sub_scheme );
					}
				} elseif ( '1' === $rb_settings[ $item->ID ]['sub_scheme'] ) {
					$inner_classes .= ' light-scheme';
				}
				if ( ! empty( $rb_settings[ $item->ID ]['mega_width'] ) ) {
					$item_output .= '<div class="flex-dropdown is-mega-column" style="width:' . absint( $rb_settings[ $item->ID ]['mega_width'] ) . 'px">';
				} else {
					$item_output .= '<div class="mega-dropdown is-mega-column">';
				}
				$item_output .= '<div class="rb-container edge-padding">';
				$item_output .= '<div class="' . esc_attr( $inner_classes ) . '">';
			}

			/** filter */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {

			$rb_settings = get_option( 'rb_menu_settings_' . self::get_menu_id( $args ), array() );

			if ( empty( $depth ) && 'category' === $item->object && ! empty( $rb_settings[ $item->ID ]['category'] ) ) {
				$output .= $this->category_mega_menu( $item, $rb_settings );
				$output .= '</div></div></div>';
			} elseif ( empty( $depth ) && ( 'custom' === $item->object ) && ! empty ( $rb_settings[ $item->ID ]['mega_shortcode'] ) ) {
				$output .= $this->column_mega_menu( $item, $rb_settings );
				$output .= '</div></div>';
			} elseif ( empty( $depth ) && ( 'custom' === $item->object ) && ( ! empty ( $rb_settings[ $item->ID ]['columns'] ) ) ) {
				$output .= $this->column_mega_menu( $item, $rb_settings );
				$output .= '</div></div></div>';
			}

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$output .= "</li>{$n}";
		}

		/**
		 * @param $item
		 * @param $rb_settings
		 *
		 * @return string
		 */
		public function category_mega_menu( $item, $rb_settings ) {

			if ( ! empty ( $rb_settings[ $item->ID ]['layout'] ) ) {
				return $this->blog_hierarchical( $item );
			} else {
				return $this->blog_default( $item );
			}
		}

		/** mega category default */
		public function blog_default( $item ) {

			$output = '';
			if ( ! empty( $item->object_id ) ) {

				$output .= '<div class="mega-header mega-header-fw">';
				$output .= '<span class="h4">' . esc_html( $item->title ) . '</span>';
				$output .= '<a class="mega-link is-meta" href="' . esc_url( $item->url ) . '"';
				if ( ! empty( $item->target ) ) {
					$output .= 'target="' . $item->target . '"';
				}
				$output .= '><span>' . foxiz_html__( 'Show More', 'foxiz' ) . '</span><i class="rbi rbi-cright"></i></a>';
				$output .= '</div>';

				$output .= foxiz_get_grid_small_1( array(
					'uuid'              => 'mega-listing-' . $item->ID,
					'duplicate_allowed' => 1,
					'columns'           => 5,
					'posts_per_page'    => 5,
					'title_tag'         => 'span',
					'crop_size'         => 'foxiz_crop_g1',
					'title_classes'     => 'h4',
					'review'            => 'replace',
					'entry_meta'        => 'date',
					'entry_category'    => '-1',
					'excerpt_length'    => '-1',
					'category'          => $item->object_id
				) );
			}

			return $output;
		}

		/**
		 * @param $item
		 *
		 * @return string
		 */
		public function blog_hierarchical( $item ) {

			$output = '';
			if ( ! empty( $item->object_id ) ) {
				$data        = get_option( 'foxiz_category_meta', array() );
				$description = term_description( $item->object_id );
				$featured    = '';
				if ( isset( $data[ $item->object_id ]['featured_image'] ) ) {
					$featured = $data[ $item->object_id ]['featured_image'];
				}

				$output .= '<div class="mega-col mega-col-intro">';
				$output .= '<div class="h3">';
				$output .= '<a class="p-url" href="' . esc_url( $item->url ) . '"';
				if ( ! empty( $item->target ) ) {
					$output .= 'target="' . $item->target . '"';
				}
				$output .= '>' . esc_html( $item->title ) . '</a></div>';
				$output .= foxiz_get_category_hero( $featured );
				if ( ! empty( $description ) ) {
					$output .= '<div class="cbox-description">' . wp_trim_words( $description, 25 ) . '</div>';
				}
				$output .= '<a class="mega-link p-readmore" href="' . esc_url( $item->url ) . '"';
				if ( ! empty( $item->target ) ) {
					$output .= 'target="' . $item->target . '"';
				}
				$output .= '><span>' . foxiz_html__( 'Show More', 'foxiz' ) . '</span><i class="rbi rbi-cright"></i></a>';
				$output .= '</div>';

				$output .= '<div class="mega-col mega-col-trending">';
				$output .= '<div class="mega-header">';
				$output .= '<i class="rbi rbi-trending"></i><span class="h4">' . foxiz_html__( 'Top News', 'foxiz' ) . '</span>';
				$output .= '</div>';

				$output .= foxiz_get_list_small_2( array(
					'uuid'              => 'mega-listing-trending-' . $item->ID,
					'duplicate_allowed' => 1,
					'posts_per_page'    => 3,
					'title_tag'         => 'span',
					'title_classes'     => 'h4',
					'category'          => $item->object_id,
					'order'             => 'comment_count',
					'review'            => 'replace',
					'entry_category'    => '-1',
					'excerpt_length'    => '-1',
					'entry_meta'        => 'date',
					'entry_format'      => 'bottom',
					'readmore'          => '-1',
				) );

				$output .= '</div>';

				$output .= '<div class="mega-col mega-col-latest">';
				$output .= '<div class="mega-header">';
				$output .= '<i class="rbi rbi-clock"></i><span class="h4">' . foxiz_html__( 'Latest News', 'foxiz' ) . '</span>';
				$output .= '</div>';

				$output .= foxiz_get_list_small_1( array(
					'uuid'               => 'mega-listing-latest-' . $item->ID,
					'duplicate_allowed'  => 1,
					'posts_per_page'     => 4,
					'title_tag'          => 'span',
					'title_classes'      => 'h4',
					'category'           => $item->object_id,
					'review'             => 'replace',
					'entry_format'       => 'false',
					'review_description' => '-1',
					'entry_category'     => '-1',
					'entry_meta'         => 'date',
					'excerpt_length'     => '-1',
					'readmore'           => '-1',
					'bottom_border'      => 'gray',
                    'last_bottom_border' => '-1'
				) );

				$output .= '</div>';
			}

			return $output;
		}

		/**
		 * @param $item
		 * @param $rb_settings
		 *
		 * @return false|string
		 */
		public function column_mega_menu( $item, $rb_settings ) {

			ob_start();
			if ( ! empty( $rb_settings[ $item->ID ]['mega_shortcode'] ) ) : ?>
				<?php echo do_shortcode( stripslashes( $rb_settings[ $item->ID ]['mega_shortcode'] ) ); ?>
			<?php elseif ( is_active_sidebar( $rb_settings[ $item->ID ]['columns'] ) ) : ?>
                <div class="mega-columns">
					<?php dynamic_sidebar( $rb_settings[ $item->ID ]['columns'] ); ?>
                </div>
			<?php endif;

			return ob_get_clean();
		}
	}
}
