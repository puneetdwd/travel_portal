<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Timesheet
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."work/timesheet"; ?>">
                    Manage Timesheet
                </a>
            </li>
            <li class="active">Timesheet</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> View Timesheet - <?php echo date('F j, Y', strtotime($date)); ?>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
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
                    </form>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9">
                                        <?php //if ($this->session->userdata('employee_id')===$employee_id){?>
                                        <a href="<?php echo base_url().'work/timesheet'; ?>" class="btn default">
                                            <i class="m-icon-swapleft"></i> Back 
                                        </a>
                                      <?php /* } else {?>                                     
                                            <a href="<?php echo base_url(); ?>" class="btn default">
                                                <i class="m-icon-swapleft"></i> Back 
                                            </a>
                                            <a class="btn default green" data-confirm="Are you sure you want to approve this request?"
                                                href="<?php echo base_url()."work/change_status/".$date.'/'.$employee_id.'/Approved' ;?>">
                                                <i class="fa fa-thumbs-o-up"></i> Approve
                                            </a>
                                            
                                            <a type="button" class="btn btn-danger" data-toggle="modal" href="#decline-form">
                                                <i class="fa fa-thumbs-o-down"></i> Decline
                                            </a>

                                            <div class="modal fade" id="decline-form" role="dialog">
                                                
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Reason for decline request</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="<?php echo base_url().'work/change_status/'.$date.'/'.$employee_id.'/Declined' ; ?>"  class="validate-form" method="post">
                                                                <textarea name="decline_reason" class="form-control" rows="3" cols="28"></textarea>                               
                                                                <div style="margin-top:10px;">
                                                                    <button class="btn green" type="submit"  style="margin-left:50px;">Submit</button>
                                                                    <a href="<?php echo base_url(); ?>" class="btn default">Cancel</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                     
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <?php } */ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <!-- END FORM-->
                </div>
            </div>
            
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>