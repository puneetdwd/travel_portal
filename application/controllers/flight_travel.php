<?php

class Flight_travel extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
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
                $flight = $this->travel_request->get_request_id($travel_request_id);
                $view_data['flight_request'] = $flight;
                if (isset($request['request_number'])) {
                    $view_data['request_number'] = $flight['request_number'];
                } else {
                    $view_data['request_number'] = rand(11111111, 9999999);
                }
            } else {
                $view_data['request_number'] = rand(11111111, 9999999);
            }

            $this->load->model("travel_reasons_model");
            $travel_reasons = $this->travel_reasons_model->get_all_travel_reasons();
            $view_data['travel_reasons'] = $travel_reasons;

            $flight_date = $this->travel_category->get_all_flight_category();
            $view_data['flight_category'] = $flight_date;

            $this->load->model('employee_model');
            $employee = $this->employee_model->get_employee_by_id_new($employee_id);
            $view_data['employee'] = $employee;
            $grade_id = $employee['grade_id'];
            $city_id = $employee['city_id'];
            $cost_center_id = $employee['cost_center_id'];

            $dept_id = $employee['dept_id'];
            $this->load->model("projects_model");
            $projects = $this->projects_model->get_all_projects();
            $view_data['projects'] = $projects;

            $this->load->model('travel_policy_model');
            $policy_data = $this->travel_policy_model->get_travel_policy_by_grade($grade_id, $service_type = '1');

            $view_data['approval_level'] = '1';
            $view_data['reporting_manager_id'] = $reporting_manager_id = $employee['reporting_manager_id'];
            if (!empty($policy_data)) {
                if ($policy_data['approval_level'] == 2) {
                    $view_data['approval_level'] = $policy_data['approval_level'];
                    $reporting_manager_data = $this->travel_request->get_employee_manager_base_id($employee_id);
                    $view_data['reporting_manager_id'] = $reporting_manager_data['reporting_manager_id'];
                } else if ($policy_data['approval_level'] == 0) {
                    $view_data['approval_level'] = $policy_data['approval_level'];
                }
            }

            if ($view_data['reporting_manager_id'] == '' || $view_data['reporting_manager_id'] == '0') {
                $view_data['error'] = 'Reporting Manager Not found.';
                $this->session->set_flashdata('error', 'Reporting Manager Not found.');
                redirect(base_url() . dashboard);
            }

            $traverl_class_data = $this->travel_request->get_travel_class_by_grade($grade_id, $service_type = '1');
            $view_data['sel_traverl_class'] = $traverl_class_data;

            $this->load->model("city_model");
            $city = $this->city_model->get_airport_all_city();
            $view_data['city'] = $city;

            $hotel_allowance = 0;
            $hotel_allowance_actual = 0;
            $DA_allowance = 0;
            $DA_allowance_actual = 0;
            $convince_allowance = 0;
            $convince_allowance_actual = 0;

            /* ----------------- POST DATA---------------------- */
            if ($this->input->post()) {

                $this->load->library('form_validation');
                $this->form_validation->set_rules('departure_date', 'Departure Date', 'required');
                $this->form_validation->set_rules('return_date', 'return_date', 'required');
                $this->form_validation->set_rules('travel_reason_id', 'travel_reason_id', 'required');
                $this->form_validation->set_rules('travel_class_id', 'travel_class_id', 'required');
                $this->form_validation->set_rules('from_city_id', 'from_city_id', 'required');
                $this->form_validation->set_rules('to_city_id', 'to_city_id', 'required');
                if ($this->form_validation->run() == FALSE)
				 {
                  $this->session->set_flashdata('error', 'Please follow validation rules!');
                  redirect('flight_travel', 'refresh');
                 }
				else
				 {
                  if(!empty($travel_request_id))
				   {
                    $this->travel_request->delete_request_other_member($travel_request_id);
                   }

                  $emp_list = $this->session->userdata('emp_list');
                  $member_list = array();
                  if(!empty($emp_list))
				   {
                    foreach($emp_list as $key=>$value)
					 {
                      $member_list[] = $key;
                     }
                   }

                  $from_city_id = $this->input->post('from_city_id');
                  $to_city_id = $this->input->post('to_city_id');
                  if($from_city_id == $to_city_id)
				   {
                    $this->session->set_flashdata('error', 'To and From Location can not be same..!!');
                    redirect('flight_travel', 'refresh');
                   }

                  $departure_date = date(DATEMYSQL, strtotime($this->input->post('departure_date')));
                  $return_date = date(DATEMYSQL, strtotime($this->input->post('return_date')));
                  if($return_date != '')
				   {
                    if($departure_date>$return_date)
					 {
                      $this->session->set_flashdata('error', 'Return date must be greater then the departure date');
                      redirect('flight_travel', 'refresh');
                     }
                   }
                  $post_data = $this->input->post();

                  $post_data['departure_date'] = date(DATEMYSQL, strtotime($post_data['departure_date']));
                  $post_data['return_date'] = date(DATEMYSQL, strtotime($post_data['return_date']));

                  $request_number = $this->input->post('request_number');
                  $reference_id = $this->travel_request->generate_reference_id();
                  $post_data['reference_id'] = $reference_id;
                  $post_data['employee_id'] = $employee_id;
                  $post_data['request_date'] = date('Y-m-d');
                  $post_data['status'] = 'active';

                  $project_id = $this->input->post('project_id');
                  if($project_id=='')
				   {
                    $post_data['project_id'] = null;
                   }

                  $return_date = $this->input->post('return_date');
                  if($return_date=='')
				   {
                    $travel_date = $departure_date;
                    $travel_day = "1";
                    $post_data['trip_type'] = '1';
                    $post_data['return_date'] = null;
                   }
				  else
				   {
                    $now = strtotime(date('Y-m-d', strtotime($this->input->post('departure_date'))));
                    $your_date = strtotime(date('Y-m-d', strtotime($this->input->post('return_date'))));
                    $datediff = $your_date - $now;
                    $travel_day = floor($datediff / (60 * 60 * 24));
                    $travel_date = $departure_date . " To " . $return_date;
                   }

                  if($post_data['approval_level']==0)
				   {
                    $post_data['approval_status'] = 'Approved';
                    $post_data['request_status'] = '2';
                   }

                  $to_city_id = $this->input->post('to_city_id');
                  $to_city = $this->city_model->get_city($to_city_id);
                  $to_class = $to_city['class'];

                  $policy_data = $this->travel_policy_model->get_policy_allowance_by_grade($grade_id, $to_class);
                  foreach($policy_data as $key => $value) {
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

                        if ($post_data['approval_level'] == 0) {
                            $post_data = array(
                                'request_id' => $request_id,
                                'travel_ticket' => '1',
                                'return_travel_ticket' => '1',
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
                                $msg = (!empty($request_number)) ? ' Trip Raised Successfully for Accommodation ' : 'Trip Raised Successfully for Accommodation ';
                            } else {
                                $view_data['error'] = 'Something went wrong, please try again later.';
                            }

                            $email_template = $this->common->select_data_by_id('email_format', 'mail_id', '2');
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
                                $request_data['url'] = "<a target='_blanck' href='" . base_url("employee_request/view/") . "/" . $request_id . "' style='text-decoration-line: none;'>Click here</a>";


                                $subject = $email_template[0]['subject'];
                                $mailformat = $email_template[0]['emailformat'];
                                $subject = str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($subject))))))))))));
                                $message = str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($mailformat))))))))))));
                                $cc = '';
                                $to = $request_data['employee_email'];
                                $this->sendEmail($to, $subject, $message, $cc);
                            }

                            $email_template = $this->common->select_data_by_id('email_format', 'mail_id', '6');

                            if (!empty($email_template)) {
                                $request_data = $this->travel_request->get_request_details_by_id($request_id);
                                $request_data['amount'] = $request_data['hotel_allowance'] + $request_data['da_allowance'] + $request_data['convince_allowance'];
                                $from_city_id = $request_data['from_city_id'];
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
                        } else {
                            $msg = (!empty($request_number)) ? "Trip raised successfully for Manager's approval." : "Trip raised successfully for Manager's approval.";

                            $email_template = $this->common->select_data_by_id('email_format', 'mail_id', '1');
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
                                $request_data['url'] = "<a target='_blanck' href='" . base_url("employee_request/approval_request/") . "/" . $request_id . "' style='text-decoration-line: none;'>Click here</a>";


                                $subject = $email_template[0]['subject'];
                                $mailformat = $email_template[0]['emailformat'];

                                $subject = str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($subject))))))))))));
                                $message = str_replace("%trip_id%", $request_data['reference_id'], str_replace("%reporting_manager_name%", $request_data['manager_name'], str_replace("%employee_name%", $request_data['employee_name'], str_replace("%to_city_name%", $request_data['to_city_name'], str_replace("%from_city_name%", $request_data['from_city_name'], str_replace("%travel_reason%", $request_data['reason'], str_replace("%travel_mode%", $request_data['travel_mode'], str_replace("%travel_datetime%", $request_data['travel_datetime'], str_replace("%day_plan%", $request_data['day_plan'], str_replace("%amount%", $request_data['amount'], str_replace("%url%", $request_data['url'], stripslashes($mailformat))))))))))));

                                $cc = $request_data['employee_email'];
                                $to = $request_data['manager_email'];
                                $this->sendEmail($to, $subject, $message, $cc);
                            }
                        }

                        $this->session->set_flashdata('success', $msg);
                        redirect(base_url() . dashboard);
                    } else {
                        $view_data['error'] = 'Something went wrong, please try again later.';
                    }
                }
            } else {
                $array = array(
                    "emp_list" => ''
                );
                $this->session->set_userdata($array);
            }
            $this->template->write_view('content', 'flight_travel/add_flight_travel', $view_data);
            $this->template->render();
        } else {
            $view_data['error'] = 'Admin can not request for Travel.';
            $this->session->set_flashdata('error', 'Admin can not request for Travel.');
            redirect(base_url() . flight_travel);
        }
    }

    public function save_to_draft() {
        $employee_id = $this->session->userdata('employee_id');
        $response = array('status' => '0', 'msg' => 'Something went wrong.');
        if ($employee_id != '') {
            $view_data = array();

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
                    $reporting_manager_data = $this->travel_request->get_employee_manager_id($employee_id);
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

            if ($this->input->post()) {
                $request_number = $this->input->post('request_number');
                $post_data = $this->input->post();
                $post_data['departure_date'] = date(DATEMYSQL, strtotime($post_data['departure_date']));
                $post_data['return_date'] = date(DATEMYSQL, strtotime($post_data['return_date']));

                $post_data['employee_id'] = $employee_id;
                $post_data['status'] = "draft";

                $return_date = $this->input->post('return_date');
                if ($return_date == '') {
                    $post_data['return_date'] = null;
                }
                $to_city_id = $this->input->post('to_city_id');
                if ($to_city_id == '') {
                    $post_data['to_city_id'] = null;
                }
                $travel_class_id = $this->input->post('travel_class_id');
                if ($travel_class_id == '') {
                    $post_data['travel_class_id'] = null;
                }

                $employee_name = $this->input->post('employee_name');
                if (!empty($member_list)) {
                    $post_data['group_travel'] = "1";
                } else {
                    $post_data['group_travel'] = "0";
                    if (!empty($employee_name)) {
                        foreach ($employee_name as $key => $emp_name) {
                            if ($employee_name[$key] != '' && $age[$key]) {
                                $post_data['group_travel'] = "1";
                            }
                        }
                    }
                }

                $draft_req = $this->common->select_data_by_id('travel_request', $condition_array = array('employee_id' => $employee_id, 'request_number !=' => $request_number), 'id,request_number', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array());
                if (!empty($draft_req)) {
                    if ($draft_req[0]['request_number'] != $request_number) {
                        $this->common->delete_data('travel_request', 'employee_id', $employee_id, 'status', 'draft');
                    }
                }

                $comb_id = $this->travel_request->get_travel_request_combination_draft($post_data['request_number']);
                if (empty($comb_id)) {
                    $request_number = '';
                    $data = $this->travel_request->update_travel_request_to_draft($post_data, $request_number);
                    if ($data) {
                        $response['status'] = "1";
                        $response['msg'] = "Draft Autosaved at " . date('H:i:s');
                    } else {
                        $response['status'] = "0";
                        $response['msg'] = "Something went wrong, please try again later.";
                    }
                } else {
                    if ($comb_id['status'] == "draft") {
                        $data = $this->travel_request->update_travel_request_to_draft($post_data, $request_number);
                        if ($data) {
                            $response['status'] = "1";
                            $response['msg'] = "Draft Autosaved at " . date('H:i:s');
                        } else {
                            $response['status'] = "0";
                            $response['msg'] = "Something went wrong, please try again later.";
                        }
                    }
                }
            }
        } else {
            $response['status'] = "0";
            $response['msg'] = "Something went wrong, please try again later.";
        }
        echo json_encode($response);
    }

    function check_hangout_suggestion() {
        $response = array();
        $travel_reason_id = $this->input->post('travel_reason_id');
        $reason_data = $this->common->select_data_by_id('travel_reasons', array('id' => $travel_reason_id), 'hangout_suggestion', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array());
        if (!empty($reason_data)) {
            $hangout_suggestion = $reason_data[0]['hangout_suggestion'];
            if ($hangout_suggestion == "Yes") {
                $response['status'] = "success";
            } else {
                $response['status'] = "fail";
            }
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public function status($code, $status, $view = '') {
        $flight = $this->flight_model->get_flight($code);
        if (!$flight) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if ($this->common->change_status('travel_request', $code, $status)) {
                $this->session->set_flashdata('success', 'Flight Request marked as ' . $status);
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }
        }
        if ($view == 'view') {
            redirect(base_url() . 'flight_travel/view/' . $code);
        } else {
            redirect(base_url() . 'flight_travel');
        }
    }

    //check request unique avalibility
    public function requestExiest($title = '') {
//        $departure_date = ($this->input->post('departure_date'));
//        $return_date = ($this->input->post('return_date'));
//        $employee_id = $this->session->userdata('employee_id');
//        if (trim($departure_date) != '') {
//            $sql = "SELECT * FROM travel_request WHERE departure_date <= '" . date('Y-m-d H:i:s', strtotime($departure_date)) . "' and return_date >='" . date('Y-m-d H:i:s', strtotime($departure_date)) . "' and status= 'active' and employee_id='".$employee_id."'";
//            $result = $this->db->query($sql);
//            $res = $result->result_array();
//            if (empty($res)) {
//                if (trim($return_date) != '') {
//                    $sql = "SELECT * FROM travel_request WHERE departure_date <= '" . date('Y-m-d H:i:s', strtotime($return_date)) . "' and return_date >='" . date('Y-m-d H:i:s', strtotime($return_date)) . "' and status= 'active' and employee_id='".$employee_id."'";
//                    $result = $this->db->query($sql);
//                    $res = $result->result_array();
//                    if (empty($res)) {
                        echo 'true';
                        die();
//                    } else {
//                        echo 'false';
//                        die();
//                    }
//                } else {
//                    echo 'true';
//                    die();
//                }
//            } else {
//                echo 'false';
//                die();
//            }
//        } else {
//            echo 'false';
//            die();
//        }
    }

}
