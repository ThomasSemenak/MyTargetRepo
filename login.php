<?php
// login.php
session_start();

// If user is already logged in, redirect to welcome page
if(isset($_SESSION['UserName'])) {
    header("Location: welcome.php");
    exit();
}

require 'config.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $passwordInput = trim($_POST['password']);
    
    // Prepare a query to retrieve the user's firstname and password and ID
    $query = "SELECT id, firstname, [password] FROM users2 WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user) {
        // In production, use password hashing and verification instead of plain text comparison
        if($passwordInput == $user['password']) {
            $_SESSION['UserName'] = $user['firstname'];
            $_SESSION['user_id']=$user['id'];
            $_SESSION['Last']=$user['lastname'];
            header("Location: welcome.php");
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
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($_GET['success'])): ?>
        <p style="color:green;">Registration successful! Please login.</p>
    <?php endif; ?>
    <?php if($errorMessage != ""): ?>
        <p style="color:red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label>Email:</label>
        <input type="text" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</body>
</html>
