<?php

// header.php handles:
// - output buffering
// - session_start()
// - database connection
// - HTML header/navbar

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
                src="/img/AppointDoc/drimages/home2.jpg"
                alt="Appointment Doctor"
            >

        </div>

        <!-- Home Content -->
        <div class="content">

            <?php if (isset($_SESSION['user_name'])): ?>

                <p>
                    Welcome&nbsp;&nbsp;
                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
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

<h1 class="heading1" style="color:#0188df;">
    Specialist
</h1>

<section id="doctor" class="card">

    <div class="box-container">

        <?php

        $query = "SELECT * FROM tblspecialization";

        $result = mysqli_query($conn, $query);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {

                ?>

                <div class="box">

                    <a href="dr.php?id=<?php echo (int)$row['ID']; ?>">

                        <img
                            src="/img/AppointDoc/drimages/<?php echo htmlspecialchars($row['Image']); ?>"
                            alt="<?php echo htmlspecialchars($row['Specialization']); ?>"
                        >

                    </a>

                    <div class="content">

                        <a href="dr.php?id=<?php echo (int)$row['ID']; ?>">

                            <h2>
                                <?php
                                echo htmlspecialchars($row['Specialization']);
                                ?>
                            </h2>

                        </a>

                    </div>

                </div>

                <?php

            }

        } else {

            echo "<p>Unable to load specialists.</p>";

        }

        ?>

    </div>

</section>


<!-- =========================
     EMERGENCY APPOINTMENT
========================= -->

<section id="emergency" class="review">

    <h1 class="heading">
        Emergency Appointment Book
    </h1>

    <div class="box-container">

        <div class="box">

            <div class="images">

                <img
                    src="/img/AppointDoc/drimages/emergency.jpeg"
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

<section id="review" class="review">

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

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {

                ?>

                <div class="box">

                    <i class="fas fa-quote-left"></i>

                    <p>
                        <?php
                        echo htmlspecialchars($row['feedback']);
                        ?>
                    </p>

                    <div class="info">

                        <hr>

                        <h3>

                            <?php
                            echo htmlspecialchars($row['name']);
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


<!-- =========================
     FOOTER
========================= -->

<section
    class="footer"
    style="
        background-image:url('/img/AppointDoc/drimages/25757.jpg');
        background-size:100%;
    "
>

    <!-- Specialists -->
    <div class="box">

        <h2 class="logo">
            Specialist
        </h2>

        <?php

        try {

            $sql = "SELECT * FROM tblspecialization";

            $stmt = $dbh->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                ?>

                <a href="/img/AppointDoc/dr.php?id=<?php echo (int)$row['ID']; ?>">

                    <?php
                    echo htmlspecialchars($row['Specialization']);
                    ?>

                </a>

                <?php

            }

        } catch (PDOException $e) {

            echo "<p>Unable to load specialists.</p>";

        }

        ?>

    </div>


    <!-- Links -->
    <div class="box">

        <h2 class="logo">
            Links
        </h2>

        <a href="/img/AppointDoc/index.php">
            Home
        </a>

        <a href="/img/AppointDoc/about.php">
            About
        </a>

        <a href="/img/AppointDoc/appointment/bookappointment.php">
            Book Appointment
        </a>

        <a href="/img/AppointDoc/appointment/check-appointment.php">
            Check Appointment
        </a>

        <a href="/img/AppointDoc/appointment/cancel.php">
            Cancel Appointment
        </a>

        <a href="/img/AppointDoc/feedback.php">
            Feedback
        </a>

    </div>


    <!-- Copyright -->
    <h1 class="credit">

        Created by

        <span>
            OM And MAYUR
        </span>

        All Rights Reserved.

    </h1>

</section>


<!-- =========================
     END HTML
========================= -->

</body>

</html>