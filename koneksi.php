<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koneksi Database</title>
</head>

<body>
    <?php
// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection parameters
$databaseHost = 'localhost';
$databaseName = 'sales_hp';
$databaseUsername = 'root';
$databasePassword = '';

// Create a new MySQLi connection
$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set default timezone
date_default_timezone_set('Asia/Jakarta');
?>

</body>

</html>