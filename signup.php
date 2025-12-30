<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Sign Up</title>

<style>
/* ===== BODY & BACKGROUND ===== */
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #f8cdda, #e6d7ff);
    position: relative;
    overflow-x: hidden;
}

/* ===== HEADER ===== */
.header {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px 40px;
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
    background: rgba(255,255,255,0.7);
    text-decoration: none;
    color: #4b4453;
    font-size: 15px;
}

.header-home a:hover {
    background: white;
}

/* ===== SIGNUP BOX ===== */
.signup-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 60px;
}

.signup-box {
    background: rgba(255, 255, 255, 0.9);
    width: 360px;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    backdrop-filter: blur(6px);
}

.signup-box h2 {
    text-align: center;
    color: #4b4453;
    margin-bottom: 25px;
}

input {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border-radius: 10px;
    border: 1px solid #c4b5fd;
    font-size: 14px;
}

input:focus {
    outline: none;
    border-color: #a78bfa;
}

button {
    width: 100%;
    padding: 12px;
    background: #c084fc;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 12px;
}

button:hover {
    background: #a855f7;
}

/* ===== LOGIN LINK ===== */
.login-text {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #4b4453;
}

.login-text a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
}

.login-text a:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="header-title">Study Buddy</div>
    <div class="header-home">
        <a href="index.php">Home</a>
    </div>
</div>

<!-- SIGNUP FORM -->
<div class="signup-container">
    <div class="signup-box">
        <h2>Sign Up</h2>

        <form action="signup_check.php" method="POST">
            <input type="text" name="username" placeholder="Username" required autocomplete="username">
            <input type="email" name="email" placeholder="Email" required autocomplete="email">
            <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password">
            <button type="submit">Sign Up</button>
        </form>

        <div class="login-text">
            Already have an account?
            <a href="login.php">Login</a>
        </div>
    </div>
</div>

</body>
</html>


