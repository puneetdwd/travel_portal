<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Bus Request
        </h1>
        <div class="pull-right">
            <span id="alert_msg"></span>
            <span id="success_msg" style="color:green"></span>
            <span id="error_msg" style="color:red"></span>
            <a class="btn btn_blue" href="<?php echo base_url('flight_travel/index') ?>">Flight Travel</a>
            <a class="btn btn_blue" href="<?php echo base_url('train_travel/index') ?>">Train Travel</a>
            <a class="btn btn_blue" href="<?php echo base_url('car_travel/index') ?>">Car Travel</a>
        </div>
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


                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dtp_input1" class="control-label">Departure Date</label>
                                    <div class="input-group date form_datetime" data-date="<?php echo isset($travel_request['departure_date']) ? $travel_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                        <input name="departure_date" id="departure_date"  class="form-control" size="16" type="text" value="<?php echo isset($travel_request['departure_date']) ? $travel_request['departure_date'] : date("Y-m-d", strtotime("+1 day")) . " 07:00:00"; ?>" readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" /><br/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php
                                    if (isset($travel_request)) {
                                        if ($travel_request['return_date'] == '0000-00-00 00:00:00') {
                                            $return_date = '';
                                        } else if ($travel_request['return_date'] != '') {
                                            $return_date = $travel_request['return_date'];
                                        } else {
                                            $return_date = '';
                                        }
                                    } else {
                                        $return_date = '';
                                    }
                                    ?>
                                    <label for="dtp_input1" class="control-label">Return Date</label>
                                    <div class="input-group date form_datetime" data-date="<?php echo isset($travel_request['departure_date']) ? $travel_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T018:00:07Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                        <input name="return_date" id='return_date' class="form-control" size="16" type="text" value="<?php echo $return_date; ?>" readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" /><br/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class ="form-group">
                                    <label class="control-label">Travel Reason                                               
                                        <span class="required"> * </span></label>
                                    <select id="travel_reason_id"  name="travel_reason_id" class="form-control required select2me"
                                            data-placeholder="Select a Travel Reason">
                                        <option value=''></option>
                                        <?php $travel_reason_id = !empty($travel_request['travel_reason_id']) ? $travel_request['travel_reason_id'] : ''; ?>

                                        <?php foreach ($travel_reasons as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $travel_reason_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['reason']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class ="form-group">
                                    <label class="control-label">Travel Class                                               
                                        <span class="required"> * </span></label>
                                    <?php $traverl_class_id = !empty($travel_request['travel_class_id']) ? $travel_request['travel_class_id'] : ''; ?>
                                    <?php
                                    if ($traverl_class_id == '') {
                                        if (!empty($sel_traverl_class['travel_class'])) {
                                            $traverl_class_id = $sel_traverl_class['travel_class'];
                                        }
                                    }
                                    ?>       
                                    <select id="travel_class_id"  name="travel_class_id" class="form-control required select2me"
                                            data-placeholder="Select a Travel Class">
                                        <option value=''></option>                                       

                                        <?php foreach ($bus_category as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $traverl_class_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-md-3">
                                <div class ="form-group">
                                    <label class="control-label">From Location                                               
                                        <span class="required"> * </span></label>
                                    <select id="from_city_id"  name="from_city_id" class="form-control required select2me"
                                            data-placeholder="Select a From Location">
                                        <option value=''></option>
                                        <?php $from_city_id = !empty($travel_request['from_city_id']) ? $travel_request['from_city_id'] : ''; ?>
                                        <?php
                                        if ($from_city_id == '') {
                                            if (!empty($employee['city_id'])) {
                                                $from_city_id = $employee['city_id'];
                                            }
                                        }
                                        ?>

                                        <?php foreach ($city as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $from_city_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class ="form-group">
                                    <label class="control-label">To Location                                               
                                        <span class="required"> * </span></label>
                                    <select id="to_city_id"  name="to_city_id" class="form-control required select2me"
                                            data-placeholder="Select a To Location">
                                        <option value=''></option>
                                        <?php $to_city_id = !empty($travel_request['to_city_id']) ? $travel_request['to_city_id'] : ''; ?>

                                        <?php foreach ($city as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $to_city_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Select for Group Travel</label>
                                    <select id="member_list"  name="member_list[]" class="form-control select2me" multiple=""
                                            data-placeholder="Select Group Member">
                                        <option value=''></option>                                        
                                        <?php $project_id = !empty($flight_request['project_id']) ? $flight_request['project_id'] : ''; ?>
                                        <?php
                                        foreach ($employees as $data) {
                                            if ($data['id'] != $employee['id']) {
                                                ?>
                                                <option value="<?php echo $data['id']; ?>"
                                                        <?php if ($data['id'] == $project_id) { ?> selected="selected" <?php } ?>
                                                        >
                                                            <?php echo $data['gi_email']; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>                                    
                                </div>
                            </div>
                            <!--                            <div class="col-md-3">
                                                            <div class ="form-group">
                                                                <label class="control-label">Projects                                               
                                                                    <span class="required"> * </span></label>
                                                                <select id="project_id"  name="project_id" class="form-control required select2me"
                                                                        data-placeholder="Select a Project">
                                                                    <option value=''></option>                                        
                            <?php $project_id = !empty($flight_request['project_id']) ? $flight_request['project_id'] : ''; ?>
                            <?php foreach ($projects as $data) { ?>
                                                                                <option value="<?php echo $data['id']; ?>"
                                <?php if ($data['id'] == $project_id) { ?> selected="selected" <?php } ?>
                                                                                        >
                                <?php echo $data['name']; ?>
                                                                                </option>
                            <?php } ?>
                                                                </select>                                    
                                                            </div>
                                                        </div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Comments</label>
                                    <?php $comment = !empty($travel_request['comment']) ? $travel_request['comment'] : ''; ?>
                                    <textarea class="form-control" rows="5" name="comment" id="comment" placeholder="Any Other Comments"><?php echo $comment; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">                                    
                                    <label class="control-label">Others</label>
                                    <?php $others = !empty($flight_request['others']) ? $flight_request['others'] : ''; ?>
                                    <input type="text" name="others" id="others" class="form-control" value="<?php echo $others; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">                                    
                                    <label class="control-label col-md-12">Trip Type</label>
                                    <input type="radio" name="trip_type" id="others" class="form-control required" value="0" checked=""> OneWay Trip
                                    <input type="radio" name="trip_type" id="others" class="form-control required" value="1"> Round Trip
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">                        
                        <input type="hidden" id="travel_type" name="travel_type" value="4">
                        <input type="hidden" id="request_number" name="request_number" value="<?php echo $request_number; ?>">
                        <input type="hidden" id="reporting_manager_id" name="reporting_manager_id" value="<?php echo $reporting_manager_id; ?>">
                        <input type="hidden" id="approval_level" name="approval_level" value="<?php echo $approval_level; ?>">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'employee_request'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        save_request();
    });
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        startDate: "<?php echo date("Y-m-d", strtotime("+1 day")); ?> 07:00:00",
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
</script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        startDate: "<?php echo date("Y-m-d", strtotime("+1 day")); ?> 07:00:00",
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
</script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        startDate: "<?php echo date("Y-m-d", strtotime("+1 day")); ?> 07:00:00",
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    window.setInterval(function () {
        save_request();
    }, 20000);

    function save_request() {
        $('#success_msg').html('');
        $('#alert_msg').html('Saving..');
        $('#error_msg').html('');
        $.ajax({
            url: '<?php echo site_url('flight_travel/save_to_draft'); ?>',
            data: {
                'travel_type': $('#travel_type').val(),
                'request_number': $('#request_number').val(),
                'approval_level': $('#approval_level').val(),
                'reporting_manager_id': $('#reporting_manager_id').val(),
                'departure_date': $('#departure_date').val(),
                'return_date': $('#return_date').val(),
                'travel_reason_id': $('#travel_reason_id').val(),
                'travel_class_id': $('#travel_class_id').val(),
                'from_city_id': $('#from_city_id').val(),
                'to_city_id': $('#to_city_id').val(),
                'comment': $('#comment').val(),
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            type: 'post',
            dataType: 'json',
            catch : false,
            success: function (data) {
                var status = data.status;
                var msg = data.msg;
                $('#alert_msg').html('');
                if (status == '1') {
                    $('#success_msg').html(msg);
                } else {
                    $('#error_msg').html(msg);
                }
            }
        });
    }
</script>
