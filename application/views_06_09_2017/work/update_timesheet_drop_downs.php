<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($drop_down_list_by_id) ? 'Edit': 'Add'); ?> Timesheet Drop Downs
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."work/timesheet_drop_down"; ?>">
                    Timesheet Drop Down
                </a>
            </li>
            <li class="active"><?php echo (isset($drop_down_list_by_id) ? 'Edit': 'Add'); ?> Timesheet Drop Downs</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered user-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Timesheet Drop Downs
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
                            <?php } else if(isset($success)) { ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i>
                                   <?php echo $success;?>
                                </div>
                            <?php } ?>

                            <?php if(isset($drop_down['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $drop_down['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Drop Down:
                                            <span class="required">*</span></label>

                                            <select id="type_" name="drop_down_id" class="form-control select2me"
                                                    data-placeholder="Select Drop Down Name ">
                                                    <option></option>
                                                    <?php foreach($drop_down as $dd) { ?>
                                                            <option value="<?php echo $dd['id']; ?>"
                                                                    <?php if($dd['id'] == @$drop_down_list_by_id['drop_down_id']){ echo "selected='selected'"; } ?>>
                                                                    <?php echo $dd['drop_down_name']; ?>
                                                            </option>
                                                    <?php } ?>        
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="drop_down_list">Drop Down List:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="drop_down_list"
                                        value="<?php echo isset($drop_down_list_by_id) ? $drop_down_list_by_id['drop_down_list'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url(); ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>