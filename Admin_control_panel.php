<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Study Buddy | Admin Verification</title>
    <style>
        body {
            margin: 0; font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8cdda, #e6d7ff);
            display: flex; flex-direction: column; align-items: center; min-height: 100vh;
        }
        .admin-container { width: 90%; max-width: 1000px; margin-top: 40px; }
        .header { width: 100%; display: flex; justify-content: space-between; padding: 20px 60px; box-sizing: border-box; }
        .header-title { font-size: 24px; font-weight: bold; color: #4b4453; }
        
        .verify-card {
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);
            border-radius: 20px; padding: 25px; margin-bottom: 20px;
            display: grid; grid-template-columns: 1fr 2fr 1fr; align-items: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.05);
        }
        .student-info h3 { margin: 0; color: #4b4453; }
        .student-info p { margin: 5px 0; color: #777; font-size: 14px; }
        
        .id-preview img {
            width: 150px; height: 100px; object-fit: cover;
            border-radius: 10px; border: 2px solid #c084fc; cursor: pointer;
        }
        
        .actions { display: flex; gap: 10px; justify-content: flex-end; }
        .btn { padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-approve { background: #22c55e; color: white; }
        .btn-approve:hover { background: #16a34a; }
        .btn-reject { background: #ef4444; color: white; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-title">Admin Control Panel</div>
    <div class="nav-links"><a href="logout.php" style="text-decoration:none; color:#4b4453;">Logout</a></div>
</div>

<div class="admin-container">
    <h2 style="color: #4b4453;">Pending Verifications</h2>

    <?php
    // Example: SELECT * FROM Student WHERE Verified_status = '0'
    // For each student, display this card:
    ?>
    <div class="verify-card">
        <div class="student-info">
            <h3>Sarah Miller</h3>
            <p>ID: 2023-001 | Dept: CS</p>
            <p>Year: 2nd Year</p>
        </div>
        
        <div class="id-preview">
            <img src="uploads/ids/example_scan.jpg" alt="ID Scan Preview">
            <p style="font-size: 10px; color: #888;">Click to enlarge scan</p>
        </div>

        <form action="verify_logic.php" method="POST" class="actions">
            <input type="hidden" name="student_id" value="STUDENT_ID_HERE">
            <input type="hidden" name="enroll_id" value="ENROLL_ID_HERE">
            <button type="submit" name="action" value="approve" class="btn btn-approve">Approve</button>
            <button type="submit" name="action" value="reject" class="btn btn-reject">Reject</button>
        </form>
    </div>
    </div>

</body>
</html>