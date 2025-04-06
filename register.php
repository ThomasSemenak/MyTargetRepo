<?php
// Azure SQL Database connection settings
$serverName = "ts19cpsqldb.database.windows.net,1433";
$database   = "ts19cpdb3p96";
$username   = "ts19cp";
$password   = "@Group93p96";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user input (additional validation/sanitization is recommended)
    $user = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $plainPassword = trim($_POST["password"]);
    
    // In production, use password_hash() to hash the password securely.
    // For demonstration purposes, we're using plain text (do not use plain text in production!)
    $hashedPassword = $plainPassword;

    try {
        // Create a new PDO connection to the Azure SQL Database
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a parameterized SQL statement to prevent SQL injection
        $sql = "INSERT INTO users3 (username, email, [password])
                VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the statement
        $stmt->execute();

        // Success message with a login hyperlink
        $message = "Registration successful! You may now <a href='login.php'>login</a>.";
    } catch (PDOException $e) {
        // In production, log errors and display a generic error message.
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Include the login-register.css file; adjust the path as needed -->
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <link rel="stylesheet" type="text/css" href="styles/login-register.css">
</head>
<body>
    <div class="main-container">
        <div class="content-container">
            <h2>Register</h2>
            <?php if (isset($message)) { echo "<p>" . $message . "</p>"; } ?>
            <div class="form-container">
                <form method="post" action="" class="main-form">
                    <input type="text" id="username" name="username" placeholder="Username" required />
                    <input type="email" id="email" name="email" placeholder="Email" required />
                    <input type="password" id="password" name="password" placeholder="Password" required />
                    <button type="submit">Register</button>
                </form>
                <div class="login-signup-redirect">
                    <p>Already have an account?</p>
                    <a href="login.php" class="login-signup-link">Login here</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
