<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_single_review' ) ) {
	/**
	 * @param string $post_id
	 * @param false $is_shortcode
	 *
	 * @return false
	 */
	function foxiz_single_review( $post_id = '', $is_shortcode = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$_post = get_post( $post_id );
		if ( false !== strpos( $_post->post_content, '[ruby_review_box]' ) && ! $is_shortcode ) {
			return false;
		}

		$settings = foxiz_get_review_settings( $post_id );
		if ( empty( $settings ) || ! is_array( $settings ) ) {
			return false;
		}

		if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
			foxiz_single_review_score( $settings );
		} else {
			foxiz_single_review_star( $settings );
		}
	}
}

if ( ! function_exists( 'foxiz_single_review_score' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_single_review_score( $settings = array() ) { ?>
        <div class="review-section type-score">
            <div class="inner">
				<?php foxiz_render_review_header( $settings ); ?>
                <div class="review-content">
					<?php if ( is_array( $settings['criteria'] ) ) :
						foreach ( $settings['criteria'] as $element ) :
							if ( empty( $element['label'] ) || empty( $element['rating'] ) ) {
								continue;
							}
							if ( $element['rating'] > 10 ) {
								$element['rating'] = 10;
							} elseif ( $element['rating'] < 1 ) {
								$element['rating'] = 1;
							} ?>
                            <div class="review-el">
                                <div class="review-label">
                                    <span class="h5"><?php echo esc_html( $element['label'] ); ?></span>
                                    <span class="rating-info is-meta"><?php printf( foxiz_html__( '%s out of 10', 'foxiz' ), $element['rating'] ); ?></span>
                                </div>
                                <span class="review-rating">
                                    <?php echo foxiz_get_review_line( $element['rating'] ); ?>
                                </span>
                            </div>
						<?php endforeach;
					endif; ?>
                </div>
                <div class="review-footer">
					<?php
					foxiz_render_review_pros_cons( $settings );
					foxiz_render_review_summary( $settings );
					foxiz_render_review_rating( $settings )
					?>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_single_review_star' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_single_review_star( $settings = array() ) { ?>
        <div class="review-section type-star">
            <div class="inner">
				<?php foxiz_render_review_header( $settings ); ?>
                <div class="review-content">
					<?php if ( is_array( $settings['criteria'] ) ) :
						foreach ( $settings['criteria'] as $element ) :
							if ( empty( $element['label'] ) || empty( $element['rating'] ) ) {
								continue;
							}
							if ( $element['rating'] > 5 ) {
								$element['rating'] = 5;
							} elseif ( $element['rating'] < 1 ) {
								$element['rating'] = 1;
							} ?>
                            <div class="review-el">
                                <div class="review-label">
                                    <span class="h5"><?php echo esc_html( $element['label'] ); ?></span>
                                    <span class="rating-info is-meta"><?php printf( foxiz_html__( '%s out of 5', 'foxiz' ), $element['rating'] ); ?></span>
                                </div>
                                <span class="review-rating">
                                    <?php echo foxiz_get_review_stars( $element['rating'] ); ?>
                                </span>
                            </div>
						<?php endforeach;
					endif; ?>
                </div>
                <div class="review-footer">
					<?php
					foxiz_render_review_pros_cons( $settings );
					foxiz_render_review_summary( $settings );
					foxiz_render_review_rating( $settings )
					?>
                </div>
            </div>
        </div>
	<?php }
}

if ( ! function_exists( 'foxiz_render_review_header' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_render_review_header( $settings = array() ) { ?>
        <div class="review-header review-intro">
			<?php if ( ! empty( $settings['image'] ) ) : ?>
                <div class="review-bg">
					<?php if ( ! is_array( $settings['image'] ) ) : ?>
						<?php echo wp_get_attachment_image( $settings['image'], 'full' ); ?>
					<?php elseif ( ! empty( $settings['image']['url'] ) ) : ?>
                        <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['image']['url'] ); ?>" height="<?php echo esc_attr( $settings['image']['height'] ); ?>" width="<?php echo esc_attr( $settings['image']['width'] ); ?>">
					<?php endif ?>
                </div>
			<?php endif; ?>
            <div class="inner white-text">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
                    <div class="review-heading">
                        <span class="h2"><?php echo esc_html( $settings['title'] ); ?></span>
                    </div>
				<?php endif; ?>
                <div class="meta-info">
					<?php if ( ! empty( $settings['average'] ) ) :
						if ( 'star' === $settings['type'] )  :
							echo foxiz_get_review_stars( $settings['average'] );
						else:
							echo foxiz_get_review_line( $settings['average'] );
						endif;
						?><span class="average"><?php if ( ! empty( $settings['meta'] ) ) : ?>
                        <span class="meta-text"><span class="meta-description"><?php echo wp_kses( $settings['meta'], 'foxiz' ); ?></span></span>
					<?php endif; ?><span class="h1"><?php echo esc_html( $settings['average'] ); ?></span></span>
					<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_review_pros_cons' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_render_review_pros_cons( $settings = array() ) {

		if ( empty( $settings['pros'] ) && empty( $settings['cons'] ) ) {
			return false;
		} ?>
        <div class="pros-cons">
            <div class="pros-cons-holder">
                <div class="inner">
					<?php if ( is_array( $settings['pros'] ) ) : ?>
                        <div class="pros-list-wrap">
                            <div class="pros-cons-list-inner">
                            <span class="h4 pros-cons-title">
                                <?php foxiz_render_svg( 'like' ); ?>
                                 <span class="h5"><?php foxiz_html_e( 'Good Stuff', 'foxiz' ); ?></span>
                            </span>
								<?php foreach ( $settings['pros'] as $item ) :
									if ( ! empty( $item['pros_item'] ) ) :?>
                                        <span class="pros-cons-el"><i class="rbi rbi-plus"></i><?php echo esc_html( $item['pros_item'] ); ?></span>
									<?php endif;
								endforeach; ?>
                            </div>
                        </div>
					<?php endif;
					if ( is_array( $settings['cons'] ) ) : ?>
                        <div class="cons-list-wrap">
                            <div class="pros-cons-list-inner">
                             <span class="pros-cons-title"><?php foxiz_render_svg( 'dislike' ); ?>
                                 <span class="h5"><?php foxiz_html_e( 'Bad Stuff', 'foxiz' ); ?></span>
                             </span>
								<?php foreach ( $settings['cons'] as $item ) :
									if ( ! empty( $item['cons_item'] ) ) :?>
                                        <span class="pros-cons-el"><i class="rbi rbi-minus"></i><?php echo esc_html( $item['cons_item'] ); ?></span>
									<?php endif;
								endforeach; ?>
                            </div>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'foxiz_render_review_summary' ) ) {
	/**
	 * @param array $settings
	 */
	function foxiz_render_review_summary( $settings = array() ) {

		if ( ! empty( $settings['summary'] ) )  : ?>
            <div class="summary-wrap">
                <span class="h3 review-summary-title"><?php foxiz_html_e( 'Summary', 'foxiz' ); ?></span>
                <div class="summary-content">
					<?php echo wp_kses( $settings['summary'], 'foxiz' ); ?>
                </div>
            </div>
		<?php endif;
		if ( ! empty( $settings['button'] ) && ! empty( $settings['destination'] ) ) : ?>
            <div class="review-action">
                <a class="review-btn is-btn" href="<?php echo esc_url( $settings['destination'] ); ?>" target="_blank" rel="nofollow noreferrer"><?php echo wp_kses( $settings['button'], 'foxiz' ); ?></a>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'foxiz_render_review_rating' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false
	 */
	function foxiz_render_review_rating( $settings = array() ) {

		if ( empty( $settings['user_rating']['count'] ) || empty( $settings['user_rating']['average'] ) || empty( $settings['type'] ) ) {
			return false;
		} ?>
        <div class="user-rating">
            <div class="rating-header">
				<?php foxiz_render_svg( 'like' ); ?>
                <span class="h4"><?php echo foxiz_html__( 'User Votes', 'foxiz' ); ?></span>
				<?php if ( ! empty( $settings['user_rating']['count'] ) ) :
					if ( '1' === (string) $settings['user_rating']['count'] ) {
						$vote_output = $settings['user_rating']['count'] . ' ' . foxiz_html__( 'vote', 'foxiz' );
					} else {
						$vote_output = $settings['user_rating']['count'] . ' ' . foxiz_html__( 'votes', 'foxiz' );
					}
					?><span class="total-vote is-meta"><?php echo '(' . esc_html( $vote_output ) . ')'; ?></span>
				<?php endif; ?>
            </div>
            <div class="average-info">
				<?php echo foxiz_get_review_stars( $settings['user_rating']['average'] ); ?>
            </div>
        </div>
		<?php
	}
}
