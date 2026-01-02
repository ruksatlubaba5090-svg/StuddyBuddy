<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_POST['post_id'];
$student_id = $_SESSION['user_id'];

$sql = "INSERT IGNORE INTO interested_student (Post_ID, Student_id, status)
        VALUES ('$post_id', '$student_id', 'pending')";

mysqli_query($conn, $sql);

header("Location: Activity_feed.php");
exit();
