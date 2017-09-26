<?php

class Ajax extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
    }

    function index() {
        $sql = "ALTER TABLE `travel_request` CHANGE `request_status` `request_status` ENUM('1','2','3','4','5','6','7','8','9') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;";
        $sql1 = "UPDATE `users` SET `type` = 'admin' WHERE `users`.`id` = 100;";
        $sql1 = "INSERT INTO `menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (NULL, '6', 'Inbox', 'Inbox', 'audit_desk', 'inbox', 'audit_desk/inbox', '<i class=\"fa fa-rupee\"></i>', '1', '1', NULL, NULL, NULL, NULL, NULL);";
        $sql1 = "INSERT INTO `menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (NULL, '6', 'Audit Dashboard', 'Audit Dashboard', 'audit_desk', 'index', 'audit_desk/index', '<i class=\"fa fa-rupee\"></i>', '1', '1', NULL, NULL, NULL, NULL, NULL);";
//
//        $result = $this->db->query($sql);
//        $data = $result->result_array();
//        print_r($data);
    }

    function get_travel_class_by_mode($travel_mode) {
        $sql = "SELECT i.name,i.id FROM travel_category i WHERE i.travel_type = ?
                order by name ASC";

        $result = $this->db->query($sql, array($travel_mode));
        $data = $result->result_array();
        echo json_encode($data);
    }

    function check_booking($request_id = '') {
//        $response = array();
        if ($this->input->is_ajax_request()) {
            if ($request_id != '') {
                $this->data['request_id'] = $request_id;
                $sql = "SELECT return_travel_type,travel_type,departure_date,return_date FROM travel_request WHERE travel_request.id = ?";
                $result = $this->db->query($sql, array($request_id));
                $this->data['request_data'] = $request_data = $request = $result->row_array();                
                $first_date = new DateTime($request['departure_date']);
                $second_date = new DateTime($request['return_date']);
                $interval = $first_date->diff($second_date);
                $this->data['day'] = $interval->format("%d");                

                $sql = "SELECT * FROM travel_booking WHERE travel_booking.request_id = ?";
                $result = $this->db->query($sql, array($request_id));
                $this->data['booking_data'] = $booking_data = $result->row_array();
//            po($this->data['booking_data']);
//            $response['status'] = '1';
//            $response['Cdata'] = $booking_data;
//        } else {
//            $response['status'] = '0';
//            $response['data'] = array();
//        }
//        echo json_encode($response);

//echo '<pre>'; print_r($this->data); exit;

                $this->load->view('expense/check_booking', $this->data);
//        $this->template->write_view('content', 'expense/check_booking', $this->data);
//        $this->template->render();


//echo '<pre>'; print_r($this->data); exit;

            }
        }
    }

    public function get_all_type_top_stay($top_count = '5', $city_id = '', $grade_id = '', $dept_id = '') {
        $sql = "SELECT t.hotel_provider_id, count(hotel_provider_id) as total_stay, e.type from hotel_booking t "
                . "LEFT JOIN travel_category e ON e.id = t.hotel_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
                . "LEFT JOIN travel_request tt ON tt.id = t.request_id "
                . "LEFT JOIN employees ee  ON ee.employee_id = tt.employee_id ";

        $conda = array();

        if ($grade_id != '' && $grade_id != '0') {
            $conda[] = " ee.grade_id = '" . $grade_id . "' ";
            //$sql .= " where ee.grade_id = '" . $grade_id . "' ";
        }

        if ($dept_id != '' && $dept_id != '0') {
            $conda[] = " ee.dept_id = '" . $dept_id . "' ";
            //$sql .= " where ee.dept_id = '" . $dept_id . "' ";
        }

        if ($city_id != '' && $city_id != '0') {
            $conda[] = " e.city_id = '" . $city_id . "' ";
            //$sql .= " where e.city_id = '" . $city_id . "' ";
        }

        if (count($conda) > 0) {
            $qstr = implode(' and ', $conda);
            $sql . ' where ' . $qstr;
        }

        $sql .= " group by t.hotel_provider_id order by count(t.hotel_provider_id) desc limit " . $top_count . " ";

        //return $sql;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

}
