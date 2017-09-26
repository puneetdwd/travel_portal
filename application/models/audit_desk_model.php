<?php

class Audit_desk_model extends CI_Model {

    public function get_travel_requests() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
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
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and travel_request.approval_status='Approved' and travel_request.request_status='8' and expense.expense_status ='Approved'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_total_requests() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
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
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and expense.expense_status != 'Rejected' and travel_request.approval_status='Approved' and (travel_request.request_status='7' or travel_request.request_status='8')";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_total_requests() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
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
		left join indian_cities toCity on travel_request.to_city_id = toCity.id  where travel_request.status='active' and expense.expense_status != 'Rejected' and travel_request.approval_status='Approved' and (travel_request.request_status >= '7') limit 100";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_pending_requests() {

        $sql = "select basicDetail.employee_id as emp_id,travel_request.*,
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
