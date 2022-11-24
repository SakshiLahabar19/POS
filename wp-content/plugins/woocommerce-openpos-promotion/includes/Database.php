<?php
if(!class_exists('OP_Promotion_Db'))
{
    class OP_Promotion_Db{

        public static function install(){
            global $_has_openpos;

            global $wpdb;

            if(!$_has_openpos)
            {
                wp_die( __( 'Sorry, Please install <a  target="_blank" href="https://codecanyon.net/item/openpos-a-complete-pos-plugins-for-woocomerce/22613341">OpenPOS - WooCommerce Point Of Sale(POS)</a> before active this plugin.','openpos' ) );
            }

            $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}openpos_promotions` (
                `promotion_id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `promo_type` varchar(255) NOT NULL,
                `warehouse_id` int(11) NOT NULL,
                `from_date` varchar(255) NOT NULL,
                `to_date` varchar(255) NOT NULL,
                `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                `created_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                `created_by` int(11) NOT NULL DEFAULT '0',
                `status` int(11) NOT NULL DEFAULT '0',
                PRIMARY KEY (`promotion_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
            $wpdb->query($sql);
            $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}openpos_promotion_products` (
              `promotion_product_id` int(11) NOT NULL AUTO_INCREMENT,
              `promotion_id` bigint(50) NOT NULL,
              `product_id` bigint(50) NOT NULL,
              `product_barcode` varchar(255) NOT NULL,
              `product_sku` varchar(255) NOT NULL DEFAULT '',
              `cons` text NOT NULL,
              `action` text NOT NULL,
              PRIMARY KEY (`promotion_product_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

            $wpdb->query($sql);
        }

        public function save_draft_promotion($from_warehouse_id = 0,$type = ''){
            global $wpdb;
            $wpdb->insert(
                $wpdb->prefix . "openpos_promotions",
                array(
                    'title' => 'temp',
                    'warehouse_id' => $from_warehouse_id,
                    'promo_type' => $type,
                    'created_date' => date('Y-m-d H:i:s' ),
                    'created_date_gmt' => gmdate('Y-m-d H:i:s' )
                )
            );
            return $wpdb->insert_id;

        }
        public function save_promotion($data){

            global $wpdb;
            if(isset($data['promotion_id']) && $data['promotion_id'] > 0 )
            {
                $table = $wpdb->prefix.'openpos_promotions';
                $update_data = array(
                    'title' => esc_textarea($data['title']),
                    'warehouse_id' => $data['warehouse_id'],
                    'created_by' => $data['created_by'],
                    'status' => (int)$data['status'],
                    'from_date' => $data['from_date'],
                    'to_date' => $data['to_date'],
                    'created_date' => date('Y-m-d H:i:s' ),
                    'created_date_gmt' => gmdate('Y-m-d H:i:s' )
                );
                $where = [ 'promotion_id' =>(int)$data['promotion_id']];
                $wpdb->update( $table, $update_data, $where );
                return $data['promotion_id'];
            }else{
                $wpdb->insert(
                    $wpdb->prefix . "openpos_promotions",
                    array(
                        'title' => esc_textarea($data['title']),
                        'warehouse_id' => $data['warehouse_id'],
                        'promo_type' => $data['promo_type'],
                        'created_by' => $data['created_by'],
                        'from_date' => (int)$data['from_date'],
                        'to_date' => (int)$data['to_date'],
                        'status' => (int)$data['status'],
                        'created_date' => date('Y-m-d H:i:s' ),
                        'created_date_gmt' => gmdate('Y-m-d H:i:s' )
                    )
                );
                return $wpdb->insert_id;
            }
        }
        public function save_promotion_items($data){
            global $wpdb;
            $wpdb->delete( $wpdb->prefix . "openpos_promotion_products", array( 'promotion_id' => $data['promotion_id'], 'product_id' => $data['product_id'] ) );

            $wpdb->insert(
                $wpdb->prefix . "openpos_promotion_products",
                array(
                    'promotion_id' => $data['promotion_id'],
                    'product_id' => $data['product_id'],
                    'product_barcode' => $data['product_barcode'],
                    'product_sku' => $data['product_sku'],
                    'cons' => $data['cons'],
                    'action' => $data['action'],
                )
            );
            return $wpdb->insert_id;

        }

        public function delete_promotion_item($item_id)
        {
            global $wpdb;
            $wpdb->delete( $wpdb->prefix . "openpos_promotion_products", array( 'promotion_product_id' => (int)$item_id ) );
        }
        public function delete_promotion($promotion_id)
        {
            global $wpdb;
            $wpdb->delete( $wpdb->prefix . "openpos_promotions", array( 'promotion_id' => (int)$promotion_id ) );
            $wpdb->delete( $wpdb->prefix . "openpos_promotion_products", array( 'promotion_id' => (int)$promotion_id ) );
        }



        
        public function getPromotionProducts($params){
            global $wpdb;
            $sql_count = "SELECT COUNT(*)  FROM ".$wpdb->prefix."openpos_promotion_products WHERE promotion_id = ".(int)$params['promotion_id'];


            $sql = "SELECT * FROM ".$wpdb->prefix."openpos_promotion_products WHERE promotion_id = ".(int)$params['promotion_id'];


            $sql .= ' ORDER BY product_id '.$params['order'];

            $sql .= " LIMIT ".$params['start'].','.$params['per_page'];
            $total = $wpdb->get_var($sql_count);
            $rows = $wpdb->get_results( $sql,ARRAY_A );
            return array('total' => $total,'rows' => $rows);
        }

        

        public function getPromotion($promotion_id){
            global $wpdb;
            $sql = "SELECT * FROM ".$wpdb->prefix."openpos_promotions WHERE promotion_id = ".intval($promotion_id);
            $row = $wpdb->get_row($sql,ARRAY_A);
            return $row;
        }
        public function getPromotions($params){
            global $wpdb;
            $sql_count = "SELECT COUNT(*)  FROM ".$wpdb->prefix."openpos_promotions WHERE status > 0 ";
            $sql = "SELECT * FROM ".$wpdb->prefix."openpos_promotions WHERE status > 0 ";
            if($params['term'])
            {
                $sql .= ' AND title LIKE "%'.$params['term'].'%"';
            }
            $sql .= ' ORDER BY promotion_id '.$params['order'];
            $sql .= " LIMIT ".$params['start'].','.$params['per_page'];
            $total = $wpdb->get_var($sql_count);
            $rows = $wpdb->get_results( $sql,ARRAY_A );
            return array('total' => $total,'rows' => $rows);
        }
        public function updatePromotionProduct($id,$field,$data)
        {
            global $wpdb;
            $table = $wpdb->prefix.'openpos_promotion_products';
            $data = [ $field => $data ];
            $where = [ 'promotion_product_id' => $id ];
            $updated = $wpdb->update( $table, $data, $where );
        }

        public function getPromotionByBarcode($barcode,$warehouse_id){
            global $wpdb;
            $sql = "SELECT * FROM ".$wpdb->prefix."openpos_promotion_products pr LEFT JOIN ".$wpdb->prefix."openpos_promotions p ON pr.promotion_id = p.promotion_id  WHERE p.status > 0 AND p.warehouse_id = '$warehouse_id'  AND pr.product_barcode ='$barcode'";
            $rows = $wpdb->get_results( $sql,ARRAY_A );
            return $rows;
        }
        
        public function getStatus(){
            return array(
                0 => 'Temp',
                1 => 'Draft',
                2 => 'Pending Receive',
                3 => 'Received',
                4 => 'Declined'
            );
        }

       
    }

}
?>