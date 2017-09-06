<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Timesheet Drop Downs
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Timesheet Drop Down</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                   <i class="fa fa-times"></i>
                   <?php echo $this->session->flashdata('error');?>
                </div>
            <?php } else if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                   <?php echo $this->session->flashdata('success');?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i> Timesheet Drop Down
                    </div>
                    <div class="actions">
                        <a class="btn grey-cascade" href="<?php echo base_url()."work/update_timesheet_drop_downs"; ?>">
                            <i class="fa fa-plus"></i> Add New Timesheet Drop Down
                        </a>
                        
                    </div>
                </div>
                <div class="portlet-body">
                    
                        <table class="table" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Drop Down Name</th>
                                    <th>Drop Down List</th>
                                    <th class="no_sort" style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($drop_downs as $drop_down) { ?>
                                    <tr>
                                        <td><?php echo $drop_down['drop_down_name']; ?></td>
                                        <td><?php echo $drop_down['drop_down_list']; ?></td>
                                        <td nowrap> 
                                            <a class="btn btn-xs purple" 
                                                href="<?php echo base_url().'work/update_timesheet_drop_downs/'.$drop_down['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn default btn-xs red"  onclick="return confirm('You really want to delete this ?');"
                                                    href="<?php echo base_url()."work/delete_drop_down_list/".$drop_down['id'];?>">
                                                    <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
				<?php } ?>
                            </tbody>
                        </table>
                    
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>