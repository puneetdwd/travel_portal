<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Flight Request
        </h1>
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "flight_travel/add_flight_request"; ?>">
                <i class="fa fa-plus"></i> Add New Flight Request
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
                            <th>Departure date</th>
                            <th>Return date</th>
                            <th>Travel Reason</th>
                            <th>Travel Class</th>
                            <th>From Location</th>
                            <th>To Location</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($flight as $data) { ?>
                            <tr>
                                <td><?php echo $data['departure_date']; ?></td>
                                <td><?php echo $data['return_date']; ?></td>
                                <td><?php echo $data['reason']; ?></td>
                                <td><?php echo $data['travel_class']; ?></td>
                                <td><?php echo $data['from_city_name']; ?></td>
                                <td><?php echo $data['to_city_name']; ?></td>

                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'flight_travel/add_flight_request/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                            
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Flight Request Request as <?php echo $data['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "flight_travel/status/" . $data['id'] . '/' . ($data['status'] == 'active' ? 'inactive' : 'active' ); ?>">
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