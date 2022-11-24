<?php
if(!class_exists('OP_Promotion'))
{
    class OP_Promotion{
        public $rules = array();
        public $db;
        function __construct()
        {
            $this->db = new OP_Promotion_Db();
            $this->rules = array(
                'buy_x_qty_y_with_price' => __('Buy Product A with qty >= X => price Y','openpos-promotion'),
                'buy_x_qty_y_with_discount' => __('Buy Product A with qty >= X => discount Y','openpos-promotion'),
                'role_price' => __('Customer Role X have price Y','openpos-promotion'),
            );
        }
        function init(){
            add_action( 'init', array($this, '_wp_init') );
            add_action( 'admin_menu', array($this,'admin_menu'),10 );

            add_action( 'wp_ajax_op_promotion_scan_barcode', array($this,'op_promotion_scan_barcode') );
            add_action( 'wp_ajax_op_delete_promotion_product', array($this,'op_delete_promotion_product') );
            add_action( 'wp_ajax_op_update_promotion_product', array($this,'op_update_promotion_product') );
            add_action( 'wp_ajax_op_save_promotion', array($this,'op_save_promotion') );
            add_action( 'wp_ajax_op_delete_promotion', array($this,'op_delete_promotion') );
            add_action( 'wp_ajax_op_promotion_product_ajax_list', array($this,'op_promotion_product_ajax_list') );
            add_action( 'wp_ajax_op_promotions_ajax_list', array($this,'op_promotions_ajax_list') );

            add_filter('op_product_data',array($this,'op_product_data'),10,2);
            add_filter('op_customer_data',array($this,'op_customer_data'),10,1);
        }
        public function _wp_init(){
            
        }
        public function admin_menu(){

            $page = add_submenu_page( 'openpos-dasboard', __( 'Promotions', 'openpos-promotion' ),  __( 'Promotions', 'openpos-promotion' ) , 'manage_woocommerce', 'op-promotions', array( $this, 'promotions_page' ) );
    
            add_action( 'admin_print_styles-'. $page, array( $this, 'admin_enqueue' ) );
        }
        public function admin_enqueue(){
            wp_enqueue_style('op-promotion-bootstrap.jquery', OPENPOS_PROMO_URL.'/assets/css/jquery.dataTables.css');
            wp_enqueue_style('op-promotion-bootstrap', OPENPOS_PROMO_URL.'/assets/css/bootstrap.css');
            wp_enqueue_style('op-promotion-bootstrap.datetime', OPENPOS_PROMO_URL.'/assets/css/bootstrap-datetimepicker.min.css');
    
            wp_enqueue_style('openpos-promotion.admin.datatable.bootrap', OPENPOS_PROMO_URL.'/assets/css/dataTables.bootstrap.css',array('op-promotion-bootstrap','op-promotion-bootstrap.jquery'));
            wp_enqueue_style('openpos-promotion.admin', OPENPOS_PROMO_URL.'/assets/css/admin.css',array('op-promotion-bootstrap','op-promotion-bootstrap.datetime'));
    
    
            wp_enqueue_script('openpos-promotion.admin.moment', OPENPOS_PROMO_URL.'/assets/js/moment.min.js',array('jquery'));
            wp_enqueue_script('openpos-promotion.admin.bootstrap', OPENPOS_PROMO_URL.'/assets/js/bootstrap.js',array('jquery'));
    
            wp_enqueue_script('openpos-promotion.admin.datables', OPENPOS_PROMO_URL.'/assets/js/datatables.min.js',array('jquery', 'wp-mediaelement'));
            wp_enqueue_script('openpos-promotion.admin.datables.jquery', OPENPOS_PROMO_URL.'/assets/js/jquery.dataTables.js',array('openpos-promotion.admin.bootstrap'));
            wp_enqueue_script('openpos-promotion.admin.bootstrap.datepicker', OPENPOS_PROMO_URL.'/assets/js/bootstrap-datetimepicker.js',array('openpos-promotion.admin.datables.jquery','openpos-promotion.admin.moment'));
            wp_enqueue_script('openpos-promotion.admin', OPENPOS_PROMO_URL.'/assets/js/admin.js',array('openpos-promotion.admin.datables.jquery','openpos-promotion.admin.bootstrap.datepicker'));
        }
        public function promotions_page(){
            
            global $op_warehouse;
            $warehouses = array();
            $rules = $this->rules;
            if($op_warehouse)
            {
                $warehouses = $op_warehouse->warehouses();
    
            }else{
                $warehouses[] = array(
                    'id' => 0,
                    'name' => __('Default Woocommerce Store','openpos-promotion')
                );
            }
            $action = isset($_REQUEST['action']) ? esc_attr($_REQUEST['action']) : '';
            $id = isset($_REQUEST['id']) ? 1 * $_REQUEST['id'] : 0;
            $template = 'promotions.php';
            $default_data = array(
                'promotion_id' => 0,
                'title' => '',
                'promo_type' => '',
                'warehouse_id' => -1,
                'from_date' => '',
                'to_date' => ''
            );
            if($action == 'edit' && $id > 0 )
            {
                $promotion = $this->db->getPromotion($id);
                $default_data = $promotion;
            }
           
            switch($action)
            {
                case "edit":
                case "new":
                    $template = 'new.php';
                    break;

            }
            require(OPENPOS_PROMO_DIR.'templates/'.$template);
        }
        public function op_promotion_scan_barcode(){
            global $OPENPOS_CORE;
            $result = array(
                'status' => 0,
                'data' => array(),
                'message' => 'unknown'
            );
            $promotion_id = isset($_REQUEST['promotion_id']) ? 1 * $_REQUEST['promotion_id'] : 0;
            $warehouse_id = isset($_REQUEST['warehouse_id']) ?  $_REQUEST['warehouse_id'] : 0;
            $promotion_type = isset($_REQUEST['promotion_type']) ? $_REQUEST['promotion_type'] : '';
            $barcode = isset($_REQUEST['barcode']) ?  $_REQUEST['barcode'] : '';
            $barcode = sanitize_text_field($barcode);
            try{
                $product_id = $OPENPOS_CORE->getProductIdByBarcode($barcode);
                if(!$product_id)
                {
                    throw new Exception(__('No product with barcode "'.sanitize_text_field($barcode).'"','openpos'));
                }
                if($promotion_id == 0)
                {
                    $promotion_id = $this->db->save_draft_promotion($warehouse_id,$promotion_type);
                }
                $product = wc_get_product($product_id);
                $data = array(
                    'promotion_id' => $promotion_id,
                    'product_id' => $product_id,
                    'product_barcode' => $OPENPOS_CORE->getBarcode($product_id),
                    'product_sku' => $product->get_sku(),
                    'cons' => '',
                    'action' => '',
                );
                
                $this->db->save_promotion_items($data);
    


                $result['data'] = array(
                    'promotion_id' => $promotion_id
                );
                $result['status'] = 1;
            }catch(Exception $e)
            {
                $result['message'] = $e->getMessage();
            }
            
            echo json_encode($result);
            exit;
        }
        public function op_delete_promotion_product(){
            $result = array();

            $promotion_product_id = isset($_REQUEST['id']) ? 1 * ($_REQUEST['id']) : 0;
            if($promotion_product_id)
            {
                $this->db->delete_promotion_item($promotion_product_id);
            }

            echo json_encode($result);
            exit;
        }
        
        public function op_delete_promotion(){
            $result = array(
                'status' => 0,
                'data' => array(),
                'message' => 'unknown'
            );
            $promotion_id = isset($_REQUEST['id']) ? 1 * ($_REQUEST['id']) : 0;
            if($promotion_id)
            {
                $this->db->delete_promotion($promotion_id);
            }
            echo json_encode($result);
            exit;
        }
        public function op_save_promotion(){
            $result = array(
                'status' => 0,
                'data' => array(),
                'message' => 'unknown'
            );
            $data = $_REQUEST;
            $promotion_id = 0;
            if(isset($data['title']) && isset($data['warehouse_id']))
            {
                $pro_data = array(
                    'title' => esc_textarea($data['title']),
                    'warehouse_id' => $data['warehouse_id'],
                    'created_by' => 0,
                    'status' => 1,
                    'from_date' => $data['from_date'],
                    'to_date' => $data['to_date'],
                    
                );
                if(isset($data['promotion_id']) && $data['promotion_id'] > 0 )
                {
                    $pro_data['promotion_id'] = $data['promotion_id'];
                }
                if(isset($data['promotion_type'])  )
                {
                    $pro_data['promo_type'] = $data['promotion_type'];
                }
                $promotion_id = $this->db->save_promotion($pro_data);
                if(isset($data['promotion_condition'])){
                    foreach($data['promotion_condition'] as $row_id => $row_data)
                    {
                        $this->db->updatePromotionProduct($row_id,'cons',json_encode($row_data));
                    }
                }
                if(isset($data['promotion_action'])){
                    foreach($data['promotion_action'] as $row_id => $row_data)
                    {
                        $this->db->updatePromotionProduct($row_id,'action',json_encode($row_data));
                    }
                }
                $result['status'] = 1;
            }
            $result['data']['promotion_id'] = $promotion_id;
            
            echo json_encode($result);
            exit;
        }

        public function op_promotions_ajax_list(){
            $result = array(
                "draw" => 0,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                'data' => array()
            );

            $per_page = intval($_REQUEST['length']);
            $start = intval($_REQUEST['start']);
            $term = isset($_REQUEST['search']['value']) ? sanitize_text_field($_REQUEST['search']['value']): '' ;
            $order = isset($_REQUEST['order'][0]['dir']) ? esc_attr($_REQUEST['order'][0]['dir']) : 'asc';
            $params = array(
                'term' => $term,
                'per_page' => $per_page,
                'start' => $start,
                'order' => $order
            );
            $rows = $this->db->getPromotions($params);
            $result['draw'] = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0;
            $result['recordsTotal'] = $rows['total'];
            $result['recordsFiltered'] = $rows['total'];
            global $op_warehouse;
            
            $all_statuses = $this->db->getStatus();
            
            foreach($rows['rows'] as $row)
            {

                $created_by = $row['created_by'];
                $user = get_user_by('id',$created_by);
                $warehouse_id  = $row['warehouse_id'];
                $promo_type  = $row['promo_type'];
                $from_date  = $row['from_date'] ? $row['from_date'] : '--/--/--';
                $to_date  = $row['to_date'] ? $row['to_date'] : '--/--/--';

                $output_format = 'Y-m-d H:i:s';
                
                $local_timestamp = get_date_from_gmt( $row['created_date_gmt'], $output_format );
                $warehouse = $op_warehouse->get($warehouse_id);
                $action_html = '<button class="edit-row" type="button" data-id="'.$row['promotion_id'].'" ><span class="glyphicon glyphicon-pencil"></span></button>&nbsp;<button class="delete-row" type="button" data-id="'.$row['promotion_id'].'" ><span class="glyphicon glyphicon-trash"></span></button>&nbsp;';
                $type_ext = __('Unknown','openpos-promotion');
                if(isset($this->rules[$promo_type]))
                {
                    $type_ext = $this->rules[$promo_type];
                }
                $tmp = array(
                    (int)$row['promotion_id'],
                    $row['title'],
                    $warehouse['name'],
                    $type_ext,
                    implode(' - ',array($from_date,$to_date)),
                    $local_timestamp,
                    $action_html
                );
                 $result['data'][] = $tmp;
            }


            echo json_encode($result);
            exit;
        }
        public function op_promotion_product_ajax_list(){
            $result = array(
                "draw" => 0,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                'data' => array()
            );
            
            $promotion_id = isset($_REQUEST['promotion_id']) ? 1 * ($_REQUEST['promotion_id']) : 0;
            if($promotion_id)
            {
                $promotion = $this->db->getPromotion($promotion_id);

                $per_page = intval($_REQUEST['length']);
                $start = intval($_REQUEST['start']);
                $term = isset($_REQUEST['search']['search']) ? sanitize_text_field($_REQUEST['search']['search']): '' ;
                $order = isset($_REQUEST['order'][0]['dir']) ? esc_attr($_REQUEST['order'][0]['dir']) : 'asc';
                $params = array(
                    'promotion_id' => $promotion_id,
                    'per_page' => $per_page,
                    'start' => $start,
                    'order' => $order
                );

                $rows = $this->db->getPromotionProducts($params);
                $result['draw'] = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0;
                $source = isset($_REQUEST['source']) ? esc_attr($_REQUEST['source']) : '';
                $result['recordsTotal'] = $rows['total'];
                $result['recordsFiltered'] = $rows['total'];
                $warehouse_id = $promotion['warehouse_id'];
                $type = $promotion['promo_type'];
                foreach($rows['rows'] as $row)
                {
                    $product = wc_get_product($row['product_id']);
                    $condition_html = $this->_generateConsHtml($row,$type);
                    $action_html = $this->_generateActionHtml($row,$type);
                    $tmp = array(
                        (int)$row['product_id'],
                        $row['product_barcode'],
                        $product->get_name(),
                        wc_price($product->get_price()),
                        $condition_html,
                        $action_html,
                        '<p><button class="del-row" type="button" data-id="'.$row['promotion_product_id'].'" ><span class="glyphicon glyphicon-trash"></span></button></p>',
                    );
                    $result['data'][] = $tmp;
                }
            }

            echo json_encode($result);
            exit;
        }
        function _generateConsHtml($row,$type){
            global $wp_roles;
            $all_roles = $wp_roles->roles;
            $html = '<div class="condition-container">';
            $condtions_json = $row['cons'];
            $condtions = array();
            if($condtions_json && $condtions_json != null)
            {
                $condtions = json_decode($condtions_json,true);
            }
            switch($type)
            {
                case 'buy_x_qty_y_with_price':
                    $default_qty = isset($condtions['qty']) ? $condtions['qty'] : '';
                    $html.='<input type="text" name="promotion_condition['.$row['promotion_product_id'].'][qty]" value="'.$default_qty.'" placeholder="'.__('Qty','openpos-promotion').'" id="row-'.$row['promotion_product_id'].'" />';
                    break;
                case 'buy_x_qty_y_with_discount':
                    $default_qty = isset($condtions['qty']) ? $condtions['qty'] : '';
                    $html.='<input type="text" name="promotion_condition['.$row['promotion_product_id'].'][qty]" value="'.$default_qty.'" placeholder="'.__('Qty','openpos-promotion').'" id="row-'.$row['promotion_product_id'].'" />';
                    break;
                case 'role_price':
                    $default_roles = isset($condtions['roles']) ? $condtions['roles'] : array();
                    $html.='<select name="promotion_condition['.$row['promotion_product_id'].'][roles][]" multiple id="row-'.$row['promotion_product_id'].'" >';
                    foreach($all_roles as $role_key => $role)
                    {
                        if(in_array($role_key,$default_roles))
                        {
                            $html .= '<option selected value="'.$role_key.'">'.$role['name'].'</option>';
                        }else{
                            $html .= '<option value="'.$role_key.'">'.$role['name'].'</option>';
                        }
                    }
                    $html .= '</select>';
                    break;
            }
            $html .= '</div>';
            return $html;
        }
        function _generateActionHtml($row,$type){
            $html = '<div class="action-container">';
            $condtions_json = $row['action'];
            $actions = array();
            if($condtions_json && $condtions_json != null)
            {
                $actions = json_decode($condtions_json,true);
            }
            switch($type)
            {
                case 'buy_x_qty_y_with_price':
                    $default_price = isset($actions['price']) ? $actions['price'] : '';
                    $html.='<input type="text" name="promotion_action['.$row['promotion_product_id'].'][price]" value="'.$default_price.'" placeholder="'.__('Price','openpos-promotion').'" id="row-'.$row['promotion_product_id'].'" />';
                    break;
                case 'buy_x_qty_y_with_discount':
                    $default_price = isset($actions['discount']) ? $actions['discount'] : '';
                    $html.='<input type="text" name="promotion_action['.$row['promotion_product_id'].'][discount]" value="'.$default_price.'" placeholder="'.__('Discount','openpos-promotion').'" id="row-'.$row['promotion_product_id'].'" />';
                    break;
                case 'role_price':
                    $default_price = isset($actions['price']) ? $actions['price'] : '';
                    $html.='<input type="text" name="promotion_action['.$row['promotion_product_id'].'][price]" value="'.$default_price.'" placeholder="'.__('Price','openpos-promotion').'" id="row-'.$row['promotion_product_id'].'" />';
                    break;
            }

            $html .= '</div>';
            return $html;
        }
        function _getPromotionsByBarcode($barcode,$warehouse_id = 0){
            $promotions = $this->db->getPromotionByBarcode($barcode,$warehouse_id);
            $result = array();


            
            foreach($promotions as $promotion)
            {
                $date_pass = true;
                $from_date = $promotion['from_date'];
                $to_date = $promotion['to_date'];
                $cons_json = $promotion['cons'];
                $action_json = $promotion['action'];
                $cons = array();
                $action = array();
                if(!$cons_json || !$action_json)
                {
                    continue;
                }
                $cons = json_decode($cons_json,true);
                $action = json_decode($action_json,true);
                if(empty($cons) || empty($action))
                {
                    continue;
                }

                $promotion['cons'] = $cons;
                $promotion['action'] = $action;
                if($from_date && $from_date != null)
                {
                    $from_date_time = strtotime($from_date);
                    if($from_date_time > time())
                    {
                        $date_pass = false;
                    }
                }
                if($to_date && $to_date != null)
                {
                    $to_date_time = strtotime($to_date);
                    if($to_date_time < time())
                    {
                        $date_pass = false;
                    }
                }
                if($date_pass)
                {
                    $result[] = $promotion;
                }

            }
            
            return $result;
        }
        function op_product_data($product_data,$product){
            global $op_session_data;
            $barcode = isset($product_data['barcode']) ? $product_data['barcode'] : '';
            if($barcode && $op_session_data)
            {
                if(isset($op_session_data['login_warehouse_id']))
                {
                    $promotions = $this->_getPromotionsByBarcode($barcode,$op_session_data['login_warehouse_id']);
                    $discount_rules = array();
                    
                    if(isset($product_data['discount_rules'])){
                        $discount_rules = $product_data['discount_rules'];
                    }
                   
                    if(!empty($promotions))
                    {
                        
                        foreach($promotions as $promotion)
                        {
                            $type = $promotion['promo_type'];
                            $cons = $promotion['cons'];
                            $actions = $promotion['action'];
                            $from_date = $promotion['from_date'];
                            $to_date = $promotion['to_date'];
                            switch($type)
                            {
                                case 'buy_x_qty_y_with_price':
                                    $discount_rules[] = array(
                                        'id' => $promotion['promotion_id'],
                                        'name' => $promotion['title'],
                                        'type' => 'custom_rule', //discount_on_customer
                                        'condition_type' => 'item',
                                        'conditions' => array(
                                            array( 
                                                'variable' => 'item.qty', // item.qty, item.total, item.total_incl_tax
                                                'operator' => 'ge',  // in , not , eq, ne, gt , ge , lt , le , ( IN, NOT IN, EQUAL, NOT EQUAL, GREATER THAN, GREATER THAN EQUAL, LESS THAN, LESS THAN EQUAL)
                                                'value' => $cons['qty']
                                                )
                                        ),
                                        'action' => array(
                                            'price' => 1*$actions['price']
                                        ),
                                        'complex' => false,
                                        'priority' => 0,
                                        'from_date' => $from_date,
                                        'to_date' => $to_date
                                    );
                                    break;
                                case 'buy_x_qty_y_with_discount':
                                    $discount_type = 'fixed';
                                    $discount_amount = $actions['discount'];
                                    if(strpos($discount_amount,'%') !== false)
                                    {
                                        $discount_type = 'percent';
                                        $discount_amount = str_replace('%','',$discount_amount);
                                    }
                                    $discount_rules[] = array(
                                        'id' => $promotion['promotion_id'],
                                        'name' => $promotion['title'],
                                        'type' => 'custom_rule', //discount_on_customer
                                        'condition_type' => 'item',
                                        'conditions' => array(
                                            array( 
                                                'variable' => 'item.qty', // item.qty, item.total, item.total_incl_tax
                                                'operator' => 'ge',  // in , not , eq, ne, gt , ge , lt , le , ( IN, NOT IN, EQUAL, NOT EQUAL, GREATER THAN, GREATER THAN EQUAL, LESS THAN, LESS THAN EQUAL)
                                                'value' => $cons['qty']
                                                )
                                        ),
                                        'action' => array(
                                            'discount' => array(
                                                'discount_type' => $discount_type, // percent / fixed
                                                'discount_amount' => 1 * $discount_amount,
                                            )
                                        ),
                                        'complex' => false,
                                        'priority' => 0,
                                        'from_date' => $from_date,
                                        'to_date' => $to_date
                                    );
                                    break;
                                case 'role_price':
                                    $discount_rules[] = array(
                                        'id' => $promotion['promotion_id'],
                                        'name' => $promotion['title'],
                                        'type' => 'custom_rule', //discount_on_customer
                                        'condition_type' => 'customer',
                                        'conditions' => array(
                                            array( 'variable' => 'customer.group_id', 'operator' => 'in', 'value' => $cons['roles'])  //  'customer.id' , 'customer.phone', 'customer.email' ,'customer.group'
                                        ),
                                        'action' => array(
                                            'price' => 1*$actions['price']
                                        ),
                                        'complex' => false,
                                        'priority' => 0,
                                        'from_date' => $from_date,
                                        'to_date' => $to_date
                                    );
                                    break;
                            }
                        }
                       
                        $product_data['discount_rules'] = $discount_rules;

                    }
                }
                
                
            }
            return $product_data;
        }
        function op_customer_data($data){
            $customer_id = isset($data['id']) ? $data['id'] : 0;
            if($customer_id)
            {
                $customer = new WC_Customer($customer_id);
            
                $data['group_id'] = $customer->get_role();
                
            }
            return $data;
        }
    }
}
