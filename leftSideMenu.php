<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$firstName = htmlspecialchars($_SESSION["first_name"]);
$currentuserid = $_SESSION["id"];
$role = $_SESSION["role"];

//Error checker for all pages


?>

<div id="navbarToggleExternalContent" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bonfire"></use></svg>
        <span class="fs-4">Bonfire</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <!-- Admin Section -->
        <?php
        if($role == "admin")
        {
            ?>
            <li class="nav-item">
                <a href="editClasses.php" class="nav-link text-white left-menu-item" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                    Manage Classes
                </a>
            </li>
            <li class="nav-item">
                <a href="editUsers.php" class="nav-link text-white left-menu-item" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                    Manage People
                </a>
            </li>
            <?php
        }
        ?>
        <li>
            <a href="dashboard.php" class="nav-link text-white left-menu-item">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                Dashboard
            </a>
        </li>
        <?php
            if($role == "student" || $role == "teacher" ){
        ?>
                <li>
                    <a href="allClasses.php" class="nav-link text-white left-menu-item">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                        All Classes
                    </a>
                </li>
                <li>
                    <a href="pastClasses.php" class="nav-link text-white left-menu-item">
                        <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                        Past Classes
                    </a>
                </li>
        <?php
            }
        ?>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="avatars/user-<?=$currentuserid?>.jpg" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?php echo $firstName; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <!--                <li><a class="dropdown-item" href="#">New project...</a></li>-->
            <!--                <li><a class="dropdown-item" href="#">Settings</a></li>-->
            <li><a class="dropdown-item" href="profile.php?userid=<?=$currentuserid ?>">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="reset-password.php">Reset Password</a></li>
            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
        </ul>
    </div>
</div>

<!--<nav class="navbar navbar-dark bg-dark">-->
<!--    <div class="container-fluid">-->
<!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">-->
<!--            <span class="navbar-toggler-icon"></span>-->
<!--        </button>-->
<!--    </div>-->
<!--</nav>-->