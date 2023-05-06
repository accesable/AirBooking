<?php
    require_once("db.php");
    function get_destinations(){
        $con=get_connection();
        $result = $con->query("SELECT DISTINCT destination FROM `flight_infor` WHERE 1");

        $dest=array();
        while ($row = $result->fetch_assoc()){
            $dest[]= $row;
        }
        return $dest;
    }
    function add_flight($start, $dst, $time)
    {
        //2023-04-22T14:06
        $sqltime= substr($time,0,10)." ".substr($time,11).":00";
        
        $conn=get_connection();
        $sql="INSERT INTO `flight_infor`( `starting_location`, `destination`, `flight_time`) VALUES (?,?,?)";
        $stm=$conn->prepare($sql);
        $stm->bind_param('sss',$start,$dst,$sqltime);
        return $stm->execute();

    }

    function get_flights() {
        $sqlQuery = "SELECT * FROM `flight_infor` ORDER BY `flight_time` DESC";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);

        if(!$stm->execute()){
            return array("code"=>1,"message"=>"Fail to find flight");
        }
        $result=$stm->get_result();
        
        if($result->num_rows===0) return array("code"=>1,"message"=>"No flight available!");
        $num_rows=$result->num_rows;
        $flights = array();
        for ($i =0 ;$i<$num_rows;$i++){
            $flights[]=$result->fetch_assoc();
        }
        return $flights;

    }
    function update_flight($id, $start, $dst, $time)
    {
        $sqlQuery="update flight_infor set starting_location=?,destination=?,flight_time=? where flight_id =?";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);
        $stm->bind_param('sssi',$start,$dst,$time,$id);

        $stm->execute();
        return ($stm->affected_rows===1);
    }

    function delete_flight($id)
    {
        $sqlQuery="delete from flight_infor where flight_id =? ";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);
        $stm->bind_param("i",$id);

        $stm->execute();
        return ($stm->affected_rows===1);
    }
    function search_flights($time,$dest){
        $sqlQuery = "SELECT * FROM `flight_infor` WHERE flight_time > '$time' AND destination = '$dest' ORDER BY flight_time DESC";
        $conn=get_connection();

        $stm=$conn->prepare($sqlQuery);

        if(!$stm->execute()){
            return array("code"=>1,"message"=>"Fail to find flight");
        }
        $result=$stm->get_result();
        
        if($result->num_rows===0) return array("code"=>1,"message"=>"No flight available!");
        $num_rows=$result->num_rows;
        $flights = array();
        for ($i =0 ;$i<$num_rows;$i++){
            $flights[]=$result->fetch_assoc();
        }
        return $flights;
    }
?>