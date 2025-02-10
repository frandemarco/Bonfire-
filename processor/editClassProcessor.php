<?php
require_once "../config.php";
$pdo = getDBConnection();

$id = $_POST["id"];
$cname =$_POST["cname"];
$teacherID=$_POST["teacher"];
$sdate =$_POST["sdate"];
$edate= $_POST["edate"];
$term =$_POST["term"];
$students = $_POST["students"];

$sql="UPDATE classes
          SET class_name = :class_name,
              teacher_id = :teacher_id,
              start_date = :start_date,
              end_date = :end_date,
              term = :term
          WHERE id = :id";

if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":class_name", $cname, PDO::PARAM_STR);
    $stmt->bindParam(":teacher_id", $teacherID, PDO::PARAM_INT);
    $stmt->bindParam(":start_date", $sdate, PDO::PARAM_STR);
    $stmt->bindParam(":end_date", $edate, PDO::PARAM_STR);
    $stmt->bindParam(":term", $term, PDO::PARAM_STR);
//    if($stmt->execute())
//    {
//        header("location: editClasses.php");
//    }
    if($stmt->execute())
    {
//        echo "<p> First Stmt Executed</p><ol>";
        #Class should be created
        //$lastId = $pdo->lastInsertId();
        //echo $lastId;

        foreach($students as $student)
        {
//            echo "<li><ol>";
//            echo "<li> Working on student $student</li>";
            $studentSql = "Insert into course_grades (class_id, user_id)
                            VALUES(:class_id, :user_id)";
            if($studentStmt = $pdo->prepare($studentSql))
            {
//                echo "<li> Statment successfully prepared</li>";
                $studentStmt->bindParam(":class_id", $id, PDO::PARAM_INT);
                $studentStmt->bindParam(":user_id", $student, PDO::PARAM_INT);
                if($studentStmt->execute())
                {
//                    echo "<li> Statment successfully executed</li>";
                    echo "$student added to class with id $id";
                    unset($studentSql);
                    unset($studentStmt);
                    //TODO: Try to do this with a created statement instead of loop
                }
                else{
//                    echo "<li> Statment not executed </li>";
                    echo "Problem adding student ($student) to class ($id)";
                }
            }
            else{
//                echo "<li> Statment not prepared</li>";
            }
//            echo "</ol></li>";
        }
//        echo "</ol>";
        header("location: ../editClasses.php?status=Class%20Successfully%20Edited"); //add a parameter here with a success statmenet
    }
    else{
        header("location: ../editClasses.php?status=Failed%20Editing%20Class"); //add a parameter here with a failure statmenet
    }
}
?>