<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($grade) ? 'Edit' : 'Add'); ?> City
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
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

                        <?php if (isset($grade['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $grade['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="add-designation-level-error">
                                    <label class="control-label" for="band">States Name:
                                        <span class="required">*</span></label>

                                    <select name="state_id" class="form-control required select2me"
                                            data-placeholder="Select Designation" data-error-container="#add-designation-level-error">
                                        <option value=""></option>

                                        <?php $desg_id = (!empty($city['state_id']) ? $city['state_id'] : ''); ?>
                                        <?php foreach ($states as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>" 
                                                    <?php if ($desg_id == $data['id']) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $data['state_name']; ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">City Name:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="name"
                                           value="<?php echo isset($city['name']) ? $city['name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">City Class:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="class"
                                           value="<?php echo isset($city['class']) ? $city['class'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Cost Center:
                                        <span class="required">*</span></label>
                                    <select id="cost_center_id"  name="cost_center_id" class="form-control required select2me"
                                            data-placeholder="Please select a cost center">
                                        <option value=''></option>

                                        <?php $cost_center_id = !empty($city['cost_center_id']) ? $city['cost_center_id'] : ''; ?>

                                        <?php foreach ($city1 as $l_city) { ?>
                                            <option value="<?php echo $l_city['id']; ?>"
                                                    <?php if ($l_city['id'] == $cost_center_id) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $l_city['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Guest House:
                                        <span class="required">*</span></label>
                                    <?php $guest_house = !empty($city['guest_house']) ? $city['guest_house'] : ''; ?>
                                    <select id="guest_house"  name="guest_house" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value='1' <?php if ($guest_house == "1") echo "selected"; ?>>Yes</option>
                                        <option value='2' <?php if ($guest_house == "2") echo "selected"; ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Office Number:</label>
                                    <input type="number" class="form-control intonly" minlength="15" name="officenumber"
                                           value="<?php echo isset($city['officenumber']) ? $city['officenumber'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Office Address:</label>                                    
                                    <textarea name="officeaddress" rows="4" class="form-control"><?php echo isset($city['officeaddress']) ? $city['officeaddress'] : ''; ?></textarea>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">GS Address:</label>                                    
                                    <textarea name="gsaddress" rows="4" class="form-control"><?php echo isset($city['gsaddress']) ? $city['gsaddress'] : ''; ?></textarea>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Care Taker Name:</label>
                                    <input type="text" class="form-control" name="caretakername"
                                           value="<?php echo isset($city['caretakername']) ? $city['caretakername'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Mobile Number:</label>
                                    <input type="number" class="form-control intonly" minlength="15" name="mobile_number" maxlength="10"
                                           value="<?php echo isset($city['mobile_number']) ? $city['mobile_number'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'city'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>