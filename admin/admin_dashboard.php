<?php
// Include the database connection file
include '../db_connection.php';

// Function to fetch semesters from the database
function getSemesters($conn) {
    $semesters = []; // Initialize an empty array to store semesters

    // Query to fetch semesters from the database
    $sql = "SELECT semester_id FROM semester";
    $result = $conn->query($sql);

    // Check if query executed successfully
    if ($result) {
        // Fetch each row and add it to the $semesters array
        while ($row = $result->fetch_assoc()) {
            $semesters[] = $row['semester_id'];
        }
    }

    // Return the array of semesters
    return $semesters;
}

// Call the getSemesters function to get the list of semesters
$semesters = getSemesters($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital@0;1&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, Admin!</h2>
        <h3>Select Semester</h3>
        <!-- Generate buttons for each semester -->
        <div class="admin-buttons">
        <?php
        foreach ($semesters as $semester) {
            echo "<a href='subjects.php?semester=$semester'><button>Semester $semester</button></a>";
        }
        ?>
        </div>
    </div>


</body>
</html>
