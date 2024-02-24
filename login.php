<?php

include "connection.php";

$showAlert = false;
$showError = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `user_table` WHERE `email`='$email' AND `password`='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $showAlert = true;
        $row = mysqli_fetch_assoc($result); 
        if ($row['role'] == 'student') {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            $_SESSION['reg_no'] = $row['reg_no'];
            $_SESSION['email'] = $row['email'];
            header("location: s_dashboard.php");
        }
        if ($row['role'] == 'teacher') {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            header("location: a_dashboard.php");
        }
        if ($row['role'] == 'account') {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            header("location: account_dash.php");
        }
        if ($row['role'] == 'cafe') {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            header("location: invoice.php");
        }
        if ($row['role'] == 'management') {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            header("location: man_dashboard.php");
        }
        if ($row['role'] == 'admin') {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            header("location: admin.php");
        }
    } else {
        $showError = true;
        $show = "Invalid Credentials";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="center">
        <?php
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Congratulations!</strong>Data has been submitted.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($showError) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong>'.$show.'.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }

        ?>
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="txt_field">
                <input type="text" name="email" id="">
                <span></span>
                <label for="Email">Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" id="">
                <span></span>
                <label for="Password">Password</label>
            </div>
            <div class="pass">Forget Password</div>
            <input type="submit" name="submit">
            <div class="signup_link">
                Not a member? <a href="registration.php">Signup</a>
            </div>
        </form>
    </div>
    <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>