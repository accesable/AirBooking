<?php
require_once("db.php");
function buy_ticket($flight_id, $username, $ticket_type,$email) {
    // Connect to the database
    $conn = get_connection();
    // Check if the user already has a ticket for this flight
    if($username != null){
      $sql = "SELECT * FROM flight_ticket WHERE flight_id = $flight_id AND username = '$username'";
      $sqlInsert = "INSERT INTO flight_ticket (flight_id, username, ticket_type) VALUES ($flight_id, '$username', $ticket_type)";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
      return array("code"=>1,"message"=>"Already Bought ");
      }
    }else{
      $sqlInsert = "INSERT INTO flight_ticket (flight_id, username, ticket_type) VALUES ($flight_id, NULL, $ticket_type)";
    }
    // Check if the requested ticket type is valid
    $sql = "SELECT * FROM ticket_type WHERE type_id = $ticket_type";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      return array("code"=>1,"message"=>"Invalid Ticket Type ");;
    }
  
    // Get the price of the ticket
  
    // Insert the ticket into the database
    
    if ($conn->query($sqlInsert) === TRUE) {
      $last_id = $conn->insert_id;
      if($email!==null){
        send_mail($email,$last_id);        
      }
      return array("code"=>0,"message"=>"Ticket Purchased, ticket's id is ".$last_id);
      
    } else {
      return array("code"=>1,"message"=>"Cannot Buy ");
    }
  
    // Close the database connection
    $conn->close();
  };

  use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

  function send_mail($email,$id){
//Load Composer's autoloader
    //require 'vendor/autoload.php';
    require_once ("../phpmailer/vendor/autoload.php");

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //$mail->setLanguage('vi', '/optional/path/to/language/directory/');
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'trannhutanh654@gmail.com';                     //SMTP username
        $mail->Password   = 'jhvxmscfsubekhtu';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('trannhutanh654@gmail.com', 'Mailer');
        $mail->addAddress($email, 'Receiver');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Your flight ticket ID';
        $mail->Body    = "Your Ticket ID is <strong>$id</strong> Please Check the information at <a href=\"http://localhost/FlightReservation/ticket_id_infor.php\">This site</a>";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
        //echo 'Message has been sent';
    } catch (Exception $e) {
        return false;
    }
  }
  function get_ticket_infor_id($ticket_id){
      $conn=get_connection();

      // Prepare the SQL statement to fetch the ticket info
      $sql = "SELECT flight_infor.flight_id,flight_ticket.username,flight_infor.starting_location, flight_infor.destination, flight_infor.flight_time
      ,flight_ticket.ticket_type, ticket_type.type_class, ticket_type.flight_type, ticket_type.price
      FROM flight_infor 
      JOIN flight_ticket ON flight_infor.flight_id = flight_ticket.flight_id 
      JOIN ticket_type ON flight_ticket.ticket_type = ticket_type.type_id 
      WHERE flight_ticket.ticket_id = $ticket_id";

    // Execute the SQL statement and fetch the result
    $result = mysqli_query($conn, $sql);
    $ticket_info = mysqli_fetch_assoc($result);

    // Close the database connection
    mysqli_close($conn);

    // Return the ticket information as an associative array
    return $ticket_info;
  } 

  function get_ticket_infor_user($ticket_user){
    $conn=get_connection();

    // Prepare the SQL statement to fetch the ticket info
    $sql = "SELECT flight_infor.flight_id,flight_ticket.username,flight_infor.starting_location, flight_infor.destination, flight_infor.flight_time
    ,flight_ticket.ticket_type, ticket_type.type_class, ticket_type.flight_type, ticket_type.price
    FROM flight_infor 
    JOIN flight_ticket ON flight_infor.flight_id = flight_ticket.flight_id 
    JOIN ticket_type ON flight_ticket.ticket_type = ticket_type.type_id 
    WHERE flight_ticket.username = \"$ticket_user\"";

  // Execute the SQL statement and fetch the result
  $result = $conn->query($sql);
  if($result->num_rows>0){
    $tickets=array();
    while($row=$result->fetch_assoc()){
      $tickets[]=$row;
    }
    return $tickets;
  }
  mysqli_close($conn);
  return FALSE;
} 


  
?>