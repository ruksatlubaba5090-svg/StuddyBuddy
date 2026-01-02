<?php
session_start();
include 'Config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$my_id = $_SESSION['user_id'];

// Handle Department Filter
$selected_dept = isset($_GET['dept']) ? $_GET['dept'] : 'All';

// Fetch Posts based on Filter
if ($selected_dept == 'All') {
    $query = "
        SELECT 
            sp.*,
            s.Username
        FROM study_post sp
        JOIN student s ON sp.Student_ID = s.Student_id
        ORDER BY sp.Post_date DESC
    ";
} else {
    $query = "
        SELECT 
            sp.*,
            s.Username
        FROM study_post sp
        JOIN student s ON sp.Student_ID = s.Student_id
        WHERE sp.Department = '$selected_dept'
        ORDER BY sp.Post_date DESC
    ";
}

$posts = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Study Buddy | Activity Feed</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8cdda, #e6d7ff);
        }

        .header {
            display: flex;
            justify-content: center;
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

        .header-home {
            position: absolute;
            right: 40px;
        }

        .header-home a {
            padding: 8px 18px;
            border-radius: 20px;
            background: #c084fc;
            color: white;
            text-decoration: none;
            font-weight: 600;
            margin-left: 10px;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .filter-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            justify-content: center;
        }

        .filter-nav a {
            text-decoration: none;
            background: white;
            padding: 8px 15px;
            border-radius: 20px;
            color: #4b4453;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        .filter-nav a.active {
            background: #7c3aed;
            color: white;
            border-color: #7c3aed;
        }

        .post-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .user-name {
            font-weight: bold;
            color: #7c3aed;
        }

        .dept-badge {
            font-size: 11px;
            background: #f3e8ff;
            color: #7c3aed;
            padding: 4px 10px;
            border-radius: 10px;
            font-weight: bold;
        }

        .post-content {
            color: #374151;
            line-height: 1.6;
        }

        .post-date {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 10px;
        }

        /* Interested button */
        .btn-interest {
            margin-top: 12px;
            padding: 8px 18px;
            background: #22c55e;
            color: white;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-interest:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-title">Study Buddy Feed</div>
    <div class="header-home">
        <a href="Student_Dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="filter-nav">
        <a href="feed.php?dept=All" class="<?= $selected_dept == 'All' ? 'active' : '' ?>">All</a>
        <a href="feed.php?dept=CSE" class="<?= $selected_dept == 'CSE' ? 'active' : '' ?>">CSE</a>
        <a href="feed.php?dept=BBA" class="<?= $selected_dept == 'BBA' ? 'active' : '' ?>">BBA</a>
        <a href="feed.php?dept=Law" class="<?= $selected_dept == 'Law' ? 'active' : '' ?>">Law</a>
        <a href="feed.php?dept=Pharmacy" class="<?= $selected_dept == 'Pharmacy' ? 'active' : '' ?>">Pharmacy</a>
        <a href="feed.php?dept=Architecture" class="<?= $selected_dept == 'Architecture' ? 'active' : '' ?>">Arch</a>
    </div>

    <?php if ($posts->num_rows > 0): ?>
        <?php while ($row = $posts->fetch_assoc()): ?>

            <?php
            // Check if already interested
            $check = $conn->query("
                SELECT 1 FROM interested_student
                WHERE post_id = {$row['Post_ID']}
                AND student_id = $my_id
            ");
            ?>

            <div class="post-card">
                <div class="post-header">
                    <span class="user-name">@<?= htmlspecialchars($row['Username']) ?></span>
                    <span class="dept-badge"><?= htmlspecialchars($row['Department']) ?></span>
                </div>

                <div class="post-content">
                    <?= nl2br(htmlspecialchars($row['Description'])) ?>
                </div>

                <div class="post-date">
                    On <?= date('M d, Y', strtotime($row['Post_date'])) ?>
                </div>

                <!-- Interested Button -->
                <?php if ($row['Student_ID'] != $my_id): ?>
                    <?php if ($check->num_rows > 0): ?>
                        <button class="btn-interest" disabled>Interested</button>
                    <?php else: ?>
                        <form action="interest_logic.php" method="POST">
                            <input type="hidden" name="post_id" value="<?= $row['Post_ID'] ?>">
                            <button type="submit" class="btn-interest">Interested</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align:center; color:#4b4453;">
            No posts found in this department.
        </div>
    <?php endif; ?>

</div>

</body>
</html>
