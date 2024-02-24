<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
$showError = false;
$showAlert = false;
$fill = false;
if (isset($_POST['add'])) {
  $dept = $_POST['s_dept'];
  $t_name = $_POST['t_name'];
  $t_ID = $_POST['t_ID'];

  if ($dept == "" || $t_name == "" || $t_ID == "") {
    $fill = true;
  } else {
    $sql = "INSERT INTO `teacher_table` (`department_ID`,`teacher_name`,`teacher_ID`) VALUES ('$dept','$t_name','$t_ID')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $showAlert = true;
    } else {
      $showError = true;
    }
  }
}

if (isset($_GET['delid'])) {
  $delid = $_GET['delid'];
  $sql = "DELETE FROM `teacher_table` WHERE id='$delid'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location:tt-teachers.php");
  }
}
if (isset($_POST['save'])) {
  if (isset($_POST['availability'])) {
    $teacher_ID = $_POST['teacher_ID'];
    $availability = $_POST['availability'];
    $string = implode($availability);
    $count = strlen($string);

    if ($teacher_ID == "" || $availability == "") {
      $fill = true;
    } else {

      // Check whether class_ID exists or not
      $existSql = "SELECT * FROM `teacher_schedule` WHERE `teacher_ID`='$teacher_ID'";
      $existResult = mysqli_query($conn, $existSql);
      $existRows = mysqli_num_rows($existResult);
      if ($existRows > 0) {
        $del = "DELETE FROM `teacher_schedule` WHERE `teacher_ID`='$teacher_ID'";
        $delResult = mysqli_query($conn, $del);
      }
      for ($i = 0; $i < $count; $i = $i + 2) {
        // echo "Class= ",$class_ID, "<br>";

        // $first is for lec_ID
        $first = $string[$i];
        // echo "First= ",$first, "<br>";
        for ($j = $i + 1; $j <= $i + 1; $j++) {
          // $second is for day_ID
          $second = $string[$j];

          $sql = "INSERT INTO `teacher_schedule` (`teacher_ID`,`day_ID`,`lec_ID`,`slot`) VALUES ('$teacher_ID','$second','$first','available')";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $showAlert = true;
          } else {
            $showError = true;
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
  <form action="tt-teachers.php" method="POST">
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
          <button button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#teacherModal">Add
            Teachers</button>
      

        </div>

        <!-- Teacher Detail modal -->
        <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Teacher</h1>
              </div>
              <div class="modal-body">
                <label for="">Department</label><br>
                <select name="s_dept" id="s_dept" class="form-select">
                  <option disabled selected>Select Department</option>
                  <?php
                  $sql = "SELECT * FROM `department`";
                  $query = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($query)) {
                  ?>
                    <option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
                  <?php
                  }
                  ?>
                </select><br>
                <label for="">Teacher Name</label><br>
                <input type="text" name="t_name" class="form-control"><br>
                <label for="">Teacher ID</label><br>
                <input type="text" name="t_ID" class="form-control"><br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="add" id="add" value="ADD" class="btn btn-primary">
              </div>
            </div>
          </div>
        </div>
        <div class="caption">
          <h3>Teachers Information</h3>
        </div>
        <div class="table-info">
          <table>
            <thead class="t-head">
              <tr>
                <th>Teacher Department</th>
                <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t-body">
            </tbody>
          </table>
        </div>
      </div>

      <!-- modal for Teacher Schedule -->
      <div class="sidebar">


      </div>
    </div>
  </form>
  <script src="bootstrap/js/bootstrap.js"></script>
<script src="js/jquery.js"></script>
  <script>
    $(document).ready(function() {
      load_data();
    });

    function load_data() {
      var teachers = "teachers";
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          action: teachers
        },
        success: function(data) {
          $("#t-body").html(data);
        }
      });
    }
  </script>
</body>

</html>