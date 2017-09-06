<?php

class Service_proviers_model extends CI_Model {

    public function get_all_service_proviers($state_id ='') {

        $sql = "SELECT t.*,c.name as city_name from service_proviers t "
                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
                . "WHERE t.status = 'active'";
        if ($state_id != '') {
            $sql .= " and state_id = '".$state_id."'";
        }
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_service_proviers($id) {
        $sql = "SELECT * from service_proviers WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_service_proviers_combination($name, $service_type, $amount, $city_id,$half_amount) {
        $sql = "SELECT id from service_proviers WHERE name = ? and service_type = ? and amount = ? and city_id = ? and half_amount = ?";
        $result = $this->db->query($sql, array($name, $service_type, $amount, $city_id,$half_amount));
        return $result->row_array();
    }

    public function update_service_proviers($data, $service_proviers_id) {
        $needed_array = array('name', 'service_type', 'amount', 'city_id','half_amount');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($service_proviers_id)) {
            $this->db->where('id', $service_proviers_id);
            $result = $this->db->update('service_proviers', $data);
            if ($result) {
                return $service_proviers_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('service_proviers', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
