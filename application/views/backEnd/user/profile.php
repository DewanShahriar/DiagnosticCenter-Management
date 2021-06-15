

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <form action="<?php echo base_url('user/profile/update_photo') ?>" method="post" enctype="multipart/form-data">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <?php echo $user_info->firstname .' '. $user_info->lastname; ?> </h3>
                    </div>
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().$user_info->photo; ?>" alt="User profile picture" id="profile_picture_change">
                        <br>
                        <input type="file" name="photo" onchange="readpicture(this);">
                        <br>
                        <p class="text-muted text-center"><?php echo $user_info->userType; ?></p>
                        <center> <button type="submit" class="btn bg-orange btn-sm"><b><?php echo $this->lang->line('update'); ?></b></button> </center>
                    </div>
                    <!-- /.box-body -->
                </div>
            </form>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#user_info" data-toggle="tab"><?php echo $this->lang->line('user_info'); ?></a></li>
                    <li><a href="#pass_change" data-toggle="tab"><?php echo $this->lang->line('password_change'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="user_info">
                        <form class="form-horizontal" action="<?php echo base_url('user/profile/update_info') ?>"      method="post">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('first_name'); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" name="firstname" class="form-control" id="inputName" value="<?php echo $user_info->firstname ;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('last_name'); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" name="lastname" class="form-control" id="inputName" value="<?php echo $user_info->lastname ;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label"><?php echo $this->lang->line('email'); ?></label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" id="inputEmail" value="<?php echo $user_info->email ;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('user_name'); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control" id="inputName" value="<?php echo $user_info->username ;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('road_house'); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" name="roadHouse" class="form-control" id="inputName" value="<?php echo $user_info->roadHouse ;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('division'); ?></label>
                                <div class="col-sm-8">
                                    <select name="divission_id" id="division" class="form-control select2">
                                        <?php foreach ($divissions as $key => $value): ?>
                                        <option value="<?php echo $value->id; ?>"
                                            <?php if ($user_info->division_id == $value->id): ?>
                                            selected
                                            <?php endif ?>
                                            ><?php echo $value->name; ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-sm-8">
                                    <select name="zilla" id="zilla" class="form-control select2">
                                        <?php foreach ($distrcts as $key => $value): ?>
                                        <option value="<?php echo $value->id; ?>"
                                            <?php if ($user_info->zilla_id == $value->id): ?>
                                            selected
                                            <?php endif ?>
                                            ><?php echo $value->name; ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label"><?php echo $this->lang->line('upozilla'); ?></label>
                                <div class="col-sm-8">
                                    <select name="address" id="upozilla" class="form-control select2">
                                        <?php foreach ($upozilla as $key => $value): ?>
                                        <option value="<?php echo $value->id; ?>"
                                            <?php if ($user_info->address == $value->id): ?>
                                            selected
                                            <?php endif ?>
                                            ><?php echo $value->name; ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <button type="submit" class="btn btn-warning"><?php echo $this->lang->line('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="pass_change">
                        <form class="form-horizontal" action="<?php echo base_url('user/profile/update_pass') ?>" method="post">
                            <div class="form-group">
                                <label for="inputOldPass" class="col-sm-2 control-label"><?php echo $this->lang->line('old_password'); ?></label>
                                <div class="col-sm-8">
                                    <input type="password" name="old_pass" class="form-control" id="inputOldPass" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputNewPass" class="col-sm-2 control-label"><?php echo $this->lang->line('new_password'); ?></label>
                                <div class="col-sm-8">
                                    <input type="password" name="new_pass" class="form-control" id="inputNewPass" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <button type="submit" class="btn btn-warning"><?php echo $this->lang->line('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<script>
    // profile picture change
    	function readpicture(input) {
    			if (input.files && input.files[0]) {
    					var reader = new FileReader();
    
    					reader.onload = function (e) {
    						$('#profile_picture_change')
    								.attr('src', e.target.result)
    								.width(88)
    								.height(88);
    					};
    
    					reader.readAsDataURL(input.files[0]);
    			}
    	}
    
</script>
<script>
    $(document).ready(function () {
    
    		// this is for presend address change only
    		$('#division').change(function () {
    				$('#zilla').find('option').remove().end().append("<option value=''>Select District</option>");
    				$('#upozilla').find('option').remove().end().append("<option value=''>Select District First</option>");
    				loadZilla($(this).find(':selected').val() );
    		});
    
    		$('#zilla').change(function () {
    				$('#upozilla').find('option').remove().end().append("<option value=''>Select Upozilla</option>");
    				loadUpozilla($(this).find(':selected').val() );
    		});
    
    		// init the divisions
    		//loadDivision();
    
    });
    
    
    function loadDivision() {
    
    		$.post("<?php echo base_url() . "user/get_division"; ?>",
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
    		$.post("<?php echo base_url() . "user/get_zilla_from_division/"; ?>" + divisionId,
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
    		$.post("<?php echo base_url() . "user/get_upozilla_from_division_zilla/"; ?>" + zillaId,
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

