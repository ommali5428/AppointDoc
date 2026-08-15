<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '3306';
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');


/*
|--------------------------------------------------------------------------
| Check environment variables
|--------------------------------------------------------------------------
*/

if (!$host || !$user || !$db) {
    die("Database environment variables are missing.");
}


/*
|--------------------------------------------------------------------------
| MySQLi connection
|--------------------------------------------------------------------------
*/

$conn = mysqli_connect(
    $host,
    $user,
    $pass,
    $db,
    (int)$port
);

if (!$conn) {
    die("MySQLi connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");


/*
|--------------------------------------------------------------------------
| PDO connection
|--------------------------------------------------------------------------
*/

try {

    $dbh = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    die("PDO connection failed: " . $e->getMessage());

}