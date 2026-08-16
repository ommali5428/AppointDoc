<?php

require_once __DIR__ . '/header.php';


// ==========================================
// LOGIN CHECK
// ==========================================

if (
    !isset($_SESSION['uid']) ||
    (int)$_SESSION['uid'] <= 0
) {

    header('Location: /login/logout.php');
    exit;

}


$userId = (int)$_SESSION['uid'];


// ==========================================
// UPDATE PROFILE
// ==========================================

if (isset($_POST['update'])) {


    $name =
        trim($_POST['name'] ?? '');

    $email =
        trim($_POST['email'] ?? '');


    if ($name === '' || $email === '') {

        echo "<script>
                alert(
                    'Name and email are required.'
                );
              </script>";

    } elseif (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        echo "<script>
                alert(
                    'Please enter a valid email address.'
                );
              </script>";

    } else {


        try {


            $stmt = $dbh->prepare(
                "UPDATE user_form
                 SET name = :name,
                     email = :email
                 WHERE id = :id"
            );


            $stmt->bindParam(
                ':name',
                $name,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':email',
                $email,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':id',
                $userId,
                PDO::PARAM_INT
            );


            $stmt->execute();


            $_SESSION['user_name'] =
                $name;

            $_SESSION['email'] =
                $email;


            echo "<script>
                    alert(
                        'Profile has been updated.'
                    );
                  </script>";


        } catch (PDOException $e) {

            echo "<script>
                    alert(
                        'Something went wrong. Please try again.'
                    );
                  </script>";

        }

    }

}


// ==========================================
// GET USER
// ==========================================

$user = null;


try {


    $stmt = $dbh->prepare(
        "SELECT id, name, email
         FROM user_form
         WHERE id = :id
         LIMIT 1"
    );


    $stmt->bindParam(
        ':id',
        $userId,
        PDO::PARAM_INT
    );

    $stmt->execute();


    $user =
        $stmt->fetch(PDO::FETCH_ASSOC);


} catch (PDOException $e) {

    $user = null;

}


if (!$user) {

    echo '<h2 style="text-align:center;">
            User not found.
          </h2>';

    exit;

}


$userName = htmlspecialchars(
    $user['name'] ?? '',
    ENT_QUOTES,
    'UTF-8'
);

$userEmail = htmlspecialchars(
    $user['email'] ?? '',
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
        User Profile - Appoint Doc
    </title>

    <link
        rel="stylesheet"
        href="/css/user.css"
    >

</head>

<body
    style="background-color:white;"
>


<form
    class="form-horizontal"
    method="post"
>


<main>

    <div class="wrap">

        <section class="app-content">

            <div
                class="row"
                style="margin-top:120px;"
            >


                <h1
                    align="center"
                    style="padding-bottom:10px;"
                >
                    User Information
                </h1>


                <hr>


                <!-- NAME -->

                <div class="form-group">

                    <label>
                        Name:
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        required
                        value="<?php
                            echo $userName;
                        ?>"
                        style="width:50%;"
                    >

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label>
                        Email:
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        value="<?php
                            echo $userEmail;
                        ?>"
                        style="width:50%;"
                    >

                </div>


                <!-- APPOINTMENTS -->

                <h2
                    style="
                        margin-top:40px;
                        margin-bottom:20px;
                    "
                >
                    My Appointments
                </h2>


                <?php

                try {


                    $appointmentStmt =
                        $dbh->prepare(
                            "SELECT
                                AppointmentNumber,
                                AppointmentDate,
                                AppointmentTime,
                                Specialization,
                                Doctor,
                                Status,
                                Remark
                             FROM tblappointment
                             WHERE Email = :email
                             ORDER BY ID DESC"
                        );


                    $appointmentStmt->bindParam(
                        ':email',
                        $user['email'],
                        PDO::PARAM_STR
                    );


                    $appointmentStmt->execute();


                    $appointments =
                        $appointmentStmt
                        ->fetchAll(
                            PDO::FETCH_ASSOC
                        );


                    if (
                        count($appointments) > 0
                    ) {


                        foreach (
                            $appointments
                            as $appointment
                        ) {

                            ?>


                            <div
                                style="
                                    padding:15px;
                                    margin-bottom:15px;
                                    border:1px solid #ddd;
                                    border-radius:8px;
                                "
                            >

                                <strong>
                                    Appointment Number:
                                </strong>

                                <?php
                                echo htmlspecialchars(
                                    $appointment[
                                        'AppointmentNumber'
                                    ] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                                <br>


                                <strong>
                                    Date:
                                </strong>

                                <?php
                                echo htmlspecialchars(
                                    $appointment[
                                        'AppointmentDate'
                                    ] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                                <br>


                                <strong>
                                    Time:
                                </strong>

                                <?php
                                echo htmlspecialchars(
                                    $appointment[
                                        'AppointmentTime'
                                    ] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                                <br>


                                <strong>
                                    Status:
                                </strong>

                                <?php
                                echo htmlspecialchars(
                                    $appointment[
                                        'Status'
                                    ] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                                <br>


                                <strong>
                                    Remark:
                                </strong>

                                <?php
                                echo htmlspecialchars(
                                    $appointment[
                                        'Remark'
                                    ] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </div>


                            <?php

                        }


                    } else {

                        ?>

                        <p>
                            No appointments found.
                        </p>

                        <?php

                    }


                } catch (PDOException $e) {

                    ?>

                    <p>
                        Unable to load appointments.
                    </p>

                    <?php

                }

                ?>


                <!-- UPDATE -->

                <div
                    class="row"
                    style="margin-top:30px;"
                >

                    <input
                        type="submit"
                        class="button"
                        name="update"
                        value="Update"
                        style="
                            width:100px;
                            height:30px;
                        "
                    >

                </div>


            </div>

        </section>

    </div>

</main>


</form>


</body>

</html>