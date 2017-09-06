<?php

class Travel_desk extends Admin_Controller {

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
        $this->load->model("travel_desk_model", 'travel_desk');
        $this->load->model("travel_request_model", 'travel_request');
        $this->load->model("expense_model", 'expense');
    }

    public function travel_policy() {

        $emp_id = $this->session->userdata('employee_id');

        $this->load->model('employee_model');

        $this->load->model("grades_model");
        $grade_data = $this->grades_model->get_all_grades();

        $emp_policy = array();
        $i = 0;
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

    public function index($duration = NULL) {
        $employee_id = $this->session->userdata('employee_id');
        $request_arr = $this->travel_desk->get_all_travel_requestSNT($employee_id);
        $request = array();
        foreach ($request_arr as $key => $value) {
            $request[$value['id']] = $value;
        }

        $view_request = array();
        $today = array();
        $tomorrow = array();
        $yesterday = array();
        $comingWeek = array();

        if (isset($request) and count($request) > 0) {
            $timestamp = time();
            $todayFirstStamp = strtotime("midnight", $timestamp);
            $todayLastStamp = strtotime("tomorrow", $todayFirstStamp) - 1;
            $tomorrowFirstStamp = strtotime("tomorrow", $todayFirstStamp);
            $tomorrowLastStamp = $tomorrowFirstStamp + 86400;
            $yesterdayLastStamp = $todayFirstStamp - 1;
            $yesterdayFirstStamp = $yesterdayLastStamp - 86400;
            $comingWeekFirstStamp = strtotime("next monday");
            $comingWeekLastStamp = $comingWeekFirstStamp + 604800;
            foreach ($request as $ki => $val) {
                $beginStampOfJourney = strtotime($val['departure_date']);
                if ($beginStampOfJourney >= $todayFirstStamp and $beginStampOfJourney < $todayLastStamp) {
                    $today[] = $val;
                } elseif ($beginStampOfJourney >= $tomorrowFirstStamp and $beginStampOfJourney < $tomorrowLastStamp) {
                    $tomorrow[] = $val;
                } elseif ($beginStampOfJourney >= $yesterdayFirstStamp and $beginStampOfJourney < $yesterdayLastStamp) {
                    $yesterday[] = $val;
                } elseif ($beginStampOfJourney >= $comingWeekFirstStamp and $beginStampOfJourney < $comingWeekLastStamp) {
                    $comingWeek[] = $val;
                }
            }
        }

        if (isset($duration) and $duration == 'today') {
            $view_request['request'] = $today;
        } elseif (isset($duration) and $duration == 'tomorrow') {
            $view_request['request'] = $tomorrow;
        } elseif (isset($duration) and $duration == 'yesterday') {
            $view_request['request'] = $yesterday;
        } elseif (isset($duration) and $duration == 'comingWeek') {
            $view_request['request'] = $comingWeek;
        } else {
            $view_request['request'] = $request;
        }

        $view_request['today'] = $today;
        $view_request['tomorrow'] = $tomorrow;
        $view_request['yesterday'] = $yesterday;
        $view_request['comingWeek'] = $comingWeek;

        $this->template->write_view('content', 'travel_desk/index', $view_request);
        $this->template->render();
    }

    public function inbox() {
        $employee_id = $this->session->userdata('employee_id');
        $cost_center_data = $this->travel_desk->get_cost_centre_id_by_emp($employee_id);
        if (!empty($cost_center_data)) {
            $cost_center_id = $cost_center_data['cost_center_id'];

            $request = $this->travel_desk->get_all_travel_request($cost_center_id);
            $view_request = array('request' => $request);

            $refund_request = $this->travel_desk->get_all_refund_request();
            $view_request['refund_request'] = $refund_request;
            $this->template->write_view('content', 'travel_desk/inbox', $view_request);
            $this->template->render();
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect(base_url() . 'travel_desk/inbox');
        }
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
            $view_request['full_cancellation'] = $full_cancellation;
        }

        $this->template->write_view('content', 'travel_desk/cancel_request', $view_request);
        $this->template->render();
    }

    function canceled_trip($request_id = '', $ticket_type = '', $full_cancellation = '') {
        $request = $this->travel_request->get_all_request_by_id($request_id);
        if (!$request) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {
            if ($request['approval_status'] == 'Approved') {

                if ($ticket_type == '') {
                    $data_array = array(
                        'status' => 'cancel',
                        'refund_amount' => $this->input->post('refund_amount'),
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
                        redirect(base_url() . 'travel_desk/inbox');
                    } else {
                        $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                        redirect(base_url() . 'travel_desk/inbox');
                    }
                } else {
                    $data_array2 = array(
                        'cancel_status' => "1",
                        'refund_amount' => $this->input->post('refund_amount'),
                        'cancellation_comment' => $this->input->post('comment'),
                    );
                    if ($ticket_type == "1") {
                        if (!$this->common->update_data($data_array2, 'flight_ticket_booking', 'request_id', $request_id)) {
                            $subject = "Flight Booking Cancellation Status";
                            $reference_id = $request['reference_id'];
                            $messege = "Your Trip " . $reference_id . " Flight Booking Cancelled";
                            $to = $request['email'];
                            $this->sendEmail($to, $subject, $messege);

                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . travel_desk / inbox);
                        }
                    } else if ($ticket_type == "2") {
                        if (!$this->common->update_data($data_array2, 'train_ticket_booking', 'request_id', $request_id)) {
                            $subject = "Train Booking Cancellation Status";
                            $reference_id = $request['reference_id'];
                            $messege = "Your Trip " . $reference_id . " Train Booking Cancelled";
                            $to = $request['email'];
                            $this->sendEmail($to, $subject, $messege);

                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . travel_desk / inbox);
                        }
                    } else if ($ticket_type == "3") {
                        if (!$this->common->update_data($data_array2, 'car_ticket_booking', 'request_id', $request_id)) {
                            $subject = "Car Booking Cancellation Status";
                            $reference_id = $request['reference_id'];
                            $messege = "Your Trip " . $reference_id . " Car Booking Cancelled";
                            $to = $request['email'];
                            $this->sendEmail($to, $subject, $messege);
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . travel_desk / inbox);
                        }
                    } else if ($ticket_type == "4") {
                        if (!$this->common->update_data($data_array2, 'bus_ticket_booking', 'request_id', $request_id)) {
                            $subject = "Bus Booking Cancellation Status";
                            $reference_id = $request['reference_id'];
                            $messege = "Your Trip " . $reference_id . " Bus Booking Cancelled";
                            $to = $request['email'];
                            $this->sendEmail($to, $subject, $messege);
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . travel_desk / inbox);
                        }
                    } else if ($ticket_type == "5") {
                        if (!$this->common->update_data($data_array2, 'hotel_booking', 'request_id', $request_id)) {
                            $subject = "Hotel Booking Cancellation Status";
                            $reference_id = $request['reference_id'];
                            $messege = "Your Trip " . $reference_id . " Hotel Booking Cancelled";
                            $to = $request['email'];
                            $this->sendEmail($to, $subject, $messege);
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . travel_desk / inbox);
                        }
                    } else if ($ticket_type == "6") {
                        if (!$this->common->update_data($data_array2, 'car_booking', 'request_id', $request_id)) {
                            $subject = "Car Booking Cancellation Status";
                            $reference_id = $request['reference_id'];
                            $messege = "Your Trip " . $reference_id . " Car Booking Cancelled";
                            $to = $request['email'];
                            $this->sendEmail($to, $subject, $messege);
                            $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                            redirect(base_url() . travel_desk / inbox);
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                        redirect(base_url() . travel_desk / inbox);
                    }
                    if ($full_cancellation == "0") {
                        $data_array = array(
                            'status' => 'cancel',
                            'refund_amount' => $this->input->post('refund_amount'),
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
                            redirect(base_url() . 'travel_desk/inbox');
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect(base_url() . 'travel_desk/inbox');
                        }
                    } else {
                        $data_array = array(
                            'cancel_status' => '0',
                        );
                        if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                            $this->session->set_flashdata('success', 'Request Cancelled successfully');
                            redirect(base_url() . 'travel_desk/inbox');
                        } else {
                            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                            redirect(base_url() . 'travel_desk/inbox');
                        }
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Request Already Rejected');
                redirect(base_url() . 'travel_desk/inbox');
            }
        }
    }

    function booking($request_id) {
        $view_request = array();

        $request = $this->travel_desk->get_travel_request_by_id($request_id);
        $view_request['request'] = $request;
        if ($request['other_manager_expense'] == "1") {
            
        }
        if ($request['group_travel'] == "1") {
            $member_list = $this->travel_request->get_all_member_list_by_id($request_id);
            $view_request['member_list'] = $member_list;
        }

        $member_other_list = $this->travel_request->get_all_member_other_list_by_id($request_id);
        $view_request['member_other_list'] = $member_other_list;

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

        $this->template->write_view('content', 'travel_desk/booking_request', $view_request);
        $this->template->render();
    }

    function get_hotel_category_by_location($city, $type = '') {
        $data = $this->travel_desk->get_hotel_category_by_location($city, $type);
        echo json_encode($data);
    }

    function get_hotel_rent_by_occupancy($hotel_id, $type = '') {
        $response = array();
        $data = $this->travel_desk->get_travel_category_id($hotel_id);
        if (!empty($data)) {
            if ($type == "2") {
                $response['status'] = '1';
                $response['amount'] = $data['amount'];
            } else {
                $response['status'] = '1';
                $response['amount'] = $data['half_amount'];
            }
        } else {
            $response['status'] = '0';
            $response['amount'] = '';
        }
        echo json_encode($response);
    }

    function get_car_rent_by_type($car_id, $type = '') {
        $response = array();
        $data = $this->travel_desk->get_travel_category_id($car_id);
        if (!empty($data)) {
            if ($type == "2") {
                $response['status'] = '1';
                $response['amount'] = $data['amount'];
            } else {
                $response['status'] = '1';
                $response['amount'] = $data['half_amount'];
            }
        } else {
            $response['status'] = '0';
            $response['amount'] = '';
        }
        echo json_encode($response);
    }

    function other_expense() {
        if ($this->input->post()) {
            $request_id = $this->input->post('request_id');
            $pick_up_location = $this->input->post('pick_up_location');
            $drop_off_location = $this->input->post('drop_off_location');
            $pick_up_date = $this->input->post('pick_up_date');
            $drop_off_date = $this->input->post('drop_off_date');

            $request = $this->travel_desk->get_travel_request_by_id($request_id);
            $trip_ticket = $request['trip_ticket'];
            $hotel_booking = $request['hotel_booking'];

            if ($request['accommodation'] == '1' || $request['accommodation'] == '2') {
                $hotel_booking = $request['hotel_booking'];
            } else {
                $hotel_booking = "1";
            }

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
                        $trip_ticket = "0";
                    }
                } else {
                    $trip_ticket = $request['trip_ticket'];
                }
            } else {
                $trip_ticket = "1";
            }

            $data_array = $this->input->post();
            unset($data_array['trip_mode']);
            if ($this->common->insert_data($data_array, 'other_manager_expense')) {
                $data_array = array();
                $redirect_flag = 0;
                $data_array['other_manager_expense'] = '1';
                if ($trip_ticket == "1" && $hotel_booking == "1" && $car_booking == "1") {
                    $data_array['request_status'] = '4';
                    $redirect_flag++;
                }

                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {
                    $this->session->set_flashdata('success', 'expense added successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
        }
    }

    function car_booking() {
        if ($this->input->post()) {
            $request_id = $this->input->post('request_id');
            $pick_up_location = $this->input->post('pick_up_location');
            $drop_off_location = $this->input->post('drop_off_location');
            $pick_up_date = $this->input->post('pick_up_date');
            $drop_off_date = $this->input->post('drop_off_date');

            $request = $this->travel_desk->get_travel_request_by_id($request_id);
            $trip_ticket = $request['trip_ticket'];
            $hotel_booking = $request['hotel_booking'];
            $other_manager_expense = $request['other_manager_expense'];

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
                    redirect('travel_desk/inbox', 'refresh');
                }
            }

            $drop_off_date = $this->input->post('drop_off_date');
            if ($drop_off_date == '') {
                $data_array['drop_off_date'] = null;
            }

            unset($data_array['car_type']);
            if ($this->common->insert_data($data_array, 'car_booking')) {
                $redirect_flag = 0;
                $data_array = array();
                $data_array['car_booking'] = '1';
                if ($trip_ticket == "1" && $hotel_booking == "1" && $other_manager_expense == "1") {
                    $data_array['request_status'] = '4';
                    $redirect_flag++;
                }

                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['employee_name'] . ",</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>local conveyance from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $pick_up_location . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> To </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $drop_off_location . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> Car Hired successfully at " . $request_data['to_city_name'] . ".</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Below is car hired details-</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Pick-Up Location: " . $pick_up_location . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Drop Location: " . $drop_off_location . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Pick-Up Date &amp; Time: " . $pick_up_date . "</span></span></p>

<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('employee_request/view/') . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view more details of Trip</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>(Personal Task</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>&gt; My Request</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>)</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d014-7fb7-6550-94bb259e5555'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";
                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Accommodation Booked";
                    $to = $request_data['employee_email'];
                    $this->sendEmail($to, $subject, $message);

                    $this->session->set_flashdata('success', 'Car Booked successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
        }
    }

    function hotel_booking() {

        if ($this->input->post()) {
            $request_id = $this->input->post('request_id');

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
            $check_in_date = $this->input->post('check_in_date');
            $check_out_date = $this->input->post('check_out_date');
            $comment = $this->input->post('comment');
            $room_no = $this->input->post('bill_no');
            if ($check_out_date == '') {
                $data_array['check_out_date'] = null;
            }
            $cost = $this->input->post('cost');
            if ($cost == '') {
                $data_array['cost'] = 0;
            }



            $data_array['hotel_attchment'] = '';
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
                    redirect('travel_desk/inbox', 'refresh');
                }
            }

            unset($data_array['occupancy']);
            if ($this->common->insert_data($data_array, 'hotel_booking')) {
                $data_array = array();
                $redirect_flag = 0;
                $data_array['hotel_booking'] = '1';
                $other_manager_expense = $request['other_manager_expense'];
                if ($car_booking == "1" && $trip_ticket == "1" && $other_manager_expense == "1") {
                    $data_array['request_status'] = '4';
                    $redirect_flag++;
                }
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    $hotel_id = $this->input->post('hotel_provider_id');
                    $this->load->model('Travel_category_model', "hotel_model");
                    $hotel_data = $this->hotel_model->get_travel_category_id($hotel_id);

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['employee_name'] . ",</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your " . $request_data['to_city_name'] . " Trip accommodation has been booked successfully.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Below is stay details-</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Name of &lt;Hotel /Guest House&gt;: " . $hotel_data['name'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Address: " . $hotel_data['address'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Room No: " . $room_no . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Contact Number: " . $hotel_data['phone'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Check-In Date: " . $check_in_date . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Check-out Date: " . $check_out_date . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Desk Comment:" . $comment . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('employee_request/view/') . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view more details of Trip</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>(Personal Task</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>&gt; My Request</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>&gt;</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>View Details)</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d000-e20b-97dd-43adf5382d67'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Accommodation Booked";
                    $reference_id = $request['reference_id'];
                    $to = $request['email'];
                    $this->sendEmail($to, $subject, $message);

                    $this->session->set_flashdata('success', 'Hotel Booked successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
        }
    }

    function flight_booking() {
        if ($this->input->post()) {
            $pnr_number = $this->input->post('pnr_number');
            $trip_number = $this->input->post('flight_number');
            $trip_mode = $this->input->post('trip_mode');
            $request_id = $this->input->post('request_id');
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
                    redirect('travel_desk/inbox', 'refresh');
                }
            }


            if ($this->common->insert_data($data_array, 'flight_ticket_booking')) {
                $data_array = array();
                $booking_mode = 0;
                $redirect_flag = 0;
                $other_manager_expense = $request['other_manager_expense'];
                if ($trip_mode == 1) {
                    $data_array['trip_ticket_return'] = '1';
                    if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1' && $other_manager_expense == "1") {
                        $data_array['request_status'] = '4';
                        $booking_mode = 1;
                        $redirect_flag++;
                    }
                } else {
                    $data_array['trip_ticket'] = '1';
                    if ($request['trip_type'] == '1') {
                        if ($car_booking == "1" && $hotel_booking == "1" && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $booking_mode = 1;
                            $redirect_flag++;
                        }
                    } else {
                        if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1' && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $booking_mode = 1;
                            $redirect_flag++;
                        }
                    }
                }
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);

                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['employee_name'] . ",</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your " . $request_data['to_city_name'] . " Trip ticket has been booked. Please </span><a target='_blanck' href='" . base_url('employee_request/view/') . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view ticket of Trip</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>";

                    if ($car_booking != "1" && $hotel_booking != "1") {
                        $message .= "<span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . " Travel Desk will provide you there accommodation/Car booking shortly.</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>	&nbsp;</p>";
                    }

                    $message .= "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Flight Number: " . $pnr_number . "</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>PNR:" . $trip_number . "</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <br />
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
                        <div>
                                &nbsp;</div>
                        ";

                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $reference_id = $request['reference_id'];
                    $to = $request['email'];
                    $this->sendEmail($to, $subject, $message);


                    $to_city_id = $request['to_city_id'];
                    $cost_center_list = $this->travel_request->get_cost_center_by_city_id($to_city_id);
                    $cost_center_id = $cost_center_list['cost_center_id'];


                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi Travel Desk,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Mr. " . $request_data['employee_name'] . " is reaching at </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>. Duration</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $travel_date . " </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Kindly book the accommodation of trip.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Train Number: " . $trip_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>PNR: " . $pnr_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Reaching Date&amp;Time:" . $request_data['return_date'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('travel_desk/booking/') . '/' . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view travel ticket of Trip</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>(Travel Desk &gt; Inbox )</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $travel_email = $this->travel_request->get_travel_manager_email_from_id($cost_center_id);

                    if (!empty($travel_email)) {
                        $to_email = '';
                        foreach ($travel_email as $key => $value) {
                            $to_email[] = $value['email'];
                        }
                        $this->sendEmail($to_email, $subject, $message);
                    }

                    $this->session->set_flashdata('success', 'Trip Booked successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
        }
    }

    function train_booking() {
        if ($this->input->post()) {
            $trip_mode = $this->input->post('trip_mode');
            $pnr_number = $this->input->post('pnr_number');
            $trip_number = $this->input->post('train_number');
            $request_id = $this->input->post('request_id');
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
                    redirect('travel_desk/inbox', 'refresh');
                }
            }


            if ($this->common->insert_data($data_array, 'train_ticket_booking')) {
                $booking_mode = 0;
                $redirect_flag = 0;
                $data_array = array();
                $other_manager_expense = $request['other_manager_expense'];
                if ($trip_mode == 1) {
                    $data_array['trip_ticket_return'] = '1';
                    if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1' && $other_manager_expense == "1") {
                        $data_array['request_status'] = '4';
                        $redirect_flag++;
                        $booking_mode = 1;
                    }
                } else {
                    $data_array['trip_ticket'] = '1';
                    if ($request['trip_type'] == '1') {
                        if ($car_booking == "1" && $hotel_booking == "1" && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $redirect_flag++;
                            $booking_mode = 1;
                        }
                    } else {
                        if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1' && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $redirect_flag++;
                            $booking_mode = 1;
                        }
                    }
                }

                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);

                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['employee_name'] . ",</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your " . $request_data['to_city_name'] . " Trip ticket has been booked. Please </span><a target='_blanck' href='" . base_url('employee_request/view/') . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view ticket of Trip</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>";

                    if ($car_booking != "1" && $hotel_booking != "1") {
                        $message .= "<span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . " Travel Desk will provide you there accommodation/Car booking shortly.</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>	&nbsp;</p>";
                    }

                    $message .= "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Train Number: " . $pnr_number . "</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>PNR:" . $trip_number . "</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <br />
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
                        <div>
                                &nbsp;</div>
                        ";
                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $reference_id = $request['reference_id'];
                    $to = $request['email'];
                    $this->sendEmail($to, $subject, $message);


                    $to_city_id = $request['to_city_id'];
                    $cost_center_list = $this->travel_request->get_cost_center_by_city_id($to_city_id);
                    $cost_center_id = $cost_center_list['cost_center_id'];


                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi Travel Desk,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Mr. " . $request_data['employee_name'] . " is reaching at </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>. Duration</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $travel_date . " </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Kindly book the accommodation of trip.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Train Number: " . $trip_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>PNR: " . $pnr_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Reaching Date&amp;Time:" . $request_data['return_date'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('travel_desk/booking/') . '/' . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view travel ticket of Trip</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>(Travel Desk &gt; Inbox )</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $travel_email = $this->travel_request->get_travel_manager_email_from_id($cost_center_id);

                    if (!empty($travel_email)) {
                        $to_email = '';
                        foreach ($travel_email as $key => $value) {
                            $to_email[] = $value['email'];
                        }
                        $this->sendEmail($to_email, $subject, $message);
                    }

                    $this->session->set_flashdata('success', 'Trip Booked successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
        }
    }

    function car_ticket_booking() {
        if ($this->input->post()) {
            $trip_mode = $this->input->post('trip_mode');
            $request_id = $this->input->post('request_id');
            $request = $this->travel_desk->get_travel_request_by_id($request_id);

            $car_booking = $request['car_booking'];
            $hotel_booking = $request['hotel_booking'];

            if ($request['car_hire'] == '1') {
                $car_booking = $request['car_booking'];
            } else {
                $car_booking = "1";
            }

            if ($request['accommodation'] == '1') {
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
                    redirect('travel_desk/inbox', 'refresh');
                }
            }


            if ($this->common->insert_data($data_array, 'car_ticket_booking')) {
                $booking_mode = 0;
                $redirect_flag = 0;
                $data_array = array();
                $other_manager_expense = $request['other_manager_expense'];
                if ($trip_mode == 1) {
                    $data_array['trip_ticket_return'] = '1';
                    if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1' && $other_manager_expense == "1") {
                        $data_array['request_status'] = '4';
                        $booking_mode = 1;
                        $redirect_flag++;
                    }
                } else {
                    $data_array['trip_ticket'] = '1';
                    if ($request['trip_type'] == '1') {
                        if ($car_booking == "1" && $hotel_booking == "1" && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $booking_mode = 1;
                            $redirect_flag++;
                        }
                    } else {
                        if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1' && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $booking_mode = 1;
                            $redirect_flag++;
                        }
                    }
                }
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);

                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['employee_name'] . ",</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your " . $request_data['to_city_name'] . " Trip ticket has been booked. Please </span><a target='_blanck' href='" . base_url('employee_request/view/') . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view ticket of Trip</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>";

                    if ($car_booking != "1" && $hotel_booking != "1") {
                        $message .= "<span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . " Travel Desk will provide you there accommodation/Car booking shortly.</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>	&nbsp;</p>";
                    }

                    $message .= "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
                        
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <br />
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
                        <div>
                                &nbsp;</div>
                        ";
                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $reference_id = $request['reference_id'];
                    $to = $request['email'];
                    $this->sendEmail($to, $subject, $message);


                    $to_city_id = $request['to_city_id'];
                    $cost_center_list = $this->travel_request->get_cost_center_by_city_id($to_city_id);
                    $cost_center_id = $cost_center_list['cost_center_id'];


                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi Travel Desk,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Mr. " . $request_data['employee_name'] . " is reaching at </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>. Duration</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $travel_date . " </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Kindly book the accommodation of trip.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Train Number: " . $trip_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>PNR: " . $pnr_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Reaching Date&amp;Time:" . $request_data['return_date'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('travel_desk/booking/') . '/' . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view travel ticket of Trip</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>(Travel Desk &gt; Inbox )</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $travel_email = $this->travel_request->get_travel_manager_email_from_id($cost_center_id);

                    if (!empty($travel_email)) {
                        $to_email = '';
                        foreach ($travel_email as $key => $value) {
                            $to_email[] = $value['email'];
                        }
                        $this->sendEmail($to_email, $subject, $message);
                    }

                    $this->session->set_flashdata('success', 'Trip Booked successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
        }
    }

    function bus_ticket_booking() {
        if ($this->input->post()) {
            $trip_mode = $this->input->post('trip_mode');
            $request_id = $this->input->post('request_id');
            $request = $this->travel_desk->get_travel_request_by_id($request_id);

            $car_booking = $request['car_booking'];
            $hotel_booking = $request['hotel_booking'];

            if ($request['car_hire'] == '1') {
                $car_booking = $request['car_booking'];
            } else {
                $car_booking = "1";
            }

            if ($request['accommodation'] == '1') {
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
                    redirect('travel_desk/inbox', 'refresh');
                }
            }


            if ($this->common->insert_data($data_array, 'bus_ticket_booking')) {
                $booking_mode = 0;
                $redirect_flag = 0;
                $data_array = array();
                $other_manager_expense = $request['other_manager_expense'];
                if ($trip_mode == 1) {
                    $data_array['trip_ticket_return'] = '1';
                    if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket'] == '1' && $other_manager_expense == "1") {
                        $data_array['request_status'] = '4';
                        $booking_mode = 1;
                        $redirect_flag++;
                    }
                } else {
                    $data_array['trip_ticket'] = '1';
                    if ($request['trip_type'] == '1') {
                        if ($car_booking == "1" && $hotel_booking == "1" && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $booking_mode = 1;
                            $redirect_flag++;
                        }
                    } else {
                        if ($car_booking == "1" && $hotel_booking == "1" && $request['trip_ticket_return'] == '1' && $other_manager_expense == "1") {
                            $data_array['request_status'] = '4';
                            $booking_mode = 1;
                            $redirect_flag++;
                        }
                    }
                }
                if ($this->common->update_data($data_array, 'travel_request', 'id', $request_id)) {


                    $request_data = $this->travel_request->get_request_details_by_id($request_id);

                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['employee_name'] . ",</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your " . $request_data['to_city_name'] . " Trip ticket has been booked. Please </span><a target='_blanck' href='" . base_url('employee_request/view/') . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view ticket of Trip</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>";

                    if ($car_booking != "1" && $hotel_booking != "1") {
                        $message .= "<span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . " Travel Desk will provide you there accommodation/Car booking shortly.</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>	&nbsp;</p>";
                    }

                    $message .= "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
                        
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <br />
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                &nbsp;</p>
                        <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                <span id='docs-internal-guid-b1891aba-cf4c-b842-1e0d-d50556ef916e'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
                        <div>
                                &nbsp;</div>
                        ";
                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $reference_id = $request['reference_id'];
                    $to = $request['email'];
                    $this->sendEmail($to, $subject, $message);


                    $to_city_id = $request['to_city_id'];
                    $cost_center_list = $this->travel_request->get_cost_center_by_city_id($to_city_id);
                    $cost_center_id = $cost_center_list['cost_center_id'];


                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi Travel Desk,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Mr. " . $request_data['employee_name'] . " is reaching at </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>. Duration</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'> </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $travel_date . " </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Kindly book the accommodation of trip.</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Following are the trip details-</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>From To: </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Train Number: " . $trip_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>PNR: " . $pnr_number . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Reaching Date&amp;Time:" . $request_data['return_date'] . "</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url('travel_desk/booking/') . '/' . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to view travel ticket of Trip</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>(Travel Desk &gt; Inbox )</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<br />
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	&nbsp;</p>
<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
	<span id='docs-internal-guid-b1891aba-d07d-5aac-d1bb-3bc9e9aacf51'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
<div>
	&nbsp;</div>
";

                    $subject = " " . $request_data['reference_id'] . ",  From " . $request_data['from_city_name'] . " To " . $request_data['to_city_name'] . " Trip Ticket Booked";
                    $travel_email = $this->travel_request->get_travel_manager_email_from_id($cost_center_id);

                    if (!empty($travel_email)) {
                        $to_email = '';
                        foreach ($travel_email as $key => $value) {
                            $to_email[] = $value['email'];
                        }
                        $this->sendEmail($to_email, $subject, $message);
                    }

                    $this->session->set_flashdata('success', 'Trip Booked successfully');
                    if ($redirect_flag != 0) {
                        redirect('travel_desk/inbox', 'refresh');
                    } else {
                        redirect('travel_desk/booking/' . $request_id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('travel_desk/inbox', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('travel_desk/inbox', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('travel_desk/inbox', 'refresh');
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

    public function inbox1() {
        $employee_id = $this->session->userdata('employee_id');
        $pending_request = $this->travel_request->get_all_pending_request_for_manager($employee_id);
        $completed_request = $this->travel_request->get_all_completed_request_for_manager($employee_id);

        $view_request = array('pending_request' => $pending_request);
        $view_request['completed_request'] = $completed_request;

        $this->template->write_view('content', 'employee_request/inbox_request', $view_request);
        $this->template->render();
    }

    function approval_request($request_id) {
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->travel_request->get_all_request_by_id($request_id);
        $view_request = array('request' => $request, 'request_id' => $request_id);

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

}
