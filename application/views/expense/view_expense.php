<?php 

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
<input type='button' id='btn' class="btn btn_blue pull-right" value='Print Expense' onclick='printDiv();'>
<div id="print_div">
<div class="col-md-12">
<div class="header text-center">
<h3>DB Corp Ltd.,<?php echo $employee['city_name'] ?></h3>
</div>    
</div>    
<div class="row">        
<div class="col-md-12">
<div class="portlet light bordered">
<!-- BEGIN FORM-->
<form role="form" class="validate-form" method="post" id="expense_form" name="expense_form">
<div class="form-body"> 
<div class="row">
<div class="col-md-12 portlet light bordered text-center">
<h4 class="form-section">Travelling Expense Reimbursement form (<?php echo $request['reference_id']; ?>)</h4>
<div class="row">
<table id="make-data-table_asd1" class="table table-hover table-bordered table-responsive" style="display:block;">                                        
<tbody align="left">
<tr>
<th width="15%">Name</th>
<td width="16%"><?php echo $employee['first_name'] . " " . $employee['last_name'] ?></td>
<th width="15%">Employee Id</th>
<td width="16%"><?php echo $employee['employee_id'] ?></td>
<th width="15%">Designation</th>
<td width="16%"><?php echo $employee['desg_name'] ?></td>
</tr>
<tr>
<th>Grade</th>
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
?></td>
</tr>

<tr>
<th>Departure Date and Time</th>
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
<h4 class="form-section">Ticket Details</h4>
<div class="row">
<table id="ticket_table" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Date</th>
<th>From-To</th>
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
<td><?php echo $value['location_from'].'-'.$value['location_to']; ?></td>
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
<td><?php echo $value['trip_from'].'-'.$value['trip_to']; ?></td>
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
<?php echo "&#8360; " . $value['total']; ?>
</td>
</tr>
<?php } ?>                                    
</tbody>
<tfoot>
<tr>
<td colspan="5"></td>
<th align="center">Total (&#8377;)</th>
<td>
<b id="txt_total_sum">
<?php echo $total.'.00'; ?>
</b>
</td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 light bordered ">
<h4 class="form-section">Guest House/Hotel/Own Arrangement</h4>
<div class="row">
<table id="loading_hotel" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Hotel</th>
<th>Check-In Date</th>
<th>Check-Out Date</th>
<th>Room No</th>
<th>Bill No</th>
<th>Location</th>
<th>Paid By</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
$total1 = 0;
foreach ($hotel_details as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo $value['hotel_provider_name']; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date_from'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date_to'])); ?></td>
<td><?php echo $value['bill_no']; ?></td>
<td><?php echo $value['bill_no_1']; ?></td>
<td><?php echo $value['location'] ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td width="15%"><?php
$total_loading = $value['cost'] + $value['loading_expense_1'] + $value['other_expense_1'];
$total1 = $total1 + $total_loading;
?>
<?php echo $total_loading; ?>
</td>

</tr>
<?php } ?>
<?php foreach ($other_loading_booking as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo $value['hotel_provider_name']; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_departure'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_return'])); ?></td>
<td><?php echo $value['room_no']; ?></td>
<td><?php echo $value['bill_no']; ?></td>                                                    
<td><?php echo $value['location'] ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td width="15%"><?php
$total_loading = $value['loading_total'] + $value['loading_expense'] + $value['other_expense'];
$total1 = $total1 + $total_loading;
?>
<?php echo $total_loading; ?>
</td>
</tr>
<?php }
$sty= '';
if(isset($hotel_allowance) and isset($day)){
$eligible= $hotel_allowance * $day;
if($eligible<$total1){ $sty= 'style="color:red;"'; }
}
?></tbody>
<tfoot>
<tr>
<td colspan="7"></td>
<th>Total (&#8377;)</th>
<td><b <?php echo $sty; ?> ><?php echo $total1.'.00'; ?></b></td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div><?php


$DA_STL= '';
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
  $DA_eliz= $da_eligibility;
 }
else
 {
  $DA_STL= 'style="display:none;"';
  $DA_eliz= "Actual";
 }
 
?><div <?php echo $DA_STL; ?> class="row"><div class="col-md-12 light bordered">
<h4 class="form-section">DA Particulars</h4><div class="row"><?php
$d1= date(DATETIME_FORMAT, strtotime($request['departure_date']));
$d2= date(DATETIME_FORMAT, strtotime($request['return_date']));
$allDates= find_DA_rows($d1, $d2, 'A', 'M');
?><table id="da_perticulars" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>#</th>
<th>Date</th>
<th>City</th>
<th>Duration</th>
<th>DA/Day</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
$totRecordCount= count($allDates);
$allAmounts= array();
foreach($allDates as $key=>$val)
{
 ?><tr><td><?php echo $i; ?></td>
 <td><?php if($i==1){ echo 'From '.$d1; }elseif($i==$totRecordCount){ echo $d2; }else{ echo $key; } ?></td>
 <td><?php echo $request['to_city_name']; ?></td>
 <td><?php echo $val['HRS'].' hrs'; ?></td>
 <td><?php
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
?></tbody>
<tfoot><tr><td colspan="3">Includes "expenses on tea/coffee, breakfast, lunch, dinner" and any other incidental expenses.</td><th><?php echo $diff->days.' Days, '; echo $diff->h.' hrs'; ?></th>
<th>Total (&#8377;)</th><td><b><?php $total2= $da_total= array_sum($allAmounts); echo $total2.'.00'; ?></b></td>
</tr></tfoot>
</table>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 light bordered ">
<h4 class="form-section">Conveyance-Car Hire Bills</h4>
<div class="row">
<?php $total3 = 0; ?>
<table id="conveyance_car" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Date</th>
<th>Location From</th>
<th>Location To</th>
<th>Book By</th>
<th>Paid By</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
$total3 = 0;
foreach ($car_details as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['location_from'] ?></td>
<td><?php echo $value['location_to'] ?></td>
<td><?php
if ($value['book_by'] == "1") {
echo "Uber";
} else if ($value['book_by'] == "2") {
echo "Ola";
} else if ($value['book_by'] == "3") {
echo "Auto";
}
?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td width="15%">
<?php $total3 = $total3 + $value['cost']; ?>
<?php echo $value['cost']; ?>
</td>
</tr>
<?php } ?>
<?php foreach ($other_con_booking as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['con_date'])) ?></td>
<td><?php echo $value['con_from'] ?></td>
<td><?php echo $value['con_to'] ?></td>
<td><?php
if ($value['con_book_by'] == "1") {
echo "Uber";
} else if ($value['con_book_by'] == "2") {
echo "Ola";
} else if ($value['con_book_by'] == "3") {
echo "Auto";
}
?></td>
<td><?php echo $value['con_arrange_by'] ?></td>
<td width="15%">
<?php $total3 = $total3 + $value['total']; ?>
<?php echo $value['total']; ?>
</td>
</tr>
<?php }

$styl2= '';
if(isset($conELG) and $conELG<$total3){$styl2= 'style="color:red;"';}

?></tbody>
<tfoot>
<tr>
<td colspan="5"></td>
<th>Total (&#8377;)</th>
<td><b <?php echo $styl2; ?> ><?php echo $total3.'.00'; ?></b></td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 light bordered">
<h4 class="form-section">Other Expense Details</h4>
<div class="row"><?php
$total4 = 0;
$total5 = 0;
?><table id="other_expense" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Date</th>
<th>Expense Details</th>
<th>Location</th>
<th>Paid By</th>
<th>Bill No</th>
<th>Remarks</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
if (isset($other_manager_expense)) {
?>
<tr>
<td><?php echo $i; ?></td>;
<td id="other_manager_expense_date">
<?php
if ($request['return_date'] != '') {
echo date(DATE_FORMAT, strtotime($request['departure_date']));
} else {
echo date(DATE_FORMAT, strtotime($request['departure_date']));
}
?>                                                        
</td>
<td>
Food Expense
</td>
<td><?php
if (isset($other_manager_expense_location)) {
echo $other_manager_expense_location;
}
?></td>
<td>
<?php
echo $request['to_city_name'] . " Travel Desk";
?>
</td>
<td>-</td>
<td>-</td>
<td><?php
echo $other_manager_expense_food;
?></td>
</tr>
<tr>
<td><?php
$i++;
echo $i;
?></td>;
<td id="other_manager_expense_date">
<?php
if ($request['return_date'] != '') {
echo date(DATE_FORMAT, strtotime($request['departure_date']));
} else {
echo date(DATE_FORMAT, strtotime($request['departure_date']));
}
?>                                                        
</td>
<td>
Travel Expense
</td>
<td><?php
if (isset($other_manager_expense_location)) {
echo $other_manager_expense_location;
}
?></td>
<td>
<?php
echo $request['to_city_name'] . " Travel Desk";
?>
</td>
<td>-</td><td>-</td>
<td><?php
echo $other_manager_expense_travel;
$total5 = $total5 + $other_manager_expense;
?></td>
</tr>
<?php
$i++;
}
$other_total = 0;
foreach ($other_expense as $key => $value) {
$amount = $value['amount'];
$other_total = $other_total + $amount;
$total5 = $total5 + $amount;
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['expense_name']; ?></td>
<td><?php echo $value['expense_type']; ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td><?php echo $value['bill_no'] ?></td>
<td><?php echo $value['remarks']; ?></td>
<td><?php echo $amount ?></td>
</tr>
<?php } ?>                                            
</tbody>
<tfoot>
<tr>
<td colspan="6"></td>
<td><b>Total (&#8377;)</b></td>
<td><b><?php echo $total5.'.00'; ?></b></td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

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
<?php echo $expense_pending['final_total_claim'].'.00'; ?></th></tr>
<tr><th>Paid By Company</th><th id="lbl_total_claim_company"><?php
$lbl_total_claim_company = $expense_pending['final_total_claim'] - $expense_pending['total_claim'];
echo $lbl_total_claim_company.'.00';?></th></tr>
<tr><th>Paid By Self</th><th id="lbl_total_claim"><?php
$lbl_total_claim = $expense_pending['total_claim'] - $lbl_da_total;
//$lbl_total_claim = $expense_pending['total_claim'] - $da_total;
echo $lbl_total_claim.'.00'; ?></th></tr><tr>
<th>D.A.<?php if(isset($DA_50) and $DA_50>0){if($DA_50==3){ echo ' (Policy : DA is Not Admissible)'; }elseif($DA_50==1){ echo ' (Policy : Guest house with</br>food DA@50%)'; }elseif($DA_50==2){ echo ' (Policy : Hotel with food DA@50%)'; }} ?></th>
<th id="lbl_da_total"><?php
echo $lbl_da_total;
//$lbl_da_total = $da_total;
//echo $lbl_da_total.'.00';
?></th></tr>
<tr style="display:none;">
<th>Other Expense By Travel Desk</th>
<th>
<?php
if (isset($other_manager_expense)) {
echo "&#8360; " . $other_manager_expense;
}
?>
</th>
</tr>
<tr>
<th>Travel Advance</th>
<th class="col-md-3">
<?php if($expense_pending['less_advance']==0){echo $expense_pending['less_advance'];}else{
echo $expense_pending['less_advance'].'.00'; }
?>
</th>
</tr>
<tr>
<th>
<?php if ($expense_pending['recevied_amount'] >= 0) { ?>
Pay to Employee
<?php } else { ?>
<span style="color:red;">  Employee will pay to company</span>                                            
<?php } ?>
</th>
<th id="your_recived">
<?php
echo $expense_pending['recevied_amount'].'.00';
?>
</th>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
</div>
</div>
</div>

<script type="text/javascript">
function printDiv() {
var printContents = document.getElementById('print_div').innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();
document.body.innerHTML = originalContents;
}

</script>

