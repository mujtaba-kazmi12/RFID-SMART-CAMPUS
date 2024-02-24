<?php
include("connection.php");
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
$showalert = false;
$fill = false;
$showError = false;
if (isset($_POST['add'])) {
  $c_code = $_POST['c_code'];
  $class = $_POST['s_class'];
  $c_name = $_POST['c_name'];
  $teacher=$_POST['teachers_name'];
  $no_lec=$_POST['no_lec'];
  $c_type = $_POST['c_type'];
  $room=$_POST['room'];
  $query = "INSERT INTO `subject_table` (`class_ID`,`course_code`,`course_name`,`course_type`,`no_of_lec`,`teacher_ID`,`room_ID`) VALUES ('$class','$c_code','$c_name','$c_type','$no_lec','$teacher','$room')";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $showalert = true;
  } else {
    $showError = true;
  }
}

if (isset($_GET['delid'])) {
  $delid = $_GET['delid'];
  $sql = "DELETE FROM `subject_table` WHERE id='$delid'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location:tt-subjects.php");
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
  <form action="tt-subjects.php" method="POST">
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
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
            Subjects</button>
        </div>

        <!-- Modal  for adding subject -->
        <div class="modal custom-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subjects</h1>
              </div>
              <div class="modal-body">

                <div class="row">
                  <div class="col">
                    <label for="">Course Code</label><br>
                    <input type="text" class="form-control" placeholder="ENG-121" name="c_code">
                  </div>

                  <div class="col">
                    <label for="">Class</label><br>
                    <select name="s_class" id="s_class" class="form-select">
                      <option selected disabled>Choose Class</option>
                      <?php
                      $sql = "SELECT class_table.id,class_table.class_name FROM detail_table INNER JOIN class_table
                      ON detail_table.class_ID=class_table.id";
                      $result = mysqli_query($conn, $sql);
                      while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['class_name']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col">
                    <label for="">Course Name</label><br>
                    <input type="text" class="form-control" placeholder="English" name="c_name"><br>
                  </div>
                  <div class="col">
                    <label for="">Assign Teachers</label>
                    <select name="teachers_name" id="" class="form-select">
                      <option value="" disabled selected>Teacher</option>
                      <?php
                      $sql = "SELECT * FROM `teacher_table`";
                      $result = mysqli_query($conn, $sql);
                      while ($run = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $run['id']; ?>"><?php echo $run['teacher_name']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div><br>

                </div>
                <div class="row">
                  <div class="col">
                    <label for="">Course Type</label><br>
                    <select name="c_type" id="c_type" class="form-select">
                      <option value="" disabled selected>Select</option>
                      <option value="Theory">Theory</option>
                      <option value="Practical">Practical</option>
                    </select>
                  </div>
                  <div class="col">
                    <label for="">Select Room</label>
                    <select name="room" id="" class="form-select">
                      <option value="" disabled selected>Room No</option>
                      <?php
                      $sql = "SELECT * FROM `room_table`";
                      $result = mysqli_query($conn, $sql);
                      while ($run = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $run['id']; ?>"><?php echo $run['room_no']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="" class="form-label">No of Lectures</label>
                    <input type="text" class="form-control" name="no_lec" placeholder="3" required>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="add" value="ADD">
              </div>
            </div>
          </div>
        </div>
        <!-- modal Close -->

        <div class="caption">
          <h3>Subjects Information</h3>
        </div>
        <div class="table-info">
          <table>
            <thead class="t-head">
              <tr>
                <th>Sr#</th>
                <th>Class</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Course Type</th>
                <th>No of Lectures</th>
                <th>Teacher ID</th>
                <th>Room No</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t_body">
            </tbody>
          </table>
        </div>
        <table>
          <th>

          </th>
        </table>
      </div>

      <div class="sidebar">


      </div>
    </div>
  </form>

  <script src="js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>
  <script>
    $(document).ready(function () {
      $("#s_class").change(function () {
        var cl = $('#s_class').val();
        console.log(cl);
      });
      load_data();
    });

    function load_data() {
      var subjects = "subjects";
      $.ajax({
        url: "action.php",
        method: "POST",
        data: { action: subjects },
        success: function (data) {
          $("#t_body").html(data);
        }
      });
    }
  </script>
</body>

</html>