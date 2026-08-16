<?php

// ==========================================
// HEADER
// ==========================================

require_once __DIR__ . '/../header.php';


// ==========================================
// CHECK DATABASE CONNECTION
// ==========================================

if (!isset($conn) || !$conn) {
    die('Database connection failed.');
}


// ==========================================
// GET SPECIALIZATION ID
// ==========================================

$specializationId = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;


// ==========================================
// APPOINTMENT SUBMISSION
// ==========================================

if (isset($_POST['submit'])) {


    // ==========================================
    // CHECK LOGIN
    // ==========================================

    if (
        !isset($_SESSION['uid']) ||
        empty($_SESSION['uid'])
    ) {

        echo '<script>
            alert("Please Login To Book Appointment");
            window.location.href="../login/login_form.php";
        </script>';

        exit;
    }


    // ==========================================
    // GET FORM VALUES
    // ==========================================

    $name = trim(
        $_POST['name'] ?? ''
    );

    $mobnum = trim(
        $_POST['phone'] ?? ''
    );

    $email = trim(
        $_POST['email'] ?? ''
    );

    $appdate = trim(
        $_POST['date'] ?? ''
    );

    $aaptime = trim(
        $_POST['time'] ?? ''
    );

    $specialization = isset(
        $_POST['specialization']
    )
        ? (int)$_POST['specialization']
        : 0;

    $doctorlist = isset(
        $_POST['doctorlist']
    )
        ? (int)$_POST['doctorlist']
        : 0;

    $message = trim(
        $_POST['message'] ?? ''
    );


    // ==========================================
    // BASIC VALIDATION
    // ==========================================

    if ($name === '') {

        echo '<script>
            alert("Please enter your name.");
        </script>';

    } elseif (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        echo '<script>
            alert("Please enter a valid email address.");
        </script>';

    } elseif ($mobnum === '') {

        echo '<script>
            alert("Please enter your mobile number.");
        </script>';

    } elseif (
        !preg_match(
            '/^[0-9]{10}$/',
            $mobnum
        )
    ) {

        echo '<script>
            alert("Please enter a valid 10 digit mobile number.");
        </script>';

    } elseif ($appdate === '') {

        echo '<script>
            alert("Please select appointment date.");
        </script>';

    } elseif ($aaptime === '') {

        echo '<script>
            alert("Please select appointment time.");
        </script>';

    } elseif ($specialization <= 0) {

        echo '<script>
            alert("Please select specialization.");
        </script>';

    } elseif ($doctorlist <= 0) {

        echo '<script>
            alert("Please select doctor.");
        </script>';

    } else {


        // ==========================================
        // CHECK APPOINTMENT DATE
        // ==========================================

        $today = date('Y-m-d');


        if ($appdate <= $today) {

            echo '<script>
                alert("Appointment date must be greater than todays date");
            </script>';

        } else {


            // ==========================================
            // GENERATE APPOINTMENT NUMBER
            // ==========================================

            do {

                $aptnumber = mt_rand(
                    100000000,
                    999999999
                );


                $checkAppointment = mysqli_prepare(
                    $conn,
                    "SELECT ID
                     FROM tblappointment
                     WHERE AppointmentNumber = ?
                     LIMIT 1"
                );


                if (!$checkAppointment) {

                    die(
                        'Unable to check appointment number.'
                    );
                }


                mysqli_stmt_bind_param(
                    $checkAppointment,
                    "i",
                    $aptnumber
                );

                mysqli_stmt_execute(
                    $checkAppointment
                );

                $appointmentResult =
                    mysqli_stmt_get_result(
                        $checkAppointment
                    );

                $appointmentExists =
                    $appointmentResult &&
                    mysqli_num_rows(
                        $appointmentResult
                    ) > 0;


                mysqli_stmt_close(
                    $checkAppointment
                );

            } while ($appointmentExists);


            // ==========================================
            // INSERT APPOINTMENT
            // ==========================================

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
                (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";


            $stmt = mysqli_prepare(
                $conn,
                $sql
            );


            if ($stmt) {


                mysqli_stmt_bind_param(
                    $stmt,
                    "isssssiss",
                    $aptnumber,
                    $name,
                    $mobnum,
                    $email,
                    $appdate,
                    $aaptime,
                    $specialization,
                    $doctorlist,
                    $message
                );


                if (
                    mysqli_stmt_execute($stmt)
                ) {

                    $lastInsertId =
                        mysqli_insert_id($conn);


                    mysqli_stmt_close($stmt);


                    if ($lastInsertId > 0) {

                        echo '<script>
                            alert(
                                "Your Appointment Request Has Been Send. We Will Contact You Soon"
                            );
                            window.location.href =
                                "bookappointment.php";
                        </script>';

                        exit;

                    } else {

                        echo '<script>
                            alert(
                                "Something Went Wrong. Please try again"
                            );
                        </script>';

                    }


                } else {

                    echo '<script>
                        alert(
                            "Something Went Wrong. Please try again"
                        );
                    </script>';

                    mysqli_stmt_close($stmt);
                }


            } else {

                echo '<script>
                    alert(
                        "Unable to process appointment. Please try again."
                    );
                </script>';

            }

        }

    }

}

?>

<!doctype html>
<html lang="en">

<head>

    <title>
        Doctor Appointment
    </title>


    <!-- CSS FILES -->

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

    <link
        href="css_app/bootstrap.min1.css"
        rel="stylesheet"
    >


    <link
        href="css_app/templatemo-medic-care4.css"
        rel="stylesheet"
    >


    <script>

        function getdoctors(val) {

            $.ajax({

                type: "POST",

                url: "get_doctors.php",

                data: 'sp_id=' + val,

                success: function(data) {

                    $("#doctorlist").html(data);

                },

                error: function() {

                    $("#doctorlist").html(
                        '<option value="">Unable to load doctors</option>'
                    );

                }

            });

        }

    </script>

</head>


<body
    style="
        background-color:White;
        border-radius:10px;
    "
>


<section
    class="section-padding"
    id="booking"
>


    <div class="container">


        <div class="row">


            <div
                class="col-lg-8 col-12 mx-auto"
            >


                <div
                    class="booking-form"
                >


                    <h3
                        class="text-center mb-lg-3 mb-2"
                        style="color:#0188df;"
                    >
                        Book an appointment
                    </h3>


                    <form
                        role="form"
                        method="post"
                        style="margin-top:30px;"
                    >


                        <div
                            class="row"
                        >


                            <!-- FULL NAME -->

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
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['name'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
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
                                    pattern="[^ @]*@[^ @]*"
                                    class="form-control"
                                    style="
                                        font-size:15px;
                                        background-color:#EDF4FF;
                                        border-radius:8px;
                                    "
                                    placeholder="Email address"
                                    required
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['email'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
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
                                    pattern="[0-9]{10}"
                                    required
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['phone'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
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
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['date'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
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
                                    value="<?php
                                        echo htmlspecialchars(
                                            $_POST['time'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                >

                            </div>


                            <!-- SPECIALIZATION -->

                            <div
                                class="col-lg-6 col-12"
                            >

                                <select
                                    onChange="getdoctors(this.value);"
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

                                    // ==================================
                                    // LOAD SPECIALIZATIONS
                                    // ==================================

                                    if ($specializationId > 0) {

                                        $stmt =
                                            mysqli_prepare(
                                                $conn,
                                                "SELECT ID, Specialization
                                                 FROM tblspecialization
                                                 WHERE ID = ?
                                                 LIMIT 1"
                                            );


                                        if ($stmt) {

                                            mysqli_stmt_bind_param(
                                                $stmt,
                                                "i",
                                                $specializationId
                                            );

                                            mysqli_stmt_execute(
                                                $stmt
                                            );

                                            $result =
                                                mysqli_stmt_get_result(
                                                    $stmt
                                                );


                                            if (
                                                $result &&
                                                mysqli_num_rows(
                                                    $result
                                                ) > 0
                                            ) {

                                                $row =
                                                    mysqli_fetch_assoc(
                                                        $result
                                                    );

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

                                            mysqli_stmt_close(
                                                $stmt
                                            );

                                        }

                                    } else {

                                        $result =
                                            mysqli_query(
                                                $conn,
                                                "SELECT ID, Specialization
                                                 FROM tblspecialization
                                                 ORDER BY ID ASC"
                                            );


                                        if ($result) {

                                            while (
                                                $row =
                                                mysqli_fetch_assoc(
                                                    $result
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

                                    }

                                    ?>

                                </select>

                            </div>


                            <!-- DOCTOR -->

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


                            <!-- MESSAGE -->

                            <div
                                class="col-12"
                            >

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
                                ><?php
                                    echo htmlspecialchars(
                                        $_POST['message'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                ?></textarea>

                            </div>


                            <!-- BOOK BUTTON -->

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


<!-- ==========================================
     JAVASCRIPT
========================================== -->

<script src="js/jquery.min.js"></script>

<script src="js/bootstrap.bundle.min.js"></script>

<script src="js/owl.carousel.min.js"></script>

<script src="js/scrollspy.min.js"></script>

<script src="js/custom.js"></script>


</body>

</html>