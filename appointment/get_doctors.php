<?php

// ======================================================
// AppointDoc - Get Doctors
// ======================================================

// Load database connection.
// conn.php is one directory above the appointment folder.
require_once dirname(__DIR__) . '/conn.php';


// ======================================================
// CHECK SPECIALIZATION ID
// ======================================================

if (
    !isset($_POST['sp_id']) ||
    trim($_POST['sp_id']) === ''
) {
    echo '<option value="">Select Doctor</option>';
    exit;
}


// ======================================================
// GET SPECIALIZATION ID
// ======================================================

$spid = (int) $_POST['sp_id'];


// ======================================================
// GET DOCTORS
// ======================================================

try {

    $sql = $dbh->prepare(
        "SELECT ID, FullName
         FROM tbldoctor
         WHERE Specialization = :spid
         ORDER BY FullName ASC"
    );

    $sql->bindValue(
        ':spid',
        $spid,
        PDO::PARAM_INT
    );

    $sql->execute();


    // ==================================================
    // DEFAULT OPTION
    // ==================================================

    echo '<option value="">Select Doctor</option>';


    // ==================================================
    // DOCTOR OPTIONS
    // ==================================================

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

        $doctorId = (int) ($row['ID'] ?? 0);

        $doctorName = htmlspecialchars(
            $row['FullName'] ?? '',
            ENT_QUOTES,
            'UTF-8'
        );


        if ($doctorId > 0 && $doctorName !== '') {

            echo '<option value="' .
                $doctorId .
                '">' .
                $doctorName .
                '</option>';

        }

    }


} catch (PDOException $e) {

    // Do not expose database errors to visitors.
    echo '<option value="">Unable to load doctors</option>';

}

?>