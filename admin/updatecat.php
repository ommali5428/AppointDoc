<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

/* ==============================
   ADMIN LOGIN CHECK
================================= */

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('location:logout.php');
    exit();
}

/* ==============================
   GET CATEGORY ID
================================= */

if (!isset($_GET['upid']) || !is_numeric($_GET['upid'])) {
    header('location:categories.php');
    exit();
}

$upid = intval($_GET['upid']);


/* ==============================
   UPDATE CATEGORY
================================= */

if (isset($_POST['insert'])) {

    $specialization = trim($_POST['specialization']);

    if (empty($specialization)) {
        echo "<script>alert('Please enter specialization');</script>";
    } 
    else {

        /* Get current image */
        $sqlOld = "SELECT images FROM tblspecialization WHERE ID = :id";
        $stmtOld = $dbh->prepare($sqlOld);
        $stmtOld->bindParam(':id', $upid, PDO::PARAM_INT);
        $stmtOld->execute();

        $oldData = $stmtOld->fetch(PDO::FETCH_OBJ);

        $oldImage = $oldData ? $oldData->images : '';

        /* Check whether new image is uploaded */
        if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {

            $originalName = $_FILES['images']['name'];
            $tmpName = $_FILES['images']['tmp_name'];

            $extension = strtolower(
                pathinfo($originalName, PATHINFO_EXTENSION)
            );

            /* Allowed extensions */
            $allowed_extension = array(
                'jpg',
                'jpeg',
                'png',
                'gif'
            );

            if (!in_array($extension, $allowed_extension)) {

                echo "<script>
                        alert('Invalid image format. Only JPG, JPEG, PNG and GIF are allowed.');
                      </script>";

            } 
            else {

                /* Create unique image name */
                $newImage = md5($originalName . time()) . '.' . $extension;

                /* Upload directory */
                $uploadPath = "../drimages/" . $newImage;

                if (move_uploaded_file($tmpName, $uploadPath)) {

                    /* Update database with new image */
                    $sql = "UPDATE tblspecialization
                            SET Specialization = :specialization,
                                images = :images
                            WHERE ID = :id";

                    $query = $dbh->prepare($sql);

                    $query->bindParam(
                        ':specialization',
                        $specialization,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':images',
                        $newImage,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':id',
                        $upid,
                        PDO::PARAM_INT
                    );

                    $query->execute();

                    /* Delete old image */
                    if (!empty($oldImage)) {

                        $oldImagePath = "../drimages/" . $oldImage;

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    echo "<script>
                            alert('Category and photo updated successfully');
                            window.location.href='categories.php';
                          </script>";
                    exit();

                } 
                else {

                    echo "<script>
                            alert('Photo upload failed. Please try again.');
                          </script>";
                }
            }

        } 
        else {

            /* ==============================
               UPDATE WITHOUT NEW IMAGE
            ================================= */

            $sql = "UPDATE tblspecialization
                    SET Specialization = :specialization
                    WHERE ID = :id";

            $query = $dbh->prepare($sql);

            $query->bindParam(
                ':specialization',
                $specialization,
                PDO::PARAM_STR
            );

            $query->bindParam(
                ':id',
                $upid,
                PDO::PARAM_INT
            );

            $query->execute();

            echo "<script>
                    alert('Category updated successfully');
                    window.location.href='categories.php';
                  </script>";
            exit();
        }
    }
}


/* ==============================
   FETCH CATEGORY DATA
================================= */

$sql = "SELECT * FROM tblspecialization WHERE ID = :id";

$query = $dbh->prepare($sql);
$query->bindParam(':id', $upid, PDO::PARAM_INT);
$query->execute();

$category = $query->fetch(PDO::FETCH_OBJ);

if (!$category) {
    echo "<script>
            alert('Category not found');
            window.location.href='categories.php';
          </script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Update Categories</title>

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
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        Breakpoints();
    </script>

</head>


<body class="menubar-left menubar-unfold menubar-light theme-primary">

<!-- HEADER -->

<?php include_once('includes/header.php'); ?>

<!-- SIDEBAR -->

<?php include_once('includes/sidebar.php'); ?>


<!-- APP MAIN -->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <!-- TITLE -->

                        <header class="widget-header">

                            <h3 class="widget-title">
                                Update Category
                            </h3>

                        </header>

                        <hr class="widget-separator">


                        <!-- FORM -->

                        <div class="widget-body">

                            <form method="post"
                                  enctype="multipart/form-data">

                                <!-- CURRENT PHOTO -->

                                <div class="form-group">

                                    <label>
                                        Current Photo
                                    </label>

                                    <br>

                                    <?php if (!empty($category->images)) { ?>

                                        <img
                                            src="/./img/AppointDoc/drimages/<?php echo htmlentities($category->images); ?>"
                                            style="
                                                width:150px;
                                                height:150px;
                                                object-fit:cover;
                                                border:2px solid #ccc;
                                                padding:3px;
                                            "
                                            alt="Category Image">

                                    <?php } else { ?>

                                        <p>
                                            No image uploaded.
                                        </p>

                                    <?php } ?>

                                </div>


                                <!-- SPECIALIZATION -->

                                <div class="form-group">

                                    <label>
                                        Specialization
                                    </label>

                                    <input
                                        id="specialization"
                                        type="text"
                                        name="specialization"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($category->Specialization); ?>"
                                        placeholder="Enter Specialization"
                                        style="width:70%;">

                                </div>


                                <!-- NEW PHOTO -->

                                <div class="form-group">

                                    <label>
                                        Upload New Photo
                                    </label>

                                    <input
                                        id="images"
                                        type="file"
                                        name="images"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png,.gif"
                                        style="width:70%;">

                                    <p style="color:red;">
                                        * Leave empty if you only want to change the specialization.
                                    </p>

                                </div>


                                <br>


                                <!-- BUTTONS -->

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    name="insert"
                                    id="submit">

                                    Update

                                </button>


                                <a
                                    href="categories.php"
                                    class="btn btn-default">

                                    Cancel

                                </a>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>


    <!-- FOOTER -->

    <?php include_once('includes/footer.php'); ?>


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