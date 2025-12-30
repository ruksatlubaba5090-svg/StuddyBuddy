<?php
require_once 'config.php';

if (!isset($_POST['student_id'], $_POST['authority_id'])) {
    die("Required data missing");
}

$student_id   = $_POST['student_id'];
$authority_id = $_POST['authority_id'];

$sql = "INSERT INTO Student_verification
        (Student_ID, Authority_ID)
        VALUES ('$student_id', '$authority_id')";

if (mysqli_query($conn, $sql)) {
    echo "Verification request submitted successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

