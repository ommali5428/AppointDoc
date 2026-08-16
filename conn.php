<?php

$host = "YOUR_DATABASE_HOST";
$dbname = "YOUR_DATABASE_NAME";
$username = "YOUR_DATABASE_USERNAME";
$password = "YOUR_DATABASE_PASSWORD";

try {
    // PDO connection
    $dbh = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // MySQLi connection
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("MySQLi Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>