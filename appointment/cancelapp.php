<?php

// ======================================================
// DATABASE CONNECTION
// ======================================================
// cancelapp.php is inside appointment/
// conn.php is one folder above
require_once __DIR__ . '/../conn.php';


// ======================================================
// GET APPOINTMENT NUMBER
// ======================================================

$apid = $_GET['id'] ?? '';


// ======================================================
// VALIDATE APPOINTMENT NUMBER
// ======================================================

if ($apid === '') {

    echo '<script>
        alert("Invalid appointment number.");
        window.location.href="cancel.php";
    </script>';

    exit;
}


// AppointmentNumber in your database is numeric.
$apid = trim($apid);

if (!ctype_digit($apid)) {

    echo '<script>
        alert("Invalid appointment number.");
        window.location.href="cancel.php";
    </script>';

    exit;
}


// ======================================================
// CANCEL APPOINTMENT
// ======================================================

$sql = "
    UPDATE tblappointment
    SET Status = 'Cancelled'
    WHERE AppointmentNumber = :appointmentNumber
";


$query = $dbh->prepare($sql);


$query->bindValue(
    ':appointmentNumber',
    $apid,
    PDO::PARAM_STR
);


$query->execute();


// ======================================================
// CHECK RESULT
// ======================================================

if ($query->rowCount() > 0) {

    echo '<script>
        alert("Appointment has been cancelled successfully.");
        window.location.href="cancel.php";
    </script>';

} else {

    echo '<script>
        alert("Appointment not found or already cancelled.");
        window.location.href="cancel.php";
    </script>';

}

exit;

?>