<link href="<?php echo base_url().'assets/assets/css/morris.css';?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/new/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/new/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url(); ?>assets/new/global/scripts/datatable.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/new/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/new/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

<div class="row"><div class="col-lg-12 col-md-12 col-sm-6 col-xs-4"><div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">Chart for Mode of Travels and Trip</h3></div><div class="panel-body"><div id="morris-bar-chart"></div></div></div></div></div>

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
 xLabelAngle: 0,
 hideHover: 'auto',
 resize: true
});

var thisDate,thisData;
$("#morris-bar-chart svg rect").on('click', function(){
  xAxisLable = $(".morris-hover-row-label").html();
  get_admin_report_graph_data(xAxisLable);
 });

});
</script>