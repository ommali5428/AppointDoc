<?php

session_start();

// Show errors while debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// dashboard.php is inside /admin/
// ../conn.php points to /AppointDoc/conn.php
require_once __DIR__ . '/../conn.php';

// Check admin login
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {

    header("Location: ../login/login_form.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - Dashboard</title>

    <link rel="stylesheet"
          href="libs/bower/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet"
          href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">

    <link rel="stylesheet"
          href="libs/bower/animate.css/animate.min.css">

    <link rel="stylesheet"
          href="libs/bower/fullcalendar/dist/fullcalendar.min.css">

    <link rel="stylesheet"
          href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">

    <link rel="stylesheet"
          href="assets/css/bootstrap.css">

    <link rel="stylesheet"
          href="assets/css/core.css">

    <link rel="stylesheet"
          href="assets/css/app.css">

    <link rel="stylesheet"
          href="/img/AppointDoc/css/navbar.css">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        Breakpoints();
    </script>

</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

<?php include_once __DIR__ . '/includes/header.php'; ?>

<?php include_once __DIR__ . '/includes/sidebar.php'; ?>


<!-- APP MAIN -->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <!-- APPROVED APPOINTMENTS -->

                <div class="col-md-4 col-sm-12">

                    <div class="widget stats-widget">

                        <div class="widget-body clearfix">

                            <?php

                            $sql = "SELECT COUNT(*) 
                                    FROM tblappointment
                                    WHERE Status = 'Approved'";

                            $query = $dbh->prepare($sql);

                            $query->execute();

                            $totalApproved = $query->fetchColumn();

                            ?>

                            <div class="pull-left">

                                <h3 class="widget-title text-success">

                                    <span
                                        class="counter"
                                        style="color:#4FC3F7;"
                                    >

                                        <?php
                                        echo htmlentities($totalApproved);
                                        ?>

                                    </span>

                                </h3>

                                <small class="text-color">
                                    Total Approved
                                </small>

                            </div>

                        </div>

                        <footer
                            class="widget-footer"
                            style="background-color:#4FC3F7;"
                        >

                            <a href="approved-appointment.php">

                                <small>
                                    View Detail
                                </small>

                            </a>

                        </footer>

                    </div>

                </div>


                <!-- CANCELLED APPOINTMENTS -->

                <div class="col-md-4 col-sm-12">

                    <div class="widget stats-widget">

                        <div class="widget-body clearfix">

                            <?php

                            $sql = "SELECT COUNT(*) 
                                    FROM tblappointment
                                    WHERE Status = 'Cancelled'";

                            $query = $dbh->prepare($sql);

                            $query->execute();

                            $totalCancelled = $query->fetchColumn();

                            ?>

                            <div class="pull-left">

                                <h3 class="widget-title text-danger">

                                    <span
                                        class="counter"
                                        style="color:#EF9A9A;"
                                    >

                                        <?php
                                        echo htmlentities($totalCancelled);
                                        ?>

                                    </span>

                                </h3>

                                <small class="text-color">
                                    Cancelled Appointment
                                </small>

                            </div>

                        </div>

                        <footer
                            class="widget-footer"
                            style="background-color:#EF9A9A;"
                        >

                            <a href="cancelled-appointment.php">

                                <small>
                                    View Detail
                                </small>

                            </a>

                        </footer>

                    </div>

                </div>


                <!-- TOTAL APPOINTMENTS -->

                <div class="col-md-4 col-sm-12">

                    <div class="widget stats-widget">

                        <div class="widget-body clearfix">

                            <?php

                            $sql = "SELECT COUNT(*) 
                                    FROM tblappointment";

                            $query = $dbh->prepare($sql);

                            $query->execute();

                            $totalAppointments = $query->fetchColumn();

                            ?>

                            <div class="pull-left">

                                <h3 class="widget-title text-primary">

                                    <span
                                        class="counter"
                                        style="color:#1565C0;"
                                    >

                                        <?php
                                        echo htmlentities($totalAppointments);
                                        ?>

                                    </span>

                                </h3>

                                <small class="text-color">
                                    Total Appointment
                                </small>

                            </div>

                        </div>

                        <footer
                            class="widget-footer"
                            style="background-color:#1565C0;"
                        >

                            <a href="all-appointment.php">

                                <small>
                                    View Detail
                                </small>

                            </a>

                        </footer>

                    </div>

                </div>

            </div>

        </section>

    </div>


    <!-- APP FOOTER -->

    <?php include_once __DIR__ . '/includes/footer.php'; ?>


</main>


<!-- JAVASCRIPT -->

<script src="libs/bower/jquery/dist/jquery.js"></script>

<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>

<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>

<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>

<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>

<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

<script src="libs/bower/PACE/pace.min.js"></script>

<script src="assets/js/library.js"></script>

<script src="assets/js/plugins.js"></script>

<script src="assets/js/app.js"></script>

<script src="libs/bower/moment/moment.js"></script>

<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>

<script src="assets/js/fullcalendar.js"></script>

</body>

</html>