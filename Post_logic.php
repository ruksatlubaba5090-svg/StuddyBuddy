<?php
session_start();
include 'config.php';

/* 1. Security check */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];


/* 2. Check form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $course_code  = mysqli_real_escape_string($conn, $_POST['course_code']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $study_type   = mysqli_real_escape_string($conn, $_POST['study_type']);
    $description  = mysqli_real_escape_string($conn, $_POST['description']);

    // IMPORTANT PART (FIX)
    // datetime-local example: 2026-01-06T15:00
    $study_time_raw = $_POST['study_time'];

    // Convert to MySQL formats
    $study_time = date('Y-m-d H:i:s', strtotime($study_time_raw)); // full datetime
    $post_date  = date('Y-m-d', strtotime($study_time_raw));      // date only

    /* 3. Insert post */
    $sql = "
        INSERT INTO study_post
        (Student_ID, Course_code, Subject_name, Study_type, Study_time, Post_date, Description)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssss",
        $student_id,
        $course_code,
        $subject_name,
        $study_type,
        $study_time,
        $post_date,
        $description
    );

    if ($stmt->execute()) {
        header("Location: Post_success.php");
 // change if your page name differs
        exit();
    } else {
        echo "Error posting study session.";
    }
}
?>
