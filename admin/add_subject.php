<?php
// Include the database connection file
include '../db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subjectCode = $_POST['subject_code'] ?? '';
    $subjectName = $_POST['subject_name'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $facultyId = $_POST['faculty_id'] ?? '';

    // Validate form data (perform additional validation as needed)
    if (!empty($subjectCode) && !empty($subjectName) && !empty($semester) && !empty($facultyId)) {
        // Check if the faculty exists
        $sql = "SELECT * FROM faculty WHERE faculty_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $facultyId);
        $stmt->execute();
        $result = $stmt->get_result();

        // If faculty does not exist, display an error message
        if ($result->num_rows == 0) {
            echo "Faculty not available.";
        } else {
            // Prepare SQL statement to insert subject into the database
            $sql = "INSERT INTO course (course_id, course_name, semester_id, faculty_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param("ssss", $subjectCode, $subjectName, $semester, $facultyId);
                if ($stmt->execute()) {
                    // Subject added successfully
                    
                    echo "<script> window.location='admin_dashboard.php';alert('Subject added successfully');</script>";
                } else {
                    // Error occurred while executing the statement
                    echo "Error: " . $conn->error;
                }

                // Close statement
                $stmt->close();
            } else {
                // Error occurred while preparing the statement
                echo "Error: Unable to prepare statement.";
            }
        }
    } else {
        // Form fields are empty
        echo "Error: All fields are required.";
    }
}

