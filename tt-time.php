<?php

include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
$showAlert = false;
$showError = false;
$fill = false;

// Modal Add Button to add days and lectures in db
if (isset($_POST['add'])) {
    $days = $_POST['days'];
    $lectures = $_POST['lectures'];

    if ($days == "" || $lectures == "") {
        $fill = true;
    } else {
        $existSql = "SELECT * FROM `days-lec_table`";
        $result1 = mysqli_query($conn, $existSql);
        if (mysqli_num_rows($result1) > 0) {
            $sql = "UPDATE `days-lec_table` SET `days`='$days', `lectures`='$lectures' WHERE `id`=1";
            $result2 = mysqli_query($conn, $sql);
        } else {
            $query = "INSERT INTO `days-lec_table` (`days`,`lectures`) VALUES ('$days', '$lectures')";
            $result2 = mysqli_query($conn, $query);
        }
        if ($result2) {
            $showAlert = true;
        } else {
            $showError = true;
        }
    }
}

if (isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM `days-lec_table` WHERE id='$delid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql = "DELETE FROM `detail_table`";
        $run = mysqli_query($conn, $sql);
        if ($run) {
            $query = "DELETE FROM teacher_table";
            $res = mysqli_query($conn, $query);
            if ($res) {
                $sql2 = "DELETE FROM room_table";
                $r = mysqli_query($conn, $sql2);
                if ($r) {
                    $sql3 = "DELETE FROM teacher_table";
                    $re = mysqli_query($conn, $sql3);
                    if ($re) {
                        $sql4 = "DELETE FROM class_schedule";
                        $run1 = mysqli_query($conn, $sql4);
                        if ($run1) {
                            $timetable = "DELETE FROM timetable";
                            $timeResult = mysqli_query($conn, $timetable);
                            if ($timeResult) {
                                header("location:tt-time.php");
                            }
                        }
                    }
                }
            }
        }

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
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
  <!-- navbar -->
  <form action="tt-time.php" method="POST">
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
//Alert
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

<!-- Overall Container -->
    <div class="s_container">
      <nav>
        <!-- sidebar -->
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

      <!-- Page Center -->
      <div class="main-body">
        <h2>Timetable Generator</h2>
        <div class="promo_card">
          <ul>
            <li><a href="tt-time.php">Days/Lectures</a></li>
            <li><a href="tt-classes.php">Classes</a></li>
            <li><a href="tt-teachers.php">Teachers</a></li>
            <li><a href="tt-classrooms.php">Class Rooms</a></li>
            <li><a href="tt-subjects.php">Subjects</a></li>
            <li><a href="tt-generate.php">Generate Timetable</a></li>
          </ul>
        </div>

        <!-- Modal button to add schedule -->
        <div class="add">
          <button button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#classModal">Add</button>
        </div>

        <!-- Modal to add schedule -->
        <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
              </div>
              <div class="modal-body">
                <label for="">Number of Days:</label>
                <select class="form-select" name="days" id="No-days" aria-label="Default select example">
                  <option selected>Select Days</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select><br>
                <label for="">Lecture Per Day:</label>
                <select class="form-select" name="lectures" id="lectures" aria-label="Default select example">
                  <option selected>Select number of lectures</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select><br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="ADD" name="add">
              </div>
            </div>
          </div>
        </div>

        <!-- heading above table -->
        <div class="caption">
          <h3>Schedule Information</h3>
        </div>

        <!-- table to display info -->
        <div class="table-info">
          <table>
            <thead class="t-head">
              <tr>
                <th>No of Days</th>
                <th>No of Lectures</th>
                <th>Days Schedule</th>
                <th>Lectures Schedule</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t_body">
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Day schedule -->
      <div class="modal fade" id="dayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">No.</th>
                    <th scope="col">Days</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$query = "SELECT * FROM `days-lec_table`";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $d = $row['days'];
}
$sql = "SELECT * FROM `schedule_table` LIMIT $d";
$run = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($run)) {
    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['days'] . "</td>
                      </tr>";
}
?>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Lectures schedule -->
      <div class="modal fade" id="lectureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">Lectures</th>
                    <th scope="col">No of Lectures</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$query = "SELECT * FROM `days-lec_table`";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $l = $row['lectures'];
}
$sql = "SELECT * FROM `schedule_table` LIMIT $l";
$run = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($run)) {
    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['lectures_time'] . "</td>
                      </tr>";
}
?>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <div class="sidebar">


      </div>
    </div>
  </form>
  <script src="js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>

  <script>
    $(document).ready(function () {
      load_data();
    });

    function load_data() {
      var schedule = "schedule";
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          action: schedule
        },
        success: function (data) {
          $("#t_body").html(data);
        }

      })
    }
  </script>
</body>

</html>