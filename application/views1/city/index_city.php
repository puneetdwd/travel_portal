<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage City
        </h1>
        <!--        <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li class="active">City</li>
                </ol>-->
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "city/add_city"; ?>">
                <i class="fa fa-plus"></i> Add New City
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
                            <th>State</th>
                            <th>City</th>
                            <th>Class</th>
                            <th>Cost Center</th>
                            <th>Guest House</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($city as $data) { ?>
                            <tr>
                                <td><?php echo $data['state_name']; ?></td>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['class']; ?></td>
                                <td><?php echo $data['cost_center']; ?></td>
                                <td><?php
                                    if ($data['guest_house'] == "1") {
                                        echo "Yes";
                                    } else if ($data['guest_house'] == "2") {
                                        echo "No";
                                    };
                                    ?></td>


                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'city/add_city/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                            
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this City as <?php echo $data['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "city/status/" . $data['id'] . '/' . ($data['status'] == 'active' ? 'inactive' : 'active' ); ?>">
                                        <i class="fa fa-retweet"></i> <?php echo $data['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>