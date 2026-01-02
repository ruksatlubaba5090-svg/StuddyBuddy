<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$student_id = $_POST['student_id'];
$action = $_POST['action'];

if ($action === 'approve') {
    $stmt = $conn->prepare("UPDATE student SET Verified_status = 1 WHERE Student_id=?");
} else {
    $stmt = $conn->prepare("DELETE FROM student WHERE Student_id=?");
}

$stmt->bind_param("i", $student_id);
$stmt->execute();

header("Location: Admin_verify.php");
exit();
