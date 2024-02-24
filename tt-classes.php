<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
$showalert = false;
$fill = false;
$showError = false;


// Add button to add department and classes
if (isset($_POST['add'])) {
  $dept = $_POST['s_dept'];
  $class = $_POST['s_class'];

  if ($dept == "" || $class == "") {
    $fill = true;
  } else {
    $sql = "INSERT INTO `detail_table` (`department_ID`,`class_ID`) VALUES ('$dept','$class')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
      $showalert = true;
    } else {
      $showError = true;
    }
  }
}

// To delete row from table
if (isset($_GET['delid'])) {
  $delid = $_GET['delid'];
  $sql = "DELETE FROM `detail_table` WHERE id='$delid'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $sql2="DELETE FROM `class_schedule WHERE id='$delid'`";
    $result2=mysqli_query($conn,$sql2);
    if($result2){
      header("location:tt-classes.php");
    }
  }
}

// Save schedule of classes
if (isset($_POST['save'])) {
  if (isset($_POST['availability'])) {
    $class_ID = $_POST['class_ID'];
    $availability = $_POST['availability'];
    $string = implode($availability);
    $count = strlen($string);


    if ($class_ID == "" || $availability == "") {
      $fill = true;
    } else {

      // Check whether class_ID exists or not
      $existSql = "SELECT * FROM `class_schedule` WHERE `class_ID`='$class_ID'";
      $existResult = mysqli_query($conn, $existSql);
      $existRows = mysqli_num_rows($existResult);
      if ($existRows > 0) {
        $del = "DELETE FROM `class_schedule` WHERE `class_ID`='$class_ID'";
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

          $sql = "INSERT INTO `class_schedule` (`class_ID`,`day_ID`,`lec_ID`,`slot`) VALUES ('$class_ID','$second','$first','available')";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $showalert = true;
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
  <form action="tt-classes.php" method="POST">
    <header class="header">
      <div class="logo">
        <a href="#">SUS</a>
        <div class="search_box">
          <input type="text" placeholder="Search">
          <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
    </header>
    <!-- alert -->
    <?php
    if ($showalert) {
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
            <li><a href="tt-generate.php">Generate Timetable</a></li>
          </ul>
        </div>
        <div class="add">
          <button button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#classModal">Add</button>
          <button type='button' name='check' class='btn' data-bs-toggle='modal' data-bs-target='#schedule'>
            Classes Schedule
          </button>
        </div>

        <!-- Modal Add Class -->
        <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Class</h1>
              </div>
              <div class="modal-body">
                <label for="">Department</label><br>
                <select name="s_dept" id="s_dept" class="form-control">
                  <option selected disabled>Select Department</option>
                  <?php
                  $query = "SELECT * FROM `department`";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>

                  <?php
                  }
                  ?>
                </select><br>
                <label for="">Class Name</label><br>
                <select name="s_class" id="s_class" class="form-control">
                  <option selected disabled>Choose Class</option>
                </select><br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="ADD" name="add">
              </div>
            </div>
          </div>
        </div>

        <div class="caption">
          <h3>Classes Information</h3>
        </div>
        <div class="table-info">
          <table>
            <thead class="t-head">
              <tr>
                <th>#</th>
                <th>Department</th>
                <th>Class Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t_body">
            </tbody>
          </table>
        </div>
      </div>

      <!-- classes schedule -->`
      <div class="modal custom-modal fade" id="schedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class='modal-title fs-5' id='exampleModalLabel'>Schedule</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col">
                  <label for="" class="form-label">Choose Class for schedule:</label>
                  <select name="class_ID" id="class_abc" class="form-select">
                    <option value="" disabled selected>Choose</option>
                    <?php
                    $sql = "SELECT detail_table.class_ID, class_table.class_name FROM detail_table INNER JOIN department ON detail_table.department_ID=department.dept_id INNER JOIN class_table ON detail_table.class_ID=class_table.id";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['class_ID'] . "'>" . $row['class_name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                </div>
              </div>
              <table class="table">
                <thead>
                  <?php
                  $query = "SELECT * FROM `days-lec_table`";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $d = $row['days'];
                  }
                  $sql = "SELECT * FROM `schedule_table` LIMIT $d";
                  $run = mysqli_query($conn, $sql);
                  echo "<tr>";
                  echo "<th>Time/Schedule</th>";
                  while ($row = mysqli_fetch_assoc($run)) {
                    echo "<th>" . $row['days'] . "</th>";
                  }
                  echo "</tr>";
                  ?>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM `days-lec_table`";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $d = $row['days'];
                    $l = $row['lectures'];
                  }
                  $sql = "SELECT * FROM `schedule_table` LIMIT $l";
                  $run = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($run)) {
                    echo "<tr>
                    <td>" . $row['lectures_time'] . "</td>";
                    for ($r = 1; $r <= $d; $r++) {
                      echo "<td name='lec_time'><input class='form-check-input' type='checkbox' name='availability[]' value='" . $row['id'], $r . "' id='flexCheckChecked'></td>";
                    }
                    echo "</tr>";
                  }
                  ?>
                </tbody>

              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="save">Save changes</button>
            </div>
          </div>
        </div>
      </div>`
      <div class="sidebar">


      </div>
    </div>
  </form>
  <script src="js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>
  <script>
    $(document).ready(function() {
      $("#class_abc").change(function() {
        var abc = $("#class_abc").val();
        console.log(abc);
      });
      // Function for class name
      $("#s_dept").change(function() {
        var x = $("#s_dept").val();
        console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?class_table=" + x, false);
        xmlhttp.send(null);
        $("#s_class").html(xmlhttp.responseText);
      });
      load_data();
    });


    // function to display data in table
    function load_data() {
      var action = "load";
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          action: action
        },
        success: function(data) {
          $('#t_body').html(data);
        }
      });
    }
  </script>

</body>

</html>