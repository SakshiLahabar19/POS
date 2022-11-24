<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'rb_weather_data' ) ) {
	/**
	 * @param $options
	 *
	 * @return false|string
	 */
	function rb_weather_data( $options ) {

		$title               = isset( $options['title'] ) ? $options['title'] : false;
		$location            = isset( $options['location'] ) ? $options['location'] : false;
		$api_key             = isset( $options['api_key'] ) ? $options['api_key'] : false;
		$days_to_show        = isset( $options['forecast_days'] ) ? $options['forecast_days'] : 5;
		$units               = ( isset( $options['units'] ) and strtoupper( $options['units'] ) === "C" ) ? "metric" : "imperial";
		$units_display       = ( $units === "metric" ) ? esc_html__( 'C', 'foxiz-core' ) : esc_html__( 'F', 'foxiz-core' );
		$locale              = 'en';
		$now_w_icon          = '';
		$ruby_today_temp     = '';
		$name_country        = '';
		$weather_description = '';

		$system_locale = get_locale();
		$foxizlocales  = array(
			'en',
			'es',
			'sp',
			'fr',
			'it',
			'de',
			'pt',
			'ro',
			'pl',
			'ru',
			'uk',
			'ua',
			'fi',
			'nl',
			'bg',
			'sv',
			'se',
			'ca',
			'tr',
			'hr',
			'zh',
			'zh_tw',
			'zh_cn',
			'hu'
		);

		if ( in_array( $system_locale, $foxizlocales ) ) {
			$locale = $system_locale;
		}

		if ( in_array( substr( $system_locale, 0, 2 ), $foxizlocales ) ) {
			$locale = substr( $system_locale, 0, 2 );
		}

		if ( is_numeric( $location ) ) {
			$city_name_slug = $location;
			$your_city      = "id=" . $location;
		} else {
			$city_name_slug = sanitize_title( $location );
			$your_city      = "q=" . $location;
		}

		$weather_transient_name = 'foxiz_' . $city_name_slug . "_" . strtolower( $units_display ) . '_' . $locale;

		if ( get_transient( $weather_transient_name ) ) {
			$weather_data = get_transient( $weather_transient_name );
		} else {
			$weather_data['now'] = array();
			$now_ping            = "https://api.openweathermap.org/data/2.5/weather?" . $your_city . "&lang=" . $locale . "&units=" . $units . "&APPID=" . $api_key;
			$now_ping_get        = wp_remote_get( $now_ping, array( 'timeout' => 120 ) );

			if ( is_wp_error( $now_ping_get ) ) {
				weather_error();

				return false;
			}

			$city_data = json_decode( $now_ping_get['body'] );

			if ( isset( $city_data->cod ) && $city_data->cod === 404 ) {
				weather_error();

				return false;
			} else {
				$weather_data['now'] = $city_data;
			}

			if ( $days_to_show !== 'hide' ) {
				$weather_data['forecast'] = array();

				$rb_forecast_ping = "https://api.openweathermap.org/data/2.5/forecast?" . $your_city . "&lang=" . $locale . "&units=" . $units . "&cnt=35&appid=" . $api_key;

				$rb_forecast_ping_get = wp_remote_get( $rb_forecast_ping, array( 'timeout' => 120 ) );

				$rb_forecast_data = json_decode( $rb_forecast_ping_get['body'] );

				if ( isset( $rb_forecast_data->cod ) && $rb_forecast_data->cod === 404 ) {
					weather_error();

					return false;
				} else {
					$weather_data['forecast'] = $rb_forecast_data;
				}
			}
		}

		if ( $weather_data['now'] || $weather_data['forecast'] ) {
			set_transient( $weather_transient_name, $weather_data, 10800 );
		}

		$ruby_today = $weather_data['now'];

		if ( ! empty( $ruby_today->main->temp ) ) {
			$ruby_today_temp = round( $ruby_today->main->temp );
		}

		if ( ! empty( $ruby_today->main->temp_max ) ) {
			$ruby_today_high = round( $ruby_today->main->temp_max );
		}

		if ( ! empty( $ruby_today->main->temp_min ) ) {
			$ruby_today_low = round( $ruby_today->main->temp_min );
		}

		if ( ! empty( $ruby_today->main->humidity ) ) {
			$ruby_today->main->humidity = round( $ruby_today->main->humidity );
		}

		if ( ! empty( $ruby_today->wind->speed ) && 0 !== ( $ruby_today->wind->speed ) ) {
			$ruby_today->wind->speed = round( $ruby_today->wind->speed );
		}

		$speed_text = ( $units === "metric" ) ? esc_html__( 'km/h', 'foxiz-core' ) : esc_html__( 'mph', 'foxiz-core' );
		if ( ! empty( $ruby_today->name ) ) {
			$name_country = $ruby_today->name;
		}

		if ( ! empty( $ruby_today->weather[0]->description ) ) {
			$weather_description = $ruby_today->weather[0]->description;
		}

		if ( ! empty( $ruby_today->main->humidity ) ) {
			$weather_humidity = $ruby_today->main->humidity . '' . esc_html__( '%', 'foxiz-core' );
		}

		if ( ! empty( $ruby_today->wind->speed ) ) {
			$weather_speed = $ruby_today->wind->speed . ' ' . esc_html( $speed_text ) . ' ';
		}

		if ( ! empty( $ruby_today->weather[0]->icon ) ) {
			$ruby_today_icon = $ruby_today->weather[0]->icon;
			$now_w_icon      = rb_weather_icon( $ruby_today_icon );
		}

		ob_start();
		if ( ( 401 !== $weather_data['now']->cod ) && ! empty( $options['api_key'] ) ) :
			$classes = 'rb-weather-wrap';
			if ( ! empty( $options['color_scheme'] ) ) {
				$classes .= ' light-scheme';
			}
			?><div class="<?php echo esc_attr( $classes ); ?>">
				<?php if ( ! empty( $title ) ) : ?>
					<div class="rb-w-title h4">
						<?php echo esc_html( $title ) ?>
					</div>
				<?php endif; ?>
				<div class="rb-w-header">
					<div class="col-left">
						<div class="rb-w-big-icon <?php esc_html( $now_w_icon ) ?>">
							<?php foxiz_render_svg( esc_html( $now_w_icon ), '', 'weather' ) ?>
						</div>

					</div>
					<div class="col-right">
						<div class="rb-w-units h6">
							<span><?php echo esc_html( $ruby_today_temp ) ?></span>
							<span class="ruby-degrees">
		                            <sup><?php echo '&deg;' . esc_html( $units_display ) ?></sup>
		                       </span>
						</div>
					</div>
				</div>
				<div class="rb-w-stats">
					<div class="col-left">
						<div class="rb-header-name h6">
							<?php echo esc_html( $name_country ) ?>
						</div>
						<div class="rb-w-desc">
							<?php echo esc_html( $weather_description ) ?>
						</div>
					</div>
					<div class="col-right">
						<div class="rb-weather-highlow">
							<?php if ( ! empty( $ruby_today_high ) ) : ?>
								<span class="icon-hight"><?php foxiz_render_svg( 'hight', '', 'weather' ) ?></span>
								<span class="text-hight"><?php echo esc_html( $ruby_today_high ) ?><sup><?php echo '&deg;'; ?></sup></span>
							<?php endif; ?>
							<?php if ( ! empty( $ruby_today_low ) ) : ?>
								<span>&lowbar;</span><span class="icon-low"><?php foxiz_render_svg( 'low', '', 'weather' ) ?></span>
								<span class="text-low"><?php echo esc_html( $ruby_today_low ) ?><sup><?php echo '&deg;'; ?></sup></span>
							<?php endif; ?>
						</div>
						<div class="rb-w-humidity">
							<?php if ( ! empty( $weather_humidity ) ) : ?>
								<span class="icon-humidity"><?php foxiz_render_svg( 'raindrop', '', 'weather' ) ?></span>
								<span><?php echo esc_html( $weather_humidity ) ?></span>
							<?php endif; ?>
						</div>
						<div class="ruby-weather-wind">
							<?php if ( ! empty( $weather_speed ) ) : ?>
								<span class="icon-windy"><?php foxiz_render_svg( 'windy', '', 'weather' ) ?></span>
								<span><?php echo esc_html( $weather_speed ) ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php if ( $days_to_show !== 'hide' && ( ! empty( $weather_data['forecast'] ) || ! empty( $weather_data['forecast']->list ) ) ) : ?>
					<div class="w-forecast-wrap">
						<?php
						$rb_forecast_days = array();
						$today_date       = date( 'Ymd', current_time( 'timestamp', 0 ) );

						foreach ( (array) $weather_data['forecast']->list as $rb_forecast ) :

							$day_of_week = date( 'Ymd', $rb_forecast->dt );

							if ( $today_date > $day_of_week ) {
								continue;
							}

							if ( $today_date == $day_of_week ) {
								if ( ! empty( $rb_forecast->main->temp_max ) && $rb_forecast->main->temp_max > $ruby_today_high ) {
									$ruby_today_high = round( $rb_forecast->main->temp_max );
								}
								if ( ! empty( $rb_forecast->main->temp_min ) && $rb_forecast->main->temp_min < $ruby_today_low ) {
									$ruby_today_low = round( $rb_forecast->main->temp_min );
								}
							}

							if ( empty( $rb_forecast_days[ $day_of_week ] ) ) {
								$rb_forecast_days[ $day_of_week ] = array(
									'utc'  => $rb_forecast->dt,
									'icon' => $rb_forecast->weather[0]->icon,
									'temp' => ! empty( $rb_forecast->main->temp_max ) ? round( $rb_forecast->main->temp_max ) : '',
								);
							} else {
								if ( ( $rb_forecast->main->temp_max ) > ( $rb_forecast_days[ $day_of_week ]['temp'] ) ) {
									$rb_forecast_days[ $day_of_week ]['temp'] = round( $rb_forecast->main->temp_max );
									$rb_forecast_days[ $day_of_week ]['icon'] = $rb_forecast->weather[0]->icon;
								}
							}
						endforeach;

						$count          = 1;
						foreach ( $rb_forecast_days as $rb_forecast_day ) :
							$forecast_icon = rb_weather_icon( $rb_forecast_day['icon'] );
							$rb_the_day = date_i18n( 'D', $rb_forecast_day['utc'] ); ?>
							<div class="w-forecast-day forecast-day-<?php echo esc_html( $days_to_show ) ?>">
								<div class="w-forecast-day h6"><?php echo esc_html( $rb_the_day ) ?></div>
								<div class="w-forecast-icon"><?php foxiz_render_svg( esc_html( $forecast_icon ), '', 'weather' . esc_html( $count ) ) ?></div>
								<div class="w-forecast-temp"><?php echo esc_html( $rb_forecast_day['temp'] ) ?>
									<sup><?php echo '&deg;' . esc_html( $units_display ) ?></sup>
								</div>
							</div>

							<?php
							if ( $count === intval($days_to_show) ) {
								break;
							}
							$count ++;
						endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else:
			weather_error();
		endif;

		return ob_get_clean();
	}
}

if ( ! function_exists( 'rb_weather_icon' ) ) {
	/**
	 * @param $rb_icon
	 *
	 * @return string
	 */
	function rb_weather_icon( $rb_icon ) {
		if ( $rb_icon === '01d' ) {
			$icon_weather = 'day-sunny';
		} elseif ( $rb_icon === '01n' ) {
			$icon_weather = 'moon-full';
		} elseif ( $rb_icon === '02d' ) {
			$icon_weather = 'day-cloudy';
		} elseif ( $rb_icon === '02n' ) {
			$icon_weather = 'night-cloudy';
		} elseif ( $rb_icon === '04d' || $rb_icon === '04n' ) {
			$icon_weather = 'cloudy';
		} elseif ( $rb_icon === '09d' || $rb_icon === '09n' ) {
			$icon_weather = 'rain';
		} elseif ( $rb_icon === '10d' ) {
			$icon_weather = 'day-rain';
		} elseif ( $rb_icon === '10n' ) {
			$icon_weather = 'night-rain';
		} elseif ( $rb_icon === '11d' ) {
			$icon_weather = 'storm-showers';
		} elseif ( $rb_icon === '11n' ) {
			$icon_weather = 'storm-showers';
		} elseif ( $rb_icon === '13d' ) {
			$icon_weather = 'day-snow';
		} elseif ( $rb_icon === '13n' ) {
			$icon_weather = 'night-alt-snow';
		} elseif ( $rb_icon === '50d' ) {
			$icon_weather = 'day-fog';
		} elseif ( $rb_icon === '50n' ) {
			$icon_weather = 'night-fog';
		} else {
			$icon_weather = 'cloudy';
		}

		return $icon_weather;
	}
}

if ( ! function_exists( 'weather_error' ) ) {
	/**
	 * @return false
	 */
	function weather_error() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}
		?>
		<div class="rb-weather-error is-meta"><?php echo esc_html__( 'No weather information available. Please check your location here: ', 'foxiz-core' ) ?>
			<a target="_blank" href="https://openweathermap.org/find/"><?php echo esc_html__( 'Find location', 'foxiz-core' ) ?></a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'rb_social_follower' ) ) {
	/**
	 * @param $instance
	 * @param $style
	 *
	 * @return false|string
	 */
	function rb_social_follower( $instance, $style ) {

		$classes   = array();
		$classes[] = 'sb-social-counter fncount-wrap';
		if ( ! empty( $instance['color_scheme'] ) ) {
			$classes[] = 'light-scheme';
		}

		$style = intval( $style );

		switch ( $style ) {
			case 1:
				$classes[] = 'is-style-1';
				break;
			case 2:
				$classes[] = 'is-style-2';
				break;
			case 3:
				$classes[] = 'is-style-3';
				break;
			case 4:
				$classes[] = 'is-style-4';
				break;
			case 5:
				$classes[] = 'is-style-5';
				break;
			case 6:
				$classes[] = 'is-style-6';
				break;
			case 7:
				$classes[] = 'is-style-7';
				break;
			case 8:
				$classes[] = 'is-style-8';
				break;
			case 9:
				$classes[] = 'is-style-9';
				break;
			case 10:
				$classes[] = 'is-style-10';
				break;
			case 11:
				$classes[] = 'is-style-11';
				break;
			case 12:
				$classes[] = 'is-style-12';
				break;
			case 13:
				$classes[] = 'is-style-13';
				break;
			case 14:
				$classes[] = 'is-style-14';
				break;
			case 15:
				$classes[] = 'is-style-15';
				break;
		}
		$classes = implode( ' ', $classes );
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<div class="social-follower effect-fadeout">
				<?php if ( ! empty( $instance['facebook_page'] ) ) : ?>
					<div class="follower-el bg-facebook">
						<a target="_blank" href="https://facebook.com/<?php echo esc_html( $instance['facebook_page'] ); ?>" class="facebook" title="Facebook" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-facebook"></i></span>
                                <?php
                                if ( ! empty( $instance['facebook_count'] ) ) : ?>
	                                <span class="fntotal"><?php echo foxiz_pretty_number( $instance['facebook_count'] ) ?></span>
                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                <?php endif; ?>
                                    <span class="text-count"><?php echo foxiz_html__( 'Like' ); ?></span>
                                <?php else : ?>
	                                <span class="fnlabel"><?php echo foxiz_html__( 'Facebook' ); ?></span>
	                                <span class="text-count"><?php echo foxiz_html__( 'Like' ); ?></span>
                                <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['twitter_user'] ) ) : ?>
					<div class="follower-el bg-twitter">
						<a target="_blank" href="https://twitter.com/<?php echo esc_html( $instance['twitter_user'] ); ?>" class="twitter" title="Twitter" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-twitter"></i></span>
                                <?php if ( ! empty( $instance['twitter_count'] ) ) : ?>
	                                <span class="fntotal"><?php echo foxiz_pretty_number( $instance['twitter_count'] ); ?></span>
	                                <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                <?php endif; ?>
                                    <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                <?php else : ?>
	                                <span class="fnlabel"><?php echo foxiz_html__( 'Twitter' ); ?></span>
	                                <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['pinterest_user'] ) ) : ?>
					<div class="follower-el bg-pinterest">
						<a target="_blank" href="https://pinterest.com/<?php echo esc_html( $instance['pinterest_user'] ); ?>" class="pinterest" title="Pinterest" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-pinterest"></i></span>
                                <?php if ( ! empty( $instance['pinterest_count'] ) ) : ?>
	                                <span class="fntotal"><?php echo foxiz_pretty_number( $instance['pinterest_count'] ); ?></span>
	                                <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                <?php endif; ?>
                                    <span class="text-count"><?php echo foxiz_html__( 'Pin' ); ?></span>
                                <?php else : ?>
	                                <span class="fnlabel"><?php echo foxiz_html__( 'Pinterest' ); ?></span>
	                                <span class="text-count"><?php echo foxiz_html__( 'Pin' ); ?></span>
                                <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['instagram_user'] ) ) : ?>
					<div class="follower-el bg-instagram">
						<a target="_blank" href="https://instagram.com/<?php echo esc_html( $instance['instagram_user'] ); ?>" class="instagram" title="Instagram" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-instagram"></i></span>
                                    <?php if ( ! empty( $instance['instagram_count'] ) ) : ?>
	                                    <span class="fntotal"><?php echo foxiz_pretty_number( $instance['instagram_count'] ); ?></span>
	                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                    <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                    <?php endif; ?>
                                        <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php else : ?>
	                                    <span class="fnlabel"><?php echo foxiz_html__( 'Instagram' ); ?></span>
	                                    <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['youtube_link'] ) ) : ?>
					<div class="follower-el bg-youtube">
						<a target="_blank" href="<?php echo esc_html( $instance['youtube_link'] ); ?>" class="youtube" title="Youtube" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                 <span class="fnicon"><i class="rbi rbi-youtube"></i></span>
                                    <?php if ( ! empty( $instance['youtube_count'] ) ) : ?>
	                                    <span class="fntotal"><?php echo foxiz_pretty_number( $instance['youtube_count'] ); ?></span>
	                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                    <span class="fnlabel"><?php echo foxiz_html__( 'Subscribers' ); ?></span>
	                                    <?php endif; ?>
                                        <span class="text-count"><?php echo foxiz_html__( 'Subscribe' ); ?></span>
                                    <?php else : ?>
	                                    <span class="fnlabel"><?php echo foxiz_html__( 'Youtube' ); ?></span>
	                                    <span class="text-count"><?php echo foxiz_html__( 'Subscribe' ); ?></span>
                                    <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['soundcloud_user'] ) ) : ?>
					<div class="follower-el bg-soundcloud">
						<a target="_blank" href="https://soundcloud.com/<?php echo esc_html( $instance['soundcloud_user'] ); ?>" class="soundcloud" title="SoundCloud" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-soundcloud"></i></span>
                                    <?php if ( ! empty( $instance['soundcloud_count'] ) ) : ?>
	                                    <span class="fntotal"><?php echo foxiz_pretty_number( $instance['soundcloud_count'] ); ?></span>
	                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                    <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                    <?php endif; ?>
                                        <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php else : ?>
	                                    <span class="fnlabel"><?php echo foxiz_html__( 'SoundCloud' ); ?></span>
	                                    <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['telegram_link'] ) ) : ?>
					<div class="follower-el bg-telegram">
						<a target="_blank" href="<?php echo esc_html( $instance['telegram_link'] ); ?>" class="telegram" title="Telegram" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-telegram"></i></span>
                                    <?php if ( ! empty( $instance['telegram_count'] ) ) : ?>
							            <span class="fntotal"><?php echo foxiz_pretty_number( $instance['telegram_count'] ); ?></span>
	                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                    <span class="fnlabel"><?php echo foxiz_html__( 'Members' ); ?></span>
	                                    <?php endif; ?>
                                        <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php else : ?>
	                                    <span class="fnlabel"><?php echo foxiz_html__( 'Telegram' ); ?></span>
	                                    <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['vimeo_user'] ) ) : ?>
					<div class="follower-el bg-vimeo">
						<a target="_blank" href="https://vimeo.com/<?php echo esc_html( $instance['vimeo_user'] ); ?>" class="vimeo" title="Vimeo" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-vimeo"></i></span>
                                    <?php if ( ! empty( $instance['vimeo_count'] ) ) : ?>
	                                    <span class="fntotal"><?php echo foxiz_pretty_number( $instance['vimeo_count'] ); ?></span>
	                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                    <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                    <?php endif; ?>
                                        <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php else : ?>
	                                    <span class="fnlabel"><?php echo foxiz_html__( 'Vimeo' ); ?></span>
	                                    <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php endif; ?>
                            </span>
					</div>
				<?php endif;

				if ( ! empty( $instance['dribbble_user'] ) ) : ?>
					<div class="follower-el bg-dribbble">
						<a target="_blank" href="https://dribbble.com/<?php echo esc_html( $instance['dribbble_user'] ); ?>" class="dribbble" title="Dribbble" rel="noopener nofollow"></a>
						<span class="follower-inner h6">
                                <span class="fnicon"><i class="rbi rbi-dribbble"></i></span>
                                    <?php if ( ! empty( $instance['dribbble_count'] ) ) : ?>
	                                    <span class="fntotal"><?php echo foxiz_pretty_number( $instance['dribbble_count'] ); ?></span>
	                                    <?php if ( $style === 10 || $style === 11 || $style === 12 || $style === 13 || $style === 14 || $style === 15 ) : ?>
		                                    <span class="fnlabel"><?php echo foxiz_html__( 'Followers' ); ?></span>
	                                    <?php endif; ?>
                                        <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php else : ?>
	                                    <span class="fnlabel"><?php echo foxiz_html__( 'Dribbble' ); ?></span>
	                                    <span class="text-count"><?php echo foxiz_html__( 'Follow' ); ?></span>
                                    <?php endif; ?>
                            </span>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

if ( ! function_exists( 'rb_sidebar_banner' ) ) {
	/**
	 * @param $instance
	 */
	function rb_sidebar_banner( $instance ) {

		$inner_classes = 'w-banner-content';
		if ( ! empty( $instance['color_scheme'] ) ) {
			$inner_classes .= ' light-scheme';
		}
		?><div class="w-banner">
			<div class="banner-bg">
				<?php if ( ! empty( $instance['e_image']['id'] ) ) :
					$image = wp_get_attachment_image_src( $instance['e_image']['id'], 'full' );
					if ( empty( $image[0] ) ) {
						$image = array( '', 0, 0 );
					}
					if ( ! empty( $instance['e_dark_image']['id'] ) ) :
						$dark_image = wp_get_attachment_image_src( $instance['e_dark_image']['id'], 'full' );
						if ( empty( $dark_image[0] ) ) {
							$dark_image = array( '', 0, 0 );
						} ?>
						<img data-mode="default" src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr__( 'banner', 'foxiz-core' ); ?>" width="<?php echo esc_attr( $image[1] ); ?>" height="<?php echo esc_attr( $image[2] ); ?>">
						<img data-mode="dark" src="<?php echo esc_url( $dark_image[0] ); ?>" alt="<?php echo esc_attr__( 'banner', 'foxiz-core' ); ?>" width="<?php echo esc_attr( $dark_image[1] ); ?>" height="<?php echo esc_attr( $dark_image[2] ); ?>">
					<?php else : ?>
						<img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr__( 'banner', 'foxiz-core' ); ?>" width="<?php echo esc_attr( $image[1] ); ?>" height="<?php echo esc_attr( $image[2] ); ?>">
					<?php endif;
				else :
					if ( ! empty( $instance['image'] ) ) :
						$image_size = foxiz_get_image_size( $instance['image'] );
						if ( ! empty( $instance['dark_image'] ) ) :
							$dark_image_size = foxiz_get_image_size( $instance['dark_image'] );
							?>
							<img data-mode="default" src="<?php echo esc_url( $instance['image'] ); ?>" alt="<?php echo esc_attr__( 'banner', 'foxiz-core' );
							?>" width="<?php if ( ! empty( $image_size[0] ) ) {
								echo esc_attr( $image_size[0] );
							} ?>" height="<?php if ( ! empty( $image_size[1] ) ) {
								echo esc_attr( $image_size[1] );
							} ?>">
							<img data-mode="dark" src="<?php echo esc_url( $instance['dark_image'] ); ?>" alt="<?php echo esc_attr__( 'banner', 'foxiz-core' );
							?>" width="<?php if ( ! empty( $dark_image_size[0] ) ) {
								echo esc_attr( $dark_image_size[0] );
							} ?>" height="<?php if ( ! empty( $dark_image_size[1] ) ) {
								echo esc_attr( $dark_image_size[1] );
							} ?>">
						<?php else : ?>
							<img src="<?php echo esc_url( $instance['image'] ); ?>" alt="<?php echo esc_attr__( 'banner', 'foxiz-core' );
							?>" width="<?php if ( ! empty( $image_size[0] ) ) {
								echo esc_attr( $image_size[0] );
							} ?>" height="<?php if ( ! empty( $image_size[1] ) ) {
								echo esc_attr( $image_size[1] );
							} ?>">
						<?php endif;
					endif;
				endif; ?>
			</div>
			<div class="<?php echo esc_attr( $inner_classes ); ?>">
				<div class="content-inner">
					<?php if ( ! empty( $instance['title'] ) ) : ?>
						<h5 class="w-banner-title h2"><?php echo html_entity_decode( $instance['title'] ); ?></h5>
					<?php endif;
					if ( ! empty( $instance['description'] ) ) : ?>
						<div class="w-banner-desc element-desc"><?php echo html_entity_decode( $instance['description'] ); ?></div>
					<?php endif;
					if ( ! empty( $instance['url'] ) ) : ?>
						<div class="banner-btn is-btn">
							<a href="<?php echo esc_url( $instance['url'] ) ?>" target="_blank" rel="noopener nofollow"><?php echo esc_html( $instance['submit'] ) ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}