<?php 
$con_allo= $convince_allowance;
function find_da_multiple($hrs)
{
 $DA_multiple= 0;
 if($hrs>=6 and $hrs<=13)
  {
   $DA_multiple=0.5;
  }
 elseif($hrs>=14 and $hrs<=24)
  {
   $DA_multiple=1;
  }
 return $DA_multiple;
}

function find_all_dates_between_2_dates($fromd, $tod)
 {
  $allDates= array();
  $begin = new DateTime($fromd);
  $end = new DateTime($tod);
  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
  foreach($daterange as $date)
   {
    $allDates[]= $date->format("d-m-Y");
   }
  return $allDates;
 }

function find_DA_rows($fromDate, $toDate, $cityGrade, $empGrade)//30-08-2017 06:00
 {
  $allDatesWithMutiplicationFactor= array();
  $Begin= explode(' ', $fromDate);
  $Finish= explode(' ', $toDate);
  $ff= $Begin[0];
  $tt= $Finish[0];
  $allDuringDates= find_all_dates_between_2_dates($ff, $tt);
  foreach($allDuringDates as $k=>$v)
  {
   if($v==$ff)// first_date
   {
	$it2= $v.' 23:59';
	$t1=date_create($fromDate);
    $t2=date_create($it2);
    $diff=date_diff($t1,$t2);
	$hrCount= $diff->h+1;
	$allDatesWithMutiplicationFactor[$v]['HRS']= $hrCount;
	$da_mul= find_da_multiple($hrCount);
	$allDatesWithMutiplicationFactor[$v]['multiple']= $da_mul;
   }
   elseif($v==$tt)// last_date// it never comes true
   {
	$it1= $v.' 00:01';
	$t1=date_create($it1);
    $t2=date_create($toDate);
    $diff=date_diff($t1,$t2);
	$hrCount= $diff->h+1;
	$allDatesWithMutiplicationFactor[$v]['HRS']= $hrCount;
	$da_mul= find_da_multiple($hrCount);
	$allDatesWithMutiplicationFactor[$v]['multiple']= $da_mul;
   }
   else// middle_dates
   {
	$allDatesWithMutiplicationFactor[$v]['HRS']= 24;
	$da_mul= find_da_multiple(24);
	$allDatesWithMutiplicationFactor[$v]['multiple']= $da_mul;
   }
  }
  $it1= $tt.' 00:01';
  $t1=date_create($it1);
  $t2=date_create($toDate);
  $diff=date_diff($t1,$t2);
  $hrCount= $diff->h+1;
  $allDatesWithMutiplicationFactor[$tt]['HRS']= $hrCount;
  $da_mul= find_da_multiple($hrCount);
  $allDatesWithMutiplicationFactor[$tt]['multiple']= $da_mul;
  return $allDatesWithMutiplicationFactor;
 }

?><div class="page-content"> 
<div class="header text-center">
<h3>DB Corp Ltd.,<?php echo $employee['city_name'] ?></h3></div>
<div class="row margin-mob-zero">        
<div class="col-md-12">
<div class="portlet light borderLight">
<!-- BEGIN FORM-->
<form role="form" class="validate-form" method="post" id="expense_form" name="expense_form">
<div class="form-body"> 
<div class="row">
<div class="col-md-12 portlet light borderLight text-center">
<h4 class="form-section">Traveling Expense Reimbursement form(<?php echo $request['reference_id']; ?>)</h4>
<div class="row">
<table id="make-data-table_asd1" class="table table-hover table-bordered table-responsive" style="display:block;">                                        
<tbody align="left">
<tr><th width="15%">Name</th>
<td width="16%"><?php echo $employee['first_name'] . " " . $employee['last_name'] ?></td>
<th width="15%">Employee Id</th>
<td width="16%"><?php echo $employee['employee_id'] ?></td>
<th width="15%">Designation</th>
<td width="16%"><?php echo $employee['desg_name'] ?></td></tr>
<tr><th>Grade</th>
<td><?php echo $employee['grade_name'] ?></td>
<th>Reporting Manager</th>
<td><?php echo $employee['reporting_manager'] ?></td>
<th>Purpose of Travel</th>
<td><?php
if ($request['project_id'] != "") {
echo "Project";
} else {
echo $request['reason'];
}
if ($request['project_id'] != "") {
echo ', '.$project['name'];
}
?></td></tr>

<tr><th>Departure Date and Time</th>
<td><?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?></td>
<th>From-To</th>
<td><?php echo $request['from_city_name'].' - '.$request['to_city_name']; ?></td>
<th>Credit Card Number</th>
<td>
<b>
<?php
echo $expense_pending['credit_card_number'];
?>
</b>
</td>
</tr>

<tr>
<th>Return Date and Time</th>
<td><?php
if($request['trip_type'] != "1") {
echo date(DATETIME_FORMAT, strtotime($request['return_date']));
}
?></td>
<th>Travel Type</th>
<td><?php
if ($request['group_travel'] == "1") {
echo "Group Travel";
} else {
echo "Single Person";
}
?></td>
<th>Bank Name</th>
<td>
<b>
<?php
echo $expense_pending['bank_name'];
?>
</b>
</td>
</tr>
</tbody>
</table> 
</div>
</div>                            
</div>          

<div class="row">
<div class="col-md-12 light bordered ">
<h4 class="form-section">Ticket Details (<span style="color:#005982;">Eligibility-<?php
if($eligibility_mode!='')
 {
  echo $eligibility_mode . "/" . $eligibility_class;
 }
else
 {
  if($sel_traverl_class!='')
   {
	echo $travel_mode . "/" . $sel_traverl_class;
   }
  else
   {
	echo $travel_mode;
   }
 }
?></span>)</h4>
<div class="row">
<table id="ticket_table" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Date</th>
<th>Location From</th>
<th>Location To</th>
<th>Expense Location</th>
<th>Paid By</th>
<th>Mode</th>
<th>View</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
$total = 0;
foreach ($ticket_details as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['location_from'] ?></td>
<td><?php echo $value['location_to'] ?></td>
<td><?php echo $value['expense_location'] ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td>
<?php $service_type = !empty($value['travel_type']) ? $value['travel_type'] : ''; ?>
<?php
if ($service_type == "1") {
echo "Flight";
} else if ($service_type == "2") {
echo "Train";
} else if ($service_type == "3") {
echo "Car";
} else if ($service_type == "4") {
echo "Bus";
} else if ($service_type == "5") {
echo "Hotel";
}
?>
</td>
<td> 
<?php if ($value['attachment'] != '') { ?>
<a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
<i class="fa fa-eye"></i> View 
</a>
<?php } ?>
</td>
<td width="15%">
<?php $total = $total + $value['cost']; ?>
<?php echo $value['cost']; ?>
</td>
</tr>
<?php } ?>
<?php foreach ($other_trip_expense as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>                             
<td><?php echo date(DATETIME_FORMAT, strtotime($value['trip_date'])); ?></td>
<td><?php echo $value['trip_from'] ?></td>
<td><?php echo $value['trip_to'] ?></td>
<td><?php // echo $value['trip_arrange_by']                ?></td>
<td><?php echo $value['trip_arrange_by'] ?></td>
<td><?php
if ($value['trip_book_by'] == "1") {
echo "Flight";
} else if ($value['trip_book_by'] == "2") {
echo "Train";
} else if ($value['trip_book_by'] == "3") {
echo "Car";
} else if ($value['trip_book_by'] == "4") {
echo "Bus";
} else if ($value['trip_book_by'] == "5") {
echo "Hotel";
}
?></td>
<td>
<?php
$view = 1;
if (!empty($value['attachment'])) {
$attachment = $value['attachment'];
foreach ($attachment as $key => $val) {
if ($val['file_name'] != '') {
?>
<a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $val['file_name']; ?>">
<i class="fa fa-eye"></i> <?php
echo "View" . $view;
$view++;
?> 
</a><br>
<?php
}
}
}
?>
</td>                                               
<td width="15%">
<?php $total = $total + $value['total']; ?>
<?php echo $value['total']; ?>
</td>
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr>
<td colspan="7"></td>
<th align="center">Total (&#8377;) </th>
<td>
<b id="txt_total_sum">
<?php echo $total . '.00'; ?>
</b>
</td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

<div class="row"><div class="col-md-12 light bordered">
<h4 class="form-section">Guest House/Hotel/Own Arrangement(<span style="color:#005982;">Eligibility-&#8377;<?php $GH_act= $hotel_allowance; if($GH_act==0){ echo 'Actual'; }else{ echo $GH_act.'/Day'; } ?></span>)</h4>
<div class="row">
<table id="loading_hotel" class="table table-hover table-bordered text-center">
<thead><tr class="th_blue"><th>Sr.No.</th><th>Hotel</th>
<th>Check-In<br> Date</th><th>Check-Out<br> Date</th>
<th>Room No</th><th>Bill No</th><th>Location</th>
<th>Expense<br> Location</th><th>View</th>
<th>Paid By</th><th>Hotel Expense</th>
<th>Tax</th><th>Amount</th></tr></thead><tbody><?php
$i = 1;
$total1 = 0;
foreach ($hotel_details as $key => $value) {
?><tr><td><?php echo $i; ?></td>
<td><?php echo $value['hotel_provider_name']; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date_from'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date_to'])); ?></td>
<td><?php echo $value['bill_no']; ?></td>
<td><?php echo $value['bill_no_1']; ?></td>
<td><?php echo $value['location'] ?></td>
<td><?php echo $value['expense_location'] ?></td>
<td> 
<?php if ($value['attachment'] != '') { ?>
<a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
<i class="fa fa-eye"></i> View 
</a>
<?php } ?>
</td>
<td><?php echo $value['arrange_by'] ?></td>
<td><?php echo $value['loading_expense_1'] ?></td>
<td><?php echo $value['other_expense_1'] ?></td>
<td width="15%"><?php $total1 = $total1 + $value['cost']; ?>
<?php echo $value['cost']; ?>
<!--<input type="text" id="total" value="<?php echo $value['cost']; ?>" class="form-control">-->
</td></tr><?php }
foreach($other_loading_booking as $key => $value) {
?><tr><td><?php echo $i++; ?></td>
<td><?php echo $value['hotel_provider_name']; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_departure'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_return'])); ?></td>
<td><?php echo $value['room_no']; ?></td>
<td><?php echo $value['bill_no']; ?></td>                                                    
<td><?php echo $value['location'] ?></td>
<td></td><td><?php
$view = 1;
if (!empty($value['attachment'])) {
$attachment = $value['attachment'];
foreach ($attachment as $key => $val) {
if ($val['file_name'] != '') {
?><a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $val['file_name']; ?>">
<i class="fa fa-eye"></i> <?php echo "View" . $view; $view++; ?></a><br><?php
}
}
}
?></td><td><?php echo $value['arrange_by'] ?></td>
<td><?php echo $value['loading_expense'] ?></td>
<td><?php echo $value['other_expense'] ?></td><td width="15%"><?php
$total_loading = $value['loading_total'] + $value['loading_expense'] + $value['other_expense'];
$total1 = $total1 + $total_loading;
echo $total_loading; ?></td></tr><?php
}
$eligible= $hotel_allowance * $day;
$sty= '';
if($eligible<$total1 and $GH_act>0){ $sty= 'style="color:red;"'; }
?></tbody><tfoot><tr><td colspan="11"></td><th>Total (&#8377;)</th><td>
<b <?php echo $sty; ?> ><?php echo $total1 . '.00'; ?></b></td>
</tr></tfoot></table></div></div></div><?php

$DA_STYLE= '';
if($request['DA_allowance_actual']!=1)
 {
  $da_eligibility = $DA_allowance * $day;
  if($hours != '0')
   {
	if($hours!='')
	 {
	  if($hours < 14)
	   {
		$da = $request['DA_allowance'] / 2;
		$da_eligibility = $da_eligibility + $da;
	   }
	  else
	   {
		$da_eligibility = $da_eligibility + $request['DA_allowance'];
	   }
	 }
   }
  $da_eligibilityVIEW= $DA_allowance.'/Day';
  //$da_eligibilityVIEW= $da_eligibility;
 }
else
 {
  $DA_STYLE= 'style="display:none;"';
  $da_eligibilityVIEW= "Actual";
 }

?><div <?php echo $DA_STYLE; ?> class="row"><div class="col-md-12 light bordered ">
<h4 class="form-section">DA Perticulars(<span style="color:#005982;">Eligibility-&#8377;<?php
echo $da_eligibilityVIEW; ?></span>)</h4><div class="row"><?php
$i = 1;
$total2 = 0;
$d1= date(DATETIME_FORMAT, strtotime($request['departure_date']));
$d2= date(DATETIME_FORMAT, strtotime($request['return_date']));
$allDates= find_DA_rows($d1, $d2, 'A', 'M');
?><table id="da_perticulars" class="table table-hover table-bordered text-center">
<thead><tr class="th_blue"><th>#</th><th>Date</th><th>City</th>
<th>Class</th><th>Term</th><th>Duration</th><th>DA/Day</th>
<th>Amount</th></tr></thead><tbody><?php
$i=1;
$totRecordCount= count($allDates);
$allAmounts= array();
foreach($allDates as $key=>$val)
{
 ?><tr><td><?php echo $i; ?></td>
 <td><?php if($i==1){ echo 'From '.$d1; }elseif($i==$totRecordCount){ echo $d2; }else{ echo $key; } ?></td>
 <td><?php echo $request['to_city_name']; ?></td>
 <td><?php echo $request['to_city_class']; ?></td>
 <td><?php if($val['multiple']==1){ echo 'Full DA'; }elseif($val['multiple']==0.5){ echo '1/2 DA'; }elseif($val['multiple']==0){ echo 'N/A'; } ?></td>
 <td><?php echo $val['HRS'].' hrs'; ?></td><td><?php
 if($request['DA_allowance_actual'] != '1')
  {
   echo $request['DA_allowance'];
   $da_to_show= $request['DA_allowance'];
  }
 else
  {
   ?><input type="number" class="only_number form-control required" name="da_allowance" id="da_allowance" onkeyup="received_total();" placeholder="DA/Per day" value="<?php
   if(!empty($expense_details))
    {
	 echo $request['DA_allowance'];
	 $da_to_show= $request['DA_allowance'];
	}
   else
    {
	 echo 0;
	 $da_to_show= 0;
	}?>"><?php
  }
 ?></td><td><?php echo $da_to_show*$val['multiple']; $allAmounts[]=$da_to_show*$val['multiple']; ?></td></tr><?php
 $i++;
}
$t87=date_create($d1);
$t88=date_create($d2);
$diff=date_diff($t87,$t88);
?></tbody><tfoot><tr><td colspan="5">Includes "expenses on tea/coffee, breakfast, lunch, dinner" and any other incidental expenses.</td><th><?php echo $diff->days.' Days, '; echo $diff->h.' hrs'; ?></th>
<th>Total (&#8377;)</th>
<td><b><?php $total2= $da_total= array_sum($allAmounts); echo $total2.'.00'; ?></b></td>
</tr></tfoot></table></div></div></div>

<div class="row"><div class="col-md-12 light bordered">
<h4 class="form-section">Conveyance-Car Hire Bills(<span style="color:#005982;">Eligibility- &#8377;<?php echo $con_allo.'/Day'; ?></span>)</h4>
<div class="row">
<?php $total3 = 0; ?>
<table id="conveyance_car" class="table table-hover table-bordered text-center">
<thead><tr class="th_blue"><th>Sr.No.</th><th>Date</th>
<th>Location From</th><th>Location To</th><th>Expense Location</th>
<th>Book By</th><th>Mode</th><th>View</th><th>Amount</th></tr></thead>
<tbody><?php
$i = 1;
$total3 = 0;
foreach ($car_details as $key => $value) {
?><tr><td><?php echo $i; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['location_from'] ?></td>
<td><?php echo $value['location_to'] ?></td>
<td><?php echo $value['expense_location'] ?></td>
<td><?php echo $value['arrange_by'] ?></td><td><?php
if ($value['book_by'] == "1") {
echo "Uber";
} else if ($value['book_by'] == "2") {
echo "Ola";
} else if ($value['book_by'] == "3") {
echo "Auto";
}
?></td><td><?php
if ($value['attachment'] != '') {
?><a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
<i class="fa fa-eye"></i> View </a><?php } ?></td>
<td width="15%"><?php $total3 = $total3 + $value['cost'];
echo $value['cost']; ?></td></tr><?php }
foreach ($other_con_booking as $key => $value) {
?><tr><td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['con_date'])) ?></td>
<td><?php echo $value['con_from'] ?></td>
<td><?php echo $value['con_to'] ?></td>
<td><?php //echo $value['con_to'] ?></td>
<td><?php echo $value['con_arrange_by'] ?></td>
<td><?php
if ($value['con_book_by'] == "1") {
echo "Uber";
} else if ($value['con_book_by'] == "2") {
echo "Ola";
} else if ($value['con_book_by'] == "3") {
echo "Auto";
}
?></td><td><?php
$view = 1;
if (!empty($value['attachment'])) {
$attachment = $value['attachment'];
foreach ($attachment as $key => $val) {
if ($val['file_name'] != '') {
?><a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $val['file_name']; ?>">
<i class="fa fa-eye"></i> <?php echo "View" . $view; $view++; ?></a><br><?php
}
}
}
?></td><td width="15%"><?php
$total3 = $total3 + $value['total'];
echo $value['total']; ?></td></tr><?php
}
$styl2= '';
if(isset($conELG) and $conELG<$total3){$styl2= 'style="color:red;"';}
?></tbody><tfoot><tr><td colspan="7"></td><th>Total (&#8377;)</th>
<td><b <?php echo $styl2; ?> ><?php echo $total3 . '.00'; ?></b></td>
</tr></tfoot></table></div></div></div>

<div class="row"><div class="col-md-12 light bordered ">
<h4 class="form-section">Other Expense Details</h4>
<div class="row"><?php
$total4 = 0;
$total5 = 0;
?><table id="other_expense" class="table table-hover table-bordered text-center">
<thead><tr class="th_blue"><th>Sr.No.</th><th>Date</th>
<th>Expense Details</th><th>Location</th><th>Paid By</th>
<th>Bill No</th><th>View</th><th>Remarks</th><th>Amount</th>
</tr></thead><tbody><?php
$i = 1;
if(isset($other_manager_expense)) {
?><tr><td><?php echo $i; ?></td>
<td id="other_manager_expense_date"><?php
if ($request['return_date'] != '') {
echo date(DATE_FORMAT, strtotime($request['departure_date'])) . " To " . date(DATE_FORMAT, strtotime($request['return_date']));
} else {
echo date(DATE_FORMAT, strtotime($request['departure_date']));
}
?></td><td>Food Expense </td><td><?php
if (isset($other_manager_expense_location)) {
echo $other_manager_expense_location;
}
?></td><td><?php echo $request['to_city_name'] . " Travel Desk";?></td>
<td>-</td><td>-</td><td>-</td><td><?php
echo $other_manager_expense_food;
?></td></tr><tr><td><?php
$i++;
echo $i;
?></td><td id="other_manager_expense_date"><?php
if ($request['return_date'] != '') {
echo date(DATE_FORMAT, strtotime($request['departure_date'])) . " To " . date(DATE_FORMAT, strtotime($request['return_date']));
} else {
echo date(DATE_FORMAT, strtotime($request['departure_date']));
}
?></td><td>Travel Expense </td><td><?php
if (isset($other_manager_expense_location)) {
echo $other_manager_expense_location;
}
?></td><td><?php
echo $request['to_city_name'] . " Travel Desk";
?></td><td>-</td><td>-</td><td>-</td><td><?php
echo $other_manager_expense_travel;
$total5 = $total5 + $other_manager_expense;
?></td></tr><?php
$i++;
}
$other_total = 0;
foreach ($other_expense as $key => $value) {
$amount = $value['amount'];
$other_total = $other_total + $amount;
$total5 = $total5 + $amount;
?><tr><td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['expense_name']; ?></td>
<td><?php echo $value['expense_type']; ?></td>
<td><?php echo $value['arrange_by']; ?></td>
<td><?php echo $value['bill_no'] ?></td><td><?php
$view = 1;
if (!empty($value['attachment'])) {
$attachment = $value['attachment'];
foreach ($attachment as $key => $val) {
if ($val['file_name'] != '') {
?><a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $val['file_name']; ?>">
<i class="fa fa-eye"></i> <?php
echo "View" . $view;
$view++;
?></a><br><?php
}
}
}
?></td><td><?php echo $value['remarks'] ?></td>
<td><?php echo $amount ?></td></tr><?php
}
?></tbody><tfoot><tr><td colspan="7"></td><td><b>Total (&#8377;)</b></td>
<td><b><?php echo $total5 . '.00'; ?></b></td></tr></tfoot></table></div>
</div></div>

<?php

if(isset($DA_50) and $DA_50>0)
 {
  if($DA_50==3)
   {
	$lbl_da_total=0;
   }
  elseif($DA_50==1 or $DA_50==2)
   {
	$lbl_da_total = $da_total/2;
   }
 }
else
 {
  $lbl_da_total = $da_total;
 }

?>

<div class="row"><div class="col-md-4 col-xs-12">
<table class="table table-bordered"><tbody>
<tr class="th_blue"><th>Expense Summary</th><th>INR(&#8377;)</th></tr>
<tr><th>Trip Expense Total</th><th id="lbl_total_claim1">
<?php echo $expense_pending['final_total_claim']; ?></th></tr>
<tr><th>Paid By Company</th><th id="lbl_total_claim_company"><?php
$lbl_total_claim_company = $expense_pending['final_total_claim'] - $expense_pending['total_claim'];
echo $lbl_total_claim_company;
?></th></tr><tr><th>Paid By Employee</th><th id="lbl_total_claim"><?php
//$lbl_total_claim = $expense_pending['total_claim'] - $da_total;
$lbl_total_claim = $expense_pending['total_claim'] - $lbl_da_total;
echo $lbl_total_claim;
?></th></tr><tr><th>D.A.<?php if(isset($DA_50) and $DA_50>0){if($DA_50==3){ echo ' (Policy : DA is Not Admissible)'; }elseif($DA_50==1){ echo ' (Policy : Guest house with</br>food DA@50%)'; }elseif($DA_50==2){ echo ' (Policy : Hotel with food DA@50%)'; }} ?></th>
<th id="lbl_da_total"><?php
echo $lbl_da_total;
?></th></tr><tr style="display:none;">
<th>Other Expense By Travel Desk</th><th><?php
if (!isset($other_manager_expense)) {
echo $other_manager_expense = 0;
} else {
echo $other_manager_expense;
}
?></th></tr><tr><th>Travel Advance</th><th class="col-md-3"><?php
if($request['request_status'] != "8")
 {
  ?><input type="number" name="less_advance" onkeyup="received_total()" id="less_advance" value="<?php echo $expense_pending['less_advance']; ?>" class="form-control only_number"><?php
 }
else
 {
  echo $expense_pending['less_advance'];
 }
?></th></tr><tr><th><?php
if($expense_pending['recevied_amount']>=0)
 {
  ?>Pay to Employee<?php
 }
else
 {
  ?><span style="color:red;">Employee will pay to company</span><?php
 }
?></th><th id="your_recived"><?php echo $expense_pending['recevied_amount'].'.00';?></th>
</tr></tbody></table></div>
<input type="hidden" id="your_recived_hidd" name="your_recived_hidd"><?php
if ($request['travel_type'] == "1") {
$travel_mode = "Flight";
} else if ($request['travel_type'] == "2") {
$travel_mode = "Train";
} else if ($request['travel_type'] == "3") {
$travel_mode = "Car";
} else if ($request['travel_type'] == "4") {
$travel_mode = "Bus";
}
?><div class="col-md-3 col-xs-12"><table class="table table-bordered" style="display:none;">
<thead><tr class="th_blue"><th>Expense Type</th><th>Eligible</th>
<th>Requested</th></tr></thead><tbody><tr><td>Travel Mode/Class</td><td><?php
if($eligibility_mode != ''){
echo $eligibility_mode . "/" . $eligibility_class;
} else {
if ($sel_traverl_class != '') {
echo $travel_mode . "/" . $sel_traverl_class;
} else {
echo $travel_mode;
}
}
?></td>
<td><?php echo $travel_mode . "/" . $request['travel_class']; ?></td></tr>
<tr><td>D.A.</td><td><?php
if ($request['DA_allowance_actual'] != 1) {
$da_eligibility = $DA_allowance * $day;
if ($hours != '0') {
if ($hours != '') {
if ($hours < 14) {
$da = $request['DA_allowance'] / 2;
$da_eligibility = $da_eligibility + $da;
} else {
$da_eligibility = $da_eligibility + $request['DA_allowance'];
}
}
}
echo $da_eligibility;
} else {
echo "Actual";
}
?></td><td><?php echo $da_total; ?></td>
</tr><tr><td>Hotel</td><td><?php
if ($request['hotel_allowance_actual'] != 1) {
echo $hotel_allowance * $day;
} else {
echo "Actual";
}
?></td><td><?php echo $total1 ?></td></tr><tr><td>Conveyance</td><td><?php
if ($request['convince_allowance_actual'] != 1) {
echo $convince_allowance * $day;
} else {
echo "Actual";
}
?></td><td><?php echo $total3; ?></td></tr></tbody></table></div>

<div class="col-md-2 col-xs-12">
<h4 class="form-section">
<span class="cutm_lbl btn_blue">Travel Bills</span></h4><?php
$u = 1;
if(!empty($get_other_attachment))
 {
  foreach($get_other_attachment as $value)
   {
	?><div class="form-group"><div class="col-md-12">
	<p class="form-control-static">
	<a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['file_name']; ?>">
	<i class="fa fa-eye"></i> <?php echo "Attachment " . $u++ ?></a>
	</p></div></div><?php
   }
 }
else
 {
  ?><br><b>No Bill Found</b><?php
 }
?></div>

<div class="col-md-3 col-xs-12"><div class="col-md-12"><br><br><?php
if($request['request_status'] != "8") {
?><a href="#send_audit_modal" data-toggle="modal" class="btn btn_blue">
Sent to Audit</a>
<a class="btn btn_red" href="#rejected_modal" data-toggle="modal">
Clarification</a><?php
} else {
?><a href="#approve_modal" data-toggle="modal" class="btn green button-submit">
Pay to Employee</a><?php } ?></div></div></div></div></form></div></div>
</div></div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="send_audit_modal">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class="modal-title">Approve Task</h4></div>
<form action="<?php echo base_url() . 'finance_desk/audit_expense/' . $request['id']; ?>" id="approval_task" method="post" class="validate-form form-horizontal row-border">
<div class="modal-body"><div class="row"><div class="col-md-12">
<div class="widget box"><div class="widget-content">
<div class="col-md-12"><div class="form-group">
<label class="control-label">Are you sure you want to send this Trip to Audit Desk?</label>
</div></div></div></div></div></div></div><?php
if (!isset($other_manager_expense)) {
$other_manager_expense = 0;
}
$total_claim = $expense_pending['total_claim'] - $other_manager_expense;
?><div class="modal-footer">
<input type="hidden" name="less_advance_hidd_audit" id="less_advance_hidd_audit" value="<?php echo $expense_pending['less_advance']; ?>">
<input type="hidden" name="your_recived_hidd_audit" id="your_recived_hidd_audit" value="<?php echo $expense_pending['recevied_amount']; ?>">
<input type="hidden" name="total_claim" id="total_claim" value="<?php echo $total_claim; ?>">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-success">Submit</button>
</div></form></div></div></div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="approve_modal">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class="modal-title">Approve Task</h4></div>
<form action="<?php echo base_url() . 'finance_desk/approve_expense/' . $request['id']; ?>" id="approval_task" method="post" class="validate-form form-horizontal row-border">
<div class="modal-body"><div class="row"><div class="col-md-12">
<div class="widget box"><div class="widget-content">
<div class="col-md-12"><div class="form-group">
<label class="control-label">Are you sure you want to Complete this Trip?</label>
</div></div></div></div></div></div></div>

<div class="modal-footer">
<input type="hidden" name="less_advance_hidd_finance" id="less_advance_hidd_finance" value="<?php echo $expense_pending['less_advance']; ?>">
<input type="hidden" name="your_recived_hidd_finance" id="your_recived_hidd_finance" value="<?php echo $expense_pending['recevied_amount']; ?>">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-success">Submit</button>
</div></form></div></div></div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="rejected_modal">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class="modal-title">Clarification Task</h4></div>
<form action="<?php echo base_url() . 'finance_desk/clarification_expense/' . $request['id']; ?>" id="reject_task" method="post" class="form-horizontal row-border validate-form">
<div class="modal-body"><div class="row"><div class="col-md-12">
<div class="widget box"><div class="widget-content">
<div class="col-md-12"><div class="form-group">
<label class="control-label">Please provide your comments.
<span class="required">*</span>:</label>
<textarea name="clarification_comment" id="clarification_comment" class="form-control required" rows="4"></textarea>
</div></div></div></div></div></div></div><div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-success">Submit</button>
</div></form></div></div></div>
<script type="text/javascript">
function received_total() {
var total_travel_claim = $("#total_claim").val();
if (!$("#total_claim").length) {
total_travel_claim = 0;
}
if (total_travel_claim == '') {
total_travel_claim = 0;
}
var less_advance = $("#less_advance").val();
if (!$("#less_advance").length) {
less_advance = 0;
}
if (less_advance == '') {
less_advance = 0;
}
var your_recived = total_travel_claim - less_advance;
$("#less_advance_hidd_audit").val(less_advance);
$("#your_recived_hidd_audit").val(your_recived);
$("#less_advance_hidd_finance").val(less_advance);
$("#your_recived_hidd_finance").val(your_recived);
$("#your_recived").text("₨ " + your_recived);
$("#your_recived_hidd").val(your_recived);
}
$(document).ready(function () {
$(".only_number").on('keypress', function (evt) {
evt = (evt) ? evt : window.event;
var charCode = (evt.which) ? evt.which : evt.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57)) {
return false;
}
return true;
});

$('#reject_task').validate({
rules: {
clarification_comment: {
required: true
},
},
messages: {
clarification_comment: {
required: 'Clarification Comment is required'
},
}});
$('#expense_form').validate({
rules: {
credit_card_number: {
required: true
},
bank_name: {
required: true
},
},
messages: {
credit_card_number: {
required: 'Credit Card Number is required'
},
bank_name: {
required: 'Bank Name is required'
},}});});
</script>

<style>.table { text-align:left;}</style>