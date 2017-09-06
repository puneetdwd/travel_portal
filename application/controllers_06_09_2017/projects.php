<?php

class Projects extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


        $this->is_logged_in();
//        $this->is_user_admin();

        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'states'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("projects_model");
    }

    public function index() {
        $projects = $this->projects_model->get_all_projects();
        $view_data = array('projects' => $projects);
        $this->template->write_view('content', 'projects/index_projects', $view_data);
        $this->template->render();
    }

    public function add_project($project_id = '') {
        $view_data = array();
        if (!empty($project_id)) {
            $project = $this->projects_model->get_project($project_id);            
            $view_data['project'] = $project;
        }
        
        $this->load->model("department_model");
        $department_date = $this->department_model->get_all_department();
        $view_data['department'] = $department_date;
        
        if ($this->input->post()) {            
            $post_data = $this->input->post();
            if(empty($project_id)) {
                $post_data['remain_budget'] = $post_data['budget'];
            }
            $comb_id = $this->projects_model->get_projects_combination($post_data['name'],$post_data['dept_id'],$post_data['budget'],$post_data['remain_budget']);                        
            if (empty($comb_id)) {
                $data = $this->projects_model->update_projects($post_data, $project_id);
                if ($data) {
                    $msg = (!empty($project_id)) ? ' Project successfully Updated' : 'Project successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . projects);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'projects/add_projects', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
            $states = $this->projects_model->get_project($code);
            if (!$states) {
                $this->session->set_flashdata('error', 'Invalid record');
            } else {

                if ($this->common->change_status('projects',$code, $status)) {
                    $this->session->set_flashdata('success', 'States marked as ' . $status);
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
                }
            }
            if ($view == 'view') {
                redirect(base_url() . 'projects/view/' . $code);
            } else {
                redirect(base_url() . 'projects');
            }
       
    }

}
