<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$role = $_SESSION["role"];

?>

<nav class="navbar bg-dark  bg-gradient">
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills me-auto mb-2 mb-lg-0">
                <li class="nav-item btn btn-outline-secondary">
                  <a href="class.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link" aria-current="page">Class Home</a>
                </li>
                <li class="nav-item btn btn-outline-secondary">
                  <a href="announcements.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link">Announcements</a>
                </li>
                <li class="nav-item btn btn-outline-secondary">
                  <a href="assignments.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link">Assignments</a>
                </li>
                <?php 
                  if($role == "teacher" || $role == "admin")
                  { 
                  ?> 
                    <li  class="nav-item btn btn-outline-secondary">
                      <a href="viewStudentGrades.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link">Grades</a>
                    </li> 
                  <?php 
                   }
                   if($role == "student")
                   { 
                   ?>
                      <li class="nav-item btn btn-outline-secondary">
                        <a href="viewGrades.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link">Grades</a>
                      </li>
                   <?php 
                   } 
                   ?>
                <li class="nav-item btn btn-outline-secondary">
                  <a href="classRoster.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link">People</a>
                </li>
                <li class="nav-item btn btn-outline-secondary">
                  <a href="syllabus.php?classid=<?= $_SESSION["currentclass"] ?> "class="nav-link">Syllabus</a>
                </li>
                <li class="nav-item btn btn-outline-secondary">
                  <a href="classFiles.php?classid=<?= $_SESSION["currentclass"] ?> "class="nav-link">Files</a>
                </li>
                <?php
                  if($role == "teacher")
                  {
                  ?>
                      <li class="nav-item btn btn-outline-secondary">
                        <a href="classSettings.php?classid=<?= $_SESSION["currentclass"] ?>" class="nav-link">settings</a>
                      </li>
                  <?php
                  }
                ?>
            </ul>
        </header>
    </div>
</nav>