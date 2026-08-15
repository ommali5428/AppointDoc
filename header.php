<?php

// Start session before any HTML/output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
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
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/profilelogo2.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="/js/main.js"></script>
    <script src="/js/java.js"></script>

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
    <a href="/index.php" class="logo">
        <span>A</span>ppoint <span>D</span>oc.
    </a>

    <!-- Navigation -->
    <nav class="navbar">

        <ul>

            <!-- Home -->
            <li>
                <a href="/index.php">Home</a>
            </li>

            <!-- About -->
            <li>
                <a href="/about.php">About Us</a>
            </li>

            <!-- Doctor Specialist -->
            <li>

                <div class="dropdown">

                    <button
                        type="button"
                        onclick="myFunction()"
                        class="dropbtn"
                    >
                        Dr. Specialist
                    </button>

                    <div id="myDropdown" class="dropdown-content">

                        <?php

                        try {

                            $sql = "SELECT * FROM tblspecialization";
                            $stmt = $dbh->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                $specializationId = (int)($row['ID'] ?? 0);

                                $specializationName = htmlspecialchars(
                                    $row['Specialization'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                                if ($specializationId > 0 && $specializationName !== '') {
                                    ?>

                                    <a href="/dr.php?id=<?php echo $specializationId; ?>">
                                        <?php echo $specializationName; ?>
                                    </a>

                                    <?php
                                }
                            }

                        } catch (PDOException $e) {

                            echo '<span>Unable to load specialists.</span>';

                        }

                        ?>

                    </div>

                </div>

            </li>

            <!-- Check Appointment -->
            <li>
                <a href="/appointment/check-appointment.php">
                    Check Appointment
                </a>
            </li>

            <!-- Book Appointment -->
            <li>
                <a href="/appointment/bookappointment.php">
                    Book Appointment
                </a>
            </li>

            <!-- Feedback -->
            <li>
                <a href="/feedback.php">
                    Feedback
                </a>
            </li>

            <!-- Doctor Panel -->
            <li>
                <a href="/appointment/dr_pannel/login.php">
                    Dr Panel
                </a>
            </li>

            <!-- User Profile -->
            <li>

                <?php if (!isset($_SESSION['user_name'])): ?>

                    <!-- NOT LOGGED IN -->

                    <div class="profile-container">

                        <img
                            src="/drimages/profile.png"
                            class="user-pic"
                            onclick="toggleMenu()"
                            alt="Profile"
                        >

                        <div class="sub-menu-wrap" id="subMenu">

                            <div class="sub-menu">

                                <div class="user-info">

                                    <h2>
                                        Login or Signup
                                    </h2>

                                </div>

                                <hr>

                                <!-- Profile -->
                                <a
                                    href="/login/login_form.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/drimages/profile.png"
                                        alt="Profile"
                                    >

                                    <p>
                                        Profile
                                    </p>

                                    <span>&gt;</span>

                                </a>

                                <!-- Settings -->
                                <a
                                    href="/login/login_form.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/drimages/setting.png"
                                        alt="Settings"
                                    >

                                    <p>
                                        Settings
                                    </p>

                                    <span>&gt;</span>

                                </a>

                                <!-- Login -->
                                <a
                                    href="/login/login_form.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/drimages/login1.png"
                                        alt="Login"
                                    >

                                    <p>
                                        Login
                                    </p>

                                    <span>&gt;</span>

                                </a>

                            </div>

                        </div>

                    </div>

                <?php else: ?>

                    <!-- LOGGED IN -->

                    <?php

                    $userName = $_SESSION['user_name'] ?? 'User';

                    ?>

                    <div class="profile-container">

                        <img
                            src="/drimages/profile.png"
                            class="user-pic"
                            onclick="toggleMenu()"
                            alt="Profile"
                        >

                        <div class="sub-menu-wrap" id="subMenu">

                            <div class="sub-menu">

                                <div class="user-info">

                                    <h2>

                                        <?php
                                        echo htmlspecialchars(
                                            $userName,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                        ?>

                                    </h2>

                                </div>

                                <hr>

                                <!-- Profile -->
                                <a
                                    href="/user.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/drimages/profile.png"
                                        alt="Profile"
                                    >

                                    <p>
                                        Profile
                                    </p>

                                    <span>&gt;</span>

                                </a>

                                <!-- Settings -->
                                <a
                                    href="/setting.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/drimages/setting.png"
                                        alt="Settings"
                                    >

                                    <p>
                                        Settings
                                    </p>

                                    <span>&gt;</span>

                                </a>

                                <!-- Logout -->
                                <a
                                    href="/login/logout.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/drimages/logout.png"
                                        alt="Logout"
                                    >

                                    <p>
                                        Logout
                                    </p>

                                    <span>&gt;</span>

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </li>

        </ul>

    </nav>

    <!-- Mobile Menu Button -->
    <div class="fas fa-bars"></div>

</header>

<!-- Profile JavaScript -->
<script src="/js/profile.js"></script>