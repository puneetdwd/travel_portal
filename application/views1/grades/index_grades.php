<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Grades
        </h1>
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "grades/add_grade"; ?>">
                <i class="fa fa-plus"></i> Add New Grade
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
                            <th>Grades</th>
                            <th>Travel Mode</th>
                            <th>Travel Class</th>
                            <th>Hotel Class</th>
                            <th>Transport Entitlement</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade) { ?>
                            <tr>
                                <td><?php echo $grade['grade_name']; ?></td>
                                <td><?php                                
                                    if ($grade['travel_mode'] == "1") {
                                        echo "Flight";
                                    } else if ($grade['travel_mode'] == "2") {
                                        echo "Train";
                                    } else if ($grade['travel_mode'] == "3") {
                                        echo "Car";
                                    } else if ($grade['travel_mode'] == "4") {
                                        echo "Bus";
                                    } else if ($grade['travel_mode'] == "5") {
                                        echo "Hotel";
                                    }
                                    ?></td>
                                <td><?php echo $grade['travel_class']; ?></td>
                                <td><?php
                                    if ($grade['hotel_class'] == "1") {
                                        echo "1 Star";
                                    } else if ($grade['hotel_class'] == "2") {
                                        echo "2 Star";
                                    } else if ($grade['hotel_class'] == "3") {
                                        echo "3 Star";
                                    } else if ($grade['hotel_class'] == "4") {
                                        echo "4 Star";
                                    } else if ($grade['hotel_class'] == "5") {
                                        echo "5 Star";
                                    } else if ($grade['hotel_class'] == "6") {
                                        echo "6 Star";
                                    } else if ($grade['hotel_class'] == "7") {
                                        echo "7 Star";
                                    }
                                    ?></td>
                                <td><?php echo $grade['car_type']; ?></td>
                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'grades/add_grade/' . $grade['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Grade as <?php echo $grade['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "grades/status/" . $grade['id'] . '/' . ($grade['status'] == 'active' ? 'inactive' : 'active' ); ?>">
                                        <i class="fa fa-retweet"></i> <?php echo $grade['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                    </a>
                                    <!--                                        <a class="btn btn-xs red"  onclick="return confirm('You really want to delete this Grade ?');"
                                                                               href="<?php echo base_url() . 'grades/del_grade/' . $grade['id']; ?>">
                                                                                <i class="fa fa-trash-o"></i> Delete
                                                                            </a>-->
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