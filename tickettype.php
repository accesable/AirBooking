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
    <title>Ticket Type</title>
    <meta class="viewport" content="width=device-width, initial-scale=1" />
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
  <body>
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
    <div class="container">
      <div class="row justify-content-center">
        <div class="col col-md-10">
          <h3 class="my-4 text-center">Type List</h3>
          <div class="d-flex justify-content-between">
            <a class="btn btn-sm btn-secondary mb-4 add-btn" >Add type</a>
          </div>
          <table class="table-bordered table table-hover text-center">
            <thead>
              <tr>
                <th>Type ID</th>
                <th>Type Class</th>
                <th>type trip</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="type_list" >
              <tr style="display: none;" >
                <td class="align-middle">1</td>
                <td class="align-middle">'.$row['class'].'</td>
                <td class="align-middle">'.$row['flight-type'].'</td>
                <td class="align-middle">'.$row['priceription'].'</td>
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
          <p id ="total_types" class="text-right">Total types: <strong>2</strong></p>
        </div>
      </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <hp class="modal-title">Delete a Ticket Type</hp>
            <button  type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <p>
              Are you sure you want to delete <strong></strong> ?
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
            <hp class="modal-title">Update Ticket Type <strong></strong></hp>
            <button type="button" class="close" data-dismiss="modal">
              &prices;
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="class">Type Class</label>
                <input id="class" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="type-trip">type trip</label>
                <select name="type-trip" id="type-trip">
                  <option value="One-way">One-way</option>
                  <option value="Round-trip">Round-trip</option>
                </select>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input id="price" type="number" class="form-control" />
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
    <!-- Add type Modal -->
    <div id="addModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <hp class="modal-title">Add Ticket Type <strong id="type"></strong></hp>
            <button type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="class">type class</label>
                <input onkeyup="show_add_type(this.value)" id="class" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="type-trip">type trip</label>
                <select name="type-trip" id="type-trip">
                  <option value="One-way">One-way</option>
                  <option value="Round-trip">Round-trip</option>
                </select>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input id="price" type="number" class="form-control" />
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
            <button id="add-btn" type="button" class="btn btn-sm btn-success">Add type</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function () {
        function append_type(item){           
            var actions= $(".actions")[0]
            var row= $("<tr></tr>");
            row.append("<td class=\"align-middle\">"+item.type_id+"</td>")
            row.append("<td class=\"align-middle\">"+item.type_class+"</td>")
            row.append("<td class=\"align-middle\">"+item.flight_type+"</td>")
            row.append("<td class=\"align-middle\">"+item.price+"</td>")
            row.append(actions.cloneNode(true));
            $("#type_list").append(row);
        }

        //Load in types
        $.ajax({
            url:'api/api_ticket_type/get_ticket_types.php',
            method:'get',
            dataType:'json',
            contentType:"application/json",
            success: function(response) {
                $("#total_types strong").text(response.length);
                response.forEach(append_type)
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Unable to load ');
              }
        })
        $(".close").on('click',function(){
          $(".message").text("");
        })
      });
      
      // show delete confirm
      function showDelete(cell){
        const row =$(cell).parent().parent();
        var id=row.children('td:not(:last-child)')[0].innerHTML
        $('#deleteModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#delete-btn').on('click', function() {
          $.ajax({
            url: 'api/api_ticket_type/delete_ticket_type.php?id=' + id,
            method: 'DELETE',
            dataType: 'json',
            contentType: "application/json",
            success: function(response) {
              if(response.code === 0) {
                alert("Deleted")
              } else {
                alert("Cannot delete because the type has been selected by customer");
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting type');
            }
          });
        });

      }

      function show_add_type(str){
        $(".modal-title > strong").text(str)
      }
      //show add type
      $(".add-btn").on('click',()=>{
        $('#addModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $("#add-btn").on('click',function(){
          var update_class=$("#addModal #class").val();
          var update_flight_type=$("#addModal #type-trip").val();
          var update_price=$("#addModal #price").val();
          console.log(update_class,update_flight_type,update_price)
          var data={
            class:update_class,
            flight_type:update_flight_type,
            price:parseInt(update_price)
          }
          var jsonData=JSON.stringify(data);
          $.ajax({
            url:"api/api_ticket_type/add_ticket_type.php",
            method:"POST",
            data: jsonData,
            dataType:"json",
            contentType:"application/json",
            success: function(response){
              alert(response.message)
            },error: function(xhr, status, error){
              alert(xhr.responseText);
            }
          })
        })

      })

      // show edit confirm
      function showEdit(cell){
        const row =$(cell).parent().parent();
        var id=row.children('td:not(:last-child)')[0].innerHTML

        $('#editModal').modal({
          backdrop: 'static',
          keyboard: false
      });
        $(".modal-title > strong").text(id);
        //Ajax request API
        $("#edit-btn").on('click',function(){
          var update_class=$("#editModal #class").val();
          var update_flight_type=$("#editModal #type-trip").val();
          var update_price=$("#editModal #price").val();
          console.log(update_class,update_flight_type,update_price);
          var data={
            class:update_class,
            flight_type:update_flight_type,
            price:parseInt(update_price)
          }
          var jsonData=JSON.stringify(data);
          $.ajax({
            url: "api/api_ticket_type/update_ticket_type.php?id="+id,
            method: "PUT",
            data: jsonData,
            dataType: "json",
            contentType: "application/json",
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
          });
        })
      }

    </script>
  </body>
</html>