<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Employee Attendance Calendar
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Employees</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <div class="portlet light bordered review-timesheet-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Filter Form
                    </div>
                </div>
            
                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if($this->session->flashdata('error')) {?>
                                <div class="alert alert-danger">
                                   <i class="fa fa-ban"></i>
                                   <?php echo $this->session->flashdata('error');?>
                                </div>
                            <?php } else if($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i>
                                   <?php echo $this->session->flashdata('success');?>
                                </div>
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Employee</label>
                                        <select name="employee_id[]" class="form-control select2me"
                                                data-placeholder="Select Employee" multiple>
                                            <option></option>
                                            <?php foreach($employees as $employee) { 
                                                if(!in_array($employee['id'],$dept_heads)){
                                                ?>
                                                <option value="<?php echo $employee['id']; ?>"
                                                    <?php if($this->input->post('employee_id') && in_array($employee['id'], $this->input->post('employee_id')) 
                                                            || ($user_check == 'employee')) { ?> selected="selected" <?php } ?> >
                                                    <?php echo $employee['first_name'].' '.$employee['last_name']; ?>
                                                </option>
                                                <?php } } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date Range
                                        <span class="required"> * </span></label>
                                        <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="required form-control" name="start_range" 
                                            value="<?php echo $this->input->post('start_range'); ?>">
                                            <span class="input-group-addon">
                                            to </span>
                                            <input type="text" class="required form-control" name="end_range"
                                            value="<?php echo $this->input->post('end_range'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url(); ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>Employees
                    </div>
                    <?php if($this->input->post()){ ?>
                    <div class="actions" style="margin-top: 0px;">
                        <form action="<?php echo base_url()."employees/attendance_calendar"?>" method="post" role="form">
                            <input type="hidden" name="start_range" value="<?php echo $this->input->post('start_range'); ?>" />
                            <input type="hidden" name="end_range" value="<?php echo $this->input->post('end_range'); ?>" />
                            <?php $emps = $this->input->post('employee_id') ? $this->input->post('employee_id') : array(); ?>
                            
                            <?php foreach($emps as $emp) { ?>
                                <input type="hidden" name="employee_id" value="<?php echo $emp; ?>" />
                            <?php } ?>

                            <button class="btn grey-cascade btn-sm" type="submit" name="download" value="excel">
                                <i class="fa fa-download"></i> Download as Excel
                            </button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
                <?php if($this->input->post()){ ?>
                <div class="portlet-title">
                    <div class="caption">
                        <b style="color:green; font-size: 14px;">P -> Present, </b>
                        <b style="color:red; font-size: 14px;">A -> Absent, </b>
                        <b style="color:#FF6B49; font-size: 14px;">W -> Weekend, </b>
                        <b style="color:blue; font-size: 14px;">L -> Leave,</b>
                        <b style="color:orange; font-size: 14px;">F -> Festival</b>
                    </div>
                </div>
                <?php } ?>
                <div class="portlet-body" >

                    <?php if(empty($employee_attendance)) { ?>
                        <p class="text-center">No Employee exist yet.</p>
                    <?php } else { ?>
                        <table class="table" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Reporting Person</th>
                                    <th>Employee Name</th>
                                    <?php for($j=0; $j< sizeof($diff_dates); $j++) { ?>
                                    <th class='text-center'><?php echo $diff_dates[$j]; ?></th>
                                    <?php } ?>
                                    <th class='text-center'>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=0;
                                    foreach($employee_attendance as $employee) { ?>
                                    <tr>
                                        <td><?php echo $employee[$i][10]; ?></td>
                                        <td><?php echo $employee[$i][1]; ?></td>
                                        <?php 
                                            $ip = $i;
                                            $j=0;
                                            $total_count = 0;
                                            foreach($employee as $emp){
                                                
                                                $date1=date_create($emp[11]);
                                                $date2=date_create($diff_dates[$j]);
                                                $diff=date_diff($date1,$date2);
                                                $num_days = $diff->format("%R%a days");

                                                //if($num_days >= 0){
                                                    //echo $diff_dates[$j]." ";
                                                    while($diff_dates[$j] != $emp[0]){

                                                        //echo "<td>A(00 : 00)</td>";
                                                        $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);
                                                        if(in_array($diff_dates[$j],$festival_array)){
                                                            if($num_days >= 0){
                                                                $total_count = $total_count + 1;
                                                            }
                                                            echo "<td class='text-center'><b style='color:orange;'>F</b></td>";
                                                        }else if(in_array($diff_dates[$j],$weekend_array)){
                                                            echo "<td class='text-center'><b style='color:#FF6B49;'>W</b></td>";
                                                        }else if(!empty ($is_leave)){
                                                            if($num_days >= 0){
                                                                $total_count = $total_count + 1;
                                                            }
                                                            echo "<td class='text-center'><b style='color:blue;'>L</b></td>";
                                                        }else{
                                                            echo "<td class='text-center'><b style='color:red;'>A</b></td>";
                                                        }
                                                        $j++;
                                                    }
                                                    if($diff_dates[$j] == $emp[0]){
                                                        $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);
                                                        //echo "<td>".$emp[6]."(".sprintf('%02d',$emp[3])." : ".sprintf('%02d',$emp[4]).")</td>"; 
                                                        if(in_array($diff_dates[$j],$festival_array)){
                                                            if($num_days >= 0){
                                                                $total_count = $total_count + 1;
                                                            }
                                                            echo "<td class='text-center'><b style='color:orange;'>F</b></td>";
                                                        }else if(in_array($diff_dates[$j],$weekend_array)){
                                                            echo "<td class='text-center'><b style='color:#FF6B49;'>W</b></td>";
                                                        }else if(!empty ($is_leave)){
                                                            if($num_days >= 0){
                                                                $total_count = $total_count + 1;
                                                            }
                                                            echo "<td class='text-center'><b style='color:blue;'>L</b></td>";
                                                        }else{
                                                            $total_count = $total_count + $emp[7];
                                                            echo "<td class='text-center'>".$emp[6]."</td>"; 
                                                        }

                                                    }else{
                                                        //echo "<td>A(00 : 00)</td>";
                                                        $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);

                                                        if(in_array($diff_dates[$j],$festival_array)){
                                                            if($num_days >= 0){
                                                                $total_count = $total_count + 1;
                                                            }
                                                            echo "<td class='text-center'><b style='color:orange;'>F</b></td>";
                                                        }else if(in_array($diff_dates[$j],$weekend_array)){
                                                            echo "<td class='text-center'><b style='color:#FF6B49;'>W</b></td>";
                                                        }else if(!empty ($is_leave)){
                                                            if($num_days >= 0){
                                                                $total_count = $total_count + 1;
                                                            }
                                                            echo "<td class='text-center'><b style='color:blue;'>L</b></td>";
                                                        }else{
                                                            echo "<td class='text-center'><b style='color:red;'>A</b></td>";
                                                        }
                                                    }
                                                    $i++; $j++; 
//                                                }else{
//                                                    $j++;
//                                                }
                                            } 
                                        ?>
                                        
                                        <?php for($k=$j ;$k< sizeof($diff_dates);$k++){
                                            
                                            $date1=date_create($employee[$ip][11]);
                                            $date2=date_create($diff_dates[$k]);
                                            $diff=date_diff($date1,$date2);
                                            $num_days = $diff->format("%R%a days");

                                            //if($num_days >= 0){
                                                //echo $diff_dates[$k];
                                                $is_leave=$this->leave_model->get_date_wise_leave($diff_dates[$k], $employee[$ip][5]);

                                                if(in_array($diff_dates[$k],$festival_array)){
                                                    if($num_days >= 0){
                                                        $total_count = $total_count + 1;
                                                    }
                                                    echo "<td class='text-center'><b style='color:orange;'>F</b></td>";
                                                }else if(in_array($diff_dates[$k],$weekend_array)){
                                                    echo "<td class='text-center'><b style='color:#FF6B49;'>W</b></td>";
                                                }else if(!empty ($is_leave)){
                                                    if($num_days >= 0){
                                                        $total_count = $total_count + 1;
                                                    }
                                                    echo "<td class='text-center'><b style='color:blue;'>L</b></td>";
                                                }else{
                                                    echo "<td class='text-center'><b style='color:red;'>A</b></td>";
                                                }
                                            //}
                                        } 
                                        ?>
                                        <?php if($employee[$ip][9] < 0){
                                                $avl_leaves = $employee[$ip][9];
                                            }else{
                                                $avl_leaves = 0;
                                            } ?>
                                        <td class='text-center'><?php echo "<b style='color:black;'>".($total_count+$avl_leaves)."</b>"; ?></td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>