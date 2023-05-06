<?php
    require_once("./api/db/db.php");
    function validate_login($user,$pass){
        $conn = get_connection();
        $sqlQuery = "select * from user_account where username = ?";

        $stm = $conn->prepare($sqlQuery);
        $stm->bind_param('s',$user);
        if(!$stm->execute()){
            die("Query error ".$stm->error);
        }

        $result=$stm->get_result();
        if($result->num_rows!==1) return array('code'=>1,"message"=>"User is not exist");

        $data=$result->fetch_assoc();

        $hased_password = $data['password'];
        if(!password_verify($pass,$hased_password)){
            return array('code'=>2,"message"=>"Invalid password or username");
        }
        else{
            $data['code']=0;
            $data['message']='Successfully login';
            return $data;
        };
    }
    function is_email_user_exist($email,$user){
        $conn=get_connection();
        $sqlQuery="select count(*) from user_account where email = ? or username= ?";

        $stm=$conn->prepare($sqlQuery);
        $stm->bind_param('ss',$email,$user);
        if(!$stm->execute()){
            return null;
        }

        $data=$stm->get_result();
        if($data->fetch_array()[0] !== 0) return true;
        return false;
    }
    function validate_register($user,$pass,$email,$lastname,$firstname,$phone){
        $conn=get_connection();
        if(is_email_user_exist($email,$user)) {
            return array('code'=>1, 'message'=>'Email or username already existed');
        };
        $hashed= password_hash($pass,PASSWORD_DEFAULT);

        $sqlQuery="insert into user_account (username,firstname,lastname,email,password,telephone) values (?,?,?,?,?,?)";

        $stm=$conn->prepare($sqlQuery);
        $stm->bind_param('ssssss',$user,$firstname,$lastname,$email,$hashed,$phone);

        if(!$stm->execute()){
            return array('code'=>2, 'message'=>'Register error occurred');
        }
        if($stm->affected_rows===0) return array('code'=>2, 'message'=>'Cannot Register occurred');
        return array('code'=>0, 'message'=>'Register successfully');
    }
    

?>