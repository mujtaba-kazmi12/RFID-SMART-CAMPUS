<?php
include "connection.php";
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit; 
}
$rollno=$_SESSION['reg_no'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/s_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

</head>

<body>
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
                <h1>Welcome <?php echo $_SESSION['name'];?></h1>
                <i class="fas fa-user-cog"></i>
            </div>
            <div class="main-skill">
                <div class="card">
                    <h3>Student LMS</h3>
                </div>
            </div>
            <div class="main-s_info">
                <h3>Student Info</h3>
                <div class="card">
                    <table>
                        <tbody>
                            <div class="row g-3 align-items-center ms-2">
                                <div class="col-md-2">
                                    <label for="name" class="col-form-label">Name:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="name" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="<?php echo $_SESSION['name']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="rollno" class="col-form-label">Reg No:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="rollno" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="<?php echo $_SESSION['reg_no']; ?>">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center ms-2">
                                <div class="col-md-2">
                                    <label for="email" class="col-form-label">Email:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="Email" id="email" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="<?php echo $_SESSION['email']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="pno" class="col-form-label">Phone Number:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="pno" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="">
                                </div>
                            </div>
                            <!-- <div class="row g-3 align-items-center ms-2">
                                <div class="col-md-2">
                                    <label for="dept" class="col-form-label">Department:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="dept" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="Computer Science">
                                </div>
                                <div class="col-md-3">
                                    <label for="degree" class="col-form-label">Degree:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="degree" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="BSCS">
                                </div>
                            </div> -->
                            <!-- <div class="row g-3 align-items-center ms-2">
                                <div class="col-md-2">
                                    <label for="semester" class="col-form-label">Current Semester:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="semester" class="form-control-plainetext" aria-labelledby="passwordHelpInline" value="8">
                                </div>
                            </div> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <section class="main-course">
                <h3>Enroll Courses</h3>
                <div class="Course-box">
                    <table class="table table-striped border">
                        <thead>
                            <tr>
                                <th scope="col">Course Code</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Credit Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql="SELECT * FROM `student_table` WHERE rollno='$rollno'";
                                $result=mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)==1){
                                    while($row=mysqli_fetch_assoc($result)){
                                        $id=$row['id'];
                                        $sql2="SELECT table_subject.course_code,table_subject.course_name,table_subject.credit_hours FROM `enrollment_table` INNER JOIN table_subject ON
                                        enrollment_table.subject_ID=table_subject.sem_id WHERE enrollment_table.id='$id' AND status='Approved'";
                                        $result2=mysqli_query($conn,$sql2);
                                        if($result2){
                                            if(mysqli_num_rows($result2)>0){
                                                while($row=mysqli_fetch_assoc($result2)){
                                                    echo "<tr><td>".$row['course_code']."</td>";
                                                    echo "<td>".$row['course_name']."</td>";
                                                    echo "<td>".$row['credit_hours']."</td></tr>";
                                                }
                                            }
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