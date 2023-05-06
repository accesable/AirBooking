$(document).ready(function () {
  function append_flight(item){           
      var actions= $(".actions")[0]
      var row= $("<tr></tr>");
      row.append("<td class=\"align-middle\">"+item.flight_id+"</td>")
      row.append("<td class=\"align-middle\">"+item.starting_location+"</td>")
      row.append("<td class=\"align-middle\">"+item.destination+"</td>")
      row.append("<td class=\"align-middle\">"+item.flight_time+"</td>")
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
          $("#total_flights strong").text(response.length);
          response.forEach(append_flight)
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error loading flights');
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
      url: 'api/api_flight/delete_flight.php?id=' + id,
      method: 'DELETE',
      dataType: 'json',
      contentType: "application/json",
      success: function(response) {
        if(response.code === 0) {
          alert("flight id "+id+" Deleted")
        } else {
          alert("flight id "+id+" Not Deleted")
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error deleting flight');
      }
    });
  });

}
function show_add_flight(str){
  $(".modal-title > strong").text(str)
}
//show add flight
$(".add-btn").on('click',()=>{
  $('#addModal').modal({
    backdrop: 'static',
    keyboard: false
  });
  $("#add-btn").on('click',function(){
    var update_start=$("#addModal #start").val();
    var update_dst=$("#addModal #dst").val();
    var update_time=$("#addModal #time").val();
    console.log(update_start+update_dst+update_time);
    var data={
      start:update_start,
      dst:update_dst,
      time:update_time
    }
    var jsonData=JSON.stringify(data);
    $.ajax({
      url:"api/api_flight/add_flight.php",
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
  var start=row.children('td:not(:last-child)')[1].innerHTML

  $('#editModal').modal({
    backdrop: 'static',
    keyboard: false
});
  $(".modal-title > strong").text(start);
  //Ajax request API
  $("#edit-btn").on('click',function(){
    var update_start=$("#editModal #start").val();
    var update_dst=$("#editModal #dst").val();
    var update_time=$("#editModal #time").val();
    console.log(update_start+update_dst+update_time + id);
    var data={
      start:update_start,
      dst:update_dst,
      time:update_time
    }
    var jsonData=JSON.stringify(data);
    $.ajax({
      url: "api/api_flight/update_flight.php?id="+id,
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
