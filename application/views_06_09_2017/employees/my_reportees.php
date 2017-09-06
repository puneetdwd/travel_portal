<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            My Reportees
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">My Reportees</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                   <i class="fa fa-ban"></i>
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
                        <i class="fa fa-users"></i>My Reportees
                    </div>
                    <!--<div class="actions">
                        <a href="<?php echo base_url()."employees/add";?>" class="btn grey-cascade">
                            <i class="fa fa-plus"></i> Add new Employee
                        </a>
                    </div>-->
                </div>
                <div class="portlet-body">

                    <?php if(empty($reportees)) { ?>
                        <p class="text-center">No Employee exist yet.</p>
                    <?php } else { ?>
                        <table class="table" id="make-data-table">
                            <thead>
                                <tr>
                                    
                                    <th>Employee ID</th>
                                    <th>Employee Photo</th>
                                    <th>Name</th>
                                    <th>Official Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reportees as $reportee) { ?>
                                    <tr>
                                        
                                        <td><?php echo $reportee['empID']; ?></td>
                                        <td><img src="<?php if(!empty($reportee['image'])) echo base_url().$reportee['image']; 
                                                            else echo base_url().'assets/admin/layout/img/avatar_small.png';
                                                            ?>" height="100" width="100" />
                                        </td>
                                        <td><?php echo $reportee['reportee_name']; ?></td>
                                        <td><?php echo $reportee['gi_email']; ?></td>
                                        <td><?php echo $reportee['phone']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>