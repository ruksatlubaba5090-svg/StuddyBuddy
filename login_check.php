<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check student credentials
    $query = "SELECT Student_Id, Password FROM Student WHERE Username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // If passwords are stored as plain text
        if ($password == $row['Password']) {

            // Set session
            $_SESSION['student_id'] = $row['Student_Id'];

            // Redirect to dashboard
            header("Location: Dashboard.php");
            exit();

        } else {
            echo "<script>alert('Incorrect password'); window.location='login.php';</script>";
        }

    } else {
        echo "<script>alert('User not found'); window.location='login.php';</script>";
    }
}
?>
