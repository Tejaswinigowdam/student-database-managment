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

        // Check if the student is logged in
        if (!isset($_SESSION['username'])) {
            // Redirect to the login page if not logged in
            header("Location: student_login.php");
            exit;
        }

        // Get student ID from session
        $student_id = $_SESSION['username'];

        // Check if semester ID is provided
        if (isset($_GET['semester'])) {
            // Retrieve the selected semester ID
            $semester_id = $_GET['semester'];

            // Fetch courses offered in the selected semester for the student
            $sql_courses = "SELECT c.course_id, c.course_name, m.IA1, m.IA2, m.IA3, m.assessment, m.finalIA, m.extern, m.total_marks, a.percentage
                        FROM course c
                        LEFT JOIN marks m ON c.course_id = m.course_id AND m.student_id = '$student_id'
                        LEFT JOIN attendance a ON c.course_id = a.course_id AND a.student_id = '$student_id'
                        WHERE c.semester_id = $semester_id";
            $result_courses = $conn->query($sql_courses);

            if ($result_courses->num_rows > 0) {
                // Output the table header
                echo "<h2>Details for Semester $semester_id</h2>";
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
                echo "<script>alert('No courses found for Semester $semester_id.');window.location='student_dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('Semester ID not provided.');window.location='../index.php';</script>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>