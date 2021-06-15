<section class="content">
   <div class="row">
      <div class="col-md-12">
         <!-- Horizontal Form -->
         <div class="box box-primary box-solid">
            <div class="box-header with-border">
               <h4 class="box-title">
               <?php echo $this->lang->line('test_details_add'); ?></h3>
               <div class="box-tools pull-right">
                  <a href="<?php echo base_url() ?>lab/test-details/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('test_details_list'); ?>  </a>
               </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="row" style="box-shadow: 0px 0px 10px 0px #3c8dbc; margin: 20px 20px 20px 20px; padding:20px 4px 20px 4px;">
               <div class="col-md-12">
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('issue_date'); ?>*</label>
                           <input name="issue_date" placeholder="<?php echo $this->lang->line('issue_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('patient_type'); ?></label>
                           <select class="form-control inner_shadow_primary select2" name="patient_type" id="patient_type" style="width: 100%;">
                              <option value=""><?php echo $this->lang->line('select_patient_type'); ?></option>
                              <option value="0"><?php echo $this->lang->line('old'); ?></option>
                              <option value="1"><?php echo $this->lang->line('new'); ?></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('referred_by');?></label>
                           <select class="form-control inner_shadow_primary select2" name="referred_by" id="referred_by" style="width: 100%;">
                              <option value=""><?php echo $this->lang->line('select_referred'); ?></option>
                              <?php foreach ($referred_list as $key => $value) {  ?>
                              <option value="<?= $value->id?>"><?php echo $value->firstname.' '.$value->lastname; ?></option>
                              <?php  }?>    
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12" id="patient_search" style="display: none;">
                           <label><?php echo $this->lang->line('patient_search'); ?></label>
                           <input name="patient_id" id="patient_id" placeholder="<?php echo $this->lang->line('phone/pid/nid'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off">
                           <input  type="hidden" id="hiddenid" name="hiddenid">
                        </div>

                     </div>
                     <div id="display"></div>
                  </div>
                  
               </div>
               <div class="col-md-12">
                  <br>
                  <center style="margin-top: 0px;margin-bottom: 15px;">
                     <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('patient_info'); ?></span>
                  </center>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('patient_name'); ?></label>
                           <input id="patient_name" name="patient_name" placeholder="<?php echo $this->lang->line('patient_name'); ?>" class="form-control inner_shadow_primary" type="text" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('patient_phone'); ?></label>
                           <input id="patient_phone" name="patient_phone" placeholder="<?php echo $this->lang->line('patient_phone'); ?>" class="form-control inner_shadow_primary" type="tel" pattern="[0]{1}[1]{1}[3|4|5|6|7|8|9]{1}[0-9]{8}" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('father_name'); ?></label>
                           <input id="father_name" name="father_name" placeholder="<?php echo $this->lang->line('father_name'); ?>" class="form-control inner_shadow_primary" type="text" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('mother_name'); ?></label>
                           <input id="mother_name" name="mother_name" placeholder="<?php echo $this->lang->line('mother_name'); ?>" class="form-control inner_shadow_primary" type="text" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('patient_nid'); ?></label>
                           <input id="patient_nid" name="patient_nid" placeholder="<?php echo $this->lang->line('patient_nid'); ?>" class="form-control inner_shadow_primary" type="text" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('birth_date'); ?></label>
                           <input id="birth_date" name="birth_date" placeholder="<?php echo $this->lang->line('birth_date'); ?>" class="form-control inner_shadow_primary date" type="text" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <div class="col-sm-12">
                           <label><?php echo $this->lang->line('address'); ?></label>
                           <input id="address" name="address" placeholder="<?php echo $this->lang->line('address'); ?>" class="form-control inner_shadow_primary" type="text" autocomplete="off">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                         <div class="col-sm-12">
                             <label><?php echo $this->lang->line('gender'); ?></label>
                             <select id="gender" name="gender" class="form-control select2" style="width:100%">
                                 <option value=""><?php echo $this->lang->line('select_gender'); ?></option>
                                 <option value="male"><?php echo $this->lang->line('male'); ?></option>
                                 <option value="female"><?php echo $this->lang->line('female'); ?></option>
                                 <option value="other"><?php echo $this->lang->line('other'); ?></option>
                             </select>
                         </div>
                     </div>
                 </div>
               </div>
             
            </div>
            <div class="box-body">
               
               <div class="row">
                <center style="margin-top: 0px;margin-bottom: 15px;">
                     <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('invoice_details'); ?></span>
                  </center>
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="col-md-12">
                           <table class="table table-bordered table-striped table_th_primary" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                    <th style="width: 25%;"><?php echo $this->lang->line('test_name'); ?></th>
                                    <th style="width: 20%;"><?php echo $this->lang->line('report_publish_date'); ?></th>
                                    <th style="width: 20%;"><?php echo $this->lang->line('referrer_fee'); ?></th>
                                    <th style="width: 20%;"><?php echo $this->lang->line('amount'); ?></th>
                                    
                                 </tr>
                              </thead>
                              <tbody>
                                 <input type="hidden" name="showrowid" id="showrowid" value="3">
                                 <?php
                                    // 61 is the max limit, change to javascript also from botom of the code.
                                    
                                    for ($i=1; $i < 10 ; $i++) { ?>
                                 <tr id="trid<?= $i; ?>" style="<?php if($i > 2) echo 'display: none'; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                       <select name="tests_name_id[]" id="tests_name_id" class="form-control select2" onchange="load_amount(this.value, <?= $i; ?>)" style="width:100%" >
                                          <option value=""><?php echo $this->lang->line('select_test_name'); ?></option>
                                          <?php foreach ($test_name_list as $key => $value): ?>
                                          <option data-keyid="<?= $i; ?>" value="<?php echo $value->id; ?>"><?php echo $value->test_name; ?></option>
                                          <?php endforeach ?>
                                       </select>
                                    </td>
                                    
                                    
                                    <td>
                                       <input name="report_publish_date[]" placeholder="<?php echo $this->lang->line('report_publish_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off">
                                    </td>
                                    <td>
                                       <input type="number"  class="form-control inner_shadow_primary numberconvert" name="referrer_fee[]" value="0" id="referrer_fee<?= $i; ?>"  placeholder="<?php echo $this->lang->line('referrer_fee');?>" readonly>
                                    </td>
                                    <td>
                                       <input type="number" class="form-control inner_shadow_primary numberconvert" name="amount[]" value="0" id="amount<?= $i; ?>"  placeholder="<?php echo $this->lang->line('amount'); ?>" readonly>
                                    </td>
                                 </tr>
                                 <?php } ?>
                                 <tr>
                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('sub_total') ?>: </td>
                                    <td>
                                       <input type="text" readonly id="total_amount_id" name="total_amount_id" class="form-control inner_shadow_primary" value="0">
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('discount') ?>: </td>
                                    <td>
                                       <input type="checkbox" id="discount_check" class="pull-right">
                                    </td>
                                 </tr>
                                 <tr id="discount_tr" style="display: none;">
                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('discount_amount') ?>: </td>
                                    <td>
                                       <input type="text" name="discount_amount"  id="discount_amount" class="form-control inner_shadow_primary" onkeyup="discount_cal()" autocomplete="off">
                                    </td>
                                 </tr>
                                 <tr id="permit_tr" style="display: none;">
                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('permit_by') ?>: </td>
                                    <td>
                                       <input type="text" id="permit_by" name="discount_permit_by" class="form-control inner_shadow_primary">
                                    </td>
                                 </tr>
                                 <tr id="discount_option" style="display: none;">
                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('discount_option') ?>: </td>
                                    <td>
                                      <select class="form-control inner_shadow_primary select2" name="discount_option_id" id="discount_option_id" style="width: 100%;">
                                        <option value=""><?php echo $this->lang->line('select_discount_option'); ?></option>
                                        <?php foreach($discount_option_list as $list){?>
                                          <option value="<?php echo $list->id;?>"><?php echo $list->option_name; ?></option>
                                        <?php }?>
                                      </select>
                                      
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('payable') ?>: </td>
                                    <td>
                                       <input type="text" id="payable" name="total_amount" class="form-control inner_shadow_primary" readonly="">
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <center>
                        <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                        <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                        <a class="btn btn-info" onclick="makerowvisible();"><i class="fa fa-plus"></i> </a>
                     </center>
                  </div>
               </div>
            </div>
        </form>
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

<script>
    function load_amount(tests_name_id, keyid) {
        $.post("<?php echo base_url() . "lab/get_test_amount/"; ?>" + tests_name_id,
            {'nothing': 'nothing'},
            function (data2) {
                var data = JSON.parse(data2);
                
                $('#referrer_fee'+keyid).val(data.referral_commission);
                $('#amount'+keyid).val(data.price);

                var total_amount = 0;
    
                for(var i = 1; i < 10; i++){
            
                    var tempamount = $('#amount'+i).val();
                    total_amount+= Number(tempamount);
                }
                
                $('#total_amount_id').val(total_amount);
                $('#payable').val(total_amount);
                
            });  
        
    }
    
</script>

<script>
    let sub_total;
    let discount_amount;
    let payable_amount;
    
    function discount_cal(){
        
        sub_total       = parseInt($("#total_amount_id").val());
        discount_amount = parseInt($("#discount_amount").val()) || 0;
        payable_amount  = 0;

        if(sub_total > 0){
            payable_amount  = sub_total - discount_amount;
            $("#payable").val(payable_amount);   
        }
        
    }

    function makerowvisible(){
        
        var nextrownumber = $("#showrowid").val();
        $("#trid"+Number(nextrownumber)).show();
        $("#showrowid").val(Number(nextrownumber)+1);
        $("#discount_amount").val('');
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $("#discount_check").click(function(){
            
            if ($("#discount_check").is(":checked"))
            {
                //show the hidden div
                $("#discount_tr").show();
                $("#permit_tr").show();
                $("#discount_option").show();

            }
            else
            {
                //otherwise, hide it
                $("#discount_tr").hide();
                $("#permit_tr").hide();
                $("#discount_option").hide();
            }
        });
      
    });

</script>

<script type="text/javascript">

    $( document ).ready(function() {

        $('#patient_type').on('change', function() {

            if (this.value == 0) {
                
                $('#patient_search').show();
                
            } else if (this.value == 1) {

                $('#patient_search').hide();
            }
        });
    });
    
</script>

<script type="text/javascript">

$(document).ready(function() {
   
    $("#patient_id").keyup(function() {
       
       var search = $('#patient_id').val();
       
       if (search == "") {
           
           $("#display").html("");
       }
       
       else {
           
           $.ajax({
               type: "POST",
               url: "<?php echo base_url() . 'lab/patient-search'; ?>",
               data: {search: search },
               success: function(res) {
                    var obj = JSON.parse(res);
                    var data = [];
                    
                    if(obj.length > 0){
                        $.each(obj, function (i, item) {
                            data.push({label:(this.patient_name + "(" + this.patient_phone + ")"), idx:this.id, pname:this.patient_name, phone:this.patient_phone,fname:this.father_name, mname:this.mother_name, nid:this.patient_nid, bdate:this.birth_date, addr:this.address, gen: this.gender}); 
                        
                        });
                        $( "#patient_id").autocomplete({ 
                    
                            source: data,

                            select: function(event, ui) {
                                //hidden input
                                $('#hiddenid').val(ui.item.idx);
                                $('#patient_name').val(ui.item.pname);
                                $('#patient_phone').val(ui.item.phone);
                                $('#father_name').val(ui.item.fname);
                                $('#mother_name').val(ui.item.mname);
                                $('#patient_nid').val(ui.item.nid);
                                $('#birth_date').val(ui.item.bdate);
                                $('#address').val(ui.item.addr);
                                $("#gender").find('option').remove().end();
                                $("#gender").append($('<option>', {
    
                                   value: ui.item.gen,
       
                                   text: ui.item.gen,
             
                                 }));

                            }
                        });
                        
                    } else{
   
                    }     
               }
           });
       }
   });
});

</script>
