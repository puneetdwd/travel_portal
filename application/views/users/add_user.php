<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($user) ? 'Edit': 'Add'); ?> User
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."users"; ?>">
                    Manage Users
                </a>
            </li>
            <li class="active"><?php echo (isset($user) ? 'Edit': 'Add'); ?> User</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered user-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> User form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <?php if(isset($user['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">First Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="first_name"
                                        value="<?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="last_name">Last Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="last_name"
                                        value="<?php echo isset($user['last_name']) ? $user['last_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="username">Username
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="username"
                                        value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                <?php if(isset($user['id'])) { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" value="">
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="password">Password
                                            <span class="required">*</span></label>
                                            <input type="password" class="required form-control" name="password" value="">
                                            <span class="help-block">
                                            </span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="user-active-error">
                                        <label class="control-label">Active</label>
                                        <div class="radio-list" data-error-container="#user-active-error">
                                            <label class="radio-inline">
                                            <input type="radio" name="is_active" class="user-active required" 
                                            value="1" <?php if(!isset($user['is_active']) || $user['is_active']) { ?> checked="checked" <?php } ?>>
                                            True </label>
                                            <label class="radio-inline">
                                            <input type="radio" name="is_active" class="user-active required" 
                                            value="0" <?php if(isset($user['is_active']) && !$user['is_active']) { ?> checked="checked" <?php } ?>>
                                            False </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url().'users'; ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>