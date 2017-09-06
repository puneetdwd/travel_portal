<?php

class Roles extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);


        $this->is_logged_in();
//        $this->is_user_admin();
        //render template
        $header_data = array(
            'page' => 'masters',
            'sub' => 'roles'
        );

        $this->template->write_view('header', 'templates/header', $header_data);
        $this->template->write_view('footer', 'templates/footer');
        $this->load->model("roles_model");
    }

    public function index() {
        $roles = $this->roles_model->get_all_roles();
        $view_roles = array('roles' => $roles);
        $this->template->write_view('content', 'roles/index_roles', $view_roles);
        $this->template->render();
    }

    public function add_roles($role_id = '') {
        $view_data = array();
        $con_array = array('is_visible' => '1', 'id !=' => '16');


        if (!empty($role_id)) {
            $roles = $this->roles_model->get_roles($role_id);
            $roles_menu = $this->roles_model->get_roles_menu($role_id);
            $menu_arr = array();
            foreach ($roles_menu as $key => $menu) {
                $menu_arr[] = $menu['menu_id'];
            }
            $view_data['roles'] = $roles;
            $view_data['main_menu'] = $this->common->select_data_by_condition('menu', $con_array, '*', 'sort_order', 'ASC', '', '', array());
            $view_data['menu'] = $this->common->display_menu1($view_data['main_menu'], $menu_arr);
        } else {
            $view_data['main_menu'] = $this->common->select_data_by_condition('menu', $con_array, '*', 'sort_order', 'ASC', '', '', array());
            $view_data['menu'] = $this->common->display_menu1($view_data['main_menu'], '', '');
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();
            $inserted_id = $this->roles_model->update_roles($post_data, $role_id);
            $menu_data = $this->input->post('menu');
            if ($inserted_id) {
                $output = $this->roles_model->delete_roles_menu($inserted_id);
                foreach ($menu_data as $key => $menu) {
                    $menu_post = array(
                        'roles_id' => $inserted_id,
                        'menu_id' => $menu,
                    );
                    $this->roles_model->insert_roles_menu($menu_post);
                }
                $msg = (!empty($role_id)) ? ' Role successfully Updated' : 'Role successfully Added';
                $this->session->set_flashdata('success', $msg);
                redirect(base_url() . roles);
            } else {
                $view_data['error'] = 'Something went wrong, please try again later.';
            }
        }
        $this->template->write_view('content', 'roles/add_roles', $view_data);
        $this->template->render();
    }

    public function status($code, $status, $view = '') {
        if ($code != '1') {
            $roles = $this->roles_model->get_roles($code);
            if (!$roles) {
                $this->session->set_flashdata('error', 'Invalid record');
            } else {

                if ($this->roles_model->change_status($code, $status)) {
                    $this->session->set_flashdata('success', 'Role marked as ' . $status);
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
                }
            }
        } else {
            $this->session->set_flashdata('info', 'You can not inactive base Role');
        }
        if ($view == 'view') {
            redirect(base_url() . 'roles/view/' . $code);
        } else {
            redirect(base_url() . 'roles');
        }
    }

}
