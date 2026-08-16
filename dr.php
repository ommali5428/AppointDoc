<?php

require_once __DIR__ . '/header.php';


// ==========================================
// GET SPECIALIZATION ID
// ==========================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


// ==========================================
// VALIDATE ID
// ==========================================

if ($id <= 0) {
    header('Location: /index.php');
    exit;
}


// ==========================================
// GET SPECIALIZATION
// ==========================================

$stmt = $dbh->prepare(
    "SELECT ID, Specialization, images
     FROM tblspecialization
     WHERE ID = :id
     LIMIT 1"
);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();

$specialization = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$specialization) {
    echo '<h2 style="text-align:center;">Specialization not found.</h2>';
    exit;
}


$specializationName = htmlspecialchars(
    $specialization['Specialization'] ?? '',
    ENT_QUOTES,
    'UTF-8'
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo $specializationName; ?> - Appoint Doc
    </title>

    <style>

        .backbtn {
            margin-left: 30px;
            background: transparent;
            border: none;
            height: 2.5rem;
        }

        .backbtn a {
            text-decoration: none;
        }

        .backspan {
            font-size: 15px;
            margin-left: 12px;
            margin-right: 12px;
            color: gray;
        }

        .doctor-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .doctor-placeholder {
            width: 100%;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
        }

        .doctor-placeholder i {
            font-size: 80px;
            color: #0188df;
        }

    </style>

</head>

<body>


<section id="blog" class="blog">


    <button class="backbtn">

        <a href="/index.php">

            <span class="backspan">
                ← Back
            </span>

        </a>

    </button>


    <h1 class="heading">

        <?php echo $specializationName; ?>

    </h1>


    <div
        class="box-container"
        style="margin-top:100px;"
    >


        <?php

        // ==========================================
        // GET DOCTORS
        // ==========================================

        $doctorStmt = $dbh->prepare(
            "SELECT *
             FROM tbldoctor
             WHERE Specialization = :specialization
             ORDER BY ID ASC"
        );

        $doctorStmt->bindParam(
            ':specialization',
            $id,
            PDO::PARAM_INT
        );

        $doctorStmt->execute();


        $doctorsFound = false;


        while ($doctor = $doctorStmt->fetch(PDO::FETCH_ASSOC)) {

            $doctorsFound = true;


            $doctorId = (int)$doctor['ID'];

            $doctorName = htmlspecialchars(
                $doctor['FullName'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );


            $doctorImage = trim(
                (string)($doctor['images'] ?? '')
            );


            ?>


            <div
                class="box"
                style="
                    margin-left:50px;
                    padding-bottom:20px;
                "
            >


                <!-- DOCTOR IMAGE -->

                <?php if ($doctorImage !== ''): ?>

                    <img
                        src="/appointment/dr_pannel/images/<?php
                            echo rawurlencode($doctorImage);
                        ?>"
                        class="doctor-image"
                        alt="<?php echo $doctorName; ?>"
                        onerror="this.style.display='none';"
                    >

                <?php else: ?>

                    <div class="doctor-placeholder">

                        <i class="fas fa-user-doctor"></i>

                    </div>

                <?php endif; ?>


                <!-- DOCTOR CONTENT -->

                <div class="content">


                    <h2
                        style="
                            margin-bottom:10px;
                            margin-top:3px;
                        "
                    >

                        <a
                            href="/drinfo.php?id=<?php
                                echo $doctorId;
                            ?>"
                        >

                            <?php echo $doctorName; ?>

                        </a>

                    </h2>


                    <hr
                        style="
                            margin-bottom:16px;
                            border-top:2px solid #ccc;
                        "
                    >


                    <center>


                        <a
                            href="/drinfo.php?id=<?php
                                echo $doctorId;
                            ?>"
                            class="button"
                            style="
                                padding-bottom:5px;
                                padding-top:5px;
                                padding-left:35px;
                                padding-right:35px;
                            "
                        >

                            About

                        </a>


                        &nbsp;&nbsp;&nbsp;&nbsp;


                        <a
                            href="/appointment/specific_book_appointment.php?id=<?php
                                echo $doctorId;
                            ?>&spid=<?php
                                echo $id;
                            ?>"
                            class="button"
                            style="
                                padding-bottom:5px;
                                padding-top:5px;
                                padding-left:37px;
                                padding-right:35px;
                            "
                        >

                            Book

                        </a>


                    </center>


                </div>

            </div>


            <?php

        }


        if (!$doctorsFound) {

            ?>

            <div
                style="
                    width:100%;
                    text-align:center;
                    padding:50px;
                "
            >

                <h2>
                    No doctors found for this specialization.
                </h2>

            </div>

            <?php

        }

        ?>


    </div>

</section>


</body>

</html>