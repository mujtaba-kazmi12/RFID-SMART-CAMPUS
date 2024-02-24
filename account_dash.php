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
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/dash.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
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
            <div class="side_navbar">
                <span>Main Menu</span>
                <a href="account_dash.php" class="active">Dashboard</a>
                <a href="all_card.php">Billing</a>

                <div class="links">
                    <span>User Menu</span>
                    <a href="#">Profile</a>
                    <a href="#">Change Password</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </nav>

        <div class="main-body">
            <h2>Dashboard</h2>
            <div class="promo_card">
                <h2>Welcome to Smart University System</h2>
                <span>Here you can get:</span>
            </div>

            <div class="container">
                <div class="row py-5">
                    <div class="col">
                        <div class="feature_lists">
                            <h3> <i class="fa fa-calendar"></i> Timetable Generator</h3><br>
                            <!-- <p>Generate timetable according your need.</p> -->
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature_lists">
                            <h3>
                                <i class="fa fa-calendar"></i> Date Sheet Generator
                            </h3><br>
                            <!-- <p>Genrate Date Sheet and Seating plan for students.</p> -->
                        </div>
                    </div>
                </div>
                <div class="row py-5">
                    <div class="col">
                        <div class="feature_lists">
                            <h3><i class="fa fa-money-bill"></i> Billing</h3>
                            <!-- <p>Billing system for University.</p> -->
                        </div>
                    </div>
                    <div class="col">
                        <div class="feature_lists">
                            <h3>
                                <i class="fa fa-user"></i> Enrollment
                            </h3>
                            <!-- <p>Enrollment request of students for there courses.</p> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="sidebar">


        </div>
    </div>
</body>

</html>