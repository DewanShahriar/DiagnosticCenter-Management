



<section class="content">

    <div class="row">

        <div class="col-md-12">

            <!-- Horizontal Form -->

            <div class="box box-teal">

                <div class="box-header with-border">

                    <h3 class="box-title"> <?php echo $this->lang->line('mail_send_setting'); ?> </h3>

                    <div class="box-tools pull-right">

                    </div>

                </div>

                <div class="box-body">

                    <div class="row" style="box-shadow: 1px 1px 15px 5px #3c8dbc;margin: 10px 165px 40px 165px;padding: 30px 0px 30px 0px;">

                        <form action="<?php echo base_url('admin/mail_setting') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-2"></div>

                            <div class="col-md-8">

                                <?php if ($mail_setting_info) {
                                    foreach ($mail_setting_info as $key => $value) { ?>

                                    <div class="form-group">

                                        <label class="col-sm-4"> <?php echo strtoupper(str_replace('_', ' ', $value->setting_name)); ?></label>
                                        <div class="col-sm-8">

                                            <input name="value[]" class="form-control inner_shadow_teal" placeholder="<?php echo $this->lang->line('value'); ?>" required="" type="text" value="<?php echo $value->value; ?>">

                                            <input name="mail_setting_id[]" class="form-control" placeholder="<?php echo $this->lang->line('value'); ?>" required="" type="hidden" value="<?php echo $value->id; ?>">

                                        </div>

                                    </div>

                                <?php } } ?>

                                <center>

                                    <button type="submit" class="btn-sm btn bg-teal"> <?php echo $this->lang->line('update'); ?> </button>

                                </center>

                            </div>

                            <div class="col-md-2"></div>

                        </form>

                    </div>

                </div>

                <!-- /.box-footer --> 

            </div>

            <!-- /.box -->

        </div>

        <!--/.col (right) -->

    </div>

</section>



