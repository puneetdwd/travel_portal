<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            My Task
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
                <!--<div class="col-md-12">-->
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Trip Approval<?php echo " (" . count($pending_request) . ")" ?></a></li>
                            <li><a href="#tab2default" data-toggle="tab">Cancellation Approval<?php echo " (" . count($cancel_request) . ")" ?></a></li>
                            <li><a href="#tab4default" data-toggle="tab">Expense Approval<?php echo " (" . count($expense_request) . ")" ?></a></li>
                            <li><a href="#tab3default" data-toggle="tab">Completed</a></li>                                
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <table class="table" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>Employee ID</th>
                                            <th>Requester Name</th>
                                            <th>Travel Description</th>
                                            <th>Day Plan</th>                            
                                            <th>Travel Reason</th>                            
                                            <th>Requested date</th>
                                            <th>Travel Type</th>
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($pending_request as $data) {
                                            if ($data['return_date'] != "0000-00-00 00:00:00") {
                                                $return_date = $data['return_date'];
                                                $your_date = strtotime($data['departure_date']);
                                                $now = strtotime($data['return_date']);
                                                $datediff = $now - $your_date;

                                                $day = floor($datediff / (60 * 60 * 24));
                                                $day++;
                                            } else {
                                                $day = "Not Fix";
                                                $return_date = '';
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['requested_name']; ?></td>                                                
                                                <td><?php echo $data['from_city_name'] . ' - ' . $data['to_city_name']; ?></td>
                                                <td><?php echo $day; ?></td>                   
                                                <td><?php echo $data['reason']; ?></td>
                                                <td><?php echo$return_date; ?></td>
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
                                                        echo "(Group)";
                                                    }
                                                    ?></td>
                                                <td nowrap>
                                                    <a class="btn btn-xs purple" 
                                                       href="<?php echo base_url() . 'employee_request/approval_request/' . $data['id']; ?>">
                                                        <i class="fa fa-eye"></i> Approve / Reject
                                                    </a>               
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab2default">
                                <table class="table" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Referense ID</th>
                                            <th>Employee ID</th>
                                            <th>Requester Name</th>
                                            <th>Travel Description</th>
                                            <th>Day Plan</th>                            
                                            <th>Travel Reason</th>                            
                                            <th>Requested date</th>
                                            <th>Travel Type</th>
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($cancel_request as $data) {
                                            if ($data['return_date'] != "0000-00-00 00:00:00") {
                                                $return_date = $data['return_date'];
                                                $your_date = strtotime($data['departure_date']);
                                                $now = strtotime($data['return_date']);
                                                $datediff = $now - $your_date;

                                                $day = floor($datediff / (60 * 60 * 24));
                                                $day++;
                                            } else {
                                                $day = "Not Fix";
                                                $return_date = '';
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['requested_name']; ?></td>
                                                <td><?php echo $data['from_city_name'] . ' - ' . $data['to_city_name']; ?></td>
                                                <td><?php echo $day; ?></td>                                
                                                <td><?php echo $data['reason']; ?></td>
                                                <td><?php echo$return_date; ?></td>
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
                                                    ?></td>
                                                <td nowrap>
                                                    <a class="btn btn-xs purple" 
                                                       href="<?php echo base_url() . 'employee_request/cancel_request/' . $data['id']; ?>">
                                                        <i class="fa fa-eye"></i> view
                                                    </a>               
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab3default">
                                <table class="table" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Requester Name</th>
                                            <th>Travel Description</th>
                                            <th>Day Plan</th>                            
                                            <th>Requested date</th>
                                            <th>Travel Type</th>
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($completed_request as $data) {
                                            if ($data['return_date'] != "0000-00-00 00:00:00") {

                                                $your_date = strtotime($data['departure_date']);
                                                $now = strtotime($data['return_date']);
                                                $datediff = $now - $your_date;

                                                $day = floor($datediff / (60 * 60 * 24));
                                                $day++;
                                            } else {
                                                $day = "Not Fix";
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $data['requested_name']; ?></td>
                                                <td><?php echo $data['from_city_name'] . ' - ' . $data['to_city_name']; ?></td>
                                                <td><?php echo $day; //$data['departure_date'];        ?></td>                                
                                                <td><?php echo $data['request_date']; ?></td>
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
                                                    ?></td>
                                                <td nowrap>
                                                    <a class="btn btn-xs purple" 
                                                       href="<?php echo base_url() . 'employee_request/approval_request/' . $data['id']; ?>">
                                                        <i class="fa fa-eye"></i> view
                                                    </a>               
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab4default">
                                <table class="table" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Referense ID</th>
                                            <th>Employee ID</th>
                                            <th>Travel Reason</th>
                                            <th>Departure date</th>
                                            <th>Return date</th>
                                            <th>Service</th>
                                            <th>Travel Description</th>
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($expense_request as $data) { ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
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
                                                    ?></td>
                                                <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
                                                <td nowrap>
                                                    <?php if ($data['request_status'] == "5") { ?>
                                                        <a class="btn btn-xs blue" 
                                                           href="<?php echo base_url() . 'employee_request/expense_pending/' . $data['id']; ?>">
                                                            <i class="fa fa-edit"></i> Expense Pending
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--</div>-->






                <!--</div>-->
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>