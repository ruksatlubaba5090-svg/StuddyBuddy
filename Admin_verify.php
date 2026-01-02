<?php
session_start();
include 'config.php';

// Admin login check
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$students_query = "SELECT * FROM student WHERE Verified_status = 0";
$students = mysqli_query($conn, $students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Verification | Study Buddy</title>
<style>
body { margin:0; font-family:'Segoe UI',sans-serif; background: linear-gradient(135deg,#f8cdda,#e6d7ff); display:flex; flex-direction:column; align-items:center; min-height:100vh;}
.admin-container { width:90%; max-width:1000px; margin-top:40px; }
.header { width:100%; display:flex; justify-content:space-between; padding:20px 60px; box-sizing:border-box; }
.header-title { font-size:24px; font-weight:bold; color:#4b4453; }
.verify-card { background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border-radius:20px; padding:25px; margin-bottom:20px; display:grid; grid-template-columns:1fr 2fr 1fr; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,0.05); }
.student-info h3 { margin:0; color:#4b4453; }
.student-info p { margin:5px 0; color:#777; font-size:14px; }
.id-preview img { width:150px; height:100px; object-fit:cover; border-radius:10px; border:2px solid #c084fc; cursor:pointer; }
.actions { display:flex; gap:10px; justify-content:flex-end; }
.btn { padding:10px 20px; border:none; border-radius:10px; cursor:pointer; font-weight:bold; transition:0.3s; }
.btn-approve { background:#22c55e; color:white; }
.btn-approve:hover { background:#16a34a; }
.btn-reject { background:#ef4444; color:white; }
</style>
</head>
<body>

<div class="header">
    <div class="header-title">Admin Control Panel</div>
    <div class="nav-links"><a href="logout.php" style="text-decoration:none; color:#4b4453;">Logout</a></div>
</div>

<div class="admin-container">
<h2 style="color:#4b4453;">Pending Verifications</h2>

<?php if (mysqli_num_rows($students) > 0): ?>

    <?php while($s = mysqli_fetch_assoc($students)): ?>
        <div class="verify-card">
            <div class="student-info">
                <h3><?php echo htmlspecialchars($s['Name']); ?></h3>
                <p>ID: <?php echo htmlspecialchars($s['Student_id']); ?> | Dept: <?php echo htmlspecialchars($s['Department']); ?></p>
                <p>Year: <?php echo htmlspecialchars($s['Year']); ?></p>
            </div>
            <div class="id-preview">
                <img src="<?php echo htmlspecialchars($s['ID_scan']); ?>" alt="ID Scan">
            </div>
            <form action="verify_logic.php" method="POST" class="actions">
                <input type="hidden" name="student_id" value="<?php echo $s['Student_id']; ?>">
                <button type="submit" name="action" value="approve" class="btn btn-approve">Approve</button>
                <button type="submit" name="action" value="reject" class="btn btn-reject">Reject</button>
            </form>
        </div>
    <?php endwhile; ?>

<?php else: ?>

    <div class="verify-card" style="text-align:center; grid-template-columns:1fr;">
        <h3 style="color:#6b7280;">🎉 No Pending Verifications</h3>
        <p style="font-size:14px; color:#9ca3af;">
            All students have been reviewed.
        </p>
    </div>

<?php endif; ?>

</div>
</body>
</html>
