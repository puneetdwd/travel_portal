

<tr id='<?php echo "row_load_id_" . $count ?>'>
    <td><a  onclick='remove_load_row("<?php echo $count ?>")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
    <td><?php echo $count ?></td>
    <td>
        <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
            <input style="width:100px !important;" name="loading_departure[]" id="departure_date"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime("+1 day")); ?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
    </td>
    <td>
        <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
            <input style="width:100px !important;" name="loading_return[]" id="loading_return"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime("+1 day")); ?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
    </td>
    <td><input type='text' name='load_room_no[]' maxlength="15" id='<?php echo "load_room_no" . $count ?>'  class='form-control required'></td>
    <td><input type='text' name='load_bill_no[]' maxlength="15" id='<?php echo "load_bill_no" . $count ?>' class='form-control required'></td>
    <td><input type='text' data-default='' name='load_location[]' onfocus='locationtxti(this.id)' onfocusout='locationtxtd(this.id)' id='<?php echo "load_location" . $count ?>' class='form-control csslocation'></td>
    <td></td>
    <td>
        <select name="load_arrange_by[]" onchange='received_total()' id="<?php echo 'load_arrange_by_' . $count ?>" class="form-control">
            <option value="Company">Company</option>
            <option value="Own">Own</option>
        </select> 
    </td>   
    <td><input type='number'  value="0" name='loading_expense[]' id='<?php echo "loading_expense_" . $count ?>' min="0" onkeyup='received_total()'  class='only_number form-control'></td>
    <td><input type='number'  value="0" name='other_expense[]' id='<?php echo "other_expense_" . $count ?>' min="0" onkeyup='received_total()'  class='only_number form-control'></td>
    <td><input type='number' value="0"  name='loading_total[]' id='<?php echo "loading_total_" . $count ?>' min="0" onkeyup='received_total()'  class='only_number form-control required'></td>
    <td id='<?php echo "loading_total_final_" . $count ?>' >0</td>
</tr>
<!--<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">-->

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
//            endDate: "<?php echo $return_date; ?>",
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1,
            minView: 1,
            format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
        });
</script>
