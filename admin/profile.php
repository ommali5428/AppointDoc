<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: /img/AppointDoc/login/login_form.php');
    exit();
}

$did = $_SESSION['admin'];

if (isset($_POST['submit'])) {

    $name = trim($_POST['fname']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $sid = $_POST['specializationid'];

    $sql = "UPDATE tbldoctor 
            SET FullName = :name,
                MobileNumber = :mobile,
                Email = :email,
                Specialization = :sid
            WHERE ID = :did";

    $query = $dbh->prepare($sql);

    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':sid', $sid, PDO::PARAM_INT);
    $query->bindParam(':did', $did, PDO::PARAM_INT);

    if ($query->execute()) {
        echo '<script>alert("Profile has been updated successfully");</script>';
    } else {
        echo '<script>alert("Something went wrong. Please try again.");</script>';
    }
}

/* Get doctor details */
$sql = "SELECT * FROM tbldoctor WHERE ID = :did";
$query = $dbh->prepare($sql);
$query->bindParam(':did', $did, PDO::PARAM_INT);
$query->execute();

$doctor = $query->fetch(PDO::FETCH_OBJ);

/* Get specialization categories */
$specSql = "SELECT * FROM tblspecialization ORDER BY Specialization ASC";
$specQuery = $dbh->prepare($specSql);
$specQuery->execute();
$specializations = $specQuery->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Doctor Profile</title>

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

<?php include_once('includes/header.php'); ?>

<?php include_once('includes/sidebar.php'); ?>

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <header class="widget-header">
                            <h3 class="widget-title">Doctor Profile</h3>
                        </header>

                        <hr class="widget-separator">

                        <div class="widget-body">

                            <?php if ($doctor) { ?>

                            <form class="form-horizontal" method="post">

                                <!-- Name -->
                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Name:
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="fname"
                                            placeholder="Full Name"
                                            required
                                            value="<?php echo htmlentities($doctor->FullName); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- Mobile -->
                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Mobile Number:
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="mobile"
                                            placeholder="Mobile Number"
                                            required
                                            value="<?php echo htmlentities($doctor->MobileNumber); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- Email -->
                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Email:
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            placeholder="Email Address"
                                            required
                                            value="<?php echo htmlentities($doctor->Email); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- Specialization -->
                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Specialization:
                                    </label>

                                    <div class="col-sm-9">

                                        <select
                                            name="specializationid"
                                            class="form-control"
                                            required
                                        >

                                            <option value="">
                                                Select Specialization
                                            </option>

                                            <?php foreach ($specializations as $spec) { ?>

                                                <option
                                                    value="<?php echo $spec->ID; ?>"
                                                    <?php
                                                    if ($doctor->Specialization == $spec->ID) {
                                                        echo 'selected';
                                                    }
                                                    ?>
                                                >
                                                    <?php echo htmlentities($spec->Specialization); ?>
                                                </option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                </div>


                                <!-- Update button -->
                                <div class="row">

                                    <div class="col-sm-9 col-sm-offset-3">

                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            name="submit"
                                        >
                                            Update
                                        </button>

                                    </div>

                                </div>

                            </form>

                            <?php } else { ?>

                                <div class="alert alert-danger">
                                    Doctor profile not found.
                                </div>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

    <?php include_once('includes/footer.php'); ?>

</main>


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