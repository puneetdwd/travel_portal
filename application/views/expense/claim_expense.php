<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<div class="page-content"> 
    <div class="header text-center">
        <h3>DB Corp Ltd.,<?php echo $employee['city_name'] ?></h3>
        <h4>Travelling Bill
            <div class="pull-right">
                <?php
                if (!empty($expense_details)) {
                    ?>
                    <a style="color:orange;text-decoration: underline" href="#emp_modal" data-toggle="modal">Clarification Comment</a><br>
                    <?php
                }
                ?>                
            </div>
        </h4>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="emp_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Clarification Comment</h4>
                </div>
                <div class="modal-body">
                    <?php
                    if (!empty($expense_details)) {
                        echo $expense_details['clarification_comment'];
                    }
                    ?>
                </div>
            </div>
        </div><!-- /.modal-dialog -->
    </div>    
    <div class="row">        
        <div class="col-md-12">
            <div class="portlet light borderLight">
                <!-- BEGIN FORM-->
                <form role="form" class="validate-form" method="post" id="expense_form" name="expense_form" enctype="multipart/form-data" >                    
                    <div class="form-body"> 
                        <div class="row">
                            <div class="col-md-12 light bordered text-center">
                                <h4 class="form-section">Expense Reimbursement Form</h4>
                                <div class="row">
                                    <table id="make-data-table_asd1" class="table table-hover table-bordered table-responsive" style="display:block;">                                        
                                        <tbody align="">
                                            <tr>
                                                <th width="15%">Name</th>
                                                <td width="16%"><?php echo $employee['first_name'] . " " . $employee['last_name'] ?></td>
                                                <th width="15%">Employee Id</th>
                                                <td width="16%"><?php echo $employee['employee_id'] ?></td>
                                                <th width="15%">Designation</th>
                                                <td width="16%"><?php echo $employee['desg_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Grade</th>
                                                <td><?php echo $employee['grade_name'] ?></td>
                                                <th>Reporting Manager</th>
                                                <td><?php echo $employee['reporting_manager'] ?></td>
                                                <th>Departure Date and Time</th>
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Return Date and Time</th>
                                                <td>
                                                    <?php
//                                                    if ($request['trip_type'] != '1') {
//                                                        echo $request['return_date'];
//                                                    } else {
                                                    ?>
                                                    <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T018:00:00Z" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
                                                        <input name="return_date" id='return_date' class="form-control required" size="16" type="text" readonly onchange="check_date()" value="<?php
//                                                            if (!empty($expense_details)) {
                                                        echo date(DATETIME_FORMAT, strtotime($request['return_date']));
//                                                            }
                                                        ?>">
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    </div>
                                                    <?php
//                                                    }
                                                    ?>
                                                </td>
                                                <th>Travel From</th>
                                                <td><?php echo $request['from_city_name'] ?></td>
                                                <th>Travel To</th>
                                                <td><?php echo $request['to_city_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Purpose of Travel</th>
                                                <td><?php echo $request['reason'] ?></td>                                                
                                                <th>Travel Type</th>
                                                <td><?php
                                                    if ($request['group_travel'] == "1") {
                                                        echo "Group Travel";
                                                    } else {
                                                        echo "Single Person";
                                                    }
                                                    ?></td>
                                                <th>Project Travel</th>
                                                <td><?php
                                                    if ($request['project_id'] != "") {
                                                        echo $project['name'];
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                    ?></td>  
                                            </tr>
                                            <tr>
                                                <th>Own/Company Arrangment</th>
                                                <td>
                                                    <select name="arrange_by" id="arrange_by" class="form-control">
                                                        <option value="Company" <?php if (!empty($expense_details)) if ($expense_details['reimbursement_arrangment'] == "Company") echo "selected"; ?>>Company</option>
                                                        <option value="Own" <?php if (!empty($expense_details)) if ($expense_details['reimbursement_arrangment'] == "Own") echo "selected"; ?>>Own</option>
                                                    </select> 
                                                </td>
                                                <th>Credit Card Number</th>
                                                <td>
                                                    <input type="text" name="credit_card_number" id="credit_card_number" class="only_number form-control number intonly" value="<?php if (!empty($expense_details)) echo $expense_details['credit_card_number']; ?>">
                                                </td>
                                                <th>Bank Name</th>
                                                <td>
                                                    <input type="text" name="bank_name" id="bank_name" class="form-control" value="<?php if (!empty($expense_details)) echo $expense_details['bank_name']; ?>">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>

                        </div>          

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Ticket Details</h4>
                                <div class="pull-right">
                                    <a  onclick="add_trip_row()" class="btn btn-sm blue-chambray">Add New Row</a>
                                </div>
                                <div class="row">
                                    <table id="ticket_table" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th></th>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Paid By</th>
                                                <th>Mode</th>
                                                <th>View</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="trip_tbody">
                                            <?php
                                            $i = 1;
                                            $total = 0;
                                            $lbltotal = 0;
                                            $ticket_cost_1 = 0;
                                            foreach ($ticket_details as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
                                                    <td><?php echo $value['location_from'] ?></td>
                                                    <td><?php echo $value['location_to'] ?></td>                                                    
                                                    <td>
                                                        <?php
                                                        if ($request['travel_ticket'] == "1") {
                                                            $arrange_by_tick = "Company";
                                                        } else {
                                                            $arrange_by_tick = "Own";
                                                        }
                                                        ?>
                                                        <select name="<?php echo 'ticket_' . $value['trip_mode'] . '_arrange_by_' . $value['type'] ?>" onchange='received_total()' id="<?php echo "ticket_arrange_by" . $i ?>" class="form-control">
                                                            <option value="Company" <?php if ($arrange_by_tick == "Company") echo "selected"; ?>>Company</option>
                                                            <option value="Own" <?php if ($arrange_by_tick == "Own") echo "selected"; ?>>Own</option>
                                                        </select> 
                                                        <!--<input type="hidden" name="<?php echo 'ticket_' . $value['trip_mode'] . '_arrange_by_' . $value['type'] ?>" id="<?php echo "ticket_arrange_by" . $i ?>" value="<?php // echo $arrange_by_tick;                         ?>">-->
                                                    </td>
                                                    <td>
                                                        <?php $service_type = !empty($value['travel_type']) ? $value['travel_type'] : ''; ?>
                                                        <?php
                                                        if ($service_type == "1") {
                                                            echo "Flight";
                                                        } else if ($service_type == "2") {
                                                            echo "Train";
                                                        } else if ($service_type == "3") {
                                                            echo "Car";
                                                        } else if ($service_type == "4") {
                                                            echo "Bus";
                                                        } else if ($service_type == "5") {
                                                            echo "Hotel";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> 
                                                        <?php if ($value['attachment'] != '') { ?>
                                                                                                                                                                                                                <!--<a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $value['attachment']; ?>">-->
                                                            <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                        <?php } ?>
                                                        <?php $total = $total + $value['cost']; ?>
                                                        <?php $lbltotal = $lbltotal + $value['cost']; ?>                                                        
                                                    </td>
                                                    <td width="10%">
                                                        <?php $ticket_cost_1 = $ticket_cost_1 + $value['cost']; ?>
                                                        <input type="number" onkeyup='received_total()' class="form-control only_number" id="<?php echo "ticket_cost_" . $i ?>" name="<?php echo "ticket_cost_" . $i ?>" value="<?php echo $value['cost']; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>                                            
                                            <?php
                                            if (!empty($expense_details)) {
                                                $total_travel_claim_hidd = $expense_details['total_claim'];
                                            } else {
                                                $total_travel_claim_hidd = 0;
                                            }
                                            if (!empty($other_trip_expense)) {
                                                foreach ($other_trip_expense as $key => $value) {
                                                    ?>
                                                    <tr id="<?php echo "row_trip_id_" . $i ?>">
                                                        <td><a  onclick="remove_trip_row('<?php echo $i ?>')" class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>                                                
                                                        <td><?php echo $i; ?></td>
                                                        <td>
                                                            <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                                <input style="width:150px !important;" name="trip_date[]" id="trip_date"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime($value['trip_date'])); ?>" readonly>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                            </div>
                                                        </td>
                                                        <td><input type='text' name='trip_from[]' id="<?php echo "trip_from_" . $i ?>" class='form-control required' value="<?php echo $value['trip_from'] ?>"></td>
                                                        <td><input type='text' name='trip_to[]' id="<?php echo "trip_from_" . $i ?>" class='form-control required' value="<?php echo $value['trip_to'] ?>"></td>                                                    
                                                        <td>
                                                            <select name="trip_arrange_by[]" onchange='received_total()' id="con_arrange_by" class="form-control">
                                                                <option value="Company" <?php if ($value['trip_arrange_by'] == "Company") echo "selected"; ?>>Company</option>
                                                                <option value="Own" <?php if ($value['trip_arrange_by'] == "Own") echo "selected"; ?>>Own</option>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="trip_book_by[]" class="form-control">
                                                                <option value='1' <?php if ($value['trip_book_by'] == "1") echo "selected"; ?>>Uber</option>
                                                                <option value='2' <?php if ($value['trip_book_by'] == "2") echo "selected"; ?>>Ola</option>
                                                                <option value='3' <?php if ($value['trip_book_by'] == "3") echo "selected"; ?>>Auto</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="<?php echo 'trip_attachment_' . $i . '[]'; ?>" id="<?php echo 'trip_attachment_' . $i ?>" multiple="" class="btn green button-submit">
                                                            <input type="hidden" name="reference_id[]" value="<?php echo $value['reference_id']; ?>">
                                                        </td>                                                    
                                                        <td width="5%">
                                                            <?php
                                                            $total = $total + $value['total'];
                                                            $total_travel_claim_hidd = $total_travel_claim_hidd - $value['total'];
//                                                        $lbltotal = $lbltotal + $value['total']; 
                                                            ?>                                                        
                                                            <input type='number' name='total_trip_no[]' id="<?php echo "total_trip_no" . $i ?>" onkeyup='received_total()'  class='only_number form-control required' value="<?php echo $value['total']; ?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>                                        
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"></td>
                                                <th align="center">Total ₹</th>
                                                <td><b id='other_trip_total'><?php
                                                        echo $total . '.00';
//                                                echo number_format($total,2);
                                                        ?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                    <input type="hidden" name="other_trip_row" id="other_trip_row" value="<?php echo $i; ?>">
                                    <input type="hidden" id="other_trip_total_hidd" value="<?php echo $lbltotal; ?>">

                                    <input type="hidden" id="other_trip_total_hidd" value="<?php echo $lbltotal; ?>">
                                </div>
                            </div>
                        </div>                       

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Guest House/Hotel/Own Arrangement</h4>
                                <div class="pull-right">
                                    <a  onclick="add_load_row()" class="btn btn-sm blue-chambray">Add New Row</a>
                                </div>
                                <div class="row">
                                    <table id="loading_hotel" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>&nbsp;</th>
                                                <th>#</th>
                                                <th>Check-In Date</th>
                                                <th>Check-Out Date</th>
                                                <th>Room<br> No</th>
                                                <th>Bill<br> No</th>
                                                <th>Location</th>
                                                <th>View<br> Bill</th>
                                                <th>Paid By</th>
                                                <th>Guest House<br>/Hotel<br> Expense</th>
                                                <th>Other<br> Expense</th>
                                                <th>Amount</th>
                                                <th>Total<br> Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_tbody">

                                            <?php
                                            $i = 1;
                                            $total1 = 0;
                                            $lbltotal1 = 0;
                                            $load_cost = 0;
                                            if (!empty($hotel_details)) {
                                                foreach ($hotel_details as $key => $value) {
                                                    $load_cost = $value['cost'];
                                                    ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo $i; ?></td>
                                                        <td>
                                                            <div class="input-group date form_datetime" data-date="<?php echo isset($value['date_from']) ? $value['date_from'] : date("Y-m-d", strtotime("+1 day")); ?>T018:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                                <input name="date_from_1" id='date_from_1' class="form-control required" size="16" type="text" readonly value="<?php
                                                                if (!empty($value['date_from'])) {
                                                                    echo date(DATETIME_FORMAT, strtotime($value['date_from']));
                                                                }
                                                                ?>">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                            </div>
                                                            <?php // echo $value['date_from']    ?>
                                                        </td>
                                                        <td>
                                                            <div class="input-group date form_datetime" data-date="<?php echo isset($value['date_to']) ? $value['date_to'] : date("Y-m-d", strtotime("+1 day")); ?>T018:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                                <input name="date_to_1" id='date_to_1' class="form-control required" size="16" type="text" readonly value="<?php
                                                                if (!empty($value['date_to'])) {
                                                                    echo date(DATETIME_FORMAT, strtotime($value['date_to']));
                                                                }
                                                                ?>">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                            </div>
                                                            <?php // echo $value['date_to']  ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control required" id="bill_no" maxlength="15" name="bill_no" value="<?php echo $value['bill_no']; ?>">
                                                            <?php // echo $value['bill_no']    ?>
                                                        </td>                                                    
                                                        <td class="col-md-1">
                                                            <input type="text" class="form-control required" id="bill_no_1" maxlength="15" name="bill_no_1" value="<?php
                                                            if ($value['bill_no_1'] == '') {
                                                                echo 0;
                                                            } else {
                                                                echo $value['bill_no_1'];
                                                            }
                                                            ?>">
                                                        </td>
                                                        <td><?php echo $value['location'] ?></td>
                                                        <td> 
                                                            <?php if ($value['attachment'] != '') { ?>
                                                                <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
                                                                    <i class="fa fa-eye"></i> View 
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <select name="<?php echo 'load_arrange_by_' . $i ?>" onchange='received_total()' id="<?php echo 'load_arrange_by_' . $i ?>" class="form-control">
                                                                <option value="Company" <?php if ($value['arrange_by'] == "Company") echo "selected" ?>>Company</option>
                                                                <option value="Own" <?php if ($value['arrange_by'] == "Own") echo "selected" ?>>Own</option>
        <!--                                                                <option value="Company" <?php if ($request['accommodation'] == "1") echo "selected" ?>>Company</option>
                                                                <option value="Own" <?php if ($request['accommodation'] == "2") echo "selected" ?>>Own</option>-->
                                                            </select>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <input type="number" class="form-control only_number " min="0" onkeyup="received_total()"  name="loading_expense_1" id="loading_expense_1" value="<?php
                                                            if ($value['loading_expense_1'] != '') {
                                                                echo $value['loading_expense_1'];
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>">
                                                        </td>
                                                        <td class="col-md-1">
                                                            <input type="number" class="form-control only_number " min="0" onkeyup="received_total()"  name="other_expense_1" id="other_expense_1" value="<?php
                                                            if ($value['other_expense_1'] != '') {
                                                                echo $value['other_expense_1'];
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>">
                                                            <!--<input type="hidden" class="form-control"  name="loading_cost" id="loading_cost" value="<?php echo $value['cost']; ?>">-->
                                                        </td>
                                                        <?php $total1 = $total1 + $value['cost'] + $value['loading_expense_1'] + $value['other_expense_1']; ?>
                                                        <?php $lbltotal1 = $lbltotal1 + $value['cost']; ?>
                                                        <?php
                                                        if (!empty($expense_details)) {
                                                            $other_expensetxt = $value['loading_expense_1'] + $value['other_expense_1'];
                                                            $total_travel_claim_hidd = $total_travel_claim_hidd - $other_expensetxt;
                                                        }
                                                        ?>
                                                        <td class="col-md-1">

                                                            <?php // if ($value['cost'] != '') { ?>
                                                            <?php // if ($value['cost'] != '0') {   ?>
                                                            <?php // echo $value['cost'];  ?>
                                                                                                                                                                                                                                                <!--                                                                    <input type="hidden" id="loading_cost" name="hotel_cost" value="////<?php echo $value['cost']; ?>">-->
                                                            <?php // } else {   ?>
                                                                                                                                                                                                                                                                                                                    <!--<input type="number" id="loading_cost" min="0" onkeyup="received_total()" class="form-control" name="hotel_cost" value="">-->
                                                            <?php // }   ?>
                                                            <?php // } else {   ?>
                                                                                                                                                                                                                                                                                                                <!--<input type="number" id="loading_cost" min="0" onkeyup="received_total()" class="form-control" name="hotel_cost" value="////<?php echo $value['cost']; ?>">-->
                                                            <?php // }    ?>
                                                            <input type="number" id="loading_cost" min="0" onkeyup="received_total()" class="only_number form-control" name="hotel_cost" value="<?php echo $value['cost']; ?>">
                                                            <input type="hidden" id="loadtotal" value="<?php echo $value['cost']; ?>" class="form-control">
                                                        </td>                                                                                                                
                                                        <td id="loading_total_1">
                                                            <?php echo $value['cost'] + $value['loading_expense_1'] + $value['other_expense_1']; ?>                                                            
                                                        </td>

                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            } else {
                                                ?>
                                            <input type="hidden" name="loading_expense_1" id="loading_expense_1" value="0">
                                            <input type="hidden" name="other_expense_1" id="other_expense_1" value="0">
                                            <input type="hidden" name="loading_cost" id="loading_cost" value="0">
                                            <?php
                                        }
                                        ?>            
                                        <?php
                                        $i = 2;
                                        if (!empty($other_loading_booking)) {
                                            foreach ($other_loading_booking as $key => $value) {
                                                ?>
                                                <tr id="<?php echo "row_load_id_" . $i ?>">
                                                    <td><a  onclick="remove_load_row('<?php echo $i ?>')" class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
                                                    <td><?php echo $i; ?></td>                                                
                                                    <td>
                                                        <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                            <input style="width:100px !important;" name="loading_departure[]" id="departure_date"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime($value['loading_departure'])); ?>" readonly>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                            <input style="width:100px !important;" name="loading_return[]" id="loading_return"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime($value['loading_return'])); ?>" readonly>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        </div>
                                                    </td>
                                                    <td><input type='text' name='load_room_no[]' id="<?php echo "load_room_no" . $i; ?>" class='form-control required' value="<?php echo $value['room_no']; ?>"></td>
                                                    <td><input type='text' name='load_bill_no[]' id="<?php echo "load_bill_no" . $i; ?>" class='form-control required' value="<?php echo $value['bill_no']; ?>"></td>
                                                    <td><input type='text' name='load_location[]' id="<?php echo "load_location" . $i; ?>" class='form-control required' value="<?php echo $value['location']; ?>"></td>
                                                    <td>
                                                        <input type="file" name="<?php echo 'load_attachment_' . $i . '[]'; ?>" id="<?php echo 'load_attachment_' . $i ?>" multiple="" class="btn green button-submit" style="width:120px !important;">
                                                        <input type="hidden" name="load_reference_id[]" value="<?php echo $value['reference_id']; ?>">
                                                    </td>
                                                    <td>
                                                        <select name="load_arrange_by[]" onchange='received_total()' id="<?php echo 'load_arrange_by_' . $i ?>" class="form-control">
                                                            <option value="Company" <?php if ($value['arrange_by'] == "Company") echo "selected"; ?>>Company</option>
                                                            <option value="Own" <?php if ($value['arrange_by'] == "Own") echo "selected"; ?>>Own</option>
                                                        </select> 
                                                    </td>                                                    
                                                    <td><input type='text' name='loading_expense[]' id="<?php echo "loading_expense_" . $i ?>" onkeyup='received_total()'  class='form-control only_number ' value="<?php echo $value['loading_expense'] ?>"></td>
                                                    <td><input type='text' name='other_expense[]' id="<?php echo "other_expense_" . $i ?>" onkeyup='received_total()'  class='form-control only_number ' value="<?php echo $value['other_expense'] ?>"></td>
                                                    <td><input type='text' name='loading_total[]' id="<?php echo "loading_total_" . $i ?>"  onkeyup='received_total()'  class='form-control required only_number ' value="<?php echo $value['loading_total'] ?>"></td>
                                                    <?php
                                                    $total_loading = $value['loading_total'] + $value['loading_expense'] + $value['other_expense'];
                                                    $total1 = $total1 + $total_loading;
//                                                    $lbltotal1 = $lbltotal1 + $total_loading;


                                                    if ($value['arrange_by'] == "Own") {
                                                        $total_unpaid_claim = $total_unpaid_claim - $total_loading;
                                                    } else {
                                                        $total_travel_claim_hidd = $total_travel_claim_hidd - $total_loading;
                                                    }
                                                    ?>
                                                    <?php
                                                    if (!empty($expense_details)) {
//                                                        $other_expensetxt = $value['loading_expense'] + $value['other_expense'];
//                                                        $total_travel_claim_hidd = $total_travel_claim_hidd - $other_expensetxt;
                                                    }
                                                    ?>
                                                    <td width="5%" id="<?php echo "loading_total_final_" . $i; ?>">                                                    
                                                        <?php echo $total_loading; ?>
                                                    </td>

                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="11">If Company Guest House is not available, View Ticket should available here</td>
                                                <th><b id="other_load_total">Total ₹</b></th>
                                                <td><b id="loading_total_final"><?php echo $total1 . '.00'; ?></b></td>                                        
                                            </tr>
                                        </tfoot>
                                    </table> 
                                    <input type="hidden" name="other_load_row" id="other_load_row" value="<?php echo $i; ?>">
                                    <input type="hidden" id="other_load_total_hidd" value="<?php echo $lbltotal1; ?>">
                                </div>
                            </div>
                        </div>

						
<div class="row"><div class="col-md-12 light bordered ">
<h4 class="form-section">DA Particulars</h4><div class="row">
<table id="da_perticulars" class="table table-hover table-bordered text-center">
<thead><tr class="th_blue"><th>#</th><th>From Date</th>
<th>To Date</th><th>Location</th><th>No of Day</th>
<th>DA@per day</th><th>Amount</th></tr></thead><tbody><tr><td>1</td><td>
<input type="hidden" value="<?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?>" name="departure_date" id="departure_date">
<?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?></td>
<td id="lbl_da_return_date"><?php echo date(DATETIME_FORMAT, strtotime($request['return_date'])); ?></td>
<td><?php echo $request['to_city_name']; ?></td>
<td id="lbl_day"><?php echo $day . " Day," . $hours . " hours"; ?></td>
<td  class="col-md-2"><input type="hidden" class="form-control required" name="da_actual" id="da_actual" value="<?php echo $request['DA_allowance_actual']; ?>"><?php
if($request['DA_allowance_actual'] != '1')
 {
  echo $request['DA_allowance'];
  ?><input type="hidden" name="da_allowance" id="da_allowance"  onkeyup="received_total()" placeholder="DA/Per day" value="<?php echo $request['DA_allowance']; ?>"><?php
 }
else
 {
  ?><input type="number" class="only_number form-control required" name="da_allowance" id="da_allowance"  onkeyup="received_total()" placeholder="DA/Per day" value="<?php if(!empty($expense_details)){ echo $request['DA_allowance']; } else { echo 0; } ?>"><?php
 }
?><input type="hidden" class="form-control required" name="day" id="day" value="<?php echo $day; ?>">
<input type="hidden" class="form-control required" name="hours" id="hours" value="<?php echo $hours; ?>"></td><?php
$total2 = 0;
$expense_da = 0;
$da_total = 0;
if($request['DA_allowance_actual'] != '1')
 {
  $da_total = $request['DA_allowance'] * $day;
  if($hours != '0')
   {
	if($hours != '')
	 {
	  if($hours < 14)
	   {
		$da = $request['DA_allowance'] / 2;
		$da_total = $da_total + $da;
	   }
	  else
	   {
		$da_total = $da_total + $request['DA_allowance'];
	   }
     }
   }
  $total2 = $total2 + $da_total;
 }
else
 {
  if(!empty($expense_details))
   {
	$da_total = $request['DA_allowance'] * $day;
	if($hours != '0')
	 {
	  if($hours != '')
	   {
		if ($hours < 14)
		 {
		  $da = $request['DA_allowance'] / 2;
		  $da_total = $da_total + $da;
		 }
		else
		 {
		  $da_total = $da_total + $request['DA_allowance'];
		 }
	   }
	 }
   }

?><!--<input type="text" id="da_total" name="da_total" value="<?php if (!empty($expense_details)) echo $request['DA_allowance'] * $day; ?>" class="form-control" disabled="">--><?php

if(!empty($expense_details))
 {
  $total_da = $request['DA_allowance'] * $day;
  if ($hours != '0')
   {
	if ($hours != '')
	 {
	  if ($hours < 14)
	   {
		$da = $request['DA_allowance'] / 2;
		$total_da = $total_da + $da;
	   }
	  else
	   {
		$total_da = $total_da + $request['DA_allowance'];
	   }
	 }
   }
  $total2 = $total2 + $total_da;
 }
 ?><input type="hidden" id="da_total_hidd" name="da_total_hidd" value="<?php echo $total2 ?>"><?php
}
?><td width="5%" id="lbl_final_da"><?php echo $da_total; $expense_da = $da_total; ?></td></tr></tbody>
<tfoot><tr><td colspan="5"></td><th>Total ₹</th>
<td><b id="da_final_total"><?php if(isset($DA_50) and $DA_50>0){ if($DA_50==3){ echo '0.00'; }elseif($DA_50==1 or $DA_50==2){ $policyApplied= $total2/2; echo round($policyApplied, 2); } }else{ echo $total2 . '.00'; } ?></b></td></tr></tfoot></table></div></div></div>


                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Conveyance-Car Hire Bills</h4>
                                <div class="pull-right">
                                    <a  onclick="add_con_row()" class="btn btn-sm blue-chambray">Add New Row</a>
                                </div>
                                <div class="row">
                                    <?php $total3 = 0; ?>
                                    <table id="conveyance_car" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th></th>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Location From</th>
                                                <th>Location To</th>
                                                <th>Book By</th>
                                                <th>Mode</th>
                                                <th>View Bill</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="con_tbody">
                                            <?php
                                            $i = 1;
                                            $total3 = 0;
                                            $lbltotal3 = 0;
                                            $con_total = 0;
                                            $expense_con = 0;
                                            foreach ($car_details as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $i++; ?></td>
                                                    <td>
                                                        <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                            <input style="width:150px !important;" name="con_date_1" id="con_date_1"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?>" readonly>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        </div>
                                                        <?php // echo $value['date']          ?>
                                                    </td>
                                                    <td><?php echo $value['location_from'] ?></td>
                                                    <td><?php echo $value['location_to'] ?></td>
                                                    <td><?php
                                                        if ($value['book_by'] == "1") {
                                                            echo "Uber";
                                                        } else if ($value['book_by'] == "2") {
                                                            echo "Ola";
                                                        } else if ($value['book_by'] == "3") {
                                                            echo "Auto";
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <?php
                                                        if ($request['car_hire'] == "1") {
                                                            $arrange_by_tick = "Company";
                                                        } else {
                                                            $arrange_by_tick = "Own";
                                                        }
                                                        ?>
                                                        <select name="<?php echo 'ticket_arrange_by_5' ?>" onchange='received_total()' id="con_arrange_by_1" class="form-control">
                                                            <option value="Company" <?php if ($arrange_by_tick == "Company") echo "selected"; ?>>Company</option>
                                                            <option value="Own" <?php if ($arrange_by_tick == "Own") echo "selected"; ?>>Own</option>
                                                        </select> 
                                                        <!--<input type="hidden" name="<?php echo 'ticket_arrange_by_5' ?>" id="con_arrange_by_1" value="<?php echo $arrange_by_tick; ?>">-->    
                                                    </td>
                                                    <td> 
                                                        <?php if ($value['attachment'] != '') { ?>
                                                            <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                        <?php } ?>
                                                        <?php $con_total = $value['cost']; ?>
                                                        <?php $total3 = $total3 + $value['cost']; ?>
                                                        <?php $lbltotal3 = $lbltotal3 + $value['cost']; ?>
                                                    </td>                                                    
                                                    <td width="10%">
                                                        <?php // echo $value['cost'];       ?>
                                                        <input type="number" onkeyup='received_total()'   name="con_total_1" id="con_total_1" class="only_number form-control" value="<?php echo $value['cost']; ?>">
                                                    </td>
                                                </tr>
                                            <?php } ?>    
                                            <?php
                                            if (!empty($other_con_booking)) {
                                                foreach ($other_con_booking as $key => $value) {
                                                    ?>
                                                    <tr id="<?php echo "row_con_id_" . $i ?>">
                                                        <td><a  onclick="remove_con_row('<?php echo $i ?>')" class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
                                                        <td><?php echo $i++; ?></td>                                                    
                                                        <td>
                                                            <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                                <input style="width:150px !important;" name="con_date[]" id="con_date"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime($value['con_date'])) ?>" readonly>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                            </div>
                                                        </td>
                                                        <td><input type='text' name='con_from[]' id="<?php echo "con_from_" . $i ?>" class='form-control required' value="<?php echo $value['con_from'] ?>"></td>
                                                        <td><input type='text' name='con_to[]' id="<?php echo "con_to_" . $i ?>" class='form-control required' value="<?php echo $value['con_to'] ?>"></td>                                                    
                                                        <td>
                                                            <select name="con_book_by[]" class="form-control">
                                                                <option value='1' <?php if ($value['con_book_by'] == "1") echo "selected"; ?>>Uber</option>
                                                                <option value='2' <?php if ($value['con_book_by'] == "2") echo "selected"; ?>>Ola</option>
                                                                <option value='3' <?php if ($value['con_book_by'] == "3") echo "selected"; ?>>Auto</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="con_arrange_by[]" onchange='received_total()' id="con_arrange_by" class="form-control">
                                                                <option value="Company" <?php if ($value['con_arrange_by'] == "Company") echo "selected"; ?>>Company</option>
                                                                <option value="Own" <?php if ($value['con_arrange_by'] == "Own") echo "selected"; ?>>Own</option>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <input type="file" name="<?php echo 'con_attachment_' . $i . '[]'; ?>" id="<?php echo 'con_attachment_' . $i ?>" multiple="" class="btn green button-submit" style="width:120px !important;">
                                                            <input type="hidden" name="con_reference_id[]" value="<?php echo $value['reference_id']; ?>">
                                                        </td>
                                                        <td width="5%">
                                                            <?php $total3 = $total3 + $value['total']; ?>
                                                            <?php // $lbltotal3 = $lbltotal3 + $value['total'];            ?>
                                                            <?php $total_travel_claim_hidd = $total_travel_claim_hidd - $value['total']; ?>

                                                            <input type='number' name='total_con_no[]' id="<?php echo "total_con_no" . $i; ?>"  onkeyup='received_total()'  class='only_number form-control required' value="<?php echo $value['total']; ?>">                                                        
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"></td>
                                                <th>Total ₹</th>
                                                <td><b id='other_con_total'><?php
                                                        echo $total3 . '.00';
                                                        $expense_con = $total3;
                                                        ?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                    <input type="hidden" name="other_con_row" id="other_con_row" value="<?php echo $i; ?>">
                                    <input type="hidden" id="other_con_total_hidd" value="<?php echo $lbltotal3; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Other Expense Details</h4>
                                <div class="pull-right">
                                    <a  onclick="add_row()" class="btn btn-sm blue-chambray">Add New Row</a>
                                </div>
                                <div class="row">
                                    <?php $total4 = 0; ?>
                                    <?php $total5 = 0; ?>
                                    <input type="hidden" id="other_manager_expense" name="other_manager_expense" value="<?php
                                    if (isset($other_manager_expense)) {
                                        echo $other_manager_expense;
                                    } else {
                                        echo "0";
                                    }
                                    ?>">
                                    <table id="other_expense" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <!--<th class="no_sort" style="width:150px;"></th>-->
                                                <th>Remove</th>
                                                <th>Date</th>
                                                <th>Expense Details</th>
                                                <th>Expense Location</th>
                                                <th>Paid By</th>
                                                <th>Bill No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"> 
                                            <?php if (isset($other_manager_expense)) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td id="other_manager_expense_date">
                                                        <?php
                                                        if ($request['return_date'] != '') {
                                                            echo date(DATETIME_FORMAT, strtotime($request['departure_date'])) . " <br>  To  <br>" . date(DATETIME_FORMAT, strtotime($request['return_date']));
                                                        } else {
                                                            echo date(DATETIME_FORMAT, strtotime($request['departure_date']));
                                                        }
                                                        ?>                                                        
                                                    </td>
                                                    <td>

                                                        <table width="210" border="1">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Food</td>
                                                                    <td>Travel</td>
                                                                 <!--   <td>Others</td>-->
                                                                </tr>
                                                                <tr>
                                                                    <td> <?php echo $other_manager_expense_food; ?></td>
                                                                    <td><?php echo $other_manager_expense_travel; ?></td>
                                                                    <?php /* ?> <td><?php echo $other_manager_expense_other;?></td><?php */ ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <?php /* ?> <?php
                                                          echo "Food: Rs." . $other_manager_expense_food . "<br>";
                                                          echo "Travel: Rs." . $other_manager_expense_travel . "<br>";
                                                          echo "Others: Rs." . $other_manager_expense_other . "<br>";
                                                          ?><?php */ ?>
                                                    </td>
                                                    <td><?php
                                                        if (isset($other_manager_expense_location)) {
                                                            echo $other_manager_expense_location;
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <?php
                                                        echo $request['to_city_name'] . " Travel Desk";
                                                        ?>
                                                    </td>
                                                    <td>-</td>
                                                    <td><?php
                                                        echo $other_manager_expense;
                                                        $total5 = $total5 + $other_manager_expense;
                                                        ?>
                                                        <input type="hidden" id="other_manager_expense" value="<?php echo $other_manager_expense; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                $other_manager_expense = 0;
                                            }
                                            ?>
                                            <?php
                                            $i = 1;
                                            if (!empty($other_expense)) {
                                                foreach ($other_expense as $key => $value) {
                                                    $amount = $value['amount'];
                                                    $total4 = $total4 + $amount;
                                                    $total5 = $total5 + $amount;
                                                    ?>
                                                    <tr id="<?php echo "row_id_" . $i; ?>">
                                                        <td><a  onclick='remove_row("<?php echo $i; ?>")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
                                                        <!--<td><?php echo $i; ?></td>-->
                                                        <td>
                                                            <div class="input-group date form_datetime" data-date="<?php echo date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                                <input style="width:150px !important;" name="other_date[]" id="<?php echo "other_date_" . $i ?>"  class="form-control" size="16" type="text" value="<?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?>" readonly>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select name="expense_name[]" class="form-control required" id='<?php echo "expense_name_" . $i ?>'>
                                                                <option value="">Select Expense ..</option>
                                                                <?php
                                                                if (isset($other_expencesData)) {
                                                                    foreach ($other_expencesData as $OtherExpenceData) {
                                                                        ?>
                                                                        <option value="<?php echo $OtherExpenceData['id']; ?>" <?php if($OtherExpenceData['id'] == $value['expense_name_id']) echo "selected"; ?>><?php echo $OtherExpenceData['expense_name']; ?></option>
                                                                    <?php }
                                                                }
                                                                ?>
                                                            </select>
                                                            <!--<input type='text' name='expense_name[]' id='<?php echo "expense_name_" . $i; ?>' value="<?php echo $value['expense_name']; ?>" class='form-control required'>-->
                                                        </td>
                                                        <td><input type='text' name='expense_type[]' id='<?php echo "expense_type" . $i; ?>' value="<?php echo $value['expense_type']; ?>" class='form-control required'></td>
                                                        <td>
                                                            <select name="other_arrange_by[]" onchange='received_total()' id="<?php echo "other_expense_arrange_by_" . $i ?>" class="form-control">
                                                                <option value="Company" <?php if ($value['arrange_by'] == "Company") echo "selected"; ?>>Company</option>
                                                                <option value="Own" <?php if ($value['arrange_by'] == "Own") echo "selected"; ?>>Own</option>
                                                            </select>
                                                        </td>
                                                        <td><input type='text' name='expense_bill_no[]' maxlength="15" id='<?php echo "bill_no_" . $i; ?>' value="<?php echo $value['bill_no']; ?>" class='form-control'></td>
                                                        <td><input type='number' name='total_no[]' id='<?php echo "total_no" . $i; ?>'  onkeyup='received_total()'  class='only_number form-control required' value="<?php echo $value['amount'] ?>"></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"></td>
                                                <th>Total ₹</th>
                                                <th id="other_total"><?php echo $total5 . '.00';
                                            ?></th>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                    <input type="hidden" name="other_row" id="other_row" value="<?php echo $i; ?>">

                                </div>
                            </div>
                        </div>
                        <?php
                        if (!empty($expense_details)) {
                            $less_advance = $expense_details['less_advance'];
                            $total_travel_claim_db = $total_travel_claim;

                            $total_travel_claim_hidd_db = $total_travel_claim_hidd;
                            $total_travel_claim_hidd_db - $total2;
                            $total_travel_claim_hidd_db = $total_travel_claim_hidd_db - $total4;

                            $total_travel_claim = $total_travel_claim;
                            $total_travel_claim_hidd_db = $total_travel_claim - $other_manager_expense;

                            $total_travel_claim_hidd_db = $total_travel_claim_hidd_db - $con_total;
                            $total_travel_claim_hidd_db = $total_travel_claim_hidd_db - $ticket_cost_1;
                            $total_travel_claim_hidd_db = $total_travel_claim_hidd_db - $load_cost;
//                            if ($request['DA_allowance_actual'] != '1') {
                            $total_travel_claim_hidd_db = $total_travel_claim_hidd_db - $da_total;
//                            }

                            $total_travel_claim = $expense_details['final_total_claim'];


                            $total_unpaid_claim_show = $expense_details['total_claim'];
                            $total_unpaid_claim_hidd = $total_unpaid_claim;
                            $total_unpaid_claim_hidd = $total_unpaid_claim - $da_total;
//                            $total_unpaid_claim_hidd = $total_unpaid_claim - $con_total;

                            $total_travel_claim_hidd - $total2;
                            $total_travel_claim_hidd = $total_travel_claim_hidd - $total4;

//                            $total_travel_claim = $total_travel_claim - $total_unpaid_claim_show;
                            $total_travel_claim_hidd = $total_travel_claim - $other_manager_expense;
                            $your_recived_hidd = $total_unpaid_claim_show - $other_manager_expense;
                        } else {
                            $your_recived_hidd = 0;
                            $less_advance = 0;
                            $total_travel_claim = $total_travel_claim;
                            $total_travel_claim_hidd = $total_travel_claim - $other_manager_expense;

                            $total_unpaid_claim_show = $total_unpaid_claim;
                            $total_unpaid_claim_hidd = $total_unpaid_claim;

                            $total_travel_claim_hidd_db = $total_travel_claim_hidd - $con_total;
                            $total_travel_claim_hidd_db = $total_travel_claim_hidd - $ticket_cost_1;
                            if ($request['DA_allowance_actual'] != '1') {
                                $total_travel_claim_hidd_db = $total_travel_claim_hidd_db - $da_total;
                                $total_unpaid_claim_hidd = $total_unpaid_claim_hidd - $da_total;
                            }
                            $total_travel_claim_hidd_db = 0;
//                            $total_travel_claim_hidd = $total_travel_claim;
                        }
                        ?>      
                        <!--<input type="text" name="hidd_total_claim" id="hidd_total_claim" value="<?php echo $total_travel_claim_hidd_db; ?>" >-->
                        <!--<input type="text" name="total_unpaid_claim_hidd" id="total_unpaid_claim_hidd" value="<?php echo $total_unpaid_claim_hidd; ?>" >-->
                        <input type="hidden" name="hidd_total_claim" id="hidd_total_claim" value="0" >
                        <input type="hidden" name="total_unpaid_claim_hidd" id="total_unpaid_claim_hidd" value="0" >
                        <input type="hidden" name="total_claim" id="total_claim" value="<?php echo $total_unpaid_claim_show; ?>" >
                        <input type="hidden" name="final_total_claim" id="final_total_claim" value="<?php echo $total_travel_claim; ?>" >
                        <input type="hidden" name="your_recived_hidd" id="your_recived_hidd" value="<?php echo $your_recived_hidd - $less_advance; ?>">

                        <input type="hidden" name="car_hire" id="car_hire" value="<?php echo $request['car_hire']; ?>" >
                        <input type="hidden" name="accommodation" id="accommodation" value="<?php echo $request['accommodation']; ?>" >
                        <input type="hidden" name="travel_ticket" id="travel_ticket" value="<?php echo $request['travel_ticket']; ?>" >                        
                        <input type="hidden" name="expense_da" id="expense_da" value="<?php echo $expense_da; ?>" >
                        <input type="hidden" name="expense_con" id="expense_con" value="<?php echo $expense_con; ?>" >

                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Trip Expense Total</th>
                                            <th id="lbl_total_claim1">
<?php echo $total_travel_claim; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Paid By Company</th>
                                            <th id="lbl_total_claim_company">
<?php echo $total_travel_claim - $total_unpaid_claim_show; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Paid By Self</th>
                                            <th id="lbl_total_claim">
<?php echo $total_unpaid_claim_show - $da_total; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>D.A.</th>
                                            <th id="lbl_da_total">
<?php echo $da_total; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Other Expense By Travel Desk</th>
                                            <th>
                                                <?php
                                                if (isset($other_manager_expense)) {
                                                    echo $other_manager_expense;
                                                } else {
                                                    $other_manager_expense = 0;
                                                }
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Travel Advance</th>
                                            <th class="col-md-3">
                                                <input type="number" autocomplete="off" name="les_advance" id="les_advance" class="only_number form-control" onkeyup="received_total()" value="<?php echo $less_advance; ?>">
                                            </th>
                                        </tr>
<?php $TotalAmountSummery = $total_unpaid_claim_show - $less_advance - $other_manager_expense; ?>
                                        <tr>
                                            <th>
                                                <?php if ($TotalAmountSummery >= 0) { ?>
                                                    Pay to Employee
                                                <?php } else { ?>
                                                    <span style="color:red;">  Employee will pay to company</span>
<?php } ?>
                                            </th>
                                            <th id="your_recived">
<?php echo $TotalAmountSummery; ?>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if ($request['travel_type'] == "1") {
                                $travel_mode = "Flight";
                            } else if ($request['travel_type'] == "2") {
                                $travel_mode = "Train";
                            } else if ($request['travel_type'] == "3") {
                                $travel_mode = "Car";
                            } else if ($request['travel_type'] == "4") {
                                $travel_mode = "Bus";
                            }
                            ?>
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="th_blue">
                                            <th>Expense Type</th>
                                            <th>Eligibility@Per Day</th>
                                            <!--<th>Requested</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Travel Mode/Class</td>
                                            <td><?php
                                                if ($eligibility_mode != '') {
                                                    echo $eligibility_mode . "/" . $eligibility_class;
                                                } else {
                                                    if ($sel_traverl_class != '') {
                                                        echo $travel_mode . "/" . $sel_traverl_class;
                                                    } else {
                                                        echo $travel_mode;
                                                    }
                                                }
                                                ?></td>
                                            <!--<td><?php echo $travel_mode . "/" . $request['travel_class']; ?></td>-->
                                        </tr>
                                        <tr>
                                            <td>D.A.</td>
                                            <td><?php echo $DA_allowance; ?></td>
<!--                                            <td><?php
                                            if ($request['DA_allowance_actual'] != 1) {
                                                echo $request['DA_allowance'];
                                            } else {
                                                echo "Actual";
                                            }
                                            ?></td>-->
                                        </tr>
                                        <tr>
                                            <td>Hotel</td>
                                            <td><?php echo $hotel_allowance; ?></td>
<!--                                            <td><?php
                                            if ($request['hotel_allowance_actual'] != 1) {
                                                echo $request['hotel_allowance'];
                                            } else {
                                                echo "Actual";
                                            }
                                            ?></td>-->
                                        </tr>
                                        <tr>
                                            <td>Convency</td>
                                            <td><?php echo $convince_allowance; ?></td>
<!--                                            <td><?php
                                            if ($request['convince_allowance_actual'] != 1) {
                                                echo $request['convince_allowance'];
                                            } else {
                                                echo "Actual";
                                            }
                                            ?></td>-->
                                        </tr>
                                    </tbody>
                                </table>   
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-offset-1 col-md-12">
                                    ** Pls attach all Bills, Upload Option&nbsp;<br>
                                    <input type="file" name="other_attachment[]" id="other_attachment" class="btn green button-submit" multiple capture><br>
                                    <input type="submit" class="btn green button-submit">
                                    <a href="<?php echo base_url() . 'employee_request'; ?>" class="btn default">
                                        <i class="m-icon-swapleft"></i> Back 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<input type="hidden" name="request_id" id="request_id" value="<?php echo $request['id']; ?>">
<input type="hidden" id="add_row_flag" value="0">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCdGlqSgU-wNjCn6_mig33UF5yv5QB7tqI"></script>

<script type="text/javascript">

                                                    $(".only_number").on('keypress', function (evt) {
                                                        evt = (evt) ? evt : window.event;
                                                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                                                        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                                            return false;
                                                        }
                                                        return true;
                                                    });

                                                    function check_date() {
                                                        var departure_date = $("#departure_date").val();
                                                        var return_date = $("#return_date").val();


                                                        $.ajax({
                                                            url: "<?php echo base_url('employee_request/get_days_hours'); ?>",
                                                            type: "POST",
                                                            dataType: "json",
                                                            data: {departure_date: departure_date, return_date: return_date},
                                                            catch : false,
                                                            success: function (data) {
                                                                var Days = data.day;
                                                                var hours = data.hours;
                                                                var departure_date1 = data.departure_date;
                                                                var return_date1 = data.return_date;

                                                                $("#day").val(Days);
                                                                $("#hours").val(hours);
                                                                $("#lbl_day").text(Days + " Day, " + hours + " hours");
                                                                $("#lbl_da_return_date").text(return_date1);
                                                                $("#other_manager_expense_date").text(departure_date1 + " To " + return_date1);
                                                                received_total();
                                                            }
                                                        });

                                                    }
                                                    function received_total() {
                                                        var hidd_total_claim = $("#hidd_total_claim").val();
                                                        var total_unpaid_claim_hidd = $("#total_unpaid_claim_hidd").val();

                                                        var loading_cost = $("#loading_cost").val();
                                                        var loading_expense_1 = $("#loading_expense_1").val();
                                                        var other_expense_1 = $("#other_expense_1").val();
                                                        var accommodation = $("#accommodation").val();
                                                        var load_arrange_by_1 = $("#load_arrange_by_1").val();

                                                        if (!$("#loading_cost").length) {
                                                            loading_cost = 0;
                                                        }
                                                        if (!$("#loading_expense_1").length) {
                                                            loading_expense_1 = 0;
                                                        }
                                                        if (!$("#other_expense_1").length) {
                                                            other_expense_1 = 0;
                                                        }
                                                        if (loading_cost == '') {
                                                            loading_cost = 0;
                                                        }
                                                        if (loading_expense_1 == '') {
                                                            loading_expense_1 = 0;
                                                        }
                                                        if (other_expense_1 == '') {
                                                            other_expense_1 = 0;
                                                        }

                                                        var final_cost = parseInt(loading_cost) + parseInt(loading_expense_1) + parseInt(other_expense_1);
                                                        $("#loading_total_1").text(final_cost);
                                                        $("#loading_total_final").text(final_cost.toFixed(2));

                                                        if (load_arrange_by_1 == "Own") {
//                                                            total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(loading_expense_1) + parseInt(other_expense_1);
                                                            total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(loading_cost) + parseInt(loading_expense_1) + parseInt(other_expense_1);
                                                            hidd_total_claim = parseInt(loading_cost) + parseInt(hidd_total_claim) + parseInt(loading_expense_1) + parseInt(other_expense_1);
                                                        } else {
                                                            hidd_total_claim = parseInt(loading_cost) + parseInt(hidd_total_claim) + parseInt(loading_expense_1) + parseInt(other_expense_1);
                                                        }


                                                        var other_load_total = 0;
                                                        var other_load_total_hidd = final_cost;//$("#other_load_total_hidd").val();
                                                        var other_load_row = $('#other_load_row').val();
                                                        var j = 0;
                                                        for (var i = 2; i < other_load_row; i++) {
                                                            if ($('#loading_expense_' + i).length) {
                                                                var loading_expense = $('#loading_expense_' + i).val();
                                                                var other_expense = $('#other_expense_' + i).val();
                                                                var loading_total = $('#loading_total_' + i).val();
                                                                var load_arrange_by = $('#load_arrange_by_' + i).val();
                                                                if (loading_expense == '') {
                                                                    loading_expense = 0;
                                                                }
                                                                if (other_expense == '') {
                                                                    other_expense = 0;
                                                                }
                                                                if (loading_total == '') {
                                                                    loading_total = 0;
                                                                }
                                                                var row_total = parseFloat(loading_expense) + parseFloat(other_expense) + parseFloat(loading_total);
                                                                other_load_total = other_load_total + row_total;
                                                                $('#loading_total_final_' + i).text(row_total);

                                                                if (load_arrange_by == "Own") {
                                                                    total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(row_total);
                                                                    hidd_total_claim = parseInt(hidd_total_claim) + parseInt(row_total);
                                                                } else {
                                                                    hidd_total_claim = parseInt(hidd_total_claim) + parseInt(row_total);
                                                                }
                                                            }
                                                        }

                                                        var other_load_total_final = parseFloat(other_load_total_hidd) + parseFloat(other_load_total);
                                                        $("#loading_total_final").text(other_load_total_final.toFixed(2));
//                                                        total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(other_load_total);
//                                                        hidd_total_claim = parseInt(hidd_total_claim) + parseInt(other_load_total);


                                                        var other_total = 0;
                                                        var other_total1 = 0;
                                                        var other_manager_expense = $("#other_manager_expense").val();
                                                        if (!$("#other_manager_expense").length) {
                                                            other_manager_expense = 0;
                                                        }
                                                        if (other_manager_expense != '') {
                                                            other_total1 = parseFloat(other_total1) + parseFloat(other_manager_expense);
                                                        }

                                                        var other_paid_by = document.getElementsByName('other_arrange_by[]');
                                                        var inps = document.getElementsByName('total_no[]');
                                                        for (var i = 0; i < inps.length; i++) {
                                                            var inp = inps[i];
                                                            var other_paid = other_paid_by[i];
                                                            var total = inp.value;
                                                            var paid = other_paid.value;
                                                            if (total != '') {
                                                                other_total = parseInt(other_total) + parseInt(total);
                                                                other_total1 = parseInt(other_total1) + parseInt(total);

                                                                if (paid == "Own") {
                                                                    total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(total);
                                                                    hidd_total_claim = parseInt(hidd_total_claim) + parseInt(total);
                                                                } else {
                                                                    hidd_total_claim = parseInt(hidd_total_claim) + parseInt(total);
                                                                }
                                                            }
                                                        }
                                                        $("#other_total").text(other_total1.toFixed(2));
//                                                        total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(other_total);
//                                                        hidd_total_claim = parseInt(hidd_total_claim) + parseInt(other_total);
                                                        hidd_total_claim = parseInt(hidd_total_claim) + parseInt(other_manager_expense);

                                                        var other_trip_total = 0;
                                                        var total_trip_lbl = 0;
                                                        var other_trip_total1 = 0;
                                                        var other_trip_total_hidd = $("#other_trip_total_hidd").val();
                                                        var inps_trip = document.getElementsByName('total_trip_no[]');
                                                        var trip_arrange_by = document.getElementsByName('trip_arrange_by[]');

                                                        var ticket_cost_1 = $("#ticket_cost_1").val();
                                                        if (!$("#ticket_cost_1").length) {
                                                            ticket_cost_1 = 0;
                                                        }
                                                        if (ticket_cost_1 == '') {
                                                            ticket_cost_1 = 0;
                                                        }
                                                        var trip = $("#ticket_arrange_by1").val();
                                                        if (ticket_cost_1 != '') {
                                                            other_trip_total1 = parseFloat(other_trip_total1) + parseFloat(ticket_cost_1);
                                                            other_trip_total_hidd = parseFloat(other_trip_total_hidd) - parseFloat(ticket_cost_1);
                                                            total_trip_lbl = parseFloat(total_trip_lbl) + parseFloat(ticket_cost_1);
                                                            if (trip == "Own") {
                                                                other_trip_total = parseInt(other_trip_total) + parseInt(ticket_cost_1);
                                                            } else {
                                                                hidd_total_claim = parseInt(hidd_total_claim) + parseInt(ticket_cost_1);
                                                            }
                                                        }

                                                        var ticket_cost_2 = $("#ticket_cost_2").val();
                                                        if (!$("#ticket_cost_2").length) {
                                                            ticket_cost_2 = 0;
                                                        }
                                                        if (ticket_cost_2 == '') {
                                                            ticket_cost_2 = 0;
                                                        }
                                                        var trip = $("#ticket_arrange_by2").val();
                                                        if (ticket_cost_2 != '') {

                                                            other_trip_total1 = parseFloat(other_trip_total1) + parseFloat(ticket_cost_2);
                                                            other_trip_total_hidd = parseFloat(other_trip_total_hidd) - parseFloat(ticket_cost_2);
                                                            total_trip_lbl = parseFloat(total_trip_lbl) + parseFloat(ticket_cost_2);
                                                            if (trip == "Own") {
                                                                other_trip_total = parseInt(other_trip_total) + parseInt(ticket_cost_2);
                                                            } else {
                                                                hidd_total_claim = parseInt(hidd_total_claim) + parseInt(ticket_cost_2);
                                                            }
                                                        }

                                                        for (var i = 0; i < inps_trip.length; i++) {
                                                            var inp = inps_trip[i];
                                                            var arrange_by = trip_arrange_by[i];
                                                            var total_trip = inp.value;
                                                            var trip = arrange_by.value;
                                                            if (total_trip != '') {
                                                                other_trip_total1 = parseInt(other_trip_total1) + parseInt(total_trip);
                                                                total_trip_lbl = parseFloat(total_trip_lbl) + parseInt(total_trip);
                                                                if (trip == "Own") {
                                                                    other_trip_total = parseInt(other_trip_total) + parseInt(total_trip);
                                                                } else {
                                                                    hidd_total_claim = parseInt(hidd_total_claim) + parseInt(total_trip);
                                                                }
                                                            }
                                                        }
                                                        var other_trip_total_final = parseFloat(other_trip_total_hidd) + parseFloat(other_trip_total1);

                                                        $("#other_trip_total").text(total_trip_lbl.toFixed(2));
                                                        total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(other_trip_total);
                                                        hidd_total_claim = parseInt(hidd_total_claim) + parseInt(other_trip_total);

                                                        var other_con_total_unpaid = 0;
                                                        var other_con_total = 0;
                                                        var other_con_total_hidd = $("#other_con_total_hidd").val();
                                                        var inps_con = document.getElementsByName('total_con_no[]');
                                                        var con_arrange_by = document.getElementsByName('con_arrange_by[]');

                                                        var total_con = $("#con_total_1").val();
                                                        if (!$("#con_total_1").length) {
                                                            total_con = 0;
                                                        }
                                                        if (total_con == '') {
                                                            total_con = 0;
                                                        }
                                                        var con = $("#con_arrange_by_1").val();
                                                        if (total_con != '') {
                                                            other_con_total = parseInt(other_con_total) + parseInt(total_con);
                                                            if (con == 'Own') {
                                                                other_con_total_unpaid = parseInt(other_con_total_unpaid) + parseInt(total_con);
                                                            } else {
                                                                hidd_total_claim = parseInt(hidd_total_claim) + parseInt(total_con);
                                                            }
                                                        }


                                                        for (var i = 0; i < inps_con.length; i++) {
                                                            var inp = inps_con[i];
                                                            var con_arrange = con_arrange_by[i];
                                                            var con = con_arrange.value;
                                                            var total_con = inp.value;
                                                            if (total_con != '') {
                                                                other_con_total = parseInt(other_con_total) + parseInt(total_con);
                                                                if (con == 'Own') {
                                                                    other_con_total_unpaid = parseInt(other_con_total_unpaid) + parseInt(total_con);
                                                                } else {
                                                                    hidd_total_claim = parseInt(hidd_total_claim) + parseInt(total_con);
                                                                }
                                                            }
                                                        }
                                                        var other_con_total_final = parseFloat(other_con_total_hidd) + parseFloat(other_con_total);
                                                        $("#other_con_total").text(other_con_total.toFixed(2));
                                                        total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(other_con_total_unpaid);
                                                        hidd_total_claim = parseInt(hidd_total_claim) + parseInt(other_con_total_unpaid);


                                                        var total_travel_claim = $("#total_claim").val();
                                                        var les_advance = $("#les_advance").val();
                                                        if (les_advance == '') {
                                                            les_advance = 0;
                                                        }
                                                        if (!$("#les_advance").length) {
                                                            les_advance = 0;
                                                        }
                                                        var other_manager_expense = $("#other_manager_expense").val();
                                                        les_advance = parseFloat(les_advance) + parseFloat(other_manager_expense);
                                                        var da_actual = $("#da_actual").val();

                                                        if (da_actual == "1") {
                                                            var da_allowance = $("#da_allowance").val();
                                                            if (da_allowance == '') {
                                                                da_allowance = 0;
                                                            }
                                                            var day = $("#day").val();

                                                            var final_da = da_allowance * day;

                                                            var hours = $("#hours").val();
                                                            if (hours != '0') {
                                                                if (hours != '') {
                                                                    if (hours < 14) {
                                                                        var da = da_allowance / 2;
                                                                        var final_da = parseFloat(final_da) + parseFloat(da);
                                                                    } else {
                                                                        var final_da = parseFloat(final_da) + parseFloat(da_allowance);
                                                                    }
                                                                }
                                                            }

                                                            $("#da_total").val(final_da);
                                                            $("#da_total_hidd").val(final_da);
                                                            $("#da_final_total").text(final_da.toFixed(2));
                                                            $("#lbl_final_da").text(final_da);
                                                            $("#lbl_da_total").text(final_da);
                                                            total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(final_da);
                                                            hidd_total_claim = parseInt(hidd_total_claim) + parseInt(final_da);
                                                        } else {
                                                            var da_allowance = $("#da_allowance").val();
                                                            if (da_allowance == '') {
                                                                da_allowance = 0;
                                                            }
                                                            var day = $("#day").val();

                                                            var final_da = da_allowance * day;

                                                            var hours = $("#hours").val();
                                                            if (hours != '0') {
                                                                if (hours != '') {
                                                                    if (hours < 14) {
                                                                        var da = da_allowance / 2;
                                                                        var final_da = parseFloat(final_da) + parseFloat(da);
                                                                    } else {
                                                                        var final_da = parseFloat(final_da) + parseFloat(da_allowance);
                                                                    }
                                                                }
                                                            }

                                                            $("#da_total").val(final_da);
                                                            $("#da_total_hidd").val(final_da);
                                                            $("#da_final_total").text(final_da.toFixed(2));
                                                            $("#lbl_final_da").text(final_da);
                                                            $("#lbl_da_total").text(final_da);
                                                            total_unpaid_claim_hidd = parseInt(total_unpaid_claim_hidd) + parseInt(final_da);
                                                            hidd_total_claim = parseInt(hidd_total_claim) + parseInt(final_da);
                                                        }

                                                        $("#expense_da").val(final_da);
                                                        $("#expense_con").val(other_con_total);

                                                        $("#lbl_total_claim1").text(hidd_total_claim);
                                                        $("#final_total_claim").val(hidd_total_claim);

                                                        var lbl_total_claim_company = parseFloat(hidd_total_claim) - parseFloat(total_unpaid_claim_hidd);
                                                        $("#lbl_total_claim_company").text(lbl_total_claim_company);
                                                        var paid_by_self = parseFloat(total_unpaid_claim_hidd) - parseFloat(final_da);
                                                        $("#total_claim").val(total_unpaid_claim_hidd);
                                                        $("#lbl_total_claim").text(paid_by_self);

                                                        var your_recived = parseFloat(total_unpaid_claim_hidd) - parseFloat(les_advance);
                                                        $("#your_recived").text(your_recived);
                                                        $("#your_recived_hidd").val(your_recived);
                                                    }


                                                    function add_trip_row() {
                                                        var count = document.getElementById('other_trip_row').value;
                                                        var add_row_flag = $("#add_row_flag").val();
                                                        var request_id = $("#request_id").val();
                                                        if (add_row_flag == "0") {
                                                            $("#add_row_flag").val('1');

                                                            $.ajax({
                                                                url: '<?php echo site_url('employee_request/new_add_trip_row'); ?>',
                                                                type: 'post',
                                                                dataType: 'html',
                                                                data: {'count': count, request_id: request_id, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'},
                                                                catch : false,
                                                                success: function (data) {
                                                                    $("#trip_tbody").append(data);
                                                                    count++;
                                                                    $("#other_trip_row").val(count);
                                                                    $("#add_row_flag").val('0');
                                                                    initialize2();
                                                                }
                                                            });
                                                        }
                                                    }

                                                    function add_load_row() {
                                                        var count = document.getElementById('other_load_row').value;
                                                        var add_row_flag = $("#add_row_flag").val();
                                                        var request_id = $("#request_id").val();
                                                        if (add_row_flag == "0") {
                                                            $("#add_row_flag").val('1');

                                                            $.ajax({
                                                                url: '<?php echo site_url('employee_request/new_add_loading_row'); ?>',
                                                                type: 'post',
                                                                dataType: 'html',
                                                                data: {'count': count, request_id: request_id, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'},
                                                                catch : false,
                                                                success: function (data) {
                                                                    $("#load_tbody").append(data);
                                                                    count++;
                                                                    $("#other_load_row").val(count);
                                                                    $("#add_row_flag").val('0');
                                                                    initialize();
                                                                }
                                                            });
                                                        }
                                                    }

                                                    function initialize() {
                                                        var other_row = $("#other_load_row").val();
                                                        other_row--;
                                                        var input = document.getElementById("load_location" + other_row);
                                                        var autocomplete = new google.maps.places.Autocomplete(input);
                                                        google.maps.event.addDomListener(window, 'load', initialize);
                                                    }

                                                    function locationtxti(id) {
                                                        var id = '#' + id;
                                                        $(id).animate({width: 150}, 'slow');
                                                    }

                                                    function locationtxtd(id) {
                                                        var id = '#' + id;
                                                        $(id).animate({width: 80}, 'slow');
                                                    }

                                                    function add_con_row() {
                                                        var count = document.getElementById('other_con_row').value;
                                                        var request_id = document.getElementById('request_id').value;
                                                        var add_row_flag = $("#add_row_flag").val();
                                                        if (add_row_flag == "0") {
                                                            $("#add_row_flag").val('1');
                                                            $.ajax({
                                                                url: '<?php echo site_url('employee_request/new_add_con_row'); ?>',
                                                                type: 'post',
                                                                dataType: 'html',
                                                                data: {'count': count, request_id: request_id, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'},
                                                                catch : false,
                                                                success: function (data) {
                                                                    $("#con_tbody").append(data);
                                                                    count++;
                                                                    $("#other_con_row").val(count);
                                                                    $("#add_row_flag").val('0');
                                                                    initialize1();
                                                                }
                                                            });
                                                        }
                                                    }

                                                    function initialize1() {
                                                        var other_row = $("#other_con_row").val();
                                                        other_row--;
                                                        var con_from = document.getElementById("con_from_" + other_row);
                                                        var con_to = document.getElementById("con_to_" + other_row);
                                                        var autocomplete = new google.maps.places.Autocomplete(con_from);
                                                        var autocomplete = new google.maps.places.Autocomplete(con_to);
                                                        google.maps.event.addDomListener(window, 'load', initialize);
                                                    }

                                                    function initialize2() {
                                                        var other_row = $("#other_trip_row").val();
                                                        other_row--;
                                                        var trip_from = document.getElementById("trip_from_" + other_row);
                                                        var trip_to = document.getElementById("trip_to_" + other_row);
                                                        var autocomplete = new google.maps.places.Autocomplete(trip_from);
                                                        var autocomplete = new google.maps.places.Autocomplete(trip_to);
                                                        google.maps.event.addDomListener(window, 'load', initialize);
                                                    }

                                                    function initialize_other() {
                                                        var other_row = $("#other_row").val();
                                                        other_row--;
                                                        var other_date = document.getElementById("expense_type_" + other_row);
                                                        var autocomplete = new google.maps.places.Autocomplete(other_date);
                                                        google.maps.event.addDomListener(window, 'load', initialize);
                                                    }

                                                    function add_row() {
//                                                        var other_row = $("#other_row").val();
//                                                        var html = "<tr id='row_id_" + other_row + "'><td><a  onclick='remove_row(" + other_row + ")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>";
//                                                        html += "<td><input type='text' name='expense_name[]' id='expense_name_" + other_row + "' class='form-control required'></td>";
//                                                        html += "<td><input type='text' name='expense_type[]' id='expense_type_" + other_row + "' class='form-control required'></td>";
//                                                        html += "<td><input type='text' name='expense_bill_no[]' maxlength='15' id='bill_no_" + other_row + "' class='form-control'></td>";
//                                                        html += "<td><input type='number' name='total_no[]' id='total_no" + other_row + "'  onkeyup='received_total()'  class='only_number form-control required'></td></tr>";
//                                                        $("#tbody").append(html);
//                                                        other_row++;
//                                                        $("#other_row").val(other_row);

                                                        var count = document.getElementById('other_row').value;
                                                        var request_id = document.getElementById('request_id').value;
                                                        var add_row_flag = $("#add_row_flag").val();
                                                        if (add_row_flag == "0") {
                                                            $("#add_row_flag").val('1');
                                                            $.ajax({
                                                                url: '<?php echo site_url('employee_request/new_add_other_row'); ?>',
                                                                type: 'post',
                                                                dataType: 'html',
                                                                data: {'count': count, request_id: request_id, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'},
                                                                catch : false,
                                                                success: function (data) {
                                                                    $("#tbody").append(data);
                                                                    count++;
                                                                    $("#other_row").val(count);
                                                                    $("#add_row_flag").val('0');
                                                                    initialize_other();
                                                                }
                                                            });
                                                        }
                                                    }

                                                    function remove_row(id) {
                                                        $("#row_id_" + id).remove();
                                                        received_total();
                                                    }

                                                    function remove_con_row(id) {
                                                        $("#row_con_id_" + id).remove();
                                                        received_total();
                                                    }

                                                    function remove_trip_row(id) {
                                                        $("#row_trip_id_" + id).remove();
                                                        received_total();
                                                    }

                                                    function remove_load_row(id) {
                                                        $("#row_load_id_" + id).remove();
                                                        received_total();
                                                    }

</script>
<?php
if ($request['trip_type'] != "1") {
    $return_date = $request['return_date'];
} else {
    $return_date = '';
}
?>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<script type="text/javascript">
                                                    $('.form_datetime').datetimepicker({
                                                        weekStart: 1,
                                                        todayBtn: 1,
                                                        startDate: "<?php echo isset($request['departure_date']) ? $request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>",
//                                                        endDate: "<?php // echo $return_date;                                             ?>",
                                                        autoclose: 1,
                                                        todayHighlight: 1,
                                                        startView: 2,
                                                        forceParse: 0,
                                                        showMeridian: 1,
                                                        minView: 1,
                                                        format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
                                                    });
</script>
<style>
    .table { text-align:left;}
</style>