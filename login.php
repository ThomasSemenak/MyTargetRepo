<?php
// login.php
session_start();

// If user is already logged in, redirect to welcome page
if(isset($_SESSION['UserName'])) {
    header("Location: index.php");
    exit();
}

require 'config.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $passwordInput = trim($_POST['password']);
    
    // Updated query to match the new users3 table structure.
    $query = "SELECT id, username, [password] FROM users3 WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user) {
        // In production, use password_hash() and password_verify() for security.
        if($passwordInput == $user['password']) {
            $_SESSION['UserName'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Invalid email or password.";
        }
    } else {
        $errorMessage = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Global styling and form-specific styling -->
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <link rel="stylesheet" type="text/css" href="styles/login-register.css">
</head>
<body>
    <div class="main-container">
        <div class="content-container">
            <h2>Login</h2>
            <?php if(isset($_GET['success'])): ?>
                <p style="color:green;">Registration successful! Please login.</p>
            <?php endif; ?>
            <?php if($errorMessage != ""): ?>
                <p style="color:red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <div class="form-container">
                <form method="post" action="login.php" class="main-form">
                    <input type="text" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Login">
                </form>
                <div class="login-signup-redirect">
                    <p>Don't have an account?</p>
                    <a href="register.php" class="login-signup-link">Register here</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
