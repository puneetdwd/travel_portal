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




                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Trip<?php echo " (" . count($request) . ")" ?></a></li>
                            <li><a href="#tab3default" data-toggle="tab">Merge Trip<?php echo " (" . count($merge_request_arr) . ")" ?></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
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
                                                <td><?php // echo $data['bossName'];    ?></td>
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
                            </div>

                            <div class="tab-pane fade" id="tab3default">
                                <table class="table" id="make-data-table">
                                    <thead>
                                        <tr>
                                            <th>Trip ID</th>
                                            <th>EMP ID</th>
                                            <th>Name</th>
                                            <th>Grade</th>
                                            <!--<th>From - To</th>-->
                                            <th>Action By</th>
                                            <th>Claim</th>
                                            <th>Advance</th>
                                            <th>Net Pay</th>
                                            <!--<th>Reason</th>-->
                                            <th class="no_sort" style="width:150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($merge_request_arr as $k => $data) {
                                            ?>
                                            <tr>
                                                <td><?php echo $data['exp_id']; ?></td>
                                                <td><?php echo $data['emp_id']; ?></td>
                                                <th><?php echo $data['requested_name']; ?></th>
                                                <th><?php echo $data['gradeName']; ?></th>
                                                <td><?php echo $data['bossName']; ?></td>
                                                <td><?php echo $data['total_claim']; ?></td>
                                                <td><?php echo $data['less_advance']; ?></td>

                                                <td nowrap>
                                                    <?php if ($data['request_status'] == "7") { ?>
                                                        <a class="btn btn-xs blue" 
                                                           href="<?php echo base_url() . 'audit_desk/merge_expense_pending/' . $data['id']; ?>">
                                                            <i class="fa fa-edit"></i> Trip Audit
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>