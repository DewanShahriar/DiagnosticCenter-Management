<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('sms_send_list'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/sms_send/setting" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-cog"></i> <?php echo $this->lang->line('sms_send_setting'); ?> </a>

                        <a href="<?php echo base_url() ?>admin/sms_send/new_sms" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-envelope"></i> <?php echo $this->lang->line('sms_send_new'); ?> </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                            <tr>
                                <th style="width : 10%"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width : 15%"><?php echo $this->lang->line('date');?></th>
                                <th style="width : 50%"><?php echo $this->lang->line('message'); ?></th>
                                <th style="width : 15%"><?php echo $this->lang->line('receivers'); ?></th>
                                <th style="width : 10%"><?php echo $this->lang->line('total'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php 
                            
                                if ($sms_send_list) {
                                    foreach ($sms_send_list as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo date('M d, Y H:s A', strtotime($value->send_date_time)); ?></td>
                                <td><?php echo $value->message; ?></td>
                                <td><a class="show_receivers" data-toggle="modal" data-target="#modal-default" style="color: #333;" data-receivers = "<?php echo $value->receiver_numbers; ?>"><?php echo substr($value->receiver_numbers, 0, 20); ?></a></td>
                                <td><?php $total = explode(',', $value->receiver_numbers); echo sizeof($total); ?></td>
                            </tr>
                                                    <?php } } ?> -->
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>

     <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('all_receivers'); ?></h4>
                </div>
                <div class="modal-body">
                    <textarea id="all_receivers" rows="10" class="form-control" style="resize: none;"></textarea>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>
<script type="text/javascript">
    $(function () {
        $("#userListTable").DataTable();
    });
    
</script>

<script>
    $(function() {

        $('.show_receivers').click(function() {

            var all_receivers = $(this).data('receivers');

            //alert(all_receivers);

            $('#all_receivers').text(all_receivers);

        });

    });
</script>