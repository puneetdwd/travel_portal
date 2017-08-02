<?php

class Common extends CI_Model {

    //insert data into database and returns true and false.
    //used mostly when primary key field is not an auto increment.
    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    //insert data into database and returns last insert id or 0
    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    //update database and returns true and false based on single column
    function update_data($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function update_data_by_conditions($data, $tablename, $conditions) {
        if ($this->db->update($tablename, $data, $conditions)) {
            return true;
        } else {
            return false;
        }
    }

    function checkName($table, $name_colume, $value_colume, $table_id = '', $id = '', $name_colume1 = '', $value_colume1 = '') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($name_colume, $value_colume);
        if ($name_colume1 != '') {
            $this->db->where($name_colume1, $value_colume1);
        }
        if ($id != '') {
            $notequal = $table_id . ' !=';
            $this->db->where($notequal, (int) $id);
        }
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    // select data using column id
    function select_data_by_id($tablename, $columnname, $columnid, $data = '*', $join_str = array()) {
        $this->db->select($data);
        $this->db->from($tablename);
        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                //check for join type
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        $this->db->where($columnname, $columnid);
        $query = $this->db->get();
        return $query->result_array();
    }

    // select data using multiple conditions
    function select_data_by_condition($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array()) {

        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        //order by query
        //  $this->db->distinct();
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    // select data using multiple conditions and search keyword
    function select_data_by_search($tablename, $search_condition, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array()) {

        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if ($search_condition != '') {
            $this->db->where($search_condition);
        }
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        //order by query
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();
        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    //table records count
    function get_count_of_table($table) {
        $query = $this->db->get($table)->num_rows();
        return $query;
    }

    // delete data
    function delete_data($tablename, $columnname, $columnid, $columnname1 = '', $columnid1 = '', $columnname2 = '', $columnid2 = '') {
        $this->db->where($columnname, $columnid);
        if ($columnname1 != '' && $columnid1 != '') {
            $this->db->where($columnname1, $columnid1);
        }
        if ($columnname2 != '' && $columnid2 != '') {
            $this->db->where($columnname2, $columnid2);
        }
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }

    // check unique avaliblity
    function check_unique_avalibility($tablename, $columname1, $columnid1_value, $columname2, $columnid2_value, $condition_array) {

        // if edit than $columnid2_value use
        if ($columnid2_value != '') {
            $this->db->where($columname2 . " != ", $columnid2_value);
        }

        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        $this->db->where($columname1, $columnid1_value);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    public function selectDataById($table, $id, $filed) {
        $this->db->where($filed, $id);
        // $this->db->where('status', 'Enable');
        if ($sortby != '' && $orderby != "") {
            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {

            return $query->result();
        } else {
            return array();
        }
    }

    public function selectRecord($table) {
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function get_all_record($tablename, $data, $sortby, $orderby) {
        $this->db->select($data);
        $this->db->from($tablename);
        //$this->db->where('status', 'Enable');
        if ($sortby != '' && $orderby != "") {
            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    /*
     * Function Name :selectRecordById
     * Parameters :variables
     * Return :array
     */

    public function selectRecordById($table, $id, $filed) {

        $this->db->where($filed, $id);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    public function selectRecordByName($table, $name, $filed) {

        $this->db->where($filed, $name);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    /*
     * Function Name :saveTableImg
     * Parameters :variables
     * Return :variable
     */

    public function saveTableImg($tablename, $filed, $id, $data) {


        $this->db->where($filed, $id);
        $que = $this->db->update($tablename, $data);
        return $que;
    }

    /*
     * Function Name :checkAddTimeRecord
     * Parameters :variables
     * Return :variable
     */

    public function checkAddTimeRecord($columnVal, $columnName, $table) {

        $this->db->where($columnName, $columnVal);
        $query = $this->db->get($table);
        $num = $query->num_rows();

        if ($num != 0) {
            $res = 1;
        } else {
            $res = 0;
        }
        return $res;
    }

    /*
     * Function Name :checkEditTimeRecord
     * Parameters :variables
     * Return :variable
     */

    public function checkEditTimeRecord($columnVal, $columnName, $table, $id, $tableid) {

        $notequal = '<>';
        $tableId = $tableid . " " . $notequal;

        $this->db->where($tableId, $id);
        $this->db->where($columnName, $columnVal);
        $query = $this->db->get($table);
        $num = $query->num_rows();

        if ($num > 0) {
            $this->db->where($columnName, $columnVal);
            $query = $this->db->get($table);
            $rnum = $query->num_rows();
            if ($rnum > 0) {
                $res = 1;
            } else {
                $res = 0;
            }
        } else {
            $res = 0;
        }

        return $res;
    }

    function getSettingDetails() {
        return $this->db->get('settings')->result_array();
    }

    function select_data_by_allcondition($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $like = array()) {
        $this->db->select($data);
        $this->db->from($tablename);
        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);



        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }


        if (!empty($like)) {
//            $this->db->group_start();
            foreach ($like as $key => $value) {
                $this->db->or_like($key, $value);
            }
//            $this->db->group_end();
        }

        $query = $this->db->get();
        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }

        //if limit is not empty then return result array
        return $query->result_array();
    }

    /*
     * This function is to create the data source of the Jquery Datatable
     * 
     * @param $tablename Name of the Table in database
     * @param $datatable_fields Fields in datatable that are available for filtering in datatable andnumber of column and order sequence is must maintan with apearance in datatable and add blank filed for not related to database fileds.
     * @param $condition_array conditions for Query 
     * @param $data The field set to be return to datatables, it can contain any number of fileds
     * @param $request The Get or Post Request Sent from Datatable
     * @param $join_str Join array for Query
     * @param $group_by Group by clause array if present in query
     * @return JSON data for datatable
     */

    function getDataTableSource($tablename, $datatable_fields = array(), $conditions_array = array(), $data = '*', $request, $join_str = array(), $group_by = array(), $condition_or_arr = array()) {
        //Fields tobe display in datatable
        //$this->db->distinct();
        $this->db->select($data, false);
        $this->db->from($tablename);
        //Making Join with tables if provided
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //Conditions for Query  that is defaultly available to Datatable data source.
        if (!empty($conditions_array)) {
            $this->db->where($conditions_array);
        }
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }
        //Applying groupby clause to query
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }
        //echo $this->db->last_query();die();
        //Total record in query tobe return
        $output['recordsTotal'] = $this->db->count_all_results(NULL, FALSE);

        //Filtering based on the datatable_fileds
        if ($request['search']['value'] != '') {
            $this->db->group_start();
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $this->db->or_like($datatable_fields[$i], $request['search']['value']);
                }
            }
            $this->db->group_end();
        }

        //Total number of records return after filtering not no of record display on page.
        //It must be counted before limiting the resultset.
        $output['recordsFiltered'] = $this->db->count_all_results(NULL, FALSE);

        //Setting Limit for Paging
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
        }


        //ordering the query
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $this->db->order_by($datatable_fields[$request['order'][$i]['column']] . ' ' . $request['order'][$i]['dir']);
                }
            }
        }

        $query = $this->db->get();
        $output['draw'] = $request['draw'];
        $output['data'] = $query->result_array();
//        if(count($output['data']) != $output['recordsFiltered']) {
//            $output['recordsFiltered'] = count($output['data']);
//        }
//        if(count($output['data']) != $output['recordsTotal']) {
//            $output['recordsTotal'] = count($output['data']);
//        }
        // echo $this->db->last_query();die();
        return json_encode($output);
    }

    function has_chield($menu_id, $item_array) {
        $temp = 0;
        for ($i = 0; $i < count($item_array); $i++) {
            if ($item_array[$i]['menu_id'] == $menu_id) {
                $temp = 1;
                return true;
                break;
            }
        }
        if ($temp == 0) {
            return false;
        }
    }

    function check_menu_auth($item_array, $credentials_list) {
        unset($_SESSION['final_menu']);
        for ($i = 0; $i < count($item_array); $i++) {
            $url1 = $item_array[$i]['url'];
            if ($item_array[$i]['module'] == '') {
                $url_arr = explode('/', $url1);
                $controller = $url_arr[0];
            } else {
                $controller = $item_array[$i]['module'];
            }

            if ($controller != '') {
                if (in_array($controller, $credentials_list)) {
                    $_SESSION['final_menu'][$item_array[$i]['id']] = $item_array[$i]['id'];
                    if ($item_array[$i]['menu_id'] != null) {
                        $this->recursive_auth($item_array[$i]['menu_id'], $item_array, $credentials_list);
                    }
                }
            }
        }

        $final_menu = $_SESSION['final_menu'];

        return $final_menu;
    }

    function recursive_auth($menu_id, $item_array, $credentials_list) {
        for ($i = 0; $i < count($item_array); $i++) {
            if ($item_array[$i]['id'] == $menu_id) {
                $url1 = $item_array[$i]['url'];
                if ($item_array[$i]['module'] == '') {
                    $url_arr = explode('/', $url1);
                    $controller = $url_arr[0];
                } else {
                    $controller = $item_array[$i]['module'];
                }
                $_SESSION['final_menu'][$item_array[$i]['id']] = $item_array[$i]['id'];
                if ($item_array[$i]['menu_id'] != null) {
                    $this->recursive_auth($item_array[$i]['menu_id'], $item_array, $credentials_list);
                }
            }
        }
    }

    function display_menu($item_array) {
        $str = '<ul id="nav">';
        for ($i = 0; $i < count($item_array); $i++) {


            if ($item_array[$i]['menu_id'] == null) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }
//                $url1 = $item_array[$i]['url'];
//                if ($item_array[$i]['module'] == '') {
//                    $url_arr = explode('/', $url1);
//                    $controller = $url_arr[0];
//                } else {
//                    $controller = $item_array[$i]['module'];
//                }
//                $credentials_list = $this->data['credentials_list'];
//                $this->data['final_menu'];
                if ($this->data['is_superadmin'] != '1') {
                    if (in_array($item_array[$i]['id'], $this->data['final_menu'])) {
                        $str .= '<li>';
                        $str .= '<a href="' . $url . '">';
                        $str .= '';
                        $str .= $item_array[$i]['name'];
                        $str .= '</a>';

                        if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                            $str .= $this->recursive($item_array[$i]['id'], $item_array);
                        }
                        $str .= '</li>';
                    }
                } else {
                    $str .= '<li>';
                    $str .= '<a href="' . $url . '">';
                    $str .= '';
                    $str .= $item_array[$i]['name'];
                    $str .= '</a>';

                    if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                        $str .= $this->recursive($item_array[$i]['id'], $item_array);
                    }
                    $str .= '</li>';
                }
            }
        }
        $str .= '</ul>';
        return $str;
    }

    function display_menu1($item_array, $id, $userid) {
        $sel_credential = array();
//        if ($id != '') {
//            $sel_admin_credtal = $this->common->select_data_by_condition('acl_group_permissions', array('group_id' => $id), 'credentials_id as id', '', '', '', '', $join_str = array());
//            $sel_credential = array();
//            foreach ($sel_admin_credtal as $key => $value) {
//                $sel_credential[] = $value['id'];
//            }
//        }
//        if ($userid != '') {
//            $join_str[0] = array('table' => 'admin_user',
//                'join_table_id' => 'admin_user.id',
//                'from_table_id' => "acl_user_permissions.admin_user_id",
//                "join_type" => 'left'
//            );
//
//            $sel_admin_credtal = $this->common->select_data_by_condition('acl_user_permissions', array('admin_user.id' => $userid), 'acl_user_permissions.credentials_id as id', '', '', '', '', $join_str);
//
//            $sel_credential = array();
//            foreach ($sel_admin_credtal as $key => $value) {
//                $sel_credential[] = $value['id'];
//            }
//        }

        $str = '<ol class="dd-list">';
        for ($i = 0; $i < count($item_array); $i++) {

//            if($item_array[$i]['menu_id'] == 365) {
//                echo $item_array[$i]['menu_id'];
//            }
            if ($item_array[$i]['menu_id'] == null) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }



                if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                    $str .= '<li class="dd-item" data-id="' . $item_array[$i]['id'] . '">';
                    $str .= '<div class="dd-handle">';
                    $str .= '';
                    $str .= $item_array[$i]['name'];
                    $str .= '</div>';
                    $str .= $this->recursive1($item_array[$i]['id'], $item_array, $sel_credential);
                } else {
                    $str .= '<li class="dd-item" data-id="1153153" style="cursor: pointer;">';
                    $str .= '<div class="cust_dd-item" style=""><label class="checkbox"><input type="checkbox" name="credentails[]" class="uniform" value="' . $item_array[$i]['id'] . '">' . $item_array[$i]['name'] . '</label>';
//                    $str .= '<input type="checkbox" name="credentails[]" class="uniform" value="' . $item_array[$i]['id'] . '" onclick="sel_cehck()">';
//                    $str .= $item_array[$i]['name'];
                    $str .= '</div>';
                    $str .= '</li>';
//                    $str .= $this->get_credentials($item_array[$i]['id'], $sel_credential);
//                    break;
                }
                $str .= '</li>';
            }
        }
        $str .= '</ol>';
        return $str;
    }
    
    function recursive1($menu_id, $item_array, $sel_credential) {
        $str = '<ol class="dd-list">';
        for ($i = 0; $i < count($item_array); $i++) {

            if ($item_array[$i]['menu_id'] == $menu_id) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }
                
                

                if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                    $str .= '<li class="dd-item" data-id="' . $item_array[$i]['id'] . '">';
                $str .= '<div class="dd-handle">';
                $str .= $item_array[$i]['name'];
                $str .= '</div>';
                    $str .= $this->recursive1($item_array[$i]['id'], $item_array, $sel_credential);
                } else {
                    $str .= '<li class="dd-item" data-id="1153153" style="cursor: pointer;">';
                    $str .= '<div class="cust_dd-item" style=""><label class="checkbox"><input type="checkbox" name="credentails[]" class="uniform" value="' . $item_array[$i]['id'] . '">' . $item_array[$i]['name'] . '</label>';
//                    $str .= '<input type="checkbox" name="credentails[]" class="uniform" value="' . $item_array[$i]['id'] . '" onclick="sel_cehck()">';
//                    $str .= $item_array[$i]['name'];
                    $str .= '</div>';
                    $str .= '</li>';
//                    $str .= $this->get_credentials($item_array[$i]['id'], $sel_credential);
//                    break;
                }

                $str .= '</li>';
            }
        }
        $str .= '</ol>';
        return $str;
    }

    function recursive($menu_id, $item_array) {
        $str = '<ul class="sub-menu">';
        for ($i = 0; $i < count($item_array); $i++) {

            if ($item_array[$i]['menu_id'] == $menu_id) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }
                if ($this->data['is_superadmin'] != '1') {
                    if (in_array($item_array[$i]['id'], $this->data['final_menu'])) {
                        $str .= '<li>';
                        $str .= '<a href="' . $url . '">';
                        $str .= '<i class="icon-angle-right"></i>';
                        $str .= '<span class="arrow"></span>';
                        $str .= $item_array[$i]['name'];
                        $str .= '</a>';
                        if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                            $str .= $this->recursive($item_array[$i]['id'], $item_array);
                        }
                        $str .= '</li>';
                    }
                } else {
                    $str .= '<li>';
                    $str .= '<a href="' . $url . '">';
                    $str .= '<i class="icon-angle-right"></i>';
                    $str .= '<span class="arrow"></span>';
                    $str .= $item_array[$i]['name'];
                    $str .= '</a>';
                    if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                        $str .= $this->recursive($item_array[$i]['id'], $item_array);
                    }

                    $str .= '</li>';
                }
            }
        }
        $str .= '</ul>';
        return $str;
    }
    
    function get_credentials($item_id = '', $sel_credential) {
        if ($item_id != '') {

            $con_array = array('id' => $item_id);
            $menu_details = $this->common->select_data_by_condition('menu', $con_array, '*', '', '', '', '', array());
            $module = $menu_details[0]['module'];
            $action = $menu_details[0]['action'];
            $url = $menu_details[0]['url'];
            if ($module == '') {
                $url_arr = explode('/', $url);
                $controller = $url_arr[0];
            } else {
                $controller = $module;
            }

//            $con_array1 = array('controller' => $controller);
//            $acl_credentials_details = $this->common->select_data_by_condition('acl_credentials', $con_array1, '*', '', '', '', '', array());
//            po($this->data['main_data']);
            $str = '<ol class="dd-list">';
            if (isset($acl_credentials_details)) {

                if (!empty($acl_credentials_details)) {
                    foreach ($acl_credentials_details as $key => $value) {
                        $select = false;
                        if (in_array($value['id'], $sel_credential)) {
                            $select = true;
                        }
                        if ($select == true) {
                            $checked = "checked";
                        } else {
                            $checked = '';
                        }

                        $str .= '<li class="dd-item" data-id="1153153" style="cursor: pointer;">';
                        $str .= '<div class="cust_dd-item" style=""><label class="checkbox"><input type="checkbox" name="credentails[]" class="uniform" value="' . $value['id'] . '" ' . $checked . '>' . $value['credential'] . '</label>';
                        $str .= '</div></li>';
                    }
                } else {
                    $str .= '<li class="dd-item" data-id="1153153" style="cursor: pointer;">';
                    $str .= '<div style="margin: 5px 0;padding: 0px 5px;color: #333;text-decoration: none;font-weight: 400;border: 1px solid #ccc;background: #fafafa;"><label class="checkbox">No Credentails Found</label>';
                    $str .= '</div></li>';
                }
            } else {
                $str .= '<li class="dd-item" data-id="1153153" style="cursor: pointer;">';
                $str .= '<div style="margin: 5px 0;padding: 0px 5px;color: #333;text-decoration: none;font-weight: 400;border: 1px solid #ccc;background: #fafafa;"><label class="checkbox">No Credentails Found</label>';
                $str .= '</div></li>';
            }

            $str .= '</ol>';
            return $str;
        }
    }

    function getDataTableSourcesortby($tablename, $datatable_fields = array(), $conditions_array = array(), $data = '*', $request, $join_str = array(), $group_by = array(), $sortby = '', $orderby = '') {
        $output = array();
        //Fields tobe display in datatable
        $this->db->select($data);
        $this->db->from($tablename);
        //Making Join with tables if provided
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        //Conditions for Query  that is defaultly available to Datatable data source.
        if (!empty($conditions_array)) {
            $this->db->where($conditions_array);
        }

        //Applying groupby clause to query
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }

        //Total record in query tobe return
        $output['recordsTotal'] = $this->db->count_all_results(NULL, FALSE);

        //Filtering based on the datatable_fileds
        if ($request['search']['value'] != '') {
            $this->db->group_start();
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $this->db->or_like($datatable_fields[$i], $request['search']['value']);
                }
            }
            $this->db->group_end();
        }

        //Total number of records return after filtering not no of record display on page.
        //It must be counted before limiting the resultset.
        $output['recordsFiltered'] = $this->db->count_all_results(NULL, FALSE);

        //Setting Limit for Paging
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
        }


        //ordering the query
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $this->db->order_by($datatable_fields[$request['order'][$i]['column']] . ' ' . $request['order'][$i]['dir']);
                }
            }
        }

        $query = $this->db->get();
        $output['draw'] = $request['draw'];
        $output['data'] = $query->result_array();

//        if ($output['recordsFiltered'] != count($output['data'])) {
//            $output['recordsTotal'] = count($output['data']);
//            $output['draw'] = '1';
//            $output['recordsFiltered'] = count($output['data']);
//        }
        //print_r($output); die();
        return json_encode($output);
    }

    public function select_data_by_multiple_condition($tablename, $condition_array = array(), $data = '*', $where_in_col = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array(), $where_in_val = array()) {
        //select_data_by_multiple_condition('biometric_student_attendance', $condition_arr, $selected,$where_in,$orderby, '', '', $join_str,'','');
        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);
        //$this->db->where('student_assignment_reply.student_id is null');
        if (!empty($where_in_val)) {
            $this->db->where_in($where_in_col, $where_in_val);
        } else {
            $this->db->where_in($where_in_col);
        }
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        //order by query

        if ($orderby = '') {
            $this->db->order_by($orderby);
        }


        $query = $this->db->get();

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    function getDataTableSourcorderby($tablename, $datatable_fields = array(), $conditions_array = array(), $data = '*', $request, $join_str = array(), $group_by = array(), $orderby = '') {
        $output = array();
        //Fields tobe display in datatable
        $this->db->select($data);
        $this->db->from($tablename);
        //Making Join with tables if provided
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        if ($orderby = '') {
            $this->db->order_by($orderby);
        }

        //Conditions for Query  that is defaultly available to Datatable data source.
        if (!empty($conditions_array)) {
            $this->db->where($conditions_array);
        }

        //Applying groupby clause to query
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }

        //Total record in query tobe return
        $output['recordsTotal'] = $this->db->count_all_results(NULL, FALSE);

        //Filtering based on the datatable_fileds
        if ($request['search']['value'] != '') {
            $this->db->group_start();
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $this->db->or_like($datatable_fields[$i], $request['search']['value']);
                }
            }
            $this->db->group_end();
        }

        //Total number of records return after filtering not no of record display on page.
        //It must be counted before limiting the resultset.
        $output['recordsFiltered'] = $this->db->count_all_results(NULL, FALSE);

        //Setting Limit for Paging
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
        }


        //ordering the query
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $this->db->order_by($datatable_fields[$request['order'][$i]['column']] . ' ' . $request['order'][$i]['dir']);
                }
            }
        }

        $query = $this->db->get();
        $output['draw'] = $request['draw'];
        $output['data'] = $query->result_array();
        //print_r($output); die();
        return json_encode($output);
    }

    function select_data_by_search_groupby($tablename, $search_condition, $condition_array = array(), $data = '*', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '') {

        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if ($search_condition != '') {
            $this->db->where($search_condition);
        }
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }

        if ($orderby = '') {
            $this->db->order_by($orderby);
        }


        $query = $this->db->get();
        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    function change_status($table_name, $id, $status) {
        if (!empty($id) && !empty($status)) {
            $this->db->where('id', $id);
            $this->db->set('status', $status);
            $this->db->update($table_name);
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
        return FALSE;
    }

}
