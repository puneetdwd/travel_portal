<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($grade) ? 'Edit' : 'Add'); ?> Grades
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
                                <div class="form-group">
                                    <label class="control-label" for="name">Grades Name:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="grade_name"
                                           value="<?php echo isset($grade['grade_name']) ? $grade['grade_name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Travel Mode:
                                        <span class="required">*</span></label>
                                    <?php $grade_id = !empty($grade['travel_mode']) ? $grade['travel_mode'] : ''; ?>
                                    <select id="travel_mode"  name="travel_mode" class="form-control required select2me"
                                            data-placeholder="Please select travel mode">
                                        <option value=''></option>
                                        <option value='1' <?php if ($grade_id == "1") echo "selected"; ?>>Flight</option>
                                        <option value='2' <?php if ($grade_id == "2") echo "selected"; ?>>Train</option>
                                        <option value='3' <?php if ($grade_id == "3") echo "selected"; ?>>Car</option>
                                        <option value='4' <?php if ($grade_id == "4") echo "selected"; ?>>Bus</option>
                                        <option value='5' <?php if ($grade_id == "5") echo "selected"; ?>>Hotel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Travel Class:
                                        <span class="required">*</span></label>
                                    <select id="travel_class_id"  name="travel_class" class="form-control required select2me"
                                            data-placeholder="Please select a travel class">
                                        <option value=''></option>
                                        <?php $travel_class_id = !empty($grade['travel_class']) ? $grade['travel_class'] : ''; ?>
                                        <?php foreach ($travel_category as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>" <?php if ($data['id'] == $travel_class_id) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="hotel_class">Hotel Class:
                                        <span class="required">*</span></label>
                                    <?php $hotel_class = !empty($grade['hotel_class']) ? $grade['hotel_class'] : ''; ?>
                                    <select id="hotel_class"  name="hotel_class" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value=''></option>
                                        <option value='1' <?php if ($hotel_class == "1") echo "selected"; ?>>1 Star</option>
                                        <option value='2' <?php if ($hotel_class == "2") echo "selected"; ?>>2 Star</option>
                                        <option value='3' <?php if ($hotel_class == "3") echo "selected"; ?>>3 Star</option>
                                        <option value='4' <?php if ($hotel_class == "4") echo "selected"; ?>>4 Star</option>
                                        <option value='5' <?php if ($hotel_class == "5") echo "selected"; ?>>5 Star</option>
                                        <option value='6' <?php if ($hotel_class == "6") echo "selected"; ?>>6 Star</option>
                                        <option value='7' <?php if ($hotel_class == "7") echo "selected"; ?>>7 Star</option>
                                    </select>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="add-designation-level-error">
                                    <label class="control-label" for="band">Transport Entitlement:
                                        <span class="required">*</span></label>

                                    <select name="car_id" class="form-control required select2me"
                                            data-placeholder="Select Transport Entitlement" data-error-container="#add-designation-level-error">
                                        <option value=""></option>

                                        <?php $car_id = (!empty($grade['car_id']) ? $grade['car_id'] : ''); ?>
                                        <?php foreach ($car as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>" 
                                                    <?php if ($car_id == $data['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'grades'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>