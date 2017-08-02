var All = function () {

    var handleDataTables = function() {
        var dontSort = [];
        $('#make-data-table thead th').each( function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        // begin second table
        $('#make-data-table').dataTable({
            "aoColumns": dontSort,
            "aLengthMenu": [
                [10, 15, 30, -1],
                [10, 15, 30, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 15,
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            }
        });

        jQuery('#make-data-table_wrapper .dataTables_filter input').addClass("form-control input-small input-inline"); // modify table search input
        jQuery('#make-data-table_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
        jQuery('#make-data-table_wrapper .dataTables_length select').select2({
            showSearchInput : false //hide search box with special css class
        }); // initialize select2 dropdown
    }

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
    }

    var handleMonthPickers = function () {

        if (jQuery().datepicker) {
            $('.month-picker').datepicker({
                rtl: Metronic.isRTL(),
                autoclose: true,
                startView: 'year',
                minViewMode: 'months'
            });
            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
    }

    var handleConfirmBox = function() {
        $('a[data-confirm]').click(function() {
            var elem = $(this);

            bootbox.confirm(elem.attr('data-confirm'), function(result) {
                if(result) {
                    window.location.href = elem.attr('href');
                }
            });

            return false;
        });
    } 

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form3 = $('.validate-form');
        var error3 = $('.alert-danger', form3);
        var success3 = $('.alert-success', form3);

        form3.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },  
                type: {
                    required: true
                }
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.parent(".input-group").size() > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').size() > 0) { 
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                success3.hide();
                error3.show();
                Metronic.scrollTo(error3, -200);
            },

            highlight: function (element) { // hightlight error inputs
               $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

        });

         //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
        $('.validate-form .select2me', form3).change(function () {
            form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });

        $('.validate-form .date-picker .form-control').change(function() {
            form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
        });

    }

    var handleBootstrapSelect = function() {
        $('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
    }

    var handleWysihtml5 = function () {
        if (!jQuery().wysihtml5) {
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../../../assets/admin/plugins/bootstrap-wysihtml5/wysiwyg-color.css"],
                "link": false, //Button to insert a link. Default true
                "image": false, //Button to insert an image. Default true,
            });
        }
    }
    
    var handleSelect2Modal = function () {
        $('.select2_multiple').select2({
            allowClear: true
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleDataTables();
            handleDatePickers();
            handleMonthPickers();
            handleConfirmBox();
            handleValidation3();
            handleBootstrapSelect();
            handleWysihtml5();
            handleSelect2Modal();
            
            if($('.btn-datepicker').length > 0) {
                $('.btn-datepicker').datepicker({
                    rtl: Metronic.isRTL(),
                    autoclose: true,
                    format: "yyyy-mm-dd",
                });

                $('.btn-datepicker').datepicker('update', $('.btn-datepicker').html().replace('<i class="fa fa-calendar"></i> ', '').trim());

                $('.btn-datepicker').datepicker().on('changeDate', function(e){
                    $('.btn-datepicker').html('<i class="fa fa-calendar"></i> '+ e.format('yyyy-mm-dd'));
                    window.location.href = $('#base_url').val()+'work/set_date/'+e.format('yyyy-mm-dd');
                });
            }
        },
        initDashboardDaterange: function () {
            

            if($('#dashboard-report-range').length > 0) {
                $('#dashboard-report-range').daterangepicker({
                        opens: (Metronic.isRTL() ? 'right' : 'left'),
                        showDropdowns: false,
                        showWeekNumbers: true,
                        timePicker: false,
                        timePickerIncrement: 1,
                        timePicker12Hour: true,
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                            'Last 7 Days': [moment().subtract('days', 6), moment()],
                            'Last 30 Days': [moment().subtract('days', 29), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                        },
                        buttonClasses: ['btn btn-sm'],
                        applyClass: ' blue',
                        cancelClass: 'default',
                        format: 'YYYY-MM-DD',
                        separator: ' to ',
                        locale: {
                            applyLabel: 'Apply',
                            fromLabel: 'From',
                            toLabel: 'To',
                            customRangeLabel: 'Custom Range',
                            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            firstDay: 1
                        }
                    },
                    function (start, end) {
                        $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        window.location.href = $('#base_url').val()+'work/set_date/'+start.format('YYYY-MM-DD')+'/'+end.format('YYYY-MM-DD');
                    }
                );

                $('#dashboard-report-range').data('daterangepicker').setStartDate($('#timesheet_start').val());
                $('#dashboard-report-range').data('daterangepicker').setEndDate($('#timesheet_end').val()); 
                $('#dashboard-report-range span').html($('#timesheet_start_str').val() + ' - ' + $('#timesheet_end_str').val());
                $('#dashboard-report-range').show();
            }
        }
        
    };
    

}();