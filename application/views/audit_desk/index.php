<br>
<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            Audit Desk Dashboard
        </h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                    <a href="<?php echo base_url() . 'audit_desk/index/1'; ?>" class="cutm_theme_blue">
                        <h4><?php echo $total_requests; ?></h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            Total
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                    <a href="<?php echo base_url() . 'audit_desk/index/2'; ?>" class="cutm_theme_blue">
                        <h4><?php echo $approved_requests; ?></h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            Completed
                        </div>
                    </a>
                </div>


                <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                    <a href="<?php echo base_url() . 'audit_desk/index/3'; ?>" class="cutm_theme_blue">
                        <h4><?php echo $pending_requests; ?></h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            Pending
                        </div>
                    </a>
                </div>
            </div>
        </div>
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
                            <th>Emp ID</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>From - To</th>
                            <th>Approved By</th>
                            <th>Policy Meet</th>
                            <th>Claim Amount</th>
                            <th>Advance</th>
                            <th>Net Pay</th>
                            <th>Reason</th>
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
                                <td><?php echo $data['from_city_name']." - ".$data['to_city_name']; ?></td>
                                <td><?php echo $data['bossName']; ?></td>
                                <td><?php // echo $data['bossName']; ?></td>
                                <td><?php echo $data['total_claim']; ?></td>
                                <td><?php echo $data['less_advance']; ?></td>
                                <td><?php echo $data['recevied_amount']; ?></td>
                                <td title="<?php echo $data['comment']; ?>"><?php
                                    if ($data['travel_reason_id'] != "Projects") {
                                        echo $data['reasonOfJourney'];
                                    } else {
                                        echo "Projects";
                                    };
                                    ?></td>
                            </tr>
                            <?php
                            if($i == 100) {
                                break;
                            }
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