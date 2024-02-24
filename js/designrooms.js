$(document).ready(function() {
    load_data();
    $("#design_room").change(function() {
        var x = $("#design_room").val();
        console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?room_design=" + x, false);
        xmlhttp.send(null);
        $("#response").html(xmlhttp.responseText);
      });
  });

  function load_data() {
    var design = "design";
    $.ajax({
      url: "action.php",
      method: "POST",
      data: {
        action: design
      },
      success: function(data) {
        $("#t_body").html(data);
      }
    });
}
