<?php
    require_once("../db/flight_db.php");
    header("Content-Type: application/json; charset=uft-8");

    // request method validation
    if($_SERVER['REQUEST_METHOD']!=="GET"){
        http_response_code(405) ;
        die(json_encode(array('code'=>4, 'message'=>'GET supported API')));
    }
    $data=get_flights();
    die(json_encode($data));

?>