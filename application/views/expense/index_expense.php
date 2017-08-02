<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Expense
        </h1>
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
                            <th>Referense ID</th>
                            <th>Travel Reason</th>
                            <th>Departure date</th>
                            <th>Return date</th>
                            <th>Service</th>
                            <th>Travel Description</th>
                            <th>Approved by</th>
                            <th>Status</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($request as $data) { ?>
                            <tr>
                                <td><?php echo $data['reference_id']; ?></td>
                                <td><?php echo $data['reason']; ?></td>
                                <td><?php echo $data['departure_date']; ?></td>
                                <td><?php
                                    if ($data['return_date'] != "0000-00-00 00:00:00") {
                                        echo $data['return_date'];
                                    }
                                    ?></td>
                                <td><?php
                                    if ($data['travel_type'] == "1") {
                                        echo "Flight";
                                    } else if ($data['travel_type'] == "2") {
                                        echo "Train";
                                    } else if ($data['travel_type'] == "3") {
                                        echo "Car";
                                    } else if ($data['travel_type'] == "4") {
                                        echo "Bus";
                                    } else if ($data['travel_type'] == "5") {
                                        echo "Hotel";
                                    }
                                    ?></td>
                                <td><?php echo $data['from_city_name'] . " - " . $data['to_city_name']; ?></td>
                                <td><?php echo $data['reporting_manager_name']; ?></td>
                                <td nowrap>
                                    <?php
                                   if ($data['request_status'] == "5") {
                                        if ($data['expense_status'] == "Pending") {
                                            ?>
                                            <span class="btn btn-xs blue" <i class="fa fa-eye"></i> Pending </span>               
                                            <?php
                                        }
                                    } else if ($data['request_status'] == "6") {
                                        if ($data['expense_status'] == "Approved") {
                                            ?>
                                            <span class="btn btn-xs blue" <i class="fa fa-eye"></i> Approved </span>               
                                            <?php
                                        } else if ($data['expense_status'] == "Rejected") {
                                            ?>
                                            <span class="btn btn-xs red" <i class="fa fa-eye"></i> Rejected </span>               
                                            <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td nowrap>
                                    <?php
                                    if ($data['request_status'] == "4") {
                                        ?>
                                        <a class="btn btn-xs purple" 
                                           href="<?php echo base_url() . 'expense/claim/' . $data['id']; ?>">
                                            <i class="fa fa-eye"></i> Claim Expense
                                        </a>               
                                        <?php
                                    }
                                    ?>
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="frm_title">Cancellation Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to Cancel this Trip?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Cancel</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
        });

    });
</script>