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
    <title>Accounts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/timetable-gen.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
    <!-- navbar -->
    <form action="all_users.php" method="POST">
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
                    <a href="add_user.php" class="active">Add Users</a>

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
                <!-- <div class="promo_card">
                    <ul>
                        <li><a href="all_card.php">All Cards</a></li>
                        <li><a href="add_card.php">Add Card</a></li>
                        <li><a href="add_cash.php">Deposit Cash</a></li>
                    </ul>
                </div> -->

                <div class="caption">
                    <h3>All Users</h3>
                </div>
                <div class="table-info">
                    <table>
                        <thead class="t-head">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Roll No</th>
                            </tr>
                        </thead>
                        <?php
                            $sql="SELECT * FROM user_table";
                            $result=mysqli_query($conn,$sql);
                            if($result){
                                $num=mysqli_num_rows($result);
                                if($num>0){
                                    while($row=mysqli_fetch_assoc($result)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row['id']?></td>
                                            <td><?php echo $row['name']?></td>
                                            <td><?php echo $row['email']?></td>
                                            <td><?php echo $row['reg_no']?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        
                        ?>
                        <tbody>
                        </tbody>
                    </table>
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