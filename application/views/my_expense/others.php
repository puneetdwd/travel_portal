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
<div class="col-md-4 portlet light bordered paddingBottom10 set-boxes">
<?php if (!empty(($request))) { ?>
<h4 class="form-section marginLeft15">
<spam class="cutm_lbl btn_blue">
Add Other Expenses
</spam> <br/> <br/>
<span style="color:#999999; font-size:15px;"> Pls add your other expenses of trip to claim  </span>
</h4>
<form action="<?php echo base_url('my_expense/save_others'); ?>"  enctype="multipart/form-data" method="post" id="other_conveyance_form">
<div class="row">
<div class="col-md-12"> 
<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Trip ID<span class="required" aria-required="true"> * </span>:</label>                                    
<select id="request_id" name="request_id" data-placeholder="Select Trip .." class="form-control required select2me"  onchange='findRefrenceId()'>
<option value="">Select Trip ..</option>
<?php
if (isset($request)) {
$last = $request[0];
$last_id = $last['id'];
foreach ($request as $requestRefrenceId) {
?>
<option value="<?php echo $requestRefrenceId['id']; ?>"<?php
if ($last_id == $requestRefrenceId['id']) {
echo "selected";
}
?>>                                                             
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
<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Date of Expense<span class="required" aria-required="true"> * </span>:</label>                                    
<div class="input-group date form_datetime">
<input name="expanse_date" id="expanse_date"  class="form-control required" size="16" type="text" value="<?php echo date(DATE_FORMAT); ?>" readonly>
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div>
<label id="expanse_date-error" class="error" for="expanse_date"></label>
</div>
<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Expense<span class="required" aria-required="true"> * </span>:</label>                                    
<select name="name" id="expense_details" class="form-control required">
<option value="">Select Expense ..</option>
<?php
if (isset($other_expencesData)) {
foreach ($other_expencesData as $OtherExpenceData) {
?>
<option value="<?php echo $OtherExpenceData['id']; ?>"><?php echo $OtherExpenceData['expense_name']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Location<span class="required" aria-required="true"> * </span>:</label>                                    
<input class="form-control required" name="location" id="location" aria-required="true" id="location" type="text">
</div>
<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Paid By<span class="required" aria-required="true"> * </span>:</label>                                    
<select name="arrange_by"  class="form-control required">
<option value="Own">Own</option>
<option value="Company">Company</option>
</select>
</div>
<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Amount<span class="required" aria-required="true"> * </span>:</label>                                     
<input class="form-control required" name="amount" aria-required="true" id="amount" type="number">
</div>

<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Remarks:</label>   
<input class="form-control" name="remarks" id="remarks" type="text">
</div>

<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Bill No<span class="required" aria-required="true"> * </span>:</label>   
<input class="form-control required" name="bill_no" aria-required="true" id="bill_no" type="text">
</div>

<div class="form-group col-xs-12">
<label class="control-label text-left-imp">Attach:</label>                                                                            
<input class="form-control " name="other_attachment[]" type="file" multiple="">
</div>

<div class="form-actions col-xs-12">     
<label class="control-label text-left-imp">&nbsp;</label>
<input type="hidden" name="other_reference_id" value="<?php echo rand(10000, 10000000); ?>">
<button class="btn green form-control" type="submit" name="submit">Submit</button>
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
<?php
$request['departure_date'] = date('Y-m-d H:i:s');
$request['return_date'] = '';
$request['trip_type'] = '';
?>
<?php
if ($request['trip_type'] != "1") {
$return_date = $request['return_date'];
} else {
$return_date = '';
}
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCdGlqSgU-wNjCn6_mig33UF5yv5QB7tqI"></script>

<script type="text/javascript">

function initialize() {
var input = document.getElementById("location");
var autocomplete = new google.maps.places.Autocomplete(input);
google.maps.event.addDomListener(window, 'load', initialize);
}

function findRefrenceId() {
var refrence_id_val = $("#request_id").find(":selected").text();
$('#reference_id').val(refrence_id_val);
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
autoclose: 1,
todayHighlight: 1,
startView: 2,
forceParse: 0,
showMeridian: 1,
minView: 2,
format: "<?php echo DATETIME_FORMAT_DATEPICKER_API; ?>"
});


$(document).ready(function () {
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

$('#other_conveyance_form').validate({
rules: {
'other_attachment[]': {
filesize: 2097152,
},
},
messages: {
request_id: {
required: 'Please select Trip ID',
},
expanse_date: {
required: 'Please select Expanse Date',
},
book_by: {
required: 'Please select Book by',
},
name: {
required: 'Please add Expense Details',
},
location: {
required: 'Please add Location',
},
arrange_by: {
required: 'Please select Paid by',
},
bill_no: {
required: 'Please add Bill no',
},
amount: {
required: 'Please add amount',
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
