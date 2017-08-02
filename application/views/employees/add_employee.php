<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($employee) ? 'Edit' : 'Add'); ?> Employee
        </h1>

        <div class="pull-right">
            <a href="<?php echo base_url() . 'employees'; ?>" class="btn default"><i class="fa fa-backward"></i> Back</a>
        </div>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i> Employee Form - <span class="step-title">
                            Step 1 of 5 </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" class="form-horizontal" id="submit_form" enctype="multipart/form-data">
                        <div class="form-wizard">
                            <div class="form-body">
                                <ul class="nav nav-pills nav-justified steps">
                                    <li>
                                        <a href="#tab1" data-toggle="tab" class="step">
                                            <span class="number">
                                                1 </span>
                                            <span class="desc">
                                                <i class="fa fa-check"></i> Basic Info </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab2" data-toggle="tab" class="step">
                                            <span class="number">
                                                2 </span>
                                            <span class="desc">
                                                <i class="fa fa-check"></i> Personal Info </span>
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
                                        <a href="#tab5" data-toggle="tab" class="step">
                                            <span class="number">
                                                4 </span>
                                            <span class="desc">
                                                <i class="fa fa-check"></i> Confirm </span>
                                        </a>
                                    </li>
                                </ul>
                                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
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

                                    <?php if (isset($error)) { ?>
                                        <div class="alert alert-danger">
                                            <i class="fa fa-ban"></i>
                                            <strong>Error!</strong> <?php echo $error; ?>
                                        </div>
                                    <?php } ?>

                                    <div class="tab-pane active" id="tab1">
                                        <h3 class="block">Provide your account details</h3>

                                        <?php if (isset($employee['id'])) { ?>
                                            <input id="employee-id" type="hidden" name="id" value="<?php echo $employee['id']; ?>" />
                                        <?php } ?>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email (Official)
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control email validate-email" id="email_check" name="gi_email" 
                                                       autocomplete="off" value="<?php echo isset($employee['gi_email']) ? $employee['gi_email'] : ''; ?>">
                                                <span class="help-block">
                                                    Provide your email address </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Alias
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control" id="username" name="username" 
                                                       autocomplete="off" value="<?php echo isset($employee['username']) ? $employee['username'] : ''; ?>">                                                
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Employee ID
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control" id="employee_id" name="employee_id" 
                                                       autocomplete="off" value="<?php echo isset($employee['employee_id']) ? $employee['employee_id'] : ''; ?>">                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Password 
                                                <?php if (!isset($employee['id'])) { ?> <span class="required"> * </span> <?php } ?>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="password" class=" <?php if (!isset($employee['id'])) { ?> required <?php } ?>form-control" 
                                                       name="password" autocomplete="false" id="submit_form_password" />
                                                <span class="help-block">
                                                    Provide your password. </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Confirm Password
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="password" class="form-control" name="rpassword"/>
                                                <span class="help-block">
                                                    Confirm your password </span>
                                            </div>
                                        </div>
                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Grades                                                
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <select id="grade_id"  name="grade_id" class="form-control required select2me"
                                                        data-placeholder="Select a Grade">
                                                    <option value=''></option>
                                                    <?php $grade_id = !empty($employee['grade_id']) ? $employee['grade_id'] : ''; ?>

                                                    <?php foreach ($grades as $grade) { ?>
                                                        <option value="<?php echo $grade['id']; ?>"
                                                                <?php if ($grade['id'] == $grade_id) { ?> selected="selected" <?php } ?>
                                                                >
                                                                    <?php echo $grade['grade_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Cost Center                                                
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <select id="cost_center_id"  name="cost_center_id" class="form-control required select2me"
                                                        data-placeholder="Select a Cost Center">
                                                    <option value=''></option>
                                                    <?php $cost_center_id = !empty($employee['cost_center_id']) ? $employee['cost_center_id'] : ''; ?>

                                                    <?php foreach ($cost_center as $cost) { ?>
                                                        <option value="<?php echo $cost['id']; ?>"
                                                                <?php if ($cost['id'] == $cost_center_id) { ?> selected="selected" <?php } ?>
                                                                >
                                                                    <?php echo $cost['city_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Reporting Manager<span class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <select id="reporting_manager_id"  name="reporting_manager_id" class="form-control select2me"
                                                        data-placeholder="Select a Reporting Manager">                                                    
                                                            <?php $reporting_manager_id = !empty($employee['reporting_manager_id']) ? $employee['reporting_manager_id'] : ''; ?>
                                                            <?php $id = !empty($employee['id']) ? $employee['id'] : ''; ?>

                                                    <?php
                                                    foreach ($all_employee as $data) {
                                                        if ($id != $data['id']) {
                                                            ?>
                                                            <option value="<?php echo $data['id']; ?>"
                                                                    <?php if ($data['id'] == $reporting_manager_id) { ?> selected="selected" <?php } ?>
                                                                    >
                                                                        <?php echo $data['first_name'] . " " . $data['last_name']; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <option value='0'>N/A</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class ="form-group">
                                            <label class="control-label col-md-3">EA of Manager</label>
                                            <div class="col-md-4">
                                                <select id="ea_manager_id"  name="ea_manager_id" class="form-control select2me"
                                                        data-placeholder="Select a EA of Manager">
                                                    <option value=''></option>

                                                    <?php $id = !empty($employee['id']) ? $employee['id'] : ''; ?>
                                                    <?php $ea_manager_id = !empty($employee['ea_manager_id']) ? $employee['ea_manager_id'] : ''; ?>

                                                    <?php
                                                    foreach ($all_employee as $data) {
                                                        if ($id != $data['id']) {
                                                            ?>
                                                            <option value="<?php echo $data['id']; ?>"
                                                                    <?php if ($data['id'] == $ea_manager_id) { ?> selected="selected" <?php } ?>
                                                                    >
                                                                        <?php echo $data['first_name'] . " " . $data['last_name']; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Designation
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4 ">
                                                <select id="designation" name="designation_id" class="form-control required select2me"
                                                        data-placeholder="Select a Designation">
                                                    <option value=''></option>
                                                    <?php $desg_id = !empty($employee['designation_id']) ? $employee['designation_id'] : ''; ?>                                                    

                                                    <?php foreach ($designations as $designation) { ?>
                                                        <option value="<?php echo $designation['id']; ?>"
                                                                <?php if ($designation['id'] == $desg_id) { ?> selected="selected" <?php } ?>
                                                                >
                                                                    <?php echo $designation['desg_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>	
                                            </div>
                                        </div>                                       
                                        <div class="form-group" id="add-designation-level-error">
                                            <label class="control-label col-md-3" for="band">Department:
                                                <span class="required">*</span></label>
                                            <?php $department_id = (!empty($employee['dept_id']) ? $employee['dept_id'] : ''); ?>
                                            <div class="col-md-4">
                                                <select name="dept_id" class="form-control required select2me"
                                                        data-placeholder="Select Department" data-error-container="#add-designation-level-error">
                                                    <option value=""></option>                                        
                                                    <?php foreach ($department as $data) { ?>
                                                        <option value="<?php echo $data['id']; ?>" 
                                                                <?php if ($department_id == $data['id']) { ?> selected="selected" <?php } ?>>
                                                                    <?php echo $data['dept_name']; ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class ="form-group">
                                            <label class="control-label col-md-3">Roles                                                
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <?php
                                                foreach ($roles as $key => $value) {
                                                    $selected = false;
                                                    if (!empty($sel_roles)) {
                                                        foreach ($sel_roles as $key => $sel_role) {
                                                            if ($sel_role['roles_id'] == $value['id']) {
                                                                $selected = true;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <input type="checkbox" id="role_id" name="role_id[]" value="<?php echo $value['id'] ?>" <?php
                                                    if ($value['id'] == "1") {
                                                        echo "checked disabled";
                                                    } else if ($selected == true) {
                                                        echo "checked";
                                                    }
                                                    ?>> 
                                                           <?php
                                                           echo $value['roles_name'];
                                                       }
                                                       ?>

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
                                                       value="<?php echo isset($employee['first_name']) ? $employee['first_name'] : ''; ?>">
                                                <span class="help-block">
                                                    Provide your first name </span>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-md-3">Last Name
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="required form-control" name="last_name"
                                                       value="<?php echo isset($employee['last_name']) ? $employee['last_name'] : ''; ?>">
                                                <span class="help-block">
                                                    Provide your last name </span>
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
                                                               <?php if ($emp_status === 'Male') { ?> checked="checked" <?php } ?>>
                                                        Male </label>
                                                    <label>
                                                        <input type="radio" name="gender" value="Female" data-title="Female"
                                                               <?php if ($emp_status === 'Female') { ?> checked="checked" <?php } ?>>
                                                        Female </label>
                                                </div>
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
                                            <label class="control-label col-md-3" for="upload" class="control-label" style="padding-bottom:25px;">Upload Photo</label>
                                            <?php if (isset($employee['image'])) { ?>
                                                ( <a class="btn-link" target="_blank" href="<?php echo base_url() . $employee['image']; ?>">
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
                                                    <label class="control-label col-md-3">State
                                                        <span class="required"> * </span></label>
                                                    <div class="col-md-9">
                                                        <select id="l-state"  name="l_state" class="form-control required select2me"
                                                                data-placeholder="Select a State">
                                                            <option value=''></option>
                                                            <?php $state_name = !empty($employee['l_state']) ? $employee['l_state'] : ''; ?>

                                                            <?php foreach ($states as $state) { ?>
                                                                <option value="<?php echo $state['state_name']; ?>"
                                                                        <?php if ($state['state_name'] == $state_name) { ?> selected="selected" <?php } ?>>
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
                                                        <select id="l-city"  name="city_id" class="form-control required select2me"
                                                                data-placeholder="Please select a state first">
                                                            <option value=''></option>

                                                            <?php $city_name = !empty($employee['city_id']) ? $employee['city_id'] : ''; ?>

                                                            <?php foreach ($l_cities as $l_city) { ?>
                                                                <option value="<?php echo $l_city['id']; ?>"
                                                                        <?php if ($l_city['id'] == $city_name) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $l_city['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Post Code</label>
                                                    <div class="col-md-9">
                                                        <input  id="l-post" type="text" name="l_post_code" class="form-control intonly"
                                                                value="<?php echo isset($employee['l_post_code']) ? $employee['l_post_code'] : ''; ?>" maxlength="6">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Country</label>
                                                    <div class="col-md-9">
                                                        <input  id="l-country" type="text" name="l_country" class="form-control"
                                                                value="<?php echo isset($employee['l_country']) ? $employee['l_country'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="tab5">
                                        <h3 class="block">Confirm your account</h3>

                                        <h4 class="form-section">Basic Info</h4>


                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email (Official):</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="gi_email">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Alias:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="username">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Employee ID:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="employee_id">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Grade:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="grade_id">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Cost Center:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="cost_center_id">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Reporting Manager:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="reporting_manager_id">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">EA of Manager:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="ea_manager_id">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Designation :</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="designation_id">
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
                                            <label class="control-label col-md-3">DOB:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="dob">  
                                                </p>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Address Local</h4>

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


<script>
    $(document).ready(function () {
        $('#submit_form1').validate({
            rules: {
                username: {
                    required: true,
                    remote: {
                        url: "<?php echo site_url('employees/usernameExits') ?>",
                        type: "post",
                        data: {
                            username: function () {
                                return $("#username").val();
                            },
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        }
                    }
                },
            },
            messages: {
                username: {
                    required: 'Please enter username',
                    remote: 'Username is already exiest'
                },
            }
        });

    });

</script>
