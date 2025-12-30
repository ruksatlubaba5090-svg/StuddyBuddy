<?php
require_once 'config.php';

if (!isset($_POST['Student_id'])) {
    die("Student ID missing");
}

$student_id = $_POST['Student_id'];

$sql = "UPDATE student
        SET Verified_status = 'Accepted'
        WHERE Student_id = '$student_id'";

if (mysqli_query($conn, $sql)) {
    echo "Student verified successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
