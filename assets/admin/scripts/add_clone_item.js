/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    var project_line_index = 0;
    var line_index = 1;
    
    $('#project-add-line-item').click(function() {
        project_line_index++;
        //if(line_index <=3){
        $('#project-line-item-clone').find( ".project-line-item" ).clone().appendTo( ".project-items #project-line-items", this ).addClass('project-line-item-'+project_line_index);
        invoice_activate_plugins(project_line_index);
        $('.new-task').attr('id', 'add-line-item-'+project_line_index);
        $('.items1 #line-items1').attr('id', 'line-items-'+project_line_index);
        
        $('.other_phase_div_1').attr('id','other_phase_div_'+project_line_index);
        $('.other_challenge_type_div_1').attr('id','other_challenge_type_div_'+project_line_index);
        $('.other_action_on_div_1').attr('id','other_action_on_div_'+project_line_index);
        $('.other_customer_feedback_div_1').attr('id','other_customer_feedback_div_'+project_line_index);
        //}
        //project_line_index++;
    });

    
    $('.print-invoice').click(function(){
        window.print();
    });
});
var line_index=1;
var project_line_index=1;
var quote_line_index = 1;
var expense=0;
   
if($('.line-item-0').length > 0) {
    line_index = parseInt($('#line-items').children('.line-item').last().attr('class').split(' ').pop().split('-').pop()) + 1;
}

//function project(this1) {
//    
//        project_line_index++;
//        
//        var this2=$(this1).parents().eq(2).children().last().prev().prev();
//        //var this3=$(this1).parents().eq(3);
//        $('#project-line-item-clone').find( ".project-line-item" ).clone().appendTo( ".project-items #project-line-items", this2 ).addClass('project-line-item-'+project_line_index);
//        //invoice_activate_plugins(project_line_index);
//        $('.new-task').attr('id', 'add-line-item-'+project_line_index);
//        $('.items1 #line-items1').attr('id', 'line-items-'+project_line_index);
//    }

function tasks(this1) {
    var this2=$(this1).parents().eq(2).children().last().prev().prev().prev();
    var this3=$(this1).parents().eq(3);
    $('#line-item-clone').find( ".line-item" ).clone().appendTo( this2 ).addClass('line-item-'+line_index);
    var count=$('input:hidden:first',this3).val();
    count=parseInt(count)+1;
    $('.tasks_count',this3).attr('value', count);
    //invoice_activate_plugins(line_index);
    line_index++;
}

// tasks function seems to have changed, so for precautius measures creating a different function.

function add_more_details(element) {
    var line_items_element = $(element).parents().eq(1).prev().find('#line-items');
    //alert(line_items_element);
    //console.log(line_items_element);
    var form_body = $(element).parents().eq(3);
    $('#line-item-clone').find( ".line-item" ).clone().appendTo(line_items_element).addClass('line-item-'+line_index);
    line_items_element.children().last().find('input[name=gender_]').attr('name', 'gender_'+line_index);
    var count=$('input:hidden:first',form_body).val();
    count=parseInt(count)+1;
    $('.tasks_count',form_body).attr('value', count);
    //invoice_activate_plugins(line_index);
    line_index++;
}

function add_expense(this1) {     
    var this2=$(this1).parents().eq(2).children().first();
    var this3=$(this1).parents().eq(2);
    expense++;
    $('#line-item-clone').find( ".line-item" ).clone().appendTo( this2 ).addClass('line-item-'+expense);
    
    $('.line-item-'+expense+' #upload_bill',this3).attr('name', 'bill_file_'+expense);
}
    
function remove_tasks(this1) {
    expense--;
    //alert("hii");
    var base_url = $('#base_url').val();
    //var base_url = 'http://dashboard.crgroup.com:90/CRG/';
    if($(this1).parents('.invoice-item-remove').hasClass('new-item')) {
        var line_item = $(this1).parents('.line-item');
        var class_arr = line_item.attr('class').split(' ');
        var item_class = class_arr.pop().split('-');
        var local_line_index = item_class[item_class.length - 1];
        jQuery.each(line_item.nextAll('.line-item'), function() {
            new_class = class_arr.join(' ') + ' line_item-' + local_line_index;
            $(this).attr('class', new_class);
            $(this).find('input[name^=gender_]').attr('name', 'gender_'+local_line_index);
            local_line_index++;
        });
        line_item.remove();
//        var this3=$(this1).parents('.common_extra');
//        var count=$('.tasks_count',this3).val();
//        //alert(count);
//        count=parseInt(count)-1;
//        alert(count);
//        
//        $('.tasks_count',this3).attr('value', count);
        line_index--;
    } else {
        if(confirm('This action will delete the task permanently. Do you want to continue?')){
            var this2=$(this1).parents().eq(2);
            //var item_id = $(this1).prev('.item-id');
            var task_id=$('input:hidden:first',this2).val();
            //alert(task_id);
            //this2.remove();
            //exit;
            if(task_id > 0) {
                $.get(base_url + 'work/delete_timesheet_tasks/' + task_id, function(result){
                    if(result == 1) {
                        this2.remove();
                        var this3=$(this1).parents().eq(2);
                        var count=$('input:hidden:first',this3).val();
                        count=parseInt(count)-1;
                        $('.tasks_count',this3).attr('value', count);
                        line_index--;
                    }
                });
            } else {
                this2.remove();
            }
        }
    }

    return true;
}

function remove_project(this1) {
        if($(this1).parents('.project-item-remove').hasClass('project-new-item')) {
            $(this1).parents('.project-line-item').remove();
            project_line_index--;
        } else {
            if(confirm('This action will delete the project permanently. Do you want to continue?')){
                var base_url = $('#base_url').val();
                //var base_url = 'http://dashboard.crgroup.com:90/CRG/';
                var this2=$(this1).parents().eq(2);
                //var item_id = $(this1).prev('.item-id');
                var project_id=$(this2).find('input:hidden').eq(1).val();
                var date=$('#date').val();
                //alert('project_id : '+project_id+' and Date : '+date);
                //this2.remove();
                //exit();
                if(project_id > 0) {
                    $.get(base_url + 'work/delete_timesheet_project/' + project_id + '/' + date, function(result){
                        if(result == 1) {
                            this2.remove();
                            project_line_index--;
                        }
                    });
                } else {
                    this2.remove();
                    project_line_index--;
                }
            }
        }
        
        return false;
    }
    
function add_quotes(element) {
    var line_items_element = $(element).parents().eq(1).prev().find('#line-items');
    //alert(line_items_element);
    //console.log(line_items_element);
    var form_body = $(element).parents().eq(3);
    $('#line-item-clone').find( ".line-item" ).clone().appendTo(line_items_element).addClass('line-item-'+quote_line_index);
   
    var count=$('input:hidden:first',form_body).val();
    count=parseInt(count)+1;
    $('.tasks_count',form_body).attr('value', count);
    //invoice_activate_plugins(line_index);
    quote_line_index++;
}

function remove_quote(this1) {
    if($(this1).parents('.quote-item-remove').hasClass('quote-new-item')) {
        $(this1).parents('.line-item').remove();
        quote_line_index--;
    } else {
        if(confirm('This action will delete the Details permanently. Do you want to continue?')){
            var base_url = $('#base_url').val();
            //var base_url = 'http://dashboard.crgroup.com:90/CRG/';
            var this2=$(this1).parents('.line-item');
            //var item_id = $(this1).prev('.item-id');
            var quote_id=$(this2).find('input:hidden').eq(0).val();
           
            //this2.remove();
            //exit();
            
            if(quote_id > 0) {
                $.get(base_url + 'generate_quote/delete_quote_item/' + quote_id + '/' , function(result){
                    if(result == 1) {
                        this2.remove();
                        quote_line_index--;
                    }
                });
            } else {
                this2.remove();
                quote_line_index--;
            }
        }
    }
    
    return false;
}

function disable_type(){
    if($('#ttype').attr('disabled')) 
        $('#ttype').removeAttr('disabled'); 
    else 
        $('#ttype').attr('disabled','disabled');
}

function others_text_box(div, text_box){
    //alert('here');
    if($(text_box).val() == 'Others'){
        $(div).css('display','block');
    }else{
        $(div).css('display','none');
    }
}