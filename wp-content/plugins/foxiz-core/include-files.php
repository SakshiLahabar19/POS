<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/** includes */
include_once FOXIZ_CORE_PATH . 'define.php';
include_once FOXIZ_CORE_PATH . 'admin/includes.php';
include_once FOXIZ_CORE_PATH . 'includes/helpers.php';
include_once FOXIZ_CORE_PATH . 'elementor/base.php';
include_once FOXIZ_CORE_PATH . 'includes/actions.php';
include_once FOXIZ_CORE_PATH . 'includes/optimized.php';
include_once FOXIZ_CORE_PATH . 'includes/login-screen.php';
include_once FOXIZ_CORE_PATH . 'includes/svg.php';
include_once FOXIZ_CORE_PATH . 'includes/table-contents.php';
include_once FOXIZ_CORE_PATH . 'includes/video-thumb.php';
include_once FOXIZ_CORE_PATH . 'includes/extras.php';
include_once FOXIZ_CORE_PATH . 'includes/shortcodes.php';
include_once FOXIZ_CORE_PATH . 'includes/amp.php';
include_once FOXIZ_CORE_PATH . 'membership/membership.php';
include_once FOXIZ_CORE_PATH . 'membership/options.php';

/** elementor templates */
include_once FOXIZ_CORE_PATH . 'e-template/init.php';

/** template parts */
include_once FOXIZ_CORE_PATH . 'includes/shares.php';
include_once FOXIZ_CORE_PATH . 'includes/ads.php';

/** reaction */
include_once FOXIZ_CORE_PATH . 'reaction/reaction.php';

/** widgets */
include_once FOXIZ_CORE_PATH . 'includes/widget.php';
include_once FOXIZ_CORE_PATH . 'widgets/fw-instagram.php';
include_once FOXIZ_CORE_PATH . 'widgets/fw-mc.php';
include_once FOXIZ_CORE_PATH . 'widgets/banner.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-post.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-follower.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-weather.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-tweet.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-social-icon.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-youtube.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-flickr.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-address.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-instagram.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-ad-image.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-ad-script.php';
include_once FOXIZ_CORE_PATH . 'widgets/sb-facebook.php';
include_once FOXIZ_CORE_PATH . 'widgets/ruby-template.php';

include_once FOXIZ_CORE_PATH . 'gutenberg/gutenberg.php';