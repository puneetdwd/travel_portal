<?php

class Da_policy_model extends CI_Model {

    public function get_all_da_policy() {

        $sql = "SELECT * from da_policy t";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_policy($id) {

        $sql = "SELECT * from da_policy WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }
    
    public function get_da_band_combination($policy_name) {

        $sql = "SELECT id from da_policy WHERE policy_name=?";
        $result = $this->db->query($sql, array($policy_name));

        return $result->row_array();
    }

    public function update_da($data, $dept_id) {

        $needed_array = array('policy_name');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($dept_id)) {
            $this->db->where('id', $dept_id);
            $result = $this->db->update('da_policy', $data);
            if ($result) {
                return $dept_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('da_policy', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
