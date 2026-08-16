<?php

// ==========================================
// DATABASE CONNECTION
// ==========================================

require_once __DIR__ . '/../conn.php';


// ==========================================
// REGISTRATION PROCESS
// ==========================================

$error = [];

if (isset($_POST['submit'])) {

    // Get form values
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['cpassword'] ?? '';

    // User registration always creates a normal user
    $user_type = 'user';


    // ==========================================
    // BASIC VALIDATION
    // ==========================================

    if ($name === '') {

        $error[] = 'Please enter your name.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error[] = 'Please enter a valid email address.';

    } elseif ($password === '') {

        $error[] = 'Please enter a password.';

    } elseif ($password !== $confirmPassword) {

        $error[] = 'Password not matched!';

    } else {


        // ==========================================
        // CHECK IF EMAIL ALREADY EXISTS
        // ==========================================

        $checkStmt = mysqli_prepare(
            $conn,
            "SELECT id
             FROM user_form
             WHERE email = ?
             LIMIT 1"
        );


        if ($checkStmt) {

            mysqli_stmt_bind_param(
                $checkStmt,
                "s",
                $email
            );

            mysqli_stmt_execute($checkStmt);

            $checkResult =
                mysqli_stmt_get_result($checkStmt);


            if (
                $checkResult &&
                mysqli_num_rows($checkResult) > 0
            ) {

                $error[] =
                    'User already exists!';


            } else {


                // ==========================================
                // PASSWORD
                // ==========================================
                //
                // Your existing database uses MD5 passwords.
                // Keeping MD5 here maintains compatibility
                // with the existing login system.
                //

                $pass = md5($password);


                // ==========================================
                // INSERT USER
                // ==========================================

                $insertStmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO user_form
                    (name, email, password, user_type)
                    VALUES (?, ?, ?, ?)"
                );


                if ($insertStmt) {

                    mysqli_stmt_bind_param(
                        $insertStmt,
                        "ssss",
                        $name,
                        $email,
                        $pass,
                        $user_type
                    );


                    if (
                        mysqli_stmt_execute(
                            $insertStmt
                        )
                    ) {

                        mysqli_stmt_close(
                            $insertStmt
                        );

                        mysqli_stmt_close(
                            $checkStmt
                        );


                        // ==================================
                        // REGISTRATION SUCCESS
                        // ==================================

                        header(
                            'Location: login_form.php'
                        );

                        exit;


                    } else {

                        $error[] =
                            'Registration failed. Please try again.';

                        mysqli_stmt_close(
                            $insertStmt
                        );
                    }


                } else {

                    $error[] =
                        'Unable to process registration.';

                }

            }


            mysqli_stmt_close(
                $checkStmt
            );


        } else {

            $error[] =
                'Unable to check user information.';

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

    <title>Register Form</title>


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
        style="background:#BCC6CC"
    >

        <h3>
            Register Now
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
            type="text"
            name="name"
            required
            placeholder="Enter your name"
            value="<?php
                echo htmlspecialchars(
                    $_POST['name'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>"
        >


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
            type="password"
            name="cpassword"
            required
            placeholder="Confirm your password"
        >


        <select name="user_type">

            <option value="user">
                User
            </option>

        </select>


        <input
            type="submit"
            name="submit"
            value="Register Now"
            class="form-btn"
        >


        <p>

            Already have an account?

            <a href="login_form.php">
                Login Now
            </a>

        </p>


    </form>


</div>


</body>

</html>