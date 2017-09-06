<?php

class Travel_policy extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'travel_policy'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_policy_model");
    }

    public function index() {
        $travel_policy = $this->travel_policy_model->get_all_travel_policy();
        $view_travel_policy = array('travel_policy' => $travel_policy);

        $this->template->write_view('content', 'travel_policy/index_travel_policy', $view_travel_policy);
        $this->template->render();
    }

    public function add_travel_policy($travel_policy_id = '') {
        $view_data = array();

        if (!empty($travel_policy_id)) {
            $travel_policy = $this->travel_policy_model->get_travel_policy($travel_policy_id);
            $view_data['travel_policy'] = $travel_policy;
        }

        $grades = $this->common->select_data_by_id('grades', $condition_array = array('status' => 'active'), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
        $view_data['grades'] = $grades;
        if ($this->input->post()) {

            $post_data = $this->input->post();
            if (isset($post_data['actual'])) {
                if ($post_data['actual'] == '1') {
                    $post_data['amount'] = '0';
                } else {
                    $post_data['actual'] = 0;
                }
            } else {
                $post_data['actual'] = 0;
            }

            $comb_id = $this->travel_policy_model->get_travel_policy_combination($post_data['service_type'], $post_data['grade_id'], $post_data['approval_level'], $post_data['city_class'], $post_data['popup'], $post_data['actual'], $post_data['amount']);

            if (empty($comb_id)) {
                $data = $this->travel_policy_model->update_travel_policy($post_data, $travel_policy_id);
                if ($data) {
                    $msg = (!empty($travel_policy_id)) ? ' Travel policy successfully Updated' : 'Travel policy successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . travel_policy);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }

        $this->template->write_view('content', 'travel_policy/add_travel_policy', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $travel_policy = $this->travel_policy_model->get_travel_policy($code);
        if (!$travel_policy) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_policy', $code, $status)) {
                $this->session->set_flashdata('success', 'Travel Policy marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'travel_policy/view/' . $code);
        } else {
            redirect(base_url() . 'travel_policy');
        }
    }

}
