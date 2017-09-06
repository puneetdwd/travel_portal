<?php

class Cost_center extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'cost_centres'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("cost_model");
    }

    public function index() {
        $cost_center = $this->cost_model->get_all_cost_center();
//        po($cost_center);
        $view_cost_center = array('cost_center' => $cost_center);

        $this->template->write_view('content', 'cost_center/index_cost_center', $view_cost_center);
        $this->template->render();
    }

    public function add_cost_center($cost_id = '') {
        $view_data = array();
        $this->load->model("states_model");
        $states_date = $this->states_model->get_all_states();
        $view_data['states'] = $states_date;
        if (!empty($cost_id)) {
            $cost = $this->cost_model->get_cost($cost_id);
            $view_data['cost'] = $cost;

            $this->load->model("city_model");
            $city_date = $this->city_model->get_all_city();
            $view_data['l_cities'] = $city_date;
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $comb_id = $this->cost_model->get_cost_combination($post_data['city_id'], $post_data['guest_house']);
            if (empty($comb_id)) {
                $data = $this->cost_model->update_cost($post_data, $cost_id);
                if ($data) {
                    $msg = (!empty($cost_id)) ? ' Cost Center successfully Updated' : 'Cost Center successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . cost_center);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'cost_center/add_cost_center', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $cost = $this->cost_model->get_cost($code);
        if (!$cost) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('cost_center', $code, $status)) {
                $this->session->set_flashdata('success', 'Cost Center marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'cost_center/view/' . $code);
        } else {
            redirect(base_url() . 'cost_center');
        }
    }

}
