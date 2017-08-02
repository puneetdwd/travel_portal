<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            My Draft
        </h1>
        <div class="pull-right">
            <a href="<?php echo base_url('employee_request/delete_all_draft'); ?>" class="btn btn-md red">Delete All</a>
        </div>
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
                                        $travel_type = "flight_travel";
                                    } else if ($data['travel_type'] == "2") {
                                        echo "Train";
                                        $travel_type = "train_travel";
                                    } else if ($data['travel_type'] == "3") {
                                        echo "Car";
                                        $travel_type = "car_travel";
                                    } else if ($data['travel_type'] == "4") {
                                        echo "Bus";
                                        $travel_type = "bus_travel";
                                    } else if ($data['travel_type'] == "5") {
                                        echo "Hotel";
                                        $travel_type = "dashboard";
                                    }
                                    ?></td>
                                <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
                                <td><?php echo $data['reporting_manager_name']; ?></td>
                                <td><?php
                                    if ($data['approval_status'] == "Rejected") {
                                        echo "Rejected";
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
                                <td nowrap>
                                    <a class="btn btn-xs blue-chambray" 
                                       href="<?php echo base_url() . $travel_type.'/index/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <a class="btn btn-xs red" 
                                       href="<?php echo base_url() . 'employee_request/delete_request/' . $data['id']; ?>">
                                        <i class="fa fa-times"></i> Delete
                                    </a>

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