<?php

// ==========================================================
// AppointDoc - Specific Doctor Appointment
// ==========================================================

// Load header and database connection.
// header.php already loads conn.php.
require_once dirname(__DIR__) . '/header.php';


// ==========================================================
// GET DOCTOR AND SPECIALIZATION IDs
// ==========================================================

$drid = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$spid = isset($_GET['spid']) ? (int) $_GET['spid'] : 0;


// ==========================================================
// VALIDATE IDS
// ==========================================================

if ($drid <= 0 || $spid <= 0) {

    echo '<script>
        alert("Invalid doctor or specialization.");
        window.location.href = "bookappointment.php";
    </script>';

    exit;
}


// ==========================================================
// GET DOCTOR INFORMATION
// ==========================================================

$doctorName = '';
$doctorFound = false;

try {

    $doctorQuery = $dbh->prepare(
        "SELECT ID, FullName, Specialization
         FROM tbldoctor
         WHERE ID = :drid
         LIMIT 1"
    );

    $doctorQuery->bindValue(
        ':drid',
        $drid,
        PDO::PARAM_INT
    );

    $doctorQuery->execute();

    $doctor = $doctorQuery->fetch(PDO::FETCH_ASSOC);

    if ($doctor) {

        $doctorFound = true;

        $doctorName = $doctor['FullName'] ?? '';

    }

} catch (PDOException $e) {

    $doctorFound = false;

}


// ==========================================================
// GET SPECIALIZATION INFORMATION
// ==========================================================

$specializationName = '';

try {

    $specializationQuery = $dbh->prepare(
        "SELECT ID, Specialization
         FROM tblspecialization
         WHERE ID = :spid
         LIMIT 1"
    );

    $specializationQuery->bindValue(
        ':spid',
        $spid,
        PDO::PARAM_INT
    );

    $specializationQuery->execute();

    $specialization =
        $specializationQuery->fetch(PDO::FETCH_ASSOC);

    if ($specialization) {

        $specializationName =
            $specialization['Specialization'] ?? '';

    }

} catch (PDOException $e) {

    $specializationName = '';

}


// ==========================================================
// CHECK DOCTOR
// ==========================================================

if (!$doctorFound) {

    echo '<script>
        alert("Doctor not found.");
        window.location.href = "bookappointment.php";
    </script>';

    exit;
}


// ==========================================================
// CHECK SPECIALIZATION
// ==========================================================

if ($specializationName === '') {

    echo '<script>
        alert("Specialization not found.");
        window.location.href = "bookappointment.php";
    </script>';

    exit;
}


// ==========================================================
// HANDLE APPOINTMENT SUBMISSION
// ==========================================================

if (isset($_POST['submit'])) {


    // ======================================================
    // CHECK LOGIN
    // ======================================================

    if (
        !isset($_SESSION['uid']) ||
        empty($_SESSION['uid'])
    ) {

        echo '<script>
            alert("Please Login To Book Appointment");
            window.location.href = "../login/login_form.php";
        </script>';

        exit;
    }


    // ======================================================
    // GET FORM VALUES
    // ======================================================

    $name =
        trim($_POST['name'] ?? '');

    $mobnum =
        trim($_POST['phone'] ?? '');

    $email =
        trim($_POST['email'] ?? '');

    $appdate =
        trim($_POST['date'] ?? '');

    $aaptime =
        trim($_POST['time'] ?? '');

    $message =
        trim($_POST['message'] ?? '');


    // ======================================================
    // BASIC VALIDATION
    // ======================================================

    if (
        $name === '' ||
        $mobnum === '' ||
        $email === '' ||
        $appdate === '' ||
        $aaptime === ''
    ) {

        echo '<script>
            alert("Please fill all required fields.");
        </script>';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo '<script>
            alert("Please enter a valid email address.");
        </script>';

    } else {


        // ==================================================
        // CHECK APPOINTMENT DATE
        // ==================================================

        $today = date('Y-m-d');

        if ($appdate <= $today) {

            echo '<script>
                alert("Appointment date must be greater than today\'s date.");
            </script>';

        } else {


            // ==================================================
            // GENERATE APPOINTMENT NUMBER
            // ==================================================

            $aptnumber = mt_rand(
                100000000,
                999999999
            );


            // ==================================================
            // INSERT APPOINTMENT
            // ==================================================

            try {

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
                        Message
                    )
                    VALUES
                    (
                        :aptnumber,
                        :name,
                        :mobnum,
                        :email,
                        :appdate,
                        :aaptime,
                        :specialization,
                        :doctor,
                        :message
                    )
                ";


                $query = $dbh->prepare($sql);


                $query->bindValue(
                    ':aptnumber',
                    $aptnumber,
                    PDO::PARAM_STR
                );


                $query->bindValue(
                    ':name',
                    $name,
                    PDO::PARAM_STR
                );


                $query->bindValue(
                    ':mobnum',
                    $mobnum,
                    PDO::PARAM_STR
                );


                $query->bindValue(
                    ':email',
                    $email,
                    PDO::PARAM_STR
                );


                $query->bindValue(
                    ':appdate',
                    $appdate,
                    PDO::PARAM_STR
                );


                $query->bindValue(
                    ':aaptime',
                    $aaptime,
                    PDO::PARAM_STR
                );


                $query->bindValue(
                    ':specialization',
                    $spid,
                    PDO::PARAM_INT
                );


                $query->bindValue(
                    ':doctor',
                    $drid,
                    PDO::PARAM_INT
                );


                $query->bindValue(
                    ':message',
                    $message,
                    PDO::PARAM_STR
                );


                $query->execute();


                // ==================================================
                // SUCCESS
                // ==================================================

                if ($query->rowCount() > 0) {

                    echo '<script>
                        alert(
                            "Your Appointment Request Has Been Sent. We Will Contact You Soon."
                        );
                        window.location.href = "bookappointment.php";
                    </script>';

                    exit;

                } else {

                    echo '<script>
                        alert("Something Went Wrong. Please try again.");
                    </script>';

                }


            } catch (PDOException $e) {

                echo '<script>
                    alert("Unable to book appointment. Please try again.");
                </script>';

            }

        }

    }

}

?>

<!doctype html>

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
         BOOTSTRAP
    =================================================== -->

    <link
        href="css_app/bootstrap.min1.css"
        rel="stylesheet"
    >


    <!-- ==================================================
         MEDIC CARE CSS
    =================================================== -->

    <link
        href="css_app/templatemo-medic-care4.css"
        rel="stylesheet"
    >

</head>


<body
    style="
        background-color: White;
        border-radius: 10px;
    "
>


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


                    <!-- ==================================================
                         TITLE
                    =================================================== -->

                    <h3
                        class="text-center mb-lg-3 mb-2"
                        style="color:#0188df;"
                    >
                        Book an appointment
                    </h3>


                    <!-- ==================================================
                         FORM
                    =================================================== -->

                    <form
                        role="form"
                        method="post"
                        style="margin-top:30px;"
                    >


                        <!-- ==================================================
                             DOCTOR INFORMATION
                        =================================================== -->

                        <p>

                            Book Appointment for

                            <span
                                style="font-weight:bold;"
                            >

                                <?php

                                echo htmlspecialchars(
                                    $doctorName,
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                                ?>

                            </span>

                            &nbsp;

                            (

                            <span
                                style="font-weight:bold;"
                            >

                                <?php

                                echo htmlspecialchars(
                                    $specializationName,
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                                ?>

                            </span>

                            )

                        </p>


                        <!-- ==================================================
                             FORM ROW
                        =================================================== -->

                        <div class="row">


                            <!-- NAME -->

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
                                    required
                                >

                            </div>


                            <!-- EMAIL -->

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
                                    required
                                >

                            </div>


                            <!-- PHONE -->

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
                                    required
                                >

                            </div>


                            <!-- DATE -->

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
                                    required
                                >

                            </div>


                            <!-- TIME -->

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
                                    required
                                >

                            </div>


                            <!-- MESSAGE -->

                            <div class="col-12">

                                <textarea
                                    class="form-control"
                                    rows="5"
                                    id="message"
                                    name="message"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    placeholder="Additional Message"
                                ></textarea>

                            </div>


                            <!-- SUBMIT -->

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
     JAVASCRIPT
======================================================= -->

<script src="js/jquery.min.js"></script>

<script src="js/bootstrap.bundle.min.js"></script>

<script src="js/owl.carousel.min.js"></script>

<script src="js/scrollspy.min.js"></script>

<script src="js/custom.js"></script>


</body>

</html>