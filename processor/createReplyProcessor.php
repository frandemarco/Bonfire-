<?php
require_once "../config.php";
session_start();
$pdo = getDBConnection();


$announcementid = $_POST['annid'];
$userId = $_SESSION["id"];
$announcement = $_POST["inputReply"];


date_default_timezone_set("America/New_York");
$date = date("Y-m-d H:i:s");

var_dump($_POST);
var_dump($_SESSION);
$sql="Insert into comments(announcement_id, user_id, text, date)
values(:announcement_id, :user_id, :text, :date)";
try {
    echo "Starting try";
    if ($stmt = $pdo->prepare($sql)) {
        echo "prepared statement";
        $stmt->bindParam(":announcement_id", $announcementid, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":text", $announcement, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        if($stmt->execute()){
            header("location: ../viewAnnouncement.php?status=Replied%20to%20Announcement&announcementid=$announcementid ");
        }
    }
    else {
        header("location: ../viewAnnouncement.php?status=Failed%20to%20Reply%20to%20Announcement&announcementid=$announcementid "); //add a parameter here with a failure statmenet
    }
}
catch(PDOException $e) {
    echo $e->getMessage();
}
?>
