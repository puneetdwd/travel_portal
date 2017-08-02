<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($travel_reasons) ? 'Edit' : 'Add'); ?> Travel Reasons
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

                        <?php if (isset($travel_reasons['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $travel_reasons['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="hotel_name">Reason:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="reason"
                                           value="<?php echo isset($travel_reasons['reason']) ? $travel_reasons['reason'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Hangout Suggestion:
                                        <span class="required">*</span></label>                                        
                                    <input type="text" class="required form-control" name="hangout_suggestion"
                                           value="<?php echo isset($travel_reasons['hangout_suggestion']) ? $travel_reasons['hangout_suggestion'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'travel_reasons'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>