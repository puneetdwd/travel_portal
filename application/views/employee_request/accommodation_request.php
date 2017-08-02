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
                        <div style="width: 50px; height: 50px; color: white; padding: 17px; margin: 0px auto; border-radius: 50px !important; background-color: #e73d4a;" ng-style="$parent.getBackgroundColor($index)" class="ng-binding" data-original-title="" title=""></div><span class="ng-binding"> Approver Reject</span></div><!-- ngIf: $index!=arrStates.length-1 --></div>
            <?php } ?>
        </div>
    </div>
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

                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4 portlet light bordered" style="height: 200px;">
                            <h4 class="form-section">
                                <spam class="cutm_lbl btn_blue">
                                    Accommodation
                                </spam>
                            </h4>
                            <form  method="post" class="form-horizontal" role="form">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">                                            
                                            <div class="col-md-12">
                                                <input type="checkbox" name="travel_ticket" value="1" checked="" <?php
                                                if ($booking) {
                                                    if ($booking['travel_ticket'] == "1")
                                                        echo "checked";
                                                }
                                                ?>> Travel Ticket
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <div class="col-md-12">
                                                <input type="checkbox" name="accommodation" value="1" checked="" <?php
                                                if ($booking) {
                                                    if ($booking['accommodation'] == "1")
                                                        echo "checked";
                                                }
                                                ?>> Accommodation
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <div class="col-md-12">
                                                <input type="checkbox" name="car_hire" value="1" checked="" <?php
                                                if ($booking) {
                                                    if ($booking['car_hire'] == "1")
                                                        echo "checked";
                                                }
                                                ?>> Car Hire
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" value="<?php
                                                if ($booking) {
                                                    echo $booking['id'];
                                                }
                                                ?>">
                                                <br>
                                                <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                <input type="submit" name="self" value="Booked By Self" class="btn btn-success">                                                                                                
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 portlet light bordered" style="height: 200px;">
                            <h4 class="form-section">
                                <spam class="cutm_lbl btn_blue">
                                    Travel Request Summary
                                </spam>
                            </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-left-imp">Travel Date:</label>                                    
                                        <!--<div class="col-md-7">-->
                                        <p class="form-control-static">
                                            <?php echo $request['departure_date'] . " to " . $request['return_date']; ?>
                                        </p>
                                        <!--</div>-->
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-left-imp">Travel Reason:</label>                                    
                                        <!--<div class="col-md-7">-->
                                        <p class="form-control-static">
                                            <?php echo $request['reason']; ?>
                                        </p>
                                        <!--</div>-->
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-left-imp">Travel Class:</label>                                    
                                        <!--<div class="col-md-7">-->
                                        <p class="form-control-static">
                                            <?php echo $request['travel_class']; ?>
                                        </p>
                                        <!--</div>-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-left-imp">Comments:</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $request['comment']; ?>&nbsp;
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 portlet light bordered" style="height: 200px;">
                            <h4 class="form-section">
                                <spam class="cutm_lbl btn_blue">
                                    Allowances
                                </spam>
                            </h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-9 text-left-imp">Conveynace Allowance:</label>
                                        <div class="col-md-3">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-9 text-left-imp">Accomodation Allowance:</label>
                                        <div class="col-md-3">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-9 text-left-imp">Daily Allowance:</label>
                                        <div class="col-md-3">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-9 text-left-imp">Total Allowance:</label>
                                        <div class="col-md-3">
                                            <p class="form-control-static">
                                                <?php
                                                $total_allowance = $request['convince_allowance'] + $request['hotel_allowance'] + $request['DA_allowance'];
                                                echo number_format($total_allowance, 2);
                                                ?>
                                            </p>
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    <div class="row">
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
                    </div>
                    <!-- END FORM-->
                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>


