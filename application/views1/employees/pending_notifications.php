<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Pending Notifications
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Pending Notifications</li>
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
                                        <select name="employee_id" class="form-control select2me"
                                        data-placeholder="Select Employee">
                                            <option></option>
                                            <?php foreach($employees as $employee) { ?>
                                                <option value="<?php echo $employee['id']; ?>"
                                                    <?php if(($this->input->post('employee_id') == $employee['id']) 
                                                            || ($user_check == 'employee')) { ?> selected="selected" <?php } ?> >
                                                    <?php echo $employee['first_name'].' '.$employee['last_name']; ?>
                                                </option>
                                            <?php } ?>
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
                        <i class="fa fa-users"></i>Pending Notifications
                    </div>
                </div>
                <div class="portlet-body" >

                    <?php if(empty($notifications)) { ?>
                        <p class="text-center">No Pending Notifications Exist Yet.</p>
                    <?php } else { ?>
                        <table class="table" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Reporting Person</th>
                                    <th>Pending For</th>
                                    <th class='text-center'>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=0;
                                    foreach($notifications as $noti_details) { ?>
                                    <tr>
                                        <td><?php echo $noti_details['employee_name']; ?></td>
                                        <td><?php echo ucwords(implode(' ',explode('_',$noti_details['type']))); ?></td>
                                        <td class='text-center'><?php echo $noti_details['count']; ?></td>
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