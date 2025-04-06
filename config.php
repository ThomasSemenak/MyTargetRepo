<?php
// config.php
$serverName = "ts19cpsqldb.database.windows.net,1433";
$database   = "ts19cpdb3p96";
$username   = "ts19cp";
$password   = "@Group93p96";

try {
    // Use the PDO SQL Server driver
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
