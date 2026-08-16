<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
| categories.php is inside /admin/
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
| DELETE CATEGORY
|--------------------------------------------------------------------------
*/
if (isset($_GET['delid'])) {

    $delid = (int) $_GET['delid'];

    if ($delid > 0) {

        $sql = "DELETE FROM tblspecialization WHERE ID = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $delid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Category deleted successfully');
                    window.location.href='categories.php';
                  </script>";
            exit;
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
}


/*
|--------------------------------------------------------------------------
| FETCH CATEGORIES
|--------------------------------------------------------------------------
*/
$sql = "SELECT * FROM tblspecialization ORDER BY ID DESC";
$query = $dbh->prepare($sql);
$query->execute();
$categories = $query->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Categories</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        if (typeof Breakpoints !== "undefined") {
            Breakpoints();
        }
    </script>

    <style>

        .category-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
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
     MAIN CONTENT
========================================================= -->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <header class="widget-header">

                            <h3 class="widget-title">
                                Categories
                            </h3>

                        </header>

                        <hr class="widget-separator">

                        <div class="widget-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped">

                                    <thead>

                                        <tr>

                                            <th width="70">
                                                #
                                            </th>

                                            <th width="120">
                                                Photo
                                            </th>

                                            <th>
                                                Specialization
                                            </th>

                                            <th width="220">
                                                Action
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php

                                    if (count($categories) > 0) {

                                        $cnt = 1;

                                        foreach ($categories as $row) {

                                    ?>

                                        <tr>

                                            <td>
                                                <?php echo $cnt; ?>
                                            </td>


                                            <td>

                                                <?php

                                                $image = !empty($row->images)
                                                    ? $row->images
                                                    : '';

                                                $imagePath = "../drimages/" . $image;

                                                ?>

                                                <?php if (!empty($image)): ?>

                                                    <img
                                                        src="<?php echo htmlspecialchars($imagePath); ?>"
                                                        class="category-image"
                                                        alt="Category">

                                                <?php else: ?>

                                                    <span>
                                                        No Image
                                                    </span>

                                                <?php endif; ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row->Specialization
                                                );
                                                ?>

                                            </td>


                                            <td>

                                                <a
                                                    href="updatecat.php?upid=<?php echo (int)$row->ID; ?>"
                                                    class="btn btn-primary action-btn">

                                                    <i class="fa fa-edit"></i>
                                                    Edit

                                                </a>


                                                <a
                                                    href="categories.php?delid=<?php echo (int)$row->ID; ?>"
                                                    class="btn btn-danger action-btn"
                                                    onclick="return confirm('Are you sure you want to delete this category?');">

                                                    <i class="fa fa-trash"></i>
                                                    Delete

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
                                                colspan="4"
                                                class="empty-message">

                                                No categories found.

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