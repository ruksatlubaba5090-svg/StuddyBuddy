<?php
session_start();
include 'config.php';

$post_id = $_POST['post_id'];
$selected = $_POST['students'] ?? [];
$owner_id = $_SESSION['user_id'];

// Get post info
$check = mysqli_query($conn, "
    SELECT 1 
    FROM study_post 
    WHERE Post_ID='$post_id' 
    AND Student_ID='$owner_id'
");

if (mysqli_num_rows($check) == 0) {
    die("Unauthorized");
}	
$post = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM study_post WHERE Post_ID='$post_id'
"));

$max = $post['max_members'];

if (count($selected) > $max) {
    die("You can only select $max students.");
}

// Accept selected
foreach ($selected as $sid) {
    mysqli_query($conn, "
        UPDATE interested_student
        SET status='accepted'
        WHERE Post_ID='$post_id' AND Student_id='$sid'
    ");
}

// Reject others
mysqli_query($conn, "
    UPDATE interested_student
    SET status='rejected'
    WHERE Post_ID='$post_id' AND status='pending'
");
$check = mysqli_query($conn, "
    SELECT 1 FROM study_post
    WHERE Post_ID='$post_id' AND Student_ID='$owner_id'
");

header("Location: owner_interest.php? post_id=$post_id");
exit()
?>