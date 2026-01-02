<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['post_id'])) {
    header("Location: my_posts.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$post_id = intval($_POST['post_id']); // IMPORTANT

$stmt = $conn->prepare("
    DELETE FROM study_post
    WHERE Post_ID = ?
    AND Student_ID = ?
");

$stmt->bind_param("ii", $post_id, $student_id);
$stmt->execute();

header("Location: my_posts.php");
exit();
