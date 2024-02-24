<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
// To Accept student enrollment from table
if (isset($_GET['upid'])) {
    $upid = $_GET['upid'];
    $sql = "UPDATE `enrollment_table` SET status='Approved' WHERE id='$upid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location:a_enrollment.php");
      }
    }
if (isset($_GET['delid'])) {
    $delid = $_GET['delid'];
    $sql = "DELETE FROM `enrollment_table` WHERE id='$delid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql2="DELETE FROM `student_table` WHERE id='$delid'";
        $result2=mysqli_query($conn,$result2);
        if($result2){
            header("location:a_enrollment.php");
        }

      }
    }
  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Enrollment System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/timetable-gen.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
    <!-- navbar -->
    <form action="a_enrollment.php" method="POST">
        <header class="header">
            <div class="logo">
                <a href="#">SUS</a>
                <div class="search_box">
                    <input type="text" placeholder="Search">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
        </header>
        <div class="s_container">
            <nav>
                <!-- sidebar -->
                <div class="side_navbar">
                    <span>Main Menu</span>
                    <a href="man_dashboard.php">Dashboard</a>
                    <a href="dt-classes.php">Date Sheet Generator</a>
                    <!-- <a href="billing.php">Billing</a> -->
                    <a href="a_enrollment.php" class="active">Enrollment</a>

                    <div class="links">
                        <span>User Menu</span>
                        <a href="#">Profile</a>
                        <a href="#">Change Password</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="main-body" style="width: 88%; padding-right: 10px;">
                <h2>Enrollment System</h2>


                <div class="caption">
                    <h3>Student Request</h3>
                </div>
                <div class="table-info" style="padding: 0.5rem 0.5rem 1rem 0.5rem;">
                    <table>
                        <thead class="t-head">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Rollno</th>
                                <th>Email</th>
                                <th>Degree</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="response">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- <div class="sidebar" style="width: 6%;"> </div> -->
        </div>
    </form>
  <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            load_data();
        });


        // function to display data in table
        function load_data() {
            var enrollment = "enrollment";
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    action: enrollment
                },
                success: function(data) {
                    $('#response').html(data);
                }
            });
        }
    </script>
</body>

</html>
