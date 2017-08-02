<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($train) ? 'Edit' : 'Add'); ?> Train
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
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

                        <?php if (isset($train['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $train['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="train_name">Name:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="name"
                                           value="<?php echo isset($train['name']) ? $train['name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="travel_type" id="" value="2">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'train_category'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>