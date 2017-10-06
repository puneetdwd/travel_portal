<?php

class Finance_desk_model extends CI_Model {

    public function get_travel_requests() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
                expense.policy_meet,
                expense.total_claim,
                expense.less_advance,
                expense.recevied_amount,
		concat(travaller.first_name, ' ', travaller.last_name) as travallername,
		concat(boss.first_name, ' ', boss.last_name) as bossName,
		basicDetail.phone as travallerMobile,
		basicDetail.grade_id as GradeId,
		grades.grade_name as gradeName,
		travel_reasons.reason as reasonOfJourney,
		travel_category.name as journeyClass,
		fromCity.name as from_city_name,
		toCity.name as to_city_name from travel_request
		left join users travaller on travel_request.employee_id= travaller.employee_id
		left join employees basicDetail on travel_request.employee_id= basicDetail.id
		left join grades on basicDetail.grade_id= grades.id
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join expense on expense.request_id = travel_request.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and merge_expense != '1' and travel_request.approval_status='Approved' and travel_request.request_status='6' and expense.expense_status ='Approved'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_finance_expense_requests() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
                expense.policy_meet,
                expense.total_claim,
                expense.less_advance,
                expense.recevied_amount,
		concat(travaller.first_name, ' ', travaller.last_name) as travallername,
		concat(boss.first_name, ' ', boss.last_name) as bossName,
		basicDetail.phone as travallerMobile,
		basicDetail.grade_id as GradeId,
		grades.grade_name as gradeName,
		travel_reasons.reason as reasonOfJourney,
		travel_category.name as journeyClass,
		fromCity.name as from_city_name,
		toCity.name as to_city_name from travel_request
		left join users travaller on travel_request.employee_id= travaller.employee_id
		left join employees basicDetail on travel_request.employee_id= basicDetail.id
		left join grades on basicDetail.grade_id= grades.id
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join expense on expense.request_id = travel_request.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.merge_expense !='1' and travel_request.status='active' and travel_request.approval_status='Approved' and travel_request.request_status='6' and expense.expense_status ='Approved'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function get_all_merge_expense_pending_for_manager($employee_id) {
        $sql = "SELECT t.*,concat(boss.first_name, ' ', boss.last_name) as bossName,grades.grade_name as gradeName,e.employee_id as emp_id,CONCAT(u.first_name,' ',u.last_name) as requested_name from merge_expense t "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "left join grades on e.grade_id= grades.id "
                . "left join users boss on t.reporting_manager_id= boss.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . " WHERE t.status = 'active' and t.expense_status = 'Approved' and t.request_status ='6'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function get_travel_merge_requests_unaudit($employee_id) {
        $sql = "SELECT t.*,concat(boss.first_name, ' ', boss.last_name) as bossName,grades.grade_name as gradeName,e.employee_id as emp_id,CONCAT(u.first_name,' ',u.last_name) as requested_name from merge_expense t "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "left join grades on e.grade_id= grades.id "
                . "left join users boss on t.reporting_manager_id= boss.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . " WHERE t.status = 'active' and t.expense_status = 'Approved' and t.request_status ='8'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_travel_requests_unaudit() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
                expense.policy_meet,
                expense.total_claim,
                expense.less_advance,
                expense.recevied_amount,
		concat(travaller.first_name, ' ', travaller.last_name) as travallername,
		concat(boss.first_name, ' ', boss.last_name) as bossName,
		basicDetail.phone as travallerMobile,
		basicDetail.grade_id as GradeId,
		grades.grade_name as gradeName,
		travel_reasons.reason as reasonOfJourney,
		travel_category.name as journeyClass,
		fromCity.name as from_city_name,
		toCity.name as to_city_name from travel_request
		left join users travaller on travel_request.employee_id= travaller.employee_id
		left join employees basicDetail on travel_request.employee_id= basicDetail.id
		left join grades on basicDetail.grade_id= grades.id
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join expense on expense.request_id = travel_request.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.merge_expense !='1' and travel_request.status='active' and travel_request.approval_status='Approved' and travel_request.request_status='8' and expense.expense_status ='Approved'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_total_requests() {

        $sql = "select travel_request.*,
                expense.policy_meet,
                expense.total_claim,
                expense.expense_status,
                expense.less_advance,
                expense.recevied_amount,
		concat(travaller.first_name, ' ', travaller.last_name) as travallername,
		concat(boss.first_name, ' ', boss.last_name) as bossName,
		basicDetail.phone as travallerMobile,
		basicDetail.grade_id as GradeId,
		grades.grade_name as gradeName,
		travel_reasons.reason as reasonOfJourney,
		travel_category.name as journeyClass,
		fromCity.name as from_city_name,
		toCity.name as to_city_name from travel_request
		left join users travaller on travel_request.employee_id= travaller.employee_id
		left join employees basicDetail on travel_request.employee_id= basicDetail.id
		left join grades on basicDetail.grade_id= grades.id
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join expense on expense.request_id = travel_request.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and expense.expense_status != 'Rejected' and travel_request.approval_status='Approved' and travel_request.request_status >= '6' limit 100";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_pending_requests() {

        $sql = "select travel_request.*,
            expense.total_claim,
                expense.less_advance,
                expense.recevied_amount,
		concat(travaller.first_name, ' ', travaller.last_name) as travallername,
		concat(boss.first_name, ' ', boss.last_name) as bossName,
		basicDetail.phone as travallerMobile,
		basicDetail.grade_id as GradeId,
		grades.grade_name as gradeName,
		travel_reasons.reason as reasonOfJourney,
		travel_category.name as journeyClass,
		fromCity.name as from_city_name,
		toCity.name as to_city_name from travel_request
		left join users travaller on travel_request.employee_id= travaller.employee_id
		left join employees basicDetail on travel_request.employee_id= basicDetail.id
		left join grades on basicDetail.grade_id= grades.id
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join expense on expense.request_id = travel_request.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and travel_request.approval_status='Approved' and travel_request.request_status='5'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_approved_requests() {

        $sql = "select travel_request.*,
            expense.total_claim,
                expense.less_advance,
                expense.recevied_amount,
		concat(travaller.first_name, ' ', travaller.last_name) as travallername,
		concat(boss.first_name, ' ', boss.last_name) as bossName,
		basicDetail.phone as travallerMobile,
		basicDetail.grade_id as GradeId,
		grades.grade_name as gradeName,
		travel_reasons.reason as reasonOfJourney,
		travel_category.name as journeyClass,
		fromCity.name as from_city_name,
		toCity.name as to_city_name from travel_request
		left join users travaller on travel_request.employee_id= travaller.employee_id
		left join employees basicDetail on travel_request.employee_id= basicDetail.id
		left join grades on basicDetail.grade_id= grades.id
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join expense on expense.request_id = travel_request.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and travel_request.approval_status='Approved' and travel_request.request_status='7'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

}
