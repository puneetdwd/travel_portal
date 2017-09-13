<?php

class states_model extends CI_Model {

    public function get_all_states() {

        $sql = "SELECT * from state_list";
		//$sql = "SELECT * from state_list t WHERE t.status = 'active' ";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_states($id) {

        $sql = "SELECT * from state_list WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_states_combination($states_name) {

        $sql = "SELECT id from state_list WHERE state_name=?";
        $result = $this->db->query($sql, array($states_name));

        return $result->row_array();
    }

    public function update_states($data, $state_id) {

        $needed_array = array('state_name');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($state_id)) {
            $this->db->where('id', $state_id);
            $result = $this->db->update('state_list', $data);
            if ($result) {
                return $state_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('state_list', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function delete_states($state_id) {

        if (!empty($state_id)) {
            $this->db->where('id', $state_id);
            $this->db->delete('state_list');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }
    
}
