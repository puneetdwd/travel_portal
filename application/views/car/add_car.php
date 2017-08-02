<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($car) ? 'Edit' : 'Add'); ?> Car
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

                        <?php if (isset($car['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $car['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="car_name">Car Name:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="name"
                                           value="<?php echo isset($car['name']) ? $car['name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Rate@KM:
                                        <span class="required">*</span></label>                                        
                                    <input type="text" class="required form-control" name="amount"
                                           value="<?php echo isset($car['amount']) ? $car['amount'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                        </div>                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Location                                                
                                        <span class="required"> * </span></label>
                                    <?php $city_id = !empty($car['city_id']) ? $car['city_id'] : ''; ?>
                                    <select id="city_id"  name="city_id" class="form-control required select2me"
                                            data-placeholder="Select a Location">
                                        <option value=''></option>

                                        <?php foreach ($city as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $city_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>             
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Car Type
                                        <span class="required"> * </span></label>
                                    <?php $car_owner = !empty($car['category']) ? $car['category'] : ''; ?>
                                    <select id="category"  name="category" class="form-control required select2me"
                                            data-placeholder="Select a option">
                                        <option value='1'
                                                <?php if ("1" == $car_owner) { ?> selected="selected" <?php } ?>
                                                >Vendor</option>
                                        <option value='2'
                                                <?php if ("2" == $car_owner) { ?> selected="selected" <?php } ?>
                                                >Office Car</option>
                                    </select>
                                </div>
                            </div>             
                        </div>                        
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="travel_type" id="travel_type" value="3">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'car_category'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>