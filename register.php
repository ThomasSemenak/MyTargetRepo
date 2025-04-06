<?php
// Azure SQL Database connection settings
$serverName = "ts19cpsqldb.database.windows.net,1433";
$database = "ts19cpdb3p96";
$username = "ts19cp";
$password = "@Group93p96";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user input (more validation/sanitization is recommended)
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $phoneNumber = !empty($_POST["phonenumber"]) ? $_POST["phonenumber"] : null;
    $plainPassword = $_POST["password"];
    
    // In production, hash the password securely.
    // $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
    // For demonstration purposes, we're using the plain text (do not do this in production!)
    $hashedPassword = $plainPassword;

    try {
        // Create a new PDO connection to the Azure SQL Database
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a parameterized SQL statement to prevent SQL injection
        $sql = "INSERT INTO users2 (firstname, lastname, email, phonenumber, [password])
                VALUES (:firstname, :lastname, :email, :phonenumber, :password)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phonenumber', $phoneNumber);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the statement
        $stmt->execute();

        // Updated success message with a login hyperlink
        $message = "Registration successful! You may now <a href='login.php'>login</a>.";
    } catch (PDOException $e) {
        // In production, log errors and display a generic error message to the user.
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($message)) { echo "<p>" . $message . "</p>"; } ?>
    <form method="post" action="">
        <div>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required />
        </div>
        <div>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required />
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />
        </div>
        <div>
            <label for="phonenumber">Phone Number:</label>
            <input type="text" id="phonenumber" name="phonenumber" />
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Register</button>
    </form>
</body>
</html>
