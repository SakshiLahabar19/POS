<div class="wrap op-conten-wrap">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-danger pull-left" href="<?php echo admin_url('admin.php?page=op-promotions'); ?>" role="button" style="margin-right: 5px;"><?php echo __('Back','openpos-promotion'); ?></a>
        </div>
    </div>
    <h1>
        <?php echo ($action != 'edit') ?  __( 'New OpenPOS Promotion', 'openpos-promotion' ) : __( 'Edit OpenPOS Promotion', 'openpos-promotion' ) ; ?>
    </h1>

        <div class="form-container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form class="form-horizontal" id="book-form">
                        <input type="hidden" name="promotion_id" value="<?php echo $default_data['promotion_id']; ?>">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo __( 'Title', 'openpos-promotion' ); ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $default_data['title']; ?>" id="book_title" name="title" placeholder="Title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo __( 'Outlet', 'openpos-promotion' ); ?></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="warehouse_id">
                                    <option value="-2"><?php echo __('Please choose Outlet','openpos-promotion'); ?></option>
                                   
                                    <?php foreach($warehouses as $warehouse): ?>
                                    <option value="<?php echo $warehouse['id']; ?>" <?php echo $default_data['warehouse_id'] == $warehouse['id'] ? 'selected':''; ?> ><?php echo $warehouse['name']; ?></option>
                                    <?php endforeach; ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo __( 'Type', 'openpos-promotion' ); ?></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="promotion_type" <?php echo $default_data['promotion_id'] > 0 ? 'disabled':''; ?>>
                                    <option value="-1"><?php echo __('Please choose type','openpos-promotion'); ?></option>
                                        <?php foreach($rules as $rule_key => $rule): ?>
                                            <option value="<?php echo esc_attr($rule_key); ?>" <?php echo $default_data['promo_type'] == $rule_key ? 'selected':''; ?> ><?php echo $rule; ?></option>
                                        <?php endforeach; ?>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="from_date" class="col-sm-2 control-label"><?php echo __( 'From Date', 'woo-book-price' ); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control datepicker" value="<?php echo $default_data['from_date']; ?>" id="from_date" name="from_date">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <div class="form-group">
                            <label for="to_date" class="col-sm-2 control-label"><?php echo __( 'To Date', 'woo-book-price' ); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control datepicker" value="<?php echo $default_data['to_date']; ?>" id="to_date" name="to_date">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <button type="button" id="book-save-btn" class="btn btn-primary pull-right"><?php echo __( 'Save', 'openpos-promotion' ); ?></button>
                    </form>
                </div>
            </div>
            <p><?php echo __( 'Discount value accept % synbol for Percentage value.', 'woo-book-price' ); ?></p>
            <hr>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form class="form-inline" id="barcode-scan-frm" >
                        <div class="form-group">

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <?php echo __( 'Barcode', 'openpos-promotion' ); ?>
                                </div>
                                <input type="text" class="form-control" style="z-index:inherit;" id="barcodeScanInput" name="barcodeScanInput" placeholder="<?php echo __( 'Enter barcode to add', 'openpos-promotion' ); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo __( 'Scan', 'openpos-promotion' ); ?></button>
                    </form>
                </div>
            </div>

        </div>

    <br class="clear">
    <div class="product-list-container">
        <form id="product-table-data">
        <table id="op-transfer-grid" class="table table-condensed table-hover table-striped op-transfer-grid">
            <thead>
            <tr>
                <th data-column-id="product_id" data-identifier="true" ><?php echo __( 'Product ID', 'openpos-promotion' ); ?></th>
               
                <th data-column-id="barcode" data-identifier="false" data-sortable="false"><?php echo __( 'Barcode', 'openpos-promotion' ); ?></th>
                <th data-column-id="product_name" data-identifier="false" data-sortable="false"><?php echo __( 'Product Name', 'openpos-promotion' ); ?></th>
                <th data-column-id="price" data-identifier="false"  data-sortable="false"><?php echo __( 'Price', 'openpos-promotion' ); ?></th>
                <th data-column-id="qty" data-sortable="false"><?php echo __( 'Conditions - X', 'openpos-promotion' ); ?></th>
                <th data-column-id="qty" data-sortable="false"><?php echo __( 'Action - Y', 'openpos-promotion' ); ?></th>
                <th data-column-id="view_url" class="text-right" data-sortable="false"></th>
            </tr>
            </thead>
        </table>
        </form>
    </div>


    <br class="clear">
</div>


<script type="text/javascript">
    var loading_html = '<div id="op-stock-loading">Loading...</div>';
    (function($) {
        "use strict";

        var files = new Array();
        var book_id = $('input[name="promotion_id"]').val() ;

        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY'
        });


        var table = $('#op-transfer-grid').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "<?php echo admin_url( 'admin-ajax.php?promotion_id='.$default_data['promotion_id'] ); ?>",
                type: 'post',
                data: {action: 'op_promotion_product_ajax_list',id: book_id}
            },
            pageLength : 10,
            "language": {
                    "emptyTable":     "<?php echo __( 'No data available in table', 'openpos-promotion' ); ?>",
                    "info":           "<?php echo __( 'Showing _START_ to _END_ of _TOTAL_ entries', 'openpos-promotion' ); ?>",
                    "infoEmpty":      "<?php echo __( 'Showing 0 to 0 of 0 entries', 'openpos-promotion' ); ?>",
                    "infoFiltered":   "<?php echo __( '(filtered from _MAX_ total entries)', 'openpos-promotion' ); ?>",
                
                    "lengthMenu":     "<?php echo __( 'Show _MENU_ entries', 'openpos-promotion' ); ?>",
                    "loadingRecords": "<?php echo __( 'Loading...', 'openpos-promotion' ); ?>",
                    "processing":     "<?php echo __( 'Processing...', 'openpos-promotion' ); ?>",
                    "search":         "<?php echo __( 'Search:', 'openpos-promotion' ); ?>",
                    "zeroRecords":    "<?php echo __( 'No matching records found', 'openpos-promotion' ); ?>",
                    "paginate": {
                        "first":      "<?php echo __( 'First', 'openpos-promotion' ); ?>",
                        "last":       "<?php echo __( 'Last', 'openpos-promotion' ); ?>",
                        "next":       "<?php echo __( 'Next', 'openpos-promotion' ); ?>",
                        "previous":   "<?php echo __( 'Previous', 'openpos-promotion' ); ?>"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
        } );




       
        $('#book-save-btn').click(function () {
            let allow_save = true;
            
            if(allow_save && $('select[name="warehouse_id"]').val() <  0)
            {
                allow_save = false;
                alert("<?php echo __( 'Please choose outlet', 'openpos-promotion' ); ?>");
            }
            if(allow_save && $('select[name="promotion_type"]').val() <  0)
            {
                allow_save = false;
                alert("<?php echo __( 'Please choose promotion type', 'openpos-promotion' ); ?>");
            }
            if(allow_save && $('input[name="title"]').val().length < 1)
            {
                allow_save = false;
                alert("<?php echo __( 'Please enter title', 'openpos-promotion' ); ?>");
            }

            let rows = $('#product-table-data').serialize();
            

            if(allow_save) {
                $.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                    type: 'post',
                    data: $('#book-form').serialize()+'&action=op_save_promotion&'+rows,
                    dataType: 'json',
                    beforeSend:function(){
                        $('body').addClass('op_loading');
                        $('.op-conten-wrap').append(loading_html);
                    },
                    success: function(response){
                        $('body').removeClass('op_loading');
                        if(response['status'] == 1)
                        {
                            var transfer_id = response['data']['promotion_id'];
                            <?php if($action != 'edit'):?>
                                window.location = '<?php echo admin_url('admin.php?page=op-promotions')?>'+'#' + transfer_id;
                            <?php endif; ?>
                            $('body').find('#op-stock-loading').remove();
                        }else {
                            $('.op-conten-wrap').find('#op-stock-loading').remove();
                            alert(response['message']);
                        }
                    },
                    error:function(){
                        $('body').removeClass('op_loading');
                    }
                });
            }
        });
        

        $(document).on('click','.del-row',function(){
            var id = $(this).data('id');
            var input_selected = $(document).find('#row-'+id);

            $.ajax({
                url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                type: 'post',
                data: {action: 'op_delete_promotion_product',id: id},
                dataType: 'json',
                beforeSend:function(){
                    input_selected.prop('disabled',true);
                },
                success: function(response){
                    table.ajax.reload();
                }
            });
        });

        $('#barcode-scan-frm').on('submit',function(e){
            e.preventDefault();
            var from_warehouse_id = $('select[name="warehouse_id"]').val();
            var transfer_id = $('input[name="promotion_id"]').val();
            var barcode = $('input[name="barcodeScanInput"]').val();
            var promotion_type = $('select[name="promotion_type"]').val();

            let allow_save = true;
            
            if(allow_save && $('select[name="warehouse_id"]').val() <  0)
            {
                allow_save = false;
                alert("<?php echo __( 'Please choose outlet', 'openpos-promotion' ); ?>");
            }
            if(allow_save && $('select[name="promotion_type"]').val() <  0)
            {
                allow_save = false;
                alert("<?php echo __( 'Please choose promotion type', 'openpos-promotion' ); ?>");
            }
            
            
            if(allow_save && barcode.length > 0)
            {
                $.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                    type: 'post',
                    data: {action: 'op_promotion_scan_barcode',promotion_id: transfer_id, warehouse_id: from_warehouse_id, barcode: barcode, promotion_type : promotion_type },
                    dataType: 'json',
                    beforeSend:function(){

                    },
                    success: function(response){
                        $('input[name="barcodeScanInput"]').select();
                        $('select[name="promotion_type"]').prop('disabled',true);
                        if(response.status == 1)
                        {
                            var promotion_id = response['data']['promotion_id'];
                            
                            if(promotion_id)
                            {
                                $('input[name="promotion_id"]').val(promotion_id);
                            }
                            
                            table.ajax.url("<?php echo admin_url( 'admin-ajax.php?promotion_id=' ); ?>"+promotion_id).load();

                        }else {
                            alert(response.message);
                        }
                    }
                });
            }

        })

    })( jQuery );
</script>