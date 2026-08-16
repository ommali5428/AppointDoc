<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');


// Admin login check
if (strlen($_SESSION['admin']) == 0) {
    header('location:logout.php');
    exit();
}


// Insert specialization
if (isset($_POST['insert'])) {

    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

    // Image upload
    $images = $_FILES["images"]["name"];
    $extension = strtolower(pathinfo($images, PATHINFO_EXTENSION));

    // Allowed extensions
    $allowed_extension = array("jpg", "jpeg", "png", "gif");

    if (!in_array($extension, $allowed_extension)) {

        echo "<script>
                alert('Featured image has invalid format. Only jpg/jpeg/png/gif format allowed');
              </script>";

    } else {

        // Generate unique image name
        $images = md5($images . time()) . "." . $extension;

        $uploadPath = "../drimages/" . $images;

        if (move_uploaded_file($_FILES["images"]["tmp_name"], $uploadPath)) {

            $sql = "INSERT INTO tblspecialization
                    (Specialization, images)
                    VALUES (:specialization, :images)";

            $query = $dbh->prepare($sql);

            $query->bindParam(
                ':specialization',
                $specialization,
                PDO::PARAM_STR
            );

            $query->bindParam(
                ':images',
                $images,
                PDO::PARAM_STR
            );

            $query->execute();

            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {

                echo "<script>
                        alert('Data Inserted Successfully');
                        window.location.href='categories.php';
                      </script>";

            } else {

                echo "<script>
                        alert('Something went wrong. Please try again');
                      </script>";
            }

        } else {

            echo "<script>
                    alert('Image upload failed. Please try again');
                  </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Categories</title>

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

<!-- Header -->
<?php include_once('includes/header.php'); ?>

<!-- Sidebar -->
<?php include_once('includes/sidebar.php'); ?>


<form id="basic-form" method="post" enctype="multipart/form-data">

<!-- APP MAIN -->
<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <!-- Insert Category -->
                        <header class="widget-header">

                            <h3 class="widget-title">
                                Insert New Specialists Category
                            </h3>

                        </header>

                        <hr class="widget-separator">

                        <br>

                        <header class="widget-header">

                            <div class="form-group">

                                <label>Enter Specialization</label>

                                <input
                                    id="specialization"
                                    type="text"
                                    name="specialization"
                                    required
                                    class="form-control"
                                    placeholder="Enter Specialization"
                                    style="width: 70%;">

                            </div>


                            <div class="form-group">

                                <label>Upload photo</label>

                                <input
                                    id="images"
                                    type="file"
                                    name="images"
                                    required
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.gif"
                                    style="width: 70%;">

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary"
                                name="insert"
                                id="submit">

                                Insert

                            </button>

                            <br>
                            <hr>

                        </header>


                        <!-- Category List -->
                        <header class="widget-header">

                            <h3 class="widget-title">
                                Specialization Categories
                            </h3>

                        </header>


                        <div class="widget-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">

                                    <thead>

                                        <tr>

                                            <th>ID</th>

                                            <th>Specialization</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                    <?php

                                    $sql = "SELECT * FROM tblspecialization";

                                    $query = $dbh->prepare($sql);
                                    $query->execute();

                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt = 1;

                                    if ($query->rowCount() > 0) {

                                        foreach ($results as $row) {

                                    ?>

                                        <tr>

                                            <td>
                                                <?php echo htmlentities($row->ID); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlentities($row->Specialization); ?>
                                            </td>


                                            <td style="width: 300px;">

                                                <center>

                                                    <a href="/./img/AppointDoc/admin/updatecat.php?upid=<?php echo (int)$row->ID; ?>">

                                                        <input
                                                            type="button"
                                                            value="Edit"
                                                            class="btn btn-primary"
                                                            style="width: 80px;">

                                                    </a>

                                                    &nbsp;

                                                    <a href="/./img/AppointDoc/admin/deletecat.php?deleteid=<?php echo (int)$row->ID; ?>">

                                                        <input
                                                            type="button"
                                                            value="Delete"
                                                            class="btn btn-primary"
                                                            style="width: 80px;">

                                                    </a>

                                                </center>

                                            </td>

                                        </tr>

                                    <?php

                                            $cnt++;

                                        }

                                    } else {

                                    ?>

                                        <tr>

                                            <td colspan="3">
                                                No record found
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


    <!-- APP FOOTER -->
    <?php include_once('includes/footer.php'); ?>

</main>


<!-- JavaScript -->

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

</form>

</body>
</html>