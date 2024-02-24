<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
} else {

    $showAlert = false;
    $showError = false;
    if (isset($_POST['add'])) {
        $rollno = $_POST['rollno'];
        $card_no = $_POST['card_no'];
        // Taking id from student table
        $stu_id = mysqli_query($conn, "SELECT id FROM `student_table` WHERE rollno='$rollno'");
        $id = mysqli_fetch_assoc($stu_id);
        // Converting array into string
        $s_id = implode($id);

        // Checking whether Id already exists: IF Yes:
        $existSql = "SELECT * FROM `account_table` WHERE `student_id`='$s_id'";
        $exists = mysqli_query($conn, $existSql);
        $num = mysqli_num_rows($exists);
        if ($num > 0) {
            $showError = true;
            $show = "Account already exists";
        }
        // IF Not then it will insert data in database:
        else {
            $sql = "INSERT INTO `account_table` (`student_id`,`account_no`) VALUES('$s_id','$card_no')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            } else {
                $showError = true;
                $show = "Data is not submitted due to some error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Accounts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/account.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
    <!-- navbar -->
    <form action="add_card.php" method="POST">
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

        <div class="s_container">
            <nav>
                <!-- sidebar -->
                <div class="side_navbar">
                    <span>Main Menu</span>
                    <a href="a_dashboard.php">Dashboard</a>
                    <a href="all_card.php" class="active">Billing</a>

                    <div class="links">
                        <span>User Menu</span>
                        <a href="#">Profile</a>
                        <a href="#">Change Password</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="main-body">
                <h2>Accounts</h2>
                <div class="promo_card">
                    <ul>
                        <li><a href="all_card.php">All Cards</a></li>
                        <li><a href="add_card.php">Add Card</a></li>
                        <li><a href="add_cash.php">Deposit Cash</a></li>
                    </ul>
                </div>

                <div class="caption">
                    <h3>Add Cards</h3>
                </div>
                <div class="table-info">
                    <div class="row">
                        <div class="col-md justify-content-center">
                            <div class="row">
                                <div class="col-md text-center">
                                    <h2>Student Information</h2>
                                </div>
                            </div>
                            <hr>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Roll No:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="rollno" id="box">
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" value="Search" class="btn btn-primary" id="search" name="submit">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Name:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" disabled>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Email:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email" disabled>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Phone Number:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="pno" disabled>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Assign Card Number:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="card_no" id="card_no" required>
                                </div>
                            </div>
                            <div class="row my-5">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-danger" name="add" style="width: 153%;">
                                </div>
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
	// To load student details according to card number
	var barcodeInput = $('#card_no');

            $('#search').click(function(e) {
                e.preventDefault();
                var id = $("#box").val();
                // console.log(id);
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: {
                        "search_btn": true,
                        "id": id,
                    },
                    dataType: "Text",
                    success: function(response) {
                        $.each(JSON.parse(response), function(key, value) {
                            $("#name").val(value['name']);
                            $("#email").val(value['email']);
                            $("#pno").val(value['pno']);
                        });
                    }

                });
            });
        });
    </script>
</body>

</html>
