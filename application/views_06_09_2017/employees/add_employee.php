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

            <form method="post" class="form-horizontal" id="submit_form" enctype="multipart/form-data">
                <?php if (isset($employee['id'])) { ?>
                    <input id="employee-id" type="hidden" name="id" value="<?php echo $employee['id']; ?>" />
                <?php } ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Email (Official)
                            <span class="required"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" maxlength="50" class="required form-control email validate-email" id="email_check" name="gi_email" 
                                   autocomplete="off" value="<?php echo isset($employee['gi_email']) ? $employee['gi_email'] : ''; ?>">
                            <span class="help-block">
                                Provide your email address </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Alias
                            <span class="required"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" maxlength="15" class="required form-control" id="alias" name="alias" minlength="2"
                                   autocomplete="off" value="<?php echo isset($employee['username']) ? $employee['username'] : ''; ?>">                                                
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Employee ID
                            <span class="required"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" maxlength="45"  class="required form-control" id="employee_id" name="employee_id" 
                                   autocomplete="off" value="<?php echo isset($employee['employee_id']) ? $employee['employee_id'] : ''; ?>">                                                
                        </div>
                    </div>

                    <div class ="form-group">
                        <label class="control-label col-md-3">Grades                                                
                            <span class="required"> * </span></label>
                        <div class="col-md-9">
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
                        <div class="col-md-9">
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
                        <?php $reporting_manager = !empty($employee['reporting_manager']) ? $employee['reporting_manager'] : ''; ?>
                        <div class="col-md-7">
                            <input id="dd_user_input" name="dd_user_input" type="text" class="form-control required" onblur="if (this.value == '')
                                        this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
                                                    this.value = '';" value="<?php if (!empty($reporting_manager)) echo $reporting_manager; ?>" <?php if (!empty($reporting_manager)) echo "disabled"; ?> /> 
                        </div>
                        <div class="col-md-2">
                            <?php $reporting_manager_id = !empty($employee['reporting_manager_id']) ? $employee['reporting_manager_id'] : ''; ?>
                            <input type="button" class="btn btn_blue col-md-12" value="Clear" id="delete_check" onclick="unselect_emp()" >
                            <input type="hidden" name="reporting_manager_id" id="reporting_manager_id" value="<?php if (!empty($reporting_manager_id)) echo $reporting_manager_id; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">EA of Manager</label>
                        <?php $ea_manager = !empty($employee['ea_manager']) ? $employee['ea_manager'] : ''; ?>
                        <div class="col-md-7">
                            <input id="dd_user_input1" name="dd_user_input1" type="text" class="form-control" onblur="if (this.value == '')
                                        this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
                                                    this.value = '';" value="<?php if (!empty($ea_manager)) echo $ea_manager; ?>" <?php if (!empty($ea_manager)) echo "disabled"; ?> /> 
                        </div>
                        <div class="col-md-2">
                            <?php $ea_manager_id = !empty($employee['ea_manager_id']) ? $employee['ea_manager_id'] : ''; ?>
                            <input type="button" class="btn btn_blue col-md-12" value="Clear" id="delete_check" onclick="unselect_emp1()" >
                            <!--<i class="fa fa-times error" id="delete_check" onclick="unselect_emp()" style="display: none"></i>-->
                            <input type="hidden" name="ea_manager_id" id="ea_manager_id" value="<?php if (!empty($ea_manager_id)) echo $ea_manager_id; ?>">
                        </div>
                    </div>
                    <div class ="form-group">
                        <label class="control-label col-md-3">Designation
                            <span class="required"> * </span></label>
                        <div class="col-md-9 ">
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
                        <div class="col-md-9">
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
                        <div class="col-md-9">
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
                    <div class="form-group">
                        <label class="control-label col-md-3">First Name
                            <span class="required"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" maxlength="50" class="required form-control" name="first_name"
                                   value="<?php echo isset($employee['first_name']) ? $employee['first_name'] : ''; ?>">
                            <span class="help-block">
                                Provide your first name </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Last Name
                            <span class="required"> * </span></label>
                        <div class="col-md-9">
                            <input type="text" maxlength="50" class="required form-control" name="last_name"
                                   value="<?php echo isset($employee['last_name']) ? $employee['last_name'] : ''; ?>">
                            <span class="help-block">
                                Provide your last name </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Gender <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-9" id="form_gender_error">
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
                        <div class="col-md-9">
                            <input type="text" id="contact_id" maxlength="15"  class="required form-control intonly mobile-no contact_number " name="phone"
                                   value="<?php echo isset($employee['phone']) ? $employee['phone'] : ''; ?>" maxlength="10"
                                   placeholder="Ex(10 Digits Only): 9897969594" autocomplete="off" >
                            <span class="help-block">
                                Provide your phone number </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="dob">DOB </label>
                        <div class="col-md-9">
                            <div data-date-format="dd-mm-yyyy" 
                                 class="input-group date date-picker" data-date-end-date="-18y">
                                <input type="text" readonly="" name="dob" class="required form-control"
                                       value="<?php echo isset($employee['dob']) ? date('d-m-Y', strtotime($employee['dob'])) : ''; ?>">
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
                        <div class="col-md-9">
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
                    <div class="form-group">
                        <label class="control-label col-md-3">Post Code</label>
                        <div class="col-md-9">
                            <input  id="l-post" type="text" maxlength="50" name="l_post_code" class="form-control intonly"
                                    value="<?php echo isset($employee['l_post_code']) ? $employee['l_post_code'] : ''; ?>" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label col-md-3">Country</label>
                        <div class="col-md-9">
                            <input  id="l-country" type="text" name="l_country" maxlength="50" class="form-control"
                                    value="<?php echo isset($employee['l_country']) ? $employee['l_country'] : ''; ?>">
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <button class="btn green col-md-offset-2" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'employees'; ?>" class="btn default">Cancel</a>
                    </div>
                </div>
            </form>

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

<script type="text/javascript" src="<?php echo base_url() . "assets/autocomplete/jquery-ui-1.8.2.custom.min.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">
    $(function () {
        $("#dd_user_input").autocomplete({
            source: '<?php echo site_url('employees/find_employees'); ?>',
            minLength: 1,
            select: function (event, ui) {
                var stud_id = ui.item.id;
                if (stud_id != '#') {
                    $("#reporting_manager_id").val(stud_id);
                    $("#dd_user_input").attr("disabled", "disabled");
//                    $("#delete_check").css("display", "block");
//                    save_studnet();
                }
            },
            html: true,
            open: function (event, ui) {
                $("#reporting_manager_id").val('');
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });

    });

    $(function () {
        $("#dd_user_input1").autocomplete({
            source: '<?php echo site_url('employees/find_employees'); ?>',
            minLength: 1,
            select: function (event, ui) {
                var stud_id = ui.item.id;
                if (stud_id != '#') {
                    $("#ea_manager_id").val(stud_id);
                    $("#dd_user_input1").attr("disabled", "disabled");
//                    $("#delete_check").css("display", "block");
//                    save_studnet();
                }
            },
            html: true,
            open: function (event, ui) {
                $("#ea_manager_id").val('');
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });

    });

    function unselect_emp() {
        $("#dd_user_input").val('');
        $("#reporting_manager_id").val('');
        $("#dd_user_input").removeAttr("disabled");
//        $("#delete_check").css("display", "none");        
    }
    function unselect_emp1() {
        $("#dd_user_input1").val('');
        $("#ea_manager_id").val('');
        $("#dd_user_input1").removeAttr("disabled");
//        $("#delete_check").css("display", "none");        
    }


</script>