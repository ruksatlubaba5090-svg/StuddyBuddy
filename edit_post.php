<?php
session_start();
include 'config.php';

/* ===== SECURITY CHECK ===== */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

/* ===== CHECK POST ID ===== */
if (!isset($_GET['id'])) {
    die("Post ID missing.");
}

$post_id = intval($_GET['id']);

/* ===== FETCH POST (OWNER ONLY) ===== */
$stmt = $conn->prepare("
    SELECT Subject_name, Description, Study_time
    FROM study_post
    WHERE Post_ID = ? AND Student_ID = ?
");
$stmt->bind_param("ii", $post_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Post not found or access denied.");
}

$post = $result->fetch_assoc();

/* ===== UPDATE POST ===== */
if (isset($_POST['update'])) {
    $subject     = trim($_POST['subject']);
    $description = trim($_POST['description']);
    $study_time  = $_POST['study_time'];

    if ($subject === "" || $description === "" || $study_time === "") {
        $error = "All fields are required.";
    } else {
        $update = $conn->prepare("
            UPDATE study_post
            SET Subject_name = ?, Description = ?, Study_time = ?
            WHERE Post_ID = ? AND Student_ID = ?
        ");
        $update->bind_param(
            "sssii",
            $subject,
            $description,
            $study_time,
            $post_id,
            $student_id
        );
        $update->execute();

        header("Location: my_posts.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Study Post</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#f8cdda,#e6d7ff);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.form-box {
    background:white;
    padding:30px;
    border-radius:16px;
    width:420px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

h2 {
    text-align:center;
    margin-bottom:20px;
}

label {
    font-weight:600;
    margin-bottom:5px;
    display:block;
}

input, textarea {
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}

textarea {
    resize:none;
}

button {
    width:100%;
    padding:12px;
    background:#22c55e;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

button:hover {
    background:#16a34a;
}

.error {
    color:red;
    text-align:center;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="form-box">
    <h2>Edit Study Post</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">

        <label>Subject</label>
        <input type="text" name="subject"
               value="<?= htmlspecialchars($post['Subject_name']) ?>" required>

        <label>Study Date & Time</label>
        <input type="datetime-local" name="study_time"
               value="<?= date('Y-m-d\TH:i', strtotime($post['Study_time'])) ?>"
               required>

        <label>Description</label>
        <textarea name="description" rows="6" required><?= 
            htmlspecialchars($post['Description']) ?></textarea>

        <button type="submit" name="update">Update Post</button>
    </form>
</div>

</body>
</html>
