$(document).ready(function() {


$.getJSON( "assets/data/data.json", function( data ) {
  var items = [];
  var html = "";
  $.each( data['list'], function( key, val ) {
    //items.push( "<option value='" + val.iata + "'>" + val.iata + " (" + val.iata + ")</option>" );
    html = html + "<option value='" + val.iata + "'>" + val.label + " (" + val.iata + ")</option>"
    //console.log(val);
    //return false;
  });

  $("#from_city_id").append(html);
  $("#to_city_id").append(html);
  //$("#to_city_id").append(html);
 //console.log(html);
  /*$( "<ul/>", {
    "class": "my-new-list",
    html: items.join( "" )
  }).appendTo( "body" );*/

  //$('#from_location').select2();
  //$('#to_city_id').select2();
});




	// process the form

	// datetimepicker
	$('.form_datetime').datetimepicker({
	    weekStart: 1,
	    todayBtn: 1,
	    startDate:new Date(),
	    autoclose: 1,
	    todayHighlight: 1,
	    startView: 2,
	    forceParse: 0,
	    showMeridian: 1,
	    minView: 1,
	    // format: 'HH:00'
	});
	
	//$('#example').DataTable();

//alert(newDate);
	$('form').submit(function(event) {


		$('#display tbody').empty();
		$('#found').empty();
		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var formData = {
			'departure_date' 		: $('input[name=departure_date]').val(),
			'return_date' 			: $('input[name=return_date]').val(),
			'from_city_id' 			: $( "#from_city_id option:selected" ).val(),
			'to_city_id' 			: $( "#to_city_id option:selected" ).val(),
			'class' 				: $( "#class option:selected" ).val()
			
		};

		// process the form
		$.ajax({
			type 		: 'GET', // define the type of HTTP verb we want to use (POST for our form)
			url 		: 'http://developer.goibibo.com/api/search/?app_id=b6384641&app_key=3143607bd1279532978d34d05ce585ac&format=json&source='+formData['from_city_id']+'&destination='+formData['to_city_id']+'&dateofdeparture=20170820&seatingclass='+formData['class']+'&adults=1&children=0&infants=0&counter=100', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true,
			beforeSend: function() {
        	// setting a timeout
			   $("#ajaxwaiting").show();
			    },
			})
			// using the done promise callback
			.done(function(data) {


				$("#ajaxwaiting").fadeOut(2000);				
				//console.log(data); 
				
				// here we will handle errors and validation messages
				if ( ! data.success) {
					
				$.each(data, function(key, val) {
				//var onwardflights= JSON.stringify(val.onwardflights);
			    var row='';
			    var record='Total Record Found <b>'+val.onwardflights.length+'</b>';
			    $.each(val.onwardflights, function(k, v){

			
			    	row+='<tr>';
			    	row+='<td></td>';
			    	row+='<td>'+v.origin+'</td>';
			    	row+='<td>'+v.destination+'</td>';
			    	row+='<td>'+v.DepartureTime+'</td>';
			    	row+='<td>'+v.ArrivalTime+'</td>';
			    	row+='<td>'+v.duration+'</td>';
			    	row+='<td>'+v.fare.totalfare+'</td>';
			    	row+='</tr>';
			       // $('<tr><td>'+JSON.stringify(v.origin)+'</td></tr>').appendTo('#display body');
			    });


			    $('#display tbody').append(row);
			    $('#found').append(record);
			    //row.appendTo('#display');
			});

				} else {

					$('form').append('<div class="alert alert-success">' + data.message + '</div>');

				}
			})

			// using the fail promise callback
			.fail(function(data) {
				console.log(data);
			});

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

});