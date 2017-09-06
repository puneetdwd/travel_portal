<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="false" data-auto-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start">
                <a href="<?php echo base_url(); ?>">
                    <i class="fa fa-home"></i>
                    <span class="title">Home</span>
                </a>
            </li>
            
            <?php if($this->session->userdata('type') == 'admin'){ ?>
            
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">Manage Accounts</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                       <li>
                            <a href="<?php echo base_url(); ?>pos">
                                <i class="fa fa-file-text"></i>
                                <span class="title">Upload POs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices">
                                <i class="fa fa-money"></i>
                                <span class="title">Upload Invoices</span>
                            </a>
                        </li>
                     </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">Manage Masters</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>users">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>department">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Departments</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>designation">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Designations</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>employees">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>vendors">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Vendors</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>customers">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Customers</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>products">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>leave_settings/settings">
                                <i class="fa fa-users"></i>
                                <span class="title">Manage Leave Settings</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">HR Mangement</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>offer_letter">
                                <i class="fa fa-users"></i>
                                <span class="title">Offer Letter</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>service_agreement">
                                <i class="fa fa-users"></i>
                                <span class="title">Service Agreement</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url(); ?>employees/view_candidates">
                                <i class="fa fa-users"></i>
                                <span class="title">New Candidates</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url(); ?>expenses/hr_view">
                                <i class="fa fa-users"></i>
                                <span class="title">Expense Disburse</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-calendar"></i>
                        <span class="title">Timesheet</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url()."review/timesheet"; ?>">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    Employee
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()."review/project_timesheet"; ?>">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    Customer
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if($this->session->userdata('type') === 'employee') { ?>
                <?php if($this->session->userdata('dept_head')){ ?>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">Manage Accounts</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                       <li>
                            <a href="<?php echo base_url(); ?>pos">
                                <i class="fa fa-file-text"></i>
                                <span class="title">Upload POs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices">
                                <i class="fa fa-money"></i>
                                <span class="title">Upload Invoices</span>
                            </a>
                        </li>
                         <?php if($this->session->userdata('employee_id') == 2){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>report">
                                <i class="fa fa-files-o"></i>
                                <span class="title">Generate Report</span>
                            </a>
                        </li>
                        <?php } ?>
                     </ul>
                </li>
                 <?php } ?>   
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">Manage Leaves</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                    <?php if($this->session->userdata('is_reporting_person')){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>leave/check_leave_index">
                                <i class="fa fa-bell"></i>
                                <span class="title">Check Leaves</span>
                            </a>
                        </li>
                      <?php } ?> 
                        <li>
                            <a href="<?php echo base_url(); ?>leave">
                                <i class="fa fa-bell"></i>
                                <span class="title">Leaves</span>
                            </a>
                        </li>
                        
                        <!-- <li>
                                <a href="<?php echo base_url(); ?>leave/settings">
                                        <i class="fa fa-users"></i>
                                        <span class="title">Manage Leave Setting</span>
                                </a>
                        </li>-->
                        <?php if($this->session->userdata('is_reporting_person')){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>comp_off">
                                <i class="fa fa-trophy "></i>
                                <span class="title">Comp-off Allotment</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <li>
                            <a href="<?php echo base_url(); ?>comp_off/request_index">
                                <i class="fa fa-trophy "></i>
                                <span class="title">Comp-off Request</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url(); ?>short_leave">
                                <i class="fa fa-trophy "></i>
                                <span class="title">Short Leave</span>
                            </a>
                        </li>
                        
                        
                    </ul>
                </li>
                <?php if($this->session->userdata('is_reporting_person')){ ?>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-calendar"></i>
                        <span class="title">Timesheet</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url()."review/timesheet"; ?>">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    Employee
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()."review/project_timesheet"; ?>">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    Customer
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if($this->session->userdata('dept_head')){ ?>
                <li>
                    <a href="<?php echo base_url(); ?>projects">
                        <i class="fa fa-users"></i>
                        <span class="title">Manage Projects</span>
                    </a>
                </li>
             <?php } ?>
                <?php if($this->session->userdata('is_reporting_person')){ ?>
                <li>
                    <a href="<?php echo base_url(); ?>project_assignment">
                        <i class="fa fa-check-circle-o"></i>
                        <span class="title">Project Assignment</span>
                    </a>
                </li>
                 <?php } ?>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-file-text"></i>
                        <span class="title">Service Requests</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>service_request/index">
                                <i class="fa fa-share-square-o "></i>
                                <span class="title">General Requests</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>booking_request/index">
                                <i class="fa fa-share-square-o "></i>
                                <span class="title">Travel Booking Form</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>room_booking/index">
                                <i class="fa fa-share-square-o "></i>
                                <span class="title">Hotel Room Booking</span>
                            </a>
                        </li>
                    
                    </ul>
                </li>
                <?php if($this->session->userdata('department') !== 'Sales') { ?>
                    <li>
                         <a href="<?php echo base_url(); ?>work/timesheet">
                             <i class="fa fa-calendar"></i>
                             <span class="title">Manage Timesheet</span>
                         </a>
                    </li>
                <?php } else { ?>
                    <li class="start">
                        <a href="<?php echo base_url(); ?>work/reporting">
                            <i class="fa fa-list"></i>
                            <span class="title">Manage Reporting</span>
                        </a>
                    </li>
                <?php } ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-money "></i>
                            <span class="title">Expenses</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url()."expenses/travel_expense"; ?>">
                                    <i class="fa fa-plane"></i>
                                    <span class="title">
                                        Travel Expenses
                                    </span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo base_url()."expenses/other_expense"; ?>">
                                    <i class="fa fa-inr"></i>
                                    <span class="title">
                                        Other Expenses
                                    </span>
                                </a>
                            </li>
                            <!--<li>
                                <a href="<?php echo base_url()."expenses/manage_expense"; ?>">
                                    <i class="fa fa-download "></i>
                                    <span class="title">
                                        Download Expenses
                                    </span>
                                </a>
                            </li>-->
                        </ul>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url()."bring_your_buddy"; ?>">
                            <i class="fa fa-list-alt"></i>
                            <span class="title">BRING YOUR BUDDY</span>
                        </a>
                    </li>
                    
            <?php } ?>
                    
                    
            
            <li>
                <a href="javascript:;">
                    <i class="fa fa-file-text"></i>
                    <span class="title">Policies</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo base_url()."policies/holiday_list"; ?>">
                            <i class="fa fa-table"></i>
                            <span class="title">
                                Holiday List
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."policies/travel"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                Travel Policy
                            </span>
                        </a>
                    </li>
                     <li>
                        <a href="<?php echo base_url()."policies/working_hours"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                    Working Hours Policy
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."policies/reimbursement"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                Reimbursement Policy
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."policies/short_leave"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                Short Leave Policy
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."policies/leave_policy"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                Leave Policy
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."policies/erp_policy"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                ERP Policy
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."policies/discipline_policy"; ?>">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                Discipline Policy
                            </span>
                        </a>
                    </li>
                    
                </ul>
                <li>
                    <a href="<?php echo base_url()."library"; ?>">
                        <i class="fa fa-book"></i>
                        <span class="title">
                            Library
                        </span>
                    </a>
                </li>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>