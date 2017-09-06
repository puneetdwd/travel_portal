<?php

class Department_model extends CI_Model {

    public function get_all_department() {

        $sql = "SELECT * from departments t WHERE t.status='active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_dept($id) {

        $sql = "SELECT * from departments WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }
    
    public function get_dept_band_combination($department) {

        $sql = "SELECT id from departments WHERE dept_name=?";
        $result = $this->db->query($sql, array($department));

        return $result->row_array();
    }

    public function update_dept($data, $dept_id) {

        $needed_array = array('dept_name');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($dept_id)) {
            $this->db->where('id', $dept_id);
            $result = $this->db->update('departments', $data);
            if ($result) {
                return $dept_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('departments', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
