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
    <title>Timetable Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/timetable-gen.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  </head>

  <body>
    <form action="tt-generate.php" method="POST">
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
            <a href="a_dashboard.php">Dashboard</a>
            <a href="tt-time.php" class="active">Timetable Generator</a>

            <div class="links">
              <span>User Menu</span>
              <a href="#">Profile</a>
              <a href="#">Change Password</a>
              <a href="logout.php">Logout</a>
            </div>
          </div>
        </nav>

        <div class="main-body">
          <h2>Timetable Generator</h2>
          <div class="promo_card">
            <ul>
              <li><a href="tt-time.php">Days/Lectures</a></li>
              <li><a href="tt-classes.php">Classes</a></li>
              <li><a href="tt-teachers.php">Teachers</a></li>
              <li><a href="tt-classrooms.php">Class Rooms</a></li>
              <li><a href="tt-subjects.php">Subjects</a></li>
              <li><a href="tt-generate.html">Generate Timetable</a></li>
            </ul>
          </div>
          <div class="Assign">
            <select name="s_class" id="s_class" class="form-select" required>
              <option selected disabled>Choose Class</option>
              <?php
              $sql = "SELECT class_table.id,class_table.class_name FROM detail_table INNER JOIN class_table
                        ON detail_table.class_ID=class_table.id";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['class_name']; ?></option>
              <?php
              }
              ?>
            </select>
            <button type="submit" name="generate" id="generate">Generate Timetable</button>
            <button type="submit" name="save">Save Timetable</button>
          </div>
          <div class="Assign">
            <select name="show_class" id="show_class" class="form-select" required>
              <option selected disabled>Choose Class</option>

              <?php
              $sql = "SELECT DISTINCT class_table.class_name,timetable.class_ID FROM `timetable`
                  INNER JOIN class_table ON timetable.class_ID=class_table.id;";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $row['class_ID']; ?>"><?php echo $row['class_name']; ?></option>
              <?php
              }
              ?>
            </select>
            <button type="submit" name="display">View Timetable</button>
          </div>



          <div class="caption">
            <h3>See Timetable</h3>
          </div>
          <!-- table -->
          <div class="table-info">
            <?php
            if (isset($_POST['generate'])) {
              // if(!isset($_SESSION['s_class'])){
              //   echo "<p class='text-danger'>Please select a class to generate timetable </p>";
              // }
              
              // // echo $class_ID;
              // else {
                $class_ID = $_POST['s_class'];

                $query = "SELECT * FROM `days-lec_table`";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                  $d = $row['days'];
                  $l = $row['lectures'];
                }
                // To fetch timeSlots
                $timeSlots = array();
                $sql = "SELECT * FROM `schedule_table` LIMIT $l";
                $run = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($run)) {
                  array_push($timeSlots, $row['lectures_time']);
                }
                // To fetch days 
                $days = array();
                $sql = "SELECT * FROM `schedule_table` LIMIT $d";
                $run = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($run)) {
                  array_push($days, $row['days']);
                }
                // To fetch classes
                $sql = "SELECT subject_table.course_code,subject_table.course_name,subject_table.course_type,subject_table.no_of_lec
                      ,teacher_table.teacher_name,room_table.room_no FROM `subject_table`
                      INNER JOIN teacher_table on subject_table.teacher_ID=teacher_table.id INNER JOIN
                      room_table ON subject_table.room_ID=room_table.id WHERE subject_table.class_ID='$class_ID'";
                $run = mysqli_query($conn, $sql);
                if (!mysqli_num_rows($run) > 0) {
                  echo "<p class='danger'>No Subjects found for desired classes </p>";
                } else {

                  while ($row = mysqli_fetch_assoc($run)) {
                    $course_code[] = $row['course_code'];
                    $course_name[] = $row['course_name'];
                    $course_type[] = $row['course_type'];
                    $no_of_lec[] = $row['no_of_lec'];
                    $teacher_name[] = $row['teacher_name'];
                    $room_no[] = $row['room_no'];
                  }
                  // Total lectures
                  $t_lec = 0;
                  $count = count($course_code);
                  for ($j = 0; $j < $count; $j++) {
                    $t_lec += $no_of_lec[$j];
                  }
                  // Number of lectures to schedule
                  $numberOfLectures = $t_lec;

                  // Array of subjects and their desired number of lectures per week
                  $subjects = [];
                  for ($i = 0; $i < $count; $i++) {
                    $key = $course_code[$i] . "<br>" . $teacher_name[$i] . "<br>Room-" . $room_no[$i];;
                    $value = $no_of_lec[$i];

                    $subjects[$key] = $value;
                  }
                  // Fetching the schedule of class
                  $sql = "SELECT class_table.class_name,s1.lectures_time, s2.days, class_schedule.slot 
                      FROM class_schedule 
                      INNER JOIN class_table ON class_schedule.class_ID = class_table.id 
                      INNER JOIN schedule_table s1 ON class_schedule.lec_ID = s1.id 
                      INNER JOIN schedule_table s2 ON class_schedule.day_ID = s2.id WHERE class_schedule.class_ID='$class_ID'";
                  $result = mysqli_query($conn, $sql);

                  if (!mysqli_num_rows($result) > 0) {
                    echo "Please enter the schedule of desired class";
                  } else {

                    $classSchedule = array();

                    // Fetching values from the database
                    while ($row = $result->fetch_assoc()) {
                      $day = $row['days'];
                      $timeSlot = $row['lectures_time'];

                      // Check if the day exists in the $classSchedule array
                      if (!isset($classSchedule[$day])) {
                        $classSchedule[$day] = array();
                      }

                      // Adding the time slot to the corresponding day in the array
                      $classSchedule[$day][] = $timeSlot;
                    }
                    // Generate timetable
                    $timetable = array();

                    // Assign lectures for each subject
                    foreach ($subjects as $subject => $lectureCount) {
                      for ($i = 0; $i < $lectureCount; $i++) {
                        $lecture = $subject . " Lecture " . ($i + 1);

                        // Find available time slots for the subject based on class schedule
                        $availableTimeSlots = array();
                        foreach ($classSchedule as $day => $slots) {
                          foreach ($slots as $slot) {
                            if (!isset($timetable[$day][$slot])) {
                              $availableTimeSlots[] = array("day" => $day, "timeSlot" => $slot);
                            }
                          }
                        }

                        // Check if there are any available time slots
                        if (empty($availableTimeSlots)) {
                          break; // No available time slots, exit the loop
                        }

                        // Randomly select an available time slot
                        $randomIndex = array_rand($availableTimeSlots);
                        $selectedSlot = $availableTimeSlots[$randomIndex];
                        $randomDay = $selectedSlot["day"];
                        $randomTimeSlot = $selectedSlot["timeSlot"];

                        // Store the lecture with subject in the timetable array
                        $timetable[$randomDay][$randomTimeSlot] = array(
                          "Subject" => $subject,
                          "Lecture" => $lecture
                        );
                      }
                    }

                    // ...

                    // Output the timetable
                    echo "<table border='1' class='table'>";
                    echo "<tr><th>Time Slot</th>";

                    // Display days in <th>
                    foreach ($days as $day) {
                      echo "<th>$day</th>";
                    }

                    echo "</tr>";

                    foreach ($timeSlots as $timeSlot) {
                      echo "<tr>";
                      echo "<td>$timeSlot</td>";

                      // Display subject and lecture for each day and time slot in <td>
                      foreach ($days as $day) {
                        $lectureDetails = isset($timetable[$day][$timeSlot]) ? $timetable[$day][$timeSlot] : array("Subject" => "", "Lecture" => "");
                        $subject = $lectureDetails["Subject"];
                        $lecture = $lectureDetails["Lecture"];
                        echo "<td>$subject</td>";
                      }

                      echo "</tr>";
                    }
                    echo "</table>";
                    $_SESSION['timetable'] = $timetable;
                    $_SESSION['timeSlots'] = $timeSlots;
                    $_SESSION['days'] = $days;
                    $_SESSION['class_ID'] = $class_ID;
                  }
                }
              }
            // }
            if (isset($_POST['save'])) {
              // Check if the timetable has been generated and stored in the session
              if (isset($_SESSION['timetable'])) {
                $timetable = $_SESSION['timetable'];
                $timeSlots = $_SESSION['timeSlots'];
                $days = $_SESSION['days'];
                $class_ID = $_SESSION['class_ID'];
                // Store the timetable in the database
                foreach ($timeSlots as $timeSlot) {
                  foreach ($days as $day) {
                    // Check if the lecture exists in the timetable for the current time slot and day
                    if (isset($timetable[$day][$timeSlot])) {
                      $lectureDetails = $timetable[$day][$timeSlot];
                      $subject = $lectureDetails["Subject"];
                      $lecture = $lectureDetails["Lecture"];
                    } else {
                      // For empty cells, set the subject and lecture to empty strings
                      $subject = "";
                      $lecture = "";
                    }

                    // Store the lecture in the database
                    $sql = "INSERT INTO timetable (class_ID, day, time_slot, lecture) VALUES ('$class_ID', '$day', '$timeSlot', '$subject')";
                    $result = mysqli_query($conn, $sql);
                  }
                }

                // Clear the session variable after saving the timetable
                unset($_SESSION['timetable']);

                if ($result) {
                  $delclass = "DELETE FROM `detail_table` WHERE class_ID='$class_ID'";
                  $delrun = mysqli_query($conn, $delclass);
                  if ($delrun) {
                    $del_sch = "DELETE FROM `class_schedule` WHERE class_ID='$class_ID'";
                    $del_run = mysqli_query($conn, $del_sch);
                  }
                }
                echo "<p class='text-danger'>Timetable saved successfully! </p>";
                // Display a success message or perform any other desired action
              } else {
              }     // If the timetable is not available in the session, display an error message
              // echo "<p class='text-danger'>No timetable to save. Please generate a timetable first.</p>";
            }

            if (isset($_POST['display'])) {
              // if(!isset($_SESSION['show_class'])){
              //   echo "<p class='text-danger'>Please select a class to display timetable </p>";
              // }
              // else {
                $show_class = $_POST['show_class'];
                $sql = "SELECT * FROM timetable WHERE class_ID='$show_class'";
                $result = mysqli_query($conn, $sql);

                // Array to store the timetable data
                $timetableData = [];

                while ($row = mysqli_fetch_assoc($result)) {
                  $timetableData[] = $row;
                }

                if (!empty($timetableData)) {
                  $query = "SELECT * FROM `days-lec_table`";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $d = $row['days'];
                    $l = $row['lectures'];
                  }
                  // To fetch timeSlots
                  $timeSlots = array();
                  $sql = "SELECT * FROM `schedule_table` LIMIT $l";
                  $run = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($run)) {
                    array_push($timeSlots, $row['lectures_time']);
                  }
                  // To fetch days 
                  $days = array();
                  $sql = "SELECT * FROM `schedule_table` LIMIT $d";
                  $run = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($run)) {
                    array_push($days, $row['days']);
                  }

                  echo "<table class='table'>";
                  echo "<tr><th>Time Slot</th>";

                  // Display the days as table headers
                  foreach ($days as $day) {
                    echo "<th>$day</th>";
                  }

                  echo "</tr>";

                  // Loop through the time slots
                  foreach ($timeSlots as $timeSlot) {
                    echo "<tr>";
                    echo "<td>$timeSlot</td>";

                    // Loop through the days
                    foreach ($days as $day) {
                      $lecture = '';
                      $details = '';

                      // Find the corresponding timetable record for the current time slot and day
                      foreach ($timetableData as $row) {
                        if ($row['day'] == $day && $row['time_slot'] == $timeSlot) {
                          $lecture = $row['lecture'];
                          break;
                        }
                      }

                      echo "<td>$lecture<br>$details</td>";
                    }

                    echo "</tr>";
                  }

                  echo "</table>";
                } else {
                  // If there are no timetable records in the database, display a message
                  echo "<p class='text-danger'>No timetable records found.</p>";
                }
              }
            // }
            ?>
          </div>
        </div>

        <div class="sidebar">

        </div>
      </div>
    </form>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script>
    </script>
  </body>

  </html>