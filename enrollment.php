<?php
session_start();
include 'Config.php';

/* =========================
   1. Security Check
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];
$message = "";

/* =========================
   2. Enrollment Logic
========================= */
if (isset($_POST['enroll'])) {

    $course_code = $_POST['Course_code'];
    $course_name = $_POST['Course_Name'];
    $section     = $_POST['Section'];
    $input_code  = $_POST['Enrollment_ID'];

    /* Check if course exists + enrollment code matches */
    $stmt = $conn->prepare(
        "SELECT Enrollment_ID 
         FROM course_enrollment 
         WHERE Course_code = ? 
         AND Course_Name = ? 
         AND Section = ?"
    );
    $stmt->bind_param("sss", $course_code, $course_name, $section);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    if (!$course) {
        $message = "<div class='error'>Course not found.</div>";
    } elseif ($course['Enrollment_ID'] !== $input_code) {
        $message = "<div class='error'>Invalid Enrollment Code!</div>";
    } else {

        /* Check if already enrolled */
        $check = $conn->prepare(
            "SELECT * 
             FROM course_enrollment 
             WHERE Student_ID = ? 
             AND Course_code = ? 
             AND Course_Name = ? 
             AND Section = ?"
        );
        $check->bind_param("isss", $uid, $course_code, $course_name, $section);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            $message = "<div class='error'>You are already enrolled in this course.</div>";
        } else {

            /* Enroll student */
            $enroll = $conn->prepare(
                "INSERT INTO course_enrollment 
                 (Student_ID, Course_code, Course_Name, Section) 
                 VALUES (?, ?, ?, ?)"
            );
            $enroll->bind_param("isss", $uid, $course_code, $course_name, $section);
            $enroll->execute();

            $message = "<div class='success'>Enrolled successfully!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Enroll Courses</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background: rgba(255,255,255,0.7);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.header-title {
    font-size: 32px;
    font-weight: bold;
    color: #4b4453;
}
.header-home a {
    padding: 8px 18px;
    border-radius: 20px;
    background: #c084fc;
    color: white;
    text-decoration: none;
    font-weight: 600;
}

/* Container FIXED */
.container {
    display: flex;
    justify-content: center;
    margin-top: 80px;
    padding-bottom: 80px;
}

/* Card */
.card {
    background: rgba(255,255,255,0.95);
    width: 520px;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    text-align: center;
}

select, input {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: #7c3aed;
    color: white;
    font-size: 16px;
    cursor: pointer;
}
button:hover {
    background: #6b21a8;
}

.success {
    color: green;
    font-weight: 600;
    margin-top: 15px;
}
.error {
    color: red;
    font-weight: 600;
    margin-top: 15px;
}
</style>
</head>

<body>

<div class="header">
    <div class="header-title">Study Buddy</div>

    <div class="header-home">
        <a href="Student_Dashboard.php">Dashboard</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>


<div class="container">
    <div class="card">
        <h2>Enroll Courses</h2>
        <p>Select your course details and enter the enrollment code</p>

        <form method="POST">

            <select name="course_code" required>
                <option value="">-- Select Course Code --</option>
                <?php
                $codes = $conn->query("SELECT DISTINCT Course_code FROM course_enrollment");
                while ($c = $codes->fetch_assoc()) {
                    echo "<option value='{$c['Course_code']}'>{$c['course_code']}</option>";
                }
                ?>
            </select>

            <select name="course_name" required>
                <option value="">-- Select Course Name --</option>
                <?php
                $names = $conn->query("SELECT DISTINCT Course_Name FROM course_enrollment");
                while ($n = $names->fetch_assoc()) {
                    echo "<option value='{$n['Course_Name']}'>{$n['Course_Name']}</option>";
                }
                ?>
            </select>

            <select name="section" required>
                <option value="">-- Select Section --</option>
                <?php
                $sections = $conn->query("SELECT DISTINCT Section FROM course_enrollment");
                while ($s = $sections->fetch_assoc()) {
                    echo "<option value='{$s['Section']}'>{$s['Section']}</option>";
                }
                ?>
            </select>


            <button type="submit" name="enroll">Enroll Now</button>
        </form>

        <?= $message ?>
    </div>
</div>

</body>
</html>
