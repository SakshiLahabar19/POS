<?php
/*
Plugin Name: Promotion for OpenPOS - Best woocomerce point of sale
Plugin URI: http://openswatch.com
Description: Promotion for OpenPOS - Best woocomerce point of sale. Support promotion types: Role price, Buy Product A  With Qty X has price Y, Buy Product A  With Qty X has discount Y, 
Author: anhvnit@gmail.com
Author URI: http://wpos.app/
Version: 1.1
WC requires at least: 2.6
Text Domain: openpos-promotion
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
define('OPENPOS_PROMO_DIR',plugin_dir_path(__FILE__));
define('OPENPOS_PROMO_URL',plugins_url('woocommerce-openpos-promotion'));
require_once( OPENPOS_PROMO_DIR.'/includes/Database.php' );
require(OPENPOS_PROMO_DIR.'/includes/Promotion.php');
register_activation_hook( __FILE__, array( 'OP_Promotion_Db', 'install' ) );
global $_has_openpos;
$_has_openpos = false;

if(!function_exists('is_plugin_active'))
{
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if(is_plugin_active( 'woocommerce-openpos/woocommerce-openpos.php' ))
{
    $_has_openpos = true;
    global $openpos_promotion;
    $openpos_promotion = new OP_Promotion();
    $openpos_promotion->init();
}