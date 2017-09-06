<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct(true);

//render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'users'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
    }

    public function index() {
        $this->is_logged_in();
        $this->is_user_admin();

        $this->load->model('user_model');
        $users = $this->user_model->get_all_users();
        $view_data = array('users' => $users);

        $this->template->write_view('content', 'users/index', $view_data);
        $this->template->render();
    }

    public function view($username) {
        $this->is_logged_in();
        $this->is_user_admin();

        $this->load->model('user_model');
        $user = $this->user_model->get_user($username);
        $view_data = array('user' => $user);

        $this->template->write_view('content', 'users/view_user', $view_data);
        $this->template->render();
    }

    public function add($username = '') {
        $this->is_logged_in();
        $this->is_user_admin();

        $view_data = array();
        $this->load->model('user_model');

        if (!empty($username)) {
            $user = $this->user_model->get_user($username);
            $view_data['user'] = $user;
        }
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $postdata['type'] = 'admin';
            $user_id = !empty($user['id']) ? $user['id'] : '';

            $data = $this->user_model->get_user($postdata['username'], $user_id);

            if (empty($data)) {
                $output = $this->user_model->update_user($postdata, $user_id);

                if ($output) {
                    $msg = (!empty($username)) ? 'User successfully Updated' : 'User successfully Added';
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . 'users');
                } else {
                    $view_data['error'] = 'Something went wrong, please try again ';
                }
            } else {
                $view_data['error'] = 'Username already exists';
            }
        }


        $this->template->write_view('content', 'users/add_user', $view_data);
        $this->template->render();
    }

    public function login_check() {
//        echo $this->db->database;;die();
        if ($this->session->userdata('username')) {
            redirect(base_url() . 'dashboard');
        }

        $data = array();
        if ($this->input->post()) {

            $uid = $_REQUEST['username'];
            $pwd = $_REQUEST['password'];
//            $ldap_host = "10.51.82.51"; //final IP conform by Abhishekji 
////            $ldap_host = "10.51.82.50";
////            $ldap_host = "10.51.6.1";
//            $ldap = ldap_connect($ldap_host);
//            if ($bind = @ldap_bind($ldap, "dbgroup\\" . $uid, $pwd)) {
//// authenticated
//                ldap_unbind($ldap);

            $post_data = $this->input->post();
            $this->load->model('User_model');
            $psfim_data = $this->User_model->check_login_psfim_check($post_data['username'], $post_data['password']);

            if (!empty($psfim_data)) {

                $output = $this->User_model->check_login_check($post_data['username'], $post_data['password']);

                if (!empty($output)) {
                    if ($output['STATUS'] == 'Success') {
//                            $data = $this->update_employee($post_data['username']);
//                            if (isset($data['status'])) {
//                                if ($data['status'] == "0") {
//                                    $msg = $data['msg'];
//                                    $data['error'] = $msg;
//                                    $this->session->sess_destroy();
//                                    $this->session->set_flashdata('error', "Invalid Username");
//                                } else {
//                                    redirect(base_url() . 'dashboard');
//                                }
//                            } else {
                        redirect(base_url() . 'dashboard');
//                            }
                    } else {
                        $data['error'] = $output['MSG'];
                    }
                } else {
//code for update employee profile 
//                        $this->add_new_employee($post_data['username']);
                }
            } else {
                $data['error'] = $output['MSG'];
            }
//write code for further process
//            } else {
//// invalid name or password
//                ldap_unbind($ldap);
//                $data['error'] = "invalid name or password";
////return false;
////write code for authentication fail process
////                exit;
//            }
//authenticate($uid,$pwd);
//            ob_end_flush();
        }

        $this->load->view('login2', $data);
    }

    public function login() {
//        echo $this->db->database;;die();
        if ($this->session->userdata('username')) {
            redirect(base_url() . 'dashboard');
        }

        $data = array();
        if ($this->input->post()) {

            $uid = $_REQUEST['username'];
            $pwd = $_REQUEST['password'];
            $ldap_host = "10.51.82.51"; //final IP conform by Abhishekji 
//            $ldap_host = "10.51.82.50";
//            $ldap_host = "10.51.6.1";
            $ldap = ldap_connect($ldap_host);
            if ($bind = @ldap_bind($ldap, "dbgroup\\" . $uid, $pwd)) {
// authenticated
                ldap_unbind($ldap);

                $post_data = $this->input->post();
                $this->load->model('User_model');
                $psfim_data = $this->User_model->check_login_psfim($post_data['username'], $post_data['password']);

                if (!empty($psfim_data)) {

                    $output = $this->User_model->check_login($post_data['username'], $post_data['password']);

                    if (!empty($output)) {
                        if ($output['STATUS'] == 'Success') {
                            $data = $this->update_employee($post_data['username']);
                            if (isset($data['status'])) {
                                if ($data['status'] == "0") {
                                    $msg = $data['msg'];
                                    $data['error'] = $msg;
                                    $this->session->sess_destroy();
                                    $this->session->set_flashdata('error', "Invalid Username");
                                } else {
                                    redirect(base_url() . 'dashboard');
                                }
                            } else {
                                redirect(base_url() . 'dashboard');
                            }
                        } else {
                            $data['error'] = $output['MSG'];
                        }
                    } else {
//code for update employee profile 
                        $this->add_new_employee($post_data['username']);
                    }
                } else {
                    $data['error'] = $output['MSG'];
                }
//write code for further process
            } else {
// invalid name or password
                ldap_unbind($ldap);
                $data['error'] = "invalid name or password";
//return false;
//write code for authentication fail process
//                exit;
            }
//authenticate($uid,$pwd);
            ob_end_flush();
        }

        $this->load->view('login2', $data);
    }

    function add_new_employee($username = "") {

        $post_data = $this->input->post();
        $this->load->model('User_model');


        $sql = "SELECT * FROM grades";
        $user = $this->db->query($sql);
        $grade_array = $user->result_array();

        $grade_data = array();
        foreach ($grade_array as $key => $value) {
            $grade_data[$value['grade_name']] = $value['id'];
        }

        $sql = "SELECT * FROM designations";
        $user = $this->db->query($sql);
        $desg_array = $user->result_array();
        $desg_data = array();
        foreach ($desg_array as $key => $value) {
            $desg_data[strtolower($value['desg_name'])] = $value['id'];
        }

        $sql = "SELECT * FROM departments";
        $user = $this->db->query($sql);
        $dept_array = $user->result_array();
        $dept_data = array();
        foreach ($dept_array as $key => $value) {
            $dept_data[strtolower($value['dept_name'])] = $value['id'];
        }

        $sql = "SELECT * FROM indian_cities";
        $user = $this->db->query($sql);
        $city_array = $user->result_array();
        $city_data = array();
        $city_data1 = array();
        foreach ($city_array as $key => $value) {
            $city_data[strtolower($value['name'])] = $value['cost_center_id'];
            $city_data1[strtolower($value['name'])] = $value['id'];
        }

        $psfim_data = $this->User_model->check_login_psfim($post_data['username'], $post_data['password']);
        $value = $psfim_data['data'];
        $value['employee_id'] = $value['EMPLID'];


        if ($value['STEP'] == " " || $value['STEP'] == "" || $value['STEP'] == NULL) {
            $GRADE = $value['GRADE'];
        } else {
            $GRADE = $value['GRADE'] . "/" . $value['STEP'];
        }

        $designation = strtolower($value['DESCR6']);
        $department = strtolower($value['Z_PRNTDEPT_DESCR']);

        $city = strtolower($value['CITY']);
        $cost_center = strtolower($value['DESCR4']);

        if (!isset($grade_data[$GRADE])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Grade!, Please contact Administrator";
            return $data;
        }

        if (!isset($value['employee_id'])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Record!, Please contact Administrator";
            return $data;
        }

        if (!isset($desg_data[$designation])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Designation!, Please contact Administrator";
            return $data;
        }

        if (!isset($dept_data[$department])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Department!, Please contact Administrator";
            return $data;
        }

        if (!isset($city_data1[$city])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid City!, Please contact Administrator";
            return $data;
        }

        if (!isset($city_data[$city])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Cost Center!, Please contact Administrator";
            return $data;
        }

        $grade_id = $grade_data[$GRADE];
        $desg_id = $desg_data[strtolower($designation)];
        $dept_id = $dept_data[strtolower($department)];

        $cost_center_id = $city_data[strtolower($city)];
        $city_id = $city_data1[strtolower($city)];

        if ($value['BIRTHDATE'] == "0000-00-00 00:00:00") {
            $date = $value['BIRTHDATE'] = null;
        } else {
            $date = $value['BIRTHDATE'] = date('Y-m-d', strtotime($value['BIRTHDATE']));
        }

        $sql = "SELECT * FROM employees WHERE id = " . $value['employee_id'];
        $user = $this->db->query($sql);
        $user = $user->result_array();
        unset($value['dashboardrole']);
        if ($value['employee_id'] != '' && $desg_id != '' && $dept_id != '' && $cost_center_id != '') {
            $employee = array(
                "id" => $value['employee_id'],
                "grade_id" => $grade_id,
                "empID" => $value['employee_id'],
                "employee_id" => $value['employee_id'],
                "gi_email" => $value['EMAIL_ADDR'],
                "designation_id" => $desg_id,
                "dept_id" => $dept_id,
                "cost_center_id" => $cost_center_id,
                "city_id" => $city_id,
                "reporting_manager_id" => $value['SUPERVISOR_ID'],
                "ea_manager_id" => "0",
                "reporting_person_id" => $value['SUPERVISOR_ID'],
                "location" => "",
                "father_name" => "",
                "gender" => "Male",
                "blood_group" => "",
                "dob" => $date,
                "phone" => $value['PHONE1'],
                "emergency_phone" => "",
                "emergency_phone2" => "",
                "email" => $value['EMAIL_ADDR'],
                "l_address1" => "",
                "l_address2" => "",
                "l_city" => $value['CITY'],
                "l_state" => $value['STATE'],
                "l_post_code" => $value['POSTAL'],
                "l_country" => $value['COUNTRY'],
                "p_address1" => $value['ADDRESS1'],
                "p_address2" => $value['ADDRESS2'],
                "p_city" => $value['CITY'],
                "p_state" => $value['STATE'],
                "p_post_code" => $value['POSTAL'],
                "p_country" => $value['COUNTRY'],
                "pan" => "",
                "bank_name" => "",
                "bank_account_number" => "",
                "bank_account_name" => "",
                "bank_ifsc" => "",
                "bank_address" => "",
                "bank_address" => "active",
                "image" => "",
                "created" => date("Y-m-d H:i:s"),
                "modified" => date("Y-m-d H:i:s"),
                "status_modified" => date("Y-m-d H:i:s"),
            );
            $value['is_active'] = "active";

            $result = $this->db->insert('employees', $employee);
            $value['email'] = $value['EMAIL_ADDR'];
            $value['is_active'] = "1";
            $value['username'] = $value['alias'];
            unset($value['EMPLID']);
            unset($value['EMAIL_ADDR']);
            unset($value['alias']);
            unset($value['gender']);
            $result = $this->db->insert('users', $value);
            $this->login();
            $data['status'] = "1";
            $data['msg'] = "";
            return $data;
        } else {
            $data['status'] = "0";
            $data['msg'] = "Invalid record";
            return $data;
        }
    }

    function update_employee($username = "") {

        $post_data = $this->input->post();
        $this->load->model('User_model');


        $sql = "SELECT * FROM grades";
        $user = $this->db->query($sql);
        $grade_array = $user->result_array();

        $grade_data = array();
        foreach ($grade_array as $key => $value) {
            $grade_data[$value['grade_name']] = $value['id'];
        }

        $sql = "SELECT * FROM designations";
        $user = $this->db->query($sql);
        $desg_array = $user->result_array();
        $desg_data = array();
        foreach ($desg_array as $key => $value) {
            $desg_data[strtolower($value['desg_name'])] = $value['id'];
        }

        $sql = "SELECT * FROM departments";
        $user = $this->db->query($sql);
        $dept_array = $user->result_array();
        $dept_data = array();
        foreach ($dept_array as $key => $value) {
            $dept_data[strtolower($value['dept_name'])] = $value['id'];
        }

        $sql = "SELECT * FROM indian_cities";
        $user = $this->db->query($sql);
        $city_array = $user->result_array();
        $city_data = array();
        $city_data1 = array();
        foreach ($city_array as $key => $value) {
            $city_data[strtolower($value['name'])] = $value['cost_center_id'];
            $city_data1[strtolower($value['name'])] = $value['id'];
        }

        $psfim_data = $this->User_model->check_login_psfim($post_data['username'], $post_data['password']);
        $value = $psfim_data['data'];
        $value['employee_id'] = $value['EMPLID'];


//        $value['DESCR4'] = "sangudfghwdjhdskfdgfj";

        if ($value['STEP'] == " " || $value['STEP'] == "" || $value['STEP'] == NULL) {
            $GRADE = $value['GRADE'];
        } else {
            $GRADE = $value['GRADE'] . "/" . $value['STEP'];
        }
        $designation = strtolower($value['DESCR6']);
        $department = strtolower($value['Z_PRNTDEPT_DESCR']);

        $city = strtolower($value['CITY']);
        $cost_center = strtolower($value['DESCR4']);

        if (!isset($grade_data[$GRADE])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Grade!, Please contact Administrator";
            return $data;
        }

        if (!isset($value['employee_id'])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Record!, Please contact Administrator";
            return $data;
        }

        if (!isset($desg_data[$designation])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Designation!, Please contact Administrator";
            return $data;
        }

        if (!isset($dept_data[$department])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Department!, Please contact Administrator";
            return $data;
        }

        if (!isset($city_data1[$city])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid City!, Please contact Administrator";
            return $data;
        }

        if (!isset($city_data[$city])) {
            $data['status'] = "0";
            $data['msg'] = "Invalid Cost Center!, Please contact Administrator";
            return $data;
        }

        $grade_id = $grade_data[$GRADE];
        $desg_id = $desg_data[$designation];
        $dept_id = $dept_data[$department];

        $city_id = $city_data1[$city];
        $cost_center_id = $city_data[$city];
        
        if ($value['BIRTHDATE'] == "0000-00-00 00:00:00") {
            $date = $value['BIRTHDATE'] = null;
        } else {
            $date = $value['BIRTHDATE'] = date('Y-m-d', strtotime($value['BIRTHDATE']));
        }


        $sql = "SELECT * FROM employees WHERE id = " . $value['employee_id'];
        $user = $this->db->query($sql);
        $user = $user->result_array();
        if ($value['employee_id'] != '' && $desg_id != '' && $dept_id != '' && $cost_center_id != '') {
            $employee = array(
                "id" => $value['employee_id'],
                "grade_id" => $grade_id,
                "empID" => $value['employee_id'],
                "employee_id" => $value['employee_id'],
                "gi_email" => $value['EMAIL_ADDR'],
                "designation_id" => $desg_id,
                "dept_id" => $dept_id,
                "cost_center_id" => $cost_center_id,
                "city_id" => $city_id,
                "reporting_manager_id" => $value['SUPERVISOR_ID'],
                "ea_manager_id" => "0",
                "reporting_person_id" => $value['SUPERVISOR_ID'],
                "location" => "",
                "father_name" => "",
                "gender" => "Male",
                "blood_group" => "",
                "dob" => $date,
                "phone" => $value['PHONE1'],
                "emergency_phone" => "",
                "emergency_phone2" => "",
                "email" => $value['EMAIL_ADDR'],
                "l_address1" => "",
                "l_address2" => "",
                "l_city" => $value['CITY'],
                "l_state" => $value['STATE'],
                "l_post_code" => $value['POSTAL'],
                "l_country" => $value['COUNTRY'],
                "p_address1" => $value['ADDRESS1'],
                "p_address2" => $value['ADDRESS2'],
                "p_city" => $value['CITY'],
                "p_state" => $value['STATE'],
                "p_post_code" => $value['POSTAL'],
                "p_country" => $value['COUNTRY'],
                "pan" => "",
                "bank_name" => "",
                "bank_account_number" => "",
                "bank_account_name" => "",
                "bank_ifsc" => "",
                "bank_address" => "",
                "bank_address" => "active",
                "image" => "",
                "modified" => date("Y-m-d H:i:s"),
                "status_modified" => date("Y-m-d H:i:s"),
            );
            $value['is_active'] = "active";

            $this->db->where('employee_id', $value['employee_id']);
            $result = $this->db->update('employees', $employee);

            $value['email'] = $value['EMAIL_ADDR'];
            $value['is_active'] = "1";
            $value['username'] = $value['alias'];
            unset($value['gender']);
            unset($value['EMPLID']);
            unset($value['EMAIL_ADDR']);
            unset($value['alias']);
            unset($value['dashboardrole']);

            $this->db->where('employee_id', $value['employee_id']);
            $result = $this->db->update('users', $value);
            $data['status'] = "1";
            $data['msg'] = "";
            return $data;
        } else {
            $data['status'] = "0";
            $data['msg'] = "Invalid record";
            return $data;
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'users/login');
    }

    public function change_password() {
        $this->is_logged_in();
        $data = array();

        if ($this->input->post()) {

            $this->load->model('user_model');
            $username = $this->session->userdata('username');
            $type = $this->session->userdata('type');

            $this->load->library('form_validation');
            $validate = $this->form_validation;

            $validate->set_rules('old', 'Old Password', 'trim|required|xss_clean');
            $validate->set_rules('new', 'New Password', 'trim|required|xss_clean');
            $validate->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');

            if ($validate->run() === true) {
                $post_data = $this->input->post();

                if ($post_data['new'] === $post_data['confirm_password']) {
                    $user = $this->user_model->check_login($username, $this->input->post('old'), $type);

                    if ($user['STATUS'] == 'Success') {
                        $changed = $this->user_model->change_password($username, $this->input->post('new'));

                        if ($changed) {
                            $this->session->set_flashdata('success', 'Password successfully updated.');
                            redirect(base_url());
                        } else {
                            $data['error'] = 'Something went wrong, Please try again.';
                        }
                    } else {
                        $data['error'] = 'Old doesn\'t match, Please provide correct password';
                    }
                } else {
                    $data ['error'] = 'New Password and Confirm Password doesn\'t match';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->template->write_view('content', 'change_password', $data);
        $this->template->render();
    }

    public function change_status($username, $status) {
        $this->load->model('User_model');
        $user = $this->User_model->get_user($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->User_model->change_status($username, $status)) {
                $this->session->set_flashdata('success', 'User marked as ' . ($status == 0 ? 'inactive' : 'active'));
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        redirect(base_url() . 'users');
    }

    public function delete_user($username) {
        $this->load->model('User_model');
        $user = $this->User_model->get_user($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->User_model->delete_item($username)) {
                $this->session->set_flashdata('success', 'User deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }

        redirect(base_url() . 'users');
    }

    public function forgot_password() {
        $data = array();
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $this->load->model('User_model');

            $user = $this->User_model->find_user_by_email($post_data['email_id']);
            if (count($user) >= 1) {
                $token = $this->User_model->reset_token($post_data['email_id']);
                if ($token) {
                    $link = 'forgot_password/reset_password/' . $token;
                    $subject = "Password Reset URL ";
                    $message = "Dear " . $user['first_name'] . ' ' . $user['last_name'] . " ,<br><br>
                    Please <a href='" . base_url() . $link . "'>Click Here</a>. for reset the password.<br>
                    Please do not share your password with anyone.<br><br>Thank You.<br><br>Manager";
                    $to = $user['username'];
                    $this->sendMail($to, $subject, $message);

                    $msg = "Your password reset link has been sent to your e-mail address.";
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . 'users/login');
                }
            } else {
                $data['error'] = 'Email id not registered!!';
            }
        }

        $this->load->view('login2', $data);
    }

}
