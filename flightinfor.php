<?php
    session_start();
    $name='';
    if (isset($_SESSION['user']) && $_SESSION['role']==="admin") {
        $name=$_SESSION['fullname'];
    }
    else{
      header('Location: index.php');
      exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Flight Information List</title>
    <meta start="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
      integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
      td {
        vertical-align: middle;
      }
      img {
        max-height: 100px;
      }

    </style>
  </head>
  <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="./index.php">The Great Airline</a>
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
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col col-md-10">
          <h3 class="my-4 text-center">Flight List</h3>
          <div class="d-flex justify-content-between">
            <a class="btn btn-sm btn-secondary mb-4 add-btn" >Add Flight</a>
          </div>
          <table class="table-bordered table table-hover text-center">
            <thead>
              <tr>
                <th>FlightID</th>
                <th>Starting At</th>
                <th>Destination</th>
                <th>Depart At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="flight_list" >
              <tr style="display: none;" >
                <td class="align-middle">1</td>
                <td class="align-middle">'.$row['start'].'</td>
                <td class="align-middle">'.$row['dst'].'</td>
                <td class="align-middle">'.$row['timeription'].'</td>
                <td class="align-middle actions">
                  <button onclick="showEdit(this)" class="btn btn-sm btn-primary mr-1 edit-btn">
                    <i class="fas fa-pen"></i>
                  </button>
                  <button onclick="showDelete(this)" value="'.$row['id'].'" class="btn btn-sm btn-danger delete-btn">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <p id ="total_Flights" class="text-right">Total Flights: <strong>2</strong></p>
        </div>
      </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <hp class="modal-title">Delete a flight</hp>
            <button  type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <p>
              Are you sure you want to delete the flight ?
            </p>
            <div class="message"></div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-sm btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button id="delete-btn" type="button" class="btn btn-sm btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Confirm Modal -->
    <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <hp class="modal-title">Update flight</hp>
            <button type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="start">Flight start at</label>
                <input id="start" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="dst">Land at</label>
                <input id="dst" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="time">Depart at</label>
                <input id="time" type="datetime-local" class="form-control" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-sm btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button id="edit-btn" type="button" class="btn btn-sm btn-success">Save</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Add flight Modal -->
    <div id="addModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <hp class="modal-title">Add flight <strong id="flight_start"></strong></hp>
            <button type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="start">flight start At</label>
                <input onkeyup="show_add_flight(this.value)" id="start" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="dst">Land at</label>
                <input id="dst" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="time">time</label>
                <input id="time" type="datetime-local" class="form-control" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-sm btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button id="add-btn" type="button" class="btn btn-sm btn-success">Add flight</button>
          </div>
        </div>
      </div>
    </div>
    <script src="./assets/scripts/flightinfor.js"></script>
  </body>
</html>