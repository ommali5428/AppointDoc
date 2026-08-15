<?php

// ==========================================
// HEADER
// ==========================================

require_once __DIR__ . '/header.php';

?>

<!-- ==========================================
     HOME SECTION
=========================================== -->

<section id="home" class="home">

    <div class="row">

        <!-- HOME IMAGE -->

        <div class="images">

            <img
                src="/drimages/home2.jpg"
                alt="Appointment Doctor"
            >

        </div>


        <!-- HOME CONTENT -->

        <div class="content">

            <?php if (isset($_SESSION['user_name'])): ?>

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


<!-- ==========================================
     SPECIALIST SECTION
=========================================== -->

<h1
    class="heading1"
    style="color:#0188df;"
>
    Specialist
</h1>


<section
    id="doctor"
    class="card"
>

    <div class="box-container">

        <?php

        // ==========================================
        // GET SPECIALIZATIONS
        // ==========================================

        $query = "SELECT * FROM tblspecialization";

        $result = mysqli_query($conn, $query);


        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {

                // ==================================
                // SAFE VALUES
                // ==================================

                $specializationId =
                    isset($row['ID'])
                    ? (int)$row['ID']
                    : 0;


                $specializationName =
                    htmlspecialchars(
                        $row['Specialization'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );


                /*
                 * IMPORTANT:
                 *
                 * Your database currently has NULL/empty
                 * values in the Image column.
                 *
                 * Therefore we DO NOT pass NULL to
                 * htmlspecialchars().
                 */

                $imageName =
                    isset($row['Image'])
                    ? trim((string)$row['Image'])
                    : '';


                // ==================================
                // IMAGE PATH
                // ==================================

                $imagePath = '';

                if ($imageName !== '') {

                    $imagePath =
                        '/drimages/' .
                        rawurlencode($imageName);

                }

                ?>

                <div class="box">

                    <!-- SPECIALIST IMAGE -->

                    <a
                        href="/dr.php?id=<?php echo $specializationId; ?>"
                    >

                        <?php if ($imagePath !== ''): ?>

                            <img
                                src="<?php echo $imagePath; ?>"
                                alt="<?php echo $specializationName; ?>"
                            >

                        <?php else: ?>

                            <!--
                                No image exists in database.
                                Do not show a broken image.
                            -->

                            <div
                                style="
                                    width:100%;
                                    min-height:180px;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    background:#f5f5f5;
                                    border-radius:8px;
                                "
                            >

                                <i
                                    class="fas fa-user-doctor"
                                    style="
                                        font-size:70px;
                                        color:#0188df;
                                    "
                                ></i>

                            </div>

                        <?php endif; ?>

                    </a>


                    <!-- SPECIALIST NAME -->

                    <div class="content">

                        <a
                            href="/dr.php?id=<?php echo $specializationId; ?>"
                        >

                            <h2>

                                <?php
                                echo $specializationName;
                                ?>

                            </h2>

                        </a>

                    </div>

                </div>

                <?php

            }

        } else {

            echo '<p>Unable to load specialists.</p>';

        }

        ?>

    </div>

</section>


<!-- ==========================================
     EMERGENCY APPOINTMENT
=========================================== -->

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


<!-- ==========================================
     PATIENT REVIEWS
=========================================== -->

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

        // ==========================================
        // GET LAST 3 REVIEWS
        // ==========================================

        $query = "
            SELECT *
            FROM feedback
            ORDER BY id DESC
            LIMIT 3
        ";


        $result = mysqli_query(
            $conn,
            $query
        );


        if ($result) {

            while (
                $row = mysqli_fetch_assoc($result)
            ) {

                $feedbackText =
                    htmlspecialchars(
                        $row['feedback'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );


                $feedbackName =
                    htmlspecialchars(
                        $row['name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );

                ?>

                <div class="box">

                    <i class="fas fa-quote-left"></i>


                    <p>

                        <?php
                        echo $feedbackText;
                        ?>

                    </p>


                    <div class="info">

                        <hr>


                        <h3>

                            <?php
                            echo $feedbackName;
                            ?>

                        </h3>

                    </div>

                </div>

                <?php

            }

        }

        ?>

    </div>

</section>


<!-- ==========================================
     FOOTER
=========================================== -->

<section
    class="footer"
    style="
        background-image:url('/drimages/25757.jpg');
        background-size:100%;
    "
>


    <!-- ==========================================
         SPECIALISTS
    =========================================== -->

    <div class="box">

        <h2 class="logo">

            Specialist

        </h2>


        <?php

        try {

            $sql =
                "SELECT * FROM tblspecialization";


            $stmt =
                $dbh->query($sql);


            while (
                $row = $stmt->fetch(PDO::FETCH_ASSOC)
            ) {

                $specializationId =
                    isset($row['ID'])
                    ? (int)$row['ID']
                    : 0;


                $specializationName =
                    htmlspecialchars(
                        $row['Specialization'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );


                if ($specializationId > 0) {

                    ?>

                    <a
                        href="/dr.php?id=<?php echo $specializationId; ?>"
                    >

                        <?php
                        echo $specializationName;
                        ?>

                    </a>

                    <?php

                }

            }

        } catch (PDOException $e) {

            echo '<p>Unable to load specialists.</p>';

        }

        ?>

    </div>


    <!-- ==========================================
         LINKS
    =========================================== -->

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


        <a
            href="/appointment/bookappointment.php"
        >
            Book Appointment
        </a>


        <a
            href="/appointment/check-appointment.php"
        >
            Check Appointment
        </a>


        <a
            href="/appointment/cancel.php"
        >
            Cancel Appointment
        </a>


        <a href="/feedback.php">
            Feedback
        </a>

    </div>


    <!-- ==========================================
         COPYRIGHT
    =========================================== -->

    <h1 class="credit">

        Created by

        <span>
            OM And MAYUR
        </span>

        All Rights Reserved.

    </h1>


</section>


<!-- ==========================================
     END HTML
=========================================== -->

</body>

</html>