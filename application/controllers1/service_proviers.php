<?php

class Service_proviers extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'service_proviers'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("service_proviers_model");
    }

    public function index() {
        if ($this->session->userdata('type') != 'admin') {
            $this->load->model('employee_model');
            $this->load->model("travel_request_model", 'travel_request');
            $employee_id = $this->session->userdata('employee_id');
            $request = $this->employee_model->get_employee_by_id($employee_id);
            $to_city_id = $request['city_id'];
            
            $state_list = $this->travel_request->get_state_id_by_city_id($to_city_id);
            $state_id = $state_list['state_id'];
            
//            $cost_center_list = $this->travel_request->get_cost_center_by_city_id($to_city_id);
//            $cost_center_id = $cost_center_list['cost_center_id'];
        } else {
            $state_id = '';
        }
        $service_proviers = $this->service_proviers_model->get_all_service_proviers($state_id);
        $view_service_proviers = array('service_proviers' => $service_proviers);

        $this->template->write_view('content', 'service_proviers/index_service_proviers', $view_service_proviers);
        $this->template->render();
    }

    public function add_service_proviers($service_proviers_id = '') {
        $view_data = array();
        $this->load->model("city_model");
        $city_date = $this->city_model->get_all_city();
        $view_data['city'] = $city_date;

        if (!empty($service_proviers_id)) {
            $service_proviers = $this->service_proviers_model->get_service_proviers($service_proviers_id);
            $view_data['service_proviers'] = $service_proviers;
        }

        $grades = $this->common->select_data_by_id('grades', $condition_array = array('status' => 'active'), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
        $view_data['grades'] = $grades;
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $comb_id = $this->service_proviers_model->get_service_proviers_combination($post_data['name'], $post_data['service_type'], $post_data['amount'], $post_data['city_id'], $post_data['half_amount']);

            if (empty($comb_id)) {
                $data = $this->service_proviers_model->update_service_proviers($post_data, $service_proviers_id);
                if ($data) {
                    $msg = (!empty($service_proviers_id)) ? ' Service proviers successfully Updated' : 'Service proviers successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . service_proviers);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }

        $this->template->write_view('content', 'service_proviers/add_service_proviers', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $service_proviers = $this->service_proviers_model->get_service_proviers($code);
        if (!$service_proviers) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('service_proviers', $code, $status)) {
                $this->session->set_flashdata('success', 'Service proviers marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'service_proviers/view/' . $code);
        } else {
            redirect(base_url() . 'service_proviers');
        }
    }

}
