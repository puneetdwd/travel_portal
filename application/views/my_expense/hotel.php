<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<div class="row">
<div class="col-md-12">
<div class="portlet light">
<!-- BEGIN FORM-->
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

<div class="form-body">

<div class="row">
<div class="col-md-4 portlet light bordered">
<?php if (!empty(($request))) { ?>
<h4 class="form-section">
<spam class="cutm_lbl btn_blue">
Accommodation
</spam>
</h4>
<form action="<?php echo base_url('my_expense/save_hotel'); ?>"  enctype="multipart/form-data" method="post" id="hotel_form">
<div class="row">
<div class="col-md-12">   
<div class="form-group">
<label class="control-label text-left-imp">Trip ID<span class="required" aria-required="true"> * </span>:</label>                                    
<select id="request_id" name="request_id" data-placeholder="Select Trip .." class="form-control required select2me"  onchange='findRefrenceId()'>
<option value="">Select Trip ..</option>
<?php
if (isset($request)) {
$last = $request[0];
$last_id = $last['id'];
foreach ($request as $requestRefrenceId) {
?>
<option value="<?php echo $requestRefrenceId['id']; ?>" <?php if ($last_id == $requestRefrenceId['id']) {
echo "selected";
} ?>>                                                             
<?php echo $requestRefrenceId['reference_id']; ?> (<?php
echo $requestRefrenceId['from_city_name'] . ' To  ' .
$requestRefrenceId['to_city_name'];
?>) </option>
<?php
}
}
?>
</select>
<input type="hidden" name="reference_id" id="reference_id" value="" >
</div>
<div class="form-group">
<label class="control-label text-left-imp">Hotel Name<span class="required" aria-required="true"> * </span>:</label>                                     
<!--<input class="form-control required" name="hotel_name" id="hotel_name" aria-required="true" type="text">-->
<select id="hotel_name" data-placeholder="Select Hotel .." name="hotel_name" class="form-control required select2me">
<option value="">Select Hotel ..</option>
<?php
if (isset($hotel)) {
foreach ($hotel as $data) {
?>
<option value="<?php echo $data['id']; ?>">
<?php echo $data['name']; ?> </option>
<?php
}
}
?>
</select>
</div>
<div class="form-group">
<label for="dtp_input1" class="control-label">Check-In Date<span class="required"> * </span></label>
<div class="input-group date form_datetime" data-date="" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
<input name="check_in_date" id="check_in_date"  class="form-control required" size="16" type="text" value="<?php echo date(DATETIME_FORMAT); ?>" readonly>
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div>
<label id="check_in_date-error" class="error" for="check_in_date"></label>                                                    
</div>
<div class="form-group">
<label for="dtp_input1" class="control-label">Check-Out Date</label>
<div class="input-group date form_datetime" data-date="" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
<input name="check_out_date" id="check_out_date" class="form-control" size="16" type="text" value="" readonly>
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div>
<label id="check_out_date-error" class="error" for="check_out_date"></label>
</div>
<div class="form-group">
<label class="control-label text-left-imp">Location<span class="required" aria-required="true"> * </span>:</label>                                    
<input class="form-control required" name="location" aria-required="true" id="location" type="text">
</div>
<div class="form-group">
<label class="control-label text-left-imp">Room No:</label>                                    
<input type="text" class="form-control required" name="room_no">
</div>
<div class="form-group">
<label class="control-label text-left-imp">Bill No<span class="required" aria-required="true"> * </span>:</label>                                     
<input class="form-control" name="bill_no" aria-required="true" id="bill_no" type="text">
</div>
<div class="form-group">
<label class="control-label text-left-imp">Paid By<span class="required" aria-required="true"> * </span>:</label>                                    
<select name="arrange_by"  class="form-control">
<option value="Own">Own</option>
<option value="Company">Company</option>
</select>
</div>
<div class="form-group">
<label class="control-label text-left-imp">Hotel Expense<span class="required"> * </span>:</label>                                    
<input type="number" class="form-control required intonly" name="loading_expense" id="loading_exp" onkeyup="calculation()" value="0">
</div>
<div class="form-group">
<label class="control-label text-left-imp">Tax<span class="required"> * </span>:</label>                                    
<input type="number" class="form-control required intonly" name="other_expense" id="other_exp" onkeyup="calculation()"  value="0">
</div>

<div class="form-group" style="display:none;">
<label class="control-label text-left-imp">Amount<span class="required"> * </span>:</label>                                    
<input type="number" class="form-control required intonly" name="loading_total" id="loading_total" onkeyup="calculation()"  value="0">
</div>

<div class="form-group">
<label class="control-label text-left-imp">Total Amount<span class="required"> * </span>:</label>                                    
<input type="number" class="form-control required intonly" name="total_amount" disabled="" id="total_amount" onkeyup="calculation()">
</div>
<div class="form-group">
<label class="control-label text-left-imp">Attach:</label>                                                                            
<input type="file" class="form-control" name="hotel_attachment[]" multiple="">
</div><br>
<div class="form-actions">           
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" name="reference_id" value="<?php echo rand(10000, 10000000); ?>">
<button class="btn green" type="submit">Submit</button>
</div>                                                
</div>
</div>
</form>
<?php } else { ?>
<h4 class="form-section marginLeft15">
<spam class="cutm_lbl btn_red">
You have not active Trip
</spam> <br/> <br/>
</h4>
<?php } ?>
</div>
</div>
</div>

</div>
</div>
<!-- END PAGE CONTENT-->
</div>



<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCdGlqSgU-wNjCn6_mig33UF5yv5QB7tqI"></script>

<script type="text/javascript">

function calculation() {
var loading_exp = $("#loading_exp").val();
if (loading_exp == '') {
loading_exp = 0;
}
var other_exp = $("#other_exp").val();
if (other_exp == '') {
other_exp = 0;
}
var loading_total = $("#loading_total").val();
if (loading_total == '') {
loading_total = 0;
}
var total_amount = parseFloat(loading_exp) + parseFloat(other_exp) + parseFloat(loading_total);
$("#total_amount").val(total_amount);
}

function initialize() {
var input = document.getElementById("location");
var autocomplete = new google.maps.places.Autocomplete(input);
google.maps.event.addDomListener(window, 'load', initialize);
}

initialize();
$(".only_number").on('keypress', function (evt) {
evt = (evt) ? evt : window.event;
var charCode = (evt.which) ? evt.which : evt.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57)) {
return false;
}
return true;
});
$('.form_datetime').datetimepicker({
weekStart: 1,
todayBtn: 1,
startDate: "",
//                endDate: "",
autoclose: 1,
todayHighlight: 1,
startView: 2,
forceParse: 0,
showMeridian: 1,
minView: 1,
format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
});
$(document).ready(function () {
$("#check_in_date,#check_out_date").change(function () {
var check_in_date = document.getElementById("check_in_date").value;
var check_out_date = document.getElementById("check_out_date").value;

if (check_out_date == check_in_date) {
alert("Check-In date and Check-Out date should not be same");
document.getElementById("check_out_date").value = "";
}
});


$.validator.addMethod('filesize', function (value, element, param) {
var ln = element.files.length;
var allow_fla = 0;
for (var i = 0; i < ln; i++) {
if (this.optional(element) || (element.files[i].size <= param)) {
} else {
allow_fla++;
}
}
if (allow_fla == 0) {
return true;
} else {
return false;
}
}, 'Each file size must be less than 2MB');

$('#hotel_form').validate({
rules: {
'hotel_attachment[]': {
filesize: 2097152,
},
},
messages: {
request_id: {
required: 'Please select Trip ID',
},
hotel_name: {
required: 'Please select Hotel name',
},
check_in_date: {
required: 'Check-In date is required'
},
check_out_date: {
required: 'Check-Out date is required'
},
location: {
required: 'Please add Location',
},
arrange_by: {
required: 'Please select Paid by',
},
room_no: {
required: 'Please add Room no',
},
loading_expense: {
required: 'Please add Guest House/Hotel Expense',
},
other_expense: {
required: 'Please add Other expense',
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

</script>
