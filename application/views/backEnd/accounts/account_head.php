<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('account_head'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <?php if(isset($edit_info)){ ?>
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #c99568; margin: 10px 30px 40px 25px; padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('accounts/account-head/edit/'.$edit_info->id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('account_head'); ?> *</label>
                                            <input name="account_head" class="form-control inner_shadow_orange" placeholder="<?php echo $this->lang->line('account_head'); ?>" required="" type="text" value="<?php echo $edit_info->account_head; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('accounts_type'); ?> *</label>
                                            <select name="accounts_type" id="" class="form-control select2 inner_shadow_orange" required="">
                                                <option value="1" <?php if ($edit_info->accounts_type == 1) echo 'selected' ; ?> > <?php echo $this->lang->line('income'); ?> </option>
                                                <option value="0" <?php if ($edit_info->accounts_type == 0) echo 'selected' ; ?> > <?php echo $this->lang->line('expense'); ?> </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('editable'); ?> *</label>
                                            <select name="readonly" id="" class="form-control select2 inner_shadow_orange" required="">
                                                <option value="0" <?php if ($edit_info->readonly == 0) echo 'selected' ; ?> > <?php echo $this->lang->line('yes'); ?> </option>
                                                <option value="1" <?php if ($edit_info->readonly == 1) echo 'selected' ; ?> > <?php echo $this->lang->line('no'); ?> </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn bg-orange"> <?php echo $this->lang->line('update'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php } else {?>
                    <div class="row" style="box-shadow: 1px 1px 15px 5px #3c8dbc;margin: 10px 30px 40px 25px;padding: 30px 0px 30px 0px;">
                        <form action="<?php echo base_url('accounts/account-head/add') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('account_head'); ?> *</label>
                                            <input name="account_head" class="form-control" placeholder="<?php echo $this->lang->line('account_head'); ?>" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('accounts_type'); ?> *</label>
                                            <select name="accounts_type" id="" class="form-control select2" required="">
                                                <option value=""><?php echo $this->lang->line('select_accounts_type'); ?></option>
                                                <option value="1"><?php echo $this->lang->line('income'); ?></option>
                                                <option value="0"><?php echo $this->lang->line('expense'); ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <?php echo $this->lang->line('editable'); ?> *</label>
                                            <select name="readonly" id="" class="form-control select2" required="">
                                                
                                                <option value="0" selected=""><?php echo $this->lang->line('yes'); ?></option>
                                                <option value="1"><?php echo $this->lang->line('no'); ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label> <br> </label>
                                            <button type="submit" class="form-control btn bg-orange"> <?php echo $this->lang->line('save'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#income" data-toggle="tab"><?php echo $this->lang->line('income'); ?></a></li>
                                    <li><a href="#expense" data-toggle="tab"><?php echo $this->lang->line('expense'); ?></a></li>
                                    
                                </ul>
                                <br>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="income">
                                        <table id="userListTable" class="table table-bordered table-striped table_th_orange">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; "><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 45%; "><?php echo $this->lang->line('name'); ?></th>
                                                    <th style="width: 35%; "><?php echo $this->lang->line('accounts_type'); ?></th>
                                                    
                                                    <th style="width: 15%; "><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sl = 1;
                                                    foreach ($account_head as $key => $value) {
                                                        
                                                        if ($value->accounts_type == 1) {
                                                        ?>
                                                <tr>
                                                    <td> <?= $sl++; ?> </td>
                                                    <td> <?= $value->account_head ; ?> </td>
                                                    <td> <?php if ($value->accounts_type == 1 ) {
                                                        echo "Cash In";
                                                    } ?> </td>
                                                    
                                                    <td>
                                                        <a href="<?= base_url('accounts/account-head/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                                        <?php if($value->readonly == 0){?>
                                                        <a href="<?= base_url('accounts/account-head/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                                    <?php }?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    } }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="expense">
                                        <table id="userListTable2" class="table table-bordered table-striped table_th_orange">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; "><?php echo $this->lang->line('sl'); ?></th>
                                                    <th style="width: 45%; "><?php echo $this->lang->line('name'); ?></th>
                                                    <th style="width: 35%; "><?php echo $this->lang->line('accounts_type'); ?></th>
                                                    
                                                    <th style="width: 15%; "><?php echo $this->lang->line('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sl = 1;
                                                    foreach ($account_head as $key => $value) {
                                                         
                                                        if ($value->accounts_type == 0) {
                                                        ?>
                                                <tr>
                                                    <td> <?= $sl++; ?> </td>
                                                    <td> <?= $value->account_head ; ?> </td>
                                                    <td> <?php if ($value->accounts_type == 0 ) {
                                                        echo "Expense";
                                                    } ?> </td>
                                                    
                                                    <td>
                                                        <a href="<?= base_url('accounts/account-head/edit/'.$value->id); ?>" class="btn btn-sm bg-green"> <i class="fa fa-edit"></i> </a>
                                                        <?php if($value->readonly == 0){?>
                                                        <a href="<?= base_url('accounts/account-head/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-orange"> <i class="fa fa-trash"></i> </a>
                                                    <?php }?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    } }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        
                            
                        </div>
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
      $("#userListTable2").DataTable();
      $("#userListTable3").DataTable();
    });
    
</script>

