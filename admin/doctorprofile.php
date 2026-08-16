<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../conn.php';

/*
|--------------------------------------------------------------------------
| Check Admin Login
|--------------------------------------------------------------------------
*/
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

    <title>Doctor Profile</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="libs/bower/font-awesome/css/font-awesome.min.css">

    <!-- Material Design Iconic Font -->
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

</head>


<body class="menubar-left menubar-unfold menubar-light theme-primary">


<?php include_once __DIR__ . '/includes/header.php'; ?>

<?php include_once __DIR__ . '/includes/sidebar.php'; ?>


<!-- ================= APP MAIN ================= -->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <header class="widget-header">

                            <h3 class="widget-title">
                                Doctor Profile
                            </h3>

                        </header>

                        <hr class="widget-separator">


                        <div class="widget-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover">

                                    <thead>

                                    <tr>

                                        <th>#</th>

                                        <th>Photo</th>

                                        <th>Name</th>

                                        <th>Mobile</th>

                                        <th>Email</th>

                                        <th>Specialization</th>

                                        <th>Qualification</th>

                                        <th>Experience</th>

                                        <th>Hospital</th>

                                        <th>Timing</th>

                                        <th>Action</th>

                                    </tr>

                                    </thead>


                                    <tbody>

                                    <?php

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Get Doctors
                                    |--------------------------------------------------------------------------
                                    */

                                    $sql = "SELECT 
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
                                            ORDER BY d.ID DESC";

                                    $query = $dbh->prepare($sql);

                                    $query->execute();

                                    $results = $query->fetchAll(PDO::FETCH_OBJ);


                                    $cnt = 1;


                                    if ($query->rowCount() > 0) {

                                        foreach ($results as $row) {

                                    ?>

                                    <tr>

                                        <!-- Number -->

                                        <td>
                                            <?php echo $cnt; ?>
                                        </td>


                                        <!-- Doctor Photo -->

                                        <td>

                                            <?php

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Image URL
                                            |--------------------------------------------------------------------------
                                            |
                                            | doctorprofile.php is inside:
                                            |
                                            | /admin/
                                            |
                                            | images are inside:
                                            |
                                            | /drimages/
                                            |
                                            | Therefore:
                                            |
                                            | ../drimages/
                                            |
                                            */

                                            $imageName = trim($row->images);


                                            if (!empty($imageName)) {

                                                $imagePath =
                                                    "../drimages/" .
                                                    rawurlencode($imageName);

                                            ?>

                                                <img
                                                    src="<?php echo $imagePath; ?>"
                                                    alt="Doctor"
                                                    style="
                                                        width:100px;
                                                        height:100px;
                                                        object-fit:cover;
                                                        border-radius:8px;
                                                        border:2px solid #ddd;
                                                    "
                                                    onerror="this.onerror=null;this.src='../drimages/default-doctor.png';"
                                                >

                                            <?php

                                            } else {

                                            ?>

                                                <img
                                                    src="../drimages/default-doctor.png"
                                                    alt="No Image"
                                                    style="
                                                        width:100px;
                                                        height:100px;
                                                        object-fit:cover;
                                                        border-radius:8px;
                                                        border:2px solid #ddd;
                                                    "
                                                >

                                            <?php

                                            }

                                            ?>

                                        </td>


                                        <!-- Name -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->FullName
                                            );
                                            ?>
                                        </td>


                                        <!-- Mobile -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->MobileNumber
                                            );
                                            ?>
                                        </td>


                                        <!-- Email -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->Email
                                            );
                                            ?>
                                        </td>


                                        <!-- Specialization -->

                                        <td>

                                            <?php

                                            if (!empty($row->SpecializationName)) {

                                                echo htmlspecialchars(
                                                    $row->SpecializationName
                                                );

                                            } else {

                                                echo "Not Available";

                                            }

                                            ?>

                                        </td>


                                        <!-- Qualification -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->qualification
                                            );
                                            ?>
                                        </td>


                                        <!-- Experience -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->experience
                                            );
                                            ?>
                                        </td>


                                        <!-- Hospital -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->hospital_detail
                                            );
                                            ?>
                                        </td>


                                        <!-- Timing -->

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $row->timing
                                            );
                                            ?>
                                        </td>


                                        <!-- Action -->

                                        <td>

                                            <a
                                                href="updatedr.php?upid=<?php echo $row->ID; ?>"
                                                class="btn btn-primary"
                                            >
                                                Edit
                                            </a>

                                        </td>

                                    </tr>


                                    <?php

                                            $cnt++;

                                        }

                                    } else {

                                    ?>

                                    <tr>

                                        <td colspan="11"
                                            style="text-align:center;">

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


    <!-- Footer -->

    <?php include_once __DIR__ . '/includes/footer.php'; ?>


</main>


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


</body>

</html>