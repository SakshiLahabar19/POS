<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foxiz_W_Twitter', false ) ) :
	class Foxiz_W_Twitter extends WP_Widget {

		private $params = array();
		private $widgetID = 'widget-twitter';

		function __construct() {

			$this->params = array(
				'title'           => esc_html__( 'Latest Tweets', 'foxiz-core' ),
				'twitter_user'    => '',
				'num_tweets'      => '3',
				'consumer_key'    => '',
				'consumer_secret' => '',
				'access_token'    => '',
				'access_secret'   => '',
			);

			parent::__construct( $this->widgetID, esc_html__( 'Foxiz - Widget Twitter Tweets', 'foxiz-core' ), array(
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display latest Twitter tweets in the sidebars.', 'foxiz-core' )
			) );
		}

		function update( $new_instance, $old_instance ) {

			if ( current_user_can( 'unfiltered_html' ) ) {
				return wp_parse_args( (array) $new_instance, $this->params );
			} else {
				$instance = array();
				foreach ( $new_instance as $id => $value ) {
					$instance[ $id ] = sanitize_text_field( $value );
				}

				return wp_parse_args( $instance, $this->params );
			}
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'title' ),
				'name'  => $this->get_field_name( 'title' ),
				'title' => esc_html__( 'Title', 'foxiz-core' ),
				'value' => $instance['title']
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'twitter_user' ),
				'name'  => $this->get_field_name( 'twitter_user' ),
				'title' => esc_html__( 'Twitter User Name', 'foxiz-core' ),
				'value' => $instance['twitter_user'],
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'num_tweets' ),
				'name'  => $this->get_field_name( 'num_tweets' ),
				'title' => esc_html__( 'Number of Tweets', 'foxiz-core' ),
				'value' => $instance['num_tweets'],
			) );

			foxiz_create_widget_heading_field( array(
				'id'          => $this->get_field_id( 'twitter_api' ),
				'name'        => $this->get_field_name( 'twitter_api' ),
				'title'       => esc_html__( 'Twitter API Settings', 'foxiz-core' ),
				'description' => '<a href="https://dev.twitter.com/apps" target="_blank">Create your Twitter App</a>',
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'consumer_key' ),
				'name'  => $this->get_field_name( 'consumer_key' ),
				'title' => esc_html__( 'Twitter Consumer Key', 'foxiz-core' ),
				'value' => $instance['consumer_key'],
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'consumer_secret' ),
				'name'  => $this->get_field_name( 'consumer_secret' ),
				'title' => esc_html__( 'Twitter Consumer Secret', 'foxiz-core' ),
				'value' => $instance['consumer_secret'],
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'access_token' ),
				'name'  => $this->get_field_name( 'access_token' ),
				'title' => esc_html__( 'Twitter Access Token', 'foxiz-core' ),
				'value' => $instance['access_token'],
			) );

			foxiz_create_widget_text_field( array(
				'id'    => $this->get_field_id( 'access_secret' ),
				'name'  => $this->get_field_name( 'access_secret' ),
				'title' => esc_html__( 'Twitter Access Secret', 'foxiz-core' ),
				'value' => $instance['access_secret'],
			) );
		}

		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			$tweets_data = $this->get_tweets_data( $instance );

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . $instance['title'] . $args['after_title'];
			}

			if ( ! empty( $instance['twitter_user'] ) && ! empty( $tweets_data ) && is_array( $tweets_data ) && empty( $tweets_data['error'] ) ) :
				?>
                <div class="rb-twitter-wrap">
                    <div class="rb-twitter-inner">
                        <div class="rb-tweet-header">
                            <div class="rb-twitter-h-info">
                                <div class="tweet-avatar">
                                    <a class="rb-twitter-link" href="https://twitter.com/<?php echo esc_html( $tweets_data[0]->user->name ) ?>/" target="_blank">
                                        <img src="<?php echo esc_url( $tweets_data[0]->user->profile_image_url_https ) ?>" alt="<?php echo wp_strip_all_tags( $tweets_data[0]->user->name ) ?>" width="44" height="44">
                                    </a>
                                </div>
                                <div class="tweet-info h6">
                                    <a class="rb-twitter-link" href="https://twitter.com/<?php echo esc_html( $tweets_data[0]->user->name ) ?>/" target="_blank">
                                        <span>&commat;</span><span><?php echo esc_html( $tweets_data[0]->user->screen_name ) ?></span>
                                    </a>
                                </div>
                                <div class="pk-twitter-counters pk-color-secondary">
                                    <div class="rb-fl-counter rb-following">
                                        <a class="rb-twitter-link" href="https://twitter.com/<?php echo esc_html( $tweets_data[0]->user->name ) ?>/" target="_blank">
                                            <span class="rb-twitter-number h6"><?php echo esc_html( foxiz_pretty_number( $tweets_data[0]->user->friends_count ) ) ?></span>
                                            <span class="rb-twitter-text h6"><?php echo foxiz_html__( 'Following' ) ?></span>
                                        </a>
                                    </div>
                                    <div class="rb-fl-counter rb-followers">
                                        <a class="rb-twitter-link" href="https://twitter.com/<?php echo esc_url( $tweets_data[0]->user->name ) ?>/" target="_blank">
                                            <span class="rb-twitter-number h6"><?php echo esc_html( foxiz_pretty_number( $tweets_data[0]->user->followers_count ) ) ?></span>
                                            <span class="rb-twitter-text h6"><?php echo foxiz_html__( 'Followers' ) ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php foreach ( $tweets_data as $tweet ) :
							$tweet->text = preg_replace( '/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"$1\" class=\"twitter-link\">$1</a>", $tweet->text );
							$tweet->text = preg_replace( '/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $tweet->text );
							$tweet->text = preg_replace( "/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i", "<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $tweet->text );
							$tweet->text = preg_replace( '/([\.|\,|\:|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $tweet->text );
							$tweet->text = str_replace( 'RT', ' ', $tweet->text );

							$time = strtotime( $tweet->created_at );
							if ( ( abs( time() - $time ) ) < 86400 ) {
								$h_time = sprintf( foxiz_html__( '%s ago' ), human_time_diff( $time ) );
							} else {
								$h_time = date( 'M j, Y', $time );
							} ?>
                            <div class="rb-twitter-summary">
                                <div class="rb-quoted-author">
                                    <img src="<?php echo esc_url( $tweets_data[0]->user->profile_image_url_https ) ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $tweet->text ) ); ?>" width="24" height="24">
                                    <em class="twitter-timestamp h6"><?php echo esc_attr( $h_time ) ?></em>
                                </div>
                                <div class="rb-tweet-entry"><?php echo do_shortcode( $tweet->text ); ?></div>
                                <div class="rb-tweet-actions">
                                    <a class="rb-reply" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_html( $tweet->id_str ) ?>&related=<?php echo esc_html( $tweet->user->screen_name ) ?>" target="_blank" rel="noopener nofollow">
										<?php foxiz_render_svg( 'reply', '', 'tweet' ) ?>
                                    </a>
                                    <a class="rb-retweet" href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_html( $tweet->id_str ) ?>&related=<?php echo esc_html( $tweet->user->screen_name ) ?>" target="_blank" rel="noopener nofollow">
										<?php foxiz_render_svg( 'retweet', '', 'tweet' );
										if ( ( $tweet->retweet_count ) > 0 ) : ?>
                                            <span class="rb-action-count rb-retweet-count">
                                                <?php echo esc_html( $tweet->retweet_count ); ?>
                                            </span>
										<?php endif; ?>
                                    </a>
                                    <a class="rb-like" href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_html( $tweet->id_str ) ?>&related=<?php echo esc_html( $tweet->user->screen_name ) ?>" target="_blank" rel="noopener nofollow">
										<?php foxiz_render_svg( 'favorite', '', 'tweet' );
										if ( ( $tweet->favorite_count ) > 0 ) : ?>
                                            <span class="rb-action-count rb-favorite-count">
                                                <?php echo esc_html( $tweet->favorite_count ); ?>
                                             </span>
										<?php endif; ?>
                                    </a>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
			<?php endif;
			echo $args['after_widget'];
		}

		function get_tweets_data( $options ) {

			$cache_data_name = 'rb_twitter_' . $options['twitter_user'] . "_" . $options['num_tweets'] . '';
			$cache           = get_transient( $cache_data_name );
			if ( $cache === false ) {
				$data_tweets = $this->get_tweets( $options );
				if ( $data_tweets ) {
					set_transient( $cache_data_name, $data_tweets, 10800 );

					return $data_tweets;
				}
			} else {
				return $cache;
			}
		}

		function get_tweets( $options ) {

			if ( ! function_exists( 'getTweets' ) || ! class_exists( 'TwitterOAuth' ) ) {
				include_once FOXIZ_CORE_PATH . 'lib/twitteroauth/twitteroauth.php';
				$twitterConnection = new TwitterOAuth(
					$options['consumer_key'],
					$options['consumer_secret'],
					$options['access_token'],
					$options['access_secret']
				);
				$data_tweets       = $twitterConnection->get( 'statuses/user_timeline',
					array(
						'screen_name'     => $options['twitter_user'],
						'count'           => $options['num_tweets'],
						'exclude_replies' => false
					) );
				if ( $twitterConnection->http_code === 200 ) {
					return $data_tweets;
				}
			}

			return false;
		}

	}
endif;



