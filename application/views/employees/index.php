<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Employees
        </h1>
        <div class="pull-right">
            <a href="<?php echo base_url() . "employees/add"; ?>" class="btn grey-cascade">
                <i class="fa fa-plus"></i> Add new Employee
            </a>
        </div>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-ban"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } else if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <?php if (empty($employees)) { ?>
                    <p class="text-center">No Employee exist yet.</p>
                <?php } else { ?>
                    <table class="table" id="make-data-table">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Official Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="no_sort" style="width:230px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $employee) { ?>
                                <tr>
                                    <td><?php echo $employee['employee_id']; ?></td>
                                    <td><?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?></td>
                                    <td><?php echo $employee['gi_email']; ?></td>
                                    <td><?php echo $employee['phone']; ?></td>
                                    <td><?php echo ucwords($employee['status']); ?></td>
                                    <td nowrap>
                                        <a class="btn btn-xs green" 
                                           href="<?php echo base_url() . "employees/view/" . $employee['empID']; ?>">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a class="btn btn-xs purple-plum" 
                                           href="<?php echo base_url() . "employees/add/" . $employee['empID']; ?>">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- <a class="btn default btn-xs red" data-confirm="Are you sure you want to delete this Employee?"
                                                href="<?php echo base_url() . "employees/delete_employee/" . $employee['id']; ?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                        </a> -->

                                        <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this employee as <?php echo $employee['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                           href="<?php echo base_url() . "employees/status/" . $employee['empID'] . '/' . ($employee['status'] == 'active' ? 'inactive' : 'active' ); ?>">
                                            <i class="fa fa-retweet"></i> <?php echo $employee['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>

            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>