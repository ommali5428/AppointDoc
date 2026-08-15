<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "doctor", 3307);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'doctor');
define('DB_PORT', 3307);

try {
    $dbh = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    );

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

?>