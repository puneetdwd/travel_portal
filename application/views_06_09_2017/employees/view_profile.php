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
            <li class="active">View Profile</li>
        </ol>

    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light borderLight">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="form-section">Basic Info </h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Employee ID</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp">:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['empID']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Email (Official)</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp" >:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['gi_email']; ?>
                                            </p>
                                        </div>
                                    </div>

                                    <!--/span-->
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Department</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp" >:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['dept_name']); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Grade</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp" >:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['grade_name']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Mobile Number</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp">:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['phone']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Date of Birth</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp">:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo date('jS M, Y', strtotime($employee['dob'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">City</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp">:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['city_name']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Cost Center</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp" >:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['cost_center']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Reporting Manager</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp" >:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['reporting_manager']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-xs-4 col-md-offset-1 text-left-imp">Last Login</label>
                                        <label class="control-label col-md-1 col-xs-1 text-center-imp" >:</label>
                                        <div class="col-md-6 col-xs-6">
                                            <p class="form-control-static">
                                                <?php echo date(DATETIME_FORMAT,strtotime($this->session->userdata('last_login'))); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 table-scrollable">
                                    <h4 class="form-section">My Policy</h4>
                                    <!--<table class="table table-bordered table-responsive" id="make-data-table">-->
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Mode of Travel</th>
                                                <th>Travel class</th>
                                                <th>Transport</th>
                                                <th colspan="3">City Class(A)</th>                                                
                                                <th colspan="3">City Class(B)</th>                                                
                                                <th colspan="3">City Class(C)</th>                                                
                                            </tr>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th>Hotel</th>
                                                <th>DA</th>
                                                <th>Con</th>
                                                <th>Hotel</th>
                                                <th>DA</th>
                                                <th>Con</th>
                                                <th>Hotel</th>
                                                <th>DA</th>
                                                <th>Con</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($emp_policy as $key => $value) { ?>
                                                <tr>
                                                    <td><?PHP echo $value['grade_name'] ?></td>
                                                    <td><?PHP echo $value['name'] ?></td>
                                                    <td><?PHP echo $value['travel_class'] ?></td>
                                                    <td><?PHP echo $value['transport'] ?></td>
                                                    <td><?PHP if(isset($value['hotel']['A'])) echo $value['hotel']['A']; ?></td>
                                                    <td><?PHP if(isset($value['DA']['A']))  echo $value['DA']['A'] ?></td>
                                                    <td><?PHP if(isset($value['DC']['A']))  echo $value['DC']['A'] ?></td>
                                                    <td><?PHP if(isset($value['hotel']['B']))  echo $value['hotel']['B'] ?></td>
                                                    <td><?PHP if(isset($value['DA']['B']))  echo $value['DA']['B'] ?></td>
                                                    <td><?PHP if(isset($value['DC']['B']))  echo $value['DC']['B'] ?></td>
                                                    <td><?PHP if(isset($value['hotel']['C']))  echo $value['hotel']['C'] ?></td>
                                                    <td><?PHP if(isset($value['DA']['C']))  echo $value['DA']['C'] ?></td>
                                                    <td><?PHP if(isset($value['DC']['C']))  echo $value['DC']['C'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--END FORM-->
                </div>
            </div>

        </div>
    </div>
    <!--END PAGE CONTENT-->
</div>