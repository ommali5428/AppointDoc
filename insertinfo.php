<?php

require_once __DIR__ . '/conn.php';


// ==========================================
// INSERT DOCTOR
// ==========================================

if (isset($_POST['insert'])) {


    $name = trim($_POST['name'] ?? '');

    $mobile = trim($_POST['mobile'] ?? '');

    $email = trim($_POST['email'] ?? '');

    $specialization = (int)(
        $_POST['specialization'] ?? 0
    );

    $password = trim($_POST['password'] ?? '');

    $qualification = trim(
        $_POST['qf'] ?? ''
    );

    $experience = trim(
        $_POST['ex'] ?? ''
    );

    $hospital = trim(
        $_POST['hd'] ?? ''
    );

    $timing = trim(
        $_POST['time'] ?? ''
    );


    // ==========================================
    // VALIDATION
    // ==========================================

    if (
        $name === '' ||
        $mobile === '' ||
        $email === '' ||
        $specialization <= 0
    ) {

        echo "<script>
                alert('Please fill all required fields.');
              </script>";

    } elseif (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        echo "<script>
                alert('Invalid email address.');
              </script>";

    } elseif (
        !isset($_FILES['images']) ||
        $_FILES['images']['error'] !== UPLOAD_ERR_OK
    ) {

        echo "<script>
                alert('Please select a doctor image.');
              </script>";

    } else {


        // ==========================================
        // IMAGE
        // ==========================================

        $originalName =
            $_FILES['images']['name'];

        $tmpName =
            $_FILES['images']['tmp_name'];

        $extension =
            strtolower(
                pathinfo(
                    $originalName,
                    PATHINFO_EXTENSION
                )
            );


        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp'
        ];


        if (
            !in_array(
                $extension,
                $allowedExtensions,
                true
            )
        ) {

            echo "<script>
                    alert(
                        'Invalid image format. Allowed: JPG, JPEG, PNG, GIF, WEBP.'
                    );
                  </script>";

        } else {


            // ==========================================
            // IMAGE DIRECTORY
            // ==========================================

            $uploadDirectory =
                __DIR__ .
                '/appointment/dr_pannel/images/';


            if (!is_dir($uploadDirectory)) {

                mkdir(
                    $uploadDirectory,
                    0755,
                    true
                );

            }


            // ==========================================
            // UNIQUE IMAGE NAME
            // ==========================================

            $imageName =
                md5(
                    uniqid(
                        $originalName,
                        true
                    )
                ) .
                time() .
                '.' .
                $extension;


            $destination =
                $uploadDirectory .
                $imageName;


            if (
                !move_uploaded_file(
                    $tmpName,
                    $destination
                )
            ) {

                echo "<script>
                        alert(
                            'Unable to upload image.'
                        );
                      </script>";

            } else {


                // ==========================================
                // PASSWORD
                // ==========================================

                $hashedPassword =
                    md5($password);


                try {


                    $stmt = $dbh->prepare(
                        "INSERT INTO tbldoctor
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
                            images,
                            CreationDate
                        )
                        VALUES
                        (
                            :name,
                            :mobile,
                            :email,
                            :specialization,
                            :password,
                            :qualification,
                            :experience,
                            :hospital,
                            :timing,
                            :images,
                            NOW()
                        )"
                    );


                    $stmt->bindParam(
                        ':name',
                        $name,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':mobile',
                        $mobile,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':email',
                        $email,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':specialization',
                        $specialization,
                        PDO::PARAM_INT
                    );

                    $stmt->bindParam(
                        ':password',
                        $hashedPassword,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':qualification',
                        $qualification,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':experience',
                        $experience,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':hospital',
                        $hospital,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':timing',
                        $timing,
                        PDO::PARAM_STR
                    );

                    $stmt->bindParam(
                        ':images',
                        $imageName,
                        PDO::PARAM_STR
                    );


                    $stmt->execute();


                    echo "<script>
                            alert(
                                'Doctor details have been submitted.'
                            );
                            window.location.href='/insertinfo.php';
                          </script>";

                    exit;


                } catch (PDOException $e) {


                    // Remove uploaded image if database insert fails

                    if (file_exists($destination)) {

                        unlink($destination);

                    }


                    echo "<script>
                            alert(
                                'Something went wrong. Please try again.'
                            );
                          </script>";

                }

            }

        }

    }

}


// ==========================================
// GET SPECIALIZATIONS
// ==========================================

$specializations = [];

try {

    $stmt = $dbh->query(
        "SELECT ID, Specialization
         FROM tblspecialization
         ORDER BY ID ASC"
    );

    $specializations =
        $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $specializations = [];

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

    <title>Add Doctor - Appoint Doc</title>

</head>

<body>


<form
    method="post"
    enctype="multipart/form-data"
>


<table
    border="1"
    cellpadding="10"
    cellspacing="0"
    align="center"
>


    <tr>

        <th colspan="2">
            Add Doctor
        </th>

    </tr>


    <tr>

        <td>Name</td>

        <td>

            <input
                type="text"
                name="name"
                required
            >

        </td>

    </tr>


    <tr>

        <td>Mobile Number</td>

        <td>

            <input
                type="text"
                name="mobile"
                required
            >

        </td>

    </tr>


    <tr>

        <td>Email</td>

        <td>

            <input
                type="email"
                name="email"
                required
            >

        </td>

    </tr>


    <tr>

        <td>Specialization</td>

        <td>

            <select
                name="specialization"
                required
            >

                <option value="">
                    Select Specialization
                </option>


                <?php foreach (
                    $specializations
                    as $specialization
                ): ?>

                    <option
                        value="<?php
                            echo (int)$specialization['ID'];
                        ?>"
                    >

                        <?php
                        echo htmlspecialchars(
                            $specialization['Specialization'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </td>

    </tr>


    <tr>

        <td>Password</td>

        <td>

            <input
                type="password"
                name="password"
            >

        </td>

    </tr>


    <tr>

        <td>Qualification</td>

        <td>

            <textarea
                name="qf"
                required
            ></textarea>

        </td>

    </tr>


    <tr>

        <td>Experience</td>

        <td>

            <input
                type="text"
                name="ex"
            >

        </td>

    </tr>


    <tr>

        <td>Hospital Details</td>

        <td>

            <textarea
                name="hd"
            ></textarea>

        </td>

    </tr>


    <tr>

        <td>Timing</td>

        <td>

            <textarea
                name="time"
            ></textarea>

        </td>

    </tr>


    <tr>

        <td>Image</td>

        <td>

            <input
                type="file"
                name="images"
                accept=".jpg,.jpeg,.png,.gif,.webp"
                required
            >

        </td>

    </tr>


    <tr>

        <td colspan="2" align="center">

            <input
                type="submit"
                name="insert"
                value="Insert"
            >

        </td>

    </tr>


</table>

</form>


</body>

</html>