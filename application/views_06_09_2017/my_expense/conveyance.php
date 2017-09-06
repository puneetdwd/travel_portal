<div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <!-- BEGIN FORM-->
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

                <div class="form-body">

                    <div class="row">
                                                            <div class="col-md-4 portlet light bordered paddingBottom10 set-boxes">
                                        <?php if(!empty(($request))){?>
                                        <h4 class="form-section marginLeft15">
                                            <spam class="cutm_lbl btn_blue">
                                               Add Convenyance Expenses
                                            </spam> <br/> <br/>
											<span style="color:#999999; font-size:15px;"> Pls add your convenyance expenses of trip to claim  </span>
                                        </h4>
                                        <form action="<?php echo base_url('my_expense/conveyance'); ?>"  enctype="multipart/form-data" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                   
                                                    <div class="form-group col-xs-12">
                                                        <label class="control-label text-left-imp">Trip ID<span class="required" aria-required="true"> * </span>:</label>                                    
                                                       <select id="request_id" name="request_id" class="form-control required"  onchange='findRefrenceId()'>
                                                        <option value="">Select Trip ..</option>
                                                        <?php 
                                                        if(isset($request)){
                                                        foreach($request as $requestRefrenceId){?>
                                                        <option value="<?php echo $requestRefrenceId['id'];?>">
														<?php echo $requestRefrenceId['reference_id'];?> (<?php echo $requestRefrenceId['from_city_name'] .' To  ' .
														$requestRefrenceId['to_city_name'];
														?>) </option>
                                                        <?php } }?>
                                                        </select>
                                                        <input type="hidden" name="reference_id" id="reference_id" value="" >
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label class="control-label text-left-imp">Date of Expense<span class="required" aria-required="true"> * </span>:</label>                                    
                                                        <div class="input-group date form_datetime">
                                                        <input name="expanse_date" id="expanse_date"  class="form-control" size="16" type="text" value="" readonly>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-xs-12">
                                                        <label class="control-label text-left-imp">Book By<span class="required" aria-required="true"> * </span>:</label>                                    
                                                        <select name="book_by"  class="form-control">
                                              <option value="Ola">Ola</option>
                                                <option value="Uber">Uber</option>
                                                    <option value="Auto">Auto</option>
                                                </select>
                                                    </div>
                                                    
                                                     <div class="form-group col-xs-12">
                                                        <label class="control-label text-left-imp">From Location<span class="required" aria-required="true"> * </span>:</label>                                    
                                                        <input class="form-control required" name="from_location" aria-required="true" id="from_location" type="text">
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group col-xs-12">
                                                        <label class="control-label text-left-imp">To Location<span class="required" aria-required="true"> * </span>:</label>                                    
                                                        <input class="form-control required" name="to_location" aria-required="true" id="to_location" type="text">
                                                    </div>
                                                    
                                                    
                                                
                                                 <div class="form-group col-xs-12">
                                                 <label class="control-label text-left-imp">Paid By<span class="required" aria-required="true"> * </span>:</label>                                    
                                                <select name="arrange_by"  class="form-control">
                                              <option value="Own">Own</option>
                                                <option value="Company">Company</option>
                                                </select>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group col-xs-12">
                                                 <label class="control-label text-left-imp">Amount<span class="required" aria-required="true"> * </span>:</label>                                     <input class="form-control required" name="amount" aria-required="true" id="amount" type="number">
                                               
                                                    </div>
                                                    
                                                   

                                                    <div class="form-group col-xs-12">
                                                        <label class="control-label text-left-imp">Attach:</label>                                                                            
                                                        <input class="form-control " name="flight_attachment" type="file">
                                                    </div>
                                                    <div class="form-actions col-xs-12">     
                                                        <label class="control-label text-left-imp">&nbsp;</label>
                                                       
                                                        <button class="btn green form-control" type="submit" name="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </form>
                                        <?php }else{ ?>
                                        <h4 class="form-section marginLeft15">
                                            <spam class="cutm_lbl btn_red">
                                               You have not active Trip
                                            </spam> <br/> <br/>
											
                                        </h4>
                                        <?php }  ?>
                                    </div>
                                                                                                            
                                            </div>
                                    </div>

            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>







<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" ?>" charset="UTF-8"></script>
<?php $request['departure_date'] =date('Y-m-d H:i:s');
$request['return_date']= '';
$request['trip_type'] = '';
 ?>
<?php
if ($request['trip_type'] != "1") {
    $return_date = $request['return_date'];
} else {
    $return_date = '';
}
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCdGlqSgU-wNjCn6_mig33UF5yv5QB7tqI"></script>

<script type="text/javascript">

		 function initialize() {
			var input = document.getElementById("from_location");
			var autocomplete = new google.maps.places.Autocomplete(input);
			google.maps.event.addDomListener(window, 'load', initialize);
			
			
			var input = document.getElementById("to_location");
			var autocomplete = new google.maps.places.Autocomplete(input);
			google.maps.event.addDomListener(window, 'load', initialize);
         }
		 
	function findRefrenceId(){
		var refrence_id_val =$("#request_id").find(":selected").text();
		$('#reference_id').val(refrence_id_val);
		}

             initialize();                                      
            $(".only_number").on('keypress', function (evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            });
            $('.form_datetime').datetimepicker({
                weekStart: 1,
                todayBtn: 1,
                startDate: "",
//                endDate: "",
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                minView: 1,
                format: "<?php echo DATETIME_FORMAT_DATEPICKER; ?>"
            });
</script>
