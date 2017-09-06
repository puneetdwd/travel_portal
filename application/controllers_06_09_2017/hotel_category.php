<?php

class Hotel_category extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'hotel_category'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model('Travel_category_model', "hotel_model");
    }

    public function index() {
        if ($this->session->userdata('type') != 'admin') {
            $this->load->model('employee_model');
            $this->load->model("travel_request_model", 'travel_request');
            $employee_id = $this->session->userdata('employee_id');
            $request = $this->employee_model->get_employee_by_id($employee_id);
            $to_city_id = $request['city_id'];

            $state_list = $this->travel_request->get_state_id_by_city_id($to_city_id);
            $state_id = $state_list['state_id'];
            $hotel = $this->hotel_model->get_all_hotel_category($state_id);
            $view_hotel = array('hotel' => $hotel);
        } else {            
            $hotel = $this->hotel_model->get_all_hotel_category();
            $view_hotel = array('hotel' => $hotel);
        }
        
        $this->template->write_view('content', 'hotel/index_hotel', $view_hotel);
        $this->template->render();
    }

    public function add_hotel($hotel_id = '') {
        $view_data = array();
        $this->load->model("city_model");
        $city_date = $this->city_model->get_all_city();
        $view_data['city'] = $city_date;

        if (!empty($hotel_id)) {
            $hotel = $this->hotel_model->get_travel_category_id($hotel_id);
            $view_data['hotel'] = $hotel;
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $comb_id = $this->hotel_model->get_hotel_combination($post_data['name'], $post_data['city_id'], $post_data['amount'], $post_data['category'], $post_data['travel_type'], $post_data['type'], $post_data['half_amount'], $post_data['address'], $post_data['phone']);
            if (empty($comb_id)) {
                $data = $this->hotel_model->update_hotel($post_data, $hotel_id);
                if ($data) {
                    $msg = (!empty($hotel_id)) ? ' Hotel successfully Updated' : 'Hotel successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . hotel_category);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'hotel/add_hotel', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        $hotel = $this->hotel_model->get_travel_category_id($code);
        if (!$hotel) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_category', $code, $status)) {
                $this->session->set_flashdata('success', 'Hotel marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'hotel_category/view/' . $code);
        } else {
            redirect(base_url() . 'hotel_category');
        }
    }

}
