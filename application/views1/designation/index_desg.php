<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Designations
        </h1>
        <!--        <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li class="active">Designations</li>
                </ol>-->
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "designation/add_desg"; ?>">
                <i class="fa fa-plus"></i> Add New Designation
            </a>
        </div>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-times"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } else if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <!--                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-reorder"></i>Designations
                                                    </div>
                                                    <div class="actions">
                                                        <a class="btn grey-cascade" href="<?php echo base_url() . "designation/add_desg"; ?>">
                                                            <i class="fa fa-plus"></i> Add New Designation
                                                        </a>
                                                    </div>
                                                </div>-->
                <!--<div class="portlet-body">-->

                <table class="table" id="make-data-table">
                    <thead>
                        <tr>
                            <th>Designations</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($desgs as $desg) { ?>
                            <tr>
                                <td><?php echo $desg['desg_name']; ?></td>

                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'designation/add_desg/' . $desg['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Designation as <?php echo $desg['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "designation/status/" . $desg['id'] . '/' . ($desg['status'] == 'active' ? 'inactive' : 'active' ); ?>">
                                        <i class="fa fa-retweet"></i> <?php echo $desg['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                    </a>
                                    <!--                                        <a class="btn btn-xs red"  onclick="return confirm('You really want to delete this Designation ?');"
                                                                               href="<?php echo base_url() . 'designation/del_desg/' . $desg['id']; ?>">
                                                                                <i class="fa fa-trash-o"></i> Delete
                                                                            </a>-->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


                <!--</div>-->
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>