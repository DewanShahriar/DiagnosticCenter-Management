<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('test_category_add'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/test-category/list" type="submit" class="btn bg-teal btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('test_category_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/test-category/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('test_category_name'); ?>*</label>
                                            <input name="name" placeholder="<?php echo $this->lang->line('test_category_name'); ?> " class="form-control inner_shadow_orange"  type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                </div>    
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('save'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</section>

<script>

    $(function(){

        $('.date').datepicker({

            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd-mm-yy",
            yearRange: "-10:+10"
        });

        $('.timepicker').timepicker({
            
            showInputs: false
        });

    });
</script>

