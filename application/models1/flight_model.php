<?php

class Flight_model extends CI_Model {

    public function get_all_flight() {

        $sql = "SELECT * from flight_category t WHERE t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_flight($id) {

        $sql = "SELECT * from flight_category WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_flight_combination($name) {

        $sql = "SELECT id from flight_category WHERE name=? ";
        $result = $this->db->query($sql, array($name));

        return $result->row_array();
    }

    public function update_flight($data, $flight_id) {
        $needed_array = array('name');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($flight_id)) {
            $this->db->where('id', $flight_id);
            $result = $this->db->update('flight_category', $data);
            if ($result) {
                return $flight_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('flight_category', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
