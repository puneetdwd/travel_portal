<br>
<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Roles
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Roles</li>
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
            <?php } else if($this->session->flashdata('info')) { ?>
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i>
                   <?php echo $this->session->flashdata('info');?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Roles
                    </div>
                    <div class="actions">
                        <a class="btn grey-cascade" href="<?php echo base_url()."roles/add_roles"; ?>">
                            <i class="fa fa-plus"></i> Add New Roles
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    
                        <table class="table" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Roles</th>
                                    <th class="no_sort" style="width:150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($roles as $role) { ?>
                                    <tr>
                                        <td><?php echo  $role['roles_name']; ?></td>
                                    	
                                        <td nowrap>
                                            <a class="btn btn-xs purple" 
                                                href="<?php echo base_url().'roles/add_roles/'.$role['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                             <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Role as <?php echo $role['status'] == 'active' ? 'inactive' : 'active';?> ?');"
                                                href="<?php echo base_url()."roles/status/".$role['id'].'/'.($role['status'] == 'active' ? 'inactive' : 'active' );?>">
                                                <i class="fa fa-retweet"></i> <?php echo $role['status'] == 'active' ? 'Mark Inactive' : 'Mark Active';?>
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