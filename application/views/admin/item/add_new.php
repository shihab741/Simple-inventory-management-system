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
                    <h1 class="page-header">New item</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                              <?php $message = $this->session->userdata('message');?>
                                <?php if ($message) : ?> 
                                    <?php echo $message; ?>
                                <?php $this->session->unset_userdata('message'); ?>
                              <?php endif; ?>

<?php echo form_open('Super_admin/saving_new_item'); ?>

                            <fieldset>
                                <div class="form-group">
                                    <label>Item name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter item name">
                                </div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" step="any" name="stock" class="form-control" placeholder="Enter stock">
                                </div>
                                <div class="form-group">
                                    <label>Consumption per day</label>
                                    <input type="number" step="any" name="per_day" class="form-control" placeholder="Enter consumption per day">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Add</button>
                            </fieldset>

<?php echo form_close(); ?>


<?php $this->load->view('admin/footer'); ?>