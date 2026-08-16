<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

if (isset($_POST['submit'])) {

    $fname = trim($_POST['fname']);
    $mobno = trim($_POST['mobno']);
    $email = trim($_POST['email']);
    $sid   = $_POST['specializationid'];
    $qf    = trim($_POST['qf']);
    $exp   = trim($_POST['exp']);
    $hd    = trim($_POST['hd']);
    $time  = trim($_POST['time']);

    // Keep MD5 for compatibility with your existing login system
    $password = md5($_POST['password']);


    /* ---------------------------------
       Check duplicate email
    --------------------------------- */

    $ret = "SELECT ID FROM tbldoctor WHERE Email = :email";

    $query = $dbh->prepare($ret);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {

        echo "<script>
                alert('Email-id already exists. Please try another email.');
              </script>";

    } else {


        /* ---------------------------------
           Image validation
        --------------------------------- */

        if (!isset($_FILES['images']) || $_FILES['images']['error'] != 0) {

            echo "<script>
                    alert('Please select a doctor image.');
                  </script>";

        } else {

            $originalName = $_FILES['images']['name'];
            $tmpName      = $_FILES['images']['tmp_name'];
            $fileSize     = $_FILES['images']['size'];

            // Get extension safely
            $extension = strtolower(
                pathinfo($originalName, PATHINFO_EXTENSION)
            );

            // Allowed image types
            $allowed_extension = array(
                'jpg',
                'jpeg',
                'png',
                'gif'
            );


            /* Maximum image size = 5 MB */
            $maxSize = 5 * 1024 * 1024;


            if (!in_array($extension, $allowed_extension)) {

                echo "<script>
                        alert('Invalid image format. Only JPG, JPEG, PNG and GIF are allowed.');
                      </script>";

            } elseif ($fileSize > $maxSize) {

                echo "<script>
                        alert('Image size must be less than 5 MB.');
                      </script>";

            } else {


                /* ---------------------------------
                   Generate unique image name
                --------------------------------- */

                $images = md5(
                    uniqid(
                        $originalName,
                        true
                    )
                ) . '_' . time() . '.' . $extension;


                /* ---------------------------------
                   Image upload folder
                --------------------------------- */

                $uploadDir = __DIR__ . '/images/';


                // Create folder if it doesn't exist
                if (!is_dir($uploadDir)) {

                    mkdir(
                        $uploadDir,
                        0777,
                        true
                    );
                }


                $uploadPath = $uploadDir . $images;


                /* ---------------------------------
                   Move uploaded image
                --------------------------------- */

                if (!move_uploaded_file(
                    $tmpName,
                    $uploadPath
                )) {

                    echo "<script>
                            alert('Image upload failed. Please try again.');
                          </script>";

                } else {


                    /* ---------------------------------
                       Insert Doctor
                    --------------------------------- */

                    $sql = "INSERT INTO tbldoctor
                    (
                        FullName,
                        MobileNumber,
                        Email,
                        Specialization,
                        Password,
                        qualification,
                        experience,
                        hospital_detail,
                        timing,
                        images
                    )
                    VALUES
                    (
                        :fname,
                        :mobno,
                        :email,
                        :sid,
                        :password,
                        :qf,
                        :exp,
                        :hd,
                        :time,
                        :images
                    )";


                    $query = $dbh->prepare($sql);


                    $query->bindParam(
                        ':fname',
                        $fname,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':mobno',
                        $mobno,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':email',
                        $email,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':sid',
                        $sid,
                        PDO::PARAM_INT
                    );

                    $query->bindParam(
                        ':password',
                        $password,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':qf',
                        $qf,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':exp',
                        $exp,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':hd',
                        $hd,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':time',
                        $time,
                        PDO::PARAM_STR
                    );

                    $query->bindParam(
                        ':images',
                        $images,
                        PDO::PARAM_STR
                    );


                    if ($query->execute()) {

                        echo "<script>
                                alert('Doctor registered successfully.');
                                window.location.href='login.php';
                              </script>";

                    } else {

                        // Remove uploaded image if database insert fails
                        if (file_exists($uploadPath)) {
                            unlink($uploadPath);
                        }

                        echo "<script>
                                alert('Something went wrong. Please try again.');
                              </script>";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Signup Page</title>

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

</head>


<body
    class="simple-page"
    style="background-color:#44B4FF;"
>


<!-- Home Button -->

<div id="back-to-home">

    <a
        href="/./img/AppointDoc/index.php"
        style="
            font-size:15px;
            border:2px solid #E6EDF1;
            padding:8px 15px;
        "
    >
        Home
    </a>

</div>


<div class="simple-page-wrap">


    <div
        style="
            width:1000px;
            max-width:95%;
            margin:30px auto;
        "
    >


        <div
            class="simple-page-form animated flipInY"
            id="login-form"
        >

            <h4 class="form-title m-b-xl text-center">
                Sign Up With Your Account
            </h4>


            <form
                method="post"
                action=""
                enctype="multipart/form-data"
            >


                <!-- Full Name -->

                <div class="form-group">

                    <input
                        id="fname"
                        type="text"
                        class="form-control"
                        placeholder="Full Name"
                        name="fname"
                        required
                    >

                </div>


                <!-- Email -->

                <div class="form-group">

                    <input
                        id="email"
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        name="email"
                        required
                    >

                </div>


                <!-- Mobile -->

                <div class="form-group">

                    <input
                        id="mobno"
                        type="text"
                        class="form-control"
                        placeholder="Mobile"
                        name="mobno"
                        maxlength="10"
                        minlength="10"
                        pattern="[0-9]{10}"
                        required
                    >

                </div>


                <!-- Specialization -->

                <div class="form-group">

                    <select
                        class="form-control"
                        name="specializationid"
                        required
                    >

                        <option value="">
                            Choose Specialization
                        </option>


                        <?php

                        $sql1 = "SELECT ID, Specialization
                                 FROM tblspecialization
                                 ORDER BY Specialization ASC";

                        $query1 = $dbh->prepare($sql1);

                        $query1->execute();

                        $results1 =
                            $query1->fetchAll(PDO::FETCH_OBJ);


                        foreach ($results1 as $row1) {

                        ?>

                            <option
                                value="<?php echo htmlentities($row1->ID); ?>"
                            >
                                <?php
                                echo htmlentities(
                                    $row1->Specialization
                                );
                                ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>


                <!-- Qualification -->

                <div class="form-group">

                    <input
                        id="qf"
                        type="text"
                        class="form-control"
                        placeholder="Qualification"
                        name="qf"
                        required
                    >

                </div>


                <!-- Experience -->

                <div class="form-group">

                    <input
                        id="exp"
                        type="text"
                        class="form-control"
                        placeholder="Experience"
                        name="exp"
                        required
                    >

                </div>


                <!-- Hospital -->

                <div class="form-group">

                    <input
                        id="hd"
                        type="text"
                        class="form-control"
                        placeholder="Hospital Detail"
                        name="hd"
                        required
                    >

                </div>


                <!-- Doctor Image -->

                <div class="form-group">

                    <label>
                        Doctor Photo
                    </label>

                    <input
                        id="images"
                        type="file"
                        class="form-control"
                        name="images"
                        accept=".jpg,.jpeg,.png,.gif"
                        required
                    >

                </div>


                <!-- Timing -->

                <div class="form-group">

                    <input
                        id="time"
                        type="text"
                        class="form-control"
                        placeholder="Timing"
                        name="time"
                        required
                    >

                </div>


                <!-- Password -->

                <div class="form-group">

                    <input
                        id="password"
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        name="password"
                        minlength="6"
                        required
                    >

                </div>


                <!-- Register -->

                <input
                    type="submit"
                    class="btn btn-primary"
                    style="background-color:#44B4FF;"
                    value="Register"
                    name="submit"
                >

            </form>

        </div>


        <div class="simple-page-footer">

            <p>

                <small>
                    Do you have an account?
                </small>

                <a href="login.php">
                    SIGN IN
                </a>

            </p>

        </div>


    </div>

</div>

</body>

</html>