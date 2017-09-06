<?php

class My_expense extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'employee_request'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("my_expense_model", 'my_expense');
       $this->load->model("travel_request_model", 'travel_request');

        $this->load->library('form_validation');
    }

    public function others() {
        
		$employee_id = $this->session->userdata('employee_id');
		$allowances_item_array = array();
		if($this->input->post())
		 {
		  $allowances_item_array['employees_id']=$employee_id;
		  $allowances_item_array['request_id']=$this->input->post('request_id');
		  //$allowances_item_array['reference_id']=$this->input->post('reference_id');
		  $allowances_item_array['date']=date(DATEMYSQL, strtotime($this->input->post('expanse_date')));
		  $allowances_item_array['expense_name']=$this->input->post('name');
		  $allowances_item_array['expense_type']=$this->input->post('location');
		  $allowances_item_array['arrange_by']=$this->input->post('arrange_by');
		  $allowances_item_array['amount']=$this->input->post('amount');
		  $allowances_item_array['bill_no']=$this->input->post('bill_no');

		  if($this->common->insert_data($allowances_item_array, 'other_expense'))
		   {
		    $this->session->set_flashdata('success', 'Expense added successfully');
		    //redirect(base_url().'my_expense/others');	
		   }
		  else
		   {
		    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
		    //redirect(base_url().'my_expense/others');	
		   }

		 }

		
		//$this->session->set_flashdata('error', 'TESTING.....');
		//$this->redirect(base_url().'my_expense/others');
		
		$view_request['request'] = $this->my_expense->get_all_request($employee_id);
		$view_request['other_expencesData'] = $this->my_expense->get_all_other_expences_data('mast_other_expense');

        $this->template->write_view('content', 'my_expense/others', $view_request);
        $this->template->render();
    }
	
	
	 public function conveyance() {
        $employee_id = $this->session->userdata('employee_id');
		$allowances_item_array = array();
		 if ($this->input->post()) {
			
					$allowances_item_array['request_id']=$this->input->post('request_id');
					$allowances_item_array['con_date']=date(DATEMYSQL, strtotime($this->input->post('expanse_date')));
					$allowances_item_array['con_from']=$this->input->post('from_location');
					$allowances_item_array['con_to']=$this->input->post('to_location');
					$allowances_item_array['con_book_by']=$this->input->post('book_by');
					$allowances_item_array['con_arrange_by']=$this->input->post('arrange_by');
					$allowances_item_array['total']=$this->input->post('amount');
					
					
					if ($this->common->insert_data($allowances_item_array, 'other_con_booking')) {
						 $this->session->set_flashdata('success', 'Expense added successfully');
						  redirect(base_url() . my_expense/conveyance);
						}else{
							 $this->session->set_flashdata('error', 'Error occurred. Try Again!');
							  redirect(base_url() . my_expense/conveyance);
							}
					
			}
		
        $view_request['request'] = $this->my_expense->get_all_request($employee_id);
		$view_request['other_expencesData'] = $this->my_expense->get_all_other_expences_data('mast_other_expense');
		
		

        $this->template->write_view('content', 'my_expense/conveyance', $view_request);
        $this->template->render();
    }
	
	 public function hotel() {
        $employee_id = $this->session->userdata('employee_id');
		$allowances_item_array = array();
		 if ($this->input->post()) {
			
					$allowances_item_array['request_id']=$this->input->post('request_id');
					$allowances_item_array['loading_departure']=date(DATEMYSQL, strtotime($this->input->post('check_in_date')));
					$allowances_item_array['loading_return']=$this->input->post('check_out_date');
					$allowances_item_array['location']=$this->input->post('location');
					$allowances_item_array['hotal_name']=$this->input->post('hotal_name');
					$allowances_item_array['room_no']=$this->input->post('room_no');
					$allowances_item_array['loading_total']=$this->input->post('amount');
					$allowances_item_array['bill_no']=$this->input->post('bill_no');
					$allowances_item_array['arrange_by'] =$this->input->post('arrange_by');
					
					if ($this->common->insert_data($allowances_item_array, 'other_expense')) {
						 $this->session->set_flashdata('success', 'Expense added successfully');
						 redirect(base_url() . my_expense/hotel);	
						}else{
							 $this->session->set_flashdata('error', 'Error occurred. Try Again!');
							 redirect(base_url() . my_expense/hotel);
							}
			}
			
			$request= $this->my_expense->get_all_request($employee_id);
			print_r($request);die;
			$view_request['request'] =$request ;
			$to_city_id = $request['to_city_id'];
        $this->load->model('employee_model');
        $hotel_category = $this->travel_desk->get_hotel_category_by_location($to_city_id, '1');
        $view_request['hotel_category'] = $hotel_category;
        $view_request['to_city_id'] = $to_city_id;
			
		 $service_proviers = $this->travel_desk->get_service_proviers($request['travel_type']);
        $view_request['service_proviers'] = $service_proviers;
		
        
		$view_request['other_expencesData'] = $this->my_expense->get_all_other_expences_data('mast_other_expense');
		
		

        $this->template->write_view('content', 'my_expense/hotel', $view_request);
        $this->template->render();
    }

}
