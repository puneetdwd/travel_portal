<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Timesheet
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Timesheet</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered manage-timesheet-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Timesheet form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post" id="policy-add-form">
                        
                        <input type="hidden" name="total_hours" id="total_hours" value="1" />
                        <input type="hidden" name="total_minutes" id="total_minutes" value="0" />
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <?php if(isset($timesheet['id'])) { ?>
                                <input type="hidden" id="edit-policy" name="id" value="<?php echo $timesheet['id']; ?>" />
                            <?php } ?>

                            <div class="row" <?php if($leave_flag) { ?>style="display:none;"<?php } ?>>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date
                                        <span class="required"> * </span></label>
                                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" 
                                             data-date-start-date="-3d" >
                                            <input name="date" id="date" type="text" class="required form-control" readonly
                                            value="<?php echo isset($timesheet[0]['date']) ? $timesheet[0]['date'] : $date; ?>">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" id="timesheet-for-error">
                                        <label class="control-label">Type
                                        <span class="required"> * </span></label>
                                        <?php $timesheet_for = isset($timesheet[0]['timesheet_for']) ? $timesheet[0]['timesheet_for'] : ''; ?>
                                        <div class="radio-list" data-error-container="#timesheet-for-error">
                                            <label class="radio-inline">
                                            <input type="radio" name="timesheet_for" class="timesheet-register-for required" 
                                            value="working" <?php if($timesheet_for === 'working' || $timesheet_for === '') { ?>checked="checked"<?php } ?>> Working </label>
                                            <label class="radio-inline">
                                            <input type="radio" name="timesheet_for" class="timesheet-register-for required" 
                                            value="holiday" <?php if($timesheet_for === 'holiday') { ?>checked="checked"<?php } ?>> Holiday </label>
                                            <!--
                                            <label class="radio-inline">
                                            <input type="radio" name="timesheet_for" class="timesheet-register-for required" 
                                            value="on_leave" <?php if($timesheet_for === 'on_leave') { ?>checked<?php } ?>> On Leave </label>
                                            -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" <?php if(!$leave_flag) { ?>style="display:none;"<?php } ?>>
                                <div class="col-md-12 text-center">
                                    <p class="text-danger">You have applied leave for this date i.e. <?php echo $cur_date; ?></p>
                                </div>
                            </div>
                            
                            <div class="project-items" style="margin-bottom:20px;<?php if($leave_flag || $timesheet_for == 'holiday') { ?>display:none;<?php } ?>" >
                            <?php $item_count = 0; 
                            do{ ?>
                            <div id="project-line-items"  style="border-top: 2px solid #dfdfdf; padding-top: 10px; padding-bottom: 50px;"
                            class="common_extra <?php if($item_count > 0){ echo 'project-line-item-'.$item_count; } ?>" >
                            <div class="row manage-timesheet-project">
                                <?php
                                if(isset($timesheet) && !empty($timesheet)){
                                $timesheet_tasks_count = $this->Work_model->get_timesheet_tasks_count($timesheet[$item_count]['date'], $timesheet[$item_count]['project_id'],$timesheet[$item_count]['employee_id']);
                                }else{
                                    $timesheet_tasks_count=0;
                                }?>
                                <input type="hidden" class="tasks_count" name="tasks_count[]" <?php if($timesheet_tasks_count > 0){ ?> value="<?php echo $timesheet_tasks_count;?>" <?php }else{ ?> value="1" <?php } ?> >
                                
                                <?php $project_val = isset($timesheet[$item_count]['project_id']) ? $timesheet[$item_count]['project_id'] : ''; ?>
                                
                                <input type="hidden" name="project_id_hidden[]" value="<?php echo $project_val; ?>" >
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Project
                                        <span class="required"> * </span></label>
                                        <select id="policy-form-company" name="project_id[]" class="form-control required select2me"
                                        data-placeholder="Select a Project" required="required">
                                            <option></option>
                                            
                                            <?php foreach($projects as $project) { ?>
                                                <option value="<?php echo $project['id']; ?>"
                                                    <?php if($project_val == $project['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $project['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="items" style="margin-bottom:20px;">
                            
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="control-label" for="dashboard"> Report/Dashboard/Module:
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="dashboard[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['dashboard']) ? $timesheet[$item_count]['dashboard'] : ''; ?>" >
                                </div>
                                <div class="col-md-6 ">
                                    <label class="control-label" for="phase"> Phase:
                                    <span class="required"> * </span></label>
                                    <select id="policy-form-company" name="phase[]" class="form-control required" required="required"
                                            data-placeholder="Phase - Study/BluePrint/Build" onchange="return others_text_box('.other_phase_div', this);">
                                        <option value="" ></option>
                                        <?php foreach($drop_downs as $drop_down){ 
                                              if($drop_down['drop_down_name'] == 'Phase'){
                                        ?>
                                                <option value="<?php echo $drop_down['drop_down_list']; ?>" 
                                                <?php if(@$timesheet[$item_count]['phase']== $drop_down['drop_down_list']){ ?> selected="selected" <?php } ?> >
                                                            <?php echo $drop_down['drop_down_list'];  ?>
                                                </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                                
                            <div class="row other_phase_div" style="display:none;">
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 ">
                                    <label class="control-label" for="others_phase"> Phase(Others):
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="others_phase[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['others_phase']) ? $timesheet[$item_count]['others_phase'] : ''; ?>" >
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="action_type"> Action Type For Development:
                                    <span class="required"> * </span></label>
                                    <select name="action_type[]" class="form-control required" required="required"
                                        data-placeholder="Action Type For Development">
                                        <option value="" ></option>
                                        <?php foreach($drop_downs as $drop_down){ 
                                              if($drop_down['drop_down_name'] == 'Action Type'){
                                        ?>
                                                <option value="<?php echo $drop_down['drop_down_list']; ?>" 
                                                <?php if(@$timesheet[$item_count]['action_type']== $drop_down['drop_down_list']){ ?> selected="selected" <?php } ?> >
                                                            <?php echo $drop_down['drop_down_list'];  ?>
                                                </option>
                                        <?php } } ?>

                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="challenge_type"> Challenge Type:
                                    <span class="required"> * </span></label>
                                    <select id="policy-form-company" name="challenge_type[]" class="form-control required" required="required"
                                        data-placeholder="Challenge Type" onchange="return others_text_box('.other_challenge_type_div', this);">
                                        <option value="" ></option>
                                        <?php foreach($drop_downs as $drop_down){ 
                                              if($drop_down['drop_down_name'] == 'Challenge Type'){
                                        ?>
                                                <option value="<?php echo $drop_down['drop_down_list']; ?>" 
                                                <?php if(@$timesheet[$item_count]['challenge_type']== $drop_down['drop_down_list']){ ?> selected="selected" <?php } ?> >
                                                            <?php echo $drop_down['drop_down_list'];  ?>
                                                </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                
                            </div>
                                
                            <div class="row other_challenge_type_div" style="display:none;">
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 ">
                                    <label class="control-label" for="others_challenge_type"> Challenge Type(Others):
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="others_challenge_type[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['others_challenge_type']) ? $timesheet[$item_count]['others_challenge_type'] : ''; ?>" >
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="time_wait"> Time Wait Due To Challenge:
                                    <span class="required"> * </span></label>
                                    <select id="policy-form-company" name="time_wait[]" class="form-control required" required="required"
                                        data-placeholder="Time Wait Due To Challenge">
                                        <option value="" ></option>
                                        <option value="NA" <?php if(@$timesheet[$item_count]['time_wait']== 'NA'){ ?> selected="selected" <?php } ?> > 
                                            NA</option>
                                        <option value="00:15" <?php if(@$timesheet[$item_count]['time_wait']== '00:15'){ ?> selected="selected" <?php } ?> > 
                                            00:15 Hrs</option>
                                        <option value="00:30" <?php if(@$timesheet[$item_count]['time_wait']== '00:30'){ ?> selected="selected" <?php } ?> > 
                                            00:30 Hrs</option>
                                        <option value="00:45" <?php if(@$timesheet[$item_count]['time_wait']== '00:45'){ ?> selected="selected" <?php } ?> > 
                                            00:45 Hrs</option>
                                        <option value="01:00" <?php if(@$timesheet[$item_count]['time_wait']== '01:00'){ ?> selected="selected" <?php } ?> > 
                                            01:00 Hrs</option>
                                        <option value="01:15" <?php if(@$timesheet[$item_count]['time_wait']== '01:15'){ ?> selected="selected" <?php } ?> > 
                                            01:15 Hrs</option>
                                        <option value="01:30" <?php if(@$timesheet[$item_count]['time_wait']== '01:30'){ ?> selected="selected" <?php } ?> > 
                                            01:30 Hrs</option>
                                        <option value="01:45" <?php if(@$timesheet[$item_count]['time_wait']== '01:45'){ ?> selected="selected" <?php } ?> > 
                                            01:45 Hrs</option>
                                        <option value="02:00" <?php if(@$timesheet[$item_count]['time_wait']== '02:00'){ ?> selected="selected" <?php } ?> > 
                                            02:00 Hrs</option>
                                        <option value="02:15" <?php if(@$timesheet[$item_count]['time_wait']== '02:15'){ ?> selected="selected" <?php } ?> > 
                                            02:15 Hrs</option>
                                        <option value="02:30" <?php if(@$timesheet[$item_count]['time_wait']== '02:30'){ ?> selected="selected" <?php } ?> > 
                                            02:30 Hrs</option>
                                        <option value="02:45" <?php if(@$timesheet[$item_count]['time_wait']== '02:45'){ ?> selected="selected" <?php } ?> > 
                                            02:45 Hrs</option>
                                        <option value="03:00" <?php if(@$timesheet[$item_count]['time_wait']== '03:00'){ ?> selected="selected" <?php } ?> > 
                                            03:00 Hrs</option>
                                        <option value="03:15" <?php if(@$timesheet[$item_count]['time_wait']== '03:15'){ ?> selected="selected" <?php } ?> > 
                                            03:15 Hrs</option>
                                        <option value="03:30" <?php if(@$timesheet[$item_count]['time_wait']== '03:30'){ ?> selected="selected" <?php } ?> > 
                                            03:30 Hrs</option>
                                        <option value="03:45" <?php if(@$timesheet[$item_count]['time_wait']== '03:45'){ ?> selected="selected" <?php } ?> > 
                                            03:45 Hrs</option>
                                        <option value="04:00" <?php if(@$timesheet[$item_count]['time_wait']== '04:00'){ ?> selected="selected" <?php } ?> > 
                                            04:00 Hrs</option>
                                        <option value="04:15" <?php if(@$timesheet[$item_count]['time_wait']== '04:15'){ ?> selected="selected" <?php } ?> > 
                                            04:15 Hrs</option>
                                        <option value="04:30" <?php if(@$timesheet[$item_count]['time_wait']== '04:30'){ ?> selected="selected" <?php } ?> > 
                                            04:30 Hrs</option>
                                        <option value="04:45" <?php if(@$timesheet[$item_count]['time_wait']== '04:45'){ ?> selected="selected" <?php } ?> > 
                                            04:45 Hrs</option>
                                        <option value="05:00" <?php if(@$timesheet[$item_count]['time_wait']== '05:00'){ ?> selected="selected" <?php } ?> > 
                                            05:00 Hrs</option>
                                        <option value="05:15" <?php if(@$timesheet[$item_count]['time_wait']== '05:15'){ ?> selected="selected" <?php } ?> > 
                                            05:15 Hrs</option>
                                        <option value="05:30" <?php if(@$timesheet[$item_count]['time_wait']== '05:30'){ ?> selected="selected" <?php } ?> > 
                                            05:30 Hrs</option>
                                        <option value="05:45" <?php if(@$timesheet[$item_count]['time_wait']== '05:45'){ ?> selected="selected" <?php } ?> > 
                                            05:45 Hrs</option>
                                        <option value="06:00" <?php if(@$timesheet[$item_count]['time_wait']== '06:00'){ ?> selected="selected" <?php } ?> > 
                                            06:00 Hrs</option>
                                        <option value="06:15" <?php if(@$timesheet[$item_count]['time_wait']== '06:15'){ ?> selected="selected" <?php } ?> > 
                                            06:15 Hrs</option>
                                        <option value="06:30" <?php if(@$timesheet[$item_count]['time_wait']== '06:30'){ ?> selected="selected" <?php } ?> > 
                                            06:30 Hrs</option>
                                        <option value="06:45" <?php if(@$timesheet[$item_count]['time_wait']== '06:45'){ ?> selected="selected" <?php } ?> > 
                                            06:45 Hrs</option>
                                        <option value="07:00" <?php if(@$timesheet[$item_count]['time_wait']== '07:00'){ ?> selected="selected" <?php } ?> > 
                                            07:00 Hrs</option>
                                        <option value="07:15" <?php if(@$timesheet[$item_count]['time_wait']== '07:15'){ ?> selected="selected" <?php } ?> > 
                                            07:15 Hrs</option>
                                        <option value="07:30" <?php if(@$timesheet[$item_count]['time_wait']== '07:30'){ ?> selected="selected" <?php } ?> > 
                                            07:30 Hrs</option>
                                        <option value="07:45" <?php if(@$timesheet[$item_count]['time_wait']== '07:45'){ ?> selected="selected" <?php } ?> > 
                                            07:45 Hrs</option>
                                        <option value="08:00" <?php if(@$timesheet[$item_count]['time_wait']== '08:00'){ ?> selected="selected" <?php } ?> > 
                                            08:00 Hrs</option>
                                        <option value="08:15" <?php if(@$timesheet[$item_count]['time_wait']== '08:15'){ ?> selected="selected" <?php } ?> > 
                                            08:15 Hrs</option>
                                        <option value="08:30" <?php if(@$timesheet[$item_count]['time_wait']== '08:30'){ ?> selected="selected" <?php } ?> > 
                                            08:30 Hrs</option>
                                        <option value="08:45" <?php if(@$timesheet[$item_count]['time_wait']== '08:45'){ ?> selected="selected" <?php } ?> > 
                                            08:45 Hrs</option>
                                        <option value="09:00" <?php if(@$timesheet[$item_count]['time_wait']== '09:00'){ ?> selected="selected" <?php } ?> > 
                                            09:00 Hrs</option>
                                        <option value="09:15" <?php if(@$timesheet[$item_count]['time_wait']== '09:15'){ ?> selected="selected" <?php } ?> > 
                                            09:15 Hrs</option>
                                        <option value="09:30" <?php if(@$timesheet[$item_count]['time_wait']== '09:30'){ ?> selected="selected" <?php } ?> > 
                                            09:30 Hrs</option>
                                        <option value="09:45" <?php if(@$timesheet[$item_count]['time_wait']== '09:45'){ ?> selected="selected" <?php } ?> > 
                                            09:45 Hrs</option>
                                        <option value="10:00" <?php if(@$timesheet[$item_count]['time_wait']== '10:00'){ ?> selected="selected" <?php } ?> > 
                                            10:00 Hrs</option>
                                        <option value="10:15" <?php if(@$timesheet[$item_count]['time_wait']== '10:15'){ ?> selected="selected" <?php } ?> > 
                                            10:15 Hrs</option>
                                        <option value="10:30" <?php if(@$timesheet[$item_count]['time_wait']== '10:30'){ ?> selected="selected" <?php } ?> > 
                                            10:30 Hrs</option>
                                        <option value="10:45" <?php if(@$timesheet[$item_count]['time_wait']== '10:45'){ ?> selected="selected" <?php } ?> > 
                                            10:45 Hrs</option>
                                        <option value="11:00" <?php if(@$timesheet[$item_count]['time_wait']== '11:00'){ ?> selected="selected" <?php } ?> > 
                                            11:00 Hrs</option>
                                        <option value="11:15" <?php if(@$timesheet[$item_count]['time_wait']== '11:15'){ ?> selected="selected" <?php } ?> > 
                                            11:15 Hrs</option>
                                        <option value="11:30" <?php if(@$timesheet[$item_count]['time_wait']== '11:30'){ ?> selected="selected" <?php } ?> > 
                                            11:30 Hrs</option>
                                        <option value="11:45" <?php if(@$timesheet[$item_count]['time_wait']== '11:45'){ ?> selected="selected" <?php } ?> > 
                                            11:45 Hrs</option>
                                        <option value="12:00" <?php if(@$timesheet[$item_count]['time_wait']== '12:00'){ ?> selected="selected" <?php } ?> > 
                                            12:00 Hrs</option>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="task_status"> Task Status:
                                    <span class="required"> * </span></label>
                                    <select id="policy-form-company" name="task_status[]" class="form-control required" required="required"
                                        data-placeholder="Task Status">
                                        <option value="" ></option>
                                        <?php foreach($drop_downs as $drop_down){ 
                                              if($drop_down['drop_down_name'] == 'Task Status'){
                                        ?>
                                                <option value="<?php echo $drop_down['drop_down_list']; ?>" 
                                                <?php if(@$timesheet[$item_count]['task_status']== $drop_down['drop_down_list']){ ?> selected="selected" <?php } ?> >
                                                            <?php echo $drop_down['drop_down_list'];  ?>
                                                </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                
                            </div>
                                
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="assigned_to"> Assigned To:
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="assigned_to[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['assigned_to']) ? $timesheet[$item_count]['assigned_to'] : ''; ?>" >
                                </div>
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="action_on"> Action On:
                                    <span class="required"> * </span></label>
                                    <select id="policy-form-company" name="action_on[]" class="form-control required" required="required"
                                        data-placeholder="Action On" onchange="return others_text_box('.other_action_on_div', this);">
                                        <option value="" ></option>
                                        <?php foreach($drop_downs as $drop_down){ 
                                              if($drop_down['drop_down_name'] == 'Action On'){
                                        ?>
                                                <option value="<?php echo $drop_down['drop_down_list']; ?>" 
                                                <?php if(@$timesheet[$item_count]['action_on']== $drop_down['drop_down_list']){ ?> selected="selected" <?php } ?> >
                                                            <?php echo $drop_down['drop_down_list'];  ?>
                                                </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row other_action_on_div" style="display:none;">
                                <div class="col-md-6 "></div>
                                <div class="col-md-6 ">
                                    <label class="control-label" for="others_action_on"> Action On(Others):
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="others_action_on[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['others_action_on']) ? $timesheet[$item_count]['others_action_on'] : ''; ?>" >
                                    
                                </div>
                            </div>
                            
                                <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label class="control-label"  for="challanges"> Challenges Faced:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="challanges[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['challanges']) ? $timesheet[$item_count]['challanges'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label class="control-label"  for="challange_sol"> Solution of Challenge:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="challenges_sol[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['challenges_sol']) ? $timesheet[$item_count]['challenges_sol'] : ''; ?>" >
                                    </div>
                                </div>
                            </div>
                                
                            <?php 
                            if(isset($timesheet) && !empty($timesheet)){
                                $timesheet_tasks = $this->Work_model->get_timesheet_tasks($timesheet[$item_count]['date'], $timesheet[$item_count]['project_id'],$timesheet[$item_count]['employee_id']); 
                            $a=0;
                            foreach($timesheet_tasks as $timesheet_task){
                            ?>
                            <div id="line-items">

                                <div class="row manage-timesheet-project-fields" id="tasks-line-0" >
                                    <input type="hidden" name="timesheet_id[]" value="<?php if(isset($timesheet_task['id'])){ echo $timesheet_task['id'];} ?>" />
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="hours">Task
                                            <span class="required">*</span></label>
                                            <input type="text" class="required form-control" name="tasks[]" required="required"
                                            value="<?php echo isset($timesheet_task['tasks']) ? $timesheet_task['tasks'] : ''; ?>" >
                                            <span class="help-block">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="hours">Hours
                                        <span class="required">*</span></label>
                                        <select id="policy-form-company" name="hours[]" class="form-control required"
                                        data-placeholder="Hours" required="required">
                                            <?php if($a == 0){ $ck = 1;} else{ $ck = 0;} ?>
                                            <?php for($i=0;$i<=12;$i++){ ?>
                                            <option value="<?php echo $i; ?>" 
                                            <?php if($timesheet_task['hours']==$i){ ?> selected="selected" <?php } ?> > 
                                                <?php echo $i; ?> 
                                            </option>
                                            <?php } ?>
                                        </select>
                                        
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                    <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="minutes">Minutes
                                        <span class="required">*</span></label>
                                        <select id="policy-form-company" name="minutes[]" class="form-control required"
                                        data-placeholder="Minutes" required="required">
                                            <?php //for($i=0;$i<=45;$i++){ ?>
                                            <option value="0" <?php if($timesheet_task['minutes']== 0){ ?> selected="selected" <?php } ?> >00</option>
                                            <option value="15" <?php if($timesheet_task['minutes']== 15){ ?> selected="selected" <?php } ?> >15</option>
                                            <option value="30" <?php if($timesheet_task['minutes']== 30){ ?> selected="selected" <?php } ?> >30</option>
                                            <option value="45" <?php if($timesheet_task['minutes']== 45){ ?> selected="selected" <?php } ?> >45</option>
                                            <?php //} ?>
                                        </select>
                                        
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                <?php if($a > 0){ ?>  
                                <div class="col-md-12 invoice-item-remove text-right">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-xs red remove-item" onclick="return remove_tasks(this);">
                                            <i class="fa fa-minus"></i> Delete Task
                                        </button>
                                    </div>
                                </div>
                                <?php } ?>
                                </div>
                                
                            </div>
                                
                            <?php $a++; }
                                }else{ ?>
                            
                            <div id="line-items">

                                <div class="row manage-timesheet-project-fields" id="tasks-line-0" >
                                    <input type="hidden" name="timesheet_id[]" value="" />
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="hours">Task
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="tasks[]" value="" required="required" >
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                    <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="hours">Hours
                                        <span class="required">*</span></label>
                                        <select id="policy-form-company" name="hours[]" class="form-control required"
                                                data-placeholder="Hours" required="required" onchange="return calculate_hours(this);">
                                            <?php for($i=0;$i<=12;$i++){ ?>
                                            <option value="<?php echo $i; ?>" > 
                                                <?php echo $i; ?> 
                                            </option>
                                            <?php } ?>
                                        </select>
                                        
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="minutes">Minutes
                                        <span class="required">*</span></label>
                                        <select id="policy-form-company" name="minutes[]" class="form-control required"
                                            data-placeholder="Minutes" onchange="return calculate_hours(this);">
                                            <?php //for($i=0;$i<=59;$i++){ ?>
                                            <option value="0" >00</option>
                                            <option value="15" >15</option>
                                            <option value="30" >30</option>
                                            <option value="45" >45</option>
                                            <?php //} ?>
                                        </select>
                                        
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                </div>
                                
                            </div>    
                                
                            <?php }?>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-xs green" onclick="return tasks(this);">
                                        <i class="fa fa-plus"></i> Add Tasks
                                    </button>
                                </div>
                            </div>
                                
                            
                            
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="control-label"  for="customer_feedback"> Customer Feedback:
                                    <span class="required"> * </span></label>
                                    <select id="policy-form-company" name="customer_feedback[]" class="form-control required" required="required"
                                        data-placeholder="Customer Feedback" onchange="return others_text_box('.other_customer_feedback_div', this);">
                                        <option value="" ></option>
                                        <?php foreach($drop_downs as $drop_down){ 
                                              if($drop_down['drop_down_name'] == 'Customer Feedback'){
                                        ?>
                                                <option value="<?php echo $drop_down['drop_down_list']; ?>" 
                                                <?php if(@$timesheet[$item_count]['customer_feedback']== $drop_down['drop_down_list']){ ?> selected="selected" <?php } ?> >
                                                            <?php echo $drop_down['drop_down_list'];  ?>
                                                </option>
                                        <?php } } ?>
                                        
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label"  for="remarks"> Remarks(If Any):
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="remarks[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['remarks']) ? $timesheet[$item_count]['remarks'] : ''; ?>" >
                                </div>
                            </div>
                                
                            <div class="row other_customer_feedback_div" style="display:none;">
                                <div class="col-md-6 ">
                                    <label class="control-label" for="others_customer_feedback"> Customer Feedback(Others):
                                    <span class="required"> * </span></label>
                                    <input type="text" class="required form-control" name="others_customer_feedback[]" required="required"
                                           value="<?php echo isset($timesheet[$item_count]['others_customer_feedback']) ? $timesheet[$item_count]['others_customer_feedback'] : ''; ?>" >
                                    
                                </div>
                                <div class="col-md-6 "></div>
                            </div>
                                
                            <div class="form-group">
                                <label class="control-label"  for="next_action"> Next Action Plan:
                                <span class="required">*</span></label>
                                <textarea class="required form-control" name="next_action[]" required="required"><?php echo isset($timesheet[$item_count]['next_action']) ? $timesheet[$item_count]['next_action'] : ''; ?></textarea>
                            </div>
                            
                            </div>
                                
                            
                                
                            <?php if(isset($timesheet) && $item_count > 0){ ?>
                                    
                            <div class="col-md-12 project-item-remove text-right" style="padding: 0;">
                                <div class="form-group">
                                    <button type="button" class="btn btn-xs red project-remove-item" onclick="return remove_project(this);">
                                        <i class="fa fa-minus"></i> Delete Project
                                    </button>
                                </div>
                            </div>
                            <?php } ?>    
                            
                            </div>
                            <?php
                                $item_count++;
                                } while($item_count < sizeof(@$timesheet) )
                            ?>
                            </div>
                                <?php //if(!isset($timesheet)){ ?>
                            <div class="row add-more-projects" <?php if($leave_flag || $timesheet_for == 'holiday') { ?>style="display:none;"<?php } ?>>
                                <div class="col-md-12 text-right">
                                    <button type="button" id="project-add-line-item" class="btn btn-xs green" onclick="return projects(this);">
                                        <i class="fa fa-plus"></i> Add Project
                                    </button>
                                </div>
                            </div><br>
                            
                            <div class="row reason-row" <?php if($timesheet_for !== 'holiday') { ?>style="display:none;"<?php } ?>>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="reason"> Reason:
                                        <span class="required">*</span></label>
                                        <textarea class="required form-control" name="reason"><?php echo isset($timesheet[0]['next_action']) ? $timesheet[0]['next_action'] : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                                <?php //} ?>
                            <div class="form-actions" <?php if($leave_flag) { ?>style="display:none;"<?php } ?>>
                                <button class="btn green" type="submit">Submit</button>
                                <a href="<?php echo base_url().'work/timesheet'; ?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </form>
 
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
    
<!--Tasks Clone Starts-->
<div id="line-item-clone" style="display:none;">
<div class="line-item">
<div class="manage-timesheet-project-fields">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="tasks">Task
            <span class="required">*</span></label>
            <input type="text" class="required form-control" name="tasks[]" value="" required="required">
            <span class="help-block">
            </span>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="form-group">
            <label class="control-label" for="hours">Hours
            <span class="required">*</span></label>
            <select name="hours[]" class="form-control required"
            data-placeholder="Hours" required="required">
                <?php for($i=0;$i<=12;$i++){ ?>
                <option value="<?php echo $i; ?>" > <?php echo $i; ?> </option>
                <?php } ?>
            </select>

            <span class="help-block">
            </span>
        </div>
    </div>

    <div class="col-md-3 col-xs-6">
        <div class="form-group">
            <label class="control-label" for="minutes">Minutes
            <span class="required">*</span></label>
            <select name="minutes[]" class="form-control required"
            data-placeholder="Minutes" required="required">
                <?php /* for($i=0;$i<=59;$i++){ ?>
                <option value="<?php echo $i; ?>" > <?php echo $i; ?> </option>
                <?php } */ ?>
                
                <option value="0" >00</option>
                <option value="15" >15</option>
                <option value="30" >30</option>
                <option value="45" >45</option>
            </select>

            <span class="help-block">
            </span>
        </div>
    </div>
    
    <div class="col-md-12 invoice-item-remove new-item text-right">
        <div class="form-group">
            <button type="button" class="btn btn-xs red remove-item" onclick="return remove_tasks(this);">
                <i class="fa fa-minus"></i> Delete Task
            </button>
        </div>
    </div>
</div>
</div>
</div>
<!--Tasks Clone Starts-->


<!--Project Clone Starts-->
    
<div id="project-line-item-clone" style="display:none;">
    <div class="project-line-item" style="border-top: 2px solid #dfdfdf; padding-top: 10px; padding-bottom: 50px;">
        <div class="row manage-timesheet-project">
            <input type="hidden" class="tasks_count" name="tasks_count[]" value="1" >
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Project
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="project_id[]" class="form-control required"
                    data-placeholder="Select a Project" required="required">
                        <option></option>
                        <?php foreach($projects as $project) { ?>
                            <option value="<?php echo $project['id']; ?>" >
                                <?php echo $project['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    
                </div>
            </div>
        </div>

        <div class="items1" style="margin-bottom:20px;">
            
                        <div class="row">
                <div class="col-md-6 ">
                    <label class="control-label" for="dashboard"> Report/Dashboard/Module:
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="dashboard[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['dashboard']) ? $timesheet[$item_count]['dashboard'] : ''; ?>" >
                </div>
                <div class="col-md-6 ">
                    <label class="control-label" for="phase"> Phase
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="phase[]" class="form-control required" required="required"
                        data-placeholder="Phase - Study/BluePrint/Build" onchange="return others_text_box('.other_phase_div_1', this);">
                        <option value="" ></option>
                        <?php foreach($drop_downs as $drop_down){ 
                              if($drop_down['drop_down_name'] == 'Phase'){
                        ?>
                        <option value="<?php echo $drop_down['drop_down_list']; ?>" ><?php echo $drop_down['drop_down_list'];  ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            
            <div class="row other_phase_div_1" style="display:none;">
                <div class="col-md-6 "></div>
                <div class="col-md-6 ">
                    <label class="control-label" for="others_phase"> Phase(Others):
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="others_phase[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['others_phase']) ? $timesheet[$item_count]['others_phase'] : ''; ?>" >

                </div>
            </div>

            <div class="row">
                <div class="col-md-6 ">
                    <label class="control-label"  for="action_type"> Action Type For Development:
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="action_type[]" class="form-control required" required="required"
                        data-placeholder="Action Type For Development">
                        <option value="" ></option>
                        <?php foreach($drop_downs as $drop_down){ 
                            if($drop_down['drop_down_name'] == 'Action Type'){
                        ?>
                              <option value="<?php echo $drop_down['drop_down_list']; ?>" ><?php echo $drop_down['drop_down_list'];  ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-6 ">
                    <label class="control-label"  for="challenge_type"> Challenge Type:
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="challenge_type[]" class="form-control required" required="required"
                        data-placeholder="Challenge Type" onchange="return others_text_box('.other_challenge_type_div_1', this);">
                        <option value="" ></option>
                        <?php foreach($drop_downs as $drop_down){ 
                              if($drop_down['drop_down_name'] == 'Challenge Type'){
                        ?>
                        <option value="<?php echo $drop_down['drop_down_list']; ?>" ><?php echo $drop_down['drop_down_list'];  ?></option>
                        <?php } } ?>
                    </select>
                </div>

            </div>
            
            <div class="row other_challenge_type_div_1" style="display:none;">
                <div class="col-md-6 "></div>
                <div class="col-md-6 ">
                    <label class="control-label" for="others_challenge_type"> Challenge Type(Others):
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="others_challenge_type[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['others_challenge_type']) ? $timesheet[$item_count]['others_challenge_type'] : ''; ?>" >

                </div>
            </div>

            <div class="row">
                <div class="col-md-6 ">
                    <label class="control-label"  for="time_wait"> Time Wait Due To Challenge:
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="time_wait[]" class="form-control required" required="required"
                        data-placeholder="Time Wait Due To Challenge">
                        <option value="" ></option>
                        <option value="00:15" >00:15 Hrs</option>
                        <option value="00:30" >00:30 Hrs</option>
                        <option value="00:45" >00:45 Hrs</option>
                        <option value="01:00" >01:00 Hrs</option>
                        <option value="01:15" >01:15 Hrs</option>
                        <option value="01:30" >01:30 Hrs</option>
                        <option value="01:45" >01:45 Hrs</option>
                        <option value="02:00" >02:00 Hrs</option>
                        <option value="02:15" >02:15 Hrs</option>
                        <option value="02:30" >02:30 Hrs</option>
                        <option value="02:45" >02:45 Hrs</option>
                        <option value="03:00" >03:00 Hrs</option>
                        <option value="03:15" >03:15 Hrs</option>
                        <option value="03:30" >03:30 Hrs</option>
                        <option value="03:45" >03:45 Hrs</option>
                        <option value="04:00" >04:00 Hrs</option>
                        <option value="04:15" >04:15 Hrs</option>
                        <option value="04:30" >04:30 Hrs</option>
                        <option value="04:45" >04:45 Hrs</option>
                        <option value="05:00" >05:00 Hrs</option>
                        <option value="05:15" >05:15 Hrs</option>
                        <option value="05:30" >05:30 Hrs</option>
                        <option value="05:45" >05:45 Hrs</option>
                        <option value="06:00" >06:00 Hrs</option>
                        <option value="06:15" >06:15 Hrs</option>
                        <option value="06:30" >06:30 Hrs</option>
                        <option value="06:45" >06:45 Hrs</option>
                        <option value="07:00" >07:00 Hrs</option>
                        <option value="07:15" >07:15 Hrs</option>
                        <option value="07:30" >07:30 Hrs</option>
                        <option value="07:45" >07:45 Hrs</option>
                        <option value="08:00" >08:00 Hrs</option>
                        <option value="08:15" >08:15 Hrs</option>
                        <option value="08:30" >08:30 Hrs</option>
                        <option value="08:45" >08:45 Hrs</option>
                        <option value="09:00" >09:00 Hrs</option>
                        <option value="09:15" >09:15 Hrs</option>
                        <option value="09:30" >09:30 Hrs</option>
                        <option value="09:45" >09:45 Hrs</option>
                        <option value="10:00" >10:00 Hrs</option>
                        <option value="09:15" >10:15 Hrs</option>
                        <option value="09:30" >10:30 Hrs</option>
                        <option value="09:45" >10:45 Hrs</option>
                        <option value="10:00" >11:00 Hrs</option>
                        <option value="09:15" >11:15 Hrs</option>
                        <option value="09:30" >11:30 Hrs</option>
                        <option value="09:45" >11:45 Hrs</option>
                        <option value="09:45" >12:00 Hrs</option>
                    </select>
                </div>
                <div class="col-md-6 ">
                    <label class="control-label"  for="task_status"> Task Status:
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="task_status[]" class="form-control required" required="required"
                        data-placeholder="Task Status">
                        <option value="" ></option>
                        <?php foreach($drop_downs as $drop_down){ 
                            if($drop_down['drop_down_name'] == 'Task Status'){
                        ?>
                              <option value="<?php echo $drop_down['drop_down_list']; ?>" ><?php echo $drop_down['drop_down_list'];  ?></option>
                        <?php } } ?>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 ">
                    <label class="control-label"  for="assigned_to"> Assigned To:
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="assigned_to[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['assigned_to']) ? $timesheet[$item_count]['assigned_to'] : ''; ?>" >
                </div>
                <div class="col-md-6 ">
                    <label class="control-label"  for="action_on"> Action On:
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="action_on[]" class="form-control required" required="required"
                        data-placeholder="Action On" onchange="return others_text_box('.other_action_on_div_1', this);">
                        <option value="" ></option>
                        <?php foreach($drop_downs as $drop_down){ 
                              if($drop_down['drop_down_name'] == 'Action On'){
                        ?>
                        <option value="<?php echo $drop_down['drop_down_list']; ?>" ><?php echo $drop_down['drop_down_list'];  ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            
            <div class="row other_action_on_div_1" style="display:none;">
                <div class="col-md-6 "></div>
                <div class="col-md-6 ">
                    <label class="control-label" for="others_action_on"> Action On(Others):
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="others_action_on[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['others_action_on']) ? $timesheet[$item_count]['others_action_on'] : ''; ?>" >

                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label class="control-label"  for="challanges"> Challenges Faced:
                        <span class="required">*</span></label>
                        <input type="text" class="required form-control" name="challanges[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['challanges']) ? $timesheet[$item_count]['challanges'] : ''; ?>" >
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label class="control-label"  for="challange_sol"> Solution of Challenge:
                        <span class="required">*</span></label>
                        <input type="text" class="required form-control" name="challenges_sol[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['challenges_sol']) ? $timesheet[$item_count]['challenges_sol'] : ''; ?>" >
                    </div>
                </div>
            </div>
            
            <div id="line-items1">

                <div class="row manage-timesheet-project-fields" >
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="hours">Task
                            <span class="required">*</span></label>
                            <input type="text" class="required form-control" name="tasks[]" value="" required="required" >
                            <span class="help-block">
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="hours">Hours
                            <span class="required">*</span></label>
                            <select name="hours[]" class="form-control required"
                            data-placeholder="Hours" required="required">
                                <?php for($i=0;$i<=12;$i++){ ?>
                                <option value="<?php echo $i; ?>" > <?php echo $i; ?> </option>
                                <?php } ?>
                            </select>

                            <span class="help-block">
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="form-group">
                            <label class="control-label" for="minutes">Minutes
                            <span class="required">*</span></label>
                            <select name="minutes[]" class="form-control required"
                            data-placeholder="Minutes" required="required">
                                <?php //for($i=0;$i<=59;$i++){ ?>
                                <option value="0" >00</option>
                                <option value="15" >15</option>
                                <option value="30" >30</option>
                                <option value="45" >45</option>
                                <?php //} ?>
                            </select>

                            <span class="help-block">
                            </span>
                        </div>
                    </div>
                    
<!--                    <div class="col-md-12 invoice-item-remove new-item text-right">
                        <div class="form-group">
                            <button type="button" class="btn btn-xs red remove-item" >
                                <i class="fa fa-minus"></i> Delete Task
                            </button>
                        </div>
                    </div>-->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-xs green new-task" onclick="return tasks(this);">
                        <i class="fa fa-plus"></i> Add Tasks
                    </button>
                </div>
            </div>

            

            <div class="row">
                <div class="col-md-6 ">
                    <label class="control-label"  for="customer_feedback"> Customer Feedback:
                    <span class="required"> * </span></label>
                    <select id="policy-form-company" name="customer_feedback[]" class="form-control required" required="required"
                        data-placeholder="Customer Feedback" onchange="return others_text_box('.other_customer_feedback_div_1', this);">
                        <option value="" ></option>
                        <?php foreach($drop_downs as $drop_down){ 
                              if($drop_down['drop_down_name'] == 'Customer Feedback'){
                        ?>
                        <option value="<?php echo $drop_down['drop_down_list']; ?>" ><?php echo $drop_down['drop_down_list'];  ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-6 ">
                    <label class="control-label"  for="remarks"> Remarks(If Any):
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="remarks[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['remarks']) ? $timesheet[$item_count]['remarks'] : ''; ?>" >
                </div>
            </div>
            
            <div class="row other_customer_feedback_div_1" style="display:none;">
                <div class="col-md-6 ">
                    <label class="control-label" for="others_customer_feedback"> Customer Feedback(Others):
                    <span class="required"> * </span></label>
                    <input type="text" class="required form-control" name="others_customer_feedback[]" required="required"
                           value="<?php echo isset($timesheet[$item_count]['others_customer_feedback']) ? $timesheet[$item_count]['others_customer_feedback'] : ''; ?>" >

                </div>
                <div class="col-md-6 "></div>
            </div>

            <div class="form-group">
                <label class="control-label" id="timesheet-for-label" for="next_action"> Next Action Plan:
                <span class="required">*</span></label>
                <textarea class="required form-control" name="next_action[]" required="required"></textarea>
            </div>

        </div>
        
        <div class="col-md-12 project-item-remove project-new-item text-right" style="padding: 0;">
            <div class="form-group">
                <button type="button" class="btn btn-xs red project-remove-item" onclick="return remove_project(this);">
                    <i class="fa fa-minus"></i> Delete Project
                </button>
            </div>
        </div>
    </div>
</div>

<!--/Project Clone Ends-->

<style>
.line-item {
    border-top: 0;
    margin-top: 0;
    padding-top: 0;
}
    
</style>
</div>