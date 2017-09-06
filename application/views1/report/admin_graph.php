<br><link href="<?php echo base_url().'assets/assets/css/morris.css';?>" rel="stylesheet" type="text/css" />
<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<div class="page-content"><div class="breadcrumbs">
<a href="index"><img width="60px" height="60px" src="../travel_report.png" alt="My Travel Report"></a>
<!--<h1>Admin Report</h1>-->
</div>
<!-- BEGIN PAGE CONTENT-->
<div class="row"><div class="col-md-12">
<div class="panel panel-primary"><div class="panel-heading">
<h3 class="panel-title">Mode Chart</h3></div>
<div class="panel-body">
<div id="morris-bar-chart"></div>
</div></div></div></div></div>

<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>

<script type="text/javascript" charset="UTF-8" src="<?php echo base_url().'assets/assets/js/morris.min.js';?>"></script>

<script type="text/javascript" charset="UTF-8" src="<?php echo base_url().'assets/assets/js/raphael-2.1.0.min.js';?>"></script>

<script type="text/javascript"><?php
$eachDA= array();
if(isset($travel_types) and count($travel_types)>0)
{
 foreach($travel_types as $iK=>$iV)
 {
  $counter= 0;
  if(isset($typeWiseCount[$iK]))
  {
   $counter= array_sum($typeWiseCount[$iK]);
  }
  $eachDA[]= "{Modes: '".$iV."', Count: ".$counter."}";
 }
}
$codeString= '';
if(count($eachDA)>0)
{
 $codeString= implode(', ', $eachDA);
}
?>
$(function(){
	Morris.Bar({
        element: 'morris-bar-chart',
        data: [ <?php echo $codeString; ?> ],
        xkey: 'Modes',
        ykeys: ['Count'],
        labels: ['Count'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        resize: true
    });
});
</script>