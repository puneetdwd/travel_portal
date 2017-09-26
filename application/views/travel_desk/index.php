
<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            Travel Dashboard
        </h1>
    </div>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="col-md-2 col-sm-12 col-xs-3 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/today'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($today); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Today
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-3 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/tomorrow'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($tomorrow); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Tomorrow
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-3 text-center title_div">
                <a href="<?php echo base_url() . 'travel_desk/index/comingWeek'; ?>" class="cutm_theme_blue">
                    <h4><?php echo count($comingWeek); ?></h4>
                    <div class="row cutm_theme_oranger cutm_theme_font cutm_dashbord_box">
                        Coming Week
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-3 text-center title_div">
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
        <div class="col-md-12 col-sm-12 col-xs-12">
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
                            <th class="sorting_desc">Trip ID</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Mobile</th>
                            <th>Reason</th>
                            <th>From</th>
                            <th>To</th>

                            <th>Ticket</th>
                            <th>Hotel</th>
                            <th>Car</th>
                            <th>Travel Expenses</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($request as $k => $data) {
                            $other_manager_expense = $data['other_manager_expense'];
                            if ($data['trip_type'] == '1') {
                                if ($data['travel_ticket'] == '1') {
                                    $trip_ticket = $data['trip_ticket'];
                                } else {
                                    $trip_ticket = 1;
                                }                                
                            } else {
                                if ($data['travel_ticket'] != '2') {
                                    if ($data['travel_ticket'] == '1' && $data['trip_ticket_return'] == '1') {
                                        $trip_ticket = $data['trip_ticket'];
                                    } else {
                                        $trip_ticket = 0;
                                    }
                                } else {
                                    $trip_ticket = 1;
                                }
                            }
                            if ($data['accommodation'] == '1') {
                                $hotel_booking = $data['hotel_booking'];
                            } else {
                                $hotel_booking = 1;
                            }
                            if ($data['car_hire'] == '1') {
                                $car_booking = $data['car_booking'];
                            } else {
                                $car_booking = 1;
                            }
                            
//                            if ($trip_ticket == 1 && $hotel_booking == 1 && $car_booking == 1 && $other_manager_expense == '1') {
//                                
//                            } else {
                                ?>
                                <tr>
                                    <th><?php echo $data['reference_id']; ?></th>
                                    <th><?php echo $data['travallername']; ?></th>
                                    <th><?php echo $data['gradeName']; ?></th>
                                    <th><?php echo $data['travallerMobile']; ?></th>
                                    <td title="<?php echo $data['comment']; ?>"><?php 
                                    if ($data['travel_reason_id'] != "Projects") {
                                        echo $data['reasonOfJourney'];
                                    } else {
                                        echo "Projects (" . $data['project_name'] . ")";
                                    }
                                    ?></td>
                                    <td><?php echo $data['from_city_name']; ?></td>
                                    <td><?php echo $data['to_city_name']; ?></td>

                                    <th><?php if ($data['trip_ticket'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>
                                    <th><?php if ($data['hotel_booking'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>
                                    <th><?php if ($data['car_booking'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>
                                    <th><?php if ($data['other_manager_expense'] == "1") { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php  } ?></th>
                                    <!--<th><?php if(isset($data['others'])) { if ($data['others'] == 1) { ?><span class="glyphicon glyphicon-ok" style="color:green" aria-hidden="true"></span><?php } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } } else { ?><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true"></span><?php } ?></th>-->
                                    <td nowrap>
                                        <?php
                                        if ($data['request_status'] == "3") {
//                                        if ($data['bookbyself'] != "1") {
                                            ?>
                                            <a class="btn btn-xs blue-chambray" 
                                               href="<?php echo base_url() . 'travel_desk/booking/' . $data['id']; ?>">
                                                <i class="fa fa-edit"></i> Travel Booking
                                            </a>
                                            <?php
//                                        }
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php
//                            }
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

<style>
    @media only screen and (max-width: 500px) {
        .title_div{
            margin: 0px;
        }
        .dataTables_filter{
            margin-top: 20px !important;
        }
    }

</style>