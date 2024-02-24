<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<body>
    <?php
$name = $nameErr = "";
$email = $emailErr = "";
$rollno = $rollnoErr = "";
$role = $roleErr = "";
$password = $passwordErr = "";
$cpassword = $cpasswordErr = "";
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name is valid using regular expression
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $nameErr = "<p class='text-danger'>Invalid!. Only letters and spaces are allowed.</p>";
        }
    }
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email is valid using regular expression
        // if (!preg_match("/^[a-zA-Z0-9._-]+@tuf\.edu\.pk$/", $email)) {
        //     $emailErr = "<p class='text-danger'>Invalid email address. Only email addresses with the domain 'tuf.edu.pk' are allowed.</p>";
        // }
    }
    // Validate rollno
    if (empty($_POST["rollno"])) {
        $rollnoErr = "Registration number is required";
    } else {
        $rollno = test_input($_POST["rollno"]);
        // Check if email is valid using regular expression
        if (!preg_match("/^[A-Za-z0-9\-]+$/", $rollno)) {
            $rollnoErr = "<p class='text-danger'>Invalid Registration Number. Special characters are not allowed.</p>";
        }
    }
    // Validate role
    if (empty($_POST["role"])) {
        $roleErr = "Please select any option";
    } else {
        $role = test_input($_POST["role"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        // Check if email is valid using regular expression
        // if (!preg_match("/^[A-Za-z0-9]+$/", $password)) {
        //     $passwordErr = "<p class='text-danger'>Invalid password. It must be at least 8 characters long and contain at least one letter and one digit.</p>";
        // }
    }
    // Validate Password and Confirm Password
    if (empty($_POST["cpassword"])) {
        $cpasswordErr = "Please confirm the password";
    } else {
        $cpassword = test_input($_POST["cpassword"]);

        if ($password != $cpassword) {
            $cpasswordErr = "Passwords do not match";
        }
    }

    if (empty($nameErr) && empty($emailErr) && empty($rollnoErr) && empty($roleErr) && empty($passwordErr) && empty($cpasswordErr)) {
        $rollno = strtoupper($rollno);
        // Check whether email already exists or not
        $existSql = "SELECT * FROM `user_table` WHERE `email`='$email' OR `reg_no`='$rollno'";
        $run = mysqli_query($conn, $existSql);
        $exist = mysqli_num_rows($run);

        if ($exist) {
            $showError = true;
            $show = "Already exists";
        } else {
            if ($password == $cpassword) {
                $sql = "INSERT INTO `user_table` (`name`,`email`,`reg_no`,`role`,`password`) VALUES ('$name','$email','$rollno','$role','$password')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $showAlert = true;
                } else {
                    $showError = true;
                    $show = "Data is not submitted";
                }
            }
        }
    }
}

// Function to sanitize input data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

    <div class="container">
        <div class="title">Registration</div>
        <hr>
        <div class="content">
            <?php
if ($showAlert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Congratulations!</strong>Data has been submitted.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
if ($showError) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Invalid Credentials!</strong>' . $show . '.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" placeholder="Enter your name" name="name">
                        <span style="color: red;"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" name="email" placeholder="Enter your email">
                        <span style="color: red;"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="input-box">
                        <span class="details">Registration No:</span>
                        <input type="text" name="rollno" placeholder="Enter your Reg No:">
                        <span style="color: red;"><?php echo $rollnoErr; ?></span>
                    </div>
                    <div class="input-box">
                        <span class="details">Role</span>
                        <select name="role" id="">
                            <option value="" disabled selected>Chose Your Role</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="account">Accounts</option>
                            <option value="management">Mangement</option>
                            <option value="cafe">Cafeteria</option>
                        </select>
                        <span style="color: red;"><?php echo $roleErr; ?></span>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" name="password" placeholder="Enter your password">
                        <span style="color: red;"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" name="cpassword" placeholder="Confirm your password">
                        <span style="color: red;"><?php echo $cpasswordErr; ?></span>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Register">
                </div>
                <hr>
                <div class="account">
                    <div class="text-center">
                        <span>Already have an account?<a href="login.php">Sign In here</a></span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>
