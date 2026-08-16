<?php

// ======================================================
// HEADER
// ======================================================
// appointment/ is one level below AppointDoc/
require_once __DIR__ . '/../header.php';

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Check Status</title>


    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >


    <link
        href="css_app/bootstrap.min1.css"
        rel="stylesheet"
    >

    <link
        href="css_app/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link
        href="css_app/owl.carousel.min.css"
        rel="stylesheet"
    >

    <link
        href="css_app/owl.theme.default.min.css"
        rel="stylesheet"
    >

    <link
        href="css_app/templatemo-medic-care4.css"
        rel="stylesheet"
    >


    <script>
        function getdoctors(val) {

            alert(val);

            $.ajax({

                type: "POST",

                url: "get_doctors.php",

                data: 'sp_id=' + val,

                success: function(data) {

                    $("#doctorlist").html(data);

                }

            });

        }
    </script>

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


                        <h3
                            class="text-center mb-lg-3 mb-2"
                            style="color:#0188df"
                        >
                            Search Appointment History by Appointment Number/Name/Mobile No
                        </h3>


                        <form
                            role="form"
                            method="post"
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
                                        placeholder="Appointment No./Name/Mobile No."
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


                                    <div
                                        style="margin-top:20px;"
                                    >

                                        <a
                                            href="cancel.php"
                                        >

                                            <span
                                                style="
                                                    font-size:15px;
                                                    color:#800000;
                                                "
                                            >
                                                * Want to Cancel your Appointment?
                                            </span>

                                        </a>

                                    </div>

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
                    // SEARCH
                    // ==================================================

                    if (isset($_POST['search'])) {


                        // ----------------------------------------------
                        // CHECK LOGIN
                        // ----------------------------------------------

                        if (
                            !isset($_SESSION['uid'])
                            ||
                            empty($_SESSION['uid'])
                        ) {

                            echo '<script>
                                alert("Please Login To Check Status of Appointment");
                            </script>';

                            echo '<script>
                                window.location.href="../login/login_form.php";
                            </script>';

                            exit;

                        }


                        // ----------------------------------------------
                        // SEARCH VALUE
                        // ----------------------------------------------

                        $sdata = trim(
                            $_POST['searchdata'] ?? ''
                        );


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

                                        </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    // ==================================================
                                    // DATABASE SEARCH
                                    // ==================================================

                                    /*
                                     * Original query was:
                                     *
                                     * SELECT * FROM tblappointment
                                     * WHERE AppointmentNumber like '$sdata%'
                                     * || Name like '$sdata%'
                                     * || MobileNumber like '$sdata%'
                                     *
                                     * Changed only to a prepared statement.
                                     */

                                    $sql = "
                                        SELECT *
                                        FROM tblappointment
                                        WHERE
                                            AppointmentNumber LIKE :search
                                            OR Name LIKE :search
                                            OR MobileNumber LIKE :search
                                        ORDER BY ID DESC
                                    ";


                                    $query = $dbh->prepare($sql);


                                    $searchValue =
                                        $sdata . '%';


                                    $query->bindValue(
                                        ':search',
                                        $searchValue,
                                        PDO::PARAM_STR
                                    );


                                    $query->execute();


                                    $results =
                                        $query->fetchAll(
                                            PDO::FETCH_OBJ
                                        );


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


                                                <!-- MOBILE NUMBER -->

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


                                                    if (
                                                        $doctorName !== ''
                                                    ) {

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

                                                <?php

                                                if (
                                                    empty($row->Status)
                                                ) {

                                                    ?>

                                                    <td>
                                                        Not Updated Yet
                                                    </td>

                                                    <?php

                                                } else {

                                                    ?>

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $row->Status,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                        ?>

                                                    </td>

                                                    <?php

                                                }

                                                ?>


                                                <!-- REMARK -->

                                                <?php

                                                if (
                                                    empty($row->Remark)
                                                ) {

                                                    ?>

                                                    <td>
                                                        Not Updated Yet
                                                    </td>

                                                    <?php

                                                } else {

                                                    ?>

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $row->Remark,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                        ?>

                                                    </td>

                                                    <?php

                                                }

                                                ?>


                                            </tr>


                                            <?php

                                            $cnt++;

                                        }


                                    } else {

                                        ?>


                                        <tr>

                                            <td
                                                colspan="8"
                                                style="text-align:center;"
                                            >
                                                No record found against this search
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