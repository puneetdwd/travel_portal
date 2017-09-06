<?php

class Flight_category extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'flight_category'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_category_model", "flight_model");
    }

    public function index() {
        $flight = $this->flight_model->get_all_flight_category();
        $view_flight = array('flight' => $flight);
        
        $this->template->write_view('content', 'flight/index_flight', $view_flight);
        $this->template->render();
    }

    public function add_flight($class_id = '') {
        $view_data = array();

        if (!empty($class_id)) {
            $flight = $this->flight_model->get_travel_category_id($class_id);
            $view_data['flight'] = $flight;
        }
        if ($this->input->post()) {
            
            $post_data = $this->input->post();
            $comb_id = $this->flight_model->get_travel_class_combination($post_data['name'],$post_data['travel_type']);
            if (empty($comb_id)) {                
                $data = $this->flight_model->update_travel_category($post_data, $class_id);
                if ($data) {
                    $msg = (!empty($class_id)) ? ' Flight class successfully Updated' : 'Flight class successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . flight_category);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'flight/add_flight', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $flight = $this->flight_model->get_travel_category_id($code);
        if (!$flight) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_category', $code, $status)) {
                $this->session->set_flashdata('success', 'Flight marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'flight_category/view/' . $code);
        } else {
            redirect(base_url() . 'flight_category');
        }
    }

}
