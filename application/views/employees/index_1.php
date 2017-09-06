<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Employees
        </h1>
        <div class="pull-right">
            <a href="<?php echo base_url() . "employees/add"; ?>" class="btn grey-cascade">
                <i class="fa fa-plus"></i> Add new Employee
            </a>
        </div>
    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-ban"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } else if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>

            <div class="portlet light bordered">
                <?php // if (empty($employees)) { ?>
                    <!--<p class="text-center">No Employee exist yet.</p>-->
                <?php // } else { ?>
                    <!--<table class="table" id="make-data-table">-->
                <table class="table" id="data-table">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Official Email</th>
<!--                                <th>Phone</th>
                            <th>Status</th>-->
                            <!--<th class="no_sort" style="width:230px;"></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee) { ?>
                            <tr>
                                <td><?php echo $employee['employee_id']; ?></td>
                                <td><?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?></td>
                                <td><?php echo $employee['email']; ?></td>
                                <td><?php echo $employee['phone']; ?></td>
                                <td><?php echo ucwords($employee['status']); ?></td>
                                <td nowrap>
                                    <a class="btn btn-xs green" 
                                       href="<?php echo base_url() . "employees/view/" . $employee['empID']; ?>">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a class="btn btn-xs purple-plum" 
                                       href="<?php echo base_url() . "employees/add/" . $employee['empID']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to mark this employee as <?php echo $employee['status'] == 'active' ? 'inactive' : 'active'; ?> ?');"
                                       href="<?php echo base_url() . "employees/status/" . $employee['empID'] . '/' . ($employee['status'] == 'active' ? 'inactive' : 'active' ); ?>">
                                        <i class="fa fa-retweet"></i> <?php echo $employee['status'] == 'active' ? 'Mark Inactive' : 'Mark Active'; ?>
                                    </a>

                                    <!-- <a class="btn default btn-xs red" data-confirm="Are you sure you want to delete this Employee?"
                                            href="<?php echo base_url() . "employees/delete_employee/" . $employee['id']; ?>">
                                            <i class="fa fa-trash-o"></i> Delete
                                    </a> -->


                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php // } ?>

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
                <h4 class="modal-title" id="frm_title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Employee?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteproduct(obj, id) {
        var title;
        title = obj.attr('data-title');
        $.confirm({
            title: title,
            text: "Are you really sure to delete it?",
            confirm: function () {
                deleteAjax(id);
            },
            cancel: function () {},
            post: true,
            confirmButton: "Yes",
            cancelButton: "No",
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-primary",
            dialogClass: "modal-dialog" // Bootstrap classes for large modal
        });
    }


    $(document).ready(function () {
        //Start: Load datatable content using ajax calling
        table = $('#data-table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('employees/ajax_list'); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [3], //last column
                    "orderable": false, //set not orderable
                },
            ],
        });

        //redirect for delete
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
        });
        
        $(document).on("click", ".best_seller", function () {
            var product_id = $(this).data("id");
            var best_seller = "no";
            if ($(this).is(":checked")) {
                best_seller = "yes";
            }
            $.ajax({
                "url": "product/make_best_seller",
                "method": "post",
                "data": {product_id: product_id, is_best_seller: best_seller},
                "success": function () {

                }
            });
        });
    });

    // Delete Product
    function deleteAjax(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>admin/product/delete",
            data: {id: id},
            success: function (result) {
                location.reload();
                $.growl.notice({title: "Success", message: "Product Deleted successfully"});
            }
        });
    }
</script>
