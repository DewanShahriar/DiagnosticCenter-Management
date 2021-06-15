<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title"><?php echo $this->lang->line('test_payment_edit'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/test-payment/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('test_payment_list'); ?>  </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/test-payment/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('paid_date'); ?>*</label>
                                            <input name="paid_date" placeholder="<?php echo $this->lang->line('paid_date'); ?> " class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required value="<?= $edit_info->paid_date
                                            ;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('patient_name'); ?>*</label>
                                            <select class="form-control inner_shadow_primary select2" name="patient_id" id="patient_id" required="" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_patient'); ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('test'); ?>*</label>
                                            <select class="form-control inner_shadow_primary select2" name="tests_id" id="tests_id" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('select_patient_first'); ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('paid_amount'); ?></label>
                                            <input name="paid_amount" placeholder="<?php echo $this->lang->line('paid_amount'); ?> " class="form-control inner_shadow_primary"  type="text" autocomplete="off" required value="<?= $edit_info->paid_amount?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('approved_status'); ?>*</label>
                                            <select class="form-control inner_shadow_primary select2" name="payment_approved" id="payment_approved" style="width: 100%;">
                                                <option value="1" <?php if($edit_info->payment_approved == 1) echo "selected"?>><?php echo $this->lang->line('approved'); ?></option>
                                                <option value="0" <?php if($edit_info->payment_approved == 0) echo "selected"?>><?php echo $this->lang->line('unapproved'); ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                            <div class="col-md-12">
                                <br>
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('update'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
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
    
    $(document).ready(function () {
    
        $('#patient_id').change(function () {
            $('#tests_id').find('option').remove().end().append("<option value=''>Select Test</option>");
            loadTests($(this).find(':selected').val() );
        });
    
        loadPatients();
    
    });
    
    
    function loadPatients() {

        var selected_patient = "<?= $edit_info->patient_id; ?>";
    
        $.post("<?php echo base_url() . "admin/get_patients_data"; ?>",
                {'asd': 'asd'},
                function (data2) {
    
                    var data = JSON.parse(data2);
                    $.each(data, function () {
    
                        $("#patient_id").append($('<option>', {
                            value: this.id,
                            text: this.patient_name+'('+this.patient_phone+')',
                        }));

                        if(this.id == selected_patient) {
                            $("#patient_id option[value='" + selected_patient + "']").attr("selected", true);
                        }
                    });
    
                });
        loadTests(selected_patient);
    }
    
    function loadTests(patient_id) {
        var selected_test = "<?= $edit_info->tests_id; ?>";
        console.log(selected_test);
        $.post("<?php echo base_url() . "admin/get_tests_data/"; ?>" + patient_id,
                {'nothing': 'nothing'},
                function (data2) {
                    var data = JSON.parse(data2);
                    $.each(data, function (i, item) {
    
                        $("#tests_id").append($('<option>', {
                            value: this.id,
                            text: this.invoice_number,
                        }));

                        if(this.id == selected_test) {
                            $("#tests_id option[value='" + selected_test + "']").attr("selected", true);
                        }
                    });
                });
    
    }
    
</script>
