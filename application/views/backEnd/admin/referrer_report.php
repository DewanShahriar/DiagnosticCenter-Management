<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('referrer_report'); ?> </h3>
                    <div class="box-tools pull-right">
                        
                        
                    </div>
                </div>

                <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                   <form action="<?php echo base_url('admin/referrer-report') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                                        <label><?php echo $this->lang->line('referred_by'); ?></label>
                                        <select class="form-control inner_shadow_primary select2" name="user_id" id="user_id" style="width: 100%;">
                                            <option value=""><?php echo $this->lang->line('select_doctor'); ?></option>
                                            <?php foreach($referred_list as $list){?>
                                            <option value="<?php echo $list->id;?>" <?php if($search['user_id'] == $list->id) echo "selected";?>><?php echo $list->firstname.' '.$list->lastname;?></option>
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
                            <?php if($search['print']){?>
                            <a href="<?php echo base_url('admin/referrer-list-print?start_date='.$search['start_date'].'&end_date='.$search['end_date'].'&user_id='.$search['user_id']); ?>" class="btn bg-green btn-sm" target="_blank"><i class="fa fa-print"></i> <?php echo $this->lang->line("print");?></a>
                            <?php }?>
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
                                        
                                        <th style="width: 30%"><?php echo $this->lang->line('referred_by'); ?></th>
                                        <th style="width: 15%"><?php echo $this->lang->line('total_bill'); ?></th>
                                        <th style="width: 15%"><?php echo $this->lang->line('referrer_fee'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sl = 1;
                                    $grand_total = 0;
                                    $referrer_total = 0;
                                        foreach ($referrer_report_list as $key => $value) {
                                            $grand_total += ($value->total_amount - $value->discount_amount);
                                            $referrer_total += $value->referrer_fee;?>
                                    <tr>
                                        <td> <?php echo $sl++; ?> </td>
                                        
                                        <td> <?= date('d M Y',strtotime($value->issue_date)); ?> </td>
                                        <td> <?= $value->invoice_number; ?> </td>
                                        <td> <?= $value->firstname.' '.$value->lastname; ?> </td>
                                        <td style="text-align: right; padding-right: 20px;"> <?= number_format($value->total_amount - $value->discount_amount, 2); ?> </td>
                                        <td style="text-align: right; padding-right: 20px;"> <?= number_format($value->referrer_fee, 2); ?> </td>
                                        
                                    </tr>
                                    <?php
                                        }
                                        ?>
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('total');?></td>
                                        <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format($grand_total, 2) ; ?> </strong></td>
                                        <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format($referrer_total, 2) ; ?> </strong></td>  
                                         
                                    </tr>

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