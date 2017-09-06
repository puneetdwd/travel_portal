<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Update Profile
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."employees/view_profile"; ?>">
                    View Profile
                </a>
            </li>
            <li class="active">Update Profile</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i> Form - <span class="step-title">
                        Step 1 of 5 </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" class="form-horizontal" id="submit_form" enctype="multipart/form-data">
                        <div class="form-wizard">
                            <div class="form-body">
                                <ul class="nav nav-pills nav-justified steps">
                                    <li>
                                        <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number">
                                        1 </span>
                                        <span class="desc">
                                        <i class="fa fa-check"></i> Personal Info </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number">
                                        2 </span>
                                        <span class="desc">
                                        <i class="fa fa-check"></i> Basic Info </span>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="#tab3" data-toggle="tab" class="step">
                                        <span class="number">
                                        3 </span>
                                        <span class="desc">
                                        <i class="fa fa-check"></i> Address Info </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab4" data-toggle="tab" class="step active">
                                        <span class="number">
                                        4 </span>
                                        <span class="desc">
                                        <i class="fa fa-check"></i> Bank Account </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab5" data-toggle="tab" class="step">
                                        <span class="number">
                                        5 </span>
                                        <span class="desc">
                                        <i class="fa fa-check"></i> Confirm </span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="bar" class="progress progress-striped" role="progressbar">
                                    <div class="progress-bar progress-bar-success">
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="alert alert-danger display-none">
                                        <button class="close" data-dismiss="alert"></button>
                                        You have some form errors. Please check below.
                                    </div>
                                    <div class="alert alert-success display-none">
                                        <button class="close" data-dismiss="alert"></button>
                                        Your form validation is successful!
                                    </div>

                                    <?php if(isset($error)) { ?>
                                        <div class="alert alert-danger">
                                            <i class="fa fa-ban"></i>
                                            <strong>Error!</strong> <?php echo $error; ?>
                                        </div>
                                    <?php } ?>

                                    <div class="tab-pane active" id="tab1">
                                        <h3 class="block">Provide your account details</h3>

                                        <?php if(isset($employee['id'])) { ?>
                                            <input id="employee-id" type="hidden" name="id" value="<?php echo $employee['id']; ?>" />
                                        <?php } ?>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email (Official)
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control email validate-email" id="email_check" name="gi_email" 
                                                autocomplete="off" value="<?php echo isset($employee['gi_email']) ? $employee['gi_email'] : ''; ?>"
                                                readonly="">
                                                <span class="help-block">
                                                Can't edit date of joining </span>
                                            </div>
                                        </div>

                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Department
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <?php $dept_id = !empty($employee['department_id']) ? $employee['department_id'] : '';?>
                                                
                                                <input type="text" class="form-control" name="department_id" 
                                                autocomplete="off" value="<?php foreach($departments as $department){  
                                                    if($department['id'] == $dept_id) { echo $department['dept_name']; }
                                                } ?>"
                                                readonly="">
                                             </div>
                                        </div>
                                            
                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Sub-Department
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <?php $sub_dept_id = !empty($employee['sub_dept_id']) ? $employee['sub_dept_id'] : '';?>
                                                
                                                <input type="text" class="form-control" name="sub_dept_id" 
                                                autocomplete="off" value="<?php foreach($sub_depts as $sub_dept){  
                                                    if($sub_dept['id'] == $sub_dept_id) { echo $sub_dept['sub_dept']; }
                                                } ?>" readonly="">
                                            </div>
                                            </div>
                                            <div class ="form-group">
                                                <label class="control-label col-md-3">Designation
                                                <span class="required"> * </span></label>
                                                <div class="col-md-4 ">
                                                    <?php $desg_id = !empty($employee['designation_id']) ? $employee['designation_id'] : '';?>	
                                                    
                                                    <input type="text" class="form-control" name="designation_id" 
                                                    autocomplete="off" value="<?php foreach($designations as $designation){  
                                                        if($designation['id']== $desg_id) { echo $designation['desg_name'].'('.$designation['band_name'].')'; }
                                                    } ?>" readonly="">
                                                    
                                                </div>
                                            </div>
                                            <div class ="form-group">
                                                <label class="control-label col-md-3">Reporting Person
                                                <span class="required"> * </span></label>
                                                <div class="col-md-4">
                                            <?php $person_id = !empty($employee['reporting_person_id']) ? $employee['reporting_person_id'] : '';?>
                                                
                                                <input type="text" class="form-control" name="reporting_person_id" 
                                                    autocomplete="off" value="<?php echo ucwords($employee['reporting_person']); ?>" readonly="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Location
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <select id="currency_type" name="location" class="form-control required select2me"
                                                data-placeholder="Select a Location">
                                                    <?php $location = isset($employee['location']) ? $employee['location'] : '';?>
                                                    <option></option>
                                                    <option value="Gurgaon" <?php if($location == 'Gurgaon') { echo "selected='selected'"; } ?>>
                                                        Gurgaon
                                                    </option>
                                                    <option value="Mumbai" <?php if($location == 'Mumbai') { echo "selected='selected'"; } ?>>
                                                        Mumbai
                                                    </option>
                                                    <option value="Bangalore" <?php if($location == 'Bangalore') { echo "selected='selected'"; } ?>>
                                                        Bangalore
                                                    </option>
                                                    <option value="Delhi" <?php if($location == 'Delhi') { echo "selected='selected'"; } ?>>
                                                        Delhi
                                                    </option>
                                                    <option value="Pune" <?php if($location == 'Pune') { echo "selected='selected'"; } ?>>
                                                        Pune
                                                    </option>
                                                    <option value="Kolkata" <?php if($location == 'Kolkata') { echo "selected='selected'"; } ?>>
                                                        Kolkata
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                   
                                    </div>

                                    <div class="tab-pane" id="tab2">
                                        <h3 class="block">Provide your profile details</h3>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">First Name
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control" name="first_name"
                                                value="<?php echo isset($employee['first_name']) ? $employee['first_name'] : ''; ?>"
                                                readonly="">
                                                <span class="help-block">
                                                Can't edit your first name </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Middle Name
                                           </label>
                                            <div class="col-md-4">
                                                <input type="text" class=" form-control" name="middle_name"
                                                value="<?php echo isset($employee['middle_name']) ? $employee['middle_name'] : ''; ?>"
                                                readonly="">
                                                <span class="help-block">
                                                Can't edit your first name </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Last Name
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control" name="last_name"
                                                value="<?php echo isset($employee['last_name']) ? $employee['last_name'] : ''; ?>"
                                                readonly="">
                                                <span class="help-block">
                                                Can't edit your last name </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Father's Name
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control" name="father_name"
                                                value="<?php echo isset($employee['father_name']) ? $employee['father_name'] : ''; ?>"
                                                readonly="">
                                                <span class="help-block">
                                                Can't edit your Father name </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Gender <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-4" id="form_gender_error">
                                                <div class="radio-list" data-error-container="#form_gender_error">
                                                    <?php $emp_status = !empty($employee['gender']) ? $employee['gender'] : ''; ?>
                                                    <label>
                                                    <input type="radio" name="gender" value="Male" data-title="Male"
                                                    <?php if($emp_status === 'Male') { ?> checked="checked" <?php } ?>>
                                                    Male </label>
                                                    <label>
                                                    <input type="radio" name="gender" value="Female" data-title="Female"
                                                    <?php if($emp_status === 'Female') { ?> checked="checked" <?php } ?>>
                                                    Female </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Blood Group
                                            <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <select  name="blood_group" class="form-control required select2me"
                                                data-placeholder="Select a Blood Group">
                                                    <?php $blood = isset($employee['blood_group']) ? $employee['blood_group'] : '';?>
                                                    <option></option>
                                                    <option value="O+" <?php if($blood == 'O+') { echo "selected='selected'"; } ?>>
                                                        O+
                                                    </option>
                                                    <option value="O-" <?php if($blood == 'O-') { echo "selected='selected'"; } ?>>
                                                        O-
                                                    </option>
                                                    <option value="A+" <?php if($blood == 'A+') { echo "selected='selected'"; } ?>>
                                                        A+
                                                    </option>
                                                    <option value="A-" <?php if($blood == 'A-') { echo "selected='selected'"; } ?>>
                                                        A-
                                                    </option>
                                                    <option value="B+" <?php if($blood == 'B+') { echo "selected='selected'"; } ?>>
                                                        B+
                                                    </option>
                                                    <option value="B-" <?php if($blood == 'B-') { echo "selected='selected'"; } ?>>
                                                        B-
                                                    </option>
                                                    <option value="AB+" <?php if($blood == 'AB+') { echo "selected='selected'"; } ?>>
                                                        AB+
                                                    </option>
                                                    <option value="AB-" <?php if($blood == 'AB-') { echo "selected='selected'"; } ?>>
                                                        AB-
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Mobile Number <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" id="contact_id" class="required form-control intonly mobile-no contact_number " name="phone"
                                                value="<?php echo isset($employee['phone']) ? $employee['phone'] : ''; ?>" maxlength="10"
                                                 placeholder="Ex(10 Digits Only): 9897969594" autocomplete="off" >
                                                <span class="help-block">
                                                Provide your phone number </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Emergency Contact Number <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" id="emergency" class="required form-control intonly emergency-no" name="emergency_phone"
                                                value="<?php echo isset($employee['emergency_phone']) ? $employee['emergency_phone'] : ''; ?>" maxlength="10"
                                                 placeholder="Ex(10 Digits Only): 9897969594" autocomplete="off" 
                                                    onblur="return mobile_check();">
                                                <span class="help-block">
                                                Provide your phone number </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Additional Emergency Contact Number <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control intonly emergency-no" name="emergency_phone2"
                                                value="<?php echo isset($employee['emergency_phone2']) ? $employee['emergency_phone2'] : ''; ?>" maxlength="10"
                                                 placeholder="Ex(10 Digits Only): 9897969594" autocomplete="off" 
                                                    onblur="return mobile_check();">
                                                <span class="help-block">
                                                Provide your phone number </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Personal Email 
                                            <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control email" name="email"
                                                value="<?php echo isset($employee['email']) ? $employee['email'] : ''; ?>">
                                                <span class="help-block">
                                                Provide your email address </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3" for="dob">DOB </label>
                                            <div class="col-md-4">
                                                <div data-date-format="yyyy-mm-dd" 
                                                class="input-group date date-picker" data-date-end-date="-18y">
                                                    <input type="text" readonly="" name="dob" class="required form-control"
                                                    value="<?php echo isset($employee['dob']) ? $employee['dob'] : ''; ?>">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn default">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <span class="help-block">
                                                Provide your date of birth </span>
                                            </div>
                                        </div>
                                        
                                       <div class="form-group">                                            
                                            <div class="col-md-4">
                                                <input type="hidden" class="required form-control" name="type"
                                                value="employee">                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3" for="doj">Date of Joining </label>
                                            <div class="col-md-4">
                                                    <input type="text" readonly="" name="doj" class="required form-control"
                                                    value="<?php echo isset($employee['doj']) ? $employee['doj'] : ''; ?>">
                                                <span class="help-block">
                                                Can't edit date of joining </span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3" for="upload" class="control-label" style="padding-bottom:25px;">Upload Photo</label>
                                            <?php if(isset($employee['image'])) { ?>
                                                ( <a class="btn-link" target="_blank" href="<?php echo base_url().$employee['image']; ?>">
                                                        <i class="fa fa-download"></i> Download Photo
                                                </a> )
                                            <?php } ?>
                                            <input type="file" id="image" name="image" value ="<?php echo isset($employee['image']) ? $employee['image'] : ''; ?>" >
                                            <span>(Valid Formats - JPG, JPEG, PNG and GIF)</span>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab3">
                                        <h3 class="block">Provide your address details</h3>
                                        <h4 class="form-section">Address Local</h4>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Address 1
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <input id="l-add1" type="text" name="l_address1" class="required form-control"
                                                        value="<?php echo isset($employee['l_address1']) ? $employee['l_address1'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Address 2</label>
                                                    <div class="col-md-9">
                                                        <input  id="l-add2" type="text" name="l_address2" class="form-control"
                                                        value="<?php echo isset($employee['l_address2']) ? $employee['l_address2'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">State
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <select id="l-state"  name="l_state" class="form-control required select2me"
                                                            data-placeholder="Select a State">
                                                            <option value=''></option>
                                                            <?php $state_name = !empty($employee['l_state']) ? $employee['l_state'] : '';?>
                                                             
                                                            <?php foreach($states as $state){?>
                                                                    <option value="<?php echo $state['state_name']; ?>"
                                                                    <?php if($state['state_name'] == $state_name) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $state['state_name']; ?>
                                                                    </option>
                                                            <?php } ?>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">City
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <select id="l-city"  name="l_city" class="form-control required select2me"
                                                            data-placeholder="Please select a state first">
                                                            <option value=''></option>
                                                             
                                                            <?php $city_name = !empty($employee['l_city']) ? $employee['l_city'] : '';?>

                                                            <?php foreach($l_cities as $l_city){?>
                                                                    <option value="<?php echo $l_city['name']; ?>"
                                                                    <?php if($l_city['name'] == $city_name) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $l_city['name']; ?>
                                                                    </option>
                                                            <?php } ?>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Post Code
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <input  id="l-post" type="text" name="l_post_code" class="required form-control intonly"
                                                        value="<?php echo isset($employee['l_post_code']) ? $employee['l_post_code'] : ''; ?>" maxlength="6">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Country
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <input  id="l-country" type="text" name="l_country" class="required form-control"
                                                        value="<?php echo isset($employee['l_country']) ? $employee['l_country'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div style="float:right"  class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="from">Same as Above</label>
                                                     
                                                    <input  id="address-check" type="checkbox" class=" form-control" name="same_as_above"
                                                    value="1">
                                                    <span class="help-block">
                                                    </span>
                                            </div>
                                        </div>
                                        <h4 class="form-section">Address Permanent</h4>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Address 1
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <input id="p-add1" type="text" name="p_address1" class="required form-control"
                                                        value="<?php echo isset($employee['p_address1']) ? $employee['p_address1'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Address 2</label>
                                                    <div class="col-md-9">
                                                        <input id="p-add2" type="text" name="p_address2" class="form-control"
                                                        value="<?php echo isset($employee['p_address2']) ? $employee['p_address2'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">State
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <select id="p-state"  name="p_state" class="form-control required select2me"
                                                            data-placeholder="Select a State">
                                                            <option value=''></option>
                                                            <?php $s_name = !empty($employee['p_state']) ? $employee['p_state'] : '';?>

                                                            <?php foreach($states as $state){?>
                                                                    <option value="<?php echo ucfirst(strtolower($state['state_name'])); ?>"
                                                                    <?php if(ucfirst(strtolower($state['state_name'])) == $s_name) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo ucfirst(strtolower($state['state_name'])); ?>
                                                                    </option>
                                                            <?php } ?>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <?php //echo '<pre>' ; print_r($employee); ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">City
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <select id="p-city"  name="p_city" class="form-control required select2me"
                                                            data-placeholder="Please select a state first">
                                                             <option value=''></option>
                                                             
                                                            <?php $p_city_name = !empty($employee['p_city']) ? $employee['p_city'] : '';?>

                                                            <?php foreach($p_cities as $p_city){?>
                                                                    <option value="<?php echo $p_city['name']; ?>"
                                                                    <?php if($p_city['name'] == $p_city_name) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $p_city['name']; ?>
                                                                    </option>
                                                            <?php } ?>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <?php //echo '<pre>' ; print_r($c_name); ?>
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Post Code
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <input id="p-post" type="text" name="p_post_code" class="required form-control intonly"
                                                        value="<?php echo isset($employee['p_post_code']) ? $employee['p_post_code'] : ''; ?>" maxlength="6">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Country
                                                    <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <input id="p-country" type="text" name="p_country" class="required form-control"
                                                        value="<?php echo isset($employee['p_country']) ? $employee['p_country'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab4">
                                        <h3 class="block">Provide your bank account details</h3>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pan No. 
                                            <span class="required" >*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control validPancard" name="pan" 
                                                       value="<?php echo isset($employee['pan']) ? $employee['pan'] : ''; ?>" maxlength="10" readonly="">
                                                <span class="help-block">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank Name </label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="bank_name"
                                                value="<?php echo isset($employee['bank_name']) ? $employee['bank_name'] : ''; ?>">
                                                <span class="help-block">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank Account Number </label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="bank_account_number"
                                                value="<?php echo isset($employee['bank_account_number']) ? $employee['bank_account_number'] : ''; ?>">
                                                <span class="help-block">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Name as in Bank Account </label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="bank_account_name"
                                                value="<?php echo isset($employee['bank_account_name']) ? $employee['bank_account_name'] : ''; ?>">
                                                <span class="help-block">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank IFSC Code</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="bank_ifsc"
                                                value="<?php echo isset($employee['bank_ifsc']) ? $employee['bank_ifsc'] : ''; ?>">
                                                <span class="help-block">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank Address </label>
                                            <div class="col-md-4">
                                                <textarea class="form-control" name="bank_address"/><?php echo isset($employee['bank_address']) ? $employee['bank_address'] : ''; ?></textarea>
                                                <span class="help-block">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab5">
                                        <h3 class="block">Confirm your account</h3>

                                        <h4 class="form-section">Basic Info</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Employee ID:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="empID"><?php echo $empID ;?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email (Official):</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="gi_email">
                                                </p>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Personal Info</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">First Name:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="first_name">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Last Name:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="last_name">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Gender:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="gender">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Mobile Number:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="phone">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Emergency Contact Number:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="emergency_phone">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Personal Email:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="email">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">DOB:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="dob">  
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Date of Joining:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="doj"> 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Department:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="department_id"> 
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Sub-Department:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="sub_dept_id"> 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Reporting Person:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="reporting_person_id"> 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Designation:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="designation_id"> 
                                                </p>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Address Local</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Address 1:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="l_address1">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Address 2:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="l_address2">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">City:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="l_city">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">State:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="l_state">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Post Code:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="l_post_code">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Country:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="l_country">
                                                </p>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Permanent Address</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Address 1:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="p_address1">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Address 2:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="p_address2">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">City:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="p_city">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">State:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="p_state">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Post Code:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="p_post_code">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Country:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="p_country">
                                                </p>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Bank Account</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pan No:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="pan">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank Name:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="bank_name">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank Account Number:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="bank_account_number">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Name as in Bank Account:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="bank_account_name">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank IFSC Code:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="bank_ifsc">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bank Address:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="bank_address">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a href="javascript:;" class="btn default button-previous">
                                            <i class="m-icon-swapleft"></i> Back </a>
                                            <a href="javascript:;" class="btn grey-cascade button-next">
                                            Continue <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                            <a href="javascript:;" class="btn green button-submit">
                                            Submit <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>