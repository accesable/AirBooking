<?php
    require_once("../db/flight_db.php");
    header("Content-Type: application/json; charset=uft-8");

    // request method validation
    if($_SERVER['REQUEST_METHOD']!=="DELETE"){
        http_response_code(405) ;
        die(json_encode(array('code'=>4, 'message'=>'DELETE supported API',"error"=>$_SERVER['REQUEST_METHOD'])));
    }
    $input=$_GET['id'] ?? null;

    //Check Input
    if(is_null($input)){
        die(json_encode(array('code'=>1, 'message'=>'please provide ID')));
    }
    //Check for properties existed
    //check if properties is empty
    if(empty($input)){
        die(json_encode(array('code'=>1, 'message'=>'Missing Input'))); 
    }
    //json can convert string to number at price property
    if(!is_numeric($input)){
        die(json_encode(array('code'=>1, 'message'=>'Invalid Input at ID')));
    }
    $input=intval($input);
    $result=delete_flight($input);  
    if($result){
        die(json_encode(array('code'=>0, 'message'=>'Delete Successfully')));
    }else{
        die(json_encode(array('code'=>1, 'message'=>'Delete Failed'))); 
    }
?>