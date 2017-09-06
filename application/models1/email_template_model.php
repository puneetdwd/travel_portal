<?php

class email_template_model extends CI_Model {

    public function get_all_email_template() {

        $sql = "SELECT * from email_format t";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_email_template($id) {

        $sql = "SELECT * from email_format WHERE mail_id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    } 
    
    public function update_email($data, $mail_id) {

        $needed_array = array('mailformat');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($mail_id)) {
            $this->db->where('mail_id', $mail_id);
            $result = $this->db->update('email_format', $data);
            if ($result) {
                return $mail_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('email_format', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }
    
    
}
