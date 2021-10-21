<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ERROR | E_PARSE);
    $c = new mysqli("localhost", "root", "", "tasiuks");
    if($c->connect_errno) 
    {
        echo json_encode(array('result'=> 'ERROR', 'message' => 'Failed to connect DB'));
        die();
    }

?>