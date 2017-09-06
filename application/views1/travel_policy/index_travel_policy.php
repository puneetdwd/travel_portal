<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Travel Policy
        </h1>
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "travel_policy/add_travel_policy"; ?>">
                <i class="fa fa-plus"></i> Add New Travel Policy
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
                <table class="table" id="make-data-table">
                    <thead>
                        <tr>
                            <th>Service Type</th>
                            <th>Grade</th>
                            <th>Approval Level</th>
                            <th>City Class</th>
                            <th>Amount</th>
                            <th>Popup</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($travel_policy as $data) { ?>
                            <tr>
                                <td><?php
                                    if ($data['service_type'] == "1") {
                                        echo "Flight";
                                    } else if ($data['service_type'] == "2") {
                                        echo "Train";
                                    } else if ($data['service_type'] == "3") {
                                        echo "Car";
                                    } else if ($data['service_type'] == "4") {
                                        echo "Bus";
                                    } else if ($data['service_type'] == "5") {
                                        echo "Hotel";
                                    } else if ($data['service_type'] == "6") {
                                        echo "Daily Allowance";
                                    } else if ($data['service_type'] == "7") {
                                        echo "Daily Conveyance";
                                    }
                                    ?></td>
                                <td><?php echo $data['grade_name']; ?></td>
                                <td><?php echo $data['approval_level']; ?></td>
                                <td><?php echo $data['city_class']; ?></td>
                                <td><?php
                                    if ($data['actual'] == 1) {
                                        echo 'Actual';
                                    } else {
                                        echo $data['amount'];
                                    };
                                    ?></td>
                                <td><?php echo $data['popup']; ?></td>

                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'travel_policy/add_travel_policy/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                            
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Travel Policy as <?php echo $data['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "travel_policy/status/" . $data['id'] . '/' . ($data['status'] == 'active' ? 'inactive' : 'active' ); ?>">
                                        <i class="fa fa-retweet"></i> <?php echo $data['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                    </a>
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