<table id="visitorsTab" class="display" cellspacing="0" width="100%">
<thead><tr><th>Trip ID</th><th>Employee</th><th>City</th><th>Grade</th>
<th>Email</th><th>Phone</th><th>Check In</th><th>Check Out</th><th>Days</th></tr>

<tr><td>Trip ID</td><td>Employee</td><td>City</td><td>Grade</td><td>Email</td><td>Phone</td><td>Check In</td><td>Check Out</td><td>Days</td></tr></thead></tbody>
<?php
foreach($visitors as $data)
 {
  $date1=date_create($data['check_in_date']);
  $date2=date_create($data['check_out_date']);
  $diff=date_diff($date1,$date2);
  ?><tr><td><?php echo $data['reference_id']; ?></td>
  <td><?php echo $data['NAME_DISPLAY']; ?></td>
  <td><?php echo $data['CITY']; ?></td>
  <td><?php echo $data['GRADE']; ?></td>
  <td><?php echo $data['email']; ?></td>
  <td><?php echo $data['PHONE1']; ?></td>
  <td><?php echo $data['check_in_date']; ?></td>
  <td><?php echo $data['check_out_date']; ?></td>
  <td><?php echo $diff->days.' Days '; if($diff->h!='' and $diff->h!=0){ echo $diff->h.' hrs'; } ?></td></tr><?php
 }
?></tbody></table>

<script type="text/javascript">

$(document).ready(function () {

var table = $('#visitorsTab').DataTable();

table.columns().every(function()
 {
  var that = this;
  $('input', this.header()).on('keyup change', function()
   {
	if(that.search() !== this.value)
	 {
	  that.search(this.value).draw();
	 }
   });
 });
});
</script>