<?php

session_start();
error_reporting(0);

include('../conn.php');

if (isset($_POST['submit'])) {

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mobno = mysqli_real_escape_string($conn, $_POST['mobno']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sid   = (int)$_POST['specializationid'];
    $qf    = mysqli_real_escape_string($conn, $_POST['qf']);
    $exp   = mysqli_real_escape_string($conn, $_POST['exp']);
    $hd    = mysqli_real_escape_string($conn, $_POST['hd']);
    $time  = mysqli_real_escape_string($conn, $_POST['time']);

    $password = md5($_POST['password']);

    /* Check whether email already exists */
    $checkQuery = "SELECT ID FROM tbldoctor WHERE Email='$email' LIMIT 1";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {

        echo "<script>
                alert('Email-id already exist. Please try again');
              </script>";

    } else {

        /* Image upload */

        if (
            !isset($_FILES['images']) ||
            $_FILES['images']['error'] != UPLOAD_ERR_OK
        ) {

            echo "<script>
                    alert('Please select a valid doctor image.');
                  </script>";

        } else {

            $originalImage = $_FILES['images']['name'];
            $tmpImage = $_FILES['images']['tmp_name'];

            $extension = strtolower(
                pathinfo($originalImage, PATHINFO_EXTENSION)
            );

            /* Allowed image extensions */
            $allowed_extensions = array(
                'jpg',
                'jpeg',
                'png',
                'gif'
            );

            if (!in_array($extension, $allowed_extensions)) {

                echo "<script>
                        alert('Featured image has invalid format. Only jpg/jpeg/png/gif format allowed');
                      </script>";

            } else {

                /*
                 * Doctor images are stored here:
                 * AppointDoc/appointment/dr_pannel/images/
                 */

                $imageName = md5(
                    $originalImage . microtime(true)
                ) . '.' . $extension;

                $uploadDirectory = __DIR__ . '/../appointment/dr_pannel/images/';

                /* Create directory if it doesn't exist */
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);
                }

                $uploadPath = $uploadDirectory . $imageName;

                if (!move_uploaded_file($tmpImage, $uploadPath)) {

                    echo "<script>
                            alert('Image upload failed. Please try again.');
                          </script>";

                } else {

                    /* Insert doctor */

                    $sql = "INSERT INTO tbldoctor
                            (
                                FullName,
                                MobileNumber,
                                Email,
                                Specialization,
                                Password,
                                qualification,
                                experience,
                                hospital_detail,
                                timing,
                                images
                            )
                            VALUES
                            (
                                '$fname',
                                '$mobno',
                                '$email',
                                '$sid',
                                '$password',
                                '$qf',
                                '$exp',
                                '$hd',
                                '$time',
                                '$imageName'
                            )";

                    $query = mysqli_query($conn, $sql);

                    if ($query) {

                        echo "<script>
                                alert('You have signup Successfully');
                                window.location.href='addprofile.php';
                              </script>";

                    } else {

                        /* If database insertion fails, remove uploaded image */
                        if (file_exists($uploadPath)) {
                            unlink($uploadPath);
                        }

                        echo "<script>
                                alert('Something went wrong. Please try again');
                              </script>";
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Add New Doctor</title>

    <link rel="stylesheet"
          href="libs/bower/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet"
          href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">

    <!-- build:css assets/css/app.min.css -->

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

    <!-- endbuild -->

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

    <script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>

    <script>
        Breakpoints();
    </script>

</head>

<body class="menubar-left menubar-unfold menubar-light theme-primary">

<!--============= start main area -->

<?php include_once('includes/header.php'); ?>

<?php include_once('includes/sidebar.php'); ?>


<!-- APP MAIN ========== -->

<main id="app-main" class="app-main">

    <div class="wrap">

        <section class="app-content">

            <div class="row">

                <div class="col-md-12">

                    <div class="widget">

                        <header class="widget-header">

                            <h3 class="widget-title">
                                Add New Doctor Pofile
                            </h3>

                        </header>

                        <hr class="widget-separator">

                        <br>

                        <div class="widget-body">

                            <table>

                                <td style="">

                                    <form
                                        class="form-horizontal"
                                        method="post"
                                        enctype="multipart/form-data">


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="fname"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Full Name"
                                                    name="fname"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="email"
                                                    type="email"
                                                    class="form-control"
                                                    placeholder="Email"
                                                    name="email"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="mobno"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Mobile"
                                                    name="mobno"
                                                    maxlength="10"
                                                    pattern="[0-9]+"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <select
                                                    class="form-control"
                                                    name="specializationid"
                                                    style="width: 220%">

                                                    <option value="">
                                                        Choose Specialization
                                                    </option>

                                                    <?php

                                                    $sql1 =
                                                        "SELECT ID, Specialization
                                                         FROM tblspecialization
                                                         ORDER BY ID ASC";

                                                    $query1 =
                                                        mysqli_query(
                                                            $conn,
                                                            $sql1
                                                        );

                                                    if (
                                                        $query1 &&
                                                        mysqli_num_rows($query1) > 0
                                                    ) {

                                                        while (
                                                            $row1 =
                                                            mysqli_fetch_assoc(
                                                                $query1
                                                            )
                                                        ) {

                                                    ?>

                                                        <option
                                                            value="<?php echo htmlspecialchars($row1['ID']); ?>">

                                                            <?php
                                                            echo htmlspecialchars(
                                                                $row1['Specialization']
                                                            );
                                                            ?>

                                                        </option>

                                                    <?php

                                                        }

                                                    }

                                                    ?>

                                                </select>

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="qf"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Qualification"
                                                    name="qf"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="exp"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Experience"
                                                    name="exp"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="hd"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Hospital Detail"
                                                    name="hd"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="images"
                                                    type="file"
                                                    class="form-control"
                                                    name="images"
                                                    accept=".jpg,.jpeg,.png,.gif"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="time"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Timing"
                                                    name="time"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="form-group">

                                            <div class="col-sm-9">

                                                <input
                                                    id="password"
                                                    type="password"
                                                    class="form-control"
                                                    placeholder="Password"
                                                    name="password"
                                                    required="true"
                                                    style="width: 220%">

                                            </div>

                                        </div>


                                        <div class="row">

                                            <div class="col-sm-9 col-sm-offset-3">

                                                <button
                                                    type="submit"
                                                    class="btn btn-success"
                                                    name="submit">

                                                    Submit

                                                </button>

                                            </div>

                                        </div>

                                    </form>

                                </td>


                                <td style="
                                    float: right;
                                    margin-left: 350px;
                                    margin-top: 30px;
                                ">

                                    <img
                                        src="../drimages/—Pngtree—hospital medical symbol_5415984.png"
                                        style="width: 400px;">

                                </td>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>


    <!-- APP FOOTER -->

    <?php include_once('includes/footer.php'); ?>

    <!-- /#app-footer -->

</main>

<!--========== END app main -->


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