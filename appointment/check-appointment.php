<?php

// ==========================================================
// AppointDoc - Check Appointment
// ==========================================================

// header.php is one directory above this file.
// It also loads conn.php and starts the session.
require_once dirname(__DIR__) . '/header.php';


// ==========================================================
// DEFAULT VALUES
// ==========================================================

$appointment = null;
$searchPerformed = false;
$errorMessage = '';


// ==========================================================
// CHECK APPOINTMENT
// ==========================================================

if (isset($_POST['check'])) {

    $searchPerformed = true;

    $appointmentNumber = trim(
        $_POST['appointmentnumber'] ?? ''
    );

    $email = trim(
        $_POST['email'] ?? ''
    );


    // ======================================================
    // VALIDATION
    // ======================================================

    if ($appointmentNumber === '' || $email === '') {

        $errorMessage =
            'Please enter Appointment Number and Email.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errorMessage =
            'Please enter a valid email address.';

    } else {

        try {

            // ==================================================
            // FIND APPOINTMENT
            // ==================================================

            $sql = "
                SELECT
                    ID,
                    AppointmentNumber,
                    Name,
                    MobileNumber,
                    Email,
                    AppointmentDate,
                    AppointmentTime,
                    Specialization,
                    Doctor,
                    Message,
                    ApplyDate,
                    Remark,
                    Status,
                    UpdatonDate
                FROM tblappointment
                WHERE AppointmentNumber = :appointmentnumber
                AND Email = :email
                LIMIT 1
            ";

            $query = $dbh->prepare($sql);

            $query->bindValue(
                ':appointmentnumber',
                $appointmentNumber,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':email',
                $email,
                PDO::PARAM_STR
            );

            $query->execute();

            $appointment =
                $query->fetch(PDO::FETCH_ASSOC);


            // ==================================================
            // NOT FOUND
            // ==================================================

            if (!$appointment) {

                $errorMessage =
                    'No appointment found. Please check your Appointment Number and Email.';

            }

        } catch (PDOException $e) {

            $errorMessage =
                'Unable to check appointment. Please try again later.';

        }

    }

}


// ==========================================================
// GET DOCTOR NAME
// ==========================================================

$doctorName = '';

if ($appointment) {

    try {

        $doctorId =
            (int) ($appointment['Doctor'] ?? 0);

        if ($doctorId > 0) {

            $doctorQuery = $dbh->prepare(
                "SELECT FullName
                 FROM tbldoctor
                 WHERE ID = :doctor
                 LIMIT 1"
            );

            $doctorQuery->bindValue(
                ':doctor',
                $doctorId,
                PDO::PARAM_INT
            );

            $doctorQuery->execute();

            $doctor = $doctorQuery->fetch(
                PDO::FETCH_ASSOC
            );

            if ($doctor) {

                $doctorName =
                    $doctor['FullName'] ?? '';

            }

        }

    } catch (PDOException $e) {

        $doctorName = '';

    }

}


// ==========================================================
// GET SPECIALIZATION NAME
// ==========================================================

$specializationName = '';

if ($appointment) {

    try {

        $specializationId =
            (int) ($appointment['Specialization'] ?? 0);

        if ($specializationId > 0) {

            $specializationQuery =
                $dbh->prepare(
                    "SELECT Specialization
                     FROM tblspecialization
                     WHERE ID = :id
                     LIMIT 1"
                );

            $specializationQuery->bindValue(
                ':id',
                $specializationId,
                PDO::PARAM_INT
            );

            $specializationQuery->execute();

            $specialization =
                $specializationQuery->fetch(
                    PDO::FETCH_ASSOC
                );

            if ($specialization) {

                $specializationName =
                    $specialization['Specialization'] ?? '';

            }

        }

    } catch (PDOException $e) {

        $specializationName = '';

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Check Appointment</title>


    <!-- ==================================================
         FONT AWESOME
    =================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        .appointment-check-container {
            width: 90%;
            max-width: 1100px;
            margin: 120px auto 60px;
        }


        .appointment-check-box {
            background: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.12);
        }


        .appointment-check-box h1 {
            text-align: center;
            color: #0188df;
            margin-bottom: 10px;
        }


        .appointment-check-box .title {
            text-align: center;
            margin-bottom: 30px;
        }


        .check-form {
            max-width: 700px;
            margin: auto;
        }


        .check-form input {
            width: 100%;
            padding: 13px 15px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #EDF4FF;
            font-size: 15px;
            box-sizing: border-box;
        }


        .check-form button {
            display: block;
            margin: 10px auto 0;
            padding: 12px 35px;
            border: none;
            cursor: pointer;
        }


        .error-message {
            max-width: 700px;
            margin: 25px auto;
            padding: 15px;
            background: #ffe8e8;
            color: #c00000;
            border-radius: 8px;
            text-align: center;
        }


        .success-message {
            max-width: 700px;
            margin: 25px auto;
            padding: 15px;
            background: #e8f8ed;
            color: #08752b;
            border-radius: 8px;
            text-align: center;
        }


        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }


        .appointment-table th,
        .appointment-table td {
            border: 1px solid #ddd;
            padding: 13px;
            text-align: left;
        }


        .appointment-table th {
            width: 35%;
            background: #f2f8ff;
            color: #003265;
        }


        .status-approved {
            color: green;
            font-weight: bold;
        }


        .status-rejected {
            color: red;
            font-weight: bold;
        }


        .status-pending {
            color: #d88900;
            font-weight: bold;
        }


        @media (max-width: 768px) {

            .appointment-check-container {
                width: 95%;
                margin-top: 100px;
            }


            .appointment-check-box {
                padding: 20px;
            }


            .appointment-table th,
            .appointment-table td {
                padding: 9px;
                font-size: 14px;
            }

        }

    </style>

</head>


<body>


<!-- ======================================================
     CHECK APPOINTMENT
======================================================= -->

<section class="appointment-check-container">

    <div class="appointment-check-box">


        <h1>
            Check Appointment
        </h1>


        <h3 class="title">
            Check your appointment status
        </h3>


        <!-- ==================================================
             SEARCH FORM
        =================================================== -->

        <form
            method="post"
            class="check-form"
        >


            <input
                type="text"
                name="appointmentnumber"
                placeholder="Enter Appointment Number"
                value="<?php

                    echo htmlspecialchars(
                        $_POST['appointmentnumber'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );

                ?>"
                required
            >


            <input
                type="email"
                name="email"
                placeholder="Enter Email Address"
                value="<?php

                    echo htmlspecialchars(
                        $_POST['email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );

                ?>"
                required
            >


            <button
                type="submit"
                name="check"
                class="button"
            >
                Check Appointment
            </button>


        </form>


        <!-- ==================================================
             ERROR MESSAGE
        =================================================== -->

        <?php if ($errorMessage !== ''): ?>

            <div class="error-message">

                <i class="fas fa-circle-exclamation"></i>

                &nbsp;

                <?php

                echo htmlspecialchars(
                    $errorMessage,
                    ENT_QUOTES,
                    'UTF-8'
                );

                ?>

            </div>

        <?php endif; ?>


        <!-- ==================================================
             APPOINTMENT DETAILS
        =================================================== -->

        <?php if ($appointment): ?>


            <div class="success-message">

                <i class="fas fa-circle-check"></i>

                &nbsp;

                Appointment found successfully.

            </div>


            <table class="appointment-table">


                <!-- APPOINTMENT NUMBER -->

                <tr>

                    <th>
                        Appointment Number
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['AppointmentNumber'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- NAME -->

                <tr>

                    <th>
                        Patient Name
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['Name'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- MOBILE -->

                <tr>

                    <th>
                        Mobile Number
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['MobileNumber'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- EMAIL -->

                <tr>

                    <th>
                        Email
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['Email'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- SPECIALIZATION -->

                <tr>

                    <th>
                        Specialization
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $specializationName,
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- DOCTOR -->

                <tr>

                    <th>
                        Doctor
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $doctorName,
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- DATE -->

                <tr>

                    <th>
                        Appointment Date
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['AppointmentDate'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- TIME -->

                <tr>

                    <th>
                        Appointment Time
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['AppointmentTime'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- MESSAGE -->

                <tr>

                    <th>
                        Message
                    </th>

                    <td>

                        <?php

                        echo nl2br(
                            htmlspecialchars(
                                $appointment['Message'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        );

                        ?>

                    </td>

                </tr>


                <!-- APPLY DATE -->

                <tr>

                    <th>
                        Apply Date
                    </th>

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $appointment['ApplyDate'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </td>

                </tr>


                <!-- STATUS -->

                <tr>

                    <th>
                        Status
                    </th>

                    <td>

                        <?php

                        $status =
                            trim(
                                $appointment['Status'] ?? ''
                            );

                        $statusClass = '';

                        if (
                            strtolower($status)
                            === 'approved'
                        ) {

                            $statusClass =
                                'status-approved';

                        } elseif (
                            strtolower($status)
                            === 'rejected'
                        ) {

                            $statusClass =
                                'status-rejected';

                        } else {

                            $statusClass =
                                'status-pending';

                        }

                        ?>

                        <span
                            class="<?php
                                echo $statusClass;
                            ?>"
                        >

                            <?php

                            echo htmlspecialchars(
                                $status !== ''
                                    ? $status
                                    : 'Pending',
                                ENT_QUOTES,
                                'UTF-8'
                            );

                            ?>

                        </span>

                    </td>

                </tr>


                <!-- REMARK -->

                <tr>

                    <th>
                        Remark
                    </th>

                    <td>

                        <?php

                        $remark =
                            trim(
                                $appointment['Remark'] ?? ''
                            );

                        echo $remark !== ''
                            ? nl2br(
                                htmlspecialchars(
                                    $remark,
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            )
                            : 'No remark available';

                        ?>

                    </td>

                </tr>


                <!-- UPDATE DATE -->

                <?php

                if (
                    !empty(
                        $appointment['UpdatonDate']
                    )
                ):

                ?>

                    <tr>

                        <th>
                            Last Updated
                        </th>

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $appointment['UpdatonDate'],
                                ENT_QUOTES,
                                'UTF-8'
                            );

                            ?>

                        </td>

                    </tr>

                <?php endif; ?>


            </table>


        <?php endif; ?>


    </div>

</section>


</body>

</html>