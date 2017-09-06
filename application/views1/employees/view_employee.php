<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View <?php echo ucwords($employee['first_name']) . ' ' . ucwords($employee['last_name']); ?>'s Details
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <h4 class="form-section">Basic Info</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Employee ID</label>
                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo $employee['employee_id']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Email (Official)</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo $employee['gi_email']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Cost Center</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['cost_center']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Grade</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['grade_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Reporting Manager</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['reporting_manager']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">EA of Reporting Manager</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['ea_manager']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Designation</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['desg_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Department</label>
                                    <label class="control-label col-md-1 text-center-imp" >:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['dept_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <h4 class="form-section">Personal Info</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">First Name</label>
                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['first_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Last Name</label>
                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo ucwords($employee['last_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Gender</label>
                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo $employee['gender']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Date of Birth</label>
                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo date('jS M, Y', strtotime($employee['dob'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Mobile Number</label>
                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo $employee['phone']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">City</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['l_city']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">State</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['l_state']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Country</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['l_country']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Post Code</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['l_post_code']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a href="<?php echo base_url() . 'employees'; ?>" class="btn default">
                                            <i class="m-icon-swapleft"></i> Back 
                                        </a>
                                        <?php if ($this->session->userdata('type') == 'admin') { ?>
                                            <a class="btn purple-plum" 
                                               href="<?php echo base_url() . "employees/add/" . $employee['empID']; ?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-warning" data-confirm="Are you sure you want to mark this employee as <?php echo $employee['status'] == 'active' ? 'inactive' : 'active'; ?>?"
                                               href="<?php echo base_url() . "employees/status/" . $employee['empID'] . '/' . ($employee['status'] == 'active' ? 'inactive' : 'active' ) . '/view'; ?>">
                                                <i class="fa fa-retweet"></i> <?php echo $employee['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <!-- END FORM-->
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>