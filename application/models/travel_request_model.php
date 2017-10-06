<?php

class Travel_request_model extends CI_Model {

    function generate_reference_id() {
        $this->db->select('reference_id');
        $this->db->order_by('id', 'desc');
        $this->db->where('reference_id != ', '');
        $record = $this->db->get('travel_request');

        $code = 0;
        if ($record->num_rows() > 0) {
            $record = $record->row_array();
            $code = $record['reference_id'];
        }
        if (empty($code)) {
            return 'TR/' . str_pad(1, 4, '0', STR_PAD_LEFT);
        }

        $new_code = (int) str_replace('TR/', '', $code) + 1;
        return 'TR/' . str_pad($new_code, 4, '0', STR_PAD_LEFT);
    }

	public function get_active_city() {

        $sql = "SELECT t.*,c.name as cost_center,s.state_name from indian_cities t "
                . "LEFT JOIN indian_cities c ON c.id = t.cost_center_id "
                . "LEFT JOIN state_list s ON s.id = t.state_id "
                . "WHERE t.status = 'active' order by name ASC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_request($employee_id = '', $cancel_status = '') {

        $sql = "SELECT b.id as booking_req_id,p.name as project_name,b.*,x.*,travel_request.*,b.bookbyself,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request "
                . "LEFT JOIN travel_booking b ON b.request_id = travel_request.id "
                . "LEFT JOIN indian_cities f ON f.id = travel_request.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = travel_request.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = travel_request.travel_reason_id "
                . "LEFT JOIN projects p ON p.id = travel_request.project_id "
                . "LEFT JOIN expense x ON x.request_id = travel_request.id "
                . "LEFT JOIN users u ON u.employee_id = travel_request.reporting_manager_id "
                . "LEFT JOIN travel_category c ON c.id = travel_request.travel_class_id WHERE ";

        if ($employee_id != '') {
            $sql .= " travel_request.employee_id =" . $employee_id . " ";
        }

        if ($cancel_status != '') {
            $sql .= "and (travel_request.status = 'active' or travel_request.status = 'cancel')";
        } else {
            $sql .= "and travel_request.status = 'active'";
        }
        $sql .= " ORDER BY travel_request.id desc";
//        $sql .= " GROUP BY travel_request.id";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_my_employee_request($employee_id = '', $cancel_status = '') {

        $sql = "SELECT CONCAT(uu.first_name,' ',uu.last_name) as employee_name,p.name as project_name,b.*,x.*,travel_request.*,b.bookbyself,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request "
                . "LEFT JOIN travel_booking b ON b.request_id = travel_request.id "
                . "LEFT JOIN indian_cities f ON f.id = travel_request.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = travel_request.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = travel_request.travel_reason_id "
                . "LEFT JOIN projects p ON p.id = travel_request.project_id "
                . "LEFT JOIN expense x ON x.request_id = travel_request.id "
                . "LEFT JOIN users u ON u.employee_id = travel_request.reporting_manager_id "
                . "LEFT JOIN employees ee ON ee.employee_id = travel_request.employee_id "
                . "LEFT JOIN users uu ON uu.employee_id = ee.employee_id "
                . "LEFT JOIN travel_category c ON c.id = travel_request.travel_class_id WHERE ";

        if ($employee_id != '') {
            $sql .= " ee.ea_manager_id =" . $employee_id . " ";
        }

        if ($cancel_status != '') {
            $sql .= "and (travel_request.status = 'active' or travel_request.status = 'cancel')";
        } else {
            $sql .= "and travel_request.status = 'active'";
        }
//        $sql .= " GROUP BY travel_request.id";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_last_few_request_by_empid($employee_id = '', $request_id = '') {

        $sql = "SELECT t.*,b.bookbyself,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . " WHERE t.status = 'active'";

        if ($request_id != '') {
            $sql .= "and t.id !=" . $request_id . " ";
        }
        if ($employee_id != '') {
            $sql .= "and t.employee_id =" . $employee_id . " ORDER BY id desc limit 5";
        }

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_draft_request($employee_id = '') {

        $sql = "SELECT t.*,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . " WHERE t.status = 'draft' ";

        if ($employee_id != '') {
            $sql .= "and t.employee_id =" . $employee_id;
        }

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function delete_request($req_id) {
        if (!empty($req_id)) {
            $this->db->where('id', $req_id);
            $this->db->delete('travel_request');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }

    public function delete_all_request($employee_id) {
        if (!empty($employee_id)) {
            $this->db->where('employee_id', $employee_id);
            $this->db->where('status', 'draft');
            $this->db->delete('travel_request');

            if ($this->db->affected_rows() > 0) {
                return True;
            }
        } else {
            return False;
        }
    }

    public function get_request_id($id, $data = '*') {
        $sql = "SELECT " . $data . " from travel_request WHERE id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_all_flight_request($employee_id = '') {

        $sql = "SELECT t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . " WHERE t.travel_type = '1' and t.status = 'active' ";

        if ($employee_id != '') {
            $sql .= "and employee_id =" . $employee_id;
        }


        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_request_by_id($request_id, $cancel_status = '') {

        $sql = "SELECT u.email,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " ";
        if ($cancel_status != '') {
            $sql .= "WHERE t.status != 'inactive' and t.status != 'draft' ";
        } else {
            $sql .= "WHERE t.status = 'active'";
        }

        $sql .= "and t.id = ?";

        $result = $this->db->query($sql, array($request_id));

        return $result->row_array();
    }

    public function get_emp_request_by_id($request_id, $employee_id) {

        $sql = "SELECT u.email,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " ";

        $sql .= "WHERE t.id = ? and t.employee_id = ?";

        $result = $this->db->query($sql, array($request_id, $employee_id));

        return $result->row_array();
    }

    public function get_emp_request_by_ea_id($request_id, $employee_id) {

        $sql = "SELECT u.email,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " ";

        $sql .= "WHERE t.id = ? and e.ea_manager_id = ?";

        $result = $this->db->query($sql, array($request_id, $employee_id));

        return $result->row_array();
    }

    public function get_manager_request_by_id($request_id, $manager_id) {

        $sql = "SELECT u.email,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " ";
        $sql .= " WHERE t.id = ? and t.reporting_manager_id = ? ";

        $result = $this->db->query($sql, array($request_id, $manager_id));

        return $result->row_array();
    }

    public function get_request_details_by_id($request_id) {

//        $sql = "SELECT ,c.name as travel_class,tp.amount from travel_request t "
        $sql = "SELECT t.from_city_id,g.grade_name as grade,c.name as travel_class,e.ea_manager_id,e.phone as mobile,e.gender,TIMESTAMPDIFF(YEAR, e.dob, CURDATE()) AS age,t.departure_date,"
                . "t.return_date,t.trip_type,t.travel_type,t.reference_id,CONCAT(u.first_name,' ',u.last_name) as employee_name,"
                . "CONCAT(uu.first_name,' ',uu.last_name) as manager_name,uu.email as manager_email,uuu.NAME_DISPLAY as ea_name,uuu.email as ea_email,u.email as employee_email,f.name as from_city_name,"
                . "d.name as to_city_name,r.reason,t.hotel_allowance,t.da_allowance,convince_allowance from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN grades g ON g.id = e.grade_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
				. "LEFT JOIN users uuu ON uuu.employee_id  = e.ea_manager_id "
				//. "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id ";
                . "";
        $sql .= "WHERE t.status = 'active'";
        $sql .= "and t.id = ?";

        $result = $this->db->query($sql, array($request_id));

        return $result->row_array();
    }

    public function get_all_member_list_by_id($request_id) {
        $sql = "SELECT t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,e.phone as mobile,e.email,e.dob,TIMESTAMPDIFF(YEAR, e.dob, CURDATE()) AS age from travel_request_member t "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN employees e ON e.employee_id = u.employee_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_all_member_other_list_by_id($request_id) {
        $sql = "SELECT t.* from travel_request_member_others t "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_travel_class_by_grade($grade_id, $service_type) {
        $sql = "SELECT t.travel_class,c.name from grades t "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class "
                . " WHERE t.id = ? and t.travel_mode = ? and t.status = 'active'";
        $result = $this->db->query($sql, array($grade_id, $service_type));
        return $result->row_array();
    }

    public function get_hotel_booking($request_id) {
        $sql = "SELECT t.*,f.name as from_city_name,s.name as hotel_provider_name,c.name as expense_location  from hotel_booking t "
                . "LEFT JOIN indian_cities f ON f.id = t.city_id "
                . "LEFT JOIN travel_category s ON s.id = t.hotel_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_car_booking($request_id) {
        $sql = "SELECT t.*,f.name as car_category_name,c.name as expense_location from car_booking t "
                . "LEFT JOIN travel_category f ON f.id = t.car_category_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_flight_ticket_booking($request_id) {
        $sql = "SELECT t.*,s.name as flight_provider_name from flight_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.flight_provider_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_train_ticket_booking($request_id) {
        $sql = "SELECT t.*,s.name as train_provider_name from train_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.train_provider_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_car_ticket_booking($request_id) {
        $sql = "SELECT t.*,s.name as car_provider_name from car_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.car_provider_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_bus_ticket_booking($request_id) {
        $sql = "SELECT t.*,s.name as bus_provider_name from bus_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.bus_provider_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_all_request_for_manager($employee_id) {

        $sql = "SELECT t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.reporting_manager_id=" . $employee_id;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_pending_request_for_manager($employee_id) {

        $sql = "SELECT t.id,r.reason,t.*,e.employee_id as emp_id,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.request_status ='1' and t.reporting_manager_id=" . $employee_id . " ";
//                . " WHERE t.status = 'active' and t.request_status ='1' and t.reporting_manager_id=" . $employee_id . " GROUP BY t.id";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_cancallation_pending_request_for_manager($employee_id) {

        $sql = "SELECT t.*,e.employee_id as emp_id,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.approval_status ='Approved' and t.reporting_manager_id=" . $employee_id . " and (cancel_status = '2' or cancel_status = '3'  or cancel_status = '6')";
//                . " WHERE t.status = 'active' and t.approval_status ='Approved' and t.reporting_manager_id=" . $employee_id . " and cancel_status = '2' or cancel_status = '3' GROUP BY t.id";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_completed_request_for_manager($employee_id) {

        $sql = "SELECT g.grade_name,t.*,e.employee_id as emp_id,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN grades g ON g.id = e.grade_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.request_status !='1' and t.reporting_manager_id=" . $employee_id;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_expense_pending_for_manager($employee_id) {

        $sql = "SELECT x.*,e.employee_id as emp_id,t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN expense x ON x.request_id = t.id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and merge_expense != '1' and x.expense_status = 'Pending' and t.request_status ='5' and t.reporting_manager_id=" . $employee_id . " ";
//                . " WHERE t.status = 'active' and x.expense_status = 'Pending' and t.request_status ='5' and t.reporting_manager_id=" . $employee_id . " GROUP BY t.id";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_total_count_request($employee_id) {
        $sql = "SELECT count(id) as total_request from travel_request t "
                . " WHERE t.status = 'active' and t.employee_id=" . $employee_id;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_approved_count_request($employee_id) {
        $sql = "SELECT count(id) as approved_request from travel_request t "
                . " WHERE t.status = 'active' and request_status >= '2' and approval_status = 'Approved' and t.employee_id=" . $employee_id;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_pending_count_request($employee_id) {
        $sql = "SELECT count(id) as pending_request from travel_request t "
                . " WHERE t.status = 'active' and request_status = '1' and t.employee_id=" . $employee_id;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_pending_expense_count_request($employee_id) {
        $sql = "SELECT count(id) as pending_request from travel_request t "
                . " WHERE t.status = 'active' and request_status = '5' and t.employee_id=" . $employee_id;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_expense_count_request($employee_id) {
        $sql = "SELECT count(id) as approved_request from travel_request t "
                . " WHERE t.status = 'active' and request_status >= '6' and t.employee_id=" . $employee_id;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_employee_manager_id($employee_id) {
        $sql = "SELECT t.reporting_manager_id from employees t "
                . " WHERE t.status = 'active' and t.id =" . $employee_id;
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    public function get_last_few_request($employee_id) {
        $sql = "SELECT t.trip_type,t.id,t.departure_date,t.return_date,t.travel_type,t.cancel_status,t.approval_status,t.request_status,t.reference_id,f.name as from_city_name,d.name as to_city_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . " WHERE t.status = 'active' and t.employee_id=" . $employee_id . " ORDER BY t.id DESC LIMIT 4";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_last_few_task($employee_id) {
        $sql = "SELECT t.trip_type,t.id,t.approval_status,t.request_status,f.name as from_city_name,d.name as to_city_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . " WHERE t.status = 'active' and request_status > '2' and t.employee_id=" . $employee_id . " ORDER BY t.id DESC LIMIT 4";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_last_few_expense_request($employee_id) {
//$sql = "SELECT * from travel_request t "
//. " WHERE t.status = 'active' and request_status >= '5' and t.employee_id=" . $employee_id." order by request_status asc";

        $sql = "SELECT t.trip_type,t.id,t.departure_date,t.return_date,t.approval_status,t.request_status,t.reference_id,f.name as from_city_name,d.name as to_city_name,t.travel_type from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . " WHERE t.status = 'active' and request_status >= '5' and t.employee_id=" . $employee_id . " ORDER BY request_status ASC LIMIT 4";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_employee_manager_base_id($employee_id) {
        $sql = "SELECT f.reporting_manager_id from employees t "
                . "LEFT JOIN employees f ON f.id = t.reporting_manager_id "
                . " WHERE t.status = 'active' and t.id =" . $employee_id;
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    public function get_travel_request_combination($employee_id, $travel_type, $departure_date, $return_date, $travel_reason_id, $travel_class_id, $from_city_id, $to_city_id, $comment) {
        $sql = "SELECT id from travel_request WHERE employee_id = ? and travel_type = ? and departure_date = ? and return_date = ? and travel_reason_id = ? and travel_class_id = ? and from_city_id = ? and to_city_id = ? and comment = ?";
        $result = $this->db->query($sql, array($employee_id, $travel_type, $departure_date, $return_date, $travel_reason_id, $travel_class_id, $from_city_id, $to_city_id, $comment));

        return $result->row_array();
    }

    public function update_travel_request($data, $request_number) {
        if (!empty($request_number)) {
            if ($data['approval_level'] == 0) {
                $needed_array = array('employee_id', 'reference_id', 'group_travel', 'trip_type', 'project_id', 'status', 'travel_type', 'return_travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
            } else {
                $needed_array = array('employee_id', 'reference_id', 'group_travel', 'trip_type', 'project_id', 'status', 'travel_type', 'return_travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
            }
            $data = array_intersect_key($data, array_flip($needed_array));
            $this->db->where('request_number', $request_number);
            $result = $this->db->update('travel_request', $data);
            if ($result) {
                return $request_number;
            } else {
                return FALSE;
            }
        } else {
            if ($data['approval_level'] == 0) {
                $needed_array = array('employee_id', 'request_number', 'group_travel', 'trip_type', 'reference_id', 'project_id', 'status', 'travel_type', 'return_travel_type','departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
            } else {
                $needed_array = array('employee_id', 'request_number', 'group_travel', 'trip_type', 'reference_id', 'project_id', 'status', 'travel_type', 'return_travel_type','departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
            }
            $data = array_intersect_key($data, array_flip($needed_array));
            $result = $this->db->insert('travel_request', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function update_travel_request_to_draft($data, $request_number) {
        if (!empty($request_number)) {
            if ($data['approval_level'] == 0) {
                $needed_array = array('employee_id', 'status', 'travel_type', 'return_travel_type', 'project_id', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status');
            } else {
                $needed_array = array('employee_id', 'status', 'travel_type', 'return_travel_type', 'project_id', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment');
            }
            $data = array_intersect_key($data, array_flip($needed_array));
            $this->db->where('request_number', $request_number);
            $result = $this->db->update('travel_request', $data);
            if ($result) {
                return $request_number;
            } else {
                return FALSE;
            }
        } else {
            if ($data['approval_level'] == 0) {
                $needed_array = array('employee_id', 'status', 'request_number', 'travel_type', 'return_travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status');
            } else {
                $needed_array = array('employee_id', 'status', 'request_number', 'travel_type', 'return_travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment');
            }
            $data = array_intersect_key($data, array_flip($needed_array));
            $result = $this->db->insert('travel_request', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function get_travel_request_combination_draft($request_number) {
        $sql = "SELECT id,status from travel_request WHERE request_number = ?";
        $result = $this->db->query($sql, array($request_number));

        return $result->row_array();
    }

    public function update_travel_booking($data, $travel_booking_id = '') {
        $needed_array = array('request_id', 'travel_ticket', 'return_travel_ticket','accommodation', 'car_hire', 'bookbyself', 'bookbymanager');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($travel_booking_id)) {
            $this->db->where('id', $travel_booking_id);
            $result = $this->db->update('travel_booking', $data);
            if ($result) {
                return $travel_booking_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_booking', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function update_travel_request_status($data, $request_id) {
        $needed_array = array('request_status');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($request_id)) {
            $this->db->where('id', $request_id);
            $result = $this->db->update('travel_request', $data);
            if ($result) {
                return $request_id;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_cost_center_by_city_id($id) {
        $sql = "SELECT cost_center_id from indian_cities WHERE id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_state_id_by_city_id($id) {
        $sql = "SELECT state_id from indian_cities WHERE id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_travel_manager_email_from_id($cost_center_id) {

        $sql = "SELECT u.email FROM employees e
        
        INNER JOIN users u ON u.employee_id = e.employee_id 
        INNER JOIN employees_role r ON r.employees_id = e.employee_id 
        
        WHERE e.status='active' and r.roles_id='2'
        AND e.cost_center_id = ?";


        $result = $this->db->query($sql, array($cost_center_id));
        return $result->result_array();
    }

    public function delete_request_other_member($req_id) {
        if (!empty($req_id)) {
            $this->db->where('request_id', $req_id);
            $this->db->delete('travel_request_member');
            $this->db->where('request_id', $req_id);
            $this->db->delete('travel_request_member_others');
        }
    }

    public function get_all_other_expences_data($TableName) {
        $sql = "select id,expense_name from " . $TableName . " where status='active';";
        $result = $this->db->query($sql);
        return $result->result_array();
    } 
    
    public function get_all_merge_expense_pending_for_manager($employee_id) {
        $sql = "SELECT t.*,e.employee_id as emp_id,CONCAT(u.first_name,' ',u.last_name) as requested_name from merge_expense t "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . " WHERE t.status = 'active' and t.expense_status = 'Pending' and t.request_status ='5' and t.reporting_manager_id=" . $employee_id . " ";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
}
