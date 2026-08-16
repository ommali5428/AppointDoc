<?php

require_once __DIR__ . '/header.php';


// ==========================================
// SUBMIT FEEDBACK
// ==========================================

if (isset($_POST['submit'])) {


    $name = trim($_POST['name'] ?? '');

    $email = trim($_POST['email'] ?? '');

    $feedback = trim($_POST['feedback'] ?? '');


    if (
        $name === '' ||
        $email === '' ||
        $feedback === ''
    ) {

        echo "<script>
                alert('Please fill all fields.');
              </script>";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "<script>
                alert('Please enter a valid email address.');
              </script>";

    } else {


        try {


            $stmt = $dbh->prepare(
                "INSERT INTO feedback
                (name, email, feedback)
                VALUES
                (:name, :email, :feedback)"
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
                ':feedback',
                $feedback,
                PDO::PARAM_STR
            );


            $stmt->execute();


            echo "<script>
                    alert('Thank you. Your Feedback is submitted.');
                    window.location.href='/feedback.php';
                  </script>";

            exit;


        } catch (PDOException $e) {

            echo "<script>
                    alert('Something went wrong. Please try again.');
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

    <title>Feedback - Appoint Doc</title>

</head>

<body>


<form method="post">


<section
    id="contact"
    style="background-color:#fff;"
    class="contact"
>


    <h1 class="heading">
        Feedback
    </h1>


    <h3 class="title">
        Share your experience with us
    </h3>


    <div class="row">


        <div class="images">

            <img
                src="/drimages/feedback.webp"
                alt="Feedback"
            >

        </div>


        <div class="form-container">


            <input
                type="text"
                placeholder="Full Name"
                name="name"
                maxlength="100"
                required
                style="
                    font-size:15px;
                    background-color:#EDF4FF;
                    border-radius:8px;
                "
            >


            <input
                type="email"
                placeholder="Enter Your Email"
                name="email"
                maxlength="150"
                required
                style="
                    font-size:15px;
                    background-color:#EDF4FF;
                    border-radius:8px;
                "
            >


            <textarea
                name="feedback"
                cols="30"
                rows="10"
                placeholder="Feedback"
                maxlength="130"
                required
                style="
                    font-size:15px;
                    background-color:#EDF4FF;
                    border-radius:8px;
                "
            ></textarea>


            <input
                type="submit"
                name="submit"
                value="Submit"
            >


        </div>

    </div>


</section>


</form>


</body>

</html>