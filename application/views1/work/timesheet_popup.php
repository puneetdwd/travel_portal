        
                    
    <div class="form-body">
    <h4> Timesheet : <?php  $timesheet['emp_name'] ?></h4>
            <?php if(empty($timesheet)) { ?>
                <h4 class="text-center">
                    <b>No item in timesheet for date - <?php echo date('F j, Y', strtotime($date)); ?></b>
                </h4>
            <?php } else { $item_count=1;?>
                <?php foreach($timesheet as $key => $sheet) { ?>
                    <?php if($key) { ?>
                        <hr />
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="control-label col-md-3 col-md-offset-2 text-left-imp bold">Project <?php echo " ".$item_count; ?></label>
                                <label class="control-label col-md-1 text-center-imp bold">:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static bold">
                                        <?php echo $sheet['project_name']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <?php 
                    if(isset($timesheet) && !empty($timesheet)){
                        $i=1;
                    $timesheet_tasks = $this->Work_model->get_timesheet_tasks($sheet['date'], $sheet['project_id'],$sheet['employee_id']); 
                    foreach($timesheet_tasks as $tasks){ ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-md-offset-2 text-left-imp">Task <?php echo " ".$i; ?></label>
                                <label class="control-label col-md-1 text-center-imp">:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $tasks['tasks']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-md-offset-2 text-left-imp">Duration</label>
                                <label class="control-label col-md-1 text-center-imp">:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $tasks['hours'].' hours '.$tasks['minutes'].' minutes'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <?php $i++; } } ?>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-md-offset-1 text-left-imp">Challenges Faced &nbsp;&nbsp;: </label>
<!--                                                <label class="control-label col-md-1 text-center-imp">:</label>-->
                                <div class="col-md-9">
                                    <p class="form-control-static">
                                        <?php echo $sheet['challanges']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                        
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-md-offset-1 text-left-imp">Next Action Plan &nbsp;&nbsp;&nbsp;&nbsp;: </label>
<!--                                                <label class="control-label col-md-1 text-center-imp">:</label>-->
                                <div class="col-md-9">
                                    <p class="form-control-static">
                                        <?php echo $sheet['next_action']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $item_count++; } ?>
            <?php } ?>
        </div>
                   
               
           
           
       