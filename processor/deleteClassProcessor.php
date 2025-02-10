<?php
require_once "../config.php";
$pdo = getDBConnection();

$id = $_POST["id"];


//$sql="DELETE FROM classes
//          WHERE id = :id";
$sql = "Update classes
set is_active = 0
where id = :id";
if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("location: ../editClasses.php?status=Class%20Successfully%20Archived!");
    }
    else{
        header("location: ../editClasses.php?status=Error%20Archiving%20Class!");
    }
}
else
{
    header("location: ../editClasses.php?status=Error%20Archiving%20Class!");
}
?>
