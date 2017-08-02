<style>
    
 .dashboard-date-range {
    background-color: #95a5a6;
    color: #fff;
    cursor: pointer;
    display: none;
    margin-top: 0px; 
    margin-bottom: 0px; 
    padding:6px 10px;
    padding-top:4px;
}

</style>
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
            <li class="active">Timesheet</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                   <i class="icon-remove"></i>
                   <?php echo $this->session->flashdata('error');?>
                </div>
            <?php } else if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i>
                   <?php echo $this->session->flashdata('success');?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Timesheet - <?php echo date('F j, Y', strtotime($start)).' - '. date('F j, Y', strtotime($end)); ?>
                        
                    </div>

                    <div class="actions">
                        <div style="display: inline-block;">
                             <input type="hidden" value="<?php echo $start; ?>" id="timesheet_start" />
                                <input type="hidden" value="<?php echo date('F j, Y', strtotime($start)); ?>" id="timesheet_start_str" />
                                <input type="hidden" value="<?php echo $end; ?>" id="timesheet_end" />
                                <input type="hidden" value="<?php echo date('F j, Y', strtotime($end)); ?>" id="timesheet_end_str" />
                                <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                                    <i class="fa fa-calendar"></i>
                                    <span></span>
                                    <i class="fa fa-angle-down"></i>
                                </div>
                        </div>
                        
<!--                        <a class="btn grey-cascade" href="<?php echo base_url()."work/timesheet/view"; ?>" style="padding-top: 5px;">
                            <i class="fa fa-eye"></i> View Timesheet
                        </a>-->
                        <a class="btn grey-cascade" href="<?php echo base_url()."work/manage_timesheet"; ?>"  style="padding-top: 5px;">
                            <i class="fa fa-plus"></i> Add Timesheet
                        </a>
                        
                    </div>
                    
                </div>
                <div class="portlet-body">
                    <?php if(false) { ?>
                        <p class="text-right">
                            Change Date <i class="fa fa-arrow-right "></i>
                            <button type="button" class="btn-datepicker btn btn-sm grey-cascade-madison" style="color:#000000;">
                                <i class="fa fa-calendar"></i> <?php echo $date; ?>
                            </button>
                        <a class="btn btn-sm grey-cascade" href="<?php echo base_url()."work/timesheet/view"; ?>">
                            <i class="fa fa-eye"></i> View Timesheet
                        </a>
                        <a class="btn btn-sm grey-cascade" href="<?php echo base_url()."work/manage_timesheet"; ?>">
                            <i class="fa fa-plus"></i> Add Timesheet
                        </a>
                        </p>

                        <hr />
                    <?php } ?>

                    <?php if(empty($timesheet)) { ?>
                        <h5 class="text-center">
                            <b>No item in timesheet yet for date - <?php echo date('F j, Y', strtotime($start)).' - '.date('F j, Y', strtotime($end)); ?>.</b>
                        </h5>
                    <?php } else { ?>
                        
                        <table class="table" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
<!--                                    <th>Project</th>-->
                                    <th style="text-align: center;">Hours</th>
                                    <th style="text-align: center;">Minutes</th>
<!--                                    <th>Tasks</th>-->
                                    <th class="no_sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($timesheet as $sheet) { ?>
                                    <?php 
                                        $timesheet_for = 'Working';
                                        $project_name = $sheet['project_name'];
                                        $hours = floor($sheet['hours']+($sheet['minutes']/60));
                                        $minutes = ($sheet['minutes']%60);
                                        if($sheet['timesheet_for'] === 'holiday') {
                                            $timesheet_for = 'Holiday';
                                            //$hours = '-';
                                            //$minutes = '-';
                                        }
                                        if($sheet['timesheet_for'] === 'on_leave') {
                                            $timesheet_for = 'On Leave';
                                            //$project_name = '-';
                                            //$hours = '-';
                                            //$minutes = '-';
                                        }
                                    ?>
                                    <tr>
                                        <td nowrap><?php echo date('m/d/Y', strtotime($sheet['date'])); ?></td>
                                        <td><?php echo $timesheet_for; ?></td>
                                        <td>
                                            <?php if($sheet['status'] === 'Pending') { ?>
                                                <span class="label label-warning"> 
                                                    <i class="fa fa-spinner"></i> <?php echo $sheet['status']; ?> 
                                                </span>
                                            <?php } else if($sheet['status'] === 'In_Question') { ?>
                                            <span class="label label-primary" data-toggle="tooltip" title="<?php echo $sheet['in_question_reason']; ?>"> 
                                                    <i class="fa fa-question"></i> In-Question
                                                </span>
                                            <?php } else if($sheet['status'] === 'Approved') { ?>
                                                <span class="label label-success"> 
                                                    <i class="fa fa-thumbs-o-up"></i> <?php echo $sheet['status']; ?> 
                                                </span>
                                            <?php } else if($sheet['status'] === 'Declined') { ?>
                                                <span class="label label-danger" data-toggle="tooltip" title="<?php echo $sheet['decline_reason']; ?>"> 
                                                    <i class="fa fa-thumbs-o-down"></i> <?php echo $sheet['status']; ?> 
                                                </span>
                                            <?php }  ?> 
                                        </td>
<!--                                        <td><?php echo $project_name; ?></td>-->
                                        <?php if($sheet['timesheet_for'] === 'working') { ?> 
                                            <td style="text-align: center;"><?php echo $hours; ?></td>
                                            <td style="text-align: center;"><?php echo $minutes; ?></td>
                                        <?php } else { ?>
                                            <td style="text-align: center;">NA</td>
                                            <td style="text-align: center;">NA</td>
                                        <?php } ?>
<!--                                        <td><?php echo (strlen($sheet['tasks']) > 100 ? substr($sheet['tasks'], 0, 100)."..." : $sheet['tasks']); ?></td>-->
                                        <td nowrap>
                                            <?php if($sheet['can_edit']=='Yes'){ ?>
                                            <a class="btn default btn-xs purple" 
                                                href="<?php echo base_url()."work/manage_timesheet/".$sheet['date'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <?php } ?>
<!--                                            <a class="btn default btn-xs red" data-confirm="Are you sure you want to delete this item?"
                                                href="<?php echo base_url()."work/delete_timesheet/".$sheet['date'];?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>-->
                                            <?php if($sheet['can_edit']=='No'){ ?>
                                            <a class="btn default btn-xs yellow"
                                                href="<?php echo base_url()."work/timesheet_edit_request/".$sheet['date'];?>">
                                                <i class="fa fa-thumbs-o-up"></i> Request to Edit
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>