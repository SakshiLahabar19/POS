<div class="wrap op-conten-wrap">
    <h1><?php echo __( 'All Promotions', 'openpos-stransfer' ); ?></h1>
    <form id="op-order-list">
        <div class="row">
            <div class="col-md-4 col-md-offset-8" style="margin-bottom: 15px;">
                <a class="btn btn-primary pull-right" href="<?php echo admin_url('admin.php?page=op-promotions&action=new'); ?>" role="button"><?php echo __( 'New Promotion', 'openpos-promotion' ); ?></a>
            </div>
        </div>
        <table id="op-transfer-grid" class="table table-condensed table-hover table-striped op-transfer-grid">
            <thead>
            <tr>
                <th data-column-id="id" data-identifier="true" data-type="numeric"><?php echo __( 'ID', 'openpos-promotion' ); ?></th>
                <th data-column-id="title" data-sortable="false"><?php echo __( 'Title', 'openpos-stransfer' ); ?></th>
                <th data-column-id="from_warehouse_id" data-sortable="false"><?php echo __( 'Outlet', 'openpos-promotion' ); ?></th>
                <th data-column-id="to_warehouse_id" data-identifier="false" data-sortable="false"><?php echo __( 'Type', 'openpos-promotion' ); ?></th>
                <th data-column-id="total_qty" data-identifier="false"  data-sortable="false"><?php echo __( 'Effect Date', 'openpos-promotion' ); ?></th>

                <th data-column-id="transfer_date" data-sortable="false"><?php echo __( 'Created At', 'openpos-promotion' ); ?></th>
                
               
                <th data-column-id="view_url" class="text-right" data-sortable="false"></th>
            </tr>
            </thead>
        </table>
    </form>
    <br class="clear">
</div>
<script type="text/javascript">
    (function($) {
        "use strict";
        var table = $('#op-transfer-grid').DataTable({
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                type: 'post',
                data: {action: 'op_promotions_ajax_list'}
            },
            pageLength : 10,
            "language": {
                    "emptyTable":     "<?php echo __( 'No data available in table', 'openpos-stransfer' ); ?>",
                    "info":           "<?php echo __( 'Showing _START_ to _END_ of _TOTAL_ entries', 'openpos-stransfer' ); ?>",
                    "infoEmpty":      "<?php echo __( 'Showing 0 to 0 of 0 entries', 'openpos-stransfer' ); ?>",
                    "infoFiltered":   "<?php echo __( '(filtered from _MAX_ total entries)', 'openpos-stransfer' ); ?>",
                
                    "lengthMenu":     "<?php echo __( 'Show _MENU_ entries', 'openpos-stransfer' ); ?>",
                    "loadingRecords": "<?php echo __( 'Loading...', 'openpos-stransfer' ); ?>",
                    "processing":     "<?php echo __( 'Processing...', 'openpos-stransfer' ); ?>",
                    "search":         "<?php echo __( 'Search:', 'openpos-stransfer' ); ?>",
                    "zeroRecords":    "<?php echo __( 'No matching records found', 'openpos-stransfer' ); ?>",
                    "paginate": {
                        "first":      "<?php echo __( 'First', 'openpos-stransfer' ); ?>",
                        "last":       "<?php echo __( 'Last', 'openpos-stransfer' ); ?>",
                        "next":       "<?php echo __( 'Next', 'openpos-stransfer' ); ?>",
                        "previous":   "<?php echo __( 'Previous', 'openpos-stransfer' ); ?>"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
        } );
        $(document).on('click','.edit-row',function(){
            var id = $(this).data('id');
            var url = "<?php echo admin_url( 'admin.php?page=op-promotions&action=edit' ); ?>"+'&id='+id;
            window.location = url;
        });
       
        $(document).on('click','.delete-row',function(){
            var id = $(this).data('id');
            var input_selected = $(document).find('#row-'+id);
            if(confirm('Are you sure ?'))
            {
                $.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                    type: 'post',
                    data: {action: 'op_delete_promotion',id: id},
                    dataType: 'json',
                    beforeSend:function(){
                        input_selected.prop('disabled',true);
                    },
                    success: function(response){
                        table.ajax.reload();
                    }
                });
            }

        });

    })( jQuery );
</script>