<?php

class Travel_request extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        
        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'flight_travel'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_request_model", 'travel_request');
    }

    public function index($travel_request_id = '') {
        $employee_id = $this->session->userdata('employee_id');
        if ($employee_id != '') {
            $view_data = array();

            $this->load->model('employee_model');
            $employee = $this->employee_model->get_employee_by_id($employee_id);
            $view_data['employee'] = $employee;
            $grade_id = $employee['grade_id'];
            $this->load->model("grades_model");
            $grade = $this->grades_model->get_grade($grade_id);            
            if (!empty($grade)) {
                $view_data['travel_mode'] = $grade['travel_mode'];
                if ($view_data['travel_mode'] == "1") {
                    redirect(base_url() . flight_travel);
                } else if ($view_data['travel_mode'] == "2") {
                    redirect(base_url() . train_travel);
                } else if ($view_data['travel_mode'] == "3") {
                    redirect(base_url() . car_travel);
                } else if ($view_data['travel_mode'] == "4") {
                    redirect(base_url() . bus_travel);
                } else {
                    redirect(base_url() . flight_travel);
                }
            } else {
                redirect(base_url() . flight_travel);
            }
        } else {
            $view_data['error'] = 'Admin can not request for Travel.';
            $this->session->set_flashdata('error', 'Admin can not request for Travel.');
            redirect(base_url() . flight_travel);
        }
    }

    public function status($code, $status, $view = '') {
        $flight = $this->flight_model->get_flight($code);
        if (!$flight) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_request', $code, $status)) {
                $this->session->set_flashdata('success', 'Flight Request marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'flight_travel/view/' . $code);
        } else {
            redirect(base_url() . 'flight_travel');
        }
    }

}
