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
        background-image: url('images/sky.jpg');
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="./index.php" style="color: #004400">The Great Airline</a>
          </div>

          <?php
            if(empty($name)){
              echo"
            <ul class=\"nav navbar-nav\">
              <li><a href=\"./login.php\">Login</a></li>
              <li><a href=\"./register.php\">Register</a></li>
              <li><a href=\"./ticket_id_infor.php\">Ticket Information</a></li>
            </ul>
            ";
            }else if ($_SESSION['role']==="admin"){
              echo"<ul class=\"nav navbar-nav\">
              <li><a>".$name."</a></li>
              <li><a href=\"./logout.php\">Logout</a></li>
              <li><a href=\"./flight_history.php\">Flights history</a></li>
              <li><a href=\"./flightinfor.php\">Flight Management</a></li>
              <li><a href=\"./tickettype.php\">Ticket Management</a></li>
            </ul>";
            }
            else{
              echo"<ul class=\"nav navbar-nav\">
              <li><a>".$name."</a></li>
              <li><a href=\"./logout.php\">Logout</a></li>
              <li><a href=\"./flight_history.php\">Flights history</a></li>
            </ul>";
            }
          ?>
        </div>
      </nav>
      <div class="container">
        <div class="row">
            <div class=" col-md-4" >
                <form  >
                    <div class="form-group" style="color: #004400">
                      <label for="time">Flight Date:</label>
                      <input type="date" class="form-control" id="time">
                    </div>
                    <div class="form-group">
                        <label style="display: block;" for="time">Destination:</label>
                        <select id="dest" class="form-select p-2" aria-label="Default select example">
                          </select>
                      </div>
                      <div id="message"></div>
                      <button id="search" type="button" class="btn btn-default">Find Flights</button>
                </form>

            </div>
            <div class=" col-md-6">
              <table class="table" style="color: #004400">
                <thead>
                  <tr>
                    <th>FlightID</th>
                    <th>Starting At</th>
                    <th>Destination</th>
                    <th>Depart At</th>
                    <th></th>
                  </tr>
                  <tr style="display: none;" >
                    <td class="align-middle">1</td>
                    <td class="align-middle">'.$row['start'].'</td>
                    <td class="align-middle">'.$row['dst'].'</td>
                    <td class="align-middle">'.$row['timeription'].'</td>
                    <td class="align-middle actions">
                    </td>
                  </tr>
                </thead>
                <tbody id="flight_list" >
                  
                </tbody>
              </table>
            </div>
        </div>
      </div>

      <!-- Buy Model -->
      <div id="buyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <hp class="modal-title">Please Select ticket type For Flight <strong id="flight-id"></strong></hp>
              <button  type="button" class="close close-m" data-dismiss="modal">
                &times;
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Trip</th>
                            <th>Price</th>
                        </tr>
                    </thead >
                    <tbody id="ticket-type">

                    </tbody>
                </table>
              <div class="message"></div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-sm btn-secondary close-m"
                data-dismiss="modal"
              >
                Close
              </button>
              <button id="purchase-btn" type="button" class="btn btn-sm btn-success">Purchase</button>
            </div>
          </div>
        </div>
      </div>
      <script src="./assets/scripts/index.js"></script>
      
</body>
</html>