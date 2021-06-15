
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('sms_send_new'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/sms_send/list" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('sms_send_list'); ?> </a>
                        <a href="<?php echo base_url() ?>admin/sms_send/list" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('sms_send_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        
                        <div class="col-md-8">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label col-md-3"><?php echo $this->lang->line('select_number'); ?></label>
                                    <div class="col-sm-9">
                                        <select id="select_number" class="select2 form-control" style="width: 100%;" required="">
                                            <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                                            <option value="1"><?php echo $this->lang->line('member'); ?></option>
                                            <option value="2"><?php echo $this->lang->line('committee'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a id="shownumber" class="btn btn-sm bg-blue form-control"><?php echo $this->lang->line('go') ?></a>
                            </div>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                    <div class="row" id="new_sms" style="display: none;">
                        <form action="<?php echo base_url("admin/sms_send/new_sms");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <br>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12 ">
                                            <label><?php echo $this->lang->line('to'); ?></label>
                                            <textarea name="receiver_numbers" rows="10" class="form-control inner_shadow_primary" name="receiver_numbers" placeholder="<?php echo $this->lang->line('to'); ?>" required="" id="sms_number"></textarea>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12 ">
                                            <label><?php echo $this->lang->line('message'); ?></label>
                                            <textarea name="message" rows="10" class="form-control inner_shadow_primary" name="message" placeholder="<?php echo $this->lang->line('message'); ?>" required=""></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                   <center>
                                    <button type="submit" class="btn btn-sm bg-blue"><?php echo $this->lang->line('send') ?></button>
                                   </center>
                                    
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

<script>
    $(function() {

        $('#shownumber').click(function() {

            $('#new_sms').show();

            var sms_to = $('#select_number').val();

            $.post("<?php echo base_url() . "admin/get_sms_number/"; ?>" + sms_to,
                {'sms_to': 'sms_to'},

                function (data2) {

                    var data = JSON.parse(data2)

                    $('#sms_number').val(data);
                });

        });

    });
</script>

