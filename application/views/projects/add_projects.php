<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($grade) ? 'Edit' : 'Add'); ?> Project
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

                        <?php if (isset($project['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $project['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Project Name:
                                        <span class="required">*</span></label>
                                    <input type="text" class="required form-control" name="name"
                                           value="<?php echo isset($project['name']) ? $project['name'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="add-designation-level-error">
                                    <label class="control-label" for="band">Department:
                                        <span class="required">*</span></label>
                                    <?php  $department_id = (!empty($project['dept_id']) ? $project['dept_id'] : ''); ?>
                                    <select name="dept_id" class="form-control required select2me"
                                            data-placeholder="Select Department" data-error-container="#add-designation-level-error">
                                        <option value=""></option>                                        
                                        <?php foreach ($department as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>" 
                                                    <?php if ($department_id == $data['id']) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $data['dept_name']; ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'projects'; ?>" class="btn default">Cancel</a>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>