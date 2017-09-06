<?php

class Bus_category extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'bus_category'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_category_model","bus_model");
    }

    public function index() {
        $bus = $this->bus_model->get_all_bus_category();
        $view_bus = array('bus' => $bus);

        $this->template->write_view('content', 'bus/index_bus', $view_bus);
        $this->template->render();
    }

    public function add_bus($bus_id = '') {
        $view_data = array(); 

        if (!empty($bus_id)) {
            $bus = $this->bus_model->get_travel_category_id($bus_id);
            $view_data['bus'] = $bus;
        }
        if ($this->input->post()) {            
            $post_data = $this->input->post();
            $comb_id = $this->bus_model->get_travel_class_combination($post_data['name'], $post_data['travel_type']);
            
            if (empty($comb_id)) {
                $data = $this->bus_model->update_travel_category($post_data, $bus_id);
                if ($data) {
                    $msg = (!empty($bus_id)) ? ' Trip Raise successfully to Manager Approval ' : 'Trip Raise successfully to Manager Approval ';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . bus_category);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'bus/add_bus', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $bus = $this->bus_model->get_travel_category_id($code);
        if (!$bus) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_category', $code, $status)) {
                $this->session->set_flashdata('success', 'Bus marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'bus_category/view/' . $code);
        } else {
            redirect(base_url() . 'bus_category');
        }
    }

}
