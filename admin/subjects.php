<?php
// Include the database connection file
include '../db_connection.php';

// Retrieve selected semester
$selectedSemester = $_GET['semester'] ?? '';

// Fetch subjects for the selected semester from the database
$subjects = [];
if (!empty($selectedSemester)) {
    $sql = "SELECT course_id, course_name, faculty_id FROM course WHERE semester_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedSemester);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects for Semester
        <?php echo $selectedSemester; ?>
    </title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="add-sub">
        <div class="add-sub-1">
            <h3>Subjects for semester 
                <?php echo $selectedSemester; ?>
            </h3>
            <div class="subject-list">
                <?php if (!empty($subjects)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Subject Code </th>
                                <th>Subject Name </th>
                                <th>Faculty ID </th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td>
                                        <?php echo $subject['course_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $subject['course_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $subject['faculty_id']; ?>
                                    </td> <!-- Print Faculty ID -->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No subjects found for this semester.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Add Subject Form -->
        <div class="add-subject-form">
            <h3>Add Subject</h3>
            <form action="add_subject.php" method="post">
                <!-- <label for="subject_code">Subject Code:</label> -->
                <input type="text" id="subject_code" name="subject_code" placeholder="Subject_code" required><br>
                <!-- <label for="subject_name">Subject Name:</label> -->
                <input type="text" id="subject_name" name="subject_name" placeholder="Subject_name" required><br>
                <!-- <label for="faculty_id">Faculty ID:</label> -->
                <input type="text" id="faculty_id" name="faculty_id" placeholder="Faculty_id" required><br>
                <input type="hidden" name="semester" value="<?php echo $selectedSemester; ?>">
                <div class="form-group button-container">
                <input type="submit" name="submit" value="Add Subject" class="submit-button">
                </div>
            </form>
        </div>

    </div>
</body>

</html>