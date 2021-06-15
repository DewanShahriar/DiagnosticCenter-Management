

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('update_user'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/user_list" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('user_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/edit_user/".$userDetails[0]['id']); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                           
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('first_name'); ?></label>
                                            <input name="first_name" value="<?php echo $userDetails[0]['firstname'] ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('last_name') ?></label>
                                            <input name="last_name" value="<?php echo $userDetails[0]['lastname'] ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('user_name'); ?></label>
                                            <input name="user_name" value="<?php echo $userDetails[0]['username'] ?>" class="form-control" disabled="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('email'); ?></label>
                                            <input name="email" value="<?php echo $userDetails[0]['email'] ?>" class="form-control" disabled="" type="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('phone'); ?></label>
                                            <input name="phone" value="<?php echo $userDetails[0]['phone'] ?>" class="form-control" type="tel" pattern="[0]{1}[1]{1}[5|6|7|8|9]{1}[0-9]{8}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('password'); ?></label>
                                            <input name="password" placeholder="Password" class="form-control" type="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('division'); ?></label>
                                            <select class="form-control select2" name="divission_id" id="division" required >
                                                <?php foreach ($divissions as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"
                                                    <?php if ($value->id == $mydivision_id): ?>
                                                    selected
                                                    <?php endif ?>
                                                    ><?php echo $value->name ?>
                                                </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('district'); ?></label>
                                            <select class="form-control select2" name="district" id="zilla">
                                                <?php foreach ($distrcts as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"
                                                    <?php if ($value->id == $myzilla_id): ?>
                                                    selected
                                                    <?php endif ?>
                                                    ><?php echo $value->name ?>
                                                </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('upozilla'); ?></label>
                                            <select class="form-control select2" name="address" id="upozilla">
                                                <?php foreach ($upozilla as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"
                                                    <?php if ($value->id == $userDetails[0]['address']): ?>
                                                    selected
                                                    <?php endif ?>
                                                    ><?php echo $value->name; ?>
                                                </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('road_house'); ?></label>
                                            <input name="road_house" value="<?php echo $userDetails[0]['roadHouse'] ?>" class="form-control" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('user_type'); ?> *</label>
                                            <select class="form-control select2" name="user_type" required="" >
                                                <?php foreach ($user_type as $value): ?>
                                                <option value="<?php echo $value->value; ?>"
                                                    <?php if ($value->value == $userDetails[0]['userType']): ?>
                                                    selected
                                                    <?php endif ?>
                                                    ><?php echo $value->name ?>
                                                </option>
                                                <?php endforeach ?>
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
                                            <img id="user_picture_change" class="img-responsive" src="<?php echo base_url($userDetails[0]['photo']); ?>" alt="profile picture" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                            <br>
                                            <input type="file" name="photo" onchange="readpicture(this);">
                                        </center>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.box-body -->
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
    
    $(".select2").select2();
    
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
    $(document).ready(function () {
    
        // this is for presend address change only
        $('#division').change(function () {
            $('#zilla').find('option').remove().end().append("<option value=''>জেলা নির্বাচন করুন</option>");
            $('#upozilla').find('option').remove().end().append("<option value=''>আগে জেলা নির্বাচন করুন</option>");
            loadZilla($(this).find(':selected').val() );
        });
    
        $('#zilla').change(function () {
            $('#upozilla').find('option').remove().end().append("<option value=''>উপজেলা নির্বাচন করুন</option>");
            loadUpozilla($(this).find(':selected').val() );
        });
    
        // init the divisions
        loadDivision();
    
    });
    
    
    function loadDivision() {
    
        $.post("<?php echo base_url() . "admin/get_division"; ?>",
                {'asd': 'asd'},
                function (data2) {
    
                    var data = JSON.parse(data2);
                    $.each(data, function () {
    
                        $("#division").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });
    
                });
    }
    
    function loadZilla(divisionId) {
        $.post("<?php echo base_url() . "admin/get_zilla_from_division/"; ?>" + divisionId,
                {'nothing': 'nothing'},
                function (data2) {
                    var data = JSON.parse(data2);
                    $.each(data, function (i, item) {
    
                        $("#zilla").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });
                });
    
    }
    function loadUpozilla(zillaId) {
        $.post("<?php echo base_url() . "admin/get_upozilla_from_division_zilla/"; ?>" + zillaId,
                {'nothing': 'nothing'},
                function (data2) {
                    var data = JSON.parse(data2);
                    $.each(data, function (i, item) {
    
                        $("#upozilla").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });
                });
    }
    
    
</script>

