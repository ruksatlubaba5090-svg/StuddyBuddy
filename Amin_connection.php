<?php
include 'config.php';
session_start();

// Ensure only Admin (Authority_ID) can access this
if(!isset($_SESSION['authority_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $enroll_id = $_POST['enroll_id'];
    $admin_id = $_SESSION['authority_id'];
    $action = $_POST['action'];

    if ($action == "approve") {
        // 1. Update Student Verified_status
        $updateStudent = "UPDATE Student SET Verified_status = '1' WHERE Student_Id = '$student_id'";
        
        // 2. Insert into Checks table as per your schema
        $insertCheck = "INSERT INTO Checks (Authority_Id, Enrollment_id) VALUES ('$admin_id', '$enroll_id')";
        
        if (mysqli_query($conn, $updateStudent) && mysqli_query($conn, $insertCheck)) {
            header("Location: admin_verify.php?msg=Approved");
        }
    } else {
        // Handle Rejection logic (e.g., delete scan or notify student)
        header("Location: admin_verify.php?msg=Rejected");
    }
}
?>