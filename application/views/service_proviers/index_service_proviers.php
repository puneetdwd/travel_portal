<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Service Proviers
        </h1>
        <div class="pull-right">
            <a class="btn grey-cascade" href="<?php echo base_url() . "service_proviers/add_service_proviers"; ?>">
                <i class="fa fa-plus"></i> Add New Service Proviers
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
                            <th>Vendor Name</th>
                            <th>Service Type</th>
                            <th>Commisson</th>
                            <th>Location</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($service_proviers as $data) { ?>
                            <tr>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php 
                                if($data['service_type'] == "1") {
                                  echo "Flight";  
                                } else if($data['service_type'] == "2") {
                                  echo "Train";    
                                } else if($data['service_type'] == "3") {
                                  echo "Car";    
                                } else if($data['service_type'] == "4") {
                                  echo "Bus";    
                                } else if($data['service_type'] == "5") {
                                  echo "Hotel";    
                                }
                                ?></td>
                                <td><?php echo $data['amount']; ?></td>
                                <td><?php echo $data['city_name']; ?></td>
                                <td nowrap>
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'service_proviers/add_service_proviers/' . $data['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                            
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this Service Proviers as <?php echo $data['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "service_proviers/status/" . $data['id'] . '/' . ($data['status'] == 'active' ? 'inactive' : 'active' ); ?>">
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