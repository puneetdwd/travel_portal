<link href="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" ?>" rel="stylesheet" media="screen">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCdGlqSgU-wNjCn6_mig33UF5yv5QB7tqI"></script>
<!--<input id="searchTextField" type="text" size="50">-->
<div class="page-content"> 
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div style="text-align:center;margin-top: -25px;" data-original-title="" title="">
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
                <div class="col-sm-3 text-center" data-original-title="" title="">
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
                            ?>

                        </h4>
                    </label>
                </div>
                <div class="col-sm-3 text-center" ng-show="travelCardObject.travelType" data-original-title="" title="">
                    <label><h4 class="label-class ng-binding"><?php echo $request['travel_class'] ?></h4></label>
                </div>
                <div class="col-sm-3 text-center" ng-show="travelCardObject.fromLocation & amp; & amp; travelCardObject.toLocation" data-original-title="" title="">
                    <label><h4 class="label-class ng-binding"><?php echo $request['from_city_name'] . " To " . $request['to_city_name'] ?></h4></label>
                </div>
                <div class="col-sm-3 text-right" ng-show="travelCardObject.fromLocation & amp; & amp; travelCardObject.toLocation" data-original-title="" title="">
                    <a style="color:orange;text-decoration: underline" href="#emp_modal" data-toggle="modal"><?php echo $request['employee_name']; ?></a>
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
                        <?php
                        if ($request['travel_ticket'] == '1') {
                            if ($request['travel_type'] == '1') {
                                if ($request['trip_ticket'] != '1') {
                                    ?>
                                    <div class="col-md-4 portlet light bordered" style="height: 700px;">
                                        <h4 class="form-section">
                                            <spam class="cutm_lbl btn_blue">
                                                Flight Ticket
                                            </spam>
                                        </h4>
                                        <form action="<?php echo base_url('employee_request/flight_booking'); ?>" id="flight_booking" enctype="multipart/form-data" method="post" class="validate-form" role="form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!--                                                    <div class="form-group">
                                                                                                            <label class="control-label text-left-imp">Flight Provider<span class="required"> * </span>:</label>                                    
                                                                                                            <select id="flight_provider_id"  name="flight_provider_id" class="form-control required select2me"
                                                                                                                    data-placeholder="Select a Flight Provider">
                                                                                                                <option value=''></option>
                                                    <?php foreach ($service_proviers as $data) { ?>
                                                                                                                        <option value="<?php echo $data['id']; ?>">
                                                        <?php echo $data['name']; ?>
                                                                                                                        </option>
                                                    <?php } ?>
                                                                                                            </select>
                                                                                                            <label id="flight_provider_id-error" class="error" for="flight_provider_id"></label>
                                                                                                        </div>-->
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">PNR number<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="pnr_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Ticket Cost<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="cost">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Flight number<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="flight_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Comment:</label>                                                                            
                                                        <textarea class="form-control" rows="4" name="comment"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Attach<span class="required"> * </span>:</label>                                                                            
                                                        <input type="file" class="form-control required" name="flight_attachment">
                                                    </div>
                                                    <div class="form-actions">                        
                                                        <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                                        <button class="btn green" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <?php
                        if ($request['travel_ticket'] == '1') {
                            if ($request['travel_type'] == '2') {
                                if ($request['trip_ticket'] != '1') {
                                    ?>
                                    <div class="col-md-4 portlet light bordered" style="height: 700px;">
                                        <h4 class="form-section">
                                            <spam class="cutm_lbl btn_blue">
                                                Train Ticket
                                            </spam>
                                        </h4>
                                        <form action="<?php echo base_url('employee_request/train_booking'); ?>" id="train_booking" enctype="multipart/form-data" method="post" class="validate-form" role="form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!--                                                    <div class="form-group">
                                                                                                            <label class="control-label text-left-imp">Train Provider<span class="required"> * </span>:</label>                                    
                                                                                                            <select id="train_provider_id"  name="train_provider_id" class="form-control required select2me"
                                                                                                                    data-placeholder="Select a Train Provider">
                                                                                                                <option value=''></option>
                                                    <?php foreach ($service_proviers as $data) { ?>
                                                                                                                        <option value="<?php echo $data['id']; ?>">
                                                        <?php echo $data['name']; ?>
                                                                                                                        </option>
                                                    <?php } ?>
                                                                                                            </select>
                                                                                                        </div>-->
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">PNR number<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="pnr_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Ticket Cost<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="cost">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Train number<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="train_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Comment:</label>                                                                            
                                                        <textarea class="form-control" rows="4" name="comment"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Attach<span class="required"> * </span>:</label>                                                                            
                                                        <input type="file" class="form-control required" name="train_attachment">
                                                    </div>
                                                    <div class="form-actions">                        
                                                        <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                                        <button class="btn green" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <?php
                        if ($request['travel_ticket'] == '1') {
                            if ($request['travel_type'] == '3') {
                                if ($request['trip_ticket'] != '1') {
                                    ?>
                                    <div class="col-md-4 portlet light bordered" style="height: 700px;">
                                        <h4 class="form-section">
                                            <spam class="cutm_lbl btn_blue">
                                                Car Ticket
                                            </spam>
                                        </h4>
                                        <form action="<?php echo base_url('employee_request/car_ticket_booking'); ?>" id="car_ticket_booking" enctype="multipart/form-data" method="post" class="validate-form" role="form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!--                                                    <div class="form-group">
                                                                                                            <label class="control-label text-left-imp">Car Provider<span class="required"> * </span>:</label>                                    
                                                                                                            <select id="car_provider_id"  name="car_provider_id" class="form-control required select2me"
                                                                                                                    data-placeholder="Select a Car Provider">
                                                                                                                <option value=''></option>
                                                    <?php foreach ($service_proviers as $data) { ?>
                                                                                                                        <option value="<?php echo $data['id']; ?>">
                                                        <?php echo $data['name']; ?>
                                                                                                                        </option>
                                                    <?php } ?>
                                                                                                            </select>
                                                                                                        </div>-->
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Ticket Cost<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="cost">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Comment:</label>                                                                            
                                                        <textarea class="form-control" rows="4" name="comment"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Attach<span class="required"> * </span>:</label>                                                                            
                                                        <input type="file" class="form-control required" name="car_attachment">
                                                    </div>
                                                    <div class="form-actions">                        
                                                        <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                                        <button class="btn green" type="submit">Submit</button>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <?php
                        if ($request['travel_ticket'] == '1') {
                            if ($request['travel_type'] == '4') {
                                if ($request['trip_ticket'] != '1') {
                                    ?>
                                    <div class="col-md-4 portlet light bordered" style="height: 700px;">
                                        <h4 class="form-section">
                                            <spam class="cutm_lbl btn_blue">
                                                Bus Ticket
                                            </spam>
                                        </h4>
                                        <form action="<?php echo base_url('employee_request/bus_ticket_booking'); ?>" id="car_ticket_booking" enctype="multipart/form-data" method="post" class="validate-form" role="form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!--                                                    <div class="form-group">
                                                                                                            <label class="control-label text-left-imp">Bus Provider<span class="required"> * </span>:</label>                                    
                                                                                                            <select id="bus_provider_id"  name="bus_provider_id" class="form-control required select2me"
                                                                                                                    data-placeholder="Select a Bus Provider">
                                                                                                                <option value=''></option>
                                                    <?php foreach ($service_proviers as $data) { ?>
                                                                                                                        <option value="<?php echo $data['id']; ?>">
                                                        <?php echo $data['name']; ?>
                                                                                                                        </option>
                                                    <?php } ?>
                                                                                                            </select>
                                                                                                        </div>-->
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Ticket Cost<span class="required"> * </span>:</label>                                    
                                                        <input type="text" class="form-control required" name="cost">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Comment:</label>                                                                            
                                                        <textarea class="form-control" rows="4" name="comment"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label text-left-imp">Attach<span class="required"> * </span>:</label>                                                                            
                                                        <input type="file" class="form-control required" name="bus_attachment">
                                                    </div>
                                                    <div class="form-actions">                        
                                                        <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                                        <button class="btn green" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>


                        <?php
                        if ($request['accommodation'] == '1') {
                            if ($request['hotel_booking'] != '1') {
                                ?>
                                <div class="col-md-4 portlet light bordered" style="height: 700px;">
                                    <h4 class="form-section">
                                        <spam class="cutm_lbl btn_blue">
                                            Accommodation
                                        </spam>
                                    </h4>
                                    <form action="<?php echo base_url('employee_request/hotel_booking'); ?>" id="hotel_booking" enctype="multipart/form-data" method="post" class="validate-form" role="form">
                                        <div class="row">
                                            <div class="col-md-12">                                                
                                                <div class ="form-group">
                                                    <label class="control-label">Accommodation Type                                                
                                                        <span class="required"> * </span></label>
                                                    <select id="accommodation_type"  name="accommodation_type" class="form-control required select2me"
                                                            data-placeholder="Select a Accommodation Type">
                                                        <option value='1'>Hotel</option>
                                                        <option value='2'>Guest House</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Location<span class="required"> * </span>:</label>                                    
                                                    <select id="hotel_city_id"  name="city_id" class="form-control required select2me"
                                                            data-placeholder="Select a Location">
                                                        <option value=''></option>
                                                        <?php foreach ($city as $data) { ?>
                                                            <option value="<?php echo $data['id']; ?>" <?php
                                                            if ($to_city_id == $data['id']) {
                                                                echo "selected";
                                                            }
                                                            ?> > 
                                                                        <?php echo $data['name']; ?>
                                                            </option>
                                                        <?php } ?>                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Hotel/Guest House<span class="required"> * </span>:</label>                                    
                                                    <select id="hotel_provider_id"  name="hotel_provider_id" class="form-control required select2me"
                                                            data-placeholder="Select a Hotel Provider">
                                                        <option value=''></option>
                                                        <?php foreach ($hotel_category as $data) { ?>
                                                            <option value="<?php echo $data['id']; ?>">
                                                                <?php echo $data['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dtp_input1" class="control-label">Check-In Date<span class="required"> * </span></label>
                                                    <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                        <input name="check_in_date" id="check_in_date"  class="form-control required" size="16" type="text" value="" readonly>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    </div>
                                                    <label id="check_in_date-error" class="error" for="check_in_date"></label>
                                                    <!--<input type="hidden" id="dtp_input1" value="" /><br/>-->
                                                </div>
                                                <div class="form-group">
                                                    <label for="dtp_input1" class="control-label">Check-Out Date</label>
                                                    <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T018:00:07Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                        <input name="check_out_date" id="check_out_date" class="form-control" size="16" type="text" value="" readonly>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    </div>
                                                    <!--<input type="hidden" id="dtp_input1" value="" /><br/>-->
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Room No:</label>                                    
                                                    <input type="text" class="form-control" name="bill_no">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Total Cost<span class="required"> * </span>:</label>                                    
                                                    <input type="text" class="form-control required" name="cost">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Comment:</label>                                                                            
                                                    <textarea class="form-control" rows="4" name="comment"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Attach:</label>                                                                            
                                                    <input type="file" class="form-control" name="hotel_attchment">
                                                </div>
                                                <div class="form-actions">           
                                                    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                                                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                                    <button class="btn green" type="submit">Submit</button>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                        }
                        if ($request['car_hire'] == '1') {
                            if ($request['car_booking'] != '1') {
                                ?>
                                <div class="col-md-4 portlet light bordered" style="height: 700px;">
                                    <h4 class="form-section">
                                        <spam class="cutm_lbl btn_blue">
                                            Car Booking
                                        </spam>
                                    </h4>
                                    <form action="<?php echo base_url('employee_request/car_booking'); ?>" id="car_booking" enctype="multipart/form-data" method="post" class="validate-form" role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Book By<span class="required"> * </span>:</label>                                    
                                                    <select class="form-control required select2me"
                                                            data-placeholder="Select a Location">
                                                        <option value='1'>Uber</option>
                                                        <option value='2'>Ola</option>
                                                        <option value='3'>Autp</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dtp_input1" class="control-label">Pick-Up Date<span class="required"> * </span></label>
                                                    <div class="input-group date form_datetime" data-date="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>T07:00:00Z" data-date-format="yyyy-mm-dd HH:ii:ss" data-link-field="dtp_input1">
                                                        <input name="pick_up_date" id="departure_date"  class="form-control required" size="16" type="text" value="<?php echo isset($flight_request['departure_date']) ? $flight_request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?> 07:00:00" readonly>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    </div>
                                                    <label id="departure_date-error" class="error" for="departure_date"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Pick-Up Location<span class="required"> * </span>:</label>                                    
                                                    <input type="text" class="form-control required" id="pick_up_location" name="pick_up_location" value="<?php echo $request['to_city_name'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Drop-Off Location<span class="required"> * </span>:</label>                                    
                                                    <input type="text" class="form-control required" id="drop_off_location" name="drop_off_location"  value="<?php echo $request['to_city_name'] ?>">
                                                </div>
                                                <!--<div class="form-group">-->
                                                    <!--<label class="control-label text-left-imp">Cost<span class="required"> * </span>:</label>-->                                                                            
                                                <input type="hidden" class="form-control required" name="cost" value="0">
                                                <!--</div>-->
                                                <div class="form-group">
                                                    <label class="control-label text-left-imp">Attach:</label>                                                                            
                                                    <input type="file" class="form-control" name="car_attchment">
                                                </div>
                                                <div class="form-actions">                        
                                                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                                    <button class="btn green" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>                        
                </div>

            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="emp_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Employee Information</h4>
                </div>
                <div class="modal-body">
                    <table id="basicTable" class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td>Employee Id</td>
                                <td><?php echo $employee['employee_id'] ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?php echo $employee['first_name'] . " " . $employee['last_name'] ?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td><?php echo $employee['gender'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $employee['gi_email'] ?></td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td><?php echo $employee['phone'] ?></td>
                            </tr>
                            <tr>
                                <td>Ticket Cost Center</td>
                                <td><?php echo $employee['cost_center'] ?></td>
                            </tr>
                            <tr>
                                <td>Grade</td>
                                <td><?php echo $employee['grade_name'] ?></td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div><!-- /.modal-dialog -->
    </div>
    <?php
    $return_date = isset($request['return_date']) ? $request['return_date'] : '';
    if ($return_date == "0000-00-00 00:00:00") {
        $return_date = '';
    }
    ?>
    <script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
    <script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
    <script type="text/javascript">
                    $('.form_datetime').datetimepicker({
                    weekStart: 1,
                            todayBtn: 1,
                            autoclose: 1,
                            startDate: "<?php echo isset($request['departure_date']) ? $request['departure_date'] : date("Y-m-d", strtotime("+1 day")); ?>",
                            endDate: "<?php echo $return_date; ?>",
                            todayHighlight: 1,
                            startView: 2,
                            forceParse: 0,
                            showMeridian: 1
                    });
    </script>
    <script>
        $(document).ready(function() {
        initialize();
        google.maps.event.addDomListener(window, 'load', initialize);
        $('#flight_booking').validate({
        rules: {
        flight_provider_id: {
        required: true
        },
        },
                messages: {
                flight_provider_id: {
                required: 'Flight provider is required'
                },
                        pnr_number: {
                        required: 'PNR Number is required'
                        },
                        cost: {
                        required: 'Ticket Cost is required'
                        },
                        flight_number: {
                        required: 'Flight Number is required'
                        },
                        flight_attachment: {
                        required: 'Flight Attachment is required'
                        },
                }
        });
        $('#car_ticket_booking').validate({
        rules: {
        train_provider_id: {
        required: true
        },
        },
                messages: {
                train_provider_id: {
                required: 'Train provider is required'
                },
                }
        });
        $('#train_booking').validate({
        rules: {
        train_provider_id: {
        required: true
        },
        },
                messages: {
                train_provider_id: {
                required: 'Train provider is required'
                },
                }
        });
        $('#hotel_booking').validate({
        rules: {
        },
                messages: {
                city_id: {
                required: 'Location is required'
                },
                        hotel_provider_id: {
                        required: 'Hotel Provider is required'
                        },
                        check_in_date: {
                        required: 'Check-In date is required'
                        },
                        cost: {
                        required: 'Ticket Cost is required'
                        },
                        hotel_attchment: {
                        required: 'Hotel Attachment is required'
                        },
                }
        });
        $('#car_booking').validate({
        rules: {
        },
                messages: {
                car_category_id: {
                required: 'Car Category is required'
                },
                        pick_up_date: {
                        required: 'Pick-up date is required'
                        },
                        pick_up_location: {
                        required: 'Pick-up location is required'
                        },
                        drop_off_location: {
                        required: 'Drop-off location is required'
                        },
                        cost: {
                        required: 'Ticket Cost is required'
                        },
                        car_attchment: {
                        required: 'Car Attchment is required'
                        },
                }
        });
        });
        function initialize() {

        var input = document.getElementById('pick_up_location');
        var drop_off_location = document.getElementById('drop_off_location');
        var autocomplete = new google.maps.places.Autocomplete(input);
        var drop_off_location = new google.maps.places.Autocomplete(drop_off_location);
        }


    </script>

