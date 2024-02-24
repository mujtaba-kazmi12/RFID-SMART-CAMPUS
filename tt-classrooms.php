<?php

include("connection.php");
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
$showAlert = false;
$fill = false;
$showError = false;
if (isset($_POST['add'])) {
  $room = $_POST['room'];
  if ($room == "") {
    $fill = true;
  } else {
    $sql = "INSERT INTO `room_table` (`room_no`) VALUES ('$room')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $showAlert = true;
    } else {
      $showError = true;
    }
  }
}
if(isset($_GET['delid'])){
  $delid=$_GET['delid'];
  $sql="DELETE FROM `room_table` WHERE id='$delid'";
  $result=mysqli_query($conn,$sql);
  if($result){
    header("location:tt-classrooms.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Timetable Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/timetable-gen.css" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
  <form action="tt-classrooms.php" method="POST">
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
          <strong>Congratulations!</strong>Data has been submitted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  }
  if ($fill) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>!</strong>Please fill all fields.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  }
  if ($showError) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sorry!</strong>Data is not submitted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  }

  ?>
  <div class="s_container">
    <nav>
      <div class="side_navbar">
        <span>Main Menu</span>
        <a href="a_dashboard.php">Dashboard</a>
        <a href="tt-time.php" class="active">Timetable Generator</a>

        <div class="links">
          <span>User Menu</span>
          <a href="#">Profile</a>
          <a href="#">Change Password</a>
          <a href="logout.php">Logout</a>
        </div>
      </div>
    </nav>

    <div class="main-body">
      <h2>Timetable Generator</h2>
      <div class="promo_card">
        <ul>
          <li><a href="tt-time.php">Days/Lectures</a></li>
          <li><a href="tt-classes.php">Classes</a></li>
          <li><a href="tt-teachers.php">Teachers</a></li>
          <li><a href="tt-classrooms.php">Class Rooms</a></li>
          <li><a href="tt-subjects.php">Subjects</a></li>
          <!-- <li>
            <div class="dropdown">
              <button class="dropbtn">Allotment</button>
              <div class="dropdown-content">
                <a href="tt-allotcourses.php">Allotment</a>
                <a href="tt-allotlab.html">Practical Labs</a>
                <a href="tt-allotrooms.html">Class Rooms</a>
              </div>
            </div>
          </li> -->
          <li><a href="tt-generate.php">Generate Timetable</a></li>
        </ul>
      </div>
      <div class="add">
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
          Classrooms</button>
      </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Classroom</h1>
            </div>
            <div class="modal-body">
              <label for="">Room No:</label><br>
              <input type="text" class="form-control" name="room">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" name="add" value="ADD">
            </div>
          </div>
        </div>
      </div>
      <div class="caption">
        <h3>Room Information</h3>
      </div>
      <div class="table-info">
        <table>
          <thead class="t-head">
            <tr>
              <th>Room No:</th>
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
  </form>
  </div>
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="js/jquery.js"></script>
    <script>
      $(document).ready(function(){
        load_classrooms();

      });
      function load_classrooms(){
        var classrooms="classrooms";
        $.ajax({
          url:"action.php",
          method:"POST",
          data:{action: classrooms},
          success:function (data){
            $("#t_body").html(data);
          }
        });
      }
    </script>
</body>

</html>