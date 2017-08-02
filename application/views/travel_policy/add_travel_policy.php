<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($travel_policy) ? 'Edit' : 'Add'); ?> Travel Policy
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <!--<div class="portlet-body form">-->
                <form role="form" class="validate-form" method="post">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>

                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-times"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($travel_policy['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $travel_policy['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Service Type:
                                        <span class="required">*</span></label>
                                    <?php $service_type = !empty($travel_policy['service_type']) ? $travel_policy['service_type'] : ''; ?>
                                    <select id="guest_house"  name="service_type" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value=''></option>
                                        <option value='1' <?php if ($service_type == "1") echo "selected"; ?>>Flight</option>
                                        <option value='2' <?php if ($service_type == "2") echo "selected"; ?>>Train</option>
                                        <option value='3' <?php if ($service_type == "3") echo "selected"; ?>>Car</option>
                                        <option value='4' <?php if ($service_type == "4") echo "selected"; ?>>Bus</option>
                                        <option value='5' <?php if ($service_type == "5") echo "selected"; ?>>Hotel</option>
                                        <option value='6' <?php if ($service_type == "6") echo "selected"; ?>>Daily Allowance</option>
                                        <option value='7' <?php if ($service_type == "7") echo "selected"; ?>>Daily Conveyance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Grades                                                
                                        <span class="required"> * </span></label>
                                    <?php $grade_id = !empty($travel_policy['grade_id']) ? $travel_policy['grade_id'] : ''; ?>
                                    <select id="grade_id"  name="grade_id" class="form-control required select2me"
                                            data-placeholder="Select a Grade">
                                        <option value=''></option>

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

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Approval Level:
                                        <span class="required">*</span></label>
                                    <?php $approval_level = !empty($travel_policy['approval_level']) ? $travel_policy['approval_level'] : ''; ?>
                                    <select id="guest_house"  name="approval_level" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value=''></option>
                                        <option value='0' <?php if ($approval_level == "0") echo "selected"; ?>>0</option>
                                        <option value='1' <?php
                                        if (!empty($approval_level)) {
                                            if ($approval_level == "1") {
                                                echo "selected";
                                            }
                                        } else {
                                            echo "selected";
                                        }
                                        ?>>1</option>
                                        <option value='2' <?php if ($approval_level == "2") echo "selected"; ?>>2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">City Class:
                                        <span class="required">*</span></label>
                                    <?php $city_class = !empty($travel_policy['city_class']) ? $travel_policy['city_class'] : ''; ?>
                                    <select id="guest_house"  name="city_class" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value=''></option>
                                        <option value='A' <?php if ($city_class == "A") echo "selected"; ?>>A</option>
                                        <option value='B' <?php if ($city_class == "B") echo "selected"; ?>>B</option>
                                        <option value='C' <?php if ($city_class == "C") echo "selected"; ?>>C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">       
                                    <label class="control-label col-md-12" for="flight_name">Allowances:
                                        <span class="required">*</span></label>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <input type="checkbox" id="actual" name="actual" value="1" <?php
                                            if (!empty($travel_policy['actual'])) {
                                                if ($travel_policy['actual'] == 1) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?>> Actual
                                        </div>
                                        <label class="control-label col-md-2" for="flight_name">Amount:</label>
                                        <div class="col-md-6">                                        
                                            <input type="number" class="required form-control" id="amount" name="amount"
                                                   value="<?php
                                                   if (isset($travel_policy)) {
                                                       if ($travel_policy['actual'] != 1) {
                                                           echo isset($travel_policy['amount']) ? $travel_policy['amount'] : '';
                                                       }
                                                   }
                                                   ?>" <?php
                                                   if (isset($travel_policy)) {
                                                       if ($travel_policy['actual'] == 1) {
                                                           echo "disabled";
                                                       }
                                                   }
                                                   ?>>
                                        </div>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="flight_name">Popup:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="popup"
                                           value="<?php echo isset($travel_policy['popup']) ? $travel_policy['popup'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'travel_policy'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#actual').change(function () {
            $("#amount").prop("disabled", $(this).is(':checked'));
        });
    });
</script>