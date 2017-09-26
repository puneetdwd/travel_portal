<?php

class Project_model extends CI_Model {
	
    public function get_all_projects(){
		
	$sql = "SELECT p.*, sd.sub_dept, c.name as customer  
        FROM projects p 
        INNER JOIN sub_departments sd ON p.sub_dept_id = sd.id
        INNER JOIN customers c ON c.id = p.customer_id
        WHERE p.status = 'Active' ";
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function get_all_projects_for_index(){
		
	$sql = "SELECT p.*, sd.sub_dept, c.name as customer  
        FROM projects p 
        INNER JOIN sub_departments sd ON p.sub_dept_id = sd.id
        INNER JOIN customers c ON c.id = p.customer_id
         ";
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function get_all_projects_by_dept_id($dept_id){
		
	$sql = "SELECT p.*, sd.sub_dept , c.name as customer  FROM projects p 
        INNER JOIN sub_departments sd
        ON p.sub_dept_id = sd.id
        INNER JOIN customers c
        ON c.id = p.customer_id
        WHERE p.dept_id = ? AND p.status = 'Active'
        GROUP BY p.id";
        
        $result = $this->db->query($sql, array($dept_id));
        return $result->result_array();
    }
    
    public function get_all_projects_by_sub_dept_id($sub_dept_id){
		
	$sql = "SELECT p.*, sd.sub_dept , c.name as customer  FROM projects p 
        INNER JOIN sub_departments sd
        ON p.sub_dept_id = sd.id
        INNER JOIN customers c
        ON c.id = p.customer_id
        WHERE p.sub_dept_id = ? AND p.status = 'Active'
        GROUP BY p.id
        UNION
        SELECT p.*, sd.sub_dept , c.name as customer FROM `project_assignments` pa
        INNER JOIN sub_departments sd on sd.dept_lead = pa.emp_id
        INNER JOIN projects p on p.id = pa.project_id
        INNER JOIN customers c ON c.id = p.customer_id
        where sd.id = ? and p.status = 'Active'";
        
        $result = $this->db->query($sql, array($sub_dept_id, $sub_dept_id));
        return $result->result_array();
    }
    
    public function get_all_projects_by_project_assigned($emp_id){
		
	$sql = "SELECT p.*, sd.sub_dept , c.name as customer  FROM projects p 
        INNER JOIN sub_departments sd
        ON p.sub_dept_id = sd.id
        INNER JOIN customers c
        ON c.id = p.customer_id
        LEFT JOIN project_assignments pa
        ON pa.project_id = p.id
        WHERE pa.emp_id = ?  AND p.status = 'Active'
        GROUP BY p.id";
        
        $result = $this->db->query($sql, $emp_id);
        return $result->result_array();
    }
	
    public function get_project($id){

        $sql = "SELECT * from projects WHERE id=?";
        $result = $this->db->query($sql,array($id));

        return $result->row_array();
    }
    
    public function get_project_details($id){

        $sql = "SELECT p.*,sd.dept_lead,d.dept_name,emp.gi_email as dept_head_email, 
        sd.sub_dept , u.first_name, u.last_name, e.gi_email, e.phone, c.address1, 
        c.address2 ,c.city,c.state, c.post_code,c.country 
        FROM projects p 
        INNER JOIN project_assignments pa 
        ON pa.project_id = p.id 
        INNER JOIN sub_departments sd 
        ON sd.id = p.sub_dept_id 
        INNER JOIN employees e 
        ON e.id = sd.dept_lead 
        INNER JOIN users u 
        ON u.employee_id = e.id 
        INNER JOIN customers c 
        ON p.customer_id = c.id 
        INNER JOIN departments d 
        ON d.id = sd.department_id 
        INNER JOIN employees emp 
        ON d.dept_head = emp.id 
        WHERE p.id = ?  
        GROUP BY p.id";
        $result = $this->db->query($sql,array($id));

        return $result->row_array();
    }
    
    
    
    public function get_project_combination($project, $sub_dept){
		
        $sql = "SELECT id from projects WHERE name = ?  AND sub_dept_id = ? ";
        $result = $this->db->query($sql,array($project, $sub_dept ));

        return $result->row_array();
    }
   
	
    public function update_project($data, $project_id){

        $needed_array = array('name','customer_id','dept_id','code' , 'sub_dept_id', 'date');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        if(!empty($project_id)){
            $this->db->where('id', $project_id) ;

            $result = $this->db->update('projects',$data);

            if($result){
                    return $project_id;
            }else{
                    return FALSE;
            }
        }else{
            $data['code'] = $this->generate_project_code();
            $result = $this->db->insert('projects', $data);

            if($result){
                    return $this->db->insert_id();

            }else{
                    return False;
            }
        }
    }
    
     public function get_all_sub_depts($dept_id =''){
         
        if(!empty($dept_id)){
            $sql = "SELECT *  FROM sub_departments where department_id = ?";
            $result = $this->db->query($sql, array($dept_id));
        }else{
            $sql = "SELECT *  FROM sub_departments";
            $result = $this->db->query($sql);
        }

        return $result->result_array();
    }
    
    
    function add_default_projects($data){
        
        for($i=0; $i<sizeof($data);$i++){
            $response = $this->db->insert('project_assignments', $data[$i]);
        }

        /*if($response){
            return $this->db->insert_id();
        } else {
            return FALSE;
        }*/
        return true;
    }
    
    function delete_item($id) {
       
        if(!empty($id)) {
            
            $this->db->where('id', $id);
            $this->db->delete('projects');
            
            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
   
   function generate_project_code() {
        $this->db->select('MAX(code) as code');
        $record = $this->db->get('projects');

        $code = 0;
        if($record->num_rows() > 0) {
            $record = $record->row_array();
            $code =  $record['code'];
        }

        if(empty($code)) {
            return 'PRJ-101';
        }
        
        $sql = 'select code from projects order by id desc limit 0,1';
        
            $result = $this->db->query($sql);
            $project=$result->row_array();
            
            $project=explode('-',$project['code']);
            
            $project_part=$project[1]+1;
            
          return 'PRJ-'.str_pad($project_part, 3, '0', STR_PAD_LEFT);

    }
    
     function change_status($id, $status) {
        if(!empty($id) && !empty($status)) {
            $this->db->where('id', $id);
            $this->db->set('status', $status);
            $this->db->update('projects');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
    
  }