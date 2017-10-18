<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<br><div class="page-content"><div class="breadcrumbs">
        <legend class="border-bottom-none">My Request</legend></div>
    <div class="row"><div class="col-md-12 padding_mob"><?php
            if ($this->session->flashdata('error')) {
                ?><div class="alert alert-danger"><i class="fa fa-times"></i><?php echo $this->session->flashdata('error'); ?></div><?php
            } elseif ($this->session->flashdata('success')) {
                ?><div class="alert alert-success"><i class="fa fa-check"></i><?php echo $this->session->flashdata('success'); ?></div><?php
                }
                ?><div class="portlet light bordered"><div class="panel-heading"><ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1default" data-toggle="tab">My Request</a></li><?php
                        if (!empty($emp_request)) {
                            ?><li><a href="#tab1default1" data-toggle="tab">My Manager</a></li><?php
                            }
                            ?></ul></div>

                <div class="panel-body"><div class="tab-content">
                        <div class="tab-pane fade active in" id="tab1default">
                            <table class="table" id="make-data-table">
                                <thead><tr class="th_blue"><th>Trip ID</th>
                                        <th class="hidden-xs">Reason</th>
                                        <th>Departure date</th><th>Return date</th>
                                        <th class="hidden-xs">Service</th><th>From - To</th>
                                        <th class="hidden-xs">Action by</th><th>Status</th>
                                        <th class="no_sort" style="width:150px;">Action</th></tr></thead><tbody><?php
                                    $post_data[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                                    foreach ($request as $data) {
                                        $display_flag = 0;
                                        if ($data['trip_type'] == '1') {
                                            if ($data['travel_ticket'] == '2') {
                                                $display_flag = 1;
                                                $trip_ticket = $data['trip_ticket'];
                                            } else {
                                                $trip_ticket = 1;
                                            }
                                        } else {
                                            if ($data['travel_ticket'] == '2') {
                                                $display_flag = 1;
                                            }
                                            if ($data['return_travel_ticket'] == '2') {
                                                $display_flag = 1;
                                            }
                                            if ($data['travel_ticket'] == '2' && $data['trip_ticket_return'] == '1') {
                                                $trip_ticket = $data['trip_ticket'];
                                            } else {
                                                $trip_ticket = 0;
                                            }
                                        }

                                        if ($data['accommodation'] == '2') {
                                            $display_flag = 1;
                                            $hotel_booking = $data['hotel_booking'];
                                        } else {
                                            $hotel_booking = 1;
                                        }

                                        if ($data['car_hire'] == '2') {
                                            $display_flag = 1;
                                            $car_booking = $data['car_booking'];
                                        } else {
                                            $car_booking = 1;
                                        }
                                        ?><tr><td><?php
                                                            if ($data['request_status'] != "9") {
                                                                ?><a title="Incompleted Trip" href="<?php echo base_url() . 'employee_request/view/' . $data['id']; ?>">&nbsp;<?php echo $data['reference_id']; ?></a><?php
                                                } else {
                                                    ?><a title="Completed Trip" href="<?php echo base_url() . 'employee_request/view/' . $data['id']; ?>"><?php echo $data['reference_id']; ?></a><?php
                                                    }
                                                    ?></td><td class="hidden-xs"><?php
                                                if ($data['travel_reason_id'] != "Projects") {
                                                    echo $data['reason'];
                                                } else {
                                                    echo "Projects (" . $data['project_name'] . ")";
                                                };
                                                ?></td>

                                            <td class="form_datetime"><?php echo date(DATETIME_FORMAT, strtotime($data['departure_date'])); ?></td>

                                            <td class="form_datetime"><?php
                                                if ($data['trip_type'] != "1") {
                                                    ?><input class="form-control" size="11" type="text" readonly onchange="edit_date();" value="<?php echo date(DATETIME_FORMAT, strtotime($data['return_date'])); ?>"><?php
                                                } else {
                                                    echo "Not Fix";
                                                }
                                                ?></td>

                                            <td class="hidden-xs"><?php
                                                $controller = '';
                                                if ($data['travel_type'] == "1") {
                                                    $controller = "flight_travel";
                                                    echo "Flight";
                                                } else if ($data['travel_type'] == "2") {
                                                    $controller = "train_travel";
                                                    echo "Train";
                                                } else if ($data['travel_type'] == "3") {
                                                    $controller = "car_travel";
                                                    echo "Car";
                                                } else if ($data['travel_type'] == "4") {
                                                    $controller = "bus_travel";
                                                    echo "Bus";
                                                } else if ($data['travel_type'] == "5") {
                                                    echo "Hotel";
                                                }
                                                if ($data['group_travel'] == "1") {
                                                    echo "(Group Travel)";
                                                }
                                                ?></td>
                                            <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
                                            <td class="hidden-xs"><?php echo $data['reporting_manager_name']; ?></td>
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
                                                        echo "Claim Expense";
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

                                            <td class="nowrap"><?php
                                                if ($data['request_status'] == "1") {
                                                    if ($controller != '') {
                                                        ?>
                                                        <!--<a class="btn btn-xs blue-chambray" title="Edit Trip"
                                                        href="<?php echo base_url($controller) . '/index/' . $data['id']; ?>">
                                                        <i class="fa fa-eye"></i> Edit Request</a> --><?php
                                                    }
                                                }

                                                if ($data['request_status'] != "9") {
                                                    
                                                } else {
                                                    if ($data['merge_expense'] == "0") {
                                                        ?></br><a class="btn btn-xs blue-chambray" href="<?php echo base_url() . 'employee_request/view_expense/' . $data['id']; ?>" title="View Approved Expense"><i class="fa fa-eye"></i> Approved Expense </a><?php
                                                    }
                                                }
                                                if ($data['request_status'] == "3") {
                                                    if ($display_flag == "1") {
                                                        ?></br><a class="btn btn-xs blue-chambray" href="<?php echo base_url() . 'employee_request/self_booking/' . $data['id']; ?>"><i class="fa fa-edit"></i> Self Booking</a><?php
                                                    }
                                                }
                                                if ($data['cancel_status'] != "1") {
                                                    if ($data['approval_status'] == "Approved") {
                                                        if ($data['request_status'] <= "3") {
                                                            ?>
                                                                        <!--<a class="btn btn-xs blue-chambray" href="<?php echo base_url() . 'employee_request/accommodation/' . $data['id']; ?>"><i class="fa fa-edit"></i> Booking</a>-->
                                                                        <!--<button type="button" class="btn btn-xs blue-chambray" data-id="<?php echo $data['booking_req_id']; ?>" data-href="<?php echo base_url() . 'employee_request/accommodation/' . $data['id']; ?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-bus"></i> Request Booking</button>-->
                                                            </br><a class="btn btn-xs blue-chambray" data-placement="top" data-original-title="View" href="#edit_modal" data-toggle="modal" title="View" data-url="<?php echo base_url() . 'ajax/check_booking/' . $data['id']; ?>" onclick='show_modal(this,<?php echo json_encode($post_data); ?>);' title="Send Booking Request To Admin OR Self-booking"><i class="fa fa-bus"></i> Request Booking</a><?PHP
                                                        }
                                                    }

                                                    if ($data['request_status'] != "9") {
                                                        if ($data['cancel_status'] == "0") {
                                                            if ($data['approval_status'] == "Approved") {
                                                                ?></br><a class="btn btn-xs red-intense" href="<?php echo base_url() . 'employee_request/cancel_trip_request/' . $data['id']; ?>" title="Cancel Your Travel"><i class="fa fa-remove"></i> Trip Cancel</a><?PHP
                                                            }
                                                        } else if ($data['cancel_status'] == "4") {
                                                            ?></br><span class="btn btn-xs red"> Refund Pending </span><?PHP
                                                        }
                                                    }
                                                    if ($data['request_status'] == "4") {
                                                        if ($data['cancel_status'] == "0") {
                                                            ?></br><a onClick="sureClaim('<?php echo $data['id']; ?>');" class="btn btn-xs purple" href="javascript:void(0);" title="Submit Your Travel Expense"><i class="fa fa-eye"></i> Claim</a><?php
                                                        }
                                                    } else if ($data['request_status'] == "5" && $data['expense_status'] == "Pending") {
                                                        ?></br><a class="btn btn-xs blue" href="<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>" title="View Your Unapproved Expense"><i class="fa fa-eye"></i>Unapproved Expense </a><?php
                                                    } else if ($data['request_status'] == "5" && $data['expense_status'] == "Clarification") {
                                                        if ($data['merge_expense'] == "0") {
                                                            if ($data['cancel_status'] == "0") {
                                                                ?></br><a class="btn btn-xs red" href="<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>"><i class="fa fa-eye"></i> Claim Clarification</a><?php
                                                            }
                                                        }
                                                    } else if ($data['request_status'] == "6") {
                                                        if ($data['expense_status'] == "Approved") {
                                                            ?></br><a class="btn btn-xs blue-chambray" href="<?php echo base_url() . 'employee_request/view_expense/' . $data['id']; ?>"><i class="fa fa-eye"></i> Expense Approved </a><?php
                                                        } else if ($data['expense_status'] == "Rejected") {
                                                            ?></br><span class="btn btn-xs red" <i class="fa fa-eye"></i> Expense Rejected </span><?php
                                                        }
                                                    }
                                                }
                                                ?></td></tr><?php
                                    }
                                    ?></tbody></table></div>

                        <div class="tab-pane fade" id="tab1default1">
                            <table class="table" id="make-data-table_1">
                                <thead>
                                    <tr>
                                        <th>Trip ID</th>
                                        <th>Emp. Name</th>
                                        <th class="hidden-xs">Reason</th><th>Departure date</th>
                                        <th>Return date</th><th class="hidden-xs">Service</th>
                                        <th>From - To</th><th class="hidden-xs">Action by</th>
                                        <th>Status</th><th class="no_sort" style="width:150px;"></th></tr></thead>
                                <tbody><?php
                                    foreach ($emp_request as $data) {
                                        $display_flag = 0;
                                        if ($data['trip_type'] == '1') {
                                            if ($data['travel_ticket'] == '2') {
                                                $display_flag = 1;
                                                $trip_ticket = $data['trip_ticket'];
                                            } else {
                                                $trip_ticket = 1;
                                            }
                                        } else {
                                            if ($data['travel_ticket'] == '2') {
                                                $display_flag = 1;
                                            }
                                            if ($data['travel_ticket'] == '2' && $data['trip_ticket_return'] == '1') {
                                                $trip_ticket = $data['trip_ticket'];
                                            } else {
                                                $trip_ticket = 0;
                                            }
                                        }

                                        if ($data['accommodation'] == '2') {
                                            $display_flag = 1;
                                            $hotel_booking = $data['hotel_booking'];
                                        } else {
                                            $hotel_booking = 1;
                                        }

                                        if ($data['car_hire'] == '2') {
                                            $display_flag = 1;
                                            $car_booking = $data['car_booking'];
                                        } else {
                                            $car_booking = 1;
                                        }
                                        ?><tr><td><?php echo $data['reference_id']; ?></td>
                                            <td><?php echo $data['employee_name']; ?></td>
                                            <td class="hidden-xs"><?php
                                                if ($data['travel_reason_id'] != "Projects") {
                                                    echo $data['reason'];
                                                } else {
                                                    echo "Projects (" . $data['project_name'] . ")";
                                                };
                                                ?></td>
                                            <td><?php echo date(DATETIME_FORMAT, strtotime($data['departure_date'])); ?></td><td><?php
                                                if ($data['trip_type'] != "1") {
                                                    echo date(DATETIME_FORMAT, strtotime($data['return_date']));
                                                } else {
                                                    echo "Not Fix";
                                                }
                                                ?></td><td class="hidden-xs"><?php
                                                $controller = '';
                                                if ($data['travel_type'] == "1") {
                                                    $controller = "flight_travel";
                                                    echo "Flight";
                                                } else if ($data['travel_type'] == "2") {
                                                    $controller = "train_travel";
                                                    echo "Train";
                                                } else if ($data['travel_type'] == "3") {
                                                    $controller = "car_travel";
                                                    echo "Car";
                                                } else if ($data['travel_type'] == "4") {
                                                    $controller = "bus_travel";
                                                    echo "Bus";
                                                } else if ($data['travel_type'] == "5") {
                                                    echo "Hotel";
                                                }
                                                if ($data['group_travel'] == "1") {
                                                    echo "(Group Travel)";
                                                }
                                                ?></td><td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
                                            <td class="hidden-xs"><?php if ($data['approval_level'] != '0') echo $data['reporting_manager_name']; ?></td><td><?php
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
                                                        echo "Claim Expense";
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
                                                ?></td><td class="nowrap"><?php
                                                if ($data['request_status'] != "9") {
                                                    ?></br><a class="btn btn-xs purple" title="Incompleted Trip" href="<?php echo base_url() . 'employee_request/view/' . $data['id']; ?>">
                                                        <i class="fa fa-eye"></i> view</a><?php
                                                } else {
                                                    ?></br><a class="btn btn-xs btn-success" title="Completed Trip" href="<?php echo base_url() . 'employee_request/view/' . $data['id']; ?>"><i class="fa fa-eye"></i>view</a><?php
                                                    }
                                                    if ($data['cancel_status'] != "1") {
                                                        if ($data['approval_status'] == "Approved") {
                                                            if ($data['request_status'] <= "3") {
                                                                ?>
                                                                                        <!--<button type="button" class="btn btn-xs blue-chambray" data-href="<?php echo base_url() . 'employee_request/accommodation/' . $data['id']; ?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-bus"></i> Request Booking</button>-->
                                                            </br><a class="btn btn-xs blue-chambray" data-placement="top" data-original-title="View" href="#edit_modal" data-toggle="modal" title="View" data-url="<?php echo base_url() . 'ajax/check_booking/' . $data['id']; ?>" onclick='show_modal(this,<?php echo json_encode($post_data); ?>);' title="View"><i class="fa fa-bus"></i> Request Booking</a><?PHP
                                                        }
                                                    }
                                                }

                                                if ($data['cancel_status'] != "1") {
                                                    if ($data['request_status'] == "4") {
                                                        if ($data['cancel_status'] == "0") {
                                                            ?></br><a class="btn btn-xs purple" href="<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>"><i class="fa fa-eye"></i> Claim</a><?php
                                                        }
//}
//} else if ($data['request_status'] == "5" && $data['expense_status'] == "Pending") {
//
                                                        ?><!--<a class="btn btn-xs blue" href="//<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>"><i class="fa fa-eye"></i> Edit Pending Expense </a>--><?php
                                                    } else if ($data['request_status'] == "5" && $data['expense_status'] == "Clarification") {
                                                        if ($data['cancel_status'] == "0") {
                                                            ?></br><a class="btn btn-xs red" href="<?php echo base_url() . 'employee_request/claim/' . $data['id']; ?>"><i class="fa fa-eye"></i> Claim Clarification</a><?php
                                                        }
                                                    }

//} else if ($data['request_status'] == "6") {
//if ($data['expense_status'] == "Approved") {
//
                                                    ?>
                            <!--<a class="btn btn-xs blue-chambray" href="//<?php echo base_url() . 'employee_request/view_expense/' . $data['id']; ?>"><i class="fa fa-eye"></i> Expense Approved </a>--><?php
//} else if ($data['expense_status'] == "Rejected") {
//
                                                    ?><!--<span class="btn btn-xs red" <i class="fa fa-eye"></i> Expense Rejected </span>--><?php
//}
//}
                                                }
                                                ?></td></tr><?php
                                    }
                                    ?></tbody></table></div></div></div>

                <!--</div>-->
            </div></div></div>
    <!-- END PAGE CONTENT-->
</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content"><div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="frm_title">Cancellation Confirmation</h4></div>
            <div class="modal-body">Are you sure you want to Cancel this Trip?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Cancel</a></div></div></div></div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"><div class="modal-content">
            <form method="post" class="form-horizontal" id="accommodation_form" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Request Booking</h4></div>
                <div class="modal-body"><div class="row"><div class="col-md-12 light bordered">

                            <div class="row"><div class="col-md-6 col-xs-6" style="border-right: 1px #000 dashed">
                                    <h4 class="form-section"><spam class="cutm_lbl btn_blue" style="margin-left: 5px;">
                                            By Travel Desk</spam></h4><div class="form-group"><div class="col-md-12"><label>
                                                <div class="radio mgt-24px"><input type="radio" name="travel_ticket" value="1" checked='true'></div>
                                                Travel Ticket</label></div></div>

                                    <div class="form-group"><div class="col-md-12"><label>
                                                <div class="radio mgt-24px"><input type="radio" name="accommodation" value="1" ></div>
                                                Accommodation </label></div></div>

                                    <div class="form-group"><div class="col-md-12"><label>
                                                <div class="radio mgt-24px"><input type="radio" name="car_hire" value="1" ></div>
                                                Car Hire</label></div></div></div>

                                <div class="col-md-6 col-xs-6"><h4 class="form-section">
                                        <spam class="cutm_lbl btn_blue">Book By Self</spam></h4>
                                    <div class="form-group"><div class="col-md-12"><label>
                                                <div class="radio mgt-24px"><input type="radio" name="travel_ticket" value="2"></div>
                                                Travel Ticket</label></div></div>

                                    <div class="form-group"><div class="col-md-12"><label>
                                                <div class="radio mgt-24px"><input type="radio" name="accommodation" value="2"></div>
                                                Accommodation </label></div></div>

                                    <div class="form-group"><div class="col-md-12"><label>
                                                <div class="radio mgt-24px"><input type="radio" name="car_hire" value="2"></div>
                                                Car Hire</label></div></div></div></div></div></div></div>

                <div class="modal-footer"><input type="hidden" name="id" id="id" value="">
                    <input type="submit" name="submit_ticket" value="Submit" class="btn btn-success">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form></div></div></div>

<!--Add new inventory item form modal-- ajax-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="add_inventory_item_modal">
    <div class="modal-dialog"><div class="modal-content" id="add_itemt_frm"></div></div></div>

<!--edit new inventory item form modal-- ajax-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="edit_modal">
    <div class="modal-dialog"><div class="modal-content"></div></div></div>

<div class="modal fade" id="sureClaim" role="dialog">
    <div class="modal-dialog"><div class="modal-content"><div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4></div><div class="modal-body">
                <p>Are you sure to claim your travel expense? If you have filled your pocket expenses, click 'Yes'</p></div>
            <div class="modal-footer">
                <a id="sureClaimYesButton" href="" class="btn btn-success">Yes</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div></div></div></div>

<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>

<script type="text/javascript">

                                                                function sureClaim(recordID)
                                                                {
                                                                    var link = '<?php echo base_url() . 'employee_request/claim/'; ?>' + recordID;
                                                                    $("#sureClaimYesButton").attr('href', link);
                                                                    $("#sureClaim").modal();
                                                                }

                                                                $('.form_datetime_REMOVE_ME').datetimepicker({
                                                                    weekStart: 0,
                                                                    todayBtn: 1,
                                                                    startDate: "<?php echo date("Y-m-d", strtotime("+1 day")); ?>",
                                                                    autoclose: 1,
                                                                    todayHighlight: 1,
                                                                    startView: 2,
                                                                    showMeridian: 1,
                                                                    minView: 1,
                                                                    format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
                                                                });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
        });
        $('#myModal').on('show.bs.modal', function (e) {
            $(this).find('#accommodation_form').attr('action', $(e.relatedTarget).data('href'));
            var data_id = $(e.relatedTarget).data('id');
            $("#id").val(data_id);
        });
    });

    function edit_date()
    {
        //alert('Update these dates in DB');
    }

    function show_modal(obj, post_data) {
        var modal_id = $(obj).attr('href');
        var content = $(modal_id).children('div.modal-dialog').children('div.modal-content');
        var data_url = $(obj).attr('data-url');
//$(content).html('');        
        $.ajax({
            url: data_url,
            type: "POST",
            dataType: "html",
            data: post_data, catch : false,
            success: function (data) {
                $(content).html(data);
            }});
    }

//$(document).ready(function () {
//var oTable = $('#make-data-table').dataTable();
// // Sort immediately with columns 0 and 1
//oTable.fnSort([[0, 'desc']]);
//});

//$(document).ready(function () {
//$('#make-data-table').DataTable({
//"order": [[0, "desc"]],
//});
//});

    var makeRadiosDeselectableByName = function (name) {
        $('input[name=' + name + ']').on("click", function () {
            if ($(this).attr('previousValue') == 'true') {
                $(this).attr('checked', false)
                $('input[name=' + name + ']').attr('previousValue', false);
            } else if ($(this).attr('previousValue') == undefined) {
                $('input[name=' + name + ']').attr('previousValue', true);
                $(this).attr('checked', true);
            } else if ($(this).attr('previousValue') == 'false') {
                $('input[name=' + name + ']').attr('previousValue', true);
                $(this).attr('checked', true);
            } else {
                $('input[name=' + name + ']').attr('previousValue', false);
                $(this).attr('checked', false);
            }
// $(this).attr('previousValue', $(this).attr('checked'));
        });
    };
    makeRadiosDeselectableByName('accommodation');
    makeRadiosDeselectableByName('car_hire');
</script>
<style type="text/css">.mgt-24px{margin-bottom:24px !important;}</style>