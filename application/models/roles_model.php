<?php

class roles_model extends CI_Model {

    public function get_all_roles() {

        $sql = "SELECT * from roles";
		//$sql = "SELECT * from roles t WHERE t.status='active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_roles($id) {

        $sql = "SELECT * from roles WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_roles_menu($id) {

        $sql = "SELECT * from roles_menu WHERE roles_id=?";
        $result = $this->db->query($sql, array($id));

        return $result->result_array();
    }

    public function get_roles_combination($role_name) {

        $sql = "SELECT id from roles WHERE roles_name=?";
        $result = $this->db->query($sql, array($role_name));

        return $result->row_array();
    }

    public function update_roles($data, $role_id) {

        $needed_array = array('roles_name', 'description');
        $data = array_intersect_key($data, array_flip($needed_array));

        if (!empty($role_id)) {
            $this->db->where('id', $role_id);
            $result = $this->db->update('roles', $data);
            if ($result) {
                return $role_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('roles', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function insert_roles_menu($data) {
        $needed_array = array('roles_id', 'menu_id');
        $data = array_intersect_key($data, array_flip($needed_array));
        $result = $this->db->insert('roles_menu', $data);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return False;
        }
    }

    public function delete_roles_menu($roles_id) {

        if (!empty($roles_id)) {
            $this->db->where('roles_id', $roles_id);
            $this->db->delete('roles_menu');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }

    function change_status($rolesID, $status) {
        if (!empty($rolesID) && !empty($status)) {
            $this->db->where('id', $rolesID);
            $this->db->set('status', $status);
            $this->db->update('roles');
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
        return FALSE;
    }

}
