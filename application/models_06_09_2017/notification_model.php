<?php
class Notification_model extends CI_Model {
    
    function __construct() {
        parent::__construct();

    }
    
    function update_notification($data, $id = ''){
		
        $needed_array = array('type', 'notify_emp_id', 'sender_emp_id', 'target_id', 'level', 'notify_datetime');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (empty($id)){
                $result = $this->db->insert('notifications', $data);
                return ($result) ? $this->db->insert_id() : False;

        } else {
                $this->db->where('id', $id);
                $result = $this->db->update('notifications', $data);
                return ($result) ? $id : False;
        }

    }   
	
    function get_noti_for_employee($id){
        $sql = 'SELECT n.*, 
        CONCAT(u.first_name, " ", u.last_name) 
        AS employee_name 
        FROM notifications n 
        LEFT JOIN users u 
        ON u.employee_id = n.sender_emp_id 
        WHERE n.status IN ("Pending", "Assigned","In_Process") 
        AND n.notify_emp_id = ? ';

        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }
    
    function get_noti_count($notify_emp_id = '', $date_from, $date_to){
        $sql = 'SELECT n.notify_emp_id, n.type, count(n.type) as count, 
                CONCAT(u.first_name, " ", u.last_name) AS employee_name 
        FROM notifications n 
        INNER JOIN users u ON u.employee_id = n.notify_emp_id 
        WHERE n.status = "Pending" and notify_datetime >= ? and notify_datetime <= ? ';
        
        if(!empty($notify_emp_id)){
            $sql.= ' and n.notify_emp_id in ('.$notify_emp_id.') ';
        }
        
        
        $sql.= 'GROUP BY n.notify_emp_id, n.type 
                ORDER BY n.notify_emp_id';
        //echo $sql; exit;

        $result = $this->db->query($sql, array($date_from, $date_to));
        return $result->result_array();
    }
    
    function get_noti_for_check_leave($id){
            $sql = 'SELECT n.*, 
            CONCAT(u.first_name, " ", u.last_name) 
            AS employee_name 
            FROM notifications n 
            INNER JOIN users u 
            ON u.employee_id = n.sender_emp_id 
            WHERE n.status = "Pending" 
            AND n.sender_emp_id = ? AND n.type IN 
            ("Personal Leave", "Medical Leave", "Paid Meternity Leave","Comp-Off", "Half Day", "leave")';
		
            $result = $this->db->query($sql, array($id));
            return $result->result_array();
	}
    
    function get_noti_for_service_requests($id){
		$sql = 'SELECT n.*, 
		CONCAT(u.first_name, " ", u.last_name) 
		AS employee_name ,sr.others, sr.request_for
		FROM notifications n 
		INNER JOIN users u 
		ON u.employee_id = n.sender_emp_id 
        INNER JOIN service_requests sr 
        ON sr.id = n.target_id
		WHERE n.status IN ("Pending","In_Process") 
        AND n.notify_emp_id = ?';
		
		$result = $this->db->query($sql, array($id));
		return $result->result_array();
	}
    
    function get_noti_for_project_assignment($id){
        $date = date('Y-m-d');
		$sql = "SELECT n.*, p.name , pa.start_date, pa.end_date,pa.assigned_by, concat(u.first_name, ' ', u.last_name) as assign_by_emp
        FROM notifications n 
        LEFT JOIN project_assignments pa 
        ON pa.emp_id = n.notify_emp_id 
        LEFT JOIN projects p 
        ON p.id = pa.project_id 
        LEFT JOIN users u 
        ON u.employee_id = pa.assigned_by
        WHERE n.notify_emp_id = ? AND
        pa.start_date = ? "	;	
		$result = $this->db->query($sql, array($id, $date));
		return $result->row_array();
	}
	
	function delete_notification($type, $id){
		$this->db->where('target_id',$id);
		$this->db->where('type', $type);
		$this->db->delete('notifications');
		if ($this->db->affected_rows() > 0){
			return True;
		} else {
			return False;
		} 
	}
    
    function get_all_notifications($id){
       //echo "hi ".$id; exit;
        $sql = "SELECT n.*, IF (count(n.id) > 0,count(n.id),NULL) as total , CONCAT(u.first_name, ' ', u.last_name) 
        AS employee_name FROM notifications  n
        LEFT JOIN users u 
        ON u.employee_id = n.sender_emp_id
        WHERE n.status IN ('Pending', 'In_Process')  AND n.notify_emp_id = ? ";
		
		$result = $this->db->query($sql, array($id));
		return $result->result_array();
    }
    
    function get_notification_counts($id){
       //echo "hi ".$id; exit;
        $pending_sql = 'SELECT  IF (count(id) > 0,count(id),NULL) as total 
        FROM notifications 
        WHERE  type != "Timesheet" AND status IN ("Pending", "In_Process")  AND notify_emp_id = ? ';
		
		$pending = $this->db->query($pending_sql, array($id));
		$pending_result = $pending->row_array();
        
        $unread_sql = 'SELECT  IF (count(n.id) > 0,count(n.id),NULL) as unread 
        FROM notifications n
        WHERE n.status IN ("Pending", "In_Process") AND n.read = ? AND n.notify_emp_id = ? ';
		
		$unread = $this->db->query($unread_sql, array(false, $id));
        $unread_result = $unread->row_array();
        
        return array_merge($pending_result, $unread_result);
    }
	
    public function mark_read($id){
        $this->db->where('id', $id);
        $this->db->set('read', true);
        $result = $this->db->update('notifications');
        if ($this->db->affected_rows() > 0){
			return True;
		} else {
			return False;
		} 
    }
}