<?php

class Grades extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


        $this->is_logged_in();
//        $this->is_user_admin();

        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'grades'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("grades_model");
    }

    public function index() {
        $grades = $this->grades_model->get_all_grades();
//        po($grades);
        $view_grades = array('grades' => $grades);

        $this->template->write_view('content', 'grades/index_grades', $view_grades);
        $this->template->render();
    }

    public function add_grade($grade_id = '') {
        $view_data = array();
        $this->load->model("Travel_category_model","car_model");        
        $car_date = $this->car_model->get_all_car_category();
        $view_data['car'] = $car_date;

        if (!empty($grade_id)) {
            $grade = $this->grades_model->get_grade($grade_id);            
            $view_data['grade'] = $grade;
            
            $this->load->model("travel_category_model",'travel_category');
            $travel_category_date = $this->travel_category->get_travel_category($grade['travel_mode']);            
            $view_data['travel_category'] = $travel_category_date;
//            po($view_data['travel_category']);
        }
        if ($this->input->post()) {             
//            po();
            $post_data = $this->input->post();
            $comb_id = $this->grades_model->get_grade_combination($post_data['grade_name'],$post_data['travel_mode'],$post_data['travel_class'],$post_data['hotel_class'],$post_data['car_id']);
            if (empty($comb_id)) {
                $data = $this->grades_model->update_grade($post_data, $grade_id);
                if ($data) {
                    $msg = (!empty($grade_id)) ? ' Grades successfully Updated' : 'Grades successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . grades);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $view_data['error'] = 'Same Combination already exits.';
            }
        }
        $this->template->write_view('content', 'grades/add_grades', $view_data);
        $this->template->render();
    }

    public function del_grade($id) {

        $output = $this->grades_model->delete_grade($id);

        if (!$output) {
            $this->session->set_flashdata('error', 'Something went wrong');
        } else {
            $this->session->set_flashdata('success', 'Grade deleted Successfully');
            redirect(base_url() . 'grades/index');
        }
    }
    
     public function status($code, $status, $view = '') {
            $grades = $this->grades_model->get_grade($code);
            if (!$grades) {
                $this->session->set_flashdata('error', 'Invalid record');
            } else {

                if ($this->common->change_status('grades',$code, $status)) {
                    $this->session->set_flashdata('success', 'Grade marked as ' . $status);
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
                }
            }
            if ($view == 'view') {
                redirect(base_url() . 'grades/view/' . $code);
            } else {
                redirect(base_url() . 'grades');
            }
        
    }

}
