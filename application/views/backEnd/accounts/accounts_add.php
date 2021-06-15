<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_add'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>accounts/accounts/list" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('account_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url('accounts/accounts/add') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('accounts_date'); ?> </label>
                                            <input name="accounts_date" id="accounts_date" class="form-control inner_shadow_purple date" placeholder="<?php echo $this->lang->line('accounts_date'); ?>" required="" type="text" autocomplete="off"  value="<?= date('d-m-Y'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('accounts_type'); ?> *</label>
                                            <select id="accounts_type" name="accounts_type" id="" class="form-control select2" required="" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_accounts_type'); ?></option>
                                                <option value="1"><?php echo $this->lang->line('income'); ?></option>
                                                <option value="0"><?php echo $this->lang->line('expense'); ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped table_th_primary" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 30%;"><?php echo $this->lang->line('account_head'); ?></th>
                                                    
                                                    <th style="width: 25%;"><?php echo $this->lang->line('description'); ?></th>
                                                    <th style="width: 20%;"><?php echo $this->lang->line('quantity'); ?></th>
                                                    
                                                    <th style="width: 20%;"><?php echo $this->lang->line('amount'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="showrowid" id="showrowid" value="10">
                                                <?php
                                                    // 61 is the max limit, change to javascript also from botom of the code.
                                                    
                                                    for ($i=1; $i < 21 ; $i++) { ?>
                                                <tr id="trid<?= $i; ?>" style="<?php if($i > 10) echo 'display: none'; ?>">
                                                    <td><?php echo $i; ?></td>
                                                    
                                                    <td>
                                                        <select name="accounts_type_id[]" id="accounts_type_id<?= $i; ?>" class="form-control select2" style="width:100%">
                                                            <option value=""><?php echo $this->lang->line('select_accounts_head'); ?></option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="description[]" id="" class="form-control inner_shadow_purple" cols="" rows="1"></textarea> 
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control inner_shadow_purple numberconvert" name="quantity[]" value="0" min="0" id="quantity<?= $i; ?>" placeholder="<?php echo $this->lang->line('quantity'); ?>" >
                                                    </td>
                                                    
                                                    <td>
                                                        <input type="number" step="0.001" class="form-control inner_shadow_purple numberconvert" name="amount[]" value="0" id="amount<?= $i; ?>" min="0" placeholder="<?php echo $this->lang->line('amount'); ?>" onkeyup="amountshow(<?= $i; ?>)">
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"><?php echo $this->lang->line('total') ?>: </td>
                                                    <td>
                                                        <input type="text" readonly name="total_amount" id="total_amount" style="border: none;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="col-sm-12">
                                <center>
                                    <a href="<?php echo current_url(); ?>" class="btn bg-purple"><?php echo $this->lang->line('reset') ?></a>
                                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save') ?></button>
                                    <a class="btn btn-info" onclick="makerowvisible();"><i class="fa fa-plus"></i> </a>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class=" box-footer">
                </div>
                <!-- /.box-footer --> 
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</section>
<script type="text/javascript">
    $(function () {
    
      $("#userListTable").DataTable();
    
    });
    
    
    
</script>
<script>
    $(function () {
    
        $('.date').datepicker({
    
            autoclose: true,
    
            changeYear:true,
    
            changeMonth:true,
    
            dateFormat: "dd-mm-yy",
    
            yearRange: "-100:+5"
    
        });
    
    });
    
    $(".numberconvert").keypress(function(event){
    
        var ew = event.which;
    
        if(ew == 32) return true;
    
        if(48 <= ew && ew <= 57) return true;
    
        if(2534 <= ew && ew <= 2543){
    
            return false;
    
        }
    
        if(97 <= ew && ew <= 122) return false;
    
    
        //return false;
      
    });
    
</script>

<script>
    function amountshow(id) {
    
        var amount =  $('#amount'+id).val(); 
    
        var total_amount = 0;
    
        // same as php for loop from up.
    
        for(var i = 1; i < 21; i++){
    
            var tempamount = $('#amount'+i).val();
            total_amount+= Number(tempamount);
        }
    
        $('#total_amount').val(total_amount);
    }
    
    function makerowvisible(){
        
        var nextrownumber = $("#showrowid").val();
        $("#trid"+Number(nextrownumber)).show();
        $("#showrowid").val(Number(nextrownumber)+1);
    }
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        $("#accounts_type").change(function(){
            var type = $("#accounts_type").val();
            $.post("<?php echo base_url() . "accounts/get_accounts_head_type/"; ?>" + type,
            {'nothing': 'nothing'},
            function (res) {
                var data = JSON.parse(res);
                
                for(var i = 1; i < 21; i++){
                    $("#accounts_type_id"+i).find('option').remove().end();
                    $.each(data, function (key, item) {
                        
                        $("#accounts_type_id"+i).append($('<option>', {
    
                                value: this.id,
    
                                text: this.account_head,
    
                        }));
    
                    });
                }
                
            });
        });
    });
</script>