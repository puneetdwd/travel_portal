$(document).ready(function () {

    $('.intonly').numeric();
    $('.charonly').alpha({allow: " "});

    var base_url = $('#base_url').val();

    $('[data-toggle="tooltip"]').tooltip();

    $.validator.addMethod('validPancard', function (value, element) {

        if (!is_PAN_Salaried(value) || value.toUpperCase().indexOf('P', 3) == -1) {
            return false;
        }
        return true;
    }, "Please enter valid Pancard");

    $.validator.addMethod('validate-email', function (value, element) {
        //alert(is_unique_email(value, element));
        if (!is_unique_email(value, element)) {

            return true;
        }
        return false;
    }, "Email address already exists. Please enter a unique email.");

    $.validator.addMethod('validPancardCompany', function (value, element) {

        if (!is_PAN(value)) {
            return false;
        }
        return true;
    }, "Please enter valid Pancard");

    $.validator.addMethod('check_password', function (value, element) {

        if (!unique_password(value)) {
            return false;
        }
        return true;
    }, "Please enter Unique Password.");

    $.validator.addMethod('emergency-no', function (value, element) {

        if (!emergency(value)) {
            return false;
        }
        return true;
    }, "Emergency contact no. cannot be same as your Mobile No. entered.");

    $.validator.addMethod('mobile-no', function (value, element) {

        if (!contact_number_check(value)) {
            return false;
        }
        return true;
    }, "Please enter valid mobile number.");

    $.validator.addMethod('end-date', function (value, element) {

        if (!end_date(value)) {
            return false;
        }
        return true;
    }, "End date could not be less than start date.");

    $.validator.addMethod('validDateFormat', function (value, element) {
        var date_new = value.split("-");
        var year = date_new[0];
        var month = date_new[1];
        var day = date_new[2];
        date = new Date(year, month - 1, day), today = new Date();
        var diff = today.getTime() - date.getTime();
        var age = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
        if (!isNaN(date.getTime()) && date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day && date < today && age > 18 && age < 61) {
            return true;
        }

        return false;
    }, "Please enter valid Date");

    $.validator.addMethod('validMarriageDateFormat', function (value, element) {
        var date_new = value.split("-");
        var year = date_new[0];
        var month = date_new[1];
        var day = date_new[2];
        date = new Date(year, month - 1, day), today = new Date();
        var diff = today.getTime() - date.getTime();
        var age = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
        if (!isNaN(date.getTime()) && date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day && date < today) {
            return true;
        }

        return false;
    }, "Please enter valid Date");


    $('#expense-travel-mode').change(function () {
        $selected = $('#expense-travel-mode').val();
        $('#expense-km').val('');
        $('#amount').find('input').val('');

        if ($selected === 'Two Wheeler' || $selected === 'Four Wheeler') {
            $('#expense-km').removeAttr('disabled');
            $('#parking-toll').find('input').removeAttr('disabled');
            $('#kms').find('span.required').show();

            $('#amount').find('input').attr('disabled', 'disabled');
            $('#amount').find('span.required').hide();
            $('#amount').removeClass('has-error');

            calculate_amount();
        } else {
            $('#expense-km').attr('disabled', 'disabled');
            $('#parking-toll').find('input').attr('disabled', 'disabled');

            if ($selected === 'Auto') {
                $('#toll').removeAttr('disabled');
            }

            $('#kms').find('span.required').hide();
            $('#kms').removeClass('has-error');

            $('#amount').find('input').removeAttr('disabled');
            $('#amount').find('span.required').show();

        }

    });

    $('#expense-km').keyup(function () {
        calculate_amount();
    });

    $('#add-lead').click(function () {
        $(".lead-row").find('.row').clone().appendTo("#lead-section");
    });

    $('#add-gec').click(function () {
        $(".gec-row").find('.row').clone().appendTo("#gec-section");
    });

    $('.timesheet-register-for').change(function () {
        var selected = $('.timesheet-register-for:checked').val();

        if (selected === 'working') {
            $('.add-more-projects').show();
            $('.project-items').show();
            $('.reason-row').hide();
        } else {
            $('.add-more-projects').hide();
            $('.project-items').hide();
            $('.reason-row').show();
        }
    });



    $('#has_bill_checkbox').change(function () {
        var has_bill = $('#has_bill_checkbox:checked').val();
        if (has_bill == 1) {
            $('#upload_bill').addClass('required');
        } else {
            $('#upload_bill').removeClass('required');
        }
    });

    $('#dept_head').change(function () {
        var dept_head = $('#dept_head:checked').val();
        //alert(dept_head);
        if (dept_head == 1) {
            $('#sub-dept').attr('disabled', 'disabled');
            $('#reporting-person').attr('disabled', 'disabled');
        } else {
            $('#sub-dept').removeAttr('disabled');
            $('#reporting-person').removeAttr('disabled');
        }
    });

    $.fn.hasExtension = function (exts) {
        return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test($(this).val());
    }

    $('#image').bind('change', function () {

        //var image, file;
        //var _URL = window.URL;

        if ($('#image').hasExtension(['.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG', '.gif', '.GIF'])) {
            //this.files[0].size gets the size of your file.
            var filesize = (this.files[0].size) / 1024;
            //file = this.files[0];
            if (filesize > 1024) {
                $("#image").replaceWith($("#image").val('').clone(true));
                alert("File size is more than 1 MB !");
            } else {
//                image = new Image();
//        
//                image.onload = function() {
//
//                    alert("The image width is " +this.width + " and image height is " + this.height);
//                };
//
//                image.src = _URL.createObjectURL(file);
            }
        } else {
            $("#image").replaceWith($("#image").val('').clone(true));
            alert("Invalid Extension !");

        }

    });

    $('#medical_cert').bind('change', function () {

        //var image, file;
        //var _URL = window.URL;

        if ($('#medical_cert').hasExtension(['.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG', '.gif',
            '.GIF', '.pdf', '.PDF', '.doc', '.DOC', '.docx', '.DOCX'])) {
            //this.files[0].size gets the size of your file.
            var filesize = (this.files[0].size) / 1024;
            //file = this.files[0];
            if (filesize > 1024) {
                $("#medical_cert").replaceWith($("#medical_cert").val('').clone(true));
                alert("File size is more than 1 MB !");
            } else {

            }
        } else {
            $("#medical_cert").replaceWith($("#medical_cert").val('').clone(true));
            alert("Invalid Extension !");

        }

    });


    $('#l-state').change(function () {
        //alert("hi");
        //$('#sub-dept').html( '' );
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var get_city_url = base_url + 'employees/get_indian_cities/' + $(this).val();
        var state = $("#l-state").select2('val');
        //alert();
        $.get(get_city_url, function (response) {
            var results = $.parseJSON(response);
            //console.log(results);
            //var cities = results.name;
            city_dropdown = $('#l-city');
            city_dropdown.removeAttr('disabled');
            if (results.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(results, function () {
                    options_list += "<option value='" + this.id + "'>" + this.name + "</option>";
                });
                //alert(options_list);
                city_dropdown.html(options_list);
            } else {
                city_dropdown.html(options_list);
            }
        })
    });

    $('#p-state').change(function () {
        //alert("hi");
        //$('#sub-dept').html( '' );
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var get_city_url = base_url + 'employees/get_indian_cities/' + $(this).val();
        var state = $("#p-state").select2('val');
        //alert();
        $.get(get_city_url, function (response) {
            var results = $.parseJSON(response);
            //console.log(results);
            //var cities = results.name;
            city_dropdown = $('#p-city');
            city_dropdown.removeAttr('disabled');
            if (results.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(results, function () {
                    options_list += "<option value='" + this.name + "'>" + this.name + "</option>";
                });
                city_dropdown.html(options_list);
            } else {
                city_dropdown.html(options_list);
            }
        })
    });

    $('#state_id').change(function () {
        //alert("hi");
        //$('#sub-dept').html( '' );
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var get_city_url = base_url + 'employees/get_indian_cities_by_id/' + $(this).val();
        var state = $("#state_id").select2('val');
        //alert();
        $.get(get_city_url, function (response) {
            var results = $.parseJSON(response);
            //console.log(results);
            //var cities = results.name;
            city_dropdown = $('#city_id');
            city_dropdown.removeAttr('disabled');
            if (results.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(results, function () {
                    options_list += "<option value='" + this.id + "'>" + this.name + "</option>";
                });
                //alert(options_list);
                city_dropdown.html(options_list);
            } else {
                city_dropdown.html(options_list);
            }
        })
    });

    $('#city_id').change(function () {
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var get_city_url = base_url + 'employees/get_indian_cities_class/' + $(this).val();
        var city = $("#city_id").select2('val');
        $.get(get_city_url, function (response) {
            var results = $.parseJSON(response);
            var class_name = results[0].class;
            $("#class_name").val(class_name);
        })
    });

    $('#hotel_city_id,#accommodation_type').change(function () {
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var hotel_city_id = $("#hotel_city_id").val();
        var accommodation_type = $("#accommodation_type").val();
        var get_city_url = base_url + 'travel_desk/get_hotel_category_by_location/' + hotel_city_id + '/' + accommodation_type;
        var city = $("#hotel_city_id").select2('val');
        $.get(get_city_url, function (response) {
            var results = $.parseJSON(response);
            //console.log(results);
            //var cities = results.name;
            city_dropdown = $('#hotel_provider_id');
            options_list = "<option value='' selected='selected' >Please select </option>";
            if (results.length > 0) {
                $.each(results, function () {
                    options_list += "<option value='" + this.id + "'>" + this.name + "</option>";
                });
                //alert(options_list);
                city_dropdown.html(options_list);
            } else {
                city_dropdown.html(options_list);
            }
        })
    });

    $('#travel_mode').change(function () {
        //$('#sub-dept').html( '' );
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var get_city_url = base_url + 'ajax/get_travel_class_by_mode/' + $(this).val();
        var state = $("#travel_mode").select2('val');
        //alert();
        $.get(get_city_url, function (response) {
            var results = $.parseJSON(response);
            //console.log(results);
            //var cities = results.name;
            travel_class_id = $('#travel_class_id');
            var options_list = '';
            if (results.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(results, function () {
                    options_list += "<option value='" + this.id + "'>" + this.name + "</option>";
                });
                //alert(options_list);
                travel_class_id.html(options_list);
            } else {
                travel_class_id.html(options_list);
            }
        })
    });


    $('#project').change(function () {
        //alert("hi");
        //$('#sub-dept').html( '' );
        var base_url = $('#base_url').val();
        //var replaced = str.replace("%20", " ");
        var get_employee_url = base_url + 'review/get_employee_list/' + $(this).val();
        var project = $("#project").select2('val');
        //alert();
        $.get(get_employee_url, function (response) {
            var results = $.parseJSON(response);
            //console.log(results);
            //var cities = results.name;
            employee_dropdown = $('#employee');
            employee_dropdown.removeAttr('disabled');
            if (results.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(results, function () {
                    options_list += "<option value='" + this.employee + "'>" + this.employee + "</option>";
                });
                employee_dropdown.html(options_list);
            } else {
                employee_dropdown.html(options_list);
            }
        })
    });

    /*$('#project').change(function(){
     //alert("hi");
     //$('#sub-dept').html( '' );
     var base_url = $('#base_url').val();
     //var replaced = str.replace("%20", " ");
     var get_employee_url =  base_url + 'review/get_employee_list/' + $(this).val();
     //var state =  $("#l-state").select2('val');
     //alert();
     $.get(get_employee_url, function(response) {
     var results = $.parseJSON(response);    
     //console.log(results);
     //var cities = results.name;
     employee_dropdown = $('#employee');
     employee_dropdown.removeAttr('disabled');
     if(results.length > 0) {
     options_list = "<option value='' selected='selected' > </option>";
     $.each(results, function(){
     options_list += "<option value='" +  this.employee + "'>" + this.employee + "</option>";
     });
     //alert(options_list);
     employee_dropdown.html(options_list);
     } else {
     employee_dropdown.html(options_list);
     }
     })
     });
     */
    $('#address-check').change(function () {

        var address_check = $('#address-check:checked').val();
        //alert(address_check);
        if (address_check == 1) {
            var a = $("#l-add1").val();
            var b = $("#l-add2").val();
            var c = $("#l-city").select2('val');
            var d = $("#l-state").select2('val');
            var e = $("#l-post").val();
            var f = $("#l-country").val();

            $("#p-add1").val(a);
            $("#p-add2").val(b);
            $("#p-city").select2('val', c);
            $("#p-state").select2('val', d);
            $("#p-post").val(e);
            $("#p-country").val(f);

        } else {
            $("#p-add1").val('');
            $("#p-add2").val('');
            $("#p-city").select2('val', '');
            $("#p-state").select2('val', '');
            $("#p-post").val('');
            $("#p-country").val('');
        }


    });

    $('.pan').blur(function () {
        var pan = $(this).val();
        if (!is_PAN_Salaried(pan)) {
            $(this).next('.help-block').html('Please enter a valid PAN.');
            $(this).parents().eq(1).addClass('has-error');
            $(this).parents().eq(1).removeClass('has-success');
        } else {
            $(this).next('.help-block').css('display', 'none');
            $(this).parents().eq(1).removeClass('has-error');
            $(this).parents().eq(1).addClass('has-success');
        }
    });

    $('.is-pan').blur(function () {
        var pan = $(this).val();
        if (!is_PAN(pan)) {
            $(this).next('.help-block').html('Please enter a valid PAN.');
            $(this).parents().eq(1).addClass('has-error');
            $(this).parents().eq(1).removeClass('has-success');
        } else {
            $(this).next('.help-block').css('display', 'none');
            $(this).parents().eq(1).removeClass('has-error');
            $(this).parents().eq(1).addClass('has-success');
        }
    });



    /*$('#email_check').blur(function(){
     var base_url = $('.page-sidebar-menu .start a').attr('href');
     var encoded_email = encodeURIComponent($(this).val());
     var emp_id = $('#employee-id').length > 0 ? $('#employee-id').val() : '';
     var validate_url = base_url + 'employees/validate_email/' + encoded_email + '/' + emp_id;
     var email_field = $(this);
     
     $.get(validate_url, function(result){
     if(result == 1) {
     email_field.next('.help-block').html('Email address already exists. Please enter a unique email.');
     email_field.parents().eq(1).addClass('has-error');
     email_field.parents().eq(1).removeClass('has-success');
     } else {
     email_field.next('.help-block').css('display','none');
     email_field.parents().eq(1).addClass('has-success');
     email_field.parents().eq(1).removeClass('has-error');
     }
     });
     });*/

    $('#check-email').blur(function () {
        var base_url = $('.page-sidebar-menu .start a').attr('href');
        var encoded_email = encodeURIComponent($(this).val());
        var v_id = $('#vendor-id').length > 0 ? $('#vendor-id').val() : '';
        var validate_url = base_url + 'vendors/validate_email/' + encoded_email + '/' + v_id;
        var email_field = $(this);

        $.get(validate_url, function (result) {
            if (result == 1) {
                email_field.next('.help-block').html('Email address already exists. Please enter a unique email.');
                email_field.parents().eq(1).addClass('has-error');
                email_field.parents().eq(1).removeClass('has-success');
            } else {
                email_field.next('.help-block').css('display', 'none');
                email_field.parents().eq(1).addClass('has-success');
                email_field.parents().eq(1).removeClass('has-error');
            }
        });
    });
    $('#check-email-id').blur(function () {
        var base_url = $('.page-sidebar-menu .start a').attr('href');
        var encoded_email = encodeURIComponent($(this).val());
        var v_id = $('#customer-id').length > 0 ? $('#customer-id').val() : '';
        var validate_url = base_url + 'customers/validate_email/' + encoded_email + '/' + v_id;
        var email_field = $(this);

        $.get(validate_url, function (result) {
            if (result == 1) {
                email_field.next('.help-block').html('Email address already exists. Please enter a unique email.');
                email_field.parents().eq(1).addClass('has-error');
                email_field.parents().eq(1).removeClass('has-success');
            } else {
                email_field.next('.help-block').css('display', 'none');
                email_field.parents().eq(1).addClass('has-success');
                email_field.parents().eq(1).removeClass('has-error');
            }
        });
    });

    $('#username').blur(function () {
        var base_url = $('#base_url').val();
        var username = encodeURIComponent($("#username").val());
        var e_id = $('#employee-id').length > 0 ? $('#employee-id').val() : '';
        var validate_url = base_url + 'employees/usernameExits/' + username + '/' + e_id;
        var username_field = $(this);

        $.get(validate_url, function (result) {
            if (result == 1) {
                username_field.next('.help-block').html('Username already exists. Please enter a unique username.');
                username_field.parents().eq(1).addClass('has-error');
                username_field.parents().eq(1).removeClass('has-success');
            } else {
                username_field.next('.help-block').css('display', 'none');
                username_field.parents().eq(1).addClass('has-success');
                username_field.parents().eq(1).removeClass('has-error');
            }
        });
    });

    $('#employee_id').blur(function () {
        var base_url = $('#base_url').val();
        var employee_id = encodeURIComponent($("#employee_id").val());
        var e_id = $('#employee-id').length > 0 ? $('#employee-id').val() : '';
        var validate_url = base_url + 'employees/employee_idExits/' + employee_id + '/' + e_id;
        var error_field = $(this);

        $.get(validate_url, function (result) {
            if (result == 1) {
                error_field.next('.help-block').html('Employee ID already exists. Please enter a unique Employee Id.');
                error_field.parents().eq(1).addClass('has-error');
                error_field.parents().eq(1).removeClass('has-success');
            } else {
                error_field.next('.help-block').css('display', 'none');
                error_field.parents().eq(1).addClass('has-success');
                error_field.parents().eq(1).removeClass('has-error');
            }
        });
    });

    $('#line-items').on('change', '.product', function () {
        var base_url = $('#base_url').val();
        var product_url = base_url + 'products/get_product/' + $(this).val();
        var product = $(this);
        $.get(product_url, function (result) {
            result = $.parseJSON(result);
            rate = result.rate;
            product.parents('.line-item').find('.rate').val(rate);
        });
    });

    $('input[name=sale_type]').change(function () {
        var base_url = $('#base_url').val();
        var products_url = base_url + 'products/get_products_by_type/' + $(this).val();
        var type = $(this);
        $.get(products_url, function (result) {
            products = $.parseJSON(result);
            products_dropdown = $('.product');
            if (products.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(products, function () {
                    options_list += "<option value='" + this.id + "'>" + this.p_name + "</option>";
                });
                products_dropdown.html(options_list);
            } else {
                products_dropdown.html('');
            }
        });

    });

    $('input[name=discount_type]').change(function () {
        if ($(this).val() == 'Flat') {
            $('#flat').show().attr('disabled', false);
            $('#disc_rate').hide().attr('disabled', true);
            $('.discount_rate').removeAttr('value');
        } else if ($(this).val() == 'Percentage') {
            $('#disc_rate').show().attr('disabled', false);
            $('#flat').hide().attr('disabled', true);
            $('.flat_disc').removeAttr('value');
        }
    });

    /* $('.disc-type').change(function(){
     if($(this).val()=='Flat') {
     $('.flat_item').show().attr('disabled', false);
     $('.disc_rate_item').hide().attr('disabled', true);
     }else if($(this).val()=='Percentage'){
     $('.disc_rate_item').show().attr('disabled', false);
     $('.flat_item').hide().attr('disabled', true);
     } 
     });*/

    $('input[name=sale_type]').change(function () {
        if ($(this).val() == 'Service') {
            $('#service-type').show().attr('disabled', true);
            $('.work-type').show();
            $('#product-type').hide().attr('disabled', false);
            $('#quote-type').show().attr('disabled', true);
        } else {
            $('#product-type').show().attr('disabled', true);
            $('#quote-type').hide().attr('disabled', false);
            $('.work-type').hide();
            $('#service-type').hide().attr('disabled', false);
        }
    });



    $('input[name=refer]').change(function () {
        if ($(this).is(':checked')) {
            $('#attached').show().attr('disabled', true);
        } else {
            $('#attached').hide().attr('disabled', false);
        }
    });

    $('input[name=unpaid]').change(function () {
        if ($(this).is(':checked')) {
            $('#status').show().attr('disabled', true);
        } else {
            $('#status').hide().attr('disabled', false);
        }
    });

    $('input[name=pmnt_collect]').change(function () {
        if ($(this).val() == 'No') {
            $('#status').show().attr('disabled', true);
        } else {
            $('#status').hide().attr('disabled', false);
        }
    });

    $('input[name=discount_on]').change(function () {
        if ($(this).val() == 'overall') {
            $('#discount-type').show().attr('disabled', false);
            $('.discount-item').hide().attr('disabled', true);
            $('.flat_item').hide().attr('disabled', true);
            $('.disc_rate_item').hide().attr('disabled', true);
            $('.overall-disc-fields').show();
            //$('.disc-type').attr('disabled', true);
        } else if ($(this).val() == 'line_item') {
            $('.discount-item').show().attr('disabled', false);
            $('#discount-type').hide().attr('disabled', true);
            $('.overall-disc-fields').hide().attr('disabled', true);
            $(".discount-overall").attr("disabled", true).value = '';
        }
    });



    $('#line-items').on('change', '.working-type', function () {
        if ($(this).val() == 'PT') {

            $(this).parents('.work_as').find('.working-days').show().attr('disabled', false);
        } else {
            $(this).parents('.work_as').find('.working-days').hide().attr('disabled', true);
        }
    });


    $('#line-items').on('change', '.disc-type', function () {

        if ($(this).val() == 'Flat') {
            $(this).parents('.discount-line-item').find('.flat_item').show().attr('disabled', false);
            $(this).parents('.discount-line-item').find('.disc_rate_item').hide().attr('disabled', true);
        } else if ($(this).val() == 'Percentage') {
            $(this).parents('.discount-line-item').find('.disc_rate_item').show().attr('disabled', false);
            $(this).parents('.discount-line-item').find('.flat_item').hide().attr('disabled', true);
        }
    });


    $('#year').change(function () {
        var year = $(this).val();
        if ($(this).val() == '') {
            $('input[name=start_range]').val("");
            $('input[name=end_range]').val("");
        } else {

            $('input[name=start_range]').val(year + "-04-01");
            $('input[name=end_range]').val((parseInt(year) + 1) + "-03-31");

        }
    });

    $('#quarter').change(function () {
        var year = $('#year').val();
        if ($(this).val() == 'first') {
            $('input[name=start_range]').val(year + "-01-01");
            $('input[name=end_range]').val(year + "-03-31");
        } else if ($(this).val() == 'second') {
            $('input[name=start_range]').val(year + "-04-01");
            $('input[name=end_range]').val(year + "-06-30");
        } else if ($(this).val() == 'third') {
            $('input[name=start_range]').val(year + "-07-01");
            $('input[name=end_range]').val(year + "-09-30");
        } else if ($(this).val() == 'fourth') {
            $('input[name=start_range]').val(year + "-10-01");
            $('input[name=end_range]').val(year + "-12-31");
        }
    });

    $('.check').change(function () {

        if ($(this).is(':checked')) {
            $('#reminder').show();
        } else if ($("input.check:checked").length == 0) {
            $('#reminder').hide();
        }

    });

    $('.insight-check').change(function () {

        if ($(this).is(':checked')) {
            $(this).closest('.col-md-12').addClass('col-md-8').removeClass('col-md-12');
            $(this).closest('.modal-body').find('#reminder').show();
        } else if ($("input.check:checked").length == 0) {
            $(this).closest('.col-md-8').addClass('col-md-12').removeClass('col-md-8');
            $(this).closest('.modal-body').find('#reminder').hide();
        }

    });

    $('.check-all').change(function () {
        if ($(this).is(':checked')) {
            $('#reminder').show();
        } else {
            $('#reminder').hide();
        }
    });
    $('.insight-check-all').change(function () {
        if ($(this).is(':checked')) {
            $(this).closest('.col-md-12').addClass('col-md-8').removeClass('col-md-12');
            $(this).closest('.modal-body').find('#reminder').show();
        } else {
            $(this).closest('.col-md-8').addClass('col-md-12').removeClass('col-md-8');
            $(this).closest('.modal-body').find('#reminder').hide();
        }
    });


    $('#dept').change(function () {
        //alert("hi");
        //$('#sub-dept').html( '' );
        var base_url = $('#base_url').val();
        var sub_dept_url = base_url + 'department/sub_dept_index/' + $(this).val();
        var dept_check = base_url + 'department/get_dept_head/' + $(this).val();

        $.get(sub_dept_url, function (response) {
            response = $.parseJSON(response);
            var sub_depts = response.sub_depts;
            sub_dept_dropdown = $('#sub-dept');
            sub_dept_dropdown.removeAttr('disabled');
            if (sub_depts.length > 0) {
                options_list = "<option value='' selected='selected' > </option>";
                $.each(sub_depts, function () {
                    options_list += "<option value='" + this.id + "'>" + this.sub_dept + "</option>";
                });
                sub_dept_dropdown.html(options_list);
            } else {
                sub_dept_dropdown.html('');
            }
        }),
                $.get(dept_check, function (response) {
                    response = $.parseJSON(response);
                    var depts = response.depts;
                    dept_head_checkbox = $('#dept_head_div');

                    if (depts.dept_head > 0) {
                        //alert(depts.dept_head);
                        dept_head_checkbox.css('display', 'none');
                        //$('#sub-dept').attr('disabled','disabled');
                        //$('#reporting-person').attr('disabled','disabled');
                    } else {
                        //alert(0);
                        dept_head_checkbox.css('display', 'block');
                        $('#sub-dept').removeAttr('disabled');
                        $('#reporting-person').removeAttr('disabled');
                    }
                });
    });

    $('#sub-dept').change(function () {
        var desg = $('#designation').val();
        if (desg != '') {
            desg = desg.split(' ')[1];
            var base_url = $('.page-sidebar-menu .start a').attr('href')
            var remote_url = base_url + 'employees/populate_reporting_person/' + $(this).val() + '/' + $('#dept').val() + '/' + desg;
            //alert(remote_url);
            $.get(remote_url, function (response) {
                response = $.parseJSON(response);
                reporting_dropdown = $('#reporting-person');
                reporting_dropdown.removeAttr('disabled');
                if (response.length > 0) {
                    options_list = "";
                    $.each(response, function () {
                        options_list += "<option value='" + this.emp_id + "'>" + this.first_name + ' ' + this.last_name + "</option>";
                    });
                    reporting_dropdown.html(options_list);
                } else {
                    options_list = "<option value='0'>Admin</option>";
                    reporting_dropdown.html(options_list);
                }
            });
        }
    });

    $('#type_of_leave').change(function () {
        var leave_type = $('#type_of_leave').val();
        if (leave_type != '' && leave_type == 'Half Day') {

            $('#comp_offs').css('display', 'none');
            $('#el_leaves').css('display', 'none');
            $('#half_leaves').css('display', 'block');
            $('#start_span').css('display', 'none');

            $('#half_day_extra').css('display', 'none');
            $('#half_day_req').css('display', 'block');
        } else if (leave_type != '' && leave_type == 'Comp-Off') {

            $('#comp_offs').css('display', 'block');
            $('#el_leaves').css('display', 'none');
            $('#half_leaves').css('display', 'none');
            $('#half_day_extra').css('display', 'none');
            $('#start_span').css('display', 'none');

        } else {
            $('#comp_offs').css('display', 'none');
            $('#el_leaves').css('display', 'block');
            $('#half_leaves').css('display', 'none');

            $('#half_day_extra').css('display', 'block');
            $('#half_day_req').css('display', 'none');

            $('#start_span').css('display', 'inline');
        }
    });

    $('.notification-link').click(function (event) {
        event.preventDefault();//.stopPropagation();
        $('#myModal .modal-content').html($('.loading-container').html());
        $('#myModal').modal();
        $('#myModal .modal-content').load($(this).attr('href'));
    });

    $('.ajax-link').click(function (event) {
        event.preventDefault();//.stopPropagation();
        $('#myModal .modal-ajax-content').html($('.loading-container').html());
        $('#myModal form').attr('action', $(this).attr('href'));
        $('#myModal').modal();
        $('#myModal .modal-ajax-content').load($(this).attr('href'));
    });

    $('#designation').change(function () {
        $('#sub-dept').change();
    });

    $('#leave-end-date-picker').on('changeDate', function (e) {

        var first_load = $('#first_load').val();
        //alert(first_load);
        if (first_load == 1) {
            //alert("hi");
            $('#first_load').val(0);
            return false;
        }

        var personal_leave = $('#personal_leave_count').val();
        //alert(personal_leave);
        var medical_leave = $('#medical_leave_count').val();
        var paid_maternity_leave = $('#paid_maternity_leave_count').val();
        var comp_off = $('#comp_off_count').val();
        var full_leaves = $('#available_leaves_count').val();
        var half_leaves = $('#available_half_leaves_count').val();
        var comp_offs = $('#remaining_comp_offs').val();

        var s_date = $('#s_date').val();
        var e_date = $('#e_date').val();
        var type_of_leave = $('#type_of_leave').val();
        var contact_id = $('#contact_id').val();
        var reason = $('#reason').val();
        var half_leave_interval = $('#half_leave_interval').val();
        //alert(edit);
        var t2 = new Date(s_date);
        var t1 = new Date(e_date);

        var days_check = (parseInt((t1 - t2) / (24 * 3600 * 1000)) + 1);

        if (s_date != '' && e_date != '' && type_of_leave != '' && contact_id != '' && (contact_id.length) == 10 && reason != '') {
            $(".leave_from :input[type=submit]").removeAttr('disabled');
        } else {
            $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
        }

        if (type_of_leave == 'Comp-Off') {
            $('#comp_offs').css('display', 'block');
            $('#el_leaves').css('display', 'none');
            $('#half_leaves').css('display', 'none');
            $('#half_day_extra').css('display', 'none');
            $('#start_span').css('display', 'none');

            var cur_date = new Date();
            var start_date = new Date(s_date);
            var end_date = new Date(e_date);
            //alert(start_date+' and '+cur_date);
            if ((start_date.getTime() > end_date.getTime()) || (start_date.getTime() < end_date.getTime())) {
                $('.alert-danger').css('display', 'block');
                document.getElementById("common_error").innerHTML = 'Error : Start and end dates must be same.';
                //$("#s_date").val( '' );
                $("#e_date").val('');
                return 0;
            }
        }

        if (type_of_leave != 'Comp-Off' && type_of_leave != 'Half Day') {
            $('#comp_offs').css('display', 'none');
            $('#el_leaves').css('display', 'block');
            $('#half_leaves').css('display', 'none');

            $('#half_day_extra').css('display', 'block');
            $('#half_day_req').css('display', 'none');

            $('#start_span').css('display', 'inline');
        }

        if (type_of_leave == 'Half Day') {
            $('#comp_offs').css('display', 'none');
            $('#el_leaves').css('display', 'none');
            $('#half_leaves').css('display', 'block');
            $('#start_span').css('display', 'none');

            $('#half_day_extra').css('display', 'none');
            $('#half_day_req').css('display', 'block');

            if (s_date != '' && half_leave_interval != '' && type_of_leave != '' && contact_id != '' && contact_id.length == 10 && reason != '') {
                $(".leave_from :input[type=submit]").removeAttr('disabled');
            } else {
                $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
            }
            return 0;
        }

        if (days_check <= 0) {
            $('.alert-danger').css('display', 'block');
            document.getElementById("common_error").innerHTML = "Error : Start date can never be greater than end date.";
            //$("#s_date").val( '' );
            $("#e_date").val('');
            return 0;
        }
        //alert("here");
        var days = (dateDifference(s_date, e_date) + 1);
        //alert(days);
        if (days > 0) {
            if (type_of_leave == 'Paid Maternity Leave') {
                document.getElementById("leave_count").innerHTML = days_check;
            } else {
                if (s_date != '') {
                    document.getElementById("leave_count").innerHTML = days;
                } else {
                    document.getElementById("leave_count").innerHTML = 0;
                }
            }
        } else {
            $('.alert-danger').css('display', 'block');
            document.getElementById("common_error").innerHTML = "Error : Start date can never be greater than end date.";
            //$("#s_date").val( '' );
            $("#e_date").val('');
            return 0;
        }


        if (type_of_leave == 'Personal Leave' && days > personal_leave) {
            //alert("You can take maximum of 10 days personal leave at a time.");
            $('.alert-danger').css('display', 'block');
            document.getElementById("common_error").innerHTML = 'Error : Maximum ' + personal_leave + ' days of personal leave is allowed.';
            //$("#s_date").val( '' );
            $("#e_date").val('');
            return 0;
        } else if (type_of_leave == 'Paid Maternity Leave' && days_check > paid_maternity_leave) {
            $('.alert-danger').css('display', 'block');
            document.getElementById("common_error").innerHTML = "Error : Maximum " + paid_maternity_leave + " days of paid maternity leave is allowed.";
            //$("#s_date").val( '' );
            $("#e_date").val('');
            return 0;
        } else if (type_of_leave == 'Comp-Off' && days_check > comp_off) {
            $('.alert-danger').css('display', 'block');
            document.getElementById("common_error").innerHTML = "Error : Maximum " + comp_off + " day of comp-off is allowed.";
            //$("#s_date").val( '' );
            $("#e_date").val('');
            return 0;
        } else {
            $('.alert-danger').css('display', 'none');
            //return 0;
        }
        if (type_of_leave == 'Medical Leave' && days > medical_leave) {
            $("#med_cert").css('display', 'block');
        } else {
            $("#med_cert").css('display', 'none');
        }

        if (type_of_leave == 'Half Day' && days_check > half_leaves) {

            bootbox.alert("You do not have sufficient half days available. \nThis half day will deduct from your EL.");

        } else if (type_of_leave == 'Comp-Off' && days_check > comp_offs) {

            bootbox.alert("You do not have sufficient Comp-Offs available.\nYou can not apply for comp-off.");

        } else if (type_of_leave == 'Paid Maternity Leave') {
            return false;
        } else if ((type_of_leave == 'Personal Leave' || type_of_leave == 'Medical Leave') && days_check > personal_leave) {

            bootbox.alert("You do not have sufficient leaves available.\nNow you are applying as LWP.");

        } else if ((type_of_leave == 'Personal Leave') && days_check > full_leaves) {

            bootbox.alert("You do not have sufficient leaves available.\nNow you are applying as LWP.");

        }/*else if((type_of_leave == 'Medical Leave') && days_check > full_leaves){
         
         bootbox.alert("You do not have sufficient leaves available.\nNow you are applying as LWP.");
         }*/
        return false;

    });

    $('.non-dt-checkable-table').find('.group-checkable').change(function () {
        var table = $('.non-dt-checkable-table');

        var set = $(this).attr("data-set");
        var checked = $(this).is(":checked");
        $(set).each(function () {
            if (checked) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
        });
        jQuery.uniform.update(set);
    });

    $('.non-dt-checkable-table-modal').find('.group-checkable').change(function () {
        var table = $('.non-dt-checkable-table');

        var set = $(this).attr("data-set");
        var checked = $(this).is(":checked");
        $(this).closest('.modal-body').find(set).each(function () {
            if (checked) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
        });
        jQuery.uniform.update(set);
    });

    $('.non-dt-checkable-table').on('change', 'tbody tr .checkboxes', function () {
        //$(this).parents('tr').toggleClass("active");
    });

});

function emergency() {
    var contact_id = $('#contact_id').val();
    var emergency = $('#emergency').val();

    if (contact_id == emergency) {

        $('#emergency').value = '';
        $(this).next('.help-block').html('Emergency contact no. cannot be same as your Mobile No. entered.');
        $(this).parents().eq(0).addClass('has-error');
        $(this).parents().eq(0).removeClass('has-success');
        $('#emergency').focus();

        return false;
    } else {
        $(this).next('.help-block').css('display', 'none');
        $(this).parents().eq(0).addClass('has-success');
        $(this).parents().eq(0).removeClass('has-error');
        return true;
    }
}



function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}


function printFile() {
    window.print();
}

function isValidMail(e) {

    var email = $(e).val();
    //var e1 = $(e).parents().eq(2).addClass('has-error');
    //alert(email);
    if (!isValidEmailAddress(email)) {
        //alert('1');
        //$('.help-block').innerHtml('<span for="gi_email" class="help-block">Please enter a valid email address.</span>');
        $(e).parents().eq(1).addClass('has-error');
    } else {
        //alert('2');
        //$('.help-block').css('display','none');
        $(e).parents().eq(1).removeClass('has-error');
        $(e).parents().eq(1).addClass('has-success');
    }
}

function travel_mode(this2) {
    //alert("hi");
    var this1 = $(this2).parents().eq(3);
    $selected = $('#expense-travel-mode1', this1).val();
    //alert($selected);
    $('#expense-km', this1).val('');
    $('#amount', this1).find('input').val('');

    if ($selected === 'Two Wheeler' || $selected === 'Four Wheeler') {
        $('#expense-km1', this1).removeAttr('disabled');
        $('#parking-toll', this1).find('input').removeAttr('disabled');
        $('#kms', this1).find('span.required').show();

        $('#amount', this1).find('input').attr('disabled', 'disabled');
        $('#amount', this1).find('span.required').hide();
        $('#amount', this1).removeClass('has-error');

        calculate_amount1(this1);
    } else {
        $('#expense-km1', this1).attr('disabled', 'disabled');
        $('#parking-toll', this1).find('input').attr('disabled', 'disabled');

        if ($selected === 'Auto') {
            $('#toll', this1).removeAttr('disabled');
        }

        $('#kms', this1).find('span.required').hide();
        $('#kms', this1).removeClass('has-error');

        $('#amount', this1).find('input').removeAttr('disabled');
        $('#amount', this1).find('span.required').show();

    }

}

function calculate_amount() {

    $selected = $('#expense-travel-mode').val();
    $two_wheel = $('#two-wheeler').val();
    $four_wheel = $('#four-wheeler').val();
    //alert($two_wheel);
    //alert($four_wheel);
    //var amount;
    if ($selected === 'Two Wheeler' || $selected === 'Four Wheeler') {
        $exp = $('#expense-km').val();
        //alert($exp);

        if ($exp == '') {
            $amount = 0;
            $('#amount').find('input').val($amount);
            return false;
        }

        if ($selected === 'Two Wheeler') {
            $amount = $exp * $two_wheel;
        } else {
            $amount = $exp * $four_wheel;
        }

        $('#amount').find('input').val($amount);
    }
}

function bill_check(this1) {

    //var image, file;
    //var _URL = window.URL;

    if ($(this1).hasExtension(['.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG', '.gif',
        '.GIF', '.pdf', '.PDF', '.xls', '.XLS', '.xlsx', '.XLSX'])) {
        //this.files[0].size gets the size of your file.
        var filesize = (this.files[0].size) / 1024;
        //file = this.files[0];
        if (filesize > 1024) {
            $(this1).replaceWith($(this1).val('').clone(true));
            alert("File size is more than 1 MB !");
        } else {

        }
    } else {
        $(this1).replaceWith($(this1).val('').clone(true));
        alert("Invalid Extension !");

    }
}

function calculate_amount1(this1) {
    $selected = $('#expense-travel-mode1', this1).val();
    //var amount;
    //alert($selected);
    if ($selected === 'Two Wheeler' || $selected === 'Four Wheeler') {
        $exp = $('#expense-km1', this1).val();
        //alert($exp);
        if ($exp == '') {
            $amount = 0;
            $('#amount1', this1).find('input').val($amount);
            //return false;
        }

        if ($selected === 'Two Wheeler') {
            $amount = $exp * 3;
        } else {
            $amount = $exp * 6;
        }

        $('#amount1', this1).find('input').val($amount);
    }
}

function travel_check() {
    var travel_type = $('#travel_type').val();

    if (travel_type == 'local') {
        $('#per_diem_extra').css('display', 'none');
        $('.items').css('display', 'block');
        $('#end_date').css('display', 'none');

        $("#expense-travel-mode option[value='Air']").remove();
        $("#expense-travel-mode option[value='Train']").remove();

    } else if (travel_type == 'per_diem') {
        $('#per_diem_extra').css('display', 'block');
        $('#end_date').css('display', 'block');
        $('.items').css('display', 'none');
        $("#expense-travel-mode").append(new Option("option Air", "Air"));
        $("#expense-travel-mode").append(new Option("option Train", "Train"));
    } else {
        $('#per_diem_extra').css('display', 'none');
        $('.items').css('display', 'block');
        $('#end_date').css('display', 'block');
        $("#expense-travel-mode").append(new Option("Air", "Air"));
        $("#expense-travel-mode").append(new Option("Train", "Train"));
    }
}

function mobile_check() {
    var contact_id = $('#contact_id').val();

    if (contact_id.length == 10) {
        $('.alert-danger').css('display', 'none');
    } else {
        $('.alert-danger').css('display', 'block');
        document.getElementById("common_error").innerHTML = "Error : Enter Valid Contact Number.";
    }
    return 0;
}

function contact_number_check() {
    var contact_number = $('.mobile-no').val();

    if (contact_number.length == 10) {
        return true;
    } else {
        return false;
    }
    return false;
}

// Expects start date to be before end date
// start and end are Date objects
function dateDifference(start, end) {

    // Copy date objects so don't modify originals
    var s = new Date(start);
    var e = new Date(end);

    //alert("start : "+s+" end : "+e);

    // Set time to midday to avoid dalight saving and browser quirks
    s.setHours(12, 0, 0, 0);
    e.setHours(12, 0, 0, 0);

    // Get the difference in whole days
    var totalDays = Math.round((e - s) / 8.64e7);

    // Get the difference in whole weeks
    var wholeWeeks = totalDays / 7 | 0;

    // Estimate business days as number of whole weeks * 5
    var days = wholeWeeks * 5;

    // If not even number of weeks, calc remaining weekend days
    if (totalDays % 7) {
        s.setDate(s.getDate() + wholeWeeks * 7);

        while (s < e) {
            s.setDate(s.getDate() + 1);

            // If day isn't a Sunday or Saturday, add to business days
            //alert(s.getDay());
            if (s.getDay() != 0 && s.getDay() != 1) {
                ++days;
            }
        }
    }
    return days;
}

function days_count(event, personal_leave, medical_leave, paid_maternity_leave, comp_off, full_leaves, half_leaves, comp_offs) {

    var s_date = $('#s_date').val();
    var e_date = $('#e_date').val();
    var type_of_leave = $('#type_of_leave').val();
    var contact_id = $('#contact_id').val();
    var reason = $('#reason').val();
    var half_leave_interval = $('#half_leave_interval').val();
    //alert(edit);
    var t2 = new Date(s_date);
    var t1 = new Date(e_date);

    var days_check = (parseInt((t1 - t2) / (24 * 3600 * 1000)) + 1);

    event.stopPropagation();
    event.cancelBubble = true;
    event.preventDefault();
    //alert(days_check);

    if (s_date != '' && e_date != '' && type_of_leave != '' && contact_id != '' && (contact_id.length) == 10 && reason != '') {
        $(".leave_from :input[type=submit]").removeAttr('disabled');
    } else {
        $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
    }

    if (type_of_leave == 'Comp-Off') {
        $('#comp_offs').css('display', 'block');
        $('#el_leaves').css('display', 'none');
        $('#half_leaves').css('display', 'none');
        $('#half_day_extra').css('display', 'none');
        $('#start_span').css('display', 'none');

        var cur_date = new Date();
        var start_date = new Date(s_date);
        var end_date = new Date(e_date);
        //alert(start_date+' and '+cur_date);
        if ((start_date.getTime() > end_date.getTime()) || (start_date.getTime() < end_date.getTime())) {
            $('.alert-danger').css('display', 'block');
            document.getElementById("common_error").innerHTML = 'Error : Start and end dates must be same.';
            //$("#s_date").val( '' );
            $("#e_date").val('');
            return 0;
        }
    }

    if (type_of_leave != 'Comp-Off' && type_of_leave != 'Half Day') {
        $('#comp_offs').css('display', 'none');
        $('#el_leaves').css('display', 'block');
        $('#half_leaves').css('display', 'none');

        $('#half_day_extra').css('display', 'block');
        $('#half_day_req').css('display', 'none');

        $('#start_span').css('display', 'inline');
    }

    if (type_of_leave == 'Half Day') {
        $('#comp_offs').css('display', 'none');
        $('#el_leaves').css('display', 'none');
        $('#half_leaves').css('display', 'block');
        $('#start_span').css('display', 'none');

        $('#half_day_extra').css('display', 'none');
        $('#half_day_req').css('display', 'block');

        if (s_date != '' && half_leave_interval != '' && type_of_leave != '' && contact_id != '' && contact_id.length == 10 && reason != '') {
            $(".leave_from :input[type=submit]").removeAttr('disabled');
        } else {
            $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
        }
        return 0;
    }

    if (days_check <= 0) {
        $('.alert-danger').css('display', 'block');
        document.getElementById("common_error").innerHTML = "Error : Start date can never be greater than end date.";
        //$("#s_date").val( '' );
        $("#e_date").val('');
        return 0;
    }
    //alert("here");
    var days = (dateDifference(s_date, e_date) + 1);
    //alert(days);
    if (days > 0) {
        if (type_of_leave == 'Paid Maternity Leave') {
            document.getElementById("leave_count").innerHTML = days_check;
        } else {
            if (s_date != '') {
                document.getElementById("leave_count").innerHTML = days;
            } else {
                document.getElementById("leave_count").innerHTML = 0;
            }
        }
    } else {
        $('.alert-danger').css('display', 'block');
        document.getElementById("common_error").innerHTML = "Error : Start date can never be greater than end date.";
        //$("#s_date").val( '' );
        $("#e_date").val('');
        return 0;
    }
    //alert(days);

    if (type_of_leave == 'Personal Leave' && days > personal_leave) {
        //alert("You can take maximum of 10 days personal leave at a time.");
        $('.alert-danger').css('display', 'block');
        document.getElementById("common_error").innerHTML = 'Error : Maximum ' + personal_leave + ' days of personal leave is allowed.';
        //$("#s_date").val( '' );
        $("#e_date").val('');
        return 0;
    } else if (type_of_leave == 'Paid Maternity Leave' && days_check > paid_maternity_leave) {
        $('.alert-danger').css('display', 'block');
        document.getElementById("common_error").innerHTML = "Error : Maximum " + paid_maternity_leave + " days of paid maternity leave is allowed.";
        //$("#s_date").val( '' );
        $("#e_date").val('');
        return 0;
    } else if (type_of_leave == 'Comp-Off' && days_check > comp_off) {
        $('.alert-danger').css('display', 'block');
        document.getElementById("common_error").innerHTML = "Error : Maximum " + comp_off + " day of comp-off is allowed.";
        //$("#s_date").val( '' );
        $("#e_date").val('');
        return 0;
    } else {
        $('.alert-danger').css('display', 'none');
        //return 0;
    }
    if (type_of_leave == 'Medical Leave' && days > medical_leave) {
        $("#med_cert").css('display', 'block');
    } else {
        $("#med_cert").css('display', 'none');
    }

    //alert(edit);

    if (type_of_leave == 'Half Day' && days_check > half_leaves) {
        alert("You do not have sufficient half days available. \nThis half day will deduct from your EL.");
        //return false;
    } else if (type_of_leave == 'Comp-Off' && days_check > comp_offs) {
        alert("You do not have sufficient Comp-Offs available.\nYou can not apply for comp-off.");
        //return false;
    } else if (type_of_leave == 'Paid Maternity Leave') {
        return false;
    } else if ((type_of_leave == 'Personal Leave') && days_check > personal_leave) {

        alert("You do not have sufficient leaves available.\nNow you are applying as LWP.");

        //return false;
    } else if ((type_of_leave == 'Personal Leave') && days_check > full_leaves) {

        alert("You do not have sufficient leaves available.\nNow you are applying as LWP.");

//        event.stopPropagation();
//        event.cancelBubble = true;
//        event.preventDefault();
        //return false;
    } else if ((type_of_leave == 'Medical Leave') && days_check > full_leaves) {

        bootbox.alert("You do not have sufficient leaves available.\nNow you are applying as LWP.");
        //event.off('alert');
        //event.stopPropagation();
        //event.cancelBubble = true;
        //event.preventDefault();
        //return false;
    }
    return false;

}

function submit_button(personal_leave, medical_leave, paid_maternity_leave, comp_off) {

    var s_date = $('#s_date').val();
    var e_date = $('#e_date').val();
    var type_of_leave = $('#type_of_leave').val();
    var contact_id = $('#contact_id').val();
    var reason = $('#reason').val();
    var half_leave_interval = $('#half_leave_interval').val();

    if (type_of_leave == 'Half Day') {

        document.getElementById("leave_count").innerHTML = 0.5;

        if (s_date != '' && half_leave_interval != '' && type_of_leave != '' && contact_id != '' && contact_id.length == 10 && reason != '') {
            $(".leave_from :input[type=submit]").removeAttr('disabled');
        } else {
            $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
        }
        return 0;
    }

    if (type_of_leave == 'Comp-Off') {
        //alert("here");
        document.getElementById("leave_count").innerHTML = 1;

        if (s_date != '' && type_of_leave != '' && contact_id != '' && contact_id.length == 10 && reason != '') {
            $(".leave_from :input[type=submit]").removeAttr('disabled');
        } else {
            $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
        }
        return 0;
    }

    if (s_date != '' && e_date != '' && type_of_leave != '' && contact_id != '' && contact_id.length == 10 && reason != '') {
        $(".leave_from :input[type=submit]").removeAttr('disabled');
    } else {
        $(".leave_from :input[type=submit]").attr('disabled', 'disabled');
    }
}

function is_PAN(str) {
    if (str == undefined)
        return false;
    str = $.trim(str);
    var m = str.match(/^([A-Za-z]{5})+([0-9]{4})+([A-Za-z]{1})$/);
    return (m && m[0].length == 10);
}

function is_PAN_Salaried(str) {
    if (str == undefined)
        return false;
    str = $.trim(str);
    var m = str.match(/^([A-Za-z]{3})+(P)+([A-Za-z]{1})+([0-9]{4})+([A-Za-z]{1})$/);
    return (m && m[0].length == 10);
}



function show_div() {
    if ($('#trip').val() == 'Round Trip') {
        $('#div2').show();
    } else {
        $('#div2').hide();
    }
}

function show_input() {
    if ($('#request-type').val() == 'Visiting Card') {
        $('#card').show();
        $('#id-card').hide();
        $('#app-request').hide();
        $('#other').hide();
    } else if ($('#request-type').val() == 'ID Card') {
        $('#id-card').show();
        $('#card').hide();
        $('#app-request').hide();
        $('#other').hide();
    } else if ($('#request-type').val() == 'Application/infra Request') {
        $('#app-request').show();
        $('#id-card').hide();
        $('#card').hide();
        $('#other').hide();
    } else if ($('#request-type').val() == 'Others') {
        $('#other').show();
        $('#app-request').hide();
        $('#id-card').hide();
        $('#card').hide();

    } else {
        $('#card').hide();
        $('#id-card').hide();
        $('#app-request').hide();
        $('#other').hide();
    }
}


function calculate_hours(this1) {
    //var hours=new Array();
    //var hours = $('select[name="hours[]"] option:selected').val();
    //var minutes = $('select[name="minutes[]"] option:selected').val();
    var hour = $(this1).val();
    var hour_count = 0;
    var minute_count = 0;
    var extra_hour = 0;

    hour_count = $('#total_hours').val();
    minute_count = $('#total_minutes').val();

    hour_count = parseInt(hour_count);
    minute_count = parseInt(minute_count);

    if (minute_count >= 60) {
        minute_count = minute_count % 60;
        extra_hour = Math.floor(minute_count / 60);
    }
    hour_count = hour_count + hour + extra_hour;

    if (hour_count == 24 && minute_count > 0) {
        //alert("Can't add more than 24 hours !");
    } else if (hour_count > 24) {
        //alert("Can't add more than 24 hours !");
    } else {
        $('#total_hours').attr('value', hour_count);
        $('#total_minutes').attr('value', minute_count);
    }
}

function unique_password() {
    var old_password = $('#old-password').val();
    var new_password = $('#new-password').val();

    if (old_password == new_password) {

        /*$('#new-password').value = '';
         $(this).next('.help-block').html('Your new password cannot be same as your previous password. Please enter a unique Password.');
         $(this).parents().eq(0).addClass('has-error');
         $(this).parents().eq(0).removeClass('has-success');
         $('#new-password').focus();*/

        return false;
    } else {
        /*$(this).next('.help-block').css('display','none');
         $(this).parents().eq(0).addClass('has-success');
         $(this).parents().eq(0).removeClass('has-error');*/
        return true;
    }
}

function is_unique_email(value, email_field) {
    //alert("hi "+email_field);
    var base_url = $('#base_url').val();
    var encoded_email = encodeURIComponent(value);
    var emp_id = $('#employee-id').length > 0 ? $('#employee-id').val() : '';
    var validate_url = base_url + 'employees/validate_email/' + encoded_email + '/' + emp_id;

    $.get(validate_url, function (result) {

        if (result == 1) {
            //alert(result);
            return true;
            /*email_field.next('.help-block').html('Email address already exists. Please enter a unique email.');
             email_field.parents().eq(1).addClass('has-error');
             email_field.parents().eq(1).removeClass('has-success');*/
        } else {
            return false;
            /*email_field.next('.help-block').css('display','none');
             email_field.parents().eq(1).addClass('has-success');
             email_field.parents().eq(1).removeClass('has-error');*/
        }
    });
}

function prev_details() {
    var pf_a = $("input:radio[name=pf_member_1952]:checked").val();
    var pf_b = $("input:radio[name=pf_member_1995]:checked").val();

    if (pf_a === 'Yes' || pf_b === 'Yes') {
        $('#prev_dtl').css('display', 'block');
    } else {
        $('#prev_dtl').css('display', 'none');
    }
    return 0;
}

function internation() {
    var pf_a = $("input:radio[name=is_international_worker]:checked").val();

    if (pf_a === 'Yes') {
        $('#internation').css('display', 'block');
    } else {
        $('#internation').css('display', 'none');
    }
    return 0;
}

function other_c() {
    var pf_a = $("input:radio[name=country]:checked").val();

    if (pf_a === 'India') {
        $('#other_c').css('display', 'none');
    } else {
        $('#other_c').css('display', 'block');
    }
    return 0;
}

function spc_able() {
    var pf_a = $("input:radio[name=specially_abled]:checked").val();

    if (pf_a === 'Yes') {
        $('#spc_able').css('display', 'block');
    } else {
        $('#spc_able').css('display', 'none');
    }
    return 0;
}

     