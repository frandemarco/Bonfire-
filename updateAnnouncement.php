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
$currentclass = $_GET["class_name"];
$announcementid = $_GET["announcementid"];

$pdo = getDBConnection();

$sql = "SELECT * FROM announcements where id = :id";

if($stmt = $pdo->prepare($sql)) {
// Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id", $announcementid, PDO::PARAM_INT);
// Attempt to execute the prepared statement

    if ($stmt->execute()) {
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()) {
                $id = $row["id"];
                $title = $row["title"];
                $body = $row["body"];
            }
        }
    }
}

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
    <title><?=$className ?> Update Announcements</title>
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
    <div id="primary-window" class="d-flex overflow-y-scroll flex-column flex-shrink-0 p-3 text-bg-dark align-items-center ">
        <?php include("classTopMenu.php"); ?>
        <h1 class="my-5">Update Announcement</h1>
        <div>
            <form action="processor/editAnnouncementProcessor.php?classid=<?= $_SESSION["currentclass"] ?>" method="post" class="align-content-center">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTitle" style="font-size: 45px; text-align: center;">Announcement Title</label>
                        <input type="text" name="inputTitle" class="form-control" id="inputTitle" value="<?= $title?>" placeholder="Enter announcement Title..." style="width: 1000px; text-align: center;">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAnnouncement" style="font-size: 50px; text-align: center;">Announcement</label>
                        <textarea name="inputAnnouncement" class="form-control" id="inputAnnouncement" placeholder="Enter Announcement..." rows="5" cols="40" style="width: 1000px; text-align: center;"><?= $body?></textarea>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?= $announcementid ?>">
                <button type="submit" class="btn btn-primary">Update Announcement</button>
            </form>
        </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body>
</html>