<div class="page-content"> 
    <div class="header text-center">
        <h3>DB Corp Ltd.,<?php echo $employee['city_name'] ?></h3>
        <h4>Traveling Bill</h4>
    </div>
    <div class="row margin-mob-zero">        
        <div class="col-md-12">
            <div class="portlet light borderLight">
                <!-- BEGIN FORM-->
                <form role="form" class="validate-form" method="post" id="expense_form" name="expense_form">
                    <div class="form-body"> 
                        <div class="row">
                            <div class="col-md-12 portlet light borderLight text-center">
                                <h4 class="form-section">Expense Reimbursement form</h4>
                                <div class="row">
                                    <table id="make-data-table_asd1" class="table table-hover table-bordered table-responsive" style="display:block;">                                        
                                        <tbody>
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
                                                <td><?php if ($request['trip_type'] != "1") {
    echo date(DATETIME_FORMAT, strtotime($request['return_date']));
} ?></td>
                                                <th>Travel From</th>
                                                <td><?php echo $request['from_city_name'] ?></td>
                                                <th>Travel From</th>
                                                <td><?php echo $request['to_city_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Purpose of Travel</th>
                                                <td><?php if($request['reason']!=''){ echo $request['reason']; }
												else{ echo 'Projects'; }
 													?></td>                                                
                                                <th>Travel Type</th>
                                                <td><?php
                                                    if ($request['group_travel'] == "1") {
                                                        echo "Group Travel";
                                                    } else {
                                                        echo "Single Person";
                                                    }
                                                    ?></td>
                                                <th>Project Travel</th>
                                                <td><?php echo "Not Applicable" ?></td>  
                                            </tr>
                                            <tr>
                                                <th>Own/Company Arrangment</th>
                                                <td>
                                                    <b>
                                                        <?php
                                                        echo $expense_pending['reimbursement_arrangment'];
                                                        ?>
                                                    </b>
                                                </td>
                                                <th>Credit Card Number</th>
                                                <td>
                                                    <b>
                                                        <?php
                                                        echo $expense_pending['credit_card_number'];
                                                        ?>
                                                    </b>
                                                </td>
                                                <th>Bank Name</th>
                                                <td>
                                                    <b>
                                                        <?php
                                                        echo $expense_pending['bank_name'];
                                                        ?>
                                                    </b>
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
                                <div class="row">
                                    <table id="ticket_table" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Date</th>
                                                <th>Location From</th>
                                                <th>Location To</th>
                                                <th>Expense Location</th>
                                                <th>Paid By</th>
                                                <th>Mode</th>
                                                <th>View</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $total = 0;
                                            foreach ($ticket_details as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
                                                    <td><?php echo $value['location_from'] ?></td>
                                                    <td><?php echo $value['location_to'] ?></td>
                                                    <td><?php echo $value['expense_location'] ?></td>
                                                    <td><?php echo $value['arrange_by'] ?></td>
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
                                                            <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="15%">
    <?php $total = $total + $value['cost']; ?>
                                                <?php echo $value['cost']; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
<?php foreach ($other_trip_expense as $key => $value) {
    ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>                             
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['trip_date'])); ?></td>
                                                    <td><?php echo $value['trip_from'] ?></td>
                                                    <td><?php echo $value['trip_to'] ?></td>
                                                    <td><?php // echo $value['trip_to']   ?></td>
                                                    <td><?php echo $value['trip_arrange_by'] ?></td>
                                                    <td><?php
                                                        if ($value['trip_book_by'] == "1") {
                                                            echo "Flight";
                                                        } else if ($value['trip_book_by'] == "2") {
                                                            echo "Train";
                                                        } else if ($value['trip_book_by'] == "3") {
                                                            echo "Car";
                                                        } else if ($value['trip_book_by'] == "4") {
                                                            echo "Bus";
                                                        } else if ($value['trip_book_by'] == "5") {
                                                            echo "Hotel";
                                                        }
                                                        ?></td>
                                                    <td></td>                                                    
                                                    <td width="15%">
    <?php $total = $total + $value['total']; ?>
                                                <?php echo $value['total']; ?>
                                                    </td>
                                                </tr>
<?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"></td>
                                                <th align="center">Total ₹</th>
                                                <td>
                                                    <b id="txt_total_sum">
<?php echo $total . '.00'; ?>
                                                    </b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                </div>
                            </div>
                        </div>                       

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Lodging(Guest House/Hotel/Own Arrangement)</h4>
                                <div class="row">
                                    <table id="loading_hotel" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Check-In<br> Date</th>
                                                <th>Check-Out<br> Date</th>
                                                <th>Room No</th>
                                                <th>Bill No</th>
                                                <th>Location</th>
                                                <th>Expense<br> Location</th>
                                                <th>View</th>
                                                <th>Paid By</th>
                                                <th>Loding Expense</th>
                                                <th>Other Expense</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $total1 = 0;
                                            foreach ($hotel_details as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['date_from'])); ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['date_to'])); ?></td>
                                                    <td><?php echo $value['bill_no']; ?></td>
                                                    <td><?php echo $value['bill_no_1']; ?></td>
                                                    <td><?php echo $value['location'] ?></td>
                                                    <td><?php echo $value['expense_location'] ?></td>
                                                    <td> 
    <?php if ($value['attachment'] != '') { ?>
                                                            <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
    <?php } ?>
                                                    </td>
                                                    <td><?php echo $value['arrange_by'] ?></td>
                                                    <td><?php echo $value['loading_expense_1'] ?></td>
                                                    <td><?php echo $value['other_expense_1'] ?></td>
                                                    <td width="15%"><?php $total1 = $total1 + $value['cost']; ?>
    <?php echo $value['cost']; ?>
                                                        <!--<input type="text" id="total" value="<?php echo $value['cost']; ?>" class="form-control">-->
                                                    </td>

                                                </tr>
                                            <?php } ?>
<?php foreach ($other_loading_booking as $key => $value) {
    ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_departure'])); ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['loading_return'])); ?></td>
                                                    <td><?php echo $value['room_no']; ?></td>
                                                    <td><?php echo $value['bill_no']; ?></td>                                                    
                                                    <td><?php echo $value['location'] ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo $value['arrange_by'] ?></td>
                                                    <td><?php echo $value['loading_expense'] ?></td>
                                                    <td><?php echo $value['other_expense'] ?></td>
                                                    <td width="15%"><?php
                                                        $total_loading = $value['loading_total'] + $value['loading_expense'] + $value['other_expense'];
                                                        $total1 = $total1 + $total_loading;
                                                        ?>
    <?php echo $total_loading; ?>
                                                    </td>

                                                </tr>
<?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10"></td>
                                                <th>Total ₹</th>
                                                <td><b><?php echo $total1 . '.00'; ?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">DA Perticulars</h4>
                                <div class="row">
                                    <?php
                                    $i = 1;
                                    $total2 = 0;
                                    ?>
                                    <table id="da_perticulars" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Location</th>
                                                <th>No of Day</th>
                                                <th>DA@per day</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($request['departure_date'])); ?></td>
                                                <td><?php echo date(DATETIME_FORMAT, strtotime($request['return_date'])); ?></td>
                                                <td><?php echo $request['to_city_name']; ?></td>
                                                <td><?php echo $day . " Day," . $hours . " hours";
                                                    ;
                                    ?></td>
                                                <td><?php echo $request['DA_allowance']; ?></td>
                                                <td width="15%">
                                                    <?php
                                                    $da_total = $request['DA_allowance'] * $day;
                                                    if ($hours != '0') {
                                                        if ($hours != '') {
                                                            if ($hours < 14) {
                                                                $da = $request['DA_allowance'] / 2;
                                                                $da_total = $da_total + $da;
                                                            } else {
                                                                $da_total = $da_total + $request['DA_allowance'];
                                                            }
                                                        }
                                                    }
                                                    $total2 = $total2 + $da_total;
                                                    ?>
<?php echo $da_total; ?>
<!--                                                    <input type="text" id="total" value="<?php echo $da_total; ?>" class="form-control">-->
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"></td>
                                                <th>Total ₹</th>
                                                <td><b><?php echo $total2 . '.00'; ?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Conveyance-Car Hire Bills</h4>
                                <div class="row">
<?php $total3 = 0; ?>
                                    <table id="conveyance_car" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Date</th>
                                                <th>Location From</th>
                                                <th>Location To</th>
                                                <th>Expense Location</th>
                                                <th>Book By</th>
                                                <th>Mode</th>
                                                <th>View</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $total3 = 0;
                                            foreach ($car_details as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
                                                    <td><?php echo $value['location_from'] ?></td>
                                                    <td><?php echo $value['location_to'] ?></td>
                                                    <td><?php echo $value['expense_location'] ?></td>
                                                    <td><?php echo $value['arrange_by'] ?></td>
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
                                                        <?php if ($value['attachment'] != '') { ?>
                                                            <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['attachment']; ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="15%">
                                                <?php $total3 = $total3 + $value['cost']; ?>
                                                <?php echo $value['cost']; ?>
                                                    </td>
                                                </tr>
<?php } ?>
<?php foreach ($other_con_booking as $key => $value) {
    ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['con_date'])) ?></td>
                                                    <td><?php echo $value['con_from'] ?></td>
                                                    <td><?php echo $value['con_to'] ?></td>
                                                    <td><?php // echo $value['con_to']  ?></td>
                                                    <td><?php echo $value['con_arrange_by'] ?></td>
                                                    <td><?php
                                                        if ($value['con_book_by'] == "1") {
                                                            echo "Uber";
                                                        } else if ($value['con_book_by'] == "2") {
                                                            echo "Ola";
                                                        } else if ($value['con_book_by'] == "3") {
                                                            echo "Auto";
                                                        }
                                                        ?></td>

                                                    <td></td>
                                                    <td width="15%">
                                                <?php $total3 = $total3 + $value['total']; ?>
                                                <?php echo $value['total']; ?>
                                                    </td>
                                                </tr>
<?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"></td>
                                                <th>Total ₹</th>
                                                <td><b><?php echo $total3 . '.00'; ?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Other Expense Details</h4>
                                <div class="row">
<?php $total4 = 0; ?>
<?php $total5 = 0; ?>
                                    <table id="other_expense" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Date</th>
                                                <th>Expense Details</th>
                                                <th>Location</th>
                                                <th>Paid By</th>
                                                <th>Bill No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if (isset($other_manager_expense)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td id="other_manager_expense_date">
                                                        <?php
                                                        if ($request['return_date'] != '') {
                                                            echo date(DATETIME_FORMAT, strtotime($request['departure_date'])) . " <br> To <br> " . date(DATETIME_FORMAT, strtotime($request['return_date']));
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
                                                        <?php /* ?><?php
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
    ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                            <?php
                                            $other_total = 0;
                                            foreach ($other_expense as $key => $value) {
                                                $amount = $value['amount'];
                                                $other_total = $other_total + $amount;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo date(DATETIME_FORMAT, strtotime($value['date'])); ?></td>
                                                    <td><?php echo $value['expense_name']; ?></td>
                                                    <td><?php echo $value['expense_type']; ?></td>
                                                    <td><?php echo $value['arrange_by']; ?></td>
                                                    <td><?php echo $value['bill_no'] ?></td>
                                                    <td><?php echo $amount ?></td>
                                                </tr>
<?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"></td>
                                                <td><b>Total ₹</b></td>
                                                <td><b><?php echo $other_total . '.00'; ?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <h4 class="form-section"><spam class="cutm_lbl btn_blue">Expense Summary</spam></h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Trip Expense Total</th>
                                            <th id="lbl_total_claim1">
<?php echo $expense_pending['final_total_claim'] . '.00'; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Paid By Company</th>
                                            <th id="lbl_total_claim_company">
<?php echo $expense_pending['final_total_claim'] - $expense_pending['total_claim'] . '.00'; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Paid By Self</th>
                                            <th id="lbl_total_claim">
<?php
echo $expense_pending['total_claim'] - $da_total . '.00';
?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>D.A.</th>
                                            <th id="lbl_da_total">
<?php echo $da_total . '.00'; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Other Expense By Travel Desk</th>
                                            <th>
                                                <?php
                                                if (isset($other_manager_expense)) {
                                                    echo $other_manager_expense . '.00';
                                                }
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Travel Advance</th>
                                            <th class="col-md-3">
<?php
echo $expense_pending['less_advance'] . '.00';
?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th> <?php if ($expense_pending['recevied_amount'] >= 0) { ?>
                                                    Pay to Employee
                                                <?php } else { ?>
                                                    <span style="color:red;">  Employee will pay to company</span>

                                                <?php } ?></th>
                                            <th id="your_recived">
<?php
echo $expense_pending['recevied_amount'] . '.00';
?>
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

                            <div class="col-md-3  col-xs-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="th_blue">
                                            <th>Expense Type</th>
                                            <th>Eligible@Per Day</th>
                                            <th>Requested</th>
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
                                            <td><?php echo $travel_mode . "/" . $request['travel_class']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>D.A.</td>
                                            <td><?php echo $DA_allowance; ?></td>
                                            <td><?php echo $da_total; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Hotel</td>
                                            <td><?php echo $hotel_allowance; ?></td>
                                            <td><?php echo $total1 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Conveyance</td>
                                            <td><?php echo $convince_allowance; ?></td>
                                            <td><?php echo $total3; ?></td>
                                        </tr>
                                    </tbody>
                                </table>   
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="col-md-4 col-xs-12">
                                    <h4 class="form-section"><spam class="cutm_lbl btn_blue">Travel Bills</spam></h4>
                                    <?php
                                    $u = 1;
                                    if (!empty($get_other_attachment)) {
                                        foreach ($get_other_attachment as $value) {
                                            ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <p class="form-control-static">
                                                        <a class="btn-link" target="_blank" href="<?php echo base_url() . $this->config->item('upload_booking_attch_path') . '/' . $value['file_name']; ?>">
                                                            <i class="fa fa-eye"></i> <?php echo "Attachment " . $u++ ?> 
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>                                    
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <br>
                                        <b>No Bill Found</b>                                    
<?php }
?>                                
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="col-md-offset-5 col-md-12">
                                    <a href="#approve_modal" data-toggle="modal" class="btn btn_blue">
                                        Trip Audited
                                    </a>
                                    <a class="btn btn_red" href="#rejected_modal" data-toggle="modal">
                                        Clarification
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

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="approve_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Approve Task</h4>
            </div>
            <form action="<?php echo base_url() . 'audit_desk/approve_expense/' . $request['id']; ?>" id="approval_task" method="post" class="validate-form form-horizontal row-border">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget box">
                                <div class="widget-content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Are you sure you want to Audited this Trip?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="rejected_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Clarification Task</h4>
            </div>
            <form action="<?php echo base_url() . 'audit_desk/clarification_expense/' . $request['id']; ?>" id="reject_task" method="post" class="form-horizontal row-border validate-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget box">
                                <div class="widget-content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Please provide your comments.
                                                <span class="required">*</span>:</label>
                                            <textarea name="clarification_comment" id="clarification_comment" class="form-control required" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    function received_total() {
        var total_travel_claim = $("#total_claim").val();
        var les_advance = $("#les_advance").val();
        var your_recived = total_travel_claim - les_advance;
        $("#your_recived").text(your_recived);
        $("#your_recived_hidd").val(your_recived);
    }
    $(document).ready(function () {
        $('#reject_task').validate({
            rules: {
                clarification_comment: {
                    required: true
                },
            },
            messages: {
                clarification_comment: {
                    required: 'Clarification Comment is required'
                },
            }
        });
        $('#expense_form').validate({
            rules: {
                credit_card_number: {
                    required: true
                },
                bank_name: {
                    required: true
                },
            },
            messages: {
                credit_card_number: {
                    required: 'Credit Card Number is required'
                },
                bank_name: {
                    required: 'Bank Name is required'
                },
            }
        });
    });

</script>

<style>
    .table { text-align:left;}
</style>