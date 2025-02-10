<?php
require_once "../config.php";
session_start();
$pdo = getDBConnection();

$classid = $_SESSION["currentclass"];
$teacherid = $_SESSION["id"];
$titlename = $_POST["inputTitle"];
$announcement = $_POST["inputAnnouncement"];
date_default_timezone_set("America/New_York");
$date = date("Y-m-d H:i:s");

var_dump($_POST);
$sql="Insert into announcements(class_id, teacher_id, body, title, date)
values(:class_id, :teacher_id, :body, :title, :date)";
try {
//    echo "Starting try";
    if ($stmt = $pdo->prepare($sql)) {
//        echo "prepared statement";
        $stmt->bindParam(":class_id", $classid, PDO::PARAM_INT);
        $stmt->bindParam(":teacher_id", $teacherid, PDO::PARAM_INT);
        $stmt->bindParam(":body", $announcement, PDO::PARAM_STR);
        $stmt->bindParam(":title", $titlename, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        if($stmt->execute()){
            header("location: ../announcements.php?status=Successfully%20Created%20Announcement");
        }
    }
    else {
        header("location: ../announcements.php?status=Failed%20to%20Create%20Announcement"); //add a parameter here with a failure statmenet
    }
}
catch(PDOException $e) {
    echo $e->getMessage();
}
?>
