<?php

class projects_model extends CI_Model {

    public function get_all_projects() {

        //$sql = "SELECT t.*,d.dept_name from projects t "
        //. "LEFT JOIN departments d on d.id = t.dept_id "
        //. "WHERE t.status = 'active' ";
		
		$sql = "SELECT t.*,d.dept_name from projects t LEFT JOIN departments d on d.id = t.dept_id";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_project($id) {

        $sql = "SELECT * from projects WHERE id=?";
        $result = $this->db->query($sql, array($id));

        return $result->row_array();
    }

    public function get_project_by_dept($id) {

        $sql = "SELECT * from projects WHERE dept_id=?";
        $result = $this->db->query($sql, array($id));

        return $result->result_array();
    }

    public function get_projects_combination($name, $dept_id, $budget, $remain_budget) {

        $sql = "SELECT id from projects WHERE name = ? and dept_id = ? and budget = ? and remain_budget = ?";
        $result = $this->db->query($sql, array($name, $dept_id, $budget, $remain_budget));

        return $result->row_array();
    }

    public function update_projects($data, $project_id) {

        $needed_array = array('name', 'dept_id', 'budget', 'remain_budget');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($project_id)) {
            $this->db->where('id', $project_id);
            $result = $this->db->update('projects', $data);
            if ($result) {
                return $project_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('projects', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
