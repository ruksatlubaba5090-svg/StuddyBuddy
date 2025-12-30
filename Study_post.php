<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Study Buddy | Session Sparks</title>
    <style>
        /* ===== BODY & BACKGROUND ===== */
        body {
            margin: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8cdda 0%, #e6d7ff 100%);
            color: #4b4453;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ===== HEADER ===== */
        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            box-sizing: border-box;
        }

        .header-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .nav-links a {
            padding: 10px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            color: #4b4453;
            font-weight: 600;
            transition: 0.3s;
            backdrop-filter: blur(5px);
        }

        .nav-links a:hover {
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* ===== MAIN CONTENT ===== */
        .container {
            width: 90%;
            max-width: 900px;
            margin-top: 20px;
        }

        /* ===== CREATE POST SECTION ===== */
        .create-post-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        .create-post-card h2 {
            margin-top: 0;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        input, select, textarea {
            border: 1px solid rgba(196, 181, 253, 0.5);
            padding: 14px;
            border-radius: 12px;
            background: white;
            font-size: 14px;
            outline: none;
        }

        input:focus { border-color: #a78bfa; }

        textarea { grid-column: span 2; height: 100px; }

        .btn-primary {
            grid-column: span 2;
            background: #c084fc;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #a855f7;
            transform: translateY(-2px);
        }

        /* ===== FEED SECTION ===== */
        .feed-header {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .post-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .post-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-badge {
            background: #f3e8ff;
            color: #7c3aed;
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
        }

        .post-user { font-weight: 600; font-size: 17px; }

        .post-description { line-height: 1.6; color: #555; }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f0f0f0;
            padding-top: 15px;
            margin-top: 5px;
        }

        .meta-data { font-size: 14px; color: #888; }

        .btn-interest {
            background: #22c55e;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-interest:hover { background: #16a34a; }

    </style>
</head>
<body>

    <div class="header">
        <div class="header-title">Study Buddy</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Sign Out</a>
        </div>
    </div>

    <div class="container">
        <div class="create-post-card">
            <h2> Post </h2>
            <form action="post_logic.php" method="POST" class="form-grid">
                <input type="text" name="course_code" placeholder="Course Code (e.g., ENG101)" required>
                <input type="text" name="subject_name" placeholder="Subject Topic" required>
                
                <select name="study_type">
                    <option value="Exam Prep">Exam Prep</option>
                    <option value="Homework">Homework Help</option>
                    <option value="Deep Work">Deep Work / Silent</option>
                </select>

                <input type="datetime-local" name="study_time" required>

                <textarea name="description" placeholder="Share what you're working on..."></textarea>
                
                <button type="submit" class="btn-primary">Post Session</button>
            </form>
        </div>

        <div class="feed-header">Active Sessions</div>

        <div class="post-card">
            <div class="post-top">
                <span class="post-user">Sarah Miller</span>
                <span class="course-badge">BIO204</span>
            </div>
            <div class="post-description">
                Working on the lab report for Cellular Respiration. If anyone has the data from Tuesday's class, let's compare!
            </div>
            <div class="post-meta">
                <div class="meta-data">
                    📅 Dec 28 | 🕒 5:30 PM | 👥 3 Interested
                </div>
                <button class="btn-interest">Join In</button>
            </div>
        </div>
    </div>

</body>
</html>