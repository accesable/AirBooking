<?php 
    require_once("../db/ticket_type_db.php");
    header("Content-Type: application/json; charset=uft-8");

    // request method validation
    if($_SERVER['REQUEST_METHOD']!=="POST"){
        http_response_code(405) ;
        die(json_encode(array('code'=>4, 'message'=>'POST supported API')));
    }
    // take json request from client 
    $input=json_decode(file_get_contents("php://input"));

    //Check Input
    if(is_null($input)){
        die(json_encode(array('code'=>2, 'message'=>'JSON supported Only !')));
    }
    //Check for properties existed
    if(!property_exists($input,'class')||!property_exists($input,'flight_type')||!property_exists($input,'price')){
        http_response_code(400);
        die(json_encode(array('code'=>1, 'message'=>'Missing Input')));
    }
    //check if properties is empty
    if(empty($input->class)||empty($input->flight_type)||empty($input->price)){
        die(json_encode(array('code'=>1, 'message'=>'Missing Input'))); 
    }
    if(!is_numeric($input->price)){
        die(json_encode(array('code'=>1, 'message'=>'Invalid Price'))); 
    }
    
    $result = add_type($input->class,$input->flight_type,$input->price);
    if($result){
        die(json_encode(array('code'=>0, 'message'=>'Add Successfully'))); 
    }
    else{
        die(json_encode(array('code'=>1, 'message'=>'Add Failed'))); 
    }
?>