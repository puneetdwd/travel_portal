
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <!--<h1>
            My Inbox
        </h1>-->
        <legend class="border-bottom-none">My Inbox</legend>
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
                <!--<div class="col-md-12">-->
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Trip Approval<?php echo " (" . count($pending_request) . ")" ?></a></li>
                            <?php if(count($cancel_request) != '0') { ?><li><a href="#tab2default" data-toggle="tab">Cancellation Approval<?php echo " (" . count($cancel_request) . ")" ?></a></li> <?php } ?>
                            <?php if(count($expense_request) != '0') { ?><li><a href="#tab4default" data-toggle="tab">Expense Approval<?php echo " (" . count($expense_request) . ")" ?></a></li><?php } ?>
                            <?php if(count($merge_expense_request) != '0') { ?><li><a href="#tab5default" data-toggle="tab">Merge Expense Approval<?php echo " (" . count($merge_expense_request) . ")" ?></a></li><?php } ?>
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
                                            <th class="hidden-xs">Emp ID</th>
                                            <th>Name</th>
                                            <th>From - To</th>
                                            <th class="hidden-xs">Day Plan</th>                            
                                            <th>Reason</th>                            
                                            <th>Requested Date</th>
                                            <th class="hidden-xs">Travel Type</th>
                                            <th class="no_sort" style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($pending_request as $data) {
                                            if ($data['trip_type'] != "1") {
                                                $return_date = $data['return_date'];
                                                $your_date = strtotime($data['departure_date']);
                                                $now = strtotime($data['return_date']);
                                                $datediff = $now - $your_date;

                                                $day = floor($datediff / (60 * 60 * 24));
                                                $day++;
                                            } else {
                                                $day = "Single Trip";
                                                $return_date = '';
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td class="hidden-xs"><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['requested_name']; ?></td>                                                
                                                <td><?php echo $data['from_city_name'] . ' - ' . $data['to_city_name']; ?></td>
                                                <td class="hidden-xs"><?php echo $day; ?></td>                   
                                                <td><?php
                                                    if ($data['travel_reason_id'] != "Projects") {
                                                        echo $data['reason'];
                                                    } else {
                                                        echo "Projects";
                                                    };
                                                    ?></td>
                                                <td><?php echo date(DATE_FORMAT, strtotime($data['request_date'])); ?></td>  
                                                <td class="hidden-xs"><?php
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
                                <table class="table" id="make-data-table_1">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>From - To</th>
                                            <th>Day Plan</th>                            
                                            <th>Travel Reason</th>                            
                                            <th>Requested date</th>
                                            <th>Travel Type</th>
                                            <th class="no_sort" style="width:150px;">Action</th>
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
                                                <td><?php
                                                    if ($data['travel_reason_id'] != "Projects") {
                                                        echo $data['reason'];
                                                    } else {
                                                        echo "Projects";
                                                    };
                                                    ?></td>
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($data['request_date'])); ?></td>  
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
                            <div class="tab-pane fade" id="tab4default">
                                <table class="table" id="make-data-table_2">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Travel Reason</th>
                                            <th>Departure date</th>
                                            <th>Return date</th>
                                            <th>Service</th>
                                            <th>From - To</th>
                                            <th class="no_sort" style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($expense_request as $data) { ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['requested_name']; ?></td>
                                                <td><?php
                                                    if ($data['travel_reason_id'] != "Projects") {
                                                        echo $data['reason'];
                                                    } else {
                                                        echo "Projects";
                                                    };
                                                    ?></td>
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($data['departure_date'])); ?></td>
                                                <td><?php
                                                    if ($data['return_date'] != "0000-00-00 00:00:00") {
                                                        echo date(DATETIME_FORMAT, strtotime($data['return_date']));
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
                                                            <i class="fa fa-edit"></i> Expense Approval
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab3default">
                                <table class="table" id="make-data-table_3">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>Emp Id</th>
                                            <th>Name</th>
                                            <th>Grade</th>
                                            <th>From - To</th>
                                            <th>Date</th>
                                            <th>Days Plan</th>                            
                                            <th>Requested date</th>
                                            <th>Reason</th>
                                            <th>Travel Type</th>
                                            <th>Status</th>
                                            <th class="no_sort" style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($completed_request as $data) {
                                            if ($data['trip_type'] != "1") {
                                                $return_date = $data['return_date'];
                                                $your_date = strtotime($data['departure_date']);
                                                $now = strtotime($data['return_date']);
                                                $datediff = $now - $your_date;

                                                $day = floor($datediff / (60 * 60 * 24));
                                                $day++;
                                            } else {
                                                $day = "Single Trip";
                                                $return_date = '';
                                            }
                                            
//                                            if ($data['return_date'] != "0000-00-00 00:00:00") {
//
//                                                $your_date = strtotime($data['departure_date']);
//                                                $now = strtotime($data['return_date']);
//                                                $datediff = $now - $your_date;
//
//                                                $day = floor($datediff / (60 * 60 * 24));
//                                                $day++;
//                                            } else {
//                                                $day = "Not Fix";
//                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $data['reference_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['requested_name']; ?></td>
                                                <td><?php echo $data['grade_name']; ?></td>
                                                <td><?php echo $data['from_city_name'] . ' - ' . $data['to_city_name']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($data['trip_type'] != "1") {
                                                        $dep_date = new DateTime($data['departure_date']);
                                                        $ret_date = new DateTime($data['return_date']); 
                                                        echo $dep_date->format(DATE_FORMAT) . " to " . $ret_date->format(DATE_FORMAT);
                                                    } else {
                                                        $dep_date = new DateTime($data['departure_date']);
                                                        echo $dep_date->format(DATE_FORMAT);
                                                    }
                                                    ?>
                                                </td>                                
                                                <td><?php echo $day; //$data['departure_date'];          ?></td>                                
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($data['request_date'])); ?></td>  
                                                <td><?php echo $data['reason']; ?></td>  
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
                                            echo "Audited";
                                        } else if ($data['request_status'] == "9") {
                                            echo "Completed";
                                        }
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
                            <div class="tab-pane fade" id="tab5default">
                                <table class="table" id="make-data-table_2">
                                    <thead>
                                        <tr>
                                            <th>Exp ID</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th> 
                                            <th class="no_sort" style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($merge_expense_request as $data) { ?>
                                            <tr>
                                                <td><?php echo $data['exp_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <td><?php echo $data['requested_name']; ?></td><td nowrap>
                                                    <?php if ($data['request_status'] == "5") { ?>
                                                        <a class="btn btn-xs blue" 
                                                           href="<?php echo base_url() . 'employee_request/merge_expense_pending/' . $data['id']; ?>">
                                                            <i class="fa fa-edit"></i> Expense Approval
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