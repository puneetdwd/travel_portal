<?php

class grades_model extends CI_Model {

    public function get_all_grades() {
        
		//$sql = "SELECT t.*,c.name as car_type,tc.name as travel_class from grades t LEFT JOIN travel_category c ON c.id = t.car_id LEFT JOIN travel_category tc ON tc.id = t.travel_class WHERE t.status='active'";
		$sql = "SELECT t.*,c.name as car_type,tc.name as travel_class from grades t LEFT JOIN travel_category c ON c.id = t.car_id LEFT JOIN travel_category tc ON tc.id = t.travel_class";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_grade($id) {
        $sql = "SELECT * from grades WHERE id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_all_designations() {
        $sql = "SELECT * from designations group by desg_name";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_grade_combination($grade_name, $travel_mode, $travel_class, $hotel_class, $car_id) {

        $sql = "SELECT id from grades WHERE grade_name=? and travel_mode = ? and travel_class = ? and hotel_class = ? and car_id = ?";
        $result = $this->db->query($sql, array($grade_name, $travel_mode, $travel_class, $hotel_class, $car_id));

        return $result->row_array();
    }

    public function update_grade($data, $grade_id) {

        $needed_array = array('grade_name','travel_mode','travel_class','hotel_class','car_id');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($grade_id)) {
            $this->db->where('id', $grade_id);
            $result = $this->db->update('grades', $data);
            if ($result) {
                return $grade_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('grades', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function delete_grade($grade_id) {

        if (!empty($grade_id)) {
            $this->db->where('id', $grade_id);
            $this->db->delete('grades');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }

}
