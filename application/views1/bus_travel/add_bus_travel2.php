<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Bus Request
        </h1>
        <div class="pull-right">
            <span id="alert_msg" class="col-xs-12" style="padding: 0;"></span>
            <span id="success_msg" class="col-xs-12" style="color:green; padding: 0;"></span>
            <span id="error_msg" class="col-xs-12" style="color:red; padding: 0;"></span><div class="hidden-md hidden-lg hidden-xs"><br></div>
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
                <form role="form" class="" method="post" id="myform">
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
                                    <div class="input-group date form_datetime" data-date="<?php echo isset($travel_request['departure_date']) ? $travel_request['departure_date'] : date("Y-m-d"); ?>T07:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                        <input name="departure_date" id="departure_date"  class="form-control" size="16" type="text" value="<?php echo isset($travel_request['departure_date']) ? $travel_request['departure_date'] : date("Y-m-d H") . ":00:00"; ?> " readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>                                    
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
                                    <div class="input-group date form_datetime" data-date="<?php echo isset($travel_request['departure_date']) ? $travel_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T018:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                        <input name="return_date" id='return_date' class="form-control" size="16" type="text" value="<?php echo $return_date; ?>" readonly onchange="check_date()">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                    <label id="return_date-error" class="error" for="return_date"></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class ="form-group">
                                    <label class="control-label">Travel Reason                                               
                                        <span class="required"> * </span></label>
                                    <select id="travel_reason_id"  name="travel_reason_id" class="form-control required select2me"
                                            data-placeholder="Select a Travel Reason">
                                        <option value=''></option>                                        
                                        <option value='Projects'>Projects</option>    
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
                            <div class="col-md-2" id="project_div" style="display: none">
                                <div class ="form-group">
                                    <label class="control-label">Projects                                               
                                        <span class="required"> * </span></label>
                                    <select id="project_id"  name="project_id" class="form-control required select2me"
                                            data-placeholder="Select a Project">
                                        <option value=''></option>                                        
                                        <?php $project_id = !empty($travel_request['project_id']) ? $travel_request['project_id'] : ''; ?>
                                        <?php foreach ($projects as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $project_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
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
                                <div class="form-group">                                    
                                    <label class="control-label">Comments</label>
                                    <?php $comment = !empty($travel_request['comment']) ? $travel_request['comment'] : ''; ?>
                                    <!--<textarea ><?php echo $comment; ?></textarea>-->
                                    <input type="text" class="form-control" rows="5" name="comment" id="comment" placeholder="Any Other Comments" value="<?php echo $comment; ?>">
                                </div>                                
                            </div>
                        </div>
                        <div class="row">
                            <br>
                            <fieldset>
                                <legend>Group Travel</legend>
                                <div class="col-md-4">
                                    <div class ="form-group">
                                        <label class="control-label" style="margin-top: 13px;">Employee Group Travel</label>
                                        <input id="dd_user_input" type="text" class="form-control" onblur="if (this.value == '')
                                                    this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
                                                                this.value = '';" /> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="show_student_list" name="show_student_list">

                                        </div> 
                                    </div> 
                                    <br>
                                </div>                            
                                <div class="col-md-8">
                                    <label class="control-label col-md-6">&nbsp;</label>
                                    <a  onclick="add_row()" class="btn btn-xs btn_blue col-md-3 pull-right"><i class="fa fa-plus"></i> Add Guest</a>
                                    <br><table class="table table-bordered"><br>
                                        <thead>
                                            <tr class="cust_default_font">
                                                <th>Remove</th>
                                                <th>Guest Name</th>
                                                <th>Age</th>
                                                <th>Mobile No</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"> 
                                        </tbody>
                                        <input type="hidden" name="other_row" id="other_row" value="1">
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-actions">
                                    <br>
                                    <input type="hidden" id="travel_type" name="travel_type" value="4">                        
                                    <input type="hidden" id="request_number" name="request_number" value="<?php echo $request_number; ?>">
                                    <input type="hidden" id="reporting_manager_id" name="reporting_manager_id" value="<?php echo $reporting_manager_id; ?>">
                                    <input type="hidden" id="approval_level" name="approval_level" value="<?php echo $approval_level; ?>">
                                    <input type="hidden" id="draft" name="draft" value="0">
                                    <button class="btn green" onclick="draftsave()" type="submit">Submit</button>
                                    <a href="<?php echo base_url() . 'employee_request'; ?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<input type="hidden" id="sel_emp">
<input type="hidden" name="trip_type" value="0">
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            var isAfterStartDate = function (startDateStr, endDateStr) {
                                                var startDateStr = new Date(startDateStr),
                                                        endDateStr = new Date(endDateStr);
                                                if (endDateStr != '') {
                                                    if (startDateStr > endDateStr) {
                                                        return false;
                                                    } else {
                                                        return true;
                                                    }
                                                } else {
                                                    return true;
                                                }

                                            };
                                            $.validator.addMethod("isAfterStartDate", function (value, element) {
                                                return isAfterStartDate($('#departure_date').val(), value);
                                            }, "Return Date should be after Departure Date");


                                            $('#myform').validate({
                                                rules: {
                                                    departure_date: {
                                                        required: true,
                                                    },
                                                    return_date: {
                                                        isAfterStartDate: true
                                                    },
                                                    travel_reason_id: {
                                                        required: true,
                                                    },
                                                    travel_class_id: {
                                                        required: true,
                                                    },
                                                    project_id: {
                                                        required: true,
                                                    },
                                                    from_city_id: {
                                                        required: true,
                                                    },
                                                    to_city_id: {
                                                        required: true,
                                                    },
                                                },
                                                messages: {
                                                    departure_date: {
                                                        required: 'Please select Departure Date',
                                                    },
                                                    return_date: {
                                                        required: 'Please select Return Date',
                                                    },
                                                    travel_reason_id: {
                                                        required: 'Please select Travel Reason',
                                                    },
                                                    travel_class_id: {
                                                        required: 'Please select Travel Class',
                                                    },
                                                    project_id: {
                                                        required: 'Please select Project',
                                                    },
                                                    from_city_id: {
                                                        required: 'Please select From Location',
                                                    },
                                                    to_city_id: {
                                                        required: 'Please select To Location',
                                                    },
                                                },
                                                highlight: function (element) { // hightlight error inputs
                                                    $(element)
                                                            .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                                                },

                                                unhighlight: function (element) { // revert the change done by hightlight
                                                    $(element)
                                                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                                                },

                                            });
                                        });

                                        function add_row() {
                                            var other_row = $("#other_row").val();
                                            var html = "<tr id='row_id_" + other_row + "'><td class='col-md-1'><a  onclick='remove_row(" + other_row + ")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>";
                                            html += "<td class='col-md-3'><input type='text' name='employee_name[]' id='employee_name" + other_row + "' class='form-control required '></td>";
                                            html += "<td class='col-md-2'><input type='number'  maxlength='3' onkeyup='check_val()' name='age[]' id='age" + other_row + "' class='intonly required form-control number intonly' number='true'></td>";
                                            html += "<td class='col-md-3'><input type='text' name='mobile_no[]' id='mobile_no" + other_row + "' class='form-control required'></td>";
                                            html += "<td class='col-md-3'><input type='email' name='email[]' id='email" + other_row + "' class='form-control required'></td>";
                                            $("#tbody").append(html);
                                            other_row++;
                                            $("#other_row").val(other_row);
                                        }

                                        function check_val() {
                                            var other_row = $("#other_row").val();
                                            for (var i = 1; i < other_row; i++) {
                                                var age = $("#age" + i).val();
                                                if (Math.floor(age) == age && $.isNumeric(age)) {

                                                } else {
                                                    $("#age" + i).val('');
                                                }
                                            }
                                        }

                                        function remove_row(id) {
                                            $("#row_id_" + id).remove();
                                            received_total();
                                        }
</script>
<script type="text/javascript">
    $(document).ready(function () {
//        save_request();

        $('#travel_reason_id').on('change', function () {
            $("#project_div").css('display', (this.value == 'Projects') ? 'block' : 'none');
        });
    });

    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        startDate: "<?php echo date("Y-m-d h"); ?>",
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        minView: 1,
        // format: 'HH:00'
    });

    function draftsave() {
        $('#draft').val('1');
    }

    window.setInterval(function () {
        save_request();
    }, 20000);

    function save_request() {
        $('#success_msg').html('');
        $('#alert_msg').html('Saving..');
        $('#error_msg').html('');
        var draft = $('#draft').val();
        if (draft != '1') {
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
    }
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
                    $("#sel_emp").val(stud_id);
                    save_studnet();
                }
            },
            html: true,
            open: function (event, ui) {
                $("#sel_emp").val('');
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });

    });

    function save_studnet() {
        $("#dd_user_input").attr("disabled", "disabled");
        var sel_emp = $("#sel_emp").val();
        $.ajax({
            url: "<?php echo base_url('employees/add_employee/'); ?>",
            type: "POST",
            data: {sel_emp: sel_emp, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            catch : false,
            success: function (data) {
                if (data == '1') {
                    $("#dd_user_input").removeAttr("disabled");
                    get_emp_list();
                } else {
                    $("#dd_user_input").removeAttr("disabled");
                    alert("Student not added!");
                }
            }
        });
    }

    function get_emp_list() {
        $.ajax({
            url: "<?php echo base_url('employees/get_employee/'); ?>",
            type: "POST",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "html",
            catch : false,
            success: function (data) {
                $('#show_student_list').html(data);
                $("#stud_id").val('');
                $("#dd_user_input").val('');
                $("#dd_user_input").focus();
            }
        });
    }


    function delete_employee(id) {
        $.ajax({
            url: "<?php echo base_url('employees/delete_employees'); ?>",
            type: "POST",
            data: {emp_id: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "html",
            catch : false,
            success: function (data) {
                get_emp_list();
            }
        });
    }

</script>