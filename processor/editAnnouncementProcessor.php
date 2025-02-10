<?php
require_once "../config.php";
$pdo = getDBConnection();

$id = $_POST["id"];
$titlename = $_POST["inputTitle"];
$announcement = $_POST["inputAnnouncement"];
//var_dump($_POST);

$sql="UPDATE announcements
          SET title = :title,
              body = :body
          WHERE id = :id";

if($stmt = $pdo->prepare($sql)) {
    if ($stmt = $pdo->prepare($sql)) {
//        echo "prepared statement";
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $titlename, PDO::PARAM_STR);
        $stmt->bindParam(":body", $announcement, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "success";
            header("location: ../announcements.php?status=success");
        }
        else{
            header("location: ../announcements.php?status=failure"); //add a parameter here with a failure statmenet
        }
    }
}
var_dump($stmt);
?>