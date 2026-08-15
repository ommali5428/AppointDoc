<?php

/*
|--------------------------------------------------------------------------
| AppointDoc - Home Page
|--------------------------------------------------------------------------
| header.php handles:
| - session_start()
| - database connection
| - HTML <head>
| - navbar
| - profile menu
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/header.php';

?>

<!-- =========================
     HOME SECTION
========================= -->

<section id="home" class="home">

    <div class="row">

        <!-- Home Image -->
        <div class="images">

            <img
                src="/drimages/home2.jpg"
                alt="Appointment Doctor"
            >

        </div>


        <!-- Home Content -->
        <div class="content">

            <?php if (isset($_SESSION['user_name']) && $_SESSION['user_name'] !== ''): ?>

                <p>
                    Welcome&nbsp;&nbsp;
                    <?php
                    echo htmlspecialchars(
                        $_SESSION['user_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </p>

            <?php endif; ?>


            <h1>
                <span>Stay</span> Safe,
                <span>Stay</span> Healthy.
            </h1>


            <p>
                Balance Is The Key To Everything.
                What we Do, Think, Say, Eat, Feel,
                They All Require Awareness,
                And Through This Awareness, We Can Grow.
            </p>

        </div>

    </div>

</section>


<!-- =========================
     SPECIALIST SECTION
========================= -->

<h1
    class="heading1"
    style="color:#0188df;"
>
    Specialist
</h1>


<section id="doctor" class="card">

    <div class="box-container">

        <?php

        $query = "SELECT * FROM tblspecialization";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                /*
                |--------------------------------------------------------------------------
                | Get specialization ID
                |--------------------------------------------------------------------------
                */

                $specializationId = isset($row['ID'])
                    ? (int)$row['ID']
                    : 0;


                /*
                |--------------------------------------------------------------------------
                | Get specialization name
                |--------------------------------------------------------------------------
                */

                if (isset($row['Specialization'])) {

                    $specializationName = $row['Specialization'];

                } elseif (isset($row[1])) {

                    $specializationName = $row[1];

                } else {

                    $specializationName = '';

                }


                /*
                |--------------------------------------------------------------------------
                | Get specialization image
                |--------------------------------------------------------------------------
                */

                if (isset($row['Image']) && $row['Image'] !== '') {

                    $specializationImage = $row['Image'];

                } elseif (isset($row[2]) && $row[2] !== '') {

                    $specializationImage = $row[2];

                } else {

                    $specializationImage = '';

                }


                $specializationName = htmlspecialchars(
                    $specializationName,
                    ENT_QUOTES,
                    'UTF-8'
                );

                $specializationImage = htmlspecialchars(
                    $specializationImage,
                    ENT_QUOTES,
                    'UTF-8'
                );


                /*
                |--------------------------------------------------------------------------
                | Skip invalid database records
                |--------------------------------------------------------------------------
                */

                if ($specializationId <= 0 || $specializationName === '') {
                    continue;
                }

                ?>

                <!-- Specialist Box -->

                <div class="box">

                    <a href="/dr.php?id=<?php echo $specializationId; ?>">

                        <?php if ($specializationImage !== ''): ?>

                            <img
                                src="/drimages/<?php echo $specializationImage; ?>"
                                alt="<?php echo $specializationName; ?>"
                            >

                        <?php endif; ?>

                    </a>


                    <div class="content">

                        <a href="/dr.php?id=<?php echo $specializationId; ?>">

                            <h2>
                                <?php echo $specializationName; ?>
                            </h2>

                        </a>

                    </div>

                </div>

                <?php

            }

        } else {

            ?>

            <p>
                Unable to load specialists.
            </p>

            <?php

        }

        ?>

    </div>

</section>


<!-- =========================
     EMERGENCY APPOINTMENT
========================= -->

<section
    id="emergency"
    class="review"
>

    <h1 class="heading">
        Emergency Appointment Book
    </h1>


    <div class="box-container">

        <div class="box">

            <div class="images">

                <img
                    src="/drimages/emergency.jpeg"
                    alt="Emergency Appointment"
                >


                <div class="info">

                    <a href="#">

                        <h3>
                            Emergency Appointment
                        </h3>

                    </a>

                </div>

            </div>


            <p style="color:green;">
                *Under Construct*
            </p>

        </div>

    </div>

</section>


<!-- =========================
     PATIENT REVIEWS
========================= -->

<section
    id="review"
    class="review"
>

    <h1 class="heading">
        Our Patient Reviews
    </h1>


    <h3 class="title">
        What patients say about us
    </h3>


    <div class="box-container">

        <?php

        $query = "
            SELECT *
            FROM feedback
            ORDER BY id DESC
            LIMIT 3
        ";

        $result = mysqli_query($conn, $query);


        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {


                /*
                |--------------------------------------------------------------------------
                | Feedback text
                |--------------------------------------------------------------------------
                */

                if (isset($row['feedback'])) {

                    $feedbackText = $row['feedback'];

                } elseif (isset($row['Feedback'])) {

                    $feedbackText = $row['Feedback'];

                } elseif (isset($row[3])) {

                    $feedbackText = $row[3];

                } else {

                    $feedbackText = '';

                }


                /*
                |--------------------------------------------------------------------------
                | Patient name
                |--------------------------------------------------------------------------
                */

                if (isset($row['name'])) {

                    $patientName = $row['name'];

                } elseif (isset($row['Name'])) {

                    $patientName = $row['Name'];

                } elseif (isset($row[1])) {

                    $patientName = $row[1];

                } else {

                    $patientName = 'Patient';

                }


                $feedbackText = htmlspecialchars(
                    $feedbackText,
                    ENT_QUOTES,
                    'UTF-8'
                );

                $patientName = htmlspecialchars(
                    $patientName,
                    ENT_QUOTES,
                    'UTF-8'
                );

                ?>

                <!-- Review Box -->

                <div class="box">

                    <i class="fas fa-quote-left"></i>


                    <p>
                        <?php echo $feedbackText; ?>
                    </p>


                    <div class="info">

                        <hr>


                        <h3>
                            <?php echo $patientName; ?>
                        </h3>

                    </div>

                </div>

                <?php

            }

        } else {

            ?>

            <p>
                No patient reviews available.
            </p>

            <?php

        }

        ?>

    </div>

</section>


<!-- =========================
     FOOTER
========================= -->

<section
    class="footer"
    style="
        background-image: url('/drimages/25757.jpg');
        background-size: 100%;
    "
>


    <!-- =========================
         SPECIALISTS
    ========================= -->

    <div class="box">

        <h2 class="logo">
            Specialist
        </h2>


        <?php

        try {

            $sql = "SELECT * FROM tblspecialization";

            $stmt = $dbh->query($sql);


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                $specializationId = isset($row['ID'])
                    ? (int)$row['ID']
                    : 0;


                if (isset($row['Specialization'])) {

                    $specializationName = $row['Specialization'];

                } elseif (isset($row[1])) {

                    $specializationName = $row[1];

                } else {

                    $specializationName = '';

                }


                $specializationName = htmlspecialchars(
                    $specializationName,
                    ENT_QUOTES,
                    'UTF-8'
                );


                if ($specializationId <= 0 || $specializationName === '') {
                    continue;
                }

                ?>

                <a href="/dr.php?id=<?php echo $specializationId; ?>">

                    <?php echo $specializationName; ?>

                </a>

                <?php

            }

        } catch (PDOException $e) {

            ?>

            <p>
                Unable to load specialists.
            </p>

            <?php

        }

        ?>

    </div>


    <!-- =========================
         WEBSITE LINKS
    ========================= -->

    <div class="box">

        <h2 class="logo">
            Links
        </h2>


        <a href="/index.php">
            Home
        </a>


        <a href="/about.php">
            About
        </a>


        <a href="/appointment/bookappointment.php">
            Book Appointment
        </a>


        <a href="/appointment/check-appointment.php">
            Check Appointment
        </a>


        <a href="/appointment/cancel.php">
            Cancel Appointment
        </a>


        <a href="/feedback.php">
            Feedback
        </a>

    </div>


    <!-- =========================
         COPYRIGHT
    ========================= -->

    <h1 class="credit">

        Created by

        <span>
            OM And MAYUR
        </span>

        All Rights Reserved.

    </h1>


</section>


<!-- =========================
     END PAGE
========================= -->

</body>

</html>