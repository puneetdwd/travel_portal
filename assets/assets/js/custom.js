/*
 * custom.js
 *
 * Place your code here that you need on all your pages.
 */

"use strict";

$(document).ready(function(){

	//===== Sidebar Search (Demo Only) =====//
	$('.sidebar-search').submit(function (e) {
		//e.preventDefault(); // Prevent form submitting (browser redirect)

		$('.sidebar-search-results').slideDown(200);
		return false;
	});

	$('.sidebar-search-results .close').click(function() {
		$('.sidebar-search-results').slideUp(200);
	});

	//===== .row .row-bg Toggler =====//
	$('.row-bg-toggle').click(function (e) {
		e.preventDefault(); // prevent redirect to #

		$('.row.row-bg').each(function () {
			$(this).slideToggle(200);
		});
	});

	//===== Sparklines =====//

	$("#sparkline-bar").sparkline('html', {
		type: 'bar',
		height: '35px',
		zeroAxis: false,
		barColor: App.getLayoutColorCode('red')
	});

	$("#sparkline-bar2").sparkline('html', {
		type: 'bar',
		height: '35px',
		zeroAxis: false,
		barColor: App.getLayoutColorCode('green')
	});

	//===== Refresh-Button on Widgets =====//

	$('.widget .toolbar .widget-refresh').click(function() {
		var el = $(this).parents('.widget');

		App.blockUI(el);
		window.setTimeout(function () {
			App.unblockUI(el);
			noty({
				text: '<strong>Widget updated.</strong>',
				type: 'success',
				timeout: 1000
			});
		}, 1000);
	});

	//===== Fade In Notification (Demo Only) =====//
	setTimeout(function() {
		$('#sidebar .notifications.demo-slide-in > li:eq(1)').slideDown(500);
	}, 3500);

	setTimeout(function() {
		$('#sidebar .notifications.demo-slide-in > li:eq(0)').slideDown(500);
	}, 7000);
});


/*add by Reena Mori 5-8-16 11:57 am* chart button js*/
function callbar() {
    $("#bar").attr("class", "btn btn-red");
    $("#line").attr("class", "btn btn-blue");
    $("#pie").attr("class", "btn btn-blue");
    drawChart_bar();

}
function callline() {
    $("#bar").attr("class", "btn btn-blue");
    $("#line").attr("class", "btn btn-red");
    $("#pie").attr("class", "btn btn-blue");
    drawChart_line();
}
function callpie() {
    $("#bar").attr("class", "btn btn-blue");
    $("#line").attr("class", "btn btn-blue");
    $("#pie").attr("class", "btn btn-red");
    drawChart_pie();
}
/* end chart button js*/

function show_modal(obj){
    var modal_id=$(obj).attr('href');
    var content=$(modal_id).children('div.modal-dialog').children('div.modal-content');
    var data_url=$(obj).attr('data-url');
    //$(content).html('');
    $.ajax({
        url:data_url ,
        dataType: "html",
        catch : false,
        success: function (data) {
            $(content).html(data);
        }
    });
}
