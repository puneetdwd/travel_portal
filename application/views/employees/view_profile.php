<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            My Profile
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <!--<li>
                <a href="<?php echo base_url() . "employees"; ?>">
                    Employees
                </a>
            </li>-->
            <li class="active">View Profile</li>
        </ol>

    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <!--                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i> 
                                    </div>
                                     
                                    <div style="float:right">
                                        
                                            <a class="btn purple-plum" 
                                                    href="<?php echo base_url() . "employees/update_profile"; ?>">
                                                    <i class="fa fa-edit"></i> Update Profile
                                                </a>
                                    </div>
                                </div>-->
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="form-section">Basic Info </h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Employee ID</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['empID']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Email (Official)</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['gi_email']; ?>
                                            </p>
                                        </div>
                                    </div>

                                    <!--/span-->
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Department</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['dept_name']); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Grade</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['grade_name']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Mobile Number</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['phone']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Date of Birth</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo date('jS M, Y', strtotime($employee['dob'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">City</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['l_city']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Cost Center</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['cost_center']); ?>
                                            </p>
                                        </div>
                                    </div>
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
                                    <h4 class="form-section">My Policy</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Mode of Travel</th>
                                                <th>Transport</th>
                                                <th>City Class(A)</th>                                                
                                                <th>City Class(B)</th>                                                
                                                <th>City Class(C)</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>M4</td>
                                                <td>Train</td>
                                                <td>Car</td>
                                                <td>100</td>
                                                <td>500</td>
                                                <td>700</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>