<div class="page-content"> 
    <div class="header text-center">
        <h3>D B Crop Ltd,<?php echo $employee['city_name'] ?></h3>
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
            <div class="portlet light bordered">
                <!-- BEGIN FORM-->
                <form role="form" class="validate-form" method="post" id="expense_form" name="expense_form">
                    <div class="form-body"> 
                        <div class="row">
                            <div class="col-md-12 light bordered text-center">
                                <h4 class="form-section">Expense Reimbursement Form</h4>
                                <div class="row">
                                    <table id="basicTable" class="table table-hover table-bordered">
                                        <tbody align="">
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
                                                    <select name="arrange_by" id="arrange_by" class="form-control">
                                                        <option value="Company" <?php if (!empty($expense_details)) if ($expense_details['reimbursement_arrangment'] == "Company") echo "selected"; ?>>Company</option>
                                                        <option value="Own" <?php if (!empty($expense_details)) if ($expense_details['reimbursement_arrangment'] == "Own") echo "selected"; ?>>Own</option>
                                                    </select> 
                                                </td>
                                                <th>Credit Card Number</th>
                                                <td>
                                                    <input type="number" name="credit_card_number" id="credit_card_number" class="form-control" value="<?php if (!empty($expense_details)) echo $expense_details['credit_card_number']; ?>">
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
                                                    <td>
                                                        <select name="<?php echo 'ticket_arrange_by_' . $value['type'] ?>" id="ticket_arrange_by" class="form-control">
                                                            <option value="Company" <?php if ($value['arrange_by'] == "Company") echo "selected"; ?>>Company</option>
                                                            <option value="Own" <?php if ($value['arrange_by'] == "Own") echo "selected"; ?>>Own</option>
                                                        </select> 
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
                                                    <td><?php echo $value['bill_no'] ?></td>                                                    
                                                    <td class="col-md-1">
                                                        <input type="text" class="form-control" id="bill_no_1" name="bill_no_1" value="<?php echo $value['bill_no_1']; ?>">
                                                    </td>
                                                    <td><?php echo $value['location'] ?></td>
                                                    <td class="col-md-1">
                                                        <input type="text" class="form-control" onkeyup="received_total()"  name="loading_expense_1" id="loading_expense_1" value="<?php echo $value['loading_expense_1']; ?>">
                                                    </td>
                                                    <td class="col-md-1">
                                                        <input type="text" class="form-control" onkeyup="received_total()"  name="other_expense_1" id="other_expense_1" value="<?php echo $value['other_expense_1']; ?>">
                                                        <input type="hidden" class="form-control"  name="loading_cost" id="loading_cost" value="<?php echo $value['cost']; ?>">
                                                    </td>
                                                    <?php $total1 = $total1 + $value['cost'] + $value['loading_expense_1'] + $value['other_expense_1']; ?>
                                                    <td width="15%" id="loading_total">
                                                        <?php echo $value['cost'] + $value['loading_expense_1'] + $value['other_expense_1']; ?>
                                                        <!--<input type="text" id="total" value="<?php echo $value['cost']; ?>" class="form-control">-->
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="7">If Company Guest House is not available, Attachment should available here</td>
                                                <th>Total</th>
                                                <td><b id="loading_total_final"><?php echo $total1; ?></b></td>
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
                                                <td  class="col-md-2">
                                                    <input type="hidden" class="form-control required" name="da_actual" id="da_actual" value="<?php echo $request['DA_allowance_actual']; ?>">
                                                    <?php
                                                    if ($request['DA_allowance_actual'] != '1') {
                                                        echo $request['DA_allowance'];
                                                    } else {
                                                        ?>
                                                        <input type="number" class="form-control required" name="da_allowance" id="da_allowance"  onkeyup="received_total()" placeholder="DA/Per day" value="<?php if (!empty($expense_details)) echo $request['DA_allowance']; ?>">
                                                        <input type="hidden" class="form-control required" name="day" id="day" value="<?php echo $day; ?>">                                                        
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td width="15%">
                                                    <?php
                                                    if ($request['DA_allowance_actual'] != '1') {
                                                        $da_total = $request['DA_allowance'] * $day;
                                                        $total2 = $total2 + $da_total;
                                                        ?>
                                                        <?php
                                                        echo $da_total;
                                                    } else {
                                                        ?>
                                                        <input type="text" id="da_total" name="da_total" value="<?php if (!empty($expense_details)) echo $request['DA_allowance'] * $day; ?>" class="form-control" disabled="">
                                                        <?php
                                                        if (!empty($expense_details)) {
                                                            $total_da = $request['DA_allowance'] * $day;
                                                            $total2 = $total2 + $total_da;
                                                        }
                                                        ?>
                                                        <input type="hidden" id="da_total_hidd" name="da_total_hidd" value="<?php echo $total2 ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
                                                <th>Total</th>
                                                <td><b id="da_final_total"><?php echo $total2; ?></b></td>
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
                                                    <td>
                                                        <select name="<?php echo 'ticket_arrange_by_5' ?>" id="ticket_arrange_by" class="form-control">
                                                            <option value="Company" <?php if ($value['arrange_by'] == "Company") echo "selected"; ?>>Company</option>
                                                            <option value="Own" <?php if ($value['arrange_by'] == "Own") echo "selected"; ?>>Own</option>
                                                        </select> 
                                                    </td>
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
                                <div class="pull-right">
                                    <a  onclick="add_row()" class="btn btn-sm blue-chambray">Add New Row</a>
                                </div>
                                <div class="row">
                                    <?php $total4 = 0; ?>
                                    <table id="basicTable" class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr class="th_blue">
                                                <!--<th class="no_sort" style="width:150px;"></th>-->
                                                <th>Remove</th>
                                                <th>Expense Details</th>
                                                <th>Location</th>
                                                <th>Bill No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"> 
                                            <?php
                                            $i = 1;
                                            if (!empty($other_expense)) {
                                                foreach ($other_expense as $key => $value) {
                                                    $amount = $value['amount'];
                                                    $total4 = $total4 + $amount;
                                                    ?>
                                                    <tr id="<?php echo "row_id_" . $i; ?>">
                                                        <td><a  onclick='remove_row("<?php echo $i; ?>")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>
                                                        <!--<td><?php echo $i; ?></td>-->
                                                        <td><input type='text' name='expense_name[]' id='<?php echo "expense_name_" . $i; ?>' value="<?php echo $value['expense_name']; ?>" class='form-control required'></td>
                                                        <td><input type='text' name='expense_type[]' id='<?php echo "expense_type" . $i; ?>' value="<?php echo $value['expense_type']; ?>" class='form-control required'></td>
                                                        <td><input type='text' name='bill_no[]' id='<?php echo "bill_no_" . $i; ?>' value="<?php echo $value['bill_no']; ?>" class='form-control'></td>
                                                        <td><input type='number' name='total_no[]' id='<?php echo "total_no" . $i; ?>'  onkeyup='received_total()'  class='form-control required' value="<?php echo $value['amount'] ?>"></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <th>Total</th>
                                                <th id="other_total"><?php echo $total4; ?></th>
                                            </tr>
                                        </tfoot>
                                    </table> 
                                    <input type="hidden" name="other_row" id="other_row" value="<?php echo $i; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label col-md-3 text-left-imp">Total Travel Claim:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static" id="lbl_total_claim">
                                            <?php
                                            if (!empty($expense_details)) {
                                                $less_advance = $expense_details['less_advance'];
                                                $total_travel_claim = $expense_details['total_claim'];
                                            } else {
                                                $less_advance = 0;
                                                $total_travel_claim = $total_travel_claim + $total4;
                                            }
                                            
                                            echo $total_travel_claim;
                                            ?>                                                    
                                        </p>
                                        <input type="hidden" name="hidd_total_claim" id="hidd_total_claim" value="<?php echo ($total_travel_claim - $total4) - $total2; ?>" >
                                        <input type="hidden" name="total_claim" id="total_claim" value="<?php echo $total_travel_claim; ?>" >
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label col-md-3 text-left-imp">Employee Advance:</label>
                                    <div class="col-md-2">
                                        <!--<p class="form-control-static col-md-2">-->
                                        <input type="text" name="les_advance" id="les_advance" class="form-control" onkeyup="received_total()" value="<?php echo $less_advance; ?>">
                                        <!--</p>-->
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-xs-12 col-sm-12">
                                    <label class="control-label col-md-3 text-left-imp">You Recevied:</label>
                                    <div class="col-md-9">
                                        <input type="hidden" name="your_recived_hidd" id="your_recived_hidd" value="<?php echo $total_travel_claim - $less_advance; ?>">
                                        <p class="form-control-static" name="your_recived" id="your_recived">
                                            <?php echo $total_travel_claim - $less_advance; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-offset-5 col-md-12">
                                    ** Pls attach all Bills, Upload Option&nbsp;<br>
                                    <input type="file" class="btn green button-submit" multiple=""><br>
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

    <script type="text/javascript">
        function add_row() {
            var other_row = $("#other_row").val();
            var html = "<tr id='row_id_" + other_row + "'><td><a  onclick='remove_row(" + other_row + ")' class='btn-xs btn_red'><i class='fa fa-trash-o'></i></a></td>";
//            html += "<td>" + other_row + "</td>";
            html += "<td><input type='text' name='expense_name[]' id='expense_name_" + other_row + "' class='form-control required'></td>";
            html += "<td><input type='text' name='expense_type[]' id='expense_type_" + other_row + "' class='form-control required'></td>";
            html += "<td><input type='text' name='bill_no[]' id='bill_no_" + other_row + "' class='form-control'></td>";
            html += "<td><input type='number' name='total_no[]' id='total_no" + other_row + "'  onkeyup='received_total()'  class='form-control required'></td></tr>";
            $("#tbody").append(html);
            other_row++;
            $("#other_row").val(other_row);
        }

        function remove_row(id) {
            $("#row_id_" + id).remove();
            received_total();
        }

        function received_total() {
            var hidd_total_claim = $("#hidd_total_claim").val();

            var loading_cost = $("#loading_cost").val();
            var loading_expense_1 = $("#loading_expense_1").val();
            var other_expense_1 = $("#other_expense_1").val();

            if (loading_expense_1 == '') {
                loading_expense_1 = 0;
            }
            if (other_expense_1 == '') {
                other_expense_1 = 0;
            }


            var final_cost = parseInt(loading_cost) + parseInt(loading_expense_1) + parseInt(other_expense_1);
            $("#loading_total").text(final_cost);
            $("#loading_total_final").text(final_cost);

            hidd_total_claim = parseInt(hidd_total_claim) + parseInt(loading_expense_1) + parseInt(other_expense_1);

            var other_total = 0;

            var inps = document.getElementsByName('total_no[]');
            for (var i = 0; i < inps.length; i++) {
                var inp = inps[i];
                var total = inp.value;
                if (total != '') {
                    other_total = parseInt(other_total) + parseInt(total);
                }
            }
            $("#other_total").text(other_total);

            hidd_total_claim = parseInt(hidd_total_claim) + parseInt(other_total);

            var total_travel_claim = $("#total_claim").val();
            var les_advance = $("#les_advance").val();
            var da_actual = $("#da_actual").val();
            if (da_actual == "1") {
                var da_allowance = $("#da_allowance").val();
                var day = $("#day").val();
                var final_da = da_allowance * day;
                $("#da_total").val(final_da);
                $("#da_total_hidd").val(final_da);
                $("#da_final_total").text(final_da);
                hidd_total_claim = parseInt(hidd_total_claim) + parseInt(final_da);
            }
            $("#total_claim").val(hidd_total_claim);
            $("#lbl_total_claim").text(hidd_total_claim);
            var your_recived = hidd_total_claim - les_advance;
            $("#your_recived").text(your_recived);
            $("#your_recived_hidd").val(your_recived);
        }
//        $(document).ready(function () {
//            $('#expense_form').validate({
//                rules: {
//                    credit_card_number: {
//                        required: true
//                    },
//                    bank_name: {
//                        required: true
//                    },
//                },
//                messages: {
//                    credit_card_number: {
//                        required: 'Credit Card Number is required'
//                    },
//                    bank_name: {
//                        required: 'Bank Name is required'
//                    },
//                }
//            });
//        });

    </script>

