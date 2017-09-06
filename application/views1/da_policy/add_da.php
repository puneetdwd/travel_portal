<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($dept) ? 'Edit' : 'Add'); ?> DA Policy
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
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

                            <?php if (isset($dept['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $dept['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">DA Policy Name:
                                            <span class="required">*</span></label>
                                            <textarea name="policy_name" id="policy_name" rows="4" class="form-control required"><?php echo isset($dept['dept_name']) ? $dept['dept_name'] : ''; ?></textarea>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url() . 'da_policy'; ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>