<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
.modal-lg {
width: 1300px;
}
.pull-left {float: left !important;text-align: left;}
</style>
<div class="page-content">
<!-- BEGIN PAGE HEADER-->
<div class="breadcrumbs">

<div class="pull-left"><img src="assets/images/train-icon" /></div>
<div class="pull-mob" style="margin-top:15px">
<a title="Hotel Search" class="btn btn-success" href="javascript:void(0)" data-toggle="modal" data-target="#hotel_modal"><i class="fa fa-bed"></i></a>
<a title="Flight Travel" class="btn btn_blue" href="<?php echo base_url('flight_travel/index') ?>"><i class="fa fa-plane"></i></a>
<a title="Car Travel" class="btn btn_blue" href="<?php echo base_url('car_travel/index') ?>"><i class="fa fa-car"></i></a>
<a title="Bus Travel" class="btn btn_blue" href="<?php echo base_url('bus_travel/index') ?>"><i class="fa fa-bus"></i></a>
</div>

</div>
<!-- END PAGE HEADER-->
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
<div class="portlet light borderLight">
<!--<div class="portlet-body form">-->
<form role="form" class="" method="post" id="trf_form">
<!--<form role="form" class="validate-form" method="post" id="myform">-->
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


<div class="row"><div class="col-md-3"><div class="form-group">
<label for="dtp_input1" title="Select your departure date" class="control-label">Departure Date</label>
<div class="input-group date form_datetime" data-date="<?php echo isset($travel_request['departure_date']) ? date(DATETIME_FORMAT, strtotime($travel_request['departure_date'])) : date(DATETIME_FORMAT); ?>T07:00Z" data-link-field="dtp_input1">
<input title="Select your departure date" name="departure_date" id="departure_date"  class="form-control required" size="16" type="text" value="<?php echo isset($travel_request['departure_date']) ? date(DATETIME_FORMAT, strtotime($travel_request['departure_date'])) : date(DATETIME_FORMAT); ?>" readonly>
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div><input type="hidden" id="dtp_input1" value="" /></div></div>
<div class="col-md-3"><div class="form-group"><?php
if(isset($travel_request))
 {
  if(isset($travel_request['return_date']))
   {
	if($travel_request['return_date'] == '0000-00-00 00:00:00')
	 {
	  $return_date = '';
	 }
	elseif($travel_request['return_date'] != '')
	 {
	  $return_date = date(DATETIME_FORMAT, strtotime($travel_request['return_date']));
	 }
	else
	 {
	  $return_date = '';
	 }
   }
  else
   {
	$return_date = '';
   }
 }
else
 {
  $return_date = '';
 }

?><label for="dtp_input1" title="Select your approximate return date" class="control-label">Return Date</label>
<div class="input-group date form_datetime" data-date="<?php echo isset($travel_request['departure_date']) ? date(DATETIME_FORMAT, strtotime($travel_request['departure_date'])) : date(DATETIME_FORMAT, strtotime("+1 day")); ?>T07:00Z" data-link-field="dtp_input1">
<input title="Select your approximate return date" name="return_date" id='return_date' class="form-control required" size="16" type="text" value="<?php echo $return_date; ?>" readonly onchange="check_date()">
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div>
<label id="return_date-error" class="error" for="return_date" style="display:none"></label></div></div>

<div class="col-md-2"><div class ="form-group">
<label title="Select your reason of travel" class="control-label">Travel Reason                                               
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
<option value='Other'>Other</option>    
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

<?php foreach ($train_category as $data) { ?>
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
<input type="text" class="form-control" rows="5" name="comment" id="comment" placeholder="Mention your ID proof details, and preferred train." value="<?php echo $comment; ?>">
</div>                                
</div>
</div>
<div class="row marginZero">
<br>
<fieldset>
<legend>For Group Travel</legend>
<div class="col-md-4">
<div class ="form-group">
<label class="control-label" style="margin-top: 13px;">Employee Group Travel</label>
<input id="dd_user_input" type="text" class="form-control" onblur="if (this.value == '')
this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
this.value = '';" placeholder="Select Travelling Colleague" /> 
</div>
<div class="row">
<div class="col-md-12" id="show_student_list" name="show_student_list">

</div> 
</div> 
<br>
</div>                            
<div class="col-md-8">
<label class="control-label col-md-6">&nbsp;</label>
<a onclick="add_guest_row_trf()" class="btn btn-xs btn_blue col-md-3 pull-right"><i class="fa fa-plus"></i> Add Guest</a>
<br><table class="table table-bordered"><br>
<thead>
<tr class="cust_default_font">
<th>Remove</th>
<th>Guest Name<span class="required"> * </span></th>
<th>Age<span class="required"> * </span></th>
<th>Mobile No<span class="required"> * </span></th>
<th>Email<span class="required"> * </span></th>
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
<input type="hidden" id="travel_type" name="travel_type" value="2">                        
<input type="hidden" id="return_travel_type" name="return_travel_type" value="2">                        
<input type="hidden" id="request_number" name="request_number" value="<?php echo $request_number; ?>">
<input type="hidden" id="reporting_manager_id" name="reporting_manager_id" value="<?php echo $reporting_manager_id; ?>">
<input type="hidden" id="approval_level" name="approval_level" value="<?php echo $approval_level; ?>">
<input type="hidden" id="draft" name="draft" value="0">
<button class="btn green" onclick="draftsave()" type="submit">Submit</button> 
<a href="<?php echo base_url(); ?>" class="btn default">Discard</a>
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
<!-- END PAGE CONTENT-->
</div>
<input type="hidden" id="sel_emp">
<input type="hidden" name="trip_type" value="0">

<!-- hotel popup api -->
<div class="modal fade" id="hotel_modal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Hotel search</h4>
</div>
<div class="modal-body">
<div class="row">
<div class="col-md-12">
<div class="portlet light bordered">
<!--<div class="portlet-body form">-->
<form role="form" class="" method="post" id="hotel_search_form" novalidate="novalidate">
<div class="form-body">                
<div class="row">
<div class="col-md-3">
<div class="form-group">
<label for="dtp_input1" class="control-label">Check In Date</label>
<div class="input-group date form_datetime_j" data-date="<?= date(DATETIME_FORMAT_API); ?>" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
<input name="check_in_j" id="check_in_j" class="form-control" size="16" value="<?= date(DATETIME_FORMAT_API); ?>" readonly="" aria-required="true" aria-invalid="false" type="text">
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div>
<input id="dtp_input1" value="" type="hidden"><br>
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<label for="dtp_input1" class="control-label">Check Out Date</label>
<div class="input-group date form_datetime_j" data-date="<?= date(DATETIME_FORMAT_API); ?>" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
<input name="check_out_j" id="check_out_j" class="form-control" size="16" value="" readonly="" onchange="check_date()" type="text">
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div>
<label id="return_date-error" class="error" for="return_date"></label>
</div>
</div>

<div class="col-md-3"><div class="form-group"><label class="control-label">Select city                                               
<span class="required" aria-required="true"> * </span></label>
<select id="hotel_city_id_j" class="form-control required select2me " data-placeholder="Select city">
</select></div></div>

<div class="col-md-3"><div class="form-group"><label class="control-label">Rooms                                               
<span class="required" aria-required="true"> * </span></label>
<select id="hotel_room_j" name="hotel_room_j" class="form-control required select2me " data-placeholder="Select no of rooms" aria-required="true" tabindex="-1" aria-hidden="true">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
</div>
</div>
</div>

<div class="row"><div class="col-md-12"><div class=" pull-right">                   
<button type="button" id="search_hotel" class="btn btn-success">Search Hotel <span class="fa fa-arrow-right"></span></button>
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>

<div id="ajaxwaiting" style="display: none">                
<div class="alert alert-info">
Loading...
</div>
<!--<img src="assets/images/loading.gif" title="Loader" alt="Loader" />-->
</div>

<div class="table-responsive" id="display"><div class="row"><div class="col-md-12">
<div class=" pull-right"><p id="hotels_found"></p></div></div></div>

<table class="table" id="hotel_search_table" class="display" cellspacing="0" width="90%">
<thead><tr><th>Image</th><th>Hotel name</th><th>Rating</th>
<th>Total price</th></tr></thead><tbody></tbody></table>

<ul class="pagination pull-right">
<li class="disabled" id="hotel_search_table_paginate_pre_j"><a href="javascript:void(0)" onclick="preHotel()">Previous</a></li>
<li class="active"><a href="javascript:void(0)" id="hotel_search_table_paginate_current_j"></a></li>
<li><a href="javascript:void(0)" id="hotel_search_table_paginate_next_j" onclick="nextHotel()">Next</a></li>
</ul></div></div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div></div></div>

<div class="modal fade" id="hangout_popup" role="dialog">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Confirmation</h4></div>
<div class="modal-body"><p>Do you want to create hangout meeting instead of travelling ?</p>
<p>Click "Yes" to create a hangouts meeting or "No" to continue with your request.</p>
</div><div class="modal-footer">
<a href="<?php echo base_url('hangout_meet'); ?>" class="btn btn-success">Yes</a>
<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div></div></div></div>

<div class="modal fade" id="greaterDate" role="dialog">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Warning</h4></div>
<div class="modal-body"><p>Return date should be greater than departure date</p>
</div></div></div></div>

<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">

//$("#greaterDate").modal();

$(document).ready(function () {
check_hangout_suggestion();
$('.form_datetime').datetimepicker({
weekStart: 1,
todayBtn: 1,
startDate: "<?php echo date("Y-m-d h", strtotime("-15 day")) . ":00"; ?>",
autoclose: 1,
todayHighlight: 1,
startView: 2,
forceParse: 0,
showMeridian: 1,
minView: 1,
format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
});
$('#travel_reason_id').on('change', function () {
$("#project_div").css('display', (this.value == 'Projects') ? 'block' : 'none');
//                                    if (this.value == 'Other') {
//                                        $("#comment").addClass('required');
//                                    } else {
//                                        $("#comment").removeClass('required');
//                                        $("#comment").removeClass('has-error');
//                                        $("#comment").attr('aria-invalid', 'false');
//                                        $("#comment-error").css('display', 'none');
//                                    }

});
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
}};

$.validator.addMethod("isAfterStartDate", function (value, element) {
return isAfterStartDate($('#departure_date').val(), value);
}, "Return Date should be after Departure Date");



$("#departure_date").change(function () {

var startDate1 = $('#departure_date').val().split(' ');
var sD= startDate1[0].split('-');
var startDate = sD[1]+'-'+sD[0]+'-'+sD[2]+' '+startDate1[1]+':00';

var currentDateTime= '<?php echo date('m-d-Y h:i:s', time()); ?>';
var b= new Date(startDate);
var c= new Date(currentDateTime);

if(b<c)
 {
  alert('As far as possible, you should plan their travel well in advance in order to available lowest fares possible.');
 }

if($('#return_date').val()!='')
 {
  var endDate1 = $('#return_date').val().split(' ');
  var eD= endDate1[0].split('-');
  var endDate = eD[1]+'-'+eD[0]+'-'+eD[2]+' '+endDate1[1]+':00';
  var a= new Date(endDate);
  if(Date.parse(a)==Date.parse(b))
   {
	alert("Departure date and Return date should not be same.");
	$('#return_date').val('');
   }
  else
   {
    if((Date.parse(endDate) < Date.parse(startDate)))
     {
	  alert("Return date should be greater than Departure Date");
	  $('#return_date').val('');
     }
   }
  var diff = new Date(a - b);
  var days = diff/1000/60/60/24;
  var dayDiff= parseInt(days);
  if(dayDiff>15)
  {
   alert('Your travel will be treated as deputation and expense will be covered under the business travel deputation policy.');
  }
 }
});

$("#return_date").change(function () {

var startDate1 = $('#departure_date').val().split(' ');
var sD= startDate1[0].split('-');
var startDate = sD[1]+'-'+sD[0]+'-'+sD[2]+' '+startDate1[1]+':00';
var b= new Date(startDate);
if($('#return_date').val()!='')
 {
  var endDate1 = $('#return_date').val().split(' ');
  var eD= endDate1[0].split('-');
  var endDate = eD[1]+'-'+eD[0]+'-'+eD[2]+' '+endDate1[1]+':00';
  var a= new Date(endDate);
  if(Date.parse(a)==Date.parse(b))
   {
	alert("Departure date and Return date should not be same.");
	$('#return_date').val('');
   }
  else
   {
    if((Date.parse(a) < Date.parse(b)))
     {
	  alert("Return date should be greater than Departure Date");
	  $('#return_date').val('');
     }
   }
  var diff = new Date(a - b);
  var days = diff/1000/60/60/24;
  var dayDiff= parseInt(days);
  if(dayDiff>15)
  {
   alert('Your travel will be treated as deputation and expense will be covered under the business travel deputation policy.');
  }
 }
});












$("#travel_reason_id").change(function(){check_hangout_suggestion();});

function check_hangout_suggestion() {
var travel_reason_id = $("#travel_reason_id").val();
$.ajax({
url: '<?php echo site_url('flight_travel/check_hangout_suggestion'); ?>',
data: {
'travel_reason_id': $('#travel_reason_id').val(),
'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
},
type: 'post',
dataType: 'json',
catch : false,
success: function (data) {
var status = data.status;
if (status == 'success') {
$("#hangout_popup").modal();
}
}
});
}

$("#from_city_id").change(function () {
var from = document.getElementById("from_city_id").value;
var to = document.getElementById("to_city_id").value;
if (from == to) {
alert("To and From Location can not be same..!!");
document.getElementById("from_city_id").value = "";
}
});
$("#to_city_id").change(function () {
var from = document.getElementById("from_city_id").value;
var to = document.getElementById("to_city_id").value;
if (from == to) {
alert("To and From Location can not be same..!!");
document.getElementById("to_city_id").value = "";
}
});
//                                jQuery.validator.addMethod("check_comment", function (value, element, params) {
//                                    var travel_reason_id = $('#travel_reason_id').val();
//                                    var comment = $('#comment').val();
//                                    if ($('#travel_reason_id').val() == "Other") {
//                                        if (comment == "") {
//                                            return false;
//                                        } else {
//                                            return true;
//                                        }
//                                    } else {
//                                        return true;
//                                    }
//                                }, jQuery.validator.format("Please add comment"));

$("#travel_reason_id").change(function () {
if ($('#travel_reason_id').val() == "Other") {
$("#comment").rules("add", {
required: true,
messages: {
required: "Please add comment",
}
});
} else {
$("#comment").rules("remove");
}
});

$('#trf_form').validate({
rules: {
departure_date: {
required: true,
remote: {
url: "<?php echo site_url('flight_travel/requestExiest') ?>",
type: "post",
data: {
departure_date: function () {
return $("#departure_date").val();
},
return_date: function () {
return $("#return_date").val();
},
'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
}
}
},
return_date: {
isAfterStartDate: true,
remote: {
url: "<?php echo site_url('flight_travel/requestExiest') ?>",
type: "post",
data: {
departure_date: function () {
return $("#departure_date").val();
},
return_date: function () {
return $("#return_date").val();
},
'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
}
}
},
travel_reason_id: {
required: true,
//                                            check_comment: true,
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
//                                        comment: {
//                                            check_comment: true,
//                                        },
},
messages: {
departure_date: {
required: 'Please select Departure Date',
remote: "Request already exiest in same during of this date!"
},
return_date: {
required: 'Please select Return Date',
remote: "Request already exiest in same during of this date!"
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
function add_guest_row_trf() {
var other_row = $("#other_row").val();
var html = "<tr id='row_id_" + other_row + "'><td class='col-md-1'><a  onclick='remove_row(" + other_row + ")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>";
html += "<td class='col-md-3'><input type='text' name='employee_name[]' id='employee_name" + other_row + "' class='form-control required '></td>";
html += "<td class='col-md-2'><input type='number' min='0'  maxlength='3' onkeyup='check_val()' name='age[]' id='age" + other_row + "' class='intonly required form-control number intonly' number='true'></td>";
html += "<td class='col-md-3'><input type='text' min='0' maxlength='10' minlength='10' onkeyup='check_mob_val()' name='mobile_no[]' id='mobile_no" + other_row + "' class='form-control required'></td>";
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

function check_mob_val() {
var other_row = $("#other_row").val();
for (var i = 1; i < other_row; i++) {
var age = $("#mobile_no" + i).val();
if (Math.floor(age) == age && $.isNumeric(age)) {

} else {
$("#mobile_no" + i).val('');
}
}
}

function remove_row(id) {
$("#row_id_" + id).remove();
received_total();
}
</script>
<script type="text/javascript">

function check_date() {
var flag;
flag = 'false';
var departure_date = new Date($("#departure_date").val());
var return_date = new Date($("#return_date").val());
if (Number(return_date) > Number(departure_date)) {
flag = 'true';
} else {
flag = 'false';
}
}

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
'return_travel_type': $('#return_travel_type').val(),
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
put_employee();
}
},
html: true,
open: function (event, ui) {
$("#sel_emp").val('');
$(".ui-autocomplete").css("z-index", 1000);
}
});
});
function put_employee() {
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
alert("Something Wen't Wrong!");
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
<script>
$(document).ready(function () {
$('.form_datetime_j').datetimepicker({
weekStart: 1,
todayBtn: 1,
startDate: new Date(),
autoclose: 1,
todayHighlight: 1,
startView: 2,
forceParse: 0,
showMeridian: 1,
minView: 2,
format: "<?php echo DATETIME_FORMAT_DATEPICKER_API; ?>"
});
$('#hotel_search_table').DataTable({
"paging": false,
"info": false
});
//get vcid for hotel search city list
$.getJSON("<?php echo base_url(); ?>/assets/data/hotel_city_list.json", function (data) {
var items = [];
var html = "<option value=''>Select city</option>";
$.each(data, function (key, val) {
html = html + "<option value='" + val.city_id + "'>" + val.city_name + "</option>"
});
$("#hotel_city_id_j").append(html);
});
var formData;
hotel_search_table_paginate_current_j = 1;
$("#hotel_search_table_paginate_current_j").html(hotel_search_table_paginate_current_j);
//hotel search form submit
$("#search_hotel").click(function () {
//            var event = $('#hotel_search_form');
//        $('#hotel_search_form').submit(function (event) {

//            departure_flight_table = $('#hotel_search_table').DataTable({
//                "paging": false,
//                "info": false
//            });
departure_flight_table = $('#hotel_search_table').DataTable();
departure_flight_table.destroy();
$('#hotel_search_table tbody').empty();
hotel_search_table_paginate_current_j = 1;
$('#hotels_found').empty();
$('.form-group').removeClass('has-error'); // remove the error class
$('.help-block').remove(); // remove the error text

// get the form data
// there are many ways to get this data using jQuery (you can use the class or id also)
check_in_j = $('#check_in_j').val();
check_out_j = $('#check_out_j').val();
check_in_j = check_in_j.replace("-", "");
check_out_j = check_out_j.replace("-", "");
var formDataHotel = {
'check_in_j': check_in_j.replace("-", ""),
'check_out_j': check_out_j.replace("-", ""),
'hotel_city_id_j': $("#hotel_city_id_j option:selected").val(),
'hotel_room_j': $("#hotel_room_j option:selected").val()
};
//console.log(formDataHotel);

// process the form
$.ajax({
type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
url: "http://www.goibibo.com/hotels/search-data/?app_id=b6384641&app_key=3143607bd1279532978d34d05ce585ac&vcid=" + formDataHotel['hotel_city_id_j'] + "&ci=" + formDataHotel['check_in_j'] + "&co=" + formDataHotel['check_out_j'] + "&r=" + formDataHotel['hotel_room_j'] + "-1_0&pid=" + hotel_search_table_paginate_current_j,
data: formDataHotel, // our data object
dataType: 'json', // what type of data do we expect back from the server
encode: true,
beforeSend: function () {
// setting a timeout
$("#ajaxwaiting").show();
},
})
// using the done promise callback
.done(function (data) {
$("#ajaxwaiting").fadeOut(2000);
//console.log(data); 
// here we will handle errors and validation messages
if (!data.success) {
$.each(data, function (key, value) {
//var onwardflights= JSON.stringify(val.onwardflights);
//departure flights
console.log(value);
//$.each(value, function(key1, val) {
//console.log(val); 
var row = '';
var record = 'Total Hotels Found <b>' + value.length + '</b>';
//console.log(val.onwardflights.length);
$.each(value, function (k, v) {
//console.log(v.img_selected);
row += '<tr>';
row += '<td><img src="' + v.t + '" alt="thumb" width="100px"></td>';
row += '<td>' + v.hn + '</td>';
row += '<td>' + v.hr + '</td>';
row += '<td>' + v.tp_alltax + '</td>';
//row+='<td>'+v.rtn +'</td>';
row += '</tr>';
});
$('#hotel_search_table tbody').append(row);
$('#hotels_found').html(record);
//row.appendTo('#display');
$('#hotel_search_table').DataTable({
"paging": false,
"info": false
});
//});
});
} else {
$('form').append('<div class="alert alert-success">' + data.message + '</div>');
}
})
// using the fail promise callback
.fail(function (data) {
console.log(data);
});
// stop the form from submitting the normal way and refreshing the page
//            event.preventDefault();
});
function nextHotel() {
hotel_search_table_paginate_current_j++;
$("#hotel_search_table_paginate_current_j").html(hotel_search_table_paginate_current_j);
$("#hotel_search_table_paginate_pre_j").removeClass('disabled');
/*departure_flight_table = $('#hotel_search_table').DataTable({
"paging"  : false,
"info"    : false
});*/
departure_flight_table.destroy();
$('#hotel_search_table tbody').empty();
hotel_search_table_paginate_current_j = 1;
$('#hotels_found').empty();
$('.form-group').removeClass('has-error'); // remove the error class
$('.help-block').remove(); // remove the error text
// get the form data
// there are many ways to get this data using jQuery (you can use the class or id also)
check_in_j = $('#check_in_j').val();
check_out_j = $('#check_out_j').val();
check_in_j = check_in_j.replace("-", "");
check_out_j = check_out_j.replace("-", "");
var formDataHotel = {
'check_in_j': check_in_j.replace("-", ""),
'check_out_j': check_out_j.replace("-", ""),
'hotel_city_id_j': $("#hotel_city_id_j option:selected").val(),
'hotel_room_j': $("#hotel_room_j option:selected").val()
};
//console.log(formDataHotel);
// process the form
$.ajax({
type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
url: "http://www.goibibo.com/hotels/search-data/?app_id=b6384641&app_key=3143607bd1279532978d34d05ce585ac&vcid=" + formDataHotel['hotel_city_id_j'] + "&ci=" + formDataHotel['check_in_j'] + "&co=" + formDataHotel['check_out_j'] + "&r=" + formDataHotel['hotel_room_j'] + "-1_0&pid=" + hotel_search_table_paginate_current_j,
data: formDataHotel, // our data object
dataType: 'json', // what type of data do we expect back from the server
encode: true,
beforeSend: function () {
// setting a timeout
$("#ajaxwaiting").show();
},
})
// using the done promise callback
.done(function (data) {
$("#ajaxwaiting").fadeOut(2000);
//console.log(data); 
// here we will handle errors and validation messages
if (!data.success) {
$.each(data, function (key, value) {
//var onwardflights= JSON.stringify(val.onwardflights);
//departure flights
console.log(value);
//$.each(value, function(key1, val) {
//console.log(val); 
var row = '';
var record = 'Total Hotels Found <b>' + value.length + '</b>';
//console.log(val.onwardflights.length);
$.each(value, function (k, v) {
//console.log(v.img_selected);
row += '<tr>';
row += '<td><img src="' + v.t + '" alt="thumb" width="100px"></td>';
row += '<td>' + v.hn + '</td>';
row += '<td>' + v.hr + '</td>';
row += '<td>' + v.tp_alltax + '</td>';
//row+='<td>'+v.rtn +'</td>';
row += '</tr>';
});
$('#hotel_search_table tbody').append(row);
$('#hotels_found').html(record);
//row.appendTo('#display');
$('#hotel_search_table').DataTable({
"paging": false,
"info": false
});
//});
});
} else {
$('form').append('<div class="alert alert-success">' + data.message + '</div>');
}
})

// using the fail promise callback
.fail(function (data) {
console.log(data);
});
// stop the form from submitting the normal way and refreshing the page
//            event.preventDefault();
}

function preHotel() {
if (hotel_search_table_paginate_current_j - 1) {
hotel_search_table_paginate_current_j--;
$("#hotel_search_table_paginate_current_j").html(hotel_search_table_paginate_current_j);
if (hotel_search_table_paginate_current_j == 1) {
$("#hotel_search_table_paginate_pre_j").addClass('disabled');
}
}

/*departure_flight_table = $('#hotel_search_table').DataTable({
"paging"  : false,
"info"    : false
});*/
departure_flight_table.destroy();
$('#hotel_search_table tbody').empty();
hotel_search_table_paginate_current_j = 1;
$('#hotels_found').empty();
$('.form-group').removeClass('has-error'); // remove the error class
$('.help-block').remove(); // remove the error text
// get the form data
// there are many ways to get this data using jQuery (you can use the class or id also)
check_in_j = $('#check_in_j').val();
check_out_j = $('#check_out_j').val();
check_in_j = check_in_j.replace("-", "");
check_out_j = check_out_j.replace("-", "");
var formDataHotel = {
'check_in_j': check_in_j.replace("-", ""),
'check_out_j': check_out_j.replace("-", ""),
'hotel_city_id_j': $("#hotel_city_id_j option:selected").val(),
'hotel_room_j': $("#hotel_room_j option:selected").val()
};
//console.log(formDataHotel);

// process the form
$.ajax({
type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
url: "http://www.goibibo.com/hotels/search-data/?app_id=b6384641&app_key=3143607bd1279532978d34d05ce585ac&vcid=" + formDataHotel['hotel_city_id_j'] + "&ci=" + formDataHotel['check_in_j'] + "&co=" + formDataHotel['check_out_j'] + "&r=" + formDataHotel['hotel_room_j'] + "-1_0&pid=" + hotel_search_table_paginate_current_j,
data: formDataHotel, // our data object
dataType: 'json', // what type of data do we expect back from the server
encode: true,
beforeSend: function () {
// setting a timeout
$("#ajaxwaiting").show();
},
})
// using the done promise callback
.done(function (data) {
$("#ajaxwaiting").fadeOut(2000);
//console.log(data); 
// here we will handle errors and validation messages
if (!data.success) {
$.each(data, function (key, value) {
//var onwardflights= JSON.stringify(val.onwardflights);
//departure flights
console.log(value);
//$.each(value, function(key1, val) {
//console.log(val); 
var row = '';
var record = 'Total Hotels Found <b>' + value.length + '</b>';
//console.log(val.onwardflights.length);
$.each(value, function (k, v) {
//console.log(v.img_selected);
row += '<tr>';
row += '<td><img src="' + v.t + '" alt="thumb" width="100px"></td>';
row += '<td>' + v.hn + '</td>';
row += '<td>' + v.hr + '</td>';
row += '<td>' + v.tp_alltax + '</td>';
//row+='<td>'+v.rtn +'</td>';
row += '</tr>';
});
$('#hotel_search_table tbody').append(row);
$('#hotels_found').html(record);
//row.appendTo('#display');
$('#hotel_search_table').DataTable({
"paging": false,
"info": false
});
//});
});
} else {
$('form').append('<div class="alert alert-success">' + data.message + '</div>');
}
})
// using the fail promise callback
.fail(function (data) {
console.log(data);
});
// stop the form from submitting the normal way and refreshing the page
//            event.preventDefault();
}
});
</script>