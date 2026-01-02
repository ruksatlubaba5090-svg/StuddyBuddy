<?php
session_start();
include 'config.php';

/* Security */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

/* Fetch ONLY this student's posts */
$posts = mysqli_query($conn, "
    SELECT *
    FROM study_post
    WHERE Student_ID = '$student_id'
    ORDER BY Post_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Study Posts</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#f8cdda,#e6d7ff);
    margin: 0;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
}

.logo {
    font-size: 24px;
    font-weight: 800;
    color: #4b4453;
}

.nav-links a {
    margin-left: 15px;
    padding: 10px 18px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    color: #4b4453;
    background: rgba(255,255,255,0.6);
    transition: 0.3s;
}

.nav-links a:hover {
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* ===== CONTENT ===== */
.container {
    max-width: 800px;
    margin: 30px auto 40px;
}

.post-card {
    background: white;
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.actions {
    margin-top: 15px;
}

.actions a, .actions button {
    padding: 6px 14px;
    border-radius: 8px;
    border: none;
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
}

.edit {
    background: #22c55e;
    color: white;
}

.delete {
    background: #ef4444;
    color: white;
}
</style>
</head>

<body>

<!-- ===== TOP HEADER ===== -->
<div class="header">
    <div class="logo">Study Buddy</div>

    <div class="nav-links">
        <a href="Student_Dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="container">
    <h2>📝 My Study Posts</h2>

    <?php if (mysqli_num_rows($posts) > 0): ?>
        <?php while ($p = mysqli_fetch_assoc($posts)): ?>
            <div class="post-card">
                <h4><?= htmlspecialchars($p['Subject_name']) ?></h4>
                <p><?= nl2br(htmlspecialchars($p['Description'])) ?></p>

                <small>
                    📅 <?= date('M d, Y H:i', strtotime($p['Study_time'])) ?>
                </small>

                <div class="actions">
                    <a class="edit" href="edit_post.php?id=<?= $p['Post_ID'] ?>">Edit</a>

                    <a class="edit" href="owner_interest.php?post_id=<?= $p['Post_ID'] ?>">View Interested</a>

                    <form action="delete_post.php" method="POST" style="display:inline;">
                        <input type="hidden" name="post_id" value="<?= $p['Post_ID'] ?>">
                        <button class="delete"
                            onclick="return confirm('Delete this post?')">
                          Delete
                        </button>
                    </form>
                </div>	
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You haven't created any posts yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
