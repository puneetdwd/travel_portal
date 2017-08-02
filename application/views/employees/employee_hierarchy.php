
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name');
      data.addColumn('string', 'Manager');
      data.addColumn('string', 'ToolTip');

      // For each orgchart box, provide the name, manager, and tooltip to show.
      /*data.addRows([
        [{v:'Mike', f:'Mike<div style="color:red; font-style:italic">President</div>'},
         '', 'The President'],
        [{v:'Jim', f:'Jim<div style="color:red; font-style:italic">Vice President</div>'},
         'Mike', 'VP'],
        ['Alice', 'Mike', ''],
        ['Bob', 'Jim', 'Bob Sponge'],
        ['Carol', 'Bob', '']
      ]);*/
      <?php if(!empty($emp_hierarchy)){ ?>  
      data.addRows([
        <?php foreach($emp_hierarchy as $emp_h){ ?>
        [{v:'<?php echo $emp_h['employee_name'] ?>', f:'<?php echo $emp_h['employee_name'] ?><div style="color:red; font-style:italic">President</div>'},
         '<?php echo $emp_h['reporting_person_name'] ?>', 'The President'],
        <?php } ?>
        ]);
        <?php } ?>

      // Create the chart.
      var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
      // Draw the chart, setting the allowHtml option to true for the tooltips.
      chart.draw(data, {allowHtml:true});
    }
</script>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Employee Hierarchy
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Employee Hierarchy</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->

    <div id="chart_div"></div>
    
</div>