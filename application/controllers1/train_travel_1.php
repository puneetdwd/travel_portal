<?php

class Train_travel extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'train_travel'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("travel_request_model", 'travel_request');
        $this->load->model("travel_category_model", 'travel_category');
    }

    public function index($travel_request_id = '') {
        $employee_id = $this->session->userdata('employee_id');
        if ($employee_id != '') {
            $view_data = array();

            if (!empty($travel_request_id)) {
                $request = $this->travel_request->get_request_id($travel_request_id);
                $view_data['travel_request'] = $request;
                if (isset($request['request_number'])) {
                    $view_data['request_number'] = $request['request_number'];
                } else {
                    $view_data['request_number'] = rand(11111111, 9999999);
                }

                
                if ($request['group_travel'] == "1") {
//                    $member_list = $this->travel_request->get_all_member_list_by_id($request_id);
//                    $view_request['member_list'] = $member_list;

                    $member_other_list = $this->travel_request->get_all_member_other_list_by_id($request['id']);
                    $view_data['member_other_list'] = $member_other_list;
                }
            } else {
                $view_data['request_number'] = rand(11111111, 9999999);
            }

            $this->load->model("travel_reasons_model");
            $travel_reasons = $this->travel_reasons_model->get_all_travel_reasons();
            $view_data['travel_reasons'] = $travel_reasons;

            $train_date = $this->travel_category->get_all_train_category();
            $view_data['train_category'] = $train_date;
//            po($view_data['train_category']);

            $this->load->model('employee_model');
            $employee = $this->employee_model->get_employee_by_id_new($employee_id);
            $view_data['employee'] = $employee;
            $grade_id = $employee['grade_id'];

//            $employees = $this->employee_model->get_all_employees();
//            $view_data['employees'] = $employees;

            $dept_id = $employee['dept_id'];
            $this->load->model("projects_model");
            $projects = $this->projects_model->get_all_projects();
            $view_data['projects'] = $projects;


            $this->load->model('travel_policy_model');
            $policy_data = $this->travel_policy_model->get_travel_policy_by_grade($grade_id, $service_type = '2');

            $view_data['approval_level'] = '';
            $view_data['reporting_manager_id'] = '';
            if (!empty($policy_data)) {
                if ($policy_data['approval_level'] == 1) {
                    $view_data['approval_level'] = $policy_data['approval_level'];
                    $reporting_manager_data = $this->travel_request->get_employee_manager_id($employee_id);
                    $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
                } else if ($policy_data['approval_level'] == 2) {
                    $view_data['approval_level'] = $policy_data['approval_level'];
                    $reporting_manager_data = $this->travel_request->get_employee_manager_base_id($employee_id);
                    $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
                } else if ($policy_data['approval_level'] == 0) {
                    $view_data['approval_level'] = $policy_data['approval_level'];
                    $reporting_manager_data = $this->travel_request->get_employee_manager_base_id($employee_id);
                    $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
                } else {
                    $view_data['approval_level'] = "1";
                    $reporting_manager_data = $this->travel_request->get_employee_manager_id($employee_id);
                    $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
                }
            } else {
                $view_data['approval_level'] = "1";
                $reporting_manager_data = $this->travel_request->get_employee_manager_id($employee_id);
                $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
            }

            if ($view_data['reporting_manager_id'] == '') {
                $view_data['approval_level'] = "1";
                $reporting_manager_data = $this->travel_request->get_employee_manager_id($employee_id);
                $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
                if ($view_data['reporting_manager_id'] == '') {
                    $view_data['error'] = 'Reporting Manager Not fount.';
                    $this->session->set_flashdata('error', 'Reporting Manager Not fount.');
                    redirect(base_url() . dashboard);
                }
            }
            $traverl_class_data = $this->travel_request->get_travel_class_by_grade($grade_id, $service_type = '2');
            $view_data['sel_traverl_class'] = $traverl_class_data;

            $this->load->model("city_model");
            $city = $this->city_model->get_all_city();
            $view_data['city'] = $city;

            $hotel_allowance = 0;
            $hotel_allowance_actual = 0;
            $DA_allowance = 0;
            $DA_allowance_actual = 0;
            $convince_allowance = 0;
            $convince_allowance_actual = 0;
            if ($this->input->post()) {
                if (!empty($travel_request_id)) {
                    $this->travel_request->delete_request_other_member($travel_request_id);
                }

                $emp_list = $this->session->userdata('emp_list');
                $member_list = array();
                if (!empty($emp_list)) {
                    foreach ($emp_list as $key => $value) {
                        $member_list[] = $key;
                    }
                }
                $from_city_id = $this->input->post('from_city_id');
                $to_city_id = $this->input->post('to_city_id');
                if ($from_city_id == $to_city_id) {
                    $this->session->set_flashdata('error', 'To and From Location can not be same..!!');
                    redirect('train_travel', 'refresh');
                }

                $post_data = $this->input->post();

                $departure_date = $this->input->post('departure_date');
                $return_date = $this->input->post('return_date');
                if ($return_date != '') {
                    if ($departure_date > $return_date) {
                        $this->session->set_flashdata('error', 'Return date must be greater than the departure date');
                        redirect('train_travel', 'refresh');
                    }
                }

                $reference_id = $this->travel_request->generate_reference_id();
                $post_data['reference_id'] = $reference_id;
                $request_number = $this->input->post('request_number');
                $post_data['employee_id'] = $employee_id;
                $post_data['request_date'] = date('Y-m-d');
                $post_data['status'] = 'active';

                $project_id = $this->input->post('project_id');
                if ($project_id == '') {
                    $post_data['project_id'] = null;
                }

                $return_date = $this->input->post('return_date');
                if ($return_date == '') {
                    $travel_date = $departure_date;
                    $travel_day = "1";
                    $post_data['trip_type'] = '1';
                    $post_data['return_date'] = null;
                } else {
                    $now = strtotime(date('Y-m-d', strtotime($this->input->post('departure_date'))));
                    $your_date = strtotime(date('Y-m-d', strtotime($this->input->post('return_date'))));
                    $datediff = $your_date - $now;
                    $travel_day = floor($datediff / (60 * 60 * 24));
                    $travel_date = $departure_date . " To " . $return_date;
                }

                if ($post_data['approval_level'] == 0) {
                    $post_data['approval_status'] = 'Approved';
                    $post_data['request_status'] = '2';
                }

                $to_city_id = $this->input->post('to_city_id');
                $to_city = $this->city_model->get_city($to_city_id);
                $to_class = $to_city['class'];

                $policy_data = $this->travel_policy_model->get_policy_allowance_by_grade($grade_id, $to_class);
                foreach ($policy_data as $key => $value) {
                    if ($value['service_type'] == "5") {
                        if ($value['actual'] == "0") {
                            $hotel_allowance = $value['amount'];
                        } else {
                            $hotel_allowance_actual = 1;
                        }
                    } else if ($value['service_type'] == "6") {
                        if ($value['actual'] == "0") {
                            $DA_allowance = $value['amount'];
                        } else {
                            $DA_allowance_actual = 1;
                        }
                    } else if ($value['service_type'] == "7") {
                        if ($value['actual'] == "0") {
                            $convince_allowance = $value['amount'];
                        } else {
                            $convince_allowance_actual = 1;
                        }
                    }
                }

                $d1 = new DateTime($this->input->post('departure_date'));
                $d2 = new DateTime($this->input->post('return_date'));
                $interval = $d1->diff($d2);
                $hr = ($interval->days * 24) + $interval->h;

                if ($hr < 14) {
                    $DA_allowance = $DA_allowance / 2;
                }

                $post_data['hotel_allowance'] = $hotel_allowance;
                $post_data['hotel_allowance_actual'] = $hotel_allowance_actual;
                $post_data['DA_allowance'] = $DA_allowance;
                $post_data['DA_allowance_actual'] = $DA_allowance_actual;
                $post_data['convince_allowance'] = $convince_allowance;
                $post_data['convince_allowance_actual'] = $convince_allowance_actual;

//                die();
//                $member_list = $this->input->post('member_list');
                $employee_name = $this->input->post('employee_name');
                $age = $this->input->post('age');
                $mobile_no = $this->input->post('mobile_no');
                $email = $this->input->post('email');
                if (!empty($member_list)) {
                    $post_data['group_travel'] = "1";
                } else {
                    $post_data['group_travel'] = "0";
                    if (!empty($employee_name)) {
                        foreach ($employee_name as $key => $emp_name) {
                            if ($employee_name[$key] != '' && $age[$key] != '' && $mobile_no[$key] != '' && $email[$key] != '') {
                                $post_data['group_travel'] = "1";
                            }
                        }
                    }
                }

                $comb_id = $this->travel_request->get_travel_request_combination_draft($post_data['request_number']);
                if (empty($comb_id)) {
                    $request_number = '';
                }

                $data = $this->travel_request->update_travel_request($post_data, $request_number);
                if ($data) {
                    if (empty($comb_id)) {
                        $request_id = $this->db->insert_id();
                    } else {
                        $request_id = $comb_id['id'];
                    }
                    if (!empty($member_list)) {
                        foreach ($member_list as $key => $emp_id) {
                            $data_array = array(
                                'request_id' => $request_id,
                                'employee_id' => $emp_id,
                            );
                            if (!$this->common->insert_data($data_array, 'travel_request_member')) {
                                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                                redirect($this->last_url(), 'refresh');
                            }
                        }
                    }

                    if (!empty($employee_name)) {

                        foreach ($employee_name as $key => $emp_name) {
                            if ($employee_name[$key] != '' && $age[$key] != '' && $mobile_no[$key] != '' && $email[$key] != '') {
                                $data_array = array(
                                    'request_id' => $request_id,
                                    'employee_name' => $employee_name[$key],
                                    'age' => $age[$key],
                                    'mobile_no' => $mobile_no[$key],
                                    'email' => $email[$key],
                                );
                                if (!$this->common->insert_data($data_array, 'travel_request_member_others')) {
                                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                                    redirect($this->last_url(), 'refresh');
                                }
                            }
                        }
                    }

                    $request_data = $this->travel_request->get_request_details_by_id($request_id);
                    $traval_amount = $request_data['hotel_allowance'] + $request_data['da_allowance'] + $request_data['convince_allowance'];

                    if ($request_data['travel_type'] == "1") {
                        $travel_mode = "Flight";
                    } else if ($request_data['travel_type'] == "2") {
                        $travel_mode = "Train";
                    } else if ($request_data['travel_type'] == "3") {
                        $travel_mode = "Car";
                    } else if ($request_data['travel_type'] == "4") {
                        $travel_mode = "Bus";
                    }


                    if ($post_data['approval_level'] == 0) {
                        $post_data = array(
                            'request_id' => $request_id,
                            'travel_ticket' => '1',
                            'accommodation' => '1',
                            'car_hire' => '1',
                            'bookbyself' => '0',
                            'bookbymanager' => '1',
                        );
                        $data = $this->travel_request->update_travel_booking($post_data);
                        if ($data) {
                            $req_data = array(
                                'request_status' => "3",
                            );
                            $data1 = $this->travel_request->update_travel_request_status($req_data, $request_id);
                            $msg = (!empty($request_number)) ? ' Trip Raised Successfully To Accommodation ' : 'Trip Raised Successfully To Accommodation ';
                        } else {
                            $view_data['error'] = 'Something went wrong, please try again later.';
                        }

                        $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-cb6f-31d1-c426-6f3cc6cbea2a'>
                                    <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); 
                                        background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>
                                        Hi " . $request_data['employee_name'] . ",
                                    </span>
                                    </span>
                                    </p>
                                    <br />
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>&nbsp;</p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                        <span id='docs-internal-guid-b1891aba-cb6f-31d1-c426-6f3cc6cbea2a'>
                                        <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); 
                                            background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>
                                            Your travel request has been raised. 
                                        </span>
                                        </span>
                                    </p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <br />
                                    <br />
                                    &nbsp;</p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                        <span id='docs-internal-guid-b1891aba-cb6f-31d1-c426-6f3cc6cbea2a'>
                                        <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); 
                                            background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>
                                            Please </span><a target='_blanck' href='" . base_url("employee_request/view/") . "/" . $request_id . "' 
                                                style='text-decoration-line: none;'>
                                            <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); 
                                            background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>
                                            click here</span></a>
                                            <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); 
                                            background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> 
                                            to review of the travel request.
                                        </span>
                                        </span>
                                    </p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                        <br />
                                        &nbsp;</p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                        <span id='docs-internal-guid-b1891aba-cb6f-31d1-c426-6f3cc6cbea2a'>
                                        <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); 
                                            background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                        <span id='docs-internal-guid-b1891aba-cb6f-31d1-c426-6f3cc6cbea2a'>
                                        <span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); 
                                        background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                            &nbsp;</p>
                                    <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                        <span id='docs-internal-guid-b1891aba-cb6f-31d1-c426-6f3cc6cbea2a'>
                                        <span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); 
                                        background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>
                                        This is an automatically generated email, please do not reply
                                        </span>
                                        </span>
                                    </p>
                                    <div>
                                    &nbsp;</div>
                            ";

                        $cc = '';
                        $to = $request_data['employee_email'];
                    } else {
                        $msg = (!empty($request_number)) ? "Trip raised successfully for Manager's approval." : "Trip raised successfully for Manager's approval.";
                        $message = "<p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>Hi " . $request_data['manager_name'] . ",</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Your team member, </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $employee['first_name'] . " " . $employee['last_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> has raised a travel request to </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['to_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> from </span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; font-weight: 700; vertical-align: baseline; white-space: pre-wrap;'>" . $request_data['from_city_name'] . "</span><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> . </span></span></p>
                            <p>
                                    &nbsp;</p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Following are the Travel Details-</span></span></p>
                            <p>
                                    &nbsp;</p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Reson: " . $request_data['reason'] . "</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Mode: " . $travel_mode . " </span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Date from: " . $travel_date . "</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Days: " . $travel_day . " Day </span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>DA+LC Amount of Trip: &nbsp;</span>" . $traval_amount . " rs.</span></p>
                            <p>
                                    &nbsp;</p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Please </span><a target='_blanck' href='" . base_url("employee_request/approval_request/") . "/" . $request_id . "' style='text-decoration-line: none;'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(17, 85, 204); background-color: transparent; text-decoration-line: underline; vertical-align: baseline; white-space: pre-wrap;'>click here</span></a><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'> to review and Approve/Deny of the travel request.</span></span></p>
                            <p>
                                    <br />
                                    &nbsp;</p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Regards,</span></span></p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 10pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(0, 0, 0); background-color: transparent; vertical-align: baseline; white-space: pre-wrap;'>Travel Admin</span></span></p>
                            <p>
                                    &nbsp;</p>
                            <p dir='ltr' style='line-height:1.2;margin-top:0pt;margin-bottom:0pt;'>
                                    <span id='docs-internal-guid-b1891aba-ca23-a4e8-75bf-f09c5731fef6'><span style='font-size: 9pt; font-family: &quot;Trebuchet MS&quot;; color: rgb(153, 153, 153); background-color: transparent; font-style: italic; vertical-align: baseline; white-space: pre-wrap;'>This is an automatically generated email, please do not reply</span></span></p>
                            <div>
                                    &nbsp;</div>
                            ";
                        $cc = $request_data['employee_email'];
                        $to = $request_data['manager_email'];
                    }


                    $subject = $request_data['reference_id'] . ", Trip Approval " . $request_data['employee_name'] . ", " . $travel_day . " Days";
                    $this->sendEmail($to, $subject, $message, $cc);


                    $this->session->set_flashdata('success', $msg);
                    redirect(base_url() . dashboard);
                } else {
                    $view_data['error'] = 'Something went wrong, please try again later.';
                }
            } else {
                $array = array(
                    "emp_list" => ''
                );
                $this->session->set_userdata($array);
            }
            $this->template->write_view('content', 'train_travel/add_train_travel', $view_data);
            $this->template->render();
        } else {
            $view_data['error'] = 'Admin can not request for Travel.';
            $this->session->set_flashdata('error', 'Admin can not request for Travel.');
            redirect(base_url() . train_travel);
        }
    }

}
