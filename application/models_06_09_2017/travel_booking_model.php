<?php

class Travel_booking_model extends CI_Model {

//    public function get_all_travel_reasons() {
//
//        $sql = "SELECT * from travel_reasons t WHERE t.status = 'active'";
//        $result = $this->db->query($sql);
//        return $result->result_array();
//    }
//
    public function get_travel_booking_by_request_id($request_id) {
        $sql = "SELECT * from travel_booking WHERE request_id = ?";
        $result = $this->db->query($sql, array($request_id));
        return $result->row_array();
    }

//
//    public function get_travel_reasons_combination($reason, $hangout_suggestion) {
//        $sql = "SELECT id from travel_reasons WHERE reason = ? and hangout_suggestion = ?";
//        $result = $this->db->query($sql, array($reason, $hangout_suggestion));
//        return $result->row_array();
//    }

    public function update_travel_booking($data, $travel_booking_id) {
        $needed_array = array('request_id', 'travel_ticket', 'accommodation', 'car_hire','bookbyself','bookbymanager');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($travel_booking_id)) {
            $this->db->where('id', $travel_booking_id);
            $result = $this->db->update('travel_booking', $data);
            if ($result) {
                return $travel_booking_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_booking', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function update_travel_request($data, $request_id) {
        $needed_array = array('request_status');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($request_id)) {
            $this->db->where('id', $request_id);
            $result = $this->db->update('travel_request', $data);
            if ($result) {
                return $request_id;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function update_travel_request_cancel($data, $request_id) {
        $needed_array = array('cancel_status');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($request_id)) {
            $this->db->where('id', $request_id);
            $result = $this->db->update('travel_request', $data);
            if ($result) {
                return $request_id;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
