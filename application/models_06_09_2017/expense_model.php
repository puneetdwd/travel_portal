<?php

class Expense_model extends CI_Model {

    public function get_all_request($employee_id = '') {

        $sql = "SELECT t.*,e.expense_status,b.bookbyself,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN expense e ON e.request_id = t.id "
                . " WHERE t.status = 'active' and request_status >= '4'";

        if ($employee_id != '') {
            $sql .= "and t.employee_id =" . $employee_id;
        }
        $sql .= " GROUP BY t.id";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_request_by_id($request_id, $cancel_status = '') {

        $sql = "SELECT b.*,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_booking b ON b.request_id  = t.id "
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

    public function get_claim_request_by_id($request_id, $employee_id) {

        $sql = "SELECT b.*,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_booking b ON b.request_id  = t.id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " ";

        $sql .= "WHERE t.id = ? and t.employee_id = ?";

        $result = $this->db->query($sql, array($request_id,$employee_id));

        return $result->row_array();
    }

    public function get_expense_pending_request_by_id($request_id, $employee_id) {

        $sql = "SELECT b.*,t.*,CONCAT(u.first_name,' ',u.last_name) as employee_name,CONCAT(uu.first_name,' ',uu.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id  = e.id "
                . "LEFT JOIN users uu ON uu.employee_id  = t.reporting_manager_id "
                . "LEFT JOIN travel_booking b ON b.request_id  = t.id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " ";

        $sql .= "WHERE t.id = ? and e.reporting_manager_id = ?";

        $result = $this->db->query($sql, array($request_id, $employee_id));

        return $result->row_array();
    }

    public function get_expense_pending($id) {
        $sql = "SELECT * from expense WHERE request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_other_attachment($id) {
        $sql = "SELECT * from expense_attachment WHERE request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_other_expense($id) {
        $sql = "SELECT * from other_expense WHERE request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_travel_class_by_grade($grade_id, $service_type) {
        $sql = "SELECT t.travel_class from grades t "
                . " WHERE t.id = ? and t.travel_mode = ? and t.status = 'active'";
        $result = $this->db->query($sql, array($grade_id, $service_type));
        return $result->row_array();
    }

    public function get_hotel_booking($request_id) {
        $sql = "SELECT t.*,f.name as from_city_name,s.name as hotel_provider_name from hotel_booking t "
                . "LEFT JOIN indian_cities f ON f.id = t.city_id "
                . "LEFT JOIN service_proviers s ON s.id = t.hotel_provider_id "
                . " WHERE t.request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

    public function get_car_booking($request_id) {
        $sql = "SELECT t.*,f.name as car_category_name from car_booking t "
                . "LEFT JOIN travel_category f ON f.id = t.car_category_id "
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

        $sql = "SELECT t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.request_status ='1' and t.reporting_manager_id=" . $employee_id . " GROUP BY t.id";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_all_cancallation_pending_request_for_manager($employee_id) {

        $sql = "SELECT t.*,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class,tp.amount,CONCAT(u.first_name,' ',u.last_name) as requested_name from travel_request t "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "LEFT JOIN employees e ON e.id = t.employee_id "
                . "LEFT JOIN users u ON u.employee_id = t.employee_id "
                . "LEFT JOIN travel_policy tp ON tp.service_type = t.travel_type and tp.grade_id = e.grade_id "
                . " WHERE t.status = 'active' and t.approval_status ='Approved' and cancel_status = '2' and t.reporting_manager_id=" . $employee_id . " GROUP BY t.id";

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

    public function update_travel_request($data, $request_number) {
        if (!empty($request_number)) {
            if ($data['approval_level'] == 0) {
                $needed_array = array('employee_id', 'reference_id', 'status', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
            } else {
                $needed_array = array('employee_id', 'reference_id', 'status', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
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
                $needed_array = array('employee_id', 'request_number', 'reference_id', 'status', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
            } else {
                $needed_array = array('employee_id', 'request_number', 'reference_id', 'status', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'hotel_allowance', 'hotel_allowance_actual', 'DA_allowance', 'DA_allowance_actual', 'convince_allowance', 'convince_allowance_actual');
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
                $needed_array = array('employee_id', 'status', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status');
            } else {
                $needed_array = array('employee_id', 'status', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment');
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
                $needed_array = array('employee_id', 'status', 'request_number', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment', 'approval_status', 'request_status');
            } else {
                $needed_array = array('employee_id', 'status', 'request_number', 'travel_type', 'departure_date', 'return_date', 'request_date', 'approval_level', 'reporting_manager_id', 'travel_reason_id', 'travel_class_id', 'from_city_id', 'to_city_id', 'comment');
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
        $sql = "SELECT id from travel_request WHERE request_number = ?";
        $result = $this->db->query($sql, array($request_number));

        return $result->row_array();
    }

    public function get_other_trip_expense($id) {
        $sql = "SELECT * from other_trip_booking WHERE request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_other_loading_booking($id) {
        $sql = "SELECT * from other_loading_booking WHERE request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_other_con_booking($id) {
        $sql = "SELECT * from other_con_booking WHERE request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_other_manager_expense($id) {
        $sql = "SELECT other_manager_expense.*,c.name as expense_location from other_manager_expense "                
                . "LEFT JOIN indian_cities c ON c.id = other_manager_expense.booking_city_id "
                . " WHERE other_manager_expense.request_id=?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

}
