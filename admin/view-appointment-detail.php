<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');


/* ==============================
   CHECK LOGIN
============================== */

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: logout.php');
    exit();
}


/* ==============================
   GET APPOINTMENT ID
============================== */

if (!isset($_GET['editid']) || !is_numeric($_GET['editid'])) {
    header('Location: all-appointment.php');
    exit();
}

$eid = (int)$_GET['editid'];


/* ==============================
   UPDATE APPOINTMENT STATUS
============================== */

if (isset($_POST['submit'])) {

    $status = trim($_POST['status']);
    $remark = trim($_POST['remark']);

    /* Allowed status values */
    $allowed_status = array('Approved', 'Cancelled');

    if (!in_array($status, $allowed_status)) {

        echo "<script>
                alert('Invalid appointment status.');
              </script>";

    } elseif (empty($remark)) {

        echo "<script>
                alert('Please enter a remark.');
              </script>";

    } else {

        $sql = "UPDATE tblappointment 
                SET Status = :status,
                    Remark = :remark
                WHERE ID = :eid";

        $query = $dbh->prepare($sql);

        $query->bindParam(
            ':status',
            $status,
            PDO::PARAM_STR
        );

        $query->bindParam(
            ':remark',
            $remark,
            PDO::PARAM_STR
        );

        $query->bindParam(
            ':eid',
            $eid,
            PDO::PARAM_INT
        );

        if ($query->execute()) {

            echo "<script>
                    alert('Remark and status have been updated successfully.');
                    window.location.href='all-appointment.php';
                  </script>";

            exit();

        } else {

            echo "<script>
                    alert('Something went wrong. Please try again.');
                  </script>";
        }
    }
}


/* ==============================
   FETCH APPOINTMENT
============================== */

$sql = "SELECT * 
        FROM tblappointment 
        WHERE ID = :eid";

$query = $dbh->prepare($sql);

$query->bindParam(
    ':eid',
    $eid,
    PDO::PARAM_INT
);

$query->execute();

$row = $query->fetch(PDO::FETCH_OBJ);


/* ==============================
   CHECK APPOINTMENT EXISTS
============================== */

if (!$row) {

    echo "<script>
            alert('Appointment not found.');
            window.location.href='all-appointment.php';
          </script>";

    exit();
}


/* Current status */

$currentStatus = $row->Status;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>View Appointment Detail</title>

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


                        <!-- WIDGET HEADER -->

                        <header class="widget-header">

                            <h4 class="widget-title"
                                style="color:blue">

                                Appointment Details

                            </h4>

                        </header>


                        <hr class="widget-separator">


                        <!-- WIDGET BODY -->

                        <div class="widget-body">

                            <div class="table-responsive">


                                <!-- APPOINTMENT DETAILS TABLE -->

                                <table class="table table-bordered">

                                    <tr>

                                        <th>
                                            Appointment Number
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->AppointmentNumber
                                            );
                                            ?>
                                        </td>


                                        <th>
                                            Patient Name
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->Name
                                            );
                                            ?>
                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Mobile Number
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->MobileNumber
                                            );
                                            ?>
                                        </td>


                                        <th>
                                            Email
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->Email
                                            );
                                            ?>
                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Appointment Date
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->AppointmentDate
                                            );
                                            ?>
                                        </td>


                                        <th>
                                            Appointment Time
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->AppointmentTime
                                            );
                                            ?>
                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Apply Date
                                        </th>

                                        <td>
                                            <?php
                                            echo htmlentities(
                                                $row->ApplyDate
                                            );
                                            ?>
                                        </td>


                                        <th>
                                            Appointment Final Status
                                        </th>

                                        <td>

                                            <?php

                                            if ($row->Status == "") {

                                                echo '<span style="color:#ff9800;">
                                                        Not Yet Updated
                                                      </span>';

                                            } elseif ($row->Status == "Approved") {

                                                echo '<span style="color:green;">
                                                        Approved
                                                      </span>';

                                            } elseif ($row->Status == "Cancelled") {

                                                echo '<span style="color:red;">
                                                        Cancelled
                                                      </span>';

                                            } else {

                                                echo htmlentities(
                                                    $row->Status
                                                );
                                            }

                                            ?>

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Remark
                                        </th>

                                        <td colspan="3">

                                            <?php

                                            if (empty($row->Remark)) {

                                                echo '<span style="color:#999;">
                                                        Not Updated Yet
                                                      </span>';

                                            } else {

                                                echo htmlentities(
                                                    $row->Remark
                                                );

                                            }

                                            ?>

                                        </td>

                                    </tr>

                                </table>


                                <br>


                                <!-- ACTION BUTTON -->

                                <?php

                                if (empty($currentStatus)) {

                                ?>

                                    <div class="text-center">

                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#myModal"
                                        >

                                            Take Action

                                        </button>

                                    </div>

                                <?php

                                } else {

                                ?>

                                    <div class="text-center">

                                        <a
                                            href="all-appointment.php"
                                            class="btn btn-default"
                                        >

                                            Back to Appointments

                                        </a>

                                    </div>

                                <?php

                                } ?>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>


    <!-- FOOTER -->

    <?php include_once('includes/footer.php'); ?>


</main>


<!-- ==============================
     TAKE ACTION MODAL
============================== -->

<?php

if (empty($currentStatus)) {

?>

<div
    class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog"
        role="document"
    >

        <div class="modal-content">


            <!-- MODAL HEADER -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="exampleModalLabel"
                >
                    Take Action
                </h5>


                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >

                    <span aria-hidden="true">
                        &times;
                    </span>

                </button>

            </div>


            <!-- FORM -->

            <form
                method="post"
                action=""
            >


                <!-- MODAL BODY -->

                <div class="modal-body">


                    <!-- REMARK -->

                    <div class="form-group">

                        <label>
                            Remark
                        </label>

                        <textarea
                            name="remark"
                            placeholder="Enter remark"
                            rows="6"
                            class="form-control"
                            required
                        ></textarea>

                    </div>


                    <!-- STATUS -->

                    <div class="form-group">

                        <label>
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-control"
                            required
                        >

                            <option
                                value="Approved"
                                selected
                            >
                                Approved
                            </option>

                            <option value="Cancelled">
                                Cancelled
                            </option>

                        </select>

                    </div>


                </div>


                <!-- MODAL FOOTER -->

                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>


                    <button
                        type="submit"
                        name="submit"
                        class="btn btn-primary"
                    >
                        Update
                    </button>


                </div>


            </form>


        </div>

    </div>

</div>

<?php

}

?>


<!-- ==============================
     JAVASCRIPT
============================== -->

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