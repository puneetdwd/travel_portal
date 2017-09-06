<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Email Template
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
                            <!--<th>Sr.No.</th>-->
                            <th>Title</th>
                            <th class="no_sort" style="width:150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
//                        $i=1;
                        foreach ($email_template as $data) { ?>
                            <tr>
                                <!--<td><?php echo $i++; ?></td>-->
                                <td><?php echo $data['title']; ?></td>
                                <td nowrap>                                    
                                    <a class="btn btn-xs purple" 
                                       href="<?php echo base_url() . 'email_template/add_email/' . $data['mail_id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
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