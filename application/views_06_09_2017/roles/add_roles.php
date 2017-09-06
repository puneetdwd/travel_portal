<link href="<?php echo base_url(); ?>assets/assets/css/plugins.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/assets/js/ui_nestable_list.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/nestable/jquery.nestable.min.js"></script>

<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($grade) ? 'Edit' : 'Add'); ?> Role
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">                        
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <?php if (isset($grade['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $grade['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Role Name:
                                            <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="roles_name"
                                               value="<?php echo isset($roles['roles_name']) ? $roles['roles_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Role Description:<span class="required">*</span></label>
                                        <textarea class="required form-control" name="description" rows="5"><?php echo isset($roles['description']) ? $roles['description'] : ''; ?></textarea>                                        
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!--<div class="dd" id="nestable_list_1">-->
                                    <div id="MainMenu">
                                        <div class="list-group panel">
                                            <?php echo $menu; ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>  
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url() . 'roles'; ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<script type="text/javascript">
    function sel_cehck() {
        alert();
    }
</script>