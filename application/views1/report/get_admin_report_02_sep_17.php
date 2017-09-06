<link href="<?php echo base_url(); ?>assets/new/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/new/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        
<!--<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>-->
<!--<table id="example" class="display" cellspacing="0" width="100%">-->
<table class="table" id="top_traveler">
    <thead>
        <tr>
            <th>Trip ID</th>
            <th>Employee</th>
            <th>Travel Reason</th>
            <th>Departure date</th>
            <th>Return date</th>
            <th>Service</th>
            <th>From - To</th>
            <th>Approved by</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>Trip ID</td>
            <td>Employee</td>
            <td>Travel Reason</td>
            <td>Departure date</td>
            <td>Return date</td>
            <td>Service</td>
            <td>From - To</td>
            <td>Approved by</td>
            <td>Status</td>
        </tr>                        
    </thead>
</tbody>
<?php foreach ($request as $data) { ?>
    <tr>
        <td><?php echo $data['reference_id']; ?></td>
        <td><?php echo $data['employee_name']; ?></td>
        <td><?php if ($data['travel_reason_id'] != "Projects") {
                                        echo $data['reason'];
                                    } else {
                                        echo "Projects";
                                    } ?></td>
        <td><?php echo date(DATETIME_FORMAT,strtotime($data['departure_date'])); ?></td>
        <td><?php
            if ($data['return_date'] != "0000-00-00 00:00:00") {
                echo date(DATETIME_FORMAT,strtotime($data['return_date']));
            }
            ?></td>
        <td><?php
            if ($data['travel_type'] == "1") {
                echo "Flight";
            } else if ($data['travel_type'] == "2") {
                echo "Train";
            } else if ($data['travel_type'] == "3") {
                echo "Car";
            } else if ($data['travel_type'] == "4") {
                echo "Bus";
            } else if ($data['travel_type'] == "5") {
                echo "Hotel";
            }
            if ($data['group_travel'] == "1") {
                echo "(Group Travel)";
            }
            ?></td>
        <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
        <td><?php echo $data['reporting_manager_name']; ?></td>
        <td><?php
            if ($data['approval_status'] == "Rejected") {
                echo "Rejected";
            } else if ($data['cancel_status'] == "1") {
                echo "Cancelled";
            } else {
                if ($data['request_status'] == "1") {
                    echo "Approval Pending";
                } else if ($data['request_status'] == "2") {
                    if ($data['approval_status'] == "Approved") {
                        echo "Trip Approved";
                    }
                } else if ($data['request_status'] == "3") {
                    echo "Trip Accommodation";
                } else if ($data['request_status'] == "4") {
                    echo "Expense Approval";
                } else if ($data['request_status'] == "5") {
                    echo "Expense Approval";
                } else if ($data['request_status'] == "6") {
                    echo "Finance Approval";
                } else if ($data['request_status'] == "7") {
                    echo "Audit Approval";
                } else if ($data['request_status'] == "8") {
                    echo "Audit Approval";
                } else if ($data['request_status'] == "9") {
                    echo "Completed";
                }
            }
            ?></td>
    </tr>
<?php } ?>
</tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
//         var top_traveler = $('#top_traveler');
//
//    // begin first table
//    top_traveler.dataTable({
//        "order": [[0, "desc"]],
////        "paging": false,
////        "searching": false,
////        "bInfo": false,
//        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
//        "language": {
//            "aria": {
//                "sortAscending": ": activate to sort column ascending",
//                "sortDescending": ": activate to sort column descending"
//            },
//            "emptyTable": "No data available in table",
//            "info": "Showing _START_ to _END_ of _TOTAL_ records",
//            "infoEmpty": "No records found",
//            "infoFiltered": "(filtered1 from _MAX_ total records)",
//            "lengthMenu": "_MENU_",
//            "search": "Search:",
//            "zeroRecords": "No matching records found",
//            "paginate": {
//                "previous": "Prev",
//                "next": "Next",
//                "last": "Last",
//                "first": "First"
//            }
//        },
//        // Or you can use remote translation file
//        //"language": {
//        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
//        //},
//
//        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
//        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
//        // So when dropdowns used the scrollable div should be removed. 
//        //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
//
////            "bSort" : true,
////            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
//        "lengthMenu": [
//            [5, 15, 20, -1],
//            [5, 15, 20, "All"] // change per page values here
//        ],
//        // set the initial value
//        "pageLength": 15,
//        "pagingType": "bootstrap_full_number",
//        "columnDefs": [{// set default column settings
//                'orderable': false,
//                'targets': [-1]
//            }, {
//                "searchable": false,
//                "targets": [-1]
//            }]
//    });

        $('#top_traveler thead td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" class="form-control" />');
        }); 
        var table = $('#top_traveler').DataTable(); 
        table.columns().every(function () {
            var that = this;

            $('input', this.header()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                            .search(this.value)
                            .draw();
                }
            });
        });
    });
</script>