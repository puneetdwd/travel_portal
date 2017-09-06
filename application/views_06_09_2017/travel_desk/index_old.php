<br>
<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            Travel Dashboard
        </h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/today'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($today); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Today
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/tomorrow'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($tomorrow); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Tomorrow
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/comingWeek'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($comingWeek); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Coming Week
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/yesterday'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($yesterday); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Yesterday
                    </div>
                </a>
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
                            <th>Referense ID</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Mobile</th>
                            <th>Reason</th>
                            <th>From</th>
                            <th>To</th>

                            <th>Ticket</th>
                            <th>Hotel</th>
                            <th>Car</th>

                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($request as $k => $data) {
                            ?>
                            <tr>
                                <th><?php echo $data['reference_id']; ?></th>
                                <th><?php echo $data['travallername']; ?></th>
                                <th><?php echo $data['gradeName']; ?></th>
                                <th><?php echo $data['travallerMobile']; ?></th>
                                <td title="<?php echo $data['comment']; ?>"><?php echo $data['reasonOfJourney']; ?></td>
                                <td><?php echo $data['from_city_name']; ?></td>
                                <td><?php echo $data['to_city_name']; ?></td>

                                <th><?php if ($data['trip_ticket'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>
                                <th><?php if ($data['hotel_booking'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>
                                <th><?php if ($data['car_booking'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>

                                <td nowrap>
                                    <?php
                                    if ($data['request_status'] == "3") {
                                        if ($data['bookbyself'] != "1") {
                                            ?>
                                            <a class="btn btn-xs blue-chambray" 
                                               href="<?php echo base_url() . 'travel_desk/booking/' . $data['id']; ?>">
                                                <i class="fa fa-edit"></i> Travel Booking
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>

                                </td>
                            </tr>
                            <?php
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