<?php

class Travel_policy_model extends CI_Model {

    public function get_all_travel_policy() {

        $sql = "SELECT t.*,g.grade_name from travel_policy t LEFT JOIN grades g on g.id = t.grade_id WHERE t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_travel_policy($id) {

        $sql = "SELECT * from travel_policy WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_travel_policy_combination($service_type, $grade_id, $approval_level, $city_class, $popup, $actual, $amount) {

        $sql = "SELECT id from travel_policy WHERE service_type=? and grade_id = ? and approval_level = ? and city_class = ? and popup = ? ";

        if ($actual == 1) {
            $sql .= "and actual = ?";
            $allowance = $actual;
        } else {
            $sql .= "and amount = ?";
            $allowance = $amount;
        }
        $result = $this->db->query($sql, array($service_type, $grade_id, $approval_level, $city_class, $popup, $allowance));

        return $result->row_array();
    }

    public function update_travel_policy($data, $travel_policy_id) {
        $needed_array = array('service_type', 'grade_id', 'approval_level', 'city_class', 'actual', 'amount', 'popup');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($travel_policy_id)) {
            $this->db->where('id', $travel_policy_id);
            $result = $this->db->update('travel_policy', $data);
            if ($result) {
                return $travel_policy_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_policy', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function get_travel_policy_by_grade($grade_id, $service_type) {
        $sql = "SELECT * from travel_policy WHERE grade_id = ? and service_type = ? and status = 'active'";
        $result = $this->db->query($sql, array($grade_id, $service_type));
        return $result->row_array();
    }

    public function get_policy_allowance_by_grade($grade_id, $to_class) {
        $sql = "SELECT service_type,amount,actual from travel_policy WHERE grade_id = ? and city_class = ? and status = 'active' and service_type in('5','6','7') ORDER BY service_type";
        $result = $this->db->query($sql, array($grade_id,$to_class));
        return $result->result_array();
    }

}
