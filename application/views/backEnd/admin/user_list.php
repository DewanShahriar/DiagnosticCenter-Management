<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("user_list"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/add_user') ?>" class="btn bg-green btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line("add_user");?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_maroon">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('sl'); ?></th>
                                <th><?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('email'); ?></th>
                                <th><?php echo $this->lang->line('phone'); ?></th>
                                <th><?php echo $this->lang->line('address'); ?></th>
                                <th><?php echo $this->lang->line('user_type'); ?></th>
                                <th><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($myUsers as $key => $value) {
                                	?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td> <?php echo $value['firstname'].' '.$value['lastname'] ; ?> </td>
                                <td> <?php echo $value['email'] ; ?> </td>
                                <td> <?php echo $value['phone'] ; ?> </td>
                                <td> <?php 
                                    echo $value['roadHouse'];
                                         	echo ", ".$this->db->get_where('tbl_upozilla',array('id'=>$value['address']))->row()->name; 
                                         	echo ", ".$this->db->get_where('tbl_zilla',array('id'=>$this->db->get_where('tbl_upozilla',array('id'=>$value['address']))->row()->zilla_id))->row()->name;
                                         	echo ", ".$this->db->get_where('tbl_divission',array('id'=>$this->db->get_where('tbl_upozilla',array('id'=>$value['address']))->row()->division_id))->row()->name; 
                                     ?> </td>
                                <td> <?php echo $value['userType'] ; ?> </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default"><?php echo $this->lang->line('action'); ?></button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?php echo base_url().'admin/edit_user/'.$value['id'] ;?>"><?php echo $this->lang->line('update'); ?></a></li>
                                            <li><a href="<?php echo base_url().'admin/suspend_user/'.$value['id'].'/'. abs($value['status']-1) ;?>"> <?php echo $value['status'] == 0 ? $this->lang->line('active'):$this->lang->line('suspend'); ?> </a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url().'admin/delete_user/'.$value['id'] ;?>" onclick="return confirm('Are you sure?')" ><?php echo $this->lang->line('delete'); ?></a></li>
                                        </ul>
                                    </div>
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

