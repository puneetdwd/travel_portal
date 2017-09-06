<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($budget) ? 'Edit' : 'Add'); ?> Budget
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

                        <?php if (isset($budget['id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $budget['id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="hotel_name">Department:
                                        <span class="required">*</span></label>
                                    <select id="department_id"  name="department_id" class="form-control required select2me"
                                            data-placeholder="Select a Department">
                                        <option value=''></option>
                                        <?php $department_id = !empty($budget['department_id']) ? $budget['department_id'] : ''; ?>
                                        <?php foreach ($department as $data) { ?>
                                            <option value="<?php echo $data['id']; ?>"
                                                    <?php if ($data['id'] == $department_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $data['dept_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Financial Year:
                                        <span class="required">*</span></label>               
                                    <?php echo isset($budget['financial_year']) ? $budget['financial_year'] : ''; ?>
                                    <select id="financial_year"  name="financial_year" class="form-control required select2me"
                                            data-placeholder="Select a Cost Center">
                                        <option value=''></option>
                                        <?php $financial_year = !empty($budget['financial_year']) ? $budget['financial_year'] : ''; ?>
                                        <?php
                                        $i = date('Y');
                                        $i--;
                                        for ($i; $i <= date('Y'); $i++) {
                                            ?>
                                            <option value="<?php echo $i; ?>"
                                                    <?php if ($i == $financial_year) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $i; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class ="form-group">
                                    <label class="control-label">Cost Center                                                
                                        <span class="required"> * </span></label>
                                    <select id="cost_center_id"  name="cost_center_id" class="form-control required select2me"
                                            data-placeholder="Select a Cost Center">
                                        <option value=''></option>
                                        <?php $cost_center_id = !empty($budget['cost_center_id']) ? $budget['cost_center_id'] : ''; ?>
                                        <?php foreach ($cost_center as $cost) { ?>
                                            <option value="<?php echo $cost['id']; ?>"
                                                    <?php if ($cost['id'] == $cost_center_id) { ?> selected="selected" <?php } ?>
                                                    >
                                                        <?php echo $cost['city_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="class">Budget:
                                        <span class="required">*</span></label>                                        
                                        <input type="number" class="required form-control intonly" name="budget"
                                           value="<?php echo isset($budget['budget']) ? $budget['budget'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($budget['id'])) { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="class">Remain Budget:
                                            <span class="required">*</span></label>                                        
                                        <input type="number" class="required form-control intonly" name="remain_budget"
                                               value="<?php echo isset($budget['remain_budget']) ? $budget['remain_budget'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-actions">
                        <button class="btn green" type="submit">Submit</button>
                        <a href="<?php echo base_url() . 'budget'; ?>" class="btn default">Cancel</a>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>