<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RB_META', false ) ) {
	/**
	 * Class RB_META
	 */
	class  RB_META {

		private static $instance;

		const RB_META_VERSION = 1;

		static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		/**
		 * RB_META constructor.
		 * __construct
		 */
		function __construct() {
			self::$instance = $this;

			add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ), 20 );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'init', array( $this, 'fallback_name' ) );
			add_action( 'save_post', array( $this, 'save' ), 0 );

			add_action( 'edit_form_top', array( $this, 'create_nonce' ) );
			add_action( 'block_editor_meta_box_hidden_fields', array( $this, 'create_nonce' ) );
			add_action( 'wp_ajax_rb_meta_gallery', array( $this, 'gallery_update' ) );
		}

		/**
		 * fallback meta ID
		 */
		function fallback_name() {

			if ( ! defined( 'RB_META_ID' ) ) {
				define( 'RB_META_ID', 'rb_global_meta' );
			}
		}

		/**
		 * create nonce
		 */
		function create_nonce() {

			wp_nonce_field( basename( __FILE__ ), 'rb_meta_nonce' );
		}

		/**
		 * register_meta_boxes
		 */
		public function register_meta_boxes() {

			global $post;
			global $pagenow;
			global $rb_meta_boxes;

			$rb_meta_boxes = array();
			$rb_meta_boxes = apply_filters( 'rb_meta_boxes', $rb_meta_boxes );

			if ( is_array( $rb_meta_boxes ) ) {

				foreach ( $rb_meta_boxes as $section ) {
					if ( ! empty( $pagenow ) && 'post.php' === $pagenow && is_array( $section['post_types'] ) && in_array( 'page', $section['post_types'] ) ) {
						$current_template = get_post_meta( $post->ID, '_wp_page_template', true );
						if ( ! empty( $section['except_template'] ) && $section['except_template'] === $current_template ) {
							continue;
						}
						if ( ! empty( $section['include_template'] ) && $section['include_template'] !== $current_template ) {
							continue;
						}
					}

					$section = wp_parse_args( $section, array(
						'id'         => '',
						'title'      => 'Ruby Meta Box',
						'context'    => 'normal',
						'post_types' => array( 'post' ),
						'priority'   => 'high',
					) );

					add_meta_box( 'rb_meta_' . $section['id'], $section['title'], array(
						$this,
						'settings_form'
					), $section['post_types'], $section['context'], $section['priority'], $section );
				}
			}
		}

		public function register_scripts( $hook ) {

			if ( $hook === 'post.php' || $hook === 'post-new.php' ) {
				wp_enqueue_media();
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_register_script( 'rb-meta-script', plugin_dir_url( __FILE__ ) . '/assets/meta.js', array(
					'jquery',
					'jquery-ui-datepicker'
				), self::RB_META_VERSION, true );
				wp_register_style( 'rb-meta-style', plugin_dir_url( __FILE__ ) . '/assets/meta.css', array(), self::RB_META_VERSION, 'all' );
				wp_localize_script( 'rb-meta-script', 'rbMetaParams', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
				wp_enqueue_style( 'rb-meta-style' );
				wp_enqueue_script( 'rb-meta-script' );
			}
		}

		/**
		 * @param $post_id
		 * save metaboxes
		 */
		function save( $post_id ) {

			$is_autosave = wp_is_post_autosave( $post_id );
			$is_revision = wp_is_post_revision( $post_id );

			if ( ! empty( $_POST['rb_meta_nonce'] ) && wp_verify_nonce( $_POST['rb_meta_nonce'], basename( __FILE__ ) ) ) {
				$is_valid_nonce = true;
			} else {
				$is_valid_nonce = false;
			}

			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return false;
			}

			if ( isset( $_POST['rb_meta'] ) ) {

				$stored_meta = get_post_meta( $post_id, RB_META_ID, true );
				if ( ! is_array( $stored_meta ) ) {
					$stored_meta = array();
				}

				$rb_meta_data = $_POST['rb_meta'];

				if ( is_array( $rb_meta_data ) ) {
					foreach ( $rb_meta_data as $meta_id => $meta_val ) {
						$meta_id = sanitize_text_field( $meta_id );

						/** sanitize_text_field */
						if ( ! current_user_can( 'unfiltered_html' ) ) {
							if ( is_array( $meta_val ) ) {
								foreach ( $meta_val as $key => $val ) {
									if ( is_array( $val ) ) {
										$meta_val[ $key ] = array_map( 'sanitize_text_field', $val );
									} else {
										$meta_val[ $key ] = sanitize_text_field( $val );
									}
								}
							} else {
								$meta_val = sanitize_text_field( $meta_val );
							}
						}

						if ( ! empty( $meta_val['type'] ) ) {
							if ( $meta_val['type'] === 'datetime' ) {
								if ( ! empty( $meta_val['date'] ) ) {
									if ( empty( $meta_val['time'] ) || ! preg_match( "/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $meta_val['time'] ) ) {
										$meta_val['time'] = '';
									}
									$stored_meta[ $meta_id ] = strtotime( $meta_val['date'] . ' ' . $meta_val['time'] );
									if ( ! empty( $meta_val['key'] ) ) {
										update_post_meta( $post_id, $meta_val['key'], $stored_meta[ $meta_id ] );
									}
								} else {
									$stored_meta[ $meta_id ] = '';
									if ( isset( $meta_val['kvd'] ) ) {
										update_post_meta( $post_id, $meta_val['key'], $meta_val['kvd'] );
									} else {
										update_post_meta( $post_id, $meta_val['key'], '' );
									}
								}
							}
						} else {
							$stored_meta[ $meta_id ] = $meta_val;
						}
					}
				};

				update_post_meta( $post_id, RB_META_ID, $stored_meta );
			}
		}

		/**
		 * @param $post
		 * @param $callback_args
		 * settings form
		 */
		function settings_form( $post, $callback_args ) {

			$stored_meta = get_post_meta( $post->ID, RB_META_ID, true );

			if ( empty( $callback_args['args'] ) ) {
				return;
			}

			$section             = $callback_args['args'];
			$wrapper_classname   = array();
			$wrapper_classname[] = 'rb-meta-wrapper';
			$heading             = '';
			$description         = '';

			if ( ! empty( $callback_args['args']['heading'] ) ) {
				$heading = $callback_args['args']['heading'];
			} elseif ( ! empty( $callback_args['args']['title'] ) ) {
				$heading = $callback_args['args']['title'];
			}

			if ( ! empty( $callback_args['args']['desc'] ) ) {
				$description = $callback_args['args']['desc'];
			}

			if ( empty( $section['tabs'] ) || ! is_array( $section['tabs'] ) ) {

				if ( ! isset( $section['fields'] ) ) {
					$section['fields'] = array();
				}

				$section['tabs']     = array(
					array(
						'id'     => 'rb-meta-none-tab',
						'title'  => '',
						'fields' => $section['fields']
					)
				);
				$wrapper_classname[] = 'rb-meta-none-tab';
			}

			if ( ! empty( $section['context'] ) ) {
				$wrapper_classname[] = 'context-' . esc_attr( $section['context'] );
			}
			$wrapper_classname = implode( ' ', $wrapper_classname );

			$rb_last_tab = '';
			$data_attrs  = 'data-section_id = rb_meta_' . $section['id'];

			if ( ! empty( $section['except_template'] ) ) {
				$data_attrs .= ' data-except_template=' . esc_attr( $section['except_template'] ) . '';
			}

			if ( ! empty( $section['include_template'] ) ) {
				$data_attrs .= ' data-include_template=' . esc_attr( $section['include_template'] ) . '';
			}
			if ( ! empty( $stored_meta['last_tab'] ) && ! empty( $stored_meta['last_tab'][ $section['id'] ] ) ) {
				$rb_last_tab = $stored_meta['last_tab'][ $section['id'] ];
			}; ?>
			<?php if ( ! empty( $heading ) ) : ?>
                <div class="rb-meta-panel-header">
	                <h3><?php echo esc_html( $heading ) ?></h3>
					<?php if ( ! empty( $description ) ) : ?>
					<p><?php echo esc_html($description); ?></p>
					<?php endif; ?>
                </div>
			<?php endif; ?>
            <div class="<?php echo esc_attr( $wrapper_classname ); ?>" <?php echo esc_html( $data_attrs ); ?>>
                <input class="hidden rb-input-hidden rb-meta-last-tab" name="rb_meta[last_tab][<?php echo esc_attr( $section['id'] ); ?>]" value="<?php echo esc_attr( $rb_last_tab ); ?>"/>
                <div class="rb-meta-tab-header">
					<?php
					if ( empty( $rb_last_tab ) ) {
						$active = true;
					}
					foreach ( $section['tabs'] as $tab ) :
						$tab = wp_parse_args( $tab, array( 'id' => '', 'title' => '' ) );
						if ( ( isset( $active ) && true === $active ) || (string) $rb_last_tab === (string) $tab['id'] ) {
							$class_name = 'rb-tab-title is-active';
							$active     = false;
						} else {
							$class_name = 'rb-tab-title';
						} ?>
                        <a href="#" class="<?php echo esc_attr( $class_name ); ?>" data-tab="<?php echo esc_attr( $tab['id'] ); ?>">
							<?php $title_classes = 'tab-title';
							if ( ! empty( $tab['icon'] ) ) {
								$title_classes .= ' dashicons-before ' . esc_attr( $tab['icon'] );
							} ?>
                            <h3 class="<?php echo esc_attr( $title_classes ); ?>"><?php echo esc_html( $tab['title'] ); ?></h3>
                        </a>
					<?php endforeach; ?>
                </div>
				<?php
				if ( empty( $rb_last_tab ) ) {
					$active = true;
				}
				foreach ( $section['tabs'] as $tab ) :
					if ( ! empty( $tab['fields'] ) ) :
						$tab = wp_parse_args( $tab, array(
							'id'    => '',
							'title' => '',
							'desc'  => ''
						) );

						if ( ( isset( $active ) && true === $active ) || (string) $rb_last_tab === (string) $tab['id'] ) {
							$class_name = 'rb-meta-tab is-active';
							$active     = false;
						} else {
							$class_name = 'rb-meta-tab';
						} ?>
                        <div class="<?php echo esc_attr( $class_name ); ?>" id="rb-tab-<?php echo esc_attr( $tab['id'] ); ?>">
							<?php if ( ! empty( $tab['desc'] ) ) : ?>
                                <p class="tab-description"><?php echo $tab['desc']; ?></p>
							<?php endif; ?>
							<?php foreach ( $tab['fields'] as $field ) :
								$params = wp_parse_args( $field, array(
									'id'      => '',
									'name'    => '',
									'desc'    => '',
									'type'    => '',
									'class'   => '',
									'default' => ''
								) );
								if ( ! empty( $stored_meta[ $params['id'] ] ) ) {
									$params['value'] = $stored_meta[ $params['id'] ];
								}

								$func_mame = 'input_' . $params['type'];
								if ( method_exists( $this, $func_mame ) ) {
									$this->$func_mame( $params );
								}
							endforeach; ?>
                        </div>
					<?php endif;
				endforeach; ?>
            </div>
			<?php
		}

		function gallery_update() {

			if ( ! empty( $_POST['attachments'] ) ) {

				$str = '';
				foreach ( $_POST['attachments'] as $id ) {
					$thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );
					if ( ! empty( $thumbnail[0] ) ) {
						$str .= '<span class="thumbnail"><img  src="' . $thumbnail[0] . '" width="75" height="75"/></span>';
					}
				}
				wp_send_json( $str );
				die();
			}
		}

		/**
		 * @param $params
		 */
		function input_text( $params ) {

			$defaults = array(
				'id'          => '',
				'name'        => '',
				'desc'        => '',
				'default'     => '',
				'class'       => '',
				'placeholder' => ''
			);
			$params   = wp_parse_args( $params, $defaults );
			if ( ! isset( $params['value'] ) ) {
				if ( ! empty( $params['default'] ) ) {
					$params['value'] = $params['default'];
				} else {
					$params['value'] = '';
				}
			} ?>
            <div class="rb-meta rb-input <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class="rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <input type="text" class="rb-meta-text rb-meta-content" placeholder="<?php echo esc_attr( $params['placeholder'] ); ?>" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" id="<?php echo esc_attr( $params['id'] ); ?>" value="<?php echo esc_attr( $params['value'] ); ?>"/>
            </div>
			<?php
		}

		/** input select */
		function input_select( $params ) {

			$defaults = array(
				'id'      => '',
				'name'    => '',
				'desc'    => '',
				'default' => '',
				'options' => array(),
				'class'   => ''
			);
			$params   = wp_parse_args( $params, $defaults );
			if ( empty( $params['value'] ) ) {
				$params['value'] = $params['default'];
			} ?>
            <div class="rb-meta rb-select <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class="rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <select class="rb-meta-content rb-meta-select" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" id="<?php echo esc_attr( $params['id'] ); ?>"/>
				<?php foreach ( $params['options'] as $val => $name ) :
					if ( (string) $params['value'] === (string) $val ) : ?>
                        <option selected value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $name ); ?></option>
					<?php else : ?>
                        <option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $name ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
                </select>
            </div>
			<?php
		}

		/**
		 * @param $params
		 */
		function input_image_select( $params ) {

			$defaults = array(
				'id'      => '',
				'name'    => '',
				'desc'    => '',
				'default' => '',
				'options' => array(),
				'class'   => ''
			);
			$params   = wp_parse_args( $params, $defaults );
			if ( empty( $params['value'] ) ) {
				$params['value'] = $params['default'];
			} ?>
            <div class="rb-meta rb-image-select <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class=" rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <div class="rb-meta-content">
					<?php foreach ( $params['options'] as $val => $image ) :
						if ( (string) $params['value'] === (string) $val ) : ?>
                            <span class="rb-checkbox is-active">
                            <?php if ( is_array( $image ) ):
                                $image = wp_parse_args( $image, array(
                                    'img'   => '#',
                                    'title' => ''
                                ) ); ?>
                                <img src="<?php echo esc_url( $image['img'] ); ?>" alt=""/>
                                <span class="select-title"><?php echo esc_html( $image['title'] ); ?></span>
                            <?php else : ?>
                                <img src="<?php echo esc_url( $image ); ?>" alt=""/>
                            <?php endif; ?>
                                <input checked="checked" type="radio" class="rb-meta-image" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" value="<?php echo esc_attr( $val ); ?>">
                            </span>
						<?php else : ?>
                            <span class="rb-checkbox">
					<?php if ( is_array( $image ) ):
						$image = wp_parse_args( $image, array(
							'img'   => '#',
							'title' => ''
						) ); ?>
                        <img src="<?php echo esc_url( $image['img'] ); ?>" alt=""/>
                        <span class="select-title"><?php echo esc_html( $image['title'] ); ?></span>
					<?php else : ?>
                        <img src="<?php echo esc_url( $image ); ?>" alt=""/>
					<?php endif; ?>
						<input type="radio" class="rb-meta-image" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" value="<?php echo esc_attr( $val ); ?>">
				</span>
						<?php endif;
					endforeach; ?>
                </div>
            </div>
			<?php
		}

		/**
		 * @param $params
		 */
		function input_images( $params ) {

			$defaults = array(
				'id'      => '',
				'name'    => '',
				'desc'    => '',
				'default' => '',
				'class'   => 'rb-images'
			);
			$params   = wp_parse_args( $params, $defaults );
			if ( empty( $params['value'] ) ) {
				$params['value'] = $defaults['default'];
			} ?>
            <div class="rb-meta rb-gallery <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class=" rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <div class="rb-gallery-content rb-meta-content">
                    <div class="meta-preview">
						<?php if ( ! empty( $params['value'] ) ) :
							$data_ids = explode( ',', $params['value'] );
							foreach ( $data_ids as $attachment_id ) :
								$img = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
								if ( isset( $img[0] ) ) {
									echo '<span class="thumbnail"><img src="' . esc_url( $img[0] ) . '" /></span>';
								}
							endforeach;
						endif; ?>
                    </div>
                    <input class="rb-edit-gallery button rb-meta-button" type="button" value="+ Add/Edit Gallery"/>
                    <input class="rb-clear-gallery button rb-meta-button" type="button" value="Clear"/>
                    <input type="hidden" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" class="rb-value-gallery" value="<?php echo esc_attr( $params['value'] ); ?>">
                </div>
            </div>
			<?php
		}

		/**
		 * @param $params
		 * input textarea
		 */
		function input_textarea( $params ) {

			$defaults = array(
				'id'          => '',
				'name'        => '',
				'desc'        => '',
				'default'     => '',
				'class'       => '',
				'placeholder' => ''
			);
			$params   = wp_parse_args( $params, $defaults );

			if ( ! isset( $params['value'] ) ) {
				if ( ! empty( $params['default'] ) ) {
					$params['value'] = $params['default'];
				} else {
					$params['value'] = '';
				}
			} ?>
            <div class="rb-meta rb-textarea <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class="rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <textarea rows="4" cols="50" placeholder="<?php echo esc_attr( $params['placeholder'] ); ?>" class="rb-meta-textarea rb-meta-content" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" id="<?php echo esc_attr( $params['id'] ); ?>"><?php echo esc_html( $params['value'] ); ?></textarea>
            </div>
			<?php
		}

		/**
		 * @param $params
		 */
		function input_category_select( $params ) {

			$defaults = array(
				'id'       => '',
				'name'     => '',
				'desc'     => '',
				'default'  => '',
				'taxonomy' => 'category',
				'class'    => '',
				'empty'    => 'None'
			);
			$params   = wp_parse_args( $params, $defaults );
			if ( empty( $params['value'] ) ) {
				$params['value'] = $params['default'];
			}

			$categories_data = array();

			$categories = get_categories( array(
				'hide_empty' => 0,
				'type'       => 'post',
			) );

			$array_walker = new Rb_Category_Select_Walker;
			$array_walker->walk( $categories, 4 );
			$buffer = $array_walker->cat_array;
			foreach ( $buffer as $name => $id ) {
				$categories_data[ $name ] = $id;
			}
			$params['options'] = $categories_data;
			?>
            <div class="rb-meta rb-select rb-category-select <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class="rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <select class="rb-meta-content rb-meta-select" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" id="<?php echo esc_attr( $params['id'] ); ?>"/>
                <option value="0" <?php if ( empty( $params['value'] ) ) {
					echo 'selected';
				} ?>>-- <?php echo esc_html( $params['empty'] ); ?> --
                </option>
				<?php foreach ( $params['options'] as $name => $id ) :
					if ( (string) $params['value'] === (string) $id ) : ?>
                        <option selected value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></option>
					<?php else : ?>
                        <option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
                </select>
            </div>
			<?php
		}

		/**
		 * @param $params
		 */
		function input_file( $params ) {

			$defaults = array(
				'id'      => '',
				'name'    => '',
				'desc'    => '',
				'default' => '',
				'class'   => 'rb-file'
			);
			$params   = wp_parse_args( $params, $defaults );
			if ( empty( $params['value'] ) ) {
				$params['value'] = $params['default'];
			} ?>
            <div class="rb-meta rb-file <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class=" rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <div class="rb-file-content rb-meta-content">
                    <div class="meta-preview">
						<?php if ( ! empty( $params['value'] ) ) :
							$file_name = get_the_title( $params['value'] );
							$url       = wp_get_attachment_url( $params['value'] );
							echo '<a class="thumbnail file" href="' . $url . '">';
							if ( ! wp_attachment_is_image( $params['value'] ) ) {
								$src = wp_mime_type_icon( $params['value'] );
								echo '<img class="icon" src="' . esc_html( $src ) . '">';
							} else {
								echo '<img class="image" src="' . esc_html( $url ) . '">';
							}
							echo '<span class=" file-name">' . esc_attr( $file_name ) . '</span></a>';
						endif; ?>
                    </div>
                    <input class="rb-edit-file button rb-meta-button" type="button" value="+Add Media"/>
                    <input class="rb-clear-file button rb-meta-button" type="button" value="Clear"/>
                    <input type="hidden" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>]" class="rb-value-file" value="<?php echo esc_attr( $params['value'] ); ?>">
                </div>
            </div>
			<?php
		}

		/**
		 * @param $params
		 */
		function input_datetime( $params ) {

			$defaults = array(
				'id'          => '',
				'name'        => '',
				'desc'        => '',
				'default'     => '',
				'key'         => '',
				'kvd'         => '',
				'class'       => 'rb-date',
				'placeholder' => 'mm/dd/yyyy'
			);
			$params   = wp_parse_args( $params, $defaults );

			if ( empty( $params['value'] ) ) {
				$params['value'] = $params['default'];
			} ?>
            <div class="rb-meta rb-date <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class=" rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <div class="rb-date-content rb-meta-content">
                    <input type="hidden" class="rb-meta-type" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>][type]" value="datetime">
					<?php if ( ! empty( $params['key'] ) ) : ?>
                        <input type="hidden" class="rb-meta-key" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>][key]" value="<?php echo esc_attr( $params['key'] ); ?>">
					<?php endif;
					if ( ! empty( $params['kvd'] ) ) : ?>
                        <input type="hidden" class="rb-meta-kvd" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>][kvd]" value="<?php echo esc_attr( $params['kvd'] ); ?>">
					<?php endif; ?>
                    <input type="text" autocomplete="off" class="rb-meta-date" placeholder="<?php echo esc_attr( $params['placeholder'] ); ?>" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>][date]" id="<?php echo esc_attr( $params['id'] ) . '_date'; ?>" value="<?php if ( ! empty( $params['value'] ) ) {
						echo date( 'm\/d\/Y', (float) ( $params['value'] ) );
					} ?>"/>
                    <input type="text" class="rb-meta-time" autocomplete="off" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>][time]" id="<?php echo esc_attr( $params['id'] ) . '_time'; ?>" value="<?php echo date( 'H:i', (float) ( $params['value'] ) ); ?>"/>
                </div>
            </div>
			<?php
		}

		/**
		 * @param $params
		 */
		function input_group( $params ) {

			$last_index = 0;
			$defaults   = array(
				'id'      => '',
				'name'    => '',
				'desc'    => '',
				'default' => '',
				'fields'  => array(),
				'button'  => '',
				'class'   => '',
				'value'   => array(),
			);

			$params   = wp_parse_args( $params, $defaults );
			if ( ! isset( $params['value']['placebo'] ) ) {
				$params['value']['placebo'] = array();
			}
			?>
            <div class="rb-meta rb-group <?php echo esc_attr( $params['class'] ); ?>">
                <div class="rb-meta-title">
                    <label for="<?php echo esc_attr( $params['id'] ); ?>" class="rb-meta-label"><?php echo esc_html( $params['name'] ); ?></label>
					<?php if ( ! empty( $params['desc'] ) ) : ?>
                        <p class=" rb-meta-desc"><?php echo esc_html( $params['desc'] ); ?></p>
					<?php endif; ?>
                </div>
                <div class="group-holder rb-meta-content">
                    <div class="rb-group-content">
	                    <?php if ( is_array( $params['value'] ) && count( $params['value'] ) ) :
		                    foreach ( $params['value'] as $index => $item ) :

			                    $class_name = 'group-item';
			                    if ( 'placebo' === ( string ) $index ) {
				                    $class_name .= ' group-placebo is-hidden';
			                    }
			                    ?>
                                <div class="<?php echo esc_attr( $class_name ); ?>">
				                    <?php foreach ( $params['fields'] as $field ) :
					                    $field = wp_parse_args( $field, array(
						                    'placeholder' => '',
						                    'id'          => '',
						                    'name'        => '',
						                    'default'     => '',
					                    ) );
					                    if ( ! isset( $item[ $field['id'] ] ) ) {
						                    $item[ $field['id'] ] = $field['default'];
					                    }
					                    if ( (string) $index === 'placebo' ) {
						                    $item[ $field['id'] ] = 0;
					                    }
					                    ?>
                                        <div class="item">
                                        <span class="group-item-title"><?php echo esc_html( $field['name'] ); ?></span>
                                        <input type="text" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" name="rb_meta[<?php echo esc_attr( $params['id'] ); ?>][<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $field['id'] ); ?>]" value="<?php echo esc_html( $item[ $field['id'] ] ); ?>"/>
                                        </div>
				                    <?php endforeach; ?>
	                                <?php if ( (string) $index !== 'placebo' ) :
					                    $last_index = absint( $index ) + 1; ?>
                                        <a href="#" class="rb-group-delete"><?php echo esc_html__( 'Delete', 'foxiz-core' ); ?></a>
				                    <?php endif; ?>
                                </div>
		                    <?php
		                    endforeach;
	                    endif; ?>
                    </div>
                    <div class="group-item default-group-item is-hidden" data-index="<?php echo esc_attr( $last_index ); ?>">
						<?php foreach ( $params['fields'] as $field ) :
							$field = wp_parse_args( $field, array(
								'placeholder' => '',
								'id'          => '',
								'name'        => '',
								'default'     => '',
							) ); ?>
                            <div class="item">
                                <span class="group-item-title"><?php echo esc_html( $field['name'] ); ?></span>
                                <input type="text" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" data-group-id="<?php echo esc_attr( $params['id'] ); ?>" data-id="<?php echo esc_attr( $field['id'] ); ?>" data-value="<?php echo esc_attr( $field['default'] ); ?>"/>
                            </div>
						<?php endforeach; ?>
                        <a href="#" class="rb-group-delete"><?php echo esc_html__( 'Delete', 'foxiz-core' ); ?></a>
                    </div>
                    <a href="#" class="rb-group-trigger"><?php echo esc_html( $params['button'] ); ?></a>
                </div>
            </div>
			<?php
		}
	}
}

if ( ! function_exists( 'rb_get_meta' ) ) {
	/**
	 * @param $id
	 * @param null $post_id
	 *
	 * @return false|mixed
	 * get meta
	 */
	function rb_get_meta( $id, $post_id = null ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( empty( $post_id ) ) {
			return false;
		}

		$rb_meta = get_post_meta( $post_id, RB_META_ID, true );
		if ( ! empty( $rb_meta[ $id ] ) ) {

			if ( is_array( $rb_meta[ $id ] ) && isset( $rb_meta[ $id ]['placebo'] ) ) {
				unset( $rb_meta[ $id ]['placebo'] );
			}

			return $rb_meta[ $id ];
		}

		return false;
	}
}

/** init */
RB_META::get_instance();