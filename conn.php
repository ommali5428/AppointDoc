<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

/* MySQLi connection */
$conn = mysqli_connect(
    $host,
    $user,
    $pass,
    $db,
    $port
);

if (!$conn) {
    die("MySQLi connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");


/* PDO connection */
try {
    $dbh = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("PDO connection failed: " . $e->getMessage());
}