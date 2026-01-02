<?php
session_start();
include 'config.php';

if (!isset($_POST['Username'], $_POST['Password'])) {
    die("Form not submitted");
}

$username = mysqli_real_escape_string($conn, $_POST['Username']);
$password = $_POST['Password'];

/* ==========================
   ADMIN LOGIN
========================== */
$admin_sql = "SELECT * FROM admin WHERE Username = ?";
$stmt = $conn->prepare($admin_sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

if ($admin && $admin['Password'] === $password) {
    $_SESSION['user_id'] = $admin['Admin_ID'];
    $_SESSION['user_type'] = 'admin';
    header("Location: Admin_Dashboard.php");
    exit();
}

/* ==========================
   STUDENT LOGIN
========================== */
$student_sql = "SELECT * FROM student WHERE Username = ?";
$stmt = $conn->prepare($student_sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student || !password_verify($password, $student['Password'])) {
    die("Invalid username or password");
}

$_SESSION['user_id'] = $student['Student_id'];
$_SESSION['user_type'] = 'student';

/* ==========================
   🚨 IMPORTANT LOGIC ORDER
========================== */

/* 1️⃣ NOT VERIFIED → PLEASE WAIT */
if ($student['Verified_status'] == 0) {
    header("Location: please_wait.php");
    exit();
}

/* 2️⃣ NOT ENROLLED → ENROLLMENT */
if ($student['enrolled'] == 0) {
    header("Location: enrollment.php");
    exit();
}

/* 3️⃣ EVERYTHING OK → DASHBOARD */
header("Location: Student_Dashboard.php");
exit();
