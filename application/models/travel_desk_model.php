<?php

class Travel_desk_model extends CI_Model {

    public function get_all_travel_requestSNT($cost_center_id) {

        $sql = "select p.name as project_name,b.*,travel_request.*,
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
                
                LEFT JOIN travel_booking b ON b.request_id = travel_request.id
		
                LEFT JOIN projects p ON p.id = travel_request.project_id
                
		left join users boss on travel_request.reporting_manager_id= boss.employee_id
		left join travel_reasons on travel_request.travel_reason_id = travel_reasons.id
		left join travel_category on travel_request.travel_class_id = travel_category.id
		left join indian_cities fromCity on travel_request.from_city_id = fromCity.id
		left join indian_cities toCity on travel_request.to_city_id = toCity.id where travel_request.status='active' and travel_request.approval_status='Approved' and request_status >= '3' and (fromCity.cost_center_id = ? or toCity.cost_center_id = ?) order by request_status asc limit 100";
        $result = $this->db->query($sql, array($cost_center_id, $cost_center_id));
        return $result->result_array();
    }

    public function get_all_travel_request($cost_center_id) {
        //$sql = "SELECT p.name as project_name,ee.phone as mobile,ee.employee_id as emp_id,uu.first_name,uu.last_name,b.*,t.*,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
        //        . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
        //        . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
        //        . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
        //        . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
        //        . "LEFT JOIN projects p ON p.id = t.project_id "
        //        . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
        //        . "LEFT JOIN travel_booking b ON b.request_id = t.id "
        //        . "LEFT JOIN users uu ON uu.employee_id = t.employee_id "
        //        . "LEFT JOIN employees ee ON ee.id = t.employee_id "
        //        . " WHERE t.status = 'active' and request_status = '3' and b.bookbymanager = '1' and (f.cost_center_id = ? or d.cost_center_id = ?)";
        
		$sql = "SELECT p.name as project_name,ee.phone as mobile,ee.employee_id as emp_id,uu.first_name,uu.last_name,b.*,t.*,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN projects p ON p.id = t.project_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN users uu ON uu.employee_id = t.employee_id "
                . "LEFT JOIN employees ee ON ee.id = t.employee_id "
                . " WHERE t.status = 'active' and request_status = '3' and (f.cost_center_id = ? or d.cost_center_id = ?)";
		
		
		$result = $this->db->query($sql, array($cost_center_id, $cost_center_id));
        return $result->result_array();
    }

    public function get_all_refund_request($cost_center_id) {

        $sql = "SELECT ee.phone as mobile,ee.employee_id as emp_id,uu.first_name,uu.last_name,b.*,t.*,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN users uu ON uu.employee_id = t.employee_id "
                . "LEFT JOIN employees ee ON ee.id = t.employee_id "
                . " WHERE t.status = 'active' and (t.cancel_status = '4' or t.cancel_status = '5') and (f.cost_center_id = ? or d.cost_center_id = ?)";
        $result = $this->db->query($sql, array($cost_center_id, $cost_center_id));
        return $result->result_array();
    }

    public function get_travel_request_by_id($request_id) {

        $sql = "SELECT e.email,t.*,CONCAT(e.first_name,' ',e.last_name) as employee_name,b.*,c.name as travel_class,f.name as from_city_name,d.name as to_city_name from travel_request t "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN users e ON e.employee_id = t.employee_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . " WHERE t.id = " . $request_id . " and t.status = 'active'";

        $result = $this->db->query($sql);

        return $result->row_array();
    }

    public function get_service_proviers($service_type) {
        $sql = "SELECT * from service_proviers WHERE service_type=?";
        $result = $this->db->query($sql, array($service_type));

        return $result->result_array();
    }

    function get_hotel_category_by_location($city, $type = '') {
        if ($type == '') {
            $sql = "SELECT * FROM travel_category t WHERE t.city_id = ? and travel_type = '5' and status='active'";
            $result = $this->db->query($sql, array($city));
        } else {
            $sql = "SELECT * FROM travel_category t WHERE t.city_id = ?  and type = ? and travel_type = '5' and status='active'";
            $result = $this->db->query($sql, array($city, $type));
        }
        return $result->result_array();
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

        $sql = "SELECT t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.request_status ='1' and t.reporting_manager_id=" . $employee_id;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_completed_request_for_manager($employee_id) {

        $sql = "SELECT t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.request_status !='1' and t.reporting_manager_id=" . $employee_id;

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
                . " WHERE t.status = 'active' and request_status = '2' and approval_status = 'Approved' and t.employee_id=" . $employee_id;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_pending_count_request($employee_id) {
        $sql = "SELECT count(id) as pending_request from travel_request t "
                . " WHERE t.status = 'active' and request_status = '1' and t.employee_id=" . $employee_id;
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
        $sql = "SELECT t.id,t.approval_status,t.request_status,f.name as from_city_name,d.name as to_city_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . " WHERE t.status = 'active' and request_status <= '2' and t.employee_id=" . $employee_id . " ORDER BY t.id DESC LIMIT 3";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_last_few_task($employee_id) {
        $sql = "SELECT t.id,t.approval_status,t.request_status,f.name as from_city_name,d.name as to_city_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . " WHERE t.status = 'active' and request_status > '2' and t.employee_id=" . $employee_id . " ORDER BY t.id DESC LIMIT 3";
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

    public function update_travel_request($data, $travel_request_id) {
        if ($data['approval_level'] == 0) {
            $needed_array = array('employee_id', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status');
        } else {
            $needed_array = array('employee_id', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment');
        }
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($travel_request_id)) {
            $this->db->where('id', $travel_request_id);
            $result = $this->db->update('travel_request', $data);
            if ($result) {
                return $travel_request_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_request', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function get_flight_ticket_booking($request_id, $trip_mode = '') {
        $sql = "SELECT t.*,s.name as flight_provider_name,c.name as expense_location from flight_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.flight_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.request_id = ?";
        if ($trip_mode != '') {
            $sql .= " and t.trip_mode = " . $trip_mode;
        }
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_train_ticket_booking($request_id, $trip_mode = '') {
        $sql = "SELECT t.*,s.name as train_provider_name,c.name as expense_location from train_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.train_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.request_id = ?";
        if ($trip_mode != '') {
            $sql .= " and t.trip_mode = " . $trip_mode;
        }
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_car_ticket_booking($request_id, $trip_mode = '') {
        $sql = "SELECT t.*,s.name as car_provider_name,c.name as expense_location from car_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.car_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.request_id = ?";
        if ($trip_mode != '') {
            $sql .= " and t.trip_mode = " . $trip_mode;
        }
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_bus_ticket_booking($request_id, $trip_mode = '') {
        $sql = "SELECT t.*,s.name as bus_provider_name,c.name as expense_location from bus_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.bus_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.request_id = ?";
        if ($trip_mode != '') {
            $sql .= " and t.trip_mode = " . $trip_mode;
        }
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    /* ---  Return --- */

    public function get_flight_ticket_booking_return($request_id) {
        $sql = "SELECT t.*,s.name as flight_provider_name,c.name as expense_location from flight_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.flight_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.trip_mode !='1' and t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_train_ticket_booking_return($request_id) {
        $sql = "SELECT t.*,s.name as train_provider_name,c.name as expense_location from train_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.train_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.trip_mode !='1' and t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_car_ticket_booking_return($request_id) {
        $sql = "SELECT t.*,s.name as car_provider_name,c.name as expense_location from car_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.car_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.trip_mode !='1' and t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    public function get_bus_ticket_booking_return($request_id) {
        $sql = "SELECT t.*,s.name as bus_provider_name,c.name as expense_location from bus_ticket_booking t "
                . "LEFT JOIN service_proviers s ON s.id = t.bus_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.booking_city_id "
                . " WHERE t.trip_mode !='1' and t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->result_array();
    }

    /* ---  Return --- */

    public function get_travel_category_id($id) {
        $sql = "SELECT * from travel_category WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_cost_centre_id_by_emp($emp_id) {
        $sql = "SELECT cost_center_id from employees WHERE employee_id = ?";
        $result = $this->db->query($sql, array($emp_id));
        return $result->row_array();
    }

}
