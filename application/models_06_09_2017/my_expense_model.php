<?php

class My_expense_model extends CI_Model {

    function generate_reference_id() {
        $this->db->select('reference_id');
        $this->db->order_by('id', 'desc');
        $this->db->where('reference_id != ', '');
        $record = $this->db->get('travel_request');

        $code = 0;
        if ($record->num_rows() > 0) {
            $record = $record->row_array();
            $code = $record['reference_id'];
        }
        if (empty($code)) {
            return 'TR/' . str_pad(1, 4, '0', STR_PAD_LEFT);
        }

        $new_code = (int) str_replace('TR/', '', $code) + 1;
        return 'TR/' . str_pad($new_code, 4, '0', STR_PAD_LEFT);
    }
//Get Refrence Id group By
   
	  public function get_all_request($employee_id) {

        $sql = "select travel_request.id,travel_request.reference_id,travel_request.to_city_id ,travel_request.from_city_id , travel_request.request_number,travel_request.employee_id ,f.name as from_city_name,d.name as to_city_name from travel_request 
		LEFT JOIN indian_cities f ON f.id = travel_request.from_city_id 
        LEFT JOIN indian_cities d ON d.id = travel_request.to_city_id 
		where employee_id=".$employee_id ." AND request_status in (4,5) Order BY reference_id DESC";
        $result = $this->db->query($sql);
		//print_r($result->result_array());die;
        return $result->result_array();
    }
	
	public function get_all_other_expences_data($TableName) {
        $sql = "select id,expense_name from ". $TableName ." where status='active';";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
	
}
