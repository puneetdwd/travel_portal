<br>

<link href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Admin Report
        </h1>
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

            <div class="portlet light bordered">
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
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
                                <td><?php echo $data['reason']; ?></td>
                                <td><?php echo $data['departure_date']; ?></td>
                                <td><?php
                                    if ($data['return_date'] != "0000-00-00 00:00:00") {
                                        echo $data['return_date'];
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
                                            echo "Ticket / Accommodation";
                                        } else if ($data['request_status'] == "4") {
                                            echo "Expense Approval";
                                        } else if ($data['request_status'] == "5") {
                                            echo "Finance Approval";
                                        } else if ($data['request_status'] == "6") {
                                            echo "Completed";
                                        }
                                    }
                                    ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


                <!--</div>-->
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>




<script type="text/javascript">

    $(document).ready(function () {
        $('#example thead td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="' + title + '" class="form-control" />');
        });

        // DataTable
        var table = $('#example').DataTable();

        // Apply the search
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

//                $('#example').DataTable({
//                    initComplete: function () {
//                        this.api().columns().every(function () {
//                            var column = this;
//                            var select = $('<select><option value=""></option></select>')
//                                    .appendTo($(column.footer()).empty())
//                                    .on('change', function () {
//                                        var val = $.fn.dataTable.util.escapeRegex(
//                                                $(this).val()
//                                                );
//
//                                        column
//                                                .search(val ? '^' + val + '$' : '', true, false)
//                                                .draw();
//                                    });
//
//                            column.data().unique().sort().each(function (d, j) {
//                                select.append('<option value="' + d + '">' + d + '</option>')
//                            });
//                        });
//                    }
//                });
    });
</script>