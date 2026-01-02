<?php
include 'config.php';
session_start();

/* Redirect if not logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];


/* Student Info */
$student_q = "SELECT * FROM student WHERE Student_id = '$student_id'";
$student_res = mysqli_query($conn, $student_q);
$student = mysqli_fetch_assoc($student_res);

/* Stats */
/* Sessions hosted by the student */
$host_count = mysqli_num_rows(mysqli_query(
    $conn, "SELECT * FROM study_post WHERE Student_ID = '$student_id'"
));

/* Sessions joined by the student */
$join_count = mysqli_num_rows(mysqli_query(
    $conn, "SELECT * FROM interested_student WHERE Interested_Student_ID = '$student_id'"
));

$total_points = ($host_count * 10) + ($join_count * 5);

/* Courses enrolled */
$courses = mysqli_query($conn, "
    SELECT Course_code, Course_Name
    FROM Course_Enrollment
    WHERE Student_ID = '$student_id' AND Semester = 'Present'
");

/* Feed posts for student's courses */
$posts = mysqli_query($conn, "
    SELECT p.*, s.Name AS Author
    FROM study_post p
    JOIN student s ON p.Student_ID = s.Student_id
    JOIN course_enrollment e ON p.Course_code = e.Course_code
    WHERE e.Student_ID = '$student_id' AND e.Semester = 'Present'
    ORDER BY p.Post_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | My Profile</title>

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

/* FEED */
.feed-item {
    background: white;
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 5px solid #c084fc;
}
.btn-join {
    background: #c084fc;
    color: white;
    border: none;
    padding: 8px 18px;
    border-radius: 10px;
    cursor: pointer;
    float: right;
}
.btn-join:hover {
    background: #a855f7;
}

/* COURSES */
.sidebar {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    padding: 25px;
    border-radius: 20px;
    margin-top: 30px;
}
.course-item {
    background: #f3e8ff;
    padding: 8px 12px;
    border-radius: 10px;
    margin-bottom: 10px;
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
        <h1><?php echo $student['Name']; ?></h1>
        <p><?php echo $student['Department']; ?> | Year <?php echo $student['Year']; ?></p>
    </div>

    <!-- 📖 COURSE FEED -->
    <h2>📖 My Course Feed</h2>

    <?php if ($posts && mysqli_num_rows($posts) > 0): ?>
        <?php while ($p = mysqli_fetch_assoc($posts)): ?>
            <div class="feed-item">
                <form action="join_logic.php" method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $p['Post_ID']; ?>">
                    <button class="btn-join">Join</button>
                </form>

                <h4><?php echo $p['Subject_Name']; ?></h4>
                <p><?php echo $p['Description']; ?></p>
                <small>
                    📅 <?php echo date('M d, H:i', strtotime($p['Study_Time'])); ?>
                    | 👤 <?php echo $p['Author']; ?>
                </small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="feed-item">No study sessions available.</div>
    <?php endif; ?>

    <!-- 📚 COURSES -->
    <div class="sidebar">
        <h3>📚 Current Courses</h3>
        <hr>
        <?php while ($c = mysqli_fetch_assoc($courses)): ?>
            <div class="course-item">
                <strong><?php echo $c['Course_Code']; ?></strong><br>
                <small><?php echo $c['Course_Name']; ?></small>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- ⬇️ SESSION STATS AT BOTTOM -->
    <div class="profile-card">
        <h2 style="text-align:center; margin-bottom:30px;">📜 Session History</h2>
        <div class="stats">
            <div class="stat-box">
                <h2><?php echo $total_points; ?></h2>
                <p>Sessions Cancelled</p>
            </div>
            <div class="stat-box">
                <h2><?php echo $host_count; ?></h2>
                <p>Sessions Hosted</p>
            </div>
            <div class="stat-box">
                <h2><?php echo $join_count; ?></h2>
                <p>Sessions Joined</p>
            </div>
        </div>
    </div>
</div>
	<div class="profile-top">
	<div style="text-align:center; margin-bottom:40px;">
    <a href="my_posts.php" 
       style="
           display:inline-block;
           padding:12px 26px;
           background:#7c3aed;
           color:white;
           text-decoration:none;
           border-radius:14px;
           font-weight:600;
       ">
        ✏️ Manage My Posts
    </a>
    </div>


</div>

</body>
</html>
