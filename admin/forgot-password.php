<?php

session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    $newpassword = md5($_POST['newpassword']);

    // Check email and mobile number
    $sql = "SELECT ID 
            FROM tbldoctor 
            WHERE Email = :email 
            AND MobileNumber = :mobile";

    $query = $dbh->prepare($sql);

    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);

    $query->execute();

    if ($query->rowCount() > 0) {

        // Update password
        $update = "UPDATE tbldoctor 
                   SET Password = :newpassword 
                   WHERE Email = :email 
                   AND MobileNumber = :mobile";

        $chngpwd = $dbh->prepare($update);

        $chngpwd->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);

        $chngpwd->execute();

        echo "<script>
                alert('Your password was successfully changed.');
                window.location.href='login.php';
              </script>";

        exit();

    } else {

        echo "<script>
                alert('Email ID or Mobile Number is invalid.');
              </script>";
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DAMS - Forgot Password</title>


    <link rel="stylesheet"
          href="libs/bower/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet"
          href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">

    <link rel="stylesheet"
          href="libs/bower/animate.css/animate.min.css">

    <link rel="stylesheet"
          href="assets/css/bootstrap.css">

    <link rel="stylesheet"
          href="assets/css/core.css">

    <link rel="stylesheet"
          href="assets/css/misc-pages.css">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">


    <script>

        function valid() {

            var newPassword =
                document.chngpwd.newpassword.value;

            var confirmPassword =
                document.chngpwd.confirmpassword.value;


            if (newPassword !== confirmPassword) {

                alert("New Password and Confirm Password do not match!");

                document.chngpwd.confirmpassword.focus();

                return false;
            }


            if (newPassword.length < 6) {

                alert("Password must contain at least 6 characters.");

                document.chngpwd.newpassword.focus();

                return false;
            }


            return true;
        }

    </script>

</head>


<body class="simple-page">


    <!-- Back To Home -->

    <div id="back-to-home">

        <a href="../index.php"
           class="btn btn-outline btn-default">

            <i class="fa fa-home animated zoomIn"></i>

        </a>

    </div>


    <div class="simple-page-wrap">


        <!-- Logo -->

        <div class="simple-page-logo animated swing">

            <span style="color:white">

                <i class="fa fa-gg"></i>

            </span>

            <span style="color:white">

                DAMS

            </span>

        </div>


        <!-- Forgot Password Form -->

        <div class="simple-page-form animated flipInY"
             id="login-form">


            <h4 class="form-title m-b-xl text-center">

                Reset Your Password

            </h4>


            <form method="post"
                  name="chngpwd"
                  onsubmit="return valid();">


                <!-- Email -->

                <div class="form-group">

                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email Address"
                        name="email"
                        required
                    >

                </div>


                <!-- Mobile -->

                <div class="form-group">

                    <input
                        type="text"
                        class="form-control"
                        name="mobile"
                        placeholder="Mobile Number"
                        maxlength="10"
                        pattern="[0-9]{10}"
                        required
                    >

                </div>


                <!-- New Password -->

                <div class="form-group">

                    <input
                        class="form-control"
                        type="password"
                        name="newpassword"
                        placeholder="New Password"
                        minlength="6"
                        required
                    >

                </div>


                <!-- Confirm Password -->

                <div class="form-group">

                    <input
                        class="form-control"
                        type="password"
                        name="confirmpassword"
                        placeholder="Confirm Password"
                        minlength="6"
                        required
                    >

                </div>


                <!-- Reset Button -->

                <input
                    type="submit"
                    class="btn btn-primary"
                    name="submit"
                    value="RESET"
                >

            </form>

        </div>


        <!-- Footer -->

        <div class="simple-page-footer">

            <p style="color:white">

                Do you have an account?

                <a href="login.php">
                    SIGN IN
                </a>

            </p>

        </div>


    </div>

</body>

</html>