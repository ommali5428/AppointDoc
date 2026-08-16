<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

/* Check admin/doctor login */
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: logout.php');
    exit();
}

/* Get doctor ID */
if (!isset($_GET['upid']) || !is_numeric($_GET['upid'])) {
    header('Location: doctorprofile.php');
    exit();
}

$upid = (int)$_GET['upid'];

/* Update doctor information */
if (isset($_POST['insert'])) {

    $name   = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $email  = trim($_POST['email']);
    $qf     = trim($_POST['qf']);
    $hd     = trim($_POST['hd']);
    $ex     = trim($_POST['ex']);
    $time   = trim($_POST['time']);

    /* Basic validation */
    if (
        empty($name) ||
        empty($mobile) ||
        empty($email) ||
        empty($qf) ||
        empty($hd) ||
        empty($ex) ||
        empty($time)
    ) {
        echo "<script>alert('Please fill all fields.');</script>";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.');</script>";
    } 
    elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo "<script>alert('Please enter a valid 10-digit mobile number.');</script>";
    } 
    else {

        /* Check whether email belongs to another doctor */
        $checkSql = "SELECT ID FROM tbldoctor 
                     WHERE Email = :email AND ID != :upid";

        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $checkQuery->bindParam(':upid', $upid, PDO::PARAM_INT);
        $checkQuery->execute();

        if ($checkQuery->rowCount() > 0) {

            echo "<script>alert('This email is already used by another doctor.');</script>";

        } else {

            /* Update doctor */
            $sql = "UPDATE tbldoctor SET
                        FullName = :name,
                        MobileNumber = :mobile,
                        Email = :email,
                        qualification = :qf,
                        experience = :ex,
                        hospital_detail = :hd,
                        timing = :time
                    WHERE ID = :upid";

            $query = $dbh->prepare($sql);

            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':qf', $qf, PDO::PARAM_STR);
            $query->bindParam(':ex', $ex, PDO::PARAM_STR);
            $query->bindParam(':hd', $hd, PDO::PARAM_STR);
            $query->bindParam(':time', $time, PDO::PARAM_STR);
            $query->bindParam(':upid', $upid, PDO::PARAM_INT);

            if ($query->execute()) {

                echo "<script>
                        alert('Doctor information updated successfully.');
                        window.location.href='doctorprofile.php';
                      </script>";
                exit();

            } else {

                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    }
}


/* Get doctor information */
$sql = "SELECT * FROM tbldoctor WHERE ID = :upid";

$query = $dbh->prepare($sql);
$query->bindParam(':upid', $upid, PDO::PARAM_INT);
$query->execute();

$doctor = $query->fetch(PDO::FETCH_ASSOC);

if (!$doctor) {
    echo "<script>
            alert('Doctor not found.');
            window.location.href='doctorprofile.php';
          </script>";
    exit();
}


/* Get specialization name */
$specializationName = '';

if (!empty($doctor['Specialization'])) {

    $spSql = "SELECT Specialization 
              FROM tblspecialization 
              WHERE ID = :sid";

    $spQuery = $dbh->prepare($spSql);
    $spQuery->bindParam(
        ':sid',
        $doctor['Specialization'],
        PDO::PARAM_INT
    );
    $spQuery->execute();

    $specialization = $spQuery->fetch(PDO::FETCH_ASSOC);

    if ($specialization) {
        $specializationName = $specialization['Specialization'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Update Doctor Information</title>

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
                                Update Doctor Information
                            </h3>

                        </header>

                        <hr class="widget-separator">

                        <div class="widget-body">

                            <form
                                id="basic-form"
                                method="post"
                                enctype="multipart/form-data"
                            >

                                <!-- Name -->

                                <div class="form-group">

                                    <label>Name</label>

                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['FullName']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <!-- Mobile -->

                                <div class="form-group">

                                    <label>Mobile Number</label>

                                    <input
                                        id="mobile"
                                        type="text"
                                        name="mobile"
                                        required
                                        maxlength="10"
                                        pattern="[0-9]{10}"
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['MobileNumber']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <!-- Email -->

                                <div class="form-group">

                                    <label>Email</label>

                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['Email']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <!-- Specialist -->

                                <div class="form-group">

                                    <label>Specialist</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="<?php echo htmlentities($specializationName); ?>"
                                        readonly
                                        style="width:70%; background:#f5f5f5;"
                                    >

                                </div>


                                <!-- Qualification -->

                                <div class="form-group">

                                    <label>Qualification</label>

                                    <input
                                        id="qf"
                                        type="text"
                                        name="qf"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['qualification']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <!-- Experience -->

                                <div class="form-group">

                                    <label>Experience</label>

                                    <input
                                        id="ex"
                                        type="text"
                                        name="ex"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['experience']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <!-- Hospital -->

                                <div class="form-group">

                                    <label>Hospital Detail</label>

                                    <input
                                        id="hd"
                                        type="text"
                                        name="hd"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['hospital_detail']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <!-- Timing -->

                                <div class="form-group">

                                    <label>Timing</label>

                                    <input
                                        id="time"
                                        type="text"
                                        name="time"
                                        required
                                        class="form-control"
                                        value="<?php echo htmlentities($doctor['timing']); ?>"
                                        style="width:70%;"
                                    >

                                </div>


                                <br>


                                <!-- Update Button -->

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    name="insert"
                                    id="submit"
                                >
                                    Update
                                </button>

                                &nbsp;&nbsp;&nbsp;


                                <!-- Change Photo -->

                                <a
                                    href="changephoto.php?pid=<?php echo $doctor['ID']; ?>"
                                    class="btn btn-primary"
                                >
                                    Change Photo
                                </a>

                                &nbsp;&nbsp;&nbsp;


                                <!-- Back -->

                                <a
                                    href="doctorprofile.php"
                                    class="btn btn-default"
                                >
                                    Back
                                </a>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>


    <!-- Footer -->

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