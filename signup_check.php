<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: signup.php");
    exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

if ($password !== $confirm) {
    die("Passwords do not match");
}

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    "INSERT INTO student (Username, Email, Password, Verified_status) VALUES (?, ?, ?, 0)"
);
$stmt->bind_param("sss", $username, $email, $hash);

if ($stmt->execute()) {
    $_SESSION['new_student_id'] = $stmt->insert_id;
    header("Location: student_info.php");
    exit();
} else {
    die("Signup failed");
}
