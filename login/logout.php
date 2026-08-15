<?php

include('C:\xampp\htdocs\img\AppointDoc\conn.php');
session_start();
session_unset();
session_destroy();

header('location:/./img/AppointDoc/index.php');

?>