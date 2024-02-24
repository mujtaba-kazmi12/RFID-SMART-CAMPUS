<?php

include "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}

$showalert = false;
$showError = false;
if (isset($_POST['generate'])) {
  // Selecting room and their rows and columns
  $sql = "SELECT room_no, n_row, columns FROM dt_room";
  $result = mysqli_query($conn, $sql);

  $roomData = array();
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $roomData[] = $row;
    }
  }

  if (count($roomData) > 0) {
    // Getting data of classes and their student roll numbers
    $class_id = array();
    $classData = array();
    $rollNumberData = array();
    $sql = 'SELECT * FROM dt_class';
    $result = mysqli_query($conn, $sql);

    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          array_push($class_id, $row['class_ID']);
        }
        $count = count($class_id);

        for ($i = 0; $i < $count; $i++) {
          $dataSql = "SELECT * FROM `students` INNER JOIN class_table ON students.class_ID=class_table.id WHERE students.class_ID='$class_id[$i]'";
          $dataResult = mysqli_query($conn, $dataSql);

          if ($dataResult) {
            while ($dataRow = mysqli_fetch_assoc($dataResult)) {
              $class = $dataRow['class_name'];
              $rollNumber = $dataRow['rollno'];

              if (!isset($classData[$class])) {
                $classData[$class] = array();
              }

              $classData[$class][] = array(
                'Roll Number' => $rollNumber,
              );
            }
          }
        }
      } else {
        echo "No class selected";
      }
    }

    // Fetching subjects from the database
    $sql = 'SELECT * FROM dt_class';
    $result = mysqli_query($conn, $sql);

    $tests = array();

    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          array_push($tests, $row['subject']);
        }
      }
    }

    // Assign tests to classes
    $test_assignments = array_combine(array_keys($classData), $tests);

    $remaining_students = array();
    foreach ($classData as $class => $students) {
      $remaining_students[$class] = $students;
    }

    $current_class_index = 0;
    $class_1_rollno_index = 0;

    foreach ($roomData as $room) {
      $roomNo = $room['room_no'];
      $rows = $room['n_row'];
      $columns = $room['columns'];

      // Create seating plan table
      $seating_plan = array();
      $current_seat = 1;
      $all_students_assigned = false;

      for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
          if ($current_seat > $rows * $columns || $all_students_assigned) {
            // All seats have been filled or no more students are available, exit the loop
            break 2;
          }

          $class_keys = array_keys($classData);
          $class = $class_keys[$current_class_index];
          $students = $classData[$class];

          // Get the roll number from Class 1 sequentially if available
          if ($class === 'Class-1' && $class_1_rollno_index < count($students)) {
            $student = $students[$class_1_rollno_index];
            $class_1_rollno_index++;
          } else {
            // Remove assigned student from the remaining students array
            $student = array_shift($remaining_students[$class]);
            if (count($remaining_students[$class]) === 0) {
              // All students of this class have been assigned
              $all_students_assigned = true;
            }
          }

          $test = $test_assignments[$class];

          $seating_plan[$i][$j] = array(
            'Seat' => $current_seat,
            'Class' => $class,
            'Roll No' => $student,
            'Test' => $test,
          );

          $current_seat++;
          $current_class_index = ($current_class_index + 1) % count($classData);
        }
      }

      // Insert the seating plan into the database
      $seatingPlanData = json_encode($seating_plan);
      $insertSql = "INSERT INTO seating_plan (room_no, seating_plan) VALUES ('$roomNo', '$seatingPlanData')";
      $insertResult = mysqli_query($conn, $insertSql);

      if ($insertResult) {
        $showalert = true;
        $show = "Seating Plan Generated";
      } else {
        $showError = true;
        $show = "Execution Failed!";
      }
    }

    // Display the remaining roll numbers for each class
    // echo "<h3>Remaining Roll Numbers:</h3>";
    // foreach ($remaining_students as $class => $students) {
    //   echo "<p>$class:</p>";
    //   echo "<ul>";
    //   foreach ($students as $student) {
    //     echo "<li>" . implode($student) . "</li>";
    //   }
    //   echo "</ul>";
    // }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Date Sheet Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/timetable-gen.css" />
  <link rel="stylesheet" href="select2/css/select2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
  <!-- navbar -->
  <form action="dt-generate.php" method="POST">
    <header class="header">
      <div class="logo">
        <a href="#">SUS</a>
        <div class="search_box">
          <input type="text" placeholder="Search">
          <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
        </div>
      </div>
    </header>
    <?php
    if ($showalert) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Congratulations!</strong>' . $show . '.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($showError) {
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Sorry!</strong>' . $show . '.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <div class="s_container">
      <nav>
        <!-- sidebar -->
        <div class="side_navbar">
          <span>Main Menu</span>
          <a href="man_dashboard.php">Dashboard</a>
          <a href="dt-classrooms.php" class="active">Date Sheet Generator</a>
          <a href="a_enrollment.php">Enrollment</a>

          <div class="links">
            <span>User Menu</span>
            <a href="#">Profile</a>
            <a href="#">Change Password</a>
            <a href="logout.php">Logout</a>
          </div>
        </div>
      </nav>

      <div class="main-body">
        <h2>Date Sheet Generator</h2>
        <div class="promo_card">
          <ul>
            <!-- <li><a href="tt-file.php">File</a></li> -->
            <li><a href="dt-classrooms.php">Class Rooms</a></li>
            <li><a href="dt-classes.php">Classes/Subjects</a></li>
            <li><a href="dt-generate.php">Generate Date Sheet</a></li>
          </ul>
        </div>

        <div class="Assign">
          <button type="submit" name="generate">Generate</button>
          <br>
          <label class="form-label my-2">Select Classes:</label>
          <select name="room_no" id="room_no" class="form-select">
            <option disabled selected>Choose class</option>
            <?php
            $sql = "SELECT * FROM `seating_plan`";
            $result = mysqli_query($conn, $sql);
            if ($result) {
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                  <option value="<?php echo $row['room_no'] ?>"><?php echo $row['room_no'] ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
          <button type="submit" name="submit">Show</button>
          <br>
        </div>

        <div class="caption">
          <h3>Design Rooms</h3>
        </div>
        <div class="table-info">

          <?php
          $sql = "SELECT DISTINCT room_no FROM seating_plan";
          $result = mysqli_query($conn, $sql);

          if (!$result) {
            die("Error retrieving room numbers: " . mysqli_error($conn));
          }

          // Array to store room numbers
          $roomNumbers = array();

          while ($row = mysqli_fetch_assoc($result)) {
            $roomNumbers[] = $row['room_no'];
          }

          // Handle form submission
          if (isset($_POST['submit'])) {
            // Get the selected room number from the form
            $selectedRoomNo = $_POST['room_no'];

            // Fetch seating plan data for the selected room number
            $seatingPlanSql = "SELECT seating_plan FROM seating_plan WHERE room_no = '$selectedRoomNo'";
            $seatingPlanResult = mysqli_query($conn, $seatingPlanSql);

            if (!$seatingPlanResult) {
              die("Error retrieving seating plan: " . mysqli_error($conn));
            }

            $seatingPlanData = mysqli_fetch_assoc($seatingPlanResult)['seating_plan'];

            if ($seatingPlanData) {
              // Decode the seating plan JSON data
              $seating_plan = json_decode($seatingPlanData, true);

              // Display the seating plan table
              echo "<h3>Seating Plan for Room $selectedRoomNo</h3>";

              echo "<table class='table'>";
              foreach ($seating_plan as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                  echo "<td>";
                  echo "Seat: " . $cell['Seat'] . "<br>";
                  echo "Class: " . $cell['Class'] . "<br>";
                  echo "Roll No: " . implode($cell['Roll No']) . "<br>";
                  echo "Test: " . $cell['Test'] . "<br>";
                  echo "</td>";
                }
                echo "</tr>";
              }
              echo "</table>";
            } else {
              echo "No seating plan data found for Room $selectedRoomNo.";
            }
          }
          ?>

        </div>

      </div>

      <div class="sidebar">


      </div>
  </form>
  <script src="js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.js"></script>
  <script src="select2/js/select2.min.js"></script>
  <!-- <script src="js/dt-generate.js"></script> -->
</body>

</html>