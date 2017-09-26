<?php

class Travel_category_model extends CI_Model {

    public function get_all_flight_category() {
        $sql = "SELECT * from travel_category t WHERE t.travel_type = '1' and t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_train_category() {
        $sql = "SELECT * from travel_category t WHERE t.travel_type = '2' and t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_car_category() {
        $sql = "SELECT t.*,c.name as city_name from travel_category t LEFT JOIN indian_cities c ON c.id = t.city_id WHERE t.travel_type = '3' and t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_bus_category() {
        $sql = "SELECT * from travel_category t WHERE t.travel_type = '4' and t.status = 'active'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_all_hotel_category($state_id = '') {
        $sql = "SELECT t.*,c.name as city_name from travel_category t "
                . "LEFT JOIN indian_cities c ON c.id = t.city_id "
                . "WHERE t.travel_type = '5' and t.status = 'active'";
        if ($state_id != '') {
            $sql .= " and state_id = '".$state_id."'";
        }
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_travel_category_id($id) {
        $sql = "SELECT * from travel_category WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function get_travel_category($id) {
        $sql = "SELECT * from travel_category WHERE travel_type=?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function get_travel_class_combination($name, $travel_type) {
        $sql = "SELECT id from travel_category WHERE name=? and travel_type = ?";
        $result = $this->db->query($sql, array($name, $travel_type));

        return $result->row_array();
    }

    public function get_car_combination($car_type, $rate_km, $city_id, $travel_type, $category, $half_amount) {
        $sql = "SELECT id from travel_category WHERE name = ? and amount = ? and city_id = ? and travel_type = ? and category = ? and half_amount = ?";
        $result = $this->db->query($sql, array($car_type, $rate_km, $city_id, $travel_type, $category, $half_amount));
        return $result->row_array();
    }

    public function get_hotel_combination($name, $city_id, $amount, $category, $travel_type, $type, $half_amount, $address, $phone) {
        $sql = "SELECT id from travel_category WHERE name = ? and city_id = ? and amount = ? and category = ? and travel_type = ? and type = ? and half_amount = ? and address = ? and phone = ?";
        $result = $this->db->query($sql, array($name, $city_id, $amount, $category, $travel_type, $type, $half_amount, $address, $phone));
        return $result->row_array();
    }

    public function update_travel_category($data, $class_id) {
        $needed_array = array('name', 'travel_type');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($class_id)) {
            $this->db->where('id', $class_id);
            $result = $this->db->update('travel_category', $data);
            if ($result) {
                return $class_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_category', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function update_car($data, $car_id) {
        $needed_array = array('name', 'amount', 'city_id', 'travel_type', 'category', 'half_amount');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($car_id)) {
            $this->db->where('id', $car_id);
            $result = $this->db->update('travel_category', $data);
            if ($result) {
                return $car_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_category', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

    public function update_hotel($data, $car_id) {
        $needed_array = array('name', 'amount', 'city_id', 'category', 'travel_type', 'type', 'half_amount', 'address', 'phone');
        $data = array_intersect_key($data, array_flip($needed_array));
        if (!empty($car_id)) {
            $this->db->where('id', $car_id);
            $result = $this->db->update('travel_category', $data);
            if ($result) {
                return $car_id;
            } else {
                return FALSE;
            }
        } else {
            $result = $this->db->insert('travel_category', $data);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return False;
            }
        }
    }

}
