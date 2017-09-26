<?php //echo '<pre>'; print_r($request); exit; ?>
<tr id='<?php echo "row_trip_id_" . $count ?>'>
    <td><a  onclick='remove_trip_row("<?php echo $count ?>")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
    <td><?php echo $count ?></td>
    <td>
        <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
            <input  name="trip_date[]" id="trip_date"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime("+1 day")); ?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
    </td>
    
	<td><select name="trip_from[]" id="<?php echo "trip_from_" . $count ?>" class="form-control required">
	<option value="">Select Source</option><?php
	if(isset($allHalts) and count($allHalts))
	 {
	  foreach($allHalts as $ke=>$va)
	  {
	   ?><option value="<?php echo $va; ?>"><?php echo $va; ?></option><?php
	  }
	 }
	?></select>
	<!---<input type='text' name='trip_from[]' id='<?php //echo "trip_from_" . $count ?>' class='form-control required'>--->
	</td>
    
	
	<td><select name="trip_to[]" id="<?php echo "trip_to_" . $count ?>" class="form-control required">
	<option value="">Select Destination</option><?php
	if(isset($allHalts) and count($allHalts))
	 {
	  foreach($allHalts as $ke=>$va)
	  {
	   ?><option value="<?php echo $va; ?>"><?php echo $va; ?></option><?php
	  }
	 }
	?></select>
	<!---<input type='text' name='trip_to[]' id='<?php //echo "trip_to_" . $count ?>' class='form-control'>-->
	</td>
    
	<td>
        <select id="<?php echo 'trip_arrange_by_' . $count ?>" name="trip_arrange_by[]" onchange='received_total()' class="form-control">
            <option value="Company">Company</option>
            <option value="Own" selected="">Own</option>
        </select>
    </td>
    <td>
        <select id="<?php echo 'trip_book_by_' . $count ?>" name="trip_book_by[]" class="form-control">
            <option value='1'>Flight</option>
            <option value='2'>Train</option>
            <option value='3'>Car</option>
            <option value='4'>Bus</option>
            <option value='5'>Bike</option>
        </select>
    </td>
    <td>
    <input type="file" name="<?php echo 'trip_attachment_'.$count.'[]';?>" id="<?php echo 'trip_attachment_' . $count ?>" multiple="" class="btn green button-submit" style="width:120px !important;">
    <input type="hidden" name="reference_id[]" value="<?php echo rand(10000,10000000); ?>">
    </td>
    
	<td><input type='number' id='<?php echo "A_A_".$count; ?>' value="0" onkeyup="add_ticket_exp('<?php echo $count; ?>');" class='required form-control only_number number intonly'></td>
	<td><input type='number' id='<?php echo "B_B_".$count; ?>' value="0" onkeyup="add_ticket_exp('<?php echo $count; ?>');" class='required form-control only_number number intonly'></td>
	<td><input type='number' id='<?php echo "C_C_".$count; ?>' value="0" onkeyup="add_ticket_exp('<?php echo $count; ?>');" class='required form-control only_number number intonly'></td>
	<td><input type='number' name='total_trip_no[]' readonly="true" value="0" id='<?php echo "total_trip_no" . $count ?>' class='required form-control only_number number intonly'></td>
</tr>

<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<?php
if ($request['trip_type'] != "1") {
    $return_date = $request['return_date'];
} else {
    $return_date = '';
}
?><script type="text/javascript">

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
minView: 1,
format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
});
</script>
