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
                    <img src="<?php echo base_url(); ?>DB_crop.png" alt="DB Corp Ltd."> 
                    <p class="logo-sub-heading">My Travel Portal</p>                    
                </a>
                
                <!-- END LOGO -->

                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">

                    <!-- BEGIN USER PROFILE -->
                    <div class="btn-group-img btn-group">
                        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span>Hi, <?php echo $this->session->userdata('name'); ?>
                                <!--<br><i style="font-size:9px">last Login : <?php echo $this->session->userdata('last_login'); ?></i>-->
                            </span>
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
                                <a href="<?php echo base_url(); ?>dashboard/view_profile">
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
                <?php 
                echo $this->menu;
                ?>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->