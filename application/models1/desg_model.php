<?php

class Desg_model extends CI_Model {

    public function get_all_desg() {

        $sql = "SELECT * from designations t WHERE t.status='active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_desg($id) {

        $sql = "SELECT * from designations WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_all_designations() {

        $sql = "SELECT * from designations group by desg_name";
        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_desg_band_combination($designation) {

        $sql = "SELECT id from designations WHERE desg_name=?";
        $result = $this->db->query($sql, array($designation));

        return $result->row_array();
    }

    public function update_desg($data, $desg_id) {

        $needed_array = array('desg_name');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($desg_id)) {
            $this->db->where('id', $desg_id);
            $result = $this->db->update('designations', $data);
            if ($result) {
                return $desg_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('designations', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function delete_desg($desg_id) {

        if (!empty($desg_id)) {
            $this->db->where('id', $desg_id);
            $this->db->delete('designations');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }

    public function get_all_desg_band() {

        $sql = "SELECT * from designation_band";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_desg_band($id) {

        $sql = "SELECT * from designation_band where id = ? ";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

}
