<?php

class Travel_reasons_model extends CI_Model {

    public function get_all_travel_reasons() {

        $sql = "SELECT * from travel_reasons t WHERE t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_travel_reasons($id) {

        $sql = "SELECT * from travel_reasons WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_travel_reasons_combination($reason, $hangout_suggestion) {
        $sql = "SELECT id from travel_reasons WHERE reason = ? and hangout_suggestion = ?";
        $result = $this->db->query($sql, array($reason, $hangout_suggestion));
        return $result->row_array();
    }

    public function update_travel_reasons($data, $travel_reasons_id) {
        $needed_array = array('reason', 'hangout_suggestion');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($travel_reasons_id)) {
            $this->db->where('id', $travel_reasons_id);
            $result = $this->db->update('travel_reasons', $data);
            if ($result) {
                return $travel_reasons_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_reasons', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
