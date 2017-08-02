<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Travel Desk Inbox
        </h1>
    </div>
    <!-- END PAGE HEADER-->

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
                <table class="table" id="make-data-table">
                    <thead>
                        <tr>
                            <th>Referense ID</th>
                            <th>Travel Reason</th>
                            <th>Departure date</th>
                            <th>Return date</th>
                            <th>Service</th>
                            <th>Travel Description</th>
                            <th>Approved by</th>
                            <th>Status</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
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
                                    }if ($data['group_travel'] == "1") {
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
                                            echo "Completed";
                                        }
                                    }
                                    ?></td>
                                <td nowrap>
                                    <?php
                                    if ($data['request_status'] == "3") {
                                        if ($data['bookbyself'] != "1") {
                                            ?>
                                            <a class="btn btn-xs blue-chambray" 
                                               href="<?php echo base_url() . 'travel_desk/booking/' . $data['id']; ?>">
                                                <i class="fa fa-edit"></i> Travel Booking
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php if ($data['request_status'] == "5") { ?>
                                        <a class="btn btn-xs blue" 
                                           href="<?php echo base_url() . 'travel_desk/expense_pending/' . $data['id']; ?>">
                                            <i class="fa fa-edit"></i> Expense Pending
                                        </a>
                                    <?php } ?>
                                </td>
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