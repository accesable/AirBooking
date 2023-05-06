<?php
    session_start();
    $name='';
    if (isset($_SESSION['user'])) {
        $name=$_SESSION['fullname'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Air Flight Reservation</title>
    <style>
      td {
        vertical-align: middle;
      }
      img {
        max-height: 100px;
      }
      body {
			  background-image: url('images/background.png');
			  background-size: cover;
		}
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php">The Great Airline</a>
          </div>
          <?php
            if(empty($name)){
              echo"
            <ul class=\"nav navbar-nav\">
              <li><a href=\"./login.php\">Login</a></li>
              <li><a href=\"./register.php\">Register</a></li>
            </ul>
            ";
            }
            else{
              echo"<ul class=\"nav navbar-nav\">
              <li><a>".$name."</a></li>
              <li><a href=\"./logout.php\">Logout</a></li>
            </ul>";
            }
          ?>
        </div>
      </nav>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
                    <label for="id">Find Fight Information</label>
                    <input id="id" type="text" class="form-control" placeholder="Flight ID">
        </div>
        <p id="message" >
          
        </p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col col-md-10">
          <h3 class="my-4 text-center">Flight List</h3>
          <div class="d-flex justify-content-between">
          </div>
          <table class="table-bordered table table-hover text-center">
            <thead>
              <tr>
                <th>Flight ID</th>
                <th>Starting At</th>
                <th>Destination</th>
                <th>Depart At</th>
                <th>Ticket Class</th>
                <th>Flight type</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody id="flight_list" >
              
            </tbody>
          </table>
        </div>
      </div>
    </div>

      
    <script>

$(document).ready(function () {
    function append_flight(item){   
             
        var row= $("<tr></tr>");
        row.append("<td class=\"align-middle\">"+item.flight_id+"</td>")
        row.append("<td class=\"align-middle\">"+item.starting_location+"</td>")
        row.append("<td class=\"align-middle\">"+item.destination+"</td>")
        row.append("<td class=\"align-middle\">"+item.flight_time+"</td>")
        row.append("<td class=\"align-middle\">"+item.type_class+"</td>")
        row.append("<td class=\"align-middle\">"+item.flight_type+"</td>")
        row.append("<td class=\"align-middle\">"+item.price+"</td>")
        $("#flight_list").append(row);
    }
    //Load in Flights
    $("#id").keypress((e)=>{
      if(e.which === 13){
        id=$("#id").val();
      $.ajax({
        url:'api/api_ticket_purchase/api_get_ticket_infor.php?id='+id,
        method:'get',
        dataType:'json',
        contentType:"application/json",
        success: function(response) {
          $("#message").empty()
            $("#flight_list").empty()
            if(response != null){
              append_flight(response)
            }
            else{
              $("#message").append("<div class=\"p-3 bg-warning text-dark\">No Flight Founded</div>")
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error loading Flights');
          }
      })
      }
      
    })
  });
    </script>
      
</body>
</html>