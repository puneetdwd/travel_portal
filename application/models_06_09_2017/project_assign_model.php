 <?php

class Project_assign_model extends CI_Model {
    
    public function get_all_assignments(){
        $sql = 'SELECT pa.*, p.name, CONCAT(u.first_name, " ", u.last_name) as emp_name  
                FROM project_assignments pa
                Left JOIN users u ON u.employee_id = pa.emp_id
                INNER JOIN projects p ON p.id = pa.project_id 
                INNER JOIN sub_departments sd ON sd.id = p.sub_dept_id' ;
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
     public function get_all_assignments_new($start_date, $end_date, $employee_id='', $project_id=''){
        $sql = 'SELECT pa.*, p.name, CONCAT(u.first_name, " ", u.last_name) as emp_name  
                FROM project_assignments pa
                Left JOIN users u ON u.employee_id = pa.emp_id
                INNER JOIN projects p ON p.id = pa.project_id 
                INNER JOIN sub_departments sd ON sd.id = p.sub_dept_id
                WHERE pa.start_date >= ? AND pa.start_date <= ? ' ;
        
        if(!empty($employee_id)){
            $sql.= " and pa.emp_id in (".$employee_id.") ";
        }
        
        if(!empty($project_id)){
            $sql.= " and pa.project_id ='".$project_id."' ";
        }
        
        $result = $this->db->query($sql, array($start_date,$end_date));
        return $result->result_array();
    }
    
    public function get_all_assignments_by_sub_dept($sub_dept_id){
		
        $sql = 'SELECT pa.*, p.name, CONCAT(u.first_name, " ", u.last_name) as emp_name  FROM project_assignments pa
        INNER JOIN users u 
        ON u.employee_id = pa.emp_id
        INNER JOIN projects p 
        ON p.id = pa.project_id 
        INNER JOIN sub_departments sd 
        ON sd.id = p.sub_dept_id
        WHERE d.sub_dept_id = ? ' ;
        
        $result = $this->db->query($sql, array($sub_dept_id));
        return $result->result_array();
    }
	
    public function get_all_assignments_by_sub_dept_new($sub_dept_id, $start_date='', $end_date='', $employee_id='', $project_id=''){
		
        $sql = 'SELECT pa.*, p.name, CONCAT(u.first_name, " ", u.last_name) as emp_name  
                FROM project_assignments pa
                INNER JOIN users u ON u.employee_id = pa.emp_id
                INNER JOIN projects p ON p.id = pa.project_id 
                INNER JOIN sub_departments sd ON sd.id = p.sub_dept_id
                INNER JOIN employees e ON e.id = pa.emp_id
                WHERE e.sub_dept_id = ? ' ;
        
        if(!empty($start_date)){
            $sql.= " and pa.start_date >='".$start_date."' ";
        }
        
        if(!empty($end_date)){
            $sql.= " and pa.start_date <='".$end_date."' ";
        }
        
        if(!empty($employee_id)){
            $sql.= " and pa.emp_id in (".$employee_id.") ";
        }
        
        if(!empty($project_id)){
            $sql.= " and pa.project_id ='".$project_id."' ";
        }
        
        //echo $sql; exit;
        
        $result = $this->db->query($sql, array($sub_dept_id));
        return $result->result_array();
    }
    
    public function get_all_assignments_by_dept($dept_id){
        $sql = 'SELECT pa.*, p.name, CONCAT(u.first_name, " ", u.last_name) as emp_name  FROM project_assignments pa
        INNER JOIN users u 
        ON u.employee_id = pa.emp_id
        INNER JOIN projects p 
        ON p.id = pa.project_id 
        INNER JOIN departments d 
        ON d.id = p.dept_id
        WHERE d.id = ?' ;
        
        $result = $this->db->query($sql, array($dept_id));
        return $result->result_array();
    }
    
    public function get_all_assignments_by_dept_new($dept_id, $start_date='', $end_date='', $employee_id='', $project_id=''){
        $sql = 'SELECT pa.*, p.name, CONCAT(u.first_name, " ", u.last_name) as emp_name  
                FROM project_assignments pa
                INNER JOIN users u ON u.employee_id = pa.emp_id
                INNER JOIN projects p ON p.id = pa.project_id 
                INNER JOIN departments d ON d.id = p.dept_id
                INNER JOIN employees e ON e.id = pa.emp_id
                WHERE e.department_id = ?' ;
        
        if(!empty($start_date)){
            $sql.= " and pa.start_date >='".$start_date."' ";
        }
        
        if(!empty($end_date)){
            $sql.= " and pa.start_date <='".$end_date."' ";
        }
        
        if(!empty($employee_id)){
            $sql.= " and pa.emp_id in (".$employee_id.") ";
        }
        
        if(!empty($project_id)){
            $sql.= " and pa.project_id ='".$project_id."' ";
        }
        
        $result = $this->db->query($sql, array($dept_id));
        return $result->result_array();
    }
    
    public function get_all_projects_as_dept($dept_id){
        $sql = 'SELECT p.id, p.name FROM projects p
        INNER JOIN departments d
        ON d.id = p.dept_id
        WHERE  d.id = ? AND p.status = "Active" ' ;
        
        $result = $this->db->query($sql, array($dept_id));
        return $result->result_array();
    }
    
    public function get_all_projects_as_sub_dept($sub_dept_id){
        $sql = 'SELECT p.id, p.name FROM projects p
        INNER JOIN sub_departments sd ON sd.id = p.sub_dept_id
        WHERE  sd.id = ? AND p.status = "Active"  ' ;
        
        $result = $this->db->query($sql, array($sub_dept_id));
        return $result->result_array();
    }
	
    public function get_assignment($id){
		
	$sql = "SELECT pa.*, p.name, u.first_name, u.last_name FROM project_assignments pa
        INNER JOIN users u 
        ON u.employee_id = pa.emp_id
        INNER JOIN projects p 
        ON p.id = pa.project_id
        WHERE pa.id=?";
        
	$result = $this->db->query($sql,array($id));
	return $result->row_array();
    }
    
   
	
    public function assign_project($data, $project_id){
		
        $needed_array = array('project_id', 'emp_id', 'work_as' , 'start_date','assigned_by', 'end_date', 'role', 'responsible', 'comment' ) ;
	$data = array_intersect_key($data, array_flip($needed_array));

        if(!empty($project_id)){
            $this->db->where('id', $project_id) ;

            $result = $this->db->update('project_assignments',$data);

            if($result){
                    return $project_id;
            }else{
                    return FALSE;
            }
        }else{

            $result = $this->db->insert('project_assignments', $data);

            if($result){
                    return $this->db->insert_id();

            }else{
                    return False;
            }
        }
    }
    
    public function get_employees(){
        $empID = $this->session->userdata('employee_id');
        $sql = 'SELECT e.*, u.id as user_id, CONCAT(u.first_name, " ", u.last_name) as emp_name, e.gi_email
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id
        WHERE e.reporting_person_id = ?'
        ;
        
        $result = $this->db->query($sql, array($empID));
        return $result->result_array();
    }
    
    public function get_employees_new(){
        
        $sql = 'SELECT e.*, u.id as user_id, CONCAT(u.first_name, " ", u.last_name) as emp_name, e.gi_email
        FROM employees e
        INNER JOIN users u on u.employee_id = e.id
        WHERE e.status = "active" ';
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function get_all_employees_by_dept_id($dept_id, $dept_head){
        $sql = "SELECT u.first_name, u.last_name, CONCAT(u.first_name, ' ' ,u.last_name) as emp_name, e.*
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id
        INNER JOIN departments d
        ON d.id = e.department_id
        WHERE e.status='active' and department_id = ?  and e.id != ?";
        
        $result = $this->db->query($sql, array($dept_id, $dept_head));
        return $result->result_array();
    }
    
    public function get_all_employees_by_sub_dept_id($sub_dept_id, $sub_dept_lead){
        $sql = "SELECT u.first_name, u.last_name, CONCAT(u.first_name, ' ' ,u.last_name) as emp_name, e.*
        FROM employees e
        INNER JOIN users u on u.employee_id = e.id
        INNER JOIN sub_departments sd ON sd.id = e.department_id
        WHERE e.status='active' and sub_dept_id = ?  and e.id != ?";
        
        $result = $this->db->query($sql, array($sub_dept_id, $sub_dept_lead));
        return $result->result_array();
    }
    
    public function get_all_projects(){
        
        $dept = $this->session->userdata('sub_dept_id');
        
        $sql = "SELECT p.*, sd.sub_dept  FROM projects p 
        INNER JOIN sub_departments sd
        ON p.sub_dept_id = sd.id 
        WHERE sd.id = ?";
        
        $result = $this->db->query($sql, array($dept));
        return $result->result_array();
    }
    
    public function get_all_projects_new(){
        
        $sql = "SELECT * FROM projects where status = 'Active' ";
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function get_employee(){
         
        $dept_id = $this->session->userdata('department_id');
        $sql = 'SELECT u.id as user_id, CONCAT(u.first_name, " ", u.last_name) as name, e.gi_email
        FROM employees e
        INNER JOIN users u
        on u.employee_id = e.id
        WHERE e.department_id = ?'
        ;
        
        $result = $this->db->query($sql, array($dept_id));
        return $result->row_array();
    }
     
    function add_notification($data, $id){
        $needed_array = array( 'type', 'sender_emp_id', 'target_id','status', 'level' ,'notify_emp_id', 'notify_datetime' );
        $data = array_intersect_key($data, array_flip($needed_array));
        
        if(empty($id)) {      
            return (($this->db->insert('notifications', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $id);
            return (($this->db->update('notifications', $data)) ? $id : False);
        }
    }  
    
     function get_notifications($id){
        $sql = "SELECT n.*, u.first_name, u.last_name, l.*,
        n.notify_emp_id as report_id
        FROM notifications n 
        INNER JOIN users u 
        ON u.employee_id = n.sender_emp_id 
        INNER JOIN leaves l 
        ON l.id = n.target_id 
        WHERE n.type = 'Assignment'
        AND n.notify_emp_id = ?"  ;
         
        $result = $this->db->query($sql, array($id));
        return $result->result_array();

    }
    
    function change_status($assignment_id, $status, $project_id) {
        if(!empty($assignment_id) && !empty($status)) {
            $this->db->where('project_id', $project_id);
            $this->db->where('responsible', $status);
            $this->db->set('responsible', !$status);
            $this->db->update('project_assignments');
            
            $this->db->where('id', $assignment_id);
            $this->db->set('responsible', $status);
            $this->db->update('project_assignments');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
    public function get_project_assignment_combination($project_id, $emp_id, $start_date, $end_date){
		
		$sql = "SELECT id 
        from project_assignments 
        WHERE project_id = ? AND emp_id = ? 
        AND start_date >= ? AND end_date <= ?  ";
		$result = $this->db->query($sql,array($project_id, $emp_id, $start_date, $end_date));
		
		return $result->row_array();
	}
    
    public function check_full_time_assigned_employee($emp_id, $start_date, $end_date){
		
		$sql = "SELECT *
        from project_assignments 
        WHERE work_as = 'Full-time' AND emp_id = ? 
        AND start_date >= ? AND end_date <= ? ";
		$result = $this->db->query($sql,array($emp_id, $start_date, $end_date));
		
		return $result->row_array();
	}
    
    
    
   
  }