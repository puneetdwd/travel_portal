<?php

class city_model extends CI_Model {

    public function get_all_city() {

        $sql = "SELECT t.*, c.name as cost_center,s.state_name from indian_cities t LEFT JOIN indian_cities c ON c.id = t.cost_center_id LEFT JOIN state_list s ON s.id = t.state_id order by t.name ASC";
		//$sql = "SELECT t.*,c.name as cost_center,s.state_name from indian_cities t LEFT JOIN indian_cities c ON c.id = t.cost_center_id LEFT JOIN state_list s ON s.id = t.state_id WHERE t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_city_by_class($class) {
        $sql = "SELECT * from indian_cities WHERE class=?";
        $result = $this->db->query($sql, array($class));
        return $result->result_array();
    }

    public function get_city($id) {

        $sql = "SELECT * from indian_cities WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_city_combination($name, $states_id, $class, $cost_center_id, $guest_house,$officenumber ,$officeaddress ,$gsaddress ,$caretakername ,$mobile_number) {        
        $sql = "SELECT id from indian_cities WHERE state_id = ? and name = ? and class = ? and cost_center_id = ? and guest_house = ? and officenumber = ? and officeaddress = ? and gsaddress = ? and caretakername = ? and mobile_number = ?";
        $result = $this->db->query($sql, array($name, $states_id, $class, $cost_center_id, $guest_house,$officenumber ,$officeaddress ,$gsaddress ,$caretakername ,$mobile_number));

        return $result->row_array();
    }

    public function update_city($data, $city_id) {
        $needed_array = array('name', 'state_id', 'class', 'cost_center_id', 'guest_house','officenumber','officeaddress','gsaddress','caretakername','mobile_number');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($city_id)) {
            $this->db->where('id', $city_id);
            $result = $this->db->update('indian_cities', $data);
            if ($result) {
                return $city_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('indian_cities', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
