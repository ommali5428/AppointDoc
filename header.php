<?php

// ==========================================
// SESSION
// ==========================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==========================================
// DATABASE CONNECTION
// ==========================================
require_once __DIR__ . '/conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointment Doctor</title>

    <!-- ==========================================
         FONT AWESOME
    =========================================== -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <!-- ==========================================
         CUSTOM CSS
         Your CSS files are inside /img/AppointDoc/
    =========================================== -->

    <link
        rel="stylesheet"
        href="/img/AppointDoc/css/style.css"
    >

    <link
        rel="stylesheet"
        href="/img/AppointDoc/css/navbar.css"
    >

    <link
        rel="stylesheet"
        href="/img/AppointDoc/css/profilelogo2.css"
    >

    <!-- ==========================================
         JQUERY
    =========================================== -->

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js">
    </script>

    <!-- ==========================================
         CUSTOM JAVASCRIPT
    =========================================== -->

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

    <!-- ==========================================
         LOGO
    =========================================== -->

    <a
        href="/img/AppointDoc/index.php"
        class="logo"
    >
        <span>A</span>ppoint <span>D</span>oc.
    </a>


    <!-- ==========================================
         NAVBAR
    =========================================== -->

    <nav class="navbar">

        <ul>

            <!-- HOME -->

            <li>

                <a href="/img/AppointDoc/index.php">
                    Home
                </a>

            </li>


            <!-- ABOUT -->

            <li>

                <a href="/img/AppointDoc/about.php">
                    About Us
                </a>

            </li>


            <!-- ==========================================
                 DOCTOR SPECIALIST
            =========================================== -->

            <li>

                <div class="dropdown">

                    <button
                        onclick="myFunction()"
                        class="dropbtn"
                        type="button"
                    >
                        Dr. Specialist
                    </button>


                    <div
                        id="myDropdown"
                        class="dropdown-content"
                    >

                        <?php

                        try {

                            $sql = "SELECT * FROM tblspecialization";

                            $stmt = $dbh->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                $specializationId =
                                    isset($row['ID'])
                                    ? (int)$row['ID']
                                    : 0;

                                $specializationName =
                                    htmlspecialchars(
                                        $row['Specialization'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                if ($specializationId > 0) {

                                    ?>

                                    <a
                                        href="/img/AppointDoc/dr.php?id=<?php echo $specializationId; ?>"
                                    >
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


            <!-- CHECK APPOINTMENT -->

            <li>

                <a
                    href="/img/AppointDoc/appointment/check-appointment.php"
                >
                    Check Appointment
                </a>

            </li>


            <!-- BOOK APPOINTMENT -->

            <li>

                <a
                    href="/img/AppointDoc/appointment/bookappointment.php"
                >
                    Book Appointment
                </a>

            </li>


            <!-- FEEDBACK -->

            <li>

                <a href="/img/AppointDoc/feedback.php">
                    Feedback
                </a>

            </li>


            <!-- DOCTOR PANEL -->

            <li>

                <a
                    href="/img/AppointDoc/appointment/dr_pannel/login.php"
                >
                    Dr Panel
                </a>

            </li>


            <!-- ==========================================
                 USER PROFILE
            =========================================== -->

            <li>

                <?php if (!isset($_SESSION['user_name'])): ?>

                    <!-- ==================================
                         NOT LOGGED IN
                    =================================== -->

                    <div>

                        <img
                            src="/img/AppointDoc/drimages/profile.png"
                            class="user-pic"
                            onclick="toggleMenu()"
                            alt="Profile"
                        >


                        <div
                            class="sub-menu-wrap"
                            id="subMenu"
                        >

                            <div class="sub-menu">

                                <div class="user-info">

                                    <h2>
                                        Login or Signup
                                    </h2>

                                </div>


                                <hr>


                                <!-- PROFILE -->

                                <a
                                    href="/img/AppointDoc/login/login_form.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/img/AppointDoc/drimages/profile.png"
                                        alt="Profile"
                                    >

                                    <p style="font-size:16px;">
                                        Profile
                                    </p>

                                    <span>&gt;</span>

                                </a>


                                <!-- SETTINGS -->

                                <a
                                    href="/img/AppointDoc/login/login_form.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/img/AppointDoc/drimages/setting.png"
                                        alt="Settings"
                                    >

                                    <p style="font-size:16px;">
                                        Settings
                                    </p>

                                    <span>&gt;</span>

                                </a>


                                <!-- LOGIN -->

                                <a
                                    href="/img/AppointDoc/login/login_form.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/img/AppointDoc/drimages/login1.png"
                                        alt="Login"
                                    >

                                    <p style="font-size:16px;">
                                        Login
                                    </p>

                                    <span>&gt;</span>

                                </a>

                            </div>

                        </div>

                    </div>


                <?php else: ?>


                    <!-- ==================================
                         LOGGED IN
                    =================================== -->

                    <?php

                    $userName = $_SESSION['user_name'] ?? '';

                    ?>

                    <div>

                        <img
                            src="/img/AppointDoc/drimages/profile.png"
                            class="user-pic"
                            onclick="toggleMenu()"
                            alt="Profile"
                        >


                        <div
                            class="sub-menu-wrap"
                            id="subMenu"
                        >

                            <div class="sub-menu">


                                <div class="user-info">

                                    <h2 style="font-size:15px;">

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


                                <!-- PROFILE -->

                                <a
                                    href="/img/AppointDoc/user.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/img/AppointDoc/drimages/profile.png"
                                        alt="Profile"
                                    >

                                    <p style="font-size:16px;">
                                        Profile
                                    </p>

                                    <span>&gt;</span>

                                </a>


                                <!-- SETTINGS -->

                                <a
                                    href="/img/AppointDoc/setting.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/img/AppointDoc/drimages/setting.png"
                                        alt="Settings"
                                    >

                                    <p style="font-size:16px;">
                                        Settings
                                    </p>

                                    <span>&gt;</span>

                                </a>


                                <!-- LOGOUT -->

                                <a
                                    href="/img/AppointDoc/login/logout.php"
                                    class="sub-menu-link"
                                >

                                    <img
                                        src="/img/AppointDoc/drimages/logout.png"
                                        alt="Logout"
                                    >

                                    <p style="font-size:16px;">
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


    <!-- ==========================================
         MOBILE MENU
    =========================================== -->

    <div class="fas fa-bars"></div>

</header>


<!-- ==========================================
     PROFILE JAVASCRIPT
=========================================== -->

<script src="/img/AppointDoc/js/profile.js"></script>