<html>
    <head>
        <link href="http://intra.crgroup.co.in/assets/admin/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="http://intra.crgroup.co.in/assets/admin/css/custom.css" rel="stylesheet" type="text/css"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        
        <style>
            hr{
                margin-top:-8px;
            }
            h4,p,label{
                font-size:11px;
            }
             .form-group{
                margin-top:-15px;
            }
        </style>
    </head>
    <body>
        <div class="page-content" style="margin-left:30px; margin-right:30px;margin-top:20px" >
            <div class="row">
                <div class="portlet-body form">
                    <div class="form-body">
                            <header>
                               <img src="http://intra.crgroup.co.in/assets/images/logo.png" alt="logo" class="logo-default" />
                            </header>
                    </div>
             <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <h4>Basic Info</h4><hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Employee ID</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['empID']; ?>
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
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Department</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['dept_name']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Sub-Department</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['sub_dept']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                             </div>
							<div class="row">
                                <!--/span-->
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
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Designation Band</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['band']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="row"> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Reporting Person</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['reporting_person']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Location</label>
                                        <label class="control-label col-md-1 text-center-imp" >:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['location']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
							</div>
								
                            <h4 class="form-section">Personal Info</h4><hr>
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
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Middle Name</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['middle_name']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Father's Name</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo ucwords($employee['father_name']); ?>
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
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Blood Group</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['blood_group']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Personal Email</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['email']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            
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
                            </div>
                            <div class="row">  
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Emergency Contact</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['emergency_phone']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Additional Emergency Contact</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['emergency_phone2']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">     
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Date of Birth</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                 <?php echo date('jS M, Y',  strtotime($employee['dob']) ); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Date of Joining</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                 <?php echo date('jS M, Y',  strtotime($employee['doj']) ); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <h4 class="form-section">Local Address</h4><hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Address 1</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['l_address1']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Address 2</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['l_address2']; ?>
                                            </p>
                                        </div>
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

                            <h4 class="form-section">Permanent Address</h4><hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Address 1</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['p_address1']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Address 2</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['p_address2']; ?>
                                            </p>
                                        </div>
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
                                                <?php echo ucwords($employee['p_city']); ?>
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
                                                <?php echo ucwords($employee['p_state']); ?>
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
                                                <?php echo ucwords($employee['p_country']); ?>
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
                                                <?php echo $employee['p_post_code']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <h4 class="form-section">Bank Details</h4><hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Pan No.</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['pan']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Bank Acc No.</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['bank_account_number']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Name as in Bank Account</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['bank_account_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Bank Name</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['bank_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">IFSC Code</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['bank_ifsc']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Bank Address</label>
                                        <label class="control-label col-md-1 text-center-imp">:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                <?php echo $employee['bank_address']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
         </div>
       </div>
    </body>
</html>