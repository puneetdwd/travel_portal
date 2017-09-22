<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();

        //render template
        $this->template->write_view('header', 'templates/header');
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model('travel_request_model', 'travel_request');
    }

    function test() {
        
//        $this->load->library('encryption');
//        $this->encryption->initialize(array('driver' => 'mcrypt'));
//        $this->encryption->initialize(array('driver' => 'openssl'));
//        $plain_text = 'This is a plain-text message!';
//        echo $ciphertext = $this->encryption->encrypt($plain_text);
//        echo $this->encryption->decrypt($ciphertext);
        
//        $sql = "INSERT INTO `travel_portal`.`menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (NULL, '5', 'Travel Policy', 'Travel Policy', 'finance_desk', 'travel_policy', 'finance_desk/travel_policy', '<i class="fa fa-rupee"></i>', '1', '1', NULL, NULL, NULL, NULL, NULL);";
//        
//        $sql = "INSERT INTO `menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (NULL, '5', 'Travel Policy', 'Travel Policy', 'finance_desk', 'travel_policy', 'finance_desk/travel_policy', '', '1', '1', NULL, NULL, NULL, NULL, NULL);";
//        $sql = "DROP TABLE `email_format`;";
//        $result = $this->db->query($sql);
        $sql = "SELECT * FROM `travel_portal`.`menu` WHERE `menu_id` LIKE '4'";
        $result = $this->db->query($sql);
        $result->result_array();
        po($result);
        
        
    }

    public function index() {
        $view_data = array();
        $employee_id = $this->session->userdata('employee_id');

        $total_request = $this->travel_request->get_all_total_count_request($employee_id);
        $view_data['total_request'] = $total_request[0]['total_request'];

        $approved_request = $this->travel_request->get_all_approved_count_request($employee_id);
        $view_data['approved_request'] = $approved_request[0]['approved_request'];

        $pending_request = $this->travel_request->get_all_pending_count_request($employee_id);
        $view_data['pending_request'] = $pending_request[0]['pending_request'];

        $last_few_request = $this->travel_request->get_last_few_request($employee_id);
        $view_data['last_few_request'] = $last_few_request;

        $last_few_expense = $this->travel_request->get_pending_expense_count_request($employee_id);
        $view_data['pending_expense'] = $last_few_expense;

        $all_expense = $this->travel_request->get_all_expense_count_request($employee_id);
        $view_data['approved_expense'] = $all_expense;

        $get_expense_request = $this->travel_request->get_last_few_expense_request($employee_id);
        $view_data['expense_request'] = $get_expense_request;

//        po($get_expense_request);
//        $pending_request = $this->travel_request->get_all_pending_request_for_manager($employee_id);
//        $cancellation_pending_request = $this->travel_request->get_all_cancallation_pending_request_for_manager($employee_id);
//        $completed_request = $this->travel_request->get_all_completed_request_for_manager($employee_id);
//        $expense_request = $this->travel_request->get_all_expense_pending_for_manager($employee_id);
//
//        $last_few_inbox = array();
//
//        for ($i = 0; $i <= 3; $i++) {
//            if (isset($pending_request[$i])) {
//                $id = $pending_request[$i]['id'];
//                $last_few_inbox[$id] = $pending_request[$i];
//            }
//            if (isset($cancellation_pending_request[$i])) {
//                $id = $cancellation_pending_request[$i]['id'];
//                $last_few_inbox[$id] = $cancellation_pending_request[$i];
//            }            
//            if (isset($expense_request[$i])) {
//                $id = $expense_request[$i]['id'];
//                $last_few_inbox[$id] = $expense_request[$i];
//            }
//            if (isset($completed_request[$i])) {
//                $id = $completed_request[$i]['id'];
//                $last_few_inbox[$id] = $completed_request[$i];
//            }
//        }

        $last_few_inbox = $this->travel_request->get_last_few_task($employee_id);
        $view_data['last_few_task'] = $last_few_inbox;


        $this->template->write_view('content', 'dashboard', $view_data);
        $this->template->render();
    }

    public function view_profile() {

        $emp_id = $this->session->userdata('employee_id');

        $this->load->model('employee_model');

        $employee = $this->employee_model->get_employee_details_by_id($emp_id);
        $view_data = array('employee' => $employee);
        $grade_id = $employee['grade_id'];

        $this->load->model("grades_model");
        $grade = $this->employee_model->get_grade_details($grade_id);
        $view_data['grade'] = $grade;

        $policy_data = $this->employee_model->get_travel_policy_by_grade($grade_id);


        $hotel = array();
        $DA = array();
        $DC = array();
        foreach ($policy_data as $key => $value) {
            if ($value['service_type'] == "5") {
                if ($value['actual'] == "1") {
                    $hotel[$value['city_class']] = "Actual";
                } else {
                    $hotel[$value['city_class']] = $value['amount'];
                }
            }
            if ($value['service_type'] == "6") {
                if ($value['actual'] == "1") {
                    $DA[$value['city_class']] = "Actual";
                } else {
                    $DA[$value['city_class']] = $value['amount'];
                }
            }
            if ($value['service_type'] == "7") {
                if ($value['actual'] == "1") {
                    $DC[$value['city_class']] = "Actual";
                } else {
                    $DC[$value['city_class']] = $value['amount'];
                }
            }
        }

        $emp_policy = array();
        if ($grade['travel_mode'] == "1") {
            $emp_policy[1]['name'] = "Flight";
        } else if ($grade['travel_mode'] == "2") {
            $emp_policy[1]['name'] = "Train";
        } else if ($grade['travel_mode'] == "3") {
            $emp_policy[1]['name'] = "Car";
        } else if ($grade['travel_mode'] == "4") {
            $emp_policy[1]['name'] = "Bus";
        }
        
        $emp_policy[1]['travel_class'] = $grade['travel_class'];
        $emp_policy[1]['grade_name'] = $grade['grade_name'];
        $emp_policy[1]['transport'] = $grade['transport'];
        $emp_policy[1]['hotel'] = $hotel;
        $emp_policy[1]['DA'] = $DA;
        $emp_policy[1]['DC'] = $DC;

        $view_data['emp_policy'] = $emp_policy;
        $this->template->write_view('content', 'employees/view_profile', $view_data);
        $this->template->render();
    }

}
