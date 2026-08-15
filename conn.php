<?php

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'doctor';
$dbPort = (int)(getenv('DB_PORT') ?: 3306);

// MySQLi
$conn = mysqli_connect(
    $dbHost,
    $dbUser,
    $dbPass,
    $dbName,
    $dbPort
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// PDO
try {
    $dbh = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}",
        $dbUser,
        $dbPass,
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]
    );

    $dbh->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    exit("Database connection failed: " . $e->getMessage());
}

?>