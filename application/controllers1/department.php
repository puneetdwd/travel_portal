<?php

class Department extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'department'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("department_model",'dept_model');
    }

    public function index() {
        $department = $this->dept_model->get_all_department();        
        $view_data = array('department' => $department);

        $this->template->write_view('content', 'department/index_dept', $view_data);
        $this->template->render();
    }

    public function add_dept($dept_id = '') {
        $view_data = array();
        if (!empty($dept_id)) {
            $dept = $this->dept_model->get_dept($dept_id);
            $view_data['dept'] = $dept;
        }
//        echo '<pre>'; print_r($view_data['dept']);  exit;
        if ($this->input->post()) {            
            $post_data = $this->input->post();
            $comb_id = $this->dept_model->get_dept_band_combination($post_data['dept_name']);
            if (empty($comb_id)) {
                $data = $this->dept_model->update_dept($post_data, $dept_id);
                if ($data) {
                    $msg = (!empty($dept_id)) ? ' Department successfully Updated' : 'Department successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . department);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'department/add_dept', $view_data);
        $this->template->render();
    }
    
    public function status($code, $status, $view = '') {
        $dept = $this->dept_model->get_dept($code);
        if (!$dept) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('departments', $code, $status)) {
                $this->session->set_flashdata('success', 'Departments marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'department/view/' . $code);
        } else {
            redirect(base_url() . 'department');
        }
    }

}
