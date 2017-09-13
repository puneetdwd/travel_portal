<?php

class Budget_model extends CI_Model {

    public function get_budget() {

        //$sql = "SELECT t.*,c.name as cost_center_name,d.dept_name as department from budget t "
        //. "LEFT JOIN indian_cities c ON c.id = t.cost_center_id "
        //. "LEFT JOIN departments d ON d.id = t.department_id "
        //. "WHERE t.status = 'active'";
        
		$sql = "SELECT t.*,c.name as cost_center_name,d.dept_name as department from budget t "
        . "LEFT JOIN indian_cities c ON c.id = t.cost_center_id "
        . "LEFT JOIN departments d ON d.id = t.department_id";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_budget_id($id) {
        $sql = "SELECT * from budget WHERE id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_budget_by_dept($id, $financial_year) {
        $sql = "SELECT * from budget WHERE department_id=? and financial_year = ?";
        $result = $this->db->query($sql, array($id, $financial_year));
        return $result->row_array();
    }

    public function get_budget_combination($department_id, $financial_year, $cost_center_id, $budget, $remain_budget) {
        $sql = "SELECT id from budget WHERE department_id = ? and financial_year = ? and cost_center_id = ? and budget = ? and remain_budget = ?";
        $result = $this->db->query($sql, array($department_id, $financial_year, $cost_center_id, $budget, $remain_budget));
        return $result->row_array();
    }

    public function update_budget($data, $budget_id) {
        $needed_array = array('department_id', 'financial_year', 'cost_center_id', 'budget', 'remain_budget');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($budget_id)) {
            $this->db->where('id', $budget_id);
            $result = $this->db->update('budget', $data);
            if ($result) {
                return $budget_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('budget', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
