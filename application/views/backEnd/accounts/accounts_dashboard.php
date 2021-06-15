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
        <div class="col-xs-6">
            <div class="box box-purple box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-circle-o-notch"></i><h3 class="box-title"><?php echo $this->lang->line('due_report'); ?></h3>
                    <div class="box-tools pull-right">
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="overflow: scroll; overflow-x:auto; height: 300px;">
                    <table id="list" class="table table-bordered table-striped table_th_purple">
                        <thead>
                            <tr>
                                <th style="width: 5%"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 20%"><?php echo $this->lang->line('issue_date'); ?></th>
                                <th style="width: 20%"><?php echo $this->lang->line('invoice_number'); ?></th>
                                
                                <th style="width: 10%"><?php echo $this->lang->line('total_bill'); ?></th>
                                <th style="width: 10%"><?php echo $this->lang->line('total_paid'); ?></th>
                                <th style="width: 15%"><?php echo $this->lang->line('due'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                                foreach ($due_report_list as $key => $value) {
                                    ?>
                            <tr>
                                <td> <?php echo $sl++; ?> </td>
                                
                                <td> <?= date('d M Y',strtotime($value->issue_date)); ?> </td>
                                <td> <a href="<?php echo base_url('accounts/test-details/view/'.$value->id); ?>" style="text-decoration: none; color: #333;"><?= $value->invoice_number; ?></a> </td>
                               
                                <td> <?= number_format($value->total_amount- $value->discount_amount, 2); ?> </td>
                                <td> <?php if(isset($value->paid_amount)) echo number_format($value->paid_amount, 2); else{
                                    echo number_format(0, 2);
                                } ?> </td>
                                <td> <?php if(isset($value->paid_amount)) echo number_format($value->total_amount- $value->discount_amount - $value->paid_amount, 2); else{
                                    echo number_format($value->total_amount- $value->discount_amount, 2);
                                } ?> </td>
                              
                            </tr>
                            <?php } ?>
                            
                        </tbody>     
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>