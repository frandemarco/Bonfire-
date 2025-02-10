<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "teacher"){
    header("location: login.php");
    exit;
}

$firstName = htmlspecialchars($_SESSION["first_name"]);
$role = $_SESSION["role"];

$pdo = getDBConnection();

$sql2 = "Select * from classes where id = :id";
if($stmt2=$pdo->prepare($sql2))
{
    $stmt2->bindParam(":id", $param_id, PDO::PARAM_INT);
    $param_id  = $_GET["classid"];
    if($stmt2->execute())
    {
        if($stmt2->rowCount() == 1) {
            if ($row2 = $stmt2->fetch()) {
                $className = $row2["class_name"];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $className ?> Create Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/stylesheets/style.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php include("svgImages.html"); ?>
<main class="d-flex flex-nowrap">
    <?php include("leftSideMenu.php"); ?>
    <div id="primary-window" class="d-flex overflow-y-scroll flex-column flex-shrink-0 p-3 text-bg-dark ">
        <?php include("classTopMenu.php"); ?>
        <h1 class="my-5">Create Announcement</h1>
        <div>
            <form action="processor/createAnnouncementProcessor.php?classid=<?= $_SESSION["currentclass"] ?>"method="post" class="align-content-center">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTitle">Announcement Title</label>
                        <input type="text" name="inputTitle" class="form-control" id="inputTitle" placeholder="Enter announcement Title...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAnnouncement">Announcement</label>
                        <textarea name="inputAnnouncement" class="form-control" id="inputAnnouncement" placeholder="Enter Announcement..." rows="5" cols="40"></textarea>
                    </div>
                </div>
<!--                <div class="form-row">-->
<!--                    <div class="form-group col-md-6">-->
<!--                        <label for="inputTodayDate">Todays Date</label>-->
<!--                        <input type="datetime-local" name = "inputTodayDate" class="form-control" id="inputDueDate" value="datetime-local" >-->
<!--                    </div>-->
<!--                </div>-->
                <button type="submit" class="btn btn-primary">Post Announcement</button>
            </form>
        </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>