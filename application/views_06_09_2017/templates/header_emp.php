<!-- BEGIN HEADER -->
<?php $page = isset($page) ? $page : ''; ?>
<?php $sub = isset($sub) ? $sub : ''; ?>



<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid" style="padding: 0px">
            <div class="clearfix navbar-fixed-top" style="margin-top: 0px;margin-bottom: 0px;padding-left: 10px;padding-right: 10px;">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a id="index" class="page-logo" href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url(); ?>DB_crop.png" alt="Logo"> 
                    <!--<p class="col-md-12" style="color: rgb(136, 136, 136); font-weight: 600; line-height: 1; padding-left: 8px; margin-top: 2px;">My Travel Portal</p>-->                    
                </a>
                
                <!-- END LOGO -->

                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">

                    <!-- BEGIN USER PROFILE -->
                    <div class="btn-group-img btn-group">
                        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
<!--                            <span>Hi, <?php echo $this->session->userdata('name'); ?>
                                <br><i style="font-size:9px">last Login : <?php echo $this->session->userdata('last_login'); ?></i>
                            </span>-->
                            <?php
                            if ($this->session->userdata('image')) {
                                $image = $this->session->userdata('image');
                            } else {
                                $image = "assets/admin/layout/img/avatar_small.png";
                            }
                            ?>
                            <!--<img src="<?php echo base_url() . $image; ?>" alt="Employee Photo" class="hidden-md hidden-lg">-->  
                        </button>

                        <ul class="dropdown-menu-v2" role="menu">
                            <li>
                                <a href="<?php echo base_url(); ?>employees/view_profile">
                                    <i class="fa fa-user"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a href="http://s.bhaskarmail.com/" target="_blanck">
                                    <i class="fa fa-key"></i> Change Password
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="<?php echo base_url(); ?>users/logout">
                                    <i class="fa fa-sign-out"></i> Log Out </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END USER PROFILE -->
                </div>
                <!-- END TOPBAR ACTIONS -->
            </div>
            <!-- BEGIN HEADER MENU -->
            <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse header-nav-links">
                
<!--                <ul class="nav navbar-nav">
                    <li class="<?php if ($page == '') { ?> active selected <?php } ?>">
                        <a href="<?php echo base_url(); ?>" class="text-uppercase">
                            <i class="fa fa-dashboard"></i> Dashboard 
                        </a>
                    </li>                                      

                    <li class="dropdown dropdown-fw">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="fa fa-list-alt"></i> Travel
                        </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-paper-plane-o"></i>
                                    <span class="title">Flight</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-train"></i>
                                    <span class="title">Train</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-car"></i>
                                    <span class="title">Car</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-bus"></i>
                                    <span class="title">Bus</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-fw">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="fa fa-list-alt"></i> Personal Task
                        </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-inbox"></i>
                                    <span class="title">Inbox</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-pencil-square"></i>
                                    <span class="title">My Draft</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">My Request</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="<?php echo base_url(); ?>" class="text-uppercase">
                            <i class="fa fa-calendar"></i> Travel Desk 
                        </a>
                    </li>

                    <li class="">
                        <a href="<?php echo base_url(); ?>" class="text-uppercase">
                            <i class="fa fa-rupee"></i> Finance Desk 
                        </a>
                    </li>

                    <li class="">
                        <a href="#" class="text-uppercase">
                            <i class="fa fa-users"></i> Auditor Desk
                        </a>
                    </li>

                    <li class="">
                        <a href="#" class="text-uppercase">
                            <i class="fa fa-file-text"></i> Report
                        </a>
                    </li>

                    <li class="dropdown dropdown-fw <?php if ($page == 'masters') { ?>active <?php } ?>">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="fa fa-list-alt"></i> Masters Data 
                        </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li>
                                <a href="<?php echo base_url('roles'); ?>" class="<?php if ($sub == 'roles') { ?>active<?php } ?>">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Roles</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('designation'); ?>" class="<?php if ($sub == 'designations') { ?>active<?php } ?>">
                                    <i class="fa fa-users"></i>
                                    <span class="title">Designations</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('states'); ?>" class="<?php if ($sub == 'states') { ?>active<?php } ?>">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="title">States</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('city'); ?>" class="<?php if ($sub == 'city') { ?>active<?php } ?>">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="title">City</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('cost_center'); ?>" class="<?php if ($sub == 'cost_center') { ?>active<?php } ?>">
                                    <i class="fa fa-location-arrow "></i>
                                    <span class="title">Cost Center</span>
                                </a>
                            </li>

                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="fa fa-plane"></i> Travel Policy
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Travel Resons</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-tags"></i>
                                            <span class="title">Travel Policy</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Travel Entitlement</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Expense Polices</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown more-dropdown <?php if ($page == 'employees') { ?>active <?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="fa fa-users"></i> Employees Data
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('grades'); ?>" class="<?php if ($sub == 'grades') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Employee Grade</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('employees'); ?>" class="<?php if ($sub == 'employees') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Employee List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="fa fa-tags"></i> Travel Categories
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Cost Centers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Car Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Hotel Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Flight Class</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Train Class</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Bus Class</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="fa fa-list-alt"></i> Service Proviers
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Flight Providers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Traini Providers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Car Providers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Bus Providers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="<?php if ($sub == 'users') { ?>active<?php } ?>">
                                            <i class="fa fa-users"></i>
                                            <span class="title">Hotel Providers</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>-->
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->