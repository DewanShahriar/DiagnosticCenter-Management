<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line("page_settings_add"); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url("admin/page_settings/list"); ?>" class="btn btn-sm bg-red" style="color: white; "><i class="fa fa-list"></i> <?php echo $this->lang->line('page_settings_list') ?> </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form action="<?php echo base_url("admin/page_settings/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="title_one"><?php echo $this->lang->line("name"); ?></label>
                                    <input id="name" type="text" name="name" class="form-control" placeholder="<?php echo $this->lang->line("name"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="title_one"><?php echo $this->lang->line("title"); ?></label>
                                    <input id="title" type="text" name="title" class="form-control" placeholder="<?php echo $this->lang->line("title"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="title_one"><?php echo $this->lang->line("priority"); ?></label>
                                    <small style="color: gray"><?php echo $this->lang->line("sorting_will_be_max_to_min"); ?></small>
                                    <input id="priority" type="number" name="priority" class="form-control" placeholder="<?php echo $this->lang->line("priority"); ?>" required min="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="title_one"><?php echo $this->lang->line("is_menu"); ?></label>
                                    <select name="is_menu" id="" class="form-control select2" style="widows: 100%;">
                                        <option value="1"><?php echo $this->lang->line("yes"); ?></option>
                                        <option value="0"><?php echo $this->lang->line("no"); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="title_one"><?php echo $this->lang->line("parent_page"); ?></label>
                                    <select name="parent_page_id" id=""  class="form-control select2" style="widows: 100%;">
                                        <option value=""><?php echo $this->lang->line("select_one"); ?></option>
                                        <?php if ($page_settings) {
                                                foreach ($page_settings as $key => $value) { ?>
                                        <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <center>
                                        <label for="old_photo"><?php echo $this->lang->line("file"); ?></label><br>
                                        <img style="height:80px; width:80px;" src="//placehold.it/400x400" id="old_photo"><br>
                                        <input id="photo" type="file" name="attatched" onchange="readpicture(this)">
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <div class="col-sm-12">
                                        <label for="body"><?php echo $this->lang->line("body"); ?></label>
                                    <textarea id="body" name="body" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <center>
                                <button type="reset" class="btn btn-sm bg-red"><?php echo $this->lang->line("cancel"); ?></button>
                                <button type="submit" class="btn btn-sm bg-green "><?php echo $this->lang->line("save"); ?></button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    CKEDITOR.replace('body');
</script>

<script>
    // profile picture change
    function readpicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#old_photo')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>