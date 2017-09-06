<?php

class my_dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->database();
    }

    function get_configuration() {
        $sql = "SELECT *, target/12 as monthly_target FROM mydashboard_config";
        return $this->db->query($sql)->row_array();
    }    
    
    function update_config($data, $config_id){
        $needed_array = array('currency', 'conversion', 'target', 'headcount_tar', 
                        'region_filter', 'service_type_filter','customer_name','service_by','sales_by');
        $data = array_intersect_key($data, array_flip($needed_array));
        
        
        if(!empty($config_id)) {
            $this->db->where('id', $config_id);
            
            $result = $this->db->update('mydashboard_config', $data);
            if($result) {
                return $config_id;
            } else {
                return FALSE;
            }
        } else {
            
            $result = $this->db->insert('mydashboard_config', $data);
            if($result) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        }
    }
} 