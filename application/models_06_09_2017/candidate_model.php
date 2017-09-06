<?php

class Candidate_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->database();
    }
    
    function get_all_candidates(){
        $this->db->where('emp_id', 0);
        return $this->db->get('employment_request_form')->result_array();
    }
    
    function get_all_candidates_for_filter(){
        
        $sql = "SELECT erf.*, CONCAT(u.first_name,' ',u.last_name) as reffered_by_name
        from employment_request_form erf
        LEFT JOIN employees e on e.empID = erf.reffered_by
        LEFT JOIN users u on u.employee_id = e.id";
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    function get_all_candidates_list($start, $end, $candidate_id, $status){
        $sql = "SELECT erf.*, CONCAT(u.first_name,' ',u.last_name) as reffered_by_name
                FROM employment_request_form erf 
                LEFT JOIN  employees e 
                ON e.empID = erf.reffered_by
                LEFT JOIN users u 
                ON u.employee_id = e.id";
               
                if(!empty($start)) {
                $sql .= " WHERE erf.created between '".$start."' AND '".$end."' ";
                }
                    
              if(!empty($candidate_id)) {
                  if(!empty($start)){
                        $sql.= " AND";
                    }else{
                        $sql.=" WHERE ";
                    }
                  
                $sql .= "  erf.id = ".$candidate_id." ";
                 
                }
            
            if(!empty($status)) {
                if(!empty($start) || !empty($candidate_id)){
                        $sql.= " AND";
                    }else{
                        $sql.=" WHERE ";
                    }
                
                $sql .= " erf.status = '".$status."' ";
                
                }
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    function get_all_candidates_new(){
        
        $sql = "SELECT erf.*, CONCAT(u.first_name,' ',u.last_name) as reffered_by_name
        from employment_request_form erf
        LEFT JOIN employees e on e.empID = erf.reffered_by
        LEFT JOIN users u on u.employee_id = e.id
        WHERE erf.emp_id =0";
        
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_candidate($email) {
        $this->db->where('email', $email);

        return $this->db->get('employment_request_form')->row_array();
    }
    
    function check_candidate_applied_before($email){
         $sql = "SELECT * FROM employment_request_form
         WHERE  created >  DATE_SUB( NOW(), INTERVAL 3 MONTH) AND email = ? " ;
         $result = $this->db->query($sql, array($email));
         return $result->row_array();
    }
         
    function get_candidate_by_ref_code($ref_code) {
        $this->db->where('ref_code', $ref_code);

        return $this->db->get('employment_request_form')->row_array();
    }
        
    function get_candidate_by_id($id) {
        $this->db->where('id', $id);

        return $this->db->get('employment_request_form')->row_array();
    }
    
    function get_last_ref_code(){
        $sql = "SELECT id,ref_code from employment_request_form order by id desc limit 0,1";
        
        $result = $this->db->query($sql);
        return $result->row_array();
    }
    
    function update_candidate_id($ref_code, $emp_id){
        
        $this->db->where('ref_code', $ref_code);
        $this->db->set('status', 'Selected');
        $this->db->set('emp_id', $emp_id);
        $this->db->set('updated', date("Y-m-d H:i:s"));
        $this->db->update('employment_request_form');
        
        if($this->db->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }

    function update_candidate($data, $candidate_id = '') {
        //filter unwanted fields while inserting in table.
        $needed_array = array('ref_code', 'status', 'reffered_by', 'first_name', 'last_name', 'email', 'phone', 'emergency_phone', 'full_data', 'created');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($candidate_id)) {
            //$data['created'] = date("Y-m-d H:i:s");

            return (($this->db->insert('employment_request_form', $data)) ? $this->db->insert_id() : false);
        } else {
            $this->db->where('id', $candidate_id);
            $data['updated'] = date("Y-m-d H:i:s");

            return (($this->db->update('employment_request_form', $data)) ? $candidate_id : false);
        }
    }
    
    public function delete_candidate($ref_id){
        
        if(!empty($ref_id)){
            $this->db->where('id', $ref_id);
            $this->db->delete('employment_request_form');
            
            if($this->db->affected_rows() > 0){
            return True;
            }
        } else {
            return False;
        }
    }
    
    function change_status($id, $status) {
        if(!empty($id)) {
            $this->db->where('id', $id);
            $this->db->set('status', $status);
            $this->db->set('status_modified', date("Y-m-d H:i:s"));
            $this->db->update('employment_request_form');

            if($this->db->affected_rows() > 0) {
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
                count(id) as total FROM employment_request_form" ;
               
               if(!empty($start)) {
                $sql .= " WHERE created between '".$start."' AND '".$end."'";
                } 
                    
              if(!empty($candidate_id)) {
                  if(!empty($start)){
                        $sql.= " AND";
                    }else{
                        $sql.=" WHERE ";
                    }
                  
                $sql .= "  id = ".$candidate_id." ";
                }
            
            if(!empty($status)) {
                if(!empty($start) || !empty($candidate_id)){
                        $sql.= " AND";
                    }else{
                        $sql.=" WHERE ";
                    }
                
                $sql .= " status = '".$status."' ";
                }
        
        $result = $this->db->query($sql);
        //echo '<pre>'; print_r($sql);exit;
        return $result->row_array();
  
    }
}