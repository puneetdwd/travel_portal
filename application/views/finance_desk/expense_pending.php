<div class="page-content"> 
    <div class="header text-center">
        <h3>D B Crop Ltd,<?php echo $employee['city_name'] ?></h3>
        <h4>Travelling Bill</h4>
    </div>
    <div class="row">        
        <div class="col-md-12">
            <div class="portlet light bordered">
                <!-- BEGIN FORM-->
                <form role="form" class="validate-form" method="post" id="expense_form" name="expense_form">
                    <div class="form-body"> 
                        <div class="row">
                            <div class="col-md-12 portlet light bordered text-center">
                                <h4 class="form-section">Expense Reimbursement form</h4>
                                <div class="row">
                                    <table id="basicTable" class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td><?php echo $employee['first_name'] . " " . $employee['last_name'] ?></td>
                                                <th>Employee Id</th>
                                                <td><?php echo $employee['employee_id'] ?></td>
                                                <th>Designation</th>
                                                <td><?php echo $employee['desg_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td><?php echo $employee['gender'] ?></td>
                                                <th>Reporting Manager</th>
                                                <td><?php echo $employee['reporting_manager'] ?></td>
                                                <th>Departure Date and Time</th>
                                                <td><?php echo $request['departure_date'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Return Date and Time</th>
                                                <td><?php echo $request['departure_date'] ?></td>
                                                <th>Travel From</th>
                                                <td><?php echo $request['from_city_name'] ?></td>
                                                <th>Travel From</th>
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
                                    <table id="basicTable" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Date</th>
                                                <th>Location From</th>
                                                <th>Location To</th>
                                                <th>Paid By</th>
                                                <th>Mode</th>
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
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $value['date'] ?></td>
                                                    <td><?php echo $value['location_from'] ?></td>
                                                    <td><?php echo $value['location_to'] ?></td>
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
                                                    <td width="15%">
                                                        <?php $total = $total + $value['cost']; ?>
                                                        <?php echo $value['cost']; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="5"></td>
                                                <th align="center">Total</th>
                                                <td>
                                                    <b id="txt_total_sum">
                                                        <?php echo $total; ?>
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
                                <h4 class="form-section">Lodging(Guest House/Hotel/Own Arrangement)</h4>
                                <div class="row">
                                    <table id="basicTable" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Check-In Date</th>
                                                <th>Check-Out Date</th>
                                                <th>Room No</th>
                                                <th>Bill No</th>
                                                <th>Location</th>
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
                                                    <td><?php echo $value['date_from'] ?></td>
                                                    <td><?php echo $value['date_to'] ?></td>
                                                    <td><?php echo $value['bill_no']; ?></td>
                                                    <td><?php echo $value['bill_no_1']; ?></td>
                                                    <td><?php echo $value['location'] ?></td>
                                                    <td><?php echo $value['loading_expense_1'] ?></td>
                                                    <td><?php echo $value['other_expense_1'] ?></td>
                                                    <td width="15%"><?php $total1 = $total1 + $value['cost']; ?>
                                                        <?php echo $value['cost']; ?>
                                                        <!--<input type="text" id="total" value="<?php echo $value['cost']; ?>" class="form-control">-->
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="7"></td>
                                                <th>Total</th>
                                                <td><b><?php echo $total1; ?></b></td>
                                            </tr>
                                        </tbody>
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
                                    <table id="basicTable" class="table table-hover table-bordered text-center">
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
                                                <td><?php echo $request['departure_date']; ?></td>
                                                <td><?php echo $request['return_date']; ?></td>
                                                <td><?php echo $request['to_city_name']; ?></td>
                                                <td><?php echo $day; ?></td>
                                                <td><?php echo $request['DA_allowance']; ?></td>
                                                <td width="15%">
                                                    <?php
                                                    $da_total = $request['DA_allowance'] * $day;
                                                    $total2 = $total2 + $da_total;
                                                    ?>
                                                    <?php echo $da_total; ?>
<!--                                                    <input type="text" id="total" value="<?php echo $da_total; ?>" class="form-control">-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
                                                <th>Total</th>
                                                <td><b><?php echo $total2; ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Conveyance-Car Hire Bills</h4>
                                <div class="row">
                                    <?php $total3 = 0; ?>
                                    <table id="basicTable" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Date</th>
                                                <th>Location From</th>
                                                <th>Location To</th>
                                                <th>Book By</th>
                                                <th>Mode</th>
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
                                                    <td><?php echo $value['date'] ?></td>
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
                                                    <td><?php echo $value['arrange_by'] ?></td>
                                                    <td width="15%">
                                                        <?php $total3 = $total3 + $value['cost']; ?>
                                                        <?php echo $value['cost']; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="5"></td>
                                                <th>Total</th>
                                                <td><b><?php echo $total3; ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 light bordered ">
                                <h4 class="form-section">Other Expense Details</h4>
                                <div class="row">
                                    <?php $total4 = 0; ?>
                                    <table id="basicTable" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <th>Sr.No.</th>
                                                <th>Expense Details</th>
                                                <th>Location</th>
                                                <th>Bill No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $other_total = 0;
                                            foreach ($other_expense as $key => $value) {
                                                $amount = $value['amount'];
                                                $other_total = $other_total + $amount;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $value['expense_name']; ?></td>
                                                    <td><?php echo $value['expense_type']; ?></td>
                                                    <td><?php echo $value['bill_no'] ?></td>
                                                    <td><?php echo $amount ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td><b>Total</b></td>
                                                <td><b><?php echo $other_total; ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label col-md-3 text-left-imp">Total Travel Claim:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">
                                            <b>
                                                <?php
                                                echo $expense_pending['total_claim'];
                                                ?>
                                            </b>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 text-left-imp">Less Advance:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">
                                            <b>
                                                <?php
                                                echo $expense_pending['less_advance'];
                                                ?>
                                            </b>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 text-left-imp">You Recevied:</label>
                                    <div class="col-md-9">

                                        <p class="form-control-static" name="your_recived" id="your_recived">
                                            <b>
                                                <?php
                                                echo $expense_pending['recevied_amount'];
                                                ?>
                                            </b>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-offset-5 col-md-12">
                                    <a href="#approve_modal" data-toggle="modal" class="btn btn_blue">
                                        Pay to Employee
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
            <form action="<?php echo base_url() . 'finance_desk/approve_expense/' . $request['id'];  ?>" id="approval_task" method="post" class="validate-form form-horizontal row-border">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget box">
                                <div class="widget-content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Are you sure you want to Complete this Trip?</label>
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
            <form action="<?php echo base_url() . 'finance_desk/clarification_expense/' . $request['id'];  ?>" id="reject_task" method="post" class="form-horizontal row-border validate-form">
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

