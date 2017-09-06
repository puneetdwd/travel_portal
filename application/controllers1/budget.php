<?php

class Budget extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'travel_reasons'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("budget_model", 'budget');
        $this->load->model("department_model", 'dept_model');
    }

    public function index() {
        $budget_list = $this->budget->get_budget();
        $view_data = array('budget_list' => $budget_list);
        $this->template->write_view('content', 'budget/index_budget', $view_data);
        $this->template->render();
    }

    public function add_budget($budget_id = '') {
        $view_data = array();

        $department = $this->dept_model->get_all_department();
        $view_data['department'] = $department;


        if (!empty($budget_id)) {
            $budget = $this->budget->get_budget_id($budget_id);            
            $view_data['budget'] = $budget;
        }

        $join_str = array();
        $join_str[0] = array(
            'table' => 'indian_cities c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'indian_cities.cost_center_id',
            'join_type' => 'LEFT'
        );
        $data = 'c.id,c.name as city_name';
        $cost_center = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.cost_center_id !=' => '', 'indian_cities.status' => 'active'), $data, '', '', '', '', $join_str,'indian_cities.cost_center_id');
        $view_data['cost_center'] = $cost_center;

        if ($this->input->post()) {
            $post_data = $this->input->post();
            if (empty($budget_id)) {
                $post_data['remain_budget'] = $post_data['budget'];
            }
            
            $comb_id = $this->budget->get_budget_combination($post_data['department_id'], $post_data['financial_year'], $post_data['cost_center_id'], $post_data['budget'],$post_data['remain_budget']);
            if (empty($comb_id)) {
                $data = $this->budget->update_budget($post_data, $budget_id);
                if ($data) {
                    $msg = (!empty($budget_id)) ? ' Budget successfully Updated' : 'Budget successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . budget);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'budget/add_budget', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $budget = $this->budget->get_budget_id($code);
        if (!$budget) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('budget', $code, $status)) {
                $this->session->set_flashdata('success', 'Budget marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'budget/view/' . $code);
        } else {
            redirect(base_url() . 'budget');
        }
    }

}
