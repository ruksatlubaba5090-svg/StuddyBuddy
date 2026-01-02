<?php
session_start();
include 'config.php';

$post_id = $_GET['post_id'];
$owner_id = $_SESSION['user_id'];

// Verify ownership
$check = mysqli_query($conn, "
    SELECT * FROM study_post
    WHERE Post_ID='$post_id' AND Student_ID='$owner_id'
");	

$emails = mysqli_query($conn, "
    SELECT s.Email
    FROM interested_student pi
    JOIN student s ON pi.Student_id = s.Student_id
    WHERE pi.Post_ID='$post_id' AND pi.status='accepted'
");

if (mysqli_num_rows($check) == 0) {
    die("Unauthorized");
}

$post = mysqli_fetch_assoc($check);

$interests = mysqli_query($conn, "
    SELECT pi.*, s.Username, s.Email
    FROM interested_student pi
    JOIN student s ON pi.Student_id = s.Student_id
    WHERE pi.Post_ID='$post_id' AND pi.status='pending'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Interested Students</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
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
    gap: 15px;
}

.logout-btn {
    padding: 8px 18px;
    border-radius: 20px;
    background: #c084fc;
    color: white;
    text-decoration: none;
    font-weight: 600;
}

/* CONTENT */
.dashboard-container {
    display: flex;
    justify-content: center;
    margin-top: 60px;
}

.dashboard-box {
    background: rgba(255, 255, 255, 0.95);
    width: 500px;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.dashboard-box h2 {
    text-align: center;
    color: #4b4453;
    margin-bottom: 20px;
}

.student-list label {
    display: block;
    background: #f3e8ff;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    font-weight: 500;
}

.student-list input {
    margin-right: 10px;
}

.accept-btn {
    width: 100%;
    margin-top: 15px;
    padding: 12px;
    background: #22c55e;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

.accept-btn:hover {
    background: #16a34a;
}

.email-box {
    margin-top: 30px;
}

.email-box h3 {
    color: #4b4453;
    margin-bottom: 10px;
}

.email-box ul {
    padding-left: 20px;
}

.email-box li {
    font-size: 14px;
    color: #374151;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="header-title">Study Buddy</div>
    <div class="header-right">
        <a href="Student_Dashboard.php" class="logout-btn">Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="dashboard-container">
    <div class="dashboard-box">

        <h2>Interested Students</h2>

        <form action="accept_students.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">

            <div class="student-list">
                <?php if (mysqli_num_rows($interests) > 0): ?>
                    <?php while($i = mysqli_fetch_assoc($interests)): ?>
                        <label>
                            <input type="checkbox" name="students[]" value="<?= $i['Student_id'] ?>">
                            <?= htmlspecialchars($i['Username']) ?>
                        </label>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center;">No pending requests.</p>
                <?php endif; ?>
            </div>

            <?php if (mysqli_num_rows($interests) > 0): ?>
                <button type="submit" class="accept-btn">Accept Selected</button>
            <?php endif; ?>
        </form>

        <div class="email-box">
            <h3>Accepted Students Emails</h3>
            <ul>
                <?php while($e = mysqli_fetch_assoc($emails)): ?>
                    <li><?= htmlspecialchars($e['Email']) ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

    </div>
</div>

</body>
</html>
