<?php 
 if($type == 1){
    $this->load->view('admin/header'); 
 }
 else{
    $this->load->view('admin/header_for_user'); 
 }

?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit item</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                              <?php $message = $this->session->userdata('message');?>
                                <?php if ($message) : ?> 
                                    <?php echo $message; ?>
                                <?php $this->session->unset_userdata('message'); ?>
                              <?php endif; ?>

<?php echo form_open('Super_admin/save_updated_inventory_item'); ?>

                            <fieldset>
                                <input type="hidden" name="id" class="form-control" value="<?php echo $item_data->id; ?>">

                                <div class="form-group">
                                    <label>Item name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $item_data->name; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" step="any" name="stock" class="form-control" value="<?php echo $item_data->stock; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Consumption per day</label>
                                    <input type="number" step="any" name="per_day" class="form-control" value="<?php echo $item_data->per_day; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                                <a href="<?php echo base_url(); ?>/Super_admin/delete_inventory_item/<?php echo $item_data->id; ?>" class="btn btn-danger btn-block" onclick="return checkDeletion();">Delete this item</a>
                            </fieldset>


<?php echo form_close(); ?>


<?php $this->load->view('admin/footer'); ?>