<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-3"></div>
            <disv class="col-lg-6">
                <!-- Horizontal Form -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('update_theme'); ?>  </h3>
                        <!-- <div class="box-tools pull-right">
                            <a href="<?php echo base_url() ?>admin/theme_setting" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('testimonial_list'); ?>  </a>
                        </div> -->
                    </div>
                    <div class="box-body">
                        
                        <!-- <div class="row"> -->
                            <form action="<?php echo base_url("admin/theme_setting");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('long_title'); ?> </label>
                                                <input name="long_title" placeholder="<?php echo $this->lang->line('long_title'); ?> " class="form-control inner_shadow_teal" required="" type="text"value="<?php echo $theme_data['long_title']; ?>" >
                                                <span><small style="color: gray">Not more then 35 character</small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('short_title'); ?> </label>
                                                <input name="short_title" placeholder="<?php echo $this->lang->line('short_title'); ?> " class="form-control inner_shadow_teal" required="" type="text"value="<?php echo $theme_data['short_title']; ?>">
                                                <span><small style="color: gray">Short Title</small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('tagline'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_max_to_min'); ?></small>
                                                <textarea name="tagline" id="" rows="3" class="form-control inner_shadow_teal"><?php echo $theme_data['tagline']; ?></textarea>
                                                <span><small style="color: gray">Place comma ceperated line</small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('share_title'); ?></label>
                                                <input name="share_title" placeholder="<?php echo $this->lang->line('share_title'); ?> " class="form-control inner_shadow_teal" required="" type="text"value="<?php echo $theme_data['share_title']; ?>">
                                                <span><small style="color: gray">Share Title</small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('version'); ?></label>
                                                <input name="version" placeholder="<?php echo $this->lang->line('version'); ?>" class="form-control inner_shadow_teal" required="" type="number"value="<?php echo $theme_data['version']; ?>">
                                                <span><small style="color: gray">Version</small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label><?php echo $this->lang->line('organization'); ?></label>
                                                <input name="organization" placeholder="<?php echo $this->lang->line('organization'); ?>" class="form-control inner_shadow_teal" required="" type="text"value="<?php echo $theme_data['organization']; ?>">
                                                <span><small style="color: gray">Must be a valid name</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <center>
                                            <div class="col-md-6">
                                                <label class="col-sm-6" style= "padding-top: 50px; padding-right: 0px;"><?php echo $this->lang->line('logo'); ?></label>

                                                
                                                <input  style= "padding-left: 25px;" type="file" name="logo" onchange="readlogo(this);">
                                                <small style="color: gray; padding-right: 0 px; ">width : 300px, Height : 300px</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <img id="theme_logo_change" class="img-responsive" src="<?php echo base_url ($theme_data['logo']); ?>" alt="logo" style="max-width: 120px;">
                                                </div>
                                                <br> 
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <center>
                                            <div class="col-md-6 " >
                                                <label class="col-sm-6" style= "padding-top: 50px;"><?php echo $this->lang->line('share_banner'); ?></label>
                                                
                                                <input  style= "padding-left: 25px;" type="file" name="share_banner" onchange="readbanner(this);">
                                                <small style="color: gray; padding-right: 0px;">width : 600px, Height : 315px</small>
                                                </div>                                            
                                                <div class="col-md-6">
                                                    <img id="theme_banner_change" class="img-responsive" src="<?php echo base_url ($theme_data['share_banner']); ?>" alt="Share Banner" style="max-width: 120px;">
                                                </div>
                                                <br> 
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('update'); ?></button>
                                    </center>
                                </div>
                            </form>
                        <!-- </div> -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (6) -->
            <div class="col-lg-3"></div>
        </div>
    </div>
</section>
<script>
    // profile picture change
    function readlogo(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#theme_logo_change')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>

<script>
    // profile picture change
    function readbanner(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#theme_banner_change')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>