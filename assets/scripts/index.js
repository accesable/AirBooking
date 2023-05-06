$(document).ready(function () {
    // <option selected>Select your Destination</option>
    function append_destination(item){           
        $("#dest").append("<option value = \""+item.destination+"\">"+item.destination+"</option>")
    }
    //Load in destinations
    $.ajax({
        url:'api/api_flight/get_destinations.php',
        method:'get',
        dataType:'json',
        contentType:"application/json",
        success: function(response) {
            response.forEach(append_destination)
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error loading flights');
          }
    })

    function append_flight(item){           
        var actions= $(".actions")[0]
        var row= $("<tr></tr>");
        row.append("<td class=\"align-middle\">"+item.flight_id+"</td>")
        row.append("<td class=\"align-middle\">"+item.starting_location+"</td>")
        row.append("<td class=\"align-middle\">"+item.destination+"</td>")
        row.append("<td class=\"align-middle\">"+item.flight_time+"</td>")
        row.append("<td class=\"align-middle\"><button onclick=\"purchase(this)\" value=\""+item.flight_id+"\" type=\"button\" class=\"btn btn-primary book-btn\">Book</button></td>")
        row.append(actions.cloneNode(true));
        $("#flight_list").append(row);
    }
    //Load in flights
    $.ajax({
        url:'api/api_flight/get_flights.php',
        method:'get',
        dataType:'json',
        contentType:"application/json",
        success: function(response) {
            response.forEach(append_flight)
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error loading flights');
          }
    })
    $("#search").on("click",()=>{
        var time1 = $("#time").val();
        var dest = $("#dest").val();
        if(time1==""){
          $("#message").text("Please fill out correctly");
        }else{
          var data={
            time:time1,
            dst:dest
          }
          console.log(time1+"     "+dest)
          var jsonData=JSON.stringify(data);
          $.ajax({
            url:'api/api_flight/search_flights.php',
            method:'POST',
            dataType:'json',
            data: jsonData,
            contentType:"application/json",
            success: function(response) {
                $("#flight_list").empty();
                if(response.code===1){
                  $("#message").text("No Suitable flights Founded")
                }else{
                  $("#message").text("")
                  response.forEach(append_flight)
                }
                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error loading flights');
              }
          })
        }
    })

    $.ajax({
      type: "get",
      url: "api/api_ticket_type/get_ticket_types.php",
      dataType: "json",
      contentType: "application/json",
      success: function (response) {
          response.forEach((item)=>{
              var row=$("<tr></tr>")
              row.append("<td class=\"align-middle\">"+item.type_class+"</td>")
              row.append("<td class=\"align-middle\">"+item.flight_type+"</td>")
              row.append("<td class=\"align-middle\">"+item.price+"$</td>")
              row.append("<td class=\"align-middle\"><input type=\"radio\" value=\""+item.type_id+"\" name=\"btnradio\" autocomplete=\"off\"></td>")
              $("#ticket-type").append(row);
          })
      }
  })
  
})
function purchase(flight){

  $('#buyModal').modal({
    backdrop: 'static',
    keyboard: false
  });
  var id = flight.value
  $("#flight-id").text(id)
    
    
}
$("#purchase-btn").click(()=>{
  var selected_type=$("input[type=radio][name=btnradio]:checked").val();
  var id = $("#flight-id").text()
  var email= $("#email").val()
  console.log(email)
      var data={
        flight:id,
        type:selected_type,
        email:email
      }
      var jsonData=JSON.stringify(data);
      $.ajax({
        url: "api/api_ticket_purchase/api_buy_ticket.php",
        method: "POST",
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
});
