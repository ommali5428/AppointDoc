<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');


// Admin login check
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('location:logout.php');
    exit();
}


if (isset($_POST['submit'])) {

    $eid = $_SESSION['admin'];

    $cpassword = md5($_POST['currentpassword']);
    $newpassword = md5($_POST['newpassword']);


    // Check current password
    $sql = "SELECT ID
            FROM user_form
            WHERE ID = :eid
            AND Password = :cpassword";

    $query = $dbh->prepare($sql);

    $query->bindParam(
        ':eid',
        $eid,
        PDO::PARAM_INT
    );

    $query->bindParam(
        ':cpassword',
        $cpassword,
        PDO::PARAM_STR
    );

    $query->execute();


    if ($query->rowCount() > 0) {

        // Update password
        $sql = "UPDATE user_form
                SET Password = :newpassword
                WHERE ID = :eid";

        $chngpwd = $dbh->prepare($sql);

        $chngpwd->bindParam(
            ':eid',
            $eid,
            PDO::PARAM_INT
        );

        $chngpwd->bindParam(
            ':newpassword',
            $newpassword,
            PDO::PARAM_STR
        );

        $chngpwd->execute();


        echo '<script>
                alert("Your password successfully changed");
                window.location.href="change-password.php";
              </script>';

    } else {

        echo '<script>
                alert("Your current password is wrong");
              </script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Change Password</title>

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


    <script type="text/javascript">

        function checkpass()
        {
            var newPassword =
                document.changepassword.newpassword.value;

            var confirmPassword =
                document.changepassword.confirmpassword.value;


            if (newPassword !== confirmPassword)
            {
                alert('New Password and Confirm Password field does not match');

                document.changepassword.confirmpassword.focus();

                return false;
            }

            return true;
        }

    </script>

</head>


<body class="menubar-left menubar-unfold menubar-light theme-primary">

<!-- Header -->
<?php include_once('includes/header.php'); ?>

<!-- Sidebar -->
<?php include_once('includes/sidebar.php'); ?>


<!-- APP MAIN -->
<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <header class="widget-header">

                            <h3 class="widget-title">
                                Change Password
                            </h3>

                        </header>

                        <hr class="widget-separator">


                        <div class="widget-body">

                            <form
                                class="form-horizontal"
                                onsubmit="return checkpass();"
                                name="changepassword"
                                method="post">


                                <div class="form-group">

                                    <label
                                        for="currentpassword"
                                        class="col-sm-3 control-label">

                                        Current Password:

                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="password"
                                            class="form-control"
                                            name="currentpassword"
                                            id="currentpassword"
                                            required>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <label
                                        for="newpassword"
                                        class="col-sm-3 control-label">

                                        New Password:

                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="password"
                                            class="form-control"
                                            name="newpassword"
                                            id="newpassword"
                                            required>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <label
                                        for="confirmpassword"
                                        class="col-sm-3 control-label">

                                        Confirm Password:

                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="password"
                                            class="form-control"
                                            name="confirmpassword"
                                            id="confirmpassword"
                                            required>

                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-sm-9 col-sm-offset-3">

                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            name="submit">

                                            Change

                                        </button>

                                    </div>

                                </div>

                            </form>

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

</body>
</html>