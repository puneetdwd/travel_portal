<div class="page-content">

    <div class="">
        <div class="">
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger">
                    <i class="icon-remove"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } else if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <h4><b>Travel Request</b></h4>
                    <div class="col-md-2 col-xs-3 text-center title_div"> 
                        <h4><?php echo $total_request; ?></h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            TOTAL
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-3 text-center title_div"> 
                        <h4><?php echo $approved_request; ?></h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            APPROVED
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-3 text-center title_div"> 
                        <h4><?php echo $pending_request; ?></h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            PENDING
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <h4><b>Expense Claim</b></h4>
                    <div class="col-md-2 col-xs-3 text-center title_div"> 
                        <h4>0</h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            TOTAL
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-3 text-center title_div"> 
                        <h4>0</h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            SETTLED
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-3 text-center title_div"> 
                        <h4>0</h4>
                        <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                            PENDING
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption cutm_theme_font">
                                <i class="fa fa-reorder"></i>My Travel Request
                            </div>
                            <div class="actions">
                                <a class="" href="<?php echo base_url() . "employee_request/index"; ?>">View All</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php foreach ($last_few_request as $key => $value) {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="col-md-10"><b><?php echo $value['from_city_name'] . " -> " . $value['to_city_name']; ?></b>
                                            (<?php
                                            if ($value['approval_status'] == "Rejected") {
                                                echo "Rejected";
                                            } else if ($value['cancel_status'] == "1") {
                                                echo "Cancelled";
                                            } else {
                                                if ($value['request_status'] == "1") {
                                                    echo "Approval Pending";
                                                } else if ($value['request_status'] == "2") {
                                                    if ($value['approval_status'] == "Approved") {
                                                        echo "Trip Approved";
                                                    }
                                                } else if ($value['request_status'] == "3") {
                                                    echo "Trip Accommodation";
                                                } else if ($value['request_status'] == "4") {
                                                    echo "Expense Approval";
                                                } else if ($value['request_status'] == "5") {
                                                    echo "Expense Approval";
                                                } else if ($value['request_status'] == "6") {
                                                    echo "Finance Approval";
                                                } else if ($value['request_status'] == "7") {
                                                    echo "Completed";
                                                }
                                            }
                                            ?>)
                                        </span>
                                        <a href="<?php echo base_url('employee_request/view/') . '/' . $value['id']; ?>" class="col-md-2">Details</a>
                                    </div>
                                </div>
                                <hr>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption cutm_theme_font">
                                <i class="fa fa-reorder"></i>My Inbox
                            </div>
                            <div class="actions">
                                <a class="" href="<?php echo base_url() . "employee_request/index"; ?>">View All</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php foreach ($last_few_task as $key => $value) {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="col-md-10"><b><?php echo $value['from_city_name'] . " -> " . $value['to_city_name']; ?></b><?php
                                            if ($value['request_status'] == "3") {
                                                echo "(Travel Booking)";
                                            } else if ($value['request_status'] == "4") {
                                                echo "(Expense Claim)";
                                            }
                                            ?></span>
                                        <a href="<?php echo base_url('employee_request/view/') . '/' . $value['id']; ?>" class="col-md-2">Details</a>
                                    </div>
                                </div>
                                <hr>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


