<br>

<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

<style>
    .modal-lg {
        width: 1300px;
    }
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Top 10 Stay
        </h1>
        <div class="col-md-2">
            <select class="form-control " id="top_count">
                <option value="5">Top 5</option>
                <option value="10" selected="selected">Top 10</option>
                <option value="30">Top 30</option>
                <option value="50">Top 50</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="city_id"  name="city_id" class="form-control required select2me"
                    data-placeholder="Select a City">
                <option value='0'>All City</option>
                <?php foreach ($city_data as $cost) { ?>
                    <option value="<?php echo $cost['id']; ?>">
                                <?php echo $cost['city_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
		
		<div class="col-md-2">
                <select name="dept_id" id="dept_id" class="form-control required select2me"
                        data-placeholder="Select Department" data-error-container="#add-designation-level-error">
                    <option value="0">All Departments</option>                                        
                    <?php foreach ($department as $data) { ?>
                        <option value="<?php echo $data['id']; ?>">
                            <?php echo $data['dept_name']; ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
			<div class="col-md-2">
                <select class="form-control required select2me" id="grade_id">
                    <option value="0">All Grades</option>
                    <?php foreach ($grades as $key => $value) { ?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['grade_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
		
		
			<div class="col-md-2">
            <select class="form-control" id="type">
                <option value="0">All Type</option>
                <option value="1">Hotel</option>
                <option value="2">Guest House</option>
            </select>
			</div>
		
		
    </div>
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-times"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } else if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <!--            <div class="page-header">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                </div>
                            </div>
                        </div>-->
            <div class="col-md-8 portlet light bordered" id="show_topper">

            </div>
            <div class="col-md-4">
                <h3>Top 10 Hotel Stay</h3>
                <div id="piechart"></div>
				</br>
				<h3>Top 10 Guest House Stay</h3>
                <div id="piechartGH"></div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>


<div class="modal fade" id="visitor_modal" role="dialog">
<div class="modal-dialog modal-lg"><div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Visitors</h4></div>
<div class="modal-body"><div class="row"><div class="col-md-12">
<div class="portlet light bordered" id="visitorDataHolder"></div></div></div></div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>


<script type="text/javascript">

    $(document).ready(function () {
        get_topper();
    });

    $('#top_count, #city_id, #grade_id, #dept_id, #type').change(function () {
        get_topper();
    });

    function get_topper() {
        $("#show_topper").html("<div class='alert alert-info'>Loading...</div>");
        $.ajax({
            //url: "<?php //echo base_url('report/get_guest_house_toppers'); ?>",
            url: "<?php echo base_url('report/get_all_type_toppers'); ?>",
			type: "POST",
            dataType: "html",
            data: {
                top_count: $("#top_count").val(),
                city_id: $("#city_id").val(),
				grade_id: $("#grade_id").val(),
				dept_id: $("#dept_id").val(),
				type: $("#type").val()
            },
            catch : false,
            success: function (data) {
                $("#show_topper").html(data);
				pie();
            },
            error: function () {
                $("#show_topper").html("<div class='alert alert-danger'><i class='fa fa-times'></i>Something went wrong, please try again later.</div>");
            }
        });
    }
    
    var color_list = ['#00FFFF', '#7FFFD4', '#0000FF', '#8A2BE2', '#A52A2A', '#DEB887', '#5F9EA0', '#7FFF00', '#D2691E', '#FF7F50', '#6495ED', '#DC143C', '#FF8C00', '#ADFF2F', '#FF69B4', '#E6E6FA', '#ADD8E6', '#90EE90', '#20B2AA', '#9370DB', '#3CB371'];
    google.load("visualization", "1", {packages: ["corechart"]});

function pie()
 {
  var data = google.visualization.arrayToDataTable([['Hotel Name', 'Total Trip'],
  <?php
  foreach ($hotel as $key => $value)
   {
	if ($value['type']==1 and $value['name'] != '' && $value['total_stay'] != '')
	 {
	  ?>['<?php echo $value['name']; ?>',<?php echo $value['total_stay']; ?>],<?php
	 }
   }
  ?>
 ]);

 var options = {
 title: 'Pie Chart',
 is3D: true,
 width: 320,
 height: 320,
 pieSliceTextStyle: {fontSize: 14},
 legend: {position: 'top', maxLines: 4, alignment: 'start'},
 };

 var chart_pie = new google.visualization.PieChart(document.getElementById('piechart'));
 chart_pie.draw(data, options);
 }




function pieGH() {
 var data = google.visualization.arrayToDataTable([['Hotel Name', 'Total Trip'],
 <?php
 foreach($hotel as $key => $value)
  {
   if($value['type']==2 and $value['name'] != '' && $value['total_stay'] != '')
    {
	 ?>['<?php echo $value['name']; ?>',<?php echo $value['total_stay']; ?>],<?php
	}
  }
 ?>
 ]);

 var options = {
 title: 'Pie Chart',
 is3D: true,
 width: 320,
 height: 320,
 pieSliceTextStyle: {fontSize: 14},
 legend: {position: 'top', maxLines: 4, alignment: 'start'},};

 var chart_pie = new google.visualization.PieChart(document.getElementById('piechartGH'));
 chart_pie.draw(data, options);
 }

</script>