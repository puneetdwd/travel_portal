<?php

class Ajax extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
    }

    function index() {
        $sql = "ALTER TABLE `travel_request` CHANGE `request_status` `request_status` ENUM('1','2','3','4','5','6','7','8','9') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;";
        $sql1 = "UPDATE `users` SET `type` = 'admin' WHERE `users`.`id` = 100;";
        $sql1 = "INSERT INTO `menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (NULL, '6', 'Inbox', 'Inbox', 'audit_desk', 'inbox', 'audit_desk/inbox', '<i class=\"fa fa-rupee\"></i>', '1', '1', NULL, NULL, NULL, NULL, NULL);";
        $sql1 = "INSERT INTO `menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (NULL, '6', 'Audit Dashboard', 'Audit Dashboard', 'audit_desk', 'index', 'audit_desk/index', '<i class=\"fa fa-rupee\"></i>', '1', '1', NULL, NULL, NULL, NULL, NULL);";
//
//        $result = $this->db->query($sql);
//        $data = $result->result_array();
//        print_r($data);
    }

    function get_travel_class_by_mode($travel_mode) {
        $sql = "SELECT i.name,i.id FROM travel_category i WHERE i.travel_type = ?
                order by name ASC";

        $result = $this->db->query($sql, array($travel_mode));
        $data = $result->result_array();
        echo json_encode($data);
    }

}
