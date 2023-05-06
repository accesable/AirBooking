<?php
    require_once('db.php');

    function add_type($class, $flight, $price)
    {
        $conn=get_connection();
        $sql="INSERT INTO `ticket_type`( `type_class`, `flight_type`, price) VALUES (?,?,?)";
        $stm=$conn->prepare($sql);
        $stm->bind_param('ssi',$class,$flight,$price);
        return $stm->execute();
    }

    function get_types() {
        $sqlQuery = "select * from ticket_type";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);

        if(!$stm->execute()){
            return array("code"=>1,"message"=>"Fail to find flight");
        }
        $result=$stm->get_result();
        
        if($result->num_rows===0) return array("code"=>1,"message"=>"No flight available!");
        $num_rows=$result->num_rows;
        $types = array();
        for ($i =0 ;$i<$num_rows;$i++){
            $types[]=$result->fetch_assoc();
        }
        return $types;

    }
    function update_ticket($id, $class, $flight, $price)
    {
        $sqlQuery="UPDATE `ticket_type` SET `type_class`=?,`flight_type`=?,`price`=? WHERE `type_id`=?";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);
        $stm->bind_param('ssii',$class,$flight,$price,$id);

        $stm->execute();
        return ($stm->affected_rows===1);
    }

    function delete_type($id)
    {
        $sqlQuery="DELETE FROM ticket_type WHERE type_id = ?";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);
        $stm->bind_param("i",$id);

        $stm->execute();
        return ($stm->affected_rows===1);
    }
?>