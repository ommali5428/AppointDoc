<?php

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointment Doctor</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/img/AppointDoc/css/style.css">
    <link rel="stylesheet" href="/img/AppointDoc/css/navbar.css">
    <link rel="stylesheet" href="/img/AppointDoc/css/profilelogo2.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Custom JS -->
    <script src="/img/AppointDoc/js/main.js"></script>
    <script src="/img/AppointDoc/js/java.js"></script>

    <style>
        header {
            width: 100%;
            top: 0;
        }
    </style>

</head>

<body>

<header style="box-shadow: .1rem .3rem rgba(0, 0, 0, .3);">

    <!-- Logo -->
    <a href="/img/AppointDoc/index.php" class="logo">
        <span>A</span>ppoint <span>D</span>oc.
    </a>

    <!-- Navbar -->
    <nav class="navbar">

        <ul>

            <li>
                <a href="/img/AppointDoc/index.php">Home</a>
            </li>

            <li>
                <a href="/img/AppointDoc/about.php">About Us</a>
            </li>

            <!-- Doctor Specialist -->
            <li>

                <div class="dropdown">

                    <button onclick="myFunction()" class="dropbtn">
                        Dr. Specialist
                    </button>

                    <div id="myDropdown" class="dropdown-content">

                        <?php

                        try {

                            $sql = "SELECT * FROM tblspecialization";
                            $stmt = $dbh->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                ?>

                                <a href="/img/AppointDoc/dr.php?id=<?php echo (int)$row['ID']; ?>">
                                    <?php echo htmlspecialchars($row['Specialization']); ?>
                                </a>

                                <?php
                            }

                        } catch (PDOException $e) {

                            echo "Unable to load specialists.";

                        }

                        ?>

                    </div>

                </div>

            </li>

            <li>
                <a href="/img/AppointDoc/appointment/check-appointment.php">
                    Check Appointment
                </a>
            </li>

            <li>
                <a href="/img/AppointDoc/appointment/bookappointment.php">
                    Book Appointment
                </a>
            </li>

            <li>
                <a href="/img/AppointDoc/feedback.php">
                    Feedback
                </a>
            </li>

            <li>
                <a href="/img/AppointDoc/appointment/dr_pannel/login.php">
                    Dr Panel
                </a>
            </li>

            <!-- User Profile -->
            <li>

                <?php if (!isset($_SESSION['user_name'])): ?>

                    <!-- NOT LOGGED IN -->

                    <div>

                        <img
                            src="/img/AppointDoc/drimages/profile.png"
                            class="user-pic"
                            onclick="toggleMenu()"
                            alt="Profile"
                        >

                        <div class="sub-menu-wrap" id="subMenu">

                            <div class="sub-menu">

                                <div class="user-info">

                                    <h2>Login or Signup</h2>

                                </div>

                                <hr>

                                <a href="/img/AppointDoc/login/login_form.php"
                                   class="sub-menu-link">

                                    <img
                                        src="/img/AppointDoc/drimages/profile.png"
                                        alt="Profile"
                                    >

                                    <p style="font-size:16px;">
                                        Profile
                                    </p>

                                    <span>></span>

                                </a>

                                <a href="/img/AppointDoc/login/login_form.php"
                                   class="sub-menu-link">

                                    <img
                                        src="/img/AppointDoc/drimages/setting.png"
                                        alt="Settings"
                                    >

                                    <p style="font-size:16px;">
                                        Settings
                                    </p>

                                    <span>></span>

                                </a>

                                <a href="/img/AppointDoc/login/login_form.php"
                                   class="sub-menu-link">

                                    <img
                                        src="/img/AppointDoc/drimages/login1.png"
                                        alt="Login"
                                    >

                                    <p style="font-size:16px;">
                                        Login
                                    </p>

                                    <span>></span>

                                </a>

                            </div>

                        </div>

                    </div>

                <?php else: ?>

                    <!-- LOGGED IN -->

                    <?php

                    $userName = $_SESSION['user_name'];

                    ?>

                    <div>

                        <img
                            src="/img/AppointDoc/drimages/profile.png"
                            class="user-pic"
                            onclick="toggleMenu()"
                            alt="Profile"
                        >

                        <div class="sub-menu-wrap" id="subMenu">

                            <div class="sub-menu">

                                <div class="user-info">

                                    <h2 style="font-size:15px;">

                                        <?php
                                        echo htmlspecialchars($userName);
                                        ?>

                                    </h2>

                                </div>

                                <hr>

                                <a href="/img/AppointDoc/user.php"
                                   class="sub-menu-link">

                                    <img
                                        src="/img/AppointDoc/drimages/profile.png"
                                        alt="Profile"
                                    >

                                    <p style="font-size:16px;">
                                        Profile
                                    </p>

                                    <span>></span>

                                </a>

                                <a href="/img/AppointDoc/setting.php"
                                   class="sub-menu-link">

                                    <img
                                        src="/img/AppointDoc/drimages/setting.png"
                                        alt="Settings"
                                    >

                                    <p style="font-size:16px;">
                                        Settings
                                    </p>

                                    <span>></span>

                                </a>

                                <a href="/img/AppointDoc/login/logout.php"
                                   class="sub-menu-link">

                                    <img
                                        src="/img/AppointDoc/drimages/logout.png"
                                        alt="Logout"
                                    >

                                    <p style="font-size:16px;">
                                        Logout
                                    </p>

                                    <span>></span>

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </li>

        </ul>

    </nav>

    <!-- Mobile menu -->
    <div class="fas fa-bars"></div>

</header>

<!-- Profile JavaScript -->
<script src="/img/AppointDoc/js/profile.js"></script>