<?php
require_once "../config.php";
$pdo = getDBConnection();

$id = $_POST["id"];


//$sql="DELETE FROM users
//          WHERE id = :id";
$sql = "Update users
set is_active = 0
where id = :id";

if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("location: ../editUsers.php?status=User%20Successfully%20Archived!");
    }else {
        header("location: ../editUsers.php?status=Error%20Archiving%20Users!");
    }
}
?>