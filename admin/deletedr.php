<?php

session_start();
include('C:\xampp\htdocs\img\AppointDoc\conn.php');

if (isset($_GET['deleteid'])) {

    $id = intval($_GET['deleteid']);

    if ($id > 0) {

        $query = "DELETE FROM tbldoctor WHERE ID = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: doctorprofile.php");
            exit();
        } else {
            die("Error deleting doctor: " . mysqli_error($conn));
        }

    } else {
        die("Invalid doctor ID.");
    }

} else {
    header("Location: doctorprofile.php");
    exit();
}

?>