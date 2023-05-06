<?php
    require_once("../db/buy_ticket_db.php");
    header("Content-Type: application/json; charset=uft-8");

    // request method validation
    if($_SERVER['REQUEST_METHOD']!=="GET"){
        http_response_code(405) ;
        die(json_encode(array('code'=>4, 'message'=>'GET supported API')));
    }
    if(isset($_GET['id'])){
        $ticket_id=$_GET['id'];
        if(is_null($ticket_id)){
            die(json_encode(array('code'=>4, 'message'=>'Provide A ID')));
        }
        if(empty($ticket_id)){
            die(json_encode(array('code'=>4, 'message'=>'Provide A ID')));
        }
        if(!is_numeric($ticket_id)){
            die(json_encode(array('code'=>4, 'message'=>'Provide A valid ID')));
        }
        $data=get_ticket_infor_id($ticket_id);
        die(json_encode($data));
    }
    else if(isset($_GET['user'])){
        $user=$_GET['user'];
        if(is_null($user)){
            die(json_encode(array('code'=>4, 'message'=>'Provide A user')));
        }
        if(empty($user)){
            die(json_encode(array('code'=>4, 'message'=>'Provide A user')));
        }
        $data=get_ticket_infor_user($user);
        die(json_encode($data));
    }
    else{
        die(json_encode(array('code'=>4, 'message'=>'Provide a id or A username')));
    }
    
?>
