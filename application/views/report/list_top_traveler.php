<link href="<?php echo base_url(); ?>assets/new/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/new/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        
<!--<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>-->

<table class="table" id="top_traveler">
    <thead>
        <tr>
            <th>Total<br> Trip</th>
            <!--<th>Trip ID</th>-->
            <th>EMP ID</th>
            <th>Employee</th>                            
            <th>Email</th>                            
            <th>Mobile</th>
			<th>Grade</th>
			<th>Department</th>
			<th>Location</th>
			
        </tr>
    </thead>
</tbody><?php
foreach ($request as $data) { ?>
    <tr>
        <td><?php echo $data['total_trip']; ?></td>
        <!--<td><?php echo $data['reference_id']; ?></td>-->
        <td><?php echo $data['employee_id']; ?></td>
        <td><?php echo $data['employee_name']; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['mobile']; ?></td>
		<td><?php echo $data['GRADE']; ?></td>
		<td><?php echo $data['dept_name']; ?></td>
		<td><?php echo $data['city_name']; ?></td>
		
    </tr>
<?php } ?>
</tbody>
</table>

<script type="text/javascript">
    var top_traveler = $('#top_traveler');

    // begin first table
    top_traveler.dataTable({
        "order": [[0, "desc"]],
        "paging": false,
        "searching": false,
        "bInfo": false,
        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ records",
            "infoEmpty": "No records found",
            "infoFiltered": "(filtered1 from _MAX_ total records)",
            "lengthMenu": "_MENU_",
            "search": "Search:",
            "zeroRecords": "No matching records found",
            "paginate": {
                "previous": "Prev",
                "next": "Next",
                "last": "Last",
                "first": "First"
            }
        },
        // Or you can use remote translation file
        //"language": {
        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
        //},

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
        // So when dropdowns used the scrollable div should be removed. 
        //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

//            "bSort" : true,
//            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
        "lengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 15,
        "pagingType": "bootstrap_full_number",
        "columnDefs": [{// set default column settings
                'orderable': false,
                'targets': [-1]
            }, {
                "searchable": false,
                "targets": [-1]
            }]
    });
</script>
