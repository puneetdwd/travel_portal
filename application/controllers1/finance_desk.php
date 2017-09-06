<?php

class Finance_desk extends Admin_Controller {

    public function __construct() {

        parent::__construct(true);
        $this->is_logged_in();
        $header_data = array(
            'page' => 'masters',
            'sub' => 'employee_request'
        );
        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("finance_desk_model", 'finance_desk');

        $this->load->model("travel_request_model", 'travel_request');
        $this->load->model("expense_model", 'expense');
        $this->load->model("travel_desk_model", 'travel_desk');
    }
    
    public function travel_policy() {

        $emp_id = $this->session->userdata('employee_id');

        $this->load->model('employee_model');

        $this->load->model("grades_model");
        $grade_data = $this->grades_model->get_all_grades();

        $emp_policy = array();
        $i=0;
        foreach ($grade_data as $key => $value) {
            $grade_id = $value['id'];
            $grade = $value;
            $policy_data = $this->employee_model->get_travel_policy_by_grade($grade_id);
            $hotel = array();
            $DA = array();
            $DC = array();
            foreach ($policy_data as $key => $value) {
                if ($value['service_type'] == "5") {
                    if ($value['actual'] == "1") {
                        $hotel[$value['city_class']] = "Actual";
                    } else {
                        $hotel[$value['city_class']] = $value['amount'];
                    }
                }
                if ($value['service_type'] == "6") {
                    if ($value['actual'] == "1") {
                        $DA[$value['city_class']] = "Actual";
                    } else {
                        $DA[$value['city_class']] = $value['amount'];
                    }
                }
                if ($value['service_type'] == "7") {
                    if ($value['actual'] == "1") {
                        $DC[$value['city_class']] = "Actual";
                    } else {
                        $DC[$value['city_class']] = $value['amount'];
                    }
                }
            }

            
            if ($grade['travel_mode'] == "1") {
                $emp_policy[$i]['name'] = "Flight";
            } else if ($grade['travel_mode'] == "2") {
                $emp_policy[$i]['name'] = "Train";
            } else if ($grade['travel_mode'] == "3") {
                $emp_policy[$i]['name'] = "Car";
            } else if ($grade['travel_mode'] == "4") {
                $emp_policy[$i]['name'] = "Bus";
            }

            $emp_policy[$i]['travel_class'] = $grade['travel_class'];
            $emp_policy[$i]['grade_name'] = $grade['grade_name'];
            $emp_policy[$i]['transport'] = $grade['car_type'];
            $emp_policy[$i]['hotel'] = $hotel;
            $emp_policy[$i]['DA'] = $DA;
            $emp_policy[$i]['DC'] = $DC;
            $i++;
        }
        
        $view_data['emp_policy'] = $emp_policy;
        
        $this->template->write_view('content', 'travel_desk/view_policy', $view_data);
        $this->template->render();
    }

    public function index($type = NULL) {
        $employee_id = $this->session->userdata('employee_id');
        $request_arr = $this->finance_desk->get_travel_requests($employee_id);
//        po($request_arr);
        $total_requests = $this->finance_desk->get_total_requests($employee_id);
        
        $view_request = array();
        $request = array();
        foreach ($request_arr as $key => $value) {
            $request[$value['id']] = $value;
        }
       

        $view_request['pending_requests'] = count($request);
        $view_request['approved_requests'] = count($total_requests) - count($request);
        $view_request['total_requests'] = count($total_requests);

        if ($type == "1") {
            $view_request['request'] = $total_requests;
        } else if ($type == "2") {
            $request = $this->finance_desk->get_approved_requests($employee_id);
            $view_request['request'] = $request;
        } else if ($type == "3") {
//            $request = $this->finance_desk->get_pending_requests($employee_id);            
            $view_request['request'] = $request;
        } else {
            $view_request['request'] = $request;
        }

        $this->template->write_view('content', 'finance_desk/index', $view_request);
        $this->template->render();
    }

    public function inbox($type = NULL) {
        $employee_id = $this->session->userdata('employee_id');
        $request_arr = $this->finance_desk->get_travel_requests($employee_id);
        $request_audit_arr = $this->finance_desk->get_travel_requests_unaudit($employee_id);

        $request = array();
        $request_audit = array();
        foreach ($request_arr as $key => $value) {
            $request[$value['id']] = $value;
        }
        foreach ($request_audit_arr as $key => $value) {
            $request_audit[$value['id']] = $value;
        }
//        po($request_audit);
        $view_request = array();
        $view_request['request'] = $request;
        $view_request['request_audit'] = $request_audit;
        $this->template->write_view('content', 'finance_desk/inbox', $view_request);
        $this->template->render();
    }

    function expense_pending($request_id) {
        $total_travel_claim = 0;
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->expense->get_all_request_by_id($request_id, '1');
        $employee_id = $request['employee_id'];

        $view_request = array('request' => $request);
        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee_id($employee_id);
        $view_request['employee'] = $employee;

        $other_manager_expense = $this->expense->get_other_manager_expense($request_id);
        if (!empty($other_manager_expense)) {
            $foods = $view_request['other_manager_expense_food'] = $other_manager_expense['foods'];
            $travel = $view_request['other_manager_expense_travel'] = $other_manager_expense['travel'];
            $other = $view_request['other_manager_expense_other'] = $other_manager_expense['other'];
			 $view_request['other_manager_expense_location'] = $other_manager_expense['expense_location'];
            $other_manager_expense_total = $foods + $travel + $other;
            $view_request['other_manager_expense'] = $other_manager_expense_total;
            $total_travel_claim = $total_travel_claim + $other_manager_expense_total;
        }

        $expense_pending = $this->expense->get_expense_pending($request_id);
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => 'mcrypt'));
        $this->encryption->initialize(array('driver' => 'openssl'));
        $expense_pending['credit_card_number'] = $this->encryption->decrypt($expense_pending['credit_card_number']);
        $expense_pending['bank_name'] = $this->encryption->decrypt($expense_pending['bank_name']);
        $view_request['expense_pending'] = $expense_pending;

        $other_trip_expense = $this->expense->get_other_trip_expense($request_id);
        $view_request['other_trip_expense'] = $other_trip_expense;

        $other_loading_booking = $this->expense->get_other_loading_booking($request_id);
        $view_request['other_loading_booking'] = $other_loading_booking;

        $other_con_booking = $this->expense->get_other_con_booking($request_id);
        $view_request['other_con_booking'] = $other_con_booking;

        $get_other_attachment = $this->expense->get_other_attachment($request_id);
        $view_request['get_other_attachment'] = $get_other_attachment;

        if ($request['return_date'] != "0000-00-00 00:00:00") {
            if ($request['return_date'] != "") {
                $first_date = new DateTime($request['departure_date']);
                $second_date = new DateTime($request['return_date']);
                $interval = $first_date->diff($second_date);
                $day = $view_request['day'] = $interval->format("%d");
                $hours = $view_request['hours'] = $interval->format("%h");
            } else {
                $day = $view_request['day'] = "1";
                $hours = $view_request['hours'] = "0";
            }
        } else {
            $day = $view_request['day'] = "1";
            $hours = $view_request['hours'] = "0";
        }

        $da_total = $request['DA_allowance'] * $day;
        

        $total_travel_claim = $total_travel_claim + $da_total;

        $ticket_details = array();
        $hotel_details = array();
        $car_details = array();

        if ($request['request_status'] >= '4') {

            if ($request['trip_ticket'] == '1') {
                if ($request['travel_type'] == '1') {
                    $flight_booking = $this->travel_request->get_flight_ticket_booking($request_id);
                    $view_request['flight_booking'] = $flight_booking;

                    $flight_booking = $this->travel_desk->get_flight_ticket_booking($request_id);
                    $view_request['flight_booking'] = $flight_booking;
                    if ($request['trip_type'] != "1") {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '1';
                        $data_array['type'] = '1';
                        $data_array['trip_mode'] = $flight_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $flight_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $flight_booking[0]['expense_location'];
                        $data_array['cost'] = $flight_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $flight_booking[0]['cost'];
                        $data_array['attachment'] = $flight_booking[0]['flight_attachment'];
                        $ticket_details[] = $data_array;

                        $data_array = array();
                        $data_array['date'] = $request['return_date'];
                        $data_array['location_from'] = $request['to_city_name'];
                        $data_array['location_to'] = $request['from_city_name'];
                        $data_array['travel_type'] = '1';
                        $data_array['type'] = '1';
                        $data_array['trip_mode'] = $flight_booking[1]['trip_mode'];
                        $data_array['arrange_by'] = $flight_booking[1]['arrange_by'];
                        $data_array['expense_location'] = $flight_booking[1]['expense_location'];
                        $data_array['cost'] = $flight_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $flight_booking[1]['cost'];
                        $data_array['attachment'] = $flight_booking[1]['flight_attachment'];
                        $ticket_details[] = $data_array;
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '1';
                        $data_array['type'] = '1';
                        $data_array['trip_mode'] = $flight_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $flight_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $flight_booking[0]['expense_location'];
                        $data_array['cost'] = $flight_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $flight_booking[0]['cost'];
                        $data_array['attachment'] = $flight_booking[0]['flight_attachment'];
                        $ticket_details[] = $data_array;
                    }
                }
                if ($request['travel_type'] == '2') {
                    $train_booking = $this->travel_desk->get_train_ticket_booking($request_id);
                    $view_request['train_booking'] = $train_booking;

                    if ($request['trip_type'] != "1") {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '2';
                        $data_array['type'] = '2';
                        $data_array['trip_mode'] = $train_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $train_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $train_booking[0]['expense_location'];
                        $data_array['cost'] = $train_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $train_booking[0]['cost'];
                        $data_array['attachment'] = $train_booking[0]['train_attachment'];
                        $ticket_details[] = $data_array;

                        $data_array = array();
                        $data_array['date'] = $request['return_date'];
                        $data_array['location_from'] = $request['to_city_name'];
                        $data_array['location_to'] = $request['from_city_name'];
                        $data_array['travel_type'] = '2';
                        $data_array['type'] = '2';
                        $data_array['trip_mode'] = $train_booking[1]['trip_mode'];
                        $data_array['arrange_by'] = $train_booking[1]['arrange_by'];
                        $data_array['expense_location'] = $train_booking[1]['expense_location'];
                        $data_array['cost'] = $train_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $train_booking[1]['cost'];
                        $data_array['attachment'] = $train_booking[1]['train_attachment'];
                        $ticket_details[] = $data_array;
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '2';
                        $data_array['type'] = '2';
                        $data_array['trip_mode'] = $train_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $train_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $train_booking[0]['expense_location'];
                        $data_array['cost'] = $train_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $train_booking[0]['cost'];
                        $data_array['attachment'] = $train_booking[0]['train_attachment'];
                        $ticket_details[] = $data_array;
                    }
                }

                if ($request['travel_type'] == '3') {
                    $car_booking = $this->travel_desk->get_car_ticket_booking($request_id);
                    $view_request['car_booking'] = $car_booking;

                    if ($request['trip_type'] != "1") {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '3';
                        $data_array['type'] = '3';
                        $data_array['trip_mode'] = $car_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $car_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $car_booking[0]['expense_location'];
                        $data_array['cost'] = $car_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $car_booking[0]['cost'];
                        $data_array['attachment'] = $car_booking[0]['car_attachment'];
                        $ticket_details[] = $data_array;

                        $data_array = array();
                        $data_array['date'] = $request['return_date'];
                        $data_array['location_from'] = $request['to_city_name'];
                        $data_array['location_to'] = $request['from_city_name'];
                        $data_array['travel_type'] = '3';
                        $data_array['type'] = '3';
                        $data_array['trip_mode'] = $car_booking[1]['trip_mode'];
                        $data_array['arrange_by'] = $car_booking[1]['arrange_by'];
                        $data_array['expense_location'] = $car_booking[1]['expense_location'];
                        $data_array['cost'] = $car_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $car_booking[1]['cost'];
                        $data_array['attachment'] = $car_booking[1]['car_attachment'];
                        $ticket_details[] = $data_array;
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '3';
                        $data_array['type'] = '3';
                        $data_array['trip_mode'] = $car_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $car_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $car_booking[0]['expense_location'];
                        $data_array['cost'] = $car_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $car_booking[0]['cost'];
                        $data_array['attachment'] = $car_booking[0]['car_attachment'];
                        $ticket_details[] = $data_array;
                    }
                }
                if ($request['travel_type'] == '4') {
                    $bus_booking = $this->travel_desk->get_bus_ticket_booking($request_id);
                    $view_request['bus_booking'] = $bus_booking;

                    if ($request['trip_type'] != "1") {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '4';
                        $data_array['type'] = '4';
                        $data_array['trip_mode'] = $bus_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $bus_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $bus_booking[0]['expense_location'];
                        $data_array['cost'] = $bus_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $bus_booking[0]['cost'];
                        $data_array['attachment'] = $bus_booking[0]['bus_attachment'];
                        $ticket_details[] = $data_array;

                        $data_array = array();
                        $data_array['date'] = $request['return_date'];
                        $data_array['location_from'] = $request['to_city_name'];
                        $data_array['location_to'] = $request['from_city_name'];
                        $data_array['travel_type'] = '4';
                        $data_array['type'] = '4';
                        $data_array['trip_mode'] = $bus_booking[1]['trip_mode'];
                        $data_array['arrange_by'] = $bus_booking[1]['arrange_by'];
                        $data_array['expense_location'] = $bus_booking[1]['expense_location'];
                        $data_array['cost'] = $bus_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $bus_booking[1]['cost'];
                        $data_array['attachment'] = $bus_booking[1]['bus_attachment'];
                        $ticket_details[] = $data_array;
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '4';
                        $data_array['type'] = '4';
                        $data_array['trip_mode'] = $bus_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $bus_booking[0]['arrange_by'];
                        $data_array['expense_location'] = $bus_booking[0]['expense_location'];
                        $data_array['cost'] = $bus_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $bus_booking[0]['cost'];
                        $data_array['attachment'] = $bus_booking[0]['bus_attachment'];
                        $ticket_details[] = $data_array;
                    }
                }
            }

            if ($request['hotel_booking'] == '1') {
                $hotel_booking = $this->travel_request->get_hotel_booking($request_id);
                $view_request['hotel_booking'] = $hotel_booking;
                $data_array = array();
                $data_array['date_from'] = $hotel_booking['check_in_date'];
                $data_array['date_to'] = $hotel_booking['check_out_date'];
                $data_array['location'] = $hotel_booking['from_city_name'];
                $data_array['bill_no'] = $hotel_booking['bill_no'];
                $data_array['bill_no_1'] = $hotel_booking['bill_no_1'];
                $data_array['expense_location'] = $hotel_booking['expense_location'];
                $data_array['loading_expense_1'] = $hotel_booking['loading_expense_1'];
                $data_array['other_expense_1'] = $hotel_booking['other_expense_1'];
                $data_array['cost'] = $hotel_booking['cost'];
                $data_array['arrange_by'] = $hotel_booking['arrange_by'];
                $total_travel_claim = $total_travel_claim + $hotel_booking['cost'];
                $data_array['attachment'] = $hotel_booking['hotel_attchment'];
                $hotel_details[] = $data_array;
            }

            if ($request['car_booking'] == '1') {
                $car_booking = $this->travel_request->get_car_booking($request_id);
                $view_request['car_booking'] = $car_booking;
                $data_array = array();
                $data_array['date'] = $car_booking['drop_off_date'];
                $data_array['location_from'] = $car_booking['pick_up_location'];
                $data_array['location_to'] = $car_booking['drop_off_location'];
                $data_array['expense_location'] = $car_booking['expense_location'];
                $data_array['travel_type'] = '3';
                $data_array['cost'] = $car_booking['cost'];
                $data_array['book_by'] = $car_booking['book_by'];
                $data_array['arrange_by'] = $car_booking['arrange_by'];
                $total_travel_claim = $total_travel_claim + $car_booking['cost'];
                $data_array['attachment'] = $car_booking['car_attchment'];
                $car_details[] = $data_array;
            }
        }


        $other_expense = $this->expense->get_other_expense($request_id);
        $view_request['other_expense'] = $other_expense;
        $view_request['ticket_details'] = $ticket_details;
        $view_request['hotel_details'] = $hotel_details;
        $view_request['car_details'] = $car_details;
        $view_request['total_travel_claim'] = $total_travel_claim;
        
        
        $employee = $this->employee_model->get_employee_by_id($employee_id);
        $grade_id = $employee['grade_id'];
        $travel_type = $request['travel_type'];
        $city_id = $request['to_city_id'];

        $this->load->model("city_model");
        $to_city = $this->city_model->get_city($city_id);
        $to_class = $to_city['class'];
        
        $traverl_class_data = $this->travel_request->get_travel_class_by_grade($grade_id, $travel_type);
        if (isset($traverl_class_data['name'])) {
            $view_request['sel_traverl_class'] = $traverl_class_data['name'];
        } else {
            $view_request['sel_traverl_class'] = "";
        }
        $this->load->model('travel_policy_model');
        $policy_data = $this->travel_policy_model->get_policy_allowance_by_grade($grade_id, $to_class);

        $convince_allowance = '';
        $hotel_allowance = '';
        $DA_allowance = '';
        foreach ($policy_data as $key => $value) {
            if ($value['service_type'] == "5") {
                if ($value['actual'] == "0") {
                    $hotel_allowance = $value['amount'];
                } else {
                    $hotel_allowance = "Actual";
                }
            } else if ($value['service_type'] == "6") {
                if ($value['actual'] == "0") {
                    $DA_allowance = $value['amount'];
                } else {
                    $DA_allowance = "Actual";
                }
            } else if ($value['service_type'] == "7") {
                if ($value['actual'] == "0") {
                    $convince_allowance = $value['amount'];
                } else {
                    $convince_allowance = "Actual";
                }
            }
        }
        $view_request['DA_allowance'] = $DA_allowance;
        $view_request['convince_allowance'] = $convince_allowance;
        $view_request['hotel_allowance'] = $hotel_allowance;
        if ($this->input->post()) {
            $allowances_item_array = array(
                'employees_id' => $request['employee_id'],
                'request_id' => $request_id,
                'credit_card_number' => $this->input->post('credit_card_number'),
                'bank_name' => $this->input->post('bank_name'),
                'reimbursement_arrangment' => $this->input->post('arrange_by'),
                'total_claim' => $this->input->post('total_claim'),
                'less_advance' => $this->input->post('les_advance'),
                'recevied_amount' => $this->input->post('your_recived_hidd'),
            );
            if ($this->common->insert_data($allowances_item_array, 'expense')) {
                $data_array = array(
                    'request_status' => "5",
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $this->session->set_flashdata('success', 'New Expense claimed successfully.');
                    redirect(base_url() . expense);
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . expense);
                }
            } else {
                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                redirect(base_url() . expense);
            }
        }


        $this->template->write_view('content', 'finance_desk/expense_pending', $view_request);
        $this->template->render();
    }

    function audit_expense($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['request_status'] == '6') {
                $expense_pending = $this->expense->get_expense_pending($request_id);
                $less_advance_hidd_audit = $this->input->post('less_advance_hidd_audit');
                if ($less_advance_hidd_audit == '') {
                    $less_advance_hidd_audit = 0;
                }
                $your_recived_hidd_audit = $this->input->post('your_recived_hidd_audit');
                if ($your_recived_hidd_audit == '') {
                    $your_recived_hidd_audit = 0;
                }
                $expense_array = array(
                    'less_advance' => $less_advance_hidd_audit,
                    'recevied_amount' => $your_recived_hidd_audit,
                );
                if ($this->common->update_data($expense_array, 'expense', 'request_id', $request_id)) {
                    $data_array = array(
                        'request_status' => '7',
                    );
                    if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                        $request_data = $this->travel_request->get_request_details_by_id($request_id);
                        $to_city_id = $request['to_city_id'];
                        $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-weight:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Hi <name of='' requester=''>" . $request_data['employee_name'] . ",</name></span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Your claim request is Approved by Finance Manager and sent to Audit Manager&nbsp;</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Please </span><a target='_blanck' href='" . base_url('employee_request/view_expense') . '/' . $request_id . "' style='text-decoration-line: none;'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' text-decoration-line:='' trebuchet='' vertical-align:='' white-space:=''>click here</span></a><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''> to review of the travel claim.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-style:='' style='font-size: 9pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";
                        $to = $request_data['employee_email'];
                        $subject = $request_data['reference_id'] . ", Claim Approval Status";
                        $this->sendEmail($to, $subject, $message);

                        $this->session->set_flashdata('success', 'Expense Sent to Adut Manager.');
                        redirect(base_url() . 'finance_desk/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'finance_desk/inbox');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'finance_desk/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already approved');
                redirect(base_url() . 'finance_desk/inbox');
            }
        }
    }

    function approve_expense($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);

        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            $expense_pending = $this->expense->get_expense_pending($request_id);

            $expense_array = array(
                'less_advance' => $this->input->post('less_advance_hidd_finance'),
                'recevied_amount' => $this->input->post('your_recived_hidd_finance'),
            );
            if ($this->common->update_data($expense_array, 'expense', 'request_id', $request_id)) {
                $data_array = array(
                    'request_status' => '9',
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    if ($request['travel_reason_id'] == "Projects") {
                        $project_id = $request['project_id'];

                        $this->load->model("projects_model");
                        $project = $this->projects_model->get_project($project_id);

                        $budget_id = $project['id'];
                        $current_budget = $project['remain_budget'];
                        $total_claim = $expense_pending['total_claim'];
                        $remain_budget = $current_budget - $total_claim;
                        $data_array = array(
                            'remain_budget' => $remain_budget,
                        );
                        if ($this->common->update_data($data_array, 'projects', 'id', $budget_id)) {
                            $data_type_array = array(
                                'project_id' => $budget_id,
                                'request_id' => $request_id,
                                'debit' => $total_claim,
                                'current_budget' => $current_budget,
                                'remain_budget' => $remain_budget,
                            );
                            if (!$this->common->insert_data($data_type_array, 'budget_history')) {
                                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                                redirect(base_url() . 'employee_request/inbox');
                            }
                        }
                    } else {
                        $employee_id = $request['employee_id'];
                        $this->load->model('employee_model');
                        $employee = $this->employee_model->get_employee_id($employee_id);
                        $view_request['employee'] = $employee;
                        $dept_id = $employee['dept_id'];
                        $this->load->model("budget_model");
                        $financial_year = date('Y');
                        $budget = $this->budget_model->get_budget_by_dept($dept_id, $financial_year);
                        $budget_id = $budget['id'];
                        $current_budget = $budget['remain_budget'];
                        $total_claim = $expense_pending['total_claim'];
                        $remain_budget = $current_budget - $total_claim;

                        $data_array = array(
                            'remain_budget' => $remain_budget,
                        );
                        if ($this->common->update_data($data_array, 'budget', 'id', $budget_id)) {
                            $data_type_array = array(
                                'budget_id' => $budget_id,
                                'request_id' => $request_id,
                                'debit' => $total_claim,
                                'current_budget' => $current_budget,
                                'remain_budget' => $remain_budget,
                            );
                            if (!$this->common->insert_data($data_type_array, 'budget_history')) {
                                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                                redirect(base_url() . 'employee_request/inbox');
                            }
                        }
                    }

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $to_city_id = $request['to_city_id'];
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-weight:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Hi <name of='' requester=''>" . $request_data['employee_name'] . ",</name></span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Your claim request is Approved and Trip is completed by Finance Manager&nbsp;</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Please </span><a target='_blanck' href='" . base_url('employee_request/view_expense') . '/' . $request_id . "' style='text-decoration-line: none;'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' text-decoration-line:='' trebuchet='' vertical-align:='' white-space:=''>click here</span></a><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''> to review of the travel claim.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-style:='' style='font-size: 9pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";
                    $to = $request_data['employee_email'];
                    $subject = $request_data['reference_id'] . ", Claim Approval Status";
                    $this->sendEmail($to, $subject, $message);

                    $this->session->set_flashdata('success', 'Expense Approved successfully');
                    redirect(base_url() . 'finance_desk/inbox');
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'finance_desk/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect(base_url() . 'finance_desk/inbox');
            }
        }
    }

    function clarification_expense($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['request_status'] == '6') {
                $expense_pending = $this->expense->get_expense_pending($request_id);

                $data_array = array(
                    'request_status' => '5',
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $data_array = array(
                        'clarification_comment' => $this->input->post('clarification_comment'),
                        'expense_status' => "Clarification",
                    );
                    if ($this->common->update_data($data_array, 'expense', 'request_id', $request_id)) {

                        $request_data = $this->travel_request->get_request_details_by_id($request_id);
                        $to_city_id = $request['to_city_id'];


                        $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-weight:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Hi <name of='' requester=''>" . $request_data['employee_name'] . ",</name></span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Your claim request is under clarification by Finance Manager&nbsp;</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Please </span><a target='_blanck' href='" . base_url('employee_request/claim') . '/' . $request_id . "' style='text-decoration-line: none;'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' text-decoration-line:='' trebuchet='' vertical-align:='' white-space:=''>click here</span></a><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''> to review and Re-claim request.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-style:='' style='font-size: 9pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                        $to = $request_data['employee_email'];
                        $subject = $request_data['reference_id'] . ", Claim Approval Status";
                        $this->sendEmail($to, $subject, $message);

                        $this->session->set_flashdata('success', 'Expense Rejected successfully');
                        redirect(base_url() . 'finance_desk/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . 'finance_desk/inbox');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'finance_desk/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already approved');
                redirect(base_url() . 'finance_desk/inbox');
            }
        }
    }

}
