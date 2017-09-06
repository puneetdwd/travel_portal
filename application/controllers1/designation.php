<?php

class Designation extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'designations'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
    }

    public function index() {

        $this->load->model("desg_model");
        $desgs = $this->desg_model->get_all_desg();
//        po($desgs);
        $view_desg = array('desgs' => $desgs);

        $this->template->write_view('content', 'designation/index_desg', $view_desg);
        $this->template->render();
    }

    public function add_desg($desg_id = '') {

        $view_data = array();
        $this->load->model("desg_model");
//        $desg_band = $this->desg_model->get_all_desg_band();
//        $view_data['desg_band'] = $desg_band;
//        
        if (!empty($desg_id)) {
            $desg = $this->desg_model->get_desg($desg_id);
            $view_data['desg'] = $desg;
        }
        //echo '<pre>'; print_r($view_data['desg']);  exit;
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $comb_id = $this->desg_model->get_desg_band_combination($post_data['desg_name']);
            if (empty($comb_id)) {
                $data = $this->desg_model->update_desg($post_data, $desg_id);
                if ($data) {
                    $msg = (!empty($desg_id)) ? ' Designation successfully Updated' : 'Designation successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . designation);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'designation/add_desg', $view_data);
        $this->template->render();
    }

    public function del_desg($id) {

        $this->load->model("desg_model");
        $output = $this->desg_model->delete_desg($id);

        if (!$output) {
            $this->session->set_flashdata('error', 'Something went wrong');
        } else {
            $this->session->set_flashdata('success', 'Designation deleted Successfully');
            redirect(base_url() . 'designation/index');
        }
    }

    public function status($code, $status, $view = '') {
        $this->load->model("desg_model");
        $desg = $this->desg_model->get_desg($code);
        if (!$desg) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('designations', $code, $status)) {
                $this->session->set_flashdata('success', 'Designation marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'designation/view/' . $code);
        } else {
            redirect(base_url() . 'designation');
        }
    }

}
