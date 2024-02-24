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
  $s_dept = $_POST['s_dept'];
  $s_class = $_POST['s_class'];
  $subject = $_POST['subject'];
  $existSql = "SELECT * FROM `dt_class` WHERE dept_ID='$s_dept' AND class_ID='$s_class'";
  $existResult = mysqli_query($conn, $existSql);
  $num = mysqli_num_rows($existResult);
  if ($num == 1) {
    $showError = true;
    $show = "Class already exists";
  } else {
    $sql = "INSERT INTO dt_class (dept_ID,class_ID,subject) VALUES ('$s_dept','$s_class','$subject')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $showAlert = true;
      $show = "Class inserted";
    } else {
      $showError = true;
      $show = "Insertion Failed";
    }
  }
}

if (isset($_GET['delid'])) {
  $delid = $_GET['delid'];
  $sql = "DELETE FROM `dt_class` WHERE id='$delid'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location:dt-classes.php");
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
  <form action="dt-classes.php" method="POST">
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
                <label for="">Department</label><br>
                <select name="s_dept" id="dept" class="form-control">
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
                <select name="s_class" id="class" class="form-control">
                  <option selected disabled>Choose Class</option>
                </select><br>
                <label class="form-label">Assign Subject:</label>
                <input type="text" class="form-control" name="subject">
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
            <thead">
              <tr>
                <th>#</th>
                <th>Department</th>
                <th>Class Name</th>
                <th>Subject</th>
                <th>Students</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody id="t_body">
                <?php
                $sql = "SELECT dt_class.id,dt_class.class_ID,dt_class.subject,department.dept_name,class_table.class_name FROM `dt_class` INNER JOIN
                       department ON dt_class.dept_ID=department.dept_id INNER JOIN class_table
              ON dt_class.class_ID=class_table.id";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr id='" . $row['class_ID'] . "'>
                          <td>" . $row['id'] . "</td>
                          <td>" . $row['dept_name'] . "</td>
                          <td>" . $row['class_name'] . "</td>
                          <td>" . $row['subject'] . "</td>
                          <td>
                          <a class='btn btn-primary view_btn' data-bs-toggle='modal' data-bs-target='#studentModal'>Check</a>
                          </td>
                          <td>
                          <button type='button' class='btn btn-danger'><a href='dt-classes.php?delid=$row[id]' style='text-decoration: none; color: white;'>Delete</a></button>
                          </td>
                        </tr>";
                  }
                }
                ?>
              </tbody>
          </table>
        </div>


        <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Class</h1>
              </div>
              <div class="modal-body">
                <table>
                  <thead>
                    <tr>
                      <td>Name</td>
                      <td>Rollno</td>
                    </tr>
                  <tbody id="tbody"></tbody>
                  </thead>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="ADD" name="add">
              </div>
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
    $(document).ready(function() {
      $("#dept").change(function() {
        var x = $("#dept").val();
        console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?class_table=" + x, false);
        xmlhttp.send(null);
        $("#class").html(xmlhttp.responseText);
      });
      $(".view_btn").click(function(e) {
        e.preventDefault();
        var c_id = $(this).closest('tr').attr('id');
        // console.log(c_id);

       $.ajax({
        type: "POST",
        url: "action.php",
        data: {
          'check_btn':true,
          'c_id':c_id,
        },
        success: function (response) {
          $("#tbody").html(response);
        }
       });
      });
      // load_data();
    });

    
  </script>
</body>

</html>