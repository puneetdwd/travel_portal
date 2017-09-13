<?php

class report_model extends CI_Model {

    public function get_all_request($employee_id = '', $cancel_status = '') {

        $sql = "SELECT x.*,t.*,b.bookbyself,CONCAT(uu.first_name,' ',uu.last_name) as employee_name,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN expense x ON x.request_id = t.id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN users uu ON uu.employee_id = t.employee_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id "
                . "WHERE t.status != 'draft'";


        if (!empty($employee_id)) {
            $sql .= " and t.employee_id ='" . $employee_id . "' ";
        }

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_admin_report($grade_id = '', $cost_center_id = '', $city_id = '', $state_id = '', $travel_mode = '', $dept_id = '', $start_date = '', $end_date = '') {

        $sql = "SELECT x.*,t.*,b.bookbyself,CONCAT(uu.first_name,' ',uu.last_name) as employee_name,CONCAT(u.first_name,' ',u.last_name) as reporting_manager_name,f.name as from_city_name,d.name as to_city_name,r.reason,c.name as travel_class from travel_request t "
                . "LEFT JOIN travel_booking b ON b.request_id = t.id "
                . "LEFT JOIN indian_cities f ON f.id = t.from_city_id "
                . "LEFT JOIN indian_cities d ON d.id = t.to_city_id "
                . "LEFT JOIN travel_reasons r ON r.id = t.travel_reason_id "
                . "LEFT JOIN expense x ON x.request_id = t.id "
                . "LEFT JOIN users u ON u.employee_id = t.reporting_manager_id "
                . "LEFT JOIN users uu ON uu.employee_id = t.employee_id "
                . "LEFT JOIN employees e ON e.employee_id = uu.employee_id "
                . "LEFT JOIN travel_category c ON c.id = t.travel_class_id ";

        if ($state_id != '' && $state_id != '0') {
            $sql .= "LEFT JOIN indian_cities cc ON cc.id = e.city_id ";
            $sql .= "LEFT JOIN state_list s ON s.id = cc.state_id ";
        }
        
		if ($city_id != '' && $city_id != '0') {
            
			//$sql .= "LEFT JOIN indian_cities cc ON cc.id = ".$city_id." ";
			
			//$sql .= "LEFT JOIN indian_cities cc ON cc.id = e.city_id ";
        }
		
		$sql .= "WHERE t.status = 'active'";


        if ($grade_id != '' && $grade_id != '0') {
            $sql .= " and e.grade_id ='" . $grade_id . "' ";
        }

        if ($state_id != '' && $state_id != '0') {
            $sql .= " and s.id ='" . $state_id . "' ";
        }

		if ($city_id != '' && $city_id != '0') {
            
			$sql .= " and ( f.id ='" . $city_id . "' or d.id ='" . $city_id . "' ) ";
			//$sql .= " and e.city_id ='" . $city_id . "' ";
			//$sql .= " and cc.id ='" . $city_id . "' ";
        }

        if ($cost_center_id != '' && $cost_center_id != '0') {
            $sql .= " and e.cost_center_id ='" . $cost_center_id . "' ";
        }

		if ($dept_id != '' && $dept_id != '0') {
            $sql .= " and e.dept_id ='" . $dept_id . "' ";
        }

        if ($travel_mode != '' && $travel_mode != '0') {
            $sql .= " and t.travel_type ='" . $travel_mode . "' ";
        }

        if ($start_date != '' && $start_date != '0') {
            $sql .= " and t.departure_date >='" . $start_date . "' ";
        }

        if ($end_date != '' && $end_date != '0') {
            $sql .= " and t.departure_date <='" . $end_date . "' ";
        }

		$result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_top_traveler($top_count = '5', $grade_id = '', $cost_center_id = '', $dept_id = '') {

        $sql = "SELECT travel_request.employee_id from travel_request "
                . "LEFT JOIN employees e ON e.employee_id = travel_request.employee_id "
                . "LEFT JOIN users uu ON uu.employee_id = travel_request.employee_id ";

        if ($grade_id != '' && $grade_id != '0') {
            $sql .= " WHERE e.grade_id = '" . $grade_id . "' ";
            if ($cost_center_id != '' && $cost_center_id != '0') {
                $sql .= " and e.cost_center_id = '" . $cost_center_id . "' ";
            }
        } else {
            if ($cost_center_id != '' && $cost_center_id != '0') {
                $sql .= " WHERE e.cost_center_id = '" . $cost_center_id . "' ";
            }
        }

        $sql .= " group by travel_request.employee_id order by count(travel_request.employee_id) desc limit " . $top_count . " ";


//        $sql = "select id, count(employee_id), employee_id from travel_request";
//        $sql = "SELECT travel_request.reference_id,uu.email,uu.phone as mobile,count(travel_request.employee_id) as total_trip,CONCAT(uu.first_name,' ',uu.last_name) as employee_name,travel_request.employee_id from travel_request "
        $sql = "SELECT travel_request.employee_id,count(travel_request.employee_id) as total_trip from travel_request "
                . "LEFT JOIN employees e ON e.employee_id = travel_request.employee_id "
                . "LEFT JOIN users uu ON uu.employee_id = travel_request.employee_id ";

        if ($grade_id != '' && $grade_id != '0') {
            $sql .= " WHERE e.grade_id = '" . $grade_id . "' ";
            if ($cost_center_id != '' && $cost_center_id != '0') {
                $sql .= " and e.cost_center_id = '" . $cost_center_id . "' ";
            }
            
            if ($dept_id != '' && $dept_id != '0') {
                $sql .= " and e.dept_id ='" . $dept_id . "' ";
            }
        } else {
            if ($cost_center_id != '' && $cost_center_id != '0') {
                $sql .= " WHERE e.cost_center_id = '" . $cost_center_id . "' ";
                
                if ($dept_id != '' && $dept_id != '0') {                    
                    $sql .= " and e.dept_id ='" . $dept_id . "' ";
                }
            } else {
                if ($dept_id != '' && $dept_id != '0') {                    
                    $sql .= " WHERE e.dept_id ='" . $dept_id . "' ";
                }
            }
        }

        $sql .= " group by travel_request.employee_id order by count(travel_request.employee_id) desc limit " . $top_count . " ";





        $result = $this->db->query($sql);
        return $result->result_array();
    }

    function get_employee_details($employee_id) {
        
		$sql = "SELECT u.email, u.phone as mobile, CONCAT(u.first_name,' ',u.last_name) as employee_name, u.GRADE, indian_cities.name as city_name, departments.dept_name from employees e LEFT JOIN users u ON u.employee_id = e.employee_id left join indian_cities on e.city_id=indian_cities.id left join departments on e.dept_id= departments.id";
		
		//$sql = "SELECT u.email,u.phone as mobile,CONCAT(u.first_name,' ',u.last_name) as employee_name, u.GRADE, e.dept_id, e.city_id from employees e LEFT JOIN users u ON u.employee_id = e.employee_id ";
        
		$sql .= " WHERE e.employee_id = '" . $employee_id . "' ";

        $result = $this->db->query($sql);
        return $result->row_array();
    }

    public function get_all_top_hotel_stay($top_count = '5', $city_id = '') {

//        $sql = "select id, count(hotel_provider_id), hotel_provider_id from hotel_booking t group by t.hotel_provider_id order by count(t.hotel_provider_id) desc";
//        $sql = "SELECT count(hotel_provider_id) as total_stay,e.name,e.amount,e.half_amount,e.category,c.name as city_name from hotel_booking t "
//                . "LEFT JOIN travel_category e ON e.id = t.hotel_provider_id "
//                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
//                . " WHERE e.type= '1' ";
//        if ($city_id != '' && $city_id != '0') {
//            $sql .= " and e.city_id = '" . $city_id . "' ";
//        } 
//
//        $sql .= " group by t.hotel_provider_id order by count(t.hotel_provider_id) desc limit " . $top_count . " ";

        $sql = "SELECT t.hotel_provider_id,count(hotel_provider_id) as total_stay from hotel_booking t "
                . "LEFT JOIN travel_category e ON e.id = t.hotel_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
                . " WHERE e.type= '1' ";
        if ($city_id != '' && $city_id != '0') {
            $sql .= " and e.city_id = '" . $city_id . "' ";
        }

        $sql .= " group by t.hotel_provider_id order by count(t.hotel_provider_id) desc limit " . $top_count . " ";


        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_hotel_details($hotel_provider_id) {

        $sql = "SELECT e.id, e.name, e.amount, e.half_amount, e.category, c.name as city_name from travel_category e LEFT JOIN indian_cities c ON c.id = e.city_id WHERE e.id = '" . $hotel_provider_id . "' ";

        $result = $this->db->query($sql);
        return $result->row_array();
    }

	public function get_hotelVisitorsDetail($city_id, $grade_id, $dept_id, $type, $HOT_ID)
	 {
      $sql= "select hotel_booking.hotel_provider_id, hotel_booking.request_id, hotel_booking.check_in_date, hotel_booking.check_out_date, hotel_booking.bill_no_1, travel_request.employee_id, travel_request.reference_id, users.NAME_DISPLAY, users.CITY, users.GRADE, users.email, users.PHONE1 from hotel_booking left join travel_request on hotel_booking.request_id=travel_request.id left join users on travel_request.employee_id= users.employee_id where hotel_booking.hotel_provider_id= '".$HOT_ID."'";

	  $result = $this->db->query($sql);
      return $result->row_array();
     }
	
    public function get_all_top_guest_house_stay($top_count = '5', $city_id = '') {

//        $sql = "SELECT count(hotel_provider_id) as total_stay,e.name,e.amount,e.half_amount,e.category,c.name as city_name from hotel_booking t "
//                . "LEFT JOIN travel_category e ON e.id = t.hotel_provider_id "
//                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
//                . " WHERE e.type= '2' ";
//        if ($city_id != '' && $city_id != '0') {
//            $sql .= " and e.city_id = '" . $city_id . "' ";
//        } 
//
//        $sql .= " group by t.hotel_provider_id order by count(t.hotel_provider_id) desc limit " . $top_count . " ";

        $sql = "SELECT t.hotel_provider_id,count(hotel_provider_id) as total_stay from hotel_booking t "
                . "LEFT JOIN travel_category e ON e.id = t.hotel_provider_id "
                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
                . " WHERE e.type= '2' ";
        if ($city_id != '' && $city_id != '0') {
            $sql .= " and e.city_id = '" . $city_id . "' ";
        }

        $sql .= " group by t.hotel_provider_id order by count(t.hotel_provider_id) desc limit " . $top_count . " ";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

	public function get_all_type_top_stay($top_count = '5', $city_id = '', $grade_id = '', $dept_id = '', $type = '') {

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

		if ($type != '' && $type != '0') {
            $conda[] = " e.type= '".$type."' ";
        }

        if ($city_id != '' && $city_id != '0') {
            $conda[] = " e.city_id = '" . $city_id . "' ";
            //$sql .= " where e.city_id = '" . $city_id . "' ";
        }

        if(count($conda)>0)
		 {
          $qstr = implode(' and ', $conda);
          $sql .= ' where ' . $qstr;
         }

        $sql .= " group by t.hotel_provider_id order by count(t.hotel_provider_id) desc limit " . $top_count . " ";

		//return $sql;
        $result = $this->db->query($sql);
        return $result->result_array();
    }

}
