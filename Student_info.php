<?php
session_start();
include 'config.php';

if (!isset($_SESSION['new_student_id'])) {
    header("Location: signup.php");
    exit();
}

$student_id = $_SESSION['new_student_id'];

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $student_code = $_POST['student_code'];

    // Create directories
    $id_dir = "uploads/ids/";
    $profile_dir = "uploads/profiles/";

    if (!is_dir($id_dir)) mkdir($id_dir, 0777, true);
    if (!is_dir($profile_dir)) mkdir($profile_dir, 0777, true);

    // ID Scan
    $id_file = time() . "_id_" . $_FILES['id_scan']['name'];
    $id_path = $id_dir . $id_file;

    // Profile Photo
    $profile_file = time() . "_profile_" . $_FILES['profile_photo']['name'];
    $profile_path = $profile_dir . $profile_file;

    if (
        !move_uploaded_file($_FILES['id_scan']['tmp_name'], $id_path) ||
        !move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profile_path)
    ) {
        die("File upload failed");
    }

    $stmt = $conn->prepare(
    "UPDATE student 
     SET Name=?, 
         Department=?, 
         Year=?, 
         Student_id=?, 
         ID_scan=?, 
         Profile_photo=?, 
         profile_done=1
     WHERE Student_ID=?"
);


    $stmt->bind_param(
        "ssssssi",
        $name,
        $department,
        $year,
        $student_code,
        $id_path,
        $profile_path,
        $student_id
    );

    if ($stmt->execute()) {
    unset($_SESSION['new_student_id']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Submission Successful | Study Buddy</title>

    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #f8cdda, #e6d7ff);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .success-card {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(12px);
        border-radius: 30px;
        padding: 50px 45px;
        text-align: center;
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        max-width: 420px;
    }
    .success-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #c084fc;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 40px;
        font-weight: bold;
    }
    .success-card h2 {
        margin: 15px 0 10px;
        color: #4b4453;
    }
    .success-card p {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 30px;
    }
    .btn-login {
        display: inline-block;
        padding: 12px 26px;
        background: #c084fc;
        color: white;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-login:hover {
        background: #a855f7;
    }
    </style>
    </head>

    <body>

    <div class="success-card">
        <div class="success-icon">✓</div>
        <h2>Information Submitted</h2>
        <p>
            Your details have been successfully submitted.<br>
            Please wait for admin verification before logging in.
        </p>
        <a href="login.php" class="btn-login">Go to Login</a>
    </div>

    </body>
    </html>
    <?php
    exit();
}
 else {
        die("Database error");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Complete Profile</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
}

.container {
    max-width: 600px;
    margin: 80px auto;
    padding: 0 20px;
}

/* CARD */
.profile-card {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(12px);
    border-radius: 30px;
    padding: 40px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

/* TOP */
.profile-top {
    text-align: center;
    margin-bottom: 35px;
}
.avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #c084fc;
    margin: 0 auto 15px;
    border: 5px solid white;
}
.profile-top h2 {
    margin: 10px 0 5px;
    color: #4b4453;
}
.profile-top p {
    color: #6b7280;
    font-size: 14px;
}

/* INPUTS */
input {
    width: 100%;
    padding: 12px;
    margin-bottom: 14px;
    border-radius: 12px;
    border: 1px solid #c4b5fd;
    font-size: 14px;
}

input:focus {
    outline: none;
    border-color: #a855f7;
}

/* FILE INPUT */
label {
    font-size: 14px;
    color: #4b4453;
}
input[type="file"] {
    background: white;
}

/* BUTTON */
button {
    width: 100%;
    padding: 14px;
    margin-top: 10px;
    background: #c084fc;
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    cursor: pointer;
}
button:hover {
    background: #a855f7;
}
</style>
</head>

<body>

<div class="container">

    <div class="profile-card">

        <!-- TOP SECTION -->
        <div class="profile-top">
            <div class="avatar"></div>
            <h2>Complete Your Profile</h2>
            <p>This information is required for verification</p>
        </div>

        <!-- FORM -->
        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="name" placeholder="Full Name" required>

            <input type="text" name="student_code" placeholder="Student ID" required>

            <input type="text" name="department" placeholder="Department" required>

            <input type="text" name="year" placeholder="Year (e.g. 2nd Year)" required>

            <label>Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/*" required>

            <label>ID Scan</label>
            <input type="file" name="id_scan" accept="image/*" required>

            <button type="submit" name="submit">Submit Information</button>

        </form>

    </div>

</div>

</body>
</html>
