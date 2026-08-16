<?php
/*
|--------------------------------------------------------------------------
| Admin Sidebar
|--------------------------------------------------------------------------
| This file is included from admin/dashboard.php and other admin pages.
| conn.php is already loaded by the parent page.
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$adminName = '';
$adminEmail = '';

/*
|--------------------------------------------------------------------------
| Get logged-in admin information
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {

    $adminId = (int) $_SESSION['admin'];

    $sql = "SELECT name, email FROM user_form WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "i", $adminId);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            $adminName = $row['name'];
            $adminEmail = $row['email'];
        }

        mysqli_stmt_close($stmt);
    }
}

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

if (empty($adminName)) {
    $adminName = $_SESSION['admin_name'] ?? 'Admin';
}

if (empty($adminEmail)) {
    $adminEmail = $_SESSION['aem'] ?? '';
}

?>

<aside id="menubar" class="menubar light">

    <!-- =========================================================
         ADMIN USER
    ========================================================== -->

    <div class="app-user">

        <div class="media">

            <div class="media-left">

                <div class="avatar avatar-md avatar-circle">

                    <img
                        class="img-responsive"
                        src="images/images.png"
                        alt="avatar"
                    >

                </div>

            </div>


            <div class="media-body">

                <div class="foldable">

                    <h5>
                        <a
                            href="javascript:void(0)"
                            class="username"
                        >
                            <?php echo htmlspecialchars($adminName); ?>
                        </a>
                    </h5>


                    <ul>

                        <li class="dropdown">

                            <a
                                href="javascript:void(0)"
                                class="dropdown-toggle usertitle"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >

                                <small>
                                    <?php echo htmlspecialchars($adminEmail); ?>
                                </small>

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         SIDEBAR MENU
    ========================================================== -->

    <div class="menubar-scroll">

        <div class="menubar-scroll-inner">

            <ul class="app-menu">


                <!-- PROFILE -->

                <li>

                    <a href="profile.php">

                        <i class="fa fa-user"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 9px;"
                        >
                            Profile
                        </span>

                    </a>

                </li>


                <!-- DASHBOARD -->

                <li>

                    <a href="dashboard.php">

                        <i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 7px;"
                        >
                            Dashboard
                        </span>

                    </a>

                </li>


                <!-- APPOINTMENT -->

                <li class="has-submenu">

                    <a
                        href="javascript:void(0)"
                        class="submenu-toggle"
                    >

                        <i class="zmdi zmdi-pages zmdi-hc-lg"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 7px;"
                        >
                            Appointment
                        </span>

                        <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>

                    </a>


                    <ul class="submenu">

                        <li>

                            <a href="approved-appointment.php">

                                <span class="menu-text">
                                    Approved Appointment
                                </span>

                            </a>

                        </li>


                        <li>

                            <a href="cancelled-appointment.php">

                                <span class="menu-text">
                                    Cancelled Appointment
                                </span>

                            </a>

                        </li>


                        <li>

                            <a href="all-appointment.php">

                                <span class="menu-text">
                                    All Appointment
                                </span>

                            </a>

                        </li>

                    </ul>

                </li>


                <!-- CATEGORIES -->

                <li>

                    <a href="categories.php">

                        <i class="zmdi zmdi-search zmdi-hc-lg"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 7px;"
                        >
                            Categories
                        </span>

                    </a>

                </li>


                <!-- NEW DOCTOR -->

                <li>

                    <a href="addprofile.php">

                        <i class="zmdi zmdi-layers zmdi-hc-lg"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 7px;"
                        >
                            New Doctor
                        </span>

                    </a>

                </li>


                <!-- DOCTOR PROFILE -->

                <li>

                    <a href="doctorprofile.php">

                        <i class="zmdi zmdi-layers zmdi-hc-lg"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 7px;"
                        >
                            Doctor Profile
                        </span>

                    </a>

                </li>


                <!-- SETTINGS -->

                <li>

                    <a href="change-password.php">

                        <i class="fa fa-gear"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 9px;"
                        >
                            Settings
                        </span>

                    </a>

                </li>


                <!-- LOGOUT -->

                <li>

                    <a href="../login/logout.php">

                        <i class="fa fa-power-off"></i>

                        <span
                            class="menu-text"
                            style="margin-left: 9px;"
                        >
                            Logout
                        </span>

                    </a>

                </li>


            </ul>

        </div>

    </div>

</aside>