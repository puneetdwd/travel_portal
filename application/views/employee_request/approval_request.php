<link href="<?php echo base_url('/assets/gauges'); ?>./jquery-gauge.css" type="text/css" rel="stylesheet">
<div class="page-content"> 
    <div class="row">
        <div style="text-align:center;margin-top: -50px;" data-original-title="" title="">
            <!-- ngRepeat: state in arrStates track by $index -->
            <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">
                    <?php if ($request['request_status'] >= "1") {
                        ?>
                        <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title="">✔</div>
                        <?php
                    } else {
                        ?>
                        <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                        <?php
                    }
                    ?>
                    <span class="ng-binding">Travel Request</span>
                </div>
                <!-- ngIf: $index!=arrStates.length-1 -->
                <div style="display:inline-block;height:70px;vertical-align:top" ng-if="$index != arrStates.length - 1" class="ng-scope" data-original-title="" title="">
                    <div style="border:1px solid black;width:70px;margin-top:35px;"></div>
                </div>
                <!-- end ngIf: $index!=arrStates.length-1 -->
            </div>
            <?php
            if ($request['approval_status'] != "Rejected") {
                ?>          

                <!-- end ngRepeat: state in arrStates track by $index -->
                <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                    <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">                    
                        <?php if ($request['request_status'] >= "2") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title="">✔</div>
                            <?php
                        } else if ($request['request_status'] == "1") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        } else {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201);" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        }
                        ?>
                        <span class="ng-binding">Manager Approval</span>
                    </div>
                    <!-- ngIf: $index!=arrStates.length-1 -->
                    <div style="display:inline-block;height:70px;vertical-align:top" ng-if="$index != arrStates.length - 1" class="ng-scope" data-original-title="" title="">
                        <div style="border:1px solid black;width:70px;margin-top:35px;"></div>
                    </div>
                    <!-- end ngIf: $index!=arrStates.length-1 -->
                </div>
                <!-- end ngRepeat: state in arrStates track by $index -->
                <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                    <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">
                        <?php if ($request['request_status'] >= "4") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title="">✔</div>
                            <?php
                        } else if ($request['request_status'] == "2") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        } else if ($request['request_status'] == "3") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        } else {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201);" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        }
                        ?>
                        <span class="ng-binding">Trip Accommodation</span>
                    </div>
                    <!-- ngIf: $index!=arrStates.length-1 -->
                    <div style="display:inline-block;height:70px;vertical-align:top" ng-if="$index != arrStates.length - 1" class="ng-scope" data-original-title="" title="">
                        <div style="border:1px solid black;width:70px;margin-top:35px;" data-original-title="" title=""></div>
                    </div>
                    <!-- end ngIf: $index!=arrStates.length-1 -->
                </div>
                <!-- end ngRepeat: state in arrStates track by $index -->
                <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                    <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">
                        <?php if ($request['request_status'] >= "5") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title="">✔</div>
                            <?php
                        } else if ($request['request_status'] == "4") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        } else {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201);" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        }
                        ?>
                        <span class="ng-binding">Expense Approval</span>
                    </div>
                    <!-- ngIf: $index!=arrStates.length-1 -->
                    <div style="display:inline-block;height:70px;vertical-align:top" ng-if="$index != arrStates.length - 1" class="ng-scope" data-original-title="" title="">
                        <div style="border:1px solid black;width:70px;margin-top:35px;"></div>
                    </div>
                    <!-- end ngIf: $index!=arrStates.length-1 -->
                </div>
                <!-- end ngRepeat: state in arrStates track by $index -->
                <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                    <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">
                        <?php if ($request['request_status'] >= "6") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title="">✔</div>
                            <?php
                        } else if ($request['request_status'] == "5") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        } else {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201);" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        }
                        ?>
                        <span class="ng-binding">Finance Approval</span>
                    </div>                
                    <!-- ngIf: $index!=arrStates.length-1 -->
                    <div style="display:inline-block;height:70px;vertical-align:top" ng-if="$index != arrStates.length - 1" class="ng-scope" data-original-title="" title="">
                        <div style="border:1px solid black;width:70px;margin-top:35px;"></div>
                    </div>
                </div>

                <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                    <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">
                        <?php if ($request['request_status'] >= "7") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title="">✔</div>
                            <?php
                        } else if ($request['request_status'] == "6") {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201); border: 1px solid #27a4b0;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        } else {
                            ?>
                            <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: rgb(209, 200, 201);" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div>
                            <?php
                        }
                        ?>
                        <span class="ng-binding">Completed</span>
                    </div>                
                    <div style="display:inline-block;height:70px;vertical-align:top" ng-if="$index != arrStates.length - 1" class="ng-scope hidden-lg hidden-md" data-original-title="" title="">
                        <div style="width:70px;margin-top:35px;"></div>
                    </div>
                </div>
                <!-- end ngRepeat: state in arrStates track by $index -->

            <?php } else { ?>
                <div ng-repeat="state in arrStates track by $index" style="display:inline-block;vertical-align:top" class="ng-scope" data-original-title="" title="">
                    <div style="padding:10px;text-align:center;display:inline-block;width:100px;" data-original-title="" title="">
                        <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #e73d4a;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div><span class="ng-binding"> Approver Reject</span></div><!-- ngIf: $index!=arrStates.length-1 --></div>
            <?php } ?>
        </div>
    </div>
    <style>
        .demo1 {
            position: relative;
            width: 20vw;
            height: 20vw;
            box-sizing: border-box;
            float:left;
            margin:20px
        }

        .demo2 {
            position: relative;
            width: 30vw;
            height: 30vw;
            box-sizing: border-box;
            /*float:right;*/
            margin:auto;
        }
    </style>
    <div class="alert green">
        <div class="pull-left col-md-6">
            <h3><?php echo $request['employee_name'] ?></h3>
        </div>
        <div class="pull-right col-md-6 text-right">
            <?php if ($request['request_status'] == "1") { ?>
                <?php if ($request['approval_status'] != "Approved") { ?>
                    <a href="#approve_modal" data-toggle="modal" class="btn btn_blue">
                        Approve
                    </a>
                <?php } ?>

                <?php if ($request['approval_status'] != "Rejected") { ?>
                    <a class="btn btn_red" href="#rejected_modal" data-toggle="modal">
                        Reject
                    </a>
                    <?php
                }
            } else {
                if ($request['approval_status'] == "Approved") {
                    ?>
                    <spam class="btn btn_blue">
                        Approved 
                    </spam>
                <?php } ?>

                <?php if ($request['approval_status'] == "Rejected") { ?>
                    <spam class="btn btn_red">
                        Rejected
                    </spam>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="row col-md-12">
        <div id="cardSpecificDetails" class="alert alert-info" data-original-title="" title="">
            <div class="row " data-original-title="" title="">
                <div class="col-sm-4 text-center" data-original-title="" title="">
                    <label>
                        <h4 class="label-class ng-binding">
                            <?php
                            if ($request['travel_type'] == "1") {
                                echo "Flight Travel";
                            } else if ($request['travel_type'] == "2") {
                                echo "Train Travel";
                            } else if ($request['travel_type'] == "3") {
                                echo "Car Travel";
                            } else if ($request['travel_type'] == "4") {
                                echo "Bus Travel";
                            }
                            if ($request['group_travel'] == "1") {
                                echo "(Group Travel)";
                            }
                            ?>

                        </h4>
                    </label>
                </div>
                <div class="col-sm-4 text-center" ng-show="travelCardObject.travelType" data-original-title="" title="">
                    <label><h4 class="label-class ng-binding"><?php echo $request['travel_class'] ?></h4></label>
                </div>
                <div class="col-sm-4 text-center" ng-show="travelCardObject.fromLocation & amp; & amp; travelCardObject.toLocation" data-original-title="" title="">
                    <label><h4 class="label-class ng-binding"><?php echo $request['from_city_name'] . " To " . $request['to_city_name'] ?></h4></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6 portlet light bordered" style="height: 200px">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Travel Request Summary
                                    </spam>
                                </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp">Travel Date:</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">
                                                    <?php echo $request['departure_date'] . " to " . $request['return_date']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp">Travel Reason:</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">
                                                    <?php echo $request['reason']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp">Travel Class:</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">
                                                    <?php echo $request['travel_class']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp">Comments:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php echo $request['comment']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp"></label>
                                            <div class="col-md-7">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp"></label>
                                            <div class="col-md-6">
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 portlet light bordered"  style="height: 200px">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Allowances
                                    </spam>
                                </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp">Conveynace Allowance:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php
                                                    if ($request['convince_allowance_actual'] != 1) {
                                                        echo number_format($request['convince_allowance'], 2);
                                                    } else {
                                                        echo "Actual";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp">Total Allowance:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php
                                                    $total_allowance = $request['convince_allowance'] + $request['hotel_allowance'] + $request['DA_allowance'];
                                                    echo number_format($total_allowance, 2);
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp">Accomodation Allowance:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php
                                                    if ($request['hotel_allowance_actual'] != 1) {
                                                        echo number_format($request['hotel_allowance'], 2);
                                                    } else {
                                                        echo "Actual";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp"></label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                </p>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp">Daily Allowance:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php
                                                    if ($request['DA_allowance_actual'] != 1) {
                                                        echo number_format($request['DA_allowance'], 2);
                                                    } else {
                                                        echo "Actual";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 portlet light bordered"  style="height: 400px">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Budget
                                    </spam>
                                </h4>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp">Total Budget:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php
                                                    if (isset($budget['budget'])) {
                                                        echo number_format($budget['budget'], 2);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left-imp">Remain:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">
                                                    <?php
                                                    if (isset($budget['remain_budget'])) {
                                                        echo number_format($budget['remain_budget'], 2);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($budget['budget'])) {
                                    $remain_budget = $budget['remain_budget'];
                                    $budget = $budget['budget'];

                                    $budget_part = $budget / 5;
                                    $first = $budget_part;
                                    $second = $budget_part * 2;
                                    $thirds = $budget_part * 3;
                                    $forth = $budget_part * 4;
                                    $fifth = $budget_part * 5;

                                    $value = $remain_budget * 100 / $budget;
                                    ?>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <br>
                                            <br>
                                            <div class="gauge2 demo2"></div>
                                        </div>
                                    </div>
                                <?php } ?>  
                            </div>
                            <div class="col-md-6 portlet light bordered" style="height: 400px">
                                <div class="row">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Travel Start Date</th>
                                                <th>Travel Reason</th>
                                                <th>Travel Description</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($last_few_req as $data) { ?>
                                                <tr>
                                                    <td><?php echo $data['departure_date']; ?></td>
                                                    <td><?php echo $data['reason']; ?></td>
                                                    <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
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

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if ($request['group_travel'] == "1") { ?>
                                <div class="col-md-6 portlet light bordered">
                                    <h4 class="form-section">
                                        <spam class="cutm_lbl btn_blue">
                                            Group Travel Member List
                                        </spam>
                                    </h4>
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Employee Name</th>
                                                    <th>Employee Age</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($member_list as $data) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $data['employee_name']; ?></td>
                                                        <td><?php echo $data['age']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                <?php
                                                foreach ($member_other_list as $data) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $data['employee_name']; ?></td>
                                                        <td><?php echo $data['age']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-5 col-md-12">
                                        <a href="<?php echo base_url() . 'employee_request'; ?>" class="btn default">
                                            <i class="m-icon-swapleft"></i> Back 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                </form>
                <!-- END FORM-->
            </div>

        </div>

    </div>
    <!-- END PAGE CONTENT-->

</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="approve_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Approve Task</h4>
            </div>
            <form action="<?php echo base_url() . 'employee_request/approve_request/' . $request_id; ?>" id="approval_task" method="post" class="validate-form form-horizontal row-border">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget box">
                                <div class="widget-content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Please provide your comments.
                                                <span class="required">*</span>:</label>
                                            <!--<div class="col-md-12">-->
                                            <textarea name="approve_comment" id="approve_comment" class="form-control required" rows="4"></textarea>
                                            <!--</div>-->
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
                <h4 class="modal-title">Reject Task</h4>
            </div>
            <form action="<?php echo base_url() . 'employee_request/reject_request/' . $request_id; ?>" id="reject_task" method="post" class="form-horizontal row-border validate-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget box">
                                <div class="widget-content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Reject Reason<span class="required">*</span>:</label>
                                            <select class="form-control required" name="reject_reason" id="reject_reason">
                                                <option class="" value="" disabled="" selected="selected">Choose an Option</option>
                                                <option value="1" label="Do the work through Hangouts">Do the work through Hangouts</option>
                                                <option value="2" label="Byond Travel Date">Byond Travel Date</option>
                                                <option value="3" label="Budget Not Approved">Budget Not Approved</option>
                                                <option value="4" label="Travel Plan Changed">Travel Plan Changed</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Please provide your comments.
                                                <span class="required">*</span>:</label>
                                            <textarea name="reject_comment" id="reject_comment" class="form-control required" rows="4"></textarea>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/assets/gauges'); ?>./jquery-gauge.min.js"></script>


<script type="text/javascript">
                    $(document).ready(function () {
                        // first example
//                        var gauge = new Gauge($('.gauge1'), {value: 70});

                        // second example
                        $('.gauge2').gauge({
                            values: {
                                0: '0',
                                20: '<?php echo $second; ?>',
                                50: '<?php echo $thirds; ?>',
                                80: '<?php echo $forth; ?>',
                                100: '<?php echo $fifth; ?>'
                            },
                            colors: {
                                0: '#666',
                                20: '#378618',
                                50: '#ffa500',
                                80: '#f00',
                                100: '#f00'
                            },
                            angles: [
                                180,
                                360
                            ],
                            lineWidth: 10,
                            arrowWidth: 20,
                            arrowColor: '#ccc',
                            inset: true,
                            value: <?php echo $value; ?>
                        });
                    });

</script>

<script>
    $(document).ready(function () {
        /*add exam form validation*/
        $('#approval_task').validate({
            rules: {
                approve_comment: {
                    required: true
                },
            },
            messages: {
                approve_comment: {
                    required: 'Comment is required'
                },
            }
        });
        $('#reject_task').validate({
            rules: {
                reject_reason: {
                    required: true
                },
                reject_comment: {
                    required: true
                },
            },
            messages: {
                reject_reason: {
                    required: 'Reject Reason is required'
                },
                reject_comment: {
                    required: 'Comment is required'
                },
            }
        });
    });

</script>

