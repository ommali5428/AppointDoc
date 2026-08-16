<?php

session_start();

// IMPORTANT:
// login_form.php is inside /login/
// ../conn.php points to /AppointDoc/conn.php
require_once __DIR__ . '/../conn.php';

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Your existing database uses MD5 passwords
    $pass = md5($password);

    // Use prepared statement
    $sql = "SELECT * FROM user_form 
            WHERE email = :email 
            AND password = :password 
            LIMIT 1";

    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $pass, PDO::PARAM_STR);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row) {

        // -------------------------
        // ADMIN LOGIN
        // -------------------------
        if ($row['user_type'] === 'admin') {

            // Set session BEFORE redirect
            $_SESSION['admin'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['aem'] = $row['email'];

            // Get latest appointment for this email
            $appSql = "SELECT * 
                       FROM tblappointment 
                       WHERE Email = :email 
                       ORDER BY ID DESC 
                       LIMIT 1";

            $appQuery = $dbh->prepare($appSql);
            $appQuery->bindParam(':email', $email, PDO::PARAM_STR);
            $appQuery->execute();

            $appointment = $appQuery->fetch(PDO::FETCH_ASSOC);

            if ($appointment) {
                $_SESSION['appid'] = $appointment['ID'];
            }

            header("Location: ../admin/dashboard.php");
            exit();

        }

        // -------------------------
        // NORMAL USER LOGIN
        // -------------------------
        elseif ($row['user_type'] === 'user') {

            $_SESSION['user_name'] = $row['name'];
            $_SESSION['uid'] = $row['id'];
            $_SESSION['em'] = $row['email'];

            // Get latest appointment
            $appSql = "SELECT * 
                       FROM tblappointment 
                       WHERE Email = :email 
                       ORDER BY ID DESC 
                       LIMIT 1";

            $appQuery = $dbh->prepare($appSql);
            $appQuery->bindParam(':email', $email, PDO::PARAM_STR);
            $appQuery->execute();

            $appointment = $appQuery->fetch(PDO::FETCH_ASSOC);

            if ($appointment) {
                $_SESSION['appid'] = $appointment['ID'];
            }

            header("Location: ../index.php");
            exit();
        }

    } else {

        $error = "Incorrect email or password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Form</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body
    class="form-container"
    style="
        background-image: url('../drimages/top-view-internet-communication-network.jpg');
        background-size: cover;
        background-position: center;
    "
>

<div>

    <form action="" method="post" style="background: #BCC6CC">

        <h3>Login Now</h3>

        <?php if (isset($error)) { ?>

            <span class="error-msg">
                <?php echo htmlspecialchars($error); ?>
            </span>

        <?php } ?>

        <input
            type="email"
            name="email"
            required
            placeholder="Enter your email"
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
            <a href="register_form.php">Register Now</a>
        </p>

    </form>

    <center>

        <a href="../index.php">

            <p
                style="
                    margin-top:8px;
                    color:black;
                    border: solid 1px #BCC6CC;
                "
            >
                Back To Home
            </p>

        </a>

    </center>

</div>

</body>

</html>