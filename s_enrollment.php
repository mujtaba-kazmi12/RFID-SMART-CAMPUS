<?php

include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
} else {
    $showAlert = false;
    $showError = false;

    $name = $_SESSION['name'];
    $rollno = $_SESSION['reg_no'];
    $email = $_SESSION['email'];

    if (isset($_POST['submit'])) {
        $pno = $_POST['pno'];
        $dept = $_POST['dept'];
        $degree = $_POST['degree'];
        $sem = $_POST['semester'];
        $subject_ID = $sem;

        // Getting id from student table to check whether the request already exist or not
        $existSql = "SELECT id FROM `student_table` WHERE `rollno`='$rollno' AND `email`='$email'";
        $run = mysqli_query($conn, $existSql);
        $row = mysqli_fetch_assoc($run);
        $id = $row['id'];
        // Now checking if the id already exists in enrollment table or not
        $checksql = "SELECT * FROM `enrollment_table` WHERE id='$id'";
        $checkresult = mysqli_query($conn, $checksql);
        $num = mysqli_num_rows($checkresult);
        if ($num == 1) {
            $showError = true;
            $show = "You have already submitted your request.";
        } else {
            $sql = "INSERT INTO `student_table` (`name`,`rollno`,`email`,`pno`)
      VALUES ('$name','$rollno','$email','$pno')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $sql2 = "INSERT INTO `enrollment_table` (`department_ID`,`degree_ID`,`sem_ID`,`subject_ID`)
        VALUES ('$dept','$degree','$sem','$subject_ID')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result2) {
                    $showAlert = true;
                    $show = "Your request has been submitted";
                }
            } else {
                $showError = true;
                $show = mysqli_error($conn);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enrollment</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/s_enrollment.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

</head>

<body>
  <?php
if ($showAlert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Congratulations!</strong>' . $show . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
if ($showError) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> ' . $show . ' .
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>

  <div class="s_container">
    <nav>
      <ul>
        <li><a href="#" class="logo"><i class="fas fa-dashboard"></i> <span class="nav-item">Logo</span></a></li>
        <li><a href="s_dashboard.php"><i class="fas fa-dashboard"></i> <span class="nav-item">Dashboard</span></a></li>
        <li><a href=""><i class="fas fa-user"></i> <span class="nav-item">Profile</span></a></li>
        <li><a href="s_billing.php"><i class="fas fa-wallet"></i> <span class="nav-item">Billing</span></a></li>
        <li><a href="s_enrollment.php"><i class="fas fa-chart-bar"></i> <span class="nav-item">Enrollment</span></a></li>
        <li><a href=""><i class="fas fa-cog"></i> <span class="nav-item">Settings</span></a></li>
        <li><a href=""><i class="fas fa-question-circle"></i> <span class="nav-item">Help</span></a></li>
        <li><a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> <span class="nav-item">Logout</span></a></li>
      </ul>
    </nav>
    <section class="main">
      <div class="main-top">
        <i class="fas fa-user-cog"></i>
      </div>
      <div class="main-skill">
        <div class="card">
          <h3>Enrollment Form</h3>
        </div>
      </div>

      <div id="container_2">

        <form id="survey-form" method="POST">

          <!-- Student Name and Registration No -->
          <div class="row my-2">
            <div class="col-md-6">
              <label for="" class="form-label">Student Name:</label>
              <input type="text" class="form-control" placeholder="Name" name="s_name" value="<?php echo $name; ?>" disabled>
            </div>
            <div class="col-md-6">
              <label for="" class="form-label">Registration No:</label>
              <input type="text" class="form-control" placeholder="Reg#" name="rollno" value="<?php echo $rollno; ?>" disabled>
            </div>
          </div>

          <!-- Email and Number -->
          <div class="row my-2">
            <div class="col-md-6">
              <label for="" class="form-label">Email:</label>
              <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" disabled>
            </div>
            <div class="col-md-6">
              <label for="" class="form-label">Phone Number:</label>
              <input type="text" class="form-control" placeholder="0321-4567890" name="pno" required>
            </div>
          </div>

          <div class="row my-2">
            <div class="col-md">
              <label for="" class="form-label">Select Department:</label>
              <select name="dept" id="dept" class="form-select" required>
                <option value="" disabled selected>Choose Your department</option>
                <?php
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    ?>
                  <option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
                <?php }
?>
              </select>
            </div>
          </div>

          <div class="row my-2">
            <div class="col-md">
              <label for="" class="form-label">Select Degree:</label>
              <select name="degree" id="degree" class="form-select" required>
                <option value="" disabled selected>Choose Your Degree</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md">
              <label for="" class="form-label">Select Semester:</label>
              <select name="semester" id="semester" class="form-select" required>
                <option value="" disabled selected>Choose Your Semester</option>
              </select>
            </div>
          </div>

          <div class="row border my-4 bg-white">
            <div class="col-md">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Course Code</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Credit Hours</th>
                  </tr>
                </thead>
                <tbody id="response">
                </tbody>
              </table>
            </div>
          </div>
          <div class="row py-4">
            <div class="col-md">
              <input type="submit" class="btn btn-primary form-control" name="submit">
            </div>
          </div>
        </form><!---survey-form--->
      </div><!--container_2--->
    </section>
  </div>
<script src="js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>

  <script>
    $(document).ready(function() {
      $("#dept").change(function() {
        var x = $("#dept").val();
        console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?degree_table=" + x, false);
        xmlhttp.send(null);
        $("#degree").html(xmlhttp.responseText);
      });
      $("#degree").change(function() {
        var x = $("#degree").val();
        console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?semester_table=" + x, false);
        xmlhttp.send(null);
        $("#semester").html(xmlhttp.responseText);
      });
      $("#semester").change(function() {
        var x = $("#semester").val();
        console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?table_subject=" + x, false);
        xmlhttp.send(null);
        $("#response").html(xmlhttp.responseText);
      });
    });
  </script>
</body>

</html>