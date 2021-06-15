<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('test_payment_list'); ?> </h3>
                    <div class="box-tools pull-right">
                        
                        <a href="<?php echo base_url() ?>user/test-payment/add" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('test_payment_add'); ?> </a>
                    </div>
                </div>

                <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('user/test-payment/list') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('start_date'); ?></label>
                                        <input name="start_date" placeholder="<?php echo $this->lang->line('start_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?= $search['start_date']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('end_date'); ?></label>
                                        <input name="end_date" placeholder="<?php echo $this->lang->line('end_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" value="<?= $search['end_date']; ?>">
                                    </div>
                                </div>    
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('test'); ?></label>
                                        <select class="form-control inner_shadow_primary select2" name="tests_id" id="tests_id" style="width: 100%;">
                                            <option value=""><?php echo $this->lang->line('select_test'); ?></option>
                                            <?php foreach($tests_list as $list){?>
                                            <option value="<?php echo $list->id;?>"><?php echo $list->invoice_number;?></option>
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
                                        <th style="width: 15%"><?php echo $this->lang->line('paid_date'); ?></th>
                                        <th style="width: 30%"><?php echo $this->lang->line('patient_name'); ?></th>
                                        <th style="width: 15%"><?php echo $this->lang->line('invoice_number'); ?></th>
                                        
                                        <th style="width: 10%"><?php echo $this->lang->line('paid_amount'); ?></th>
                                        <th style="width: 10%"><?php echo $this->lang->line('approved_status'); ?></th>
                                        <th style="width: 15%"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sl = 1;
                                        foreach ($test_payment_list as $key => $value) {
                                            ?>
                                    <tr>
                                        <td> <?php echo $sl++; ?> </td>
                                        
                                        <td> <?= date('d M Y',strtotime($value->paid_date)); ?> </td>
                                        <td> <?= $value->patient_name.'('.$value->patient_phone.')'; ?> </td>
                                        <td> <?= $value->invoice_number; ?> </td>
                                        <td style="text-align: right; padding-right: 20px;"> <?= number_format($value->paid_amount, 2); ?> </td>
                                        <td> <?php if($value->payment_approved == 1) echo "Approved";
                                        else echo "Unapproved";
                                         ?> </td>
                                        
                                        
                                        <td>
                                            <?php if($value->payment_approved == 0){ ?>
                                            <a href="<?= base_url('user/test-payment/approved/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-check-square-o"></i> </a>
                                        <?php }?>
                                            <a href="<?= base_url('user/test-payment/edit/'.$value->id); ?>" class="btn btn-sm bg-purple"> <i class="fa fa-edit"></i> </a>
                                            <a href="<?= base_url('user/test-payment/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                        </td>
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