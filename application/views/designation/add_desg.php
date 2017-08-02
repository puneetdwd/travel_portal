<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($desg) ? 'Edit' : 'Add'); ?> Designation
        </h1>
<!--        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url() . "designation"; ?>">
                    Designations
                </a>
            </li>
            <li class="active"><?php echo (isset($desg) ? 'Edit' : 'Add'); ?> Designation</li>
        </ol>-->

    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
<!--                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Designation
                    </div>
                </div>-->

                <!--<div class="portlet-body form">-->
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

                            <?php if (isset($desg['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $desg['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Designation Name:
                                            <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="desg_name"
                                               value="<?php echo isset($desg['desg_name']) ? $desg['desg_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url() . 'designation'; ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>