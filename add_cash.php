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
        $card_no = $_POST['card_no'];
        $amount = $_POST['amount'];
        // Taking previous amount of card from database
        $existAmount = "SELECT `card_amount` FROM `account_table` WHERE `account_no`='$card_no'";
        $run = mysqli_query($conn, $existAmount);
        $num = mysqli_num_rows($run);
        if ($num == 1) {
            $row = mysqli_fetch_assoc($run);
            $pre_amount = implode($row);
            // Adding the new value in previous value
            $total = $amount + $pre_amount;
            $sql = "UPDATE `account_table` SET `card_amount`='$total' WHERE `account_no`='$card_no'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                $show = "Amount has been inserted";
            } else {
                $showError = true;
                $show = "Query Failed";
            }
        } else {
            $showError = true;
            $show = "No Record found";
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
    <form action="add_cash.php" method="POST">
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
                    <h3>Deposit Cash</h3>
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
                                    <label for="" class="form-label">Card No:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="card_no" id="searchbox">
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" value="Search" class="btn btn-primary" id="searchdata" name="submit">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Name:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Roll No:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="rollno" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Email:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Previous Balance:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="balance" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Enter Amount:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="amount" required>
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
	// var barcodeInput = $('#searchbox');

	// $(document).on('keypress', function (event) {
	// 	// // Check if the barcodeInput is not focused
	// 	if (!barcodeInput.is(":focus")) {
	// 		barcodeInput.val(barcodeInput.val() + event.key);
	// 		fetch(barcodeInput);
	// 		return false;
	// 	}

	// });
            $('#searchdata').click(function(e) {
                e.preventDefault();
                var id = $("#searchbox").val();
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: {
                        "search_btn_post": 1,
                        "id": id,
                    },
                    dataType: "Text",
                    success: function(response) {
                        try {
                            $.each(JSON.parse(response), function(key, value) {
                                $("#name").val(value['name']);
                                $("#rollno").val(value['rollno']);
                                $("#email").val(value['email']);
                                $("#balance").val(value['card_amount']);
                            });
                        } catch (e) {
                            alert('Not found');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
