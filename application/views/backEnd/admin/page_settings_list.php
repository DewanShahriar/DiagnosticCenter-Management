<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success box-solid">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $this->lang->line("page_settings_list"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url("admin/page_settings/add"); ?>" class="btn btn-sm bg-red" style="color: white; "><i class="fa fa-plus"></i> <?php echo $this->lang->line('page_settings_add') ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    

                    <table class="table table-bordered table-striped table_th_success">
                        <thead>
                            <tr>
                                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 5%;"><?php echo $this->lang->line("sl"); ?> </th>
                                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 15%;"><?php echo $this->lang->line("name"); ?> </th>
                                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 25%;"><?php echo $this->lang->line("title"); ?></th>
                                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 45%;"><?php echo $this->lang->line("body"); ?></th>
                                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 10%;"><?php echo $this->lang->line("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                            foreach ($table_info as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $value['name']; ?></td>
                                    <td><?php echo $value['title']; ?></td>
                                    <td><?php echo character_limiter(strip_tags($value['body']), 100); ?></td>
                                    <td>
                                        <a href="<?php echo base_url() . 'admin/page_settings/edit/' . $value['id']; ?>" class="btn btn-sm bg-green"><i class="fa fa-edit"></i></a>

                                        <a href="<?php echo base_url() . 'admin/page_settings/delete/' . $value['id']; ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                    </td>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>


</section>

<script type="text/javascript">
    $(function () {
        $("#userListTable").DataTable();
    });

</script>