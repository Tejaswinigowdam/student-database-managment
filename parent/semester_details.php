<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Semester Details</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="s-sem-details-container">
        <?php
        session_start();
        require_once('../db_connection.php');

        // Check if the parent is logged in
        if (!isset($_SESSION['username'])) {
            // Redirect to the login page if not logged in
            header("Location: parent_login.php");
            exit;
        }

        // Get parent ID from session
        $parent_id = $_SESSION['username'];

        // Fetch student details associated with the parent
        $sql_student_details = "SELECT s.student_id, s.name FROM student s INNER JOIN parent p ON s.student_id = p.student_id WHERE p.parent_id = '$parent_id'";
        $result_student_details = $conn->query($sql_student_details);

        if ($result_student_details->num_rows > 0) {
            // Get the student details
            $row_student_details = $result_student_details->fetch_assoc();
            $student_id = $row_student_details['student_id'];
            $student_name = $row_student_details['name'];

            // Fetch student IDs associated with the parent
            $sql_student_ids = "SELECT student_id FROM parent WHERE parent_id = '$parent_id'";
            $result_student_ids = $conn->query($sql_student_ids);

            if ($result_student_ids->num_rows > 0) {
                // Store student IDs in an array
                $student_ids = array();
                while ($row_student_id = $result_student_ids->fetch_assoc()) {
                    $student_ids[] = $row_student_id['student_id'];
                }

                // Check if semester ID is provided
                if (isset($_GET['semester'])) {
                    // Retrieve the selected semester ID
                    $semester_id = $_GET['semester'];

                    // Fetch courses offered in the selected semester
                    $sql_courses = "SELECT c.course_id, c.course_name, m.IA1, m.IA2, m.IA3, m.assessment, m.finalIA, m.extern, m.total_marks, a.percentage
                            FROM course c
                            LEFT JOIN marks m ON c.course_id = m.course_id AND m.student_id IN ('" . implode("','", $student_ids) . "')
                            LEFT JOIN attendance a ON c.course_id = a.course_id AND a.student_id IN ('" . implode("','", $student_ids) . "')
                            WHERE c.semester_id = '$semester_id'";
                    $result_courses = $conn->query($sql_courses);

                    if ($result_courses->num_rows > 0) {
                        // Output the student details
                        // echo "<h2>Student ID: $student_id</h2>";
                        echo "<h2>Student Name: $student_name</h2>";

                        // Output the table header
                        echo "<table>";
                        echo "<tr><th>Course ID</th><th>Course Name</th><th>IA1</th><th>IA2</th><th>IA3</th><th>Assessment</th><th>Final IA</th><th>Extern</th><th>Total Marks</th><th>Percentage</th></tr>";

                        // Output each course's details
                        while ($row_course = $result_courses->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_course['course_id'] . "</td>";
                            echo "<td>" . $row_course['course_name'] . "</td>";
                            echo "<td>" . $row_course['IA1'] . "</td>";
                            echo "<td>" . $row_course['IA2'] . "</td>";
                            echo "<td>" . $row_course['IA3'] . "</td>";
                            echo "<td>" . $row_course['assessment'] . "</td>";
                            echo "<td>" . $row_course['finalIA'] . "</td>";
                            echo "<td>" . $row_course['extern'] . "</td>";
                            echo "<td>" . $row_course['total_marks'] . "</td>";
                            echo "<td>" . $row_course['percentage'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<script>alert('No courses found for Semester $semester_id.');window.location='parent_dashboard.php';</script>";
                    }
                } else {
                    echo "<script>alert('Semester ID not provided.');</script>";
                }
            } else {
                echo "<script>alert('No students associated with this parent.');window.location='../index.php';</script>";
            }
        } else {
            echo "<script>alert('Student details not found for this parent.');window.location='../index.php';</script>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>