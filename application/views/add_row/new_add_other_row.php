<tr id='<?php echo "row_id_" . $count ?>'>    
<td><a onclick='remove_row("<?php echo $count ?>")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
<td>
<div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
<input style="width:140px !important;" name="other_date[]" id="<?php echo "other_date_" . $count ?>"  class="form-control" size="16" type="text" value="<?php echo date('d-m-Y', strtotime("+1 day")); ?>" readonly>
<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
</div>
</td>
<td>
<select name="expense_name[]" class="form-control required" id='<?php echo "expense_name_" . $count ?>'>
<option value="">Select Expense ..</option>
<?php
if (isset($other_expencesData)) {
foreach ($other_expencesData as $OtherExpenceData) {
?>
<option value="<?php echo $OtherExpenceData['id']; ?>"><?php echo $OtherExpenceData['expense_name']; ?></option>
<?php }
}
?>
</select>
<?php /* ?> <input type='text' name='expense_name[]' id='<?php echo "expense_name_" . $count ?>' class='form-control required'><?php */ ?>
</td>
<td>
<input type='text' name='expense_type[]' id='<?php echo "expense_type_" . $count ?>' class='form-control required'>
</td>
<td>
<select name="other_arrange_by[]" onchange='received_total()' id="<?php echo "other_expense_arrange_by_" . $count ?>" class="form-control">
<option value="Company">Company</option>
<option value="Own" selected="">Own</option>
</select> 
</td>    
<td>
<input type='text' name='expense_bill_no[]' maxlength='15' id='<?php echo "expense_bill_no_" . $count ?>' class='form-control'>
</td>  
<td>
<input type="file" name="<?php echo 'other_attachment_' . $count . '[]'; ?>" id="<?php echo 'con_attachment_' . $count ?>" multiple="" class="btn green button-submit" style="width:120px !important;">
<input type="hidden" name="other_reference_id[]" value="<?php echo rand(10000,10000000); ?>">
</td>

<td><input type='text' name='other_expense_remarks[]' id='<?php echo "other_expense_remarks_" . $count ?>' class='form-control'></td>

<td>
<input type='number'  value="0" name='total_no[]' maxlength='15' id='<?php echo "total_no" . $count ?>' onkeyup='received_total()'  class='only_number form-control required'>
<input type='hidden' name='other_expense_id[]' value="0">
</td>
</tr>

<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<?php
if ($request['trip_type'] != "1") {
$return_date = $request['return_date'];
} else {
$return_date = '';
}
?>
<script type="text/javascript">

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
startDate: "<?php echo isset($request['departure_date']) ? $request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>",
//endDate: "<?php echo $return_date; ?>",
autoclose: 1,
todayHighlight: 1,
startView: 2,
forceParse: 0,
showMeridian: 1,
minView: 2,
format: "dd-mm-yyyy"
//pickTime: false
});
</script>