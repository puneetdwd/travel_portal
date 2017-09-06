<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Travel Rejected Reason
        </h1>
        <div class="pull-right">    
            <a class="btn grey-cascade" href="<?php echo base_url() . "travel_rejected_reasons/add_travel_reasons"; ?>">
                <i class="fa fa-plus"></i> Add New Travel Rejected Reason
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
                            <th>Rejected Reason</th>
                            <th>Hangout Suggestion</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($travel_reasons as $data) { ?>
                            <tr>
                                <td><?php echo $data['reason']; ?></td>
                                <td><?php echo $data['hangout_suggestion']; ?></td>

                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'travel_rejected_reasons/add_travel_reasons/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                            
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Travel Rejected Reason as <?php echo $data['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "travel_rejected_reasons/status/" . $data['id'] . '/' . ($data['status'] == 'active' ? 'inactive' : 'active' ); ?>">
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