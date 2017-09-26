<div class="page-content"><div class=""><div class="">
<?php if ($this->session->flashdata('error')) { ?>
<div class="alert alert-danger">
<i class="icon-remove"></i>
<?php echo $this->session->flashdata('error'); ?>
</div>
<?php } else if ($this->session->flashdata('success')) { ?>
<div class="alert alert-success">
<i class="icon-ok"></i>
<?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>
<div class="row">
<div class="col-md-6 col-xs-12">
<h4><b>Travel Request</b></h4>
<div class="col-md-2 col-xs-3 text-center title_div"> 
<h4><?php echo $total_request; ?></h4>
<div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
TOTAL
</div>
</div>
<div class="col-md-2 col-xs-3 text-center title_div"> 
<h4><?php echo $approved_request; ?></h4>
<div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
APPROVED
</div>
</div>
<div class="col-md-2 col-xs-3 text-center title_div"> 
<h4><?php echo $pending_request; ?></h4>
<div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
PENDING
</div>
</div>
</div>

<div class="col-md-6 col-xs-12">
<h4><b>Expense Claim</b></h4>
<div class="col-md-2 col-xs-3 text-center title_div"> 
<h4><?php echo $pending_expense[0]['pending_request'] + $approved_expense[0]['approved_request'] ?></h4>
<div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
TOTAL
</div>
</div>
<div class="col-md-2 col-xs-3 text-center title_div"> 
<h4><?php echo $approved_expense[0]['approved_request'] ?></h4>
<div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
SETTLED
</div>
</div>
<div class="col-md-2 col-xs-3 text-center title_div"> 
<h4><?php echo $pending_expense[0]['pending_request'] ?></h4>                        
<div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
PENDING
</div>
</div>
</div>
</div>
<br>
<div class="row">
<div class="col-md-6">
<div class="portlet light borderLight">
<div class="portlet-title">
<div class="caption cutm_theme_font">
<i class="fa fa-reorder"></i>My Travel Request
</div>
<div class="actions">
<a class="" href="<?php echo base_url() . "employee_request/index"; ?>">View All</a>
</div>
</div>
<div class="portlet-body">
<?php foreach ($last_few_request as $key => $value) {
?>
<div class="row">
<div class="col-md-10 col-xs-8">
<span class=""> [<strong style="color:#f26e22;"><?php echo $value['reference_id']?></strong>] <b><?php echo $value['from_city_name'] . " -> " . $value['to_city_name']; ?></b>
(<?php
if ($value['travel_type'] == "1") {
echo "Flight Travel - ";
} else if ($value['travel_type'] == "2") {
echo "Train Travel - ";
} else if ($value['travel_type'] == "3") {
echo "Car Travel - ";
} else if ($value['travel_type'] == "4") {
echo "Bus Travel - ";
}
if ($value['approval_status'] == "Rejected") {
echo "Rejected";
} else if ($value['cancel_status'] == "1") {
echo "Cancelled";
} else {
if ($value['request_status'] == "1") {
echo "Approval Pending";
} else if ($value['request_status'] == "2") {
if ($value['approval_status'] == "Approved") {
echo "Trip Approved";
}
} else if ($value['request_status'] == "3") {
echo "Trip Accommodation";
} else if ($value['request_status'] == "4") {
echo "Claim Expense";
} else if ($value['request_status'] == "5") {
echo "Expense Approval";
} else if ($value['request_status'] == "6") {
echo "Finance Approval";
} else if ($value['request_status'] == "7") {
echo "Audit Approval";
} else if ($value['request_status'] == "8") {
echo "Audited";
} else if ($value['request_status'] == "9") {
echo "Completed";
}
}
?>)
</span><br>
<span><?php
if ($value['trip_type'] != "1") {
echo date(DATE_FORMAT, strtotime($value['departure_date']))." To ".date(DATE_FORMAT, strtotime($value['return_date']));
} else {
$date = new DateTime($value['departure_date']);
echo $date->format(DATE_FORMAT);
}
?>
</span>                                        
</div>
<div class="col-md-2 col-xs-4">
<a href="<?php echo base_url('employee_request/view/') . '/' . $value['id']; ?>" class="btn btn-xs btn_blue">View</a>
</div>
</div>
<hr>
<?php }
?>
</div>
</div>
</div>
<div class="col-md-6">
<div class="portlet light borderLight">
<div class="portlet-title">
<div class="caption cutm_theme_font">
<i class="fa fa-reorder"></i>My Expenses
</div>
<div class="actions">
<a class="" href="<?php echo base_url() . "employee_request/index"; ?>">View All</a>
</div>
</div>
<div class="portlet-body">
<?php foreach ($expense_request as $key => $value) {
?>
<div class="row">
<div class="col-md-10 col-xs-8">
<span>[<strong style="color:#f26e22;"><?php echo $value['reference_id']?></strong>]  <b><?php echo $value['from_city_name'] . " -> " . $value['to_city_name']; ?></b>
(<?php
if ($value['travel_type'] == "1") {
echo "Flight Travel - ";
} else if ($value['travel_type'] == "2") {
echo "Train Travel - ";
} else if ($value['travel_type'] == "3") {
echo "Car Travel - ";
} else if ($value['travel_type'] == "4") {
echo "Bus Travel - ";
}

if ($value['approval_status'] == "Rejected") {
echo "Rejected";
} else {
if ($value['request_status'] == "4") {
echo "Claim Expense";
} else if ($value['request_status'] == "5") {
echo "Expense Pending";
} else if ($value['request_status'] == "6") {
echo "Finance Approval";
} else if ($value['request_status'] == "7") {
echo "Audit Approval";
} else if ($value['request_status'] == "8") {
echo "Audited";
} else if ($value['request_status'] == "9") {
echo "Completed";
}
}
?>)
</span><br>
<span><?php
if ($value['trip_type'] != "1") {
echo date(DATE_FORMAT, strtotime($value['departure_date']))." To ".date(DATE_FORMAT, strtotime($value['return_date']));
} else {
$date = new DateTime($value['departure_date']);
echo $date->format(DATE_FORMAT);
}
?></span></div>
<div class="col-md-2 col-xs-4"><?php
if($value['request_status']>="6")
 {
  ?><a href="<?php echo base_url('employee_request/view_expense/') . '/' . $value['id']; ?>" class="btn btn-xs btn_blue">View</a><?php
 }
else
 {
  ?><a href="<?php echo base_url() . 'employee_request/claim/' . $value['id']; ?>" class="btn btn-xs btn_blue">Claim</a><?php
 }
?></div></div><hr><?php }
?></div></div></div></div></div></div></div>