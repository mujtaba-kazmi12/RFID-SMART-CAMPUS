<?php

include "connection.php";

// Department and Class in tt-classes.php and dt-classes.php
if (isset($_GET['class_table'])) {
    $sql = "SELECT * FROM class_table WHERE dep_id='" . $_GET['class_table'] . "'";
    $result = mysqli_query($conn, $sql);

    echo "<option disabled Selected>Select class</option>";
    while ($row = mysqli_fetch_assoc($result)) {
?>
        <option value="<?php echo $row['id'] ?>"><?php echo $row['class_name']; ?></option>
    <?php
    }
}

// To show Days/Schedule in tt-time.php
if (isset($_POST['action'])) {
    if ($_POST['action'] == "schedule") {
        $sql = "SELECT * FROM `days-lec_table`";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['days'] . "</td>
                    <td>" . $row['lectures'] . "</td>
                    <td><button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#dayModal'>Open</button></td>
                    <td><button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#lectureModal'>Open</button></td>
                    <td><a href='a href='tt-time.php?delid=$row[id]' class='btn btn-danger'>Delete</a></td>
                </tr>";
            }
        }
    }
}

// To show Classes in tt-classes.php
if (isset($_POST['action'])) {
    if ($_POST["action"] == "load") {
        $sql = "SELECT detail_table.id, department.dept_name, detail_table.class_ID, class_table.class_name FROM detail_table INNER JOIN department ON detail_table.department_ID=department.dept_id INNER JOIN class_table ON detail_table.class_ID=class_table.id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["dept_name"] . "</td>
                <td>" . $row['class_name'] . "</td>
                <td>
                <button type='button' class='btn btn-danger' name='delclass'><a href='tt-classes.php?delid=$row[id]' style='text-decoration: none; color: white;'>Delete</a></button></td>
                </tr>";
            }
        }
    }
}

// To show teachers in tt-teachers.php

if (isset($_POST['action'])) {
    if ($_POST["action"] == "teachers") {
        $sql = "SELECT department.dept_name, teacher_table.teacher_ID,teacher_table.teacher_name,teacher_table.id FROM teacher_table INNER JOIN department ON teacher_table.department_ID=department.dept_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['dept_name'] . "</td>
                        <td>" . $row['teacher_ID'] . "</td>
                        <td>" . $row['teacher_name'] . "</td>
                        <td>
                        <button type='button' class='btn btn-danger'><a href='tt-teachers.php?delid=$row[id]' style='text-decoration: none; color: white;'>Delete</a></button>
                        </td>
                    </tr>";
            }
        }
    }
}

// To show classrooms in tt-classrooms.php

if (isset($_POST['action'])) {
    if ($_POST["action"] == "classrooms") {
        $sql = "SELECT * FROM `room_table`";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['room_no'] . "</td>
                        <td>
                        <button type='button' class='btn btn-danger'><a href='tt-classrooms.php?delid=$row[id]' style='text-decoration: none; color: white;'>Delete</a></button>
                        </td>
                    </tr>";
            }
        }
    }
}

// To show subjects in tt-subjects.php

if (isset($_POST['action'])) {
    if ($_POST["action"] == "subjects") {
        $sql = "SELECT subject_table.id,class_table.class_name,subject_table.course_code,subject_table.course_name,
        subject_table.course_type, subject_table.no_of_lec,teacher_table.teacher_name,room_table.room_no FROM subject_table
        INNER JOIN class_table ON subject_table.class_ID=class_table.id INNER JOIN room_table ON subject_table.room_ID=room_table.id INNER JOIN teacher_table ON subject_table.teacher_ID=teacher_table.id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['class_name'] . "</td>
                    <td>" . $row['course_code'] . "</td>
                    <td>" . $row['course_name'] . "</td>
                    <td>" . $row['course_type'] . "</td>
                    <td>" . $row['no_of_lec'] . "</td>
                    <td>" . $row['teacher_name'] . "</td>
                    <td>" . $row['room_no'] . "</td>
                    <td>
                    <button type='button' class='btn btn-danger'><a href='tt-subjects.php?delid=$row[id]' style='text-decoration: none; color: white;'>Delete</a>
                    </button>
                    </td>
                    </tr>";
            }
        }
    }
}





// Enrollment System Links

// Degree with department in s_enrollment.php
if (isset($_GET['degree_table'])) {
    $sql = "SELECT * FROM degree_table WHERE dept_id='" . $_GET['degree_table'] . "'";
    $result = mysqli_query($conn, $sql);

    echo "<option disabled Selected>Select class</option>";
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <option value="<?php echo $row['id'] ?>"><?php echo $row['degree']; ?></option>
    <?php
    }
}

// Semester With degree in s_enrollment.php

if (isset($_GET['semester_table'])) {
    $sql = "SELECT * FROM semester_table WHERE deg_id='" . $_GET['semester_table'] . "'";
    $result = mysqli_query($conn, $sql);

    echo "<option disabled Selected>Select class</option>";
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <option value="<?php echo $row['id'] ?>"><?php echo $row['semester']; ?></option>
<?php
    }
}

// Display Subjects when semester entered in s_enrollment.php
if (isset($_GET['table_subject'])) {
    $sql = "SELECT * FROM table_subject WHERE sem_id='" . $_GET['table_subject'] . "'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
        <td><input type='hidden' name='subject_ID' id='' value='" . $row['sem_id'] . "'>" . $row['course_code'] . "</td>
        <td>" . $row['course_name'] . "</td>
        <td>" . $row['credit_hours'] . "</td>
        
        </tr>";
    }
}

// To display student enrollment request in a_enrollment.php
if (isset($_POST['action'])) {
    if ($_POST["action"] == "enrollment") {
        $sql = "SELECT student_table.id,student_table.name,student_table.rollno,student_table.email,degree_table.degree,
        semester_table.semester,enrollment_table.status
        FROM `student_table` INNER JOIN 
        enrollment_table ON student_table.id=enrollment_table.id INNER JOIN degree_table ON enrollment_table.degree_ID=degree_table.id INNER JOIN semester_table ON enrollment_table.sem_ID=semester_table.id
        WHERE enrollment_table.status='pending'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['rollno'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['degree'] . "</td>
                    <td>" . $row['semester'] . "</td>
                    <td>" . $row['status'] . "</td>
                    <td>
                    <a href='a_enrollment.php?upid=$row[id]'name='accept' class='btn btn-success'>Accept</a>
                    </a>
                    <a href='a_enrollment.php?delid=$row[id]' class='btn btn-danger' style='text-decoration: none; color: white;'>Delete</a>
                    </td>
                    </tr>";
            }
        }
    }
}

// To display the information of student in amount.php

if (isset($_POST['search_btn_post'])) {
    $id = $_POST['id'];
    $result_array = [];
    $sql = "SELECT student_table.name,student_table.rollno,student_table.email,account_table.card_amount
        FROM `account_table` INNER JOIN `student_table` ON account_table.student_id=student_table.id
        WHERE account_table.account_no='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            foreach ($result as $item) {
                array_push($result_array, $item);
                header('Content-type: application/json');
                echo json_encode($result_array);
            }
        }
    }
}


// To display name email and phone number in accounts.php
if (isset($_POST['search_btn'])) {
    $id = $_POST['id'];
    // echo $id;
    $result_array = [];
    $sql = "SELECT * FROM `student_table` WHERE `rollno`='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            foreach ($result as $row) {
                array_push($result_array, $row);
                header('Content-type: application/json');
                echo json_encode($result_array);
            }
        }
    }
}

// To display cards in all_card.php

if (isset($_POST['action'])) {
    if ($_POST["action"] == "cards") {
        $sql = "SELECT student_table.name,student_table.rollno,account_table.id,
        account_table.account_no,account_table.status,account_table.card_amount 
        FROM `account_table` INNER JOIN student_table ON
        account_table.student_id=student_table.id;";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['rollno'] . "</td>
                <td>" . $row['account_no'] . "</td>
                <td>" . $row['card_amount'] . "</td>
                <td>" . $row['status'] . "</td>
                </tr>";
        }
    }
}

// To display cards detail in invoice.php

if (isset($_POST['search'])) {
    $id = $_POST['id'];
    $result_array = [];
    $sql = "SELECT student_table.name,student_table.rollno,student_table.pno
        FROM `account_table` INNER JOIN `student_table` ON account_table.student_id=student_table.id
        WHERE account_table.account_no='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            foreach ($result as $item) {
                array_push($result_array, $item);
                header('Content-type: application/json');
                echo json_encode($result_array);
            }
        }
    }
}

// To display items details in invoice.php
if (isset($_POST['btn_search'])) {
    $id = $_POST['id'];
    // echo $id;
    $result_array = [];
    $sql = "SELECT * FROM `item_table` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            foreach ($result as $row) {
                array_push($result_array, $row);
                header('Content-type: application/json');
                echo json_encode($result_array);
            }
        }
    }
}


// Date Sheet Generator

// To display room_no in dt-classrooms.php
if (isset($_POST['action'])) {
    if ($_POST["action"] == "room_no") {
        $sql = "SELECT * FROM `dt_room`";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['room_no'] . "</td>
                        <td>" . $row['n_row'] . "</td>
                        <td>" . $row['columns'] . "</td>
                        <td>
                        <button type='button' class='btn btn-danger'><a href='dt-classrooms.php?delid=$row[id]' style='text-decoration: none; color: white;'>Delete</a></button>
                        </td>
                    </tr>";
            }
        }
    }
}

// To display classes and total strength in dt-classes.php
if (isset($_POST['check_btn'])) {
$c_id=$_POST['c_id'];
// echo $c_id;
$sql="SELECT students.name,students.rollno,class_table.class_name FROM `students` INNER JOIN class_table ON students.class_ID=class_table.id WHERE students.class_ID='$c_id'";
$result=mysqli_query($conn,$sql);
if($result){
    $num=mysqli_num_rows($result);
    if($num>0){
        foreach($result as $row){
            echo "<tr>
            <td>".$row['name']."</td>
            <td>".$row['rollno']."</td>
            
            </tr>";
        }
    }
    else{
        echo "No Record Found";
    }
}
}



// To display room design with buttons on dt-generate.php
if (isset($_GET['design'])) {
    $sql = "SELECT * FROM room_design WHERE id='" . $_GET['design'] . "'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
        $no_rows = $row['no_rows'];
        $columns = $row['columns'];

        echo "<thead id='thead'>";
        echo "<tr>";
        for ($k = 1; $k <= $columns; $k++) {
            echo "<th><div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle' id='btn-" . $k . "' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                </button>
                <ul class='dropdown-menu c_list'>
                </ul>
                </div></th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody id='tbody'>";
        for ($i = 1; $i <= $no_rows; $i++) {
            echo "<tr>";
            for ($j = 1; $j <= $columns; $j++) {
                echo "<td class='r-" . $i, $j . "'></td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
    }
}

// To display the selected class name in dropdown menu in dt-generate.php
if (isset($_GET['value'])) {
    $selectedValues = $_GET['value'];
    $id = 1;
    foreach ($selectedValues as $value) {
        // Construct and execute the query for each selected value
        $query = "SELECT dt_class.class_ID,class_table.class_name,dt_class.no_student FROM 
        `dt_class` INNER JOIN class_table ON dt_class.class_ID=class_table.id WHERE dt_class.class_ID = '$value'";
        $result = mysqli_query($conn, $query);
        $num = mysqli_num_rows($result);
        // Fetch the data and store it in the result set array
        if ($num > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li><a class='dropdown-item' id='" . $row['class_name'] . "' data-value='" . $row['class_ID'] . "' >" . $row['class_name'] . "</a> </li>";
                $id++;
            }
        }
    }
}

// To return class_ID class_name and no_student in dt-generate.php
if (isset($_POST['e'])) {
    $id = $_POST['e'];
    $result_array = [];

    foreach ($id as $v) {
        $query = "SELECT dt_class.class_ID, dt_class.no_student, class_table.class_name, dt_class.no_student
                  FROM `dt_class`
                  INNER JOIN class_table ON dt_class.class_ID = class_table.id
                  WHERE dt_class.class_ID = '$v'";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $num = mysqli_num_rows($result);

            if ($num > 0) {
                foreach ($result as $item) {
                    array_push($result_array, $item);
                }
            }
        }
    }

    header('Content-type: application/json');
    echo json_encode($result_array);
}

?>