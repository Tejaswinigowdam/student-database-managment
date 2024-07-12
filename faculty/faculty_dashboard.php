<?php
session_start();
require_once('../db_connection.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Query the faculty ID (faculty_id) based on the logged-in username
$sql = "SELECT user_id FROM User WHERE username='$username' AND role='faculty'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $faculty_id = $username; // The faculty_id is the username

    // Query courses associated with the faculty_id
    $course_sql = "SELECT course_id, course_name, semester_id FROM Course WHERE faculty_id='$faculty_id'";
    $course_result = $conn->query($course_sql);
    $courses = array();
    while ($course_row = $course_result->fetch_assoc()) {
        $courses[] = $course_row;
    }
} else {
    // Handle error if faculty ID not found
    echo "Error: Faculty ID not found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="faculty-dashboard-container">
        <h2>Welcome Faculty</h2>
        <h3>Your Courses:</h3>
        <div class="faculty-container">
            <div class="faculty-buttons">
                <?php foreach ($courses as $course): ?>

                    <a
                        href="attendance_marks.php?course_id=<?php echo $course['course_id']; ?>&semester_id=<?php echo $course['semester_id']; ?>">
                        <?php echo $course['course_name']; ?>
                    </a>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>