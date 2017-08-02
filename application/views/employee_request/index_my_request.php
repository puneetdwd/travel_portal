<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            My Request
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
                            <th>Trip ID</th>
                            <th>Travel Reason</th>
                            <th>Departure date</th>
                            <th>Return date</th>
                            <th>Service</th>
                            <th>From - To</th>
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
                                    <?php if ($data['request_status'] != "7") { ?>
                                    <a class="btn btn-xs purple" title="Incompleted Trip"
                                           href="<?php echo base_url() . 'employee_request/view/' . $data['id']; ?>">
                                            <i class="fa fa-eye"></i> view Details
                                        </a> 
                                    <?php } else { ?>
                                        <a class="btn btn-xs btn-success" title="Completed Trip"
                                           href="<?php echo base_url() . 'employee_request/view/' . $data['id']; ?>">
                                            <i class="fa fa-eye"></i> view Details
                                        </a> 
                                    <?php } ?>
                                    <?php
                                    if ($data['request_status'] == "3") {
                                        if ($data['bookbyself'] == "1") {
                                            ?>
                                            <a class="btn btn-xs blue-chambray" 
                                               href="<?php echo base_url() . 'employee_request/self_booking/' . $data['id']; ?>">
                                                <i class="fa fa-edit"></i> Travel Booking
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if ($data['cancel_status'] != "1") {
                                        if ($data['approval_status'] == "Approved") {
                                            if ($data['request_status'] <= "2") {
                                                ?>
                                                <a class="btn btn-xs blue-chambray" 
                                                   href="<?php echo base_url() . 'employee_request/accommodation/' . $data['id']; ?>">
                                                    <i class="fa fa-edit"></i> Accommodation
                                                </a>
                                                <?PHP
                                            }
                                        }
                                        ?>                                    
                                        <?php
                                        if ($data['request_status'] != "7") {
                                            if ($data['cancel_status'] == "0") {
                                                if ($data['approval_status'] == "Approved") {
                                                    ?>
                                                    <br><br>
                                                    <a class="btn btn-xs red-intense" href="<?php echo base_url() . 'employee_request/cancel_trip_request/' . $data['id']; ?>">
                                                        <i class="fa fa-remove"></i> Cancel Trip
                                                    </a>
                                                    <?PHP
                                                }
                                            }
                                        }
                                        if ($data['request_status'] == "4") {
                                            ?>
                                            <a class="btn btn-xs purple" 
                                               href="<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>">
                                                <i class="fa fa-eye"></i> Claim Expense
                                            </a>               
                                            <?php
                                        } else if ($data['request_status'] == "5" && $data['expense_status'] == "Pending") {
                                            ?>
                                            <span class="btn btn-xs blue" <i class="fa fa-eye"></i> Expense Pending </span>               
                                            <?php
                                        } else if ($data['request_status'] == "5" && $data['expense_status'] == "Clarification") {
                                            ?>                                            
                                            <a class="btn btn-xs red" 
                                               href="<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>">
                                                <i class="fa fa-eye"></i> Claim Clarification
                                            </a>      
                                            <?php
                                        } else if ($data['request_status'] == "6") {
                                            if ($data['expense_status'] == "Approved") {
                                                ?>
                                                <a class="btn btn-xs blue-chambray" 
                                                   href="<?php echo base_url() . 'employee_request/view_expense/' . $data['id']; ?>">
                                                    <i class="fa fa-eye"></i> Expense Approved 
                                                </a>
                                                <?php
                                            } else if ($data['expense_status'] == "Rejected") {
                                                ?>
                                                <span class="btn btn-xs red" <i class="fa fa-eye"></i> Expense Rejected </span>               
                                                <?php
                                            }
                                        }
                                    }
                                    ?>                                    
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="frm_title">Cancellation Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to Cancel this Trip?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Cancel</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
        });

    });
</script>