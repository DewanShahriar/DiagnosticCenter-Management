<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('test_name_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('user/test-name/add') ?>" class="btn bg-teal btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('test_name_add'); ?></a>
                        <a href="<?php echo base_url('user/test-name-print') ?>" target="_blank" class="btn bg-purple btn-sm"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="cowFeedsList" class="table table-bordered table-striped table_th_primary">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('test_name'); ?></th>
                                <th style="width: 25%;"><?php echo $this->lang->line('test_category'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('price'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('referral_commission'); ?></th>
                                
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($test_name_list as $value) {
                                	?>
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo $value->test_name; ?> </td>
                                <td> <?php echo $value->category_name; ?> </td>
                                <td> <?php echo $value->price; ?> </td>
                                <td> <?php echo $value->referral_commission; ?> </td>
                               
                                <td> 
                                    <a href="<?php echo base_url('user/test-name/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('user/test-name/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>

<script type="text/javascript">

    $(function () {

        $("#cowFeedsList").DataTable();
    });
    
</script>

