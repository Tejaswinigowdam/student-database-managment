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
} else {
    // Handle error if course_id or semester_id is not provided
    echo "Error: Course ID or Semester ID not provided.";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize the form data
    $student_id = $_POST['student_id'];
    $IA1 = $_POST['IA1'];
    $IA2 = $_POST['IA2'];
    $IA3 = $_POST['IA3'];
    $assessment = $_POST['assessment'];
    $extern = $_POST['extern'];

    // Insert the marks into the database
    $insert_sql = "INSERT INTO Marks (student_id, course_id, IA1, IA2, IA3, assessment, extern) VALUES ('$student_id', '$course_id', '$IA1', '$IA2', '$IA3', '$assessment', '$extern')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Marks added successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Marks</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="add-dashboard-container">
        <h2>Add Marks</h2>
        <form action="add_marks.php?course_id=<?php echo $course_id; ?>&semester_id=<?php echo $semester_id; ?>"
            method="post" class="all-form">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="IA1">IA1:</label>
                <input type="number" id="IA1" name="IA1" required>
            </div>
            <div class="form-group">
                <label for="IA2">IA2:</label>
                <input type="number" id="IA2" name="IA2" required>
            </div>
            <div class="form-group">
                <label for="IA3">IA3:</label>
                <input type="number" id="IA3" name="IA3" required>
            </div>
            <div class="form-group">
                <label for="assessment">Assessment:</label>
                <input type="number" id="assessment" name="assessment" required>
            </div>
            <!-- <div class="form-group">
                <label for="finalIA">FinalIA:</label>
                <input type="number" id="finalIA" name="finalIA" required>
            </div> -->
            <div class="form-group">
                <label for="extern">External:</label>
                <input type="number" id="extern" name="extern" required>
            </div>
            <!-- <div class="form-group">
                <label for="total_marks">Total Marks:</label>
                <input type="number" id="total_marks" name="total_marks" required>
            </div> -->
            <div class="form-group button-container">
            <button type="submit">Submit</button>
        </div>
    </div>


    </form>
    </div>
</body>

</html>