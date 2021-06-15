<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('test_payment_list'); ?> </h3>
                    <div class="box-tools pull-right">
                        
                        <a href="<?php echo base_url() ?>admin/test-payment/add" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('test_payment_add'); ?> </a>
                    </div>
                </div>

                <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('admin/test-payment/due') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('start_date'); ?></label>
                                        <input name="start_date" placeholder="<?php echo $this->lang->line('start_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?= $search['start_date']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('end_date'); ?></label>
                                        <input name="end_date" placeholder="<?php echo $this->lang->line('end_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?= $search['end_date']; ?>">
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('patient_name'); ?></label>
                                        <select class="form-control inner_shadow_primary select2" name="patient_id" id="patient_id" style="width: 100%;">
                                            <option value=""><?php echo $this->lang->line('select_patient'); ?></option>
                                            <?php foreach($patient_list as $list){?>
                                            <option value="<?php echo $list->id;?>"><?php echo $list->patient_name.'('.$list->patient_phone.')';?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>  
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <br>
                         <center>
                            <button type="submit" class="btn btn-sm btn bg-purple"><?php echo $this->lang->line('search'); ?></button>
                         </center>
                        </div>
                   </form>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="userListTable" class="table table-bordered table-striped table_th_primary">
                                <thead>
                                    <tr>
                                        <th style="width: 5%"><?php echo $this->lang->line('sl'); ?></th>
                                        <th style="width: 15%"><?php echo $this->lang->line('issue_date'); ?></th>
                                        <th style="width: 20%"><?php echo $this->lang->line('invoice_number'); ?></th>
                                        <th style="width: 25%"><?php echo $this->lang->line('patient_name'); ?></th>
                                        
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
                                        <td> <a href="<?php echo base_url('admin/test-details/view/'.$value->id); ?>" style="text-decoration: none; color: #333;"><?= $value->invoice_number; ?></a> </td>
                                        <td> <?= $value->patient_name.'('.$value->patient_phone.')'; ?> </td>
                                        <td> <?= number_format($value->total_amount- $value->discount_amount, 2); ?> </td>
                                        <td> <?php if(isset($value->paid_amount)) echo number_format($value->paid_amount, 2); else{
                                            echo number_format(0, 2);
                                        } ?> </td>
                                        <td> <?php if(isset($value->paid_amount)) echo number_format($value->total_amount- $value->discount_amount - $value->paid_amount, 2); else{
                                            echo number_format($value->total_amount- $value->discount_amount, 2);
                                        } ?> </td>
                                        
                                        
                                        
                                    </tr>
                                    <?php
                                        }
                                        ?>

                                </tbody>
                            </table>

                           
                        </div>
                    </div>
                </div>    
            </div>
        </div>
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