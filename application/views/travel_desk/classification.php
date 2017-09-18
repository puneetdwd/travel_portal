<br><div class="page-content"><div class="breadcrumbs">
<h1>City Classification</h1>
<!--<ol class="breadcrumb"><li>
<a href="<?php //echo base_url(); ?>">Home</a></li>
<li class="active">City</li></ol><div class="pull-right">
<a class="btn grey-cascade" href="<?php echo base_url() . "city/add_city"; ?>">
<i class="fa fa-plus"></i> Add New City</a></div>-->
</div><div class="row"><div class="col-md-12"><?php
if($this->session->flashdata('error'))
 {
  ?><div class="alert alert-danger">
  <i class="fa fa-times"></i><?php
  echo $this->session->flashdata('error');
  ?></div><?php
 }
elseif($this->session->flashdata('success'))
 {
  ?><div class="alert alert-success"><i class="fa fa-check"></i>
  <?php echo $this->session->flashdata('success'); ?></div><?php
 }
?><div class="portlet light bordered">
<table class="table" id="make-data-table2">
<thead><tr><th>State</th><th>City</th><th>Class</th>
<th>Cost Center</th></tr></thead><tbody><?php
foreach($city as $data)
 {
  ?><tr><td><?php echo $data['state_name']; ?></td>
  <td><?php echo $data['name']; ?></td>
  <td><?php echo $data['class']; ?></td>
  <td><?php echo $data['cost_center']; ?></td></tr><?php
 }
?></tbody></table></div></div></div></div>

<script type="text/javascript">
$(document).ready(function(){
 $('#make-data-table2').dataTable({
   "aaSorting": [[2, "asc"]]
 });
});
</script>