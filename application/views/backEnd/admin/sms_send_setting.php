
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('sms_send_setting'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/sms_send/list" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('sms_send_list'); ?> </a>
                        <a href="<?php echo base_url() ?>admin/sms_send/new_sms" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-envelope"></i> <?php echo $this->lang->line('sms_send_new'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/sms_send/setting");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12 ">
                                            <label><?php echo $this->lang->line('user_name'); ?></label>
                                            <input  class="form-control inner_shadow_primary" name="username" placeholder="<?php echo $this->lang->line('user_name'); ?>" required="" type="text" value="<?php //echo $setting_info->username; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12 ">
                                            <label><?php echo $this->lang->line('password'); ?></label>
                                            <input  class="form-control inner_shadow_primary" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" required="" type="password" value="<?php //echo $setting_info->password; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for=""><br></label>
                                    <button type="submit" class="btn btn-sm bg-blue form-control"><?php echo $this->lang->line('save') ?></button>
                                </div>

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

