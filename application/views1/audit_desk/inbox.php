<br>
<style>
    .table thead tr th{
        font-size: 13px;
    }
    .table tbody tr td{
        font-size: 13px;
    }
</style>
<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            Audit Inbox
        </h1>
    </div>
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
                            <th>Trip ID</th>
                            <th>EMP ID</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>From - To</th>
                            <th>Action By</th>
                            <th>Policy</th>
                            <th>Claim</th>
                            <th>Advance</th>
                            <th>Net Pay</th>
                            <th>Reason</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($request as $k => $data) {
                            ?>
                            <tr>
                                <td><?php echo $data['reference_id']; ?></td>
                                <td><?php echo $data['emp_id']; ?></td>
                                <th><?php echo $data['travallername']; ?></th>
                                <th><?php echo $data['gradeName']; ?></th>
                                <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
                                <td><?php echo $data['bossName']; ?></td>
                                <td><?php // echo $data['bossName'];  ?></td>
                                <td><?php echo $data['total_claim']; ?></td>
                                <td><?php echo $data['less_advance']; ?></td>
                                <td><?php echo $data['recevied_amount']; ?></td>
                                <td><?php
                                    if ($data['travel_reason_id'] != "Projects") {
                                        echo $data['reasonOfJourney'];
                                    } else {
                                        echo "Projects";
                                    };
                                    ?></td>
                                <td nowrap>
                                    <a class="btn btn-xs blue" 
                                       href="<?php echo base_url() . 'audit_desk/expense_pending/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Trip Audit
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>