<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/

include('../conn.php');


/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: /login/login_form.php');
    exit();
}


/*
|--------------------------------------------------------------------------
| APPROVED APPOINTMENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM tblappointment WHERE Status = 'Approved'";

$query = $dbh->prepare($sql);
$query->execute();

$totappapt = $query->fetchColumn();


/*
|--------------------------------------------------------------------------
| CANCELLED APPOINTMENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM tblappointment WHERE Status = 'Cancelled'";

$query = $dbh->prepare($sql);
$query->execute();

$totncanapt = $query->fetchColumn();


/*
|--------------------------------------------------------------------------
| TOTAL APPOINTMENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM tblappointment";

$query = $dbh->prepare($sql);
$query->execute();

$totapt = $query->fetchColumn();

?>