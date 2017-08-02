<div class="page-content"> 
    <!-- BEGIN PAGE CONTENT-->
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
                        <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #e73d4a;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""><i class="fa fa-times" aria-hidden="true"></i></div><span class="ng-binding"> Approver Reject</span></div><!-- ngIf: $index!=arrStates.length-1 --></div>
            <?php } ?>
        </div>
    </div>
    <div class="alert green">
        <div class="pull-right col-md-6 text-right">
            <?php
            if ($request['cancel_status'] == "1") {
                ?>
                <spam class="btn btn_red">
                    Cancelled
                </spam>
                <?php
            } else {
                if ($request['request_status'] != "1") {

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
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5 text-left-imp">Comments:</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
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
                                            <div class="col-md-7">
                                                <p class="form-control-static">
                                                    <?php echo $request['comment']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 portlet light bordered" style="height: 200px">
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
                                                <p class="form-control-static"><?php
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
                        <?php
                        if ($request['request_status'] >= "2") {
                            ?>
                                
                                <div class="col-md-6 portlet light bordered"  style="height: 200px">
                                    <h4 class="form-section">
                                        <spam class="cutm_lbl btn_blue">
                                            Approval Summary
                                        </spam>
                                    </h4>
                                    <?php
                                    if ($request['approval_status'] == "Rejected") {
                                        ?>                            
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Rejected By</label>
                                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                                    <div class="col-md-6">
                                                        <p class="form-control-static">
                                                            <?php
                                                            echo $request['reporting_manager_name'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Reject Reason</label>
                                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                                    <div class="col-md-6">
                                                        <p class="form-control-static">
                                                            <?php
                                                            if ($request['reject_reason'] == "1") {
                                                                echo "Do the work through Hangouts";
                                                            } else if ($request['reject_reason'] == "2") {
                                                                echo "Byond Travel Datee";
                                                            } else if ($request['reject_reason'] == "3") {
                                                                echo "Budget Not Approved";
                                                            } else if ($request['reject_reason'] == "4") {
                                                                echo "Travel Plan Changed";
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Reject Date</label>
                                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                                    <div class="col-md-6">
                                                        <p class="form-control-static">
                                                            <?php
                                                            echo date('Y-m-d H:i A', strtotime($request['approval_datetime']));
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-md-offset-1 text-left-imp">Comment</label>
                                                    <label class="control-label col-md-1 text-center-imp">:</label>
                                                    <div class="col-md-6">
                                                        <p class="form-control-static">
                                                            <?php
                                                            echo $request['approve_comment'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 text-left-imp">Approved By:</label>
                                                    <div class="col-md-7">
                                                        <p class="form-control-static">
                                                            <?php
                                                            echo $request['reporting_manager_name'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 text-left-imp">Approved Date:</label>
                                                    <div class="col-md-7">
                                                        <p class="form-control-static">
                                                            <?php
                                                            echo date('Y-m-d H:i A', strtotime($request['approval_datetime']));
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 text-left-imp">Comment:</label>
                                                    <div class="col-md-7">
                                                        <p class="form-control-static">
                                                            <?php
                                                            echo $request['approve_comment'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php
                        }
                        ?>                 
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

                                                foreach ($member_other_list as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $value['employee_name'] ?></td>
                                                        <td><?php echo $value['age'] ?></td>
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
                        <?php if ($request['request_status'] >= '4') { ?>
                            <div class="row" id="print_div">
                                <?php
                                if ($request['travel_type'] == '1') {
                                    if ($request['trip_ticket'] == '1') {
                                        if (!empty($flight_booking)) {
                                            if ($flight_booking['cancel_status'] != '1') {
                                                ?>
                                                <div class="col-md-4 portlet light bordered" style="height: 300px;">
                                                    <h4 class="form-section"><spam class="cutm_lbl btn_blue">Flight Ticket</spam></h4>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Flight Provider:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $flight_booking['flight_provider_name']; ?>
                                                                </label>                                    
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">PNR number:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $flight_booking['pnr_number']; ?>
                                                                </label>                                    
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Cost:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $flight_booking['cost']; ?>
                                                                </label>  
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Flight number:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $flight_booking['flight_number']; ?>
                                                                </label>  
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Comment:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $flight_booking['comment']; ?>
                                                                </label>  
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Flight Attach:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $flight_booking['flight_attachment']; ?>">
                                                                        <i class="fa fa-download"></i> Download 
                                                                    </a>
                                                                </label>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>                        
                                <?php
                                if ($request['travel_type'] == '2') {
                                    if ($request['trip_ticket'] == '1') {
                                        if (!empty($train_booking)) {
                                            if ($train_booking['cancel_status'] != '1') {
                                                ?>
                                                <div class="col-md-4 portlet light bordered" style="height: 300px;">
                                                    <h4 class="form-section"><spam class="cutm_lbl btn_blue">Trip Ticket</spam></h4>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Train Provider:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $train_booking['train_provider_name']; ?>
                                                                </label> 
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">PNR number:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $train_booking['pnr_number']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Cost:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $train_booking['cost']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Train number:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $train_booking['train_number']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Comment:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $train_booking['comment']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Attach:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $train_booking['train_attachment']; ?>">
                                                                        <i class="fa fa-download"></i> Download 
                                                                    </a>
                                                                </label>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if ($request['travel_type'] == '3') {
                                    if ($request['trip_ticket'] == '1') {
                                        if (!empty($car_booking)) {
                                            if ($car_booking['cancel_status'] != '1') {
                                                ?>
                                                <div class="col-md-4 portlet light bordered" style="height: 300px;">
                                                    <h4 class="form-section"><spam class="cutm_lbl btn_blue">Trip Ticket</spam></h4>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Car Provider:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $car_booking['car_provider_name']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Cost:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $car_booking['cost']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Comment:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $car_booking['comment']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp">Attach:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $car_booking['car_attachment']; ?>">
                                                                        <i class="fa fa-download"></i> Download 
                                                                    </a>
                                                                </label>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if ($request['travel_type'] == '4') {
                                    if ($request['trip_ticket'] == '1') {
                                        if (!empty($bus_booking)) {
                                            if ($bus_booking['cancel_status'] != '1') {
                                                ?>
                                                <div class="col-md-4 portlet light bordered" style="height: 300px;">
                                                    <h4 class="form-section"><spam class="cutm_lbl btn_blue">Trip Ticket</spam></h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Bus Provider:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $bus_booking['bus_provider_name']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Cost:</label>                                    
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $bus_booking['cost']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Comment:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <?php echo $bus_booking['comment']; ?>
                                                                </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp">Attach:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $bus_booking['bus_attachment']; ?>">
                                                                        <i class="fa fa-download"></i> Download 
                                                                    </a>
                                                                </label>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>


                                <?php
                                if ($request['hotel_booking'] == '1') {
                                    if (!empty($hotel_booking)) {
                                        if ($hotel_booking['cancel_status'] != '1') {
                                            ?>
                                            <div class="col-md-4 portlet light bordered" style="height: 300px;">
                                                <h4 class="form-section"><spam class="cutm_lbl btn_blue">Hotel Ticket</spam></h4>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Location:</label>                                    
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $hotel_booking['from_city_name']; ?>
                                                            </label>  
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Hotel Provider:</label>  
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $hotel_booking['hotel_provider_name']; ?>
                                                            </label> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dtp_input1" class="control-label cutm_text_bold">Check-In Date</label>
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $hotel_booking['check_in_date']; ?>
                                                            </label> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dtp_input1" class="control-label cutm_text_bold">Check-Out Date</label>
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $hotel_booking['check_out_date']; ?>
                                                            </label> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Cost:</label>                                    
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $hotel_booking['cost']; ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Comment:</label>                                                                            
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $hotel_booking['comment']; ?>
                                                            </label>
                                                        </div>
                                                        <?php if ($hotel_booking['hotel_attchment'] != '') { ?>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Hotel Attach:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $hotel_booking['hotel_attchment']; ?>">
                                                                        <i class="fa fa-download"></i> Download 
                                                                    </a>
                                                                </label>  
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }

                                if ($request['car_booking'] == '1') {
                                    if (!empty($car_booking)) {
                                        if ($car_booking['cancel_status'] != '1') {
                                            ?>
                                            <div class="col-md-4 portlet light bordered" style="height: 300px;">
                                                <h4 class="form-section"><spam class="cutm_lbl btn_blue">Car Booking</spam></h4>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Car Category:</label>                                    
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $car_booking['car_category_name']; ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dtp_input1" class="control-label cutm_text_bold">Pick-Up Date</label>
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $car_booking['pick_up_date']; ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dtp_input1" class="control-label cutm_text_bold">Drop-Off Date</label>
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $car_booking['drop_off_date']; ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Pick-Up Location:</label>                                    
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $car_booking['pick_up_location']; ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Drop-Off Location:</label>                                    
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $car_booking['drop_off_location']; ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label text-left-imp cutm_text_bold">Cost:</label>                                                                            
                                                            <label class="control-label text-left-imp">
                                                                <?php echo $car_booking['cost']; ?>
                                                            </label>
                                                        </div>
                                                        <?php if ($car_booking['car_attchment'] != '') { ?>
                                                            <div class="form-group">
                                                                <label class="control-label text-left-imp cutm_text_bold">Attach:</label>                                                                            
                                                                <label class="control-label text-left-imp">
                                                                    <a class="btn-link" target="_blank" href="<?php echo base_url('employee_request/download_attchment') . '/' . $car_booking['car_attchment']; ?>">
                                                                        <i class="fa fa-download"></i> Download 
                                                                    </a>
                                                                </label> 
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>                
                        <?php } ?>
                        <div class="row">
                            <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-offset-5 col-md-12">
                                            <a href="<?php echo base_url() . 'employee_request'; ?>" class="btn default">
                                                <i class="m-icon-swapleft"></i> Back 
                                            </a>
                                            <?php
                                            if ($request['request_status'] >= '4') {
                                                if ($request['cancel_status'] == '0') {
                                                    ?>
                                                    <input type='button' id='btn' class="btn btn_blue " value='Print Ticket' onclick='printDiv();'>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM-->
                    </div>
                </form>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>

    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print_div').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>