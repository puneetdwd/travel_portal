<?php

class View_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        
        $this->is_logged_in();
        
    }

    public function view($id) {
        $this->is_logged_in();
        
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
	$res=$result->row_array();
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('service_request_model');
        $request = $this->service_request_model->get_request($res['target_id']);
        /*if($this->input->is_ajax_request()) {
            echo json_encode($request);
        } else {*/
            $view_data= array('request' => $request);
             $view_data['notification_id'] = $id;
            echo $this->load->view('service_request/view_popup', $view_data);
        //}
    }
    
    public function view_payable_invoice($id) {
      
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
        $res=$result->row_array();
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('vendors_model');
        $invoice = $this->vendors_model->get_invoice_by_id($res['target_id']);
        $view_data= array('invoice' => $invoice);
        $view_data['notification_id'] = $id;
        
        echo $this->load->view('vendors/view_invoice_popup', $view_data);
        
    }
    
   public function view_travel_booking($id) {
      
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
	$res=$result->row_array();
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('booking_model');
        $booking = $this->booking_model->get_booking($res['target_id']);
        $view_data= array('booking' => $booking);
        $view_data['notification_id'] = $id;
        
        $pas_details = $this->booking_model->get_passenger_details($res['target_id']);
        $view_data['pas_details'] = $pas_details;
        
        echo $this->load->view('booking/view_popup', $view_data);
        
    }
    
    public function view_offer_letter($id) {
      
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
        $res=$result->row_array();
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('offer_letter_model');
        $offer = $this->offer_letter_model->get_offer($res['target_id']);
        $view_data= array('offer' => $offer);
        $view_data['notification_id'] = $id;
        
        
        echo $this->load->view('offer_letter/view_popup', $view_data);
        
    }
    
     public function view_room_booking($id) {
        $this->is_logged_in();
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
        $res=$result->row_array();
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        
        $this->load->model('room_booking_model');
        $booking = $this->room_booking_model->get_booking($res['target_id']);
        $view_data= array('booking' => $booking);
        $view_data['notification_id'] = $id;
        
        $guest_details = $this->room_booking_model->get_guest_details($res['target_id']);
        $view_data['guest_details'] = $guest_details;
        
        echo $this->load->view('room_booking/view_popup', $view_data);
        
    }
    
    public function comp_off_view($id) {
        $this->is_logged_in();
        
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
        $res=$result->row_array();
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('comp_off_model');
        $comp_off = $this->comp_off_model->get_comp_off($res['target_id']);
        
        $view_data= array('comp_off' => $comp_off);
        $view_data['notification_id'] = $id;
        
        if($comp_off['type'] == 'Requested'){
            $view_data['comp_off_type'] = 'Requested';
        }else{
            $view_data['comp_off_type'] = 'Allocation';
        }
        
        echo $this->load->view('comp_off/comp_off_popup', $view_data);
        
    }
    
    public function view_leave($id) {
        $this->is_logged_in();
        
        $sql = "SELECT * FROM notifications WHERE id = ?";
        $result = $this->db->query($sql, array( $id));
		
	$res=$result->row_array();
        //echo "<pre>";print_r($res); exit;
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('leave_model');
        $leave = $this->leave_model->get_leave($res['target_id']);
        //echo "<pre>";print_r($leave); exit;
        $view_data= array('leave' => $leave);
        $view_data['notification_id'] = $id;
        
        echo $this->load->view('leave/leave_popup', $view_data);
        
    }
    
     public function view_short_leave($id) {
        $this->is_logged_in();
        
        $sql = "SELECT * FROM notifications WHERE id= ?";
        $result = $this->db->query($sql, array( $id));
		
        $res=$result->row_array();
        //echo "<pre>";print_r($res);exit;
        
        if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        
        $this->load->model('short_leave_model');
        $short_leave = $this->short_leave_model->get_short_leave($res['target_id']);
        //echo "<pre>";print_r($res);exit;
        $view_data= array('short_leave' => $short_leave);
        echo $this->load->view('short_leave/view_popup', $view_data); 

    }
    
    public function view_travel_expense($id){
        $type = $this->input->get('type');
        if($type == 'expense') {
            $sql = "SELECT * FROM notifications WHERE target_id= ?";
        } else {
            $sql = "SELECT * FROM notifications WHERE id = ?";
        }
        $result = $this->db->query($sql, array( $id));

        $res = $result->row_array();
        
        if(!empty($res)) {
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }

        $this->load->model('expenses_model');
        $expense = $this->expenses_model->get_travel_expense($res['target_id']);
        
        $notification_array = $this->expenses_model->get_pending_travel_notification($this->session->userdata('employee_id'));
        $i=0;
        $noti_array = array();
        foreach($notification_array as $noti){
            $noti_array[$i] = $noti['target_id'];
            $i++;
        }

        //echo "<pre>"; print_r($noti_array);exit;

        //$view_data['notification_array'] = $noti_array;
        
        //echo "<pre>"; print_r($expense); exit;
        $output = array('expense' => $expense, 'notification' => $res, 'notification_array' =>$noti_array);
        
        echo $this->load->view('expenses/view_trav_exp_popup', $output); 
    }
    
     public function view_other_expense($id){
        $type = $this->input->get('type');
        if($type == 'expense') {
            $sql = "SELECT * FROM notifications WHERE target_id= ?";
        } else {
            $sql = "SELECT * FROM notifications WHERE id = ?";
        }
        $result = $this->db->query($sql, array( $id));
		
        $res=$result->row_array();
        
         if(!empty($res)){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($id);
        }
        $this->load->model('expenses_model');
        $expense = $this->expenses_model->get_other_expense($res['target_id']);
        
        $notification_array = $this->expenses_model->get_pending_other_notification($this->session->userdata('employee_id'));
        $i=0;
        $noti_array = array();
        foreach($notification_array as $noti){
            $noti_array[$i] = $noti['target_id'];
            $i++;
        }

        //$view_data['notification_array'] = $noti_array;
        
        $output = array('expense' => $expense, 'notification' => $res, 'notification_array' => $noti_array);
        
        echo $this->load->view('expenses/view_oth_exp_popup', $output); 
   
    }
    
    public function view_timesheet_popup($date , $emp_id){
        
        $this->session->set_userdata('referred_from', current_url());
        if(!$this->session->userdata('timesheet_start_date')) {
            $this->session->set_userdata('timesheet_start_date', date('Y-m-d'));
            $this->session->set_userdata('timesheet_end_date', date('Y-m-d'));
        }
        
        $data['start'] = $this->session->userdata('timesheet_start_date');
        $data['end'] = $this->session->userdata('timesheet_end_date');
        $this->load->model('work_model');
        $this->load->model('employee_model');
        
        $data['date'] = $date;
        $data['employee_id'] = $emp_id;
        $data['reporting_person'] = $this->employee_model->get_reporting_person($emp_id);
        $data['timesheet'] = $this->work_model->get_timesheet($date, $emp_id);
        
        $notification = $this->work_model->get_notification_id($date, $emp_id);
        $data['notification'] = $notification;
        echo $this->load->view('review/timesheet_popup', $data);
   
    }
    
    public function view_timesheet_edit_popup($date , $emp_id){
        
        $this->session->set_userdata('referred_from', current_url());
        if(!$this->session->userdata('timesheet_start_date')) {
            $this->session->set_userdata('timesheet_start_date', date('Y-m-d'));
            $this->session->set_userdata('timesheet_end_date', date('Y-m-d'));
        }
        
        $data['start'] = $this->session->userdata('timesheet_start_date');
        $data['end'] = $this->session->userdata('timesheet_end_date');
        $this->load->model('work_model');
        
        $data['date'] = $date;
        $data['employee_id'] = $emp_id;
        $data['timesheet'] = $this->work_model->get_timesheet($date, $emp_id);
        
        $notification_id = $this->work_model->get_notification_id($date, $emp_id);
        
        if(!empty($data['timesheet'])){
            $this->load->model('notification_model');
            $this->notification_model->mark_read($notification_id['id']);
        }
        
        echo $this->load->view('review/timesheet_edit_popup', $data); 
   
    }
    
}

