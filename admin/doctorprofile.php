<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| Database connection
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../conn.php';


/*
|--------------------------------------------------------------------------
| Check admin login
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


    <!-- Material Design -->

    <link rel="stylesheet"
          href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">


    <!-- Animate -->

    <link rel="stylesheet"
          href="libs/bower/animate.css/animate.min.css">


    <!-- Bootstrap -->

    <link rel="stylesheet"
          href="assets/css/bootstrap.css">


    <!-- Core -->

    <link rel="stylesheet"
          href="assets/css/core.css">


    <!-- App -->

    <link rel="stylesheet"
          href="assets/css/app.css">


    <!-- Google Font -->

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">


    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        Breakpoints();
    </script>

</head>


<body class="menubar-left menubar-unfold menubar-light theme-primary">


<!-- HEADER -->

<?php include_once __DIR__ . '/includes/header.php'; ?>


<!-- SIDEBAR -->

<?php include_once __DIR__ . '/includes/sidebar.php'; ?>


<!-- MAIN -->

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
                                    | Get doctors
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


                                    $results = $query->fetchAll(PDO::FETCH_OBJ);


                                    $cnt = 1;


                                    if (count($results) > 0) {

                                        foreach ($results as $row) {

                                    ?>


                                    <tr>


                                        <!-- NUMBER -->

                                        <td>

                                            <?php echo $cnt; ?>

                                        </td>


                                        <!-- PHOTO -->

                                        <td>

                                            <?php

                                            $imageName = trim($row->images);


                                            if (!empty($imageName)) {

                                                /*
                                                |--------------------------------------------------------------------------
                                                | IMPORTANT
                                                |--------------------------------------------------------------------------
                                                |
                                                | doctorprofile.php is inside admin/
                                                |
                                                | images are inside admin/images/
                                                |
                                                | Therefore:
                                                |
                                                | images/filename.jpg
                                                |
                                                */

                                                $imageURL = "images/" . rawurlencode($imageName);

                                            ?>

                                                <img

                                                    src="<?php echo htmlspecialchars($imageURL); ?>"

                                                    alt="Doctor Photo"

                                                    style="
                                                        width:100px;
                                                        height:100px;
                                                        object-fit:cover;
                                                        border-radius:8px;
                                                        border:2px solid #ddd;
                                                    "

                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"

                                                >


                                                <span
                                                    style="
                                                        display:none;
                                                        color:red;
                                                        font-size:12px;
                                                    "
                                                >

                                                    Image not found

                                                </span>


                                            <?php

                                            } else {

                                            ?>

                                                <span style="color:#999;">
                                                    No Image
                                                </span>

                                            <?php

                                            }

                                            ?>

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

                                            if (!empty($row->SpecializationName)) {

                                                echo htmlspecialchars(
                                                    $row->SpecializationName
                                                );

                                            } else {

                                                echo "Not Available";

                                            }

                                            ?>

                                        </td>


                                        <!-- QUALIFICATION -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $row->qualification
                                            );

                                            ?>

                                        </td>


                                        <!-- EXPERIENCE -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $row->experience
                                            );

                                            ?>

                                        </td>


                                        <!-- HOSPITAL -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $row->hospital_detail
                                            );

                                            ?>

                                        </td>


                                        <!-- TIMING -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $row->timing
                                            );

                                            ?>

                                        </td>


                                        <!-- ACTION -->

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

                                        <td
                                            colspan="11"
                                            style="text-align:center;"
                                        >

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


</body>

</html>