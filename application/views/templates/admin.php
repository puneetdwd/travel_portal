<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>My Travel Portal</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-lightbox/ekko-lightbox.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL STYLES -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/plugins/select2/select2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-datepicker/css/datepicker.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/plugins/data-tables/DT_bootstrap.css"/>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-select/bootstrap-select.min.css"/>
        
        <link href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/admin/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="<?php echo base_url(); ?>assets/admin/layout/css/themes/light.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->

    <body class="page-header-fixed ">
        <!-- BEGIN HEADER -->
        <?php echo $header; ?>
        <!-- END HEADER -->

        <div class="clearfix">
        </div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
            <!-- BEGIN SIDEBAR -->
            <?php echo $sidebar; ?>
            <!-- END SIDEBAR -->

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <?php echo $content; ?>
            </div>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <?php echo $footer; ?>
        <!-- END FOOTER -->

        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
           <script src="<?php echo base_url(); ?>assets/admin/plugins/respond.min.js"></script>
           <script src="<?php echo base_url(); ?>assets/admin/plugins/excanvas.min.js"></script> 
           <![endif]-->
        <script src="<?php echo base_url(); ?>assets/admin/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
        <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
        <script src="<?php echo base_url(); ?>assets/admin/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-lightbox/ekko-lightbox.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/jquery-validation/js/jquery.validate.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/select2/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/data-tables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/data-tables/tabletools/js/dataTables.tableTools.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/data-tables/DT_bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <script src="<?php echo base_url(); ?>assets/admin/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/scripts/all.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/scripts/admin.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/scripts/form-wizard.js"></script>
        <script>
            jQuery(document).ready(function() {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                All.init(); // init current layout
                All.initDashboardDaterange(); // init current layout
                FormWizard.init();
            });
        </script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/scripts/alphanumeric.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/scripts/add_clone_item.js"></script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->

</html>