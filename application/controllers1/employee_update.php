<?php

Class Employee_update extends CI_Controller {

    public function __construct() {
        parent::__construct();

//        $this->is_logged_in();
        $header_data = array(
            'page' => 'employees',
            'sub' => 'employees'
        );

        $this->template->write_view('header', 'templates/header_emp', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model('employee_model');
    }

    function index() {
//        DESCR6 // designation
//        Z_PRNTDEPT_DESCR // department
//        DESCR4 // cost center


        $j = 1;
        $sql = "SELECT u.GRADE,u.STEP,e.employee_id FROM users u INNER JOIN employees e on e.employee_id = u.employee_id WHERE e.grade_id='0'";
        $user = $this->db->query($sql);
        $user = $user->result_array();
        
        $total_grade = array();
        foreach ($user as $key => $value) {
            $GRADE = $value['GRADE'];
            $STEP = $value['STEP'];
            $employee_id = $value['employee_id'];

            if ($STEP != '0') {
                $grade_name = $GRADE . "/" . $STEP;
            } else {
                $grade_name = $GRADE;
            }

//            echo $grade_name . "<br><br>";
//            $sql = "SELECT * FROM `employees` WHERE grade_id='0' and employee_id=".$employee_id;
//            $employee_data = $this->db->query($sql);
//            $employee_data = $employee_data->row_array();
//            if(!empty($employee_data)) {
//                po($employee_data);
//            }
            
            $sql = "SELECT id FROM grades WHERE grade_name='" . $grade_name . "'";
            $grade = $this->db->query($sql);
            $grade_list = $grade->row_array();
            if (!empty($grade_list)) {
                $grade_id = $grade_list['id'];

                $this->db->where('employee_id', $employee_id);
                $data['grade_id'] = $grade_id;
                $response = $this->db->update('employees', $data);
                $j++;
            }

//            die();
        }
        echo "Total Record Inserted " . $j;
        
        
        
//        po($total_grade);
//        $sql = "SELECT * FROM grades";
//        $user = $this->db->query($sql);
//        $user = $user->result_array();
//        po($user);
//        $i=2;
//        foreach ($user as $key => $value) {
//            $GRADE = $value['Z_PRNTDEPT_DESCR'];
//            $needed_array = array(
//                'id' => $i,
//                'dept_name' => strtolower($GRADE),
//                'status' => 'active',
//            );
////            po($needed_array);
//            $result = $this->db->insert('departments', $needed_array);
//            $this->db->insert_id();
//            $i++;
//        }
//        $sql = "SELECT distinct(DESCR6) FROM users";
//        $user = $this->db->query($sql);
//        $user = $user->result_array();
////        po($user);
//        $i=2;
//        foreach ($user as $key => $value) {
//            $GRADE = $value['DESCR6'];
//            $needed_array = array(
//                'id' => $i,
//                'desg_name' => strtolower($GRADE),
//                'status' => 'active',
//            );
////            po($needed_array);
//            $result = $this->db->insert('designations', $needed_array);
//            $this->db->insert_id();
//            $i++;
//        }
//        po();
//        $sql = "SELECT distinct(GRADE) FROM users";
//        $user = $this->db->query($sql);
//        $user = $user->result_array();
////        po($user);
//        foreach ($user as $key => $value) {
//            $GRADE = $value['GRADE'];            
//            $needed_array = array(
//                'grade_name' => $GRADE
//            );
//
//            $result = $this->db->insert('grades', $needed_array);
//            $this->db->insert_id();
//        }
//        
//        die();
//        $sql = "SELECT * FROM grades";
//        $user = $this->db->query($sql);
//        $grade_array = $user->result_array();
//
//        $grade_data = array();
//        foreach ($grade_array as $key => $value) {
//            $grade_data[$value['grade_name']] = $value['id'];
//        }
//
//        $sql = "SELECT * FROM designations";
//        $user = $this->db->query($sql);
//        $desg_array = $user->result_array();
//        $desg_data = array();
//        foreach ($desg_array as $key => $value) {
//            $desg_data[$value['desg_name']] = $value['id'];
//        }
//
//        $sql = "SELECT * FROM departments";
//        $user = $this->db->query($sql);
//        $dept_array = $user->result_array();
//        $dept_data = array();
//        foreach ($dept_array as $key => $value) {
//            $dept_data[$value['dept_name']] = $value['id'];
//        }
//
//        $sql = "SELECT * FROM indian_cities";
//        $user = $this->db->query($sql);
//        $city_array = $user->result_array();
//        $city_data = array();
//        foreach ($city_array as $key => $value) {
//            $city_data[$value['name']] = $value['cost_center_id'];
//        }
//        po($desg_array);
//        $sql = "SELECT employee_id FROM users";
//        $user = $this->db->query($sql);
//        $user = $user->result_array();
////        po($user);
//        $j = 0;
//        foreach ($user as $key => $value) {
//            $user_update = array();
//            $user_update['employees_id'] = $value['employee_id'];
//            $user_update['roles_id'] = "1";
//            $this->common->insert_data($user_update, 'employees_role');
//            $GRADE = $value['GRADE'];
//            $designation = strtolower($value['DESCR6']);
//            $department = strtolower($value['Z_PRNTDEPT_DESCR']);
//            $cost_center = $value['DESCR4'];
//
//            $grade_id = $grade_data[$GRADE];
//            $desg_id = $desg_data[$designation];
//            $dept_id = $dept_data[$department];
//            $cost_center_id = $city_data[$cost_center];
//            $sql = "SELECT * FROM employees WHERE id = " . $value['employee_id'];
//            $user = $this->db->query($sql);
//            $user = $user->result_array();
//
//            if (empty($user)) {
//
//                $employee = array(
//                    "id" => $value['employee_id'],
//                    "grade_id" => $grade_id,
//                    "empID" => $value['employee_id'],
//                    "employee_id" => $value['employee_id'],
//                    "gi_email" => $value['email'],
//                    "designation_id" => $desg_id,
//                    "dept_id" => $dept_id,
//                    "cost_center_id" => $cost_center_id,
//                    "city_id" => $cost_center_id,
//                    "reporting_manager_id" => $value['SUPERVISOR_ID'],
//                    "ea_manager_id" => "0",
//                    "reporting_person_id" => $value['SUPERVISOR_ID'],
//                    "location" => "",
//                    "father_name" => "",
//                    "gender" => "Male",
//                    "blood_group" => "",
//                    "dob" => date('Y-m-d', strtotime($value['BIRTHDATE'])),
//                    "phone" => $value['PHONE1'],
//                    "emergency_phone" => "",
//                    "emergency_phone2" => "",
//                    "email" => $value['email'],
//                    "l_address1" => "",
//                    "l_address2" => "",
//                    "l_city" => $value['CITY'],
//                    "l_state" => $value['STATE'],
//                    "l_post_code" => $value['POSTAL'],
//                    "l_country" => $value['COUNTRY'],
//                    "p_address1" => $value['ADDRESS1'],
//                    "p_address2" => $value['ADDRESS2'],
//                    "p_city" => $value['CITY'],
//                    "p_state" => $value['STATE'],
//                    "p_post_code" => $value['POSTAL'],
//                    "p_country" => $value['COUNTRY'],
//                    "pan" => "",
//                    "bank_name" => "",
//                    "bank_account_number" => "",
//                    "bank_account_name" => "",
//                    "bank_ifsc" => "",
//                    "bank_address" => "",
//                    "bank_address" => "active",
//                    "image" => "",
//                    "created" => "",
//                    "modified" => "",
//                    "status_modified" => "",
//                );
//                $result = $this->db->insert('employees', $employee);
//                if ($result) {
//                    $j++;
//                }
////                po();
//            }
//            po($value);
//        }
//        echo "Total Record Inserted " . $j;
    }

    public function edit($empID = '') {
        $view_data = array();
        $employee = $this->employee_model->get_all_employees($empID);

        if (!empty($employee)) {
            redirect(base_url() . 'dashboard');
//            $view_data['employee'] = $employee[0];
        } else {
            $sql = "SELECT * FROM users WHERE employee_id = ?";
            $user = $this->db->query($sql, array($empID));
            $user = $user->row_array();
//            po($user);
            unset($user['employee_id']);
        }
        $view_data['employee'] = $user;



        $ref_code = $this->input->get('ref_code');

        if (!empty($ref_code)) {
            $this->load->model('Candidate_model');
            $employee = $this->Candidate_model->get_candidate_by_ref_code($ref_code);
            $full_date = json_decode($employee['full_data'], true);
            $view_data['employee'] = $full_date;
            //echo "hello<pre>"; print_r($full_date);
        }




        $states = $this->employee_model->get_all_states();
        $view_data['states'] = $states;
//        if (!empty($empID)) {
//            $employee = $this->employee_model->get_employee($empID);
//            $sel_roles = $this->common->select_data_by_id('employees_role', $condition_array = array('employees_id' => $employee['id']), 'roles_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
//            $view_data['sel_roles'] = $sel_roles;
//
//            $l_cities = $this->employee_model->get_all_cities($employee['l_state']);
//            $view_data['l_cities'] = $l_cities;
//            $p_cities = $this->employee_model->get_all_cities($employee['p_state']);
//            $view_data['p_cities'] = $p_cities;
//            if (empty($employee)) {
//                redirect(base_url() . 'employees');
//            }
//            $view_data['employee'] = $employee;
//        }

        $roles = $this->common->select_data_by_id('roles', $condition_array = array('status' => 'active'), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
        $view_data['roles'] = $roles;

        $grades = $this->common->select_data_by_id('grades', $condition_array = array('status' => 'active'), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
        $view_data['grades'] = $grades;

        $this->load->model("desg_model");
        $desgs = $this->desg_model->get_all_desg();
        $view_data['designations'] = $desgs;

        $this->load->model("department_model");
        $department_date = $this->department_model->get_all_department();
        $view_data['department'] = $department_date;

        $all_employee = $this->employee_model->get_all_employees();
        $view_data ['all_employee'] = $all_employee;

        $join_str = array();
        $join_str[0] = array(
            'table' => 'indian_cities c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'indian_cities.cost_center_id',
            'join_type' => 'LEFT'
        );
        $data = 'c.id,c.name as city_name';
        $cost_center = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.cost_center_id !=' => '', 'indian_cities.status' => 'active'), $data, '', '', '', '', $join_str, 'indian_cities.cost_center_id');
        $view_data['cost_center'] = $cost_center;

        if (!empty($empID)) {
            $view_data['empID'] = $empID;
        } else {
            $view_data['empID'] = '';
        }

        //echo "heloo ".$view_data['empID'];exit;
        $emp_check = 0;
        if (empty($employees)) {
            $emp_check = 1;
        }

        $view_data['emp_check'] = $emp_check;
        if (!$this->input->post()) {
            if (!empty($empID)) {
                $view_data['empID'] = $empID;
            } else {
                $view_data['empID'] = $this->employee_model->generate_employee_code();
            }
        }
        $view_data['id'] = $empID;
        $this->template->write_view('content', 'employees/new_employee', $view_data);
        $this->template->render();
    }

    function update() {

        if ($this->input->post()) {
            $post_data = $this->input->post();

            $emp_id = !empty($employee['id']) ? $employee['id'] : '';

            $data = $this->employee_model->validate_emp_email($post_data['gi_email'], $emp_id);
            $post_data['id'] = $post_data['empid'];
            unset($post_data['empid']);
            if (empty($data)) {

                $id = $this->employee_model->update_employee($post_data, $emp_id);
                //echo '<pre>'; print_r($post_data); exit;

                $roles_list = $post_data['role_id'];
                $roles_data = $this->common->selectRecordById('employees_role', $id, 'employees_id');
                if (!empty($roles_data)) {
                    $this->common->delete_data('employees_role', 'employees_id', $id);
                }
                $user_update = array();
                $user_update['employees_id'] = $id;
                $user_update['roles_id'] = "1";
                $this->common->insert_data($user_update, 'employees_role');
                foreach ($roles_list as $key => $role) {
                    $user_update = array();
                    $user_update['employees_id'] = $id;
                    $user_update['roles_id'] = $role;
                    $this->common->insert_data($user_update, 'employees_role');
                }
                $msg = (!empty($empID)) ? 'Employee successfully Updated' : 'Employee successfully Added';
                $this->session->set_flashdata('success', $msg);
                $this->session->sess_destroy();
                redirect(base_url() . 'users/login');
            } else {
                $view_data['error'] = 'Email Address already exists';
            }
        } else {
            if (!empty($empID)) {
                $view_data['empID'] = $empID;
            } else {
                $view_data['empID'] = $this->employee_model->generate_employee_code();
            }
        }
    }

    public function index1() {
        $this->load->model('employee_model');
        $employees = $this->employee_model->get_all_employees();
//        po($employees);
        $view_data = array('employees' => $employees);

        $this->template->write_view('content', 'employees/index', $view_data);
        $this->template->render();
    }

    public function view($emp_code) {
        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee($emp_code);
        $view_data = array('employee' => $employee);
//        po($view_data);
        if ($this->input->post('download')) {

            $filename = 'employee_profile-' . $employee['empID'] . '.pdf';
            //$html = $this->load->view('review/download_timesheet_pdf', $data, true);
            //$this->create_pdf($html, $filename, '');
            require_once APPPATH . 'libraries/pdfcrowd.php';

            try {
                // create an API client instance
                $client = new Pdfcrowd("ajay12345", "3cb15e4f23796d58f6ba35eae6d8f421");

                $html = $this->load->view('employees/download_details', $view_data, true);
                // convert a web page and store the generated PDF into a $pdf variable
                $pdf = $client->convertHtml($html);

                // set HTTP response headers
                //header("Content-Type: application/pdf");
                //header("Cache-Control: max-age=0");
                //header("Accept-Ranges: none");
                //header("Content-Disposition: attachment; filename=\"".$filename."\"");

                $location = 'assets/employee_pdf/';
                file_put_contents($location . $filename, $pdf);
                //echo $pdf;
            } catch (PdfcrowdException $why) {
                $data['error'] = "Pdfcrowd Error: " . $why;
            }
        }

        $this->template->write_view('content', 'employees/view_employee', $view_data);
        $this->template->render();
    }

    public function usernameExits($username = '', $id = '') {
        if (trim($username) != '') {
            $res = $this->common->checkName('users', 'username', $username, 'employee_id', $id);
            if (empty($res)) {
                echo 0;
                die();
            } else {
                echo 1;
                die();
            }
        }
    }

    public function employee_idExits($employee_id = '', $id = '') {
        if (trim($employee_id) != '') {
            $res = $this->common->checkName('employees', 'employee_id', $employee_id, 'id', $id);
            if (empty($res)) {
                echo 0;
                die();
            } else {
                echo 1;
                die();
            }
        }
    }

    public function view_profile() {

        $emp_id = $this->session->userdata('employee_id');

        $this->load->model('employee_model');

        $emp = $this->employee_model->get_employee_by_id($emp_id);
        $employee = $this->employee_model->get_employee($emp['empID']);
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

        $emp_policy[1]['grade_name'] = $grade['grade_name'];
        $emp_policy[1]['transport'] = $grade['transport'];
        $emp_policy[1]['hotel'] = $hotel;
        $emp_policy[1]['DA'] = $DA;
        $emp_policy[1]['DC'] = $DC;

//        foreach ($policy_data as $key => $data) {
////            if ($data['service_type'] == $grade['travel_mode']) {
//                if ($data['service_type'] == "1") {
//                    echo "Flight";
//                } else if ($data['service_type'] == "2") {
//                    echo "Train";
//                    $emp_policy[$data['service_type']]['name'] = "Train";
//                    $emp_policy[$data['service_type']]['grade_name'] = $grade['grade_name'];
//                    $emp_policy[$data['service_type']]['transport'] = $grade['transport'];
//                    $emp_policy[$data['service_type']]['hotel'] = $hotel;
//                    $emp_policy[$data['service_type']]['DA'] = $DA;
//                    $emp_policy[$data['service_type']]['DC'] = $DC;
//                } else if ($data['service_type'] == "3") {
//                    echo "Car";
//                } else if ($data['service_type'] == "4") {
//                    echo "Bus";
//                }
////            }
//        }
//        pr($grade);
//        pr($policy_data);
//        pr($hotel);
//        pr($DA);
//        pr($DC);
//        po($emp_policy);
        $view_data['emp_policy'] = $emp_policy;
        $this->template->write_view('content', 'employees/view_profile', $view_data);
        $this->template->render();
    }

    public function view_candidates() {
        $data = array();
        $post_data = array();
        //echo "hi ";
        $this->load->model('Candidate_model');

        if ($this->input->post()) {

            $post_data = $this->input->post();
        } else {
            $post_data['start_range'] = '';
            $post_data['end_range'] = '';
            $post_data['candidate_id'] = '';
            $post_data['status'] = '';
        }
        $summary = $this->Candidate_model->get_all_status($post_data['start_range'], $post_data['end_range'], $post_data['candidate_id'], $post_data['status']);
        $data['summary'] = $summary;
        $data['candidate_list'] = $this->Candidate_model->get_all_candidates_for_filter();
        //$candidates = $this->Candidate_model->get_all_candidates_new();
        $candidates = $this->Candidate_model->get_all_candidates_list($post_data['start_range'], $post_data['end_range'], $post_data['candidate_id'], $post_data['status']);
        //echo "<pre>"; print_r($candidates); exit;
        $data['candidates'] = $candidates;
        //echo "hello1"; exit;
        if ($this->input->post('download_pdf')) {
            //echo "<pre>";print_r($data);exit;


            $filename = 'Candidate' . '-report.pdf';
            //$html = $this->load->view('review/download_timesheet_pdf', $data, true);
            //$this->create_pdf($html, $filename, '');

            require_once APPPATH . 'libraries/pdfcrowd.php';

            try {
                // create an API client instance
                $client = new Pdfcrowd("ajay12345", "3cb15e4f23796d58f6ba35eae6d8f421");

                $html = $this->load->view('candidate/download', $data, true);

                // convert a web page and store the generated PDF into a $pdf variable
                $pdf = $client->convertHtml($html);

                // set HTTP response headers
                header("Content-Type: application/pdf");
                header("Cache-Control: max-age=0");
                header("Accept-Ranges: none");
                header("Content-Disposition: attachment; filename=\"" . $filename . "\"");

                echo $pdf;
            } catch (PdfcrowdException $why) {
                $data['error'] = "Pdfcrowd Error: " . $why;
            }
        }

        //$this->load->view('employees/view_candidate', $data);
        $this->template->write_view('content', 'employees/view_candidate', $data);
        $this->template->render();
    }

    public function update_profile() {


        $empid = $this->session->userdata('employee_id');
        $view_data = array();
        $this->load->model('employee_model');
        $emp = $this->employee_model->get_employee_by_id($empid);

        $empID = $emp['empID'];

        $states = $this->employee_model->get_all_states();
        $view_data['states'] = $states;

        $employee = $this->employee_model->get_employee($empID);
        $l_cities = $this->employee_model->get_all_cities($employee['l_state']);
        $view_data['l_cities'] = $l_cities;
        $p_cities = $this->employee_model->get_all_cities($employee['p_state']);
        $view_data['p_cities'] = $p_cities;
        if (empty($employee)) {
            redirect(base_url() . 'employees/view_profile');
        }
        $view_data['employee'] = $employee;

        $this->load->model("dept_model");
        $depts = $this->dept_model->get_all_dept();
        $view_data['departments'] = $depts;


        //$this->load->model("dept_model");
        $sub_depts = $this->dept_model->get_all_sub_dept();
        $view_data['sub_depts'] = $sub_depts;

        $this->load->model("desg_model");
        $desgs = $this->desg_model->get_all_desg();
        $view_data ['designations'] = $desgs;

        $view_data['is_dept_head'] = 0;
        if (!empty($empID)) {
            $depts = $this->dept_model->get_dept($employee['department_id']);

            if ($depts['dept_head'] > 0) {
                $view_data['is_dept_head'] = 1;
            }
        }
        //echo '<pre>'; print_r($view_data['is_dept_head']);exit;
        $this->load->model('employee_model');
        if (!empty($empID)) {
            $employees = $this->employee_model->get_reporting_employees_by_sub_dept_and_level($employee['sub_dept_id'], $employee['department_id'], $employee['level']);
            $view_data['employees'] = $employees;
        } else {
            $employees = $this->employee_model->get_all_employees();
            $view_data['employees'] = $employees;
        }

        //print_r($employees); exit;

        if (!empty($empID)) {
            $view_data['empID'] = $empID;
        } else {
            $view_data['empID'] = '';
        }

        //echo "heloo ".$view_data['empID'];exit;

        $emp_check = 0;
        if (empty($employees)) {
            $emp_check = 1;
        }

        $view_data['emp_check'] = $emp_check;

        if ($this->input->post()) {
            $post_data = $this->input->post();
            $get_band = explode(' ', $post_data['designation_id']);
            $post_data['band'] = $get_band[1];
            $emp_id = !empty($employee['id']) ? $employee['id'] : '';

            if (!empty($_FILES['image']['name'])) {
                $output = $this->upload_file('image', $post_data['empID'], "assets/emp_photos/");

                if ($output['status'] == 'success') {
                    $post_data['image'] = $output['file'];
                } else {
                    $data['error'] = $output['error'];
                }
            }

            $data = $this->employee_model->validate_emp_email($post_data['gi_email'], $emp_id);

            if (empty($data)) {
                $id = $this->employee_model->update_profile($post_data, $empid);

                //echo '<pre>'; print_r($post_data); exit;
                if ($id) {

                    $emp = $this->employee_model->get_employee_by_email($post_data['gi_email']);

                    //Pre-load the employee details in case of error.
                    if (empty($view_data['employee']))
                        $view_data['employee'] = $post_data;

                    $employee = $this->employee_model->get_employee($emp['empID']);
                    $view_data = array('employee' => $employee);

                    $msg = 'Profile successfully Updated';
                    $this->session->set_flashdata('success', $msg);

                    redirect(base_url() . 'employees/view_profile');
                }else {
                    $view_data['error'] = 'Email Address already exists';
                }
            } else {
                $view_data['empID'] = $empID;
            }
        }

        $this->template->write_view('content', 'employees/update_profile', $view_data);
        $this->template->render();
    }

    public function attendance_calendar() {
        $data = array();

        $this->load->model('employee_model');

        $sub_dept_head = $this->employee_model->get_sub_dept_lead_by_id($this->session->userdata('employee_id'));
        $dept_head = $this->employee_model->get_dept_head_by_id($this->session->userdata('employee_id'));

        if ($this->session->userdata('type') == 'admin') {

            $employees = $this->employee_model->get_all_employees();
            $user_check = 'admin';
        } else if (!empty($dept_head)) {

            $employees = $this->employee_model->get_all_employees_by_dept_id($dept_head['id']);
            $user_check = 'dept_head';
        } else if (!empty($sub_dept_head)) {

            $employees = $this->employee_model->get_all_employees_by_sub_dept_id($sub_dept_head['id']);
            $user_check = 'sub_dept_head';
        } else if ($this->session->userdata('is_reporting_person')) {

            $employees = $this->employee_model->get_all_employees_by_reporting_person_id($this->session->userdata('employee_id'));
            $user_check = 'reporting_person';
        } else {

            $employees = $this->employee_model->get_all_employees($this->session->userdata('employee_id'));
            $user_check = 'employee';
        }

        $this->load->model('dept_model');
        $dept_heads_array = $this->dept_model->get_all_dept_heads_ids();

        $dept_heads = array();
        $in = 0;
        foreach ($dept_heads_array as $dha) {
            $dept_heads[$in] = $dha['dept_head'];
            $in++;
        }
        //echo $user_check; exit;
        //echo "<pre>"; print_r($dept_heads); exit;

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            //$validate->set_rules('project_id', 'Employee', 'trim|required|xss_clean');
            $validate->set_rules('start_range', 'Start Range', 'trim|required|xss_clean');
            $validate->set_rules('end_range', 'End Range', 'trim|required|xss_clean');

            if ($validate->run() === TRUE) {
                $post_data = $this->input->post();
                $start_range = $this->input->post('start_range');
                $end_range = $this->input->post('end_range');
                $employee_id = $this->input->post('employee_id');

                $employee_string = '';

                if (empty($employee_id)) {
                    $e = 0;
                    foreach ($employees as $em) {
                        if ($e == 0) {
                            $employee_string .= $em['id'];
                        } else {
                            $employee_string .= " ," . $em['id'];
                        }
                        $e++;
                    }
                } else {
                    $employee_string = implode(",", $employee_id);
                }

                //echo $employee_string.' '.$employee_id."<pre>"; print_r($employees); exit;

                $date_array = array();

                $date = $start_range;
                while (strtotime($date) <= strtotime($end_range)) {
                    $date_array[$date] = array();
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }

                $period = new DatePeriod(new DateTime($start_range), new DateInterval('P1D'), new DateTime($end_range . ' +1 day'));
                foreach ($period as $date) {
                    $diff_dates[] = $date->format("Y-m-d");
                }

                $festival_dates = $this->employee_model->get_festival_dates($start_range, $end_range);

                $i = 0;
                if (!empty($festival_dates)) {
                    foreach ($festival_dates as $fd) {
                        $festival_array[$i] = $fd['festival_date'];
                        $i++;
                    }
                } else {
                    $festival_array = array();
                }

                $weekend_array = array();
                $l = 0;
                for ($k = 0; $k < sizeof($diff_dates); $k++) {
                    $date = $diff_dates[$k];
                    $weekDay = date('w', strtotime($date));

                    if ($weekDay == 0 || $weekDay == 6) {
                        $weekend_array[$l] = $date;
                        $l++;
                    }
                }

                $employee_attendance = $this->employee_model->get_employee_attendence($start_range, $end_range, $employee_string);

                /* echo "<pre>"; 
                  echo $this->db->last_query();
                  print_r($employee_attendance); exit; */

                $this->load->model('leave_model');
                $this->load->model('short_leave_model');

                $dates = array();
                $i = 0;

                if (empty($employee_attendance)) {

                    foreach ($employee_id as $emp_id) {

                        $emp_details = $this->employee_model->get_all_employees($emp_id);
                        foreach ($emp_details as $emp_dtl) {

                            for ($dt = 0; $dt < sizeof($diff_dates); $dt++) {

                                if (!in_array($emp_dtl['id'], $dept_heads)) {

                                    $dates[$emp_dtl['empID']][$i][0] = $diff_dates[$dt];
                                    $dates[$emp_dtl['empID']][$i][1] = $emp_dtl['first_name'] . " " . $emp_dtl['last_name'];
                                    $dates[$emp_dtl['empID']][$i][2] = $emp_dtl['empID'];
                                    $dates[$emp_dtl['empID']][$i][3] = 0;
                                    $dates[$emp_dtl['empID']][$i][4] = 0;
                                    $dates[$emp_dtl['empID']][$i][5] = $emp_dtl['id'];
                                    $dates[$emp_dtl['empID']][$i][10] = $emp_dtl['reporting_person_name'];
                                    $dates[$emp_dtl['empID']][$i][11] = $emp_dtl['doj'];

                                    $available_leaves = $this->leave_model->get_available_leave_by_employee_id($emp_dtl['id']);

                                    $total_pending = $this->employee_model->get_pending_leave_count($start_range, $end_range, $emp_dtl['id']);

                                    $is_leave = $this->leave_model->get_date_wise_leave($diff_dates[$dt], $emp_dtl['id']);

                                    if (!empty($is_leave)) {
                                        $dates[$emp_dtl['empID']][$i][6] = '<b style="color:blue;">L</b>';
                                        $dates[$emp_dtl['empID']][$i][8] = "L";
                                    } else {
                                        $dates[$emp_dtl['empID']][$i][6] = '<b style="color:red;">A</b>';
                                        $dates[$emp_dtl['empID']][$i][8] = "A";
                                    }

                                    if ($available_leaves['available_leaves'] < 0) {

                                        $dates[$emp_dtl['empID']][$i][9] = $total_pending['total_pending'] + $available_leaves['available_leaves'];
                                    } else {
                                        $dates[$emp_dtl['empID']][$i][9] = $available_leaves['available_leaves'];
                                    }

                                    $dates[$emp_dtl['empID']][$i][7] = 0;
                                    $i++;
                                }
                            }
                        }
                    }
                } else {

                    foreach ($employee_attendance as $ea) {

                        if (!in_array($ea['id'], $dept_heads)) {

                            $dates[$ea['empID']][$i][0] = $ea['date'];
                            $dates[$ea['empID']][$i][1] = $ea['first_name'] . " " . $ea['last_name'];
                            $dates[$ea['empID']][$i][2] = $ea['empID'];
                            $dates[$ea['empID']][$i][3] = $ea['hours'];
                            $dates[$ea['empID']][$i][4] = $ea['minutes'];
                            $dates[$ea['empID']][$i][5] = $ea['id'];
                            $dates[$ea['empID']][$i][10] = $ea['reporting_person_name'];
                            $dates[$ea['empID']][$i][11] = $ea['doj'];

                            $available_leaves = $this->leave_model->get_available_leave_by_employee_id($ea['id']);

                            $total_pending = $this->employee_model->get_pending_leave_count($start_range, $end_range, $ea['id']);

                            //echo $ea['date']."<pre>"; print_r($diff_dates); echo "</pre>";

                            $is_leave = $this->leave_model->get_date_wise_leave($ea['date'], $ea['id']);

                            $total_count = 0;

                            if ((!isset($is_leave) || empty($is_leave))) {

                                $time = $ea['hours'] * 60 + $ea['minutes'];
                                if ($time >= 420) {
                                    $attendance = '<b style="color:green;">P</b>';
                                    $attendance1 = "P";
                                    $total_count = $total_count + 1;
                                } else {
                                    if ($time >= 360) {

                                        $is_short_leave = $this->short_leave_model->get_date_wise_short_leave($ea['date'], $ea['id']);
                                        if ((!isset($is_short_leave) || empty($is_short_leave))) {
                                            $attendance = '<b style="color:#6698FF;">0.75D</b>';
                                            $attendance1 = "0.75D";
                                            $total_count = $total_count + 0.75;
                                        } else {
                                            $attendance = '<b style="color:green;">P</b>';
                                            $attendance1 = "P";
                                            $total_count = $total_count + 1;
                                        }
                                    } else if ($time >= 180) {

                                        $is_half_day = $this->leave_model->get_date_wise_half_day($ea['date'], $ea['id']);
                                        if ((!isset($is_half_day) || empty($is_half_day))) {
                                            $attendance = '<b style="color:#6698FF;">0.5D</b>';
                                            $attendance1 = "0.5D";
                                            $total_count = $total_count + 0.5;
                                        } else {
                                            $attendance = '<b style="color:green;">P</b>';
                                            $attendance1 = "P";
                                            $total_count = $total_count + 1;
                                        }
                                    } else {
                                        $attendance = '<b style="color:red;">A</b>';
                                        $attendance1 = "A";
                                    }
                                }
                            } else {
                                $attendance = '<b style="color:blue;">L</b>';
                                $attendance1 = "L";
                            }

                            $dates[$ea['empID']][$i][6] = $attendance;
                            $dates[$ea['empID']][$i][8] = $attendance1;
                            $dates[$ea['empID']][$i][7] = $total_count;
                            if ($available_leaves['available_leaves'] < 0) {

                                $dates[$ea['empID']][$i][9] = $total_pending['total_pending'] + $available_leaves['available_leaves'];
                            } else {
                                $dates[$ea['empID']][$i][9] = $available_leaves['available_leaves'];
                            }
                            //$dates[$ea['empID']][$i][9] = $available_leaves['available_leaves'];

                            $i++;
                        }
                    }
                }

                //echo "<pre>"; print_r($dates); echo "</pre>"; exit;

                if ($this->input->post('download')) {

                    $headers[0] = 'Reporting Person';
                    $headers[1] = 'Employee Name';
                    for ($h = 0; $h < sizeof($diff_dates); $h++) {

                        $headers[$h + 2] = $diff_dates[$h];
                    }

                    $headers[$h + 2] = 'Total';

                    //echo "<pre>"; print_r($headers); exit;

                    $download_array = array();
                    $i = 0;
                    $da = 0;
                    foreach ($dates as $employee) {

                        $download_array[$da][0] = $employee[$i][10];
                        $download_array[$da][1] = $employee[$i][1];

                        $ip = $i;
                        $j = 0;
                        $total_count = 0;
                        foreach ($employee as $emp) {

                            $date1 = date_create($emp[11]);
                            $date2 = date_create($diff_dates[$j]);
                            $diff = date_diff($date1, $date2);
                            $num_days = $diff->format("%R%a days");

                            //if($num_days >= 0){

                            while ($diff_dates[$j] != $emp[0]) {

                                $is_leave = $this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);
                                if (in_array($diff_dates[$j], $festival_array)) {
                                    $download_array[$da][$j + 2] = "F";
                                    if ($num_days >= 0) {
                                        $total_count = $total_count + 1;
                                    }
                                } else if (in_array($diff_dates[$j], $weekend_array)) {
                                    $download_array[$da][$j + 2] = "W";
                                } else if (!empty($is_leave)) {
                                    $download_array[$da][$j + 2] = "L";
                                    if ($num_days >= 0) {
                                        $total_count = $total_count + 1;
                                    }
                                } else {
                                    $download_array[$da][$j + 2] = "A";
                                }
                                $j++;
                            }
                            if ($diff_dates[$j] == $emp[0]) {
                                $is_leave = $this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);

                                if (in_array($diff_dates[$j], $festival_array)) {
                                    $download_array[$da][$j + 2] = "F";
                                    if ($num_days >= 0) {
                                        $total_count = $total_count + 1;
                                    }
                                } else if (in_array($diff_dates[$j], $weekend_array)) {
                                    $download_array[$da][$j + 2] = "W";
                                } else if (!empty($is_leave)) {
                                    if ($num_days >= 0) {
                                        $total_count = $total_count + 1;
                                    }
                                    $download_array[$da][$j + 2] = "L";
                                } else {
                                    $total_count = $total_count + $emp[7];
                                    $download_array[$da][$j + 2] = $emp[8];
                                }
                            } else {

                                $is_leave = $this->leave_model->get_date_wise_leave($diff_dates[$j], $employee[$ip][5]);

                                if (in_array($diff_dates[$j], $festival_array)) {
                                    $download_array[$da][$j + 2] = "F";
                                    if ($num_days >= 0) {
                                        $total_count = $total_count + 1;
                                    }
                                } else if (in_array($diff_dates[$j], $weekend_array)) {
                                    $download_array[$da][$j + 2] = "W";
                                } else if (!empty($is_leave)) {
                                    $download_array[$da][$j + 2] = "L";
                                    if ($num_days >= 0) {
                                        $total_count = $total_count + 1;
                                    }
                                } else {
                                    $download_array[$da][$j + 2] = "A";
                                }
                            }
                            $i++;
                            $j++;
//                            }else{
//                                $j++;
//                            }
                        }

                        for ($k = $j; $k < sizeof($diff_dates); $k++) {

                            $date1 = date_create($employee[$ip][11]);
                            $date2 = date_create($diff_dates[$k]);
                            $diff = date_diff($date1, $date2);
                            $num_days = $diff->format("%R%a days");

                            //if($num_days >= 0){

                            $is_leave = $this->leave_model->get_date_wise_leave($diff_dates[$k], $employee[$ip][5]);

                            if (in_array($diff_dates[$k], $festival_array)) {
                                $download_array[$da][$k + 2] = "F";
                                if ($num_days >= 0) {
                                    $total_count = $total_count + 1;
                                }
                            } else if (in_array($diff_dates[$k], $weekend_array)) {
                                $download_array[$da][$k + 2] = "W";
                            } else if (!empty($is_leave)) {
                                $download_array[$da][$k + 2] = "L";
                                if ($num_days >= 0) {
                                    $total_count = $total_count + 1;
                                }
                            } else {
                                $download_array[$da][$k + 2] = "A";
                            }
                            //}
                        }

                        if ($employee[$ip][9] < 0) {
                            $avl_leaves = $employee[$ip][9];
                        } else {
                            $avl_leaves = 0;
                        }

                        $download_array[$da][$k + 2] = $total_count + $avl_leaves;

                        $da++;
                    }

                    //echo "<pre>"; print_r($download_array); exit;

                    $filename = 'Employees_Attendance(' . $start_range . '_' . $end_range . ')_' . time() . '.xls';
                    $title = 'Employee Attendance Sheet For Period ' . date('jS M, Y', strtotime($start_range)) . ' to ' . date('jS M, Y', strtotime($end_range));

                    $this->create_excel_downloads($headers, $download_array, $filename, $title);
                }


                $data['diff_dates'] = $diff_dates;

                $data['festival_array'] = $festival_array;

                $data['weekend_array'] = $weekend_array;

                $data['employee_attendance'] = $dates;
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['employees'] = $employees;
        $data['user_check'] = $user_check;
        $data['dept_heads'] = $dept_heads;

        $this->template->write_view('content', 'employees/attendance_calendar', $data);
        $this->template->render();
    }

    public function pending_notifications() {

        $data = array();

        $this->load->model('employee_model');

        $sub_dept_head = $this->employee_model->get_sub_dept_lead_by_id($this->session->userdata('employee_id'));
        $dept_head = $this->employee_model->get_dept_head_by_id($this->session->userdata('employee_id'));

        if ($this->session->userdata('type') == 'admin') {

            $employees = $this->employee_model->get_all_employees();
            $user_check = 'admin';
        } else if (!empty($dept_head)) {

            $employees = $this->employee_model->get_all_employees_by_dept_id($dept_head['id']);
            $user_check = 'dept_head';
        } else if (!empty($sub_dept_head)) {

            $employees = $this->employee_model->get_all_employees_by_sub_dept_id($sub_dept_head['id']);
            $user_check = 'sub_dept_head';
        } else if ($this->session->userdata('is_reporting_person')) {

            $employees = $this->employee_model->get_all_employees_by_reporting_person_id($this->session->userdata('employee_id'));
            $user_check = 'reporting_person';
        } else {

            $employees = $this->employee_model->get_all_employees($this->session->userdata('employee_id'));
            $user_check = 'employee';
        }

        if ($this->input->post()) {

            $this->load->library('form_validation');

            $validate = $this->form_validation;
            //$validate->set_rules('project_id', 'Employee', 'trim|required|xss_clean');
            $validate->set_rules('start_range', 'Start Range', 'trim|required|xss_clean');
            $validate->set_rules('end_range', 'End Range', 'trim|required|xss_clean');

            if ($validate->run() === TRUE) {
                $post_data = $this->input->post();
                $start_range = $this->input->post('start_range');
                $end_range = $this->input->post('end_range');
                $employee_id = $this->input->post('employee_id');

                $employee_string = '';

                if (empty($employee_id)) {

                    $e = 0;
                    foreach ($employees as $em) {
                        if ($e == 0) {
                            $employee_string .= $em['id'];
                        } else {
                            $employee_string .= " ," . $em['id'];
                        }
                        $e++;
                    }
                } else {
                    $employee_string = $employee_id;
                }

                $this->load->model('notification_model');
                $notifications = $this->notification_model->get_noti_count($employee_string, $start_range, $end_range);

                //echo "<pre>"; print_r($notifications); exit;

                $data['notifications'] = $notifications;
            } else {
                $data['error'] = validation_errors();
            }
        }

        $data['employees'] = $employees;
        $data['user_check'] = $user_check;

        $this->template->write_view('content', 'employees/pending_notifications', $data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {

        $this->load->model('Employee_model');
        $employee = $this->Employee_model->get_employee($code);

        if (!$employee) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->Employee_model->change_status($code, $status)) {
                $this->session->set_flashdata('success', 'Employee marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'employees/view/' . $code);
        } else {
            redirect(base_url() . 'employees');
        }
    }

    public function delete_employee($id) {
        if (($this->session->userdata('type') == 'admin') || $this->session->userdata('dept_head') == 1) {
            $this->load->model('Employee_model');
            $emp = $this->Employee_model->get_employee_by_id($id);

            if (!$emp) {
                $this->session->set_flashdata('error', 'Invalid record');
            } else {

                if ($this->Employee_model->delete_item($id)) {
                    $this->session->set_flashdata('success', 'Employee deleted successfully');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
                }
            }

            redirect(base_url() . 'employees');
        } else {
            $this->session->set_flashdata('error', 'Access Denied.');
            redirect(base_url() . 'dashboard');
        }
    }

    public function my_reportees() {

        $emp_id = $this->session->userdata('employee_id');

        $this->load->model('employee_model');
        $reportees = $this->employee_model->get_reportees($emp_id);

        $data['reportees'] = $reportees;

        $this->template->write_view('content', 'employees/my_reportees', $data);
        $this->template->render();
    }

    public function employee_hierarchy() {

        $emp_id = $this->session->userdata('employee_id');
        $email = $this->session->userdata('gi_email');
        $name = $this->session->userdata('name');

        $this->load->model('employee_model');
        $emp_hierarchy = $this->employee_model->get_employee_hierarchy($emp_id, $email, $name);

        $data['emp_hierarchy'] = $emp_hierarchy;

        $this->template->write_view('content', 'employees/employee_hierarchy', $data);
        $this->template->render();
    }

    function validate_email($email = '', $emp_id = '') {
        $this->load->model('employee_model');
        $email = urldecode($email);
        $data = $this->employee_model->validate_emp_email($email, $emp_id);

        if (!empty($data)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function populate_reporting_person($sub_dept, $dept_id, $band) {
        $this->load->model('employee_model');
        $this->load->model('desg_model');

        $desg = $this->desg_model->get_desg_band($band);
        $data = $this->employee_model->get_reporting_employees_by_sub_dept_and_level($sub_dept, $dept_id, $desg['level']);
        echo json_encode($data);
    }

    function get_indian_cities($state) {
        $this->load->model('employee_model');
        $data = $this->employee_model->get_all_cities($state);
        //echo '<pre>'; print_r($data); 
        echo json_encode($data);
    }

    function get_indian_cities_by_id($state) {
        $this->load->model('employee_model');
        $data = $this->employee_model->get_all_cities_by_id($state);
        //echo '<pre>'; print_r($data); 
        echo json_encode($data);
    }

    function get_indian_cities_class($city) {
        $this->load->model('employee_model');
        $data = $this->employee_model->get_cities_by_id($city);
//        echo '<pre>'; print_r($data); 
        echo json_encode($data);
    }

}
