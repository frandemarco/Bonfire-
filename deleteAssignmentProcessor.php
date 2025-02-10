<?php
require_once "config.php";
$pdo = getDBConnection();

$id = $_POST["id"];


//$sql="DELETE FROM assignments
//          WHERE id = :id";
$sql = "Update assignments
set is_active = 0
where id = :id";

if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("location: assignments.php?status=Assignment%20Successfully%20Deleted");
    }else{
        header("location: assignments.php?status=Assignment%20Failed%20to%20Delete");
    }
}
?>
