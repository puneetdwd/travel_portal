<?php

/**
 * My Controller Class 
 * 
 * @package IACT
 * @filename My_Controller.php
 * @category My_Controller
 * */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {

    function __construct($auth = false, $access = '') {
        parent::__construct();

        $module = $this->uri->segment(1);
        $action = $this->uri->segment(2);
        if ($action == '') {
            $action = 'index';
        }
        $active_menu = array();
        $menu_list = $menu_list_final = $this->common->select_data_by_condition('menu', $con_array = array('module' => $module, 'action' => $action), 'id,menu_id', '', '', '', '', $join_st = array());
        if (!empty($menu_list)) {
            $menu_id = $menu_list[0]['id'];
            $active_menu[] = $menu_list[0]['id'];
            if ($menu_list[0]['menu_id'] != '') {
                $menu_list = $this->common->select_data_by_condition('menu', $con_array = array('id' => $menu_list[0]['menu_id']), 'id,menu_id', '', '', '', '', $join_st = array());
                $active_menu[] = $menu_list[0]['id'];
                if ($menu_list[0]['menu_id'] != '') {
                    $menu_list = $this->common->select_data_by_condition('menu', $con_array = array('id' => $menu_list[0]['menu_id']), 'id,menu_id', '', '', '', '', $join_st = array());
                    $active_menu[] = $menu_list[0]['id'];
                    if ($menu_list[0]['menu_id'] != '') {
                        $menu_list = $this->common->select_data_by_condition('menu', $con_array = array('id' => $menu_list[0]['menu_id']), 'id,menu_id', '', '', '', '', $join_st = array());
                        $active_menu[] = $menu_list[0]['id'];
                    }
                }
            }
        }

        $emp_id = $this->session->userdata('employee_id');
        $assign_arr = array();
        $roles_list = $this->common->select_data_by_condition('roles_menu', $con_array = array('roles_id' => 1), 'menu_id', '', '', '', '', $join_st = array());
        foreach ($roles_list as $key => $value) {
            $_SESSION['list_menu'] = array();
            $id = $value['menu_id'];
            $this->get_main_menu_id($id);
            foreach ($_SESSION['list_menu'] as $key => $value) {
                if (!empty($value)) {
                    $assign_arr[$value] = $value;
                }
            }
        }


        $roles_list = $this->common->select_data_by_condition('employees_role', $con_array = array('employees_id' => $emp_id), 'roles_id', '', '', '', '', $join_st);
        foreach ($roles_list as $key => $value) {
            $roles_menu_list = $this->common->select_data_by_condition('roles_menu', $con_array = array('roles_id' => $value['roles_id']), 'menu_id', '', '', '', '', $join_st = array());
            foreach ($roles_menu_list as $key => $value) {
                $_SESSION['list_menu'] = array();
                $id = $value['menu_id'];
                $this->get_main_menu_id($id);
                foreach ($_SESSION['list_menu'] as $key => $value) {
                    if (!empty($value)) {
                        $assign_arr[$value] = $value;
                    }
                }
            }
        }
//        $assign_arr['1'] = '1';
//        echo $menu_id;
//        po($menu_list_final);
        if (!empty($menu_list_final)) {
            if ($this->session->userdata('type')) {
                if ($this->session->userdata('type') != 'admin') {
                    if (!in_array($menu_id, $assign_arr)) {
                        redirect(base_url() . 'dashboard');
                    }
                }
            }
        }

        $con_array = array('is_active' => '1');
        $this->data['main_menu'] = $this->common->select_data_by_condition('menu', $con_array, '*', 'sort_order', 'ASC', '', '', array());
        $this->menu = $this->common->display_menu($this->data['main_menu'], $assign_arr, $active_menu);
    }

    function get_main_menu_id($id) {
        $_SESSION['list_menu'][] = $id;
        $menu_list = $this->common->select_data_by_condition('menu', $con_array = array('id' => $id), 'menu_id', '', '', '', '', $join_st = array());
        if (!empty($menu_list)) {
            $menu_id = $menu_list[0]['menu_id'];
            $this->get_main_menu_id($menu_id);
        }
    }

    function is_logged_in() {
        if (!$this->session->userdata('username')) {
            redirect(base_url() . 'users/login');
        }
    }

    public function is_user_employee() {
        if ($this->session->userdata('type') != 'employee') {
            $this->session->set_flashdata('error', 'Access Denied.');
            redirect(base_url() . 'dashboard');
        }
    }

    public function is_user_admin() {
        if ($this->session->userdata('type') != 'admin') {
            $this->session->set_flashdata('error', 'Access Denied.');
            redirect(base_url() . 'dashboard');
        }
    }

//    public function is_user_admin() {
//        if ($this->session->userdata('type') != 'admin') {
//            $this->session->set_flashdata('error', 'Access Denied.');
//            redirect(base_url() . 'dashboard');
//        }
//    }

    function upload_file($file_field, $file_name, $upload_path) {

        $config['upload_path'] = $upload_path;
        $config['file_name'] = $file_name . '-' . random_string('alnum', 6);
        $config['allowed_types'] = 'jpg|jpeg|xls|xlsx|pdf|png|JPG|JPEG|PNG|XLS|XLSX|PDF|PNG';
        $config['overwrite'] = True;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file_field)) {

            if (!$this->upload->is_allowed_filetype()) {
                $error = "The file type you are attempting to upload is not allowed.";
            } else {
                $error = $this->upload->display_errors();
            }

            $result = array(
                'status' => 'error',
                'error' => $error
            );
        } else {
            $upload_data = $this->upload->data();
            $result = array(
                'status' => 'success',
                'file' => $upload_path . $upload_data['file_name'],
                'file_name' => $config['file_name']
            );
        }

        return $result;
    }

    function upload_photo($field, $upload_path, $filename) {
        $response = array('status' => 'error', 'error' => 'Invalid parameters');

        if (!empty($_FILES[$field]['name']) && !empty($upload_path)) {
            //upload wallpaper.

            if (!is_dir($upload_path)) {
                mkdir($upload_path);
            }

            $config['upload_path'] = $upload_path . '/';
            if (!empty($filename)) {
                $config['file_name'] = $filename;
            }
            $config['allowed_types'] = 'png|jpg|JPG|jpeg|';
            $config['overwrite'] = True;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($field)) {
                $response['status'] = 'error';

                if (!$this->upload->is_allowed_filetype()) {
                    $response['error'] = "The file type you are attempting to upload is not allowed.";
                } else {
                    $response['error'] = $this->upload->display_errors();
                }
            } else {
                $upload_data = $this->upload->data();

                $config = array();
                $config['source_image'] = $upload_path . '/' . $upload_data['file_name'];
                $config['new_image'] = $upload_path;
                $config['width'] = ($upload_data['image_width'] > 750) ? 750 : $upload_data['image_width'];
                $config['height'] = 0;

                if ($upload_data['image_width'] <= $upload_data['image_height']) {
                    $config['width'] = 0;
                    $config['height'] = ($upload_data['image_height'] > 600) ? 600 : $upload_data['image_height'];
                }

                $this->load->library('image_lib', $config);

                if (!$this->image_lib->fit()) {
                    $response['status'] = 'error';
                    $response['error'] = $this->image_lib->display_errors();
                } else {
                    $response['status'] = 'success';
                    $response['data'] = $upload_data;
                }
            }
        }

        return $response;
    }

    function sendMail($to, $subject, $message, $bcc = '', $attachment = '', $cc = '') {

        $is_multi_attach = 0;
        $from_email = 'mytravel@dbcorp.in';

        $this->load->model('employee_model');
        $response = $this->employee_model->save_mail_to_DB($to, $subject, $message, $is_multi_attach, $from_email, $cc, $bcc, $attachment);

        return $response;
    }

    function sendMail_with_multiple_attachment($to, $subject, $message, $bcc = '', $attachment) {

        $is_multi_attach = 1;
        $from_email = 'mytravel@dbcorp.in';

        if (!empty($attachment)) {
            $attachments = $attachment[0];
            for ($i = 1; $i < sizeof($attachment); $i++) {
                $attachments .= "," . $attachment[$i];
            }
        }

        $this->load->model('employee_model');
        $response = $this->employee_model->save_mail_to_DB($to, $subject, $message, $is_multi_attach, $from_email, $cc = '', $bcc = '', $attachments);

        return $response;
    }

    function convert_money($money) {
        $digits = array();
        $m = $money;
        if ($m == 0) {
            return 0.00;
        }
        while ($m > 0) {
            $digits[] = $m % 10;
            $m = (int) ($m / 10);
        }

        $money_str = '';

        $comma_after = array(3, 5, 7, 9);
        foreach ($digits as $key => $digit) {
            if (in_array($key, $comma_after)) {
                $money_str = ',' . $money_str;
            }

            $money_str = $digit . $money_str;
        }

        return $money_str;
    }

    function create_excel($headers, $expenses, $others_headers, $others, $name, $title) {
        $this->load->library('excel');
        $this->config->load('excel');
        $row = 1;
        $last_letter = PHPExcel_Cell::stringFromColumnIndex(count($headers) - 1);
        //activate worksheet number 1

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($this->config->item('defaultStyle'));
        $this->excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
        $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);

        $this->excel->getActiveSheet()->mergeCells('A1:' . $last_letter . '1');
        $this->excel->getActiveSheet()->setCellValue('A1', $title);
        $this->excel->getActiveSheet()->getStyle('A1:' . $last_letter . '1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A1:' . $last_letter . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->mergeCells('A2:' . $last_letter . '2');
        $this->excel->getActiveSheet()->setCellValue('A2', '**Generated on ' . date('d.m.Y H:i:s'));
        $this->excel->getActiveSheet()->getStyle('A2:' . $last_letter . '2')->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle('A2:' . $last_letter . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $row = 4;

        $this->excel->getActiveSheet()->fromArray($headers, NULL, 'A' . $row);
        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $last_letter . $row)
                ->applyFromArray($this->config->item('headerStyle'));
        $row++;

        foreach ($expenses as $expense) {
            $row_data = array_values($expense);

            $this->excel->getActiveSheet()->fromArray($row_data, NULL, 'A' . $row, true);
            $row++;
        }


        $row++;
        $last_letter1 = PHPExcel_Cell::stringFromColumnIndex(count($others_headers) - 1);
        $this->excel->getActiveSheet()->mergeCells('A' . $row . ':' . $last_letter1 . $row);
        $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Other Expenses');
        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $last_letter1 . $row)->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $last_letter1 . $row)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $row++;
        $this->excel->getActiveSheet()->fromArray($others_headers, NULL, 'A' . $row);
        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $last_letter1 . $row)
                ->applyFromArray($this->config->item('headerStyle'));
        $row++;

        foreach ($others as $other) {
            $row_data = array_values($other);
            $this->excel->getActiveSheet()->fromArray($row_data, NULL, 'A' . $row, true);
            $row++;
        }

        $filename = $name;

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_end_clean();
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function create_excel_downloads($headers, $expenses, $name, $title, $revenue = false) {
        $this->load->library('excel');
        $this->config->load('excel');
        $row = 1;
        $last_letter = PHPExcel_Cell::stringFromColumnIndex(count($headers) - 1);
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($this->config->item('defaultStyle'));
        $this->excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
        $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);

        $this->excel->getActiveSheet()->mergeCells('A1:' . $last_letter . '1');
        $this->excel->getActiveSheet()->setCellValue('A1', $title);
        $this->excel->getActiveSheet()->getStyle('A1:' . $last_letter . '1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A1:' . $last_letter . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->mergeCells('A2:' . $last_letter . '2');
        $this->excel->getActiveSheet()->setCellValue('A2', '**Generated on ' . date('d.m.Y H:i:s'));
        $this->excel->getActiveSheet()->getStyle('A2:' . $last_letter . '2')->getFont()->setSize(8);
        $this->excel->getActiveSheet()->getStyle('A2:' . $last_letter . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $row = 4;

        $this->excel->getActiveSheet()->fromArray($headers, NULL, 'A' . $row);
        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $last_letter . $row)
                ->applyFromArray($this->config->item('headerStyle'));
        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $last_letter . $row)
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $row++;

        foreach ($expenses as $expense) {
            $row_data = array_values($expense);

            $this->excel->getActiveSheet()->fromArray($row_data, NULL, 'A' . $row, true);
            $row++;
        }


        $row++;

        $filename = $name;

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();
        $objWriter->save('php://output');
    }

    function sendEmail($to_email, $subject, $mail_body, $cc_email = '') {
       if ($_SERVER['HTTP_HOST'] != "localhost") {
            $this->config->load('email', TRUE);
            $this->cnfemail = $this->config->item('email');

            //Loading E-mail Class
            $this->load->library('email');
            $this->email->initialize($this->cnfemail);

            $this->email->from("mytravel@dbcorp.in", "My Travel");
//        $this->email->to("mytravel@dbcorp.in", "My Travel");

            $this->email->to($to_email);
            if ($cc_email != '') {
                $this->email->cc($cc_email);
            }

            $this->email->subject($subject);
            $this->email->message("<table border='0' cellpadding='0' cellspacing='0'><tr><td></td></tr><tr><td>" . $mail_body . "</td></tr></table>");
            $this->email->send();
//            echo $this->email->print_debugger();die();
            return;
       } else {
           return;
       }
    }

}
