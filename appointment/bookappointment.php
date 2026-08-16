<?php

// ==========================================================
// APPOINTMENT BOOKING PAGE
// AppointDoc
// ==========================================================

// ----------------------------------------------------------
// SESSION
// ----------------------------------------------------------

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ----------------------------------------------------------
// DATABASE + HEADER
// ----------------------------------------------------------
// appointment/bookappointment.php
// __DIR__ = /var/www/html/appointment
// dirname(__DIR__) = /var/www/html
// ----------------------------------------------------------

require_once dirname(__DIR__) . '/header.php';


// ----------------------------------------------------------
// MESSAGE VARIABLES
// ----------------------------------------------------------

$successMessage = '';
$errorMessage   = '';


// ----------------------------------------------------------
// GET SPECIALIZATION ID
// ----------------------------------------------------------

$selectedSpecialization = 0;

if (isset($_GET['id']) && $_GET['id'] !== '') {

    $selectedSpecialization = filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );

    if (!$selectedSpecialization) {
        $selectedSpecialization = 0;
    }
}


// ==========================================================
// HANDLE APPOINTMENT SUBMISSION
// ==========================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {


    // ------------------------------------------------------
    // CHECK LOGIN
    // ------------------------------------------------------

    if (empty($_SESSION['uid'])) {

        echo '<script>
            alert("Please Login To Book Appointment");
            window.location.href="../login/login_form.php";
        </script>';

        exit;
    }


    // ------------------------------------------------------
    // GET FORM VALUES
    // ------------------------------------------------------

    $name = trim($_POST['name'] ?? '');

    $mobileNumber = trim($_POST['phone'] ?? '');

    $email = trim($_POST['email'] ?? '');

    $appointmentDate = trim($_POST['date'] ?? '');

    $appointmentTime = trim($_POST['time'] ?? '');

    $specialization = filter_input(
        INPUT_POST,
        'specialization',
        FILTER_VALIDATE_INT
    );

    $doctor = filter_input(
        INPUT_POST,
        'doctorlist',
        FILTER_VALIDATE_INT
    );

    $message = trim($_POST['message'] ?? '');


    // ------------------------------------------------------
    // BASIC VALIDATION
    // ------------------------------------------------------

    if ($name === '') {

        $errorMessage = 'Please enter your full name.';

    } elseif ($mobileNumber === '') {

        $errorMessage = 'Please enter your mobile number.';

    } elseif (!preg_match('/^[0-9]{10}$/', $mobileNumber)) {

        $errorMessage = 'Please enter a valid 10-digit mobile number.';

    } elseif ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errorMessage = 'Please enter a valid email address.';

    } elseif ($appointmentDate === '') {

        $errorMessage = 'Please select an appointment date.';

    } elseif ($appointmentTime === '') {

        $errorMessage = 'Please select an appointment time.';

    } elseif (!$specialization) {

        $errorMessage = 'Please select a specialization.';

    } elseif (!$doctor) {

        $errorMessage = 'Please select a doctor.';

    }


    // ------------------------------------------------------
    // DATE VALIDATION
    // ------------------------------------------------------

    if ($errorMessage === '') {

        $today = date('Y-m-d');

        if ($appointmentDate <= $today) {

            $errorMessage =
                'Appointment date must be greater than today\'s date.';

        }
    }


    // ------------------------------------------------------
    // VALIDATE SPECIALIZATION
    // ------------------------------------------------------

    if ($errorMessage === '') {

        try {

            $specializationCheck = $dbh->prepare(
                "SELECT ID
                 FROM tblspecialization
                 WHERE ID = :id
                 LIMIT 1"
            );

            $specializationCheck->bindValue(
                ':id',
                $specialization,
                PDO::PARAM_INT
            );

            $specializationCheck->execute();

            if (!$specializationCheck->fetch(PDO::FETCH_ASSOC)) {

                $errorMessage = 'Invalid specialization selected.';

            }

        } catch (PDOException $e) {

            error_log(
                'Specialization validation error: ' .
                $e->getMessage()
            );

            $errorMessage =
                'Unable to validate specialization. Please try again.';
        }
    }


    // ------------------------------------------------------
    // VALIDATE DOCTOR
    // ------------------------------------------------------

    if ($errorMessage === '') {

        try {

            $doctorCheck = $dbh->prepare(
                "SELECT ID
                 FROM tbldoctor
                 WHERE ID = :doctor
                 AND Specialization = :specialization
                 LIMIT 1"
            );

            $doctorCheck->bindValue(
                ':doctor',
                $doctor,
                PDO::PARAM_INT
            );

            $doctorCheck->bindValue(
                ':specialization',
                $specialization,
                PDO::PARAM_INT
            );

            $doctorCheck->execute();

            if (!$doctorCheck->fetch(PDO::FETCH_ASSOC)) {

                $errorMessage =
                    'The selected doctor does not belong to the selected specialization.';
            }

        } catch (PDOException $e) {

            error_log(
                'Doctor validation error: ' .
                $e->getMessage()
            );

            $errorMessage =
                'Unable to validate doctor. Please try again.';
        }
    }


    // ======================================================
    // INSERT APPOINTMENT
    // ======================================================

    if ($errorMessage === '') {

        try {

            // ------------------------------------------------
            // GENERATE UNIQUE APPOINTMENT NUMBER
            // ------------------------------------------------

            do {

                $appointmentNumber = random_int(
                    100000000,
                    999999999
                );

                $checkAppointment = $dbh->prepare(
                    "SELECT ID
                     FROM tblappointment
                     WHERE AppointmentNumber = :appointmentNumber
                     LIMIT 1"
                );

                $checkAppointment->bindValue(
                    ':appointmentNumber',
                    $appointmentNumber,
                    PDO::PARAM_INT
                );

                $checkAppointment->execute();

            } while ($checkAppointment->fetch(PDO::FETCH_ASSOC));


            // ------------------------------------------------
            // CURRENT DATE/TIME
            // ------------------------------------------------

            $applyDate = date('Y-m-d H:i:s');


            // ------------------------------------------------
            // INSERT
            // ------------------------------------------------
            // Your table:
            //
            // ID
            // AppointmentNumber
            // Name
            // MobileNumber
            // Email
            // AppointmentDate
            // AppointmentTime
            // Specialization
            // Doctor
            // Message
            // ApplyDate
            // Remark
            // Status
            // UpdatonDate
            //
            // We allow Remark, Status and UpdatonDate to use
            // their database defaults/NULL values.
            // ------------------------------------------------

            $sql = "
                INSERT INTO tblappointment
                (
                    AppointmentNumber,
                    Name,
                    MobileNumber,
                    Email,
                    AppointmentDate,
                    AppointmentTime,
                    Specialization,
                    Doctor,
                    Message,
                    ApplyDate
                )
                VALUES
                (
                    :appointmentNumber,
                    :name,
                    :mobileNumber,
                    :email,
                    :appointmentDate,
                    :appointmentTime,
                    :specialization,
                    :doctor,
                    :message,
                    :applyDate
                )
            ";


            $query = $dbh->prepare($sql);


            // ------------------------------------------------
            // BIND VALUES
            // ------------------------------------------------

            $query->bindValue(
                ':appointmentNumber',
                $appointmentNumber,
                PDO::PARAM_INT
            );

            $query->bindValue(
                ':name',
                $name,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':mobileNumber',
                $mobileNumber,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':email',
                $email,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':appointmentDate',
                $appointmentDate,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':appointmentTime',
                $appointmentTime,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':specialization',
                $specialization,
                PDO::PARAM_INT
            );

            $query->bindValue(
                ':doctor',
                $doctor,
                PDO::PARAM_INT
            );

            $query->bindValue(
                ':message',
                $message,
                PDO::PARAM_STR
            );

            $query->bindValue(
                ':applyDate',
                $applyDate,
                PDO::PARAM_STR
            );


            // ------------------------------------------------
            // EXECUTE
            // ------------------------------------------------

            $query->execute();


            // ------------------------------------------------
            // SUCCESS
            // ------------------------------------------------

            $successMessage =
                'Your Appointment Request Has Been Sent. We Will Contact You Soon.';


            // ------------------------------------------------
            // REDIRECT AFTER SUCCESS
            // ------------------------------------------------
            // Redirect prevents duplicate form submission.
            // ------------------------------------------------

            header(
                'Location: bookappointment.php?success=1'
            );

            exit;


        } catch (PDOException $e) {

            // ------------------------------------------------
            // LOG REAL DATABASE ERROR
            // ------------------------------------------------

            error_log(
                'Appointment booking error: ' .
                $e->getMessage()
            );


            $errorMessage =
                'Something went wrong while booking your appointment. Please try again.';
        }
    }
}


// ==========================================================
// SUCCESS MESSAGE AFTER REDIRECT
// ==========================================================

if (
    isset($_GET['success']) &&
    $_GET['success'] === '1'
) {

    $successMessage =
        'Your Appointment Request Has Been Sent. We Will Contact You Soon.';
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

    <title>Doctor Appointment</title>


    <!-- ==================================================
         GOOGLE FONT
    =================================================== -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- ==================================================
         APPOINTMENT CSS
    =================================================== -->

    <link
        rel="stylesheet"
        href="css_app/bootstrap.min1.css"
    >

    <link
        rel="stylesheet"
        href="css_app/templatemo-medic-care4.css"
    >


    <!-- ==================================================
         JQUERY
    =================================================== -->

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js">
    </script>


    <!-- ==================================================
         GET DOCTORS
    =================================================== -->

    <script>

        function getdoctors(value) {

            const doctorList =
                document.getElementById('doctorlist');

            if (!doctorList) {
                return;
            }


            // Clear old doctors

            doctorList.innerHTML =
                '<option value="">Loading doctors...</option>';


            if (!value) {

                doctorList.innerHTML =
                    '<option value="">Select Doctor</option>';

                return;
            }


            $.ajax({

                type: 'POST',

                url: 'get_doctors.php',

                data: {
                    sp_id: value
                },

                success: function(data) {

                    doctorList.innerHTML = data;

                },

                error: function() {

                    doctorList.innerHTML =
                        '<option value="">Unable to load doctors</option>';

                }

            });

        }

    </script>


    <!-- ==================================================
         MINIMUM DATE
    =================================================== -->

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const dateInput =
                    document.getElementById('date');

                if (dateInput) {

                    const today =
                        new Date();

                    today.setDate(
                        today.getDate() + 1
                    );

                    const year =
                        today.getFullYear();

                    const month =
                        String(
                            today.getMonth() + 1
                        ).padStart(2, '0');

                    const day =
                        String(
                            today.getDate()
                        ).padStart(2, '0');

                    dateInput.min =
                        year + '-' +
                        month + '-' +
                        day;
                }

            }
        );

    </script>

</head>


<body
    style="
        background-color: white;
        border-radius: 10px;
    "
>


<!-- ======================================================
     SUCCESS MESSAGE
======================================================= -->

<?php if ($successMessage !== ''): ?>

    <div
        style="
            max-width:900px;
            margin:30px auto 0;
            padding:15px 20px;
            background:#e8f8ee;
            border:1px solid #28a745;
            border-radius:8px;
            color:#155724;
            text-align:center;
            font-size:16px;
        "
    >

        <?php
        echo htmlspecialchars(
            $successMessage,
            ENT_QUOTES,
            'UTF-8'
        );
        ?>

    </div>

<?php endif; ?>


<!-- ======================================================
     ERROR MESSAGE
======================================================= -->

<?php if ($errorMessage !== ''): ?>

    <div
        style="
            max-width:900px;
            margin:30px auto 0;
            padding:15px 20px;
            background:#fdeaea;
            border:1px solid #dc3545;
            border-radius:8px;
            color:#721c24;
            text-align:center;
            font-size:16px;
        "
    >

        <?php
        echo htmlspecialchars(
            $errorMessage,
            ENT_QUOTES,
            'UTF-8'
        );
        ?>

    </div>

<?php endif; ?>


<!-- ======================================================
     BOOKING SECTION
======================================================= -->

<section
    class="section-padding"
    id="booking"
>


    <div class="container">


        <div class="row">


            <div
                class="col-lg-8 col-12 mx-auto"
            >


                <div class="booking-form">


                    <h3
                        class="text-center mb-lg-3 mb-2"
                        style="color:#0188df;"
                    >

                        Book an appointment

                    </h3>


                    <!-- ==================================================
                         BOOKING FORM
                    =================================================== -->

                    <form
                        role="form"
                        method="post"
                        action="bookappointment.php<?php
                            if ($selectedSpecialization > 0) {
                                echo '?id=' . $selectedSpecialization;
                            }
                        ?>"
                        style="margin-top:30px;"
                    >


                        <div class="row">


                            <!-- ==========================================
                                 NAME
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    placeholder="Full name"
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['name'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                    required
                                >

                            </div>


                            <!-- ==========================================
                                 EMAIL
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    placeholder="Email address"
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['email'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                    required
                                >

                            </div>


                            <!-- ==========================================
                                 PHONE
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    placeholder="Enter Phone Number"
                                    maxlength="10"
                                    minlength="10"
                                    pattern="[0-9]{10}"
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['phone'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                    required
                                >

                            </div>


                            <!-- ==========================================
                                 DATE
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <input
                                    type="date"
                                    name="date"
                                    id="date"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['date'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                    required
                                >

                            </div>


                            <!-- ==========================================
                                 TIME
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <input
                                    type="time"
                                    name="time"
                                    id="time"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['time'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                    required
                                >

                            </div>


                            <!-- ==========================================
                                 SPECIALIZATION
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <select
                                    onchange="getdoctors(this.value);"
                                    name="specialization"
                                    id="specialization"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    required
                                >

                                    <option value="">
                                        Select specialization
                                    </option>


                                    <?php

                                    try {

                                        // ----------------------------------
                                        // If specialization was selected
                                        // ----------------------------------

                                        if (
                                            $selectedSpecialization > 0
                                        ) {

                                            $sql = "
                                                SELECT ID, Specialization
                                                FROM tblspecialization
                                                WHERE ID = :id
                                                LIMIT 1
                                            ";

                                            $stmt =
                                                $dbh->prepare($sql);

                                            $stmt->bindValue(
                                                ':id',
                                                $selectedSpecialization,
                                                PDO::PARAM_INT
                                            );

                                            $stmt->execute();

                                            $row =
                                                $stmt->fetch(
                                                    PDO::FETCH_ASSOC
                                                );


                                            if ($row) {

                                                ?>

                                                <option
                                                    value="<?php
                                                        echo (int)$row['ID'];
                                                    ?>"
                                                    selected
                                                >

                                                    <?php
                                                    echo htmlspecialchars(
                                                        $row['Specialization'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                                    ?>

                                                </option>

                                                <?php

                                            }

                                        } else {

                                            // ----------------------------------
                                            // Show all specializations
                                            // ----------------------------------

                                            $sql = "
                                                SELECT ID, Specialization
                                                FROM tblspecialization
                                                ORDER BY Specialization ASC
                                            ";

                                            $stmt =
                                                $dbh->query($sql);


                                            while (
                                                $row =
                                                $stmt->fetch(
                                                    PDO::FETCH_ASSOC
                                                )
                                            ) {

                                                ?>

                                                <option
                                                    value="<?php
                                                        echo (int)$row['ID'];
                                                    ?>"
                                                >

                                                    <?php
                                                    echo htmlspecialchars(
                                                        $row['Specialization'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                                    ?>

                                                </option>

                                                <?php

                                            }

                                        }

                                    } catch (PDOException $e) {

                                        error_log(
                                            'Specialization loading error: ' .
                                            $e->getMessage()
                                        );

                                        ?>

                                        <option value="">
                                            Unable to load specialization
                                        </option>

                                        <?php

                                    }

                                    ?>

                                </select>

                            </div>


                            <!-- ==========================================
                                 DOCTOR
                            =========================================== -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <select
                                    name="doctorlist"
                                    id="doctorlist"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    required
                                >

                                    <option value="">
                                        Select Doctor
                                    </option>

                                </select>

                            </div>


                            <!-- ==========================================
                                 MESSAGE
                            =========================================== -->

                            <div class="col-12">

                                <textarea
                                    class="form-control"
                                    rows="5"
                                    id="message"
                                    name="message"
                                    maxlength="1000"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    placeholder="Additional Message"
                                ><?php
                                    echo htmlspecialchars(
                                        $_POST['message'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                ?></textarea>

                            </div>


                            <!-- ==========================================
                                 SUBMIT BUTTON
                            =========================================== -->

                            <div
                                class="col-lg-3 col-md-4 col-6 mx-auto"
                            >

                                <button
                                    type="submit"
                                    class="button"
                                    name="submit"
                                    style="margin-top:50px;"
                                >

                                    Book Now

                                </button>

                            </div>


                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ======================================================
     APPOINTMENT JAVASCRIPT
======================================================= -->

<script src="css_app/js/jquery.min.js"></script>

<script src="css_app/js/bootstrap.bundle.min.js"></script>

<script src="css_app/js/owl.carousel.min.js"></script>

<script src="css_app/js/scrollspy.min.js"></script>

<script src="css_app/js/custom.js"></script>


</body>

</html>