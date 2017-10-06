<?php
$con_allo= $convince_allowance;
function find_DA_rows_OLD_BACKUP($fromDate, $toDate, $cityGrade, $empGrade)//30-08-2017 06:00
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
	$allDatesWithMutiplicationFactor[$v]['FROM']= '';
	$allDatesWithMutiplicationFactor[$v]['TO']= '';
   }
   elseif($v==$tt)// last_date// it never comes true
   {
	$it1= $v.' 00:01';
	$t1=date_create($it1);
    $t2=date_create($toDate);
    $diff=date_diff($t1,$t2);
	$hrCount= $diff->h+1;
	$allDatesWithMutiplicationFactor[$v]['FROM']= '';
	$allDatesWithMutiplicationFactor[$v]['TO']= '';
	$allDatesWithMutiplicationFactor[$v]['HRS']= $hrCount;
	$da_mul= find_da_multiple($hrCount);
	$allDatesWithMutiplicationFactor[$v]['multiple']= $da_mul;
   }
   else// middle_dates
   {
	$allDatesWithMutiplicationFactor[$v]['FROM']= '';
	$allDatesWithMutiplicationFactor[$v]['TO']= '';
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
  $allDatesWithMutiplicationFactor[$v]['FROM']= '';
  $allDatesWithMutiplicationFactor[$v]['TO']= '';
  $allDatesWithMutiplicationFactor[$tt]['HRS']= $hrCount;
  $da_mul= find_da_multiple($hrCount);
  $allDatesWithMutiplicationFactor[$tt]['multiple']= $da_mul;
  return $allDatesWithMutiplicationFactor;
 }

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
  $allDates[]= $tod;
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
  $firstTime= end(explode(' ', $fromDate));
  $firstTimeStamp= strtotime($fromDate);
  $lastTime= end(explode(' ', $toDate));
  $lastTimeStamp= strtotime($toDate);
  foreach($allDuringDates as $k=>$v)
  {
   $thisDateTime= $v.' '.$firstTime;
   $t1=date_create($thisDateTime);
   $next24Hr= strtotime($thisDateTime)+86400;
   if($lastTimeStamp>$next24Hr)
   {
	$iterationNext= date('d-m-Y H:i', $next24Hr);
   }
   else
   {
	$iterationNext= $toDate;
   }
   $t2=date_create($iterationNext);
   $diff=date_diff($t1,$t2);
   $hrCount= ($diff->days*24)+($diff->h);
   $allDatesWithMutiplicationFactor[$v]['FROM']= $thisDateTime;
   $allDatesWithMutiplicationFactor[$v]['TO']= $iterationNext;
   $allDatesWithMutiplicationFactor[$v]['HRS']= $hrCount;
   $da_mul= find_da_multiple($hrCount);
   $allDatesWithMutiplicationFactor[$v]['multiple']= $da_mul;
  }
  return $allDatesWithMutiplicationFactor;
 }

$OwnExpenses= array();
$expensesByCompany= array();

?><div class="page-content"> 
<input type='button' id='btn' class="btn btn_blue pull-right" value='Print Expense' onclick='printDiv();'>
<div id="print_div">
<div class="col-md-12">
<div class="header text-center">
<h3>DB Corp Ltd.,<?php echo $employee['city_name'] ?></h3>
<h4>Travelling Bill</h4>
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
<h4 class="form-section">Expense Reimbursement form (<?php echo $request['reference_id']; ?>)</h4>
<div class="row">
<table id="make-data-table_asd1" class="table table-hover table-bordered table-responsive" style="display:block;">                                        
<tbody align="left"><tr><th width="15%">Name</th>
<td width="16%"><?php echo $employee['first_name'] . " " . $employee['last_name'] ?></td>
<th width="15%">Employee Id</th>
<td width="16%"><?php echo $employee['employee_id'] ?></td>
<th width="15%">Designation</th>
<td width="16%"><?php echo $employee['desg_name'] ?></td></tr>

<tr><th>Grade</th><td><?php echo $employee['grade_name'] ?></td>
<th>Reporting Manager</th>
<td><?php echo $employee['reporting_manager'] ?></td>
<th>Purpose of Travel</th><td><?php
if($request['project_id']!=""){echo "Project";}
else{echo $request['reason'];}
if($request['project_id']!=""){echo ', '.$project['name'];}
?></td></tr>

<tr><th>Departure Date and Time</th>
<td><?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?></td>
<th>From-To</th>
<td><?php echo $request['from_city_name'].' - '.$request['to_city_name']; ?></td>
<th>Credit Card Number</th><td>
<b><?phpecho $expense_pending['credit_card_number'];?></b></td></tr>

<tr><th>Return Date and Time</th><td><?php
if($request['trip_type']!="1"){echo date(DATETIME_FORMAT, strtotime($request['return_date']));}?></td>
<th>Travel Type</th>
<td><?php if($request['group_travel']=="1"){echo "Group Travel";}else{echo "Single Person";}?></td>
<th>Bank Name</th>
<td><b><?php echo $expense_pending['bank_name'];?></b></td></tr></tbody>
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
<tr class="th_blue"><th>Sr.No.</th><th>Date</th><th>Location From</th>
<th>Location To</th><th>Paid By</th><th>Mode/Class</th><th>View</th>
<th>Amount</th></tr>
</thead>
<tbody>
<?php
$i = 1;
$total = 0;
foreach ($ticket_details as $key => $value) {
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['location_from'] ?></td>
<td><?php echo $value['location_to'] ?></td>
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
<td width="15%">
<?php $total = $total + $value['total']; ?>
<?php echo $value['total']; ?>
</td>
</tr>
<?php } ?>

</tbody>
<tfoot>
<tr>
<td colspan="5"></td>
<th align="center">Total</th>
<td>
<b id="txt_total_sum">
<?php echo "&#8360; " .$total; ?>
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
<h4 class="form-section">Lodging(Guest House/Hotel/Own Arrangement)</h4>
<div class="row">
<table id="loading_hotel" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Check-In Date</th>
<th>Check-Out Date</th>
<th>Room No</th>
<th>Bill No</th>
<th>Location</th>
<th>Paid By</th>
<th>Loding Expense</th>
<th>Other Expense</th>
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
<td><?php echo $i; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date_from'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date_to'])); ?></td>
<td><?php echo $value['bill_no']; ?></td>
<td><?php echo $value['bill_no_1']; ?></td>
<td><?php echo $value['location'] ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td><?php echo $value['loading_expense_1'] ?></td>
<td><?php echo $value['other_expense_1'] ?></td>
<td width="15%"><?php $total1 = $total1 + $value['cost']; ?>
<?php echo $value['cost']; ?>
</td>

</tr>
<?php } ?>
<?php foreach ($other_loading_booking as $key => $value) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_departure'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_return'])); ?></td>
<td><?php echo $value['room_no']; ?></td>
<td><?php echo $value['bill_no']; ?></td>                                                    
<td><?php echo $value['location'] ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td><?php echo $value['loading_expense'] ?></td>
<td><?php echo $value['other_expense'] ?></td>
<td width="15%"><?php
$total_loading = $value['loading_total'] + $value['loading_expense'] + $value['other_expense'];
$total1 = $total1 + $total_loading;
?>
<?php echo $total_loading; ?>
</td>

</tr>
<?php } ?>                                                
</tbody>
<tfoot>
<tr>
<td colspan="8"></td>
<th>Total</th>
<td><b><?php echo "&#8360; " .$total1; ?></b></td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 light bordered ">
<h4 class="form-section">DA Perticulars</h4>
<div class="row">
<?php
$i = 1;
$total2 = 0;
?>
<table id="da_perticulars" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>From Date</th>
<th>To Date</th>
<th>Location</th>
<th>No of Day</th>
<th>DA@per day</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($request['return_date'])); ?></td>
<td><?php echo $request['to_city_name']; ?></td>
<td><?php
echo $day . " Day," . $hours . " hours";
?></td>
<td><?php echo $request['DA_allowance']; ?></td>
<td width="15%">
<?php
$da_total = $request['DA_allowance'] * $day;
if ($hours != '0') {
if ($hours != '') {
if ($hours < 14) {
$da = $request['DA_allowance'] / 2;
$da_total = $da_total + $da;
} else {
$da_total = $da_total + $request['DA_allowance'];
}
}
}
$total2 = $total2 + $da_total;
?>
<?php echo $da_total; ?>
</td>
</tr>                                                
</tbody>
<tfoot>
<tr>
<td colspan="5"></td>
<th>Total</th>
<td><b><?php echo "&#8360; " .$total2; ?></b></td>
</tr>
</tfoot>
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
<th>Book by</th>
<th>Mode</th>
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
<td><?php echo $i; ?></td>
<td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
<td><?php echo $value['location_from'] ?></td>
<td><?php echo $value['location_to'] ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td><?php
if ($value['book_by'] == "1") {
echo "Uber";
} else if ($value['book_by'] == "2") {
echo "Ola";
} else if ($value['book_by'] == "3") {
echo "Auto";
}
?></td>

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
<td><?php echo $value['con_arrange_by'] ?></td>
<td><?php
if ($value['con_book_by'] == "1") {
echo "Uber";
} else if ($value['con_book_by'] == "2") {
echo "Ola";
} else if ($value['con_book_by'] == "3") {
echo "Auto";
}
?></td>
<td width="15%">
<?php $total3 = $total3 + $value['total']; ?>
<?php echo $value['total']; ?>
</td>
</tr>
<?php } ?>                                                
</tbody>
<tfoot>
<tr>
<td colspan="5"></td>
<th>Total</th>
<td><b><?php echo "&#8360; " .$total3; ?></b></td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 light bordered ">
<h4 class="form-section">Other Expense Details</h4>
<div class="row">
<?php $total4 = 0; ?>
<?php $total5 = 0; ?>
<table id="other_expense" class="table table-hover table-bordered text-center">
<thead>
<tr class="th_blue">
<th>Sr.No.</th>
<th>Date</th>
<th>Expense Details</th>
<th>Location</th>
<th>Paid By</th>
<th>Bill No</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
if (isset($other_manager_expense)) {
?>
<tr>
<td><?php echo $i; ?></td>
<td id="other_manager_expense_date">
<?php
if ($request['return_date'] != '') {
echo date(DATE_FORMAT, strtotime($request['departure_date'])) . " To " . date(DATE_FORMAT, strtotime($request['return_date']));
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
<td><?php
echo $other_manager_expense_food;
?></td>
</tr>
<tr>
<td><?php echo $i; ?></td>
<td id="other_manager_expense_date">
<?php
if ($request['return_date'] != '') {
echo date(DATE_FORMAT, strtotime($request['departure_date'])) . " To " . date(DATE_FORMAT, strtotime($request['return_date']));
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
<td>-</td>
<td><?php
echo $other_manager_expense_travel;
$total5 = $total5 + $other_manager_expense;
?></td>
</tr>
<?php
$i++;
}
?>
<?php
$other_total = 0;
foreach ($other_expense as $key => $value) {
$amount = $value['amount'];
$other_total = $other_total + $amount;
$total5 = $total5 + $amount;
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo $value['date']; ?></td>
<td><?php echo $value['expense_name']; ?></td>
<td><?php echo $value['expense_type']; ?></td>
<td><?php echo $value['arrange_by'] ?></td>
<td><?php echo $value['bill_no'] ?></td>
<td><?php echo $amount ?></td>
</tr>
<?php } ?>                                         
</tbody>
<tfoot>
<tr>
<td colspan="5"></td>
<td><b>Total</b></td>
<td><b><?php echo "&#8360; " .$total5; ?></b></td>
</tr>
</tfoot>
</table> 
</div>
</div>
</div>

<div class="row">
<div class="col-md-4 col-xs-12">
<h4 class="form-section"><spam class="cutm_lbl btn_blue">Expense Summury</spam></h4>
<table class="table table-bordered">
<tbody>
<tr>
<th>Trip Expense Total</th>
<th id="lbl_total_claim1">
<?php echo "&#8360; " .$expense_pending['final_total_claim']; ?>
</th>
</tr>
<tr>
<th>Paid By Company</th>
<th id="lbl_total_claim_company">
<?php $lbl_total_claim_company = $expense_pending['final_total_claim'] - $expense_pending['total_claim']; 
echo "&#8360; " .$lbl_total_claim_company
?>
</th>
</tr>
<tr>
<th>Paid By Self</th>
<th id="lbl_total_claim">
<?php
$lbl_total_claim =  $expense_pending['total_claim'] - $da_total;
echo "&#8360; " .$lbl_total_claim;
?>
</th>
</tr>
<tr>
<th>D.A.</th>
<th id="lbl_da_total">
<?php echo "&#8360; " .$da_total; ?>
</th>
</tr>
<tr>
<th>Other Expense By Travel Desk</th>
<th>
<?php
if (isset($other_manager_expense)) {
echo "&#8360; " .$other_manager_expense;
}
?>
</th>
</tr>
<tr>
<th>Travel Advance</th>
<th class="col-md-3">
<?php
echo "&#8360; " .$expense_pending['less_advance'];
?>
</th>
</tr>
<tr>
<th>Employee Will be Recived</th>
<th id="your_recived">
<?php
echo "&#8360; " .$expense_pending['recevied_amount'];
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

