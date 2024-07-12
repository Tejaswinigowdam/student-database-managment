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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to add attendance
    $student_id = $_POST['student_id'];
    $percentage = $_POST['percentage'];

    // Insert the attendance record into the database
    $insert_sql = "INSERT INTO attendance (student_id, course_id, percentage) VALUES ('$student_id', '$course_id', '$percentage')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Attendence updated successfully');</script>";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="add-dashboard-container">
        <h2>Add Attendance</h2>
        <h3>Course: <?php echo $course_id; ?></h3>
        <h3>Semester: <?php echo $semester_id; ?></h3>
        <div class="add-mark-attendance">
        <form action="" method="post">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required><br>

            <label for="percentage">Percentage:</label>
            <input type="number" id="percentage" name="percentage" min="0" max="100" required><br>

            <div class="form-group button-container">
            <button type="submit">Submit</button>
        </div>
        </form>
        </div>
    </div>
</body>

</html>
