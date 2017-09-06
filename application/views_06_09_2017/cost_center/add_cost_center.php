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

                        <?php if (isset($grade['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $grade['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="add-designation-level-error">
                                    <label class="control-label" for="band">States:
                                        <span class="required">*</span></label>
                                    <select id="state_id" class="form-control required select2me"
                                            data-placeholder="Select a State">
                                        <option value=''></option>
                                        <?php $state_id = !empty($cost['state_id']) ? $cost['state_id'] : ''; ?>

                                        <?php foreach ($states as $state) { ?>
                                            <option value="<?php echo $state['id']; ?>"
                                                    <?php if ($state['id'] == $state_id) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $state['state_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">City:
                                        <span class="required">*</span></label>
                                    <select id="city_id"  name="city_id" class="form-control required select2me"
                                            data-placeholder="Please select a state first">
                                        <option value=''></option>

                                        <?php $city_id = !empty($cost['city_id']) ? $cost['city_id'] : ''; ?>

                                        <?php foreach ($l_cities as $l_city) { ?>
                                            <option value="<?php echo $l_city['id']; ?>"
                                                    <?php if ($l_city['id'] == $city_id) { ?> selected="selected" <?php } ?>>
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
                                    <label class="control-label" for="class">City Class:
                                        <span class="required">*</span></label>
                                        <?php $city_class = !empty($cost['class']) ? $cost['class'] : ''; ?>
                                    <input type="text" class="required form-control" name="class_name" id="class_name" disabled="" value="<?php echo $city_class; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Guest House:
                                        <span class="required">*</span></label>
                                        <?php $guest_house = !empty($cost['guest_house']) ? $cost['guest_house'] : ''; ?>
                                    <select id="guest_house"  name="guest_house" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value='1' <?php if($guest_house == "1") echo "selected"; ?>>Yes</option>
                                        <option value='2' <?php if($guest_house == "2") echo "selected"; ?>>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'cost_center'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>