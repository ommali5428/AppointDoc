<?php

session_start();

/*
|--------------------------------------------------------------------------
| TEMPORARILY SHOW PHP ERRORS
|--------------------------------------------------------------------------
| Remove/change this after everything is working.
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);


/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/

include('C:\xampp\htdocs\img\AppointDoc\conn.php');


/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {

    header('Location: /img/AppointDoc/login/login_form.php');
    exit();

}


/*
|--------------------------------------------------------------------------
| APPROVED APPOINTMENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM tblappointment WHERE Status = 'Approved'";

$query = $dbh->prepare($sql);

$query->execute();

$totappapt = $query->fetchColumn();


/*
|--------------------------------------------------------------------------
| CANCELLED APPOINTMENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM tblappointment WHERE Status = 'Cancelled'";

$query = $dbh->prepare($sql);

$query->execute();

$totncanapt = $query->fetchColumn();


/*
|--------------------------------------------------------------------------
| TOTAL APPOINTMENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM tblappointment";

$query = $dbh->prepare($sql);

$query->execute();

$totapt = $query->fetchColumn();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Admin - Dashboard</title>


    <!-- Font Awesome -->

    <link rel="stylesheet"
          href="libs/bower/font-awesome/css/font-awesome.min.css">


    <!-- Material Design Icons -->

    <link rel="stylesheet"
          href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">


    <!-- Animate -->

    <link rel="stylesheet"
          href="libs/bower/animate.css/animate.min.css">


    <!-- Full Calendar -->

    <link rel="stylesheet"
          href="libs/bower/fullcalendar/dist/fullcalendar.min.css">


    <!-- Perfect Scrollbar -->

    <link rel="stylesheet"
          href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">


    <!-- Bootstrap -->

    <link rel="stylesheet"
          href="assets/css/bootstrap.css">


    <!-- Core -->

    <link rel="stylesheet"
          href="assets/css/core.css">


    <!-- App -->

    <link rel="stylesheet"
          href="assets/css/app.css">


    <!-- Navbar -->

    <link rel="stylesheet"
          href="/img/AppointDoc/css/navbar.css">


    <!-- Google Font -->

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">


    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>

        Breakpoints();

    </script>

</head>


<body class="menubar-left menubar-unfold menubar-light theme-primary">


<!--======================================================
    HEADER
=======================================================-->

<?php include_once('includes/header.php'); ?>


<!--======================================================
    SIDEBAR
=======================================================-->

<?php include_once('includes/sidebar.php'); ?>


<!--======================================================
    MAIN
=======================================================-->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">


                <!--==================================================
                    APPROVED APPOINTMENTS
                ===================================================-->

                <div class="col-md-4 col-sm-6">

                    <div class="widget stats-widget">

                        <div class="widget-body clearfix">

                            <div class="pull-left">

                                <h3 class="widget-title text-success">

                                    <span class="counter"
                                          data-plugin="counterUp"
                                          style="color:#4FC3F7;">

                                        <?php echo htmlentities($totappapt); ?>

                                    </span>

                                </h3>


                                <small class="text-color">

                                    Total Approved

                                </small>

                            </div>

                        </div>


                        <footer class="widget-footer"
                                style="background-color:#4FC3F7;">

                            <a href="approved-appointment.php">

                                <small>

                                    View Detail

                                </small>

                            </a>


                            <span class="small-chart pull-right"
                                  data-plugin="sparkline"
                                  data-options="[1,2,3,5,4], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }">

                            </span>

                        </footer>

                    </div>

                </div>



                <!--==================================================
                    CANCELLED APPOINTMENTS
                ===================================================-->

                <div class="col-md-4 col-sm-6">

                    <div class="widget stats-widget">

                        <div class="widget-body clearfix">

                            <div class="pull-left">

                                <h3 class="widget-title text-danger">

                                    <span class="counter"
                                          data-plugin="counterUp"
                                          style="color:#EF9A9A;">

                                        <?php echo htmlentities($totncanapt); ?>

                                    </span>

                                </h3>


                                <small class="text-color">

                                    Cancelled Appointment

                                </small>

                            </div>

                        </div>


                        <footer class="widget-footer"
                                style="background-color:#EF9A9A;">

                            <a href="cancelled-appointment.php">

                                <small>

                                    View Detail

                                </small>

                            </a>


                            <span class="small-chart pull-right"
                                  data-plugin="sparkline"
                                  data-options="[2,4,3,4,3], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }">

                            </span>

                        </footer>

                    </div>

                </div>



                <!--==================================================
                    TOTAL APPOINTMENTS
                ===================================================-->

                <div class="col-md-4 col-sm-6">

                    <div class="widget stats-widget">

                        <div class="widget-body clearfix">

                            <div class="pull-left">

                                <h3 class="widget-title text-primary">

                                    <span class="counter"
                                          data-plugin="counterUp"
                                          style="color:#1565C0;">

                                        <?php echo htmlentities($totapt); ?>

                                    </span>

                                </h3>


                                <small class="text-color">

                                    Total Appointment

                                </small>

                            </div>

                        </div>


                        <footer class="widget-footer"
                                style="background-color:#1565C0;">

                            <a href="all-appointment.php">

                                <small>

                                    View Detail

                                </small>

                            </a>


                            <span class="small-chart pull-right"
                                  data-plugin="sparkline"
                                  data-options="[5,4,3,5,2], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }">

                            </span>

                        </footer>

                    </div>

                </div>


            </div>

        </section>

    </div>


    <!--==================================================
        FOOTER
    ===================================================-->

    <?php include_once('includes/footer.php'); ?>


</main>



<!--======================================================
    JAVASCRIPT
=======================================================-->

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