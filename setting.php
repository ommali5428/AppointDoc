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
// CHANGE PASSWORD
// ==========================================

if (isset($_POST['submit'])) {


    $currentPassword =
        $_POST['currentpassword'] ?? '';

    $newPassword =
        $_POST['newpassword'] ?? '';

    $confirmPassword =
        $_POST['confirmpassword'] ?? '';


    if ($newPassword !== $confirmPassword) {

        echo "<script>
                alert(
                    'New Password and Confirm Password do not match.'
                );
              </script>";

    } elseif (strlen($newPassword) < 4) {

        echo "<script>
                alert(
                    'New password must be at least 4 characters.'
                );
              </script>";

    } else {


        $currentHash =
            md5($currentPassword);

        $newHash =
            md5($newPassword);


        try {


            $stmt = $dbh->prepare(
                "SELECT id
                 FROM user_form
                 WHERE id = :id
                 AND password = :password
                 LIMIT 1"
            );


            $stmt->bindParam(
                ':id',
                $userId,
                PDO::PARAM_INT
            );

            $stmt->bindParam(
                ':password',
                $currentHash,
                PDO::PARAM_STR
            );

            $stmt->execute();


            if ($stmt->fetch()) {


                $update = $dbh->prepare(
                    "UPDATE user_form
                     SET password = :password
                     WHERE id = :id"
                );


                $update->bindParam(
                    ':password',
                    $newHash,
                    PDO::PARAM_STR
                );

                $update->bindParam(
                    ':id',
                    $userId,
                    PDO::PARAM_INT
                );


                $update->execute();


                echo "<script>
                        alert(
                            'Your password has been successfully changed.'
                        );
                      </script>";


            } else {


                echo "<script>
                        alert(
                            'Your current password is wrong.'
                        );
                      </script>";

            }


        } catch (PDOException $e) {

            echo "<script>
                    alert(
                        'Something went wrong. Please try again.'
                    );
                  </script>";

        }

    }

}

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
        Change Password - Appoint Doc
    </title>

    <link
        rel="stylesheet"
        href="/css/user.css"
    >

    <script>

        function checkpass() {

            const newPassword =
                document.changepassword.newpassword.value;

            const confirmPassword =
                document.changepassword.confirmpassword.value;


            if (
                newPassword !== confirmPassword
            ) {

                alert(
                    'New Password and Confirm Password do not match'
                );

                document
                    .changepassword
                    .confirmpassword
                    .focus();

                return false;

            }


            return true;

        }

    </script>

</head>

<body
    style="background-color:white;"
>


<form
    class="form-horizontal"
    onsubmit="return checkpass();"
    name="changepassword"
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
                    Change Password
                </h1>


                <hr>


                <div class="form-group">

                    <label>
                        Current Password:
                    </label>

                    <input
                        type="password"
                        name="currentpassword"
                        required
                        style="width:50%;"
                    >

                </div>


                <div class="form-group">

                    <label>
                        New Password:
                    </label>

                    <input
                        type="password"
                        name="newpassword"
                        required
                        style="width:50%;"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Confirm Password:
                    </label>

                    <input
                        type="password"
                        name="confirmpassword"
                        required
                        style="width:50%;"
                    >

                </div>


                <div class="row">

                    <input
                        type="submit"
                        class="button"
                        value="Change"
                        name="submit"
                    >

                </div>


            </div>

        </section>

    </div>

</main>


</form>


</body>

</html>