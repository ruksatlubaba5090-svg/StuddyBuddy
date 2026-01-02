<?php
session_start();
include 'config.php';

/* ADMIN AUTH CHECK */
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

/* FETCH ADMIN INFO */
$admin_query = "SELECT Username, Email FROM admin WHERE Admin_ID = '$admin_id'";
$admin_result = mysqli_query($conn, $admin_query);

if (!$admin_result) {
    die("Error fetching admin info: " . mysqli_error($conn));
}

$admin = mysqli_fetch_assoc($admin_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | Study Buddy</title>

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
    <div class="header-title">Admin Dashboard</div>
    <div class="header-right">
        <!-- Profile picture linking to My Profile -->
        <a href="Admin_profile.php" class="profile-link" title="My Profile"></a>
        <!-- Logout -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- DASHBOARD CONTENT -->
<div class="dashboard-container">
    <div class="dashboard-box">
        <h2>Welcome <?php echo htmlspecialchars($admin['Username']); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($admin['Email']); ?></p>
        <p>Manage your platform efficiently and securely.</p>

        <div class="dashboard-links">
            <a href="Admin_verify.php">Verify Students</a>
            <a href="feed.php">Activity feed</a>
            <a href="reports.php">Reports</a>
        </div>
    </div>
</div>

</body>
</html>
