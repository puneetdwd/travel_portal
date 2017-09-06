<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($service_proviers) ? 'Edit' : 'Add'); ?> Service Providers(Flight,Train,Car,Bus)
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

                        <?php if (isset($service_proviers['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $service_proviers['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="flight_name">Vendor Name:
                                        <span class="required">*</span></label>
                                        <input type="text" maxlength="255" class="required form-control" name="name"
                                           value="<?php echo isset($service_proviers['name']) ? $service_proviers['name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Service Type:
                                        <span class="required">*</span></label>
                                    <?php $service_type = !empty($service_proviers['service_type']) ? $service_proviers['service_type'] : ''; ?>
                                    <select id="guest_house"  name="service_type" class="form-control required select2me"
                                            data-placeholder="Please select">
                                        <option value=''></option>
                                        <option value='1' <?php if ($service_type == "1") echo "selected"; ?>>Flight</option>
                                        <option value='2' <?php if ($service_type == "2") echo "selected"; ?>>Train</option>
                                        <option value='3' <?php if ($service_type == "3") echo "selected"; ?>>Car</option>
                                        <option value='4' <?php if ($service_type == "4") echo "selected"; ?>>Bus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="flight_name">Tatkal Commisson :
                                        <span class="required">*</span></label>
                                    <input type="number" class="required form-control" name="amount"
                                           value="<?php echo isset($service_proviers['amount']) ? $service_proviers['amount'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="flight_name">Normal Commisson :
                                        <span class="required">*</span></label>
                                    <input type="number" class="required form-control" name="half_amount"
                                           value="<?php echo isset($service_proviers['half_amount']) ? $service_proviers['half_amount'] : ''; ?>">
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
                                    <?php $city_id = !empty($service_proviers['city_id']) ? $service_proviers['city_id'] : ''; ?>
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

                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'service_proviers'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>