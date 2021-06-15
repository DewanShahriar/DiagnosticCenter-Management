<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("test_details_view"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('accounts/test-details-print/'.$test->id) ?>" target="_blank" class="btn bg-green btn-sm"><i class="fa fa-print"></i> <?php echo $this->lang->line("print");?></a>
                    </div>
                </div>
                <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 20px 20px 20px 20px; padding:20px 4px 20px 4px;">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <center style="margin-top: 0px;margin-bottom: 15px;">
                                 <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('test_info'); ?></span>
                            </center>
                            <ul>
                                <li class=""><b><?php echo $this->lang->line('invoice_number'); ?></b><a class="pull-right"><?php echo $test->invoice_number;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('issue_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($test->issue_date));?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('referred_by'); ?></b><a class="pull-right"><?php echo $test->firstname.' '.$test->lastname;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('insert_by'); ?></b><a class="pull-right"><?php echo $test->firstname.' '.$test->lastname;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('insert_time'); ?></b><a class="pull-right"><?php echo date('d M Y h:s A', strtotime($test->insert_time));?></a>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <center style="margin-top: 0px;margin-bottom: 15px;">
                                 <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('patient_info'); ?></span>
                            </center>
                            <ul>
                                <li class=""><b><?php echo $this->lang->line('patient_name'); ?></b><a class="pull-right"><?php echo $test->patient_name;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('patient_phone'); ?></b><a class="pull-right"><?php echo $test->patient_phone;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('father_name'); ?></b><a class="pull-right"><?php echo $test->father_name;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('mother_name'); ?></b><a class="pull-right"><?php echo $test->mother_name;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('patient_nid'); ?></b><a class="pull-right"><?php echo $test->patient_nid;?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('birth_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($test->birth_date));?></a>
                                </li>
                                <li class=""><b><?php echo $this->lang->line('address'); ?></b><a class="pull-right"><?php echo $test->address;?></a>
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
                                <th style="width: 35%;"><?php echo $this->lang->line('test_name'); ?></th>
                                <th style="width: 20%;"><?php echo $this->lang->line('report_publish_date'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('update_report'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('referrer_fee'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('price'); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                                foreach ($test_details as $key => $value) {
                                	$total += $value->test_bill; ?>
                            <tr>
                                <td> <?php echo ++$key; ?></td>
                                <td> <?php echo $value->test_name ; ?> </td>
                                <td> <?php echo date('d M Y', strtotime($value->report_publish_date )); ?> </td>
                                <td> <a href="#"  class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a></td>
                                
                                <td> <?php echo $value->referrer_fee; ?> </td>
                                <td style="text-align: right; padding-right: 20px;"> <?php echo number_format($value->test_bill, 2) ; ?> </td>
                                 
                            </tr>
                            <?php
                                }
                                ?>
                            <tr>
                                <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('sub_total');?></td>
                                <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format($total, 2) ; ?> </strong></td>   
                                 
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('discount_amount');?></td>
                                <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format($test->discount_amount, 2) ; ?> </strong></td>  
                                 
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('payable');?></td>
                                <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format(($total - $test->discount_amount), 2) ; ?> </strong></td>  
                                 
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('paid_amount');?></td>
                                <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format($paid_amount, 2) ; ?> </strong></td>  
                                 
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;"> <?php echo $this->lang->line('due');?></td>
                                <td style="text-align: right; padding-right: 20px;"> <strong> <?php echo number_format(($total- $test->discount_amount - $paid_amount), 2) ; ?> </strong></td>  
                                 
                            </tr>
                            <?php if(($total- $test->discount_amount - $paid_amount) > 0){?>
                            <tr>
                                <td colspan="6"><button id="make_payment" class="btn btn-primary pull-right"><i class="fa fa-paypal" aria-hidden="true"></i> <?php echo $this->lang->line('make_payment')?> </button></td>
                                
                                 
                            </tr>  
                        <?php }?>
                            <form method="post" id="payment_submit_form" enctype="multipart/form-data" class="form-horizontal">
                            <tr id="make_payment_tr" style="display: none;">
                                <td colspan="5" style="text-align: right; font-size: 15px; font-weight: bold;"><?php echo $this->lang->line('paid_amount') ?>: </td>
                                <td>
                                   <input type="text" id="paid_amount" name="paid_amount" class="form-control inner_shadow_primary" autocomplete="off">
                                   <input type="hidden" id="tests_id" name="tests_id" value="<?php echo $test->id?>">
                                   <input type="hidden" id="patient_id" name="patient_id" value="<?php echo $test->patient_id?>">
                                </td>
                             </tr>
                             <tr id="submit_btn_tr" style="display: none;">
                                <td colspan="6"><button type="submit" id="payment_submit_btn" class="btn btn-success pull-right"><?php echo $this->lang->line('submit')?> </button></td>
                             </tr>
                             </form>
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

    CKEDITOR.replace( 'report_format' );

</script>



<script type="text/javascript">
    $(document).ready(function(){

        $("#make_payment").click(function(){
                
            $("#make_payment_tr").show();
            $("#submit_btn_tr").show();
           
        });
      
    });

</script>
<script>  
   $(document).ready(function(){  
        $('#payment_submit_form').on('submit', function(e){ 
            
             e.preventDefault();  
    
            var tests_id = $('#tests_id').val();
            var patient_id = $('#patient_id').val();
            var paid_amount = $('#paid_amount').val();
            if(paid_amount == '') { 
   
                alert("Please  Input Amount"); 
   
            } else {  
   
                $.post("<?php echo base_url() . "accounts/make_payment_from_invoice/"; ?>" + tests_id+"/"+patient_id+"/"+paid_amount,
                    {'nothing': 'nothing'},
                    function (data2) {
                        var data = JSON.parse(data2);
                        console.log(data);
                        if(data == 'ok'){
                            window.location.href = "<?php echo base_url() . 'accounts/test-details/view/'; ?>"+tests_id;
                        } else{
                            alert('err');
                        }
                        
                });
   
                    
            }  
        });  
   });  
</script>


