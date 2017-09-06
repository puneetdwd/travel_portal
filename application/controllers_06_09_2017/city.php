<?php

class City extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'city'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("city_model");
    }

    public function index() {
        $city = $this->city_model->get_all_city();        
        $view_city = array('city' => $city);
//        po($view_city);
        $this->template->write_view('content', 'city/index_city', $view_city);
        $this->template->render();
    }

    public function add_city($city_id = '') {        
        $view_data = array();
        $city = $this->city_model->get_all_city();
        $view_data['city1'] = $city;
        
        $this->load->model("states_model");
        $states_date = $this->states_model->get_all_states();
        $view_data['states'] = $states_date;

        if (!empty($city_id)) {
            $city = $this->city_model->get_city($city_id);
            $view_data['city'] = $city;
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();            
            $comb_id = $this->city_model->get_city_combination($post_data['name'], $post_data['state_id'], $post_data['class'], $post_data['cost_center_id'], $post_data['guest_house'], $post_data['officenumber'], $post_data['officeaddress'], $post_data['gsaddress'], $post_data['caretakername'], $post_data['mobile_number']);            
            if (empty($comb_id)) {
                $data = $this->city_model->update_city($post_data, $city_id);
                if ($data) {
                    $msg = (!empty($city_id)) ? ' City successfully Updated' : 'City successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . city);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        
        $this->template->write_view('content', 'city/add_city', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $city = $this->city_model->get_city($code);
        if (!$city) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('indian_cities', $code, $status)) {
                $this->session->set_flashdata('success', 'City marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'city/view/' . $code);
        } else {
            redirect(base_url() . 'city');
        }
    }

}
