<?php
include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/account.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
    <!-- navbar -->
    <form action="add_user.php" method="POST">
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
                    <a href="admin.php">Dashboard</a>
                    <a href="all_users.php" class="active">All Users</a>
                    <a href="add_user.php" class="active">Add User</a>

                    <div class="links">
                        <span>User Menu</span>
                        <a href="#">Profile</a>
                        <a href="#">Change Password</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="main-body">
                <h2>Users</h2>
                <!-- <div class="promo_card">
                    <ul>
                        <li><a href="all_card.php">All Cards</a></li>
                        <li><a href="add_card.php">Add Card</a></li>
                        <li><a href="add_cash.php">Deposit Cash</a></li>
                    </ul>
                </div> -->

                <div class="caption">
                    <h3>Add User</h3>
                </div>
                <div class="table-info">
                    <div class="row">
                        <div class="col-md justify-content-center">
                            <div class="row">
                                <div class="col-md text-center">
                                    <h2>User Information</h2>
                                </div>
                            </div>
                            <hr>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Name:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name">
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label for="" class="form-label">Rollno:</label>
                                    </div>
                                    <div class="col-md-6">
                                    <input type="text" class="form-control" name="rollno" id="box">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Email:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Role:</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="role" id="role" class="form-select">
                                        <option disabled selected>Select Role</option>
                                        <option value="management">Management</option>
                                        <option value="account">Accounts</option>
                                        <option value="cafe">Cafe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Assign Password:</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="passowrd" id="password" required>
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
</body>

</html>
