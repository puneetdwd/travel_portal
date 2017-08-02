<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Hotel Category
        </h1>
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "hotel_category/add_hotel"; ?>">
                <i class="fa fa-plus"></i> Add New Hotel
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
                            <th>Hotel/GH Name</th>
                            <th>Location</th>
                            <th>Minimum Room Rant</th>
                            <th>Hotel/GH Category</th>
                            <th>Type</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hotel as $data) { ?>
                            <tr>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['city_name']; ?></td>
                                <td><?php echo $data['amount']; ?></td>
                                <td><?php 
                                if($data['category'] == "1") {
                                  echo "1 Star";  
                                } else if($data['category'] == "2") {
                                  echo "2 Star";    
                                } else if($data['category'] == "3") {
                                  echo "3 Star";    
                                } else if($data['category'] == "4") {
                                  echo "4 Star";    
                                } else if($data['category'] == "5") {
                                  echo "5 Star";    
                                } else if($data['category'] == "6") {
                                  echo "6 Star";    
                                } else if($data['category'] == "7") {
                                  echo "7 Star";    
                                }
                                ?></td>
                                <td><?php 
                                if($data['type'] == "2") {
                                  echo "Guest House";  
                                } else if($data['type'] == "1") {
                                  echo "Hotel";    
                                }
                                ?></td>
                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'hotel_category/add_hotel/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                            
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Hotel as <?php echo $data['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "hotel_category/status/" . $data['id'] . '/' . ($data['status'] == 'active' ? 'inactive' : 'active' ); ?>">
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