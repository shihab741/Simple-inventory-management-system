<?php 
    $this->load->view('admin/header'); 
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="page-header">Inventory</h1>
                </div>
                <div class="col-md-3" align="right">
                    <a href="<?php echo base_url(); ?>Super_admin/newItem" class="btn btn-primary page-header">Add new item</a>
                </div>
            </div>



                              <?php $message = $this->session->userdata('message');?>
                                <?php if ($message) : ?> 
                                    <?php echo $message; ?>
                                <?php $this->session->unset_userdata('message'); ?>
                              <?php endif; ?>


<span id="form_output"></span>


    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="table-responsive">
            <table id="item_data" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Stock</th>
                        <th>Per day</th>
                        <th>Remaining days</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>
        </div>
        <!-- /.table-responsive -->

    </div>
    <!-- /.panel-body -->


<div id="update_stock_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="update_stock_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    <span id="form_output_modal"></span>
                    <h3 id="name"></h3>
                    <div class="form-group">
                        <input type="number" name="addOrTake" id="addOrTake" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" value="" />
                    <input type="hidden" name="stock" id="stock" value="" />
                    <input type="hidden" name="button_action" id="button_action" value="" />
                    <input type="submit" name="submit" id="action" value="" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



      <script src="<?php echo base_url(); ?>vendor/datatable-assets/jquery.dataTables.min.js"></script>  
      <script src="<?php echo base_url(); ?>vendor/datatable-assets/dataTables.bootstrap.min.js"></script>          
      <link rel="stylesheet" href="<?php echo base_url(); ?>vendor/datatable-assets/dataTables.bootstrap.min.css" /> 

 <script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
      var items = $('#item_data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url() . 'Super_admin/ajax_inventory_items'; ?>",  
                type:"POST"  
           },  
           "columnDefs":[  
                {  
                     "targets":[2, 3, 4],  
                     "orderable":false,  
                },  
           ], 
        "pageLength": 25 
      });  

    $(document).on('click', '.add_to_stock', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"<?php echo base_url(); ?>Super_admin/getInventoryItem",
            method:'POST',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#name').text(data.name);
                $('#stock').val(data.stock);
                $('#id').val(id);
                $('#update_stock_modal').modal('show');
                $('#action').val('Add');
                $('.modal-title').text('Add to stock');
                $('#button_action').val('add');
            }
        })
    });


    $(document).on('click', '.take_from_stock', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"<?php echo base_url(); ?>Super_admin/getInventoryItem",
            method:'POST',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#name').text(data.name);
                $('#stock').val(data.stock);
                $('#id').val(id);
                $('#update_stock_modal').modal('show');
                $('#action').val('Take');
                $('.modal-title').text('Take from stock');
                $('#button_action').val('take');
            }
        })
    });

    $('#update_stock_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"<?php echo base_url(); ?>Super_admin/addOrTakeFromInventory",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
                $('#form_output').html(data.success);
                $('#update_stock_form')[0].reset();
                $('#action').val('');
                $('.modal-title').text('');
                $('#button_action').val('');
                $('#item_data').DataTable().ajax.reload();
                $('#update_stock_modal').modal('hide');
            }
        })
    });

 });  
 </script> 

<?php $this->load->view('admin/footer'); ?>