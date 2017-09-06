<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Dainik Bhaskar | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url(); ?>assets/new/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/new/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/new/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>
        <style>
            .login .login-content {
                border-top:1px solid #DDDDDD;
                border-bottom:1px solid #DDDDDD;
                padding-top:15px !important;
                padding-bottom:15px !important;
                margin-top:160px !important;
            }
            .content {
                position: absolute;
                top: 50%;
                left:50%;
                transform: translate(-50%,-50%);
                background-color: #FFF;
            }
            .img {
                display: block;
                margin: auto;
                width: 40%;
            }
        </style>

    </head>
    <!-- BEGIN BODY -->
    <body class="login" style="background-color: #EEEEEE">

        <div class="content">
            <div style="border:1px solid #CCC;box-shadow: 1px 1px 1px 1px #888888;;padding: 40px;">
                <img class="img" src="<?php echo base_url(); ?>DB_crop.png" style="text-align: center;position: relative;margin: 0 auto;height: 150px;width: 300px;" />
                <div class="box box-body">
                    <span class="col-md-12" style="text-align: center; 
                          color: #888;    
                          font-size: 18px;
                          font-weight: 600;">My Travel Portal</span>
                    <br>
                    <hr style="border: 1px #000 dotted">
                    <p> Welcome to Travel Portal. Please login to continue...</p>

                    <form class="login-form" method="post">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span>Enter any username and password. </span>
                        </div>
                        <?php if (isset($error)) { ?>
                            <div class="login-error alert alert-danger">
                                <i class="fa fa-ban"></i>
                                <strong> Error ! </strong>
                                <?php echo $error; ?>
                            </div>
                        <?php } else if ($this->session->flashdata('success')) { ?>
                            <div class="login-error alert alert-success">
                                <i class="fa fa-check"></i>
                                <strong> Success </strong>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php } else if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-ban"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php } ?>
                        <div class="row">                            
                            <div class="col-md-12 form-group">                                
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" autocomplete="off" autofocus="yes" placeholder="Alias" name="username" required class="form-control form-control-solid placeholder-no-fix form-group">
                                </div>
                            </div><br><br><br>
                            <div class="col-xs-12 form-group">                                
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <input type="password" class="form-control form-control-solid placeholder-no-fix form-group" autocomplete="off" placeholder="Password" name="password" required >
                                </div>
                            </div><br><br><br>
                        </div>
                        <div class="row">
                            <!--                            <div class="col-sm-6">
                                                            <div class="form-group" style="margin-left: -15px; margin-top: 5px;">
                                                                <label class='radio-inline'>
                                                                    <input type= 'radio' class="required" name='type' value='admin'> Admin
                                                                </label>
                                                                <label class='radio-inline'>
                                                                    <input type= 'radio' class="required" name='type' value='employee' checked="checked"> Employee
                                                                </label>
                                                            </div>
                                                        </div>-->
                            <div class="col-md-offset-6 col-sm-6 text-right">
                                <button class="btn blue" type="submit">Sign In</button>
                                <br>
                                <br>
<!--                                <div class="forgot-password">
                                                                        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                                    <a href="http://s.bhaskarmail.com/pwdRecovery/" target="_blanck" id="forget-password1" class="forget-password">Forgot Password?</a>
                                </div>-->
                            </div>
                        </div>
                    </form>

                    <!-- BEGIN FORGOT PASSWORD FORM -->
<!--                    <form class="forget-form" action="<?php echo base_url() . 'users/forgot_password'; ?>" method="post">
                        <h3 class="font-green">Forgot Password ?</h3>
                        <p> Enter your e-mail address below to reset your password. </p>
                                                <div class="form-group">
                                                    <input class="form-control placeholder-no-fix form-group" /> 
                                                </div>
                        <div class="form-group">                                
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input class="form-control form-control-solid placeholder-no-fix form-group" type="email" autocomplete="off" placeholder="Email" name="email_id" >
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" id="back-btn" class="btn grey btn-default">Back</button>
                            <button type="submit" class="btn blue btn-success uppercase pull-right">Submit</button>
                        </div>
                    </form>-->
                    <!-- END FORGOT PASSWORD FORM -->
                </div>
            </div>
        </div>
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
            <script src="<?php echo base_url(); ?>assets/new/global/plugins/respond.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/new/global/plugins/excanvas.min.js"></script>            
        <![endif]-->

        <script src="<?php echo base_url(); ?>assets/new/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/new/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/new/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/new/pages/scripts/login-5.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>