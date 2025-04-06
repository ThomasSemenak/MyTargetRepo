<?php
// welcome.php
session_start();

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['UserName'])) {
    header("Location: login.php");
    exit();
}

   
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <!-- Include the header -->
    <?php include 'header.php';
    echo "Your User ID is:". htmlspecialchars($_SESSION['user_id']); ?>

    <!-- Main content area -->
    <div>
        <h2>Dashboard</h2>
        <p>This is the main content area of your dashboard.</p>
    </div>
</body>
</html>
