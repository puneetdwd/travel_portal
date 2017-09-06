<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();

        require_once APPPATH . 'libraries/pass_compat/password.php';
    }

    public function get_all_users() {
        $sql = "SELECT * FROM users WHERE type = 'admin'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_user($username, $id = '') {
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }

        $this->db->where('username', $username);

        return $this->db->get('users')->row_array();
    }

    public function update_user($data, $user_id) {
        $needed_array = array('first_name', 'email', 'last_name', 'username', 'password',
            'type', 'employee_id', 'is_active');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT . $data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }

        if (!empty($user_id)) {
            $this->db->where('id', $user_id);

            $result = $this->db->update('users', $data);
            if ($result) {
                return $user_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('users', $data);

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    public function check_login_psfim($username, $password) {
        $output = array();
        $sql = "SELECT EMPLID,NAME_DISPLAY,FIRST_NAME,MIDDLE_NAME,LAST_NAME,DESCR6,DESCR3,Z_PRNTDEPT_DESCR,GRADE,STEP,HR_STATUS,BIRTHDATE,EMAIL_ADDR,ADDRESS1,ADDRESS2,ADDRESS3,ADDRESS4,COUNTRY,STATE,CITY,POSTAL,DESCR4,DESCR30,DESCR2,SUPERVISOR_ID,NAME,EMAIL_ADDR2,PHONE,EXTENSION,PHONE1,PHONE2,updation,alias,provisioned,psentrydate FROM psfim WHERE alias = ?";
        $user = $this->db->query($sql, array($username));
        if ($user->num_rows() > 0) {
            $user = $user->row_array();
            $output = array('STATUS' => 'Success', 'data' => $user);
        } else {
            $output = array('STATUS' => 'ERROR', 'MSG' => 'Username doesn\'t exists.');
        }

        return $output;
    }

    public function check_login($username, $password) {
        $output = array();
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $this->db->query($sql, array($username));

        if ($user->num_rows() > 0) {
            $user = $user->row_array();

//            if(password_verify(SALT.$password, $user['password'])) {
            if ($user['is_active'] == 1) {
                $output = array('STATUS' => 'Success');

//                    if($type === 'employee'){
//                        $employee_sql = "SELECT e.* , CONCAT(u.first_name,' ',u.last_name) as reporting_person, e.band ,
//                        u.username as reporting_person_email 
//                        FROM employees e  
//                        LEFT JOIN users u 
//                        ON e.reporting_person_id = u.employee_id  
//                        LEFT JOIN sub_departments sd
//                        ON sd.dept_lead = e.reporting_person_id
//                        WHERE e.id = ?";
//                     
//                        $employee = $this->db->query($employee_sql,  array($user['employee_id']))->row_array();
//                    }
//                    $reporting_head_query="select reporting_person_id from employees where reporting_person_id = ? limit 0,1";
//                    $reporting_head = $this->db->query($reporting_head_query, $user['employee_id'])->row_array();
//                    
//                    $department_head_sql = "SELECT dept_head FROM departments WHERE dept_head =? limit 0,1 ";
//                    $department_head = $this->db->query($department_head_sql, $user['employee_id'])->row_array();
//                    
//                    $sub_dept_head_sql = "SELECT dept_lead FROM sub_departments WHERE dept_lead =? limit 0,1 ";
//                    $sub_dept_head = $this->db->query($sub_dept_head_sql, $user['employee_id'])->row_array();
                //create session data array.
                $session_data = array();
                $session_data['id'] = $user['id'];
                $session_data['username'] = $user['username'];
                $session_data['type'] = $user['type'];
                $session_data['employee_id'] = $user['employee_id'];
                $session_data['last_login'] = $user['last_login'];
                $session_data['name'] = $user['first_name'] . ' ' . $user['last_name'];
//                    $session_data['empID']                  = (isset($employee)) ? $employee['empID'] : null;
//                    $session_data['gi_email']               = (isset($employee)) ? $employee['gi_email'] : null;
//                    $session_data['reporting_person_id']    = (isset($employee)) ? $employee['reporting_person_id'] : null;
//                    $session_data['reporting_person']       = (isset($employee)) ? $employee['reporting_person'] : null;
//                    $session_data['reporting_person_email'] = (isset($employee)) ? $employee['reporting_person_email'] : null;
//                    $session_data['sub_dept_id']            = (isset($employee)) ? $employee['sub_dept_id'] : null;
//                    $session_data['department_id']          = (isset($employee)) ? $employee['department_id'] : null;
//                    $session_data['band']                   = (isset($employee)) ? $employee['band'] : null;
//                    $session_data['gender']                 = (isset($employee)) ? $employee['gender'] : null;
//                    $session_data['image']                  = (isset($employee)) ? $employee['image'] : null;
//                    if(isset($reporting_head) && !empty($reporting_head['reporting_person_id'])){
//                        $session_data['is_reporting_person'] = 1;
//                    }else{
//                        $session_data['is_reporting_person'] = 0;
//                    }
//                    
//                    if(isset($department_head) && !empty($department_head['dept_head'])){
//                        $session_data['dept_head'] = 1;
//                    }else{
//                        $session_data['dept_head'] = 0;
//                    }
//                    
//                    if(isset($sub_dept_head) && !empty($sub_dept_head['dept_lead'])){
//                        $session_data['sub_dept_head'] = 1;
//                    }else{
//                        $session_data['sub_dept_head'] = 0;
//                    }
//                    
//                    if($user['employee_id'] == 72){
//                        $session_data['hr_management'] = 1;
//                        //echo "here"; exit;
//                    }else{
//                        $session_data['hr_management'] = 0;
//                    }

                $this->session->set_userdata($session_data);

                $last_login = "Update users SET last_login = CONVERT_TZ(NOW(),'+00:00','+05:30') where id = ? ";
                $this->db->query($last_login, $user['id']);
            } else {
                $output = array('STATUS' => 'ERROR', 'MSG' => 'Your account has been deactivated please contact System Admin.');
            }

//            } else {
//                $output = array('STATUS' => 'ERROR', 'MSG' => 'Invalid Credentials.');
//            }
        } else {
            $output = '';
        }

        return $output;
    }

    public function check_login_psfim_check($username, $password) {
        $output = array();
        $sql = "SELECT EMPLID,NAME_DISPLAY,FIRST_NAME,MIDDLE_NAME,LAST_NAME,DESCR6,DESCR3,Z_PRNTDEPT_DESCR,GRADE,STEP,HR_STATUS,BIRTHDATE,EMAIL_ADDR,ADDRESS1,ADDRESS2,ADDRESS3,ADDRESS4,COUNTRY,STATE,CITY,POSTAL,DESCR4,DESCR30,DESCR2,SUPERVISOR_ID,NAME,EMAIL_ADDR2,PHONE,EXTENSION,PHONE1,PHONE2,updation,alias,provisioned,psentrydate FROM psfim WHERE alias = ?";
        $user = $this->db->query($sql, array($username));
        if ($user->num_rows() > 0) {
            $user = $user->row_array();
            $output = array('STATUS' => 'Success', 'data' => $user);
        } else {
            $output = array('STATUS' => 'ERROR', 'MSG' => 'Username doesn\'t exists.');
        }

        return $output;
    }

    public function check_login_check($username, $password) {
        $output = array();
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $this->db->query($sql, array($username));

        if ($user->num_rows() > 0) {
            $user = $user->row_array();

//            if(password_verify(SALT.$password, $user['password'])) {
            if ($user['is_active'] == 1) {
                $output = array('STATUS' => 'Success');

//                    if($type === 'employee'){
//                        $employee_sql = "SELECT e.* , CONCAT(u.first_name,' ',u.last_name) as reporting_person, e.band ,
//                        u.username as reporting_person_email 
//                        FROM employees e  
//                        LEFT JOIN users u 
//                        ON e.reporting_person_id = u.employee_id  
//                        LEFT JOIN sub_departments sd
//                        ON sd.dept_lead = e.reporting_person_id
//                        WHERE e.id = ?";
//                     
//                        $employee = $this->db->query($employee_sql,  array($user['employee_id']))->row_array();
//                    }
//                    $reporting_head_query="select reporting_person_id from employees where reporting_person_id = ? limit 0,1";
//                    $reporting_head = $this->db->query($reporting_head_query, $user['employee_id'])->row_array();
//                    
//                    $department_head_sql = "SELECT dept_head FROM departments WHERE dept_head =? limit 0,1 ";
//                    $department_head = $this->db->query($department_head_sql, $user['employee_id'])->row_array();
//                    
//                    $sub_dept_head_sql = "SELECT dept_lead FROM sub_departments WHERE dept_lead =? limit 0,1 ";
//                    $sub_dept_head = $this->db->query($sub_dept_head_sql, $user['employee_id'])->row_array();
                //create session data array.
                $session_data = array();
                $session_data['id'] = $user['id'];
                $session_data['username'] = $user['username'];
                $session_data['type'] = $user['type'];
                $session_data['employee_id'] = $user['employee_id'];
                $session_data['last_login'] = $user['last_login'];
                $session_data['name'] = $user['first_name'] . ' ' . $user['last_name'];
//                    $session_data['empID']                  = (isset($employee)) ? $employee['empID'] : null;
//                    $session_data['gi_email']               = (isset($employee)) ? $employee['gi_email'] : null;
//                    $session_data['reporting_person_id']    = (isset($employee)) ? $employee['reporting_person_id'] : null;
//                    $session_data['reporting_person']       = (isset($employee)) ? $employee['reporting_person'] : null;
//                    $session_data['reporting_person_email'] = (isset($employee)) ? $employee['reporting_person_email'] : null;
//                    $session_data['sub_dept_id']            = (isset($employee)) ? $employee['sub_dept_id'] : null;
//                    $session_data['department_id']          = (isset($employee)) ? $employee['department_id'] : null;
//                    $session_data['band']                   = (isset($employee)) ? $employee['band'] : null;
//                    $session_data['gender']                 = (isset($employee)) ? $employee['gender'] : null;
//                    $session_data['image']                  = (isset($employee)) ? $employee['image'] : null;
//                    if(isset($reporting_head) && !empty($reporting_head['reporting_person_id'])){
//                        $session_data['is_reporting_person'] = 1;
//                    }else{
//                        $session_data['is_reporting_person'] = 0;
//                    }
//                    
//                    if(isset($department_head) && !empty($department_head['dept_head'])){
//                        $session_data['dept_head'] = 1;
//                    }else{
//                        $session_data['dept_head'] = 0;
//                    }
//                    
//                    if(isset($sub_dept_head) && !empty($sub_dept_head['dept_lead'])){
//                        $session_data['sub_dept_head'] = 1;
//                    }else{
//                        $session_data['sub_dept_head'] = 0;
//                    }
//                    
//                    if($user['employee_id'] == 72){
//                        $session_data['hr_management'] = 1;
//                        //echo "here"; exit;
//                    }else{
//                        $session_data['hr_management'] = 0;
//                    }

                $this->session->set_userdata($session_data);

                $last_login = "Update users SET last_login = CONVERT_TZ(NOW(),'+00:00','+05:30') where id = ? ";
                $this->db->query($last_login, $user['id']);
            } else {
                $output = array('STATUS' => 'ERROR', 'MSG' => 'Your account has been deactivated please contact System Admin.');
            }

//            } else {
//                $output = array('STATUS' => 'ERROR', 'MSG' => 'Invalid Credentials.');
//            }
        } else {
            $output = '';
        }

        return $output;
    }

    public function change_password($username, $password) {
        if (!empty($password)) {
            $cost = $this->config->item('hash_cost');
            $password = password_hash(SALT . $password, PASSWORD_BCRYPT, array('cost' => $cost));

            $this->db->where('username', $username);
            $this->db->set('password', $password);
            $this->db->set('reset_token', '');

            $this->db->update('users');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return False;
    }

    function change_status($username, $status) {

        if (!empty($username) && $status >= 0) {

            $this->db->where('username', $username);
            $this->db->set('is_active', $status);
            $this->db->update('users');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function delete_item($username) {
        if (!empty($username)) {

            $this->db->where('username', $username);

            $this->db->delete('users');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function find_user_by_email($email) {

        $sql = "SELECT * FROM users WHERE type = 'employee' AND username = ?";
        $result = $this->db->query($sql, array($email));
        return $result->row_array();
    }

    public function reset_token($email) {
        $time = date('Y-m-d H:i:s');
        $token = md5($email);
        $sql = " UPDATE users
                SET reset_token = '" . $token . "'
                , reset_request_time = '" . $time . "'
                WHERE username=?";
        $result = $this->db->query($sql, array($email));
        if ($result) {
            return $token;
        } else {
            return false;
        }
    }

    public function find_user_by_token($token) {

        $sql = "SELECT * FROM users WHERE type = 'employee' AND reset_token = ?  AND reset_request_time >  DATE_SUB( NOW(), INTERVAL 24 HOUR)";
        $result = $this->db->query($sql, array($token));
        return $result->row_array();
    }

}
