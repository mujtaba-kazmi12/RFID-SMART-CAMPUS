<?php

include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
} else {
    $rollno = $_SESSION['reg_no'];
    $sql = "SELECT student_table.name,account_table.account_no,account_table.card_amount,account_table.status
    FROM `student_table` INNER JOIN account_table ON student_table.id=account_table.id
     WHERE student_table.rollno='$rollno'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            $row = mysqli_fetch_assoc($result);
            $card_status = $row['status'];
            $account_no = $row['account_no'];
            $card_amount = $row['card_amount'];
        } else {
            $card_status = "No record found";
            $account_no = "No record found";
            $card_amount = "No record found";
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
    <title>Billing</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/s_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

</head>

<body>
    <div class="s_container">
        <nav>
            <ul>
                <li><a href="#" class="logo"><i class="fas fa-dashboard"></i> <span class="nav-item">Logo</span></a>
                </li>
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
                <h1></h1>
                <i class="fas fa-user-cog"></i>
            </div>
            <div class="main-skill">
                <div class="card">
                    <h3>Student Account</h3>
                </div>
            </div>
            <div class="main-s_info">
                <h3>Account Info</h3>
                <div class="card">
                    <div class="container">
                        <div class="row my-4">
                            <div class="col-md-2">
                                <label for="" class="form-label">Name:</label>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label"><?php echo $_SESSION['name']; ?></label>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="form-label">Card Status:</label>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label"><?php echo $card_status; ?></label>
                            </div>
                        </div>
                        <hr>
                        <div class="row my-4">
                            <div class="col-md-2">
                                <label for="" class="form-label">Account Number:</label>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label"><?php echo $account_no; ?></label>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="form-label">Amount:</label>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label"><?php echo $card_amount; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="main-course">
                <h3>Transaction History</h3>
                <div class="Course-box">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Amount Spend</th>
                                <th scope="col">Date Time</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
$sql = "SELECT * FROM `total_invoices` WHERE customer_account='$account_no'";
$run = mysqli_query($conn, $sql);
if ($run) {
    $num_rows = mysqli_num_rows($run);
    if ($num_rows > 0) {
        while ($fetch_row = mysqli_fetch_assoc($run)) {
            echo "<tr>
                                        <td>" . $fetch_row['invoice_id'] . "</td>
                                        <td>" . $fetch_row['total_amount'] . "</td>
                                        <td>" . $fetch_row['time'] . "</td>
                                        </tr>";
        }
    }
}
?>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </div>
<script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>