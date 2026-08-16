<?php

// ======================================================
// HEADER
// ======================================================
// header.php is one directory above appointment/
require_once __DIR__ . '/../header.php';

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cancel Appointment</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Appointment CSS -->
    <link
        rel="stylesheet"
        href="css_app/bootstrap.min1.css"
    >

    <link
        rel="stylesheet"
        href="css_app/bootstrap-icons.css"
    >

    <link
        rel="stylesheet"
        href="css_app/owl.carousel.min.css"
    >

    <link
        rel="stylesheet"
        href="css_app/owl.theme.default.min.css"
    >

    <link
        rel="stylesheet"
        href="css_app/templatemo-medic-care4.css"
    >

</head>


<body id="top">


<main>

    <section
        class="section-padding"
        id="booking"
    >

        <div class="container">

            <div class="row">

                <div class="col-lg-12 col-12 mx-auto">

                    <div class="booking-form">


                        <!-- ==========================================
                             PAGE TITLE
                        =========================================== -->

                        <h3
                            class="text-center mb-lg-3 mb-2"
                            style="color:#0188df;"
                        >
                            Cancel Appointment by Appointment Number
                        </h3>


                        <!-- ==========================================
                             SEARCH FORM
                        =========================================== -->

                        <form
                            role="form"
                            method="post"
                            action=""
                        >

                            <div class="row">


                                <div
                                    class="col-lg-6 col-12"
                                    style="margin-top:30px;"
                                >

                                    <input
                                        id="searchdata"
                                        type="text"
                                        name="searchdata"
                                        required
                                        class="form-control"
                                        style="
                                            font-size:15px;
                                            background-color:#EDF4FF;
                                            border-radius:8px;
                                        "
                                        placeholder="Appointment Number"
                                        value="<?php
                                            echo isset($_POST['searchdata'])
                                                ? htmlspecialchars(
                                                    trim($_POST['searchdata']),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                : '';
                                        ?>"
                                    >

                                </div>


                                <div
                                    class="col-lg-3 col-md-4 col-6 mx-auto"
                                >

                                    <button
                                        type="submit"
                                        class="button"
                                        style="
                                            width:250px;
                                            margin-top:50px;
                                        "
                                        name="search"
                                    >
                                        Check
                                    </button>

                                </div>


                            </div>

                        </form>

                    </div>


                    <?php

                    // ==================================================
                    // SEARCH APPOINTMENT
                    // ==================================================

                    if (isset($_POST['search'])) {

                        $sdata = trim($_POST['searchdata'] ?? '');

                        ?>

                        <h4
                            align="center"
                            style="
                                margin-top:50px;
                                margin-bottom:50px;
                            "
                        >
                            Result For
                            "<?php
                                echo htmlspecialchars(
                                    $sdata,
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                            ?>"
                        </h4>


                        <div class="widget-body">

                            <div class="table-responsive">


                                <table
                                    class="
                                        table
                                        table-bordered
                                        table-hover
                                        js-basic-example
                                        dataTable
                                        table-custom
                                    "
                                >


                                    <thead>

                                        <tr>

                                            <th>S.No</th>

                                            <th>
                                                Appointment Number
                                            </th>

                                            <th>
                                                Patient Name
                                            </th>

                                            <th>
                                                Mobile Number
                                            </th>

                                            <th>
                                                Email
                                            </th>

                                            <th>
                                                Doctor
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Remark
                                            </th>

                                            <th>
                                                Action
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    // ==================================================
                                    // SEARCH DATABASE
                                    // ==================================================

                                    /*
                                     * Using PDO prepared statement.
                                     *
                                     * This works with your existing $dbh
                                     * created in conn.php.
                                     */

                                    $sql = "
                                        SELECT
                                            ID,
                                            AppointmentNumber,
                                            Name,
                                            MobileNumber,
                                            Email,
                                            Doctor,
                                            Status,
                                            Remark
                                        FROM tblappointment
                                        WHERE
                                            AppointmentNumber LIKE :search
                                            OR Name LIKE :search
                                            OR MobileNumber LIKE :search
                                        ORDER BY ID DESC
                                    ";


                                    $query = $dbh->prepare($sql);


                                    $searchValue = $sdata . '%';


                                    $query->bindValue(
                                        ':search',
                                        $searchValue,
                                        PDO::PARAM_STR
                                    );


                                    $query->execute();


                                    $results =
                                        $query->fetchAll(PDO::FETCH_OBJ);


                                    $cnt = 1;


                                    if (count($results) > 0) {


                                        foreach ($results as $row) {

                                            ?>


                                            <tr>


                                                <!-- S.NO -->

                                                <td>

                                                    <?php
                                                    echo $cnt;
                                                    ?>

                                                </td>


                                                <!-- APPOINTMENT NUMBER -->

                                                <td>

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $row->AppointmentNumber ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                    ?>

                                                </td>


                                                <!-- PATIENT NAME -->

                                                <td>

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $row->Name ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                    ?>

                                                </td>


                                                <!-- MOBILE -->

                                                <td>

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $row->MobileNumber ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                    ?>

                                                </td>


                                                <!-- EMAIL -->

                                                <td>

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $row->Email ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                    ?>

                                                </td>


                                                <!-- DOCTOR -->

                                                <td>

                                                    <?php

                                                    $doctorName = '';


                                                    if (
                                                        isset($row->Doctor)
                                                        &&
                                                        $row->Doctor !== ''
                                                    ) {

                                                        $doctorSql = "
                                                            SELECT FullName
                                                            FROM tbldoctor
                                                            WHERE ID = :doctor_id
                                                            LIMIT 1
                                                        ";


                                                        $doctorQuery =
                                                            $dbh->prepare(
                                                                $doctorSql
                                                            );


                                                        $doctorQuery->bindValue(
                                                            ':doctor_id',
                                                            (int)$row->Doctor,
                                                            PDO::PARAM_INT
                                                        );


                                                        $doctorQuery->execute();


                                                        $doctor =
                                                            $doctorQuery->fetch(
                                                                PDO::FETCH_ASSOC
                                                            );


                                                        if ($doctor) {

                                                            $doctorName =
                                                                $doctor['FullName'];

                                                        }

                                                    }


                                                    if ($doctorName !== '') {

                                                        echo htmlspecialchars(
                                                            $doctorName,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                    } else {

                                                        echo 'Not Assigned';

                                                    }

                                                    ?>

                                                </td>


                                                <!-- STATUS -->

                                                <td>

                                                    <?php

                                                    if (
                                                        empty($row->Status)
                                                    ) {

                                                        echo 'Not Updated Yet';

                                                    } else {

                                                        echo htmlspecialchars(
                                                            $row->Status,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                    }

                                                    ?>

                                                </td>


                                                <!-- REMARK -->

                                                <td>

                                                    <?php

                                                    if (
                                                        empty($row->Remark)
                                                    ) {

                                                        echo 'Not Updated Yet';

                                                    } else {

                                                        echo htmlspecialchars(
                                                            $row->Remark,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                    }

                                                    ?>

                                                </td>


                                                <!-- CANCEL BUTTON -->

                                                <td>


                                                    <?php

                                                    /*
                                                     * Do not allow cancellation
                                                     * of an already cancelled
                                                     * appointment.
                                                     */

                                                    $status =
                                                        strtolower(
                                                            trim(
                                                                $row->Status ?? ''
                                                            )
                                                        );


                                                    if (
                                                        $status === 'cancelled'
                                                        ||
                                                        $status === 'canceled'
                                                    ) {

                                                        ?>

                                                        <span
                                                            style="
                                                                color:red;
                                                                font-weight:bold;
                                                            "
                                                        >
                                                            Cancelled
                                                        </span>

                                                        <?php

                                                    } else {

                                                        ?>

                                                        <a
                                                            href="cancelapp.php?id=<?php
                                                                echo urlencode(
                                                                    $row->AppointmentNumber
                                                                );
                                                            ?>"
                                                            onclick="
                                                                return confirm(
                                                                    'Are you sure you want to cancel this appointment?'
                                                                );
                                                            "
                                                        >

                                                            <button
                                                                type="button"
                                                                class="button"
                                                            >
                                                                Cancel
                                                            </button>

                                                        </a>

                                                        <?php

                                                    }

                                                    ?>


                                                </td>


                                            </tr>


                                            <?php

                                            $cnt++;

                                        }


                                    } else {

                                        ?>


                                        <tr>

                                            <td
                                                colspan="9"
                                                style="
                                                    text-align:center;
                                                    padding:20px;
                                                "
                                            >

                                                No record found
                                                against this search.

                                            </td>

                                        </tr>


                                        <?php

                                    }

                                    ?>


                                    </tbody>


                                </table>


                            </div>

                        </div>


                        <?php

                    }

                    ?>


                </div>

            </div>

        </div>

    </section>

</main>


</body>

</html>