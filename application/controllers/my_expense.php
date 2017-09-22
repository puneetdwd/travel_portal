<?php

class My_expense extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        $this->is_logged_in();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'employee_request'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("my_expense_model", 'my_expense');
        $this->load->model("travel_request_model", 'travel_request');

        $this->load->library('form_validation');
    }

    public function others() {
        $employee_id = $this->session->userdata('employee_id');
        $view_request['request'] = $this->my_expense->get_all_request($employee_id);
        $view_request['other_expencesData'] = $this->my_expense->get_all_other_expences_data('mast_other_expense');
        $this->template->write_view('content', 'my_expense/others', $view_request);
        $this->template->render();
    }

    public function save_others() {
        
        $employee_id = $this->session->userdata('employee_id');
        $allowances_item_array = array();
        if ($this->input->post('request_id')) {
            $this->form_validation->set_rules('expanse_date', 'expanse_date', 'required');
            $this->form_validation->set_rules('arrange_by', 'arrange_by', 'required');
            $this->form_validation->set_rules('location', 'location', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('amount', 'amount', 'required');
            $this->form_validation->set_rules('bill_no', 'bill_no', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('my_expense/conveyance', 'refresh');
            } else {
                $ref_id = $this->input->post('other_reference_id'); 
                $request_id = $this->input->post('request_id'); 
                
                $file_upload_name = "other_attachment";
                if (isset($_FILES[$file_upload_name]['name']) && $_FILES[$file_upload_name]['name'] != null) {
                    $other_attachment = $_FILES[$file_upload_name]['name'];
                    foreach ($other_attachment as $key => $value) {
                        if (!empty($value)) {
                            $_FILES['other_attach']['name'] = $value;
                            $_FILES['other_attach']['type'] = $_FILES[$file_upload_name]['type'][$key];
                            $_FILES['other_attach']['tmp_name'] = $_FILES[$file_upload_name]['tmp_name'][$key];
                            $_FILES['other_attach']['error'] = $_FILES[$file_upload_name]['error'][$key];
                            $_FILES['other_attach']['size'] = $_FILES[$file_upload_name]['size'][$key];

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
                                    'reference_id' => $ref_id,
                                    'file_name' => $upload_data['file_name'],
                                );
                                if (!$this->common->insert_data($data_array, 'claim_expense_attachment')) {
                                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                                    redirect(base_url() . employee_request);
                                }
                            } else {
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error', $error['error']);
                                redirect('employee_request/index', 'refresh');
                            }
                        }
                    }
                }
                
                $allowances_item_array['employees_id'] = $employee_id;
                $allowances_item_array['reference_id'] = $ref_id;
                $allowances_item_array['request_id'] = $this->input->post('request_id');
                $allowances_item_array['date'] = date(DATEMYSQL, strtotime($this->input->post('expanse_date')));
                $allowances_item_array['expense_name'] = $this->input->post('name');
                $allowances_item_array['expense_type'] = $this->input->post('location');
                $allowances_item_array['arrange_by'] = $this->input->post('arrange_by');
                $allowances_item_array['amount'] = $this->input->post('amount');
                $allowances_item_array['bill_no'] = $this->input->post('bill_no');
				$allowances_item_array['remarks'] = $this->input->post('remarks');

                if ($this->common->insert_data($allowances_item_array, 'other_expense')) {
                    $this->session->set_flashdata('success', 'Expense added successfully');
                    redirect('my_expense/others', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect('my_expense/others', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('my_expense/others', 'refresh');
        }
    }

    public function conveyance() {
        $employee_id = $this->session->userdata('employee_id');
        $allowances_item_array = array();
        $view_request['request'] = $this->my_expense->get_all_request($employee_id);
        $view_request['other_expencesData'] = $this->my_expense->get_all_other_expences_data('mast_other_expense');
        $this->template->write_view('content', 'my_expense/conveyance', $view_request);
        $this->template->render();
    }

    public function save_conveyance() {
        $employee_id = $this->session->userdata('employee_id');
        $allowances_item_array = array();
        if ($this->input->post('request_id')) {
            $this->form_validation->set_rules('expanse_date', 'expanse_date', 'required');
            $this->form_validation->set_rules('book_by', 'book_by', 'required');
            $this->form_validation->set_rules('from_location', 'from_location', 'required');
            $this->form_validation->set_rules('to_location', 'to_location', 'required');
            $this->form_validation->set_rules('arrange_by', 'arrange_by', 'required');
            $this->form_validation->set_rules('amount', 'amount', 'required');
            $this->form_validation->set_rules('con_reference_id', 'con_reference_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('my_expense/conveyance', 'refresh');
            } else {
                $request_id = $this->input->post('request_id');
                $ref_id = $this->input->post('con_reference_id');
                $file_upload_name = "con_attachment";
                if (isset($_FILES[$file_upload_name]['name']) && $_FILES[$file_upload_name]['name'] != null) {
                    $other_attachment = $_FILES[$file_upload_name]['name'];
                    foreach ($other_attachment as $key => $value) {
                        if (!empty($value)) {
                            $_FILES['con_attach']['name'] = $value;
                            $_FILES['con_attach']['type'] = $_FILES[$file_upload_name]['type'][$key];
                            $_FILES['con_attach']['tmp_name'] = $_FILES[$file_upload_name]['tmp_name'][$key];
                            $_FILES['con_attach']['error'] = $_FILES[$file_upload_name]['error'][$key];
                            $_FILES['con_attach']['size'] = $_FILES[$file_upload_name]['size'][$key];

                            $file_name = $_FILES['con_attach']['name'];
                            $enc_filename = $this->GenerateRandomFilename($file_name);
                            $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                            $config['allowed_types'] = '*';
                            $config['file_name'] = $enc_filename;
                            $config['max_size'] = 2048;
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('con_attach')) {
                                $upload_data = $this->upload->data();
                                $data_array = array(
                                    'request_id' => $request_id,
                                    'reference_id' => $ref_id,
                                    'file_name' => $upload_data['file_name'],
                                );
                                if (!$this->common->insert_data($data_array, 'claim_expense_attachment')) {
                                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                                    redirect(base_url() . employee_request);
                                }
                            } else {
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error', $error['error']);
                                redirect('employee_request/index', 'refresh');
                            }
                        }
                    }
                }


                $allowances_item_array['request_id'] = $this->input->post('request_id');
                $allowances_item_array['con_date'] = date(DATEMYSQL, strtotime($this->input->post('expanse_date')));
                $allowances_item_array['con_from'] = $this->input->post('from_location');
                $allowances_item_array['reference_id'] = $this->input->post('con_reference_id');
                $allowances_item_array['con_to'] = $this->input->post('to_location');
                $allowances_item_array['con_book_by'] = $this->input->post('book_by');
                $allowances_item_array['con_arrange_by'] = $this->input->post('arrange_by');
                $allowances_item_array['total'] = $this->input->post('amount');

                if ($this->common->insert_data($allowances_item_array, 'other_con_booking')) {
                    $this->session->set_flashdata('success', 'Expense added successfully');
                    redirect('my_expense/conveyance', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect('my_expense/conveyance', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('my_expense/conveyance', 'refresh');
        }
    }

    function hotel() {
        /* Ali */
        $view_request = array();
        $employee_id = $this->session->userdata('employee_id');
        $request = $this->my_expense->get_all_request($employee_id);
        $view_request['request'] = $request;

        $sql = "SELECT * FROM travel_category t WHERE type = '1' and travel_type = '5' and status='active'";
        $result = $this->db->query($sql);
        $hotel_category = $result->result_array();
        $view_request['hotel'] = $hotel_category;
//echo '<pre>'; print_r($view_request); exit;
        $this->template->write_view('content', 'my_expense/hotel', $view_request);
        $this->template->render();
    }

    public function save_hotel() {

        if ($this->input->post('request_id')) {
            $this->form_validation->set_rules('reference_id', 'reference_id', 'required');
            $this->form_validation->set_rules('hotel_name', 'hotel_name', 'required');
            $this->form_validation->set_rules('check_in_date', 'check_in_date', 'required');
            $this->form_validation->set_rules('location', 'location', 'required');
            $this->form_validation->set_rules('room_no', 'room_no', 'required');
            $this->form_validation->set_rules('arrange_by', 'arrange_by', 'required');
            $this->form_validation->set_rules('loading_expense', 'loading_expense', 'required');
            $this->form_validation->set_rules('other_expense', 'other_expense', 'required');
            $this->form_validation->set_rules('loading_total', 'loading_total', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('my_expense/hotel', 'refresh');
            } else {
                $request_id = $this->input->post('request_id');
                $ref_id = $this->input->post('reference_id');
                $file_upload_name = "hotel_attachment";

                if (isset($_FILES[$file_upload_name]['name']) && $_FILES[$file_upload_name]['name'] != null) {
                    $other_attachment = $_FILES[$file_upload_name]['name'];

                    foreach ($other_attachment as $key => $value) {
                        if (!empty($value)) {
                            $_FILES['load_attach']['name'] = $value;
                            $_FILES['load_attach']['type'] = $_FILES[$file_upload_name]['type'][$key];
                            $_FILES['load_attach']['tmp_name'] = $_FILES[$file_upload_name]['tmp_name'][$key];
                            $_FILES['load_attach']['error'] = $_FILES[$file_upload_name]['error'][$key];
                            $_FILES['load_attach']['size'] = $_FILES[$file_upload_name]['size'][$key];

                            $file_name = $_FILES['load_attach']['name'];
                            $enc_filename = $this->GenerateRandomFilename($file_name);
                            $config['upload_path'] = $this->config->item('upload_booking_attch_path');
                            $config['allowed_types'] = '*';
                            $config['file_name'] = $enc_filename;
                            $config['max_size'] = 2048;

                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('load_attach')) {
                                $upload_data = $this->upload->data();
                                $data_array = array(
                                    'request_id' => $request_id,
                                    'reference_id' => $ref_id,
                                    'file_name' => $upload_data['file_name'],
                                );
                                if (!$this->common->insert_data($data_array, 'claim_expense_attachment')) {
                                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                                    redirect('my_expense/hotel', 'refresh');
                                }
                            } else {
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error', $error['error']);
                                redirect('my_expense/hotel', 'refresh');
                            }
                        }
                    }
                }

                $allowances_item_array['request_id'] = $this->input->post('request_id');
                $allowances_item_array['reference_id'] = $this->input->post('reference_id');
                $allowances_item_array['loading_departure'] = date(DATEMYSQL, strtotime($this->input->post('check_in_date')));
                $allowances_item_array['loading_return'] = date(DATEMYSQL, strtotime($this->input->post('check_out_date')));
                $allowances_item_array['location'] = $this->input->post('location');
                $allowances_item_array['hotal_name'] = $this->input->post('hotel_name');
                $allowances_item_array['room_no'] = $this->input->post('room_no');
                $allowances_item_array['bill_no'] = $this->input->post('bill_no');
                $allowances_item_array['arrange_by'] = $this->input->post('arrange_by');
                $allowances_item_array['loading_expense'] = $this->input->post('loading_expense');
                $allowances_item_array['other_expense'] = $this->input->post('other_expense');
                $allowances_item_array['loading_total'] = $this->input->post('loading_total');

                if ($this->common->insert_data($allowances_item_array, 'other_loading_booking')) {
                    $this->session->set_flashdata('success', 'Hotel Expense added successfully');
                    redirect('my_expense/hotel', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                    redirect('my_expense/hotel', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('my_expense/hotel', 'refresh');
        }
    }

    public function hotel1() {
        $employee_id = $this->session->userdata('employee_id');
        $allowances_item_array = array();
        if ($this->input->post()) {

            $allowances_item_array['request_id'] = $this->input->post('request_id');
            $allowances_item_array['loading_departure'] = date(DATEMYSQL, strtotime($this->input->post('check_in_date')));
            $allowances_item_array['loading_return'] = $this->input->post('check_out_date');
            $allowances_item_array['location'] = $this->input->post('location');
            $allowances_item_array['hotal_name'] = $this->input->post('hotal_name');
            $allowances_item_array['room_no'] = $this->input->post('room_no');
            $allowances_item_array['loading_total'] = $this->input->post('amount');
            $allowances_item_array['bill_no'] = $this->input->post('bill_no');
            $allowances_item_array['arrange_by'] = $this->input->post('arrange_by');

            if ($this->common->insert_data($allowances_item_array, 'other_expense')) {
                $this->session->set_flashdata('success', 'Expense added successfully');
                redirect(base_url() . my_expense / hotel);
            } else {
                $this->session->set_flashdata('error', 'Error occurred. Try Again!');
                redirect(base_url() . my_expense / hotel);
            }
        }

        $request = $this->my_expense->get_all_request($employee_id);
//        print_r($request);
//        die;
        $view_request['request'] = $request;
        $to_city_id = $request['to_city_id'];
        $this->load->model('employee_model');
        $hotel_category = $this->travel_desk->get_hotel_category_by_location($to_city_id, '1');
        $view_request['hotel_category'] = $hotel_category;
        $view_request['to_city_id'] = $to_city_id;

        $service_proviers = $this->travel_desk->get_service_proviers($request['travel_type']);
        $view_request['service_proviers'] = $service_proviers;


        $view_request['other_expencesData'] = $this->my_expense->get_all_other_expences_data('mast_other_expense');



        $this->template->write_view('content', 'my_expense/hotel', $view_request);
        $this->template->render();
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

}
