<?php
session_start();
include 'config.php';

/* Redirect if not logged in as admin */
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

/* Admin Info */
$admin_q = "SELECT * FROM admin WHERE Admin_ID = '$admin_id'";
$admin_res = mysqli_query($conn, $admin_q);
$admin = mysqli_fetch_assoc($admin_res);

/* Stats */
/* Number of pending student verifications */
$pending_students = mysqli_num_rows(mysqli_query(
    $conn, "SELECT * FROM student WHERE Verified_status = 0"
));

/* Number of courses in system */
$total_courses = mysqli_num_rows(mysqli_query(
    $conn, "SELECT * FROM course_enrollment"
));

/* Optional: Number of total admins (could be useful for stats) */
$total_admins = mysqli_num_rows(mysqli_query(
    $conn, "SELECT * FROM admin"
));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Profile | Study Buddy</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
}
.container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}

/* TOP PROFILE */
.profile-top {
    text-align: center;
    margin-bottom: 50px;
}
.avatar {
    width: 130px;
    height: 130px;
    background: #c084fc;
    border-radius: 50%;
    margin: 0 auto 15px;
    border: 5px solid white;
}

/* ADMIN LINKS */
.admin-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}
.admin-links a {
    text-decoration: none;
    padding: 12px 25px;
    border-radius: 15px;
    background: #7c3aed;
    color: white;
    font-weight: 500;
    transition: background 0.3s;
}
.admin-links a:hover {
    background: #6b21a8;
}

/* STATS (BOTTOM) */
.profile-card {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    border-radius: 30px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    margin-top: 70px;
}

.stats {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 20px;
}
.stat-box {
    background: white;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
}
.stat-box h2 {
    margin: 0;
    color: #7c3aed;
}
</style>
</head>

<body>

<div class="container">

    <!-- 🔝 PROFILE PICTURE ON TOP -->
    <div class="profile-top">
        <div class="avatar"></div>
        <h1><?php echo htmlspecialchars($admin['Username']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($admin['Email']); ?></p>
        <p>Administrator | Study Buddy</p>

        <!-- ADMIN FUNCTION LINKS -->
        <div class="admin-links">
            <a href="Admin_verify.php">Verify Students</a>
            <a href="manage_courses.php">Manage Courses</a>
            <a href="reports.php">Reports</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- ⬇️ ADMIN STATS AT BOTTOM -->
    <div class="profile-card">
        <h2 style="text-align:center; margin-bottom:30px;">📊 Admin Stats</h2>
        <div class="stats">
            <div class="stat-box">
                <h2><?php echo $pending_students; ?></h2>
                <p>Pending Students</p>
            </div>
            <div class="stat-box">
                <h2><?php echo $total_courses; ?></h2>
                <p>Total Courses</p>
            </div>
            <div class="stat-box">
                <h2><?php echo $total_admins; ?></h2>
                <p>Total Admins</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>
