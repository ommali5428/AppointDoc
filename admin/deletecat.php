<?php

session_start();

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

// Check admin login
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login_form.php');
    exit();
}

if (isset($_GET['deleteid'])) {

    $id = intval($_GET['deleteid']);

    if ($id > 0) {

        $query = "DELETE FROM tblspecialization WHERE ID = ?";
        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {

            header('Location: categories.php');
            exit();

        } else {

            echo "Something went wrong. Please try again.";
        }

        mysqli_stmt_close($stmt);

    } else {

        echo "Invalid category ID.";
    }
}
?>