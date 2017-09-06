<?php

class Employee_request extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'employee_request'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_request_model", 'travel_request');
        $this->load->model("travel_booking_model", 'travel_booking');
        $this->load->model("expense_model", 'expense');
        $this->load->model("travel_desk_model", 'travel_desk');

        $this->load->library('form_validation');
    }

    public function index() {
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_all_request($employee_id, '1');
        $request_arr = array();
        foreach ($request as $key => $value) {
            $request_arr[$value['id']] = $value;
        }

        $emp_request = $this->travel_request->get_my_employee_request($employee_id, '1');
//        po($emp_request);
        $emp_request_arr = array();
        foreach ($emp_request as $key => $value) {
            $emp_request_arr[$value['id']] = $value;
        }

        $view_request = array('request' => $request_arr, 'emp_request' => $emp_request_arr);
        $this->template->write_view('content', 'employee_request/index_my_request', $view_request);
        $this->template->render();
    }

    public function draft() {
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_all_draft_request($employee_id);
        $view_request = array('request' => $request);
        $this->template->write_view('content', 'employee_request/my_draft_request', $view_request);
        $this->template->render();
    }

    function view($request_id) {
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_all_request_by_id($request_id, '1');
        $view_request = array('request' => $request);

        if ($request['request_status'] >= '3') {
            if ($request['trip_ticket'] == '1') {
                if ($request['travel_type'] == '1') {
                    $flight_booking = $this->travel_request->get_flight_ticket_booking($request_id);
                    $view_request['flight_booking'] = $flight_booking;
                }
                if ($request['travel_type'] == '2') {
                    $train_booking = $this->travel_request->get_train_ticket_booking($request_id);
                    $view_request['train_booking'] = $train_booking;
                }
                if ($request['travel_type'] == '3') {
                    $car_booking = $this->travel_request->get_car_ticket_booking($request_id);
                    $view_request['car_booking'] = $car_booking;
                }
                if ($request['travel_type'] == '4') {
                    $bus_booking = $this->travel_request->get_bus_ticket_booking($request_id);
                    $view_request['bus_booking'] = $bus_booking;
                }
            }

            if ($request['hotel_booking'] == '1') {
                $hotel_booking = $this->travel_request->get_hotel_booking($request_id);
                $view_request['hotel_booking'] = $hotel_booking;
            }

            if ($request['car_booking'] == '1') {
                $car_booking = $this->travel_request->get_car_booking($request_id);
                $view_request['car_booking'] = $car_booking;
            }
        }

        if ($request['group_travel'] == "1") {
            $member_list = $this->travel_request->get_all_member_list_by_id($request_id);
            $view_request['member_list'] = $member_list;

            $member_other_list = $this->travel_request->get_all_member_other_list_by_id($request_id);
            $view_request['member_other_list'] = $member_other_list;
        }
        $this->template->write_view('content', 'employee_request/view_my_request', $view_request);
        $this->template->render();
    }

    function view_ticket($request_id) {
        $view_request = array();

        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_all_request_by_id($request_id);
        $view_request['request'] = $request;
        if ($request['request_status'] >= '4') {
            if ($request['trip_ticket'] == '1') {
                if ($request['travel_type'] == '1') {
                    $flight_booking = $this->travel_request->get_flight_ticket_booking($request_id);
                    $view_request['flight_booking'] = $flight_booking;
                }
                if ($request['travel_type'] == '2') {
                    $train_booking = $this->travel_request->get_train_ticket_booking($request_id);
                    $view_request['train_booking'] = $train_booking;
                }
                if ($request['travel_type'] == '3') {
                    $car_booking = $this->travel_request->get_car_ticket_booking($request_id);
                    $view_request['car_booking'] = $car_booking;
                }
                if ($request['travel_type'] == '4') {
                    $bus_booking = $this->travel_request->get_bus_ticket_booking($request_id);
                    $view_request['bus_booking'] = $bus_booking;
                }
            }

            if ($request['hotel_booking'] == '1') {
                $hotel_booking = $this->travel_request->get_hotel_booking($request_id);
                $view_request['hotel_booking'] = $hotel_booking;
            }

            if ($request['car_booking'] == '1') {
                $car_booking = $this->travel_request->get_car_booking($request_id);
                $view_request['car_booking'] = $car_booking;
            }
        }
//        po($view_request);
        $this->template->write_view('content', 'employee_request/view_ticket', $view_request);
        $this->template->render();
    }

    public function delete_request($id) {
        $output = $this->travel_request->delete_request($id);
        if (!$output) {
            $this->session->set_flashdata('error', 'Something went wrong');
        } else {
            $this->session->set_flashdata('success', 'Request deleted Successfully');
            redirect(base_url() . 'employee_request/draft');
        }
    }

    public function delete_all_draft() {
        $employee_id = $this->session->userdata('employee_id');
        $output = $this->travel_request->delete_all_request($employee_id);
        if (!$output) {
            $this->session->set_flashdata('error', 'Something went wrong');
            redirect(base_url() . 'employee_request/draft');
        } else {
            $this->session->set_flashdata('success', 'Request deleted Successfully');
            redirect(base_url() . 'employee_request/draft');
        }
    }

    function cancel_trip($request_id, $ticket_type = '') {
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_all_request_by_id($request_id);
        $view_request = array('request' => $request);
        if ($request_id) {
            if ($ticket_type == "") {
                $req_data = array(
                    'cancel_status' => "2",
                );
            } else {
                $data_array2 = array(
                    'cancel_status' => "2",
                );
                if ($ticket_type == "1") {
                    if (!$this->common->update_data($data_array2, 'flight_ticket_booking', 'request_id', $request_id)) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . expense);
                    }
                } else if ($ticket_type == "2") {
                    if (!$this->common->update_data($data_array2, 'train_ticket_booking', 'request_id', $request_id)) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . expense);
                    }
                } else if ($ticket_type == "3") {
                    if (!$this->common->update_data($data_array2, 'car_ticket_booking', 'request_id', $request_id)) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . expense);
                    }
                } else if ($ticket_type == "4") {
                    if (!$this->common->update_data($data_array2, 'bus_ticket_booking', 'request_id', $request_id)) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . expense);
                    }
                } else if ($ticket_type == "5") {
                    if (!$this->common->update_data($data_array2, 'hotel_booking', 'request_id', $request_id)) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . expense);
                    }
                } else if ($ticket_type == "6") {
                    if (!$this->common->update_data($data_array2, 'car_booking', 'request_id', $request_id)) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . expense);
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . expense);
                }
                $req_data = array(
                    'cancel_status' => "3",
                );
            }
            $data1 = $this->travel_booking->update_travel_request_cancel($req_data, $request_id);
            $msg = (!empty($request_id)) ? ' Request for cancel successfully Submitted' : 'Request for cancel successfully Submitted';
            $this->session->set_flashdata('success', $msg);
            redirect(base_url() . employee_request);
        }

        $this->template->write_view('content', 'employee_request/accommodation_request', $view_request);
        $this->template->render();
    }

    function accommodation($request_id) {
//        po();
        $flag = 0;
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_emp_request_by_id($request_id, $employee_id);
        if (empty($request)) {
            $request = $this->travel_request->get_emp_request_by_ea_id($request_id, $employee_id);
            if (empty($request)) {
                $this->session->set_flashdata('error', 'Something went wrong');
                redirect(base_url() . 'employee_request/index');
            } else {
                $flag++;
            }
        }
        $view_request = array('request' => $request);
        $booking = $this->travel_booking->get_travel_booking_by_request_id($request_id);
        $view_request['booking'] = $booking;

        if ($this->input->post('submit_ticket')) {
            $travel_ticket = $this->input->post('travel_ticket');
            $accommodation = $this->input->post('accommodation');
            $car_hire = $this->input->post('car_hire');

            $booking_flag = 0;
            if ($travel_ticket != '' && $accommodation != '' && $car_hire != '') {
                $booking_flag = 1;
            }

            $bookbymanager = 0;
            if ($travel_ticket == '1' || $accommodation == '1' || $car_hire == '1') {
                $bookbymanager = 1;
            }
            $bookbyself = 0;
            if ($travel_ticket == '2' || $accommodation == '2' || $car_hire == '2') {
                $bookbyself = 1;
            }

            $travel_booking_id = $this->input->post('id');
            if ($travel_ticket == '' && $accommodation == '' && $car_hire == '') {
                $this->session->set_flashdata('error', 'Please select accommodation.');
                $view_data['error'] = 'Please select accommodation.';
                redirect('employee_request/accommodation/' . $request_id, 'refresh');
            } else {
                $post_data = array(
                    'request_id' => $request_id,
                    'travel_ticket' => $travel_ticket,
                    'accommodation' => $accommodation,
                    'car_hire' => $car_hire,
                    'bookbymanager' => $bookbymanager,
                    'bookbyself' => $bookbyself,
                );
                $data = $this->travel_booking->update_travel_booking($post_data, $travel_booking_id);
                if ($data) {
//                    if ($booking_flag == '1') {
                    $req_data = array(
                        'request_status' => "3",
                    );
                    $data1 = $this->travel_booking->update_travel_request($req_data, $request_id);
//                    }
                    $msg = (!empty($travel_booking_id)) ? ' Accommodation request sent to travel desk' : 'Accommodation request sent to travel desk';

                    if ($travel_ticket == '1' || $accommodation == '1' || $car_hire == '1') {
                        $email_template = $this->common->select_data_by_id('email_format', 'mail_id', '5');
                        if (!empty($email_template)) {
                            $request_data = $this->travel_request->get_request_details_by_id($request_id);
                            $request_data['amount'] = $request_data['hotel_allowance'] + $request_data['da_allowance'] + $request_data['convince_allowance'];
                            $from_city_id = $request['from_city_id'];
                            $cost_center_list = $this->travel_request->get_cost_center_by_city_id($from_city_id);
                            $cost_center_id = $cost_center_list['cost_center_id'];

                            $departure_date = $request_data['departure_date'];
                            $return_date = $request_data['return_date'];
                            if ($return_date == '') {
                                $request_data['travel_datetime'] = date(DATETIME_FORMAT, strtotime($departure_date));
                                $request_data['day_plan'] = "1";
                            } else {
                                $now = strtotime(date('Y-m-d', strtotime($departure_date)));
                                $your_date = strtotime(date('Y-m-d', strtotime($return_date)));
                                $datediff = $your_date - $now;
                                $request_data['day_plan'] = floor($datediff / (60 * 60 * 24));
                                $request_data['travel_datetime'] = date(DATETIME_FORMAT, strtotime($departure_date)) . " To " . date(DATETIME_FORMAT, strtotime($return_date));
                            }

                            if ($request_data['travel_type'] == "1") {
                                $travel_mode = "Flight";
                            } else if ($request_data['travel_type'] == "2") {
                                $travel_mode = "Train";
                            } else if ($request_data['travel_type'] == "3") {
                                $travel_mode = "Car";
                            } else if ($request_data['travel_type'] == "4") {
                                $travel_mode = "Bus";
                            } else {
                                $travel_mode = "";
                            }
                            $request_data['travel_mode'] = $travel_mode;
                            $request_data['url'] = "<a target='_blanck' href='" . base_url("employee_request/view/") . "/" . $request_id . "' style='text-decoration-line: none;'>Click here</a>";

                            $subject = $email_template[0]['subject'];
                            $mailformat = $email_template[0]['emailformat'];
                            $subject = str_replace("%mobile%", $request_data['mobile'], str_replace("%employee_email%", $request_data['employee_email'], str_replace("%grade%", $request_data['grade'], str_replace("%age%", $request_data['age'], str_replace("%travel_class%", $request_data['travel_class'], str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($subject)))))))))))))))));
                            $message = str_replace("%mobile%", $request_data['mobile'], str_replace("%employee_email%", $request_data['employee_email'], str_replace("%grade%", $request_data['grade'], str_replace("%age%", $request_data['age'], str_replace("%travel_class%", $request_data['travel_class'], str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($mailformat)))))))))))))))));

                            $travel_email = $this->travel_request->get_travel_manager_email_from_id($cost_center_id);
                            if (!empty($travel_email)) {
                                $to_email = '';
                                $cc = $request_data['employee_email'];
                                foreach ($travel_email as $key => $value) {
                                    $to_email[] = $value['email'];
                                }
                                $this->sendEmail($to_email, $subject, $message, $cc);
                            }
                        }
                    }
                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . employee_request);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            }
        }

        $this->template->write_view('content', 'employee_request/accommodation_request', $view_request);
        $this->template->render();
    }

    public function inbox() {
        $employee_id = $this->session->userdata('employee_id');
        $pending_request = $this->travel_request->get_all_pending_request_for_manager($employee_id);
        $cancellation_pending_request = $this->travel_request->get_all_cancallation_pending_request_for_manager($employee_id);
        $completed_request = $this->travel_request->get_all_completed_request_for_manager($employee_id);
        $expense_request = $this->travel_request->get_all_expense_pending_for_manager($employee_id);
        $pending_request_arr = array();
        foreach ($pending_request as $key => $value) {
            $pending_request_arr[$value['id']] = $value;
        }

        $expense_request_arr = array();
        foreach ($expense_request as $key => $value) {
            $expense_request_arr[$value['id']] = $value;
        }

        $cancellation_pending_request_arr = array();
        foreach ($cancellation_pending_request as $key => $value) {
            $cancellation_pending_request_arr[$value['id']] = $value;
        }

        $completed_request_request_arr = array();
        foreach ($completed_request as $key => $value) {
            $completed_request_request_arr[$value['id']] = $value;
        }

        $view_request = array('pending_request' => $pending_request_arr);
        $view_request['cancel_request'] = $cancellation_pending_request_arr;
        $view_request['expense_request'] = $expense_request_arr;
        $view_request['completed_request'] = $completed_request_request_arr;

        $this->template->write_view('content', 'employee_request/inbox_request', $view_request);
        $this->template->render();
    }

    function approval_request($request_id) {
        $employee_id = $this->session->userdata('employee_id');

        $request = $this->travel_request->get_manager_request_by_id($request_id, $employee_id);
//        po($request);
        if (empty($request)) {
            $this->session->set_flashdata('error', "Something went wrong!");
            redirect(base_url() . dashboard);
        }
        $view_request = array('request' => $request, 'request_id' => $request_id);


        if ($request['group_travel'] == "1") {
            $member_list = $this->travel_request->get_all_member_list_by_id($request_id);
            $view_request['member_list'] = $member_list;
            $member_other_list = $this->travel_request->get_all_member_other_list_by_id($request_id);
            $view_request['member_other_list'] = $member_other_list;
        }

        $empID = $request['employee_id'];
        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee_by_id($empID);
        $grade_id = $employee['grade_id'];
        $travel_type = $request['travel_type'];
        $city_id = $request['to_city_id'];

        $this->load->model("city_model");
        $to_city = $this->city_model->get_city($city_id);
        $to_class = $to_city['class'];

        $this->load->model('travel_policy_model');
//        $view_request['policy_data'] = $this->travel_policy_model->get_travel_policy_by_grade($grade_id, $travel_type);
//        po($view_request['policy_data']);


        $traverl_class_data = $this->travel_request->get_travel_class_by_grade($grade_id, $travel_type);
        if (isset($traverl_class_data['name'])) {
            $view_request['sel_traverl_class'] = $traverl_class_data['name'];
        } else {
            $view_request['sel_traverl_class'] = "";
        }
//        if (isset($traverl_class_data['travel_class'])) {
//            $travel_class = $traverl_class_data['travel_class'];
//        } else {
//            $travel_class = "";
//        }

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


        if ($request['travel_reason_id'] != "Projects") {
            $dept_id = $employee['dept_id'];
            $this->load->model("budget_model");
            $financial_year = date('Y');
            $budget = $this->budget_model->get_budget_by_dept($dept_id, $financial_year);
            $view_request['budget'] = $budget;
        } else {
            $project_id = $request['project_id'];
            $this->load->model("projects_model");
            $project = $this->projects_model->get_project($project_id);
            $view_request['budget'] = $project;
        }

        $request = $this->travel_request->get_last_few_request_by_empid($empID, $request_id);
        $view_request['last_few_req'] = $request;

        $this->template->write_view('content', 'employee_request/approval_request', $view_request);
        $this->template->render();
    }

    function approve_request($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['approval_status'] != 'Approved') {
                $data_array = array(
                    'approval_status' => 'Approved',
                    'approve_comment' => $this->input->post('approve_comment'),
                    'approval_datetime' => date('Y-m-d H:i:s'),
                    'request_status' => '2',
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    if ($request['travel_type'] == "1") {
                        $travel_mode = "Flight";
                    } else if ($request['travel_type'] == "2") {
                        $travel_mode = "Train";
                    } else if ($request['travel_type'] == "3") {
                        $travel_mode = "Car";
                    } else if ($request['travel_type'] == "4") {
                        $travel_mode = "Bus";
                    }

                    if ($request['trip_type'] == "0" || $request['trip_type'] == "") {
                        $now = strtotime(date('Y-m-d', strtotime($request['departure_date'])));
                        $your_date = strtotime(date('Y-m-d', strtotime($request['return_date'])));
                        $datediff = $your_date - $now;
                        $travel_day = floor($datediff / (60 * 60 * 24));
                        $travel_date = $request['departure_date'] . " To " . $request['return_date'];
                    } else {
                        $travel_day = "1";
                        $travel_date = $request['departure_date'];
                    }

                    $email_template = $this->common->select_data_by_id('email_format', 'mail_id', '4');
                    if (!empty($email_template)) {
                        $request_data = $this->travel_request->get_request_details_by_id($request_id);
                        $request_data['amount'] = $request_data['hotel_allowance'] + $request_data['da_allowance'] + $request_data['convince_allowance'];

                        $departure_date = $request_data['departure_date'];
                        $return_date = $request_data['return_date'];
                        if ($return_date == '') {
                            $request_data['travel_datetime'] = date(DATETIME_FORMAT, strtotime($departure_date));
                            $request_data['day_plan'] = "1";
                        } else {
                            $now = strtotime(date('Y-m-d', strtotime($departure_date)));
                            $your_date = strtotime(date('Y-m-d', strtotime($return_date)));
                            $datediff = $your_date - $now;
                            $request_data['day_plan'] = floor($datediff / (60 * 60 * 24));
                            $request_data['travel_datetime'] = date(DATETIME_FORMAT, strtotime($departure_date)) . " To " . date(DATETIME_FORMAT, strtotime($return_date));
                        }

                        if ($request_data['travel_type'] == "1") {
                            $travel_mode = "Flight";
                        } else if ($request_data['travel_type'] == "2") {
                            $travel_mode = "Train";
                        } else if ($request_data['travel_type'] == "3") {
                            $travel_mode = "Car";
                        } else if ($request_data['travel_type'] == "4") {
                            $travel_mode = "Bus";
                        } else {
                            $travel_mode = "";
                        }
                        $request_data['travel_mode'] = $travel_mode;
                        $request_data['url'] = "<a target='_blanck' href='" . base_url('employee_request/accommodation/') . "/" . $request_id . "' style='text-decoration-line: none;'>Click here</a>";

                        $subject = $email_template[0]['subject'];
                        $mailformat = $email_template[0]['emailformat'];
                        $subject = str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($subject))))))))))));
                        $message = str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($mailformat))))))))))));

                        $to = $request['email'];
                        $this->sendEmail($to, $subject, $message);
                    }

                    $this->session->set_flashdata('success', 'Request Approved successfully');
                    redirect(base_url() . 'employee_request/inbox');
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'employee_request/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already approved');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function reject_request($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
            redirect(base_url() . 'employee_request/inbox');
        } else {
            if ($request['approval_status'] != 'Rejected') {
                $data_array = array(
                    'approval_status' => 'Rejected',
                    'reject_reason' => $this->input->post('reject_reason'),
                    'approve_comment' => $this->input->post('reject_comment'),
                    'approval_datetime' => date('Y-m-d H:i:s'),
                    'request_status' => '2',
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    $email_template = $this->common->select_data_by_id('email_format', 'mail_id', '3');
                    if (!empty($email_template)) {
                        $request_data = $this->travel_request->get_request_details_by_id($request_id);
                        $request_data['amount'] = $request_data['hotel_allowance'] + $request_data['da_allowance'] + $request_data['convince_allowance'];

                        $departure_date = $request_data['departure_date'];
                        $return_date = $request_data['return_date'];
                        if ($return_date == '') {
                            $request_data['travel_datetime'] = date(DATETIME_FORMAT, strtotime($departure_date));
                            $request_data['day_plan'] = "1";
                        } else {
                            $now = strtotime(date('Y-m-d', strtotime($departure_date)));
                            $your_date = strtotime(date('Y-m-d', strtotime($return_date)));
                            $datediff = $your_date - $now;
                            $request_data['day_plan'] = floor($datediff / (60 * 60 * 24));
                            $request_data['travel_datetime'] = date(DATETIME_FORMAT, strtotime($departure_date)) . " To " . date(DATETIME_FORMAT, strtotime($return_date));
                        }

                        $request_data['reject_comment'] = $this->input->post('reject_comment');
                        $reject_reason = $this->input->post('reject_reason');

                        if ($reject_reason == "1") {
                            $request_data['reject_reason'] = "Do the work through Hangouts";
                        } else if ($reject_reason == "2") {
                            $request_data['reject_reason'] = "Byond Travel Date";
                        } else if ($reject_reason == "3") {
                            $request_data['reject_reason'] = "Budget Not Approved";
                        } else if ($reject_reason == "4") {
                            $request_data['reject_reason'] = "Travel Plan Changed";
                        }

                        if ($request_data['travel_type'] == "1") {
                            $travel_mode = "Flight";
                        } else if ($request_data['travel_type'] == "2") {
                            $travel_mode = "Train";
                        } else if ($request_data['travel_type'] == "3") {
                            $travel_mode = "Car";
                        } else if ($request_data['travel_type'] == "4") {
                            $travel_mode = "Bus";
                        } else {
                            $travel_mode = "";
                        }
                        $request_data['travel_mode'] = $travel_mode;
                        $request_data['url'] = "<a target='_blanck' href='" . base_url("employee_request/approval_request/") . "/" . $request_id . "' style='text-decoration-line: none;'>Click here</a>";

                        $subject = $email_template[0]['subject'];
                        $mailformat = $email_template[0]['emailformat'];
                        $subject = str_replace("%reject_reason%", $request_data['reject_reason'], str_replace("%reject_comment%", $request_data['reject_comment'], str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($subject))))))))))))));
                        $message = str_replace("%reject_comment%", $request_data['reject_comment'], str_replace("%reject_reason%", $request_data['reject_reason'], str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($mailformat))))))))))))));

//                        $cc = $request_data['employee_email'];
                        $to = $request_data['employee_email'];
                        $this->sendEmail($to, $subject, $message);
                    }

                    $this->session->set_flashdata('success', 'Request Rejected successfully');
                    redirect(base_url() . 'employee_request/inbox');
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'employee_request/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function cancel_trip_request($request_id) {
        $view_request = array();
        $request = $this->travel_request->get_all_request_by_id($request_id);
        $view_request['request'] = $request;
        $view_request['request_id'] = $request_id;
        $empID = $request['employee_id'];

        if ($request['request_status'] >= '4') {
            if ($request['trip_ticket'] == '1') {
                if ($request['travel_type'] == '1') {
                    $flight_booking = $this->travel_request->get_flight_ticket_booking($request_id);
                    $view_request['flight_booking'] = $flight_booking;
                }
                if ($request['travel_type'] == '2') {
                    $train_booking = $this->travel_request->get_train_ticket_booking($request_id);
                    $view_request['train_booking'] = $train_booking;
                }
                if ($request['travel_type'] == '3') {
                    $car_booking = $this->travel_request->get_car_ticket_booking($request_id);
                    $view_request['car_booking'] = $car_booking;
                }
                if ($request['travel_type'] == '4') {
                    $bus_booking = $this->travel_request->get_bus_ticket_booking($request_id);
                    $view_request['bus_booking'] = $bus_booking;
                }
            }

            if ($request['hotel_booking'] == '1') {
                $hotel_booking = $this->travel_request->get_hotel_booking($request_id);
                $view_request['hotel_booking'] = $hotel_booking;
            }

            if ($request['car_booking'] == '1') {
                $car_booking = $this->travel_request->get_car_booking($request_id);
                $view_request['car_booking'] = $car_booking;
            }
        }

        if ($request['group_travel'] == "1") {
            $member_list = $this->travel_request->get_all_member_list_by_id($request_id);
            $view_request['member_list'] = $member_list;

            $member_other_list = $this->travel_request->get_all_member_other_list_by_id($request_id);
            $view_request['member_other_list'] = $member_other_list;
        }

        $this->template->write_view('content', 'employee_request/cancel_trip_request', $view_request);
        $this->template->render();
    }

    function cancel_request($request_id) {
        $view_request = array();
        $request = $this->travel_request->get_all_request_by_id($request_id);
        $view_request['request'] = $request;
        $view_request['request_id'] = $request_id;
        $empID = $request['employee_id'];
        if ($request['request_status'] >= '4') {
            $full_cancellation = 0;
            if ($request['trip_ticket'] == '1') {
                if ($request['travel_type'] == '1') {
                    $flight_booking = $this->travel_request->get_flight_ticket_booking($request_id);
                    $view_request['flight_booking'] = $flight_booking;
                    if ($flight_booking['cancel_status'] == "0") {
                        $full_cancellation++;
                    }
                }
                if ($request['travel_type'] == '2') {
                    $train_booking = $this->travel_request->get_train_ticket_booking($request_id);
                    $view_request['train_booking'] = $train_booking;
                    if ($train_booking['cancel_status'] == "0") {
                        $full_cancellation++;
                    }
                }
                if ($request['travel_type'] == '3') {
                    $car_booking = $this->travel_request->get_car_ticket_booking($request_id);
                    $view_request['car_booking'] = $car_booking;
                    if ($car_booking['cancel_status'] == "0") {
                        $full_cancellation++;
                    }
                }
                if ($request['travel_type'] == '4') {
                    $bus_booking = $this->travel_request->get_bus_ticket_booking($request_id);
                    $view_request['bus_booking'] = $bus_booking;
                    if ($bus_booking['cancel_status'] == "0") {
                        $full_cancellation++;
                    }
                }
            }

            if ($request['hotel_booking'] == '1') {
                $hotel_booking = $this->travel_request->get_hotel_booking($request_id);
                $view_request['hotel_booking'] = $hotel_booking;
                if ($hotel_booking['cancel_status'] == "0") {
                    $full_cancellation++;
                }
            }

            if ($request['car_booking'] == '1') {
                $car_booking = $this->travel_request->get_car_booking($request_id);
                $view_request['car_booking'] = $car_booking;
                if ($car_booking['cancel_status'] == "0") {
                    $full_cancellation++;
                }
            }

            if ($request['group_travel'] == "1") {
                $member_list = $this->travel_request->get_all_member_list_by_id($request_id);
                $member_id = '';

                foreach ($member_list as $value) {
                    if ($value['status'] == 'pending') {
                        $member_id = $value['employee_id'];
                    }
                }

                $view_request['member_list'] = $member_list;

                $member_other_list = $this->travel_request->get_all_member_other_list_by_id($request_id);
                foreach ($member_other_list as $value) {
                    if ($value['status'] == 'pending') {
                        $member_id = $value['id'];
                    }
                }
                $view_request['member_id'] = $member_id;

                $view_request['member_other_list'] = $member_other_list;
            }
            $view_request['full_cancellation'] = $full_cancellation;
        }

        $this->template->write_view('content', 'employee_request/cancel_request', $view_request);
        $this->template->render();
    }

    function canceled_trip($request_id = '', $ticket_type = '', $full_cancellation = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['approval_status'] == 'Approved') {
                if ($request['request_status'] == '3') {
                    $data_array = array(
                        'status' => 'cancel',
                        'cancellation_comment' => $this->input->post('comment'),
                        'cancel_status' => '1',
                    );
                    if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                        $subject = "Trip Cancellation Status";
                        $reference_id = $request['reference_id'];
                        $messege = "Your Trip " . $reference_id . " Cancelled";
                        $to = $request['email'];
                        $this->sendEmail($to, $subject, $messege);

                        $this->session->set_flashdata('success', 'Request Cancelled successfully');
                        redirect(base_url() . 'employee_request/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                } else {
                    if ($ticket_type == '') {
                        $data_array = array(
                            'cancellation_comment' => $this->input->post('comment'),
                            'cancel_status' => '4',
                        );
                    } else {
                        $data_array = array(
                            'cancellation_comment' => $this->input->post('comment'),
                            'cancel_status' => '5',
                        );
                    }
                    if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                        $subject = "Trip Cancellation Status";
                        $reference_id = $request['reference_id'];
                        $messege = "Your Trip " . $reference_id . " for Cancellation is Approved";
                        $to = $request['email'];
                        $this->sendEmail($to, $subject, $messege);

                        $this->session->set_flashdata('success', 'Request Cancelled successfully');
                        redirect(base_url() . 'employee_request/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function canceled_trip_member($request_id, $employee_id) {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($request['approval_status'] == 'Approved') {
                if ($request['group_travel'] == "1") {
                    $data_array = array(
                        'status' => 'leave',
                    );
                    if ($this->common->update_data($data_array, 'travel_request_member', 'employee_id', $employee_id)) {
                        $data_array = array(
                            'cancel_status' => '0',
                        );
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Member Cancelled successfully');
                            redirect(base_url() . 'employee_request/inbox');
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect(base_url() . 'employee_request/inbox');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function canceled_trip_guest($request_id, $guest_id) {

        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['approval_status'] == 'Approved') {
                if ($request['group_travel'] == "1") {
                    $data_array = array(
                        'status' => 'leave',
                    );
                    if ($this->common->update_data($data_array, 'travel_request_member_others', 'id', $guest_id)) {
                        $data_array = array(
                            'cancel_status' => '0',
                        );
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Member Cancelled successfully');
                            redirect(base_url() . 'employee_request/inbox');
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect(base_url() . 'employee_request/inbox');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function cancel_group_employee($request_id, $employee_id) {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['approval_status'] == 'Approved') {
                if ($request['group_travel'] == "1") {
                    $data_array = array(
                        'status' => 'pending',
                    );
                    if ($this->common->update_data($data_array, 'travel_request_member', 'employee_id', $employee_id)) {
                        $data_array = array(
                            'cancellation_comment' => $this->input->post('comment'),
                            'cancel_status' => '6',
                        );
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Request Cancelled successfully');
                            redirect(base_url() . 'employee_request/inbox');
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect(base_url() . 'employee_request/inbox');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'employee_request/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function cancel_group_guest($request_id, $guest_id) {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['approval_status'] == 'Approved') {
                if ($request['group_travel'] == "1") {
                    $data_array = array(
                        'status' => 'pending',
                    );
                    if ($this->common->update_data($data_array, 'travel_request_member_others', 'id', $guest_id)) {
                        $data_array = array(
                            'cancellation_comment' => $this->input->post('comment'),
                            'cancel_status' => '6',
                        );
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                            $this->session->set_flashdata('success', 'Request Cancelled successfully');
                            redirect(base_url() . 'employee_request/inbox');
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect(base_url() . 'employee_request/inbox');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'employee_request/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function download_attchment($file_name = '') {
        if ($file_name != '') {
            $file_path = $this->config->item('upload_booking_attch_path') . '/' . $file_name;
            if (file_exists($file_path)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file_path));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                ob_clean();
                flush();
                readfile($file_path);
            }
        }
    }

    function claim($request_id) {
        $total_travel_claim = 0;
        $total_unpaid_claim = 0;
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->expense->get_claim_request_by_id($request_id, $employee_id);
        if (empty($request)) {
            $this->session->set_flashdata('error', "Something went wrong!");
            redirect(base_url() . dashboard);
        }
        $view_request = array('request' => $request);
        if ($request['project_id'] != '') {
            $project_id = $request['project_id'];
            $this->load->model("projects_model");
            $view_request['project'] = $this->projects_model->get_project($project_id);
        }

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


        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee_id($employee_id);
        $view_request['employee'] = $employee;

        $expense_details = $this->expense->get_expense_pending($request_id);
        
        
        $other_expense = $this->expense->get_other_expense($request_id);
        $view_request['other_expense'] = $other_expense;

        if (!empty($expense_details)) {
            $this->load->library('encryption');
            $this->encryption->initialize(array('driver' => 'mcrypt'));
            $this->encryption->initialize(array('driver' => 'openssl'));
            $expense_details['credit_card_number'] = $this->encryption->decrypt($expense_details['credit_card_number']);
            $expense_details['bank_name'] = $this->encryption->decrypt($expense_details['bank_name']);
            if ($expense_details['expense_status'] == "Approved") {
                $this->session->set_flashdata('error', 'Expense Already Aproved');
                redirect(base_url() . 'employee_request/index');
            } else {
                if ($expense_details['expense_status'] == "Clarification") {
                    $expense_id = $expense_details['id'];
                    
                    $other_trip_expense = $this->expense->get_other_trip_expense($request_id);
                    $view_request['other_trip_expense'] = $other_trip_expense;
                    $other_loading_booking = $this->expense->get_other_loading_booking($request_id);
                    $view_request['other_loading_booking'] = $other_loading_booking;
                    $other_con_booking = $this->expense->get_other_con_booking($request_id);
                    $view_request['other_con_booking'] = $other_con_booking;
                } else {
                    $expense_id = '';
                }
            }
        } else {
            $expense_id = '';
        }
        $view_request['expense_details'] = $expense_details;

        if ($request['trip_type'] != "1") {
            $first_date = new DateTime($request['departure_date']);
            $second_date = new DateTime($request['return_date']);
            $interval = $first_date->diff($second_date);
            $day = $interval->format("%d");
            $hours = $interval->format("%h");
        } else {
            if (!empty($expense_details)) {
                $first_date = new DateTime($request['departure_date']);
                $second_date = new DateTime($request['return_date']);
                $interval = $first_date->diff($second_date);
                $day = $interval->format("%d");
                $hours = $interval->format("%h");
            } else {
                $day = $view_request['day'] = "1";
                $hours = $view_request['hours'] = "";
            }
        }

        $view_request['day'] = $day;
        $view_request['hours'] = $hours;


//        if ($day == '0') {
//            $day = $view_request['day'] = '1';
//        }

        $da_total = $request['DA_allowance'] * $day;

        if ($hours != '0') {
            if ($hours != '') {
                if ($hours < 14) {
                    $da = $request['DA_allowance'] / 2;
                    $da_total = $da_total + $da;
                } else {
                    $da_total = $da_total + $request['DA_allowance'];
                }
            }
        }

//        echo $da_total;
//        die();
        $total_travel_claim = $total_travel_claim + $da_total;
        $total_unpaid_claim = $total_unpaid_claim + $da_total;

        $ticket_details = array();
        $hotel_details = array();
        $car_details = array();

        if ($request['request_status'] >= '4') {
            if ($request['trip_ticket'] == '1') {
                if ($request['travel_type'] == '1') {
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
                        $data_array['cost'] = $flight_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $flight_booking[1]['cost'];
                        $data_array['attachment'] = $flight_booking[1]['flight_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $flight_booking[0]['cost'];
                            $total_unpaid_claim = $total_unpaid_claim + $flight_booking[1]['cost'];
                        }
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '1';
                        $data_array['type'] = '1';
                        $data_array['trip_mode'] = $flight_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $flight_booking[0]['arrange_by'];
                        $data_array['cost'] = $flight_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $flight_booking[0]['cost'];
                        $data_array['attachment'] = $flight_booking[0]['flight_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $flight_booking[0]['cost'];
                        }
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
                        $data_array['cost'] = $train_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $train_booking[1]['cost'];
                        $data_array['attachment'] = $train_booking[1]['train_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $train_booking[0]['cost'];
                            $total_unpaid_claim = $total_unpaid_claim + $train_booking[1]['cost'];
                        }
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '2';
                        $data_array['type'] = '2';
                        $data_array['trip_mode'] = $train_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $train_booking[0]['arrange_by'];
                        $data_array['cost'] = $train_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $train_booking[0]['cost'];
                        $data_array['attachment'] = $train_booking[0]['train_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $train_booking[0]['cost'];
                        }
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
                        $data_array['cost'] = $car_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $car_booking[1]['cost'];
                        $data_array['attachment'] = $car_booking[1]['car_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $car_booking[0]['cost'];
                            $total_unpaid_claim = $total_unpaid_claim + $car_booking[1]['cost'];
                        }
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '3';
                        $data_array['type'] = '3';
                        $data_array['trip_mode'] = $car_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $car_booking[0]['arrange_by'];
                        $data_array['cost'] = $car_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $car_booking[0]['cost'];
                        $data_array['attachment'] = $car_booking[0]['car_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $car_booking[0]['cost'];
                        }
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
                        $data_array['cost'] = $bus_booking[1]['cost'];
                        $total_travel_claim = $total_travel_claim + $bus_booking[1]['cost'];
                        $data_array['attachment'] = $bus_booking[1]['bus_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $bus_booking[0]['cost'];
                            $total_unpaid_claim = $total_unpaid_claim + $bus_booking[1]['cost'];
                        }
                    } else {
                        $data_array = array();
                        $data_array['date'] = $request['departure_date'];
                        $data_array['location_from'] = $request['from_city_name'];
                        $data_array['location_to'] = $request['to_city_name'];
                        $data_array['travel_type'] = '4';
                        $data_array['type'] = '4';
                        $data_array['trip_mode'] = $bus_booking[0]['trip_mode'];
                        $data_array['arrange_by'] = $bus_booking[0]['arrange_by'];
                        $data_array['cost'] = $bus_booking[0]['cost'];
                        $total_travel_claim = $total_travel_claim + $bus_booking[0]['cost'];
                        $data_array['attachment'] = $bus_booking[0]['bus_attachment'];
                        $ticket_details[] = $data_array;
                        if ($request['travel_ticket'] == "2") {
                            $total_unpaid_claim = $total_unpaid_claim + $bus_booking[0]['cost'];
                        }
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
                $data_array['loading_expense_1'] = $hotel_booking['loading_expense_1'];
                $data_array['other_expense_1'] = $hotel_booking['other_expense_1'];
                $data_array['cost'] = $hotel_booking['cost'];
                $data_array['arrange_by'] = $hotel_booking['arrange_by'];
                $data_array['type'] = '6';

                $data_array['attachment'] = $hotel_booking['hotel_attchment'];
                $hotel_details[] = $data_array;
                if ($hotel_booking['arrange_by'] == "Own") {
                    $total_unpaid_claim = $total_unpaid_claim + $hotel_booking['cost'];
                    $total_travel_claim = $total_travel_claim + $hotel_booking['cost'];
                } else {
                    $total_travel_claim = $total_travel_claim + $hotel_booking['cost'];
                }
            }

            if ($request['car_booking'] == '1') {
                $car_booking = $this->travel_request->get_car_booking($request_id);
                $view_request['car_booking'] = $car_booking;
                $data_array = array();
                $data_array['date'] = $car_booking['drop_off_date'];
                $data_array['location_from'] = $car_booking['pick_up_location'];
                $data_array['location_to'] = $car_booking['drop_off_location'];
                $data_array['travel_type'] = '3';
                $data_array['type'] = '5';
                $data_array['arrange_by'] = $car_booking['arrange_by'];
                $data_array['book_by'] = $car_booking['book_by'];
                $data_array['cost'] = $car_booking['cost'];
                $total_travel_claim = $total_travel_claim + $car_booking['cost'];
                $data_array['attachment'] = $car_booking['car_attchment'];
                $car_details[] = $data_array;
                if ($request['car_hire'] == "2") {
                    $total_unpaid_claim = $total_unpaid_claim + $car_booking['cost'];
                }
            }
        }
        $view_request['ticket_details'] = $ticket_details;
        $view_request['hotel_details'] = $hotel_details;
        $view_request['car_details'] = $car_details;
        $view_request['total_travel_claim'] = $total_travel_claim;
        $view_request['total_unpaid_claim'] = $total_unpaid_claim;


        $employee = $this->employee_model->get_employee_by_id($employee_id);
        $grade_id = $employee['grade_id'];
        $travel_type = $request['travel_type'];
        $city_id = $request['to_city_id'];

        $this->load->model("city_model");
        $to_city = $this->city_model->get_city($city_id);
        $to_class = $to_city['class'];

        $this->load->model("grades_model");
        $grade = $this->employee_model->get_grade_details($grade_id);
        if ($grade['travel_mode'] == "1") {
            $eligibility_mode = "Flight";
        } else if ($grade['travel_mode'] == "2") {
            $eligibility_mode = "Train";
        } else if ($grade['travel_mode'] == "3") {
            $eligibility_mode = "Car";
        } else if ($grade['travel_mode'] == "4") {
            $eligibility_mode = "Bus";
        }
        $view_request['eligibility_mode'] = $eligibility_mode;
        $view_request['eligibility_class'] = $grade['travel_class'];


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



//<!------------------------------------------   POST DATA ------------------------------------------!>//
        if ($this->input->post()) {
            $DA_allowance;
            $convince_allowance;
            $total_eligibility = 0;
            $expense_da = $this->input->post('expense_da');
            $expense_con = $this->input->post('expense_con');
            $total_policy = $expense_da + $expense_con;
            $flag = 0;
            $policy_meet = 0;

            if ($DA_allowance != 'Actual') {
                $total_eligibility = $total_eligibility + $DA_allowance;
            }
            if ($convince_allowance != 'Actual') {
                $total_eligibility = $total_eligibility + $convince_allowance;
            }

            if ($total_eligibility != 0) {
                if ($total_eligibility < $total_policy) {
                    $policy_meet = 1;
                }
            }

            if (isset($_FILES['other_attachment']['name']) && $_FILES['other_attachment']['name'] != null) {
                $other_attachment = $_FILES['other_attachment']['name'];
                foreach ($other_attachment as $key => $value) {
                    if (!empty($value)) {
                        $_FILES['other_attach']['name'] = $value;
                        $_FILES['other_attach']['type'] = $_FILES['other_attachment']['type'][$key];
                        $_FILES['other_attach']['tmp_name'] = $_FILES['other_attachment']['tmp_name'][$key];
                        $_FILES['other_attach']['error'] = $_FILES['other_attachment']['error'][$key];
                        $_FILES['other_attach']['size'] = $_FILES['other_attachment']['size'][$key];
                        $file_name = $_FILES['other_attach']['name'];
                        $enc_filename = $this->GenerateRandomFilename($file_name);
                        $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $enc_filename;
                        $config['max_size'] = 2048;

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('other_attach')) {
                            $upload_data = $this->upload->data();
                            $data_array = array(
                                'request_id' => $request_id,
                                'file_name' => $upload_data['file_name'],
                            );
                            if (!$this->common->insert_data($data_array, 'expense_attachment')) {
                                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                                redirect(base_url() . employee_request);
                            }
                        } else {
                            $this->db->where('request_id', $request_id);
                            $this->db->delete('expense_attachment');

                            if ($this->db->affected_rows() > 0) {
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error', $error['error']);
                                redirect('employee_request/index', 'refresh');
                            } else {
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error', $error['error']);
                                redirect('employee_request/index', 'refresh');
                            }
                        }
                    }
                }
            }

            $trip_date = $this->input->post('trip_date');
            $trip_book_by = $this->input->post('trip_book_by');
            $trip_arrange_by = $this->input->post('trip_arrange_by');

            $trip_from = $this->input->post('trip_from');
            $trip_to = $this->input->post('trip_to');
            $total_trip = $this->input->post('total_trip_no');
            if ($trip_from != '') {
                $this->db->where('request_id', $request_id);
                $this->db->delete('other_trip_booking');
            }
            foreach ($trip_from as $key => $value) {
                if ($trip_from[$key] != '' && $trip_to[$key] != '' && $total_trip != '' && $trip_date[$key] != '' && $trip_book_by != '' && $trip_arrange_by != '') {
                    $data_array = array(
                        'request_id' => $request_id,
                        'trip_from' => $trip_from[$key],
                        'trip_to' => $trip_to[$key],
                        'total' => $total_trip[$key],
                        'trip_date' => date(DATEMYSQL, strtotime($trip_date[$key])),
                        'trip_book_by' => $trip_book_by[$key],
                        'trip_arrange_by' => $trip_arrange_by[$key],
                    );

                    if (!$this->common->insert_data($data_array, 'other_trip_booking')) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . employee_request);
                    }
                }
            }

            $con_date = $this->input->post('con_date');
            $con_from = $this->input->post('con_from');
            $con_to = $this->input->post('con_to');
            $con_book_by = $this->input->post('con_book_by');
            $con_arrange_by = $this->input->post('con_arrange_by');
            $total_con = $this->input->post('total_con_no');
            if ($con_from != '') {
                $this->db->where('request_id', $request_id);
                $this->db->delete('other_con_booking');
            }
            foreach ($con_from as $key => $value) {
                if ($con_from[$key] != '' && $con_to[$key] != '' && $total_con != '') {
                    $data_array = array(
                        'request_id' => $request_id,
                        'con_date' => date(DATEMYSQL, strtotime($con_date[$key])),
                        'con_from' => $con_from[$key],
                        'con_to' => $con_to[$key],
                        'con_book_by' => $con_book_by[$key],
                        'con_arrange_by' => $con_arrange_by[$key],
                        'total' => $total_con[$key],
                    );

                    if (!$this->common->insert_data($data_array, 'other_con_booking')) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . employee_request);
                    }
                }
            }

            $loading_departure = $this->input->post('loading_departure');
            $loading_return = $this->input->post('loading_return');
            $load_location = $this->input->post('load_location');
            $load_room_no = $this->input->post('load_room_no');
            $load_bill_no = $this->input->post('load_bill_no');
            $loading_expense = $this->input->post('loading_expense');
            $other_expense = $this->input->post('other_expense');
            $loading_total = $this->input->post('loading_total');
            $load_arrange_by = $this->input->post('load_arrange_by');

            if ($loading_total != '') {
                $this->db->where('request_id', $request_id);
                $this->db->delete('other_loading_booking');
            }
            foreach ($loading_total as $key => $value) {
                if ($loading_total[$key] != '' && $loading_expense[$key] != '' && $other_expense != '') {
                    $data_array = array(
                        'request_id' => $request_id,
                        'loading_departure' => date(DATEMYSQL, strtotime($loading_departure[$key])),
                        'loading_return' => date(DATEMYSQL, strtotime($loading_return[$key])),
                        'location' => $load_location[$key],
                        'room_no' => $load_room_no[$key],
                        'bill_no' => $load_bill_no[$key],
                        'loading_expense' => $loading_expense[$key],
                        'other_expense' => $other_expense[$key],
                        'loading_total' => $loading_total[$key],
                        'arrange_by' => $load_arrange_by[$key],
                    );

                    if (!$this->common->insert_data($data_array, 'other_loading_booking')) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . employee_request);
                    }
                }
            }

            $da_actual = $this->input->post('da_actual');
            if ($da_actual == "1") {
                $da_allowance = $this->input->post('da_allowance');
                $data_array = array(
                    'DA_allowance' => $da_allowance,
                );
                if (!$this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_0_arrange_by_1')) {
                $arrange_by = $this->input->post('ticket_0_arrange_by_1');
                $data_array = array(
                    'arrange_by' => $arrange_by,
                );
                if ($this->input->post('ticket_cost_1')) {
                    $data_array['cost'] = $this->input->post('ticket_cost_1');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '0',
                );
                if (!$this->common->update_data_by_conditions($data_array, 'flight_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_1_arrange_by_1')) {
                $arrange_by = $this->input->post('ticket_1_arrange_by_1');
                $data_array = array(
                    'arrange_by' => $arrange_by,
                );
                if ($this->input->post('ticket_cost_2')) {
                    $data_array['cost'] = $this->input->post('ticket_cost_2');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '1',
                );
                if (!$this->common->update_data_by_conditions($data_array, 'flight_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_0_arrange_by_2')) {
                $arrange_by2 = $this->input->post('ticket_0_arrange_by_2');
                $data_array2 = array(
                    'arrange_by' => $arrange_by2,
                );
                if ($this->input->post('ticket_cost_1')) {
                    $data_array2['cost'] = $this->input->post('ticket_cost_1');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '0',
                );
                if (!$this->common->update_data_by_conditions($data_array2, 'train_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_1_arrange_by_2')) {
                $arrange_by2 = $this->input->post('ticket_1_arrange_by_2');
                $data_array2 = array(
                    'arrange_by' => $arrange_by2,
                );
                if ($this->input->post('ticket_cost_2')) {
                    $data_array2['cost'] = $this->input->post('ticket_cost_2');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '1',
                );
                if (!$this->common->update_data_by_conditions($data_array2, 'train_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_0_arrange_by_3')) {
                $arrange_by2 = $this->input->post('ticket_0_arrange_by_3');
                $data_array2 = array(
                    'arrange_by' => $arrange_by2,
                );
                if ($this->input->post('ticket_cost_1')) {
                    $data_array2['cost'] = $this->input->post('ticket_cost_1');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '0',
                );
                if (!$this->common->update_data_by_conditions($data_array2, 'car_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_1_arrange_by_3')) {
                $arrange_by2 = $this->input->post('ticket_1_arrange_by_3');
                $data_array2 = array(
                    'arrange_by' => $arrange_by2,
                );
                if ($this->input->post('ticket_cost_2')) {
                    $data_array2['cost'] = $this->input->post('ticket_cost_2');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '1',
                );
                if (!$this->common->update_data_by_conditions($data_array2, 'car_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_0_arrange_by_4')) {
                $arrange_by2 = $this->input->post('ticket_0_arrange_by_4');
                $data_array2 = array(
                    'arrange_by' => $arrange_by2,
                );
                if ($this->input->post('ticket_cost_1')) {
                    $data_array2['cost'] = $this->input->post('ticket_cost_1');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '0',
                );
                if (!$this->common->update_data_by_conditions($data_array2, 'bus_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_1_arrange_by_4')) {
                $arrange_by2 = $this->input->post('ticket_1_arrange_by_4');
                $data_array2 = array(
                    'arrange_by' => $arrange_by2,
                );
                if ($this->input->post('ticket_cost_2')) {
                    $data_array2['cost'] = $this->input->post('ticket_cost_2');
                }
                $condition_array = array(
                    'request_id' => $request_id,
                    'trip_mode' => '1',
                );
                if (!$this->common->update_data_by_conditions($data_array2, 'bus_ticket_booking', $condition_array)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            if ($this->input->post('ticket_arrange_by_5')) {
                $arrange_by = $this->input->post('ticket_arrange_by_5');
                $data_array = array(
                    'arrange_by' => $arrange_by,
                );
                if (!$this->common->update_data($data_array, 'car_booking', 'request_id', $request_id)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }

            $data_array = array(
                'bill_no_1' => $this->input->post('bill_no_1'),
                'cost' => $this->input->post('hotel_cost'),
                'loading_expense_1' => $this->input->post('loading_expense_1'),
                'other_expense_1' => $this->input->post('other_expense_1'),
            );
            if ($this->input->post('date_from_1')) {
                $data_array['check_in_date'] = date(DATEMYSQL, strtotime($this->input->post('date_from_1')));
            }
            if ($this->input->post('date_to_1')) {
                $data_array['check_out_date'] = date(DATEMYSQL, strtotime($this->input->post('date_to_1')));
            }
            if ($this->input->post('load_arrange_by_1')) {
                $data_array['arrange_by'] = $this->input->post('load_arrange_by_1');
            }
            if ($this->input->post('bill_no')) {
                $data_array['bill_no'] = $this->input->post('bill_no');
            }
            if ($this->input->post('bill_no_1')) {
                $data_array['bill_no_1'] = $this->input->post('bill_no_1');
            }

//            po($data_array);
            if (!$this->common->update_data($data_array, 'hotel_booking', 'request_id', $request_id)) {
                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                redirect(base_url() . employee_request);
            }

            if ($this->input->post('con_total_1')) {
                $data_array = array();
                $data_array['cost'] = $this->input->post('con_total_1');
                $data_array['pick_up_date'] = date(DATEMYSQL, strtotime($this->input->post('con_date_1')));
                if (!$this->common->update_data($data_array, 'car_booking', 'request_id', $request_id)) {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }



            $other_row = $this->input->post('other_row');

            $other_date = $this->input->post('other_date');
            $other_arrange_by = $this->input->post('other_arrange_by');

            $expense_name = $this->input->post('expense_name');
            $expense_type = $this->input->post('expense_type');
            $bill_no = $this->input->post('expense_bill_no');
            $total_no = $this->input->post('total_no');


            if ($expense_id != '') {
                $this->db->where('request_id', $request_id);
                $this->db->delete('other_expense');
            }

            foreach ($expense_name as $key => $value) {
                if ($expense_name[$key] != '' && $total_no[$key] != '') {
                    $data_array = array(
                        'employees_id' => $employee_id,
                        'request_id' => $request_id,
                        'date' => date(DATEMYSQL, strtotime($other_date[$key])),
                        'arrange_by' => $other_arrange_by[$key],
                        'expense_name' => $expense_name[$key],
                        'expense_type' => $expense_type[$key],
                        'bill_no' => $bill_no[$key],
                        'amount' => $total_no[$key],
                    );

                    if (!$this->common->insert_data($data_array, 'other_expense')) {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . employee_request);
                    }
                }
            }

            $this->load->library('encryption');
            $this->encryption->initialize(array('driver' => 'mcrypt'));
            $this->encryption->initialize(array('driver' => 'openssl'));

            $credit_card_number = $this->input->post('credit_card_number');
            $enc_credit_card_number = $this->encryption->encrypt($credit_card_number);

            $bank_name = $this->input->post('bank_name');
            $enc_bank_name = $this->encryption->encrypt($bank_name);

            $allowances_item_array = array(
                'employees_id' => $employee_id,
                'request_id' => $request_id,
                'credit_card_number' => $enc_credit_card_number,
                'bank_name' => $enc_bank_name,
                'expense_da' => $expense_da,
                'expense_con' => $expense_con,
                'policy_meet' => $policy_meet,
                'reimbursement_arrangment' => $this->input->post('arrange_by'),
                'final_total_claim' => $this->input->post('final_total_claim'),
                'total_claim' => $this->input->post('total_claim'),
                'less_advance' => $this->input->post('les_advance'),
                'recevied_amount' => $this->input->post('your_recived_hidd'),
            );
            if ($expense_id == '') {
                if ($this->common->insert_data($allowances_item_array, 'expense')) {
                    if ($request['approval_level'] == '0') {
                        $data_array = array(
                            'request_status' => "6",
                        );

                        if ($this->input->post('return_date')) {
                            $return_date = $this->input->post('return_date');
                            $data_array['return_date'] = date(DATEMYSQL, strtotime($return_date));
                        }

                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $data_array = array(
                                'expense_status' => "Approved",
                            );
                            if ($this->common->update_data($data_array, 'expense', 'request_id', $request_id)) {

                                $request_data = $this->travel_request->get_request_details_by_id($request_id);
                                $to_city_id = $request['to_city_id'];
                                $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-weight:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Hi <name of='' requester=''>" . $request_data['employee_name'] . ",</name></span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Your claim request is Sent to Finance Manager &nbsp;</span></span></p>
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
                                $subject = $request_data['reference_id'] . ", Claim Raised";
                                $this->sendEmail($to, $subject, $message);

                                $this->session->set_flashdata('success', 'New Expense claimed successfully.');
                                redirect(base_url() . employee_request);
                            } else {
                                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                                redirect(base_url() . employee_request);
                            }
                        } else {
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . employee_request);
                        }
                    } else {
                        $data_array = array(
                            'request_status' => "5",
                        );

//                    if ($request['trip_type'] == '1') {
                        if ($this->input->post('return_date')) {
                            $return_date = $this->input->post('return_date');
                            $data_array['return_date'] = date(DATEMYSQL, strtotime($return_date));
//                        $data_array['trip_type'] = "0";
//                    }
                        }
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                            $request_data = $this->travel_request->get_request_details_by_id($request_id);
                            $to_city_id = $request['to_city_id'];


                            if ($request['travel_type'] == "1") {
                                $travel_mode = "Flight";
                            } else if ($request['travel_type'] == "2") {
                                $travel_mode = "Train";
                            } else if ($request['travel_type'] == "3") {
                                $travel_mode = "Car";
                            } else if ($request['travel_type'] == "4") {
                                $travel_mode = "Bus";
                            }
                            if ($request['trip_type'] == "0") {
                                $now = strtotime(date(DATEMYSQL, strtotime($request['departure_date'])));
                                $your_date = strtotime(date(DATEMYSQL, strtotime($request['return_date'])));
                                $datediff = $your_date - $now;
                                $travel_day = floor($datediff / (60 * 60 * 24));
                                $travel_date = $request['departure_date'] . " To " . $request['return_date'];
                            } else {
                                $travel_day = "1";
                                $travel_date = $request['departure_date'];
                            }

                            $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['manager_name'] . ",</span></span></p><br>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your team member, </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['employee_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> has raised a claim request to </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> . </span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('employee_request/expense_pending') . '/' . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to review and Approve/Deny of the <span style='font-size: 13.3333px;'>claim</span> request.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                            $to = $request_data['manager_email'];
                            $subject = $request_data['reference_id'] . ", Claim Approval " . $request_data['employee_name'];
                            $this->sendEmail($to, $subject, $message, $cc);

                            $this->session->set_flashdata('success', 'New Expense claimed successfully.');
                            redirect(base_url() . employee_request);
                        } else {
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . employee_request);
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            } else {
                $allowances_item_array['expense_status'] = "Pending";
                if ($this->common->update_data($allowances_item_array, 'expense', 'request_id', $request_id)) {
                    if ($request['approval_level'] == '0') {
                        $data_array = array(
                            'request_status' => "6",
                        );
                        if ($this->input->post('return_date')) {
                            $return_date = $this->input->post('return_date');
                            $data_array['return_date'] = date(DATEMYSQL, strtotime($return_date));
                        }

                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                            $data_array = array(
                                'expense_status' => "Approved",
                            );
                            if ($this->common->update_data($data_array, 'expense', 'request_id', $request_id)) {

                                $request_data = $this->travel_request->get_request_details_by_id($request_id);
                                $to_city_id = $request['to_city_id'];
                                $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-weight:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Hi <name of='' requester=''>" . $request_data['employee_name'] . ",</name></span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Your claim request is Sent to Finance Manager &nbsp;</span></span></p>
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
                                $subject = $request_data['reference_id'] . ", Claim Raised";
                                $this->sendEmail($to, $subject, $message);

                                $this->session->set_flashdata('success', 'New Expense claimed successfully.');
                                redirect(base_url() . employee_request);
                            } else {
                                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                                redirect(base_url() . employee_request);
                            }
                        } else {
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . employee_request);
                        }
                    } else {
                        $data_array = array(
                            'request_status' => "5",
                        );
//                    if ($request['trip_type'] == '1') {
                        if ($this->input->post('return_date')) {
                            $return_date = $this->input->post('return_date');
                            $data_array['return_date'] = date(DATEMYSQL, strtotime($return_date));
                            ;
//                        $data_array['trip_type'] = "0";
//                    }
                        }
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                            $request_data = $this->travel_request->get_request_details_by_id($request_id);
                            $to_city_id = $request['to_city_id'];


                            if ($request['travel_type'] == "1") {
                                $travel_mode = "Flight";
                            } else if ($request['travel_type'] == "2") {
                                $travel_mode = "Train";
                            } else if ($request['travel_type'] == "3") {
                                $travel_mode = "Car";
                            } else if ($request['travel_type'] == "4") {
                                $travel_mode = "Bus";
                            }
                            if ($request['trip_type'] == "0") {
                                $now = strtotime(date('Y-m-d', strtotime($request['departure_date'])));
                                $your_date = strtotime(date('Y-m-d', strtotime($request['return_date'])));
                                $datediff = $your_date - $now;
                                $travel_day = floor($datediff / (60 * 60 * 24));
                                $travel_date = $request['departure_date'] . " To " . $request['return_date'];
                            } else {
                                $travel_day = "1";
                                $travel_date = $request['departure_date'];
                            }

                            $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['manager_name'] . ",</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your team member, </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['employee_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> has raised a claim request to </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> . </span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('employee_request/expense_pending') . '/' . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to review and Approve/Deny of the <span style='font-size: 13.3333px;'>claim</span> request.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9df-f82d-9215-776a388c604e'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                            $to = $request_data['manager_email'];
                            $subject = $request_data['reference_id'] . ", Claim Approval " . $request_data['employee_name'];
                            $this->sendEmail($to, $subject, $message, $cc);

                            $this->session->set_flashdata('success', 'New Expense claimed successfully.');
                            redirect(base_url() . employee_request);
                        } else {
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . employee_request);
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . employee_request);
                }
            }
        }

        $view_request['other_expencesData'] = $this->travel_request->get_all_other_expences_data('mast_other_expense');

        $this->template->write_view('content', 'expense/claim_expense', $view_request);
        $this->template->render();
    }

    function get_days_hours() {
        $departure_date = $this->input->post('departure_date');
        $return_date = $this->input->post('return_date');
        $first_date = new DateTime($departure_date);
        $second_date = new DateTime($return_date);
        $interval = $first_date->diff($second_date);
        $day = $interval->format("%d");
        $hours = $interval->format("%h");
        $arr = array();
        $arr['day'] = $day;
        $arr['hours'] = $hours;
        $arr['departure_date'] = date(DATETIME_FORMAT, strtotime($departure_date));
        $arr['return_date'] = date(DATETIME_FORMAT, strtotime($return_date));
        echo json_encode($arr);
    }

    function expense_pending($request_id) {
        $total_travel_claim = 0;
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->expense->get_expense_pending_request_by_id($request_id, $employee_id);
        if (empty($request)) {
            $this->session->set_flashdata('error', "Something went wrong!");
            redirect(base_url() . dashboard);
        }
        $view_request = array('request' => $request);
        $employee_id = $request['employee_id'];

        $empID = $request['employee_id'];
        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee_by_id($empID);

        if ($request['travel_reason_id'] != "Projects") {
            $dept_id = $employee['dept_id'];
            $this->load->model("budget_model");
            $financial_year = date('Y');
            $budget = $this->budget_model->get_budget_by_dept($dept_id, $financial_year);
            $view_request['budget'] = $budget;
        } else {
            $project_id = $request['project_id'];
            $this->load->model("projects_model");
            $project = $this->projects_model->get_project($project_id);
            $view_request['budget'] = $project;
        }

        $other_manager_expense = $this->expense->get_other_manager_expense($request_id);
        if (!empty($other_manager_expense)) {
            $foods = $view_request['other_manager_expense_food'] = $other_manager_expense['foods'];
            $travel = $view_request['other_manager_expense_travel'] = $other_manager_expense['travel'];
            $other = $view_request['other_manager_expense_other'] = $other_manager_expense['other'];
            $other_manager_expense_total = $foods + $travel + $other;
            $view_request['other_manager_expense'] = $other_manager_expense_total;
            $total_travel_claim = $total_travel_claim + $other_manager_expense_total;
        }

        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee_id($employee_id);
        $view_request['employee'] = $employee;

        $expense_pending = $this->expense->get_expense_pending($request_id);

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => 'mcrypt'));
        $this->encryption->initialize(array('driver' => 'openssl'));
        $expense_pending['credit_card_number'] = $this->encryption->decrypt($expense_pending['credit_card_number']);
        $expense_pending['bank_name'] = $this->encryption->decrypt($expense_pending['bank_name']);

        $view_request['expense_pending'] = $expense_pending;
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

        $other_trip_expense = $this->expense->get_other_trip_expense($request_id);
        $view_request['other_trip_expense'] = $other_trip_expense;

        $other_loading_booking = $this->expense->get_other_loading_booking($request_id);
        $view_request['other_loading_booking'] = $other_loading_booking;

        $other_con_booking = $this->expense->get_other_con_booking($request_id);
        $view_request['other_con_booking'] = $other_con_booking;

        $get_other_attachment = $this->expense->get_other_attachment($request_id);
        $view_request['get_other_attachment'] = $get_other_attachment;

        $view_request['ticket_details'] = $ticket_details;
        $view_request['hotel_details'] = $hotel_details;
        $view_request['car_details'] = $car_details;
        $view_request['total_travel_claim'] = $total_travel_claim;



        $employee = $this->employee_model->get_employee_by_id($employee_id);
        $grade_id = $employee['grade_id'];
        $travel_type = $request['travel_type'];
        $city_id = $request['to_city_id'];

        $this->load->model("grades_model");
        $grade = $this->employee_model->get_grade_details($grade_id);
        if ($grade['travel_mode'] == "1") {
            $eligibility_mode = "Flight";
        } else if ($grade['travel_mode'] == "2") {
            $eligibility_mode = "Train";
        } else if ($grade['travel_mode'] == "3") {
            $eligibility_mode = "Car";
        } else if ($grade['travel_mode'] == "4") {
            $eligibility_mode = "Bus";
        }
        $view_request['eligibility_mode'] = $eligibility_mode;
        $view_request['eligibility_class'] = $grade['travel_class'];

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


        $this->template->write_view('content', 'expense/expense_pending', $view_request);
        $this->template->render();
    }

    function approve_expense($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);

        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['request_status'] == '5') {
                $expense_pending = $this->expense->get_expense_pending($request_id);

                $data_array = array(
                    'request_status' => '6',
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $data_array = array(
                        'expense_status' => "Approved",
                    );
                    if ($this->common->update_data($data_array, 'expense', 'request_id', $request_id)) {

                        $request_data = $this->travel_request->get_request_details_by_id($request_id);
                        $to_city_id = $request['to_city_id'];
                        $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' font-weight:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Hi <name of='' requester=''>" . $request_data['employee_name'] . ",</name></span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-e9f5-3477-0b66-360dfc70264d'><span background-color:='' color:='' style='font-size: 10pt; font-family: ' trebuchet='' vertical-align:='' white-space:=''>Your claim request is Approved by Reporting Manager&nbsp;</span></span></p>
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
                        redirect(base_url() . 'employee_request/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect(base_url() . 'employee_request/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already approved');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function clarification_expense($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
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
                redirect(base_url() . 'employee_request/inbox');
            } else {
                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function reject_expense($request_id = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['request_status'] == '5') {
                $data_array = array(
                    'request_status' => '6',
                );
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $data_array = array(
                        'expense_status' => "Rejected",
                    );
                    if ($this->common->update_data($data_array, 'expense', 'request_id', $request_id)) {
                        $this->session->set_flashdata('success', 'Expense Rejected successfully');
                        redirect(base_url() . 'employee_request/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . 'employee_request/inbox');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect(base_url() . 'employee_request/inbox');
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already approved');
                redirect(base_url() . 'employee_request/inbox');
            }
        }
    }

    function view_expense($request_id) {
        $total_travel_claim = 0;
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->expense->get_claim_request_by_id($request_id, $employee_id);
        if (empty($request)) {
            $this->session->set_flashdata('error', "Something went wrong!");
            redirect(base_url() . dashboard);
        }
        $view_request = array('request' => $request);
        $this->load->model('employee_model');
        $employee = $this->employee_model->get_employee_id($employee_id);
        $view_request['employee'] = $employee;

        $other_manager_expense = $this->expense->get_other_manager_expense($request_id);
        if (!empty($other_manager_expense)) {
            $foods = $view_request['other_manager_expense_food'] = $other_manager_expense['foods'];
            $travel = $view_request['other_manager_expense_travel'] = $other_manager_expense['travel'];
            $other = $view_request['other_manager_expense_other'] = $other_manager_expense['other'];
            $other_manager_expense_total = $foods + $travel + $other;
            $view_request['other_manager_expense'] = $other_manager_expense_total;
            $total_travel_claim = $total_travel_claim + $other_manager_expense_total;
        }

        $other_trip_expense = $this->expense->get_other_trip_expense($request_id);
        $view_request['other_trip_expense'] = $other_trip_expense;

        $other_loading_booking = $this->expense->get_other_loading_booking($request_id);
        $view_request['other_loading_booking'] = $other_loading_booking;

        $other_con_booking = $this->expense->get_other_con_booking($request_id);
        $view_request['other_con_booking'] = $other_con_booking;

        $expense_pending = $this->expense->get_expense_pending($request_id);
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => 'mcrypt'));
        $this->encryption->initialize(array('driver' => 'openssl'));
        $expense_pending['credit_card_number'] = $this->encryption->decrypt($expense_pending['credit_card_number']);
        $expense_pending['bank_name'] = $this->encryption->decrypt($expense_pending['bank_name']);
        $view_request['expense_pending'] = $expense_pending;

        $other_expense = $this->expense->get_other_expense($request_id);
        $view_request['other_expense'] = $other_expense;

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
                $data_array['travel_type'] = '3';
                $data_array['cost'] = $car_booking['cost'];
                $data_array['book_by'] = $car_booking['book_by'];
                $data_array['arrange_by'] = $car_booking['arrange_by'];
                $total_travel_claim = $total_travel_claim + $car_booking['cost'];
                $data_array['attachment'] = $car_booking['car_attchment'];
                $car_details[] = $data_array;
            }
        }



        $view_request['ticket_details'] = $ticket_details;
        $view_request['hotel_details'] = $hotel_details;
        $view_request['car_details'] = $car_details;
        $view_request['total_travel_claim'] = $total_travel_claim;
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
        $this->template->write_view('content', 'expense/view_expense', $view_request);
        $this->template->render();
    }

    /* Travel Self Booking code start */

    function self_booking($request_id) {
        $view_request = array();

        $request = $this->travel_desk->get_travel_request_by_id($request_id);
        $view_request['request'] = $request;
        if ($request['bookbyself'] == '1') {

            $to_city_id = $request['to_city_id'];
            $this->load->model('employee_model');
            $hotel_category = $this->travel_desk->get_hotel_category_by_location($to_city_id, '1');
            $view_request['hotel_category'] = $hotel_category;
            $view_request['to_city_id'] = $to_city_id;

            $employee = $this->employee_model->get_employee_id($request['employee_id']);
            $view_request['employee'] = $employee;

            $service_proviers = $this->travel_desk->get_service_proviers($request['travel_type']);
            $view_request['service_proviers'] = $service_proviers;

            $this->load->model("city_model");
            $city_date = $this->city_model->get_all_city();
            $view_request['city'] = $city_date;

            $this->load->model("travel_category_model", "car_model");
            $car = $this->car_model->get_all_car_category();
            $view_request['car'] = $car;

            $this->template->write_view('content', 'travel_desk/self_booking_request', $view_request);
            $this->template->render();
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function get_hotel_category_by_location($city, $type = '') {
        $this->load->model('employee_model');
        $data = $this->travel_desk->get_hotel_category_by_location($city, $type);
        echo json_encode($data);
    }

    function car_booking() {
        if ($this->input->post('request_id')) {
            $request_id = $this->input->post('request_id');

//            $this->form_validation->set_rules('book_by', 'book_by', 'required');
//            $this->form_validation->set_rules('car_category_id', 'car_category_id', 'required');
//            $this->form_validation->set_rules('car_type', 'car_type', 'required');
            $this->form_validation->set_rules('pick_up_date', 'pick_up_date', 'required');
//            $this->form_validation->set_rules('drop_off_date', 'drop_off_date', 'required');
            $this->form_validation->set_rules('pick_up_location', 'pick_up_location', 'required');
            $this->form_validation->set_rules('drop_off_location', 'drop_off_location', 'required');
            $this->form_validation->set_rules('cost', 'cost', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please follow validation rules!');
                redirect('employee_request/self_booking/' . $request_id, 'refresh');
            } else {

                $request = $this->travel_desk->get_travel_request_by_id($request_id);
                $trip_ticket = $request['trip_ticket'];
                $hotel_booking = $request['hotel_booking'];

                if ($request['accommodation'] == '1' || $request['accommodation'] == '2') {
                    $hotel_booking = $request['hotel_booking'];
                } else {
                    $hotel_booking = "1";
                }

                if ($request['travel_ticket'] == '1' || $request['travel_ticket'] == '2') {
                    if ($request['trip_type'] != "1") {
                        if ($request['trip_ticket'] == '1' && $request['trip_ticket_return'] == '1') {
                            $trip_ticket = $request['trip_ticket'];
                        } else {
                            $trip_ticket = "0";
                        }
                    } else {
                        $trip_ticket = $request['trip_ticket'];
                    }
                } else {
                    $trip_ticket = "1";
                }
                $data_array = $this->input->post();
                $pick_up_date = date(DATEMYSQL, strtotime($this->input->post('pick_up_date')));
                $drop_off_date = date(DATEMYSQL, strtotime($this->input->post('drop_off_date')));
                $data_array['pick_up_date'] = $pick_up_date;
                $data_array['drop_off_date'] = $drop_off_date;
                if (isset($_FILES['car_attchment']['name']) && $_FILES['car_attchment']['name'] != null) {
                    $file_name = $_FILES['car_attchment']['name'];
                    $enc_filename = $this->GenerateRandomFilename($file_name);
                    $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $enc_filename;

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('car_attchment')) {
                        $upload_data = $this->upload->data();
                        $data_array['car_attchment'] = $upload_data['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error', $error['error']);
                        redirect('employee_request/index', 'refresh');
                    }
                }


                if ($this->common->insert_data($data_array, 'car_booking')) {
                    $data_array = array();
                    $data_array['car_booking'] = '1';
                    if ($trip_ticket == "1" && $hotel_booking == "1") {
                        $data_array['request_status'] = '4';
                    }
                    if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                        $this->session->set_flashdata('success', 'Car Booked successfully');
//                    if ($trip_ticket == "1" && $hotel_booking == "1") {
                        redirect('employee_request/index', 'refresh');
//                    } else {
//                        redirect('employee_request/self_booking/' . $request_id, 'refresh');
//                    }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect('employee_request/index', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('employee_request/index', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function hotel_booking() {
        if ($this->input->post('request_id')) {
            $request_id = $this->input->post('request_id');

            $this->form_validation->set_rules('accommodation_type', 'accommodation_type', 'required');
//            $this->form_validation->set_rules('occupancy', 'occupancy', 'required');
            $this->form_validation->set_rules('city_id', 'city_id', 'required');
            $this->form_validation->set_rules('hotel_provider_id', 'hotel_provider_id', 'required');
            $this->form_validation->set_rules('check_in_date', 'check_in_date', 'required');
            $this->form_validation->set_rules('check_out_date', 'check_out_date', 'required');
            $this->form_validation->set_rules('cost', 'cost', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please follow validation rules!');
                redirect('employee_request/self_booking/' . $request_id, 'refresh');
            } else {


                $request = $this->travel_desk->get_travel_request_by_id($request_id);
                $trip_ticket = $request['trip_ticket'];
                $car_booking = $request['car_booking'];

                if ($request['car_hire'] == '1' || $request['car_hire'] == '2') {
                    $car_booking = $request['car_booking'];
                } else {
                    $car_booking = "1";
                }

                if ($request['travel_ticket'] == '1' || $request['travel_ticket'] == '2') {
                    if ($request['trip_type'] != "1") {
                        if ($request['trip_ticket'] == '1' && $request['trip_ticket_return'] == '1') {
                            $trip_ticket = $request['trip_ticket'];
                        } else {
                            $trip_ticket = '';
                        }
                    } else {
                        $trip_ticket = $request['trip_ticket'];
                    }
                } else {
                    $trip_ticket = "1";
                }

                $data_array = $this->input->post();
                $check_in_date = date(DATEMYSQL, strtotime($this->input->post('check_in_date')));
                $check_out_date = date(DATEMYSQL, strtotime($this->input->post('check_out_date')));

                $data_array['check_in_date'] = $check_in_date;
                $data_array['check_out_date'] = $check_out_date;
                if (isset($_FILES['hotel_attchment']['name']) && $_FILES['hotel_attchment']['name'] != null) {
                    $file_name = $_FILES['hotel_attchment']['name'];
                    $enc_filename = $this->GenerateRandomFilename($file_name);
                    $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $enc_filename;

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('hotel_attchment')) {
                        $upload_data = $this->upload->data();
                        $data_array['hotel_attchment'] = $upload_data['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error', $error['error']);
                        redirect('employee_request/index', 'refresh');
                    }
                }


                if ($this->common->insert_data($data_array, 'hotel_booking')) {
                    $data_array = array();
                    $data_array['hotel_booking'] = '1';
                    if ($car_booking == "1" && $trip_ticket == "1") {
                        $data_array['request_status'] = '4';
                    }
                    if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                        $this->session->set_flashdata('success', 'Hotel Booked successfully');
//                    if ($car_booking == "1" && $trip_ticket == "1") {
                        redirect('employee_request/index', 'refresh');
//                    } else {
//                        redirect('employee_request/self_booking/' . $request_id, 'refresh');
//                    }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect('employee_request/index', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('employee_request/index', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function flight_booking() {
        if ($this->input->post('request_id')) {
            $request_id = $this->input->post('request_id');

//            $this->form_validation->set_rules('flight_provider_id', 'flight_provider_id', 'required');
            $this->form_validation->set_rules('pnr_number', 'pnr_number', 'required');
            $this->form_validation->set_rules('cost', 'cost', 'required');
            $this->form_validation->set_rules('flight_number', 'flight_number', 'required');
//            $this->form_validation->set_rules('booking_city_id', 'booking_city_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please follow validation rules!');
                redirect('employee_request/self_booking/' . $request_id, 'refresh');
            } else {

                if (isset($_FILES['flight_attachment']['name']) && $_FILES['flight_attachment']['name'] != null) {
                    $request = $this->travel_desk->get_travel_request_by_id($request_id);
                    $car_booking = $request['car_booking'];
                    $hotel_booking = $request['hotel_booking'];

                    if ($request['car_hire'] == '1' || $request['car_hire'] == '2') {
                        $car_booking = $request['car_booking'];
                    } else {
                        $car_booking = "1";
                    }

                    if ($request['accommodation'] == '1' || $request['accommodation'] == '2') {
                        $hotel_booking = $request['hotel_booking'];
                    } else {
                        $hotel_booking = "1";
                    }
                    $data_array = $this->input->post();
                    if (isset($_FILES['flight_attachment']['name']) && $_FILES['flight_attachment']['name'] != null) {
                        $file_name = $_FILES['flight_attachment']['name'];
                        $enc_filename = $this->GenerateRandomFilename($file_name);
                        $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $enc_filename;

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('flight_attachment')) {
                            $upload_data = $this->upload->data();
                            $data_array['flight_attachment'] = $upload_data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('error', $error['error']);
                            redirect('employee_request/index', 'refresh');
                        }
                    }

                    if ($this->common->insert_data($data_array, 'flight_ticket_booking')) {
                        $data_array = array();
                        $trip_mode = $this->input->post('trip_mode');
                        $booking_mode = 0;
                        if ($trip_mode == 1) {
                            $data_array['trip_ticket_return'] = '1';
                            if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1') {
                                $data_array['request_status'] = '4';
                                $booking_mode = 1;
                            }
                        } else {
                            $data_array['trip_ticket'] = '1';
                            if ($request['trip_type'] == '1') {
                                if ($car_booking == "1" && $hotel_booking == "1") {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            } else {
                                if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1') {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            }
                        }
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Trip Booked successfully');
//                    if ($booking_mode == "1") {
                            redirect('employee_request/index', 'refresh');
//                    } else {
//                        redirect('employee_request/self_booking/' . $request_id, 'refresh');
//                    }
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect('employee_request/index', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect('employee_request/index', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error!! Attachment is required!');
                    redirect('employee_request/self_booking/' . $request_id, 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function train_booking() {
        if ($this->input->post('request_id')) {
            $request_id = $this->input->post('request_id');

//            $this->form_validation->set_rules('train_provider_id', 'train_provider_id', 'required');
            $this->form_validation->set_rules('pnr_number', 'pnr_number', 'required');
            $this->form_validation->set_rules('cost', 'cost', 'required');
            $this->form_validation->set_rules('train_number', 'train_number', 'required');
//            $this->form_validation->set_rules('booking_city_id', 'booking_city_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please follow validation rules!');
                redirect('employee_request/self_booking/' . $request_id, 'refresh');
            } else {

                if (isset($_FILES['train_attachment']['name']) && $_FILES['train_attachment']['name'] != null) {


                    $request = $this->travel_desk->get_travel_request_by_id($request_id);
                    $car_booking = $request['car_booking'];
                    $hotel_booking = $request['hotel_booking'];

                    if ($request['car_hire'] == '1' || $request['car_hire'] == '2') {
                        $car_booking = $request['car_booking'];
                    } else {
                        $car_booking = "1";
                    }

                    if ($request['accommodation'] == '1' || $request['accommodation'] == '2') {
                        $hotel_booking = $request['hotel_booking'];
                    } else {
                        $hotel_booking = "1";
                    }


                    $data_array = $this->input->post();
                    if (isset($_FILES['train_attachment']['name']) && $_FILES['train_attachment']['name'] != null) {
                        $file_name = $_FILES['train_attachment']['name'];
                        $enc_filename = $this->GenerateRandomFilename($file_name);
                        $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $enc_filename;

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('train_attachment')) {
                            $upload_data = $this->upload->data();
                            $data_array['train_attachment'] = $upload_data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('error', $error['error']);
                            redirect('employee_request/index', 'refresh');
                        }
                    }


                    if ($this->common->insert_data($data_array, 'train_ticket_booking')) {
                        $data_array = array();
                        $trip_mode = $this->input->post('trip_mode');
                        $booking_mode = 0;
                        if ($trip_mode == 1) {
                            $data_array['trip_ticket_return'] = '1';
                            if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1') {
                                $data_array['request_status'] = '4';
                                $booking_mode = 1;
                            }
                        } else {
                            $data_array['trip_ticket'] = '1';
                            if ($request['trip_type'] == '1') {
                                if ($car_booking == "1" && $hotel_booking == "1") {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            } else {
                                if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1') {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            }
                        }
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Trip Booked successfully');
//                    if ($booking_mode == "1") {
                            redirect('employee_request/index', 'refresh');
//                    } else {
//                        redirect('employee_request/self_booking/' . $request_id, 'refresh');
//                    }
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect('employee_request/index', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect('employee_request/index', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error!! Attachment is requied!');
                    redirect('employee_request/self_booking/' . $request_id, 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function car_ticket_booking() {
        if ($this->input->post('request_id')) {
            $request_id = $this->input->post('request_id');

//            $this->form_validation->set_rules('car_provider_id', 'car_provider_id', 'required');
            $this->form_validation->set_rules('cost', 'cost', 'required');
//            $this->form_validation->set_rules('booking_city_id', 'booking_city_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please follow validation rules!');
                redirect('employee_request/self_booking/' . $request_id, 'refresh');
            } else {
                if (isset($_FILES['car_attachment']['name']) && $_FILES['car_attachment']['name'] != null) {

                    $request = $this->travel_desk->get_travel_request_by_id($request_id);
                    $car_booking = $request['car_booking'];
                    $hotel_booking = $request['hotel_booking'];

                    if ($request['car_hire'] == '1' || $request['car_hire'] == '2') {
                        $car_booking = $request['car_booking'];
                    } else {
                        $car_booking = "1";
                    }

                    if ($request['accommodation'] == '1' || $request['accommodation'] == '2') {
                        $hotel_booking = $request['hotel_booking'];
                    } else {
                        $hotel_booking = "1";
                    }

                    $data_array = $this->input->post();
                    if (isset($_FILES['car_attachment']['name']) && $_FILES['car_attachment']['name'] != null) {
                        $file_name = $_FILES['car_attachment']['name'];
                        $enc_filename = $this->GenerateRandomFilename($file_name);
                        $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $enc_filename;

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('car_attachment')) {
                            $upload_data = $this->upload->data();
                            $data_array['car_attachment'] = $upload_data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('error', $error['error']);
                            redirect('employee_request/index', 'refresh');
                        }
                    }


                    if ($this->common->insert_data($data_array, 'car_ticket_booking')) {
                        $data_array = array();
                        $trip_mode = $this->input->post('trip_mode');
                        $booking_mode = 0;
                        if ($trip_mode == 1) {
                            $data_array['trip_ticket_return'] = '1';
                            if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1') {
                                $data_array['request_status'] = '4';
                                $booking_mode = 1;
                            }
                        } else {
                            $data_array['trip_ticket'] = '1';
                            if ($request['trip_type'] == '1') {
                                if ($car_booking == "1" && $hotel_booking == "1") {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            } else {
                                if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1') {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            }
                        }
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Trip Booked successfully');
//                    if ($booking_mode == "1") {
                            redirect('employee_request/index', 'refresh');
//                    } else {
//                        redirect('employee_request/self_booking/' . $request_id, 'refresh');
//                    }
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect('employee_request/index', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect('employee_request/index', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error!! Attachment is requied!');
                    redirect('employee_request/self_booking/' . $request_id, 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function bus_ticket_booking() {
        if ($this->input->post('request_id')) {
            $request_id = $this->input->post('request_id');

//            $this->form_validation->set_rules('bus_provider_id', 'bus_provider_id', 'required');
            $this->form_validation->set_rules('cost', 'cost', 'required');
//            $this->form_validation->set_rules('booking_city_id', 'booking_city_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Please follow validation rules!');
                redirect('employee_request/self_booking/' . $request_id, 'refresh');
            } else {
                if (isset($_FILES['bus_attachment']['name']) && $_FILES['bus_attachment']['name'] != null) {

                    $request = $this->travel_desk->get_travel_request_by_id($request_id);
                    $car_booking = $request['car_booking'];
                    $hotel_booking = $request['hotel_booking'];

                    if ($request['car_hire'] == '1' || $request['car_hire'] == '2') {
                        $car_booking = $request['car_booking'];
                    } else {
                        $car_booking = "1";
                    }

                    if ($request['accommodation'] == '1' || $request['accommodation'] == '2') {
                        $hotel_booking = $request['hotel_booking'];
                    } else {
                        $hotel_booking = "1";
                    }

                    $data_array = $this->input->post();
                    if (isset($_FILES['bus_attachment']['name']) && $_FILES['bus_attachment']['name'] != null) {
                        $file_name = $_FILES['bus_attachment']['name'];
                        $enc_filename = $this->GenerateRandomFilename($file_name);
                        $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $enc_filename;

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('bus_attachment')) {
                            $upload_data = $this->upload->data();
                            $data_array['bus_attachment'] = $upload_data['file_name'];
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('error', $error['error']);
                            redirect('employee_request/index', 'refresh');
                        }
                    }


                    if ($this->common->insert_data($data_array, 'bus_ticket_booking')) {
                        $data_array = array();
                        $trip_mode = $this->input->post('trip_mode');
                        $booking_mode = 0;
                        if ($trip_mode == 1) {
                            $data_array['trip_ticket_return'] = '1';
                            if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1') {
                                $data_array['request_status'] = '4';
                                $booking_mode = 1;
                            }
                        } else {
                            $data_array['trip_ticket'] = '1';
                            if ($request['trip_type'] == '1') {
                                if ($car_booking == "1" && $hotel_booking == "1") {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            } else {
                                if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1') {
                                    $data_array['request_status'] = '4';
                                    $booking_mode = 1;
                                }
                            }
                        }
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Trip Booked successfully');
//                    if ($booking_mode == "1") {
                            redirect('employee_request/index', 'refresh');
//                    } else {
//                        redirect('employee_request/self_booking/' . $request_id, 'refresh');
//                    }
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect('employee_request/index', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect('employee_request/index', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error!! Attachment is requied!');
                    redirect('employee_request/self_booking/' . $request_id, 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('employee_request/index', 'refresh');
        }
    }

    function GenerateRandomFilename($file_name = '', $length = 30) {
        $finalext = '';
        if ($file_name != '') {
            $arr = explode('.', $file_name);
            $ext = end($arr);
            $finalext = '.' . $ext;
        }
        $characters = '123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . $finalext;
    }

    /* Travel Self Booking code finish */

    function new_add_loading_row() {
        $count = $this->input->post('count');
        $view_request['count'] = $count;

        $request_id = $this->input->post('request_id');
        $request = $this->travel_request->get_request_id($request_id, 'departure_date,return_date,trip_type');
        $view_request['request'] = $request;

        $this->load->view('add_row/new_add_loading_row', $view_request);
    }

    function new_add_con_row() {
        $count = $this->input->post('count');
        $view_request['count'] = $count;

        $request_id = $this->input->post('request_id');
        $request = $this->travel_request->get_request_id($request_id, 'departure_date,return_date,trip_type');
        $view_request['request'] = $request;

        $this->load->view('add_row/new_add_con_row', $view_request);
    }

    function new_add_trip_row() {
        $count = $this->input->post('count');
        $view_request['count'] = $count;

        $request_id = $this->input->post('request_id');
        $request = $this->travel_request->get_request_id($request_id, 'departure_date,return_date,trip_type');
        $view_request['request'] = $request;

        $this->load->view('add_row/new_add_trip_row', $view_request);
    }

    function new_add_other_row() {
        $count = $this->input->post('count');
        $view_request['count'] = $count;

        $request_id = $this->input->post('request_id');
        $request = $this->travel_request->get_request_id($request_id, 'departure_date,return_date,trip_type');
        $view_request['request'] = $request;
        $view_request['other_expencesData'] = $this->travel_request->get_all_other_expences_data('mast_other_expense');
        $this->load->view('add_row/new_add_other_row', $view_request);
    }

}
