<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Approved Appointment Detail</title>

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">

    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/app.css">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        Breakpoints();
    </script>

</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

<!--============= start main area -->

<?php include_once('includes/header.php'); ?>

<?php include_once('includes/sidebar.php'); ?>


<!-- APP MAIN ==========-->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <!-- DOM dataTable -->

                <div class="col-md-12">

                    <div class="widget">

                        <header class="widget-header">

                            <h4 class="widget-title">
                                Approved Appointment
                            </h4>

                        </header>

                        <hr class="widget-separator">

                        <div class="widget-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">

                                    <thead>

                                        <tr>

                                            <th>ID</th>

                                            <th>Appointment Number</th>

                                            <th>Patient Name</th>

                                            <th>Mobile Number</th>

                                            <th>Email</th>

                                            <th>Status</th>

                                            <th>Doctor</th>

                                        </tr>

                                    </thead>

                                    <tbody>

<?php

$sql = "SELECT *
        FROM tblappointment
        WHERE Status = :status
        ORDER BY ID DESC";

$query = $dbh->prepare($sql);

$status = 'Approved';

$query->bindParam(':status', $status, PDO::PARAM_STR);

$query->execute();

$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {

    foreach ($results as $row) {

?>

                                        <tr>

                                            <td>
                                                <?php echo htmlentities($row->ID); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlentities($row->AppointmentNumber); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlentities($row->Name); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlentities($row->MobileNumber); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlentities($row->Email); ?>
                                            </td>

                                            <td>

<?php

if ($row->Status == '') {

    echo "Not Updated Yet";

} else {

    echo htmlentities($row->Status);

}

?>

                                            </td>

                                            <td>

<?php

$doctorId = (int)$row->Doctor;

$doctorQuery = "SELECT FullName
                FROM tbldoctor
                WHERE ID = :doctorId";

$doctorStmt = $dbh->prepare($doctorQuery);

$doctorStmt->bindParam(
    ':doctorId',
    $doctorId,
    PDO::PARAM_INT
);

$doctorStmt->execute();

$doctor = $doctorStmt->fetch(PDO::FETCH_OBJ);

if ($doctor) {

    echo htmlentities($doctor->FullName);

} else {

    echo "Doctor Not Found";

}

?>

                                            </td>

                                        </tr>

<?php

    }

} else {

?>

                                        <tr>

                                            <td colspan="7" align="center">
                                                No approved appointments found.
                                            </td>

                                        </tr>

<?php

}

?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- END column -->

            </div>

        </section>

    </div>


    <!-- APP FOOTER -->

    <?php include_once('includes/footer.php'); ?>

    <!-- /#app-footer -->

</main>

<!--========== END app main -->


<!-- APP CUSTOMIZER -->

<?php
// include_once('includes/customizer.php');
?>


<!-- build:js assets/js/core.min.js -->

<script src="libs/bower/jquery/dist/jquery.js"></script>

<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>

<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>

<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>

<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>

<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

<script src="libs/bower/PACE/pace.min.js"></script>

<!-- endbuild -->


<!-- build:js assets/js/app.min.js -->

<script src="assets/js/library.js"></script>

<script src="assets/js/plugins.js"></script>

<script src="assets/js/app.js"></script>

<!-- endbuild -->

<script src="libs/bower/moment/moment.js"></script>

<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>

<script src="assets/js/fullcalendar.js"></script>

</body>

</html>