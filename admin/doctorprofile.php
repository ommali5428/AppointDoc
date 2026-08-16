<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
| doctorprofile.php is inside /admin/
| conn.php is one folder above /admin/
*/

require_once __DIR__ . '/../conn.php';


/*
|--------------------------------------------------------------------------
| CHECK LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {

    header("Location: ../login/login_form.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| FETCH DOCTORS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        d.ID,
        d.FullName,
        d.MobileNumber,
        d.Email,
        d.Specialization,
        d.qualification,
        d.experience,
        d.hospital_detail,
        d.timing,
        d.images,
        s.Specialization AS SpecializationName
    FROM tbldoctor d
    LEFT JOIN tblspecialization s
        ON d.Specialization = s.ID
    ORDER BY d.ID DESC
";

$query = $dbh->prepare($sql);

$query->execute();

$doctors = $query->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Doctor Profile</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Font Awesome -->

    <link rel="stylesheet"
          href="libs/bower/font-awesome/css/font-awesome.min.css">


    <!-- Material Design -->

    <link rel="stylesheet"
          href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">


    <!-- Bootstrap -->

    <link rel="stylesheet"
          href="assets/css/bootstrap.css">


    <!-- Core -->

    <link rel="stylesheet"
          href="assets/css/core.css">


    <!-- App -->

    <link rel="stylesheet"
          href="assets/css/app.css">


    <!-- Animate -->

    <link rel="stylesheet"
          href="libs/bower/animate.css/animate.min.css">


    <!-- Google Font -->

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">


    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>

        if (typeof Breakpoints !== "undefined") {
            Breakpoints();
        }

    </script>


    <style>

        .doctor-image {

            width: 80px;

            height: 80px;

            object-fit: cover;

            border-radius: 50%;

            border: 2px solid #ddd;

        }


        .action-btn {

            margin-right: 5px;

            margin-bottom: 5px;

        }


        .empty-message {

            text-align: center;

            padding: 30px;

            color: #777;

        }


        .table-responsive {

            overflow-x: auto;

        }

    </style>

</head>


<body class="menubar-left menubar-unfold menubar-light theme-primary">


<!-- =========================================================
     HEADER
========================================================= -->

<?php

include_once __DIR__ . '/includes/header.php';

?>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<?php

include_once __DIR__ . '/includes/sidebar.php';

?>


<!-- =========================================================
     MAIN
========================================================= -->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">


                        <!-- HEADER -->

                        <header class="widget-header">

                            <h3 class="widget-title">

                                Doctor Profile

                            </h3>

                        </header>


                        <hr class="widget-separator">


                        <!-- BODY -->

                        <div class="widget-body">

                            <div class="table-responsive">


                                <table class="table table-bordered table-striped">

                                    <thead>

                                        <tr>

                                            <th>
                                                #
                                            </th>

                                            <th>
                                                Photo
                                            </th>

                                            <th>
                                                Name
                                            </th>

                                            <th>
                                                Mobile
                                            </th>

                                            <th>
                                                Email
                                            </th>

                                            <th>
                                                Specialization
                                            </th>

                                            <th>
                                                Qualification
                                            </th>

                                            <th>
                                                Experience
                                            </th>

                                            <th>
                                                Hospital
                                            </th>

                                            <th>
                                                Timing
                                            </th>

                                            <th>
                                                Action
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    if (count($doctors) > 0) {

                                        $cnt = 1;


                                        foreach ($doctors as $row) {

                                    ?>


                                        <tr>


                                            <!-- NUMBER -->

                                            <td>

                                                <?php
                                                echo $cnt;
                                                ?>

                                            </td>


                                            <!-- PHOTO -->

                                            <td>

                                                <?php

                                                $image = !empty($row->images)
                                                    ? $row->images
                                                    : '';

                                                $imagePath =
                                                    "../images/" . $image;

                                                ?>


                                                <?php if (!empty($image)): ?>

                                                    <img
                                                        src="<?php echo htmlspecialchars($imagePath); ?>"
                                                        class="doctor-image"
                                                        alt="Doctor">


                                                <?php else: ?>

                                                    <span>
                                                        No Image
                                                    </span>

                                                <?php endif; ?>


                                            </td>


                                            <!-- NAME -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->FullName
                                                );

                                                ?>

                                            </td>


                                            <!-- MOBILE -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->MobileNumber
                                                );

                                                ?>

                                            </td>


                                            <!-- EMAIL -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->Email
                                                );

                                                ?>

                                            </td>


                                            <!-- SPECIALIZATION -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->SpecializationName
                                                    ?? 'Not Available'
                                                );

                                                ?>

                                            </td>


                                            <!-- QUALIFICATION -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->qualification
                                                    ?? ''
                                                );

                                                ?>

                                            </td>


                                            <!-- EXPERIENCE -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->experience
                                                    ?? ''
                                                );

                                                ?>

                                            </td>


                                            <!-- HOSPITAL -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->hospital_detail
                                                    ?? ''
                                                );

                                                ?>

                                            </td>


                                            <!-- TIMING -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row->timing
                                                    ?? ''
                                                );

                                                ?>

                                            </td>


                                            <!-- ACTION -->

                                            <td>


                                                <a
                                                    href="updatedr.php?upid=<?php echo (int)$row->ID; ?>"
                                                    class="btn btn-primary action-btn">

                                                    <i class="fa fa-edit"></i>

                                                    Edit

                                                </a>


                                                <a
                                                    href="changephoto.php?pid=<?php echo (int)$row->ID; ?>"
                                                    class="btn btn-info action-btn">

                                                    <i class="fa fa-image"></i>

                                                    Photo

                                                </a>


                                            </td>


                                        </tr>


                                    <?php

                                            $cnt++;

                                        }


                                    } else {

                                    ?>


                                        <tr>

                                            <td
                                                colspan="11"
                                                class="empty-message">

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


                    </div>

                </div>

            </div>

        </section>

    </div>


    <!-- FOOTER -->

    <?php

    include_once __DIR__ . '/includes/footer.php';

    ?>


</main>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->


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