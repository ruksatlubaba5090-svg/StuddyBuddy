<?php
require_once 'config.php';

if (!isset($_POST['student_id'])) {
    die("Student ID missing");
}

$student_id = $_POST['student_id'];

$sql = "UPDATE student
        SET Verified_status = 'Rejected'
        WHERE Student_ID = '$student_id'";

if (mysqli_query($conn, $sql)) {
    echo "Student rejected successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
