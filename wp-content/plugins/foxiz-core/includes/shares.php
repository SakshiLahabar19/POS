<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_twitter_name' ) ) {
	/**
	 * @return array|string|string[]|void
	 */
	function foxiz_get_twitter_name() {

		if ( is_singular( 'post' ) ) {
			global $post;
			$name = get_the_author_meta( 'twitter_url', $post->post_author );
		} else {
			$name = foxiz_get_option( 'twitter' );
		}

		if ( empty( $name ) ) {
			$name = get_bloginfo( 'name' );
		}

		$name = parse_url( $name, PHP_URL_PATH );
		$name = str_replace( '/', '', $name );

		return $name;
	}
}

if ( ! function_exists( 'foxiz_render_share_list' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_render_share_list( $settings = array() ) {

		if ( ! empty( $settings['post_id'] ) ) {
			$post_id = $settings['post_id'];
		} else {
			$post_id = get_the_ID();
		}

		$protocol     = foxiz_protocol();
		$twitter_user = foxiz_get_twitter_name();
		$post_title   = urlencode( html_entity_decode( get_the_title( $post_id ), ENT_COMPAT, 'UTF-8' ) );
		if ( function_exists( 'wpme_get_shortlink' ) ) {
			$permalink = wpme_get_shortlink( $post_id );
		}
		if ( empty( $permalink ) ) {
			$permalink = get_permalink( $post_id );
		}
		$tipsy_gravity = '';
		if ( ! empty( $settings['tipsy_gravity'] ) ) {
			$tipsy_gravity = ' data-gravity=' . $settings['tipsy_gravity'] . '';
		}
		if ( ! empty( $settings['facebook'] ) ) : ?>
            <a class="share-action share-trigger icon-facebook" href="<?php echo esc_attr( $protocol ); ?>://www.facebook.com/sharer.php?u=<?php echo urlencode( $permalink ); ?>" data-title="Facebook"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-facebook"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Facebook', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['twitter'] ) ) : ?>
        <a class="share-action share-trigger icon-twitter" href="https://twitter.com/intent/tweet?text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>&amp;url=<?php echo urlencode( $permalink ); ?>&amp;via=<?php echo urlencode( $twitter_user ); ?>" data-title="Twitter"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow">
            <i class="rbi rbi-twitter"></i><?php if ( ! empty( $settings['social_name'] ) ) {
				echo '<span>' . foxiz_html__( 'Twitter', 'foxiz-core' ) . '</span>';
			} ?></a><?php endif;
		if ( ! empty( $settings['pinterest'] ) ) :
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'foxiz_780x0-2x' );
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) && get_post_meta( $post_id, '_yoast_wpseo_metadesc', true ) !== '' ) {
				$pinterest_description = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true );
			} else {
				$pinterest_description = $post_title;
			} ?>
            <a class="share-action share-trigger share-trigger icon-pinterest" rel="nofollow" href="<?php echo esc_attr( $protocol ); ?>://pinterest.com/pin/create/button/?url=<?php echo urlencode( $permalink ); ?>&amp;media=<?php if ( ! empty( $image[0] ) ) {
				echo( esc_url( $image[0] ) );
			} ?>&amp;description=<?php echo htmlspecialchars( $pinterest_description, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Pinterest"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-pinterest"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Pinterest', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['whatsapp'] ) ) : ?>
            <a class="share-action icon-whatsapp is-web" href="<?php echo esc_attr( $protocol ); ?>://web.whatsapp.com/send?text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ) . ' &#9758; ' . urlencode( $permalink ); ?>" target="_blank" data-title="WhatsApp"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-whatsapp"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Whatsapp', 'foxiz-core' ) . '</span>';
				} ?></a>
            <a class="share-action icon-whatsapp is-mobile" href="whatsapp://send?text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ) . ' &#9758; ' . urlencode( $permalink ); ?>" target="_blank" data-title="WhatsApp"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-whatsapp"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Whatsapp', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['linkedin'] ) ) : ?>
            <a class="share-action share-trigger icon-linkedin" href="<?php echo esc_attr( $protocol ); ?>://linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( $permalink ); ?>&amp;title=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="linkedIn"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-linkedin"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'LinkedIn', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['tumblr'] ) ) : ?>
            <a class="share-action share-trigger icon-tumblr" href="<?php echo esc_attr( $protocol ); ?>://www.tumblr.com/share/link?url=<?php echo urlencode( $permalink ); ?>&amp;name=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>&amp;description=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Tumblr"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-tumblr"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Tumblr', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['reddit'] ) ) : ?>
            <a class="share-action share-trigger icon-reddit" href="<?php echo esc_attr( $protocol ); ?>://www.reddit.com/submit?url=<?php echo urlencode( $permalink ); ?>&amp;title=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Reddit"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-reddit"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Reddit', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['vk'] ) ) : ?>
            <a class="share-action share-trigger icon-vk" href="<?php echo esc_attr( $protocol ); ?>://vkontakte.ru/share.php?url=<?php echo urlencode( $permalink ); ?>" data-title="VKontakte" rel="nofollow"><i class="rbi rbi-vk"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'VKontakte', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['telegram'] ) ) : ?>
            <a class="share-action share-trigger icon-telegram" href="<?php echo esc_attr( $protocol ); ?>://t.me/share/?url=<?php echo urlencode( $permalink ); ?>&amp;text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Telegram"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow"><i class="rbi rbi-telegram"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Telegram', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['email'] ) ) :
			$mailto = 'mailto:?subject=' . get_the_title( $post_id ) . ' BODY=' . sprintf( foxiz_html__( 'I found this article interesting and thought of sharing it with you. Check it out: %s', 'foxiz-core' ), $permalink );
			?>
            <a class="share-action icon-email" href="<?php echo esc_url( $mailto ) ?>" data-title="Email"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow">
            <i class="rbi rbi-email"></i><?php if ( ! empty( $settings['social_name'] ) ) {
			echo '<span>' . foxiz_html__( 'Email', 'foxiz-core' ) . '</span>';
		} ?></a>
		<?php endif;
		if ( ! empty( $settings['copy'] ) && ! foxiz_is_amp() ) : ?>
            <a class="share-action live-tooltip icon-copy copy-trigger" href="#" data-copied="<?php foxiz_attr_e( 'Copied!', 'foxiz-core' ); ?>" data-link="<?php echo esc_url( $permalink ); ?>" rel="nofollow" data-copy="<?php foxiz_html_e( 'Copy Link' ); ?>"<?php echo esc_html( $tipsy_gravity ); ?>><i class="rbi rbi-link-o"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Copy Link', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;
		if ( ! empty( $settings['print'] ) && ! foxiz_is_amp() ) : ?>
            <a class="share-action icon-print" rel="nofollow" href="javascript:if(window.print)window.print()" data-title="<?php foxiz_html_e( 'Print' ); ?>"<?php echo esc_html( $tipsy_gravity ); ?>><i class="rbi rbi-print"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . foxiz_html__( 'Print', 'foxiz-core' ) . '</span>';
				} ?></a>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_render_like' ) ) {
	/**
	 * @return false
	 */
	function foxiz_render_like() {

		if ( foxiz_is_amp() ) {
			return false;
		}

		$protocol     = foxiz_protocol();
		$twitter_user = foxiz_get_twitter_name();
		$post_title   = urlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>
        <aside class="like-box">
            <div class="like-el fb-like">
                <iframe src="<?php echo esc_attr( $protocol ); ?>://www.facebook.com/plugins/like.php?href=<?php echo get_permalink() ?>&amp;layout=button_count&amp;show_faces=false&amp;width=105&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:105px; height:21px; background-color:transparent;"></iframe>
            </div>
            <div class="like-el twitter-like">
                <a href="<?php echo esc_attr( $protocol ); ?>://twitter.com/intent/tweet" class="twitter-share-button" data-url="<?php echo get_permalink() ?>" data-text="<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-via="<?php echo urlencode( $twitter_user ); ?>" data-lang="en" rel="nofollow"></a>
				<?php if ( ! wp_doing_ajax() ) : ?>
                    <script>window.twttr = (function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0],
                                t = window.twttr || {};
                            if (d.getElementById(id)) return t;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "https://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                            t._e = [];
                            t.ready = function (f) {
                                t._e.push(f);
                            };
                            return t;
                        }(document, "script", "twitter-wjs"));</script>
				<?php endif; ?>
            </div>
        </aside>
		<?php
	}
}

