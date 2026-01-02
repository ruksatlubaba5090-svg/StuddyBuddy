<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'config.php';

$student_id = $_SESSION['user_id'];

$q = "SELECT Name FROM student WHERE Student_id = '$student_id'";
$result = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($result);
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Dashboard</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
    position: relative;
    overflow-x: hidden;
}

/* HEADER */
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

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-right a.logout-btn {
    padding: 8px 18px;
    border-radius: 20px;
    background: #c084fc;
    color: white;
    text-decoration: none;
    font-weight: 600;
}

.header-right a.logout-btn:hover {
    background: #a855f7;
}

.header-right a.profile-link {
    display: inline-block;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #c084fc;
    border: 3px solid white;
    text-decoration: none;
}

/* DASHBOARD BOX */
.dashboard-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-top: 80px;
}

.dashboard-box {
    background: rgba(255, 255, 255, 0.9);
    width: 400px;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    text-align: center;
}

.dashboard-box h2 {
    color: #4b4453;
    margin-bottom: 20px;
}

.dashboard-box p {
    font-size: 16px;
    color: #374151;
    margin-bottom: 25px;
}

/* LINKS */
.dashboard-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.dashboard-links a {
    padding: 10px 18px;
    border-radius: 10px;
    background: #7c3aed;
    color: white;
    text-decoration: none;
    font-weight: 500;
}

.dashboard-links a:hover {
    background: #6b21a8;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="header-title">Study Buddy</div>
    <div class="header-right">
        <!-- Profile picture linking to My Profile -->
        <a href="My_Profile.php" class="profile-link" title="My Profile"></a>
        <!-- Logout -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- DASHBOARD CONTENT -->
<div class="dashboard-container">
    <div class="dashboard-box">
        <h2>Welcome <?php echo htmlspecialchars($row['Name']); ?>!</h2>
        <p>Same Course, Same Time, Better Results</p>

        <div class="dashboard-links">
            <a href="enrollment.php">My Courses</a>
            <a href="Activity_feed.php">Activity Feed</a>
            <a href="Study_post.php">Post</a>
        </div>
    </div>
</div>

</body>
</html>
