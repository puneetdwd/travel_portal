<?php

class States extends Admin_Controller {

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
        $this->load->model("states_model");
    }

    public function index() {
        $states = $this->states_model->get_all_states();
        $view_states = array('states' => $states);

        $this->template->write_view('content', 'states/index_states', $view_states);
        $this->template->render();
    }

    public function add_states($states_id = '') {
        $view_data = array();

//        
        if (!empty($states_id)) {
            $states = $this->states_model->get_states($states_id);
            $view_data['states'] = $states;
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $comb_id = $this->states_model->get_states_combination($post_data['state_name']);
            if (empty($comb_id)) {
                $data = $this->states_model->update_states($post_data, $states_id);
                if ($data) {
                    $msg = (!empty($states_id)) ? ' States successfully Updated' : 'States successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . states);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'states/add_states', $view_data);
        $this->template->render();
    }

    public function delete_states($id) {

        $output = $this->states_model->delete_states($id);

        if (!$output) {
            $this->session->set_flashdata('error', 'Something went wrong');
        } else {
            $this->session->set_flashdata('success', 'States deleted Successfully');
            redirect(base_url() . 'states/index');
        }
    }
    
    public function status($code, $status, $view = '') {
            $states = $this->states_model->get_states($code);
            if (!$states) {
                $this->session->set_flashdata('error', 'Invalid record');
            } else {

                if ($this->common->change_status('state_list',$code, $status)) {
                    $this->session->set_flashdata('success', 'States marked as ' . $status);
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
                }
            }
            if ($view == 'view') {
                redirect(base_url() . 'states/view/' . $code);
            } else {
                redirect(base_url() . 'states');
            }
       
    }

}
