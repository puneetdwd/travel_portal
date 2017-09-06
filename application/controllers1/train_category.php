<?php

class Train_category extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'train_category'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_category_model", "train_model");
    }

    public function index() {
        $train = $this->train_model->get_all_train_category();
        $view_train = array('train' => $train);

        $this->template->write_view('content', 'train/index_train', $view_train);
        $this->template->render();
    }

    public function add_train($train_id = '') {
        $view_data = array();

        if (!empty($train_id)) {
            $train = $this->train_model->get_travel_category_id($train_id);
            $view_data['train'] = $train;
        }
        if ($this->input->post()) {            
            $post_data = $this->input->post();
            $comb_id = $this->train_model->get_travel_class_combination($post_data['name'],$post_data['travel_type']);
            
            if (empty($comb_id)) {
                $data = $this->train_model->update_travel_category($post_data, $train_id);
                if ($data) {
                    $msg = (!empty($train_id)) ? ' Train successfully Updated' : 'Train successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . train_category);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'train/add_train', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $train = $this->train_model->get_travel_category_id($code);
        if (!$train) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_category', $code, $status)) {
                $this->session->set_flashdata('success', 'Train marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'train_category/view/' . $code);
        } else {
            redirect(base_url() . 'train_category');
        }
    }

}
