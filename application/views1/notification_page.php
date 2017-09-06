<div class="page-content">
    
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
            
            <?php if(!empty($notifications)){?>
                <div class ="row" >    
                    <div class="col-md-12">
                         <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>Notifications
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class ="row" >    
                                    <div class="col-md-12">
                                    <?php foreach ($notifications as $notification) {?>
                                           <?php $read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                        <?php if($notification['type'] == 'other_expense'){?>
                                        
                                        <p class="<?php echo $read_status; ?>">You have an Other Expense Request from<b> <?php echo $notification['employee_name']   ?>  </b>
                                             
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_other_expense/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php } else if($notification['type'] == 'Payable-invoice'){?>
                                        <p class="<?php echo $read_status; ?>">You have a Request for approval on Payable Invoice. 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_payable_invoice/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                       <?php } else if($notification['type'] == 'travel_expense'){?>
                                        <p class="<?php echo $read_status; ?>">You have a Travel Expense Request from<b> <?php echo $notification['employee_name']   ?>  </b> 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_travel_expense/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php } else if($notification['type'] == 'offer_letter'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a Request for approvel on offer letter from<b> HR Team <?php //echo $notification['employee_name']   ?>.  </b> 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_offer_letter/'.$notification['id'].'/'.$notification['target_id']. '/'.$notification['sender_emp_id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] == 'Personal Leave' || $notification['type'] == 'Medical Leave' 
                                              || $notification['type'] == 'Paid Meternity Leave' || $notification['type'] == 'Comp-Off' 
                                              || $notification['type'] == 'Half Day' || $notification['type'] == 'leave'){ 
                                            if($notification['type'] == 'Comp-Off'){
                                                $cont = "leave against Comp-Off";
                                            }else{
                                                $cont = $notification['type'];
                                            }
                                            ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for <?php echo $cont; ?> from <b> <?php echo $notification['employee_name']   ?>  </b> 
                                            <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type ="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_leave/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>      
                                      
                                       <?php }else if($notification['type'] == 'comp_off_request'){?>
                                        <p class="<?php echo $read_status; ?>">You have a Comp-Off request from <b> <?php echo $notification['employee_name']   ?></b> 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/comp_off_view/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] == 'comp_off_allocation'){?>
                                        <p class="<?php echo $read_status; ?>">You have a Comp-Off allocation request from <b> <?php echo $notification['employee_name']   ?></b> 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/comp_off_view/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] == 'short_leave_request'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for short leave from <b> <?php echo $notification['employee_name']; ?></b>  
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_short_leave/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] == 'Travel'){?>
                                        <p class="<?php echo $read_status; ?>">You have a Travel Booking request from <b> <?php echo $notification['employee_name']   ?></b> 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_travel_booking/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] == 'room'){?>
                                        <p class="<?php echo $read_status; ?>">You have a Room Booking request from <b> <?php echo $notification['employee_name']   ?></b> 
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_room_booking/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] === 'Visiting Card'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for Visiting Card from  <b> <?php echo $notification['employee_name']; ?></b>  
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] === 'ID Card'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for ID Card from  <b> <?php echo $notification['employee_name']; ?></b>  
                                             <?php //$read_status = $notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($notification['type'] === 'timesheet_edit'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a timesheet edit permission request from  <b> <?php echo $notification['employee_name']; ?></b>  
                                            <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view_timesheet_edit_popup/'
                                               .$notification['target_id']. '/'.$notification['sender_emp_id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }?>
                                        <?php }?>
                                        <?php foreach ($req_notifications as $req_notification) {?>
                                        <?php if($req_notification['request_for'] === 'Application Installation'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for Application Installation from  <b> <?php echo $req_notification['employee_name']; ?></b>  
                                             <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$req_notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($req_notification['request_for'] === 'Laptop'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for Laptop  from  <b> <?php echo $req_notification['employee_name']; ?></b>  
                                            <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$req_notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($req_notification['request_for'] === 'Form 16'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for Form 16  from  <b> <?php echo $req_notification['employee_name']; ?></b>  
                                            <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$req_notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($req_notification['request_for'] === 'Stationary'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for Stationary  from  <b> <?php echo $req_notification['employee_name']; ?></b>  
                                           <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>                                           
                                           <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$req_notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($req_notification['request_for'] === 'Data-card'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for Data-card from  <b> <?php echo $req_notification['employee_name']; ?></b>  
                                            <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$req_notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }else if($req_notification['request_for'] === 'CUG Connection'){ ?>
                                        <p class="<?php echo $read_status; ?>">You have a request for CUG Connection  from  <b> <?php echo $req_notification['employee_name']; ?></b>  
                                            <?php //$read_status = $req_notification['read'] ? 'light-green' : 'green' ?>
                                            <a type="button" class="notification-link btn btn-xs green pull-right" href="<?php echo base_url().'View_controller/view/'.$req_notification['id'];?>" >
                                            <i class="fa fa-eye"></i> View
                                            </a>
                                        </p>
                                        <?php }?>
                                        <?php }?>
                                    </div>    
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>    
            <?php }?>
            
        </div>
        
    </div>
            
           
</div>

<div class="loading-container hide">
    <div class="loading-img">
        <img src="<?php echo base_url(); ?>assets/images/loader.gif" >
        <div class="loading-txt">Loading...</div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <button type="button"  data-dismiss="modal" aria-hidden="true" style="color:white">Close</button>
    <div class="modal-content">
        
    </div>
  </div>
</div>


