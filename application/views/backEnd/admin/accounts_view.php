<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("accounts_view"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/accounts-print/'.$accounts_info->id) ?>" target="_blank" class="btn bg-green btn-sm"><i class="fa fa-print"></i> <?php echo $this->lang->line("print");?></a>
                    </div>
                </div>
                <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 20px 20px 20px 20px; padding:20px 4px 20px 4px;">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <ul>
                                <li class=""><b><?php echo $this->lang->line('invoice_number'); ?></b><a class="pull-right"><?php echo  $accounts_info->invoice_number ;?></a>
                                </li>

                                <li class=""><b><?php echo $this->lang->line('accounts_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($accounts_info->accounts_date));?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('accounts_type'); ?></b><a class="pull-right"><?php if($accounts_info->accounts_type_id == 1)echo "Income" ; else echo "Expense";?></a>
                                </li>
                                    
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li class=""><b><?php echo $this->lang->line('insert_by'); ?></b><a class="pull-right"><?php echo $accounts_info->firstname. ' '. $accounts_info->lastname;?></a>
                                    </li>
                                
                                <li class=""><b><?php echo $this->lang->line('insert_time'); ?></b><a class="pull-right"><?php echo date('d M Y h:s A', strtotime($accounts_info->insert_time));?></a>
                                </li>
                                
                            </ul>  
                        </div>
                    </div>
                </div>
                
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 45%;"><?php echo $this->lang->line('account_head'); ?></th>
                                <th style="width: 30%;"><?php echo $this->lang->line('description'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('quantity'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('amount'); ?></th>
                                   
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                                foreach ($accounts_details as $key => $value) {
                                	$total += $value->amount; ?>
                            <tr>
                                <td> <?php echo ++$key; ?></td>
                                <td> <?php echo $value->account_head ; ?> </td>
                                <td> <?php echo $value->description; ?> </td>
                                <td> <?php echo $value->quantity; ?> </td>
                                <td style="text-align: right; padding-right: 20px;"> <?php echo number_format($value->amount, 2) ; ?> </td>
                                 
                            </tr>
                            <?php
                                }
                                ?>
                            <tr>
                                <td colspan="4" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('total');?></td>
                                <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format($total, 2) ; ?> </strong></td>   
                                 
                            </tr>
                            
                                
                        </tbody>
                    </table>
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



