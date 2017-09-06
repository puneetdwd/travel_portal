<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <!--<h1>
            Travel Desk Inbox
        </h1>-->
        <legend class="border-bottom-none">Travel Desk Inbox</legend>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12 padding_mob">

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
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Booking<?php echo " (" . count($request) . ")" ?></a></li>
                            <li><a href="#tab2default" data-toggle="tab">Cancellation<?php echo " (" . count($refund_request) . ")" ?></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <table class="table" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>EMP ID</th>
                                            <th>EMP Name</th>
                                            <!--<th>Mobile</th>-->
                                            <th>Travel Reason</th>
                                            <th>Departure date</th>
                                            <th>Return date</th>
                                            <th>Service</th>
                                            <th>From - To</th>
                                            <th>Approved by</th>
                                            <!--<th>Status</th>-->
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($request as $data) {
                                            $other_manager_expense = $data['other_manager_expense'];
                                            if ($data['trip_type'] == '1') {

                                                if ($data['travel_ticket'] == '1') {
                                                    $trip_ticket = $data['trip_ticket'];
                                                } else {
                                                    $trip_ticket = 1;
                                                }
                                            } else {
                                                if ($data['travel_ticket'] != '2') {
                                                    if ($data['travel_ticket'] == '1' && $data['trip_ticket_return'] == '1') {
                                                        $trip_ticket = $data['trip_ticket'];
                                                    } else {
                                                        $trip_ticket = 0;
                                                    }
                                                } else {
                                                    $trip_ticket = 1;
                                                }
                                            }

                                            if ($data['accommodation'] == '1') {
                                                $hotel_booking = $data['hotel_booking'];
                                            } else {
                                                $hotel_booking = 1;
                                            }
                                            if ($data['car_hire'] == '1') {
                                                $car_booking = $data['car_booking'];
                                            } else {
                                                $car_booking = 1;
                                            }

                                            if ($trip_ticket == 1 && $hotel_booking == 1 && $car_booking == 1 && $other_manager_expense == '1') {
                                                
                                            } else {
                                                ?>
                                                <tr>
                                                    <td><?php echo $data['reference_id']; ?></td>
                                                    <td><?php echo $data['emp_id']; ?></td>
                                                    <td><?php echo $data['first_name'] . " " . $data['last_name']; ?></td>
                                                    <!--<td><?php echo $data['mobile']; ?></td>-->
                                                    <td><?php
                                                        if ($data['travel_reason_id'] != "Projects") {
                                                            echo $data['reason'];
                                                        } else {
                                                            echo "Projects (" . $data['project_name'] . ")";
                                                        };
                                                        ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($data['departure_date'])); ?></td>
                                                    <td><?php
                                                        if ($data['trip_type'] != "1") {
                                                            echo date(DATETIME_FORMAT, strtotime($data['return_date']));
                                                        } else {
                                                            echo "Not Fix";
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
                <!--                                    <td><?php
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
                                                            echo "Audited";
                                                        } else if ($data['request_status'] == "9") {
                                                            echo "Completed";
                                                        }
                                                    }
                                                    ?></td>-->
                                                    <td nowrap>
                                                        <?php
                                                        if ($data['request_status'] == "3") {
//                                        if ($data['bookbyself'] != "1") {
                                                            ?>
                                                            <a class="btn btn-xs blue-chambray" 
                                                               href="<?php echo base_url() . 'travel_desk/booking/' . $data['id']; ?>">
                                                                <i class="fa fa-edit"></i> Travel Booking
                                                            </a>
                                                            <?php
//                                        }
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
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab2default">
                                <table class="table" id="make-data-table_1">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>EMP ID</th>
                                            <th>EMP Name</th>
                                            <th>Travel Reason</th>
                                            <th>Departure date</th>
                                            <th>Return date</th>
                                            <th>Service</th>
                                            <th>From - To</th>
                                            <th>Approved by</th>
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($refund_request as $data) {
                                            ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['first_name'] . " " . $data['last_name']; ?></td>
                                                <!--<td><?php echo $data['mobile']; ?></td>-->
                                                <td><?php
                                                    if ($data['travel_reason_id'] != "Projects") {
                                                        echo $data['reason'];
                                                    } else {
                                                        echo "Projects";
                                                    };
                                                    ?></td>
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($data['departure_date'])); ?></td>
                                                <td><?php
                                                    if ($data['trip_type'] != "1") {
                                                        echo date(DATETIME_FORMAT, strtotime($data['return_date']));
                                                    } else {
                                                        echo "Not Fix";
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
            <!--                                    <td><?php
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
                                                        echo "Audited";
                                                    } else if ($data['request_status'] == "9") {
                                                        echo "Completed";
                                                    }
                                                }
                                                ?></td>-->
                                                <td nowrap>
                                                    <a class="btn btn-xs purple" 
                                                       href="<?php echo base_url() . 'travel_desk/cancel_request/' . $data['id']; ?>">
                                                        <i class="fa fa-eye"></i> view
                                                    </a>  
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>