<?php

class Da_policy extends Admin_Controller {

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
        $this->load->model("da_policy_model",'da_model');
    }

    public function index() {
        $da_policy = $this->da_model->get_all_da_policy();        
        $view_data = array('da_policy' => $da_policy);

        $this->template->write_view('content', 'da_policy/index_da', $view_data);
        $this->template->render();
    }
    
    public function add_da($dept_id = '') {
        $view_data = array();
        if (!empty($dept_id)) {
            $dept = $this->da_model->get_policy($dept_id);
            $view_data['dept'] = $dept;
        }

        if ($this->input->post()) {            
            
            $post_data = $this->input->post();
//            $comb_id = $this->da_model->get_da_band_combination($post_data['policy_name']);
//            if (empty($comb_id)) {
                $post_data['policy_name']= htmlspecialchars($post_data['policy_name']);
                $data = $this->da_model->update_da($post_data, $dept_id);
                if ($data) {
                    $msg = (!empty($dept_id)) ? ' DA Policy successfully Updated' : 'DA Policy successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . da_policy);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
//            } else {
//                $view_data['error'] = 'Same Combination already exits.';
//            }
        }
        $this->template->write_view('content', 'da_policy/add_da', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $dept = $this->da_model->get_policy($code);
        if (!$dept) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('da_policy', $code, $status)) {
                $this->session->set_flashdata('success', 'DA Policy marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'da_policy');
        } else {
            redirect(base_url() . 'da_policy');
        }
    }

}
