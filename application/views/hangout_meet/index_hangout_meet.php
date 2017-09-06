<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <p style="font-size: 22px;">
            Hangouts Meeting
        </p>
        <!--        <h1>
                    Hangouts Meeting
                </h1>-->
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <form role="form" action="<?php echo base_url('hangout_meet/create'); ?>" class="validate-form" method="post" id="myform" name="myform">
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
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-times"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php } else if ($this->session->flashdata('success')) { ?>
                            <div class="alert alert-success">
                                <i class="fa fa-check"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-actions">
                                    <button class="btn green" type="submit">Save</button>
                                    <a href="<?php echo base_url() . 'dashboard'; ?>" class="btn btn-danger">Discard</a>
                                </div><br>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Event Title:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" placeholder="Enter title" name="title" id="title">
                                </div>
                                <div class="row" style="padding: 0 !important">
                                    <div class="form-group col-md-6">
                                        <label for="dtp_input1" class="control-label">Date</label>
                                        <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d"); ?>T07:00:00Z" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
                                            <input name="start_date" id="start_date"  class="form-control required" size="16" type="text" value="<?php echo date("Y-m-d H") . ":00:00"; ?> " readonly>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                        </div>
                                        <!--<label id="start_date-error" class="error" for="start_date"></label>-->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <!--<br>-->
                                        <label for="dtp_input1" class="control-label">&nbsp;</label>
                                        <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d"); ?>T07:00:00Z" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
                                            <input name="end_date" id="end_date"  class="form-control required" size="16" type="text" value="" readonly>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                        </div>
                                        <!--<label id="end_date-error" class="error" for="end_date"></label>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Where:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="location" id="location">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Description:
                                        <span class="required">*</span></label>
                                    <textarea rows="4" class="required form-control" name="description" id="description"></textarea>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <div class ="form-group">
                                        <label class="control-label" style="margin-top: 13px;">Employee Group Meeting</label>
                                        <input id="dd_user_input" type="text" class="form-control" onblur="if (this.value == '')
                                                    this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
                                                                this.value = '';" placeholder="Select Travelling Colleague" /> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="show_student_list" name="show_student_list">
                                            <div class="list-group">
                                                <li class="list-group-item list-group-header">
                                                    <span class="badge"><?php echo "0"; ?></span><b>Employees List</b>
                                                </li>                                                
                                            </div>
                                        </div> 
                                    </div> 
                                    <br>
                                </div>                            
                                <div class="col-md-6">
                                    <label class="control-label col-md-6">&nbsp;</label>
                                    <a  onclick="add_row()" class="btn btn-xs btn_blue col-md-6 pull-right"><i class="fa fa-plus"></i> Add Guest</a>
                                    <br><table class="table table-bordered"><br>
                                        <thead>
                                            <tr class="cust_default_font">
                                                <th class='col-md-1'>#</th>
                                                <th class='col-md-11'>Email<span class="required"> * </span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"> 
                                        </tbody>
                                        <input type="hidden" name="other_row" id="other_row" value="1">
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="sel_emp">

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCdGlqSgU-wNjCn6_mig33UF5yv5QB7tqI"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            initialize();
                                            google.maps.event.addDomListener(window, 'load', initialize);

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


                                            $("#start_date,#end_date").change(function () {
                                                var startDate = document.getElementById("start_date").value;
                                                var endDate = document.getElementById("end_date").value;

                                                if ((Date.parse(endDate) < Date.parse(startDate))) {
                                                    alert("End date should be greater than Start Date");
                                                    document.getElementById("end_date").value = "";
                                                }
                                            });

                                            $('#myform').validate({
                                                rules: {
                                                    start_date: {
                                                        required: true,
                                                    },
                                                    end_date: {
                                                        isAfterStartDate: true
                                                    },
                                                    title: {
                                                        required: true,
                                                    },
                                                    location: {
                                                        required: true,
                                                    },
                                                    description: {
                                                        required: true,
                                                    },
                                                },
                                                messages: {
                                                    start_date: {
                                                        required: 'Please select Start Date',
                                                    },
                                                    end_date: {
                                                        required: 'Please select End Date',
                                                    },
                                                    title: {
                                                        required: 'Title is required',
                                                    },
                                                    location: {
                                                        required: 'Title is required',
                                                    },
                                                    description: {
                                                        required: 'Descripition is required',
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

                                        function initialize() {
                                            var input = document.getElementById('location');
                                            var autocomplete = new google.maps.places.Autocomplete(input);
                                        }

                                        function add_row() {
                                            var other_row = $("#other_row").val();
                                            var html = "<tr id='row_id_" + other_row + "'><td class='col-md-1'><a  onclick='remove_row(" + other_row + ")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>";
                                            html += "<td class='col-md-3'><input type='email' name='email[]' id='email" + other_row + "' class='form-control required'></td>";
                                            $("#tbody").append(html);
                                            other_row++;
                                            $("#other_row").val(other_row);
                                        }

                                        function remove_row(id) {
                                            $("#row_id_" + id).remove();
                                        }
</script>


<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">
                                        $('.form_datetime').datetimepicker({
                                            weekStart: 1,
                                            todayBtn: 1,
                                            startDate: "<?php echo date("Y-m-d h", strtotime("-15 day")) . ":00:00"; ?>",
                                            autoclose: 1,
                                            todayHighlight: 1,
                                            startView: 2,
                                            forceParse: 0,
                                            showMeridian: 1,
                                            minView: 1,
                                            // format: 'HH:00'
                                        });
</script>
<script type="text/javascript" src="<?php echo base_url() . "assets/autocomplete/jquery-ui-1.8.2.custom.min.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">
                                        $(function () {
                                            $("#dd_user_input").autocomplete({
                                                source: '<?php echo site_url('employees/find_employees'); ?>',
                                                minLength: 1,
                                                select: function (event, ui) {
                                                    var emp_id = ui.item.id;
                                                    if (emp_id != '#') {
                                                        $("#sel_emp").val(emp_id);
                                                        save_employee();
                                                    }
                                                },
                                                html: true,
                                                open: function (event, ui) {
                                                    $("#sel_emp").val('');
                                                    $(".ui-autocomplete").css("z-index", 1000);
                                                }
                                            });

                                        });

                                        function save_employee() {
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
                                                        alert("Employee not added!");
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
                                                    $("#sel_emp").val('');
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
