<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($hotel) ? 'Edit' : 'Add'); ?> Hotel/Guest House
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

                        <?php if (isset($hotel['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="hotel_name">Hotel/Guest House Name:
                                        <span class="required">*</span></label>
                                        <input type="text" maxlength="255" class="required form-control" name="name"
                                           value="<?php echo isset($hotel['name']) ? $hotel['name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Accommodation Type                                                
                                        <span class="required"> * </span></label>
                                    <?php $type = !empty($hotel['type']) ? $hotel['type'] : ''; ?>
                                    <select id="type" name="type" class="form-control required select2me"
                                            data-placeholder="Select a Accommodation Type">
                                        <option value='1' <?php if (isset($type)) if ($type == "1") echo "selected"; ?>>Hotel</option>
                                        <option value='2' <?php if (isset($type)) if ($type == "2") echo "selected"; ?>>Guest House</option>
                                    </select>
                                </div>
                            </div>                             


                        </div>
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Location                                                
                                        <span class="required"> * </span></label>
                                    <?php $city_id = !empty($hotel['city_id']) ? $hotel['city_id'] : ''; ?>
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
                                <div class="form-group">
                                    <label class="control-label" for="hotel_class">Hotel/Guest House Category:
                                        <span class="required">*</span></label>
                                    <?php $hotel_class = !empty($hotel['category']) ? $hotel['category'] : ''; ?>
                                    <select id="category"  name="category" class="form-control required select2me"
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
                                <div class="form-group">
                                    <label class="control-label" for="class">Single Occupancy Rate:
                                        <span class="required">*</span></label>
                                        <input type="number" class="required form-control" name="half_amount" id="half_amount"
                                           value="<?php
                                           if (isset($type))
                                               if ($type == "2") {
                                                   echo "";
                                               } else {
                                                   echo isset($hotel['half_amount']) ? $hotel['half_amount'] : '';
                                               }
                                           ?>" <?php if (isset($type)) if ($type == "2") echo "disabled"; ?>>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Double Occupancy Rate:
                                        <span class="required">*</span></label>
                                    <input type="number" class="required form-control" name="amount" id="amount"
                                           value="<?php
                                           if (isset($type))
                                               if ($type == "2") {
                                                   echo "";
                                               } else {
                                                   echo isset($hotel['amount']) ? $hotel['amount'] : '';
                                               }
                                           ?>" <?php if (isset($type)) if ($type == "2") echo "disabled"; ?>>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Hotel/Guest House Address:</label>
                                        <textarea class="form-control" rows="4" name="address" id="address"><?php echo isset($hotel['address']) ? $hotel['address'] : ''; ?></textarea>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Care Taker/Hotel Phone Number:</label>
                                    <input type="text" class="form-control intonly" name="phone" id="phone" value="<?php echo isset($hotel['phone']) ? $hotel['phone'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="travel_type" id="travel_type" value="5">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'hotel_category'; ?>" class="btn default">Cancel</a>
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
        $('#type').change(function () {
            if ($(this).find('option:selected').val() == '2') {
                $('#amount').val('');
                $('#amount').prop('disabled', true);
                $('#half_amount').val('');
                $('#half_amount').prop('disabled', true);
            } else {
                $('#amount').prop('disabled', false)
                $('#half_amount').prop('disabled', false)
            }
        });

    });
</script>