<?php

class cost_model extends CI_Model {

    public function get_all_cost_center() {

        $sql = "SELECT c.name as city_name,c.class as city_class,t.guest_house,t.status,t.id from cost_center t 
            
                LEFT JOIN indian_cities c
                ON c.id = t.city_id
                
                WHERE t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_cost($id) {

        $sql = "SELECT * from cost_center t LEFT JOIN indian_cities c
                ON c.id = t.city_id WHERE t.id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_cost_combination($city_id,$guest_house) {

        $sql = "SELECT id from cost_center WHERE city_id = ? and guest_house = ?";
        $result = $this->db->query($sql, array($city_id,$guest_house));

        return $result->row_array();
    }

    public function update_cost($data, $cost_id) {
        $needed_array = array('city_id','guest_house');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($cost_id)) {
            $this->db->where('id', $cost_id);
            $result = $this->db->update('cost_center', $data);
            if ($result) {
                return $cost_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('cost_center', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
