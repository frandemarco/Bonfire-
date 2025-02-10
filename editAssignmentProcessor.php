<?php
require_once "config.php";
$pdo = getDBConnection();

$id = $_POST["id"];
$assignmentname =$_POST["inputAssignment"];
$maxgrade=$_POST["inputMaxGrade"];
$descript =$_POST["inputDescription"];
$ddate= $_POST["inputDueDate"];
$categ =$_POST["inputAssigmentCategory"];

$sql="UPDATE assignments
          SET assignment_name = :assignment_name,
              max_grade = :max_grade,
              description = :description,
              due_date = :due_date,
              category = :category
          WHERE id = :id";

if($stmt = $pdo->prepare($sql)) {
    if ($stmt = $pdo->prepare($sql)) {
        echo "prepared statement";
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":assignment_name", $assignmentname, PDO::PARAM_STR);
        $stmt->bindParam(":max_grade", $maxgrade, PDO::PARAM_INT);
        $stmt->bindParam(":description", $descript, PDO::PARAM_STR);
        $stmt->bindParam(":due_date", $ddate, PDO::PARAM_STR);
        $stmt->bindParam(":category", $categ, PDO::PARAM_STR);
        if ($stmt->execute()) {
            header("location: ./assignments.php?status=?status=Assignment%20Successfully%20Edited");
        }else{
            header("location: ./assignments.php?status=?status=Failed%20Editing%20Assignment");
        }
    }
}
?>