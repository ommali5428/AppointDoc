<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

/*
|--------------------------------------------------------------------------
| CHECK LOGIN
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: /img/AppointDoc/login/login_form.php');
    exit();
}

$docid = $_SESSION['admin'];


/*
|--------------------------------------------------------------------------
| TOTAL APPROVED APPOINTMENTS
|--------------------------------------------------------------------------
*/
$sql = "SELECT COUNT(*) FROM tblappointment 
        WHERE Status = 'Approved' AND DoctorID = :docid";

$query = $dbh->prepare($sql);
$query->bindParam(':docid', $docid, PDO::PARAM_INT);
$query->execute();

$totappapt = $query->fetchColumn();


/*
|--------------------------------------------------------------------------
| TOTAL CANCELLED APPOINTMENTS
|--------------------------------------------------------------------------
*/
$sql = "SELECT COUNT(*) FROM tblappointment 
        WHERE Status = 'Cancelled' AND DoctorID = :docid";

$query = $dbh->prepare($sql);
$query->bindParam(':docid', $docid, PDO::PARAM_INT);
$query->execute();

$totncanapt = $query->fetchColumn();


/*
|--------------------------------------------------------------------------
| TOTAL APPOINTMENTS
|--------------------------------------------------------------------------
*/
$sql = "SELECT COUNT(*) FROM tblappointment 
        WHERE DoctorID = :docid";

$query = $dbh->prepare($sql);
$query->bindParam(':docid', $docid, PDO::PARAM_INT);
$query->execute();

$totapt = $query->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Doctor - Dashboard</title>

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">

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

<!--============= START MAIN AREA =============-->

<?php include_once('includes/header.php'); ?>

<?php include_once('includes/sidebar.php'); ?>


<!-- APP MAIN -->
<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">


                <!-- ================= APPROVED ================= -->

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


                        <footer class="widget-footer bg-success"
                                style="background-color:#4FC3F7;">

                            <a href="approved-appointment.php">

                                <small>View Detail</small>

                            </a>

                            <span class="small-chart pull-right"
                                  data-plugin="sparkline"
                                  data-options="[1,2,3,5,4], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }">
                            </span>

                        </footer>

                    </div>

                </div>


                <!-- ================= CANCELLED ================= -->

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


                        <footer class="widget-footer bg-danger"
                                style="background-color:#EF9A9A;">

                            <a href="cancelled-appointment.php">

                                <small>View Detail</small>

                            </a>

                            <span class="small-chart pull-right"
                                  data-plugin="sparkline"
                                  data-options="[2,4,3,4,3], { type: 'bar', barColor: '#ffffff', barWidth: 5, barSpacing: 2 }">
                            </span>

                        </footer>

                    </div>

                </div>


                <!-- ================= TOTAL ================= -->

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


                        <footer class="widget-footer bg-primary"
                                style="background-color:#1565C0;">

                            <a href="all-appointment.php">

                                <small>View Detail</small>

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


    <!-- APP FOOTER -->

    <?php include_once('includes/footer.php'); ?>

    <!-- /#app-footer -->

</main>

<!--========== END APP MAIN ==========-->


<!-- ================= JAVASCRIPT ================= -->

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