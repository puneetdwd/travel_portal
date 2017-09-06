<?php

class Employee_model extends CI_Model {

    var $table = 'users';
    var $column_order = array('users.employee_id', 'users.first_name', 'users.phone'); //set column field database for datatable orderable
    var $column_search = array('users.employee_id', 'users.first_name', 'users.phone', 'users.last_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('users.employee_id' => 'desc'); // default order 

    private function _get_datatables_query() {

        $this->db->from($this->table);

        $i = 0;
        $flag = 0;
        if (isset($_POST['search']['value'])) {
            $value = $_POST['search']['value'];
            if (strpos($value, " ") !== false) {
                $flag = 1;
            }
        }

        if (isset($_POST['search']['value'])) {
            $value = $_POST['search']['value'];
            if (strpos($value, " ") !== false) {
                $arr = explode(" ", $value);
                if ($i === 0) {
                    $this->db->like('users.first_name', $arr[0]);
                    $this->db->like('users.last_name', $arr[1]);
                    $i++;
                } else {
                    $this->db->like('users.first_name', $arr[0]);
                    $this->db->like('users.last_name', $arr[1]);
                    $i++;
                }
            }
        }

        foreach ($this->column_search as $key => $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
//                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

//                if (count($this->column_search) - 1 == $i) //last loop
//                    $this->db->group_end(); //close bracket
            }

            $i++;
        }



        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
//        $this->db->join("employees", "employees.employee_id = users.employee_id", "left");
//        $this->db->join("category_master", "category_master.id=product_master.category_id");
        $this->db->select("users.employee_id,users.first_name,users.last_name,users.email,users.is_active");
        $this->db->where("users.is_active", "1");
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all() {
        $this->db->from($this->table);
        $this->db->where("users.is_active", "1");
        return $this->db->count_all_results();
    }

    function count_filtered() {
        $this->_get_datatables_query();

//        $this->db->join("employees", "employees.employee_id = users.employee_id", "left");
//        $this->db->join("category_master", "category_master.id=product_master.category_id");

        $this->db->where("users.is_active", "1");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_employees($emp_id = '') {
        $sql = "SELECT e.*, u.*,u.id as user_id, u.first_name, u.last_name,
        concat( u.first_name,' ',u.last_name) as emp_name,
        concat( u1.first_name,' ',u1.last_name) as reporting_person_name
        FROM employees e 
        INNER JOIN users u on u.employee_id = e.id
        LEFT JOIN users u1 on u.employee_id = e.reporting_person_id
        WHERE e.status = 'active' ";

        if (!empty($emp_id)) {
            $sql .= " AND e.id = " . $emp_id;
        }
        //echo $this->db->last_query();
        //exit;
        //echo $emp_id; exit;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_employees_email() {
        $sql = "SELECT e.id,e.gi_email FROM employees e";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    // select data using multiple conditions
    function select_data_by_condition($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $like_array = array()) {

        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }



        //condition array pass to where condition
        $this->db->where($condition_array);

        //        $like_array
        $i = 0;
        if (!empty($like_array)) {
            foreach ($like_array as $like_key => $like_val) {
                if ($i == 0) {
                    $this->db->like($like_key, $like_val, 'after');
                    $i++;
                } else {
                    $this->db->or_like($like_key, $like_val, 'after');
                }
            }
        }


        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        //order by query
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    public function get_all_employees_new() {
        $sql = "SELECT e.*, u.id as user_id, u.first_name, u.last_name,
        concat( u.first_name,' ',u.last_name) as emp_name,
        concat( u1.first_name,' ',u1.last_name) as reporting_person_name
        FROM employees e 
        INNER JOIN users u on u.employee_id = e.id
        LEFT JOIN users u1 on u.employee_id = e.reporting_person_id";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_employees_by_reporting_head() {

        $sql = "SELECT e.*, u.id as user_id, u.first_name, u.last_name,
        concat( u.first_name,' ',u.last_name) as emp_name
        FROM employees e 
        INNER JOIN users u on u.employee_id = e.id
        WHERE e.status = 'active' ";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_reporting_employees_by_sub_dept_and_level($sub_dept = '', $dept_id, $level) {
        $sql = "SELECT  e.id as id, e.id as emp_id, e.empID, u.first_name, u.last_name 
        FROM employees e 
        INNER JOIN users u 
        ON u.employee_id = e.id 
        INNER JOIN designation_band db
        ON e.band = db.id
        WHERE e.status='active' AND db.level > ?
        AND e.sub_dept_id = ? ||  e.sub_dept_id = 0 and e.department_id = ?  ";

//        $dept_head_sql = "SELECT e.id as id, e.id as emp_id,e.empID, u.first_name, u.last_name from departments d
//            INNER JOIN users u on
//            u.employee_id = d.dept_head
//            INNER JOIN employees e 
//            ON e.id = u.employee_id
//            WHERE d.id = ?";

        $result = $this->db->query($sql, array($level, $sub_dept, $dept_id));
        //$dept_head_result = $this->db->query($dept_head_sql, array($dept_id));
        //$dept_head_result=array();
        //return array_merge($dept_head_result->result_array(), $result->result_array() ) ;
        return $result->result_array();
    }

    public function get_emp_reporting_person_sub_dept_head_dept_head($emp_id) {
        $sql = "SELECT sd.dept_lead, CONCAT(u.first_name, ' ' , u.last_name) as employee_name, 
	CONCAT(u1.first_name, ' ' , u1.last_name) as reporting_head,
        CONCAT(u2.first_name, ' ' , u2.last_name) as sub_dept_head,
        CONCAT(u3.first_name, ' ' , u3.last_name) as dept_head,
        e.gi_email as employee_email,
        e1.gi_email as reporting_person_email,
        e2.gi_email as sub_dept_head_email,
        e3.gi_email as dept_head_email
        FROM employees e 
        
        LEFT JOIN users u ON u.employee_id = e.id 
        LEFT JOIN employees e1 on e1.id = e.reporting_person_id
        LEFT JOIN users u1 on u1.employee_id = e1.id
        
        LEFT JOIN sub_departments sd on sd.id = e1.sub_dept_id
        LEFT JOIN users u2 on u2.employee_id = sd.dept_lead
        LEFT JOIN employees e2 on e2.id = sd.dept_lead
        
        LEFT JOIN departments d on d.id = e2.department_id
        LEFT JOIN users u3 on u3.employee_id = d.dept_head
        LEFT JOIN employees e3 on e3.id = d.dept_head
        
        WHERE e.status='active' 
        AND e.id = ?";

        $result = $this->db->query($sql, array($emp_id));
        return $result->row_array();
    }

    public function get_dept_head_dept_id($dept_id) {
        $sql = 'SELECT CONCAT(u.first_name," ", u.last_name) as head_name, e.gi_email as head_email, d.* from departments d
        LEFT JOIN employees e on e.id = d.dept_head
        LEFT JOIN users u on u.employee_id = d.dept_head
        where d.id = ?';

        $result = $this->db->query($sql, array($dept_id));
        return $result->row_array();
    }

    public function get_employee_attendence($start_date, $end_date, $emp_ids = '') {

        $sql = "SELECT e.id, e.empID, u.first_name, u.last_name, e.doj,
                CONCAT(u1.first_name,' ', u1.last_name) as reporting_person_name,
                t.date, SUM(t.hours) as hours, SUM(t.minutes) as minutes
                FROM employees e
                LEFT JOIN users u ON u.employee_id = e.id
                LEFT JOIN users u1 ON u1.employee_id = e.reporting_person_id
                LEFT JOIN timesheets t ON e.id = t.employee_id
                WHERE e.status = 'active' 
                AND t.date >= " . $start_date . "
                AND t.date <= " . $end_date . "
                AND t.status = 'Approved' ";

        if ($emp_ids != '') {
            $sql .= " AND e.id in (" . $emp_ids . ") ";
        }

        $sql .= " GROUP BY e.id, t.date
                 order by e.id asc, t.date asc";

        //echo $sql; exit;
        //echo $this->db->last_query();
        //echo $this->db->last_query();

        $result = $this->db->query($sql, array($start_date, $end_date));
        return $result->result_array();
    }

    public function get_joining_date($id) {
        $sql = "SELECT doj, phone from employees
        WHERE id = ? and status='active'";

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_dept_head_by_id($id) {
        $sql = "SELECT * FROM departments WHERE dept_head = ?";

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_sub_dept_lead_by_id($id) {
        $sql = "SELECT * FROM sub_departments WHERE dept_lead = ?";

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_all_employees_by_dept_id($dept_id) {
        $sql = "SELECT u.first_name, u.last_name, CONCAT(u.first_name, ' ' ,u.last_name) as emp_name, e.*
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id
        WHERE e.status='active' and department_id = ?";

        $result = $this->db->query($sql, array($dept_id));
        return $result->result_array();
    }

    public function get_all_employees_by_sub_dept_id($sub_dept_id) {
        $sql = "SELECT u.first_name, u.last_name, e.*
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id
        WHERE e.status='active' and sub_dept_id = ?";

        $result = $this->db->query($sql, array($sub_dept_id));
        return $result->result_array();
    }

    public function get_all_employees_by_reporting_person_id($reporting_person_id) {
        $sql = "SELECT u.first_name, u.last_name, e.*
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id
        WHERE e.status='active' and reporting_person_id = ?";

        $result = $this->db->query($sql, array($reporting_person_id));
        return $result->result_array();
    }

    public function get_all_reporting_heads() {

        $sql = "select u.first_name, u.last_name, e1.* from employees e
        LEFT JOIN employees e1 on e1.id = e.reporting_person_id
        LEFT JOIN users u on u.employee_id = e.reporting_person_id
        where e.reporting_person_id > 0 and e1.status = 'active'
        group by e.reporting_person_id";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_reporting_heads_by_empID($emp_id) {
        $sql = 'SELECT u.first_name, u.last_name, CONCAT(u1.first_name, " ", u1.last_name) as employee_name, e.gi_email, e1.id as reporting_person_id, e1.gi_email as reporting_person_email
        FROM employees e
        LEFT JOIN users u on u.employee_id = e.reporting_person_id
        LEFT JOIN employees e1 on e1.id = e.reporting_person_id
        LEFT JOIN users u1 on u1.employee_id = e.id
        WHERE e.id = ?';

        $result = $this->db->query($sql, array($emp_id));
        return $result->row_array();
    }

    public function get_employee($code) {
        $sql = 'SELECT e.*,u.id as user_id, dp.dept_name,u.first_name, u.last_name, u.username, d.desg_name, g.grade_name, i.name as cost_center, CONCAT(r.first_name," ",r.last_name) as reporting_manager, CONCAT(ea.first_name," ",ea.last_name) as ea_manager
		,CONCAT(us.first_name, " ", us.last_name) as reporting_person
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id 
		
		LEFT JOIN designations d 
		on d.id = e.designation_id
		
		LEFT JOIN departments dp 
		on dp.id = e.dept_id
                
		LEFT JOIN grades g 
		on g.id = e.grade_id 
                
		LEFT JOIN indian_cities i 
		on i.id = e.cost_center_id  
                
		LEFT JOIN users r 
		on r.employee_id = e.reporting_manager_id 
                
		LEFT JOIN users ea 
		on ea.employee_id = e.ea_manager_id 
        
		LEFT JOIN users us
		ON (us.employee_id = e.reporting_person_id AND us.type = "employee")
        WHERE empID = ?';

        $result = $this->db->query($sql, array($code));
        return $result->row_array();
    }

    public function get_employee_id($code) {
        $sql = 'SELECT e.*,e.dob,TIMESTAMPDIFF(YEAR, e.dob, CURDATE()) AS age,u.id as user_id, u.first_name, u.last_name, u.username, d.desg_name, g.grade_name, i.name as cost_center, c.name as city_name, CONCAT(r.first_name," ",r.last_name) as reporting_manager, CONCAT(ea.first_name," ",ea.last_name) as ea_manager
		,CONCAT(us.first_name, " ", us.last_name) as reporting_person
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id 
		
		LEFT JOIN designations d 
		on d.id = e.designation_id
                
		LEFT JOIN grades g 
		on g.id = e.grade_id 
                
		LEFT JOIN indian_cities i 
		on i.id = e.cost_center_id  
                
		LEFT JOIN indian_cities c 
		on c.id = e.city_id  
                
		LEFT JOIN users r 
		on r.employee_id = e.reporting_manager_id 
                
		LEFT JOIN users ea 
		on ea.employee_id = e.ea_manager_id 
        
		LEFT JOIN users us
		ON (us.employee_id = e.reporting_person_id AND us.type = "employee")
        WHERE e.id = ?';

        $result = $this->db->query($sql, array($code));
        return $result->row_array();
    }

    function get_employee_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('employees')->row_array();
    }

    function get_employee_details_by_id($id) {
        $sql = 'SELECT de.dept_name,e.*,e.dob,TIMESTAMPDIFF(YEAR, e.dob, CURDATE()) AS age,u.id as user_id, u.first_name, u.last_name, u.username, d.desg_name, g.grade_name, i.name as cost_center, c.name as city_name, CONCAT(r.first_name," ",r.last_name) as reporting_manager, CONCAT(ea.first_name," ",ea.last_name) as ea_manager
		,CONCAT(us.first_name, " ", us.last_name) as reporting_person
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id 
		
		LEFT JOIN designations d 
		on d.id = e.designation_id
		
		LEFT JOIN departments de 
		on de.id = e.dept_id
                
		LEFT JOIN grades g 
		on g.id = e.grade_id 
                
		LEFT JOIN indian_cities i 
		on i.id = e.cost_center_id  
                
		LEFT JOIN indian_cities c 
		on c.id = e.city_id  
                
		LEFT JOIN users r 
		on r.employee_id = e.reporting_manager_id 
                
		LEFT JOIN users ea 
		on ea.employee_id = e.ea_manager_id 
        
		LEFT JOIN users us
		ON (us.employee_id = e.reporting_person_id AND us.type = "employee")
        WHERE e.id = ?';

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    function get_employee_by_email($email) {
//        $this->db->where('gi_email', $email);
//
//        return $this->db->get('employees')->row_array();
        $sql = 'SELECT e.*, u.id as user_id, u.first_name, u.last_name
        FROM employees e
        LEFT JOIN users u
        on u.employee_id = e.id 
        WHERE e.gi_email = ?';

        $result = $this->db->query($sql, array($email));
        return $result->row_array();
    }

    function validate_emp_email($email, $id = '') {
        if (!empty($id))
            $this->db->where('id !=', $id);

        $this->db->where('gi_email', $email);

        return $this->db->get('employees')->row_array();
    }

    function get_employee_by_id_new($id) {
        $sql = 'SELECT e.*, u.id as user_id, u.first_name, u.last_name
        FROM employees e
        LEFT JOIN users u
        on u.employee_id = e.id 
        WHERE e.id = ?';

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    function get_employee_birthday($date) {
        $sql = "SELECT u.first_name, u.last_name, e.*
        FROM employees e
        LEFT JOIN users u
        on u.employee_id = e.id 
        WHERE DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT(?, '%m-%d')
        AND status = 'active'";

        $result = $this->db->query($sql, array($date));
        return $result->result_array();
    }

    function get_festivals() {
        $sql = "SELECT * FROM festivals WHERE YEAR(festival_date) = " . date('Y');
        echo $sql;
        exit;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_festival($date) {
        $sql = "SELECT * FROM festivals WHERE festival_date = ?";

        $result = $this->db->query($sql, array($date));
        return $result->row_array();
    }

    function get_festival_dates($start_date, $end_date) {
        $sql = "SELECT * FROM festivals WHERE festival_date >= ? and festival_date <= ? ";

        $result = $this->db->query($sql, array($start_date, $end_date));
        return $result->result_array();
    }

    function get_new_joinee() {
        $sql = "SELECT u.first_name, u.last_name, e.*
        FROM employees e
        LEFT JOIN users u
        on u.employee_id = e.id 
        WHERE status = 'active' ";

        $result = $this->db->query($sql, array($date));
        return $result->row_array();
    }

    public function update_employee($data, $code, $employee_id = '') {
        $needed_array = array('id', 'gi_email', 'employee_id', 'city_id', 'cost_center_id', 'dept_id', 'designation_id', 'grade_id', 'ea_manager_id', 'reporting_manager_id',
            'location', 'father_name', 'gender', 'blood_group', 'dob', 'phone', 'emergency_phone', 'emergency_phone2', 'email', 'l_address1',
            'l_address2', 'l_city', 'l_state', 'l_post_code', 'l_country', 'p_address1', 'p_address2',
            'p_city', 'p_state', 'p_post_code', 'p_country', 'pan', 'bank_name', 'bank_account_number',
            'bank_account_name', 'bank_ifsc', 'bank_address', 'image', 'status', 'created');

        $data = array_intersect_key($data, array_flip($needed_array));

        if (empty($data['reporting_person_id'])) {
            $data['reporting_person_id'] = null;
        }

        if (empty($code)) {
            $data['empID'] = $this->generate_employee_code();
            $data['created'] = date("Y-m-d H:i:s");
            $response = $this->db->insert('employees', $data);


            if ($response) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('empID', $code);
            $data['modified'] = date("Y-m-d H:i:s");
            $response = $this->db->update('employees', $data);

            if ($response) {
                return $code;
            } else {
                return FALSE;
            }
        }
    }

    public function update_profile($data, $employee_id) {
        $needed_array = array('location', 'gender', 'blood_group', 'dob', 'phone', 'emergency_phone', 'emergency_phone2', 'email', 'l_address1',
            'l_address2', 'l_city', 'l_state', 'l_post_code', 'l_country', 'p_address1', 'p_address2', 'p_city', 'p_state', 'p_post_code',
            'p_country', 'bank_name', 'bank_account_number', 'bank_account_name', 'bank_ifsc', 'bank_address', 'image');

        $data = array_intersect_key($data, array_flip($needed_array));


        $this->db->where('id', $employee_id);
        $data['modified'] = date("Y-m-d H:i:s");
        $response = $this->db->update('employees', $data);

        if ($response) {
            return $employee_id;
        } else {
            return FALSE;
        }
    }

    function add_available_leave($data) {
        $response = $this->db->insert('available_leaves', $data);

        if ($response) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function change_status($empID, $status) {
        if (!empty($empID) && !empty($status)) {
            $this->db->where('empID', $empID);
            $this->db->set('status', $status);
            $this->db->set('status_modified', date("Y-m-d H:i:s"));
            $this->db->update('employees');

            if ($this->db->affected_rows() > 0) {
                $user_active = ($status == 'active') ? 1 : 0;
                $sql = "UPDATE users as u INNER JOIN employees as e ON u.employee_id = e.id SET is_active = ? WHERE e.empID = ?";
                $this->db->query($sql, array($user_active, $empID));

                return TRUE;
            }
        }

        return FALSE;
    }

    function generate_employee_code() {
        $this->db->select('MAX(empID) as empID');
        $record = $this->db->get('employees');

        $code = 0;
        if ($record->num_rows() > 0) {
            $record = $record->row_array();
            $code = $record['empID'];
        }

        if (empty($code)) {
            return 'CRG-' . str_pad(1, 4, '0', STR_PAD_LEFT);
        }

        $new_code = (int) str_replace('CRG-', '', $code) + 1;
        return 'CRG-' . str_pad($new_code, 4, '0', STR_PAD_LEFT);
    }

    function delete_item($empID) {
        //echo $empID ; exit;
        if (!empty($empID)) {

            $this->db->where('id', $empID);
            $this->db->delete('employees');

            $this->db->where('employee_id', $empID);
            $this->db->delete('users');


            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function get_reporting_person($emp_id) {
        $sql = "SELECT e.reporting_person_id, concat(u.first_name, ' ' , u.last_name) as reporting_person, e1.gi_email as reporting_email,
        e1.phone as reporting_contact
        FROM employees e 
        LEFT JOIN users u 
        on u.employee_id = e.reporting_person_id 
        LEFT JOIN employees e1 
        on e1.id = e.reporting_person_id 
        WHERE e.status = 'active' 
        AND e.id = ?  ";

        $result = $this->db->query($sql, array($emp_id));
        return $result->row_array();
    }

    function get_reportees($emp_id) {
        $sql = "SELECT e.empID, concat(u.first_name, ' ' , u.last_name) as reportee_name, e.gi_email, e.phone, e.doj, e.image
        FROM employees e 
        LEFT JOIN users u on u.employee_id = e.id 
        WHERE e.status = 'active' 
        AND e.reporting_person_id = ? ";

        $result = $this->db->query($sql, array($emp_id));
        return $result->result_array();
    }

    function get_employee_hierarchy($emp_id, $email, $name) {
        $sql = "SELECT  @r AS emp_id, @q AS employee_name, @s AS email,
        (
         SELECT  @r := reporting_person_id
         FROM    employees
         WHERE   id = emp_id
        ) AS reporting_person_id,
        (
         SELECT  @s := gi_email
         FROM    employees
         WHERE   id = emp_id
        ) AS reporting_person_email,
        (
         SELECT  @q := CONCAT(first_name,' ',last_name)
         FROM    users
         WHERE   employee_id = emp_id
        ) AS reporting_person_name,
        @l := @l + 1 AS lvl
		 
        FROM    (
                SELECT  @r := ?,
                        @s := ?,
                        @q := ?,
                        @l := 0,
                        @cl := 0
                ) vars,
                employees h
        WHERE   @r <> 0 and status = 'active' ";

        $result = $this->db->query($sql, array($emp_id, $email, $name));
        return $result->result_array();
    }

    function get_vendor($type) {
        $sql = "Select * from vendors where type = ?";

        $result = $this->db->query($sql, array($type));
        return $result->row_array();
    }

    function get_total_employee_attendence($emp_id, $start_date, $end_date) {

        $sql = "SELECT count(distinct(t.date)) as days
                FROM timesheets t
                WHERE t.date >= ?
                AND t.date <= ?
                AND t.status = 'Approved'
                AND t.employee_id = ?
                GROUP BY t.employee_id";

        $result = $this->db->query($sql, array($start_date, $end_date, $emp_id));
        return $result->row_array();
    }

    function get_pending_leave_count($start_date, $end_date, $emp_id) {
        $sql = "SELECT SUM(total_days) as total_pending FROM leaves WHERE created_date >= ? and created_date <= ? and emp_id = ? 
        and status='Pending' and type_of_leave != 'Half Day' ";

        $result = $this->db->query($sql, array($start_date, $end_date, $emp_id));
        return $result->row_array();
    }

    function get_all_candidates_for_filter() {

        $sql = "SELECT erf.*, CONCAT(u.first_name,' ',u.last_name) as reffered_by_name
        from employment_request_form erf
        LEFT JOIN employees e on e.empID = erf.reffered_by
        LEFT JOIN users u on u.employee_id = e.id";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_all_candidates_list($start, $end, $candidate_id, $status) {
        $sql = "SELECT erf.*, CONCAT(u.first_name,' ',u.last_name) as reffered_by_name
                FROM employment_request_form erf 
                LEFT JOIN  employees e 
                ON e.empID = erf.reffered_by
                LEFT JOIN users u 
                ON u.employee_id = e.id";

        if (!empty($start)) {
            $sql .= " WHERE erf.created between '" . $start . "' AND '" . $end . "'";
        }

        if (!empty($candidate_id)) {
            if (!empty($start)) {
                $sql .= " AND";
            } else {
                $sql .= " WHERE ";
            }

            $sql .= "  erf.id = '" . $candidate_id . "' ";
        }

        if (!empty($status)) {
            if (!empty($start) || !empty($candidate_id)) {
                $sql .= " AND";
            } else {
                $sql .= " WHERE ";
            }

            $sql .= " erf.status = '" . $status . "' ";
        }

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function check_candidate_applied_before($email) {
        $sql = "SELECT * FROM employment_request_form
         WHERE  created >  DATE_SUB( NOW(), INTERVAL 3 MONTH) AND email = ? ";
        $result = $this->db->query($sql, array($email));
        return $result->row_array();
    }

    public function delete_candidate($ref_id) {

        if (!empty($ref_id)) {
            $this->db->where('id', $ref_id);
            $this->db->delete('employment_request_form');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }

    function change_candidate_status($id, $status) {
        if (!empty($id)) {
            $this->db->where('id', $id);
            $this->db->set('status', $status);
            $this->db->update('employment_request_form');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function get_all_status($start, $end, $candidate_id, $status) {
        $sql = "SELECT SUM(IF(status = 'Selected', 1, 0)) as selected,
                SUM(IF(status = 'Pending', 1, 0)) as pending,
                SUM(IF(status = 'Rejected', 1, 0)) as rejected,
                SUM(IF(status = 'Discarded', 1, 0)) as discarded,
                count(id) as total FROM employment_request_form";


        if (!empty($start)) {
            $sql .= " WHERE created between '" . $start . "' AND '" . $end . "'";
        }

        if (!empty($candidate_id)) {
            if (!empty($start)) {
                $sql .= " AND";
            } else {
                $sql .= " WHERE ";
            }

            $sql .= "  id = '" . $candidate_id . "' ";
        }

        if (!empty($status)) {
            if (!empty($start) || !empty($candidate_id)) {
                $sql .= " AND";
            } else {
                $sql .= " WHERE ";
            }

            $sql .= " status = '" . $status . "' ";
        }
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    function get_count($status) {
        $sql = "SELECT COUNT(id) as count 
                FROM employees 
                WHERE status = ?";

        $result = $this->db->query($sql, array($status));
        if ($result->num_rows() > 0) {
            return $result->row_array()['count'];
        } else {
            return false;
        }
    }

    function get_month_count($status, $start, $end) {
        $sql = "SELECT COUNT(status) as count 
        FROM employees 
        WHERE status = ? 
        AND doj BETWEEN ? AND ?";

        $result = $this->db->query($sql, array($status, $start, $end));
        if ($result->num_rows() > 0) {
            return $result->row_array()['count'];
        } else {
            return false;
        }
    }

    function get_left_month_count($status, $start, $end) {
        $sql = "SELECT COUNT(status) as count
            FROM employees
            WHERE status = ? 
            AND status_modified BETWEEN ? AND ? ";

        $result = $this->db->query($sql, array($status, $start, $end));
        if ($result->num_rows() > 0) {
            return $result->row_array()['count'];
        } else {
            return false;
        }
    }

    function get_candidate_count($status, $start, $end) {
        $sql = "SELECT COUNT(status) as count
            FROM employment_request_form
            WHERE status = ? 
            AND status_modified BETWEEN ? AND ? ";

        $result = $this->db->query($sql, array($status, $start, $end));
        if ($result->num_rows() > 0) {
            return $result->row_array()['count'];
        } else {
            return false;
        }
    }

    function save_mail_to_DB($to, $subject, $message, $is_multi_attach, $from_email, $cc = '', $bcc = '', $attachment = '') {

        $needed_array = array('subject', 'to_email', 'cc_email', 'bcc_email', 'from_email', 'message', 'is_multi_attachment',
            'attachment', 'no_of_try', 'created_datetime');

        $data['subject'] = $subject;
        $data['to_email'] = $to;
        $data['cc_email'] = $cc;
        $data['bcc_email'] = $bcc;
        $data['from_email'] = $from_email;
        $data['message'] = $message;
        $data['is_multi_attachment'] = $is_multi_attach;
        $data['attachment'] = $attachment;
        $data['no_of_try'] = 0;
        $data['created_datetime'] = date("Y-m-d H:i:s");

        $response = $this->db->insert('send_mail', $data);

        if ($response) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function get_email_content() {

        $sql = "SELECT * from send_mail where status = 'Not Send' and no_of_try < 3";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_email_content_by_id($id) {

        $sql = "SELECT * from send_mail where status = 'Not Send' and id = ?";

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    function update_send_mail($id, $status) {

        $modified = date("Y-m-d H:i:s");
        $sql = "UPDATE send_mail set no_of_try = no_of_try + 1, status = '" . $status . "', modified_datetime = '" . $modified . "' 
               WHERE id = " . $id;

        $this->db->query($sql);

        return $id;
    }

    function get_all_states() {

        $sql = "SELECT * FROM state_list";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_all_cities($state_name) {

        $sql = "SELECT i.name,i.id FROM indian_cities i LEFT JOIN state_list s
                ON s.id = i.state_id WHERE state_name = ?
                order by name ASC";

        $result = $this->db->query($sql, array($state_name));
        return $result->result_array();
    }

    function get_all_cities_by_id($state_id) {

        $sql = "SELECT i.name,i.id FROM indian_cities i WHERE i.state_id = ?
                order by name ASC";

        $result = $this->db->query($sql, array($state_id));
        return $result->result_array();
    }

    function get_cities_by_id($city) {

        $sql = "SELECT t.name,t.class FROM indian_cities t WHERE t.id = ?";

        $result = $this->db->query($sql, array($city));
        return $result->result_array();
    }

    function get_all_city() {

        $sql = "SELECT name FROM indian_cities 
                order by name ASC";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_employee_name($id) {
        $sql = 'SELECT GROUP_CONCAT(CONCAT(u.first_name," ",u.last_name) SEPARATOR ", ") as emp_name
        FROM users u 
        WHERE FIND_IN_SET(employee_id, ?)';

        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    function get_thought_of_the_day_image() {
        $sql = "SELECT id, image_name FROM thought_of_the_day
                WHERE status = 'Not Sent' ORDER BY id ASC LIMIT 0,1";

        $result = $this->db->query($sql);
        return $result->row_array();
    }

    function update_thought($id) {

        $date = date('Y-m-d h:m:s');
        $sql = "UPDATE thought_of_the_day SET status = 'Sent', sent_date = ? WHERE id = ?";

        $response = $this->db->query($sql, array($date, $id));

        if ($response) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function get_travel_policy_by_grade($id) {

        $sql = "SELECT * from travel_policy WHERE grade_id=? and status='active'";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_grade_details($id) {
        $sql = "SELECT t.*,e.name as transport,c.name as travel_class from grades t "
                . "LEFT JOIN travel_category e on e.id = t.car_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class "
                . "WHERE t.id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

}
