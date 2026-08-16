<?php

require_once __DIR__ . '/header.php';


// ==========================================
// GET DOCTOR ID
// ==========================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


if ($id <= 0) {

    header('Location: /index.php');
    exit;

}


// ==========================================
// GET DOCTOR
// ==========================================

$stmt = $dbh->prepare(
    "SELECT *
     FROM tbldoctor
     WHERE ID = :id
     LIMIT 1"
);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();

$doctor = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$doctor) {

    echo '<h2 style="text-align:center;">Doctor not found.</h2>';
    exit;

}


// ==========================================
// SAFE VALUES
// ==========================================

$doctorName = htmlspecialchars(
    $doctor['FullName'] ?? '',
    ENT_QUOTES,
    'UTF-8'
);

$qualification = nl2br(
    htmlspecialchars(
        $doctor['qualification'] ?? '',
        ENT_QUOTES,
        'UTF-8'
    )
);

$experience = htmlspecialchars(
    $doctor['experience'] ?? '',
    ENT_QUOTES,
    'UTF-8'
);

$hospital = nl2br(
    htmlspecialchars(
        $doctor['hospital_detail'] ?? '',
        ENT_QUOTES,
        'UTF-8'
    )
);

$timing = nl2br(
    htmlspecialchars(
        $doctor['timing'] ?? '',
        ENT_QUOTES,
        'UTF-8'
    )
);

$doctorImage = trim(
    (string)($doctor['images'] ?? '')
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
        <?php echo $doctorName; ?> - Appoint Doc
    </title>

    <style>

        .doctor-info-table {
            width: 950px;
            max-width: 95%;
            min-height: 500px;
            border-collapse: collapse;
            margin: 120px auto 40px;
        }

        .doctor-info-table th,
        .doctor-info-table td {
            border: 1px solid #333;
            padding: 15px;
        }

        .doctor-info-table th {
            color: #003265;
            background: #eaf5ff;
            font-size: 22px;
        }

        .doctor-info-table td:first-child {
            width: 180px;
            font-size: 16px;
        }

        .doctor-photo {
            width: 280px;
            max-height: 350px;
            object-fit: contain;
            display: block;
            margin: auto;
        }

        .doctor-placeholder {
            width: 280px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            margin: auto;
        }

        .doctor-placeholder i {
            font-size: 100px;
            color: #0188df;
        }

        @media (max-width: 768px) {

            .doctor-info-table {
                width: 95%;
                margin-top: 50px;
            }

            .doctor-info-table td {
                display: block;
                width: auto !important;
            }

            .doctor-photo,
            .doctor-placeholder {
                width: 220px;
            }

        }

    </style>

</head>

<body>


<section id="home" class="home">


    <table class="doctor-info-table">


        <tr>

            <th colspan="3">

                <?php echo $doctorName; ?>

            </th>

        </tr>


        <tr>

            <td>
                Qualification:
            </td>

            <td>
                <strong>
                    <?php echo $qualification; ?>
                </strong>
            </td>

            <td rowspan="4">

                <?php if ($doctorImage !== ''): ?>

                    <img
                        src="/appointment/dr_pannel/images/<?php
                            echo rawurlencode($doctorImage);
                        ?>"
                        class="doctor-photo"
                        alt="<?php echo $doctorName; ?>"
                    >

                <?php else: ?>

                    <div class="doctor-placeholder">

                        <i class="fas fa-user-doctor"></i>

                    </div>

                <?php endif; ?>

            </td>

        </tr>


        <tr>

            <td>
                Experience:
            </td>

            <td>

                <strong>
                    <?php echo $experience; ?>
                </strong>

            </td>

        </tr>


        <tr>

            <td>
                Hospital Details:
            </td>

            <td>

                <strong>
                    <?php echo $hospital; ?>
                </strong>

            </td>

        </tr>


        <tr>

            <td>
                Timing:
            </td>

            <td>

                <strong>
                    <?php echo $timing; ?>
                </strong>

            </td>

        </tr>


    </table>


</section>


</body>

</html>