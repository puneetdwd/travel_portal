<br>

<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Top Traveler
        </h1>
        <div class="col-md-2">
            <select class="form-control " id="top_count">
                <option value="5">Top 5</option>
                <option value="10">Top 10</option>
                <option value="30">Top 30</option>
                <option value="50">Top 50</option>
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
            <select id="cost_center_id"  name="cost_center_id" class="form-control required select2me"
                    data-placeholder="Select a Cost Center">
                <option value='0'>All Cost Center</option>
                <?php $cost_center_id = !empty($employee['cost_center_id']) ? $employee['cost_center_id'] : ''; ?>

                <?php foreach ($cost_center as $cost) { ?>
                    <option value="<?php echo $cost['id']; ?>"
                            <?php if ($cost['id'] == $cost_center_id) { ?> selected="selected" <?php } ?>
                            >
                                <?php echo $cost['city_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="dept_id" id="dept_id" class="form-control required select2me"
                    data-placeholder="Select Department" data-error-container="#add-designation-level-error">
                <option value="0">All Depaerment</option>                                        
                <?php foreach ($department as $data) { ?>
                    <option value="<?php echo $data['id']; ?>">
                        <?php echo $data['dept_name']; ?>
                    </option>
                <?php } ?>
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
            <!--            <div class="row">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Graph
                                            <div class="pull-right">
                                                <a data-toggle="collapse" href="#collapse1">
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                            </div>
                                        </h4>                            
                                    </div>
                                    <div id="collapse1" class="panel-collapse box collapse in">
            
                                    </div>
                                </div>
                            </div>
                        </div>-->

            <div class="col-md-8 portlet light bordered" id="show_topper">

            </div>
            <div class="col-md-4">
                <h3>Top 5 Traveler</h3>
                <div id="piechart">

                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>




<script type="text/javascript">

    $(document).ready(function () {
        get_topper();
    });

    $('#top_count,#grade_id,#cost_center_id,#dept_id').change(function () {
        get_topper();
    });

    function get_topper() {
        $("#show_topper").html("<div class='alert alert-info'>Loading...</div>");
        $.ajax({
            url: "<?php echo base_url('report/get_toppers'); ?>",
            type: "POST",
            dataType: "html",
            data: {
                top_count: $("#top_count").val(),
                grade_id: $("#grade_id").val(),
                cost_center_id: $("#cost_center_id").val(),
                dept_id: $("#dept_id").val(),
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

    function pie() {
        var data = google.visualization.arrayToDataTable([
            ['Employee Name', 'Total Trip'],
<?php
foreach ($request as $key => $value) {
    if ($value['employee_name'] != '' && $value['total_trip'] != '') {
        ?>
                    ['<?php echo $value['employee_name']; ?>',<?php echo $value['total_trip']; ?>],
        <?php
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

</script>