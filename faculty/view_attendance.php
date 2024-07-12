<?php
session_start();
require_once('../db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Check if course_id and semester_id are provided in the URL
if (isset($_GET['course_id']) && isset($_GET['semester_id'])) {
    $course_id = $_GET['course_id'];
    $semester_id = $_GET['semester_id'];

    // Query the attendance records for the given course_id and semester_id
    $attendance_sql = "SELECT * FROM Attendance WHERE course_id='$course_id' ";
    $attendance_result = $conn->query($attendance_sql);

    // Fetch other details related to the course and semester from your database if needed

} else {
    // Handle error if course_id or semester_id is not provided
    echo "Error: Course ID or Semester ID not provided.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="view1-dashboard-container">
        <h2>View Attendance</h2>
        <h3>Course ID: <?php echo $course_id; ?></h3>
        <h3>Semester ID: <?php echo $semester_id; ?></h3>

        <!-- Display attendance details -->
        <table>
            <tr>
                <th>Student ID</th>
                <th>Percentage</th>
                <!-- Add more columns if needed -->
            </tr>
            <?php while ($row = $attendance_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo $row['percentage']; ?></td>
                    <!-- Add more columns if needed -->
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
