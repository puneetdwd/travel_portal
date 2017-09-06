<?php

class Email_template extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


//        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'department'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("email_template_model", 'email_template');
    }

    public function index() {
        $email_template = $this->email_template->get_all_email_template();
        $view_data = array('email_template' => $email_template);

        $this->template->write_view('content', 'email_template/index_email', $view_data);
        $this->template->render();
    }

    public function add_email($mail_id = '') {
        $view_data = array();
        if (!empty($mail_id)) {
            $data = $this->email_template->get_email_template($mail_id);
            $view_data['email_template'] = $data;
            $this->template->write_view('content', 'email_template/edit_email', $view_data);
            $this->template->render();
        } else {
            $this->template->write_view('content', 'email_template/add_email', $view_data);
            $this->template->render();
        }
    }

    public function create() {
        if ($this->input->post()) {

            $title = ($this->input->post('title'));
            $subject = ($this->input->post('subject'));
            $mailformat = $this->input->post('mailformat');
            $variables = $this->input->post('variables');
            if ($mailformat != '') {
                $data_array = array(
                    'title' => $title,
                    'variables' => $variables,
                    'subject' => $subject,
                    'emailformat' => $mailformat,
                );

                //Updating seo Record
                if ($this->common->insert_data($data_array, 'email_format')) {
                    $this->session->set_flashdata('success', 'EMail format added successfully');
                    redirect('email_template', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('email_template', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('email_template', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect('email_template', 'refresh');
        }
    }

    public function update() {
        if ($this->input->post('id')) {
            $emailformatid = $this->input->post('id');

            $title = ($this->input->post('title'));
            $subject = ($this->input->post('subject'));
            $mailformat = $this->input->post('mailformat');
            $variables = $this->input->post('variables');
            if ($mailformat != '') {
                $data_array = array(
                    'title' => $title,
                    'variables' => $variables,
                    'subject' => $subject,
                    'emailformat' => $mailformat,
                );

                //Updating seo Record
                if ($this->common->update_data($data_array, 'email_format', 'mail_id', $emailformatid)) {
                    $this->session->set_flashdata('success', 'EMail format updated successfully');
                    redirect('email_template', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                    redirect('email_template', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                redirect('email_template', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
            redirect($this->last_url(), 'refresh');
        }
    }

}
