<?php
require_once "../config.php";
$pdo = getDBConnection();

$id = $_GET["id"];

var_dump($_GET);

$sql="DELETE FROM files WHERE id = :id";

if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("location: ../classFiles.php?status=File%20Successfully%20Deleted!");
    }
    else{
        header("location: ../classFiles.php?status=Error%20Deleting%20File!");
    }
}
else
{
    header("location: ../classFiles.php?status=Error%20Deleting%20File!");
}
?>
