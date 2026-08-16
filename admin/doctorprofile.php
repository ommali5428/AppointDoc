<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Doctors Profile</title>

    <style>
        table {
            border: solid 2px black;
        }

        td {
            border: solid 2px black;
            vertical-align: middle !important;
        }

        th {
            border: solid 2px black;
            text-align: center;
            vertical-align: middle !important;
        }

        .doctor-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .action-btn {
            width: 80px;
        }
    </style>

    <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">

    <!-- build:css assets/css/app.min.css -->
    <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
    <link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <!-- endbuild -->

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        Breakpoints();
    </script>

</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

<!--============= start main area =============-->

<?php include_once('includes/header.php'); ?>

<?php include_once('includes/sidebar.php'); ?>


<!-- APP MAIN ==========-->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <!-- HEADER -->

                        <header class="widget-header">

                            <h3 class="widget-title">
                                Doctors Profile
                            </h3>

                        </header>

                        <hr class="widget-separator">


                        <!-- BODY -->

                        <div class="widget-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">

                                    <thead>

                                        <tr>

                                            <th>Name</th>

                                            <th>Qualification</th>

                                            <th>Experience</th>

                                            <th>Hospital Detail</th>

                                            <th>Timing</th>

                                            <th>Specialist</th>

                                            <th>Images</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                    <?php

                                    /*
                                     * Get all doctors and their specialization
                                     */

                                    $query = "
                                        SELECT
                                            d.ID,
                                            d.FullName,
                                            d.qualification,
                                            d.experience,
                                            d.hospital_detail,
                                            d.timing,
                                            d.images,
                                            s.Specialization
                                        FROM tbldoctor d
                                        LEFT JOIN tblspecialization s
                                            ON d.Specialization = s.ID
                                        ORDER BY d.ID DESC
                                    ";

                                    $result = mysqli_query($conn, $query);


                                    if ($result && mysqli_num_rows($result) > 0) {

                                        while ($row = mysqli_fetch_assoc($result)) {

                                    ?>

                                        <tr>

                                            <!-- Doctor Name -->

                                            <td>
                                                <?php
                                                echo htmlentities($row['FullName']);
                                                ?>
                                            </td>


                                            <!-- Qualification -->

                                            <td>
                                                <?php
                                                echo htmlentities($row['qualification']);
                                                ?>
                                            </td>


                                            <!-- Experience -->

                                            <td>
                                                <?php
                                                echo htmlentities($row['experience']);
                                                ?>
                                            </td>


                                            <!-- Hospital -->

                                            <td>
                                                <?php
                                                echo htmlentities($row['hospital_detail']);
                                                ?>
                                            </td>


                                            <!-- Timing -->

                                            <td>
                                                <?php
                                                echo htmlentities($row['timing']);
                                                ?>
                                            </td>


                                            <!-- Specialization -->

                                            <td>

                                                <?php

                                                if (!empty($row['Specialization'])) {

                                                    echo htmlentities($row['Specialization']);

                                                } else {

                                                    echo "Not Available";

                                                }

                                                ?>

                                            </td>


                                            <!-- Doctor Image -->

                                            <td style="text-align:center;">

                                                <?php

                                                if (!empty($row['images'])) {

                                                ?>

                                                    <img
                                                        src="/img/AppointDoc/appointment/dr_pannel/images/<?php echo htmlentities($row['images']); ?>"
                                                        class="doctor-image"
                                                        alt="Doctor Image"
                                                    >

                                                <?php

                                                } else {

                                                    echo "No Image";

                                                }

                                                ?>

                                            </td>


                                            <!-- Action -->

                                            <td style="width:185px; text-align:center;">

                                                <!-- EDIT -->

                                                <a
                                                    href="/img/AppointDoc/admin/updatedr.php?upid=<?php echo (int)$row['ID']; ?>"
                                                    class="btn btn-primary action-btn"
                                                >
                                                    Edit
                                                </a>


                                                <br>
                                                <br>


                                                <!-- DELETE -->

                                                <a
                                                    href="/img/AppointDoc/admin/deletedr.php?deleteid=<?php echo (int)$row['ID']; ?>"
                                                    class="btn btn-danger action-btn"
                                                    onclick="return confirm('Are you sure you want to delete this doctor?');"
                                                >
                                                    Delete
                                                </a>

                                            </td>

                                        </tr>


                                    <?php

                                        }

                                    } else {

                                    ?>

                                        <tr>

                                            <td colspan="8" style="text-align:center;">

                                                No doctors found.

                                            </td>

                                        </tr>

                                    <?php

                                    }

                                    ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>
                        <!-- END widget-body -->

                    </div>
                    <!-- END widget -->

                </div>
                <!-- END column -->

            </div>
            <!-- END row -->

        </section>
        <!-- END app-content -->

    </div>
    <!-- END wrap -->


    <!-- APP FOOTER -->

    <?php include_once('includes/footer.php'); ?>

    <!-- /#app-footer -->

</main>

<!--========== END app main ==========-->


<!-- JAVASCRIPT -->

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