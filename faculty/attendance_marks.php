<?php
session_start();
require_once('../db_connection.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['course_id']) && isset($_GET['semester_id'])) {
    $course_id = $_GET['course_id'];
    $semester_id = $_GET['semester_id'];

    // Retrieve course and semester details from the database based on course_id and semester_id
    // You can use this information to display the relevant course and semester details

} else {
    // Handle error if course_id or semester_id is not provided
    echo "Error: Course ID or Semester ID not provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance and Marks</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="view-dashboard-container">
        <h2>Attendance and Marks</h2>
        <h3>Course:
            <?php echo $course_id; ?>
        </h3>
        <h3>Semester:
            <?php echo $semester_id; ?>
        </h3>
        <div class="faculty-view-add">
            <div class="faculty-view">
                <!-- Add form or links to add attendance and marks -->
                <a
                    href="view_attendance.php?course_id=<?php echo $course_id; ?>&semester_id=<?php echo $semester_id; ?>">View
                    Attendance</a>
                <a href="view_marks.php?course_id=<?php echo $course_id; ?>&semester_id=<?php echo $semester_id; ?>">View
                    Marks</a>
            </div>
            <div class="faculty-add">
                <a
                    href="add_attendance.php?course_id=<?php echo $course_id; ?>&semester_id=<?php echo $semester_id; ?>">Add
                    Attendance</a>
                <a href="add_marks.php?course_id=<?php echo $course_id; ?>&semester_id=<?php echo $semester_id; ?>">Add
                    Marks</a>
            </div>
        </div>
    </div>
</body>

</html>

