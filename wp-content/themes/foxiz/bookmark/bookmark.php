<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_Bookmark', false ) ) {

	/**
	 * Class Foxiz_Bookmark
	 * Bookmark system
	 */
	class Foxiz_Bookmark {

		private static $instance;
		public $settings = array();
		public $defaults = array();
		private $meta_post_ID = 'rb_bookmark_data';
		private $meta_category_ID = 'rb_user_category_data';
		private $meta_author_ID = 'rb_user_author_data';

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		/**
		 * Foxiz_Bookmark constructor.
		 */
		public function __construct() {

			self::$instance = $this;
			$this->get_settings();

			add_action( 'wp_ajax_nopriv_my_bookmarks', array( $this, 'my_bookmarks' ) );
			add_action( 'wp_ajax_my_bookmarks', array( $this, 'my_bookmarks' ) );
			add_action( 'wp_ajax_nopriv_rb_bookmark', array( $this, 'add_bookmark' ) );
			add_action( 'wp_ajax_rb_bookmark', array( $this, 'add_bookmark' ) );
			add_action( 'wp_ajax_nopriv_rb_follow', array( $this, 'follow_toggle' ) );
			add_action( 'wp_ajax_rb_follow', array( $this, 'follow_toggle' ) );
			add_action( 'wp_ajax_nopriv_sync_bookmarks', array( $this, 'sync_bookmarks' ) );
			add_action( 'wp_ajax_sync_bookmarks', array( $this, 'sync_bookmarks' ) );
			add_filter( 'body_class', array( $this, 'add_classes' ), 99 );
			add_action( 'wp_footer', array( $this, 'bookmark_info_template' ) );
			add_action( 'wp_footer', array( $this, 'bookmark_info_removed' ) );
			add_action( 'transition_post_status', array( $this, 'push_notification' ), 10, 3 );
		}

		public function guess_posts_ID() {

			return 'rb_bookmark_' . $this->get_ip();
		}

		public function guess_categories_ID() {

			return 'rb_follow_cat_' . $this->get_ip();
		}

		public function guess_authors_ID() {

			return 'rb_follow_author_' . $this->get_ip();
		}

		function my_bookmarks() {

			$response = array(
				'listposts'   => $this->my_bookmarks_posts(),
				'categories'  => $this->my_bookmarks_categories(),
				'authors'     => $this->my_bookmarks_authors(),
				'recommended' => $this->my_recommended(),
				'sync'        => $this->get_bookmarks(),
				'remove'      => $this->remove_html_tag()
			);
			wp_send_json( $response, null );
		}

		function my_bookmarks_posts() {

			$template = foxiz_get_option( 'saved_template' );
			/** query and sync posts */
			$_query = $this->saved_posts_query( array(
				'sync_data' => true
			) );

			ob_start();
			if ( ! empty( $_query ) && $_query->have_posts() ) :
				if ( ! empty( $template ) ) {
					$GLOBALS['ruby_template_query'] = $_query;
					echo do_shortcode( $template );
				} else {
					$settings = foxiz_get_archive_page_settings( 'saved_', array(
						'uuid'            => 'uid_saved',
						'bookmark_action' => true,
						'classes'         => 'saved-content',
					) );
					/** disable pagination and bookmark */
					$settings['pagination'] = false;
					$settings['bookmark']   = '-1';
					foxiz_the_blog( $settings, $_query );
				}
			else : ?>
                <div class="empty-saved">
                    <div class="rb-container edge-padding">
                        <h4 class="empty-saved-title"><?php foxiz_html_e( 'You haven\'t saved anything yet.', 'foxiz' ); ?></h4>
                        <p class="empty-saved-desc"><?php printf( foxiz_html__( 'Start saving your interested articles by clicking the %s icon and you\'ll find them all here.', 'foxiz' ), '<i class="rbi rbi-bookmark"></i>' ); ?></p>
                    </div>
                </div>
			<?php endif;

			return ob_get_clean();
		}

		function my_bookmarks_categories() {

			if ( ! foxiz_get_option( 'interest_category' ) ) {
				return false;
			}
			ob_start();
			foxiz_follow_categories_list( array(
				'url'         => foxiz_get_option( 'interest_url' ),
				'follow'      => true,
				'title_tag'   => 'h4',
				'count_posts' => true,
			) );

			return ob_get_clean();
		}

		function my_bookmarks_authors() {

			if ( ! foxiz_get_option( 'interest_author' ) ) {
				return false;
			}

			ob_start();
			foxiz_follow_authors_list( array(
				'url'         => foxiz_get_option( 'interest_url' ),
				'follow'      => true,
				'title_tag'   => 'h4',
				'count_posts' => true,
			) );

			return ob_get_clean();
		}

		function my_recommended() {

			if ( ! foxiz_get_option( 'recommended_interested' ) ) {
				return false;
			}

			ob_start();
			foxiz_recommended_posts();

			return ob_get_clean();
		}

		function remove_html_tag() {

			return '<a href="#" class="remove-bookmark meta-text"><i class="rbi rbi-rdoc"></i><span>' . foxiz_html__( 'Remove', 'foxiz' ) . '</span></a>';
		}

		function bookmark_info_removed() {

			$settings = $this->settings;
			if ( empty( $settings['bookmark'] ) ) {
				return;
			} ?>
            <aside id="bookmark-remove-info" class="bookmark-info edge-padding">
                <div class="bookmark-remove-holder bookmark-holder">
                    <p><?php foxiz_html_e( 'Removed from reading list', 'foxiz' ); ?></p>
                    <a href="#" id="bookmark-undo" class="bookmark-undo h4"><?php foxiz_html_e( 'Undo', 'foxiz' ); ?></a>
                </div>
            </aside>
		<?php }

		function bookmark_info_template() {

			$settings = $this->settings;
			if ( empty( $settings['bookmark'] ) || empty( $settings['notification'] ) ) {
				return;
			} ?>
            <aside id="bookmark-toggle-info" class="bookmark-info edge-padding">
                <div class="bookmark-holder">
                    <div class="bookmark-featured"></div>
                    <div class="bookmark-inner">
                        <span class="bookmark-title h5"></span>
                        <span class="bookmark-desc"></span>
                    </div>
                </div>
            </aside>
            <aside id="follow-toggle-info" class="bookmark-info edge-padding">
                <div class="bookmark-holder">
                    <span class="bookmark-desc"></span>
                </div>
            </aside>
			<?php
		}

		/**
		 * @param $classes
		 *
		 * @return mixed
		 * body classes
		 */
		function add_classes( $classes ) {

			if ( ! empty( $this->settings['bookmark'] ) ) {
				$classes[] = 'sync-bookmarks';
			}

			return $classes;
		}

		/**
		 * get settings
		 */
		public function get_settings() {

			$settings = array(
				'bookmark'             => foxiz_get_option( 'bookmark_system' ),
				'bookmark_enable_when' => foxiz_get_option( 'bookmark_enable_when' ),
				'follow_enable_when'   => foxiz_get_option( 'follow_enable_when' ),
				'expiration'           => absint( foxiz_get_option( 'bookmark_expiration' ) ) * 86400,
				'limit'                => absint( foxiz_get_option( 'bookmark_limit' ) ),
				'notification'         => foxiz_get_option( 'bookmark_notification' )
			);

			$this->settings = wp_parse_args( $settings, array(
				'bookmark'             => '',
				'bookmark_enable_when' => '',
				'follow_enable_when'   => '',
				'expiration'           => '5076000'
			) );
		}

		/**
		 * @return string|string[]|null
		 * get user IP
		 */
		public function get_ip() {

			if ( function_exists( 'foxiz_get_user_ip' ) ) {
				$ip = foxiz_get_user_ip();

				return foxiz_convert_to_id( $ip );
			}

			return '127_0_0_1';
		}

		/**
		 * add bookmark
		 */
		public function add_bookmark() {

			if ( empty( $_POST['pid'] ) ) {
				wp_send_json( '', null );
			}

			$post_id  = intval( $_POST['pid'] );
			$response = array(
				'action'      => 'added',
				'description' => foxiz_html__( 'This article has been added to reading list', 'foxiz' )
			);

			if ( is_user_logged_in() ) {
				$user_id    = get_current_user_id();
				$bookmarked = get_user_meta( $user_id, $this->meta_post_ID, true );
				if ( $this->is_empty( $bookmarked ) ) {
					$bookmarked = array();
				}
				$key = array_search( $post_id, $bookmarked );
				if ( false === $key ) {
					if ( count( $bookmarked ) >= $this->settings['limit'] ) {
						$response = array(
							'action'      => 'limit',
							'description' => foxiz_html__( 'Limit is reached. Please remove a post and try again!', 'foxiz' )
						);
						wp_send_json( $response, null );
						die();
					}
					array_push( $bookmarked, $post_id );
				} else {
					unset( $bookmarked[ $key ] );
					$response['action']      = 'removed';
					$response['description'] = foxiz_html__( 'This article was removed from reading list', 'foxiz' );
				}

				update_user_meta( $user_id, $this->meta_post_ID, array_unique( $bookmarked ) );
			} else {
				$transient_ID = $this->guess_posts_ID();
				$bookmarked   = get_transient( $transient_ID );

				if ( $this->is_empty( $bookmarked ) ) {
					$bookmarked = array();
				}

				$key = array_search( $post_id, $bookmarked );
				if ( false === $key ) {
					if ( count( $bookmarked ) >= $this->settings['limit'] ) {
						$response = array(
							'action'      => 'limit',
							'description' => foxiz_html__( 'The limit is reached. Please remove a post and try again!', 'foxiz' )
						);
						wp_send_json( $response, null );
						die();
					}
					array_push( $bookmarked, $post_id );
				} else {
					unset( $bookmarked[ $key ] );
					$response['action']      = 'removed';
					$response['description'] = foxiz_html__( 'This article was removed from your bookmark', 'foxiz' );
				}
				set_transient( $transient_ID, array_unique( $bookmarked ), $this->settings['expiration'] );
			}

			if ( ! empty( $this->settings['notification'] ) ) {
				$response['title'] = get_the_title( $post_id );
				$response['image'] = get_the_post_thumbnail( $post_id, 'thumbnail' );
			}

			wp_send_json( $response, null );
		}

		/**
		 * get bookmarks
		 */
		public function get_bookmarks() {

			$data = array();

			if ( is_user_logged_in() ) {
				$data['posts']      = get_user_meta( get_current_user_id(), $this->meta_post_ID, true );
				$data['categories'] = get_user_meta( get_current_user_id(), $this->meta_category_ID, true );
				$data['authors']    = get_user_meta( get_current_user_id(), $this->meta_author_ID, true );
			} else {
				$data['posts']      = get_transient( $this->guess_posts_ID() );
				$data['categories'] = get_transient( $this->guess_categories_ID() );
				$data['authors']    = get_transient( $this->guess_authors_ID() );
			}

			return $data;
		}

		public function sync_bookmarks() {

			wp_send_json( $this->get_bookmarks(), null );
		}

		/**
		 * @param $new_status
		 * @param $old_status
		 * @param $post
		 */
		public function push_notification( $new_status, $old_status, $post ) {

			if ( ( 'publish' === $new_status && 'publish' !== $old_status ) && 'post' === $post->post_type ) {
				update_option( 'rb_push_notification', $post->ID );
			}
		}

		/**
		 * @param array $settings
		 *
		 * @return false|WP_Query
		 */
		public function saved_posts_query( $settings = array() ) {

			$data = $this->get_bookmarks();
			if ( $this->is_empty( $data['posts'] ) ) {
				return false;
			}

			if ( ! empty( $settings['posts_per_page'] ) ) {
				$posts_per_page = $settings['posts_per_page'];
			} else {
				$posts_per_page = - 1;
			}
			$_query = new WP_Query( array(
				'post_type'           => 'post',
				'post__in'            => $data['posts'],
				'orderby'             => 'post__in',
				'posts_per_page'      => $posts_per_page,
				'ignore_sticky_posts' => 1,
			) );

			/** update if posts was deleted */
			if ( ! empty( $settings['sync_data'] ) ) {
				$ids = wp_list_pluck( $_query->posts, 'ID' );
				$this->update_user_saved_posts( $ids );
			}

			return $_query;
		}

		/**
		 * @param $data
		 */
		public function update_user_saved_posts( $data ) {

			if ( is_user_logged_in() ) {
				update_user_meta( get_current_user_id(), $this->meta_post_ID, $data, array() );
			} else {
				set_transient( $this->guess_posts_ID(), $data, $this->settings['expiration'] );
			}
		}

		/**
		 * @return array|mixed
		 */
		public function get_user_categories() {

			if ( is_user_logged_in() ) {
				$ids = get_user_meta( get_current_user_id(), $this->meta_category_ID, true );
			} else {
				$ids = get_transient( $this->guess_categories_ID() );
			}

			if ( ! $this->is_empty( $ids ) ) {
				return $ids;
			}

			$categories = get_categories( array(
				'orderby' => 'count',
				'order'   => 'DESC',
				'number'  => 4
			) );

			return wp_list_pluck( $categories, 'term_id' );
		}

		public function update_user_categories( $data ) {

			if ( is_user_logged_in() ) {
				update_user_meta( get_current_user_id(), $this->meta_category_ID, $data, array() );
			} else {
				set_transient( $this->guess_categories_ID(), $data, $this->settings['expiration'] );
			}
		}

		public function get_user_authors() {

			if ( is_user_logged_in() ) {
				$ids = get_user_meta( get_current_user_id(), $this->meta_author_ID, true );
			} else {
				$ids = get_transient( $this->guess_authors_ID() );
			}

			if ( ! $this->is_empty( $ids ) ) {
				return $ids;
			}

			$role = array( 'author', 'editor' );
			if ( foxiz_get_option( 'bookmark_author_admin' ) ) {
				$role[] = 'administrator';
			}

			$authors = get_users( array(
				'blog_id'  => $GLOBALS['blog_id'],
				'orderby'  => 'post_count',
				'order'    => 'DESC',
				'number'   => 4,
				'role__in' => $role
			) );

			return wp_list_pluck( $authors, 'ID' );
		}

		public function update_user_authors( $data ) {

			if ( is_user_logged_in() ) {
				update_user_meta( get_current_user_id(), $this->meta_author_ID, $data, array() );
			} else {
				set_transient( $this->guess_authors_ID(), $data, $this->settings['expiration'] );
			}
		}

		/** follow toggle */
		public function follow_toggle() {

			$response = '';
			if ( ! empty( $_POST['cid'] ) ) {
				$response = $this->category_follow_toggle( intval( $_POST['cid'] ) );
			} elseif ( ! empty( $_POST['uid'] ) ) {
				$response = $this->author_follow_toggle( intval( $_POST['uid'] ) );
			}

			wp_send_json( $response, null );
		}

		/**
		 * @param $category_id
		 *
		 * @return string[]
		 */
		function category_follow_toggle( $category_id ) {

			$response = array(
				'action'      => 'added',
				'description' => foxiz_html__( 'Successfully Added!', 'foxiz' )
			);

			if ( is_user_logged_in() ) {
				$user_id  = get_current_user_id();
				$followed = get_user_meta( $user_id, $this->meta_category_ID, true );
				if ( $this->is_empty( $followed ) ) {
					$followed = array();
				}
				$key = array_search( $category_id, $followed );
				if ( false === $key ) {
					if ( count( $followed ) >= $this->settings['limit'] ) {
						$response = array(
							'action'      => 'limit',
							'description' => foxiz_html__( 'The limit is reached. Please remove a category and try again!', 'foxiz' )
						);
						wp_send_json( $response, null );
						die();
					}
					array_push( $followed, $category_id );
				} else {
					unset( $followed[ $key ] );
					$response = array(
						'action'      => 'removed',
						'description' => foxiz_html__( 'Successfully Removed!', 'foxiz' )
					);
				}

				update_user_meta( $user_id, $this->meta_category_ID, array_unique( $followed ) );
			} else {
				$transient_ID = $this->guess_categories_ID();
				$followed     = get_transient( $transient_ID );

				if ( $this->is_empty( $followed ) ) {
					$followed = array();
				}
				$key = array_search( $category_id, $followed );
				if ( false === $key ) {
					if ( count( $followed ) >= $this->settings['limit'] ) {
						$response = array(
							'action'      => 'limit',
							'description' => foxiz_html__( 'The limit is reached. Please remove a category and try again!', 'foxiz' )
						);
						wp_send_json( $response, null );
						die();
					}
					array_push( $followed, $category_id );
				} else {
					unset( $followed[ $key ] );
					$response = array(
						'action'      => 'removed',
						'description' => foxiz_html__( 'Successfully Removed!', 'foxiz' )
					);
				}
				set_transient( $transient_ID, array_unique( $followed ), $this->settings['expiration'] );
			}

			return $response;
		}

		/**
		 * @param $author_id
		 *
		 * @return string[]
		 */
		function author_follow_toggle( $author_id ) {

			$response = array(
				'action'      => 'added',
				'description' => foxiz_html__( 'Successfully Added!', 'foxiz' )
			);

			if ( is_user_logged_in() ) {
				$user_id  = get_current_user_id();
				$followed = get_user_meta( $user_id, $this->meta_author_ID, true );
				if ( $this->is_empty( $followed ) ) {
					$followed = array();
				}
				$key = array_search( $author_id, $followed );
				if ( false === $key ) {
					if ( count( $followed ) >= $this->settings['limit'] ) {
						$response = array(
							'action'      => 'limit',
							'description' => foxiz_html__( 'The limit is reached. Please remove a category and try again!', 'foxiz' )
						);
						wp_send_json( $response, null );
						die();
					}
					array_push( $followed, $author_id );
				} else {
					unset( $followed[ $key ] );
					$response = array(
						'action'      => 'removed',
						'description' => foxiz_html__( 'Successfully Removed!', 'foxiz' )
					);
				}
				update_user_meta( $user_id, $this->meta_author_ID, array_unique( $followed ) );
			} else {
				$transient_ID = $this->guess_authors_ID();
				$followed     = get_transient( $transient_ID );

				if ( $this->is_empty( $followed ) ) {
					$followed = array();
				}
				$key = array_search( $author_id, $followed );
				if ( false === $key ) {
					if ( count( $followed ) >= $this->settings['limit'] ) {
						$response = array(
							'action'      => 'limit',
							'description' => foxiz_html__( 'The limit is reached. Please remove a followed writers and try again!', 'foxiz' )
						);
						wp_send_json( $response, null );
						die();
					}
					array_push( $followed, $author_id );
				} else {
					unset( $followed[ $key ] );
					$response = array(
						'action'      => 'removed',
						'description' => foxiz_html__( 'Successfully Removed!', 'foxiz' )
					);
				}
				set_transient( $transient_ID, array_unique( $followed ), $this->settings['expiration'] );
			}

			return $response;
		}

		public function recommended_query( $settings = array() ) {

			$_query = $this->recommended_pre_query( $settings );
			if ( ! empty( $_query ) ) {
				$_query->set( 'query_for_template', 'recommended_interest' );
			}

			return $_query;
		}

		/**
		 * @param array $settings
		 *
		 * @return false|mixed|WP_Query
		 */
		public function recommended_pre_query( $settings = array() ) {

			$offset = 0;
			if ( empty( $settings['paged'] ) ) {
				$settings['paged'] = 0;
			}
			if ( ! empty( $settings['offset'] ) ) {
				$offset = absint( $settings['offset'] );
			}

			if ( empty( $settings['posts_per_page'] ) ) {
				$settings['posts_per_page'] = foxiz_get_option( 'recommended_posts_per_page', get_option( 'posts_per_page' ) );
			}

			if ( is_user_logged_in() ) {
				$categories = get_user_meta( get_current_user_id(), $this->meta_category_ID, true );
				$authors    = get_user_meta( get_current_user_id(), $this->meta_author_ID, true );
			} else {
				$categories = get_transient( $this->guess_categories_ID() );
				$authors    = get_transient( $this->guess_authors_ID() );
			}

			if ( $this->is_empty( $categories ) && $this->is_empty( $authors ) ) {
				return foxiz_query( array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'posts_per_page' => $settings['posts_per_page'],
					'offset'         => $offset,
					'order'          => 'popular_m'
				), $settings['paged'] );
			}

			if ( $this->is_empty( $categories ) ) {
				return foxiz_query( array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'author_in'      => $authors,
					'posts_per_page' => $settings['posts_per_page'],
					'offset'         => $offset,
					'order'          => 'date_post',
				), $settings['paged'] );
			}

			if ( $this->is_empty( $authors ) ) {
				return foxiz_query( array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'categories'     => $categories,
					'posts_per_page' => $settings['posts_per_page'],
					'offset'         => $offset,
					'order'          => 'date_post',
				), $settings['paged'] );
			}

			$categories = implode( ',', $categories );
			$authors    = implode( ',', $authors );

			if ( ! empty( $settings['paged'] ) && ( $settings['paged'] > 1 ) ) {
				$offset = $offset + ( absint( $settings['paged'] ) - 1 ) * absint( $settings['posts_per_page'] );
			}

			global $wpdb;
			$data = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS wposts.ID FROM {$wpdb->posts} AS wposts
            LEFT JOIN {$wpdb->term_relationships} as wterm_relationships ON (wposts.ID = wterm_relationships.object_id)
            WHERE wterm_relationships.term_taxonomy_id IN ({$categories}) OR wposts.post_author IN ({$authors})
            AND wposts.post_type = 'post' AND wposts.post_status = 'publish' GROUP BY wposts.ID
            ORDER BY wposts.post_date DESC LIMIT {$offset} , {$settings['posts_per_page']}" );

			if ( ! empty( $data ) && is_array( $data ) ) {
				$found_posts   = (int) $wpdb->get_var( 'SELECT FOUND_ROWS();' );
				$max_num_pages = ceil( $found_posts / $settings['posts_per_page'] );

				$_query = new WP_Query( array(
						'post_type'      => 'post',
						'post_status'    => 'publish',
						'no_found_row'   => true,
						'post__in'       => wp_list_pluck( $data, 'ID' ),
						'posts_per_page' => $settings['posts_per_page'],
						'order'          => 'date_post',
					)
				);

				$_query->found_posts   = $found_posts;
				$_query->max_num_pages = $max_num_pages;

				return $_query;
			}

			return null;
		}

		/**
		 * @param $data
		 *
		 * @return bool
		 */
		public function is_empty( $data ) {

			if ( ! empty( $data ) && is_array( $data ) && count( $data ) ) {
				return false;
			}

			return true;
		}

	}
}
