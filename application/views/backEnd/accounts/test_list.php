<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("test_details_list"); ?></h3>
                    <div class="box-tools pull-right">
                        
                    </div>
                </div>
                <div class="row" style="box-shadow: 0px 0px 10px 0px #00c0ef; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('accounts/test-details/list') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('invoice_number'); ?></label>
                                    <select name="invoice_number" class="form-control inner_shadow_info select2">
                                        <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                                    <?php foreach($invoice_number_list as $list){?>
                                        
                                        <option value="<?php echo $list->id;?>" <?php if ($search['invoice_number'] == $list->id) echo 'selected' ; ?> ><?php echo $list->invoice_number;?></option>
                                    <?php }?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('start_date'); ?></label>
                                    <input name="start_date" placeholder="<?php echo $this->lang->line('start_date'); ?> " class="form-control inner_shadow_info date"  type="text" autocomplete="off" value="<?= $search['start_date']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label><?php echo $this->lang->line('end_date'); ?></label>
                                    <input name="end_date" placeholder="<?php echo $this->lang->line('end_date'); ?> " class="form-control inner_shadow_info date"  type="text" autocomplete="off" value="<?= $search['end_date']; ?>">
                                </div>
                            </div>
                        </div>
                        

                      </div>
                      <div class="col-md-12">
                        <br>
                         <center>
                            <button type="submit" class="btn btn-sm btn-info"><?php echo $this->lang->line('search'); ?></button>
                            <?php if($search['print']){?>
                            <a href="<?php echo base_url('accounts/tests-list-print?start_date='.$search['start_date'].'&end_date='.$search['end_date'].'&invoice_number='.$search['invoice_number']) ?>" class="btn bg-green btn-sm" target="_blank"><i class="fa fa-print"></i> <?php echo $this->lang->line("print");?></a>
                        <?php }?>
                         </center>
                      </div>
                   </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_primary">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('issue_date'); ?></th>

                                <th style="width: 15%;"><?php echo $this->lang->line('patient_name'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('invoice_number'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('referred_by'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('total_amount'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('discount_amount'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('payable'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($test_list as $key => $value) {
                                	?>
                            <tr>
                                <td> <?php echo ++$key; ?></td>
                                <td> <?php echo date('d M Y', strtotime($value->issue_date)); ?></td>
                                <td> <?php echo $value->patient_name ; ?> </td>
                                <td> <?php echo $value->invoice_number; ?> </td>
                                <td> <?php echo $value->firstname.' '. $value->lastname; ?> </td>
                                <td style="text-align: right; padding-right: 20px;"> <?php echo number_format((float)$value->total_amount, 2, '.', '') ; ?> </td>
                                <td style="text-align: right; padding-right: 20px;"> <?php echo number_format((float)$value->discount_amount, 2, '.', '') ; ?> </td>
                                <td style="text-align: right; padding-right: 20px;"> <?php echo number_format((float)$value->total_amount-$value->discount_amount, 2, '.', '') ; ?> </td>
                                
                                <td> 
                                    <a href="<?php echo base_url('accounts/test-details/view/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-eye"></i></a>
                                    
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

