<br>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($email_template) ? 'Edit' : 'Add'); ?> Email Template
        </h1>
    </div>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <form action="<?php echo base_url('email_template/create'); ?>" role="form" class="validate-form" method="post">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>

                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-times"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($email_template['mail_id'])) { ?>
                            <input type="hidden" name="id" value="<?php echo $email_template['mail_id']; ?>" />
                        <?php } ?>

                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">Title:
                                    <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="title" id="title" class="form-control required" value="<?php echo isset($email_template['title']) ? $email_template['title'] : ''; ?>"><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">Varibales:<span class="required">*</span></label>
                                <div class="col-md-9">
                                    <textarea name="variables" id="variables" rows="5" class="form-control required"><?php echo isset($email_template['variables']) ? $email_template['variables'] : ''; ?></textarea>
                                    <br><br><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">Subject:
                                    <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="subject" id="subject" class="form-control required" value="<?php echo isset($email_template['subject']) ? $email_template['subject'] : ''; ?>"><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">DA Policy Name:
                                    <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <textarea name="mailformat" id="mailformat" rows="8" class="form-control required"><?php echo isset($email_template['emailformat']) ? $email_template['emailformat'] : ''; ?></textarea><br><br>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group"><br>
                                <button class="col-md-offset-4 btn green" type="submit">Submit</button>
                                <a href="<?php echo base_url() . 'email_template'; ?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<script src="<?php echo base_url(); ?>./ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        /*add exam form validation*/
        $('#form_edit_frm').validate({
            // Specify the validation rules
            ignore: [],
            rules: {
                title: "required",
                subject: "required",
//                mailformat: "required",
                mailformat: {
                    required: function ()
                    {
                        CKEDITOR.instances.mailformat.updateElement();
                    }
                },
            },
            // Specify the validation error messages
            messages: {
                title: "Please enter title",
                subject: "Please enter subject",
                mailformat: "Please enter email format"
            },
            ignore: [],
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
<script>
    CKEDITOR.replace('mailformat');
</script>
