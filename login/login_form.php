<?php

// ==========================================
// DATABASE CONNECTION
// ==========================================

require_once __DIR__ . '/../conn.php';


// ==========================================
// SESSION
// ==========================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ==========================================
// LOGIN PROCESS
// ==========================================

$error = [];

if (isset($_POST['submit'])) {

    // Get and sanitize email
    $email = trim($_POST['email'] ?? '');

    // Get password
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {

        $error[] = 'Please enter email and password.';

    } else {

        // Keep MD5 because your existing database
        // passwords are stored as MD5.
        $pass = md5($password);


        // ==========================================
        // CHECK USER
        // ==========================================

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, name, email, password, user_type
             FROM user_form
             WHERE email = ? AND password = ?
             LIMIT 1"
        );


        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "ss",
                $email,
                $pass
            );

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);


            if ($result && mysqli_num_rows($result) > 0) {

                $row = mysqli_fetch_assoc($result);


                // ==========================================
                // ADMIN LOGIN
                // ==========================================

                if ($row['user_type'] === 'admin') {

                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['admin']      = (int)$row['id'];
                    $_SESSION['aem']        = $row['email'];


                    header(
                        'Location: ../admin/dashboard.php'
                    );

                    exit;


                // ==========================================
                // USER LOGIN
                // ==========================================

                } elseif ($row['user_type'] === 'user') {

                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['uid']       = (int)$row['id'];
                    $_SESSION['em']        = $row['email'];


                    // ==========================================
                    // GET LATEST APPOINTMENT OF THIS USER
                    // ==========================================

                    $appointmentStmt = mysqli_prepare(
                        $conn,
                        "SELECT ID
                         FROM tblappointment
                         WHERE Email = ?
                         ORDER BY ID DESC
                         LIMIT 1"
                    );


                    if ($appointmentStmt) {

                        mysqli_stmt_bind_param(
                            $appointmentStmt,
                            "s",
                            $email
                        );

                        mysqli_stmt_execute(
                            $appointmentStmt
                        );

                        $appointmentResult =
                            mysqli_stmt_get_result(
                                $appointmentStmt
                            );


                        if (
                            $appointmentResult &&
                            mysqli_num_rows($appointmentResult) > 0
                        ) {

                            $appointment =
                                mysqli_fetch_assoc(
                                    $appointmentResult
                                );


                            $_SESSION['appid'] =
                                (int)$appointment['ID'];

                        }


                        mysqli_stmt_close(
                            $appointmentStmt
                        );
                    }


                    header(
                        'Location: ../index.php'
                    );

                    exit;


                } else {

                    $error[] =
                        'Invalid account type.';

                }


            } else {

                $error[] =
                    'Incorrect email or password!';

            }


            mysqli_stmt_close($stmt);


        } else {

            $error[] =
                'Unable to process login. Please try again.';

        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Form</title>


    <!-- Custom CSS -->

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body
    class="form-container"
    style="
        background-image:
        url('../drimages/top-view-internet-communication-network.jpg');
        background-size:100%;
    "
>


<div>


    <form
        action=""
        method="post"
        style="background:#BCC6CC;"
    >

        <h3>
            Login Now
        </h3>


        <?php

        if (!empty($error)) {

            foreach ($error as $errorMessage) {

                echo
                    '<span class="error-msg">' .
                    htmlspecialchars(
                        $errorMessage,
                        ENT_QUOTES,
                        'UTF-8'
                    ) .
                    '</span>';

            }

        }

        ?>


        <input
            type="email"
            name="email"
            required
            placeholder="Enter your email"
            value="<?php
                echo htmlspecialchars(
                    $_POST['email'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>"
        >


        <input
            type="password"
            name="password"
            required
            placeholder="Enter your password"
        >


        <input
            type="submit"
            name="submit"
            value="Login Now"
            class="form-btn"
        >


        <p>

            Don't have an account?

            <a href="register_form.php">
                Register Now
            </a>

        </p>


    </form>


    <center>

        <a
            href="../index.php"
        >

            <p
                style="
                    margin-top:8px;
                    color:black;
                    border:solid 1px #BCC6CC;
                "
            >
                Back To Home
            </p>

        </a>

    </center>


</div>


</body>

</html>