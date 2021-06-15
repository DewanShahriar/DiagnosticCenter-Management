<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('patient_edit'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/patient/list" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('patient_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/patient/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('patient_name'); ?></label>
                                            <input name="patient_name" placeholder="<?php echo $this->lang->line('patient_name'); ?>" class="form-control" required="" type="text" value="<?= $edit_info->patient_name;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('patient_phone'); ?></label>
                                            <input name="patient_phone" placeholder="<?php echo $this->lang->line('patient_phone'); ?>" class="form-control" type="tel" pattern="[0]{1}[1]{1}[3|4|5|6|7|8|9]{1}[0-9]{8}" value="<?= $edit_info->patient_phone;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('father_name'); ?></label>
                                            <input name="father_name" placeholder="<?php echo $this->lang->line('father_name'); ?>" class="form-control" required="" type="text" value="<?= $edit_info->father_name;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('mother_name'); ?></label>
                                            <input name="mother_name" placeholder="<?php echo $this->lang->line('mother_name'); ?>" class="form-control" required="" type="text" value="<?= $edit_info->mother_name;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('patient_nid'); ?></label>
                                            <input name="patient_nid" placeholder="<?php echo $this->lang->line('patient_nid'); ?>" class="form-control" required="" type="text" value="<?= $edit_info->patient_nid;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('birth_date'); ?></label>
                                            <input name="birth_date" placeholder="<?php echo $this->lang->line('birth_date'); ?>" class="form-control date" required="" type="text" value="<?= date('d M Y', strtotime($edit_info->birth_date));?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('address'); ?></label>
                                            <input name="address" placeholder="<?php echo $this->lang->line('address'); ?>" class="form-control" required="" type="text" value="<?= $edit_info->address;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('gender'); ?></label>
                                            <select name="gender" class="form-control select2" style="width:100%">
                                                <option value=""><?php echo $this->lang->line('select_gender'); ?></option>
                                                <option value="male" <?php if($edit_info->gender == 'male') echo "selected";?>><?php echo $this->lang->line('male'); ?></option>
                                                <option value="female" <?php if($edit_info->gender == 'female') echo "selected";?>><?php echo $this->lang->line('female'); ?></option>
                                                <option value="other" <?php if($edit_info->gender == 'other') echo "selected";?>><?php echo $this->lang->line('other'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-danger box-solid">
                                    <div class="box-header"> <label> <?php echo $this->lang->line('user_photo'); ?> </label> </div>
                                    <div class="box-body box-profile">
                                        <center>
                                            <img id="user_picture_change" class="img-responsive" src="<?php echo base_url($edit_info->photo);?>" alt="profile picture" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                            <br>
                                            <input type="file" name="photo" onchange="readpicture(this);">
                                        </center>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red"><?php echo $this->lang->line('reset') ?></button>
                                    <button type="submit" class="btn btn-sm bg-green"><?php echo $this->lang->line('update') ?></button>
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
<script type="text/javascript" >
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
</script>
<script>
    // profile picture change
    function readpicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#user_picture_change')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>

<script>
    
    $(function(){

        $('.date').datepicker({

            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd-mm-yy",
            yearRange: "-70:+10"
        });

        $('.timepicker').timepicker({
            
            showInputs: false
        });

    });
</script>


