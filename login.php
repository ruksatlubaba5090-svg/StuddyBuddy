<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Study Buddy | Login</title>

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

/* ===== FLOATING DOODLES ===== */
/* Top-left */
body::before {
    content: "";
    position: fixed;
    top: 20px;
    left: 20px;
    width: 300px;
    height: 300px;
    z-index: -1;
    opacity: 0.3;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cg fill='none' stroke='black' stroke-width='1.2'%3E%3Ctext x='10' y='40' font-size='28'%3E∫x dx%3C/text%3E%3Ctext x='120' y='90' font-size='26'%3EF = ma%3C/text%3E%3Ctext x='40' y='160' font-size='24'%3EH₂O%3C/text%3E%3C/text%3E%3C/g%3E%3C/svg%3E");
}

/* Top-right */
body::after {
    content: "";
    position: fixed;
    top: 20px;
    right: 20px;
    width: 300px;
    height: 300px;
    z-index: -1;
    opacity: 0.3;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cg fill='none' stroke='black' stroke-width='1.2'%3E%3Ctext x='50' y='40' font-size='24'%3Eπr²%3C/text%3E%3Ctext x='120' y='80' font-size='26'%3EDNA%3C/text%3E%3Ccircle cx='250' cy='50' r='12'/%3E%3C/g%3E%3C/svg%3E");
}

/* Bottom-left */
#bottom-left-doodles {
    position: fixed;
    bottom: 20px;
    left: 20px;
    width: 300px;
    height: 300px;
    z-index: -1;
    opacity: 0.3;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cg fill='none' stroke='black' stroke-width='1.2'%3E%3Ctext x='10' y='40' font-size='24'%3EH₂O%3C/text%3E%3Ctext x='120' y='90' font-size='22'%3ECO₂%3C/text%3E%3Ctext x='40' y='160' font-size='24'%3EDNA%3C/text%3E%3Ccircle cx='250' cy='250' r='10'/%3E%3C/g%3E%3C/svg%3E");
}

/* Bottom-right */
#bottom-right-doodles {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    height: 300px;
    z-index: -1;
    opacity: 0.3;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cg fill='none' stroke='black' stroke-width='1.2'%3E%3Ctext x='50' y='60' font-size='24'%3Eπr²%3C/text%3E%3Ctext x='100' y='140' font-size='22'%3EDNA%3C/text%3E%3Ccircle cx='300' cy='50' r='12'/%3E%3C/g%3E%3C/svg%3E");
}

/* ===== HEADER ===== */
.header {
    position: relative;
    display: flex;
    justify-content: center; /* keeps Study Buddy centered */
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

/* ===== LOGIN BOX ===== */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 60px;
}

.login-box {
    background: rgba(255, 255, 255, 0.9);
    width: 360px;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    backdrop-filter: blur(6px);
}

.login-box h2 {
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

/* ===== SIGNUP TEXT ===== */
.signup-text {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #4b4453;
}

.signup-text a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
}

.signup-text a:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<!-- BACKGROUND DOODLES -->
<div id="bottom-left-doodles"></div>
<div id="bottom-right-doodles"></div>

<!-- HEADER -->
<div class="header">
    <div class="header-title">Study Buddy</div>
    <div class="header-home">
        <a href="index.php">Home</a>
    </div>
</div>

<!-- LOGIN FORM -->
<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>

        <form action="login_check.php" method="POST">
            <input type="text" name="id" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <div class="signup-text">
            If you don't have an account?
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</div>

</body>
</html>
