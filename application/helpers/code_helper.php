<?php

function test() {
    echo "test";
}

function last_url() {
    //return filter_input(INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_STRING); 
    return $_SERVER['HTTP_REFERER'];
}

function pr($content) {
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}

function po($data = '') {
    echo "<pre>";
    if ($data == '') {
        print_r($_POST);
    } else {
        print_r($data);
    }
    echo "</pre>";
    die();
}

function datetime() {
    return date('Y-m-d H:i:s');
}

function last_query() {
    echo "<pre>";
    echo $this->db->last_query();
    echo "</pre>";
}


?>
