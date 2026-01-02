<?php
session_start();
include 'config.php';

// Redirect if user isn't logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

// Check verification status
$check = mysqli_query($conn, "SELECT Verified_status FROM student WHERE Student_id = '$uid'");
$row = mysqli_fetch_assoc($check);

// If already verified → go to enrollment
if ($row['Verified_status'] == 1) {
    header("Location: enrollment.php");
    exit();
}

// Optional: You can fetch username if you want to personalize
$username_query = mysqli_query($conn, "SELECT Username FROM student WHERE Student_ID = '$uid'");
$user_row = mysqli_fetch_assoc($username_query);
$username = $user_row['Username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Please Wait</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
    display: flex;
    justify-content: center;
    align-items: center;
}

.verify-card {
    background: rgba(255, 255, 255, 0.9);
    width: 400px;
    padding: 50px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    text-align: center;
}

.loader {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #7c3aed;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.status-badge {
    background: #e6d7ff;
    color: #7c3aed;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 15px;
}

h2 { color: #4b4453; margin: 10px 0; }
p { color: #636e72; font-size: 16px; line-height: 1.5; }

.progress-bar-container {
    width: 80%;
    height: 6px;
    background: #eee;
    border-radius: 10px;
    margin-top: 20px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: #7c3aed;
    width: 0%;
    animation: fillProgress 5s linear forwards;
}

@keyframes fillProgress {
    0% { width: 0%; }
    100% { width: 100%; }
}
</style>

<!-- Auto-refresh every 5 seconds to check verification -->
<meta http-equiv="refresh" content="5">
</head>
<body>

<div class="verify-card">
    <div class="loader"></div>
    <div class="status-badge">Processing</div>
    <h2>Verification in Progress</h2>
    <p>
        Please wait, <b><?php echo htmlspecialchars($username); ?></b>.<br>
        Admin is reviewing your profile and ID documents.
    </p>

    <div class="progress-bar-container">
        <div class="progress-fill"></div>
    </div>
</div>

</body>
</html>
