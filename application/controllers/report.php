<?php
class Report extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
        $header_data = array(
            'page' => 'masters',
            'sub' => 'city'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("report_model");
        $this->load->model("grades_model");
        
    }

	public function index() {
        
		$grades = $this->grades_model->get_all_grades();
        $view_data = array();
        $view_data['grades'] = $grades;

        $join_str = array();
        $join_str[0] = array(
            'table' => 'indian_cities c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'indian_cities.cost_center_id',
            'join_type' => 'LEFT'
        );
        $data = 'c.id,c.name as city_name';
        $cost_center = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.cost_center_id !=' => '', 'indian_cities.status' => 'active'), $data, 'c.name', 'ASC', '', '', $join_str, 'indian_cities.cost_center_id');
        $view_data['cost_center'] = $cost_center;
        
		$city=$this->common->select_data_by_condition('indian_cities',$con_array=array('status' => 'active'), '', 'name', 'ASC');
        $view_data['cities'] = $city;
		
        $this->load->model("states_model");
        $states = $this->states_model->get_all_states();
        $view_data['states'] = $states;

        $this->load->model("department_model");
        $department_date = $this->department_model->get_all_department();
        $view_data['department'] = $department_date;
        
//        $request = $this->report_model->get_all_request();
//        $view_data['request'] = $request;
        $this->template->write_view('content', 'report/index_report', $view_data);
        $this->template->render();
    }

    public function admin_graph() {
		
		$view_data = array();
		$travel_types= array('1'=>'Flight', '2'=>'Train', '3'=>'Car', '4'=>'Bus', '5'=>'Hotel');
		$view_data['travel_types'] = $travel_types;
		$request = $this->report_model->get_admin_report();
		$typeWiseCount= array();
		foreach($request as $key=>$val)
		{
		 $typeWiseCount[$val['travel_type']][]= 1;
		}
		$view_data['typeWiseCount'] = $typeWiseCount;
		
        $this->template->write_view('content', 'report/admin_graph', $view_data);
        $this->template->render();
    }

    function get_admin_report(){
        $grade_id = $this->input->post('grade_id');
        $city_id = $this->input->post('city_id');
		$cost_center_id = $this->input->post('cost_center_id');
        $state_id = $this->input->post('state_id');
        $travel_mode = $this->input->post('travel_mode');
        $dept_id = $this->input->post('dept_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $request = $this->report_model->get_admin_report($grade_id, $cost_center_id, $city_id, $state_id, $travel_mode, $dept_id, $start_date, $end_date);
		//echo $this->db->last_query();
        $view_data = array('request' => $request);
        $this->load->view('report/get_admin_report', $view_data);
    }

    public function myreport() {
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->report_model->get_all_request($employee_id);
        
		//echo '<pre>'; print_r($request); exit;
		
		
		$view_data = array('request' => $request);
        $this->template->write_view('content', 'report/myreport', $view_data);
        $this->template->render();
    }

    public function top_traveler() {
        $grades = $this->grades_model->get_all_grades();
        $view_data = array();
        $view_data['grades'] = $grades;
        
        $this->load->model("department_model");
        $department_date = $this->department_model->get_all_department();
        $view_data['department'] = $department_date;

        $join_str = array();
        $join_str[0] = array(
            'table' => 'indian_cities c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'indian_cities.cost_center_id',
            'join_type' => 'LEFT'
        );
        $data = 'c.id,c.name as city_name';
        $cost_center = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.cost_center_id !=' => '', 'indian_cities.status' => 'active'), $data, 'c.name', 'ASC', '', '', $join_str, 'indian_cities.cost_center_id');
        $view_data['cost_center'] = $cost_center;

        $request = $this->report_model->get_all_top_traveler($top_count = '5');
        $request_data = array();
        foreach ($request as $key => $value) {
            $employee_id = $value['employee_id'];
            $employee_data = $this->report_model->get_employee_details($employee_id);
            if (!empty($employee_data)) {
                $value['email'] = $employee_data['email'];
                $value['mobile'] = $employee_data['mobile'];
                $value['employee_name'] = $employee_data['employee_name'];
            } else {
                $value['email'] = "";
                $value['mobile'] = "";
                $value['employee_name'] = "";
            }
            $request_data[] = $value;
        }
        $view_data['request'] = $request_data;
        $this->template->write_view('content', 'report/top_traveler', $view_data);
        $this->template->render();
    }

    function get_toppers() {
        $top_count = $this->input->post('top_count');
        $grade_id = $this->input->post('grade_id');
        $cost_center_id = $this->input->post('cost_center_id');
        $dept_id = $this->input->post('dept_id');
        $request = $this->report_model->get_all_top_traveler($top_count, $grade_id, $cost_center_id,$dept_id);
        $request_data = array();
        foreach ($request as $key => $value) {
            $employee_id = $value['employee_id'];
            $employee_data = $this->report_model->get_employee_details($employee_id);
            if (!empty($employee_data)) {
                $value['email'] = $employee_data['email'];
                $value['mobile'] = $employee_data['mobile'];
                $value['employee_name'] = $employee_data['employee_name'];
				$value['GRADE'] = $employee_data['GRADE'];
				$value['city_name'] = $employee_data['city_name'];
				$value['dept_name'] = $employee_data['dept_name'];
				
            } else {
                $value['email'] = "";
                $value['mobile'] = "";
                $value['employee_name'] = "";
				$value['GRADE'] = "";
				$value['city_name'] = "";
				$value['dept_name'] = "";
				
            }
            $request_data[] = $value;
        }

        $request = $this->report_model->get_employee_details($top_count, $grade_id, $cost_center_id);
        $view_data = array('request' => $request_data);
		
        $this->load->view('report/list_top_traveler', $view_data);
    }

    public function top_hotel_stay() {
        $view_data = array();
        
		$grades = $this->grades_model->get_all_grades();
        $view_data = array();
        $view_data['grades'] = $grades;

        $this->load->model("department_model");
        $department_date = $this->department_model->get_all_department();
        $view_data['department'] = $department_date;

        $join_str = array();
        $join_str[0] = array(
            'table' => 'indian_cities c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'indian_cities.cost_center_id',
            'join_type' => 'LEFT'
        );
        $data = 'c.id,c.name as city_name';
        $cost_center = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.cost_center_id !=' => '', 'indian_cities.status' => 'active'), $data, 'city_name', 'ASC', '', '', $join_str, 'indian_cities.cost_center_id');
        $view_data['cost_center'] = $cost_center;
		
		$data = 'id,name as city_name';
        $city_data = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.status' => 'active'), $data, 'name', 'ASC', '', '', array());
        $view_data['city_data'] = $city_data;

        //$hotel = $this->report_model->get_all_top_hotel_stay($top_count = '5');
        $hotel = $this->report_model->get_all_type_top_stay($top_count = '10');
		
		$request_data = array();
        foreach ($hotel as $key => $value) {
            $hotel_provider_id = $value['hotel_provider_id'];
            $hotel_data = $this->report_model->get_hotel_details($hotel_provider_id);
            if (!empty($hotel_data)) {
                $value['id'] = $hotel_data['id'];
				$value['name'] = $hotel_data['name'];
                $value['amount'] = $hotel_data['amount'];
                $value['half_amount'] = $hotel_data['half_amount'];
                $value['city_name'] = $hotel_data['city_name'];
                $value['category'] = $hotel_data['category'];
				$value['type'] = $value['type'];
            } else {
                $value['id'] = "";
				$value['name'] = "";
                $value['amount'] = "";
                $value['half_amount'] = "";
                $value['city_name'] = "";
                $value['category'] = "";
				$value['type'] = '';
            }
            $request_data[] = $value;
        }
        $view_data['hotel'] = $request_data;
        $this->template->write_view('content', 'report/top_hotel_stay', $view_data);
        $this->template->render();
    }

    public function top_guest_house_stay() {
        $view_data = array();
        
		$grades = $this->grades_model->get_all_grades();
        $view_data = array();
        $view_data['grades'] = $grades;

        $this->load->model("department_model");
        $department_date = $this->department_model->get_all_department();
        $view_data['department'] = $department_date;

        $join_str = array();
        $join_str[0] = array(
            'table' => 'indian_cities c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'indian_cities.cost_center_id',
            'join_type' => 'LEFT'
        );
        $data = 'c.id,c.name as city_name';
        $cost_center = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.cost_center_id !=' => '', 'indian_cities.status' => 'active'), $data, 'city_name', 'ASC', '', '', $join_str, 'indian_cities.cost_center_id');
        $view_data['cost_center'] = $cost_center;
		
		$data = 'id,name as city_name';
        $city_data = $this->common->select_data_by_condition('indian_cities', $con_array = array('indian_cities.status' => 'active'), $data, 'name', 'ASC', '', '', array());
        $view_data['city_data'] = $city_data;
        $request_data = array();
        //$hotel = $this->report_model->get_all_top_guest_house_stay($top_count = '5');
        $hotel = $this->report_model->get_all_type_top_stay($top_count = '10');
		foreach ($hotel as $key => $value) {
            $hotel_provider_id = $value['hotel_provider_id'];
            $hotel_data = $this->report_model->get_hotel_details($hotel_provider_id);
            if (!empty($hotel_data)) {
                $value['id'] = $hotel_data['id'];
				$value['name'] = $hotel_data['name'];
                $value['amount'] = $hotel_data['amount'];
                $value['half_amount'] = $hotel_data['half_amount'];
                $value['city_name'] = $hotel_data['city_name'];
                $value['category'] = $hotel_data['category'];
				$value['type'] = $value['type'];
            } else {
                $value['id'] = "";
				$value['name'] = "";
                $value['amount'] = "";
                $value['half_amount'] = "";
                $value['city_name'] = "";
                $value['category'] = "";
				$value['type'] = "";
            }
            $request_data[] = $value;
        }
        $view_data['hotel'] = $request_data;
        $this->template->write_view('content', 'report/top_guest_house_stay', $view_data);
        $this->template->render();
    }

    function get_guest_house_toppers() {
        $top_count = $this->input->post('top_count');
        $city_id = $this->input->post('city_id');
        $hotel = $this->report_model->get_all_top_guest_house_stay($top_count, $city_id);
        $request_data = array();
        foreach ($hotel as $key => $value) {
            $hotel_provider_id = $value['hotel_provider_id'];
            $hotel_data = $this->report_model->get_hotel_details($hotel_provider_id);
            if (!empty($hotel_data)) {
                $value['id'] = $hotel_data['id'];
				$value['name'] = $hotel_data['name'];
                $value['amount'] = $hotel_data['amount'];
                $value['half_amount'] = $hotel_data['half_amount'];
                $value['city_name'] = $hotel_data['city_name'];
                $value['category'] = $hotel_data['category'];
            } else {
                $value['id'] = "";
				$value['name'] = "";
                $value['amount'] = "";
                $value['half_amount'] = "";
                $value['city_name'] = "";
                $value['category'] = "";
            }
            $request_data[] = $value;
        }
        $view_data = array('hotel' => $request_data);
        $this->load->view('report/list_top_guest_house_stay', $view_data);
    }
    
	function get_hotel_toppers() {
        $top_count = "100";
        $this->input->post('top_count');
        $city_id = $this->input->post('city_id');
        $hotel = $this->report_model->get_all_top_hotel_stay($top_count, $city_id);
        $request_data = array();
        foreach ($hotel as $key => $value) {
            $hotel_provider_id = $value['hotel_provider_id'];
            $hotel_data = $this->report_model->get_hotel_details($hotel_provider_id);
            if (!empty($hotel_data)) {
                $value['id'] = $hotel_data['id'];
				$value['name'] = $hotel_data['name'];
                $value['amount'] = $hotel_data['amount'];
                $value['half_amount'] = $hotel_data['half_amount'];
                $value['city_name'] = $hotel_data['city_name'];
                $value['category'] = $hotel_data['category'];
            } else {
                $value['id'] = "";
				$value['name'] = "";
                $value['amount'] = "";
                $value['half_amount'] = "";
                $value['city_name'] = "";
                $value['category'] = "";
            }
            $request_data[] = $value;
        }
        $view_data = array('hotel' => $request_data);
        $this->load->view('report/list_top_hotel_stay', $view_data);
    }
    
	
	function get_all_type_toppers() {
        
		$top_count = "100";
        $this->input->post('top_count');
        $city_id = $this->input->post('city_id');
		$grade_id = $this->input->post('grade_id');
		$dept_id = $this->input->post('dept_id');
        $type = $this->input->post('type');
		
		//$hotel = $this->report_model->get_all_top_hotel_stay($top_count, $city_id);
		$hotel = $this->report_model->get_all_type_top_stay($top_count, $city_id, $grade_id, $dept_id, $type);
		
		//echo $hotel; exit;
		
        $request_data = array();
        foreach ($hotel as $key => $value) {
            $hotel_provider_id = $value['hotel_provider_id'];
            $hotel_data = $this->report_model->get_hotel_details($hotel_provider_id);
            if (!empty($hotel_data)) {
                $value['id'] = $hotel_data['id'];
				$value['name'] = $hotel_data['name'];
                $value['amount'] = $hotel_data['amount'];
                $value['half_amount'] = $hotel_data['half_amount'];
                $value['city_name'] = $hotel_data['city_name'];
                $value['category'] = $hotel_data['category'];
				if($value['type']==1)
				{
				 $value['type'] = 'Hotel';
				}
				elseif($value['type']==2)
				{
				 $value['type'] = 'Guest House';
				}
            } else {
                $value['id'] = "";
				$value['name'] = "";
                $value['amount'] = "";
                $value['half_amount'] = "";
                $value['city_name'] = "";
                $value['category'] = "";
				$value['type'] = "";
            }
            $request_data[] = $value;
        }
        $view_data = array('hotel' => $request_data);
        $this->load->view('report/list_top_hotel_stay', $view_data);
    }
	
	function get_visitors() {
        $request_data = array();
		$city_id = $this->input->post('city_id');
		$grade_id = $this->input->post('grade_id');
		$dept_id = $this->input->post('dept_id');
        $type = $this->input->post('type');
		$HOT_ID = $this->input->post('hotel_or_GH_id');
		$visitors = $this->report_model->get_hotelVisitorsDetail($city_id, $grade_id, $dept_id, $type, $HOT_ID);
		$request_data[] = $visitors;
		$view_data = array('visitors' => $request_data);
        $this->load->view('report/list_visitors', $view_data);
    }
}
