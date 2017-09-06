<?php

class Travel_reasons extends Admin_Controller {

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
        $this->load->model("travel_reasons_model");
    }

    public function index() {
        $travel_reasons = $this->travel_reasons_model->get_all_travel_reasons();
        $view_travel_reasons = array('travel_reasons' => $travel_reasons);

        $this->template->write_view('content', 'travel_reasons/index_travel_reasons', $view_travel_reasons);
        $this->template->render();
    }

    public function add_travel_reasons($travel_reasons_id = '') {
        $view_data = array(); 

        if (!empty($travel_reasons_id)) {
            $travel_reasons = $this->travel_reasons_model->get_travel_reasons($travel_reasons_id);
            $view_data['travel_reasons'] = $travel_reasons;
        }
        if ($this->input->post()) {            
            
            $post_data = $this->input->post();
            $comb_id = $this->travel_reasons_model->get_travel_reasons_combination($post_data['reason'], $post_data['hangout_suggestion']);
            if (empty($comb_id)) {
                $data = $this->travel_reasons_model->update_travel_reasons($post_data, $travel_reasons_id);
                if ($data) {
                    $msg = (!empty($travel_reasons_id)) ? ' Travel Reason successfully Updated' : 'Travel Reason successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . travel_reasons);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'travel_reasons/add_travel_reasons', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $travel_reasons = $this->travel_reasons_model->get_travel_reasons($code);
        if (!$travel_reasons) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_reasons', $code, $status)) {
                $this->session->set_flashdata('success', 'Travel reason marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'travel_reasons/view/' . $code);
        } else {
            redirect(base_url() . 'travel_reasons');
        }
    }

}
