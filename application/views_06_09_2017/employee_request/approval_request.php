<link href="<?php echo base_url('/assets/gauges'); ?>/jquery-gauge.css" type="text/css" rel="stylesheet">
<div class="page-content"> 
    <div class="row hidden-xs" style="display:none">
        <div style="text-align:center;margin-top: 0px;" data-original-title="" title="">
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
                        <?php if ($request['request_status'] >= "9") {
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
        p {
            margin: 10px 0;
        }
    </style>
    <style>
        /*        .demo2 {
                    position: relative;
                    width: 50vw;
                    height: 50vw;
                    box-sizing: border-box;
                    float:right;
                    margin:auto;
                }*/

        /*        @media only screen and (max-width: 500px) {
                    .demo2 {
                        position: relative;
                        width: 70vw;
                        height: 70vw;
                        box-sizing: border-box;
                        margin:auto;
                    }
                }*/
    </style>
    <div class="alert green">
        <div class="pull-left col-md-6 paddingZero">
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
    <div class="hidden-lg hidden-md">
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="cardSpecificDetails" class="alert alert-info" data-original-title="" title="">
                <div class="row " data-original-title="" title="">
                    <div class="col-sm-4 text-center" data-original-title="" title="">
                        <label>
                            <h4 class="label-class ng-binding">
                                <?php
                                $travel_mode = '';
                                if ($request['travel_type'] == "1") {
                                    echo "Flight Travel";
                                    $travel_mode = "Flight";
                                } else if ($request['travel_type'] == "2") {
                                    echo "Train Travel";
                                    $travel_mode = "Train";
                                } else if ($request['travel_type'] == "3") {
                                    echo "Car Travel";
                                    $travel_mode = "Car";
                                } else if ($request['travel_type'] == "4") {
                                    echo "Bus Travel";
                                    $travel_mode = "Bus";
                                }
                                echo " - " . $request['travel_class'];
                                if ($request['group_travel'] == "1") {
                                    echo " (Group Travel)";
                                }
                                ?>

                            </h4>
                        </label>
                    </div>
                    <!--<div class="col-sm-4 text-center" ng-show="travelCardObject.travelType" data-original-title="" title="">
                        <label><h4 class="label-class ng-binding"><?php echo $request['travel_class'] ?></h4></label>
                    </div>-->
                    <div class="col-sm-4 text-center" ng-show="travelCardObject.fromLocation & amp; & amp; travelCardObject.toLocation" data-original-title="" title="">
                        <label><h4 class="label-class ng-binding"><?php echo $request['from_city_name'] . " To " . $request['to_city_name'] ?></h4></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light borderLight">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 portlet light bordered padding-mob custom-height-app">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Travel Request Summary
                                    </spam>
                                </h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Trip ID:</p>                                    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php
                                                    echo $request['reference_id'];
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Travel Date:</p>                                    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php
                                                    if ($request['trip_type'] != "1") {
                                                        $dep_date = new DateTime($request['departure_date']);
                                                        $ret_date = new DateTime($request['return_date']); 
                                                        echo $dep_date->format(DATE_FORMAT) . " to " . $ret_date->format(DATE_FORMAT);
                                                    } else {
                                                        $dep_date = new DateTime($request['departure_date']);
                                                        echo $dep_date->format(DATE_FORMAT);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Travel Reason:</p>    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php echo $request['reason']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <!--/span-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Travel Class:</p>    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php echo $request['travel_class']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Comments:</p>    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php echo $request['comment']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 portlet light borderLight padding-mob custom-height-app">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Allowances
                                    </spam>
                                </h4>
                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Expense Type</th>
                                                <th>Eligibility</th>
                                                <th>Requested</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Travel Mode/Class</td>
                                                <td><?php
                                                    if ($sel_traverl_class != '') {
                                                        echo $travel_mode . "/" . $sel_traverl_class;
                                                    } else {
                                                        echo $travel_mode;
                                                    }
                                                    ?></td>
                                                <td><?php echo $travel_mode . "/" . $request['travel_class']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>D.A.</td>
                                                <td><?php echo $DA_allowance; ?></td>
                                                <td><?php
                                                    if ($request['DA_allowance_actual'] != 1) {
                                                        echo $request['DA_allowance'];
                                                    } else {
                                                        echo "Actual";
                                                    }
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td>Hotel</td>
                                                <td><?php echo $hotel_allowance; ?></td>
                                                <td><?php
                                                    if ($request['hotel_allowance_actual'] != 1) {
                                                        echo $request['hotel_allowance'];
                                                    } else {
                                                        echo "Actual";
                                                    }
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td>Conveyance</td>
                                                <td><?php echo $convince_allowance; ?></td>
                                                <td><?php
                                                    if ($request['convince_allowance_actual'] != 1) {
                                                        echo $request['convince_allowance'];
                                                    } else {
                                                        echo "Actual";
                                                    }
                                                    ?></td>
                                            </tr>
                                        </tbody>
                                    </table>                                        
                                </div>
                            </div>
                            <div class="col-md-5 portlet light bordered padding-mob custom-height-app">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Travel Budget
                                    </spam>
                                </h4>
                                <div class="row">                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Total Budget:</p>    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php
                                                    if (isset($budget['budget'])) {
                                                        echo number_format($budget['budget'], 2);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Spend:</p>    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
                                                    <?php
                                                    if (isset($budget['remain_budget']) && isset($budget['budget'])) {
                                                        $spend = $budget['budget'] - $budget['remain_budget'];
                                                        echo number_format($spend, 2);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-5 col-xs-5 ">
                                                <p class="text-left-imp">Remain:</p>    
                                            </div>
                                            <div class="col-md-7 col-xs-7">
                                                <p class="text-left-imp">
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


                                    $use_budget = $budget - $remain_budget;
                                    ?>
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="gauge2 demo2 alignCenter"></div>
                                        </div>
                                    </div>
                                <?php } ?>  


                            </div>
                            <!--                            <div class="col-md-6 portlet light bordered"  style="height: 200px">
                                                            <h4 class="form-section">
                                                                <spam class="cutm_lbl btn_blue">
                                                                    Allowances
                                                                </spam>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="col-md-7 col-xs-7 ">
                                                                            <p class="text-left-imp">Conveynace:</p>    
                                                                        </div>
                                                                        <div class="col-md-5 col-xs-5">
                                                                            <p class="text-left-imp">
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
                                                                    <div class="form-group">
                                                                        <div class="col-md-7 col-xs-7 ">
                                                                            <p class="text-left-imp">Accomodation:</p>    
                                                                        </div>
                                                                        <div class="col-md-5 col-xs-5">
                                                                            <p class="text-left-imp">
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
                                                                    <div class="form-group">
                                                                        <div class="col-md-7 col-xs-7 ">
                                                                            <p class="text-left-imp">Daily:</p>    
                                                                        </div>
                                                                        <div class="col-md-5 col-xs-5">
                                                                            <p class="text-left-imp">
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
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="col-md-7 col-xs-7 ">
                                                                            <p class="text-left-imp">Total Allowance:</p>    
                                                                        </div>
                                                                        <div class="col-md-5 col-xs-5">
                                                                            <p class="text-left-imp">
                            <?php
                            $total_allowance = $request['convince_allowance'] + $request['hotel_allowance'] + $request['DA_allowance'];
                            echo number_format($total_allowance, 2);
                            ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row hidden-xs">
                                                                /span
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="col-md-5 col-xs-5 ">
                                                                            <p class="text-left-imp">&nbsp;</p>    
                                                                        </div>
                                                                        <div class="col-md-7 col-xs-7">
                                                                            <p class="text-left-imp">
                                                                                &nbsp;
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="col-md-5 col-xs-5 ">
                                                                            <p class="text-left-imp">&nbsp;</p>    
                                                                        </div>
                                                                        <div class="col-md-7 col-xs-7">
                                                                            <p class="text-left-imp">
                                                                                &nbsp;
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>-->

                        </div>
                        <div class="row margin-mob-zero">

                            <div class="col-md-6 portlet light borderLight">
                                <h4 class="form-section">
                                    <spam class="cutm_lbl btn_blue">
                                        Last 5 Travel
                                    </spam>
                                </h4>
                                <div class="row table-scrollable">
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
                                            <?php if (empty($last_few_req)) { ?>
                                                <tr>
                                                    <td colspan="4" align="center">No Record Found</td>
                                                </tr>
                                            <?php } ?>
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
                                <div class="col-md-6 portlet light borderLight">
                                    <h4 class="form-section">
                                        <spam class="cutm_lbl btn_blue">
                                            Group Travel Members
                                        </spam>
                                    </h4>
                                    <div class="row table-scrollable">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Age</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
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
                                                        <td><?php echo $data['mobile']; ?></td>
                                                        <td><?php echo $data['email']; ?></td>
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
                                                        <td><?php echo $data['mobile_no']; ?></td>
                                                        <td><?php echo $data['email']; ?></td>
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
                        <!--<div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-5 col-md-12">
                                        <a href="<?php echo base_url() . 'employee_request'; ?>" class="btn default">
                                            <i class="m-icon-swapleft"></i> Back 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>-->

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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url('/assets/gauges'); ?>/jquery-gauge.min.js"></script>-->

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/assets/Raphael/demo'); ?>/js/kuma-gauge.jquery.js"></script>
<script type="text/javascript">
                    $(document).ready(function () {
                        var wdth = screen.width;
                        var rds = parseInt(wdth) * 215 / 1366;
//                        var pdgx = 10;
//                        alert(rds);
//                        alert(rds);
//                        1366 500 * 130
                        if (wdth < 500) {
                            var rds = wdth * 130 / 1366
                            var rds = 130;
                            var pdgx = 10;
                        } else {
                            var rds = 120;
                            var pdgx = 120;
                        }
                        $('.gauge2').kumaGauge({
                            value: <?php echo $use_budget; ?>,
                            showNeedle: false,
                            min: 0,
                            max: <?php echo $budget ?>,
                            radius: rds,
                            paddingX: pdgx,
//                            paddingY : 10,
                            label: {
                                display: true,
                                left: '0',
                                right: '<?php echo $budget ?>',
                                fontFamily: 'Helvetica',
                                fontColor: '#1E4147',
                                fontSize: '14',
                                fontWeight: 'bold'
                            }
                        });



                    });


//                    var update = setInterval(function () {
//                        $('.gauge2').kumaGauge('update', {
//                            value: 250000
//                        });
//                    }, 1000);

                    // first example
//                        var gauge = new Gauge($('.gauge1'), {value: 70});

                    // second example
//                    $('.gauge2').gauge({
//                    values: {
//                    0: '0',
//                            20: '<?php echo $second; ?>',
//                            50: '<?php echo $thirds; ?>',
//                            80: '<?php echo $forth; ?>',
//                            100: '<?php echo $fifth; ?>'
//                    },
//                            colors: {
//                            0: '#666',
//                                    20: '#378618',
//                                    50: '#ffa500',
//                                    80: '#f00',
//                                    100: '#f00'
//                            },
//                            angles: [
//                                    180,
//                                    360
//                            ],
//                            lineWidth: 10,
//                            arrowWidth: 20,
//                            arrowColor: '#ccc',
//                            inset: true,
//                            value: <?php // echo $value;          ?>
//                    });

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

