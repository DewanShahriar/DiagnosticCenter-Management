<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("patient_list"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/patient/add') ?>" class="btn bg-green btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line("patient_add");?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_maroon">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('photo'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('patient_name'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('father_name'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('mother_name'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('patient_phone'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('patient_nid'); ?></th>
                                <th style="width: 5%;"><?php echo $this->lang->line('gender'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($patient_list as $key => $value) {
                                	?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td>
                                    <img src="<?php echo base_url($value->photo);?>" alt="image" width="30px" height="30px">
                                </td>
                                <td> <?php echo $value->patient_name ; ?> </td>
                                <td> <?php echo $value->father_name; ?> </td>
                                <td> <?php echo $value->mother_name ; ?> </td>
                                <td> <?php echo $value->patient_phone ; ?> </td>
                                <td> <?php echo $value->patient_nid; ?> </td>
                                <td> <?php echo $value->gender; ?> </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/patient/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/patient/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                </td>
                                
                                
                            </tr>
                            <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
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

