<?php

Class Employees extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->is_logged_in();
        $header_data = array(
            'page' => 'employees',
            'sub' => 'employees'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model('employee_model');
    }

    public function ajax_list() {
        $employee_data = $this->employee_model->get_datatables();
        $result_data = array();
        $all_employee = array();
        $response = array();
        if (!empty($employee_data)) {
            $start = $this->input->post("start");
            foreach ($employee_data as $key => $emp) {
                $result_data = array();
                $result_data[] = trim($emp->employee_id);
                $result_data[] = trim($emp->first_name) . " " . trim($emp->last_name);
                $result_data[] = trim($emp->email);
                $curr_stats = $emp->is_active == 'active' ? 'inactive' : 'active';
                $Mark_stats = $emp->is_active != 'active' ? 'Mark Inactive' : 'Mark Active';

                $status = $emp->is_active;

                $result_data[] = "<a class='btn btn-xs green' href=" . base_url() . "employees/view/" . $emp->employee_id . "><i class='fa fa-eye'></i> View </a>
                                        <a class='btn btn-xs purple-plum' href=" . base_url() . "employees/add/" . $emp->employee_id . "><i class='fa fa-edit'></i> Edit</a>
                                    <a class='btn btn-xs btn-warning' href='#' data-href=" . site_url('employees/status') . "/" . $emp->employee_id . "/" . $curr_stats . " data-toggle='modal' data-target='#confirm-delete' title='Delete'><i class='fa fa-retweet'></i> " . $Mark_stats . "</a>";
                $all_employee[] = $result_data;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee_model->count_all(),
            "recordsFiltered" => $this->employee_model->count_filtered(),
            "data" => $all_employee,
        );
        echo json_encode($output);
    }

    function delete_employees() {
        if ($this->input->post('emp_id')) {
            $emp_id = $this->input->post('emp_id');
            if ($this->session->userdata('emp_list')) {
                $emp_list = $this->session->userdata('emp_list');
                unset($emp_list[$emp_id]);
                $array = array(
                    "emp_list" => $emp_list
                );
                $this->session->set_userdata($array);
            }
            echo "1";
        } else {
            echo "0";
        }
    }

    function get_employee() {
        if ($this->session->userdata('emp_list')) {
            $emp_list = $this->session->userdata('emp_list');
            $this->data['emp_list'] = $emp_list;
        } else {
            $this->data['emp_list'] = array();
        }
        $this->load->view('employees/emp_list', $this->data);
    }

    function add_employee() {
        if ($this->input->post('sel_emp')) {
            $sel_emp = $this->input->post('sel_emp');
            $employees_data = $this->common->select_data_by_id('users', 'employee_id', $sel_emp, 'employee_id as id,email,first_name,last_name');
            if ($this->session->userdata('emp_list')) {
                $emp_list = $this->session->userdata('emp_list');
            } else {
                $emp_list = array();
            }
            $emp_list [$sel_emp] = $employees_data[0];

            $array = array(
                "emp_list" => $emp_list
            );
            $this->session->set_userdata($array);
            echo "1";
        } else {
            echo "0";
        }
    }

    function find_employees() {

        $name = $this->input->get('term');

        $display_json = array();
        $json_arr = array();

        $like_array = array('u.email' => $name, 'u.first_name' => $name);
        $stud_list = $this->employee_model->select_data_by_condition('users u', array(), 'u.first_name,u.last_name,u.employee_id as id,u.email as name', '', '', '10', '', array(), $like_array);
        if (count($stud_list) == 0) {
            $json_arr["id"] = "#";
            $json_arr["value"] = "";
            $json_arr["label"] = "No Result Found !";
            array_push($display_json, $json_arr);
        }

        foreach ($stud_list as $recSql) {
            if (trim($recSql['name']) == null) {
                $name = $recSql['first_name'] . " " . $recSql['last_name'];
            } else {
                $name = $recSql['name'];
            }
            $json_arr["id"] = $recSql['id'];
            $json_arr["value"] = $name;
            $json_arr["label"] = $name;
            array_push($display_json, $json_arr);
        }

        $jsonWrite = json_encode($display_json); //encode that search data
        print $jsonWrite;
    }

    public function index() {
//        $this->load->model('employee_model');
//        $employees = $this->employee_model->get_all_employees();
//        po($employees);
        $employees = array();
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

    public function add($empID = '', $dept_id = '') {

        $view_data = array();
        $ref_code = $this->input->get('ref_code');

        if (!empty($ref_code)) {
            $this->load->model('Candidate_model');
            $employee = $this->Candidate_model->get_candidate_by_ref_code($ref_code);
            $full_date = json_decode($employee['full_data'], true);
            $view_data['employee'] = $full_date;
            //echo "hello<pre>"; print_r($full_date);
        }

        $this->load->model('employee_model');


        $states = $this->employee_model->get_all_states();
        $view_data['states'] = $states;
        if (!empty($empID)) {
            $employee = $this->employee_model->get_employee($empID);
            $sel_roles = $this->common->select_data_by_id('employees_role', $condition_array = array('employees_id' => $employee['id']), 'roles_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
            $view_data['sel_roles'] = $sel_roles;

            $l_cities = $this->employee_model->get_all_cities($employee['l_state']);
            $view_data['l_cities'] = $l_cities;
            $p_cities = $this->employee_model->get_all_cities($employee['p_state']);
            $view_data['p_cities'] = $p_cities;
            if (empty($employee)) {
                redirect(base_url() . 'employees');
            }
            $view_data['employee'] = $employee;
        }
//        po($view_data['employee']);
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

//        $all_employee = $this->employee_model->get_all_employees();
//        $view_data ['all_employee'] = $all_employee;

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
        if ($this->input->post()) {

            $post_data = $this->input->post();
            $post_data['username'] = $post_data['alias'];
            if (empty($post_data['reporting_manager_id'])) {
                $view_data['error'] = 'Please select Reporting Manager';
                $this->session->set_flashdata('error', 'Please select Reporting Manager');
                redirect('employees/index', 'refresh');
            }
            if (empty($post_data['ea_manager_id'])) {
                $post_data['ea_manager_id'] = '0';
//                unset($post_data['ea_manager_id']);
            }
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
                $id = $this->employee_model->update_employee($post_data, $empID);

                //echo '<pre>'; print_r($post_data); exit;
                if ($id) {
                    $user_id = '';
                    if (!empty($empID)) {
                        $id = $employee['id'];
                        $user_id = $employee['user_id'];
                    }

                    $user_update = array();
                    $user_update['first_name'] = $post_data['first_name'];
                    $user_update['last_name'] = $post_data['last_name'];
                    $user_update['username'] = $post_data['username'];
                    $user_update['email'] = $post_data['gi_email'];
                    $user_update['password'] = $post_data['password'];
                    if ($user_id == '') {
                        $user_update['type'] = 'employee';
                    }
                    $user_update['is_active'] = 1;
                    $user_update['employee_id'] = $id;


                    $this->load->model('User_model');
                    $user_id = $this->User_model->update_user($user_update, $user_id);
//                    echo $this->db->last_query();exit;

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


                    $emp = $this->employee_model->get_employee_by_email($post_data['gi_email']);

                    if (!empty($ref_code) && !empty($emp)) {
                        $this->load->model('Candidate_model');
                        $Candidate = $this->Candidate_model->update_candidate_id($ref_code, $emp['id']);
                    }

                    //Pre-load the employee details in case of error.
                    if (empty($view_data['employee']))
                        $view_data['employee'] = $post_data;

                    if ($user_id) {

                        if (empty($empID)) {

                            $desg_id = explode(" ", $post_data['designation_id']);
                            $degn = $this->desg_model->get_desg($desg_id[0]);
                            $employee = $this->employee_model->get_employee($emp['empID']);
//                                po($employee);
                            $view_data = array('employee' => $employee);

                            $path = '';

                            $filename = 'employee_profile-' . $emp["empID"] . '.pdf';
                            require_once APPPATH . 'libraries/pdfcrowd.php';

                            try {
                                // create an API client instance
                                $client = new Pdfcrowd("ajay12345", "3cb15e4f23796d58f6ba35eae6d8f421");

                                $html = $this->load->view('employees/download_details', $view_data, true);
                                // convert a web page and store the generated PDF into a $pdf variable
                                $pdf = $client->convertHtml($html);

                                $location = 'assets/employee_pdf/';
                                file_put_contents($location . $filename, $pdf);
                                //echo $pdf;
                            } catch (PdfcrowdException $why) {
                                $data['error'] = "Pdfcrowd Error: " . $why;
                            }

                            if ($post_data['gender'] == 'Male') {
                                $him_her = 'him';
                                $he_she = 'he';
                                $he_she_c = 'He';
                                $his_her = 'his';
                                $mr = 'Mr';
                            } else {
                                $him_her = 'her';
                                $he_she = 'she';
                                $he_she_c = 'She';
                                $his_her = 'her';
                                $mr = 'Ms';
                            }

                            $subject = "Welcome " . $post_data['first_name'] . " " . $post_data['last_name'] . " to CRG Family";
                            $messege = "Dear " . $post_data['first_name'] . " " . $post_data['last_name'] . ",<br><br>
                                A warm welcome to CRG Family.<br>
                                Please find a screen shot of your profile in the attachment.<br><br>
                                Best Regards,<br><br>
                                Team HR.<br>";

                            $attachment_profile = $path . 'assets/employee_pdf/employee_profile-' . $emp['empID'] . '.pdf';
                            $to = $post_data['gi_email'];
                            //$to='puneet.dwivedi@crgroup.com';
                            $this->sendMail($to, $subject, $messege, '', $attachment_profile);

                            $subject_fin = "A new member " . $post_data['first_name'] . " " . $post_data['last_name'] . " has joined CRG Family";
                            $messege_fin = "Hi Team,<br><br>
                                A new team member, <b>" . $post_data['first_name'] . " " . $post_data['last_name'] . "</b>, has joined the CRG Family today.<br>
                                Please find detailed profile below -<br><br>";

                            $messege_fin .= "<table border = '1'>";

                            /* Basic Info Starts */
                            $messege_fin .= "<tr><td colspan='4'><b style='color:#5975DC;'>BASIC INFORMATION</b></td></tr>";
                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Employee ID</b></td>";
                            $messege_fin .= "<td>" . $employee['empID'] . "</td>";
                            $messege_fin .= "<td><b>Email(Official)</b></td>";
                            $messege_fin .= "<td>" . $employee['gi_email'] . "</td>";
                            $messege_fin .= "</tr>";

                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Designation</b></td>";
                            $messege_fin .= "<td>" . $employee['desg_name'] . "</td>";
                            $messege_fin .= "<td><b>Grade</b></td>";
                            $messege_fin .= "<td>" . $employee['grade_name'] . "</td>";
                            $messege_fin .= "</tr>";

                            /* Personal Info Starts */
                            $messege_fin .= "<tr><td colspan='4'><b style='color:#5975DC;'>PERSONAL INFORMATION</b></td></tr>";
                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>First Name</b></td>";
                            $messege_fin .= "<td>" . ucwords($employee['first_name']) . "</td>";
                            $messege_fin .= "<td><b>Middle Name</b></td>";
                            $messege_fin .= "<td>" . ucwords($employee['middle_name']) . "</td>";
                            $messege_fin .= "</tr>";

                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Last Name</b></td>";
                            $messege_fin .= "<td>" . ucwords($employee['last_name']) . "</td>";
                            $messege_fin .= "<td><b>Father Name</b></td>";

                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Gender</b></td>";
                            $messege_fin .= "<td>" . $employee['gender'] . "</td>";
                            $messege_fin .= "</tr>";

                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Mobile Number</b></td>";
                            $messege_fin .= "<td>" . $employee['phone'] . "</td>";
                            $messege_fin .= "<td><b>Date of Birth</b></td>";
                            $messege_fin .= "<td>" . date('jS M, Y', strtotime($employee['dob'])) . "</td>";
                            $messege_fin .= "</tr>";

                            /* Local Address */
                            $messege_fin .= "<tr><td colspan='4'><b style='color:#5975DC;'>LOCAL ADDRESS</b></td></tr>";
                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Address 1</b></td>";
                            $messege_fin .= "<td>" . $employee['l_address1'] . "</td>";
                            $messege_fin .= "<td><b>Address 2</b></td>";
                            $messege_fin .= "<td>" . $employee['l_address2'] . "</td>";
                            $messege_fin .= "</tr>";

                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>City</b></td>";
                            $messege_fin .= "<td>" . $employee['l_city'] . "</td>";
                            $messege_fin .= "<td><b>State</b></td>";
                            $messege_fin .= "<td>" . $employee['l_state'] . "</td>";
                            $messege_fin .= "</tr>";

                            $messege_fin .= "<tr>";
                            $messege_fin .= "<td><b>Country</b></td>";
                            $messege_fin .= "<td>" . $employee['l_country'] . "</td>";
                            $messege_fin .= "<td><b>Post Code</b></td>";
                            $messege_fin .= "<td>" . $employee['l_post_code'] . "</td>";
                            $messege_fin .= "</tr>";
                            /* Local Address */

                            $messege_fin .= "</table><br><br>";

                            $messege_fin .= "Best Regards,<br><br>
                                Team HR.<br>";

                            $attachment_profile_fin = $path . 'assets/employee_pdf/employee_profile-' . $emp['empID'] . '.pdf';
                            $to_fin = "vchitale@crgroup.com,vbhokse@crgroup.com,kreengasia@crgroup.co.in";
                            $cc_fin = "hsethi@crgroup.co.in,avaidya@crgroup.com,rsethi@crgroup.co.in";
                            //$to_fin="sjindal@crgroup.co.in";
                            $this->sendMail($to_fin, $subject_fin, $messege_fin, '', $attachment_profile_fin, $cc_fin);

                            //Email to all reporting heads in the hierarchy
//                                $dept_details = $this->employee_model->get_dept_head_dept_id($post_data['department_id']);
//                                $sub_dept_detials = $this->dept_model->get_sub_dept($emp['sub_dept_id']);
                            //$emp = $this->employee_model->get_employee_by_email($post_data['gi_email']);
                            $rep_person = $emp['reporting_person_id'];

                            //Mail to all in the company
                            $subject_all = "Welcome " . $post_data['first_name'] . " " . $post_data['last_name'] . " to CRG Family";
                            $messege_all = "<p>Dear Team,<br><br>
                                Team HR take this opportunity to join you all in extending a warm welcome to
                                <b>" . $post_data['first_name'] . " " . $post_data['last_name'] . "</b>,
                                who has joined 
                                <b style='color:#337ab7;'>Corporate</b> <b style='color:#f26e22;'>Renaissance</b> <b style='color:#337ab7;'>Group</b> 
                                <b>" . $post_data['location'] . "</b> as <b>" . $degn['desg_name'] . "</b>.
                                <br><br></p>";
                            if (!empty($emp['image'])) {
                                $messege_all .= "<p style='text-align:center;'><img src='" . base_url() . $emp['image'] . "' height='100' width='100' /></p>";
                            }
                            $messege_all .= "We look forward to your support and cooperation to " . $mr . " <b>" . $post_data['first_name'] . " " . $post_data['last_name'] . "</b>,
                                in " . $his_her . " current assignment and wish " . $him_her . " a happy association with the CRG Family.<br><br>
                                You can all reach " . $him_her . " at " . $post_data['gi_email'] . "<br><br>
                                Best Regards,<br><br>
                                Team HR.<br>";

                            //$to_all='hsethi@crgroup.com';
                            $to_all = 'all@crgroup.co.in';
                            //$to_all='puneet.dwivedi@crgroup.com';
                            $this->sendMail($to_all, $subject_all, $messege_all);

                            $attachment_array = array("assets/CRG-Travel-Policy.pdf",
                                "assets/CRG-Working-hours-Guidelines.pdf",
                                "assets/Reimbursement_Policy.pdf",
                                "assets/short_leave_policy.pdf",
                                "assets/leave_policy.pdf",
                                "assets/ERP_policy.pdf",
                                "assets/Discipline_policy.pdf",
                                "assets/Employee_Receipt_for_Company_Property.pdf");

                            $subject_policy = "Company Policies";
                            $messege_policy = "Dear " . $post_data['first_name'] . " " . $post_data['last_name'] . "<br><br>
                                We at Team HRD would like to share the set of policies that we have to adhere to in CRG. 
                                Please find enclosed the company policies for your quick reference.<br>
                                You may also find the same in your Employee folder under section <b>Policies</b>.<br>
                                Look forward to have long term association with you.<br><br>
                                Thank You<br><br>
                                Team HRD.<br><br>
                                CRG Solutions Pvt Ltd.<br>";

                            $to_policy = $post_data['gi_email'];
                            //$to_policy = 'puneet.dwivedi@crgroup.com';
                            $this->sendMail_with_multiple_attachment($to_policy, $subject_policy, $messege_policy, '', $attachment_array);
                        }

                        $msg = (!empty($empID)) ? 'Employee successfully Updated' : 'Employee successfully Added';
                        $this->session->set_flashdata('success', $msg);

                        redirect(base_url() . 'employees');
                    } else {
                        $view_data['error'] = 'Something went wrong, please try again ';
                    }
                } else {
                    $view_data['error'] = 'Something went wrong, please try again ';
                }
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

        $this->template->write_view('content', 'employees/add_employee', $view_data);
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
