<br>

<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        
		<a href="admin_graph"><img width="60px" height="60px" src="../travel_report.png" alt="My Travel Report"></a>
		
		<!--<h1>Admin Report</h1>-->
        
		<div class="row">
			
            <div class="col-md-2">
                <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                    <input name="start_date" id="start_date"  class="form-control" placeholder="From Date" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                    <input name="end_date" id="end_date" placeholder="To Date" class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
            </div>
            
			<div class="col-md-2">
                <select name="dept_id" id="dept_id" class="form-control required select2me"
                        data-placeholder="Select Department" data-error-container="#add-designation-level-error">
                    <option value="0">All Depaerment</option>                                        
                    <?php foreach ($department as $data) { ?>
                        <option value="<?php echo $data['id']; ?>">
                            <?php echo $data['dept_name']; ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
			<div class="col-md-2">
                <select class="form-control required select2me" id="grade_id">
                    <option value="0">All Grades</option>
                    <?php foreach ($grades as $key => $value) { ?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['grade_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
			
        </div>
		
		<div class="row">
            <br>
			
			<div class="col-md-2">
                <select id="city_id" name="city_id" class="form-control required select2me"
                        data-placeholder="Select a Center">
                    <option value='0'>All Cities</option>
                    <?php foreach ($cities as $city) { ?>
                        <option value="<?php echo $city['id']; ?>">
                            <?php echo $city['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
			
			<div class="col-md-2">
                <select id="cost_center_id"  name="cost_center_id" class="form-control required select2me"
                        data-placeholder="Select a Cost Center">
                    <option value='0'>All Cost Center</option>
                    <?php foreach ($cost_center as $cost) { ?>
                        <option value="<?php echo $cost['id']; ?>">
                            <?php echo $cost['city_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <select id="state_id"  name="state_id" class="form-control required select2me"
                        data-placeholder="Select a State">
                    <option value='0'>All State</option>
                    <?php foreach ($states as $data) { ?>
                        <option value="<?php echo $data['id']; ?>">
                            <?php echo $data['state_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control required select2me" id="travel_mode">
                    <option value="0">All Travel Mode</option>
                    <option value="1">Flight</option>
                    <option value="2">Train</option>
                    <option value="3">Car</option>
                    <option value="4">Bus</option>
                </select>
            </div>
            
			<div class="col-md-1 text-center">
                <button class="btn btn_blue" id="clear_btn">Clear</button>
            </div>
			
			</div>
    </div>
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

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

            <div class="portlet light bordered" id="show_report">



                <!--</div>-->
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>


<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        minView: 2,
        // format: 'HH:00'
    });

    $(document).ready(function () {
        get_admin_report();
    });

    $("#clear_btn").click(function () {
        $("#start_date").datepicker('setDate', null);
        $("#end_date").datepicker('setDate', null);
        get_admin_report();
    });

    $('#top_count,#grade_id,#cost_center_id,#city_id,#state_id,#travel_mode,#dept_id,#start_date,#end_date').change(function () {
        get_admin_report();
    });

    function get_admin_report() {
        $("#show_report").html("<div class='alert alert-info'>Loading...</div>");
        $.ajax({
            url: "<?php echo base_url('report/get_admin_report'); ?>",
            type: "POST",
            dataType: "html",
            data: {
                grade_id: $("#grade_id").val(),
                city_id: $("#city_id").val(),
				cost_center_id: $("#cost_center_id").val(),
                state_id: $("#state_id").val(),
                travel_mode: $("#travel_mode").val(),
                dept_id: $("#dept_id").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
            },
            catch : false,
            success: function (data) {
                $("#show_report").html(data);
            },
            error: function () {
                $("#show_report").html("<div class='alert alert-danger'><i class='fa fa-times'></i>Something went wrong, please try again later.</div>");
            }
        });
    }
</script>