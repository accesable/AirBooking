<?php
    session_start();
    $user=$_SESSION['user'] ?? null;
    $email=$_SESSION['email'] ?? null;
    require_once("../db/buy_ticket_db.php");
    header("Content-Type: application/json; charset=uft-8");

    // request method validation
    if($_SERVER['REQUEST_METHOD']!=="POST"){
        http_response_code(405) ;
        die(json_encode(array('code'=>4, 'message'=>'GET supported API')));
    }
    $input=json_decode(file_get_contents("php://input"));

    //Check Input
    if(is_null($input)){
        die(json_encode(array('code'=>2, 'message'=>'JSON supported Only !')));
    }
    //Check for properties existed
    if(!property_exists($input,'flight')||!property_exists($input,'type')){
        http_response_code(400);
        die(json_encode(array('code'=>1, 'message'=>'Missing Input')));
    }
    //check if properties is empty
    if(empty($input->flight)||empty($input->type)){
        die(json_encode(array('code'=>1, 'message'=>'Missing Input'))); 
    }
    if(!is_numeric($input->flight)||!is_numeric($input->type)){
        die(json_encode(array('code'=>1, 'message'=>'Invalid Input'))); 
    }
    $result = buy_ticket($input->flight,$user,$input->type,$email);
    
    if($result['code']==0){
        die(json_encode($result)); 
    }
    else{
        die(json_encode($result)); 
    }
?>