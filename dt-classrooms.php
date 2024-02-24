<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}

$showAlert = false;
$showError = false;
if (isset($_POST['add'])) {
    $room_no = $_POST['room_no'];
    $rows = $_POST['rows'];
    $columns = $_POST['columns'];
    $existSql = "SELECT * FROM `dt_room` WHERE room_no='$room_no'";
    $existResult = mysqli_query($conn, $existSql);
    $num = mysqli_num_rows($existResult);
    if ($num == 1) {
        $showError = true;
        $show = "Already exist";
    } else {
        $sql = "INSERT INTO `dt_room` (`room_no`,`n_row`,`columns`) VALUES ('$room_no','$rows','$columns')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
            $show = "Room inserted";
        }
    }
}
// To delete row from table
if (isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM `dt_room` WHERE id='$delid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location:dt-classrooms.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Date Sheet Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/timetable-gen.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
  <!-- navbar -->
  <form action="dt-classrooms.php" method="POST">
    <header class="header">
      <div class="logo">
        <a href="#">SUS</a>
        <div class="search_box">
          <input type="text" placeholder="Search">
          <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
    </header>
    <?php
if ($showAlert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Congratulations!</strong>' . $show . '.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
if ($showError) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sorry!</strong>' . $show . '.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>
    <div class="s_container">
      <nav>
        <!-- sidebar -->
        <div class="side_navbar">
          <span>Main Menu</span>
          <a href="man_dashboard.php">Dashboard</a>
          <a href="dt-classrooms.php" class="active">Date Sheet Generator</a>
          <a href="a_enrollment.php">Enrollment</a>

          <div class="links">
            <span>User Menu</span>
            <a href="#">Profile</a>
            <a href="#">Change Password</a>
            <a href="logout.php">Logout</a>
          </div>
        </div>
      </nav>

      <div class="main-body">
        <h2>Date Sheet Generator</h2>
        <div class="promo_card">
          <ul>
            <!-- <li><a href="tt-file.php">File</a></li> -->
            <li><a href="dt-classrooms.php">Class Rooms</a></li>
            <li><a href="dt-classes.php">Classes</a></li>
            <!-- <li><a href="dt-designrooms.php">Design Rooms</a></li> -->
            <!-- <li><a href="dt-subjects.php">Subjects</a></li> -->
            <li><a href="dt-generate.php">Generate Date Sheet</a></li>
          </ul>
        </div>
        <div class="add">
          <button button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#classModal">Add</button>
        </div>

        <!-- Modal Add Class -->
        <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Class</h1>
              </div>
              <div class="modal-body">
                <label>Room No:</label><br>
                <input type="text" class="form-control" name="room_no">
                <label>Total Rows:</label><br>
                <input type="number" class="form-control" name="rows">
                <label>Total Columns:</label><br>
                <input type="number" class="form-control" name="columns">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="ADD" name="add">
              </div>
            </div>
          </div>
        </div>
        <div class="caption">
          <h3>Rooms Information</h3>
        </div>
        <div class="table-info">
          <table>
            <thead class="t-head">
              <tr>
                <th>#</th>
                <th>Room No</th>
                <th>Total Rows</th>
                <th>Total Columns</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t_body">
            </tbody>
          </table>
        </div>
      </div>

      <div class="sidebar">


      </div>
    </div>
  </form>
  <script src="js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.js"></script>
  <script>
    $(document).ready(function(){
      load_data();
    });
    function load_data() {
      var room_no = "room_no";
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          action: room_no
        },
        success: function(data) {
          $("#t_body").html(data);
        }
      });
    }
  </script>
</body>

</html>