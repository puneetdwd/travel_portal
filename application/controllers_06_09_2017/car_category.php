<?php

class Car_category extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'car_category'
        );
        
        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_category_model", "car_model");
    }

    public function index() {
        $car = $this->car_model->get_all_car_category();
        $view_car = array('car' => $car);
        
        $this->template->write_view('content', 'car/index_car', $view_car);
        $this->template->render();
    }

    public function add_car($car_id = '') {
        $view_data = array();
        $this->load->model("city_model");
        $city_date = $this->city_model->get_all_city();
        $view_data['city'] = $city_date;

        if (!empty($car_id)) {
            $car = $this->car_model->get_travel_category_id($car_id);
            $view_data['car'] = $car;
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $comb_id = $this->car_model->get_car_combination($post_data['name'], $post_data['amount'], $post_data['city_id'], $post_data['travel_type'], $post_data['category'], $post_data['half_amount']);
            if (empty($comb_id)) {
                $data = $this->car_model->update_car($post_data, $car_id);
                if ($data) {
                    $msg = (!empty($car_id)) ? ' Trip Raise successfully to Manager Approval ' : 'Trip Raise successfully to Manager Approval ';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . car_category);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'car/add_car', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $car = $this->car_model->get_travel_category_id($code);
        if (!$car) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_category', $code, $status)) {
                $this->session->set_flashdata('success', 'Car marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'car_category/view/' . $code);
        } else {
            redirect(base_url() . 'car_category');
        }
    }

}
