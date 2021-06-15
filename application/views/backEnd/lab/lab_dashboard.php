<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-hospital-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $this->lang->line('total_tests')?></span>
                    <span class="info-box-number"> <?php echo $total_tests;?> </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-file"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $this->lang->line('report_submitted')?></span>
                    <span class="info-box-number"> <?php echo $report_submitted;?> </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-user-md"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $this->lang->line('total_doctors')?></span>
                    <span class="info-box-number"> <?php echo $total_doctor;?></span>
                     

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-bed "></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $this->lang->line('total_patient')?></span>
                    <span class="info-box-number"><?php echo $total_patient;?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        
        <div class="col-xs-9">
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('report_submit'); ?></h3>
                    <div class="box-tools pull-right">
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow: scroll; overflow-x:auto; height: 300px;">
                    <table id="cowTypeList" class="table table-bordered table-striped table_th_info">
                        <thead>
                            <tr>
                                <th style="width: 5%"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 15%"><?php echo $this->lang->line('report_publish_date'); ?></th>
                                
                                <th style="width: 30%"><?php echo $this->lang->line('test_name'); ?></th>
                                <th style="width: 15%"><?php echo $this->lang->line('invoice_number'); ?></th>
                                <th style="width: 10%"><?php echo $this->lang->line('action'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                                foreach ($report_submit_list as $key => $value) {
                                    ?>
                            <tr>
                                <td> <?php echo $sl++; ?> </td>
                                
                                <td> <?= date('d M Y',strtotime($value->report_publish_date)); ?> </td>
                                <td> <?php echo $value->test_name; ?> </td>
                                <td> <a href="<?php echo base_url('lab/test-details/view/'.$value->tests_id); ?>" style="text-decoration: none; color: #333;"><?= $value->invoice_number; ?></a> </td>
                                <td> <a href="<?php echo base_url('lab/test-details/view/'.$value->tests_id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-eye"></i></a> </td>
                                
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

    </div>

</section>