<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title"><?php echo $this->lang->line('test_name_edit'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/test-name/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('test_name_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/test-name/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('test_category'); ?>*</label>
                                            <select class="form-control inner_shadow_primary select2" name="test_category_id" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_test_category'); ?></option>
                                                <?php foreach($test_category_list as $list){?>
                                                <option value="<?php echo $list->id;?>" <?php if($edit_info->test_category_id == $list->id) echo "selected";?>><?php echo $list->name;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('test_name'); ?>*</label>
                                            <input name="test_name" placeholder="<?php echo $this->lang->line('test_name'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off" required value="<?= $edit_info->test_name?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('price'); ?></label>
                                            <input name="price" placeholder="<?php echo $this->lang->line('price'); ?> " class="form-control inner_shadow_primary "  type="text" autocomplete="off" value="<?= $edit_info->price?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('referral_commission'); ?></label>
                                            <input name="referral_commission" placeholder="<?php echo $this->lang->line('referral_commission'); ?> " class="form-control inner_shadow_primary" type="text" autocomplete="off" value="<?= $edit_info->referral_commission?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('report_format'); ?></label>
                                            <textarea name="report_format" id="" required="" placeholder="<?php echo $this->lang->line('report_format'); ?>" rows="2" class="form-control inner_shadow_6a8d9d"><?= $edit_info->report_format?></textarea>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('update'); ?></button>
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
    CKEDITOR.replace( 'report_format' );
</script>

