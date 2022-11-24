<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_Optimized', false ) ) {
	/**
	 * Class Foxiz_Optimized
	 */
	class Foxiz_Optimized {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_action( 'wp_head', array( $this, 'site_description' ), 2 );
			add_action( 'wp_head', array( $this, 'schema_organization' ), 5 );
			add_action( 'wp_head', array( $this, 'review_markup' ), 5 );
			add_action( 'wp_head', array( $this, 'site_links' ), 10 );

			/** use jetpack og tags */
			if ( class_exists( 'Jetpack' ) ) {
				add_filter( 'jetpack_enable_open_graph', '__return_true', 100 );
			} else {
				add_action( 'wp_head', array( $this, 'open_graph' ), 20 );
			}
			add_action( 'wp_footer', array( $this, 'post_list_markup' ) );
			add_filter( 'post_class', array( $this, 'remove_hatom' ), 10, 1 );

			add_action( 'init', array( $this, 'set_elementor_font_display' ), 20 );
			add_filter( 'pvc_enqueue_styles', '__return_false' );
			add_filter( 'wp_lazy_loading_enabled', array( $this, 'lazy_load' ) );
			add_filter( 'wp_get_attachment_image_attributes', array( $this, 'optimize_featured_image' ), 10, 3 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_optimized' ), 999 );
			add_action( 'wp_head', array( $this, 'start_head_buffer' ), 0 );
			add_action( 'wp_head', array( $this, 'end_head_buffer' ), PHP_INT_MAX );
			add_action( 'wp_head', array( $this, 'preload_font_icon' ), 9 );
		}

		private $open_graph_conflicting_plugins = array(
			'2-click-socialmedia-buttons/2-click-socialmedia-buttons.php',
			'add-link-to-facebook/add-link-to-facebook.php',
			'add-meta-tags/add-meta-tags.php',
			'complete-open-graph/complete-open-graph.php',
			'easy-facebook-share-thumbnails/esft.php',
			'heateor-open-graph-meta-tags/heateor-open-graph-meta-tags.php',
			'facebook/facebook.php',
			'facebook-awd/AWD_facebook.php',
			'facebook-featured-image-and-open-graph-meta-tags/fb-featured-image.php',
			'facebook-meta-tags/facebook-metatags.php',
			'wonderm00ns-simple-facebook-open-graph-tags/wonderm00n-open-graph.php',
			'facebook-revised-open-graph-meta-tag/index.php',
			'facebook-thumb-fixer/_facebook-thumb-fixer.php',
			'facebook-and-digg-thumbnail-generator/facebook-and-digg-thumbnail-generator.php',
			'network-publisher/networkpub.php',
			'nextgen-facebook/nextgen-facebook.php',
			'social-networks-auto-poster-facebook-twitter-g/NextScripts_SNAP.php',
			'og-tags/og-tags.php',
			'opengraph/opengraph.php',
			'open-graph-protocol-framework/open-graph-protocol-framework.php',
			'seo-facebook-comments/seofacebook.php',
			'seo-ultimate/seo-ultimate.php',
			'sexybookmarks/sexy-bookmarks.php',
			'shareaholic/sexy-bookmarks.php',
			'sharepress/sharepress.php',
			'simple-facebook-connect/sfc.php',
			'social-discussions/social-discussions.php',
			'social-sharing-toolkit/social_sharing_toolkit.php',
			'socialize/socialize.php',
			'squirrly-seo/squirrly.php',
			'only-tweet-like-share-and-google-1/tweet-like-plusone.php',
			'wordbooker/wordbooker.php',
			'wpsso/wpsso.php',
			'wp-caregiver/wp-caregiver.php',
			'wp-facebook-like-send-open-graph-meta/wp-facebook-like-send-open-graph-meta.php',
			'wp-facebook-open-graph-protocol/wp-facebook-ogp.php',
			'wp-ogp/wp-ogp.php',
			'zoltonorg-social-plugin/zosp.php',
			'wp-fb-share-like-button/wp_fb_share-like_widget.php',
			'open-graph-metabox/open-graph-metabox.php',
			'seo-by-rank-math/rank-math.php',
			'slim-seo/slim-seo.php',
			'all-in-one-seo-pack/all_in_one_seo_pack.php'
		);

		private $meta_description_conflicting_plugins = array(
			'seo-by-rank-math/rank-math.php',
			'slim-seo/slim-seo.php',
			'all-in-one-seo-pack/all_in_one_seo_pack.php',
			'wp-wordpress-seo/wp-seo.php',
			'seo-ultimate/seo-ultimate.php'
		);

		/**
		 * @return bool
		 */
		public function check_conflict_open_graph() {

			$active_plugins = foxiz_get_active_plugins();
			if ( in_array( 'wp-wordpress-seo/wp-seo.php', $active_plugins, true ) ) {
				$yoast_social = get_option( 'wpseo_social' );
				if ( ! empty( $yoast_social['opengraph'] ) ) {
					return true;
				}
			}

			if ( in_array( 'wp-seopress/seopress.php', $active_plugins, true ) ) {
				$seopress_setting = get_option( 'seopress_social_option_name' );
				if ( ! empty( $seopress_setting['seopress_social_facebook_og'] ) ) {
					return true;
				}
			}

			if ( ! empty( $active_plugins ) ) {
				foreach ( $this->open_graph_conflicting_plugins as $plugin ) {
					if ( in_array( $plugin, $active_plugins, true ) ) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * @return false
		 */
		function site_links() {

			if ( ! foxiz_get_option( 'website_markup' ) ) {
				return false;
			}

			$protocol = foxiz_protocol();
			$home_url = home_url( '/' );
			$json_ld  = array(
				'@context'        => $protocol . '://schema.org',
				'@type'           => 'WebSite',
				'@id'             => $home_url . '#website',
				'url'             => $home_url,
				'name'            => get_bloginfo( 'name' ),
				'potentialAction' => array(
					'@type'       => 'SearchAction',
					'target'      => $home_url . '?s={search_term_string}',
					'query-input' => 'required name=search_term_string',
				),
			);

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		public function site_description() {

			if ( ! foxiz_get_option( 'website_description' ) ) {
				return false;
			}

			$active_plugins = foxiz_get_active_plugins();
			if ( ! empty( $active_plugins ) ) {
				foreach ( $this->meta_description_conflicting_plugins as $plugin ) {
					if ( in_array( $plugin, $active_plugins, true ) ) {
						return false;
					}
				}
			}

			if ( is_front_page() ) {
				$content = foxiz_get_option( 'site_description' );
				if ( empty( $content ) ) {
					$content = get_bloginfo( 'description' );
				}
				if ( ! empty ( $content ) ) {
					echo '<meta name="description" content="' . wp_strip_all_tags( $content ) . '">';
				}
			} elseif ( is_singular( 'post' ) ) {
				$post_id = get_the_ID();
				$content = rb_get_meta( 'tagline', $post_id );
				if ( empty( $content ) ) {
					$content = get_post_field( 'post_excerpt', $post_id );
				}
				if ( ! empty( $content ) ) {
					echo '<meta name="description" content="' . wp_strip_all_tags( $content ) . '">';
				}
			} elseif ( is_archive() ) {
				$content = get_the_archive_description();
				if ( ! empty( $content ) ) {
					echo '<meta name="description" content="' . wp_strip_all_tags( $content ) . '">';
				}
			}

			return false;
		}

		function schema_organization() {

			if ( ! foxiz_get_option( 'organization_markup' ) ) {
				return false;
			}

			$site_street   = foxiz_get_option( 'site_street' );
			$site_locality = foxiz_get_option( 'site_locality' );
			$site_phone    = foxiz_get_option( 'site_phone' );
			$site_email    = foxiz_get_option( 'site_email' );
			$postal_code   = foxiz_get_option( 'postal_code' );
			$protocol      = foxiz_protocol();

			$home_url = home_url( '/' );

			$json_ld = array(
				'@context'  => $protocol . '://schema.org',
				'@type'     => 'Organization',
				'legalName' => get_bloginfo( 'name' ),
				'url'       => $home_url
			);

			if ( ! empty( $site_street ) || ! empty( $site_locality ) ) {
				$json_ld['address']['@type'] = 'PostalAddress';

				if ( ! empty( $site_street ) ) {
					$json_ld['address']['streetAddress'] = esc_html( $site_street );
				}

				if ( ! empty( $site_locality ) ) {
					$json_ld['address']['addressLocality'] = esc_html( $site_locality );
				}

				if ( ! empty( $postal_code ) ) {
					$json_ld['address']['postalCode'] = esc_html( $postal_code );
				}
			}

			if ( ! empty( $site_email ) ) {
				$json_ld['email'] = esc_html( $site_email );
			}

			if ( ! empty( $site_phone ) ) {
				$json_ld['contactPoint'] = array(
					'@type'       => 'ContactPoint',
					'telephone'   => esc_html( $site_phone ),
					'contactType' => 'customer service',
				);
			}

			$logo = foxiz_get_option( 'site_logo' );
			if ( ! empty( $logo['url'] ) ) {
				$json_ld['logo'] = $logo['url'];
			}

			$social = array(
				foxiz_get_option( 'facebook' ),
				foxiz_get_option( 'twitter' ),
				foxiz_get_option( 'instagram' ),
				foxiz_get_option( 'pinterest' ),
				foxiz_get_option( 'linkedin' ),
				foxiz_get_option( 'tumblr' ),
				foxiz_get_option( 'flickr' ),
				foxiz_get_option( 'skype' ),
				foxiz_get_option( 'snapchat' ),
				foxiz_get_option( 'myspace' ),
				foxiz_get_option( 'youtube' ),
				foxiz_get_option( 'bloglovin' ),
				foxiz_get_option( 'digg' ),
				foxiz_get_option( 'dribbble' ),
				foxiz_get_option( 'soundcloud' ),
				foxiz_get_option( 'vimeo' ),
				foxiz_get_option( 'reddit' ),
				foxiz_get_option( 'vk' ),
				foxiz_get_option( 'telegram' ),
				foxiz_get_option( 'whatsapp' ),
				foxiz_get_option( 'rss' )
			);

			foreach ( $social as $key => $el ) {
				if ( empty( $el ) || '#' === $el ) {
					unset( $social[ $key ] );
				}
			}

			if ( count( $social ) ) {
				$json_ld['sameAs'] = array_values( $social );
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		/**
		 * @return false
		 */
		function article_markup() {

			if ( ! is_singular( 'post' ) || foxiz_conflict_schema() ) {
				return false;
			}

			$markup = rb_get_meta( 'article_markup' );
			if ( ( ! empty( $markup ) && '-1' === (string) $markup ) || ( empty( $markup ) || 'default' === $markup ) && ! foxiz_get_option( 'single_post_article_markup' ) ) {
				return false;
			}
			$protocol  = foxiz_protocol();
			$publisher = get_bloginfo( 'name' );
			$logo      = foxiz_get_option( 'logo' );

			$author_name = get_the_author_meta( 'display_name' );
			$author_link = get_the_author_meta( 'url' );
			if ( empty( $author_link ) ) {
				$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
			}

			if ( ! empty( $logo['url'] ) ) {
				$publisher_logo = esc_url( $logo['url'] );
			}
			$subtitle = rb_get_meta( 'tagline' );

			$feat_attachment = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
            <div class="article-meta is-hidden">
                <meta itemprop="mainEntityOfPage" content="<?php echo get_permalink(); ?>">
                <span class="vcard author">
                    <?php if ( ! function_exists( 'get_post_authors' ) ) : ?>
                        <span class="fn" itemprop="author" itemscope content="<?php echo esc_attr( $author_name ); ?>" itemtype="<?php echo esc_attr( $protocol ) ?>://schema.org/Person">
                                <meta itemprop="url" content="<?php echo esc_url( $author_link ); ?>">
                                <span itemprop="name"><?php echo esc_attr( $author_name ); ?></span>
                            </span>
                    <?php else :
	                    $authors = get_post_authors( get_the_ID() );
	                    if ( is_array( $authors ) && count( $authors ) > 1 ) :
		                    foreach ( $authors as $auth ) :
			                    $auth_id = $auth->ID;
			                    $auth_name = get_the_author_meta( 'display_name', $auth_id );
			                    $auth_link = get_the_author_meta( 'url', $auth_id );
			                    if ( empty( $auth_link ) ) {
				                    $auth_link = get_author_posts_url( $auth_id );
			                    } ?>
                                <span class="fn" itemprop="author" itemscope content="<?php echo esc_attr( $auth_name ); ?>" itemtype="<?php echo esc_attr( $protocol ) ?>://schema.org/Person">
                                <meta itemprop="url" content="<?php echo esc_url( $auth_link ); ?>">
                                <span itemprop="name"><?php echo esc_attr( $auth_name ); ?></span>
                            </span>
		                    <?php endforeach;
	                    else : ?>
                            <span class="fn" itemprop="author" itemscope content="<?php echo esc_attr( $author_name ); ?>" itemtype="<?php echo esc_attr( $protocol ) ?>://schema.org/Person">
                            <meta itemprop="url" content="<?php echo esc_url( $author_link ); ?>">
                            <span itemprop="name"><?php echo esc_attr( $author_name ); ?></span>
                        </span>
	                    <?php endif;
                    endif; ?>
                </span>
                <meta class="updated" itemprop="dateModified" content="<?php echo date( DATE_W3C, get_the_modified_date( 'U', get_the_ID() ) ); ?>">
                <time class="date published entry-date" datetime="<?php echo date( DATE_W3C, get_the_time( 'U', get_the_ID() ) ); ?>" content="<?php echo date( DATE_W3C, get_the_time( 'U', get_the_ID() ) ); ?>" itemprop="datePublished"><?php echo get_the_date( '', get_the_ID() ) ?></time>
				<?php if ( ! empty( $feat_attachment[0] ) ) : ?>
                    <span itemprop="image" itemscope itemtype="<?php echo esc_attr( $protocol ); ?>://schema.org/ImageObject">
				<meta itemprop="url" content="<?php echo esc_url( $feat_attachment[0] ); ?>">
				<meta itemprop="width" content="<?php echo esc_attr( $feat_attachment[1] ); ?>">
				<meta itemprop="height" content="<?php echo esc_attr( $feat_attachment[2] ); ?>">
				</span>
				<?php endif; ?>
				<?php if ( ! empty( $subtitle ) ) : ?>
                    <meta itemprop="description" content="<?php echo esc_attr( $subtitle ); ?>">
				<?php endif; ?>
                <span itemprop="publisher" itemscope itemtype="<?php echo esc_attr( $protocol ) ?>://schema.org/Organization">
				<meta itemprop="name" content="<?php echo esc_attr( $publisher ); ?>">
				<meta itemprop="url" content="<?php echo home_url( '/' ); ?>">
				<?php if ( ! empty( $publisher_logo ) ) : ?>
                    <span itemprop="logo" itemscope itemtype="<?php echo esc_attr( $protocol ) ?>://schema.org/ImageObject">
						<meta itemprop="url" content="<?php echo esc_url( $publisher_logo ); ?>">
					</span>
				<?php endif; ?>
				</span>
            </div>
			<?php
		}

		/**
		 * @return false
		 */
		function review_markup() {

			if ( ! is_singular( 'post' ) || ! function_exists( 'foxiz_get_review_settings' ) ) {
				return false;
			}

			$markup = rb_get_meta( 'review_markup' );
			if ( ( ! empty( $markup ) && '-1' === (string) $markup ) || ( empty( $markup ) || 'default' === $markup ) && ! foxiz_get_option( 'single_post_review_markup' ) ) {
				return false;
			}

			$post_id  = get_the_ID();
			$settings = foxiz_get_review_settings( $post_id );
			if ( empty( $settings ) || ! is_array( $settings ) ) {
				return false;
			}

			$protocol     = foxiz_protocol();
			$bestRating   = 5;
			$worstRating  = 1;
			$average      = 5;
			$rating_value = 5;
			$rating_count = 3;

			$description = get_the_excerpt( $post_id );

			if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
				$bestRating   = 10;
				$worstRating  = 1;
				$average      = 10;
				$rating_value = 10;
				$rating_count = 3;
			}

			if ( isset( $settings['average'] ) ) {
				$average = $settings['average'];
			}

			$author = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
			$image  = get_the_post_thumbnail_url( $post_id, 'full' );
			$sku    = get_post_field( 'post_name', $post_id );
			$name   = get_the_title( $post_id );

			if ( isset( $settings['summary'] ) ) {
				$description = $settings['summary'];
			}

			if ( ! empty( $settings['user_rating']['count'] ) ) {
				$rating_count = $settings['user_rating']['count'];
			}

			if ( ! empty( $settings['user_rating']['average'] ) ) {
				if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
					$rating_value = floatval( $settings['user_rating']['average'] ) * 2;
				} else {
					$rating_value = $settings['user_rating']['average'];
				}
			}

			$json_ld = array(
				'@context'    => $protocol . '://schema.org',
				'@type'       => 'Product',
				'description' => $description,
				'image'       => $image,
				'name'        => $name,
				'mpn'         => $post_id,
				'sku'         => $sku,
				'brand'       => array(
					'@type' => 'Brand',
					'name'  => get_bloginfo( 'name' ),
				),
			);

			$json_ld['review'] = array(
				'author'       => array(
					'@type' => 'Person',
					'name'  => $author
				),
				'@type'        => 'Review',
				'reviewRating' => array(
					'@type'       => 'Rating',
					'ratingValue' => $average,
					'bestRating'  => $bestRating,
					'worstRating' => $worstRating,
				),
			);

			$json_ld['aggregateRating'] = array(
				'@type'       => 'AggregateRating',
				'ratingValue' => $rating_value,
				'ratingCount' => $rating_count,
				'bestRating'  => $bestRating,
				'worstRating' => $worstRating,
			);

			if ( ! empty( $settings['destination'] ) && ! empty( $settings['price'] ) ) {
				if ( empty( $settings['currency'] ) ) {
					$settings['currency'] = 'USD';
				}
				$json_ld['offers'] = array(
					'@type'         => 'Offer',
					'url'           => esc_url( $settings['destination'] ),
					'price'         => preg_replace( '/\D/', '', $settings['price'] ),
					'priceCurrency' => $settings['currency'],
					'itemCondition' => 'https://schema.org/UsedCondition',
					'availability'  => 'https://schema.org/InStock',
				);
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		function open_graph() {

			if ( ! foxiz_get_option( 'open_graph' ) || $this->check_conflict_open_graph() || foxiz_is_amp() ) {
				return false;
			}

			$facebook_app_id = foxiz_get_option( 'facebook_app_id' ); ?>
            <meta property="og:title" content="<?php echo $this->get_og_title(); ?>"/>
            <meta property="og:url" content="<?php echo $this->get_og_permalink(); ?>"/>
            <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>"/>
			<?php if ( is_front_page() ) : ?>
                <meta property="og:description" content="<?php get_bloginfo( 'description' );; ?>"/>
			<?php endif;
			if ( $this->og_get_image() ) : ?>
                <meta property="og:image" content="<?php echo $this->og_get_image(); ?>"/>
			<?php endif; ?>
			<?php if ( ! empty( $facebook_app_id ) ) : ?>
                <meta property="fb:facebook_app_id" content="<?php echo esc_attr( $facebook_app_id ); ?>"/>
			<?php endif;
			if ( is_singular( 'post' ) ) :
				global $post;

				$count = get_post_meta( $post->ID, 'foxiz_content_total_word', true );
				if ( ! empty( $count ) ) {
				    $count = intval($count);
					$read_speed = intval( foxiz_get_option( 'read_speed' ) );
					if ( empty( $read_speed ) ) {
						$read_speed = 130;
					}
					$minutes = floor( $count / $read_speed );
					$second  = floor( ( $count / $read_speed ) * 60 ) % 60;
					if ( $second > 30 ) {
						$minutes ++;
					}
				}
				?>
                <meta property="og:type" content="article"/>
                <meta property="article:published_time" content="<?php echo gmdate( 'c', strtotime( $post->post_date_gmt ) ); ?>"/>
                <meta property="article:modified_time" content="<?php echo gmdate( 'c', strtotime( $post->post_modified_gmt ) ); ?>"/>
                <meta name="author" content="<?php the_author_meta( 'display_name', $post->post_author ); ?>"/>
                <meta name="twitter:card" content="summary_large_image"/>
                <meta name="twitter:creator" content="<?php echo '@' . foxiz_get_twitter_name(); ?>"/>
                <meta name="twitter:label1" content="<?php esc_html_e( 'Written by', 'foxiz-core' ) ?>"/>
                <meta name="twitter:data1" content="<?php the_author_meta( 'display_name', $post->post_author ); ?>"/>
				<?php if ( ! empty( $minutes ) ) : ?>
                <meta name="twitter:label2" content="<?php esc_html_e( 'Est. reading time', 'foxiz-core' ) ?>"/>
                <meta name="twitter:data2" content="<?php echo $minutes; ?>> minutes"/>
			<?php endif;
			endif;
		}

		function get_og_title() {

			if ( is_singular() ) {
				return get_the_title();
			}

			return wp_get_document_title();
		}

		function get_og_permalink() {

			if ( is_singular() ) {
				return get_permalink();
			}

			global $wp;

			return home_url( add_query_arg( array(), $wp->request ) );
		}

		function og_get_image() {

			if ( is_singular() && has_post_thumbnail( get_the_ID() ) ) {

				$thumbnail_url = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
				if ( ! empty( $thumbnail_url ) ) {
					return $thumbnail_url;
				}
			} elseif ( is_category() ) {

				$id   = get_queried_object_id();
				$data = get_option( 'foxiz_category_meta', array() );

				if ( ! empty( $data[ $id ]['featured_image'][0] ) ) {
					$thumbnail_url = wp_get_attachment_image_url( $data[ $id ]['featured_image'][0], 'full' );
					if ( ! empty( $thumbnail_url ) ) {
						return $thumbnail_url;
					}
				}
			} elseif ( is_author() ) {
				return get_avatar_url( get_queried_object_id(), array( 'size' => '999' ) );
			} elseif ( is_home() || is_front_page() ) {
				$image = foxiz_get_option( 'site_logo' );
				if ( ! empty( $image['url'] ) ) {
					return $image['url'];
				}
			}

			$image = foxiz_get_option( 'facebook_default_img' );
			if ( ! empty( $image['url'] ) ) {
				return $image['url'];
			}

			return false;
		}

		/**
		 * @return false
		 */
		function post_list_markup() {

			if ( ! foxiz_get_option( 'site_itemlist' ) || is_single() || ! isset( $GLOBALS['foxiz_queried_ids'] ) || ! array_filter( $GLOBALS['foxiz_queried_ids'] ) ) {
				return false;
			}

			$items_list = array();
			$index      = 1;
			$items      = array_unique( $GLOBALS['foxiz_queried_ids'] );
			foreach ( $items as $post_id ) {
				$data = array(
					'@type'    => "ListItem",
					'position' => $index,
					'url'      => get_permalink( $post_id ),
					'name'     => get_the_title( $post_id ),
					'image'    => get_the_post_thumbnail_url( $post_id, 'full' )
				);
				array_push( $items_list, $data );
				$index ++;
			}
			$post_data = array(
				'@context'        => 'https://schema.org',
				'@type'           => 'ItemList',
				"itemListElement" => $items_list
			);

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $post_data, JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $post_data );
			}
			echo '</script>', "\n";

			return false;
		}

		/**
		 * @param $classes
		 *
		 * @return mixed
		 */
		function remove_hatom( $classes ) {

			foreach ( $classes as $key => $value ) {
				if ( $value === 'hentry' ) {
					unset( $classes[ $key ] );
				}
			}

			return $classes;
		}

		/** Speed optimized */
		function lazy_load() {

			if ( empty( foxiz_get_option( 'lazy_load' ) ) ) {
				return false;
			} else {
				return true;
			}
		}

		function set_elementor_font_display() {

			if ( empty( get_option( 'elementor_font_display' ) ) ) {
				update_option( 'elementor_font_display', 'swap' );
			}
		}

		/**
		 * @param $attr
		 * @param $attachment
		 * @param $size
		 *
		 * @return mixed
		 */
		function optimize_featured_image( $attr, $attachment, $size ) {

			if ( foxiz_get_option( 'disable_srcset' ) ) {
				unset( $attr['srcset'] );
				unset( $attr['sizes'] );
			}

			return $attr;
		}

		function is_elementor() {

			if ( ! is_page() ) {
				return false;
			}
			$document = false;
			if ( class_exists( 'Elementor\Plugin' ) ) {
				$document = Elementor\Plugin::$instance->documents->get( get_the_ID() );
			}
			if ( $document && $document->is_built_with_elementor() ) {
				return true;
			}

			return false;
		}

		function enqueue_optimized() {

			if ( ! empty( $_GET['elementor-preview'] ) || is_admin() || foxiz_is_amp() ) {
				return false;
			}

			if ( foxiz_get_option( 'disable_dashicons' ) && ! is_user_logged_in() ) {
				wp_deregister_style( 'dashicons' );
			}
			if ( foxiz_get_option( 'disable_polyfill' ) && ! is_admin() ) {
				wp_deregister_script( 'wp-polyfill' );
			}
			if ( foxiz_get_option( 'disable_block_style' ) && $this->is_elementor() ) {
				wp_deregister_style( 'wp-block-library' );
			}
		}

		function start_head_buffer() {

			if ( foxiz_is_amp() ) {
				return false;
			}

			ob_start();
		}

		/**
		 * @return false
		 */
		function end_head_buffer() {

			if ( foxiz_is_amp() ) {
				return false;
			}
			$in = ob_get_clean();
			if ( ! foxiz_get_option( 'preload_gfonts' ) || is_admin() || ! empty( $_GET['elementor-preview'] ) ) {
				echo $in;

				return false;
			}

			$markup = preg_replace( '/<!--(.*)-->/Uis', '', $in );
			preg_match_all( '#<link(?:\s+(?:(?!href\s*=\s*)[^>])+)?(?:\s+href\s*=\s*([\'"])((?:https?:)?\/\/fonts\.googleapis\.com\/css(?:(?!\1).)+)\1)(?:\s+[^>]*)?>#iU', $markup, $matches );

			if ( ! $matches[2] ) {
				echo $in;

				return false;
			}

			$fonts_data    = array();
			$index         = 0;
			$fonts_string  = '';
			$subset_string = '';
			$add_pos       = '<link';

			foreach ( $matches[2] as $font ) {
				if ( ! preg_match( '/rel=["\']dns-prefetch["\']/', $matches[0][ $index ] ) ) {
					$font = str_replace( array( '%7C', '%7c' ), '|', $font );
					if ( strpos( $font, 'fonts.googleapis.com/css2' ) !== false ) {
						$font = rawurldecode( $font );
						$font = str_replace( array(
							'css2?',
							'ital,wght@',
							'wght@',
							'ital@',
							'0,',
							'1,',
							':1',
							';',
							'&family='
						), array( 'css?', '', '', '', '', 'italic', ':italic', ',', '%7C' ), $font );
					}
					$font      = explode( 'family=', $font );
					$font      = ( isset( $font[1] ) ) ? explode( '&', $font[1] ) : array();
					$this_font = array_values( array_filter( explode( '|', reset( $font ) ) ) );
					if ( ! empty( $this_font ) ) {
						$fonts_data[ $index ]['fonts'] = $this_font;
						$subset                        = ( is_array( $font ) ) ? end( $font ) : '';
						if ( false !== strpos( $subset, 'subset=' ) ) {
							$subset                          = str_replace( array( '%2C', '%2c' ), ',', $subset );
							$subset                          = explode( 'subset=', $subset );
							$fonts_data[ $index ]['subsets'] = explode( ',', $subset[1] );
						}
					}
					$in = str_replace( $matches[0][ $index ], '', $in );
				}
				$index ++;
			}

			foreach ( $fonts_data as $font ) {
				$fonts_string .= '|' . trim( implode( '|', $font['fonts'] ), '|' );
				if ( ! empty( $font['subsets'] ) ) {
					$subset_string .= ',' . trim( implode( ',', $font['subsets'] ), ',' );
				}
			}

			if ( ! empty( $subset_string ) ) {
				$subset_string = str_replace( ',', '%2C', ltrim( $subset_string, ',' ) );
				$fonts_string  = $fonts_string . '&#038;subset=' . $subset_string;
			}

			$fonts_string = str_replace( '|', '%7C', ltrim( $fonts_string, '|' ) );
			$fonts_string .= '&amp;display=swap';
			$fonts_html   = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
			$fonts_html   .= '<link rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" id="rb-preload-gfonts" href="https://fonts.googleapis.com/css?family=' . $fonts_string . '" crossorigin>';
			$fonts_html   .= '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . $fonts_string . '"></noscript>';

			echo substr_replace( $in, $fonts_html . $add_pos, strpos( $in, $add_pos ), strlen( $add_pos ) );

			return false;
		}

		function preload_font_icon() {

			if ( foxiz_get_option( 'preload_icon' ) && ! is_admin() ) {
				echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/icons.woff' ) . '" as="font" type="font/woff" crossorigin="anonymous"> ';
				if ( foxiz_get_option( 'font_awesome' ) ) {
					echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/fa-brands-400.woff2' ) . '" as="font" type="font/woff2" crossorigin="anonymous"> ';
					echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/fa-regular-400.woff2' ) . '" as="font" type="font/woff2" crossorigin="anonymous"> ';
				}
			}
		}
	}
}

